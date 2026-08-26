<script setup lang="ts">
import { computed, ref } from 'vue'
import orbitRing from '~img/decor/service-orbit-outer.svg'
import { useVennBurst } from '@/Composables/useMotion'
import { useTranslations } from '@/Composables/useTranslations'
import type { ServiceItem } from '@/types'

const { t } = useTranslations()

interface ServiceSection {
  eyebrow: string
  title: string
  description: string
}

const props = defineProps<{
  section: ServiceSection
  services: ServiceItem[]
}>()

/*
 | Matched on `key` (the fallback-locale slug), never on `title`. The title is
 | translated, so an English needle matched nothing under fa/ar: every pill fell
 | back to its lang-file label and — worse — lost `image`, which is why the
 | hover preview only ever appeared on the English page.
 */
const serviceFor = (services: ServiceItem[], needle: string): ServiceItem | undefined =>
  services.find((service) => service.key.toLowerCase().includes(needle))

const serviceLabel = (services: ServiceItem[], needle: string, fallback: string) =>
  serviceFor(services, needle)?.title ?? fallback

/*
 | The four pills, grouped by which circle of the Venn they sit inside:
 | Branding + Social build the BRAND circle, Marketing Design + Content
 | Production fill the PRODUCT circle. That grouping is this component's own
 | (there is no CMS field for it) — it is what lets four real services stand
 | inside a two-circle diagram without inventing a fifth taxonomy.
 |
 | The label is authored content; the third tuple member is the translation
 | key used when no service row matches the needle for the active locale. It
 | must stay a key rather than a literal — a hardcoded English fallback would
 | put Latin text inside the fa/ar orbit.
 */
const pills = computed(() =>
  (
    [
      ['branding', 'brand', 'services.pill_branding'],
      ['social', 'social', 'services.pill_social'],
      ['design', 'design', 'services.pill_design'],
      ['content', 'content', 'services.pill_content'],
    ] as const
  ).map(([modifier, needle, fallbackKey]) => ({
    modifier,
    label: serviceLabel(props.services, needle, t(fallbackKey)),
    image: serviceFor(props.services, needle)?.image ?? null,
  })),
)

/*
 | Decorative-only tags either side of the Venn, gesturing at the breadth of
 | a full-service agency beyond the four pills the CMS actually backs. Never
 | linked, never hoverable, aria-hidden — see the `ghost_*` keys in
 | lang/{locale}/services.php for what belongs here vs. the CMS.
 */
const ghostBrand = computed(() => [
  t('services.ghost_copywriting'),
  t('services.ghost_market_research'),
  t('services.ghost_pr_media'),
])
const ghostProduct = computed(() => [
  t('services.ghost_seo'),
  t('services.ghost_email_marketing'),
  t('services.ghost_analytics'),
])

/*
 | The Brand/Product circles rest fully overlapped and burst apart — once,
 | the first time the diagram scrolls into view — to their resting CSS
 | position, while the rings/labels/tags fade in around them. Desktop
 | separates them horizontally; the mobile layout stacks the same two circles
 | vertically instead (see the media query below), so it bursts on the other
 | axis. Both calls target the same stage; gsap.matchMedia only ever builds
 | the timeline whose query currently matches, so exactly one of the two is
 | live at a time.
 */
const stage = ref<HTMLElement | null>(null)

useVennBurst(stage, { axis: 'x', media: '(min-width: 1024px)' })
// Mobile circles rest at top:0/top:190 (see the media query below) — 95px
// each way from the midpoint lands them exactly coincident at the burst's start.
useVennBurst(stage, { distance: 95, axis: 'y', media: '(max-width: 1023px)' })
</script>

