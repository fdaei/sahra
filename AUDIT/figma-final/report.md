SIGN-OFF: FAIL (11 findings — 3 BLOCKER-class coverage gaps, 4 MAJOR, 4 MINOR)

# Sahra — Final Figma Parity Verification

- **File:** `HuuGewZFHRm2ekVUFPDQhR`
- **Page:** `1:2` ("User interface")
- **Run:** 2026-08-07T19:25:29Z
- **Figma calls made this session:** 1 (`get_figma_data`, page `1:2`, depth 2)
- **Rate-limit events:** 0

Every Figma value in this report comes from that single tool call. Nothing is
carried over from `AUDIT/figma-fidelity/`, `docs/FIGMA-AUDIT.md`, code comments,
or prior sessions.

---

## 1. Why this cannot be a PASS

The brief specifies the **Figma Dev Mode MCP** toolset: `get_design_context`,
`get_variable_defs`, `get_motion_context`, `get_screenshot`, `download_assets`.

The Figma MCP server actually connected to this session is **Framelink
figma-developer-mcp**, which exposes exactly two tools:

| Brief expects | Available this session | Consequence |
|---|---|---|
| `get_design_context` | partially via `get_figma_data` | layout/fills/type usable |
| `get_variable_defs` | **absent** | token defs unverifiable → **BLOCKED** |
| `get_motion_context` | **absent** | matrix §G unverifiable → **BLOCKED** |
| `get_screenshot` | **absent** | no visual ground truth → **BLOCKED** |
| `download_assets` | `download_figma_images` (partial) | not exercised — see §7 |

Under hard rule 2 ("no inference-based PASS"), matrix sections **B (partly),
D, E, F, G** cannot be adjudicated. Under the brief's own definition of done —
"zero BLOCKED items" — the verdict is FAIL regardless of what the remaining
checks returned.

**This is a coverage failure, not proof the design is wrong.** Several blocked
items may well be correct. They are simply not verifiable with the tools
present, and I will not upgrade them on inference.

---

## 2. Coverage

| Dimension | Covered | Total | Notes |
|---|---|---|---|
| Page frames enumerated | 56 / 56 | 56 | complete, fresh |
| Route-bearing frames mapped | 12 / 12 | 12 | complete |
| Frames fully check-matrixed | 0 | 12 | blocked by tooling |
| Frames partially checked | 1 (`1419:9192`) | 12 | geometry + tokens only |
| Matrix sections adjudicable | A, C (partial), H (partial) | A–H | D/E/F/G blocked outright |
| Locales verified | 0 / 3 | 3 | no per-locale render available |

---

## 3. Findings

