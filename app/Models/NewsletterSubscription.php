<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Lead-magnet signup. Figma 1419:9322 and the in-article checklist banner.
 */
final class NewsletterSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'locale',
        'source',
        'confirmed_at',
        'unsubscribed_at',
        'unsubscribe_token',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $subscription): void {
            $subscription->unsubscribe_token ??= Str::random(64);
        });
    }

    public function scopeActive($query)
    {
        return $query->whereNull('unsubscribed_at');
    }

    public function isActive(): bool
    {
        return $this->unsubscribed_at === null;
    }

    public function resubscribe(): bool
    {
        $this->unsubscribed_at = null;

        return $this->save();
    }
}
