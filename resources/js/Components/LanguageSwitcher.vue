<script setup lang="ts">
/**
 * Language switcher.
 *
 * Figma: header shows a globe + "EN" + chevron (1419:9339 region).
 *
 * Each option links to the *same page* in the target language, using the
 * hreflang alternates computed server-side by App\Support\LocaleAlternates —
 * so switching language on /en/insights/some-post lands on the Persian
 * translation of that post, not the Persian home page.
 *
 * Uses a native <details> element: keyboard accessible and closable with Esc
 * without any JS state, then enhanced with click-outside + Esc handling.
 */
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { onClickOutside, onKeyStroke } from '@vueuse/core'
import { Globe, ChevronDown, Check } from 'lucide-vue-next'
import type { SharedProps, LocaleCode } from '@/types'

const page = usePage<SharedProps>()
const root = ref<HTMLDetailsElement | null>(null)

function close(): void {
  if (root.value) root.value.open = false
}

onClickOutside(root, close)
onKeyStroke('Escape', close)

/** Full-page visit so <html lang/dir> and the font stack are re-rendered. */
function switchTo(url: string): void {
  close()
  window.location.href = url
}

function isCurrent(code: LocaleCode): boolean {
  return code === page.props.locale.current
}
</script>

<template>
  <details ref="root" class="relative">
    <summary
      class="flex cursor-pointer list-none items-center gap-2 rounded-sm px-3 py-2
             text-label-lg text-neutral-800 transition-colors hover:text-gold
             focus-visible:ring-2 focus-visible:ring-gold [&::-webkit-details-marker]:hidden"
      :aria-label="$t('common.change_language')"
    >
      <Globe class="size-4" aria-hidden="true" />
      <span class="uppercase">{{ page.props.locale.current }}</span>
      <ChevronDown class="size-4 transition-transform [details[open]_&]:rotate-180" aria-hidden="true" />
    </summary>

    <ul
      class="absolute inset-inline-end-0 top-full z-menu mt-2 min-w-44 overflow-hidden
             rounded-sm border border-neutral-100 bg-paper py-1 shadow-card"
      role="listbox"
    >
      <li v-for="option in page.props.locale.supported" :key="option.code">
        <button
          type="button"
          role="option"
          :aria-selected="isCurrent(option.code)"
          :lang="option.code"
          :dir="option.direction"
          class="flex w-full items-center justify-between gap-3 px-4 py-3 text-start
                 text-body-md transition-colors hover:bg-gold-100
                 focus-visible:bg-gold-100 focus-visible:outline-none"
          :class="isCurrent(option.code) ? 'text-gold' : 'text-neutral-800'"
          @click="switchTo(page.props.alternates[option.code])"
        >
          <span>{{ option.native }}</span>
          <Check v-if="isCurrent(option.code)" class="size-4 shrink-0" aria-hidden="true" />
        </button>
      </li>
    </ul>
  </details>
</template>
