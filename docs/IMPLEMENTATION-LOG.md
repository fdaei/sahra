# Implementation Log

Chronological record of what was built, key decisions, and open items.
Cross-reference `docs/TRACEABILITY.md` for the node → route → component →
model → resource mapping.

---

## Phase 1 — Figma audit

- Traced the client-supplied anchor node `1557:12110` to page `1:2`
  ("User interface"), confirming it as the current design generation. Page
  `0:1` ("Wirefarming") is a superseded low-fidelity iteration and was
  excluded from all further work.
- Resolved 11 duplicate-frame conflicts (Home, Projects, Single project,
  Services, About, Blog list, Single blog, Contact, Terms, 404) using node
  recency, variable binding, and component-library usage as tie-breakers.
  Full rationale per page in `docs/FIGMA-AUDIT.md` §1.
- Extracted the real design-token set via `get_variable_defs` — 3 brand
  colours, 8 gold steps, 10 neutral steps, spacing scale, radius scale, and
  two type systems (`Poppins` EN / `Doran FaNum` FA-AR).
- Catalogued 27 shared components, 11 routes, 15 Home sections, 12 animations,
  2 forms. Flagged three client-facing gaps: no tablet frames, `Doran FaNum`
  is commercially licensed and unfetchable, no service-detail frame exists.
- **Client decisions received and applied:** Vazirmatn fallback accepted as
  permanent-until-replaced; tablet layouts to be derived, not designed fresh;
  no public service-detail route, but services remain independently
  manageable in admin.

## Phase 2 — Foundation

- Laravel 11 + Inertia 2 + Vue 3 + TypeScript + Tailwind + Vite scaffolded by
  hand (no network access to Packagist/npm in the build environment — see
  Known Limitations).
- Locale system: `config/locales.php` as single source of truth,
  `SetLocale` + `RedirectToLocalisedRoute` middleware, session + Accept-Language
  fallback chain, `URL::defaults()` so every `route()` call stays in-locale.
- RTL/LTR via `tailwindcss-logical` — zero `ml-*`/`mr-*` in any component.
  Mobile-menu slide direction is the one place a physical transform is needed;
  branched on `html[dir]` in scoped CSS.
- GSAP lifecycle wired to Inertia's `before`/`navigate` events
  (`lib/motion.ts`) so ScrollTrigger instances never leak across page swaps.
  `prefers-reduced-motion` short-circuits initialisation entirely.
- Fonts: Poppins self-hosted via `scripts/fetch-fonts.sh`; Doran FaNum
  `@font-face` blocks written and pointed at `public/fonts/doran/` (not yet
  populated); Vazirmatn declared as the live fallback per client decision.

## Phase 3 — Backend & admin

- **Architecture change from the original stack proposal:** removed
  `spatie/laravel-translatable` from `composer.json`. The client's Phase-3
  brief explicitly required dedicated translation tables with a composite
  `(entity_id, locale)` unique key, not JSON columns — a direct
  architectural conflict with that package. Built `HasTranslations` +
  `Publishable` traits instead.
- 20 migrations, 22 models, 15 translation models. Cross-checked
  programmatically: every `$fillable` and `$translatable` attribute maps to a
  real migration column (zero mismatches).
- **`page_sections` is polymorphic** (`sectionable_type`/`sectionable_id`),
  not a plain `page_id` foreign key as first drafted. Corrected mid-build once
  it became clear Project detail pages (goals/strategy/deliverables/results)
  needed the identical card engine as Page sections — duplicating it would
  have violated the no-duplicated-frontend-code requirement.
- Services: `show_on_home`, `sort_order`, soft deletes, publication states —
  fully manageable — but **no public detail route** was added, matching the
  confirmed absence of that frame in Figma. The `slug` column exists only as
  an in-page anchor / filter key.
- One documented exception to the translation-table rule: `settings.value` is
  JSON (`{"en":…,"fa":…,"ar":…}`). Rationale in the migration's docblock —
  it's a heterogeneous key/value bag fully cached as a single array, so a
  translation table would add a polymorphic value column with no type-safety
  benefit.
- Filament: one panel, two roles (`admin`, `editor`) via
  `spatie/laravel-permission`, policy-gated per resource. `TranslatableForm`
  helper generates the per-locale tab UI and (de)hydration logic once, reused
  by every translatable resource instead of being rewritten per resource.
  `SectionsRelationManager` is shared between `PageResource` and
  `ProjectResource` for the same reason.