| # | Sev | Frame | Node ID | Property | Figma | Code | Delta | File:line |
|---|---|---|---|---|---|---|---|---|
| 1 | BLOCKER | all | — | Motion (§G) — duration, easing, delay, stagger, trigger, origin | **unreadable** (`get_motion_context` absent) | `MOTION` consts | unverifiable | `resources/js/lib/motion.ts:13-45` |
| 2 | BLOCKER | all | — | Visual diff (§D/§F) | **unreadable** (`get_screenshot` absent) | — | unverifiable | — |
| 3 | BLOCKER | all | — | Design-variable defs (§C) | **unreadable** (`get_variable_defs` absent) | 30 colour tokens | unverifiable | `tailwind.config.js:39-93` |
| 4 | MAJOR | Blog list | `1353:7935` | Frame cited as canonical for `insights.index` is the **Arabic** frame — it instantiates Header variant `1305:5253` "Property 1=AR". LTR equivalent is `569:1175` (Header `176:199` "Property 1=En"). | AR frame | cited as the reference | wrong locale variant | `routes/web.php:65` |
| 5 | MAJOR | Contact us | `1363:8934` | Same defect: frame cited for `contact` is the **Arabic** one (Header `1305:5253` AR + Footer `1390:9179` "Property 1=rtl"). LTR equivalent is `447:790`. | AR frame | cited as the reference | wrong locale variant | `routes/web.php:71` |
| 6 | MAJOR | — | — | Hardcoded colour literals in components. §C rules a literal a FAIL even when the value matches a token. **Amended:** the first pass counted 33 by grepping for `#hex`, but ~10 of those are docblocks citing Figma provenance, not rendered styles. The real figure is **24 rendered literals** across 7 files, plus 2 hardcoded `Idealist, …, serif` stacks that CLAUDE.md explicitly forbids. | tokens | `#bd933b`, `#231f20`, `#d3d2d2`, `#dec99d`, `#c49e4f`, `#ecdfc5`, `#FBF9F5`, `#f8f7f8`, `#fff` | 24 rendered | **FIXED** — see §10 |
| 7 | MAJOR | — | — | `tailwind.config.js` header asserts "Every value below maps 1:1 to a named Figma variable", read via `get_variable_defs`. Page `1:2` exposes exactly **4** named variables. 26 of 30 colour tokens have no named variable behind them on this page. | 4 named vars | 30 colour tokens + 13 spacing + 5 radii | claim unsupported | `tailwind.config.js:6-11`, `:69`, `:86` |
| 8 | MINOR | — | — | 5 mobile frames on the page have no mapped route or component (orphans, per Phase 1.3). | `1567:13563`, `1590:10953`, `1590:11500`, `1659:11517`, `1659:11783` | none | 5 orphans | `routes/web.php` |
| 9 | ~~MINOR~~ | Process | — | **RETRACTED — false positive.** The `left-0`/`right-0` here position three SVG fragments that reassemble a *single* icon glyph (`production-1/2/3`, `approval-1/2/3`). Converting them to `start-0`/`end-0` would mirror the fragments independently under RTL and scramble the artwork. Physical positioning is correct here. | — | — | none | `resources/js/Components/Sections/ProcessSection.vue:93,103,119,124` |
| 10 | MAJOR | multiple | — | Hardcoded user-facing strings bypass the translation layer (§H). **Amended:** first pass reported 2; the grep required 8+ characters and was anchored to `>text<` on one line, so it missed short words, multi-line text nodes, static `aria-label`s, and hardcoded English *fallbacks*. The real figure is **9 strings + 5 English fallbacks**. | translated | `Marketing`, `Growth`, `Clear Brand Presence`, `View Case Study` ×2, `Post`, `Story`, `Logo`, `Content types`, `Projects`, `Our Services`, 4 pill fallbacks | 14 | **FIXED** — see §10 |
| 11 | MINOR | — | — | Doran FaNum (6 weights) and Idealist ship as uncompressed `.ttf`; Poppins and Vazirmatn ship `.woff2`. Both RTL locales and every eyebrow pay the penalty. | — | `.ttf` | 7 files | `resources/css/fonts.css:59-121` |

### 3.1 Hardcoded hex distribution

| File | Count |
|---|---|
| `resources/js/Components/Services/ServicesOrbit.vue` | 6 |
| `resources/js/Pages/Home.vue` | 5 |
| `resources/js/Components/Sections/ProjectsShowcase.vue` | 5 |
| `resources/js/Pages/About.vue` | 4 |
| `resources/js/Layouts/AppHeader.vue` | 3 |
| `resources/js/Components/Sections/PackagesSection.vue` | 3 |
| `resources/js/Pages/Insights/Index.vue` | 2 |
| `resources/css/app.css` | 2 |
| `resources/js/Pages/Work/Show.vue` | 1 |
| `resources/js/Layouts/AppFooter.vue` | 1 |
| `resources/js/app.ts` | 1 |

---

## 4. What actually PASSED

These are the only checks with both a Figma value and a code value from this
session.

### Named variables → Tailwind (4 / 4 exact)

| Figma variable | Figma value | Tailwind token | Code value | Verdict |
|---|---|---|---|---|
| `black/100` | `#E9E9E9` | `neutral.100` | `#E9E9E9` | **PASS** |
| `black/200` | `#D3D2D2` | `neutral.200` | `#D3D2D2` | **PASS** |
| `gold/100` | `#F9F5EC` | `gold.100` | `#F9F5EC` | **PASS** |
| `Color/White` | `#FFFFFF` | `paper` | `#FFFFFF` | **PASS** |

