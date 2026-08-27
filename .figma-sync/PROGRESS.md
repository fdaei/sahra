# Figma → Frontend sync progress

## Current phase: 0 — Setup & stack detection (HALTED)
## Last completed unit: stack detection
## Next unit: BLOCKED — cannot start Phase 1 inventory without Figma reads
## Stack: Laravel 12 + Inertia 2 + Vue 3 (TS, strict) + Tailwind 3.4
## Blockers: TWO — see GAPS.md B1 and B2. Both need a human decision.

---

## Detected stack (Phase 0, step 1)

| Concern | Detected |
|---|---|
| Backend | Laravel 12.61 (`laravel/framework ^12.61.1`) — README says 11, trust composer.json |
| Frontend | Vue 3.5 + TypeScript (strict), Inertia 2 (`@inertiajs/vue3 ^2.0`) |
| Admin | Filament 3.2 at `/admin` (English-only, outside locale prefix) |
| Styling | Tailwind 3.4.16 + `tailwindcss-logical` + forms + typography plugins |
| Tokens | `tailwind.config.js` — extracted 1:1 from Figma variables (per CLAUDE.md) |
| Router | Laravel routes under `/{locale}` prefix; locale-agnostic route names; Ziggy 2.4 |
| i18n | Two systems: DB `{entity}_translations` tables + `lang/{locale}/*.php` UI strings |
| Locales | en (ltr), fa (rtl), ar (rtl) — source of truth `config/locales.php` |
| Asset pipeline | Vite 6, entry `resources/js/app.ts`, `laravel-vite-plugin`; static assets in `public/` |
| Breakpoints | xs 480 / sm 640 / md 768 / lg 1024 / xl 1280 / 2xl 1440 / 3xl 1600 |
| Motion | GSAP 3.12 via `Composables/useMotion.ts` + CSS; teardown on Inertia navigate |
| Tests | Pest (Feature: Locale, Content, Forms, Admin) + Playwright (7 viewports) |

## Figma connectivity (Phase 0, step 3): FAILED — not verified

`get_metadata` on `0:1` of `v1l4ANft5Wtb8wPThyP7P9` was **never called**: the tool does not
exist in this session. See GAPS.md B1 for the exact diagnosis.

## Checkpoint status

NOT committed. The Phase 0 checkpoint requires "detected stack + **confirmed Figma access**"
in this file. Figma access is not confirmed, so the checkpoint is incomplete by its own
definition. Scaffold written; no commit made.
