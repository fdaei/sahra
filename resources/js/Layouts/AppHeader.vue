<script setup lang="ts">
/**
 * Site header — rebuilt 1:1 from Figma node 1419:9339 (1440×104).
 *
 * Verified via get_design_context against the live node (not approximated):
 *   container   px-96 py-6 (Figma space96/space24), gap-[262px] logo↔nav
 *   background  backdrop-blur-[15px] bg-white/5 — ALWAYS on, not scroll-gated.
 *               (The Figma frame has no variant for a solid/transparent
 *               state; the blur-over-hero look is the only state in the file,
 *               so the earlier scroll-triggered opaque background was an
 *               invented behaviour and has been removed.)
 *   menu        gap-6 (space24) between items, each item px-1 py-1 (space4)
 *   nav text    18px / regular / #4F4C4D (black/800) inactive,
 *               18px / medium / #231F20 (primary black) active — Title/Small
 *   lang switch gap-2 p-2 rounded-xs, globe+label gap-1, 14px medium — Label/Large
 *   CTA         bg #231F20, px-6 py-3, rounded-sm (radiusSM/8px), 18px regular white
 *
 * Mobile trigger and MobileMenu panel have no dedicated Figma frame beyond
 * the hamburger icon (1530:10879) — their interaction design is derived.
 */
import { computed, ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { Menu as MenuIcon } from 'lucide-vue-next'
import BrandLogo from '@/Components/BrandLogo.vue'
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue'
import MobileMenu from '@/Layouts/MobileMenu.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { SharedProps } from '@/types'

const page = usePage<SharedProps>()
const { t } = useTranslations()

defineProps<{ minimal?: boolean }>()

const mobileOpen = ref(false)

const items = computed(() => page.props.navigation.header.filter((i) => !i.isCta))
const cta = computed(() => page.props.navigation.header.find((i) => i.isCta) ?? null)

function isActive(url: string): boolean {
  const current = new URL(page.url, window.location.origin).pathname
  const target = new URL(url, window.location.origin).pathname

  const homePath = `/${page.props.locale.current}`
  if (target === homePath) return current === homePath

  return current === target || current.startsWith(`${target}/`)
}
</script>

<template>
  <header class="fixed inset-inline-0 top-0 z-header backdrop-blur-header bg-white/5">
    <!--
      The Figma header 1419:9339 is `hug` sizing inside a 1440 frame:
      96 + logo 140 + gap 262 + objects 846 + 96 = 1440 exactly. Without a
      frame cap the row starts at the viewport edge, so past 1440 the 1248 of
      fixed content ends early and the CTA floats mid-header instead of
      landing on the 96px gutter. Same `mx-auto w-full max-w-frame` the rest
      of the site gets from `.container-sahra`.
    -->
    <div
      class="mx-auto flex w-full max-w-frame items-center px-5 py-6 lg:px-24"
      :class="minimal ? 'justify-between' : 'lg:gap-[262px]'"
    >
      <Link
        :href="`/${page.props.locale.current}`"
        class="w-[80px] shrink-0 rounded-sm focus-visible:ring-2 focus-visible:ring-gold lg:w-[140px]"
        :aria-label="page.props.settings.siteName"
      >
        <BrandLogo variant="full" :height="56" :label="page.props.settings.siteName" />
      </Link>

      <div
        class="hidden items-center lg:flex"
        :class="minimal ? 'ms-auto' : 'w-[846px] justify-between'"
      >
        <!-- menu: gap-24 (space24) — Figma "I1419:9339;159:453" -->
        <nav v-if="!minimal" :aria-label="t('common.primary_navigation')">
          <ul class="flex items-center gap-6">
            <li v-for="item in items" :key="item.id">
              <Link
                :href="item.url"
                :target="item.target"
                class="flex items-center justify-center px-1 py-1 text-title-sm transition-colors"
                :class="isActive(item.url) ? 'font-medium text-ink' : 'text-neutral-800 hover:text-ink'"
                :aria-current="isActive(item.url) ? 'page' : undefined"
              >
                {{ item.label }}
              </Link>
            </li>
          </ul>
        </nav>

        <!-- header ctas: gap-16 (space16) — Figma "I1419:9339;173:189" -->
        <div class="flex items-center justify-center gap-4">
          <LanguageSwitcher v-if="!minimal" />

          <Link
            v-if="cta"
            :href="cta.url"
            class="flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-title-sm text-paper transition-opacity hover:opacity-90"
          >
            {{ cta.label }}
          </Link>
        </div>
      </div>

      <button
        v-if="!minimal"
        type="button"
        class="touch-target ms-auto -me-2 inline-flex size-11 items-center justify-center rounded-sm text-ink lg:hidden"
        :aria-label="t('common.open_menu')"
        aria-haspopup="dialog"
        :aria-expanded="mobileOpen"
        @click="mobileOpen = true"
      >
        <MenuIcon class="size-6" aria-hidden="true" />
      </button>
    </div>
  </header>

  <MobileMenu v-model:open="mobileOpen" />
</template>
