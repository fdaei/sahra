<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Services\Seo\ContentSeoStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

final class SeoStatusColumn
{
    public static function make(): TextColumn
    {
        return TextColumn::make('seo_status')
            ->label('SEO status')
            ->getStateUsing(fn (Page|Post|Project $record): string => ContentSeoStatus::for($record, app()->getLocale()))
            ->formatStateUsing(fn (string $state): string => ContentSeoStatus::label($state))
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                'metadata_present' => 'success',
                'missing_title', 'missing_description' => 'warning',
                default => 'gray',
            })
            ->tooltip(__('Based on the admin language and saved settings; this does not indicate search ranking or publication status.'))
            ->toggleable();
    }

    public static function noindexFilter(): Filter
    {
        return Filter::make('seo_noindex')
            ->label(__('Noindex in admin language'))
            ->query(fn (Builder $query): Builder => $query->whereHas('translations', fn (Builder $translation): Builder => $translation
                ->where('locale', app()->getLocale())->where('seo_noindex', true)));
    }
}