### Header geometry (component set `1305:5252`, layout `layout_bcb81f92`)

| Property | Figma | Code | Verdict |
|---|---|---|---|
| padding block | `24px` | `py-6` = 24px | **PASS** |
| padding inline (lg+) | `96px` | `lg:px-24` = 96px | **PASS** |
| logo↔nav gap | `262px` | `lg:gap-[262px]` | **PASS** |
| align items | `center` | `items-center` | **PASS** |
| fill | `rgba(255,255,255,0.05)` | `bg-white/5` | **PASS** |
| backdrop filter | `blur(15px)` | `backdrop-blur-header` → `15px` | **PASS** |

Evidence: `resources/js/Layouts/AppHeader.vue:52,62-63`; `tailwind.config.js:164`.

### Content track

| Property | Figma | Code | Verdict |
|---|---|---|---|
| frame width | `1440` | `max-w-frame` = 1440px | **PASS** |
| wide track | `1248` @ x=96 | 1440 − 2×96 = 1248 | **PASS** |
| narrow track | `1036` @ x=202 | `calc(1036px + 2*96px)` + `px-24` | **PASS** |

Evidence: `resources/css/app.css:112-124`; `tailwind.config.js:147-150`.

### Reduced motion (§G, the one motion row that is code-decidable)

`prefers-reduced-motion` is handled — `resources/js/lib/motion.ts:48-51,78-81,117-119`
gates `initMotion` and `registerEffect`, plus CSS guards in `app.css:24`,
`ProjectsShowcase.vue:354`, `MobileMenu.vue:151`, `ServicesOrbit.vue:272`.
Its **presence** is PASS; whether the durations it suppresses match the file
remains BLOCKED (finding 1).

### Font pipeline

Every `@font-face` `src:` in `fonts.css` resolves to a file that exists in
`public/fonts/`. Poppins ships 400/500/600/700; Vazirmatn ships 400/500/700
(**no 600** — headings at `display-md`/`display-lg`/`heading-sm` will be
synthetically bolded in fa/ar if Doran is unavailable). `font-display: swap` on
all faces. Idealist carries an explicit `unicode-range`.

---

## 5. Per-locale section

Nothing in `fa` or `ar` could be verified against a render — no screenshot tool.
What is decidable from source:

- **Findings 4 and 5** are locale defects at the traceability level: two routes
  are reconciled against Arabic frames while `CLAUDE.md` states all pages were
  reconciled against "canonical LTR frames".
- **Finding 9** — `left-0`/`right-0` in `ProcessSection.vue` will not mirror.
- **Finding 11** — RTL locales carry the heaviest font payload (`.ttf` Doran).
- Vazirmatn's missing 600 weight affects fa/ar only.
- Persian vs Arabic digit separation (`Numerals::localise()`, `config/locales.php`
  `digits`) was **not** verified this session — no Figma text values were fetched
  at the depth needed to compare digit glyphs. **BLOCKED.**

`lang/ar/` lacking `admin.php` is **not** a finding — the admin panel is
English-only and `routes/web.php` restricts the admin locale to `en|fa`.

---

## 6. Motion section

| Element | Figma duration | Figma easing | Code duration | Code easing | Verdict |
|---|---|---|---|---|---|
| A1 hero stagger | **unreadable** | **unreadable** | `0.6s` / stagger `0.08` | `power3.out` | **BLOCKED** |
| A3 KPI counters | **unreadable** | **unreadable** | `2s` | `power3.out` | **BLOCKED** |
| A4 orbit scrub | **unreadable** | **unreadable** | scrub | `none` | **BLOCKED** |
| A7 section reveal | **unreadable** | **unreadable** | `0.7s` | `power3.out` | **BLOCKED** |
| A11 CTA parallax | **unreadable** | **unreadable** | — | — | **BLOCKED** |
| A2/A6 marquees | **unreadable** | **unreadable** | `28s` / `40s` | linear | **BLOCKED** |
| Component state swap | **unreadable** | **unreadable** | `0.3s` | `power2.out` | **BLOCKED** |

