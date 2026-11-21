<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Redirects\RedirectMap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Editor-managed redirect, so slugs can change without breaking inbound links.
 * Applied before routing by App\Http\Middleware\ApplyRedirects.
 *
 * Paths are stored without leading/trailing slashes and URL-decoded, so a
 * Persian path matches whether it was typed raw or pasted percent-encoded.
 */
final class Redirect extends Model
{
    use HasFactory;

    public const STATUSES = [
        301 => '301 — Permanent',
        302 => '302 — Temporary',
        303 => '303 — See Other',
        307 => '307 — Temporary, keeps method',
        308 => '308 — Permanent, keeps method',
    ];

    protected $fillable = [
        'source_path',
        'destination_path',
        'status_code',
        'is_active',
        'hits',
        'last_hit_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'status_code' => 'integer',
            'hits' => 'integer',
            'last_hit_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        self::saving(function (self $r): void {
            $r->source_path = self::normalize((string) $r->source_path);
            if (! preg_match('#^https?://#i', (string) $r->destination_path)) {
                $r->destination_path = self::normalize((string) $r->destination_path);
            }
        });

        self::saved(fn () => RedirectMap::flush());
        self::deleted(fn () => RedirectMap::flush());
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function recordHit(): void
    {
        $this->incrementQuietly('hits');
        $this->updateQuietly(['last_hit_at' => now()]);
    }

    /** "/fa/%D8%A2…/" or "https://site/fa/x?y" → "fa/آ…" */
    public static function normalize(string $path): string
    {
        $path = trim($path);
        if (preg_match('#^https?://#i', $path)) {
            $path = (string) parse_url($path, PHP_URL_PATH);
        }
        $path = (string) strtok($path, '?#');

        return trim(rawurldecode($path), '/');
    }
}
