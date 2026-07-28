# Figma Audit — SahraMarketing

**File:** `HuuGewZFHRm2ekVUFPDQhR`
**Anchor node supplied by client:** `1557:12110`
**Audited via:** Figma MCP connector (Dev Mode), authenticated as Nasim Daei
**Date:** 2026-07-23

---

## 1. Frame-set resolution

The file contains two clearly distinct design generations plus a wireframe generation. The
anchor node `1557:12110` was traced to its parent to determine which generation is current.

### Trace of the anchor node

```
1557:12110  "service section"  (362 × 628, mobile instance)
   └── parent: 1557:12225  "iPhone 16 & 17 Pro - 8"  (402 × 3008)
          └── page: 1:2  "User interface"
```

The anchor is a **mobile instance of a shared component** on the page named `User interface`.

### Page inventory

| Figma page ID | Page name | Status | Reason |
|---|---|---|---|
| `1:2` | **User interface** | **CURRENT** | Contains anchor node. Full design-token set, real photography, real logo vector, complete desktop + mobile frame pairs, shared component library (`Header`, `Footer`, `final CTA card`, `member card`, `Goal card`, `Strategy card`, `project post`, `testimonial card`, `Service card`, `Filters`, `content filter`). |
| `0:1` | Wirefarming | **ARCHIVED** | Low-fidelity wireframes. Placeholder text ("logo", "visual item", "footer", Lorem Ipsum). No variables bound, no real assets, no component library, no mobile frames. Superseded. |

> The earlier work in this project was built against page `0:1`. That page is a wireframe
> iteration and is **excluded**. All implementation below targets page `1:2`.

### Duplicate-frame resolution within page `1:2`

Several page designs exist in more than one copy. Selection signals applied, in order:
(1) reachable from the anchor's component set, (2) variables bound, (3) completeness of the
desktop/mobile pair, (4) newest node ID range, (5) naming consistency.

> **Correction (2026-07-28).** The original pass selected duplicates by
> "newest node ID", which turned out to be the wrong signal: for several pages
> the higher-numbered frame is the **Arabic (RTL) translation** of the same
> design, not a newer revision. Rendering each candidate and reading its header
> shows it immediately — the RTL frames carry an Arabic nav
> (الرئيسية / أعمالنا / خدماتنا) and a right-aligned logo. The table below is
> the corrected mapping: LTR frame drives the `en` implementation, RTL frame is
> the reference for `fa`/`ar`.

| Page | Candidates | LTR (drives `en`) | RTL (drives `fa`/`ar`) | Notes |
|---|---|---|---|---|
| Home | `230:473`, `1419:9192`, `1365:9950` | **`1419:9192`** | `1365:9950` | Both LTR candidates are English; `1419:9192` is the newer one and adds `packages` + `KPI section`. |
| Projects | `541:1558`, `1362:7198` | **`541:1558`** | `1362:7198` | Previously `1362:7198` — that frame is Arabic. |
| Single project | `639:1617`, `1323:7541` | **`639:1617`** | `1323:7541` | Previously `1323:7541` — Arabic. |
| Services | `908:1520`, `1323:7189` | **`1323:7189`** | — | Both LTR; `1323:7189` confirmed English and newer. |
| About | `908:1576`, `1315:5187` | **`908:1576`** | `1315:5187` | Unchanged. |
| Blog list | `569:1175`, `1353:7935` | **`569:1175`** | `1353:7935` | Previously `1353:7935` — Arabic. |
| Single blog | `604:1464`, `1352:7391`, `1352:6535`, `1352:6588` | **`604:1464`** | `1352:7391` | Previously `1352:7391` — Arabic. `1352:6535`/`6588` are section studies. |
| Contact | `447:790`, `1363:8934` | **`447:790`** | `1363:8934` | Previously `1363:8934` — Arabic. |
| Terms | `1072:2618`, `1303:4392`, `1309:4891` | **`1072:2618`** | `1309:4891` | Previously `1309:4891` — Arabic; it is taller because Arabic copy wraps longer, not because it has more content. |
| 404 | `1027:2061`, `1315:5087` | **`1027:2061`** | `1315:5087` | `1315:5087` is named `ar404`. |
| Privacy Policy | `1031:2101` | **`1031:2101`** | — | Single copy. |

### Mobile frame set (page `1:2`)

Named `iPhone 16 & 17 Pro - N`, all 402 px wide (iPhone 16/17 Pro logical width).

