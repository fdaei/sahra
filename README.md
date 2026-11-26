# Sahra Marketing

Multilingual (EN/FA/AR) marketing website built with Laravel 12, Blade, Tailwind and Filament 3.

Built against the `SahraMarketing` Figma file, page `User interface` (`1:2`).
See `docs/FIGMA-AUDIT.md` for the full design audit and
`docs/TRACEABILITY.md` for the node → route → component → model → admin
resource mapping.

---

## 1. Requirements

- PHP 8.2+
- Composer 2
- Node 22+ on the build machine
- MySQL 8 or PostgreSQL 14+
- A queue-capable cache (database driver works fine for development)

## 2. Quick start with Docker

The fastest way to get the whole stack running — app, MariaDB, queue worker,
and scheduler — with nothing but Docker installed:

```bash
cp .env.docker.example .env.docker
docker compose up -d --build
docker compose exec app php artisan db:seed
```

That's it — `docker compose up -d --build` builds the Vite assets and the PHP
image, waits for MariaDB to be healthy, runs migrations once (`migrate`
service), then starts:

- `app` — Apache + PHP, published at `http://localhost:8000`
- `queue` — `php artisan queue:work`, needed for contact-form/newsletter
  notification emails (`QUEUE_CONNECTION=database`)
- `scheduler` — `php artisan schedule:work`, promotes scheduled content every
  five minutes (see `routes/console.php`)
- `db` — MariaDB, data persisted in the `db_data` named volume, forwarded to
  host port 3306

The env file is deliberately named `.env.docker`, **not** `.env` — this
project's real `.env` holds production cPanel secrets, and Docker Compose
auto-loads a file literally named `.env` for variable substitution, so
reusing that name here would risk mixing the two up. `.env.docker.example`
ships with a working `APP_KEY` and `MAIL_MAILER=log`, so no extra setup is
required before `db:seed`. Change `ADMIN_EMAIL` / `ADMIN_PASSWORD` in
`.env.docker` before seeding if this isn't a throwaway environment. Rebuild
after pulling code changes with `docker compose up -d --build` again;
`docker compose logs -f app` tails the web container.

This path bakes the app into an image (no bind-mounted source, no hot
reload) — it's meant for bringing the project up to look at or demo, not for
day-to-day development. For active development, use the native workflow
below (§3–4), which supports Vite HMR.

## 3. Installation

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

## 4. Running locally

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

Visit `http://localhost:8000` — it permanently redirects to `/en`, independent of browser language or a previously selected locale. Explicit `/fa` and `/ar` URLs remain available.

Admin panel: `http://localhost:8000/admin`. The seeder creates an initial
admin account:

```
email:    admin@sahra.example   (or ADMIN_EMAIL in .env)
password: ChangeMe!2026          (or ADMIN_PASSWORD in .env)
```

**Change this password immediately.** Set `ADMIN_EMAIL` / `ADMIN_PASSWORD` /
`ADMIN_NAME` in `.env` before your first `db:seed` on a real environment to
avoid the default ever existing.

## 5. Testing

```bash
php artisan test              # Pest: locale routing, publication states,
                               # forms, admin authorization
npm run typecheck              # TypeScript checks for Vite and Playwright
npm run test:e2e               # Playwright — requires the app running;
                               # set BASE_URL if not http://localhost:8000
```

## 6. Production build & deployment

For PHP-only cPanel with no terminal, follow [the Persian upload guide](docs/DEPLOY-CPANEL-FA.md). The commands below are for environments with a terminal.

```bash
# Build machine
npm ci
npm run build

# PHP host with the built public/build directory
composer install --no-dev --optimize-autoloader
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

Scheduler (promotes scheduled content; sitemap is generated on each request — see
`routes/console.php`). Add one cron entry:

```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Submit `/sitemap.xml` to search engines. It lists localized sitemaps; when a
locale has many published records, it also lists bounded post and project
shards. In that case `/sitemap-{locale}.xml` contains the main pages and the
shards contain the articles and projects. For small sites the localized URL
continues to include all eligible content. `SEO_SITEMAP_CHUNK_SIZE` can lower
the shard size (default and maximum: 1,000 records). Per-language noindex and
non-self canonical settings exclude URLs from sitemap output without deleting
content. Image sitemap entries include published article covers and visible
project banner, before/after and gallery images when files exist. The
per-language noimageindex setting omits image entries for that page. A page has
at most 1,000 unique image entries; project shards contain at most five projects
to keep large galleries bounded.

Localized RSS 2.0 feeds are available at `/feed-en.xml`, `/feed-fa.xml`, and
`/feed-ar.xml`. They include up to 50 recent published, indexable articles with
slugs in the requested language and exclude non-self-canonical articles.

The optional 404 monitor is enabled in Site settings → Redirects. It records
only localized public GET paths, without query strings or IP addresses; paths
can themselves contain sensitive information. Administrators can review and
delete reports or create a redirect from one. Collection is rate-limited and
bounded; entries not seen for 30 days are pruned by the scheduler above.

Environment checklist for production:

- [ ] `APP_ENV=production`, `APP_DEBUG=false`
- [ ] `APP_URL` set to the real domain (used for canonical URLs, sitemaps, hreflang)
- [ ] `SEO_CANONICAL_ORIGIN=https://sahramarketing.com` (the non-www host)
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

## 7. Project structure

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
    Middleware/           SetLocale, RedirectToLocalisedRoute
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
  js/public.js             Navigation, forms and browser interactions
  views/
    app.blade.php          Public HTML layout
    public/                Page templates, layouts and shared components
    seo/                   Metadata and structured data
    sitemap/, feeds/      XML sitemap and RSS templates
    filament/              Admin panel templates

routes/
  web.php                 Locale-prefixed routes + bare-path redirect
  console.php             Scheduled commands

tests/
  Feature/                Pest — Locale, Content, Forms, Admin
  Browser/                Playwright — responsive.spec.ts
```

## 8. Public rendering

Laravel renders the localized page, layout and SEO tags on each request. The
browser receives complete HTML. Standard links and forms use Laravel routes,
and a small JavaScript bundle handles dialogs and other interactive controls.
The cPanel archive contains compiled assets and production Composer dependencies,
so PHP can serve the site with the files in the archive.