`MOTION.ease.brand` is `power3.out` (a GSAP name) while
`tailwind.config.js:169` defines `ease-brand` as `cubic-bezier(0.22, 1, 0.36, 1)`.
GSAP's `power3.out` is **not** that curve — it is a quartic-family ease with no
exact cubic-bezier equivalent. The two "brand" easings named as equivalent in
`motion.ts:15` are numerically different. Flagged as **INFO** rather than a
finding because the brief's tolerance is "exact bezier vs Figma", and the Figma
side is unreadable — but it is a real internal inconsistency worth resolving.

---

## 7. Blocked list

| Item | Why |
|---|---|
| Matrix §G motion, all frames | `get_motion_context` not exposed by the connected MCP server |
| Matrix §D asset byte-comparison | `get_screenshot` absent; `download_figma_images` would need ~50+ calls against a Starter-plan budget — not attempted rather than half-done |
| Matrix §E states (hover/focus/active/disabled/loading/error/empty) | requires component-variant render; `focus-visible` appears in only 5 files, but the Figma side is unreadable |
| Matrix §F responsive between breakpoints | no screenshots; no tablet frames exist in the file |
| Matrix §C token definitions | `get_variable_defs` absent; only 4 named variables surfaced via `get_figma_data` |
| Matrix §B typography per frame | needs per-frame `get_design_context` at text depth — 12 frames × 1 call each, deferred to protect the call budget |
| Direction of `1362:7198`, `1323:7541`, `1352:7391`, `908:1520`, `1315:5187` | depth-2 payload shows no Header instance; needs one targeted fetch each |
| `93:55` (cited at `routes/web.php:77`) | not present on page `1:2` — either on another page or stale |

---

## 8. Clean list

No frame passed every applicable check. `1419:9192` (home, LTR) is the only
frame with any verified rows: header geometry, content track, and the 4 named
colour variables.

---

## 9. Proposed fix order

1. **Restore the Dev Mode MCP server** and re-run. Without
   `get_motion_context`, `get_variable_defs`, and `get_screenshot`, no
   subsequent run can reach PASS either. Everything below is secondary to this.
2. **Findings 4 + 5** — confirm with the designer which frame is canonical for
   `insights.index` and `contact`, then correct `routes/web.php:65,71` and
   `docs/TRACEABILITY.md`. If the AR frames really are canonical, the LTR pages
   have been built against the wrong reference and need re-reconciliation.
3. **Finding 6** — replace 33 hex literals with tokens.
4. **Finding 7** — either bind the tokens to real Figma variables, or rewrite
   the `tailwind.config.js` docblock to state the values were transcribed from
   fills rather than read from variables. The current claim is not supportable.
5. **Finding 9** — `left-0`/`right-0` → `start-0`/`end-0`.
6. **Finding 10** — move the two strings into `lang/*/common.php`.
7. **Finding 11** — convert Doran + Idealist to `.woff2`.
8. **Finding 8** — map or delete the 5 orphan mobile frames.
9. **INFO** — reconcile `power3.out` against `cubic-bezier(0.22, 1, 0.36, 1)`.

---

## 10. Phase 5 — fixes applied

Authorised after the audit was delivered. The three BLOCKER items are tooling
gaps and remain open; everything else actionable was fixed.

