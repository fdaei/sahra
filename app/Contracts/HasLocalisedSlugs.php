<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * Implemented by models whose slug differs per locale (Post, Project, Page).
 *
 * Lets LocaleAlternates build a correct hreflang set: the same entity resolves
 * to /en/insights/content-direction and /fa/insights/جهت-محتوا rather than
 * reusing one slug across languages.
 */
interface HasLocalisedSlugs
{
    /**
     * The slug for the given locale, falling back to the default locale's slug
     * when no translation exists.
     */
    public function slugForLocale(string $locale): string;
}
