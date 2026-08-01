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
import { ref } from 'vue'
import { ArrowRight } from 'lucide-vue-next'
import { useParallax } from '@/Composables/useMotion'

/*
 | A11 — the gold horizon behind the card drifts against the scroll. The layer
 | is sized 120% tall and offset -10% so a ±10% travel never exposes an edge;
 | `useParallax(…, 20)` maps to exactly that yPercent range.
 */
const glow = ref<HTMLElement | null>(null)

useParallax(glow, 20)

defineProps<{
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
  <section class="pb-[224px] pt-24">
    <div class="container-sahra">
      <div
        class="relative flex min-h-[483px] flex-col justify-center gap-2
               overflow-hidden rounded-lg bg-ink p-8 md:p-14"
      >
        <img
          ref="glow"
          src="/images/sahra/dark-gold-horizon-bg.png"
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
          class="relative z-10 font-display text-[24px] leading-[26px] text-gold"
          :style="{ color: section.colors.eyebrow || undefined }"
        >
          {{ section.eyebrow }}
        </p>

        <div class="relative z-10 flex flex-col gap-10">
          <div class="flex flex-col gap-12">
            <div class="flex flex-col gap-6">
              <h2
                class="text-display-md text-paper lg:max-w-[505px]"
                :style="{ color: section.colors.title || undefined }"
              >
                {{ section.title }}
              </h2>
              <p
                class="text-title-sm font-medium text-neutral-100 lg:max-w-[715px]"
                :style="{ color: section.colors.description || undefined }"
              >
                {{ section.description }}
              </p>
            </div>

            <a
              v-if="section.primaryCta"
              :href="section.primaryCta.url"
              class="inline-flex w-fit items-center gap-1 rounded-sm bg-paper px-6 py-3
                     text-title-sm text-ink transition-opacity hover:opacity-90"
            >
              {{ section.primaryCta.label }}
              <ArrowRight class="size-6 shrink-0 rtl:-scale-x-100" aria-hidden="true" />
            </a>
          </div>

          <p
            v-if="section.subtitle"
            class="text-title-sm font-medium text-neutral-100"
            :style="{ color: section.colors.subtitle || undefined }"
          >
            {{ section.subtitle }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