| Node | Height | Maps to desktop page |
|---|---|---|
| `1419:9191` | 10607 | Home |
| `1494:9544` | 2553 | Contact |
| `1498:10840` | 3442 | Projects |
| `1530:10875` | 3541 | Blog list |
| `1543:11175` | 3738 | Single blog |
| `1555:10866` | 3833 | Single project |
| `1557:12225` | 3008 | **About** ← contains anchor `1557:12110` |
| `1567:13563` | 874 | 404 |
| `1590:10953` | 2499 | Privacy Policy |
| `1590:11500` | 2499 | Terms & Conditions |
| `1626:12562` | 6710 | Services |
| `1659:11517` | 874 | 404 (ar) |
| `1659:11783` | 874 | 404 (alt) |

**No tablet frames exist in the file.** Tablet behaviour is therefore *derived* from the
same layout system rather than invented — documented per-page in `RESPONSIVE-QA.md`.

---

## 2. Design tokens (extracted from Figma variables)

Read via `get_variable_defs` on nodes `1419:9192`, `1362:7198`, `1557:12225`.

### Colour — brand

| Token | Value |
|---|---|
| `primary black` | `#231F20` |
| `primary white` | `#FFFFFF` |
| `primary gold` | `#BD933B` |

### Colour — gold scale

| Token | Value |
|---|---|
| `gold/100` | `#F9F5EC` |
| `gold/200` | `#F2E9D8` |
| `gold/400` | `#E5D4B1` |
| `gold/500` | `#DEC99D` |
| `gold/600` | `#D7BE89` |
| `gold/700` | `#D1B476` |
| `gold/800` | `#CAA962` |
| `gold/900` | `#C49E4F` |

### Colour — black/neutral scale

| Token | Value |
|---|---|
| `black/50` | `#F4F3F4` |
| `black/100` | `#E9E9E9` |
| `black/200` | `#D3D2D2` |
| `black/300` | `#BDBCBD` |
| `black/500` | `#918F90` |
| `black/600` | `#7B7979` |
| `black/700` | `#656363` |
| `black/800` | `#4F4C4D` |
| `black/900` | `#393637` |
| `black/1000` | `#231F20` |

### Spacing scale

`4, 8, 12, 16, 24, 32, 40, 48, 56, 64, 72, 96, 112`

### Radius scale

| Token | Value |
|---|---|
| `radiusXS` | 4 |
| `radiusSM` | 8 |
| `radiusMD` | 12 |
| `radiusLG` | 16 |
| `radiusROUND` | 1000 |

### Typography — Latin (`Poppins`)

| Token | Family / style / size / weight |
|---|---|
| `EN-Desktop/Body/medium` | Poppins Regular 14 / 400 |
| `EN-Desktop/Body/Large` | Poppins Regular 16 / 400 |
| `EN-Desktop/Label/Medium` | Poppins Medium 12 / 500 |
| `EN-Desktop/Label/Large` | Poppins Medium 14 / 500 |
| `EN-Desktop/Title/Small` | Poppins Regular 18 / 400 |
| `EN-Desktop/Title/Medium` | Poppins Medium 20 / 500 |
| `EN-Desktop/Title/Large` | Poppins Medium 22 / 500 |

Display sizes appear as raw values in the frames: 36 / 40 / 48, Poppins SemiBold (600).

### Typography — Arabic / Persian (`Doran FaNum`)

| Token | Family / style / size / weight |
|---|---|
| `AR-Desktop/Body/Medium` | Doran FaNum Regular 14 / 400 |
| `AR-Desktop/Body/Large` | Doran FaNum Regular 16 / 400 |
| `AR-Desktop/Lable/Large` | Doran FaNum Medium 14 / 500 |
| `AR-Desktop/Title/Small` | Doran FaNum Regular 18 / 400 |
| `AR-Desktop/Title/Medium` | Doran FaNum Medium 20 / 500 |
| `AR-Desktop/Display/Small` | Doran FaNum Bold 36 / 700 |
| `AR-Desktop/Display/Medium` | Doran FaNum Bold 40 / 700 |
| `AR-Desktop/Display/Large` | Doran FaNum Bold 48 / 700 |

> `Doran FaNum` is a **commercial Persian typeface and is not on Google Fonts.** It cannot be
> fetched by this environment. See `ASSET-MANIFEST.md` → *Fonts* for the licensing and
> self-hosting steps required before the FA/AR locales render correctly.

### Layout

- Desktop frame width: **1440**
- Content container: **1248** (96 px gutter each side)
- Mobile frame width: **402**
- Mobile content width: **362** (20 px gutter each side)
- Grid: 12-column implied by 612 (half) and 400/429 (third) card widths

---

