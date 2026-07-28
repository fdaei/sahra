<script setup lang="ts">
/**
 * Legal page — shared template for Privacy Policy (Figma 1031:2101 / mobile
 * 1590:10953) and Terms & Conditions (1309:4891 / 1590:11500). Both render
 * the same rich-text body from a Page's translated `content` column.
 */
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SeoHead from '@/Components/SeoHead.vue'
import type { SeoMeta, SharedProps } from '@/types'

const props = defineProps<{
  title: string
  content: string
  updatedAt: string | null
  seo: SeoMeta
}>()

const page = usePage<SharedProps>()

const formattedDate = computed(() => {
  if (!props.updatedAt) return null

  return new Intl.DateTimeFormat(page.props.locale.htmlLang, { dateStyle: 'long' }).format(
    new Date(props.updatedAt),
  )
})
</script>

<template>
  <SeoHead :meta="seo" />

  <section class="section section-first">
    <div class="container-sahra max-w-3xl">
      <h1 class="text-display-md">{{ title }}</h1>
      <p v-if="formattedDate" class="mt-4 text-label-md text-neutral-500">{{ formattedDate }}</p>

      <article
        class="prose prose-neutral mt-11 max-w-none prose-headings:font-medium
               prose-a:text-gold prose-a:no-underline hover:prose-a:underline"
        v-html="content"
      />
    </div>
  </section>
</template>
