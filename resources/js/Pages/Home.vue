<script setup lang="ts">
import ButtonIcon from '@/Components/ButtonIcon.vue'
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
  ChartNoAxesCombined,
  CircleMinus,
  CirclePlus,
  ClipboardCheck,
  Gem,
  Copy,
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
  primaryCta: { label: string; url: string; icon?: string | null } | null;
  secondaryCta: { label: string; url: string; icon?: string | null } | null;
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
const heroImage = computed(() => hero.value?.image ?? null);
const kpi = computed(() => props.sections.kpi);
const process = computed(() => props.sections.process);
const packages = computed(() => props.sections.packages);
const whyUs = computed(() => props.sections.why_us);
const reviews = computed(() => props.sections.reviews);
const insights = computed(() => props.sections.insights);
const faqSection = computed(() => props.sections.faq);
const faqSubtitle = computed(
  () =>
    faqSection.value?.subtitle ||
    {
      en: "Because every creative decision is built around brand clarity, consistency, and growth.",
      fa: "چون هر تصمیم خلاقانه بر شفافیت، انسجام و رشد برند استوار است.",
      ar: "لأن كل قرار إبداعي يقوم على وضوح العلامة واتساقها ونموها.",
    }[page.props.locale.current],
);
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

/*
 | Figma orders the project CTA first and gives it the solid treatment.
 | Mobile padding/font are trimmed from the desktop values (px-8/14px) so
 | both labels fit side by side on the 402px frame instead of wrapping to
 | two full-width rows — `flex-wrap` on the parent stays as a safety net
 | for an admin-authored label long enough to still overflow.
 */
const heroCtaSolid =
  "flex items-center gap-1 whitespace-nowrap rounded-sm bg-ink px-4 py-[10px] text-[13px] font-medium text-paper transition-colors hover:bg-gold hover:text-white md:px-8 md:py-4 md:text-title-md";
const heroCtaOutline =
  "flex items-center gap-1 whitespace-nowrap rounded-sm border border-ink bg-paper px-4 py-[9px] text-[13px] font-medium text-ink transition-colors hover:border-gold hover:text-gold md:px-8 md:py-[15px] md:text-title-md";

const heroCtas = computed(() => {
  const primary = hero.value?.primaryCta ?? null;
  const secondary = hero.value?.secondaryCta ?? null;

  const ordered = [primary, secondary];

  return ordered.filter(
    (cta): cta is { label: string; url: string; icon?: string | null } => cta !== null,
  );
});

