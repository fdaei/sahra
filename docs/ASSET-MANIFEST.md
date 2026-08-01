# Asset Manifest

Every asset the design requires, with its Figma node ID, target path, and export settings.

> **Why this is a manifest and not a folder of files.**
> The build environment used to author this codebase has no outbound network access, so it
> could not download binaries from Figma's CDN. Every asset below is listed with the exact
> node ID and export settings needed to pull it yourself. The code references the **final
> local paths**, so once you run the export step the app is wired up correctly — there are
> no temporary Figma URLs anywhere in the source.

---

## 0. Bulk export (do this first)

Figma MCP asset URLs expire ~7 days after generation, so export from the Figma UI rather
than from stale links.

### Option A — Figma UI (recommended)

1. Open the file, switch to page **`User interface`**.
2. Select the node listed in each row below (`Cmd/Ctrl + P` → paste node ID, or use the
   layers panel).
3. In the right sidebar → **Export**, set the format/scale from the table.
4. Export into the **Target path** given.

### Option B — Figma REST API

```bash
export FIGMA_TOKEN="figd_your_personal_access_token"
export FILE_KEY="HuuGewZFHRm2ekVUFPDQhR"

# Returns a JSON map of nodeId -> temporary download URL
curl -H "X-Figma-Token: $FIGMA_TOKEN" \
  "https://api.figma.com/v1/images/$FILE_KEY?ids=1419:9193,1419:9229&format=png&scale=2"
```

A ready-made script that walks this entire manifest is at `scripts/export-figma-assets.sh`.

---

## 1. Branding

| Node ID | Asset | Format | Target path | Notes |
|---|---|---|---|---|
| `158:156` | Sahra logo + logotype | **SVG** | `resources/images/branding/logo-full.svg` | 13-path vector. Do **not** rasterise. Used in header + footer. |
| `158:157` | Logo mark only | **SVG** | `resources/images/branding/logo-mark.svg` | The gold swoosh. Favicon source. |
| `158:168` | Logotype only ("SAHRA / See the HORIZON") | **SVG** | `resources/images/branding/logotype.svg` | |

Derived files to generate locally from `logo-mark.svg`:
`public/favicon.ico` (32×32), `public/apple-touch-icon.png` (180×180),
`public/icon-192.png`, `public/icon-512.png`.

## 2. Home page

| Node ID | Asset | Format | Scale | Target path | Alt text (en) |
|---|---|---|---|---|---|
| `1419:9193` | Hero background — gold dunes & horizon line | **WebP** + PNG fallback | 2× (2880×1808) | `storage/app/public/pages/home-hero.webp` | Golden desert dunes meeting the horizon at sunrise |
| `1419:9229` | Home projects showcase image | **WebP** | 2× (1060×1326) | `storage/app/public/pages/home-projects.webp` | Featured Sahra brand campaign artwork |

## 3. Client logos (trust proof strip)

All six are vector. Export as **SVG**.

| Node ID | Client | Target path |
|---|---|---|
| `1419:9209` | Pars clinic | `resources/images/clients/pars.svg` |
| `1419:9210` | allDigitall.ir | `resources/images/clients/all-digitall.svg` |
| `1419:9211` | Baghche | `resources/images/clients/baghche.svg` |
| `1419:9212` | Noora | `resources/images/clients/noora.svg` |
| `1419:9213` | Vanak | `resources/images/clients/vanak.svg` |
| `1419:9214` | Tavakoli | `resources/images/clients/tavakoli.svg` |

## 4. Projects

Square 1:1 crops, **WebP**, 2× (896×896).

