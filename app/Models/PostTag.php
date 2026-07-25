<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\PostTagTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class PostTag extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [];

    /** @var array<int, string> */
    protected array $translatable = ['name', 'slug'];

    public function translationModel(): string
    {
        return PostTagTranslation::class;
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post_tag');
    }
}