const whyUsIcons = [BadgeCheck, Copy, Gem, ClipboardCheck];
const kpiIcons = [ChartNoAxesCombined, TrendingUp, UsersRound];

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
  <!--
    ============================================================
    VERTICAL RHYTHM — `lg:` margin offsets on the sections below
    ============================================================

    Frame 1419:9192 positions every section absolutely. The section components
    are shared with 6 other pages, so their own padding is left alone and the
    correction is applied here, at the call site, as a margin.

    Each value is the INCREMENTAL shift for that section: a margin moves the
    section and everything after it, so shift[i] = d[i] - d[i-1] where d is the
    section's measured offset from its Figma y. Verified at 1440: all 14 nodes
    land on their Figma y exactly (0px), see AUDIT/figma-final/report.md §12.

    Two things to know before editing:

    1. Negative margins here consume the PRECEDING section's bottom padding
       (112px at lg). Every value is smaller than that, so nothing collides.
       Keep it that way — a negative margin larger than 112 overlaps content.
    2. These are tuned against the CURRENTLY SEEDED copy. Section heights are
       content-dependent, so a materially longer heading or excerpt re-opens
       the drift. Re-run the harness rather than eyeballing it.

    The KPI band is *designed* to overlap the hero: Figma puts it at y=850
    while the hero image is 1440x904. Hence `lg:-mt-[54px] lg:pt-0` — it needs
    no top padding, it sits on the hero.
  -->
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
  >
    <!--
      The artwork is a *directional* composition, not a texture: the dune
      curve and orbit ring occupy one half and the copy sits in the empty
      half. The RTL frame (ar home 1365:11275) is the same asset mirrored, so
      the clear half follows the text — unflipped it collides with the copy.
      Hence its own layer rather than a background on the section: flipping
      the section would flip the hero text with it.

      Mobile (1419:9191) is a SEPARATE composition, not a crop: the frame is
      402x765 and the artwork is re-stacked vertically — ring and dune curve
      anchored bottom-right, the clear space above them rather than beside.
      The desktop asset is 1024x704 landscape with everything in its right
      half, so scaling it into a portrait viewport pushes the whole
      composition off the right edge. Hence a per-breakpoint asset swap.
      Both use bg-[length:100%_100%]: each asset already matches its frame's
      aspect ratio, so this fills exactly with no crop.
    -->
    <img
      v-if="heroImage"
      :src="heroImage.src"
      :alt="heroImage.alt"
      :width="heroImage.width"
      :height="heroImage.height"
      class="absolute inset-0 size-full object-cover"
    />
    <div
      v-else
      class="absolute inset-0 bg-[url('/images/sahra/hero-brand-preview-mobile.webp')] bg-[length:100%_100%] bg-center bg-no-repeat md:bg-[url('/images/sahra/hero-brand-preview.png')] rtl:-scale-x-100"
      aria-hidden="true"
    ></div>
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
      class="relative z-10 flex w-[731px] max-w-full flex-col gap-12 px-5 pb-10 pt-36 md:ms-24 md:max-w-[calc(100%-3rem)] md:gap-14 md:px-0 md:pb-0 md:pt-[176px]"
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
            "marketing systems" — flat primary gold, no gradient and no glow.
            This previously painted a 90deg white→gold→white ramp through
            `bg-clip-text`, which faded both ends of the run towards paper and
            read as a soft shadow. The handover spec pins it to the primary
            gold variable outright, so the run is a plain `color` fill and
            carries no text-shadow / drop-shadow of any kind.
          -->
          <span
            class="block w-fit font-display text-[36px] leading-normal tracking-normal md:text-[96px] md:leading-[80px]"
            :style="{
              color: hero.colors.content || 'var(--primary-gold, #BD933B)',
            }"
            >{{ hero.content }}</span
          >
          <span class="block text-[28px] md:text-[56px]">{{
            hero.description
          }}</span>
        </h1>

        <!-- Subtitle — Figma 1419:9201: Poppins Medium 18, black/700, w 612 -->
        <p
          class="w-full max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-[18px]"
          :style="{ color: hero.colors.subtitle || undefined }"
        >
          {{ hero.subtitle }}
        </p>
      </div>

      <!--
        hero cta: gap-[10px] — Figma 1419:9202 (en) / 1365:9960 (ar).
        `heroCtas` keeps the authored primary/secondary order; the primary
        project action receives the solid treatment.
      -->
      <div class="flex flex-wrap items-center gap-2 md:gap-[10px]">
        <a
          v-for="(cta, i) in heroCtas"
          :key="cta.url"
          :href="cta.url"
          :class="i === 0 ? heroCtaSolid : heroCtaOutline"
        >
          {{ cta.label }}
          <ButtonIcon :name="cta.icon" />
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
  <section v-if="kpi" class="relative z-20 -mt-[117px] py-0 md:mt-0 md:py-24 lg:-mt-[54px] lg:py-28 lg:pt-0">
    <div
      class="container-sahra grid grid-cols-3 gap-2 text-center md:container-narrow md:gap-4"
      data-reveal-group
    >
      <div
        v-for="(item, i) in kpi.items"
        :key="i"
        class="edge-gold will-reveal flex h-[77px] flex-col items-center justify-center gap-2 rounded-[4px] px-3 py-3 md:h-auto md:px-3 md:py-6"
        data-reveal
      >
        <div class="flex items-center justify-center gap-1 md:gap-4">
          <img
            v-if="item.icon"
            :src="item.icon"
            alt=""
            class="size-4 object-contain md:size-8"
            aria-hidden="true"
          />
          <component
            v-else
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
          <p class="whitespace-nowrap text-[12px] font-medium leading-normal text-gold md:text-title-sm">{{ item.title }}</p>
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

    Mobile pt/pb verified against the mobile frame 1419:9191: KPI
    (Frame 96151, y648 h77) → this section (Frame 96153, y813) is an 88px
    gap; this section (bottom y950) → services orbit (Frame 96284, y1042)
    is a 92px gap. Was pt-115/pb-0 (mismatched — pb was implicitly 0 since
    the next section's own dark background starts flush at its frame edge)
    before this fix.
  -->
  <section class="section pb-[92px] pt-[88px] md:pb-24 md:pt-0 lg:mt-[19px] lg:pb-28">
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
              class="group flex size-32 shrink-0 items-center justify-center"
              :aria-hidden="copy === 2 ? 'true' : undefined"
            >
              <img
                :src="client.logo"
                :alt="copy === 2 ? '' : client.name"
                class="size-full object-contain p-2 grayscale transition-[filter] duration-300 ease-out group-hover:grayscale-0 group-focus-within:grayscale-0"
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
    class="lg:mt-[23px]"
    :section="sections.services_cloud"
    :services="services"
  />

  <!--
    Content Direction Checklist — Figma 1419:9322.

    The mobile overrides here were `max-md:h-[207px] max-md:overflow-hidden
    max-md:opacity-0`, which pinned the block to a fixed height and then made
    it fully TRANSPARENT below 768px — the section was rendered, occupied
    space, and was invisible on every phone. Removed: the card sizes itself
    from its content at every width.
  -->
  <LeadMagnet
    v-if="sections.lead_magnet"
    class="lg:mt-[48px]"
    :section="sections.lead_magnet"
    mobile-offcanvas
  />

  <!-- Projects showcase — Figma 1419:9216 -->
  <ProjectsShowcase
    v-if="sections.projects_showcase"
    class="max-md:h-[971px] lg:-mt-[64px]"
    :section="sections.projects_showcase"
    :projects="projects"
  />

  <!-- Process — Figma 1419:9302 -->
  <ProcessSection
    v-if="process"
    class="max-md:!h-[944px] lg:mt-[7px]"
    :section="process"
  />

  <!-- Packages — Figma 1419:9323 -->
  <PackagesSection
    v-if="packages"
    class="max-md:mt-[80px] lg:mt-[126px]"
    :section="packages"
  />

  <!-- Why us — Figma 1419:9230 -->
  <section
    v-if="whyUs"
    class="py-14 md:py-24 lg:mt-[92px] lg:py-28"
  >
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
        class="mt-6 grid gap-12 lg:mt-8 lg:grid-cols-[506px_1fr] lg:items-center lg:justify-between lg:gap-8"
      >
        <!-- title & subtitle 1419:9233 — column, gap 40 -->
        <div class="flex flex-col gap-6 md:gap-10">
          <h2
            class="text-[26px] font-semibold leading-normal md:text-display-md"
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
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 md:gap-x-10 md:gap-y-12" data-reveal-group>
          <div
            v-for="(item, i) in whyUs.items"
            :key="i"
            class="will-reveal flex min-h-[140px] flex-col items-start gap-3 rounded-sm border border-gold-200 bg-gold-100 p-6 shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:gap-4 md:p-8"
            data-reveal
          >
            <img
              v-if="item.icon"
              :src="item.icon"
              alt=""
              class="size-6 object-contain md:size-8"
              aria-hidden="true"
            />
            <svg
              v-else-if="item.title.trim().toLocaleLowerCase() === 'end-to-end support'"
              class="size-6 md:size-8"
              viewBox="0 0 10 10"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M1 1V6.33333C1 7.04058 1.28095 7.71885 1.78105 8.21895C2.28115 8.71905 2.95942 9 3.66667 9H9"
                stroke="#BD933B"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
            <component
              :is="whyUsIcons[i] || BadgeCheck"
              v-else
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
  <section
    v-if="reviews"
    class="h-[573px] overflow-hidden py-14 md:h-auto md:py-24 lg:-mt-[100px] lg:py-28"
  >
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
          class="text-[26px] font-semibold leading-normal md:text-display-md"
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
    <!--
      The rail is clipped to the SAME track as every other section rather than
      running to the viewport edges. It used to be a direct child of <section>,
      so on wide screens the cards bled past `.container-sahra` and the reviews
      block was the only band on the page without the site gutter.

      `.container-sahra` supplies the gutter; `.marquee-mask` then fades inside
      it, so the row still reads as continuous motion rather than as a boxed
      carousel. The track itself keeps its own `width: max-content` — see below.
    -->
    <div class="container-sahra mt-10 md:mt-10">
    <div class="marquee-mask hidden h-[246px] overflow-hidden md:block md:h-[297px]">
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
    <div v-if="testimonials[0]" class="md:hidden">
      <div class="testimonial-card flex h-[246px] w-full flex-col rounded-sm border-[0.5px] p-6 shadow-testimonial">
        <p class="text-[14px] leading-normal text-neutral-800">{{ testimonials[0].quote }}</p>
        <div class="mt-auto flex items-center gap-2">
          <img v-if="testimonials[0].avatar" :src="testimonials[0].avatar.src" :alt="testimonials[0].avatar.alt" class="size-12 rounded-full object-cover" />
          <div>
            <p class="text-label-lg text-neutral-700">{{ testimonials[0].name }}</p>
            <p class="mt-1 text-label-md text-neutral-600">{{ testimonials[0].role }}</p>
          </div>
        </div>
      </div>
      <div class="mt-6 flex h-[10px] items-center justify-center gap-2" aria-hidden="true">
        <span class="h-[10px] w-4 rounded-round bg-gold-600"></span>
        <span v-for="i in 3" :key="i" class="size-[10px] rounded-round bg-neutral-200"></span>
      </div>
    </div>
    </div>
  </section>

  <!-- Insights — Figma 1419:9258 -->
  <section
    v-if="insights"
    class="h-[1111px] overflow-hidden py-14 md:h-auto md:py-24 lg:-mt-[10px] lg:py-28"
  >
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
            class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-md"
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
          class="group will-reveal flex min-h-[457px] flex-col gap-6 overflow-hidden rounded-sm bg-[#fbf9f5] p-4 shadow-card md:grid md:h-auto md:min-h-0 md:grid-cols-[279px_270px] md:justify-between md:gap-0"
          data-reveal
        >
          <div class="h-[248px] overflow-hidden rounded-sm border border-neutral-100 shadow-card md:h-[392px]">
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
          <div class="flex min-w-0 flex-1 flex-col gap-6 md:justify-between md:gap-0 md:py-0">
            <div class="flex items-center gap-2 text-[12px] leading-normal text-neutral-700 md:text-body-md">
              <CalendarDays class="size-4 text-gold md:size-6" :stroke-width="1.5" />
              <span>{{ posts[0].publishedAt }}</span>
            </div>
            <h3 class="text-[16px] font-semibold leading-normal text-gold md:text-title-md">
              {{ posts[0].title }}
            </h3>
            <p class="text-[13px] leading-normal text-neutral-700 md:text-body-md">
              {{ posts[0].excerpt }}
            </p>
            <span class="ms-auto hidden size-10 items-center justify-center rounded-round border border-neutral-800 bg-ink text-paper transition-colors group-hover:bg-gold group-hover:text-white md:flex md:size-12">
              <ArrowUpRight class="size-8 rtl:-scale-x-100" :stroke-width="1.25" />
            </span>
          </div>
        </a>
        <div class="will-reveal flex flex-col gap-3 md:gap-6" data-reveal>
          <a
            v-for="(post, index) in posts.slice(1, 3)"
            :key="post.slug"
            :href="post.url"
            class="group grid h-[120px] grid-cols-[120px_1fr] gap-4 md:h-auto md:flex-1 md:gap-6 sm:grid-cols-[188px_1fr]"
            :class="index === 0 ? 'border-b border-neutral-200 pb-6' : ''"
          >
            <div class="aspect-square size-[120px] overflow-hidden rounded-sm md:size-[188px]">
              <img
                v-if="post.image"
                :src="post.image.src"
                :alt="post.image.alt"
                class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.04]"
              />
            </div>
            <div class="flex flex-col justify-center gap-3 md:gap-6">
              <div
                class="flex items-center gap-2 text-[12px] leading-normal text-neutral-700 md:text-body-md"
              >
                <CalendarDays class="size-4 text-gold md:size-6" :stroke-width="1.5" />
                <span>{{ post.publishedAt }}</span>
              </div>
              <h3 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-title-md">
                {{ post.title }}
              </h3>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ — Figma 1419:9272 -->
  <section v-if="faqSection" class="py-14 md:py-24 lg:-mt-[98px] lg:py-28">
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
            class="text-[26px] font-semibold leading-normal md:text-display-md"
            :style="{ color: faqSection.colors.title || undefined }"
          >
            {{ faqSection.title }}
          </h2>
          <!-- Subtitle 1419:9277 — Poppins Medium 18, black/700 -->
          <p
            v-if="faqSubtitle"
            class="text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
            :style="{ color: faqSection.colors.subtitle || undefined }"
          >
            {{ faqSubtitle }}
          </p>
        </div>

        <div class="flex flex-col gap-3 md:gap-6" data-reveal-group>
          <!-- First box is the `open` variant 438:561; the rest are 438:563. -->
          <details
            v-for="(faq, i) in faqs"
            :key="i"
            name="faq-accordion"
            :open="i === 1"
            class="group will-reveal rounded-sm border border-gold-200 bg-gold-100 p-4 md:p-8"
            data-reveal
          >
            <summary
              class="flex cursor-pointer list-none items-center justify-between gap-4 text-[14px] font-medium text-neutral-900 md:text-title-sm [&::-webkit-details-marker]:hidden"
            >
              {{ faq.question }}
              <!--
                Figma 438:571 / 438:551 export as a ringed glyph — a 20px
                circle at stroke 1.5 #4F4C4D with the bar(s) inside it, i.e.
                lucide `circle-plus` / `circle-minus`. The bare `plus` / `minus`
                used here before dropped that ring, which is the "+ has no
                border" defect. Colour is black/800 (#4F4C4D), matching the
                exported stroke exactly — not black/700.
              -->
              <span class="relative size-6 shrink-0 text-neutral-800">
                <CirclePlus
                  class="absolute inset-0 size-6 group-open:hidden"
                  :stroke-width="1.5"
                />
                <CircleMinus
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
    class="lg:mb-[61px] lg:mt-[82px]"
    :section="sections.final_cta"
    spacing-class="pb-[182px] pt-24 md:pb-[260px]"
  />
</template>
