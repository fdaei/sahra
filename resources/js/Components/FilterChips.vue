<script setup lang="ts">
/**
 * Filter list — Figma "Filters" component set 542:858.
 *
 * The design is a plain text list, not a chip row: an "All" entry plus one
 * per item, driving a GET query param.
 *   selected  Poppins Regular 18 / black-1000   (542:857)
 *   default   Poppins Regular 16 / black-500    (542:859)
 *
 * `direction` picks the arrangement the frame uses:
 *   'column'  Work index 542:871 — vertical stack, gap 16, beside the heading
 *   'row'     wraps horizontally where the frame lays the same list out inline
 *
 * Preserves any other query params via `extraParams` and always drops `page`
 * so a filter change resets pagination.
 */
import { Link } from '@inertiajs/vue3'
import { useTranslations } from '@/Composables/useTranslations'

const props = withDefaults(
  defineProps<{
    items: { slug: string; name: string }[]
    active: string | null
    paramName: string
    basePath: string
    extraParams?: Record<string, string | null>
    direction?: 'row' | 'column'
  }>(),
  { direction: 'column' },
)

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

function classesFor(slug: string | null): string {
  return props.active === slug
    ? 'text-[16px] font-medium text-neutral-1000 md:text-[18px] md:font-normal'
    : 'text-[14px] font-medium text-neutral-500 hover:text-neutral-800 md:text-[16px] md:font-normal'
}
</script>

<template>
  <div
    role="group"
    class="flex gap-4"
    :class="direction === 'column'
      ? 'items-center overflow-x-auto md:items-start lg:flex-col lg:overflow-visible'
      : 'flex-wrap items-center gap-x-8'"
  >
    <Link
      :href="hrefFor(null)"
      :class="classesFor(null)"
      class="w-fit shrink-0 whitespace-nowrap rounded-xs transition-colors"
      :aria-current="active === null ? 'true' : undefined"
    >
      {{ t('common.all') }}
    </Link>

    <Link
      v-for="item in items"
      :key="item.slug"
      :href="hrefFor(item.slug)"
      :class="classesFor(item.slug)"
      class="w-fit shrink-0 whitespace-nowrap rounded-xs transition-colors"
      :aria-current="active === item.slug ? 'true' : undefined"
    >
      {{ item.name }}
    </Link>
  </div>
</template>
