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
 *     - Services orbit (1419:9279)         — Components/Services/ServicesOrbit.vue
 *     - KPI, process, why-us, reviews,
 *       insights and FAQ card components   — sections below
 *
 *   Uses the token system extracted in the original audit (colors, spacing,
 *   radii, type scale all come directly from Figma variables — see
 *   tailwind.config.js), but individual section layout was not re-verified
 *   node-by-node against a fresh screenshot in this pass:
 *     - trust proof, projects showcase, final CTA, footer
 *
 * Continuing the same get_design_context → download_assets → build → compare
 * loop through the remaining 13 sections (and then the other 10 pages) is
 * the direct continuation of this work.
 */
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
  ArrowUpRight,
  BadgeCheck,
  CalendarDays,
  ClipboardCheck,
  Gem,
  Minus,
  PanelsTopLeft,
  Plus,
  TrendingUp,
  UsersRound,
} from "lucide-vue-next";
import {
  useCounters,
  useHeroStagger,
  useSectionReveal,
} from "@/Composables/useMotion";
import SeoHead from "@/Components/SeoHead.vue";
import CtaBanner from "@/Components/CtaBanner.vue";
import ServicesOrbit from "@/Components/Services/ServicesOrbit.vue";
import LeadMagnet from "@/Components/Sections/LeadMagnet.vue";
import PackagesSection from "@/Components/Sections/PackagesSection.vue";
import ProcessSection from "@/Components/Sections/ProcessSection.vue";
import ProjectsShowcase from "@/Components/Sections/ProjectsShowcase.vue";
import type {
  ClientItem,
  FaqItem,
  PostSummary,
  ProjectSummary,
  ServiceItem,
  SeoMeta,
  SharedProps,
  TestimonialItem,
} from "@/types";

interface SectionItemContent {
  id: number;
  value: string;
  label: string;
  suffix: string;
  title: string;
  description: string;
  badge: string;
  features: string[];
  footer: string;
  icon: string | null;
}

interface SectionContent {
  type: string;
  eyebrow: string;
  title: string;
  subtitle: string;
  description: string;
  content: string;
  colors: Record<
    "eyebrow" | "title" | "subtitle" | "description" | "content",
    string | null
  >;
  primaryCta: { label: string; url: string } | null;
  secondaryCta: { label: string; url: string } | null;
  image: { src: string; alt: string; width: number; height: number } | null;
  items: SectionItemContent[];
}

const props = defineProps<{
  sections: Record<string, SectionContent>;
  services: ServiceItem[];
  projects: ProjectSummary[];
  clients: ClientItem[];
  testimonials: TestimonialItem[];
  posts: PostSummary[];
  faqs: FaqItem[];
  seo: SeoMeta;
}>();

const page = usePage<SharedProps>();
const hero = computed(() => props.sections.hero);
const kpi = computed(() => props.sections.kpi);
const process = computed(() => props.sections.process);
const packages = computed(() => props.sections.packages);
const whyUs = computed(() => props.sections.why_us);
const reviews = computed(() => props.sections.reviews);
const insights = computed(() => props.sections.insights);
const faqSection = computed(() => props.sections.faq);
const insightsSubtitle = computed(() => {
  if (insights.value?.description || insights.value?.subtitle) {
    return insights.value.description || insights.value.subtitle;
  }

  return {
    en: "Because every creative decision is built around brand clarity, consistency, and growth.",
    fa: "چون هر تصمیم خلاقانه بر شفافیت، انسجام و رشد برند استوار است.",
    ar: "لأن كل قرار إبداعي يقوم على وضوح العلامة واتساقها ونموها.",
  }[page.props.locale.current];
});

/*
 | Testimonial marquee track (A6).
 |
 | The animation translates the track -50%, which requires it to be exactly
 | two identical halves. A half must also be wider than the viewport or the
 | row visibly runs out mid-loop — the design shows 7 cards, but the seeded
 | data can hold as few as 1, so each half repeats the source list until it
 | covers a wide desktop (card 328 + gap 24 = 352 per item).
 */