<template>
  <section class="services-orbit overflow-hidden bg-black text-white">
    <!--
      Mobile 1731:12370 is `padding: 48px 0` with a 48px gap to the diagram
      (the copy column carries the 20px gutter itself, which `.container-sahra`
      already supplies). Desktop 1419:9279 is padding 96 / gap 72.
    -->
    <div class="container-sahra relative z-10 py-12 md:py-20 lg:py-24">
      <!--
        Copy column 1451:10383 (mobile) / 1419:9281 (desktop). The two frames
        use different rhythm: mobile stacks eyebrow → title → subtitle at gap
        24 with a 16 gap inside the title block, desktop opens both out to 48
        and puts title and subtitle side by side at gap 130.
      -->
      <div class="flex flex-col gap-6 lg:gap-12">
        <div class="service-eyebrow">
          <span aria-hidden="true" />
          {{ section.eyebrow || t('services.eyebrow') }}
        </div>

        <div class="grid gap-4 lg:grid-cols-[506px_1fr] lg:gap-[130px]">
          <h2 class="max-w-[506px] text-[28px] font-semibold leading-normal text-white md:text-[36px] lg:text-[40px] lg:leading-[1.5]">
            {{ section.title }}
          </h2>
          <p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-200 md:text-[18px]">
            {{ section.description }}
          </p>
        </div>
      </div>

      <!--
        role="group" so the label is exposed — aria-label on a bare div is
        ignored by AT. Not role="img": the pills inside carry real service
        names and must stay in the accessibility tree.

        This diagram has no Figma source. The file's axis (Marketing -> Growth,
        1419:9279) was replaced with a bespoke Brand/Product Venn per explicit
        design direction, so there is no node ID to cite anywhere below.
      -->
      <div ref="stage" class="orbit-stage mt-12 lg:mt-[72px]" role="group" :aria-label="t('services.orbit_label')">
        <div class="orbit-glow" aria-hidden="true" />

        <!--
          Two dashed rings, burst open (fade + scale) around the circle pair
          once the diagram enters view. Each lives in its own positioning
          wrapper and only THAT wrapper ever carries the centring transform —
          useVennBurst animates the inner span's scale/opacity, and GSAP's
          transform proxy would otherwise clobber a translate(-50%,-50%) set
          on the very element it animates. Same trap the ring image below is
          built around.
        -->
        <div class="orbit-ring-wrap orbit-ring-wrap--inner" aria-hidden="true">
          <span class="orbit-ring" data-venn-ring />
        </div>
        <div class="orbit-ring-wrap orbit-ring-wrap--outer" aria-hidden="true">
          <span class="orbit-ring" data-venn-ring />
        </div>

        <!--
          Same ring asset (`service-orbit-outer.svg`, the dashed-gold stroke
          used everywhere on this page) used twice and overlapped, rather than
          two bespoke exports — desktop places the pair side by side, mobile
          stacks them, entirely via the media query below, so there is only
          ever one pair of DOM nodes.

          Each ring lives in its own positioning wrapper and only THAT wrapper
          ever carries a static transform. useVennBurst writes x/y onto the
          <img> during the burst and folds any author transform into its own
          matrix — a centring transform on the animated element itself would
          be re-applied every frame and drag the ring off its resting spot,
          the same trap the dashed rings above are built around.
        -->
        <div class="venn-circle venn-circle--brand" aria-hidden="true">
          <img data-venn-circle="brand" :src="orbitRing" alt="" />
        </div>
        <div class="venn-circle venn-circle--product" aria-hidden="true">
          <img data-venn-circle="product" :src="orbitRing" alt="" />
        </div>

        <strong class="orbit-anchor venn-label venn-label--brand" data-venn-label>{{ t('services.venn_brand') }}</strong>
        <strong class="orbit-anchor venn-label venn-label--product" data-venn-label>{{ t('services.venn_product') }}</strong>

        <span class="orbit-anchor orbit-anchor--core" data-venn-label>
          <span class="orbit-core">{{ t('services.core') }}</span>
        </span>

        <!--
          Decorative-only tags gesturing at the wider breadth of the agency —
          desktop only (mobile hides `.ghost-col`, the same pruning
          `.service-pill__preview` already gets below). Never linked, never
          hoverable: aria-hidden, and their text lives in ghostBrand/
          ghostProduct rather than the accessibility tree.
        -->
        <div class="ghost-col ghost-col--brand" aria-hidden="true">
          <span v-for="label in ghostBrand" :key="label" class="ghost-tag" data-venn-tag>{{ label }}</span>
        </div>
        <div class="ghost-col ghost-col--product" aria-hidden="true">
          <span v-for="label in ghostProduct" :key="label" class="ghost-tag" data-venn-tag>{{ label }}</span>
        </div>

        <!--
          Service card 1419:9295-9298. Each carries an ON_HOVER interaction
          that CHANGE_TOs variant 501:722 with SMART_ANIMATE / EASE_OUT /
          0.3s. That variant is the same pill with a 216x116 radius-8 panel
          revealed beneath it (overlapping by 8px — the component stacks at
          gap -8). The panel is blank in the file, so it shows the service's
          own image where the CMS has one.

          The wrapper is `display: contents` on desktop, so each pill stays a
          direct layout child of the stage and keeps its own absolute frame
          coordinate. Below lg it becomes a real centred flex column, which is
          the only way to stack pills whose heights vary by locale — absolute
          `top`s per pill would drift the moment an fa/ar label wrapped to two
          lines.
        -->
        <div class="orbit-pills">
          <div
            v-for="pill in pills"
            :key="pill.modifier"
            class="orbit-anchor service-pill"
            :class="`service-pill--${pill.modifier}`"
            data-venn-tag
          >
            <span class="service-pill__label">
              <span class="service-pill__dot" aria-hidden="true" />
              {{ pill.label }}
            </span>

            <span v-if="pill.image" class="service-pill__preview" aria-hidden="true">
              <img :src="pill.image.src" :alt="''" loading="lazy" decoding="async" />
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.services-orbit {
  position: relative;
  min-height: 978px;
}