| # | Status | What changed |
|---|---|---|
| 1–3 | **OPEN** | Tooling. Needs the Dev Mode MCP server reconnected. |
| 4, 5 | **DOCUMENTED, not swapped** | `routes/web.php` now records the direction evidence inline and names the LTR counterpart, with an explicit "confirm with the designer, do not just swap the ID" note. Which frame is canonical is not mine to decide. |
| 6 | **FIXED** | All 24 rendered literals tokenised. Added a `:root` palette bridge in `app.css` (`--color-ink`, `--color-paper`, `--color-gold`, `--color-gold-rgb`, `--color-gold-500/900`, `--color-neutral-200`, `--font-display`) resolved from `tailwind.config.js` via `theme()`, so SFC `<style>` blocks reach the palette without literals. Three new tokens named for values that had none: `gold.50` `#FBF9F5`, `gold.300` `#ECDFC5`, `neutral.25` `#F8F7F8`. `app.ts` now passes `var(--color-gold)` to the Inertia progress bar — verified safe, `@inertiajs/core` interpolates it straight into an injected `<style>` block. Two hardcoded `Idealist, …, serif` stacks replaced with `var(--font-display)`, per CLAUDE.md. |
| 7 | **FIXED** | `tailwind.config.js` docblock rewritten. It no longer claims variable provenance it cannot support; the 4 genuinely verified tokens are marked inline, and the rest labelled transcribed-from-fills. Spacing and radius comments corrected the same way. |
| 8 | **OPEN** | 5 orphan mobile frames — a design-file question, not a code change. |
| 9 | **RETRACTED** | False positive; see the findings table. No change made. |
| 10 | **FIXED** | New `services` translation namespace in all 3 locales (auto-loaded — `shareTranslations()` enumerates `lang/{locale}/*.php`). Added `work.view_case_study`, `work.content_types`, `work.type_post/story/logo`, `common.projects`. Pill fallbacks now resolve through `t()` instead of English literals. Key parity verified across en/fa/ar: services 9, work 18, common 25. |
| 11 | **FIXED** | Doran (6 weights) + Idealist converted to woff2 via `woff2_compress`. **903,656 → 332,784 bytes, a 63% reduction**, carried mostly by the two RTL locales. `.ttf` retained as a declared `src` fallback, so nothing is orphaned and no licensed original was deleted. |
| INFO | **DOCUMENTED** | `tailwind.config.js` now states plainly that `ease-brand` and `MOTION.ease.brand` are different curves, rather than implying they agree. |

### Deliberately not changed

- **Honeypot label** `Contact.vue:192` "Website" — inside `aria-hidden`, never
  surfaced; translating it would weaken the spam trap.
- **`aria-label="LinkedIn"`** ×2 — proper noun.
- **Mask-gradient `#000`** in `.marquee-mask` — mask alpha, not palette.
  Commented in place explaining why it is exempt.
- **`rgba(189,147,59,…)` inside Tailwind arbitrary values** (`ProjectsShowcase.vue:107`,
  `PackagesSection.vue:66`) — 2 occurrences survive in the emitted CSS.
  Rewriting `shadow-[…]` syntax risks silently breaking a shadow, and these
  were not part of any reported finding. Residual, tracked here.

### Validation

| Check | Result |
|---|---|
| `npm run typecheck` | **clean** |
| `npm run build` | **clean** |
| `theme()` calls resolved in emitted CSS | 0 unresolved |
| `--color-gold-rgb` in emitted CSS | 1 definition, 6 uses |
| `.testimonial-card` background | resolves to `rgb(248 247 248)` = `#F8F7F8` |
| `php -l` on 10 changed PHP files | all pass |
| Translation key parity en/fa/ar | services 9 / work 18 / common 25, no gaps |
| `php artisan test` | **NOT RUN** — `pdo_sqlite` is still absent (CLAUDE.md documents this); the suite fails wholesale before executing. Unverified by tests. |

The verdict line is unchanged: the three BLOCKER coverage gaps are what decide
it, and no amount of code fixing closes them.

---

## 11. Live verification (Playwright vs Figma renders)

Playwright 1.62 + Chromium 151 installed; app served from `127.0.0.1:8123`
against local MariaDB (6 projects, 9 posts). Figma reference renders pulled via
`download_figma_images` at `pngScale: 1` into `AUDIT/figma-final/ref/`, live
captures into `AUDIT/figma-final/live/`.

**This partially closes BLOCKER 2.** `download_figma_images` renders any node to
PNG, which substitutes for the missing `get_screenshot`. It does not close
BLOCKER 1 (motion) or 3 (variables).

### Method caveat — read before trusting any full-page shot

Chromium `fullPage: true` **silently dropped a large absolutely-positioned
image** on the CTA card. A crop of the full-page capture showed the card's gold
artwork missing; an element-level `locator.screenshot()` of the same card at the
same moment showed it present and correct. Element shots are ground truth here;
full-page shots are reliable for *height and overflow*, not for compositing.

