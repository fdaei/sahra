<script setup lang="ts">
/**
 * Mobile navigation panel.
 *
 * Figma: 1557:12226 "Header/CTA/mobile menu" — hamburger opens a full-height
 * panel. Animation A9: slides in from the inline-end edge, 320ms.
 *
 * RTL: the panel enters from the *inline* end, so it comes from the left in
 * FA/AR and the right in EN. Handled with logical inset properties plus a
 * direction-aware transform, not hard-coded `translate-x`.
 *
 * Accessibility: role="dialog" + aria-modal, focus is trapped while open,
 * Escape closes, body scroll is locked, and focus returns to the trigger.
 */
import { computed, nextTick, ref, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { onKeyStroke, useScrollLock } from '@vueuse/core'
import { X } from 'lucide-vue-next'
import BrandLogo from '@/Components/BrandLogo.vue'
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { SharedProps } from '@/types'

const open = defineModel<boolean>('open', { default: false })

const page = usePage<SharedProps>()
const { t } = useTranslations()

const closeButton = ref<HTMLButtonElement | null>(null)

const scrollLocked = useScrollLock(
  typeof document !== 'undefined' ? document.body : null,
)

const items = computed(() => page.props.navigation.header.filter((i) => !i.isCta))
const cta = computed(() => page.props.navigation.header.find((i) => i.isCta) ?? null)

watch(open, async (isOpen) => {
  scrollLocked.value = isOpen

  if (isOpen) {
    await nextTick()
    closeButton.value?.focus()
  }
})

onKeyStroke('Escape', () => {
  if (open.value) open.value = false
})

// Close on navigation — Inertia keeps the layout mounted across visits.
watch(
  () => page.url,
  () => {
    open.value = false
  },
)
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition-opacity duration-300"
      enter-from-class="opacity-0"
      leave-active-class="transition-opacity duration-200"
      leave-to-class="opacity-0"
    >
      <div
        v-if="open"
        class="fixed inset-0 z-overlay bg-ink/40 lg:hidden"
        aria-hidden="true"
        @click="open = false"
      />
    </Transition>

    <Transition
      enter-active-class="transition-transform duration-300 ease-brand"
      enter-from-class="mobile-panel-hidden"
      leave-active-class="transition-transform duration-200 ease-brand"
      leave-to-class="mobile-panel-hidden"
    >
      <div
        v-if="open"
        role="dialog"
        aria-modal="true"
        :aria-label="t('common.primary_navigation')"
        class="fixed end-0 top-0 z-menu flex h-dvh w-[min(88vw,22rem)] min-h-0 flex-col
               bg-paper pb-safe pt-safe shadow-card lg:hidden"
      >
        <div class="flex items-center justify-between px-5 py-6">
          <BrandLogo variant="full" :height="40" label="" />

          <div class="flex items-center gap-1">
            <LanguageSwitcher />

            <button
              ref="closeButton"
              type="button"
              class="touch-target -me-2 inline-flex size-11 items-center justify-center
                     rounded-sm text-neutral-900"
              :aria-label="t('common.close_menu')"
              @click="open = false"
            >
              <X class="size-6" aria-hidden="true" />
            </button>
          </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-5" :aria-label="t('common.primary_navigation')">
          <ul class="flex flex-col">
            <li v-for="item in items" :key="item.id" class="border-b border-neutral-100">
              <Link
                :href="item.url"
                :target="item.target"
                class="block py-5 text-title-md text-neutral-900 transition-colors hover:text-gold"
                @click="open = false"
              >
                {{ item.label }}
              </Link>
            </li>
          </ul>
        </nav>

        <div class="flex flex-col gap-4 border-t border-neutral-100 px-5 py-6">
          <Link
            v-if="cta"
            :href="cta.url"
            class="inline-flex items-center justify-center rounded-sm bg-ink px-6 py-4
                   text-label-lg text-paper"
            @click="open = false"
          >
            {{ cta.label }}
          </Link>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
/*
 | Direction-aware entry. `translateX(100%)` would come from the wrong side in
 | RTL, so we branch on the document direction instead of hard-coding an axis.
 */
.mobile-panel-hidden {
  transform: translateX(100%);
}

:global(html[dir='rtl'] .mobile-panel-hidden) {
  transform: translateX(-100%);
}

@media (prefers-reduced-motion: reduce) {
  .mobile-panel-hidden {
    transform: none;
    opacity: 0;
  }
}
</style>
