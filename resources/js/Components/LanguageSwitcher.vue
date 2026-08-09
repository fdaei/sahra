<script setup lang="ts">
/**
 * Language switcher.
 *
 * Figma: header shows a globe + the *native* language name + chevron —
 * "English" on 1419:9339 (en), "العربية" on 1365:10094 (ar). Not the ISO
 * code: rendering `locale.current` printed "AR"/"FA" instead.
 *
 * Each option links to the *same page* in the target language, using the
 * hreflang alternates computed server-side by App\Support\LocaleAlternates —
 * so switching language on /en/insights/some-post lands on the Persian
 * translation of that post, not the Persian home page.
 *
 * Uses a native <details> element: keyboard accessible and closable with Esc
 * without any JS state, then enhanced with click-outside + Esc handling.
 */
import { computed, ref } from 'vue'
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

function isCurrent(code: LocaleCode): boolean {
  return code === page.props.locale.current
}

/** Falls back to the code so a locale missing from `supported` still labels. */
const currentLabel = computed(
  () =>
    page.props.locale.supported.find((o) => isCurrent(o.code))?.native
    ?? page.props.locale.current.toUpperCase(),
)
</script>

<template>
  <details ref="root" class="relative">
    <summary
      class="flex cursor-pointer list-none items-center gap-2 rounded-xs p-2
             text-label-lg text-neutral-800 transition-colors hover:text-gold
             focus-visible:ring-2 focus-visible:ring-gold [&::-webkit-details-marker]:hidden"
      :aria-label="$t('common.change_language')"
    >
      <span class="flex items-center gap-1">
        <Globe class="size-5" aria-hidden="true" />
        <span>{{ currentLabel }}</span>
      </span>
      <ChevronDown class="size-5 transition-transform [details[open]_&]:rotate-180" aria-hidden="true" />
    </summary>

    <!--
      Real <a href> links, not buttons driving window.location: these are
      navigations, so they must be middle-clickable, open-in-new-tab-able and
      visible to crawlers. A plain anchor also gives the full page load this
      needs (Inertia's <Link> would not re-render <html lang/dir>).

      No listbox/option roles — this is a disclosure of links, not a select.
      role="option" also requires option elements to be direct children of the
      listbox, which the <li> wrappers broke.
    -->
    <ul
      class="absolute inset-inline-end-0 top-full z-menu mt-2 min-w-44 overflow-hidden
             rounded-sm border border-neutral-100 bg-paper py-1 shadow-card"
    >
      <li v-for="option in page.props.locale.supported" :key="option.code">
        <a
          :href="page.props.alternates[option.code]"
          :lang="option.code"
          :dir="option.direction"
          :aria-current="isCurrent(option.code) ? 'true' : undefined"
          class="flex w-full items-center justify-between gap-3 px-4 py-3 text-start
                 text-body-md transition-colors hover:bg-gold-100
                 focus-visible:bg-gold-100 focus-visible:outline-none"
          :class="isCurrent(option.code) ? 'text-gold' : 'text-neutral-800'"
          @click="close"
        >
          <span>{{ option.native }}</span>
          <Check v-if="isCurrent(option.code)" class="size-4 shrink-0" aria-hidden="true" />
        </a>
      </li>
    </ul>
  </details>
</template>
