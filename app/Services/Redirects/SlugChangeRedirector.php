<?php

declare(strict_types=1);

namespace App\Services\Redirects;

use App\Models\Redirect;
use App\Models\Translations\PostTranslation;
use App\Models\Translations\ProjectTranslation;
use App\Support\SiteSettings;
use Illuminate\Database\Eloquent\Model;

/**
 * When an editor changes a published slug, redirect the old URL to the new
 * one so shared links and search results keep working.
 *
 * Site settings → Search engines:
 *   slug_auto_redirect         on/off (default on)
 *   slug_auto_redirect_status  301 (default) | 302 | 303 | 307 | 308
 *
 * Chains are collapsed: redirects that pointed at the old URL are re-pointed
 * at the new one, and a redirect whose source is the new URL is removed
 * (content lives there again — otherwise it would loop).
 */
final class SlugChangeRedirector
{
    /** translation model => URL segment between locale and slug */
    public const PREFIXES = [
        PostTranslation::class => 'insights',
        ProjectTranslation::class => 'work',
    ];

    public const STATUSES = [301, 302, 303, 307, 308];

    public static function register(): void
    {
        foreach (array_keys(self::PREFIXES) as $model) {
            $model::updated(fn (Model $t) => self::handle($t));
        }
    }

    public static function enabled(): bool
    {
        return (bool) SiteSettings::get('slug_auto_redirect', null, true);
    }

    public static function status(): int
    {
        $status = (int) SiteSettings::get('slug_auto_redirect_status', null, 301);

        return in_array($status, self::STATUSES, true) ? $status : 301;
    }

    public static function handle(Model $translation): void
    {
        if (! $translation->wasChanged('slug') || ! self::enabled()) {
            return;
        }

        $prefix = self::PREFIXES[$translation::class] ?? null;
        $old = (string) $translation->getOriginal('slug');
        $new = (string) $translation->getAttribute('slug');

        if ($prefix === null || $old === '' || $new === '' || $old === $new) {
            return;
        }

        $from = Redirect::normalize("{$translation->locale}/{$prefix}/{$old}");
        $to = Redirect::normalize("{$translation->locale}/{$prefix}/{$new}");

        Redirect::query()->where('source_path', $to)->delete();
        Redirect::query()->where('destination_path', $from)->update(['destination_path' => $to]);

        Redirect::query()->updateOrCreate(
            ['source_path' => $from],
            ['destination_path' => $to, 'status_code' => self::status(), 'is_active' => true, 'origin' => 'auto'],
        );

        RedirectMap::flush();
    }
}
