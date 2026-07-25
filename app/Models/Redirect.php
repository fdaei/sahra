<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Editor-managed redirect, so slugs can change without breaking inbound links.
 */
final class Redirect extends Model
{
    use HasFactory;

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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function recordHit(): void
    {
        $this->incrementQuietly('hits');
        $this->updateQuietly(['last_hit_at' => now()]);
    }
}
