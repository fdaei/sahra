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
import type { SharedProps } from '@/types'

const page = usePage<SharedProps>()

const flash = computed(() => page.props.flash)
const isErrorPage = computed(() => page.component === 'Error')

// Announce flash messages to screen readers when they appear.
const announcement = computed(() => flash.value.success ?? flash.value.error ?? '')
</script>

<template>
  <AppHeader :minimal="isErrorPage" />

  <!--
    The header is a fixed, translucent overlay in every Figma frame — the hero
    image on Home runs to y=0 behind it (1419:9193 is 1440×904 at 0,0). So
    `main` carries no header offset; each page's first section reproduces the
    top inset its frame specifies (Home 176, listing pages 192).
  -->
  <main id="main" class="min-h-screen-safe">
    <Transition
      mode="out-in"
      enter-active-class="transition-[opacity,transform] duration-300 ease-brand"
      enter-from-class="opacity-0 translate-y-2"
      leave-active-class="transition-opacity duration-150"
      leave-to-class="opacity-0"
    >
      <div :key="page.component">
        <slot />
      </div>
    </Transition>
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
      v-if="flash.success || flash.error"
      class="fixed inset-inline-0 bottom-6 z-modal mx-auto w-fit max-w-[90vw] rounded-sm
             px-6 py-4 text-body-md shadow-card pb-safe"
      :class="flash.success ? 'bg-ink text-paper' : 'bg-red-600 text-white'"
    >
      {{ flash.success ?? flash.error }}
    </div>
  </Transition>
</template>
