<script setup lang="ts">
/**
 * Base layout applied to every page (assigned in app.ts).
 *
 * Holds the header, the main landmark, the footer, and a polite live region
 * for flash messages. Animation A12 (page transition) is a CSS transition on
 * the <main> keyed by the Inertia page component, so it also degrades cleanly
 * under prefers-reduced-motion.
 */
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppHeader from '@/Layouts/AppHeader.vue'
import AppFooter from '@/Layouts/AppFooter.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import { useAutoReveal } from '@/Composables/useMotion'
import { useTranslations } from '@/Composables/useTranslations'
import type { Breadcrumb, SchemaBlocks, SharedProps } from '@/types'

const page = usePage<SharedProps>()
const { t } = useTranslations()
const schemaBlocks = computed<SchemaBlocks | undefined>(() =>
  (page.props as { seo?: { schemaBlocks?: SchemaBlocks } }).seo?.schemaBlocks,
)

// Falls back when `flash` wasn't shared — see the comment in Pages/Error.vue.
const flash = computed(() => page.props.flash ?? { success: null, error: null })
const isErrorPage = computed(() => page.component === 'Error')

// Every page passes `seo`; only inner pages carry a trail (Breadcrumbs.vue).
const breadcrumbs = computed<Breadcrumb[]>(() =>
  isErrorPage.value
    ? []
    : ((page.props as { seo?: { breadcrumbs?: Breadcrumb[] } }).seo?.breadcrumbs ?? []),
)

/*
 | A7b — the shared scroll reveal, applied here so EVERY page gets it rather
 | than only the ones that remembered to tag elements with [data-reveal].
 | Keyed on the page component: this layout persists across Inertia
 | navigations, so the composable has to re-scan when the page swaps.
 */
useAutoReveal(computed(() => page.component))

// Announce flash messages to screen readers when they appear.
const announcement = computed(() => flash.value.success ?? flash.value.error ?? '')

function notifyPageEntered(): void {
  window.dispatchEvent(new Event('sahra:page-entered'))
}
</script>

<template>
  <AppHeader :minimal="isErrorPage" />

  <!--
    The header is a fixed, translucent overlay in every Figma frame — the hero
    image on Home runs to y=0 behind it (1419:9193 is 1440×904 at 0,0). So
    `main` carries no header offset; each page's first section reproduces the
    top inset its frame specifies (Home 176, listing pages 192).
  -->
  <main id="main" class="relative min-h-screen-safe">
    <Breadcrumbs v-if="breadcrumbs.length > 1" :key="page.url" :items="breadcrumbs" />

    <Transition
      mode="out-in"
      enter-active-class="transition-[opacity,transform] duration-300 ease-brand"
      enter-from-class="opacity-0 translate-y-2"
      leave-active-class="transition-opacity duration-150"
      leave-to-class="opacity-0"
      @after-enter="notifyPageEntered"
    >
      <div :key="page.component">
        <slot />
      </div>
    </Transition>

    <div v-if="schemaBlocks && (schemaBlocks.steps.length || schemaBlocks.faqs.length)" class="container-sahra py-12 md:py-20">
      <section v-if="schemaBlocks.steps.length" class="prose prose-neutral max-w-none">
        <h2>{{ schemaBlocks.howtoTitle }}</h2>
        <ol>
          <li v-for="(step, index) in schemaBlocks.steps" :key="index"><h3>{{ step.name }}</h3><p class="whitespace-pre-line">{{ step.text }}</p></li>
        </ol>
      </section>
      <section v-if="schemaBlocks.faqs.length" class="prose prose-neutral max-w-none">
        <h2>{{ t('blog.schema_faq_heading') }}</h2>
        <div v-for="(faq, index) in schemaBlocks.faqs" :key="index"><h3>{{ faq.question }}</h3><p class="whitespace-pre-line">{{ faq.answer }}</p></div>
      </section>
    </div>
  </main>

  <AppFooter v-if="!isErrorPage" />

  <!-- Flash region. aria-live so success/error is announced without focus. -->
  <div
    role="status"
    aria-live="polite"
    aria-atomic="true"
    class="sr-only"
  >
    {{ announcement }}
  </div>

  <Transition
    enter-active-class="transition-all duration-300 ease-brand"
    enter-from-class="translate-y-4 opacity-0"
    leave-active-class="transition-all duration-200"
    leave-to-class="translate-y-4 opacity-0"
  >
    <div
      v-if="(flash.success && page.component !== 'Contact') || flash.error"
      class="fixed inset-inline-0 bottom-6 z-modal mx-auto w-fit max-w-[90vw] rounded-sm
             px-6 py-4 text-body-md shadow-card pb-safe"
      :class="flash.success ? 'bg-ink text-paper' : 'bg-red-600 text-white'"
    >
      {{ flash.success ?? flash.error }}
    </div>
  </Transition>
</template>