| Node ID | Project | Target path | Alt text (en) |
|---|---|---|---|
| `1362:7211` → child `img` | Baghche | `storage/app/public/projects/baghche.webp` | Baghche healthy-food brand identity |
| `1362:7212` → child `img` | Kerman Motors | `storage/app/public/projects/kerman-motors.webp` | Kerman Motors factory-price sale campaign |
| `1362:7213` → child `img` | Fakhar Clinic | `storage/app/public/projects/fakhar-clinic.webp` | Fakhar medical and dental clinic campaign |
| `1362:7214` → child `img` | Plus Protein | `storage/app/public/projects/plus-protein.webp` | Plus Protein brand mark |
| `1362:7215` → child `img` | Karsa Tourism | `storage/app/public/projects/karsa-tourism.webp` | Karsa travel services campaign |
| `1362:7216` → child `img` | Cheshmeh | `storage/app/public/projects/cheshmeh.webp` | Cheshmeh beauty clinic identity |
| `1323:7605` | Cheshmeh case-study banner | `storage/app/public/projects/cheshmeh-banner.webp` | Cheshmeh Beauty Clinic brand banner (16:9, 2406×1248) |

## 5. Services

Portrait 604×786 → **WebP**, 2× (1208×1572).

| Node ID | Service | Target path | Alt text (en) |
|---|---|---|---|
| `1323:7224` → `img` | Branding | `storage/app/public/services/branding.webp` | Framed poster reading "Where identity becomes direction" |
| `1323:7226` → `img` | Content Production | `storage/app/public/services/content-production.webp` | Warm desk setup with laptop, notebook and coffee |
| `1323:7225` → `img` | Marketing Design | `storage/app/public/services/marketing-design.webp` | Large "MARKETING" wall type behind a seated person |
| `1323:7227` → `img` | Social Media Support | `storage/app/public/services/social-media-support.webp` | Hand holding a phone showing analytics |

## 6. About

| Node ID | Asset | Format | Target path | Alt text (en) |
|---|---|---|---|---|
| `951:3598` | Gold sand-arch sculpture | **WebP**, transparent | `storage/app/public/pages/about-hero.webp` | Glass arch sculpture holding golden sand dunes and a sun disc |

### Team portraits — square 1:1, **WebP**, 2× (588×588), greyscale as in design

| Node ID | Member | Role | Target path |
|---|---|---|---|
| `992:2644` → `razieh default` | Amin | CEO | `storage/app/public/team/amin.webp` |
| `992:2649` → `malika default` | Melika | Brand Strategist | `storage/app/public/team/melika.webp` |
| `992:2654` → `banin default` | Banin | Graphic Designer | `storage/app/public/team/banin-1.webp` |
| `1264:3590` → `banin default` | Banin | Graphic Designer | `storage/app/public/team/banin-2.webp` |
| `992:2660` → `mohammad default` | Mohammad | Graphic Designer | `storage/app/public/team/mohammad.webp` |
| `992:2694` → `iman default` | Iman | Videographer | `storage/app/public/team/iman.webp` |
| `992:2697` → `img` | Razieh | Brand Strategist | `storage/app/public/team/razieh.webp` |
| `992:2695` → `amir default` | Amir | Video Creator | `storage/app/public/team/amir.webp` |
| `992:2696` → `afshin default` | Afshin | Brand Strategist | `storage/app/public/team/afshin-1.webp` |
| `1288:4189` → `afshin default` | Afshin | Brand Strategist | `storage/app/public/team/afshin-2.webp` |

## 7. Testimonials

| Node ID | Asset | Target path |
|---|---|---|
| `1419:9251` → `Ellipse 39` | Sara Amiri avatar (48×48) | `storage/app/public/testimonials/sara-amiri.webp` |

## 8. Decorative vectors

Export as **SVG**, they are pure line art and scale to full-bleed backgrounds.

| Node ID | Asset | Target path | Used on |
|---|---|---|---|
| `951:3589` | Concentric arc rings | `resources/images/decor/arc-rings.svg` | About hero backdrop |
| `979:1394` | Topographic dune contour lines | `resources/images/decor/dune-contours.svg` | About team backdrop |
| `1323:7542` | Arc rings (project variant) | `resources/images/decor/arc-rings-project.svg` | Single project |
| `1323:7190` | Arc rings (service variant, left) | `resources/images/decor/arc-rings-service-l.svg` | Services |
| `1323:7199` | Arc rings (service variant, right) | `resources/images/decor/arc-rings-service-r.svg` | Services |
| `1557:12926` | Arc rings (mobile) | `resources/images/decor/arc-rings-mobile.svg` | mobile About |
| `1419:9289`–`1419:9301` | Services orbit rings + nodes | `resources/images/decor/service-orbit.svg` | Home services |

