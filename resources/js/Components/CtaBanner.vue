<script setup lang="ts">
/**
 * Final CTA card — Figma 1419:9333 "final CTA card" (1248x483).
 * Shared by Home, Work, Single project, Services, About and Insights.
 *
 * Verified against the node: the card is padded 56 all round at radius 16
 * over a photographic background, and everything inside is **left**-aligned
 * on the padding edge (every child sits at relX 56) — not centred. The stack
 * is the gold eyebrow, gap 8, then a content column at gap 40 holding
 * [title 40/600 over subtitle 18/500 at gap 24, gap 48, the CTA button] and
 * the trailing service list 18/500.
 *
 * The eyebrow here is a plain text node, not the "small title" component —
 * the dotted variant (Frame 95772) is present but hidden in the file, so
 * this one carries no leading disc.
 */
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
import { useParallax } from '@/Composables/useMotion'
import type { SharedProps } from '@/types'

const page = usePage<SharedProps>()

/*
 | A11 — the gold horizon behind the card drifts against the scroll. The layer
 | is sized 120% tall and offset -10% so a ±10% travel never exposes an edge;
 | `useParallax(…, 20)` maps to exactly that yPercent range.
 */
const glow = ref<HTMLElement | null>(null)

useParallax(glow, 20)

/*
 | The horizon is directional, not symmetric: the sun and dune crest sit on the
 | trailing edge so they stay clear of the copy. The RTL frames (1365:11595)
 | therefore carry a horizontally mirrored bitmap of the same artwork, which the
 | LTR-only build was never picking up — in fa/ar the crest landed *under* the
 | text. Both exports ship as files rather than one being a CSS flip of the
 | other: GSAP owns `transform` on this layer and folds any `transform`/`scale`
 | we set into its own matrix, so a CSS mirror would not survive the teardown
 | and re-init that `lib/motion.ts` runs on every Inertia navigation.
 */
const horizonSrc = computed(() =>
  page.props.locale.direction === 'rtl'
    ? '/images/sahra/dark-gold-horizon-bg-rtl.png'
    : '/images/sahra/dark-gold-horizon-bg.png',
)

defineProps<{
  spacingClass?: string
  section: {
    eyebrow: string
    title: string
    description: string
    subtitle: string
    colors: Record<'eyebrow' | 'title' | 'subtitle' | 'description' | 'content', string | null>
    primaryCta: { label: string; url: string } | null
  }
}>()
</script>

<template>
  <section class="pb-[224px] pt-24" :class="spacingClass">
    <div class="container-sahra">
      <div
        class="relative flex min-h-[359px] flex-col justify-center gap-2 overflow-hidden rounded-lg
               bg-ink p-6 md:min-h-[483px] md:p-14"
      >
        <img
          ref="glow"
          :src="horizonSrc"
          alt=""
          width="1672"
          height="941"
          class="pointer-events-none absolute inset-x-0 -top-[10%] h-[120%] w-full object-cover object-center"
          aria-hidden="true"
          decoding="async"
        />
        <div
          class="pointer-events-none absolute inset-0 bg-gradient-to-r
                 from-black/75 via-black/40 to-black/10 rtl:bg-gradient-to-l"
          aria-hidden="true"
        />

        <p
          class="relative z-10 font-display text-[16px] leading-6 text-gold md:text-[24px] md:leading-[26px]"
          :style="{ color: section.colors.eyebrow || undefined }"
        >
          {{ section.eyebrow }}
        </p>

        <div class="relative z-10 flex flex-col gap-6 md:gap-10">
          <div class="flex flex-col gap-10 md:gap-12">
            <div class="flex flex-col gap-4 md:gap-6">
              <h2
                class="text-[24px] font-semibold leading-normal text-paper md:text-display-md lg:max-w-[505px]"
                :style="{ color: section.colors.title || undefined }"
              >
                {{ section.title }}
              </h2>
              <p
                class="text-body-md text-neutral-100 md:text-title-sm md:font-medium lg:max-w-[715px]"
                :style="{ color: section.colors.description || undefined }"
              >
                {{ section.description }}
              </p>
            </div>

            <a
              v-if="section.primaryCta"
              :href="section.primaryCta.url"
              class="inline-flex w-fit items-center gap-1 rounded-sm bg-paper px-3 py-3
                     text-body-md text-ink transition-opacity hover:opacity-90 md:px-6 md:text-title-sm"
            >
              {{ section.primaryCta.label }}
              <ArrowRight class="size-5 shrink-0 rtl:-scale-x-100 md:size-6" aria-hidden="true" />
            </a>
          </div>

          <p
            v-if="section.subtitle"
            class="text-[12px] font-medium leading-normal text-neutral-300 md:text-title-sm md:text-neutral-100"
            :style="{ color: section.colors.subtitle || undefined }"
          >
            {{ section.subtitle }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
