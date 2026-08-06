# Figma ↔ Code Fidelity Audit — SahraMarketing

**File:** `HuuGewZFHRm2ekVUFPDQhR` · page `1:2` "User interface"
**Run started:** 2026-08-05 · iteration 0
**Code root:** `resources/js`
**Stack:** Laravel 12 + Inertia 2 + Vue 3 (TS) + Tailwind · locales en/fa/ar

---

## Capability gap (read this before the findings)

The Figma MCP connected to this session is the Framelink-style server, which
exposes exactly two tools: `get_figma_data` and `download_figma_images`. The
Dev Mode toolset the audit protocol assumes — `get_metadata`,
`get_variable_defs`, `get_design_context`, `get_motion_context`,
`search_design_system`, `get_code_connect_map`, `get_screenshot`,
`download_assets`, `list_shader_effects` — is **not available**.

Consequences, applied consistently throughout:

| Protocol step | Status |
|---|---|
| A–E, G, H, I (spacing, sizing, layout, type, color, states, responsive, RTL) | auditable from `get_figma_data` |
| **F — animation & motion** | **`unverified` for every node.** Keyframes, easing, duration, delay and trigger cannot be read. No motion finding in this report is a `pass`, and none is a confirmed failure. |
| **Code Connect map** | unavailable → every node→file match is `match_confidence: "inferred"` (name/path/docblock matching) |
| **Phase 4 screenshot diff** | unavailable → verification is a Phase 2 re-run against the spec, not a visual comparison |
| `get_variable_defs` | unavailable → token names below are the payload's own style/variable keys, which is the same naming Figma exposes |

The user reviewed this gap and chose to proceed degraded (2026-08-05).

---

## Coverage so far

| Frame | Node | Status |
|---|---|---|
| Home (LTR desktop) | `1419:9192` | **audited — page-level sections; sub-components pending** |
| All other 32 frames | — | pending |

Home sections **verified node-by-node**: Why us `1419:9230`, FAQ `1419:9272`,
Insights `1419:9258`, KPI `1419:9318`, Trust proof `1419:9205`, section order.

Home sections **extracted but not yet drilled to leaf level** (their findings are
provisional and marked `unverified` where the leaf value was not read): hero
title/subtitle `1419:9199/9200/9201`, services orbit `1419:9279`, lead magnet
`1419:9322`, projects `1419:9216`, process `1419:9302`, packages `1419:9323`,
reviews `1419:9243`, final CTA `1419:9333`, header `1419:9339`, footer `1419:9317`.

---

## Frame: Home — `1419:9192` (1440 desktop)

### critical

_None found so far._

