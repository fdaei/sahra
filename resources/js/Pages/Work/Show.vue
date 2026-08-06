<script setup lang="ts">
/**
 * Single project — Figma 639:1617 (desktop, LTR) / 1323:7541 (RTL) /
 * 1555:10866 (mobile).
 *
 * Frame geometry taken from the file:
 *   page          1361:7175  column, align center, gap 224, content starts y=184
 *   intro row     1294:4813  row, gap 342 → [title + description] [info list]
 *   info list       654:1918  column, gap 24; icon 20 + label 14/500 + value 14/400
 *   banner          646:1754  1248×624, radius 16, shadow 3.32/9.96 rgba(0,0,0,.05)
 *   challenge     1294:4818  row, space-between; heading 40/600, body column w=612
 *   goal card     EL-5f1be45d  padding 48/24, gap 24, fill #F4F3F4 4d,
 *                              3px gold top edge, radius 8; num 36/500 gold
 *   results card  EL-4d4b557d  padding 16/32, gap 16, fill gold/100, radius 8;
 *                              value 30/500 gold, label 22/500
 *   showcase        820:2101…  400×500, radius 8, row gap 24
 *   before/after  1361:7094  row gap 24, each column w=612 gap 24, label 28/600
 *
 * Everything renders off `project` (ProjectDetail) — see
 * App\Services\ContentTransformer::projectDetail.
 */