const testimonialTrack = computed(() => {
  const source = props.testimonials;
  if (source.length === 0) return [];

  const perHalf = Math.max(1, Math.ceil(2560 / 352 / source.length));
  const half = Array.from({ length: perHalf }, () => source).flat();

  return [...half, ...half];
});

const whyUsIcons = [BadgeCheck, PanelsTopLeft, Gem, ClipboardCheck];
const kpiIcons = [TrendingUp, TrendingUp, UsersRound];

/*
 | Motion — audit A1 (hero stagger), A3 (KPI counters), A7 (section reveal).
 | The composables no-op under reduced motion and revert on unmount, so
 | ScrollTriggers do not survive an Inertia page swap.
 */
const heroStack = ref<HTMLElement | null>(null);

useHeroStagger(heroStack);
useCounters();
useSectionReveal();
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
  <!--
    Hero img 1419:9193 is 1440×904 anchored at (0,0) — it runs full-bleed
    behind the fixed header. Hero texts 1419:9194 sit at x=96 / y=176.
  -->
  <section
    v-if="hero"
    class="relative min-h-[560px] overflow-hidden md:min-h-[904px]"
    style="
      background-image: url(&quot;/images/sahra/hero-brand-preview.png&quot;);
      background-size: cover;
      background-position: bottom;
    "
  >
    <!-- hero texts: x=96 y=176, gap-14 (space56) — Figma 1419:9194 -->
    <!-- A1: the three direct children (badge / texts / CTAs) stagger in on load. -->
    <div
      ref="heroStack"
      class="relative z-10 flex w-[731px] max-w-[calc(100%-3rem)] flex-col gap-14 px-6 pb-11 pt-[120px] md:ms-24 md:px-0 md:pb-0 md:pt-[176px]"
    >
      <!--
        hero badge — Figma 1419:9195: row, padding 8, gap 8, radius 1000,
        fill gold/100. `hug` sizing, so the pill must not stretch.
      -->
      <div class="flex w-fit items-center gap-2 rounded-round bg-gold-100 p-2">
        <span
          class="inline-block size-2 rotate-45 bg-gold-700"
          aria-hidden="true"
        />
        <span
          class="text-label-md text-neutral-800"
          :style="{ color: hero.colors.eyebrow || undefined }"
          >{{ hero.eyebrow }}</span
        >
      </div>

      <!-- hero texts (title+subtitle): gap-12 (space48) — Figma 1419:9199 -->
      <div class="flex flex-col gap-12">
        <!--
          Title — Figma 1419:9200. One text node, three runs over a
          Poppins Medium 48 / 80px line-height / -0.05em base:
            ts1  "We build "          56px
            ts2  "marketing systems"  Idealist 96px, 90deg gold gradient
            ts1  "for brands ready to grow"  56px
          Runs are kept as separate translatable fields (title / content /
          description) so each locale can reorder them.
        -->
        <h1
          class="text-[48px] font-medium leading-[80px] tracking-[-0.05em] text-neutral-900"
          :style="{ color: hero.colors.title || undefined }"
        >
          <span class="block text-[36px] md:text-[56px]">{{ hero.title }}</span>
          <!--
            The gradient run is `w-fit` so the 90deg ramp is measured across
            the glyphs, as in Figma, rather than across the 731px column.
          -->
          <span
            class="block w-fit bg-clip-text font-display text-[56px] leading-[80px] tracking-normal text-transparent md:text-[96px]"
            :style="
              hero.colors.content
                ? { color: hero.colors.content, backgroundImage: 'none' }
                : {
                    backgroundImage:
                      'linear-gradient(90deg, #ffffff 0%, #bd933b 27%, #bd933b 65%, #ffffff 100%)',
                  }
            "
            >{{ hero.content }}</span
          >
          <span class="block text-[36px] md:text-[56px]">{{
            hero.description
          }}</span>
        </h1>

        <!-- Subtitle — Figma 1419:9201: Poppins Medium 18, black/700, w 612 -->
        <p
          class="w-full max-w-[612px] text-[18px] font-medium leading-[1.4] text-neutral-700"
          :style="{ color: hero.colors.subtitle || undefined }"
        >
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

  <!--
    KPI — Figma 1419:9318. Row of 3, gap 16, section width 1036.
    Card 1419:9319: column, padding 24/12, gap 8, radius 8, fill #FFFFFF,
    1px OUTSIDE gradient stroke (see `.edge-gold`).
  -->
  <section v-if="kpi" class="section">
    <div
      class="container-narrow grid grid-cols-1 gap-4 text-center md:grid-cols-3"
      data-reveal-group
    >
      <div
        v-for="(item, i) in kpi.items"
        :key="i"
        class="edge-gold will-reveal flex flex-col items-center justify-center gap-2 rounded-sm px-3 py-6"
        data-reveal
      >
        <div class="flex items-center justify-center gap-4">
          <component
            :is="kpiIcons[i] || TrendingUp"
            class="size-8 text-gold"
            :stroke-width="1.5"
          />
          <!-- A3: counts up to the authored value; the DOM text stays the
               source of truth so the number is right without JS. -->
          <p
            class="latin-nums text-[32px] font-medium leading-none text-ink"
            data-counter
          >
            {{ item.value }}
          </p>
        </div>
        <div class="flex flex-col items-center gap-1">
          <p class="text-title-sm font-medium text-gold">{{ item.title }}</p>
          <p class="text-body-md text-neutral-700">{{ item.description }}</p>
        </div>
      </div>
    </div>
  </section>

  <!--
    Trust proof — Figma 1419:9205. Column gap 32 inside the 1036 track.
    Heading 1419:9206 is Poppins Medium 22 black/600 with the count run at
    28 / black-900. Logo rail 1419:9208: row, gap 48, each logo in a
    128×128 centred box at 80px wide. `shade` 1419:9215 is a 90deg
    white→transparent→white overlay (`.marquee-mask`).
  -->
  <section class="section pt-0">
    <div class="container-narrow flex flex-col gap-8">
      <h2 class="text-center text-[22px] font-medium text-neutral-600">
        {{ sections.trust_proof?.title }}
        <span class="text-[28px] text-neutral-900">{{
          sections.trust_proof?.content
        }}</span>
        {{ sections.trust_proof?.subtitle }}
      </h2>
      <!--
        A2 — the rail scrolls continuously behind the `shade` mask. The list
        is rendered twice so the -50% loop is seamless; the duplicate is
        aria-hidden so screen readers announce each client once.
      -->
      <div class="marquee-mask overflow-hidden">
        <div
          class="marquee-track items-center gap-12"
          style="--marquee-duration: 28s"
        >
          <template v-for="copy in 2" :key="copy">
            <span
              v-for="(client, i) in clients"
              :key="`${copy}-${i}`"
              class="flex size-32 shrink-0 items-center justify-center"
              :aria-hidden="copy === 2 ? 'true' : undefined"
            >
              <img
                :src="client.logo"
                :alt="copy === 2 ? '' : client.name"
                class="w-20 object-contain"
              />
            </span>
          </template>
        </div>
      </div>
    </div>
  </section>

  <!-- Services orbit — Figma 1419:9279 -->
  <ServicesOrbit
    v-if="sections.services_cloud"
    :section="sections.services_cloud"
    :services="services"
  />

  <!-- Content Direction Checklist — Figma 1419:9322 -->
  <LeadMagnet v-if="sections.lead_magnet" :section="sections.lead_magnet" />

  <!-- Projects showcase — Figma 1419:9216 -->
  <ProjectsShowcase
    v-if="sections.projects_showcase"
    :section="sections.projects_showcase"
    :projects="projects"
  />

  <!-- Process — Figma 1419:9302 -->
  <ProcessSection v-if="process" :section="process" />

  <!-- Packages — Figma 1419:9323 -->
  <PackagesSection v-if="packages" :section="packages" />

  <!-- Why us — Figma 1419:9230 -->
  <section v-if="whyUs" class="section">
    <div class="container-sahra">
      <div
        class="eyebrow"
        :style="{ color: whyUs.colors.eyebrow || undefined }"
      >
        {{ whyUs.eyebrow }}
      </div>
      <div class="mt-8 grid gap-8 lg:grid-cols-2">
        <div>
          <h2
            class="text-display-sm"
            :style="{ color: whyUs.colors.title || undefined }"
          >
            {{ whyUs.title }}
          </h2>
          <p
            class="mt-6 text-body-lg text-neutral-600"
            :style="{ color: whyUs.colors.subtitle || undefined }"
          >
            {{ whyUs.subtitle }}
          </p>
        </div>
        <div class="grid grid-cols-2 gap-4" data-reveal-group>
          <div
            v-for="(item, i) in whyUs.items"
            :key="i"
            class="will-reveal flex min-h-[184px] flex-col items-start gap-4 rounded-sm border border-gold-200 bg-gold-100 p-8 shadow-[0_4px_5px_rgba(0,0,0,0.05)]"
            data-reveal
          >
            <component
              :is="whyUsIcons[i] || BadgeCheck"
              class="size-8 text-gold"
              :stroke-width="1.5"
            />
            <div class="flex flex-col gap-2">
              <h3 class="text-title-md text-neutral-900">{{ item.title }}</h3>
              <p class="text-body-lg text-neutral-600">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Reviews — Figma 1419:9243 -->
  <section v-if="reviews" class="section overflow-hidden">
    <div class="container-sahra">
      <div
        class="eyebrow"
        :style="{ color: reviews.colors.eyebrow || undefined }"
      >
        {{ reviews.eyebrow }}
      </div>
      <h2
        class="max-w-xl text-display-sm"
        :style="{ color: reviews.colors.title || undefined }"
      >
        {{ reviews.title }}
      </h2>
    </div>

    <!--
      A6 — the "cards" frame 1419:9249 is 2452 wide inside a 1248 viewport, so
      the row travels rather than scrolls. Same duplicate-and-shift-50% trick
      as the client rail, at the 40s the audit specifies; hovering pauses it so
      a card can be read (and its 414:864 hover state inspected).
    -->
    <div class="marquee-mask mt-11 overflow-hidden pb-4">
      <!-- No padding on the track: it is `width: max-content`, so any inline
           padding would be carried into the -50% shift and the loop would drift. -->
      <div class="marquee-track gap-6" style="--marquee-duration: 40s">
        <div
          v-for="(t, i) in testimonialTrack"
          :key="i"
          class="testimonial-card flex h-[228px] w-[328px] shrink-0 flex-col rounded-sm border-[0.5px] p-6 shadow-testimonial"
          :aria-hidden="i >= testimonials.length ? 'true' : undefined"
        >
          <p class="text-body-md leading-normal text-neutral-800">
            {{ t.quote }}
          </p>
          <div class="mt-auto flex items-center gap-2">
            <img
              v-if="t.avatar"
              :src="t.avatar.src"
              :alt="t.avatar.alt"
              class="size-12 rounded-full object-cover"
            />
            <div>
              <p class="text-label-lg text-neutral-700">{{ t.name }}</p>
              <p class="mt-1 text-label-md text-neutral-600">{{ t.role }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Insights — Figma 1419:9258 -->
  <section v-if="insights" class="section">
    <div class="container-sahra flex flex-col gap-12">
      <div class="flex flex-col gap-12">
        <div
          class="eyebrow"
          :style="{ color: insights.colors.eyebrow || undefined }"
        >
          {{ insights.eyebrow }}
        </div>
        <div
          class="grid items-start gap-8 lg:grid-cols-[505px_1fr] lg:gap-[132px]"
        >
          <h2
            class="text-display-md leading-normal text-neutral-900"
            :style="{ color: insights.colors.title || undefined }"
          >
            {{ insights.title }}
          </h2>
          <p
            v-if="insightsSubtitle"
            class="max-w-[612px] text-title-sm font-medium text-neutral-700"
            :style="{
              color:
                insights.colors.description ||
                insights.colors.subtitle ||
                undefined,
            }"
          >
            {{ insightsSubtitle }}
          </p>
        </div>
      </div>

      <div class="grid gap-6 lg:h-[424px] lg:grid-cols-2" data-reveal-group>
        <a
          v-if="posts[0]"
          :href="posts[0].url"
          class="group will-reveal grid overflow-hidden rounded-sm border border-gold-200 bg-gold-100 p-4 shadow-card md:grid-cols-[279px_1fr]"
          data-reveal
        >
          <div class="h-[260px] overflow-hidden rounded-sm md:h-[392px]">
            <img
              v-if="posts[0].image"
              :src="posts[0].image.src"
              :alt="posts[0].image.alt"
              class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.04]"
            />
          </div>
          <div class="flex min-w-0 flex-col py-0 ps-6">
            <div class="flex items-center gap-2 text-body-md text-neutral-700">
              <CalendarDays class="size-6 text-gold" :stroke-width="1.5" />
              <span>{{ posts[0].publishedAt }}</span>
            </div>
            <h3 class="mt-14 text-title-md font-semibold text-gold">
              {{ posts[0].title }}
            </h3>
            <p class="mt-8 text-body-md text-neutral-700">
              {{ posts[0].excerpt }}
            </p>
            <span
              class="mt-auto ms-auto flex size-12 items-center justify-center rounded-round border border-neutral-800 bg-ink text-paper"
            >
              <ArrowUpRight class="size-8" :stroke-width="1.25" />
            </span>
          </div>
        </a>
        <div class="will-reveal flex flex-col gap-6" data-reveal>
          <a
            v-for="(post, index) in posts.slice(1, 3)"
            :key="post.slug"
            :href="post.url"
            class="grid flex-1 gap-6 sm:grid-cols-[188px_1fr]"
            :class="index === 0 ? 'border-b border-neutral-200 pb-6' : ''"
          >
            <img
              v-if="post.image"
              :src="post.image.src"
              :alt="post.image.alt"
              class="aspect-square h-[188px] w-[188px] rounded-sm object-cover"
            />
            <div class="flex flex-col justify-center gap-6">
              <div
                class="flex items-center gap-2 text-body-md text-neutral-700"
              >
                <CalendarDays class="size-6 text-gold" :stroke-width="1.5" />
                <span>{{ post.publishedAt }}</span>
              </div>
              <h3 class="text-title-md text-neutral-900">{{ post.title }}</h3>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ — Figma 1419:9272 -->
  <section v-if="faqSection" class="section">
    <div class="container-sahra grid gap-12 lg:grid-cols-2">
      <div>
        <div
          class="eyebrow"
          :style="{ color: faqSection.colors.eyebrow || undefined }"
        >
          {{ faqSection.eyebrow }}
        </div>
        <h2
          class="text-display-sm"
          :style="{ color: faqSection.colors.title || undefined }"
        >
          {{ faqSection.title }}
        </h2>
      </div>

      <div class="flex flex-col gap-6" data-reveal-group>
        <details
          v-for="(faq, i) in faqs"
          :key="i"
          class="group will-reveal rounded-sm border border-gold-200 bg-gold-100 p-8"
          data-reveal
        >
          <summary
            class="flex cursor-pointer list-none items-center justify-between gap-4 text-title-sm font-medium text-neutral-900 [&::-webkit-details-marker]:hidden"
          >
            {{ faq.question }}
            <span class="relative size-6 shrink-0 text-neutral-700">
              <Plus
                class="absolute inset-0 size-6 group-open:hidden"
                :stroke-width="1.5"
              />
              <Minus
                class="absolute inset-0 hidden size-6 group-open:block"
                :stroke-width="1.5"
              />
            </span>
          </summary>
          <p class="mt-4 text-body-lg text-neutral-700">{{ faq.answer }}</p>
        </details>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
