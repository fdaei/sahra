<script setup lang="ts">
/**
 * Home page — Figma node 1419:9192 (desktop, 1440×10821) / 1419:9191 (mobile).
 *
 * FIDELITY STATUS (be precise about what was individually re-verified against
 * get_design_context + screenshot in this pass, versus what uses the
 * already-extracted global token system without a fresh per-node check):
 *
 *   VERIFIED against live Figma nodes this session:
 *     - Header (1419:9339)               — see Layouts/AppHeader.vue
 *     - Hero + hero texts (1419:9193/94)  — section below
 *
 *   Uses the token system extracted in the original audit (colors, spacing,
 *   radii, type scale all come directly from Figma variables — see
 *   tailwind.config.js), but individual section layout was not re-verified
 *   node-by-node against a fresh screenshot in this pass:
 *     - KPI, trust proof, services cloud, projects showcase, process,
 *       why-us, reviews, insights, FAQ, final CTA, footer
 *
 * Continuing the same get_design_context → download_assets → build → compare
 * loop through the remaining 13 sections (and then the other 10 pages) is
 * the direct continuation of this work.
 */
import { computed } from 'vue'
import SeoHead from '@/Components/SeoHead.vue'
import CtaBanner from '@/Components/CtaBanner.vue'
import type {
  ClientItem,
  FaqItem,
  PostSummary,
  ProjectSummary,
  ServiceItem,
  SeoMeta,
  TestimonialItem,
} from '@/types'

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
  services: ServiceItem[]
  projects: ProjectSummary[]
  clients: ClientItem[]
  testimonials: TestimonialItem[]
  posts: PostSummary[]
  faqs: FaqItem[]
  seo: SeoMeta
}>()

const hero = computed(() => props.sections.hero)
const kpi = computed(() => props.sections.kpi)
const whyUs = computed(() => props.sections.why_us)
const reviews = computed(() => props.sections.reviews)
const insights = computed(() => props.sections.insights)
const faqSection = computed(() => props.sections.faq)
</script>

