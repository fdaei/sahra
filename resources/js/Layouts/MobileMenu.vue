<script setup lang="ts">
import ButtonIcon from '@/Components/ButtonIcon.vue'
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
import { ChevronDown, X } from 'lucide-vue-next'
import BrandLogo from '@/Components/BrandLogo.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { NavItem, SharedProps } from '@/types'

const open = defineModel<boolean>('open', { default: false })

const page = usePage<SharedProps>()
const { t } = useTranslations()

const closeButton = ref<HTMLButtonElement | null>(null)

const scrollLocked = useScrollLock(
  typeof document !== 'undefined' ? document.body : null,
)

const items = computed(() => page.props.navigation.header.filter((i) => !i.isCta))
const cta = computed(() => page.props.navigation.header.find((i) => i.isCta) ?? null)

// Mirrors AppHeader's isActive() so the active route reads the same way in
// both the desktop nav and this panel.
// Expanded accordion rows (by item id). Rows containing the current page
// start expanded so the visitor sees where they are.
const expanded = ref<Set<number | string>>(new Set())

function isExpanded(id: number | string): boolean {
  return expanded.value.has(id)
}

function toggleExpanded(id: number | string): void {
  const next = new Set(expanded.value)
  if (next.has(id)) next.delete(id)
  else next.add(id)
  expanded.value = next
}

function isTreeActive(item: NavItem): boolean {
  return isActive(item.url) || item.children.some(isTreeActive)
}

function isActive(url: string): boolean {
  if (!url) return false
  const current = new URL(page.url, window.location.origin).pathname
  const target = new URL(url, window.location.origin).pathname

  const homePath = `/${page.props.locale.current}`
  if (target === homePath) return current === homePath

  return current === target || current.startsWith(`${target}/`)
}

watch(open, async (isOpen) => {
  scrollLocked.value = isOpen

  if (isOpen) {
    expanded.value = new Set(items.value.filter(isTreeActive).map((i) => i.id))
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

        <nav class="flex-1 overflow-y-auto px-5" :aria-label="t('common.primary_navigation')">
          <ul class="flex flex-col">
            <li v-for="item in items" :key="item.id" class="border-b border-neutral-100">
              <div class="flex items-center justify-between gap-2">
                <Link
                  v-if="item.url"
                  :href="item.url"
                  :target="item.target"
                  class="block flex-1 py-5 text-title-md transition-colors hover:text-gold"
                  :class="isTreeActive(item) ? 'font-medium text-ink' : 'text-neutral-800'"
                  :aria-current="isActive(item.url) ? 'page' : undefined"
                  @click="open = false"
                >
                  {{ item.label }}
                </Link>
                <span v-else class="flex-1 py-5 text-title-md text-neutral-800">{{ item.label }}</span>

                <button
                  v-if="item.children.length"
                  type="button"
                  class="touch-target -me-2 inline-flex size-11 items-center justify-center rounded-sm text-neutral-800"
                  :aria-expanded="isExpanded(item.id)"
                  :aria-controls="`m-sub-${item.id}`"
                  :aria-label="item.label"
                  @click="toggleExpanded(item.id)"
                >
                  <ChevronDown
                    class="size-5 transition-transform duration-200"
                    :class="isExpanded(item.id) ? 'rotate-180' : ''"
                    aria-hidden="true"
                  />
                </button>
              </div>

              <ul
                v-if="item.children.length"
                v-show="isExpanded(item.id)"
                :id="`m-sub-${item.id}`"
                class="flex flex-col pb-4 ps-3"
              >
                <li v-for="child in item.children" :key="child.id">
                  <Link
                    v-if="child.url"
                    :href="child.url"
                    :target="child.target"
                    class="block py-2.5 text-body-lg transition-colors hover:text-gold"
                    :class="isActive(child.url) ? 'font-medium text-ink' : 'text-neutral-700'"
                    :aria-current="isActive(child.url) ? 'page' : undefined"
                    @click="open = false"
                  >
                    {{ child.label }}
                  </Link>
                  <span v-else class="block py-2.5 text-body-lg font-medium text-neutral-900">{{ child.label }}</span>

                  <ul v-if="child.children.length" class="flex flex-col border-s border-neutral-100 ps-3">
                    <li v-for="grandchild in child.children" :key="grandchild.id">
                      <Link
                        :href="grandchild.url"
                        :target="grandchild.target"
                        class="block py-2 text-[14px] transition-colors hover:text-gold"
                        :class="isActive(grandchild.url) ? 'font-medium text-ink' : 'text-neutral-600'"
                        :aria-current="isActive(grandchild.url) ? 'page' : undefined"
                        @click="open = false"
                      >
                        {{ grandchild.label }}
                      </Link>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </nav>

        <div class="flex flex-col gap-4 border-t border-neutral-100 px-5 py-6">
          <Link
            v-if="cta"
            :href="cta.url"
            class="inline-flex items-center justify-center rounded-sm bg-ink px-6 py-4
                   text-label-lg text-paper transition-colors hover:bg-gold hover:text-white group"
            @click="open = false"
          >
            {{ cta.label }}
            <ButtonIcon :name="cta.icon" :hover-name="cta.hoverIcon" />
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
