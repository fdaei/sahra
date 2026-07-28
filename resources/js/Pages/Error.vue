<script setup lang="ts">
/**
 * Error page — 404, 403, 429, 500, 503.
 *
 * Figma: 404 desktop 1027:2061, mobile 1567:13563.
 * Design shows a large gold "404" glyph with a sun disc, the headline
 * "Lost in the Horizon?", a supporting line, and a "Back to Home" button.
 *
 * Other status codes reuse the same layout with different copy — the design
 * has no dedicated frames for them, so this is a documented derivation
 * (see docs/FIGMA-AUDIT.md §9).
 */
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
import SeoHead from '@/Components/SeoHead.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { SharedProps } from '@/types'

const props = defineProps<{ status: number }>()

const page = usePage<SharedProps>()
const { t } = useTranslations()

const known = [403, 404, 429, 500, 503]
const key = computed(() => (known.includes(props.status) ? String(props.status) : '500'))

const title = computed(() => t(`errors.${key.value}.title`))
const message = computed(() => t(`errors.${key.value}.message`))

const homeUrl = computed(() => `/${page.props.locale.current}`)
</script>

<template>
  <SeoHead
    :meta="{
      title,
      description: message,
      image: null,
      canonical: page.props.alternates[page.props.locale.current],
      type: 'website',
      noindex: true,
    }"
  />

  <section class="section section-first">
    <div class="container-sahra flex flex-col items-center text-center">
      <!-- Decorative status glyph. The real 404 artwork is an exported asset;
           for other codes we render the numeral in the same treatment. -->
      <p
        class="latin-nums bg-gradient-to-br from-gold-400 to-gold bg-clip-text
               font-semibold leading-none text-transparent
               [font-size:clamp(5rem,20vw,10rem)]"
        aria-hidden="true"
      >
        {{ status }}
      </p>

      <h1 class="mt-8 text-display-sm md:text-display-md">{{ title }}</h1>

      <p class="mt-4 max-w-md text-body-lg text-neutral-600">{{ message }}</p>

      <Link
        :href="homeUrl"
        class="mt-10 inline-flex items-center gap-2 rounded-sm bg-ink px-8 py-4
               text-label-lg text-paper transition-opacity hover:opacity-90"
      >
        {{ t('errors.back_home') }}
        <ArrowRight class="size-4 rtl:-scale-x-100" aria-hidden="true" />
      </Link>
    </div>
  </section>
</template>