### high

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| H-01 | `1419:9233` | auto-layout `itemSpacing` (title→subtitle) | `gap: 40px` | `mt-6` = 24px | [Home.vue:406](resources/js/Pages/Home.vue#L406) | Wrap the two nodes in `flex flex-col gap-10` and drop `mt-6`. Also fixes the margin-faking-gap pattern. |
| H-02 | `1419:9234` | fontSize | Poppins SemiBold **40** / `#393637` | `text-display-sm` = **36**/500 | [Home.vue:400](resources/js/Pages/Home.vue#L400) | `text-display-md` (40/600) — already the correct token, used properly in Insights at line 503. |
| H-03 | `1419:9235` | fontSize + weight + fill | Poppins **Medium 18** / black/700 `#656363` | `text-body-lg text-neutral-600` = 16/400 / `#7B7979` | [Home.vue:406](resources/js/Pages/Home.vue#L406) | `text-title-sm font-medium text-neutral-700` |
| H-04 | `1419:9233` | Fixed width | `width: 506` (fixed) inside a `space-between` row of 1243 | `lg:grid-cols-2` → two equal 608px columns | [Home.vue:397](resources/js/Pages/Home.vue#L397) | `lg:grid-cols-[506px_1fr]` with `justify-between`, matching the row rather than halving it. |
| H-05 | `1419:9236` / `1419:9237` | `itemSpacing` + `counterAxisSpacing` | column gap **48**, inner rows gap **40** (a 2×2 grid: row-gap 48, column-gap 40) | `grid grid-cols-2 gap-4` = 16 both axes | [Home.vue:412](resources/js/Pages/Home.vue#L412) | `grid grid-cols-2 gap-x-10 gap-y-12`. Category A requires both axes to be present explicitly. |
| H-06 | `I1419:9238;398:727` | icon asset | 4 distinct custom vectors (`398:723`, `398:724`, `398:725`, `398:726`), 32×32, no fill | 4 generic lucide icons `BadgeCheck / PanelsTopLeft / Gem / ClipboardCheck` | [Home.vue:144](resources/js/Pages/Home.vue#L144), [Home.vue:419-423](resources/js/Pages/Home.vue#L419-L423) | Export the four Figma vectors and reference them. Size (32) is already correct. |
| H-07 | `1419:9274` | row `itemSpacing` | `gap: 32` | `gap-12` = 48 | [Home.vue:587](resources/js/Pages/Home.vue#L587) | `gap-8`. The 48 in the code is the *section* gap (`1419:9272`), applied to the wrong nesting level. |
| H-08 | `1419:9275` | Fixed width | `width: 497` (fixed), sibling fills the rest | `lg:grid-cols-2` → two equal 600px columns | [Home.vue:587](resources/js/Pages/Home.vue#L587) | `lg:grid-cols-[497px_1fr]` |
| H-09 | `1419:9272` → `1419:9274` | nesting level of the eyebrow | section is a **column** `[small title, faq content]` with `gap: 48`; the eyebrow spans the full 1248 width above the row | eyebrow is hoisted **into the left grid cell**, so the FAQ list starts level with the eyebrow instead of 48px below it | [Home.vue:587-601](resources/js/Pages/Home.vue#L587-L601) | Lift the eyebrow out of the grid: `<div class="eyebrow">…</div>` as a sibling above a `grid gap-8 lg:grid-cols-[497px_1fr]`, with `mt-12` (48) on the grid. |
| H-10 | `1419:9277` | missing node | `Subtitle` instance `1005:1581`, Poppins Medium 18 / black/700 — "Because every creative decision is built around brand clarity, consistency, and growth." | no counterpart; the left FAQ column renders eyebrow + h2 only | [Home.vue:588-601](resources/js/Pages/Home.vue#L588-L601) | Render `faqSection.subtitle`. Note the identical sentence *is* rendered in Insights (line 518) — the FAQ copy is a separate node, not a duplicate to skip. |
| H-11 | `1419:9276` | fontSize | Poppins SemiBold **40** | `text-display-sm` = **36**/500 | [Home.vue:596](resources/js/Pages/Home.vue#L596) | `text-display-md`. Same defect as H-02. |
| H-12 | `1419:9275` | `primaryAxisAlignItems` + vertical sizing | `justifyContent: space-between`, vertical `fill` — title pinned top, subtitle pinned bottom, column stretched to the FAQ list height | plain stacking, `hug` height | [Home.vue:588](resources/js/Pages/Home.vue#L588) | `flex flex-col justify-between self-stretch` on the left cell (depends on H-10 landing first). |

### medium

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| M-01 | `1419:9230` | section `itemSpacing` | column with **no gap declared** (= 0) between eyebrow and the why-us row | `mt-8` = 32px | [Home.vue:397](resources/js/Pages/Home.vue#L397) | See "Design-side questions" — gap 0 is suspect; do **not** conform the code to it without a design decision. |
| M-02 | `EL-b5fd3dfe` (`1419:9238`…`9242`) | boxShadow blur | `0px 4px **10px** 0px rgba(0,0,0,0.05)` | `shadow-[0_4px_5px_rgba(0,0,0,0.05)]` — blur **5px** | [Home.vue:416](resources/js/Pages/Home.vue#L416) | `shadow-[0_4px_10px_rgba(0,0,0,0.05)]`. Note `shadow-card` in the config is a *different* shadow (4/4/12) — don't reuse it here. |
| M-03 | `EL-b5fd3dfe` | sizing | `hug` / `hug` | `min-h-[184px]` | [Home.vue:416](resources/js/Pages/Home.vue#L416) | No minHeight exists in the design. Either drop it or log it as an intentional CMS-safety floor. |
| M-04 | `I1419:9238;398:528` | Fixed width | `width: 212` (fixed) on the card description | no width constraint | [Home.vue:426](resources/js/Pages/Home.vue#L426) | `max-w-[212px]` on the description `<p>`. |
| M-05 | `I1419:9265;1210:3789` | `space-between` faked with margins | column, `justifyContent: space-between`, vertical `fill` | fixed `mt-14` (56) and `mt-8` (32) between children, `mt-auto` on the arrow | [Home.vue:543](resources/js/Pages/Home.vue#L543), [Home.vue:546](resources/js/Pages/Home.vue#L546) | `flex flex-col justify-between h-full` and drop the `mt-*`. Recurring root cause #1. |
| M-06 | `I1419:9265;1210:3790` | row spacing | `justifyContent: space-between`, img 279 + content **270** (→ 31px between) | `md:grid-cols-[279px_1fr]` + `ps-6` (24) → content 277 | [Home.vue:527](resources/js/Pages/Home.vue#L527), [Home.vue:538](resources/js/Pages/Home.vue#L538) | `md:grid-cols-[279px_270px] justify-between` and drop `ps-6`. |
| M-07 | `I1419:9278;438:620` | default variant | first FAQ box is variant **`open`** (`438:561`); the other three are `close` (`438:563`) | every `<details>` renders closed | [Home.vue:604-609](resources/js/Pages/Home.vue#L604-L609) | `:open="i === 0"` on the first `<details>`. |
| M-08 | `docs/TRACEABILITY.md` | node→page mapping | LTR desktop drivers are `541:1558`, `639:1617`, `569:1175`, `604:1464`, `447:790`, `1072:2618` (FIGMA-AUDIT.md §1, 2026-07-28 correction) | still lists the Arabic RTL frames `1362:7198`, `1323:7541`, `1353:7935`, `1352:7391`, `1363:8934`, `1309:4891` as the desktop nodes | [TRACEABILITY.md:15-23](docs/TRACEABILITY.md#L15-L23) | Update the desktop column and add an RTL-reference column. The doc contradicts its own source of truth. |

### low

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| L-01 | `I1419:9263;1005:1580` | sizing | `width: 612` **fixed** | `max-w-[612px]` | [Home.vue:510](resources/js/Pages/Home.vue#L510) | Fixed-vs-max is a real Fill/Fixed mismatch but renders identically at every audited breakpoint. |

### unverified (could not be read — not passes)

| Node | Category | Why |
|---|---|---|
| every node in this frame | **F — motion** | `get_motion_context` unavailable. A1 hero stagger, A3 KPI counters, A6 testimonial marquee, A7 reveal, A12 transition all remain unconfirmed in both directions. |
| `1419:9200`, `1419:9201` | D — hero title/subtitle type | not returned at the extraction depth used; the values in the [Home.vue:207-214](resources/js/Pages/Home.vue#L207-L214) docblock are the code's own claim and per protocol cannot be used as evidence. |
| `I1419:9265;1210:3789` | C — `alignItems: flex-end` | Figma right-aligns all four children of the Big-insight content column; whether that is visible depends on child sizing, which was not read. Needs a leaf-level drill. |
| `I1419:9278;438:620;438:556` | D — FAQ question/answer type | inside the FAQ box component; not read. |

### passes worth recording

`.eyebrow` / `.eyebrow::before` reproduces the `small title` component
(`1005:1574`) exactly — 11.31px disc, `#BD933B`, `border-radius: 1000px`, the
symmetric `2px 2px 12px / -2px -2px 12px rgba(189,147,59,0.5)` glow, gap 4,
Idealist 24. `.edge-gold` reproduces the KPI card's 1px OUTSIDE 136° gradient
stroke and `#FFFFFF` padding-box fill. KPI geometry (1036 track, gap 16,
padding 24/12, gap 8, radius 8, inner gaps 16 and 4) is exact. Trust-proof
column gap 32 and logo-rail gap 48 are exact. Insights is the best-implemented
section on the page: section gap 48, title gap 48, `505px_1fr` at gap 132,
card row gap 24 at height 424, image 279×392 and 188×188, content gap 24,
divider `#D3D2D2` — all exact. **Section order matches the Figma y-order
exactly, all 16 sections.**

---

## Frame: Home — Customer review `1419:9243` (audited separately)

This section is the worst-implemented block on the page: the entire
`title & subtitle` row (`1419:9246`) — structurally **identical** to the Insights
row the code implements correctly at [Home.vue:500](resources/js/Pages/Home.vue#L500) —
is absent, and the card geometry is wrong on three axes.

### high

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| R-01 | `1419:9246` | missing subtree | `row`, `gap: 132`, `fill` — holds the 505px title and the subtitle side by side | no row; a bare `<h2>` | [Home.vue:445-450](resources/js/Pages/Home.vue#L445-L450) | Mirror Insights: `grid items-start gap-8 lg:grid-cols-[505px_1fr] lg:gap-[132px]`. |
| R-02 | `1419:9248` | missing node | `Subtitle` `1005:1581`, Poppins Medium 18 / black/700, width 612 — "Because every creative decision is built around brand clarity, consistency, and growth" | no counterpart | [Home.vue:451](resources/js/Pages/Home.vue#L451) | Render `reviews.subtitle` in the second cell of R-01's grid. |
| R-03 | `1419:9247` | fontSize | Poppins SemiBold **40** / `#393637` | `text-display-sm` = **36**/500 | [Home.vue:446](resources/js/Pages/Home.vue#L446) | `text-display-md`. Third instance of this same substitution (see H-02, H-11). |
| R-04 | `1419:9247` | Fixed width | `width: 505` (fixed) | `max-w-xl` = 576px | [Home.vue:446](resources/js/Pages/Home.vue#L446) | Drop `max-w-xl`; the 505px column from R-01 carries the width. 71px too wide today. |
| R-05 | `1419:9244` | `itemSpacing` | `gap: 48` between eyebrow and the title row | no gap — `<h2>` follows the eyebrow directly | [Home.vue:439-450](resources/js/Pages/Home.vue#L439-L450) | Wrap both in `flex flex-col gap-12`. |
| R-06 | `EL-82980ba1` (`1419:9251`…`9257`) | fixed height | `height: 246` (fixed) | `h-[228px]` | [Home.vue:466](resources/js/Pages/Home.vue#L466) | `h-[246px]`. Width 328 is already correct (inner 280 + 2×24 padding). |

### medium

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| R-07 | `1419:9243` | `itemSpacing` | `gap: 40` (title block → cards) | `mt-11` = 44px | [Home.vue:459](resources/js/Pages/Home.vue#L459) | `mt-10` (40). `11` is not in the Figma spacing scale — it resolves via Tailwind's *default* scale, which `extend.spacing` does not remove. Off-token value where a token exists. |
| R-08 | `1419:9250` | `itemSpacing` | `gap: 26` | `gap-6` = 24px | [Home.vue:462](resources/js/Pages/Home.vue#L462) | `gap-[26px]`. 26 is not on the 4px scale — arbitrary value is correct here; the alternative is a design-side token fix. |
| R-09 | `EL-82980ba1` | boxShadow blur | `1.9537px 1.9537px **5.861px** rgba(0,0,0,0.05)` | `shadow-testimonial` = `1.954px 1.954px **2.931px**` — blur is exactly half | [tailwind.config.js:157](tailwind.config.js#L157) | Correct the token to `1.954px 1.954px 5.861px`. Config-level, so it fixes every consumer at once. |
| R-10 | `1419:9249` | fixed height | `height: 297` (fixed), track inset `y: 26`, card 246 | no height; `pb-4` on the mask, card 228 → 244 total | [Home.vue:459](resources/js/Pages/Home.vue#L459) | `h-[297px]` on the viewport with the track vertically centred, once R-06 lands. |
| R-11 | `1419:9249` | overflow / clip width | viewport is `fill` of the **1248** section track | marquee is lifted out of `.container-sahra` and runs full-bleed to the viewport edge | [Home.vue:459](resources/js/Pages/Home.vue#L459) | Design clips at 1248; code clips at 100vw. Confirm which is wanted — full-bleed may be a deliberate responsive call, in which case log it as `unspecified_in_design`. |
| R-12 | `1419:9249` | added effect | no `shade`/mask node under this frame (the `shade` `1419:9215` the CSS cites belongs to the **client logo** rail) | `.marquee-mask` gradient mask applied here too | [Home.vue:459](resources/js/Pages/Home.vue#L459), [app.css:254-270](resources/css/app.css#L254-L270) | Code element with no Figma counterpart — reported, not deleted. Likely deliberate, but it is not in the design. |

### low

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| R-13 | `EL-82980ba1` | strokeWeight | `0.488417px` | `border-[0.5px]` | [Home.vue:466](resources/js/Pages/Home.vue#L466) | Sub-pixel; 0.5px is the nearest valid implementation. Rounding noted, no change recommended. |

### unverified

| Node | Category | Why |
|---|---|---|
| `414:863` set | G — hover variant | The payload returns only the `en-Default` instance (`414:862`). The `en-hover` variant `414:864` that [app.css:184-208](resources/css/app.css#L184-L208) implements could not be read, so neither its existence nor its property values are confirmed here. |
| `1419:9250` | F — marquee motion | Track offset `x: -602` is static layout data, not keyframes. The 40s duration in the code is unverifiable. |

### passes

Card fill `#F8F7F8` and stroke `black/200` `#D3D2D2` are exact
([app.css:193](resources/css/app.css#L193)). Card width 328 is exact. Inner
`space-between` is correctly achieved with `mt-auto`. Radius 8 exact. Card count
(7) matches. Eyebrow exact.

---

## Frame: Projects — `541:1558` (1440 desktop, LTR)

**Code:** [Work/Index.vue](resources/js/Pages/Work/Index.vue) · match_confidence `inferred`

Figma page column `1726:11741` sits at (96, **184**), width 1248, and nests
`gap: 224` → `gap: 120` → `gap: 96`. The code flattens all three into a single
`gap-16 md:gap-24` on one container, so every vertical interval on the page is
wrong except one.

### high

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| P-01 | `1726:11741` | `itemSpacing` | `gap: 224` (content block → final CTA) | `pb-24` = 96px, and `CtaBanner` sits outside the container entirely | [Work/Index.vue:184-187](resources/js/Pages/Work/Index.vue#L184-L187) | `pb-56` (224). Largest single spacing error found so far — 128px. |
| P-02 | `1726:11735` | `itemSpacing` | `gap: 120` (heading row → grid) | `md:gap-24` = 96px | [Work/Index.vue:74](resources/js/Pages/Work/Index.vue#L74) | Nesting levels must be split: outer `gap-56`, inner `gap-[120px]`. 120 is not on the 4px scale — arbitrary value or a design-side token gap; I recommend the arbitrary value, since 120 appears as a deliberate rhythm here. |
| P-03 | `1726:11741` | y offset | content top at **y = 184** | `md:pt-[192px]` | [Work/Index.vue:74](resources/js/Pages/Work/Index.vue#L74) | `md:pt-[184px]`. Note this **contradicts** [app.css:154-156](resources/css/app.css#L154-L156), whose `.section-first` comment asserts "Figma puts the first eyebrow of every inner page at y=192". This frame reads 184. The claim needs re-checking across the other inner pages before `.section-first` is trusted. |
| P-04 | `1219:4240` | `counterAxisAlignItems` | `alignItems: center` | `lg:items-start` | [Work/Index.vue:76](resources/js/Pages/Work/Index.vue#L76) | `lg:items-center`. The filter column is vertically centred against the title block in the design. |

### medium

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| P-05 | `1005:1609` | Fixed width | `width: 611` (fixed) | `max-w-[612px]` | [Work/Index.vue:79](resources/js/Pages/Work/Index.vue#L79) | 1px out, and Fixed implemented as max-width. Same 611-vs-612 rounding appears in the Home hero column — likely one design-side nudge. |

### low

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| P-06 | `1215:4072` | container nesting | final CTA is `alignSelf: stretch` **inside** the 1248 track | `CtaBanner` is rendered outside `.container-sahra` | [Work/Index.vue:187](resources/js/Pages/Work/Index.vue#L187) | Only a real defect if `CtaBanner` does not re-establish the 1248 track internally — not yet read. Provisional. |

### unverified

| Node | Category | Why |
|---|---|---|
| ~~`1214:3933` children~~ | ~~A–E — the project card~~ | **RESOLVED — see "Project card" below. Drilled `1214:3933` and `553:921` to leaf level; the card passes on every property.** |
| `1005:1609` children | D — heading type | Not returned at this depth; `text-display-md md:text-display-lg` and the `gap-6` title/subtitle interval are unconfirmed. |
| `542:871` children | A/D/G — filter chips | `FilterChips.vue` not yet read; only the wrapper (`column`, `justify center`, `gap: 16`) was extracted. |
| all nodes | F — motion | as everywhere: `get_motion_context` unavailable. |

### passes

Grid `1214:3933` is **exact**: `gap: "96px 24px"` → `gap-x-6 gap-y-24` with
`sm:grid-cols-2`. This is the one place in the audit so far where an asymmetric
two-axis gap is implemented correctly on both axes. `1215:4090`'s
`alignItems: center` → `mx-auto` on the More Works control is correct, as is its
`gap: 8` → `gap-2`. Header `541:1559` is byte-identical to Home's `1419:9339`
(same component `176:199`, padding 24/96, gap 262, `rgba(255,255,255,0.05)`,
`blur(15px)`), so the shared `AppHeader.vue` is the right factoring.

### Project card `907:1423` — drilled to leaf level, **zero findings**

Extracted `1214:3933` and the `project detail` component `553:921` to leaf
depth. Every property matches. This is the highest-fidelity component found in
the audit so far, and it is worth recording precisely because the earlier pass
could not confirm it:

| Figma node | Value | Code | Verdict |
|---|---|---|---|
| `907:1423` `project post` | column, `gap: 40`, fill/fill | `flex flex-col gap-10` | pass |
| `I907:1423;542:852` `img` | radius **12**, stroke black/100 **1px**, shadow **4/4/12 rgba(0,0,0,0.05)** | `rounded-md border border-neutral-100 shadow-card` | pass |
| `I907:1423;1363:8635` `project detail` | column, `gap: 24` | `flex flex-col gap-6` | pass |
| `553:918` `caption` | column, `gap: 16` | `flex flex-col gap-4` | pass |
| `553:1101` `title+industary` | row, `space-between`, `items-center` | `flex items-center justify-between gap-4` | pass |
| `553:895` title | Poppins **SemiBold 36** / black/900 `#393637` | `md:text-[36px] font-semibold text-neutral-900` | pass |
| `1145:3137` `category` | row, `gap: 8`, hug | `flex shrink-0 items-center gap-2` | pass |
| `I1145:3137;1145:3120` icon | **24 × 24** | `size-6`, `width/height="24"` | pass |
| `I1145:3137;1145:3121` | Poppins **Medium 14** / black/500 `#918F90` | `text-label-lg text-neutral-500` | pass |
| `551:891` description | Poppins **Regular 16** / black/700 `#656363`, fill | `text-body-lg text-neutral-700` | pass |
| `553:917` `services` | row, `gap: 8`, hug | `flex flex-wrap items-center gap-2` | pass |
| `I553:908;553:904` badge | Poppins **Regular 14** / black/500 `#918F90` | `text-body-md text-neutral-500` | pass |
| `553:905` separator | ELLIPSE **4 × 4**, `#BD933B` | `size-1 rounded-full bg-gold` | pass |
| separator placement | badge · dot · badge · dot · badge | `v-if="i > 0"` | pass |
| `1214:3933` rows | `repeat(3, fit-content(100%))` × 2 cols = 6 | `PAGE_SIZE = 6` | pass |
| `553:935` variants | `services` row exists **only** in variant `hover` `553:921`; `default` `553:936` has caption only | `max-h-0 opacity-0` → `group-hover:max-h-16 group-hover:opacity-100`, with `motion-reduce` escape | pass |

The values asserted in the [Work/Index.vue:1-18](resources/js/Pages/Work/Index.vue#L1-L18)
docblock turned out to be accurate in every particular — but they are now
*verified* rather than *claimed*.

Two notes, neither a defect:

- `I907:1423;542:852` is `fill` width / **fixed 612 height**; the code uses
  `aspect-square w-full`. Identical at the audited 1440 frame (column = 612).
  Below 1440 they diverge, but no Figma frame exists there — logged as
  `unspecified_in_design`, not a finding.
- The title row carries `gap-4` in code where Figma declares no gap. Inert under
  `space-between` until the two children would collide; arguably a safety
  improvement. Low, no change.

Card 1 (`907:1423`) instantiates the `hover` variant while cards 2–6 use
`default` — that is the designer showing the hover state on one tile, not a
requirement on the implementation.

### design-side note

`1215:4065` ("More Works") instantiates component `1145:3179`, which is the
**`rtl` variant** of set `1360:7071` — inside an otherwise LTR frame. Either the
designer picked the wrong variant, or the set's variant names are backwards.
Flagged, not conformed to.

---

## Frame: Single project — `639:1617` (1440 desktop, LTR)

**Code:** [Work/Show.vue](resources/js/Pages/Work/Show.vue) · match_confidence `inferred`

Same flattening defect as Projects, and it matters more here: the file nests
`224` (page) → `224` (content) → `144` (sections), and the code collapses the
inner 144 into the outer 224, so **every gap between the nine content sections
is 80px too large**.

### high

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| SP-01 | `1361:7093` … `1361:7089` | `itemSpacing` | **`gap: 200`** between major blocks (intro → challenge → goals → strategy → deliverables → showcase → results); **`gap: 144`** only for before/after and next-case-study | `lg:gap-[224px]` on one flat column holding all nine sections | [Work/Show.vue:106](resources/js/Pages/Work/Show.vue#L106) | Two levels, not one: outer column `md:gap-[144px]`, with sections 1–7 wrapped in a nested `md:gap-[200px]` div. The file nests `224 → 224 → 144 → 200 → 200 → 200`; a single gap cannot express it. |
| SP-02 | `1361:7124` | `itemSpacing` | `gap: 224` (content → final CTA) | `pb-32` = 128px, with `CtaBanner` outside the column | [Work/Show.vue:106](resources/js/Pages/Work/Show.vue#L106), [Work/Show.vue:382](resources/js/Pages/Work/Show.vue#L382) | `pb-56` (224). Same shape as P-01 on the Projects frame. |
| SP-03 | `1083:2745` | absolute y offset | `y: 974.12` | `top-[1000px]` | [Work/Show.vue:99](resources/js/Pages/Work/Show.vue#L99) | `top-[974px]` — 26px out. `x: -617` is exact, and using logical `start-` for RTL is correct. |

### medium

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| SP-04 | `1083:2745` | dimensions | **1473 × 1563.08** | `width="1476" height="1597"`, `w-[1476px]` | [Work/Show.vue:96-99](resources/js/Pages/Work/Show.vue#L96-L99) | `1473 × 1563`. The height is 34px out, which shifts where the rings fall against the banner. |
| SP-05 | `1361:7124` | Fixed width | `width: 1254` | `.container-sahra` → 1248 | [Work/Show.vue:106](resources/js/Pages/Work/Show.vue#L106) | 6px. See "Design-side questions" — this frame uses 1254 where the rest of the file uses 1248. Do not chase it without a decision. |

### low

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| SP-06 | n/a | stale documentation | `arc-rings-project.svg` **is** imported and rendered | CLAUDE.md "Known remaining gaps" states it is "exported but not yet wired to Single project / mobile" | CLAUDE.md | Half the claim is stale: the *project* ring is wired at [Work/Show.vue:24](resources/js/Pages/Work/Show.vue#L24). `arc-rings-mobile.svg` is genuinely unreferenced anywhere in `resources/js`. Split the claim. |
| ~~SP-07~~ | `1361:7093` | ~~stale code comment~~ | **`gap: 200` — the comment was correct** | — | — | **WITHDRAWN — auditor error.** I flagged the "gap 200 between major blocks (1361:7093)" comment as citing a non-existent node and removed it. `1361:7093` **does** exist and **does** carry `gap: 200`; it simply sits below the depth of my first extraction. The comment has been restored in expanded form. Absence of a node at a given depth is not evidence of its absence — the protocol's `unverified` rule exists precisely for this, and I should have applied it here instead of asserting. |

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| SP-08 | `1361:7100` / `1361:7097` | boxShadow | `0px 4px 10px 0px rgba(0,0,0,0.05)` | `shadow-card` = `4px 4px 12px` | [Work/Show.vue:343](resources/js/Pages/Work/Show.vue#L343) | `shadow-[0_4px_10px_rgba(0,0,0,0.05)]`. This is the **second** distinct shadow in the file (why-us cards use it too, M-02) and neither is `shadow-card`. Worth a `shadow-soft` token. |
| SP-09 | `1361:7100` / `1361:7097` | fixed height | `height: 306` (fill width) | no height constraint | [Work/Show.vue:343](resources/js/Pages/Work/Show.vue#L343) | `h-[306px]`. |

### unverified

| Node | Category | Why |
|---|---|---|
| `1361:7089` children | A–E | Drilled `1361:7102 → 7093 → 7092 → 7091 → 7090 → 7089`, confirming the 200/144 chain, before/after `1361:7094`, results `1349:8209` and deliverables `1294:4968`. Still unread: the innermost sections under `1361:7089` — intro row, banner, challenge, goals, strategy — and the `1294:4920` row. Their geometry in the [Work/Show.vue:6-18](resources/js/Pages/Work/Show.vue#L6-L18) docblock remains the code's claim, not evidence. |
| `1033:2288` children | A–E | "Next case study" wrapper read (`column`, `gap: 32`, width **266**) but not its contents. Code uses `gap-8` (32) ✓ on the wrapper. |
| all nodes | F — motion | `get_motion_context` unavailable. |

### passes

Top inset `pt-[184px]` is **correct here** — which corroborates P-03: 184, not
the 192 that `.section-first` asserts. Header `641:1679` is again the same
`176:199` instance, identical to Home and Projects. `1033:2288`'s `gap: 32` →
`gap-8` is exact. The arc-ring `x: -617` is exact and correctly expressed as a
logical `start-` offset so fa/ar mirror without a second asset.

---

## Shared component: AppHeader — `1419:9339` / component `176:199`

Reported by the user from the running site: *"the Let's talk button should be at
the end of the navbar of homepage but not now."* Confirmed, root-caused, fixed.

### critical

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| HD-01 | `1419:9339` | container max-width | Header is `hug`/`hug` inside a **1440** frame: `96 + logo 140 + gap 262 + objects 846 + 96 = 1440` exactly, so the CTA's right edge lands on the 96px gutter at x=1344 | the inner row had **no frame cap** — `flex items-center px-5 py-6 lg:px-24` stretched to the full viewport | [AppHeader.vue:53-56](resources/js/Layouts/AppHeader.vue#L53-L56) | `mx-auto flex w-full max-w-frame …` |

**Why it looked fine in review and wrong in the browser.** Every measurement in
the header is individually correct — padding 96, gap 262, objects row 846,
`space-between` inside it. They sum to 1440 and match the frame *at exactly
1440px viewport*. Above that the row keeps starting at the viewport's left edge
while its contents stay a fixed 1248 wide, so the surplus collects **after** the
CTA: at 1920 the button stops at x=1344 with 576px of empty header to its right.
This is precisely the class of defect the protocol's Fixed-vs-Fill rule exists
to catch — "a Fill implemented as a hardcoded width is a finding even when the
rendered pixel value matches at the audited breakpoint" — and I did not catch it
from the payload, because at the audited breakpoint every number agreed.

`.container-sahra` already encodes the correct rule
([app.css:106-114](resources/css/app.css#L106-L114)): cap on the **frame**
(1440), not the track, then subtract the gutter as padding. `AppFooter` uses it
([AppFooter.vue:49](resources/js/Layouts/AppFooter.vue#L49)). The header was the
only top-level block in the codebase that did not, which is why it was the only
one that drifted.

Severity **critical** rather than high: it is not a few pixels of offset but the
primary conversion control detaching from the navigation bar on every viewport
wider than 1440, on every page, in every locale.

### the same defect, found by applying the lesson immediately

| # | Node | Property | Figma | Code | File:Line | Fix |
|---|---|---|---|---|---|---|
| HD-02 | `1419:9194` | container max-width | hero text block at **x = 96 inside the 1440 frame** | full-bleed `<section>` with `md:ms-24` measured from the **viewport** edge | [Home.vue:185-192](resources/js/Pages/Home.vue#L185-L192) | wrapped in `mx-auto w-full max-w-frame` |

At 1920 the hero headline sat 96px from the viewport edge while every
`.container-sahra` section below it started at 336px — the hero was **240px
adrift** from the rest of the page, on the most-viewed block of the site. The
background is legitimately full-bleed; the *text block* is not.

Swept the remaining top-level containers for the same shape:

| Component | Cap | Verdict |
|---|---|---|
| `AppFooter` | `.container-sahra` | correct |
| `LeadMagnet`, `ProcessSection`, `ProjectsShowcase`, `CtaBanner`, `ServicesOrbit` | `.container-sahra` | correct |
| `PackagesSection` | `mx-auto w-full max-w-[1248px]` | correct — caps the track and centres, equivalent to a centred 1440 frame with 96 gutters. Uses an arbitrary `1248px` where the `max-w-container` token exists; cosmetic only. |
| `AppHeader` | none | **HD-01, fixed** |
| Home hero | none | **HD-02, fixed** |

### lesson for the remaining frames

Sub-1440 behaviour is `unspecified_in_design`, but **super-1440 behaviour is
not** — the 1440 frame plus the `max-w-frame` token together specify it. When a
block's children are fixed-width and sum exactly to the frame, check that the
block is capped and centred, not just that the numbers add up. I will re-check
every already-audited frame's top-level container against this before moving on.

---

## Design-side questions (do not silently conform the code)

1. **`1419:9230` declares no gap** between the "Why us" eyebrow and the section
   body, while every comparable section on the page uses 48. The code's 32px
   (`mt-8`) matches neither. Confirm the intended value before M-01 is "fixed" —
   conforming to 0 would butt the eyebrow against the heading.
2. **`1419:9232` is 1243px wide inside a 1248px section** (`1419:9230`). A 5px
   inset with no counterpart anywhere else on the page. Almost certainly a
   nudged frame, not a design intent.
3. **`1419:9199` is 731px wide inside a 612px parent** (`1419:9194`), a 119px
   overflow. The code resolved it by widening the whole hero stack to 731
   ([Home.vue:187](resources/js/Pages/Home.vue#L187)), which is a defensible
   reading, but the file is internally inconsistent here.
4. **`1419:9330` and `1419:9332`** — sibling package cards whose fills differ by
   3/255 (`rgba(25,25,25,0.72)` vs `rgba(28,28,28,0.72)`). No variant
   distinguishes them. Treated as a design-side inconsistency, not a code target.
5. **`1419:9334`** — a `row / gap 4` frame at (243, 9183), between FAQ and the
   final CTA. **Resolved:** drilled directly and it has **no children** — an
   empty leftover frame in the design. It correctly has no code counterpart;
   no action, and nothing was dropped from the implementation.

---

## Recurring root causes (running list)

1. **Auto-layout `space-between` and `gap` implemented as per-child margins.**
   H-01, M-05, and the `mt-8`/`mt-14` pattern throughout Home. The Figma frames
   distribute; the code pins. This diverges the moment content length changes.
2. **`grid-cols-2` substituted for asymmetric fixed/fill column pairs.** H-04
   (506+fill), H-08 (497+fill). Insights got this right with
   `lg:grid-cols-[505px_1fr]` — that is the pattern the other two should follow.
3. **`text-display-sm` (36/500) used where the file specifies 40/600.** H-02,
   H-11. The correct token `text-display-md` already exists and is used
   correctly in Insights, so this is a substitution slip, not a missing token.