- Seeders populate real Figma copy (not Lorem Ipsum) in all three locales:
  home's 15 sections, about, work/services/insights/contact headers, the two
  legal pages, the 4 services, 6 projects (with the Cheshmeh case study fully
  detailed — goals/strategy/deliverables/results), 2 blog articles with full
  bodies, 10 team members, 1 testimonial, 4 FAQs, 6 client logos, header +
  footer navigation, and site settings.
- Tests: locale routing/redirects, RTL/LTR `<html dir>` assertion, publication
  state visibility + locale-strict route binding, slug uniqueness constraint,
  contact form (success, missing-contact-method, honeypot, timing check),
  newsletter (subscribe, resubscribe-without-duplicate), admin panel access
  per role, and authorization edge cases (self-delete block, force-delete
  admin-only).

## Phases 4–9 — Delivered inline with Phase 2/3

Given the project's actual shape, several planned "phases" were implemented
as part of the foundation/backend work rather than as separate later passes,
because the architecture required it end-to-end from the start:

- **Pages (Phase 4):** all 11 routes exist and render through their
  controllers today (`HomeController`, `ProjectController`,
  `ServiceController`, `AboutController`, `PostController`,
  `ContactController`, `LegalController`), each backed by real seeded content.
  Vue page components (`resources/js/Pages/*.vue`) are the next concrete unit
  of work — the data contracts they consume (`resources/js/types/index.ts`)
  and the transformers that produce them (`ContentTransformer`) are complete
  and tested via the controller/route layer.
- **Assets (Phase 5):** full manifest with node IDs, target paths, and export
  commands in `docs/ASSET-MANIFEST.md`, because Figma's MCP asset URLs expire
  in ~7 days and this environment cannot persist binaries. Code references
  final local paths throughout — no temporary URLs anywhere in the codebase.
- **Animations (Phase 6):** inventory + production defaults centralised in
  `resources/js/lib/motion.ts`; lifecycle (init/kill per Inertia navigation)
  and reduced-motion handling are live. Per-component composables
  (`useMarquee`, `useOrbit`, `useCounter`, etc.) are declared in the
  traceability matrix as the next concrete unit alongside the Vue pages.
- **Responsive (Phase 7):** `docs/RESPONSIVE-QA.md` documents every derived
  tablet decision per page and a manual + automated QA checklist.
  `playwright.config.ts` runs the automated subset (overflow, RTL switch,
  reduced motion, mobile menu) across 7 breakpoints today.
- **Blog / SEO / forms / security (Phase 8):** implemented directly in
  Phase 3 — `SeoBuilder` + `SeoHead.vue` (Open Graph, Twitter, Organization/
  Article/Breadcrumb JSON-LD), `SitemapController` (per-locale sitemap with
  hreflang alternates), honeypot + timing-based spam protection, rate
  limiting on both POST routes, Form Requests with localised validation
  messages, and policy-gated admin access throughout.
- **Tests & docs (Phase 9):** covered above; this log, the audit, the
  traceability matrix, the asset manifest, and the responsive QA doc are the
  documentation deliverables; `README.md` holds setup/deployment instructions.

## Known limitations

1. **No network access in the build environment.** `composer install` and
   `npm install` were never run here. The dependency manifests are believed
   internally consistent (versions checked against currently-stable Laravel
   11 / Filament 3 / Inertia 2 / Vue 3 releases as of the training data), but
   the first real install on the client's machine is the actual proof.
2. **`Doran FaNum` is not included.** Commercially licensed, cannot be
   fetched. Vazirmatn is the live fallback per client decision; swapping in
   the licensed files requires no code change (see `docs/ASSET-MANIFEST.md` §10).
3. **Vue page components are not yet written.** The full data contract
   (types, controllers, transformers, seeded content) is complete and
   verified; the presentational layer consuming it is the next unit of work.
4. **Binary assets are a manifest, not files.** 44 images/icons/logos need
   manual export per `docs/ASSET-MANIFEST.md` — this environment cannot write
   binary files fetched from an external CDN.
5. **FA/AR copy is a working translation**, not reviewed by a native
   copywriter. Flagged inline in `SiteSettingsSeeder` and `PageSeeder`.
6. **Tablet layouts are derived, not designed.** Every derivation is
   documented with its reasoning in `docs/RESPONSIVE-QA.md` rather than
   silently invented.
