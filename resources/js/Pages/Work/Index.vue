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
import { computed, ref, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { ChevronDown } from 'lucide-vue-next'
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

const props = defineProps<{
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

/*
 | Figma 1214:3933 lays out six cards and then the "More Works" control
 | (1215:4065). The controller returns the full set in one payload, so the
 | reveal is client-side — no request, and every project stays crawlable
 | because the markup below only hides the overflow after hydration.
 */
const PAGE_SIZE = 6
const shown = ref(PAGE_SIZE)

const visibleProjects = computed(() => props.projects.slice(0, shown.value))
const hasMore = computed(() => props.projects.length > shown.value)

// Switching filters re-renders a different set; start it back at page one.
watch(() => props.activeFilter, () => (shown.value = PAGE_SIZE))
</script>

<template>
  <SeoHead :meta="seo" />

  <!--
    Page column 1726:11741 sits at (96, 184) and nests three intervals:
    224 (content -> final CTA), 120 (heading row -> grid), 96 (grid -> More).
    They are separate auto-layout levels in the file and stay separate here.
  -->
  <div class="container-sahra flex flex-col gap-12 pb-0 pt-[160px] md:gap-[120px] md:pb-32 md:pt-[184px]">
    <!-- Heading + filters — Figma 1219:4240: space-between, items-center -->
    <div class="flex flex-col gap-16 lg:flex-row lg:items-center lg:justify-between lg:gap-10">
      <!-- "Main title & tag" 1005:1609 — eyebrow, gap 48, then title over
           subtitle at gap 24. -->
      <div class="flex h-[184px] max-w-[611px] flex-col gap-6 md:h-auto md:gap-12">
        <p class="eyebrow">{{ heading.eyebrow }}</p>
        <div class="flex flex-col gap-6">
          <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">{{ heading.title }}</h1>
          <p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">{{ heading.description }}</p>
        </div>
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

    <!-- 1215:4090 — grid and the "More Works" control, gap 96, centred. -->
    <div class="flex flex-col items-center gap-16 md:gap-24">
    <!-- Grid — 1214:3933 -->
    <p
      v-if="projects.length === 0"
      class="py-16 text-center text-body-lg text-neutral-500"
    >
      {{ t('common.empty_projects') }}
    </p>

    <ul v-else class="grid w-full gap-x-6 gap-y-16 sm:grid-cols-2 md:gap-y-24">
      <li
        v-for="(project, projectIndex) in visibleProjects"
        :key="project.slug"
        :class="[projectIndex >= 4 ? 'max-sm:hidden' : '', 'max-sm:h-[490px] max-sm:overflow-hidden']"
      >
        <Link :href="project.url" class="group flex flex-col gap-4 rounded-md md:gap-10">
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
                <h2 class="text-[22px] font-semibold text-neutral-900 md:text-[36px]">
                  {{ project.title }}
                </h2>
                <span
                  v-if="project.industry"
                  class="flex shrink-0 items-center gap-2 text-[12px] font-medium text-neutral-500 md:text-label-lg"
                >
                  <img
                    src="/icons/sahra/industry.svg"
                    alt=""
                    width="24"
                    height="24"
                    class="size-4 md:size-6"
                    aria-hidden="true"
                  />
                  {{ project.industry }}
                </span>
              </div>
              <p class="text-body-md text-neutral-700 md:text-body-lg">{{ project.excerpt }}</p>
            </div>

            <!--
              Hover variant 553:921. Collapsed by default so the card keeps the
              "default" 553:936 height; reduced-motion users get it expanded.
            -->
            <ul
              v-if="project.services.length > 0"
              class="flex max-h-0 flex-wrap items-center gap-2 overflow-hidden opacity-0 transition-[max-height,opacity] duration-500 ease-brand group-hover:max-h-16 group-hover:opacity-100 group-focus-visible:max-h-16 group-focus-visible:opacity-100"
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

    <!-- "More Works" — Figma 1215:4065, centred under the grid. -->
    <button
      v-if="hasMore || projects.length > 4"
      type="button"
      class="inline-flex items-center gap-1 text-body-md font-medium text-neutral-900 md:gap-2 md:text-body-lg
             transition-opacity hover:opacity-70"
      @click="shown += PAGE_SIZE"
    >
      {{ t('common.load_more') }}
      <ChevronDown class="size-4 shrink-0 md:size-6" aria-hidden="true" />
    </button>
    </div>
  </div>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner
    v-if="sections.final_cta"
    :section="sections.final_cta"
    spacing-class="pb-[270px] pt-[57px] md:pb-[145px] md:pt-24"
  />
</template>
