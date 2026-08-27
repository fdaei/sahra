<script setup lang="ts">
import { computed, ref } from 'vue'
import orbitInner from '~img/decor/service-orbit-inner.svg'
import orbitMobile from '~img/decor/service-orbit-mobile.svg'
import orbitOuter from '~img/decor/service-orbit-outer.svg'
import { useScrubRotate } from '@/Composables/useMotion'
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
 | The four orbiting pills, in the MOBILE frame's column order
 | (1731:12357: Branding, Social, Marketing Design, Content Production).
 |
 | Desktop is unaffected by this order — each pill is absolutely placed by its
 | `--modifier` class at its own frame coordinate — so the mobile stack, which
 | is the only place the array order is visible, gets to define it. That also
 | makes it the reading order for assistive tech in both layouts.
 |
 | The label is authored content; the third tuple member is the translation key
 | used when no service row matches the needle for the active locale. It must
 | stay a key rather than a literal — a hardcoded English fallback would put
 | Latin text inside the fa/ar orbit.
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
 | A4 — the two dashed rings rotate −8°→8° as the section crosses the viewport,
 | scrubbed to scroll position with no easing. Each ring is rotated in place
 | (about its own centre) rather than via a shared wrapper, because the rings
 | are absolutely positioned at different diameters and a wrapper transform
 | would move them off their concentric centre.
 */
const outerRing = ref<HTMLElement | null>(null)
const innerRing = ref<HTMLElement | null>(null)
const mobileRing = ref<HTMLElement | null>(null)

/*
 | The stage draws two rings above 1024px and one flattened export below it,
 | with the unused set at `display: none` (see the media query at the bottom).
 | Each rotation is therefore scoped to the width that actually renders its
 | target: a ScrollTrigger measured on a hidden element has a zero-height rect,
 | so scoping is not an optimisation — an unscoped trigger on the mobile ring
 | would simply never scrub.
 */
useScrubRotate(outerRing, { media: '(min-width: 1024px)' })
useScrubRotate(innerRing, { media: '(min-width: 1024px)' })
useScrubRotate(mobileRing, { media: '(max-width: 1023px)' })
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
      -->
      <div class="orbit-stage mt-12 lg:mt-[72px]" role="group" :aria-label="t('services.orbit_label')">
        <div class="orbit-glow" aria-hidden="true" />
        <div class="orbit-line" aria-hidden="true" />
        <!--
          Rings Ellipse 33 (520) and Ellipse 28 (320). Both are a 2px dashed
          3/3 stroke painted with a gold gradient (opacity .8 -> .4 -> .8) plus
          an inner glow — none of which a CSS border can express, so they ship
          as the exported vectors rather than as `border: dotted`.
        -->
        <img ref="outerRing" :src="orbitOuter" class="orbit-circle orbit-circle--outer" alt="" aria-hidden="true" />
        <img ref="innerRing" :src="orbitInner" class="orbit-circle orbit-circle--inner" alt="" aria-hidden="true" />
        <!--
          Mobile frame 1731:12369 flattens both rings into ONE 502x502 export
          (inner r=150, outer r=250) rather than reusing the two desktop files —
          their diameters (520/320) and their inner glow are drawn for the
          1101x520 stage and do not rescale onto the 500x500 mobile one.
          Swapped by media query below; only ever one of the two sets is drawn.
        -->
        <!--
          The centring lives on the wrapper, the rotation on the <img> inside.
          useScrubRotate rebuilds its target's matrix on every scrub tick and
          folds any author transform into it, so a `translate(-50%, -50%)` on
          the rotated element itself would be re-applied each tick and walk the
          ring off centre as it turns — the same trap the note above the
          `.orbit-circle` rules describes.
        -->
        <div class="orbit-circle orbit-circle--mobile" aria-hidden="true">
          <img ref="mobileRing" :src="orbitMobile" alt="" />
        </div>

        <span class="orbit-endpoint orbit-endpoint--start" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--middle-a" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--middle-b" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--end" aria-hidden="true" />

        <!--
          The axis is a single ordered pair in both frames, but it RUNS ALONG A
          DIFFERENT AXIS in each: left→right on desktop (1419:9286), and
          top→bottom on mobile (1731:12368), where Marketing sits above the
          stack and Growth below it. Same two labels and same reading order —
          only the direction of travel changes — so both frames are served by
          this one pair plus the media query, not by duplicated markup.
        -->
        <strong class="orbit-axis orbit-axis--marketing">{{ t('services.axis_marketing') }}</strong>
        <strong class="orbit-axis orbit-axis--growth">{{ t('services.axis_growth') }}</strong>

        <!-- Vertical dashed connector + its two dots — mobile only (1731:12358). -->
        <span class="orbit-line-vertical" aria-hidden="true" />

        <span class="orbit-anchor orbit-anchor--core">
          <span class="orbit-core">{{ t('services.core') }}</span>
        </span>

        <!--
          Service card 1419:9295-9298. Each carries an ON_HOVER interaction
          that CHANGE_TOs variant 501:722 with SMART_ANIMATE / EASE_OUT /
          0.3s. That variant is the same pill with a 216x116 radius-8 panel
          revealed beneath it (overlapping by 8px — the component stacks at
          gap -8). The panel is blank in the file, so it shows the service's
          own image where the CMS has one.

          The wrapper is `display: contents` on desktop, so each pill stays a
          direct layout child of the stage and keeps its own absolute frame
          coordinate. Below lg it becomes a real centred flex column (frame
          1731:12357), which is the only way to stack pills whose heights vary
          by locale — absolute `top`s per pill would drift the moment an
          fa/ar label wrapped to two lines.
        -->
        <div class="orbit-pills">
          <div
            v-for="pill in pills"
            :key="pill.modifier"
            class="orbit-anchor service-pill"
            :class="`service-pill--${pill.modifier}`"
          >
            <span class="service-pill__label">{{ pill.label }}</span>

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
  /* Ellipse 1419:9280 — gold at 40%, blur 200. Both were under-set (20%/112). */
  background: rgb(var(--color-gold-rgb) / 40%);
  filter: blur(200px);
}

