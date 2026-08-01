<script setup lang="ts">
import { computed, ref } from 'vue'
import orbitInner from '~img/decor/service-orbit-inner.svg'
import orbitOuter from '~img/decor/service-orbit-outer.svg'
import { useScrubRotate } from '@/Composables/useMotion'
import type { ServiceItem } from '@/types'

interface ServiceSection {
  eyebrow: string
  title: string
  description: string
}

const props = defineProps<{
  section: ServiceSection
  services: ServiceItem[]
}>()

const serviceFor = (services: ServiceItem[], needle: string): ServiceItem | undefined =>
  services.find((service) => service.title.toLowerCase().includes(needle))

const serviceLabel = (services: ServiceItem[], needle: string, fallback: string) =>
  serviceFor(services, needle)?.title ?? fallback

/** The four orbiting pills, in the order Figma positions them. */
const pills = computed(() =>
  (
    [
      ['social', 'social', 'Social Media support'],
      ['branding', 'brand', 'Branding'],
      ['content', 'content', 'Content Production'],
      ['design', 'design', 'Marketing Design'],
    ] as const
  ).map(([modifier, needle, fallback]) => ({
    modifier,
    label: serviceLabel(props.services, needle, fallback),
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
          {{ section.eyebrow || 'Our Services' }}
        </div>

        <div class="grid gap-8 lg:grid-cols-[506px_1fr] lg:gap-[130px]">
          <h2 class="max-w-[506px] text-[30px] font-semibold leading-[1.48] text-white md:text-[36px] lg:text-[40px] lg:leading-[1.5]">
            {{ section.title }}
          </h2>
          <p class="max-w-[612px] text-[15px] font-medium leading-[1.55] text-neutral-200 md:text-[18px]">
            {{ section.description }}
          </p>
        </div>
      </div>

      <div class="orbit-stage mt-[72px]" aria-label="Marketing services connected to brand growth">
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

        <strong class="orbit-axis orbit-axis--marketing">Marketing</strong>
        <strong class="orbit-axis orbit-axis--growth">Growth</strong>

        <span class="orbit-core">Clear Brand Presence</span>

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
          class="service-pill"
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
  color: #bd933b;
  font-family: Idealist, 'Doran FaNum', Vazirmatn, serif;
  font-size: 24px;
  line-height: 1;
}

.service-eyebrow span {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: #bd933b;
  box-shadow: -2px -2px 12px rgb(189 147 59 / 50%), 2px 2px 12px rgb(189 147 59 / 50%);
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
  background: rgb(189 147 59 / 20%);
  filter: blur(112px);
}

.orbit-line {
  position: absolute;
  top: 263px;
  left: 157px;
  width: 824px;
  border-top: 2px dotted #bd933b;
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
  color: white;
}

.orbit-axis--marketing { left: 0; }
.orbit-axis--growth { right: 0; }

.orbit-endpoint {
  position: absolute;
  top: 257px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #bd933b;
  box-shadow: 0 0 8px rgb(189 147 59 / 55%);
}

.orbit-endpoint--start { left: 157px; }
.orbit-endpoint--middle-a { left: 404px; width: 10px; height: 10px; }
.orbit-endpoint--middle-b { left: 725px; width: 10px; height: 10px; }
.orbit-endpoint--end { left: 971px; }

.service-pill,
.orbit-core {
  position: absolute;
  z-index: 2;
  white-space: nowrap;
}

.service-pill__label {
  display: block;
  padding: 8px 16px;
  border-radius: 1000px;
  background: linear-gradient(rgb(255 255 255 / 20%), rgb(255 255 255 / 20%)),
    rgb(35 31 32 / 50%);
  font-size: 18px;
  font-weight: 500;
  line-height: 27px;
  color: white;
}

/*
 | Hover variant 501:722 — a 216x116 radius-8 panel under the pill, pulled up
 | 8px because the component stacks at gap -8. Transition matches the stored
 | prototype timing (SMART_ANIMATE, EASE_OUT, 0.3s).
 */
.service-pill__preview {
  position: absolute;
  inset-inline-start: 50%;
  top: 100%;
  z-index: -1;
  margin-top: -8px;
  width: 216px;
  height: 116px;
  overflow: hidden;
  border-radius: 8px;
  background: #fff;
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

.service-pill--social { left: 345px; top: 98px; }
.service-pill--branding { left: 647px; top: 176px; }
.service-pill--content { left: 336px; top: 299px; }
.service-pill--design { left: 638px; top: 321px; }

.orbit-core {
  left: 490px;
  top: 245px;
  padding: 4px 8px;
  border-radius: 4px;
  background: linear-gradient(150deg, #bd933b 20%, #fff 145%);
  color: #231f20;
  font-family: Idealist, 'Doran FaNum', Vazirmatn, serif;
  font-size: 18px;
  line-height: 20px;
}

@media (max-width: 1023px) {
  .services-orbit {
    min-height: auto;
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
    left: 8%;
    right: 8%;
    top: 50%;
    width: auto;
  }

  .orbit-axis,
  .orbit-endpoint,
  .orbit-core {
    display: none;
  }

  .service-pill {
    position: relative;
    inset: auto;
    white-space: normal;
  }

  .service-pill__label {
    display: flex;
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