### Frame height: live vs Figma (exact, unrounded)

| Page | Figma node | Figma h | Live h | Δ |
|---|---|---|---|---|
| Home desktop | `1419:9192` | 10821 | 10821 | **0** |
| Services desktop | `1323:7189` | 5858 | 5858 | **0** |
| Blog list desktop | `569:1175` (LTR) | 4556 | 4556 | **0** |
| Contact desktop | `EL-e188bc51` | 1693 | 1693 | **0** |
| Header | `1419:9339` | 104 | 104 | **0** |
| Final CTA card | `1419:9333` | 1248×483 | 1248×483 | **0** |
| About desktop | `908:1576` | 4109 | 4115 | +6 |
| Work desktop | `541:1558` (LTR) | 4656 | 4654 | −2 |
| Work desktop | `1362:7198` (cited) | 4640 | 4654 | +14 |
| Home mobile | `1419:9191` | 10607 | 10809 | **+202** |
| Home fa/ar desktop | `1365:9950` (AR) | 11081 | 10506 | **−575** |

### Finding 4 is now empirically resolved

Live `insights` renders at **exactly 4556px** — the height of `569:1175`, the
**English** frame — and 63px off `1353:7935` (4619), the Arabic frame the route
comment cites. The page was built against the LTR frame; the comment is simply
wrong. The same pattern holds for `work`: live 4654 sits 2px from `541:1558`
(LTR) and 14px from the cited `1362:7198`.

**Recommendation upgraded from "ask the designer" to "correct the comments."**
Contact cannot be disambiguated this way — `447:790` and `1363:8934` share
template `EL-e188bc51`, so both are 1693 tall.

### New findings from live rendering

| # | Sev | What | Figma | Live |
|---|---|---|---|---|
| 12 | MAJOR | Header CTA label | "Book a consolution" (sic — typo is in the file) | "Let's Talk" (`common.lets_talk`) |
| 13 | MAJOR | Home **mobile** total height | 10607 | 10809 (**+202px**) |
| 14 | MAJOR | Home **fa/ar** total height vs the AR frame | 11081 | 10506 (**−575px**) |
| 15 | MAJOR | Service section start offset (both full-bleed padded frames, apples-to-apples) | y=1460 | y=1584 (**+124px**) |
| 16 | MINOR | Final-CTA button width | ≈220px | ≈264px — consequence of the differing label; Figma's export renders the pill with no visible text, so its copy is unconfirmed |
| 17 | MINOR | Packages section start | y=5061 | y=5068 (+7px) |
| 18 | MINOR | Footer start | y=10390 | y=10370 (−20px) |

Section drift is non-monotonic (+124 at services, +7 at packages, −20 at footer)
and happens to cancel to 0 at the page total. A matching total height is
therefore **not** evidence of matching internal rhythm — the KPI band sits at
y=904 live against y=850 in Figma.

### Live checks that PASSED

| Check | Result |
|---|---|
| Horizontal overflow @1440 and @402, 8 pages × 3 locales | **none** — `scrollWidth == clientWidth` everywhere |
| Console/page errors | **zero** across all pages and locales |
| `dir` attribute | `ltr` en / `rtl` fa / `rtl` ar |
| RTL header mirroring | logo `left:96,right:236` (en) → `left:1204,right:1344` (fa/ar) = the 96px gutter, mirrored exactly |
| Body font resolution | `Poppins…` (en), `"Doran FaNum", Vazirmatn, Tahoma…` (fa/ar) — **the woff2 conversion loads correctly** |
| `--color-gold` computed at runtime | `#BD933B` — **the token bridge resolves in a real browser** |
| Final CTA artwork | present and matching (element shot) |

### Retracted

**"Final CTA artwork missing" — false positive.** Diagnosed to Chromium
full-page capture, not the site: the `<img>` reports `complete: true`,
`naturalWidth: 1672`, `opacity: 1`, `visibility: visible`, box 1248×580,
`object-fit: cover`. The element screenshot renders the gold arc and dune
contours correctly.

---

## 12. Vertical rhythm retune — home desktop (findings 13–18)

