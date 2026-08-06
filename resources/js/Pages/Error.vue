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

  <section class="section section-first h-[874px] overflow-hidden md:h-[1024px]">
    <!--
      Figma 1091:3440 — a 560x560 artwork stacked over the copy block at a
      -64 gap, so the horizon overlaps the headline. Copy block is centred at
      gap 32, its own title/message pair at gap 16.
    -->
    <div class="container-sahra flex flex-col items-center text-center">
      <!-- 1027:2062. The artwork is the 404 horizon; other status codes have
           no frame in the file, so they fall back to the numeral. -->
      <img
        v-if="status === 404"
        src="/images/sahra/404-horizon.png"
        alt=""
        width="560"
        height="560"
        class="w-full max-w-[560px]"
        aria-hidden="true"
      />
      <p
        v-else
        class="latin-nums bg-gradient-to-br from-gold-400 to-gold bg-clip-text
               font-semibold leading-none text-transparent
               [font-size:clamp(5rem,20vw,10rem)]"
        aria-hidden="true"
      >
        {{ status }}
      </p>

      <div class="flex max-w-[506px] flex-col items-center gap-8 md:-mt-16">
        <div class="flex flex-col items-center gap-4">
          <h1 class="text-heading-xl font-medium">{{ title }}</h1>
          <p class="text-title-sm font-medium text-neutral-700">{{ message }}</p>
        </div>

        <Link
          :href="homeUrl"
          class="inline-flex items-center gap-1 rounded-sm bg-ink px-8 py-4
                 text-title-lg text-paper transition-opacity hover:opacity-90"
        >
          {{ t('errors.back_home') }}
          <ArrowRight class="size-6 shrink-0 rtl:-scale-x-100" aria-hidden="true" />
        </Link>
      </div>
    </div>
  </section>
</template>