## 3. Shared component inventory (page `1:2`)

| Component | Node (representative) | Used on |
|---|---|---|
| `Header` / `Frame 95818` | `1419:9339` | every desktop page |
| `Header/CTA/mobile menu` | `1557:12226` | every mobile page |
| `Footer` | `1419:9317` | every page |
| `final CTA card` | `1419:9333` | Home, Projects, Single project, Services, About, Blog |
| `Main title & tag` | `1363:7520` | Projects, Single project, Services |
| `small title` | `1419:9231` | all section eyebrows |
| `Subtitle` | `1419:9201` | all section intros |
| `CTA` | `1419:9203` | hero, cards |
| `project post` | `1362:7211` | Projects listing |
| `member card` | `992:2644` | About team grid |
| `testimonial card` | `1419:9251` | Home reviews carousel |
| `Goal card` | `1061:2072` | Single project, About |
| `Strategy card` | `1323:7639` | Single project |
| `Service card` | `1419:9295` | Home services cloud |
| `service section` | `1264:3486` | Services page (**anchor's component**) |
| `Big insight` / `small insight` | `1419:9265` / `1419:9267` | Home insights |
| `KPIs` | `1419:9319` | Home |
| `Process card` | `1419:9310` | Home |
| `why us card` | `1419:9238` | Home |
| `FAQ section` | `1419:9278` | Home |
| `Filters` / `content filter` | `1363:7500` / `812:2085` | Projects, Blog, Single project |
| `info` | `1323:7576` | Single project meta |
| `logo` | `1530:10877` → `158:156` | Header, Footer |

---

## 4. Route inventory

| # | Page | Desktop LTR (`en`) | Desktop RTL (`fa`/`ar`) | Mobile | Route (locale-prefixed) |
|---|---|---|---|---|---|
| 1 | Home | `1419:9192` | `1365:9950` | `1419:9191` | `/{locale}` |
| 2 | Projects listing | `541:1558` | `1362:7198` | `1498:10840` | `/{locale}/work` |
| 3 | Single project | `639:1617` | `1323:7541` | `1555:10866` | `/{locale}/work/{slug}` |
| 4 | Services | `1323:7189` | — | `1626:12562` | `/{locale}/services` |
| 5 | About | `908:1576` | `1315:5187` | `1557:12225` | `/{locale}/about` |
| 6 | Blog listing | `569:1175` | `1353:7935` | `1530:10875` | `/{locale}/insights` |
| 7 | Single blog | `604:1464` | `1352:7391` | `1543:11175` | `/{locale}/insights/{slug}` |
| 8 | Contact | `447:790` | `1363:8934` | `1494:9544` | `/{locale}/contact` |
| 9 | Privacy Policy | `1031:2101` | — | `1590:10953` | `/{locale}/privacy-policy` |
| 10 | Terms & Conditions | `1072:2618` | `1309:4891` | `1590:11500` | `/{locale}/terms` |
| 11 | 404 | `1027:2061` | `1315:5087` | `1567:13563` | fallback |

There is **no separate "service detail" page** in the file — services are presented as
alternating sections on one page. No search page, no author archive, no category archive
page exists as a frame; category/tag filtering is a client-side filter chip row
(`Filters` component) on the listing pages.

---

## 5. Section inventory — Home (`1419:9192`)

| Order | Section | Node | Dynamic? | Backend source |
|---|---|---|---|---|
| 1 | Header | `1419:9339` | yes | `menus` + `settings` |
| 2 | Hero (bg image, badge, title, subtitle, 2 CTAs) | `1419:9194` + `1419:9193` | yes | `page_sections` (home.hero) |
| 3 | KPI strip (3 counters) | `1419:9318` | yes | `section_items` (kpi) |
| 4 | Trust proof (6 client logos + fade mask) | `1419:9205` | yes | `clients` |
| 5 | Services cloud (orbit + 4 chips) | `1419:9279` | yes | `services` |
| 6 | Lead magnet strip | `1419:9322` | yes | `page_sections` (home.lead_magnet) |
| 7 | Projects showcase (5 rows + image) | `1419:9216` | yes | `projects` |
| 8 | Process (6 cards) | `1419:9302` | yes | `section_items` (process) |
| 9 | Packages | `1419:9323` | yes | `section_items` (package) |
| 10 | Why us (4 cards) | `1419:9230` | yes | `section_items` (why_us) |
| 11 | Customer reviews (7-card marquee) | `1419:9243` | yes | `testimonials` |
| 12 | Insights (1 big + 2 small) | `1419:9258` | yes | `posts` |
| 13 | FAQ accordion | `1419:9272` | yes | `faqs` |
| 14 | Final CTA card | `1419:9333` | yes | `page_sections` (global.final_cta) |
| 15 | Footer | `1419:9317` | yes | `menus` + `settings` + `social_links` |

---

## 6. Animation inventory

Derived from frame structure and component naming. The file's prototype layer is minimal —
most motion is implied by the design (marquee widths, orbit rings, counters), not by
Smart Animate links. Each entry below records what the design *requires*; the exact easing
values are not stored as Figma variables and are specified here as production defaults.

| # | Animation | Evidence in file | Trigger | Implementation |
|---|---|---|---|---|
| A1 | Hero content stagger-in | Hero text group is a discrete Auto Layout stack | page load | GSAP timeline, y 24→0, opacity 0→1, stagger 0.08, dur 0.6, `power2.out` |
| A2 | Client-logo marquee | `logos` frame is 1036 wide with a `shade` gradient overlay `1419:9215` masking both edges | always, paused on hover | GSAP `xPercent` loop, 28 s linear, RTL-aware direction |
| A3 | KPI counters | KPI values are `+70k` style text | ScrollTrigger enter | GSAP counter tween, dur 2, `power1.out` |
| A4 | Services orbit | `Ellipse 28/33/31` rings + positioned `Service card` chips around a circle | ScrollTrigger scrub | rotate ring −8°→8° across viewport, `none` easing |
| A5 | Project row hover | Note in file: *"when hovering, explanation comes with motion and the image zoom"* (`57:140`) | hover / row focus | CSS: image `scale(1.06)`, row description height auto-expand, 400 ms `cubic-bezier(.22,1,.36,1)` |
| A6 | Testimonial marquee | `cards` frame is 2452 wide inside a 1248 viewport, x offset −602 | always, paused on hover | GSAP `xPercent` loop, 40 s linear |
| A7 | Section reveal | every section is a discrete Auto Layout frame | ScrollTrigger enter, once | y 32→0, opacity 0→1, dur 0.7, `power3.out` |
| A8 | FAQ accordion | `FAQ section` component | click | height auto transition 300 ms + chevron rotate 180° |
| A9 | Mobile menu | `Header/CTA/mobile menu` has a hamburger `Frame` `1530:10879` | click | slide-in panel from inline-end, 320 ms, focus trap |
| A10 | Header backdrop | header uses `backdrop-blur-[15px]` + `rgba(255,255,255,0.05)` | scroll > 40 px | opacity/background transition 250 ms |
| A11 | Final-CTA glow | radial gold ellipse behind the dark card | ScrollTrigger scrub | parallax y −40→40 |
| A12 | Page transition | Inertia navigation | route change | fade+lift 250 ms, GSAP context revert on unmount |

All are gated behind `prefers-reduced-motion: reduce` → animations resolve instantly to
final state. Marquees stop. Scrub effects are disabled.

---

## 7. Form inventory

| Form | Page | Fields | Backend |
|---|---|---|---|
| Contact | Contact, Home | name, brand_name, phone (+968 default), services[], message | `contact_submissions` |
| Lead magnet | Home, Single blog | email | `newsletter_subscriptions` |

Both require: locale-aware validation messages, CSRF, throttle, honeypot, loading/success/
error states.

---

## 8. Admin-manageable content

Everything in §5 plus: site settings (logo, contact details, working-with line), menus
(header/footer), social links, SEO defaults + per-entity overrides, redirects, and all
translatable entity content in `en` / `fa` / `ar`.

---

## 9. Known gaps / decisions requiring client confirmation

| # | Gap | Decision taken |
|---|---|---|
| G1 | No tablet frames | Derived from desktop layout system at `md`/`lg`. Documented per page. |
| G2 | `Doran FaNum` is commercial and unavailable to this environment | Font files must be supplied by the client. `@font-face` block and fallback chain are written and ready; see `ASSET-MANIFEST.md`. |
| G3 | Prototype easing/duration values not stored in file | Production defaults specified in §6 and centralised in `resources/js/lib/motion.ts` so they can be tuned in one place. |
| G4 | `packages` frame `1419:9323` is an empty 1440×1320 container | Modelled as `section_items` of type `package` so content can be authored in admin; renders nothing when empty. |
| G5 | Home shows Persian project titles (باغچه) while page chrome is English | Treated as per-locale content, not a design rule. Titles come from the DB per locale. |
| G6 | Figma MCP asset URLs expire in ~7 days | Full manifest with node IDs + export commands in `ASSET-MANIFEST.md`. |
