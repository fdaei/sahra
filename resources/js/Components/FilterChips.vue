<script setup lang="ts">
/**
 * Filter chip row — Figma "Filters" 1363:7500. Used on Work/Index (industry)
 * and Insights/Index (category): an "All" chip plus one per item, driving a
 * GET query param. Preserves any other query params via `extraParams` and
 * always drops `page` so a filter change resets pagination.
 */
import { Link } from '@inertiajs/vue3'
import { useTranslations } from '@/Composables/useTranslations'

const props = defineProps<{
  items: { slug: string; name: string }[]
  active: string | null
  paramName: string
  basePath: string
  extraParams?: Record<string, string | null>
}>()

const { t } = useTranslations()

function hrefFor(slug: string | null): string {
  const params = new URLSearchParams()

  for (const [key, value] of Object.entries(props.extraParams ?? {})) {
    if (value) params.set(key, value)
  }

  if (slug) params.set(props.paramName, slug)

  const query = params.toString()
  return query ? `${props.basePath}?${query}` : props.basePath
}
</script>

<template>
  <div class="flex flex-wrap gap-3" role="group">
    <Link
      :href="hrefFor(null)"
      class="rounded-round border px-6 py-3 text-label-lg transition-colors"
      :class="active === null
        ? 'border-ink bg-ink text-paper'
        : 'border-neutral-200 text-neutral-800 hover:border-ink'"
    >
      {{ t('common.all') }}
    </Link>

    <Link
      v-for="item in items"
      :key="item.slug"
      :href="hrefFor(item.slug)"
      class="rounded-round border px-6 py-3 text-label-lg transition-colors"
      :class="active === item.slug
        ? 'border-ink bg-ink text-paper'
        : 'border-neutral-200 text-neutral-800 hover:border-ink'"
    >
      {{ item.name }}
    </Link>
  </div>
</template>
