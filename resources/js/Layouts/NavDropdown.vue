<script setup lang="ts">
/**
 * A header menu entry with a submenu — disclosure pattern (the panel holds
 * ordinary links, so Tab walks through them).
 *
 *  - Opens on mouse hover (with a short close delay so diagonal paths don't
 *    snap it shut), on click of the chevron, and on ArrowDown.
 *  - Escape closes and returns focus to the trigger; focus leaving the entry
 *    closes it; navigating closes it.
 *  - With its own URL the label stays a link and only the chevron toggles; a
 *    heading-only item (url '') is one button.
 *  - Two-level trees (category › subcategories) render as a small mega
 *    panel: each child is a column heading with its children beneath.
 *
 * Logical `start-0` keeps the panel aligned to the reading direction in RTL.
 */
import { computed, onBeforeUnmount, ref, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { ChevronDown } from 'lucide-vue-next'
import type { NavItem } from '@/types'

const props = defineProps<{
  item: NavItem
  active: boolean
  isActive: (url: string) => boolean
}>()

const page = usePage()
const open = ref(false)
const root = ref<HTMLElement | null>(null)
const trigger = ref<HTMLButtonElement | null>(null)
let closeTimer: ReturnType<typeof setTimeout> | null = null

const isMega = computed(() => props.item.children.some((c) => c.children.length > 0))
const panelId = computed(() => `nav-panel-${props.item.id}`)

function cancelClose(): void {
  if (closeTimer) clearTimeout(closeTimer)
  closeTimer = null
}

function onPointerEnter(event: PointerEvent): void {
  if (event.pointerType !== 'mouse') return
  cancelClose()
  open.value = true
}

function onPointerLeave(event: PointerEvent): void {
  if (event.pointerType !== 'mouse') return
  cancelClose()
  closeTimer = setTimeout(() => (open.value = false), 150)
}

function toggle(): void {
  cancelClose()
  open.value = !open.value
}

function onKeydown(event: KeyboardEvent): void {
  if (event.key === 'Escape' && open.value) {
    open.value = false
    trigger.value?.focus()
  } else if (event.key === 'ArrowDown' && !open.value) {
    event.preventDefault()
    open.value = true
  }
}

function onFocusOut(event: FocusEvent): void {
  if (!root.value?.contains(event.relatedTarget as Node | null)) open.value = false
}

watch(() => page.url, () => (open.value = false))
onBeforeUnmount(cancelClose)
</script>

<template>
  <li
    ref="root"
    class="relative"
    @pointerenter="onPointerEnter"
    @pointerleave="onPointerLeave"
    @keydown="onKeydown"
    @focusout="onFocusOut"
  >
    <div class="flex items-center">
      <Link
        v-if="item.url"
        :href="item.url"
        :target="item.target"
        class="flex items-center justify-center py-1 ps-1 text-title-sm font-medium transition-colors"
        :class="active ? 'text-ink' : 'text-neutral-800 hover:text-ink'"
        :aria-current="isActive(item.url) ? 'page' : undefined"
      >
        {{ item.label }}
      </Link>

      <button
        ref="trigger"
        type="button"
        class="flex items-center gap-1 rounded-xs py-1 pe-1 text-title-sm font-medium transition-colors
               focus-visible:ring-2 focus-visible:ring-gold"
        :class="[item.url ? 'ps-0.5' : 'ps-1', active ? 'text-ink' : 'text-neutral-800 hover:text-ink']"
        :aria-expanded="open"
        :aria-controls="panelId"
        :aria-label="item.url ? item.label : undefined"
        @click="toggle"
      >
        <template v-if="!item.url">{{ item.label }}</template>
        <ChevronDown
          class="size-4 transition-transform duration-200"
          :class="open ? 'rotate-180' : ''"
          aria-hidden="true"
        />
      </button>
    </div>

    <Transition
      enter-active-class="transition duration-200 ease-brand"
      enter-from-class="opacity-0 -translate-y-1"
      leave-active-class="transition duration-150"
      leave-to-class="opacity-0 -translate-y-1"
    >
      <!-- pt-3 bridges the gap so the pointer can travel into the panel. -->
      <div v-show="open" :id="panelId" class="absolute start-0 top-full z-header pt-3">
        <div
          class="rounded-md border border-neutral-100 bg-paper shadow-card"
          :class="isMega
            ? 'grid w-max max-w-[min(90vw,46rem)] grid-cols-[repeat(auto-fill,minmax(11rem,1fr))] gap-x-2 gap-y-3 p-4'
            : 'min-w-[14rem] p-2'"
        >
          <template v-if="isMega">
            <div v-for="child in item.children" :key="child.id" class="flex flex-col gap-1">
              <Link
                v-if="child.url"
                :href="child.url"
                :target="child.target"
                class="rounded-sm px-3 py-2 text-[15px] font-medium text-ink transition-colors hover:bg-neutral-100 hover:text-gold"
                :aria-current="isActive(child.url) ? 'page' : undefined"
              >
                {{ child.label }}
              </Link>
              <span v-else class="px-3 py-2 text-[15px] font-medium text-ink">{{ child.label }}</span>

              <ul v-if="child.children.length" class="ms-3 flex flex-col border-s border-neutral-100">
                <li v-for="grandchild in child.children" :key="grandchild.id">
                  <Link
                    :href="grandchild.url"
                    :target="grandchild.target"
                    class="block rounded-sm px-3 py-1.5 text-[14px] text-neutral-600 transition-colors hover:bg-neutral-100 hover:text-gold"
                    :class="isActive(grandchild.url) ? 'font-medium text-ink' : ''"
                    :aria-current="isActive(grandchild.url) ? 'page' : undefined"
                  >
                    {{ grandchild.label }}
                  </Link>
                </li>
              </ul>
            </div>
          </template>

          <ul v-else class="flex flex-col">
            <li v-for="child in item.children" :key="child.id">
              <Link
                :href="child.url"
                :target="child.target"
                class="block rounded-sm px-3 py-2.5 text-[15px] text-neutral-800 transition-colors hover:bg-neutral-100 hover:text-gold"
                :class="isActive(child.url) ? 'font-medium text-ink' : ''"
                :aria-current="isActive(child.url) ? 'page' : undefined"
              >
                {{ child.label }}
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </Transition>
  </li>
</template>
