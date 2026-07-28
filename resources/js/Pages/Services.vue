<script setup lang="ts">
/**
 * Services page — Figma node 1323:7189 (desktop) / 1626:12562 (mobile).
 *
 * Single page, four alternating image/text rows ("service section"
 * component, node 1264:3486 — the component the docs/FIGMA-AUDIT.md anchor
 * node instantiates). No detail routes exist in the design (FIGMA-AUDIT §4).
 */
import CtaBanner from '@/Components/CtaBanner.vue'
import SeoHead from '@/Components/SeoHead.vue'
import type { SeoMeta, ServiceItem } from '@/types'

interface SectionContent {
  eyebrow: string
  title: string
  subtitle: string
  description: string
  content: string
  colors: Record<'eyebrow' | 'title' | 'subtitle' | 'description' | 'content', string | null>
  primaryCta: { label: string; url: string } | null
  secondaryCta: { label: string; url: string } | null
  image: { src: string; alt: string; width: number; height: number } | null
  items: Array<{ value: string; title: string; description: string; icon: string | null }>
}

defineProps<{
  heading: { eyebrow: string; title: string; description: string }
  services: ServiceItem[]
  sections: Record<string, SectionContent>
  seo: SeoMeta
}>()
</script>

<template>
  <SeoHead :meta="seo" />

  <!-- Services heading — Figma "Main title & tag" 1363:7520 -->
  <section class="section section-first pb-0">
    <div class="container-sahra max-w-2xl text-center mx-auto">
      <div class="eyebrow justify-center">{{ heading.eyebrow }}</div>
      <h1 class="text-display-md">{{ heading.title }}</h1>
      <p class="mt-6 text-body-lg text-neutral-600">{{ heading.description }}</p>
    </div>
  </section>

  <!-- Service sections — alternating layout, Figma 1264:3486 -->
  <section
    v-for="(service, i) in services"
    :key="service.slug"
    class="section"
  >
    <div
      class="container-sahra grid items-center gap-12 lg:grid-cols-2"
      :class="i % 2 === 1 ? 'lg:[&>*:first-child]:order-2' : ''"
    >
      <img
        v-if="service.image"
        :src="service.image.src"
        :srcset="service.image.srcset"
        :alt="service.image.alt"
        class="aspect-[604/786] w-full rounded-lg object-cover"
      />
      <div v-else class="aspect-[604/786] w-full rounded-lg bg-neutral-100" />

      <div>
        <p class="latin-nums text-title-lg text-gold">{{ String(i + 1).padStart(2, '0') }}</p>
        <h2 class="mt-4 text-display-sm">{{ service.title }}</h2>
        <p class="mt-4 text-body-lg text-neutral-600">{{ service.description }}</p>

        <ul v-if="service.features.length > 0" class="mt-8 flex flex-col gap-3">
          <li
            v-for="(feature, fi) in service.features"
            :key="fi"
            class="flex items-start gap-3 text-body-md text-neutral-700"
          >
            <span class="mt-2 inline-block size-1.5 shrink-0 rounded-full bg-gold" aria-hidden="true" />
            {{ feature }}
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
