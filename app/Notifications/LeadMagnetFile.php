<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

final class LeadMagnetFile extends Notification
{
    public function __construct(
        private readonly string $title,
        private readonly string $path,
        private readonly string $contentLocale,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting(__('forms.newsletter.email_greeting', locale: $this->contentLocale))
            ->line(__('forms.newsletter.email_body', locale: $this->contentLocale))
            ->attach(Storage::disk('local')->path($this->path), [
                'as' => basename($this->path),
            ]);
    }
}