## 9. Icons

| Node ID | Icon | Target path |
|---|---|---|
| `1014:1700` | Industry / building | `resources/images/icons/industry.svg` |
| `1530:10879` | Hamburger menu | `resources/images/icons/menu.svg` |
| `88:17` | Search | `resources/images/icons/search.svg` |

Remaining UI icons (phone, pin, mail, users, calendar, chevron, arrow, external-link,
Instagram, LinkedIn, WhatsApp, X, YouTube) are **not bespoke** in the file — they are
standard Lucide glyphs. They are provided by the `lucide-vue-next` package already in
`package.json`; do not export these from Figma.

---

## 10. Fonts — ACTION REQUIRED

| Family | Locales | Source | Status |
|---|---|---|---|
| **Poppins** | `en` | Google Fonts (OFL) | Self-hosted; download script provided |
| **Doran FaNum** | `fa`, `ar` | Commercial licence | **Supplied** — `public/fonts/doran/*.ttf` |
| **Idealist** | all | Commercial licence | **Supplied** — `public/fonts/idealist/Idealist-Models.ttf` |

> **Idealist was missed by the original audit.** The file sets it on every
> section eyebrow (`small title`, 24/400 gold) and on the package price lines —
> 56 text nodes in total, across every page. It is a third family, distinct from
> both Poppins and Doran. It is now declared in `resources/css/fonts.css` and
> applied through the `.eyebrow` component class in `resources/css/app.css`.

`Doran FaNum` is not freely distributable and could not be fetched by the build
environment. Until the licensed files are placed, FA/AR locales fall back to
`Vazirmatn` (OFL, near-identical metrics) via the CSS fallback chain already configured
in `resources/css/fonts.css`.

Place licensed files here:

```
public/fonts/doran/DoranFaNum-Regular.woff2
public/fonts/doran/DoranFaNum-Medium.woff2
public/fonts/doran/DoranFaNum-Bold.woff2
```

The `@font-face` declarations are already written and reference exactly these paths.
Fetch the free fonts with:

```bash
./scripts/fetch-fonts.sh
```

---

## 10b. Exported via the REST API

These were pulled straight from the file with the `/v1/images` endpoint and are
committed. Re-run the same call with the node ID to refresh any of them.

| Node ID | Asset | Format | Target path |
|---|---|---|---|
| `1061:2133` | Goal-card trend icon (gold, 2px stroke) | SVG | `public/icons/sahra/goal.svg` |
| `951:3598` | About hero arch-sculpture cutout | PNG 2× | `public/images/sahra/about-hero-sculpture.png` |
| `1027:2062` | 404 horizon artwork | PNG 2× | `public/images/sahra/404-horizon.png` |
| `453:878` (fill) | Contact card background | PNG | `public/images/sahra/contact-bg.png` |

The Contact background is an *image fill*, not a renderable node — resolve it
through `/v1/files/$FILE_KEY/images` using the fill's `imageRef` rather than
`/v1/images`.

---

## 11. Export-completeness checklist

- [ ] Branding SVGs (3) + derived favicons
- [ ] Home hero + projects image (2)
- [ ] Client logos (6 SVG)
- [ ] Project images (7)
- [ ] Service images (4)
- [ ] About hero (1)
- [ ] Team portraits (10)
- [ ] Testimonial avatar (1)
- [ ] Decorative SVGs (7)
- [ ] Bespoke icons (3)
- [ ] Poppins woff2 (script)
- [ ] Doran FaNum woff2 (licensed — client-supplied)

Run `php artisan sahra:verify-assets` after exporting; it walks this manifest and reports
anything missing.
