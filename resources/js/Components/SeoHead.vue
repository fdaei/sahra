<script setup lang="ts">
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import type { SeoMeta, SharedProps } from '@/types'

const props = defineProps<{ meta: SeoMeta }>()
const page = usePage<SharedProps>()
const alternates = computed<Record<string, string>>(() => props.meta.noindex || (props.meta.indexableLocales && !props.meta.indexableLocales.includes(page.props.locale.current)) ? {} : Object.fromEntries(
  Object.entries(page.props.alternates ?? {}).filter(([locale]) => !props.meta.indexableLocales || props.meta.indexableLocales.includes(locale)),
))
const robots = computed(() => props.meta.robots ?? `${props.meta.noindex ? 'noindex' : 'index'}, ${props.meta.nofollow ? 'nofollow' : 'follow'}${props.meta.noindex ? '' : ', max-image-preview:large'}`)
const twitterImage = computed(() => props.meta.twitterImage ?? props.meta.socialImage ?? props.meta.image)
const defaultAlternate = computed(() => alternates.value[page.props.locale?.default ?? 'en'] ?? Object.values(alternates.value)[0])
// Escape raw-text closing tags inside JSON-LD, identically to the PHP head.
const schemaJson = (data: Record<string, unknown>) => JSON.stringify(data).replace(/</g, '\\u003C')
</script>

<template>
  <Head :title="meta.title">
    <link v-if="meta.canonical && page.props.rssFeedUrl" head-key="rss-feed" rel="alternate" type="application/rss+xml" :href="page.props.rssFeedUrl" />
    <meta head-key="description" name="description" :content="meta.description" />
    <link v-if="meta.canonical" head-key="canonical" rel="canonical" :href="meta.canonical" />
    <meta head-key="robots" name="robots" :content="robots" />
    <meta head-key="og:type" property="og:type" :content="meta.type" />
    <meta head-key="og:title" property="og:title" :content="meta.socialTitle || meta.title" />
    <meta head-key="og:description" property="og:description" :content="meta.socialDescription || meta.description" />
    <meta v-if="meta.canonical" head-key="og:url" property="og:url" :content="meta.canonical" />
    <meta head-key="og:site_name" property="og:site_name" :content="page.props.settings?.siteName ?? 'Sahra'" />
    <meta head-key="og:locale" property="og:locale" :content="meta.ogLocale" />
    <meta v-if="meta.socialImage || meta.image" head-key="og:image" property="og:image" :content="meta.socialImage || meta.image || undefined" />
    <meta v-if="(meta.socialImage || meta.image) && meta.socialImageAlt" head-key="og:image:alt" property="og:image:alt" :content="meta.socialImageAlt" />
    <meta v-if="(meta.socialImage || meta.image) && meta.socialImageWidth" head-key="og:image:width" property="og:image:width" :content="String(meta.socialImageWidth)" />
    <meta v-if="(meta.socialImage || meta.image) && meta.socialImageHeight" head-key="og:image:height" property="og:image:height" :content="String(meta.socialImageHeight)" />
    <meta v-if="(meta.socialImage || meta.image) && meta.socialImageMime" head-key="og:image:type" property="og:image:type" :content="meta.socialImageMime" />
    <template v-if="meta.type === 'article'">
      <meta v-if="meta.publishedAt" head-key="article:published_time" property="article:published_time" :content="meta.publishedAt" />
      <meta v-if="meta.modifiedAt" head-key="article:modified_time" property="article:modified_time" :content="meta.modifiedAt" />
      <meta v-if="meta.author" head-key="article:author" property="article:author" :content="meta.author" />
    </template>
    <meta head-key="twitter:card" name="twitter:card" :content="meta.twitterCard ?? (twitterImage ? 'summary_large_image' : 'summary')" />
    <meta head-key="twitter:title" name="twitter:title" :content="meta.twitterTitle || meta.socialTitle || meta.title" />
    <meta head-key="twitter:description" name="twitter:description" :content="meta.twitterDescription || meta.socialDescription || meta.description" />
    <meta v-if="twitterImage" head-key="twitter:image" name="twitter:image" :content="twitterImage" />
    <meta v-if="twitterImage && meta.twitterImageAlt" head-key="twitter:image:alt" name="twitter:image:alt" :content="meta.twitterImageAlt" />
    <link v-for="(url, code) in alternates" :key="code" :head-key="`alternate-${code}`" rel="alternate" :hreflang="String(code)" :href="url" />
    <link v-if="defaultAlternate" head-key="alternate-default" rel="alternate" hreflang="x-default" :href="defaultAlternate" />
    <component :is="'script'" v-for="(data, index) in meta.structuredData ?? []" :key="index" :head-key="`schema-${index}`" type="application/ld+json">{{ schemaJson(data) }}</component>
  </Head>
</template>