/*
 | Everything inside the stage is placed with logical insets, not left/right.
 | The composition is a directional diagram — it runs Marketing -> Growth along
 | the axis — so under fa/ar the whole orbit mirrors and the progression reads
 | right-to-left with the rest of the page. The offsets below are the LTR Figma
 | frame's; the browser mirrors them.
 */
/*
 | Axis line 1419:9292 — x=157, y=263, w=824.02, 2px stroke, dash 4/4, gold/600.
 |
 | Painted as a repeating gradient rather than `border-top: dotted`, because a
 | CSS dotted/dashed border has no controllable dash length: the browser picks
 | it from the stroke width, which gave a 2/2 dot pattern against the file's
 | 4/4. The 2px band is centred on y=263, hence top 262.
 */
.orbit-line {
  position: absolute;
  top: 262px;
  inset-inline-start: 157px;
  width: 824.02px;
  height: 2px;
  background-image: repeating-linear-gradient(
    to right,
    var(--color-gold-600) 0 4px,
    transparent 4px 8px
  );
}

/*
 | ===========================================================================
 | RING PLACEMENT — this is what makes the endpoint dots meet the circles.
 | ===========================================================================
 |
 | Both rings used to be centred on the stage (`left/top: 50%` +
 | `translate(-50%,-50%)`), which puts their centre at x=550.5 in the 1101-wide
 | group. The file does NOT centre them: Ellipse 33 (outer, 520) sits at
 | x=309,y=0 and Ellipse 28 (inner, 320) at x=409,y=107, so both are centred at
 | x=569 — 18.5px to the trailing side of the stage centre.
 |
 | That offset was the whole defect. The four endpoint dots were already at
 | their exact file coordinates, so a mis-placed ring made them look scattered:
 |
 |   inner circle, centre (569,267) r160, crossed at y=262
 |     -> x = 569 ∓ √(160² − 5²) = 409.1 / 728.9
 |     -> dots 1419:9291 (409,262) and 1419:9299 (730,262)   ✓ on the circle
 |   the two 12px dots are the LINE's endpoints (157 / 981), not ring points.
 |
 | So the dots stay put and the rings move onto them. Positioning is logical
 | (`inset-inline-start`) so the whole diagram still mirrors under fa/ar.
 |
 | No `transform` here on purpose: useScrubRotate() writes `rotation` onto
 | these elements, and GSAP folds any author transform into its own matrix —
 | a `translate(-50%,-50%)` would be re-applied on every scrub tick and drag
 | the ring off centre as it turns.
 */
