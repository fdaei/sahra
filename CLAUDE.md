# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Sahra Marketing — trilingual (en/fa/ar) marketing site. Laravel 12 + Inertia 2 +
Vue 3 (TypeScript) + Tailwind, with a Filament 3 admin panel at `/admin`.
Built against a Figma file; `docs/` holds the design audit, node→route→component
traceability map, asset manifest, responsive QA notes, and build log.

## Commands

```bash
composer run dev          # php artisan serve + queue:listen + vite (concurrently)
php artisan test          # Pest — Feature suites: Locale, Content, Forms, Admin
php artisan test --filter=LocaleRoutingTest      # single file
php artisan test tests/Feature/Forms             # single directory
npm run typecheck         # vue-tsc --noEmit, strict
npm run build             # typecheck, then vite build
npm run test:e2e          # Playwright, 7 viewports; needs the app running (BASE_URL)
php artisan sahra:verify-assets       # asserts every docs/ASSET-MANIFEST.md asset exists
php artisan sahra:publish-scheduled   # promotes due scheduled content (cron: every 5 min)
```

## Environment gotchas

- **`php artisan test` fails wholesale (28 tests) unless `pdo_sqlite` is
  installed.** `phpunit.xml` pins the test DB to `sqlite::memory:`; the local PHP
  build only has `pdo_mysql`. Install the SQLite PDO extension rather than
  editing `phpunit.xml`.
- Local dev uses MySQL (`DB_DATABASE=sahra`); tests do not.
- `npm run lint` is broken — the script assumes an ESLint 10 flat config
  (`eslint.config.js`) that is not committed. Do not treat lint as a gate; add
  the config if lint is needed.
- `npm run typecheck` and `npm run build` are both clean. If either fails, it is
  your change.
- The git repository root is `$HOME`, not this directory. Scope every git command
  to paths under this project; a bare `git add -A` stages the user's home dir.
- README says Laravel 11; the installed framework is 12.x. Trust `composer.json`.

## Architecture

### Locale routing

`config/locales.php` is the single source of truth for supported locales (URL
segment, direction, font, html lang, date format) and is consumed by routing,
middleware, models, and Filament tabs. Add a locale there, nowhere else.

Every public route lives under a `{locale}` prefix, but **route names are
locale-agnostic** (`home`, `work.show`). `SetLocale` calls
`URL::defaults(['locale' => …])`, so `route('work.show', $project)` stays inside
the visitor's language without passing the locale. Consequence: controller
methods for parameterised routes take `$locale` as their first argument
(`show(string $locale, Post $post)`).

Bare paths (`/about`) are 302-redirected to `/{locale}/about` by
`RedirectToLocalisedRoute`, registered as a catch-all *last* in
[routes/web.php](routes/web.php) so it never shadows a real route. `/admin`,
`/sitemap.xml`, and `/up` are deliberately outside the locale group.

### Numerals are a third localisation concern

`fa` and `ar` render their own digit systems, and they are **different Unicode
blocks** — Persian `۰۱۲۳` (U+06F0) vs Arabic `٠١٢٣` (U+0660). Never copy one
locale's digits to the other.

- **Generated** numbers (dates, years, counts) go through
  `App\Support\Numerals::localise()` in the transformer. Carbon's
  `translatedFormat()` localises month names but always emits ASCII digits.
- **Authored** numbers (a KPI value typed into Filament) are rendered verbatim —
  the editor writes the digits they want.
- Digit sets live in `config/locales.php` under `digits`, next to `direction`
  and `date_format`. `null` means "already ASCII".
- CSS cannot help: `.latin-nums` only picks lining over oldstyle figures within
  one script. Despite the name it does **not** force Latin digits; it exists to
  keep a numeric run (`+٧٠ ألف`) reading as one unit inside RTL copy.

