<script setup lang="ts">
import { computed, ref } from 'vue'
import orbitInner from '~img/decor/service-orbit-inner.svg'
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
 | The four orbiting pills, in the order Figma positions them.
 |
 | The label is authored content; the third tuple member is the translation key
 | used when no service row matches the needle for the active locale. It must
 | stay a key rather than a literal — a hardcoded English fallback would put
 | Latin text inside the fa/ar orbit.
 */
const pills = computed(() =>
  (
    [
      ['social', 'social', 'services.pill_social'],
      ['branding', 'brand', 'services.pill_branding'],
      ['content', 'content', 'services.pill_content'],
      ['design', 'design', 'services.pill_design'],
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

useScrubRotate(outerRing)
useScrubRotate(innerRing)
</script>

<template>
  <section class="services-orbit overflow-hidden bg-black text-white">
    <div class="container-sahra relative z-10 py-14 md:py-20 lg:py-24">
      <div class="flex flex-col gap-12">
        <div class="service-eyebrow">
          <span aria-hidden="true" />
          {{ section.eyebrow || t('services.eyebrow') }}
        </div>

        <div class="grid gap-8 lg:grid-cols-[506px_1fr] lg:gap-[130px]">
          <h2 class="max-w-[506px] text-[30px] font-semibold leading-normal text-white md:text-[36px] lg:text-[40px] lg:leading-[1.5]">
            {{ section.title }}
          </h2>
          <p class="max-w-[612px] text-[15px] font-medium leading-normal text-neutral-200 md:text-[18px]">
            {{ section.description }}
          </p>
        </div>
      </div>

      <!--
        role="group" so the label is exposed — aria-label on a bare div is
        ignored by AT. Not role="img": the pills inside carry real service
        names and must stay in the accessibility tree.
      -->
      <div class="orbit-stage mt-[72px]" role="group" :aria-label="t('services.orbit_label')">
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

        <span class="orbit-endpoint orbit-endpoint--start" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--middle-a" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--middle-b" aria-hidden="true" />
        <span class="orbit-endpoint orbit-endpoint--end" aria-hidden="true" />

        <strong class="orbit-axis orbit-axis--marketing">{{ t('services.axis_marketing') }}</strong>
        <strong class="orbit-axis orbit-axis--growth">{{ t('services.axis_growth') }}</strong>

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
        -->
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
  </section>
</template>

<style scoped>
.services-orbit {
  position: relative;
  min-height: 978px;
}

.service-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  width: fit-content;
  color: var(--color-gold);
  font-family: var(--font-display);
  font-size: 24px;
  line-height: 1;
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
  background: rgb(var(--color-gold-rgb) / 20%);
  filter: blur(112px);
}

/*
 | Everything inside the stage is placed with logical insets, not left/right.
 | The composition is a directional diagram — it runs Marketing -> Growth along
 | the axis — so under fa/ar the whole orbit mirrors and the progression reads
 | right-to-left with the rest of the page. The offsets below are the LTR Figma
 | frame's; the browser mirrors them.
 */
.orbit-line {
  position: absolute;
  top: 263px;
  inset-inline-start: 157px;
  width: 824px;
  border-top: 2px dotted var(--color-gold);
}

.orbit-circle {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

.orbit-circle--outer {
  width: 520px;
  height: 520px;
}

.orbit-circle--inner {
  width: 320px;
  height: 320px;
}

.orbit-axis {
  position: absolute;
  top: 245px;
  font-size: 24px;
  line-height: 36px;
  color: var(--color-paper);
}

.orbit-axis--marketing { inset-inline-start: 0; }
.orbit-axis--growth { inset-inline-end: 0; }

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

.service-pill__label {
  display: block;
  white-space: nowrap;
  padding: 8px 16px;
  border-radius: 1000px;
  background: linear-gradient(rgb(var(--color-paper-rgb) / 20%), rgb(var(--color-paper-rgb) / 20%)),
    rgb(var(--color-ink-rgb) / 50%);
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
 | This label is an identity/status label, not one endpoint of the directional
 | Marketing → Growth axis.  It must therefore stay at the visual centre in
 | every locale. `inset-inline-start` mirrors in RTL and shifted Persian/Arabic
 | away from centre; physical 50% is intentional here because centring is not
 | direction-dependent. The zero-width anchor centres its overflowing pill.
 */
.orbit-anchor--core { left: 50%; top: 245px; }

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

@media (max-width: 1023px) {
  .services-orbit {
    min-height: 828px;
  }

  .orbit-stage {
    width: 100%;
    height: auto;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    padding-block: 72px 24px;
  }

  .orbit-circle--outer {
    width: min(78vw, 430px);
    height: min(78vw, 430px);
  }

  .orbit-circle--inner {
    width: min(48vw, 270px);
    height: min(48vw, 270px);
  }

  .orbit-line {
    inset-inline: 8%;
    top: 50%;
    width: auto;
  }

  .orbit-axis,
  .orbit-endpoint,
  .orbit-anchor--core {
    display: none;
  }

  /* Back to an ordinary grid item: no anchor point, no zero width. */
  .service-pill {
    position: relative;
    inset: auto;
    display: block;
    width: auto;
  }

  .service-pill__label {
    display: flex;
    white-space: normal;
    min-height: 48px;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    font-size: 14px;
    line-height: 20px;
  }

  /* The mobile frame (1419:9191) stacks the pills in a 2-up grid with no
     hover affordance, and a 216px panel would overlap its neighbours. */
  .service-pill__preview {
    display: none;
  }
}
</style>