.orbit-circle {
  position: absolute;
}

/* Desktop draws the two separate rings; the flattened mobile export is idle. */
.orbit-circle--mobile {
  display: none;
}

/* Fills its wrapper, and carries no transform of its own — see the markup. */
.orbit-circle--mobile > img {
  display: block;
  width: 100%;
  height: 100%;
}

/* The pills are absolutely placed on desktop — the wrapper must not box them. */
.orbit-pills {
  display: contents;
}

/* The vertical connector belongs to the mobile frame only. */
.orbit-line-vertical {
  display: none;
}

.orbit-circle--outer {
  inset-inline-start: 309px;
  top: 0;
  width: 520px;
  height: 520px;
}

.orbit-circle--inner {
  inset-inline-start: 409px;
  top: 107px;
  width: 320px;
  height: 320px;
}

/*
 | Axis labels 1419:9287 / 1419:9288 — Poppins SemiBold 24/36, white, and both
 | are CENTER-aligned inside a fixed text box (Marketing 125 wide at x=0,
 | Growth 89 wide at x=1012, i.e. flush to the trailing edge).
 |
 | `min-width` rather than `width`: the file's box widths are measured from the
 | English strings, and the longer fa/ar labels must be allowed to grow instead
 | of wrapping inside a 89px box.
 */
.orbit-axis {
  position: absolute;
  top: 245px;
  font-size: 24px;
  font-weight: 600;
  line-height: 36px;
  text-align: center;
  color: var(--color-paper);
}

.orbit-axis--marketing { inset-inline-start: 0; min-width: 125px; }
.orbit-axis--growth { inset-inline-end: 0; min-width: 89px; }

.orbit-endpoint {
  position: absolute;
  top: 257px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: var(--color-gold);
  box-shadow: 0 0 8px rgb(var(--color-gold-rgb) / 55%);
}

.orbit-endpoint--start { inset-inline-start: 157px; }
.orbit-endpoint--middle-a { inset-inline-start: 404px; width: 10px; height: 10px; }
.orbit-endpoint--middle-b { inset-inline-start: 725px; width: 10px; height: 10px; }
.orbit-endpoint--end { inset-inline-start: 971px; }

/*
 | A zero-width point that its content overflows equally on both sides, so the
 | label is *centred* on the orbit coordinate rather than starting at it. The
 | pills were anchored by their leading edge, which is fine for the English
 | labels the frame was drawn with but let the longer fa/ar ones grow outwards
 | until they crossed the outer ring. Centring is also direction-agnostic —
 | no translateX to flip under RTL.
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

/* Frame coordinates, converted from the pill's leading edge to its centre. */
.service-pill--social { inset-inline-start: 456.5px; top: 98px; }
.service-pill--branding { inset-inline-start: 703px; top: 176px; }
.service-pill--content { inset-inline-start: 441.5px; top: 299px; }
.service-pill--design { inset-inline-start: 732px; top: 321px; }

/*
 | The rings and the horizontal axis share x=569 as their actual centre
 | (the 1101px stage itself is centred at x=550.5). Anchor the core label to
 | that shared geometry so it sits exactly at the line/ring intersection.
 | Keeping this logical also mirrors the complete diagram correctly in RTL.
 */
