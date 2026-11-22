<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class NotFoundVisit extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['hits' => 'integer', 'first_seen_at' => 'datetime', 'last_seen_at' => 'datetime'];
    }
}
