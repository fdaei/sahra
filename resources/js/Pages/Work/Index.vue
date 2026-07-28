<script setup lang="ts">
/**
 * Projects listing — Figma 541:1558 (desktop, LTR) / 1362:7198 (RTL) /
 * 1498:10840 (mobile).
 *
 * Frame geometry:
 *   heading row      title block left, "filter section" 542:871 right
 *   filters          column, gap 16; selected 18/400 black-1000,
 *                    default 16/400 black-500 — the four *services*
 *   grid   1214:3933 2 columns, gap 96 (row) / 24 (column)
 *   card    907:1423 column, gap 40
 *     img   542:852  fill × 612, radius 12, 1px black/100, shadow 4/4/12
 *     detail         column gap 24 → caption (gap 16) + services row
 *       title        36/600 black-900, category right: icon 24 + 14/500 black-500
 *       description  16/400 black-700
 *       services     row gap 8, 14/400 black-500, 4px gold dot separators —
 *                    only present in the "hover" variant 553:921
 */
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import CtaBanner from '@/Components/CtaBanner.vue'
import FilterChips from '@/Components/FilterChips.vue'
import SeoHead from '@/Components/SeoHead.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { ProjectSummary, SeoMeta, SharedProps } from '@/types'

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
  projects: ProjectSummary[]
  filters: { slug: string; name: string }[]
  activeFilter: string | null
  sections: Record<string, SectionContent>
  seo: SeoMeta
}>()

const page = usePage<SharedProps>()
const { t } = useTranslations()

const basePath = computed(() => `/${page.props.locale.current}/work`)
</script>

<template>
  <SeoHead :meta="seo" />

  <div class="container-sahra flex flex-col gap-16 pb-24 pt-[136px] md:gap-24 md:pt-[192px]">
    <!-- Heading + filters — Figma "Main title & tag" beside 542:871 -->
    <div class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-between">
      <div class="flex max-w-[612px] flex-col gap-6">
        <p class="eyebrow">{{ heading.eyebrow }}</p>
        <h1 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
          {{ heading.title }}
        </h1>
        <p class="text-body-lg text-neutral-700">{{ heading.description }}</p>
      </div>

      <FilterChips
        v-if="filters.length > 0"
        :items="filters"
        :active="activeFilter"
        param-name="service"
        :base-path="basePath"
        direction="column"
      />
    </div>

    <!-- Grid — 1214:3933 -->
    <p
      v-if="projects.length === 0"
      class="py-16 text-center text-body-lg text-neutral-500"
    >
      {{ t('common.empty_projects') }}
    </p>

    <ul v-else class="grid gap-x-6 gap-y-24 sm:grid-cols-2">
      <li v-for="project in projects" :key="project.slug">
        <Link :href="project.url" class="group flex flex-col gap-10 rounded-md">
          <div
            class="overflow-hidden rounded-md border border-neutral-100 shadow-card"
          >
            <img
              v-if="project.image"
              :src="project.image.src"
              :srcset="project.image.srcset"
              :alt="project.image.alt"
              width="612"
              height="612"
              class="aspect-square w-full object-cover transition-transform duration-500 ease-brand group-hover:scale-[1.06]"
            />
            <div v-else class="aspect-square w-full bg-neutral-100" />
          </div>

          <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-4">
              <div class="flex items-center justify-between gap-4">
                <h2 class="text-[28px] font-semibold text-neutral-900 md:text-[36px]">
                  {{ project.title }}
                </h2>
                <span
                  v-if="project.industry"
                  class="flex shrink-0 items-center gap-2 text-label-lg text-neutral-500"
                >
                  <img
                    src="/icons/sahra/industry.svg"
                    alt=""
                    width="24"
                    height="24"
                    class="size-6"
                    aria-hidden="true"
                  />
                  {{ project.industry }}
                </span>
              </div>
              <p class="text-body-lg text-neutral-700">{{ project.excerpt }}</p>
            </div>

            <!--
              Hover variant 553:921. Collapsed by default so the card keeps the
              "default" 553:936 height; reduced-motion users get it expanded.
            -->
            <ul
              v-if="project.services.length > 0"
              class="flex max-h-0 flex-wrap items-center gap-2 overflow-hidden opacity-0 transition-[max-height,opacity] duration-500 ease-brand group-hover:max-h-16 group-hover:opacity-100 group-focus-visible:max-h-16 group-focus-visible:opacity-100 motion-reduce:max-h-16 motion-reduce:opacity-100"
            >
              <li
                v-for="(service, i) in project.services"
                :key="service"
                class="flex items-center gap-2 text-body-md text-neutral-500"
              >
                <span
                  v-if="i > 0"
                  class="inline-block size-1 rounded-full bg-gold"
                  aria-hidden="true"
                />
                {{ service }}
              </li>
            </ul>
          </div>
        </Link>
      </li>
    </ul>
  </div>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
