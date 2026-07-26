<script setup lang="ts">
/**
 * Blog listing — Figma node 1353:7935 (desktop) / 1530:10875 (mobile).
 *
 * The featured card (1419:9265) is only present on an unfiltered first page
 * per PostController@index — rendering is a straight `v-if="featured"`.
 */
import { computed, onBeforeUnmount, ref, watch } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import CtaBanner from '@/Components/CtaBanner.vue'
import FilterChips from '@/Components/FilterChips.vue'
import SeoHead from '@/Components/SeoHead.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { PostSummary, SeoMeta, SharedProps } from '@/types'

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
  featured: PostSummary | null
  posts: {
    data: PostSummary[]
    currentPage: number
    lastPage: number
    total: number
    nextPageUrl: string | null
    prevPageUrl: string | null
  }
  categories: { slug: string; name: string }[]
  filters: { category: string | null; q: string | null }
  sections: Record<string, SectionContent>
  seo: SeoMeta
}>()

const page = usePage<SharedProps>()
const { t } = useTranslations()

const basePath = computed(() => `/${page.props.locale.current}/insights`)
const search = ref(props.filters.q ?? '')

let debounceHandle: ReturnType<typeof setTimeout> | undefined

watch(search, (value) => {
  clearTimeout(debounceHandle)

  debounceHandle = setTimeout(() => {
    const params = new URLSearchParams()
    if (props.filters.category) params.set('category', props.filters.category)
    if (value) params.set('q', value)

    router.get(basePath.value + (params.toString() ? `?${params.toString()}` : ''), {}, {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    })
  }, 350)
})

onBeforeUnmount(() => clearTimeout(debounceHandle))
</script>

<template>
  <SeoHead :meta="seo" />

  <!-- Insights heading — Figma "Main title & tag" 1363:7520 -->
  <section class="section pb-0">
    <div class="container-sahra max-w-2xl">
      <div class="eyebrow">{{ heading.eyebrow }}</div>
      <h1 class="text-display-md">{{ heading.title }}</h1>
      <p class="mt-6 text-body-lg text-neutral-600">{{ heading.description }}</p>
    </div>
  </section>

  <!-- Search + filters -->
  <section class="section pb-0 pt-8">
    <div class="container-sahra flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
      <FilterChips
        v-if="categories.length > 0"
        :items="categories"
        :active="filters.category"
        param-name="category"
        :base-path="basePath"
        :extra-params="{ q: filters.q }"
      />

      <label class="relative w-full max-w-xs">
        <span class="sr-only">{{ t('common.search') }}</span>
        <input
          v-model="search"
          type="search"
          :placeholder="t('common.search')"
          class="w-full rounded-round border border-neutral-200 px-5 py-3 text-body-md focus:border-ink"
        />
      </label>
    </div>
  </section>

  <!-- Featured card — "Big insight" 1419:9265 -->
  <section v-if="featured" class="section pb-0">
    <div class="container-sahra">
      <Link
        :href="featured.url"
        class="group grid gap-8 overflow-hidden rounded-lg border border-neutral-100 lg:grid-cols-2"
      >
        <div class="aspect-video w-full overflow-hidden lg:aspect-auto">
          <img
            v-if="featured.image"
            :src="featured.image.src"
            :srcset="featured.image.srcset"
            :alt="featured.image.alt"
            class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.06]"
          />
          <div v-else class="h-full w-full bg-neutral-100" />
        </div>
        <div class="flex flex-col justify-center p-8">
          <p v-if="featured.category" class="text-label-md text-gold">{{ featured.category.name }}</p>
          <h2 class="mt-2 text-title-lg text-neutral-900">{{ featured.title }}</h2>
          <p class="mt-3 text-body-md text-neutral-600">{{ featured.excerpt }}</p>
        </div>
      </Link>
    </div>
  </section>

  <!-- Post grid — "small insight" 1419:9267 -->
  <section class="section">
    <div class="container-sahra">
      <p v-if="posts.data.length === 0" class="text-center text-body-lg text-neutral-500">
        {{ filters.category || filters.q ? t('common.empty_results') : t('common.empty_posts') }}
      </p>

      <div v-else class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <Link
          v-for="post in posts.data"
          :key="post.slug"
          :href="post.url"
          class="group block overflow-hidden rounded-lg border border-neutral-100"
        >
          <div class="aspect-video w-full overflow-hidden">
            <img
              v-if="post.image"
              :src="post.image.src"
              :srcset="post.image.srcset"
              :alt="post.image.alt"
              class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.06]"
            />
            <div v-else class="h-full w-full bg-neutral-100" />
          </div>
          <div class="p-6">
            <p v-if="post.category" class="text-label-md text-gold">{{ post.category.name }}</p>
            <h3 class="mt-2 text-title-md text-neutral-900">{{ post.title }}</h3>
            <p class="mt-2 text-body-md text-neutral-600">{{ post.excerpt }}</p>
          </div>
        </Link>
      </div>

      <!-- Pagination -->
      <div v-if="posts.prevPageUrl || posts.nextPageUrl" class="mt-11 flex items-center justify-center gap-4">
        <Link
          v-if="posts.prevPageUrl"
          :href="posts.prevPageUrl"
          class="rounded-sm border border-neutral-200 px-6 py-3 text-label-lg text-neutral-800 hover:border-ink"
        >
          {{ t('common.previous') }}
        </Link>
        <Link
          v-if="posts.nextPageUrl"
          :href="posts.nextPageUrl"
          class="rounded-sm bg-ink px-6 py-3 text-label-lg text-paper transition-opacity hover:opacity-90"
        >
          {{ t('common.load_more') }}
        </Link>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