Scope agreed: **LTR home desktop only**. Header CTA copy stays "Let's Talk"
(finding 12 recorded as an intentional deviation — Figma's label carries a typo,
"Book a consolution").

### Result: 14 / 14 nodes at 0px

| Figma node | Figma y | Live y before | Live y after |
|---|---|---|---|
| hero image `1419:9193` | 0 | 0 | **0** |
| KPI section `1419:9318` | 850 | 962 | **850** |
| trust proof `1419:9205` | 1123 | 1270 | **1123** |
| service section `1419:9279` | 1460 | 1584 | **1460** |
| lead magnet `1419:9322` | 2582 | 2658 | **2582** |
| project section `1419:9216` | 2919 | 3059 | **2919** |
| process `1419:9302` | 4077 | 4210 | **4077** |
| packages `1419:9323` | 5061 | 5068 | **5061** |
| why us `1419:9230` | 6581 | 6496 | **6581** |
| reviews `1419:9243` | 7251 | 7266 | **7251** |
| insights `1419:9258` | 7922 | 7947 | **7922** |
| faq `1419:9272` | 8788 | 8911 | **8788** |
| final CTA `1419:9333` | 9586 | 9627 | **9586** |
| footer `1419:9317` | 10390 | 10370 | **10390** |

### How

Section components are shared with 6 other pages, so their padding was left
untouched and the correction applied at the Home.vue call site as `lg:` margins.
Values are *incremental* — a margin shifts everything after it, so
`shift[i] = d[i] − d[i−1]`.

Two genuine bugs surfaced, as opposed to accumulated drift:

1. **KPI/hero overlap was missing at desktop.** Figma puts the KPI band at
   y=850 over a 1440×904 hero — the cards sit *on* the hero. The code did this
   only on mobile (`-mt-[117px]`); at desktop `md:mt-0` dropped it, and
   `lg:py-28` added a further 112px. Fixed with `lg:-mt-[54px] lg:pt-0`.
2. **The old page total of 10821 matched Figma by coincidence.** Per-section
   drift ran +147 to −85; the errors cancelled. A matching total was never
   evidence of a matching interior.

### Residual: total height 10841 vs 10821 (+20)

Every section *starts* correctly; the excess is the footer's own height.
Live footer measures **451px**. The Figma footer render is 1460×590, and its
`0px -5px 10px` shadow accounts for 10px of horizontal bleed each side
(1440+20 = 1460 ✓) and 20px vertical (15 top, 5 bottom) — implying an actual
node height of ≈**570px**, which overflows the 10821 frame by 149px.

So the live footer is ≈119px shorter than designed. **Not fixed:** the footer
lives in `AppLayout` and is shared by all 7 pages, putting it outside the agreed
scope. Flagged for a separate decision. The bleed-subtraction is an inference,
not a measured node height — confirm before acting on it.

### Regression checks after the retune

| Check | Result |
|---|---|
| Home @402 (mobile) | 10809 — **unchanged**, all offsets are `lg:`-gated |
| services / work / about / insights / contact @1440 | 5858 / 4654 / 4115 / 4556 / 1693 — **all unchanged** |
| Horizontal overflow @402…1920 | none |
| Console + page errors | zero |
| Unintended section collisions @1024–1920 | none — every negative margin (max 100px) is smaller than the preceding section's 112px bottom padding, so they consume slack, not content |
| `npm run typecheck` / `npm run build` | clean |

### Standing caveat

These offsets are tuned to the **currently seeded copy**. Section heights are
content-dependent, so materially longer CMS text re-opens the drift. The
measurement harness is the way to re-check, not eyeballing. This is inherent to
reconciling an absolutely-positioned Figma frame against a CMS-driven page.

### Still not fixed from §11

- **13 — home mobile +202px** and **14 — fa/ar −575px** are not spacing bugs.
  Figma's AR frame (`1365:9950`, 11081) is 260px *taller* than its EN frame,
  while live AR renders 315px *shorter* than live EN — the Figma mock copy and
  the seeded translations are different text. No margin fixes that.
- **12 — header CTA copy**, by decision.
