<script setup lang="ts">
/**
 * Single project — Figma node 1323:7541 (desktop) / 1555:10866 (mobile).
 *
 * No `sections`/`heading` prop from ProjectController@show — everything
 * renders straight off `project` (ProjectDetail), matching
 * App\Services\ContentTransformer::projectDetail exactly.
 */
import { Link } from '@inertiajs/vue3'
import { Instagram } from 'lucide-vue-next'
import SeoHead from '@/Components/SeoHead.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { ProjectDetail, SeoMeta } from '@/types'

defineProps<{
  project: ProjectDetail
  seo: SeoMeta
}>()

const { t } = useTranslations()
</script>

<template>
  <SeoHead :meta="seo" />

  <!-- Banner — Figma case-study banner (e.g. 1323:7605) -->
  <section class="relative">
    <img
      v-if="project.banner"
      :src="project.banner.src"
      :srcset="project.banner.srcset"
      :alt="project.banner.alt"
      class="aspect-[2406/1248] w-full object-cover shadow-banner"
    />
    <div v-else class="aspect-[2406/1248] w-full bg-neutral-100" />
  </section>

  <!-- Meta row — "info" component 1323:7576 -->
  <section class="section pb-0">
    <div class="container-sahra">
      <p class="text-label-md text-gold">{{ project.industry }}</p>
      <h1 class="mt-2 text-display-md">{{ project.title }}</h1>

      <div class="mt-8 flex flex-wrap gap-8 border-t border-neutral-100 pt-8 text-body-md text-neutral-600">
        <div v-if="project.year">
          <p class="text-label-md text-neutral-500">{{ t('work.year') }}</p>
          <p class="latin-nums mt-1">{{ project.year }}</p>
        </div>
        <div v-if="project.services.length > 0">
          <p class="text-label-md text-neutral-500">{{ t('work.services') }}</p>
          <p class="mt-1">{{ project.services.join(', ') }}</p>
        </div>
        <a
          v-if="project.instagram"
          :href="`https://instagram.com/${project.instagram}`"
          target="_blank"
          rel="noopener noreferrer"
          class="flex items-center gap-2 self-end hover:text-gold"
        >
          <Instagram class="size-4" aria-hidden="true" />
          {{ project.instagram }}
        </a>
      </div>
    </div>
  </section>

  <!-- Challenge -->
  <section v-if="project.challenge" class="section">
    <div class="container-sahra grid gap-12 lg:grid-cols-2">
      <h2 class="text-display-sm">{{ t('work.challenge') }}</h2>
      <div>
        <p class="text-body-lg text-neutral-700">{{ project.challenge }}</p>
        <ul v-if="project.challengePoints.length > 0" class="mt-6 flex flex-col gap-3">
          <li
            v-for="(point, i) in project.challengePoints"
            :key="i"
            class="flex items-start gap-3 text-body-md text-neutral-600"
          >
            <span class="mt-2 inline-block size-1.5 shrink-0 rounded-full bg-gold" aria-hidden="true" />
            {{ point }}
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Goals — "Goal card" 1061:2072 -->
  <section v-if="project.goals.length > 0" class="section pt-0">
    <div class="container-sahra">
      <h2 class="text-display-sm">{{ t('work.goals') }}</h2>
      <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="(card, i) in project.goals" :key="i" class="rounded-lg border border-neutral-100 p-6">
          <h3 class="text-title-md">{{ card.title }}</h3>
          <p class="mt-2 text-body-md text-neutral-600">{{ card.description }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Strategy — "Strategy card" 1323:7639 -->
  <section v-if="project.strategy.length > 0" class="section pt-0">
    <div class="container-sahra">
      <h2 class="text-display-sm">{{ t('work.strategy') }}</h2>
      <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="(card, i) in project.strategy" :key="i" class="rounded-lg border border-neutral-100 p-6">
          <h3 class="text-title-md">{{ card.title }}</h3>
          <p class="mt-2 text-body-md text-neutral-600">{{ card.description }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Deliverables -->
  <section v-if="project.deliverables.length > 0" class="section pt-0">
    <div class="container-sahra">
      <h2 class="text-display-sm">{{ t('work.deliverables') }}</h2>
      <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="(card, i) in project.deliverables" :key="i" class="rounded-lg border border-neutral-100 p-6">
          <h3 class="text-title-md">{{ card.title }}</h3>
          <p class="mt-2 text-body-md text-neutral-600">{{ card.description }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Showcase gallery -->
  <section v-if="project.showcase.length > 0" class="section pt-0">
    <div class="container-sahra grid gap-6 sm:grid-cols-2">
      <img
        v-for="(image, i) in project.showcase"
        :key="i"
        :src="image.src"
        :srcset="image.srcset"
        :alt="image.alt"
        class="w-full rounded-lg object-cover"
      />
    </div>
  </section>

  <!-- Before / after -->
  <section v-if="project.beforeAfter.before || project.beforeAfter.after" class="section pt-0">
    <div class="container-sahra grid gap-6 sm:grid-cols-2">
      <div v-if="project.beforeAfter.before">
        <p class="mb-2 text-label-md text-neutral-500">{{ t('work.before') }}</p>
        <img :src="project.beforeAfter.before.src" :alt="project.beforeAfter.before.alt" class="w-full rounded-lg object-cover" />
      </div>
      <div v-if="project.beforeAfter.after">
        <p class="mb-2 text-label-md text-neutral-500">{{ t('work.after') }}</p>
        <img :src="project.beforeAfter.after.src" :alt="project.beforeAfter.after.alt" class="w-full rounded-lg object-cover" />
      </div>
    </div>
  </section>

  <!-- Results grid -->
  <section v-if="project.results.length > 0" class="section">
    <div class="container-sahra">
      <h2 class="text-display-sm">{{ t('work.results') }}</h2>
      <p v-if="project.resultsSummary" class="mt-4 max-w-xl text-body-lg text-neutral-600">
        {{ project.resultsSummary }}
      </p>

      <div class="mt-11 grid grid-cols-2 gap-8 lg:grid-cols-4">
        <div v-for="(stat, i) in project.results" :key="i" class="text-center">
          <p class="latin-nums text-display-sm text-gold">{{ stat.value }}</p>
          <p class="mt-2 text-body-md text-neutral-600">{{ stat.label }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Next project -->
  <section v-if="project.next" class="section pt-0">
    <div class="container-sahra">
      <Link
        :href="project.next.url"
        class="flex items-center justify-between rounded-lg border border-neutral-100 p-8 transition-colors hover:border-ink"
      >
        <div>
          <p class="text-label-md text-neutral-500">{{ t('common.next') }}</p>
          <h3 class="mt-1 text-title-lg text-neutral-900">{{ project.next.title }}</h3>
        </div>
        <span class="text-gold rtl:-scale-x-100" aria-hidden="true">&rarr;</span>
      </Link>
    </div>
  </section>
</template>
