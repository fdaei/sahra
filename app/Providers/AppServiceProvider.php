<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\MailSettings;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        \App\Services\Redirects\SlugChangeRedirector::register();

        Field::configureUsing(
            fn (Field $field): Field => $field->translateLabel(),
        );
        Section::configureUsing(function (Section $section): void {
            $heading = $section->getHeading();

            if (is_string($heading)) {
                $section->heading(function () use ($heading): string {
                    $translated = __($heading);

                    return is_string($translated) ? $translated : $heading;
                });
            }
        });
        Column::configureUsing(
            fn (Column $column): Column => $column->translateLabel(),
        );
        BaseFilter::configureUsing(
            fn (BaseFilter $filter): BaseFilter => $filter->translateLabel(),
        );

        // Remove Livewire's default 12 MB temporary-upload ceiling.
        config()->set('livewire.temporary_file_upload.rules', ['required', 'file']);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        if ($origin = config('seo.canonical_origin')) {
            URL::forceRootUrl($origin);
            URL::forceScheme(parse_url($origin, PHP_URL_SCHEME));
        }

        // Queue workers are long-lived, so apply database-backed mail settings
        // immediately before each queued notification is processed.
        Queue::before(function (): void {
            MailSettings::apply();
        });
    }

}
