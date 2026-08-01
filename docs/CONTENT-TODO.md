# Content TODO — real assets and copy still needed

Gaps that are **content**, not code. Every item below renders correctly and is wired
end-to-end; it is showing placeholder or duplicated material that a human needs to
replace. Nothing here blocks development.

---

## 1. Duplicate team portraits (About page)

The Figma team frame (`1288:4194`) reuses the same photograph across several member
cards. Confirmed with the client as **placeholder practice, not intent** — the design
simply had not sourced ten distinct portraits.

The implementation reproduces the frame faithfully, so the duplication is visible on
the live About page. Replace the files below with real photographs; no code change is
needed, the slots are already wired.

| Slot | Stored path | Currently shows | Needs |
|---|---|---|---|
| Amin — CEO | `storage/app/public/team/amin.webp` | woman with cup, patterned headscarf | real portrait |
| Razieh — Brand Strategist | `storage/app/public/team/razieh.webp` | **same photo as Amin** | real portrait |
| Banin — Graphic Designer | `storage/app/public/team/banin-1.webp` | woman, black scarf / white top | real portrait |
| Banin — Graphic Designer | `storage/app/public/team/banin-2.webp` | **same photo as banin-1** | real portrait |
| Afshin — Brand Strategist | `storage/app/public/team/afshin-1.webp` | man in suit, glasses | real portrait |
| Afshin — Brand Strategist | `storage/app/public/team/afshin-2.webp` | **same photo as afshin-1** | real portrait |

Distinct and fine as-is: `melika`, `mohammad`, `iman`, `amir`.

**Where they are wired**

- Seed data: [database/seeders/ContentSeeder.php](../database/seeders/ContentSeeder.php) — the team array, `photo_path` column.
- Transformer: `ContentTransformer::teamMember()` → `MediaTransformer` context `team` (294×294, emitted at 588×588 for retina).
- Component: [resources/js/Pages/About.vue](../resources/js/Pages/About.vue), the member-card `<figure>` grid.
- Admin: editable per member through the Team Members Filament resource — dropping a
  new upload there replaces the file without touching the seeder.

**Format when replacing:** square, 588×588 WebP (≈294 CSS px @2x). Colour is fine —
the grid applies `grayscale` in CSS to match the frame, so no pre-processing needed.

Two members also share a first name (`Banin`, `Afshin`) with identical roles. Confirm
whether these are genuinely two different people or a duplicated row in the seed.

---

## 2. Arabic copy review

The `ar` numerals were seeded with Latin digits throughout and have been converted to
Arabic-Indic (`٠١٢٣٤٥٦٧٨٩`) to match how `fa` was authored — see
`App\Support\Numerals` and `config/locales.php`. The **digits** are now correct, but
the surrounding Arabic wording was machine-drafted and is still flagged in
`docs/IMPLEMENTATION-LOG.md` as pending native review. Worth a native pass over:

- KPI card values and labels (`PageSeeder::home`)
- Package prices and tiers (`PageSeeder::services`)
- Project result stats (`ProjectSeeder`)
- The About hero, now split into two runs (`title` + `content`) so the gold display
  line and the dark line can be phrased independently per locale.
