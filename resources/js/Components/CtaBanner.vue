<script setup lang="ts">
/**
 * Final CTA card — Figma 1419:9333 "final CTA card" (1248×483).
 * Reused, unverified in this pass beyond the token system (color/spacing),
 * on Home, Work, Single project, Services, About, and Insights.
 */
defineProps<{
  section: {
    eyebrow: string
    title: string
    description: string
    subtitle: string
    primaryCta: { label: string; url: string } | null
  }
}>()
</script>

<template>
  <section class="section">
    <div class="container-sahra">
      <div class="relative overflow-hidden rounded-lg bg-ink px-8 py-14 text-center md:px-16">
        <div class="relative z-10">
          <div class="eyebrow justify-center text-gold-500">{{ section.eyebrow }}</div>
          <h2 class="text-display-sm text-paper">{{ section.title }}</h2>
          <p class="mx-auto mt-4 max-w-md text-body-lg text-neutral-300">{{ section.description }}</p>

          <a
            v-if="section.primaryCta"
            :href="section.primaryCta.url"
            class="mt-8 inline-flex items-center gap-1 rounded-sm bg-paper px-8 py-4 text-title-md text-ink transition-opacity hover:opacity-90"
          >
            {{ section.primaryCta.label }}
          </a>

          <p v-if="section.subtitle" class="mt-8 text-label-md text-neutral-400">{{ section.subtitle }}</p>
        </div>

        <div
          class="pointer-events-none absolute -bottom-24 -end-24 size-96 rounded-full bg-gold/20 blur-3xl"
          aria-hidden="true"
        />
      </div>
    </div>
  </section>
</template>
