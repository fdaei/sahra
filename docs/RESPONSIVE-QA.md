# Responsive QA

The Figma file provides only two frame sizes per page: desktop (1440px) and
mobile (402px, iPhone 16/17 Pro). No tablet frames exist (audit gap G1).
Tablet behaviour below is **derived** from the desktop layout system — the
same grid, spacing tokens, and type scale, collapsed at the column count that
keeps content readable — not an invented visual identity.

Test at: 320, 360, 375, 390, 414, 480, 768, 820, 1024, 1280, 1366, 1440,
1600, 1920px. Automated checks run at 360/390/414/768/1024/1440/1920 via
`playwright.config.ts`; the remaining widths are manual-QA only (listed below).

---

## Global rules (every breakpoint)

- No horizontal scroll — enforced by `overflow-x: hidden` never being needed
  because every container respects `max-width: 100%` and images/SVGs are
  `block; max-width: 100%; height: auto` (`resources/css/app.css`).
- Header is `fixed`; `<main>` carries `pt-24 lg:pt-26` to prevent the first
  section rendering underneath it.
- Touch targets ≥44×44px (`.touch-target` utility) — applied to the hamburger
  and mobile close button.
- `100dvh` (`.min-h-screen-safe`) instead of `100vh` so mobile browser chrome
  never clips content.
- `env(safe-area-inset-*)` padding on the mobile menu and toast for notch/
  home-indicator devices.
- RTL and LTR share one stylesheet via logical properties
  (`tailwindcss-logical`) — verified per page in the RTL section below.

---

## Per-page breakdown

### Home (`1419:9192` / `1419:9191`)

| Element | Mobile (≤640) | **Tablet (768–1023, derived)** | Desktop (≥1024) |
|---|---|---|---|
| Hero | Single column, CTAs side-by-side (trimmed padding/font so both labels fit one row) | Single column, CTAs side-by-side | Two-column-feel via centered content over full-bleed image |
| KPI strip | 1 column stacked | 3 columns (fits at 768 — each stat ~220px) | 3 columns |
| Services cloud | Chips wrap, orbit rings hidden (decorative, no info loss) | Chips wrap in 2 rows, orbit shown at reduced scale | Full orbit + chips |
| Projects showcase | Rows stack above image | **Derived:** rows stack above image (2-col grid would compress each row's text below comfortable measure — same decision as mobile) | Two columns: rows beside image |
| Process | Horizontal scroll-snap of 6 cards | Horizontal scroll-snap, 3 visible at once | All 6 in a row |
| Why-us | 1 column | 2 columns | 4 columns |
| Reviews marquee | Full-width card peeking next card | Marquee, 2 cards visible | Marquee, 3 cards visible |
| Insights | 1 large + 2 stacked | 1 large + 2 side-by-side below | 1 large + 2 side-by-side |
| FAQ | Full-width accordion | Full-width accordion, wider max-width | Max-width 800px, centered |

### Work listing (`1362:7198` / `1498:10840`)

- Mobile: single-column card grid, filter chips horizontally scrollable.
- **Tablet (derived):** 2-column card grid — the card's fixed 1:1 cover image
  stays legible at ~340px, matching the spacing token grid (`gap-6`).
- Desktop: 2-column grid per the Figma frame (frame shows exactly 2 columns
  at 1440, not 3 — preserved rather than "improved" to 3).

### Single project (`1323:7541` / `1555:10866`)

- Mobile: every grid (`goals`, `strategy`, `deliverables`, `results`)
  collapses to 1 column; results row becomes 2-column to keep numbers legible.
- **Tablet (derived):** goals/deliverables → 2 columns, strategy stays 2
  columns (matches desktop — Figma's strategy grid is already 2-up),
  results → 3 columns.
- Desktop: goals/deliverables 4 and 3 columns respectively, results 5 columns,
  per the frame.

### Services (`1323:7189` / `1626:12562`)

- Mobile: each service section stacks image below text, full width.
- **Tablet (derived):** same stacked order as mobile up to 900px (image would
  otherwise shrink below a legible detail size in the alternating layout);
  switches to the desktop side-by-side layout from 900px, which we treat as
  effectively "desktop" for this one page.
- Desktop: alternating left/right image-text rows, per the frame.

### About (`908:1576` / `1557:12225`)

- Mobile: team grid 2 columns (matches the mobile frame exactly).
- **Tablet (derived):** team grid 3 columns.
- Desktop: team grid 5 columns, per the frame.

### Blog listing / single blog (`1353:7935`, `1352:7391`)

- Mobile: 1-column card grid; article body full width, share rail moves above
  the content (was a sticky side rail on desktop).
- **Tablet (derived):** 2-column card grid; article keeps a sticky side share
  rail once the viewport is wide enough (≥900px) for it not to crowd the copy.
- Desktop: 3-column card grid, per the frame.

### Contact (`1363:8934` / `1494:9544`)

- Mobile: form stacks above the contact-details card.
- **Tablet (derived):** same stacked order as mobile (the design's two-column
  split needs more like 1000px+ to avoid squeezing the form fields).
- Desktop: two-column split — form left, details card right — per the frame.

---

## RTL / LTR verification (per breakpoint)

Checked at 390, 768, and 1440 for `fa` and `ar`:

- Mobile menu slides from the correct inline-end edge (left in RTL).
- Header nav item order does not mirror (reading order changes, list order
  does not — matches how the Figma AR/FA frames are structured).
- Icons that imply direction (arrows, the "→" in CTA buttons) flip via
  `rtl:-scale-x-100`; icons that don't imply direction (chevrons in
  accordions, social icons) do not.
- Numerals: KPI values and dates that Figma shows in Latin digits even inside
  RTL text (`+70k`, `2024`) use the `.latin-nums` utility to force LTR
  embedding, matching the design rather than rendering Eastern Arabic digits.
- Marquees (clients, testimonials) travel the mirrored direction
  (`directionFactor()` in `lib/motion.ts`).

---

## Manual QA checklist (run per release)

Use actual devices/emulators at each width; automated Playwright coverage is
noted where it exists.

- [ ] 320px — iPhone SE. No clipped text in the hero eyebrow badge. *(manual)*
- [ ] 360px — no horizontal scroll on any of the 6 core pages. *(automated)*
- [ ] 375px — mobile menu opens/closes, focus trapped, Esc closes. *(manual)*
- [ ] 390px — language switcher round-trips to the correct translated page. *(automated)*
- [ ] 414px — form fields on Contact are all reachable without zoom. *(manual)*
- [ ] 480px — KPI strip readable without truncation. *(manual)*
- [ ] 768px — tablet team grid (3 cols) has even row heights. *(manual)*
- [ ] 820px — Services page alternating layout switch point looks intentional. *(manual)*
- [ ] 1024px — Single project results grid (3 cols at tablet) no overflow. *(automated)*
- [ ] 1280px — header CTA button doesn't collide with nav on narrow desktop. *(manual)*
- [ ] 1366px — common laptop width; no unexpected wrap in the footer columns. *(manual)*
- [ ] 1440px — pixel-compare hero against the Figma frame. *(automated, overflow only)*
- [ ] 1600px — container stays capped at `max-w-container`, doesn't stretch full-bleed. *(manual)*
- [ ] 1920px — same as 1600, plus watermark text in footer doesn't look sparse. *(automated, overflow only)*
- [ ] `prefers-reduced-motion: reduce` — marquees frozen, sections visible without waiting on scroll. *(automated)*
- [ ] Keyboard-only pass: Tab through header → mobile menu → contact form → footer with no trap and visible focus rings throughout. *(manual)*