`Idealist` is Latin-only and carries an explicit `unicode-range` in
`fonts.css`. Use the `font-display` token (`Idealist → Doran FaNum → Vazirmatn`)
for eyebrows and display accents — never hardcode `Idealist, serif`, or fa/ar
falls through to a generic serif instead of the Arabic display face.

### Two separate translation systems — don't conflate them

1. **Database content** — every translatable entity has a sibling
   `{entity}_translations` table (`app/Models/Translations/`) with a
   `(entity_id, locale)` unique key. `App\Traits\HasTranslations` exposes those
   columns as if native (`$post->title`), plus `translate()`,
   `getTranslation()`, `setTranslations()`, and the `withTranslations` /
   `hasTranslation` / `whereSlug` scopes. Models declare
   `protected array $translatable` and `translationModel()`.
2. **UI strings** — `lang/{locale}/*.php`, shared into Inertia props by
   `AppServiceProvider::shareTranslations()` and read in Vue via
   `useTranslations()` / global `$t`. Blade, validation, and Vue therefore
   resolve identical strings from one source.

Slugs are per-locale. Models implementing `HasLocalisedSlugs` (Post, Project,
Page) override `resolveRouteBinding()` to resolve by translated slug *and*
publication state, and expose `slugForLocale()` so `LocaleAlternates` can build
correct hreflang sets.

**N+1 is the standing hazard here.** Never load a translatable model without a
scope that eager-loads translations — use the model's own `forListing()` /
`withFullDetail()` / `withContent()` scopes, which load only the active locale
plus the fallback.

### Publication lifecycle

`App\Traits\Publishable` + `PublicationStatus` enum give Draft / Scheduled /
Published. `published()` checks both status **and** `published_at <= now()`, so a
missed cron run can never leak future content. `sahra:publish-scheduled`
promotes due rows.

### Controller → Transformer → TypeScript contract

Controllers are thin: query with a model scope, map through a static
transformer, hand to `Inertia::render`. `App\Services\ContentTransformer` is the
**single** place Eloquent models become frontend payloads, and it mirrors
[resources/js/types/index.ts](resources/js/types/index.ts) shape for shape. When
a field changes, change both sides together. Transformers assume translations
are already loaded and must not trigger queries. Sibling services:
`MediaTransformer` (image URLs/srcset), `SeoBuilder` (SeoMeta with
entity→site-default fallback), `SubmissionHandler` (contact/newsletter).

Global props (locale, navigation, settings, alternates, flash, ziggy) come from
`HandleInertiaRequests::share()`, backed by the cached `SiteSettings` and
`NavigationBuilder` repositories (invalidated on write, not TTL-expired).

Error responses for non-admin, non-JSON requests are rendered through the
Inertia `Error` page in [bootstrap/app.php](bootstrap/app.php) so 404/403/500
keep site chrome and direction; 419 redirects back with a flash message.

### Filament admin

Panel is English-only and not locale-prefixed, while the content it edits is
trilingual. Translatable resources build per-locale tab groups with
`Filament\Support\TranslatableForm::tabs()` (fields named
`translations.{locale}.{attribute}`), and their Create/Edit pages use the
`HandlesTranslations` concern, which splits the nested array off, saves parent
and translations in one transaction.

Authorization: one policy per entity extending `BasePolicy`, which derives
Spatie permission names as `{action}_{resource}` (`view_project`,
`delete_any_post`) — those names are seeded by `RolePermissionSeeder`, so adding
a resource means adding its permissions there. Force-delete is admin-only
regardless of granted permissions. Panel entry is gated by
`User::canAccessPanel()` (admin | editor).

### Frontend

`resources/js/app.ts` auto-assigns `AppLayout` to every page unless it opts out
with `defineOptions({ layout: null })`. GSAP is torn down on Inertia `before`
and re-initialised after two frames on `navigate` (`lib/motion.ts`) — ScrollTrigger
instances would otherwise survive page swaps.