.orbit-anchor--core { inset-inline-start: 569px; top: 245px; }

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
 |=============================================================================
 | MOBILE — frame 1731:12370 / group 1731:12369 (Home mobile 1419:9191)
 |=============================================================================
 |
 | This is NOT the desktop diagram scaled down, and it is not the 2-up pill
 | grid that used to stand in for it. The mobile frame keeps the full orbit
 | but ROTATES THE AXIS a quarter turn:
 |
 |            desktop 1101x520              mobile 500x500
 |            Marketing ——•——•—— Growth     Marketing
 |            pills scattered on the ring        |
 |                                            [Branding]
 |                                       [Social Media support]
 |                                        [Marketing Design]
 |                                       [Content Production]
 |                                               |
 |                                            Growth
 |
 | Frame coordinates inside the 500x500 group (all verified on the node):
 |
 |   rings        1731:12365   0,0    502x502  (inner r150, outer r250)
 |   axis+pills   1731:12368   149,22 202x436
 |     axis col   1731:12364   +65,0   72 wide · column · centre · gap 8
 |                             [Marketing 14/500] [10x378 line] [Growth]
 |     pills col  1731:12357   +0,68  202 wide · column · centre · gap 24
 |
 | so, measured from the top of the 500 stage:
 |   Marketing  top 22   (h 21)
 |   line       top 51   (h 378)   -> ends 429
 |   Growth     top 437  (h 21)
 |   pills      top 90,  centred, 202 wide
 |
 | The group is placed at x=-49 in the 402 frame, i.e. dead centre with a 49px
 | bleed each side — the rings are MEANT to run off both edges and be clipped
 | by the section. Hence `left: 50%` + `translateX(-50%)` on a fixed 500 box
 | rather than a fluid width: shrinking the rings to fit would close the
 | composition up and lose the bleed the frame is drawn around.
 */
@media (max-width: 1023px) {
  .services-orbit {
    min-height: auto;
  }

  /*
   | The stage becomes a plain 500-tall positioning context spanning the
   | column. Height is fixed because every child inside is placed against the
   | frame's own 500px coordinate space.
   */
  .orbit-stage {
    /* Centre the diagram against the viewport, not the padded content track.
       This also avoids a visible offset when a parent/container gutter is
       asymmetric because of direction or scrollbar compensation. */
    left: auto;
    width: 100vw;
    height: 500px;
    margin-inline-start: calc(50% - 50vw);
    margin-inline-end: 0;
    transform: none;
  }

  /* Desktop rings off, flattened mobile export on, centred with its bleed. */
  .orbit-circle--outer,
  .orbit-circle--inner {
    display: none;
  }

  .orbit-circle--mobile {
    display: block;
    inset-inline-start: auto;
    left: 50%;
    top: 50%;
    width: 500px;
    height: 500px;
    max-width: none;
    transform: translate(-50%, -50%);
  }

  /* Horizontal axis line, its four dots and the core chip are desktop-only. */
  .orbit-line,
  .orbit-endpoint,
  .orbit-anchor--core {
    display: none;
  }

  /*
   | Axis labels move to the top and bottom of the stack. Both are centred on
   | the stage's midline, so they are placed physically (50% + translateX) —
   | a vertical axis has no leading/trailing side to mirror under RTL.
   */
  .orbit-axis {
    display: block;
    inset-inline: auto;
    left: 50%;
    width: auto;
    min-width: 72px;
    transform: translateX(-50%);
    font-size: 14px;
    font-weight: 500;
    line-height: 21px;
  }

  .orbit-axis--marketing {
    top: 22px;
  }

  .orbit-axis--growth {
    top: 437px;
  }

  /*
   | Connector 1731:12358 — a 378px dashed run with a 10px gold dot capping
   | each end. Same 4/4 dash and gold/600 stroke as the desktop axis, turned
   | 90°, so it is painted the same way (a repeating gradient, because a CSS
   | dashed border cannot control dash length).
   */
  .orbit-line-vertical {
    display: block;
    position: absolute;
    top: 51px;
    left: 50%;
    width: 2px;
    height: 378px;
    transform: translateX(-50%);
    background-image: repeating-linear-gradient(
      to bottom,
      var(--color-gold-600) 0 4px,
      transparent 4px 8px
    );
  }

  .orbit-line-vertical::before,
  .orbit-line-vertical::after {
    content: '';
    position: absolute;
    left: 50%;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--color-gold);
    box-shadow: 0 0 8px rgb(var(--color-gold-rgb) / 55%);
    transform: translateX(-50%);
  }

  .orbit-line-vertical::before { top: -5px; }
  .orbit-line-vertical::after { bottom: -5px; }

  /*
   | Pills column 1731:12357. `width: fit-content` with a 202px floor rather
   | than a hard 202: the file stretches its widest card ("Social Media
   | support") to define that width, so letting the widest pill in the ACTIVE
   | locale set it reproduces the same result in English and stays centred and
   | unclipped when the fa/ar labels are longer.
   */
  .orbit-pills {
    display: flex;
    position: absolute;
    top: 90px;
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