/*
 | Same "small title" component set as `.eyebrow` in app.css, and it follows
 | the same 16 -> 24 step: the mobile variant is `Property 1=ltr mobile`
 | (1451:10356) at 16px, the desktop one 1005:1574 at 24. It was pinned at 24
 | here, which made the mobile eyebrow a full step larger than every other
 | eyebrow on the page.
 */
.service-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  width: fit-content;
  color: var(--color-gold);
  font-family: var(--font-display);
  font-size: 16px;
  line-height: 1;
}

@media (min-width: 768px) {
  .service-eyebrow {
    font-size: 24px;
  }
}

.service-eyebrow span {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: var(--color-gold);
  box-shadow: -2px -2px 12px rgb(var(--color-gold-rgb) / 50%), 2px 2px 12px rgb(var(--color-gold-rgb) / 50%);
}

.orbit-stage {
  position: relative;
  width: 1101px;
  height: 520px;
  margin-inline: auto;
}

.orbit-glow {
  position: absolute;
  z-index: -1;
  left: 50%;
  bottom: -264px;
  width: 1068px;
  height: 330px;
  transform: translateX(-50%);
  border-radius: 50%;
  /* Ellipse 1419:9280 — gold at 40%, blur 200. */
  background: rgb(var(--color-gold-rgb) / 40%);
  filter: blur(200px);
}

/*
 | Everything inside the stage is placed with logical insets, not left/right,
 | so the whole Venn mirrors under fa/ar and Brand/Product swap sides with the
 | rest of the page rather than staying pinned to the LTR layout.
 */

/* The pills are absolutely placed on desktop — the wrapper must not box them. */
.orbit-pills {
  display: contents;
}

/*
 | Both rings are centred on the stage's own centre (x=550.5, y=260 — same
 | point `.orbit-anchor--core` anchors on below). translate(-50%,-50%) lives
 | on the wrapper, never on `.orbit-ring` itself, for the same reason the ring
 | image below keeps its centring transform off the animated element: GSAP
 | writes a full transform matrix for scale/opacity and would silently drop
 | a translate() set via CSS on that same node.
 */
.orbit-ring-wrap {
  position: absolute;
  z-index: 0;
  inset-inline-start: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
}

.orbit-ring-wrap--inner { width: 300px; height: 300px; }
.orbit-ring-wrap--outer { width: 500px; height: 500px; }

.orbit-ring {
  display: block;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 1px dashed rgb(255 255 255 / 22%);
}

/*
 | Two 480px circles overlapped by 160px at rest, centred as a pair on the
 | stage's own centre (x=550.5) — 390 and 710 either side of it. The wrapper
 | carries all static positioning; the <img> inside is left transform-free
 | because useVennBurst writes x/y onto it during the burst (see the note in
 | the markup above).
 */
.venn-circle {
  position: absolute;
  top: 20px;
  width: 480px;
  height: 480px;
}

.venn-circle > img {
  display: block;
  width: 100%;
  height: 100%;
}

.venn-circle--brand { inset-inline-start: 150px; }
.venn-circle--product { inset-inline-start: 470px; }

/*
 | Brand/Product labels sit inside each circle's own (non-overlapping) half,
 | vertically centred on the stage. `.orbit-anchor` gives them the same
 | zero-width, flex-centred anchor the pills and core chip use, so a longer
 | fa/ar label grows outward from its exact centre point instead of from a
 | fixed-width box's leading edge.
 */
.venn-label {
  top: 250px;
  white-space: nowrap;
  font-size: 24px;
  font-weight: 600;
  line-height: 36px;
  color: var(--color-paper);
}

.venn-label--brand { inset-inline-start: 310px; }
.venn-label--product { inset-inline-start: 790px; }

