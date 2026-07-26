<script setup lang="ts">
/**
 * About page — Figma node 908:1576 (desktop) / 1557:12225 (mobile).
 *
 * Sections: about hero, story, how-we-think (4 principles), team grid, final
 * CTA. Section keys match App\Enums\SectionType (about_hero, story,
 * how_we_think, team) seeded by database/seeders/PageSeeder.php@about — see
 * docs/TRACEABILITY.md for the node mapping. Decorative backdrop art (arc
 * rings 951:3589, dune contours 979:1394, hero sculpture 951:3598) is not
 * exported yet (docs/ASSET-MANIFEST.md §6/§8) and is skipped this pass.
 */
import { computed } from 'vue'
import SeoHead from '@/Components/SeoHead.vue'
import CtaBanner from '@/Components/CtaBanner.vue'
import type { SeoMeta, TeamMemberItem } from '@/types'

interface SectionContent {
  eyebrow: string
  title: string
  subtitle: string
  description: string
  content: string
  colors: Record<'eyebrow' | 'title' | 'subtitle' | 'description' | 'content', string | null>
  primaryCta: { label: string; url: string } | null
  secondaryCta: { label: string; url: string } | null
  image: { src: string; alt: string; width: number; height: number } | null
  items: Array<{ value: string; title: string; description: string; icon: string | null }>
}

const props = defineProps<{
  sections: Record<string, SectionContent>
  team: TeamMemberItem[]
  seo: SeoMeta
}>()

const hero = computed(() => props.sections.about_hero)
const story = computed(() => props.sections.story)
const howWeThink = computed(() => props.sections.how_we_think)
const team = computed(() => props.sections.team)
</script>

<template>
  <SeoHead :meta="seo" />

  <!-- About hero — Figma 908:1576 (top) -->
  <section v-if="hero" class="section">
    <div class="container-sahra max-w-3xl">
      <div class="eyebrow" :style="{ color: hero.colors.eyebrow || undefined }">{{ hero.eyebrow }}</div>
      <h1 class="text-display-md" :style="{ color: hero.colors.title || undefined }">{{ hero.title }}</h1>
      <p class="mt-6 text-body-lg text-neutral-600" :style="{ color: hero.colors.description || undefined }">{{ hero.description }}</p>
    </div>
  </section>

  <!-- Story — "The Story Behind Sahra" -->
  <section v-if="story" class="section pt-0">
    <div class="container-sahra grid gap-12 lg:grid-cols-2">
      <h2 class="text-display-sm" :style="{ color: story.colors.title || undefined }">{{ story.title }}</h2>
      <div>
        <p class="text-body-lg text-neutral-700" :style="{ color: story.colors.description || undefined }">{{ story.description }}</p>
        <p class="mt-4 text-body-md text-neutral-600" :style="{ color: story.colors.content || undefined }">{{ story.content }}</p>
      </div>
    </div>
  </section>

  <!-- How we think — 4 principles -->
  <section v-if="howWeThink" class="section">
    <div class="container-sahra">
      <div class="max-w-xl">
        <h2 class="text-display-sm" :style="{ color: howWeThink.colors.title || undefined }">{{ howWeThink.title }}</h2>
        <p class="mt-4 text-body-lg text-neutral-600" :style="{ color: howWeThink.colors.description || undefined }">{{ howWeThink.description }}</p>
      </div>

      <div class="mt-11 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="(item, i) in howWeThink.items"
          :key="i"
          class="rounded-lg border border-neutral-100 p-6"
        >
          <p class="latin-nums text-title-lg text-gold">{{ String(i + 1).padStart(2, '0') }}</p>
          <h3 class="mt-4 text-title-md">{{ item.title }}</h3>
          <p class="mt-2 text-body-md text-neutral-600">{{ item.description }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Team grid — "Small Team, Big Standards" -->
  <section v-if="team" class="section">
    <div class="container-sahra">
      <div class="max-w-xl">
        <h2 class="text-display-sm" :style="{ color: team.colors.title || undefined }">{{ team.title }}</h2>
        <p class="mt-4 text-body-lg text-neutral-600" :style="{ color: team.colors.description || undefined }">{{ team.description }}</p>
      </div>

      <div class="mt-11 grid gap-8 sm:grid-cols-2 lg:grid-cols-5">
        <div v-for="(member, i) in props.team" :key="i" class="text-center">
          <img
            v-if="member.image"
            :src="member.image.src"
            :alt="member.image.alt"
            class="aspect-square w-full rounded-lg object-cover grayscale"
          />
          <div v-else class="aspect-square w-full rounded-lg bg-neutral-100" />
          <p class="mt-4 text-title-sm font-medium text-neutral-900">{{ member.name }}</p>
          <p class="text-body-md text-neutral-500">{{ member.role }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
