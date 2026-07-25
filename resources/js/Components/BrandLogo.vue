<script setup lang="ts">
/**
 * Sahra brand logo.
 *
 * Figma: node 158:156 "Isolation_Mode", a 13-path vector logotype composed of
 * a gold mark (158:157) and the "SAHRA / See the HORIZON" wordmark (158:168),
 * inside the Header component (1419:9339).
 *
 * Asset status: exported directly from Figma via download_assets (flattened,
 * single-file SVG per variant — not the 21 individual vector fragments).
 * These are Figma's temporary CDN URLs (~7 day expiry, see
 * docs/ASSET-MANIFEST.md §1) — swap for the locally-saved files at
 * resources/images/branding/ once exported through the Figma UI or the
 * asset-export script for a permanent copy.
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

// Figma export URLs (download_assets, 2026-07-23). Temporary — see note above.
const sources = {
  full: 'https://www.figma.com/api/mcp/asset/c30a0d3b-9ff2-4e47-afdb-12bbedd96924',
  mark: 'https://www.figma.com/api/mcp/asset/fb56072f-9d01-45bc-b535-8238cc549766',
} as const

/** Intrinsic ratio measured from the Figma header instance (140×56). */
const ratios = {
  full: 140 / 56,
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
