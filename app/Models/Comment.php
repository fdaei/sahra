<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Comment extends Model
{
    protected $fillable = ['name', 'email', 'body', 'locale', 'status'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
