<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifies the team of a new contact submission.
 *
 * Queued so the visitor's request returns immediately — the form shows its
 * success state without waiting on SMTP.
 */
final class ContactSubmissionReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly ContactSubmission $submission,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $services = $this->submission->service_titles ?? [];

        $mail = (new MailMessage)
            ->subject("New enquiry from {$this->submission->name}")
            ->greeting('New contact submission')
            ->line("**Name:** {$this->submission->name}");

        if ($this->submission->brand_name !== null) {
            $mail->line("**Brand:** {$this->submission->brand_name}");
        }

        if ($this->submission->phone !== null) {
            $mail->line("**Phone:** {$this->submission->phone}");
        }

        if ($this->submission->email !== null) {
            $mail->line("**Email:** {$this->submission->email}");
        }

        if ($services !== []) {
            $mail->line('**Services:** '.implode(', ', $services));
        }

        if ($this->submission->message !== null) {
            $mail->line('**Message:**')->line($this->submission->message);
        }

        return $mail
            ->line("**Locale:** {$this->submission->locale}")
            ->action(
                'View in admin',
                url("/admin/contact-submissions/{$this->submission->id}"),
            );
    }
}