/*
 | A zero-width point that its content overflows equally on both sides, so the
 | label is *centred* on the coordinate rather than starting at it. Anchoring
 | by the leading edge is fine for English but lets a longer fa/ar label grow
 | outwards until it crosses the circle's stroke. Centring is also
 | direction-agnostic — no translateX to flip under RTL.
 */
.orbit-anchor {
  position: absolute;
  z-index: 2;
  display: flex;
  width: 0;
  justify-content: center;
}

/*
 | Service pill — Figma `Service card` 1144:2992, inner frame:
 |   row · padding 8/16 · justify-content CENTER · radius 1000
 |   fill rgba(108, 106, 106, 0.6)
 |
 | Two corrections against the file:
 |
 |  1. `justify-content: center`. This was a `display: block`, so the label sat
 |     on the leading edge of the pill instead of its middle. It reads as
 |     centred in English only because the pill hugs a single line of text —
 |     the moment a longer fa/ar label wraps, or the pill is given a width, the
 |     copy sticks to the start. Centring is what the file specifies and it is
 |     direction-agnostic, so it holds for all four pills in all three locales.
 |  2. The fill is one flat translucent grey, not a white-over-ink stack. The
 |     stacked version resolved a little lighter and cooler than the frame.
 */
.service-pill__label {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  text-align: center;
  white-space: nowrap;
  padding: 8px 16px;
  border-radius: 1000px;
  background: rgba(108, 106, 106, 0.6);
  font-size: 18px;
  font-weight: 500;
  line-height: 27px;
  color: var(--color-paper);
}

/* One accent per pill, drawn from the existing gold/neutral token set rather
   than inventing a new palette — same four tokens the rest of the page uses. */
.service-pill__dot {
  width: 8px;
  height: 8px;
  flex-shrink: 0;
  border-radius: 999px;
}

.service-pill--social .service-pill__dot { background: var(--color-gold); }
.service-pill--branding .service-pill__dot { background: var(--color-gold-500); }
.service-pill--design .service-pill__dot { background: var(--color-paper); }
.service-pill--content .service-pill__dot { background: var(--color-neutral-200); }

/*
 | Hover variant 501:722 — a 216x116 radius-8 panel under the pill, pulled up
 | 8px because the component stacks at gap -8. Transition matches the stored
 | prototype timing (SMART_ANIMATE, EASE_OUT, 0.3s).
 */
.service-pill__preview {
  position: absolute;
  top: 100%;
  z-index: -1;
  /* Deliberately physical: `left: 50%` + `translateX(-50%)` is one centring
     operation on a zero-width anchor and lands identically under either
     direction. The logical `inset-inline-start: 50%` this replaces resolved to
     `right` under RTL while the transform kept pulling left, throwing the
     panel a full half-width off the pill. */
  left: 50%;
  margin-top: -8px;
  width: 216px;
  height: 116px;
  overflow: hidden;
  border-radius: 8px;
  background: var(--color-paper);
  opacity: 0;
  transform: translate(-50%, -12px) scale(0.96);
  transform-origin: top center;
  transition:
    opacity 0.3s ease-out,
    transform 0.3s ease-out;
}

.service-pill__preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.service-pill:hover .service-pill__preview,
.service-pill:focus-within .service-pill__preview {
  opacity: 1;
  transform: translate(-50%, 0) scale(1);
}

@media (prefers-reduced-motion: reduce) {
  .service-pill__preview {
    transition: none;
  }
}

/*
 | Pills sit inside their own circle's non-overlapping half, offset above and
 | below the label band (top 250 / bottom ~286) so neither collides with
 | Brand/Product or with the lens-shaped overlap between x=470 and x=630.
 */
.service-pill--social { inset-inline-start: 250px; top: 110px; }
.service-pill--branding { inset-inline-start: 330px; top: 390px; }
.service-pill--design { inset-inline-start: 770px; top: 110px; }
.service-pill--content { inset-inline-start: 850px; top: 390px; }

/* The stage's own centre (550.5) is also the Venn's lens centre. */
.orbit-anchor--core { inset-inline-start: 550px; top: 250px; }

.orbit-core {
  white-space: nowrap;
  padding: 4px 8px;
  border-radius: 4px;
  background: linear-gradient(150deg, var(--color-gold) 20%, var(--color-paper) 145%);
  color: var(--color-ink);
  font-family: var(--font-display);
  font-size: 18px;
  line-height: 20px;
}

/*
 | Ghost tags fill the stage's own margin either side of the circle pair
 | (150px on the desktop stage — see `.venn-circle--brand`'s inset above), so
 | they sit inside the stage's own coordinate space rather than needing
 | `.services-orbit`'s `overflow: hidden` relaxed. `space-around` distributes
 | three tags evenly without hand-tuning three separate top offsets per side.
 */
