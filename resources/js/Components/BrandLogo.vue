<script setup lang="ts">
/**
 * Sahra brand logo.
 *
 * Figma: node 158:156 "Isolation_Mode", a 13-path vector logotype composed of
 * a gold mark (158:157) and the "SAHRA / See the HORIZON" wordmark (158:168),
 * inside the Header component (1419:9339).
 *
 * Assets are stored locally so the production header does not depend on
 * Figma's short-lived MCP URLs. The full lockup is cropped losslessly from
 * the 1440×104 Header export at its native 140×56 size; the mark is Figma's
 * direct SVG export.
 */
withDefaults(
  defineProps<{
    variant?: 'full' | 'mark'
    height?: number
    label?: string
  }>(),
  {
    variant: 'full',
    height: 48,
    label: 'Sahra',
  },
)

const sources = {
  // Vector export of Figma 158:156 — the mark is 13 paths, never rasterise it.
  full: '/icons/sahra/logo-full.svg',
  mark: '/icons/sahra/logo-mark.svg',
} as const

/** Intrinsic ratio of the exported artwork (logo-full.svg is 212×91). */
const ratios = {
  full: 212 / 91,
  mark: 1,
} as const
</script>

<template>
  <img
    :src="sources[variant]"
    :alt="label"
    :height="height"
    :width="Math.round(height * ratios[variant])"
    :aria-hidden="label === '' ? 'true' : undefined"
    class="shrink-0"
    decoding="async"
  />
</template>