import { computed, ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import projectArcRings from '~img/decor/arc-rings-project.svg'
import {
  ArrowRight,
  BarChart3,
  CalendarDays,
  Building2,
  Eye,
  Instagram,
  LayoutGrid,
  MessageCircle,
  MoveRight,
  Target,
  Users,
} from 'lucide-vue-next'
import SeoHead from '@/Components/SeoHead.vue'
import CtaBanner from '@/Components/CtaBanner.vue'
import { useHeroStagger, useSectionReveal } from '@/Composables/useMotion'
import { useTranslations } from '@/Composables/useTranslations'
import type { ProjectDetail, SeoMeta } from '@/types'

const props = defineProps<{
  project: ProjectDetail
  finalCta: InstanceType<typeof CtaBanner>['$props']['section'] | null
  seo: SeoMeta
}>()

const { t } = useTranslations()

/** Info list — Figma 654:1918. Rows are dropped when the field is empty. */
const info = computed(() =>
  [
    { icon: Building2, label: t('work.industry'), value: props.project.industry },
    { icon: CalendarDays, label: t('work.year'), value: props.project.year },
    {
      icon: Instagram,
      label: t('work.instagram'),
      value: props.project.instagram,
      href: props.project.instagram
        ? `https://instagram.com/${props.project.instagram}`
        : null,
    },
    {
      icon: LayoutGrid,
      label: t('work.services'),
      value: props.project.services.join(', '),
    },
  ].filter((row) => row.value),
)

/** Results icons, in the order the design lists them (target → eye). */
const resultIcons = [Target, BarChart3, MessageCircle, Users, Eye]

const pageRoot = ref<HTMLElement | null>(null)
const intro = ref<HTMLElement | null>(null)

useHeroStagger(intro)
useSectionReveal(pageRoot)
</script>

<template>
  <SeoHead :meta="seo" />

  <div ref="pageRoot" class="relative overflow-x-clip">
    <!--
      Figma 1083:2745 / 1323:7542 — the 1473×1563 concentric rings begin
      off-canvas at x=-617, y=974.12 on the desktop frame. Logical `start`
      mirrors the composition for fa/ar without duplicating the asset.
      The max-md offsets are derived: no mobile frame places this layer.
    -->
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
      <div class="relative mx-auto h-full w-full max-w-frame">
        <img
          :src="projectArcRings"
          alt=""
          width="1473"
          height="1563"
          class="absolute start-[-617px] top-[974px] w-[1473px] max-w-none max-md:start-[-760px] max-md:top-[820px]"
        />
      </div>
    </div>

    <!--
      Page column. The file nests three intervals and they are not
      interchangeable: 1361:7175 and 1361:7124 carry 224, while the sections
      themselves (1361:7102 / 1361:7103) sit at 144. Content starts at y=184.
      The trailing 224 is the gap to the final CTA card, hence pb-56.
    -->
    <div
      class="container-sahra relative z-10 flex flex-col gap-24 pb-56 pt-[136px] md:gap-[144px] md:pt-[184px]"
    >
    <!--
      1361:7093 — the major-block stack, gap 200. Everything from the intro
      through the results sits at this interval; only before/after and the
      next-case-study link drop to the outer 144.
    -->
    <div class="flex flex-col gap-24 md:gap-[200px]">
    <!-- Intro + banner — Figma 1361:7087 (column, gap 80) -->
    <div ref="intro" class="flex flex-col gap-14 md:gap-20">
      <div class="flex flex-col gap-10 lg:flex-row lg:justify-between lg:gap-[342px]">
        <div class="flex max-w-[612px] flex-col gap-6">
          <h1 class="text-[36px] font-semibold text-neutral-900 md:text-[48px]">
            {{ project.title }}
          </h1>
          <p
            v-if="project.excerpt"
            class="text-[18px] font-medium text-neutral-700"
          >
            {{ project.excerpt }}
          </p>
        </div>

        <dl v-if="info.length > 0" class="flex shrink-0 flex-col gap-6">
          <div v-for="row in info" :key="row.label" class="flex flex-col gap-1">
            <dt class="flex items-center gap-2">
              <component
                :is="row.icon"
                class="size-5 shrink-0 text-gold"
                :stroke-width="1.5"
                aria-hidden="true"
              />
              <span class="text-label-lg text-neutral-1000">{{ row.label }}</span>
            </dt>
            <dd class="max-w-[220px] text-body-md text-neutral-800">
              <a
                v-if="row.href"
                :href="row.href"
                target="_blank"
                rel="noopener noreferrer"
                class="underline decoration-neutral-300 underline-offset-2 hover:text-gold"
              >
                {{ row.value }}
              </a>
              <template v-else>{{ row.value }}</template>
            </dd>
          </div>
        </dl>
      </div>

      <img
        v-if="project.banner"
        :src="project.banner.src"
        :srcset="project.banner.srcset"
        :alt="project.banner.alt"
        width="1248"
        height="624"
        class="aspect-[1248/624] w-full rounded-lg object-cover shadow-banner"
      />
    </div>

    <!-- The Challenge — Figma 1294:4818 -->
    <section
      v-if="project.challenge"
      class="will-reveal flex flex-col gap-10 lg:flex-row lg:justify-between"
      data-reveal
    >
      <h2 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
        {{ t('work.challenge') }}
      </h2>

      <div class="flex w-full max-w-[612px] flex-col gap-6">
        <p class="text-[24px] font-medium text-ink md:text-[32px]">
          &ldquo;{{ project.challenge }}&rdquo;
        </p>
        <ul
          v-if="project.challengePoints.length > 0"
          class="flex flex-col gap-2"
        >
          <li
            v-for="(point, i) in project.challengePoints"
            :key="i"
            class="flex items-center gap-2 text-[18px] text-neutral-800"
          >
            <MoveRight
              class="size-5 shrink-0 text-gold rtl:-scale-x-100"
              :stroke-width="1.5"
              aria-hidden="true"
            />
            {{ point }}
          </li>
        </ul>
      </div>
    </section>

    <!-- Goals — "Goal card" 1061:2072, row of 4, gap 24 -->
    <section
      v-if="project.goals.length > 0"
      class="will-reveal flex flex-col gap-12"
      data-reveal
    >
      <h2 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
        {{ t('work.goals') }}
      </h2>
      <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <li
          v-for="(card, i) in project.goals"
          :key="i"
          class="flex flex-col gap-6 rounded-sm border-t-[3px] border-t-gold bg-neutral-50/30 px-6 py-12"
        >
          <span class="text-[36px] font-medium leading-none text-gold">
            {{ String(i + 1).padStart(2, '0') }}
          </span>
          <span class="flex flex-col gap-2">
            <span class="text-[24px] font-medium text-neutral-900">{{ card.title }}</span>
            <span class="text-[18px] text-neutral-800">{{ card.description }}</span>
          </span>
        </li>
      </ol>
    </section>

    <!-- Strategy — 2×2, numbered, gold titles, hairline separators -->
    <section
      v-if="project.strategy.length > 0"
      class="will-reveal flex flex-col gap-10 lg:flex-row lg:justify-between"
      data-reveal
    >
      <h2 class="shrink-0 text-[32px] font-semibold text-neutral-900 md:text-[40px]">
        {{ t('work.strategy') }}
      </h2>
      <ol class="grid w-full max-w-[860px] gap-x-12 gap-y-10 sm:grid-cols-2">
        <li
          v-for="(card, i) in project.strategy"
          :key="i"
          class="flex flex-col gap-4 border-neutral-100 sm:[&:nth-child(odd)]:border-e sm:[&:nth-child(odd)]:pe-12 sm:[&:nth-child(-n+2)]:border-b sm:[&:nth-child(-n+2)]:pb-10"
        >
          <span class="text-label-md text-neutral-500">
            {{ String(i + 1).padStart(2, '0') }}
          </span>
          <h3 class="text-title-md text-gold">{{ card.title }}</h3>
          <p class="text-body-md text-neutral-700">{{ card.description }}</p>
        </li>
      </ol>
    </section>

    <!-- Deliverables — 3 across, numbered cards -->
    <section
      v-if="project.deliverables.length > 0"
      class="will-reveal flex flex-col gap-12"
      data-reveal
    >
      <h2 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
        {{ t('work.deliverables') }}
      </h2>
      <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <li
          v-for="(card, i) in project.deliverables"
          :key="i"
          class="flex flex-col gap-6 rounded-sm border border-gold-400/60 px-6 py-8"
        >
          <span class="text-[36px] font-medium leading-none text-gold">
            {{ String(i + 1).padStart(2, '0') }}
          </span>
          <span class="flex flex-col gap-2">
            <span class="text-[24px] font-medium text-neutral-900">{{ card.title }}</span>
            <span class="text-body-md text-neutral-700">{{ card.description }}</span>
          </span>
        </li>
      </ol>
    </section>

    <!-- Content Showcase — 1294:4995; images 400×500, radius 8, gap 24 -->
    <section
      v-if="project.showcase.length > 0"
      class="will-reveal flex flex-col gap-12"
      data-reveal
    >
      <h2 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
        {{ t('work.showcase') }}
      </h2>
      <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <li v-for="(image, i) in project.showcase" :key="i">
          <img
            :src="image.src"
            :srcset="image.srcset"
            :alt="image.alt"
            width="400"
            height="500"
            class="aspect-[4/5] w-full rounded-sm object-cover"
          />
        </li>
      </ul>
    </section>

    <!-- Results — 1349:8209; stat cards then summary -->
    <section
      v-if="project.results.length > 0"
      class="will-reveal flex flex-col gap-12"
      data-reveal
    >
      <h2 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
        {{ t('work.results') }}
      </h2>

      <ul class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-5">
        <li
          v-for="(stat, i) in project.results"
          :key="i"
          class="flex flex-col gap-4 rounded-sm bg-gold-100 px-8 py-4"
        >
          <component
            :is="resultIcons[i] || Target"
            class="size-8 text-gold"
            :stroke-width="1.5"
            aria-hidden="true"
          />
          <span class="flex flex-col gap-2">
            <span class="text-title-lg text-neutral-900">{{ stat.label }}</span>
            <span class="latin-nums text-[30px] font-medium leading-none text-gold">
              {{ stat.value }}
            </span>
          </span>
        </li>
      </ul>

      <!-- Summary 1349:8207 — Poppins Medium 24, black/800 -->
      <p v-if="project.resultsSummary" class="whitespace-pre-line text-[24px] font-medium text-neutral-800">
        {{ project.resultsSummary }}
      </p>
    </section>
    </div>

    <!-- Before / after — 1361:7094: row gap 24, columns 612, images 306 tall -->
    <section
      v-if="project.beforeAfter.before || project.beforeAfter.after"
      class="will-reveal grid gap-6 sm:grid-cols-2"
      data-reveal
    >
      <figure v-if="project.beforeAfter.before" class="flex flex-col gap-6">
        <figcaption class="text-center text-[28px] font-semibold text-neutral-900">
          {{ t('work.before') }}
        </figcaption>
        <img
          :src="project.beforeAfter.before.src"
          :alt="project.beforeAfter.before.alt"
          class="h-[306px] w-full rounded-sm object-cover shadow-[0_4px_10px_rgba(0,0,0,0.05)]"
        />
      </figure>
      <figure v-if="project.beforeAfter.after" class="flex flex-col gap-6">
        <figcaption class="text-center text-[28px] font-semibold text-neutral-900">
          {{ t('work.after') }}
        </figcaption>
        <img
          :src="project.beforeAfter.after.src"
          :alt="project.beforeAfter.after.alt"
          class="h-[306px] w-full rounded-sm object-cover shadow-[0_4px_10px_rgba(0,0,0,0.05)]"
        />
      </figure>
    </section>

    <!-- Next case study — 1033:2288 (column, gap 32) -->
    <section
      v-if="project.next"
      class="will-reveal flex flex-col gap-8"
      data-reveal
    >
      <p class="text-[24px] font-medium text-neutral-800">
        {{ t('work.next_case_study') }}
      </p>
      <Link
        :href="project.next.url"
        class="group inline-flex w-fit items-center gap-4 rounded-sm text-[36px] font-semibold text-neutral-1000 transition-colors hover:text-gold"
      >
        {{ project.next.title }}
        <ArrowRight
          class="size-8 transition-transform group-hover:translate-x-1 rtl:-scale-x-100 rtl:group-hover:-translate-x-1"
          :stroke-width="1.5"
          aria-hidden="true"
        />
      </Link>
    </section>
    </div>

    <!-- Final CTA card — Figma 1419:9333, closing block of 639:1617 -->
    <CtaBanner v-if="finalCta" :section="finalCta" />
  </div>
</template>
