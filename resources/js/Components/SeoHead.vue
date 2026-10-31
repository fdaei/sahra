<script setup lang="ts">
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import type { SeoMeta, SharedProps } from '@/types'

const props = defineProps<{ meta: SeoMeta }>()
const page = usePage<SharedProps>()
const alternates = computed<Record<string, string>>(() => props.meta.noindex ? {} : (page.props.alternates ?? {}))
const defaultAlternate = computed(() => alternates.value[page.props.locale?.default ?? 'en'] ?? Object.values(alternates.value)[0])
// Escape raw-text closing tags inside JSON-LD, identically to the PHP head.
const schemaJson = (data: Record<string, unknown>) => JSON.stringify(data).replace(/</g, '\\u003C')
</script>

<template>
  <Head :title="meta.title">
    <meta head-key="description" name="description" :content="meta.description" />
    <link v-if="meta.canonical" head-key="canonical" rel="canonical" :href="meta.canonical" />
    <meta head-key="robots" name="robots" :content="meta.noindex ? 'noindex, follow' : 'index, follow, max-image-preview:large'" />
    <meta head-key="og:type" property="og:type" :content="meta.type" />
    <meta head-key="og:title" property="og:title" :content="meta.title" />
    <meta head-key="og:description" property="og:description" :content="meta.description" />
    <meta v-if="meta.canonical" head-key="og:url" property="og:url" :content="meta.canonical" />
    <meta head-key="og:site_name" property="og:site_name" :content="page.props.settings?.siteName ?? 'Sahra'" />
    <meta head-key="og:locale" property="og:locale" :content="meta.ogLocale" />
    <meta v-if="meta.image" head-key="og:image" property="og:image" :content="meta.image" />
    <meta v-if="meta.image" head-key="og:image:alt" property="og:image:alt" :content="meta.title" />
    <template v-if="meta.type === 'article'">
      <meta v-if="meta.publishedAt" head-key="article:published_time" property="article:published_time" :content="meta.publishedAt" />
      <meta v-if="meta.modifiedAt" head-key="article:modified_time" property="article:modified_time" :content="meta.modifiedAt" />
      <meta v-if="meta.author" head-key="article:author" property="article:author" :content="meta.author" />
    </template>
    <meta head-key="twitter:card" name="twitter:card" :content="meta.image ? 'summary_large_image' : 'summary'" />
    <meta head-key="twitter:title" name="twitter:title" :content="meta.title" />
    <meta head-key="twitter:description" name="twitter:description" :content="meta.description" />
    <meta v-if="meta.image" head-key="twitter:image" name="twitter:image" :content="meta.image" />
    <link v-for="(url, code) in alternates" :key="code" :head-key="`alternate-${code}`" rel="alternate" :hreflang="String(code)" :href="url" />
    <link v-if="defaultAlternate" head-key="alternate-default" rel="alternate" hreflang="x-default" :href="defaultAlternate" />
    <component :is="'script'" v-for="(data, index) in meta.structuredData ?? []" :key="index" :head-key="`schema-${index}`" type="application/ld+json">{{ schemaJson(data) }}</component>
  </Head>
</template>
