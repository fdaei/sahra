<script setup lang="ts">
/**
 * Per-page SEO head.
 *
 * Emits title, description, canonical, Open Graph, Twitter Card and JSON-LD.
 * hreflang tags are rendered server-side in app.blade.php (they must exist in
 * the initial HTML for crawlers that do not execute JS).
 *
 * Structured data comes ready-made in `meta.jsonLd` from
 * App\Services\SeoBuilder, so this component and its Blade twin
 * (resources/views/seo/head.blade.php, used when SSR is unavailable) emit the
 * same graph. Keep the tags below in step with that file.
 */
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import type { SeoMeta, SharedProps } from '@/types'

const props = defineProps<{ meta: SeoMeta }>()

const page = usePage<SharedProps>()

// SeoHead renders first on every page, including Error.vue — whose props can
// be missing `settings`/`locale` when the triggering exception happened
// before HandleInertiaRequests::share() ran (see the comment in
// Pages/Error.vue). Fall back instead of throwing and blanking the page.
const siteName = computed(() => page.props.settings?.siteName ?? 'Sahra')
const htmlLang = computed(() => page.props.locale?.htmlLang ?? 'en')

const title = computed(() => props.meta.title || page.props.settings?.seo.defaultTitle || siteName.value)

const description = computed(
  () => props.meta.description || page.props.settings?.seo.defaultDescription || '',
)

const image = computed(() => props.meta.image ?? page.props.settings?.seo.defaultImage ?? null)

const jsonLd = computed(() => (props.meta.jsonLd ?? []).map((graph) => JSON.stringify(graph)))
</script>

<template>
  <Head :title="title">
    <meta name="description" :content="description" />
    <link v-if="meta.canonical" rel="canonical" :href="meta.canonical" />

    <meta v-if="meta.noindex" name="robots" content="noindex, follow" />
    <meta v-else name="robots" content="index, follow, max-image-preview:large" />

    <!-- Open Graph -->
    <meta property="og:type" :content="meta.type" />
    <meta property="og:title" :content="title" />
    <meta property="og:description" :content="description" />
    <meta v-if="meta.canonical" property="og:url" :content="meta.canonical" />
    <meta property="og:site_name" :content="siteName" />
    <meta property="og:locale" :content="htmlLang.replace('-', '_')" />
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
    <component :is="'script'" v-for="(graph, index) in jsonLd" :key="index" type="application/ld+json">{{ graph }}</component>
  </Head>
</template>
