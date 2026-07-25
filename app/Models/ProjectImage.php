<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\ProjectImageTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Content-showcase gallery image. Figma 1323:7541 "Content Showcase".
 */
final class ProjectImage extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'project_id',
        'path',
        'sort_order',
    ];

    /** @var array<int, string> */
    protected array $translatable = ['alt'];

    protected function casts(): array
    {
        return ['sort_order' => 'integer'];
    }

    public function translationModel(): string
    {
        return ProjectImageTranslation::class;
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
