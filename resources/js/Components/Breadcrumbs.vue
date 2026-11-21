<script setup lang="ts">
/**
 * Visible breadcrumb trail, rendered by AppLayout on every page that sends
 * `seo.breadcrumbs` (built by App\Support\Breadcrumbs — the same trail as
 * the BreadcrumbList JSON-LD).
 *
 * Placement: every inner page already reserves a 136–192px top inset for the
 * fixed header, which is only 96/104px tall, so the trail sits in that free
 * band instead of pushing content down. One line; scrolls horizontally on
 * narrow screens, and the current page truncates.
 *
 * RTL: the chevron is mirrored so it always points "forward".
 */
import { Link } from '@inertiajs/vue3'
import { ChevronRight } from 'lucide-vue-next'
import { useTranslations } from '@/Composables/useTranslations'
import type { Breadcrumb } from '@/types'

defineProps<{ items: Breadcrumb[] }>()

const { t } = useTranslations()
</script>

<template>
  <nav
    :aria-label="t('common.breadcrumbs')"
    class="pointer-events-none absolute inset-inline-0 top-[100px] z-20 md:top-[120px]"
  >
    <ol
      class="container-sahra pointer-events-auto flex items-center gap-1.5 overflow-x-auto whitespace-nowrap
             text-[12px] leading-normal text-neutral-500 [scrollbar-width:none] md:text-[14px]"
    >
      <li
        v-for="(item, index) in items"
        :key="item.href"
        class="flex min-w-0 items-center gap-1.5"
        :class="index === items.length - 1 ? 'shrink' : 'shrink-0'"
      >
        <ChevronRight
          v-if="index > 0"
          class="size-3.5 shrink-0 text-neutral-400 rtl:-scale-x-100"
          aria-hidden="true"
        />

        <span
          v-if="index === items.length - 1"
          aria-current="page"
          class="max-w-[60vw] truncate font-medium text-neutral-900 md:max-w-[36rem]"
        >
          {{ item.name }}
        </span>

        <Link
          v-else
          :href="item.href"
          class="rounded-xs transition-colors hover:text-gold focus-visible:ring-2 focus-visible:ring-gold"
        >
          {{ item.name }}
        </Link>
      </li>
    </ol>
  </nav>
</template>
