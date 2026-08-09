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
 *
 * The footer uses a *different* lockup: Figma `1083:2762` inside the Footer
 * component (1419:9317) stacks the "SAHRA" wordmark (1083:2763, 87×20) over
 * the "See the HORIZON" rule (1083:2770, 87×4.6) with a 3px gap, and carries
 * no gold mark. It is not the header lockup at a smaller size — do not
 * substitute `full` for it.
 */
withDefaults(
  defineProps<{
    variant?: 'full' | 'mark' | 'footer'
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
  footer: '/icons/sahra/logo-footer.svg',
} as const

/** Intrinsic ratio of each exported artwork (logo-full.svg is 212×91). */
const ratios = {
  full: 212 / 91,
  mark: 1,
  footer: 87 / 28,
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
