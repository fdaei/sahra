# Sahra Marketing

Multilingual (EN/FA/AR) marketing website — Laravel 11 · Inertia 2 · Vue 3 ·
TypeScript · Tailwind · Filament 3.

Built against the `SahraMarketing` Figma file, page `User interface` (`1:2`).
See `docs/FIGMA-AUDIT.md` for the full design audit and
`docs/TRACEABILITY.md` for the node → route → component → model → admin
resource mapping.

---

## 1. Requirements

- PHP 8.3+
- Composer 2
- Node 20+
- MySQL 8 or PostgreSQL 14+
- A queue-capable cache (database driver works fine for development)

## 2. Installation

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# Point DB_* in .env at your database, then:
php artisan migrate
php artisan db:seed

php artisan storage:link
```

Fetch the openly-licensed webfonts (Poppins + Vazirmatn fallback):

```bash
chmod +x scripts/fetch-fonts.sh
./scripts/fetch-fonts.sh
```

> **Doran FaNum** (the Persian/Arabic typeface specified by the Figma
> variables) is commercially licensed and is **not** included. FA/AR render
> with Vazirmatn until you place the licensed files — see
> `docs/ASSET-MANIFEST.md` §10. No code change is needed once they're in place.

Export the real images/logos/icons from Figma per `docs/ASSET-MANIFEST.md`,
then verify nothing is missing:

```bash
php artisan sahra:verify-assets
```

## 3. Running locally

```bash
composer run dev
```

This runs the PHP server, queue listener, and Vite dev server together
(`concurrently`). Or run them separately:

```bash
php artisan serve
php artisan queue:listen
npm run dev
```

Visit `http://localhost:8000` — it redirects to `/en` (or your browser's
preferred supported language).

Admin panel: `http://localhost:8000/admin`. The seeder creates an initial
admin account:

```
email:    admin@sahra.example   (or ADMIN_EMAIL in .env)
password: ChangeMe!2026          (or ADMIN_PASSWORD in .env)
```

**Change this password immediately.** Set `ADMIN_EMAIL` / `ADMIN_PASSWORD` /
`ADMIN_NAME` in `.env` before your first `db:seed` on a real environment to
avoid the default ever existing.

## 4. Testing

```bash
php artisan test              # Pest: locale routing, publication states,
                               # forms, admin authorization
npm run typecheck              # vue-tsc, strict mode
npm run test:e2e               # Playwright — requires the app running;
                               # set BASE_URL if not http://localhost:8000
```

## 5. Production build & deployment

```bash
composer install --no-dev --optimize-autoloader
npm run build

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

php artisan migrate --force
```

Queue worker (contact-form email notifications run through the queue):

```bash
php artisan queue:work --tries=3
```

Scheduler (promotes scheduled content, regenerates the sitemap — see
`routes/console.php`). Add one cron entry:

```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Environment checklist for production:

- [ ] `APP_ENV=production`, `APP_DEBUG=false`
- [ ] `APP_URL` set to the real domain (used for canonical URLs, sitemaps, hreflang)
- [ ] `SESSION_DRIVER`, `CACHE_STORE`, `QUEUE_CONNECTION` pointed at real
      backends (Redis recommended over `database` at scale)
- [ ] `MAIL_*` configured; `CONTACT_NOTIFICATION_EMAIL` set to a monitored inbox
- [ ] `ADMIN_EMAIL` / `ADMIN_PASSWORD` set to real values **before** the first
      production `db:seed`
- [ ] Doran FaNum licensed files placed in `public/fonts/doran/` (optional but
      recommended for design fidelity)
- [ ] All 44 assets in `docs/ASSET-MANIFEST.md` exported and
      `php artisan sahra:verify-assets` passes
- [ ] `storage:link` run so `public/storage` resolves

## 6. Project structure

```
app/
  Console/Commands/     Scheduled-publish + asset-verification commands
  Contracts/            HasLocalisedSlugs (locale-aware route binding)
  Enums/                PublicationStatus, SectionType, SubmissionStatus, MenuLocation
  Filament/
    Concerns/           HandlesTranslations — shared Create/Edit page logic
    Pages/               ManageSettings
    Resources/           One per admin-managed entity
    Support/              TranslatableForm, PublicationFields
  Http/
    Controllers/          One per public route (see docs/TRACEABILITY.md)
    Middleware/           SetLocale, RedirectToLocalisedRoute, HandleInertiaRequests
    Requests/              ContactSubmissionRequest, NewsletterSubscriptionRequest
  Models/                22 Eloquent models + Translations/ (15 translation models)
  Notifications/         ContactSubmissionReceived
  Policies/              One per admin-managed entity, sharing BasePolicy
  Providers/             AppServiceProvider, Filament/AdminPanelProvider
  Services/              ContentTransformer, MediaTransformer, SeoBuilder, SubmissionHandler
  Support/               SiteSettings, NavigationBuilder, LocaleAlternates
  Traits/                HasTranslations, Publishable

config/locales.php        Single source of truth for en/fa/ar

database/
  migrations/             20 migrations, chronological
  seeders/                Real Figma copy, all 3 locales
  factories/

docs/
  FIGMA-AUDIT.md          Full design audit + frame resolution
  TRACEABILITY.md          Node → route → component → model → resource
  ASSET-MANIFEST.md        Every image/icon/font with export instructions
  RESPONSIVE-QA.md         Per-page breakpoint decisions + QA checklist
  IMPLEMENTATION-LOG.md    Chronological build log + known limitations

resources/
  css/                    app.css (Tailwind layers), fonts.css (@font-face)
  images/                 Static SVGs (branding, clients, icons, decor)
  js/
    Components/           BrandLogo, LanguageSwitcher, SeoHead
    Composables/           useTranslations
    Layouts/                AppLayout, AppHeader, AppFooter, MobileMenu
    Pages/                  Inertia page components (see Known Limitations)
    lib/motion.ts            GSAP setup, lifecycle, reduced-motion
    types/index.ts           Shared TypeScript contracts
  views/                  app.blade.php (Inertia root), sitemap/*, filament/pages/*

routes/
  web.php                 Locale-prefixed routes + bare-path redirect
  console.php             Scheduled commands

tests/
  Feature/                Pest — Locale, Content, Forms, Admin
  Browser/                Playwright — responsive.spec.ts
```

## 7. Known limitations

See `docs/IMPLEMENTATION-LOG.md` § Known limitations for the full list.
In short: dependencies were never installed in the authoring environment (no
network access there), `Doran FaNum` requires a separate licence, binary
assets are a manifest pending manual export, and the Vue page components
(`resources/js/Pages/*.vue`) are the next concrete unit of work — the full
data layer they'll consume (routes, controllers, transformers, seeded
content, TypeScript contracts) is complete and covered by tests today.
