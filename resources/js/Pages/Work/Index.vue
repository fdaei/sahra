<script setup lang="ts">
/**
 * Projects listing — Figma node 1362:7198 (desktop) / 1498:10840 (mobile).
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

const props = defineProps<{
  heading: { eyebrow: string; title: string; description: string }
  projects: ProjectSummary[]
  industries: { slug: string; name: string }[]
  activeIndustry: string | null
  sections: Record<string, SectionContent>
  seo: SeoMeta
}>()

const page = usePage<SharedProps>()
const { t } = useTranslations()

const basePath = computed(() => `/${page.props.locale.current}/work`)
</script>

<template>
  <SeoHead :meta="seo" />

  <!-- Work heading — Figma "Main title & tag" 1363:7520 -->
  <section class="section pb-0">
    <div class="container-sahra max-w-2xl">
      <div class="eyebrow">{{ heading.eyebrow }}</div>
      <h1 class="text-display-md">{{ heading.title }}</h1>
      <p class="mt-6 text-body-lg text-neutral-600">{{ heading.description }}</p>
    </div>
  </section>

  <!-- Filters — Figma 1363:7500 -->
  <section v-if="industries.length > 0" class="section pb-0 pt-8">
    <div class="container-sahra">
      <FilterChips
        :items="industries"
        :active="activeIndustry"
        param-name="industry"
        :base-path="basePath"
      />
    </div>
  </section>

  <!-- Project grid — "project post" component 1362:7211 -->
  <section class="section">
    <div class="container-sahra">
      <p v-if="projects.length === 0" class="text-center text-body-lg text-neutral-500">
        {{ t('common.empty_projects') }}
      </p>

      <div v-else class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <Link
          v-for="project in projects"
          :key="project.slug"
          :href="project.url"
          class="group block overflow-hidden rounded-lg border border-neutral-100 shadow-card transition-shadow hover:shadow-testimonial"
        >
          <div class="aspect-square w-full overflow-hidden">
            <img
              v-if="project.image"
              :src="project.image.src"
              :srcset="project.image.srcset"
              :alt="project.image.alt"
              class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.06]"
            />
            <div v-else class="h-full w-full bg-neutral-100" />
          </div>

          <div class="p-6">
            <p class="text-label-md text-gold">{{ project.industry }}</p>
            <h3 class="mt-2 text-title-lg text-neutral-900">{{ project.title }}</h3>
            <p class="mt-2 text-body-md text-neutral-600">{{ project.excerpt }}</p>
          </div>
        </Link>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