Tailwind tokens in [tailwind.config.js](tailwind.config.js) are extracted 1:1
from Figma variables; regenerate from the design rather than hand-editing
values. `tailwindcss-logical` is installed and RTL is a first-class case: use
logical properties (`inline-start`, `ms-*`) instead of left/right.

## Current state

Both the data layer and the Vue page layer are complete — every route has its
component, and all pages have been reconciled against the canonical LTR frames
listed in `docs/FIGMA-AUDIT.md` §4.

Fonts are all present and self-hosted: Poppins, Doran FaNum (licensed files
supplied) and **Idealist**, the display face the file uses for every section
eyebrow and package price. Idealist is *not* in `ASSET-MANIFEST.md` §10 — it was
missed by the original audit; it is wired up in `resources/css/fonts.css` and
consumed via the `.eyebrow` component class.

**Motion is complete.** The whole §6 inventory now runs:

- GSAP, via `Composables/useMotion.ts` — A1 hero stagger, A3 KPI counters,
  A4 orbit scrub, A7 section reveal, A11 CTA parallax.
- CSS/Vue, pre-existing — A2/A6 marquees (`.marquee-track`), A5 project row
  (`grid-template-rows` expand + image cross-fade), A8 FAQ (native `<details>`),
  A9 mobile menu, A12 page transition (`<Transition>` on `<main>` in AppLayout).
- A10 does **not** apply: the audit lists a scroll-gated header background, but
  node `1419:9339` has no such variant — the blur is the only state in the file.
  Do not re-add it.

**The file stores no keyframe data at all.** `get_motion_context` on `1419:9192`
(recursive) returns `{"nodes":[]}`, which settles audit gap G3: easing and
duration for the scroll effects cannot be extracted and come from the `MOTION`
constants in `lib/motion.ts`. Tune them there. The only motion the file does
store is the component-state `interactions` array (SMART_ANIMATE / EASE_OUT /
0.3s) — that is `MOTION.duration.state`.

`.will-reveal` sets its hidden start state in CSS, gated behind
`html.motion-ready` (added by `initMotion`), so a bundle failure can never leave
content invisible. Elements opt in with `data-reveal`, or `data-reveal-group` on
a parent to stagger its children together.

Known remaining gaps:

- The Services page's two off-canvas `Clip path group` layers are still
  unplaced; `arc-rings-project.svg` and `arc-rings-mobile.svg` are exported but
  not yet wired to Single project / mobile.
- `dune-contours` ships as a 215 kB WebP, not the exported SVG: the vector is
  345 paths / 1.09 MB gzipped. See the note in `Pages/About.vue`.
- No tablet frames exist in the file; `md`/`lg` behaviour is derived
  (`docs/RESPONSIVE-QA.md`, audit gap G1).

## Conventions

- `declare(strict_types=1)` in every PHP file; classes are `final` unless
  designed for extension (`BasePolicy`, `TestCase`).
- One controller per public route, named after the page; single-action
  controllers use `__invoke`.
- Tests are Pest with `RefreshDatabase` applied suite-wide via `tests/Pest.php`.
- Figma node IDs are cited in docblocks and route comments — keep them when
  editing, and consult `docs/TRACEABILITY.md` before adding a page.

## graphify

This project has a knowledge graph at graphify-out/ with god nodes, community structure, and cross-file relationships.

Rules:
- For codebase questions, first run `graphify query "<question>"` when graphify-out/graph.json exists. Use `graphify path "<A>" "<B>"` for relationships and `graphify explain "<concept>"` for focused concepts. These return a scoped subgraph, usually much smaller than GRAPH_REPORT.md or raw grep output.
- If graphify-out/wiki/index.md exists, use it for broad navigation instead of raw source browsing.
- Read graphify-out/GRAPH_REPORT.md only for broad architecture review or when query/path/explain do not surface enough context.
- After modifying code, run `graphify update .` to keep the graph current (AST-only, no API cost).
