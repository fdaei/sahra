<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

final class LeadMagnetFile extends Notification
{
    public function __construct(
        private readonly Post $post,
        private readonly string $contentLocale,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $title = (string) ($this->post->getTranslation('lead_magnet_title', $this->contentLocale)
            ?: $this->post->getTranslation('title', $this->contentLocale));
        $path = (string) $this->post->lead_magnet_file_path;

        return (new MailMessage)
            ->subject($title)
            ->greeting(__('forms.newsletter.email_greeting', locale: $this->contentLocale))
            ->line(__('forms.newsletter.email_body', locale: $this->contentLocale))
            ->attach(Storage::disk('local')->path($path), [
                'as' => basename($path),
            ]);
    }
}
