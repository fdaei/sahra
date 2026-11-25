<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class InternalLink extends Model
{
    protected $fillable = ['locale', 'keyword', 'url', 'max_per_page', 'is_active'];

    protected function casts(): array
    {
        return ['max_per_page' => 'integer', 'is_active' => 'boolean'];
    }

    /** @return list<array{keyword: string, url: string, max: int}> */
    public static function rulesFor(string $locale): array
    {
        return self::query()->where('locale', $locale)->where('is_active', true)
            ->get(['keyword', 'url', 'max_per_page'])
            ->sortByDesc(fn (self $rule): int => mb_strlen($rule->keyword))
            ->map(fn (self $rule): array => ['keyword' => $rule->keyword, 'url' => $rule->url, 'max' => max(1, $rule->max_per_page)])
            ->values()->all();
    }
}