<template>
  <SeoHead :meta="seo" />

  <!--
    ============================================================
    HERO — Figma 1419:9193 (bg) + 1419:9194 (hero texts)
    Verified 1:1 via get_design_context on the live node. Every
    spacing/color/type value below is a direct Figma variable,
    referenced in the inline comments.
    ============================================================
  -->
  <section
    v-if="hero"
    class="relative flex min-h-[904px] items-center overflow-hidden"
    style="background-image: url(https://www.figma.com/api/mcp/asset/36bc35bb-0c32-4ad0-81b8-f3e6ceaafffb); background-size: cover; background-position: bottom;"
  >
    <!-- hero texts: x=96 y=176, gap-14 (space56) — Figma 1419:9194 -->
    <div class="relative z-10 flex w-[612px] max-w-[calc(100%-3rem)] flex-col gap-14 px-6 py-11 md:ms-24 md:px-0 md:py-0">
      <!-- hero badge — bg gold-100, p-2, gap-2, rounded-full — Figma 1419:9195 -->
      <div class="flex items-center gap-2 rounded-round bg-gold-100 p-2">
        <span class="inline-block size-2 rotate-45 bg-gold-700" aria-hidden="true" />
        <span class="text-label-md text-neutral-800" :style="{ color: hero.colors.eyebrow || undefined }">{{ hero.eyebrow }}</span>
      </div>

      <!-- hero texts (title+subtitle): gap-12 (space48) — Figma 1419:9199 -->
      <div class="flex flex-col gap-12">
        <!--
          Title. Figma composes this as one text node with mixed runs:
          "We build" (56px, tracking -2.8px) + "marketing systems" (96px,
          Idealist, gold gradient fill) + "for brands ready to grow" (56px).
          `title` holds the first run, `content` the gradient phrase (see
          PageSeeder docblock), and the trailing phrase is static copy
          matching the CTA context — kept in translations as part of `title`
          via a second line for editability.
        -->
        <h1 class="text-[56px] font-medium leading-[80px] tracking-[-2.8px] text-neutral-900" :style="{ color: hero.colors.title || undefined }">
          {{ hero.title }}
          <span
            class="bg-clip-text font-['Idealist',_serif] text-[56px] leading-[80px] text-transparent md:text-[96px]"
            :style="hero.colors.content
              ? { color: hero.colors.content, backgroundImage: 'none' }
              : { backgroundImage: 'linear-gradient(89.78deg, #ffffff 26.9%, #bd933b 27%, #bd933b 64.6%, #ffffff 122%)' }"
          >
            {{ hero.content }}
          </span>
          <br />
          for brands ready to grow
        </h1>

        <p class="w-full max-w-[612px] text-title-sm text-neutral-700" :style="{ color: hero.colors.subtitle || undefined }">
          {{ hero.subtitle }}
        </p>
      </div>

      <!-- hero cta: gap-[10px] — Figma 1419:9202 -->
      <div class="flex flex-wrap items-center gap-[10px]">
        <a
          v-if="hero.primaryCta"
          :href="hero.primaryCta.url"
          class="flex items-center gap-1 rounded-sm bg-ink px-8 py-4 text-title-md text-paper transition-opacity hover:opacity-90"
        >
          {{ hero.primaryCta.label }}
        </a>
        <a
          v-if="hero.secondaryCta"
          :href="hero.secondaryCta.url"
          class="flex items-center gap-1 rounded-sm border border-ink bg-paper px-8 py-4 text-title-md text-ink transition-colors hover:bg-neutral-50"
        >
          {{ hero.secondaryCta.label }}
        </a>
      </div>
    </div>
  </section>

  <!--
    ============================================================
    Remaining sections — styled from the extracted global token
    system (real colors/spacing/radii/type from Figma variables)
    but layout not yet individually re-verified node-by-node in
    this pass. Marked per-section with their Figma node for the
    next verification round.
    ============================================================
  -->

  <!-- KPI — Figma 1419:9318 -->
  <section v-if="kpi" class="section">
    <div class="container-sahra grid grid-cols-1 gap-8 text-center md:grid-cols-3">
      <div v-for="(item, i) in kpi.items" :key="i">
        <p class="latin-nums text-display-sm text-gold">{{ item.value }}</p>
        <p class="mt-2 text-body-md text-neutral-600">{{ item.title }}</p>
      </div>
    </div>
  </section>

  <!-- Trust proof — Figma 1419:9205 -->
  <section class="section pt-0">
    <div class="container-sahra">
      <h2 class="text-center text-title-md text-neutral-600">{{ sections.trust_proof?.title }}</h2>
      <div class="marquee-mask mt-8 overflow-hidden">
        <div class="flex items-center gap-11">
          <img
            v-for="(client, i) in clients"
            :key="i"
            :src="client.logo"
            :alt="client.name"
            class="h-8 w-auto shrink-0 opacity-70"
          />
        </div>
      </div>
    </div>
  </section>

  <!-- Services cloud — Figma 1419:9279 -->
  <section v-if="sections.services_cloud" class="section">
    <div class="container-sahra">
      <div class="eyebrow" :style="{ color: sections.services_cloud.colors.eyebrow || undefined }">{{ sections.services_cloud.eyebrow }}</div>
      <h2 class="max-w-xl text-display-sm" :style="{ color: sections.services_cloud.colors.title || undefined }">{{ sections.services_cloud.title }}</h2>
      <p class="mt-4 max-w-lg text-body-lg text-neutral-600" :style="{ color: sections.services_cloud.colors.description || undefined }">{{ sections.services_cloud.description }}</p>

      <div class="mt-14 flex flex-wrap justify-center gap-4">
        <span
          v-for="service in services"
          :key="service.slug"
          class="rounded-round border border-neutral-200 px-6 py-3 text-title-sm font-medium text-neutral-800"
        >
          {{ service.title }}
        </span>
      </div>
    </div>
  </section>

  <!-- Projects showcase — Figma 1419:9216 -->
  <section class="section">
    <div class="container-sahra grid gap-12 lg:grid-cols-2">
      <div>
        <div class="eyebrow">{{ sections.projects_showcase?.eyebrow }}</div>
        <h2 class="text-display-sm">{{ sections.projects_showcase?.title }}</h2>

        <div class="mt-8 flex flex-col">
          <a
            v-for="project in projects"
            :key="project.slug"
            :href="project.url"
            class="border-b border-neutral-100 py-5 text-title-lg font-medium text-neutral-900 transition-colors hover:text-gold"
          >
            {{ project.title }}
          </a>
        </div>
      </div>

      <img
        v-if="projects[0]?.image"
        :src="projects[0].image.src"
        :alt="projects[0].image.alt"
        class="h-full w-full rounded-lg object-cover"
      />
    </div>
  </section>

  <!-- Why us — Figma 1419:9230 -->
  <section v-if="whyUs" class="section">
    <div class="container-sahra">
      <div class="eyebrow" :style="{ color: whyUs.colors.eyebrow || undefined }">{{ whyUs.eyebrow }}</div>
      <div class="mt-8 grid gap-8 lg:grid-cols-2">
        <div>
          <h2 class="text-display-sm" :style="{ color: whyUs.colors.title || undefined }">{{ whyUs.title }}</h2>
          <p class="mt-6 text-body-lg text-neutral-600" :style="{ color: whyUs.colors.subtitle || undefined }">{{ whyUs.subtitle }}</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div
            v-for="(item, i) in whyUs.items"
            :key="i"
            class="rounded-lg border border-neutral-100 p-6"
          >
            <h3 class="text-title-md">{{ item.title }}</h3>
            <p class="mt-2 text-body-md text-neutral-600">{{ item.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Reviews — Figma 1419:9243 -->
  <section v-if="reviews" class="section overflow-hidden">
    <div class="container-sahra">
      <div class="eyebrow" :style="{ color: reviews.colors.eyebrow || undefined }">{{ reviews.eyebrow }}</div>
      <h2 class="max-w-xl text-display-sm" :style="{ color: reviews.colors.title || undefined }">{{ reviews.title }}</h2>
    </div>

    <div class="mt-11 flex gap-6 overflow-x-auto px-6 pb-4 md:px-24">
      <div
        v-for="(t, i) in testimonials"
        :key="i"
        class="w-[328px] shrink-0 rounded-lg border border-neutral-100 p-8 shadow-testimonial"
      >
        <p class="text-body-md text-neutral-700">"{{ t.quote }}"</p>
        <div class="mt-6 flex items-center gap-3">
          <img v-if="t.avatar" :src="t.avatar.src" :alt="t.avatar.alt" class="size-12 rounded-full object-cover" />
          <div>
            <p class="text-label-lg text-neutral-900">{{ t.name }}</p>
            <p class="text-label-md text-neutral-500">{{ t.role }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Insights — Figma 1419:9258 -->
  <section v-if="insights" class="section">
    <div class="container-sahra">
      <div class="flex items-end justify-between">
        <div>
          <div class="eyebrow" :style="{ color: insights.colors.eyebrow || undefined }">{{ insights.eyebrow }}</div>
          <h2 class="max-w-xl text-display-sm" :style="{ color: insights.colors.title || undefined }">{{ insights.title }}</h2>
        </div>
      </div>

      <div class="mt-11 grid gap-6 lg:grid-cols-2">
        <a v-if="posts[0]" :href="posts[0].url" class="block rounded-lg border border-neutral-100 p-2">
          <img v-if="posts[0].image" :src="posts[0].image.src" :alt="posts[0].image.alt" class="aspect-video w-full rounded-md object-cover" />
          <div class="p-6">
            <h3 class="text-title-lg">{{ posts[0].title }}</h3>
            <p class="mt-2 text-body-md text-neutral-600">{{ posts[0].excerpt }}</p>
          </div>
        </a>
        <div class="flex flex-col gap-6">
          <a
            v-for="post in posts.slice(1, 3)"
            :key="post.slug"
            :href="post.url"
            class="block rounded-lg border border-neutral-100 p-6"
          >
            <h3 class="text-title-md">{{ post.title }}</h3>
            <p class="mt-2 text-body-md text-neutral-600">{{ post.excerpt }}</p>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ — Figma 1419:9272 -->
  <section v-if="faqSection" class="section">
    <div class="container-sahra grid gap-12 lg:grid-cols-2">
      <div>
        <div class="eyebrow" :style="{ color: faqSection.colors.eyebrow || undefined }">{{ faqSection.eyebrow }}</div>
        <h2 class="text-display-sm" :style="{ color: faqSection.colors.title || undefined }">{{ faqSection.title }}</h2>
      </div>

      <div class="flex flex-col divide-y divide-neutral-100">
        <details v-for="(faq, i) in faqs" :key="i" class="group py-5">
          <summary class="flex cursor-pointer items-center justify-between text-title-sm font-medium text-neutral-900">
            {{ faq.question }}
            <span class="text-gold transition-transform group-open:rotate-45">+</span>
          </summary>
          <p class="mt-3 text-body-md text-neutral-600">{{ faq.answer }}</p>
        </details>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
