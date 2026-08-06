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
 | covers a wide desktop (card 328 + gap 26 = 354 per item).
 */
const testimonialTrack = computed(() => {
  const source = props.testimonials;
  if (source.length === 0) return [];

  const perHalf = Math.max(1, Math.ceil(2560 / 354 / source.length));
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
    class="relative min-h-[765px] overflow-hidden md:min-h-[904px]"
    style="
      background-image: url(&quot;/images/sahra/hero-brand-preview.png&quot;);
      background-size: cover;
      background-position: bottom;
    "
  >
    <!-- hero texts: x=96 y=176, gap-14 (space56) — Figma 1419:9194 -->
    <!-- A1: the three direct children (badge / texts / CTAs) stagger in on load. -->
    <!--
      The background is full-bleed, but the text block is placed at x=96 inside
      the 1440 frame — so it has to be measured from a centred frame, not from
      the viewport edge, or past 1440 it drifts left of every `.container-sahra`
      section below it (240px adrift at 1920). Same defect as AppHeader HD-01.
    -->
    <div class="mx-auto w-full max-w-frame">
    <div
      ref="heroStack"
      class="relative z-10 flex w-[731px] max-w-[calc(100%-2.5rem)] flex-col gap-8 px-5 pb-10 pt-36 md:ms-24 md:max-w-[calc(100%-3rem)] md:gap-14 md:px-0 md:pb-0 md:pt-[176px]"
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
      <div class="flex flex-col gap-8 md:gap-12">
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
          class="text-[28px] font-medium leading-normal tracking-[-0.02em] text-neutral-900 md:text-[48px] md:leading-[80px] md:tracking-[-0.05em]"
          :style="{ color: hero.colors.title || undefined }"
        >
          <span class="block text-[28px] md:text-[56px]">{{ hero.title }}</span>
          <!--
            The gradient run is `w-fit` so the 90deg ramp is measured across
            the glyphs, as in Figma, rather than across the 731px column.
          -->
          <span
            class="block w-fit bg-clip-text font-display text-[40px] leading-normal tracking-normal text-transparent md:text-[96px] md:leading-[80px]"
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
          <span class="block text-[28px] md:text-[56px]">{{
            hero.description
          }}</span>
        </h1>

        <!-- Subtitle — Figma 1419:9201: Poppins Medium 18, black/700, w 612 -->
        <p
          class="w-full max-w-[612px] text-[16px] font-medium leading-[1.4] text-neutral-700 md:text-[18px]"
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
          class="flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-[14px] font-medium text-paper transition-opacity hover:opacity-90 md:px-8 md:py-4 md:text-title-md"
        >
          {{ hero.primaryCta.label }}
        </a>
        <a
          v-if="hero.secondaryCta"
          :href="hero.secondaryCta.url"
          class="flex items-center gap-1 rounded-sm border border-ink bg-paper px-6 py-3 text-[14px] font-medium text-ink transition-colors hover:bg-neutral-50 md:px-8 md:py-4 md:text-title-md"
        >
          {{ hero.secondaryCta.label }}
        </a>
      </div>
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
  <section v-if="kpi" class="relative z-20 -mt-[117px] py-0 md:mt-0 md:py-24 lg:py-28">
    <div
      class="container-sahra grid grid-cols-3 gap-2 text-center md:container-narrow md:gap-4"
      data-reveal-group
    >
      <div
        v-for="(item, i) in kpi.items"
        :key="i"
        class="edge-gold will-reveal flex h-[77px] flex-col items-center justify-center gap-1 rounded-sm px-1 py-2 md:h-auto md:gap-2 md:px-3 md:py-6"
        data-reveal
      >
        <div class="flex items-center justify-center gap-1 md:gap-4">
          <component
            :is="kpiIcons[i] || TrendingUp"
            class="size-4 text-gold md:size-8"
            :stroke-width="1.5"
          />
          <!-- A3: counts up to the authored value; the DOM text stays the
               source of truth so the number is right without JS. -->
          <p
            class="latin-nums text-[18px] font-medium leading-none text-ink md:text-[32px]"
            data-counter
          >
            {{ item.value }}
          </p>
        </div>
        <div class="flex flex-col items-center gap-1">
          <p class="text-[10px] font-medium leading-tight text-gold md:text-title-sm">{{ item.title }}</p>
          <p class="hidden text-body-md text-neutral-700 md:block">{{ item.description }}</p>
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
  <section class="section h-[317px] pb-0 pt-[115px] md:h-auto md:pb-24 md:pt-0 lg:pb-28">
    <div class="container-narrow flex flex-col gap-8">
      <h2 class="text-center text-[16px] font-medium leading-normal text-neutral-600 md:text-[22px]">
        {{ sections.trust_proof?.title }}
        <span class="text-[20px] leading-normal text-neutral-900 md:text-[28px]">{{
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
  <LeadMagnet v-if="sections.lead_magnet" class="max-md:h-[207px] max-md:overflow-hidden max-md:opacity-0" :section="sections.lead_magnet" />

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
  <section v-if="whyUs" class="h-[1094px] pt-[193px] md:h-auto md:py-24 lg:py-28">
    <div class="container-sahra">
      <div
        class="eyebrow"
        :style="{ color: whyUs.colors.eyebrow || undefined }"
      >
        {{ whyUs.eyebrow }}
      </div>
      <!--
        Row 1419:9232: space-between, items-center, title column fixed 506.
        Cards 1419:9236 are a column (gap 48) of rows (gap 40) — a 2×2 grid
        whose two axes differ, so both gap-x and gap-y are explicit.
      -->
      <div
        class="mt-8 grid gap-8 lg:grid-cols-[506px_1fr] lg:items-center lg:justify-between"
      >
        <!-- title & subtitle 1419:9233 — column, gap 40 -->
        <div class="flex flex-col gap-6 md:gap-10">
          <h2
            class="text-[26px] font-semibold leading-tight md:text-display-md"
            :style="{ color: whyUs.colors.title || undefined }"
          >
            {{ whyUs.title }}
          </h2>
          <!-- Subtitle 1419:9235 — Poppins Medium 18, black/700 -->
          <p
            class="text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
            :style="{ color: whyUs.colors.subtitle || undefined }"
          >
            {{ whyUs.subtitle }}
          </p>
        </div>
        <div class="grid grid-cols-2 gap-3 md:gap-x-10 md:gap-y-12" data-reveal-group>
          <div
            v-for="(item, i) in whyUs.items"
            :key="i"
            class="will-reveal flex flex-col items-start gap-3 rounded-sm border border-gold-200 bg-gold-100 p-4 shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:gap-4 md:p-8"
            data-reveal
          >
            <component
              :is="whyUsIcons[i] || BadgeCheck"
              class="size-6 text-gold md:size-8"
              :stroke-width="1.5"
            />
            <div class="flex flex-col gap-2">
              <h3 class="text-[16px] font-medium text-neutral-900 md:text-title-md">{{ item.title }}</h3>
              <!-- Description I1419:9238;398:528 is a fixed 212 in the file. -->
              <p class="max-w-[212px] text-[12px] leading-normal text-neutral-600 md:text-body-lg">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Reviews — Figma 1419:9243 -->
  <section v-if="reviews" class="h-[573px] overflow-hidden py-14 md:h-auto md:py-24 lg:py-28">
    <div class="container-sahra">
      <div
        class="eyebrow"
        :style="{ color: reviews.colors.eyebrow || undefined }"
      >
        {{ reviews.eyebrow }}
      </div>
      <!--
        title & subtitle 1419:9246 — row, gap 132, title column fixed 505.
        Structurally identical to the Insights row 1419:9261 below.
      -->
      <div
        class="mt-8 grid items-start gap-6 md:mt-12 lg:grid-cols-[505px_1fr] lg:gap-[132px]"
      >
        <h2
          class="text-[26px] font-semibold leading-tight md:text-display-md"
          :style="{ color: reviews.colors.title || undefined }"
        >
          {{ reviews.title }}
        </h2>
        <!-- Subtitle 1419:9248 — Poppins Medium 18, black/700, w 612 -->
        <p
          v-if="reviews.subtitle"
          class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
          :style="{ color: reviews.colors.subtitle || undefined }"
        >
          {{ reviews.subtitle }}
        </p>
      </div>
    </div>

    <!--
      A6 — the "cards" frame 1419:9249 is 2452 wide inside a 1248 viewport, so
      the row travels rather than scrolls. Same duplicate-and-shift-50% trick
      as the client rail, at the 40s the audit specifies; hovering pauses it so
      a card can be read (and its 414:864 hover state inspected).
    -->
    <div class="marquee-mask mt-8 h-[246px] overflow-hidden md:mt-10 md:h-[297px]">
      <!-- No padding on the track: it is `width: max-content`, so any inline
           padding would be carried into the -50% shift and the loop would drift.
           Viewport 1419:9249 is 297 tall for a 246 card — the surplus is shadow
           room, so the track centres rather than sitting flush. -->
      <div
        class="marquee-track h-full items-center gap-[26px]"
        style="--marquee-duration: 40s"
      >
        <div
          v-for="(t, i) in testimonialTrack"
          :key="i"
          class="testimonial-card flex h-[220px] w-[328px] shrink-0 flex-col rounded-sm border-[0.5px] p-5 shadow-testimonial md:h-[246px] md:p-6"
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
  <section v-if="insights" class="py-14 md:py-24 lg:py-28">
    <div class="container-sahra flex flex-col gap-10 md:gap-12">
      <div class="flex flex-col gap-8 md:gap-12">
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
            class="text-[26px] font-semibold leading-tight text-neutral-900 md:text-display-md md:leading-normal"
            :style="{ color: insights.colors.title || undefined }"
          >
            {{ insights.title }}
          </h2>
          <p
            v-if="insightsSubtitle"
            class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
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
          class="group will-reveal grid h-[458px] grid-cols-[174px_1fr] gap-3 overflow-hidden rounded-sm border border-gold-200 bg-gold-100 p-3 shadow-card md:h-auto md:grid-cols-[279px_270px] md:justify-between md:gap-0 md:p-4"
          data-reveal
        >
          <div class="h-full overflow-hidden rounded-sm md:h-[392px]">
            <img
              v-if="posts[0].image"
              :src="posts[0].image.src"
              :alt="posts[0].image.alt"
              class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.04]"
            />
          </div>
          <!--
            Content column I1419:9265;1210:3789 distributes with
            space-between over a fixed 270 — not fixed margins, which would
            stop matching the frame as soon as an excerpt changes length.
          -->
          <div class="flex min-w-0 flex-col justify-between py-2 md:py-0">
            <div class="flex items-center gap-2 text-body-md text-neutral-700">
              <CalendarDays class="size-6 text-gold" :stroke-width="1.5" />
              <span>{{ posts[0].publishedAt }}</span>
            </div>
            <h3 class="text-title-md font-semibold text-gold">
              {{ posts[0].title }}
            </h3>
            <p class="hidden text-body-md text-neutral-700 md:block">
              {{ posts[0].excerpt }}
            </p>
            <span
              class="ms-auto flex size-10 items-center justify-center rounded-round border border-neutral-800 bg-ink text-paper md:size-12"
            >
              <ArrowUpRight class="size-8" :stroke-width="1.25" />
            </span>
          </div>
        </a>
        <div class="will-reveal flex flex-col gap-3 md:gap-6" data-reveal>
          <a
            v-for="(post, index) in posts.slice(1, 3)"
            :key="post.slug"
            :href="post.url"
            class="grid h-[120px] grid-cols-[120px_1fr] gap-4 md:h-auto md:flex-1 md:gap-6 sm:grid-cols-[188px_1fr]"
            :class="index === 0 ? 'border-b border-neutral-200 pb-6' : ''"
          >
            <img
              v-if="post.image"
              :src="post.image.src"
              :alt="post.image.alt"
              class="aspect-square size-[120px] rounded-sm object-cover md:size-[188px]"
            />
            <div class="flex flex-col justify-center gap-3 md:gap-6">
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
  <section v-if="faqSection" class="h-[891px] py-14 md:h-auto md:py-24 lg:py-28">
    <!--
      Section 1419:9272 is a column [eyebrow, content] at gap 48; the content
      row 1419:9274 is gap 32 with a fixed 497 left column. The eyebrow spans
      the full track above the row — it is not a cell inside it.
    -->
    <div class="container-sahra">
      <div
        class="eyebrow"
        :style="{ color: faqSection.colors.eyebrow || undefined }"
      >
        {{ faqSection.eyebrow }}
      </div>

      <div class="mt-8 grid gap-8 md:mt-12 lg:grid-cols-[497px_1fr]">
        <!-- 1419:9275 — fills the row height, title top / subtitle bottom. -->
        <div class="flex flex-col justify-between gap-8">
          <h2
            class="text-[26px] font-semibold leading-tight md:text-display-md"
            :style="{ color: faqSection.colors.title || undefined }"
          >
            {{ faqSection.title }}
          </h2>
          <!-- Subtitle 1419:9277 — Poppins Medium 18, black/700 -->
          <p
            v-if="faqSection.subtitle"
            class="text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
            :style="{ color: faqSection.colors.subtitle || undefined }"
          >
            {{ faqSection.subtitle }}
          </p>
        </div>

        <div class="flex flex-col gap-3 md:gap-6" data-reveal-group>
          <!-- First box is the `open` variant 438:561; the rest are 438:563. -->
          <details
            v-for="(faq, i) in faqs"
            :key="i"
            :open="i === 0"
            class="group will-reveal rounded-sm border border-gold-200 bg-gold-100 p-4 md:p-8"
            data-reveal
          >
            <summary
              class="flex cursor-pointer list-none items-center justify-between gap-4 text-[14px] font-medium text-neutral-900 md:text-title-sm [&::-webkit-details-marker]:hidden"
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
            <p class="mt-3 text-[12px] leading-normal text-neutral-700 md:mt-4 md:text-body-lg">{{ faq.answer }}</p>
          </details>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner
    v-if="sections.final_cta"
    :section="sections.final_cta"
    spacing-class="pb-[182px] pt-24 md:pb-[260px]"
  />
</template>
