<script setup lang="ts">
/**
 * Per-page SEO head.
 *
 * Emits title, description, canonical, Open Graph, Twitter Card and JSON-LD.
 * hreflang tags are rendered server-side in app.blade.php (they must exist in
 * the initial HTML for crawlers that do not execute JS).
 *
 * Structured data emitted here:
 *   - Organization  (once, on every page — safe and expected)
 *   - WebSite
 *   - Article       (when type === 'article')
 *   - BreadcrumbList (when breadcrumbs provided)
 */
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import type { SeoMeta, SharedProps } from '@/types'

const props = withDefaults(
  defineProps<{
    meta: SeoMeta
    breadcrumbs?: { name: string; url: string }[]
  }>(),
  { breadcrumbs: () => [] },
)

const page = usePage<SharedProps>()

const settings = computed(() => page.props.settings)
const locale = computed(() => page.props.locale)

const title = computed(() => props.meta.title || settings.value.seo.defaultTitle)

const description = computed(
  () => props.meta.description || settings.value.seo.defaultDescription,
)

const image = computed(() => props.meta.image ?? settings.value.seo.defaultImage)

const organizationLd = computed(() =>
  JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'Organization',
    name: settings.value.seo.organizationName,
    url: props.meta.canonical,
    logo: image.value,
    email: settings.value.contact.email || undefined,
    telephone: settings.value.contact.phone || undefined,
    address: settings.value.contact.location
      ? { '@type': 'PostalAddress', addressLocality: settings.value.contact.location }
      : undefined,
    sameAs: settings.value.socialLinks.map((l) => l.url),
  }),
)

const articleLd = computed(() => {
  if (props.meta.type !== 'article') return null

  return JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'Article',
    headline: title.value,
    description: description.value,
    image: image.value ? [image.value] : undefined,
    datePublished: props.meta.publishedAt ?? undefined,
    dateModified: props.meta.modifiedAt ?? props.meta.publishedAt ?? undefined,
    author: props.meta.author
      ? { '@type': 'Person', name: props.meta.author }
      : { '@type': 'Organization', name: settings.value.seo.organizationName },
    publisher: {
      '@type': 'Organization',
      name: settings.value.seo.organizationName,
      logo: { '@type': 'ImageObject', url: image.value },
    },
    mainEntityOfPage: { '@type': 'WebPage', '@id': props.meta.canonical },
    inLanguage: locale.value.htmlLang,
  })
})

const breadcrumbLd = computed(() => {
  if (props.breadcrumbs.length === 0) return null

  return JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: props.breadcrumbs.map((crumb, index) => ({
      '@type': 'ListItem',
      position: index + 1,
      name: crumb.name,
      item: crumb.url,
    })),
  })
})
</script>

<template>
  <Head :title="title">
    <meta name="description" :content="description" />
    <link rel="canonical" :href="meta.canonical" />

    <meta v-if="meta.noindex" name="robots" content="noindex, nofollow" />
    <meta v-else name="robots" content="index, follow, max-image-preview:large" />

    <!-- Open Graph -->
    <meta property="og:type" :content="meta.type" />
    <meta property="og:title" :content="title" />
    <meta property="og:description" :content="description" />
    <meta property="og:url" :content="meta.canonical" />
    <meta property="og:site_name" :content="settings.siteName" />
    <meta property="og:locale" :content="locale.htmlLang.replace('-', '_')" />
    <meta v-if="image" property="og:image" :content="image" />
    <meta v-if="image" property="og:image:alt" :content="title" />

    <template v-if="meta.type === 'article'">
      <meta v-if="meta.publishedAt" property="article:published_time" :content="meta.publishedAt" />
      <meta v-if="meta.modifiedAt" property="article:modified_time" :content="meta.modifiedAt" />
      <meta v-if="meta.author" property="article:author" :content="meta.author" />
    </template>

    <!-- Twitter -->
    <meta name="twitter:card" :content="image ? 'summary_large_image' : 'summary'" />
    <meta name="twitter:title" :content="title" />
    <meta name="twitter:description" :content="description" />
    <meta v-if="image" name="twitter:image" :content="image" />

    <!-- Structured data -->
    <component :is="'script'" type="application/ld+json">{{ organizationLd }}</component>
    <component :is="'script'" v-if="articleLd" type="application/ld+json">{{ articleLd }}</component>
    <component :is="'script'" v-if="breadcrumbLd" type="application/ld+json">{{ breadcrumbLd }}</component>
  </Head>
</template>
