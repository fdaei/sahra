<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (parent, locale) — enforced by a composite unique
 * index in the migration.
 */
final class TeamMemberTranslation extends Model
{
    protected $fillable = [
        'locale',
        'name',
        'role',
        'photo_alt',
    ];

}
