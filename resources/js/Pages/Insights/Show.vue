<script setup lang="ts">
/**
 * Single blog article — Figma node 1352:7391 (desktop) / 1543:11175 (mobile).
 *
 * No `sections`/`heading` prop from PostController@show — everything renders
 * off `post` (PostDetail), matching ContentTransformer::postDetail exactly.
 */
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import SeoHead from '@/Components/SeoHead.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { PostDetail, SeoMeta, SharedProps } from '@/types'

const props = defineProps<{
  post: PostDetail
  seo: SeoMeta
}>()

const page = usePage<SharedProps>()
const { t } = useTranslations()

const formattedDate = computed(() => {
  if (!props.post.publishedAt) return null

  return new Intl.DateTimeFormat(page.props.locale.htmlLang, { dateStyle: 'long' }).format(
    new Date(props.post.publishedAt),
  )
})
</script>

<template>
  <SeoHead
    :meta="seo"
    :breadcrumbs="[
      { name: t('blog.related'), url: `/${page.props.locale.current}/insights` },
      { name: post.title, url: seo.canonical },
    ]"
  />

  <section class="section pb-0">
    <div class="container-sahra max-w-3xl">
      <p v-if="post.category" class="text-label-md text-gold">{{ post.category.name }}</p>
      <h1 class="mt-2 text-display-md">{{ post.title }}</h1>
      <p v-if="post.subtitle" class="mt-4 text-body-lg text-neutral-600">{{ post.subtitle }}</p>

      <div class="mt-6 flex flex-wrap items-center gap-4 border-t border-neutral-100 pt-6 text-label-md text-neutral-500">
        <span v-if="formattedDate">{{ t('blog.published_on', { date: formattedDate }) }}</span>
        <span v-if="post.readingTime" class="latin-nums">{{ t('blog.reading_time', { minutes: post.readingTime }) }}</span>
        <span v-if="post.author">{{ t('blog.written_by') }} {{ post.author.name }}</span>
      </div>
    </div>
  </section>

  <section v-if="post.image" class="section py-8">
    <div class="container-sahra max-w-3xl">
      <img
        :src="post.image.src"
        :srcset="post.image.srcset"
        :alt="post.image.alt"
        class="aspect-video w-full rounded-lg object-cover"
      />
    </div>
  </section>

  <section class="section pt-0">
    <div class="container-sahra max-w-3xl">
      <article
        class="prose prose-neutral max-w-none prose-headings:font-medium
               prose-a:text-gold prose-a:no-underline hover:prose-a:underline"
        v-html="post.content"
      />

      <div v-if="post.tags.length > 0" class="mt-11 border-t border-neutral-100 pt-8">
        <p class="mb-3 text-label-md text-neutral-500">{{ t('blog.tags') }}</p>
        <div class="flex flex-wrap gap-2">
          <span
            v-for="tag in post.tags"
            :key="tag.slug"
            class="rounded-round border border-neutral-200 px-4 py-2 text-label-md text-neutral-700"
          >
            {{ tag.name }}
          </span>
        </div>
      </div>
    </div>
  </section>

  <!-- Related — Figma "small insight" 1419:9267 -->
  <section v-if="post.related.length > 0" class="section">
    <div class="container-sahra">
      <h2 class="text-display-sm">{{ t('blog.related') }}</h2>

      <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <Link
          v-for="related in post.related"
          :key="related.slug"
          :href="related.url"
          class="group block overflow-hidden rounded-lg border border-neutral-100"
        >
          <div class="aspect-video w-full overflow-hidden">
            <img
              v-if="related.image"
              :src="related.image.src"
              :srcset="related.image.srcset"
              :alt="related.image.alt"
              class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.06]"
            />
            <div v-else class="h-full w-full bg-neutral-100" />
          </div>
          <div class="p-6">
            <h3 class="text-title-md text-neutral-900">{{ related.title }}</h3>
            <p class="mt-2 text-body-md text-neutral-600">{{ related.excerpt }}</p>
          </div>
        </Link>
      </div>
    </div>
  </section>
</template>
