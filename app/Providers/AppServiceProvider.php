<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Remove Livewire's default 12 MB temporary-upload ceiling.
        config()->set('livewire.temporary_file_upload.rules', ['required', 'file']);

        // Vite prefetches lazily-loaded chunks once the page is idle.
        Vite::prefetch(concurrency: 3);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        $this->shareTranslations();
    }

    /**
     * Expose the active locale's PHP translation files to the frontend.
     *
     * Read by resources/js/Composables/useTranslations.ts, so Vue components
     * and Blade resolve identical strings from one source of truth.
     *
     * Cached per-locale in production; re-read on every request in local so
     * editing a lang file shows up without clearing anything.
     */
    private function shareTranslations(): void
    {
        Inertia::share('translations', function (): array {
            $locale = app()->getLocale();

            $load = function () use ($locale): array {
                $path = lang_path($locale);

                if (! File::isDirectory($path)) {
                    return [];
                }

                $translations = [];

                foreach (File::files($path) as $file) {
                    if ($file->getExtension() !== 'php') {
                        continue;
                    }

                    $translations[$file->getFilenameWithoutExtension()] = require $file->getPathname();
                }

                return $translations;
            };

            if ($this->app->environment('local')) {
                return $load();
            }

            return cache()->rememberForever("translations.{$locale}", $load);
        });
    }
}