.ghost-col {
  position: absolute;
  z-index: 1;
  top: 40px;
  bottom: 40px;
  width: 130px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-around;
}

.ghost-col--brand { inset-inline-start: 4px; }
.ghost-col--product { inset-inline-end: 4px; }

.ghost-tag {
  padding: 6px 10px;
  border: 1px solid rgb(255 255 255 / 18%);
  border-radius: 999px;
  font-size: 12px;
  line-height: 1.3;
  text-align: center;
  color: rgb(255 255 255 / 40%);
}

/*
 |=============================================================================
 | MOBILE
 |=============================================================================
 |
 | The desktop Venn runs left -> right (Brand, then Product, meeting in the
 | middle); mobile turns the same pair a quarter turn so it reads top -> bottom
 | instead, the same axis flip the rest of the page's mobile frames use for
 | horizontal diagrams. The two circles are the same DOM nodes as desktop,
 | repositioned and rescaled here rather than duplicated.
 */
@media (max-width: 1023px) {
  .services-orbit {
    min-height: auto;
  }

  /* Decorative-only, and sized for the desktop stage's 1101px width — the
     mobile stack has neither the room nor, once the pills are a real column
     below the Venn rather than scattered anchors, the same "burst" reading. */
  .ghost-col,
  .orbit-ring-wrap {
    display: none;
  }

  /*
   | 260px circles overlapped by 70px vertically (0-260 and 190-450), plus a
   | pills column below, need more room than the desktop stage's 520 — sized
   | generously rather than to the exact content height because the pill
   | column's own height varies with the active locale's line count.
   */
  .orbit-stage {
    left: auto;
    width: 100vw;
    height: 800px;
    margin-inline-start: calc(50% - 50vw);
    margin-inline-end: 0;
    transform: none;
  }

  /*
   | Centred with `inset-inline: 0` + `margin-inline: auto` rather than
   | `left: 50%` + `translateX(-50%)` — a vertical stack has no leading or
   | trailing side to mirror under RTL, so either technique would centre it
   | correctly, but mixing a physical inset with the logical one the desktop
   | rule above already set on this element (`inset-inline-start: 150/470px`)
   | puts both in the SAME cascade slot per the logical-properties spec: the
   | last declaration wins the edge outright rather than overriding just the
   | axis, which cancelled the centring and pinned both circles to the
   | stage's static position. `inset-inline` never collides with it.
   */
  .venn-circle {
    top: auto;
    inset-inline: 0;
    margin-inline: auto;
    width: 260px;
    height: 260px;
  }

  .venn-circle--brand { top: 0; }
  .venn-circle--product { top: 190px; }

  .venn-label {
    inset-inline-start: 50%;
    font-size: 16px;
    font-weight: 500;
    line-height: 24px;
  }

  .venn-label--brand { top: 80px; }
  .venn-label--product { top: 350px; }

  .orbit-anchor--core {
    inset-inline-start: 50%;
    top: 215px;
  }

  /*
   | Pills column, same component as desktop's — just a real centred flex
   | column below the Venn instead of four absolutely-scattered anchors.
   | `width: fit-content` with a 202px floor rather than a hard 202: the
   | widest card in the active locale defines the column width, so it stays
   | centred and unclipped whether that is English or a longer fa/ar label.
   */
  .orbit-pills {
    display: flex;
    position: absolute;
    top: 490px;
    left: 50%;
    z-index: 2;
    flex-direction: column;
    align-items: center;
    gap: 24px;
    width: fit-content;
    min-width: 202px;
    max-width: calc(100% - 40px);
    transform: translateX(-50%);
  }

  /* Back to an ordinary column item: no anchor point, no zero width. */
  .service-pill {
    position: relative;
    inset: auto;
    display: block;
    width: auto;
    max-width: 100%;
  }

  .service-pill__label {
    width: 100%;
    white-space: nowrap;
    text-align: center;
    padding: 16px;
    border-radius: 16px;
    font-size: 16px;
    line-height: normal;
    background:
      linear-gradient(rgb(255 255 255 / 20%), rgb(255 255 255 / 20%)),
      linear-gradient(rgb(35 31 32 / 50%), rgb(35 31 32 / 50%));
  }

  /* No hover affordance on touch, and a 216px panel would cover the pill
     below it in a 24px-gap column. */
  .service-pill__preview {
    display: none;
  }
}
</style>
