<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class LeadMagnetDelivery extends Model
{
    protected $fillable = [
        'post_id',
        'newsletter_subscription_id',
        'name',
        'email',
        'locale',
        'download_enabled',
        'email_enabled',
        'email_status',
        'response_code',
        'error_message',
        'email_sent_at',
        'downloaded_at',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'download_enabled' => 'boolean',
            'email_enabled' => 'boolean',
            'response_code' => 'integer',
            'email_sent_at' => 'datetime',
            'downloaded_at' => 'datetime',
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(NewsletterSubscription::class, 'newsletter_subscription_id');
    }
}
