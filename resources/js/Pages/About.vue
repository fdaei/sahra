<script setup lang="ts">
/**
 * About page — Figma node 908:1576 (desktop) / 1557:12225 (mobile).
 *
 * Layout follows the file's own stack (body 1728:11750, col gap 200):
 *   hero 1043:1735   — space-between row, 506 text column + 321x405 cutout
 *   story 1288:4149  — space-between row, 40/600 title against a 612 column
 *   think 1288:4182  — header row, then four Goal cards (1061:2072) at gap 24
 *   team 1288:4194   — header row, then member cards (992:2644) 5 per row
 *
 * Section keys match App\Enums\SectionType (about_hero, story, how_we_think,
 * team) seeded by database/seeders/PageSeeder.php@about — see
 * docs/TRACEABILITY.md for the node mapping.
 */
import { computed } from "vue";
import { BadgeCheck, Focus, Repeat2, TrendingUp } from "lucide-vue-next";
import arcRings from "~img/decor/arc-rings.svg";
/*
 | Dune contours — Figma 979:1394, the texture behind the team header.
 |
 | Shipped as a raster, not as the exported vector: the source SVG is 345
 | contour paths totalling 1.09 MB gzipped (699 KB even after rounding
 | coordinates to 1dp), which is far too much for decoration. Rasterising at
 | 2x is worse still (1.7 MB — fine 1px lines are high-frequency detail that
 | lossy codecs handle badly), so this is 0.75x/q55 at 215 KB, upscaled by CSS.
 | The artwork is a faint 0.2-opacity texture, so the softness does not read.
 | It is lazy-loaded and desktop-only, both of which the design supports.
 */
import duneContours from "~img/decor/dune-contours.webp";
import SeoHead from "@/Components/SeoHead.vue";
import CtaBanner from "@/Components/CtaBanner.vue";
import type { SeoMeta, TeamMemberItem } from "@/types";

interface SectionContent {
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
  items: Array<{
    value: string;
    title: string;
    description: string;
    icon: string | null;
  }>;
}

const props = defineProps<{
  sections: Record<string, SectionContent>;
  team: TeamMemberItem[];
  seo: SeoMeta;
}>();

const hero = computed(() => props.sections.about_hero);
const story = computed(() => props.sections.story);
const howWeThink = computed(() => props.sections.how_we_think);
const team = computed(() => props.sections.team);
const thinkIcons = [BadgeCheck, Focus, Repeat2, TrendingUp];

/*
 | Figma 951:3598 — the arch sculpture cutout beside the hero copy. It is
 | page furniture rather than authored content, so it ships as a static
 | export (see docs/ASSET-MANIFEST.md) and the CMS image, when one is set,
 | takes precedence.
 */
const heroImage = computed(() => hero.value?.image ?? null);

/*
 | Team rows — Figma 1288:4194.
 |
 | The frame lays the team out as TWO rows of member cards, and both run PAST
 | the left and right edges of the 1248 track rather than fitting inside it —
 | the first and last card of each row are clipped by the frame. That is a
 | travelling band, not a static grid, which is what this was built as.
 |
 | Row 1 travels toward the inline end, row 2 toward the inline start, so the
 | block reads as one slow counter-rotating unit.
 |
 | Construction matches the Home marquees: a row is rendered TWICE and the
 | track translates exactly -50%, so the second copy lands where the first
 | began. That also means one half has to be wider than the viewport or the row
 | visibly runs out mid-loop — and the seeded team can hold as few as two
 | people — so each half repeats the source list until it covers a wide
 | desktop. Card 228 + gap 26 = 254 per item at lg.
 */
const TEAM_ITEM_WIDTH = 254;
const TEAM_TRACK_COVER = 2560;
const MOBILE_TEAM_ITEM_WIDTH = 190;
const MOBILE_TEAM_TRACK_COVER = 800;

const mobileTeamTrack = computed(() => {
  if (props.team.length === 0) return { items: [], uniqueCount: 0 };

  const repeats = Math.max(
    1,
    Math.ceil(MOBILE_TEAM_TRACK_COVER / MOBILE_TEAM_ITEM_WIDTH / props.team.length),
  );
  const half = Array.from({ length: repeats }, () => props.team).flat();

  return { items: [...half, ...half], uniqueCount: props.team.length };
});

const teamRows = computed(() => {
  const members = props.team;
  if (members.length === 0) return [];

  const split = Math.ceil(members.length / 2);

  return [members.slice(0, split), members.slice(split)]
    .filter((row) => row.length > 0)
    .map((row) => {
      const repeats = Math.max(
        1,
        Math.ceil(TEAM_TRACK_COVER / TEAM_ITEM_WIDTH / row.length),
      );
      const half = Array.from({ length: repeats }, () => row).flat();

      // `uniqueCount` marks where the repeats begin, so screen readers
      // announce each colleague once instead of N times.
      return { items: [...half, ...half], uniqueCount: row.length };
    });
});
</script>

<template>
  <SeoHead :meta="seo" />

  <section class="relative overflow-hidden pb-0 pt-[139px] md:pb-[128px] md:pt-[192px]">
    <!--
      Arc rings — Figma 951:3589 "Clip path group", x=672 y=-506, 1500x1320.
      Six concentric gold ellipse strokes (#BD933B at 0.2, 2.19 width) that
      enter from above the frame and run off its right edge; the frame clips
      them on both sides, which is why the section is `overflow-hidden`.

      Offsets are measured against the 1440 frame, so they are applied inside a
      centred max-w-frame box rather than the viewport — otherwise the rings
      would drift away from the content on wide screens. `start-*` keeps the
      composition mirrored in RTL, where the sculpture sits on the left.
    -->
    <div
      class="pointer-events-none absolute inset-0 overflow-hidden"
      aria-hidden="true"
    >
      <div class="relative mx-auto h-full w-full max-w-frame">
        <img
          :src="arcRings"
          alt=""
          width="1500"
          height="1320"
          class="absolute -top-[506px] start-[672px] w-[1500px] max-w-none"
        />
      </div>
    </div>

    <div class="container-sahra relative flex flex-col gap-0 lg:gap-[200px]">
      <!-- Hero — Figma 1043:1735 -->
      <div
        v-if="hero"
        class="grid h-[340px] grid-cols-[1fr_151px] items-start gap-[14px] lg:flex lg:h-auto lg:flex-row lg:items-center lg:justify-between lg:gap-[100px] xl:gap-[250px]"
      >
        <div class="flex w-full flex-col gap-12 lg:max-w-[506px]">
          <p
            class="eyebrow"
            :style="{ color: hero.colors.eyebrow || undefined }"
          >
            {{ hero.eyebrow }}
          </p>

          <!--
            Title — Figma 1288:4165. One heading, two runs:
              title    "We are Sahra"       Idealist Regular 76 / gold #BD933B
                                            / tracking -0.76px, leading normal
              content  "A digital marketing Poppins Medium 40 / black-900
                        agency rooted in    #393637 / tracking -0.8px
                        Oman"
            Kept as two translatable fields (like the Home hero's three runs)
            so each locale can reorder or re-split them. No type token matches:
            `display-md` is 40/600/1.5 against this run's 40/500/normal.
            Mobile sizes are derived — the file has no tablet frames (audit G1).
          -->
          <div class="flex flex-col gap-6">
            <h1 :style="{ color: hero.colors.title || undefined }">
              <span
                class="block font-display text-[32px] font-normal leading-none tracking-[-0.01em] text-gold md:text-[76px]"
                >{{ hero.title }}</span
              >
              <span
                v-if="hero.content"
                class="mt-2 block text-[22px] font-medium leading-normal tracking-[-0.02em] text-neutral-900 md:text-[40px]"
                :style="{ color: hero.colors.content || undefined }"
                >{{ hero.content }}</span
              >
            </h1>
            <p
              class="text-body-md text-neutral-700 md:text-title-sm md:font-medium"
              :style="{ color: hero.colors.description || undefined }"
            >
              {{ hero.description }}
            </p>
          </div>
        </div>

        <img
          :src="heroImage?.src ?? '/images/sahra/about-hero-sculpture.png'"
          :alt="heroImage?.alt ?? ''"
          width="321"
          height="405"
          class="w-[151px] shrink-0 object-contain lg:w-[321px]"
          :aria-hidden="heroImage ? undefined : 'true'"
        />
      </div>

      <!-- Story — Figma 1288:4149 -->
      <div
        v-if="story"
        class="mt-[115px] flex h-[313px] flex-col gap-8 lg:mt-0 lg:h-auto lg:flex-row lg:justify-between lg:gap-[166px]"
      >
        <!--
          Heading — Figma I1319:6508;1186:4909: Poppins SemiBold 40, black/900
          #393637, leading `normal`. The `display-md` token bakes in
          line-height 1.5, which is 25% looser than the file, so leading is
          overridden here; colour is set explicitly because the token carries
          none and the inherited body ink is black/1000, one step too dark.
        -->
        <h2
          class="text-[22px] font-semibold leading-normal text-neutral-900 md:text-display-md lg:max-w-[472px] lg:shrink-0"
          :style="{ color: story.colors.title || undefined }"
        >
          {{ story.title }}
        </h2>

        <div class="flex flex-col gap-6 lg:max-w-[612px]">
          <p
            class="text-body-md text-neutral-700 md:text-title-sm md:font-medium"
            :style="{ color: story.colors.description || undefined }"
          >
            {{ story.description }}
          </p>
          <p
            v-if="story.content"
            class="text-body-md text-neutral-700 md:text-title-sm md:font-medium"
            :style="{ color: story.colors.content || undefined }"
          >
            {{ story.content }}
          </p>
        </div>
      </div>

      <!-- How we think — Figma 1288:4182 -->
      <div v-if="howWeThink" class="mt-[81px] flex h-[759px] flex-col gap-[51px] md:gap-12 lg:mt-0 lg:h-auto">
        <div
          class="flex flex-col gap-6 lg:flex-row lg:justify-between lg:gap-[348px]"
        >
          <h2
            class="text-[22px] font-semibold md:text-display-md lg:shrink-0"
            :style="{ color: howWeThink.colors.title || undefined }"
          >
            {{ howWeThink.title }}
          </h2>
          <p
            class="hidden text-body-md text-neutral-700 md:block md:text-title-sm md:font-medium lg:max-w-[612px]"
            :style="{ color: howWeThink.colors.description || undefined }"
          >
            {{ howWeThink.description }}
          </p>
        </div>

        <!-- Goal card — Figma 1061:2072 -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="(item, i) in howWeThink.items"
            :key="i"
            class="flex flex-col gap-4 rounded-sm border-x border-b border-t-[3px] border-gold-400 border-t-gold bg-neutral-50/30 p-6 md:gap-6 md:border-x-0 md:border-b-0 md:py-12"
          >
            <!--
              Goal card icon — Figma 1061:2072. The default
              `/icons/sahra/goal.svg` was a Figma export of lucide `trending-up`
              with gold baked into its stroke; the component carries the same
              glyph and takes its colour from the class, per brief §12. A CMS
              icon still wins where an editor has set one.
            -->
            <img
              v-if="item.icon"
              :src="item.icon"
              alt=""
              width="32"
              height="32"
              class="size-5 md:size-8"
            />
            <component
              v-else
              :is="thinkIcons[i] || TrendingUp"
              class="size-5 shrink-0 text-gold md:size-8"
              :stroke-width="1.5"
              aria-hidden="true"
            />
            <div class="flex flex-col gap-2">
              <h3 class="text-[18px] font-medium text-neutral-900 md:text-title-xl">{{ item.title }}</h3>
              <p class="text-[14px] text-neutral-800 md:text-title-sm">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Team — Figma 1288:4194 -->
      <div v-if="team" class="relative isolate mt-[98px] flex flex-col gap-12 md:gap-24 lg:mt-0">
        <!--
          Dune contours 979:1394 — x=37 y=-104, 1160x1000 within the 1248 team
          track, so it bleeds above the header and sits behind the copy. Hidden
          below lg: the mobile frame (1557:12225) has no contour layer.
        -->
        <img
          :src="duneContours"
          alt=""
          aria-hidden="true"
          loading="lazy"
          decoding="async"
          width="1160"
          height="1000"
          class="pointer-events-none absolute -top-[104px] start-[37px] z-0 hidden w-[1160px] max-w-none opacity-100 lg:block"
        />
        <div
          class="relative z-10 flex flex-col gap-6 lg:flex-row lg:justify-between lg:gap-[328px]"
        >
          <h2
            class="max-w-[287px] text-[22px] font-semibold leading-normal [text-wrap:initial] md:text-display-md lg:shrink-0"
            :style="{ color: team.colors.title || undefined }"
          >
            {{ team.title }}
          </h2>
          <p
            class="hidden text-title-xl text-neutral-800 md:block lg:max-w-[612px]"
            :style="{ color: team.colors.description || undefined }"
          >
            {{ team.description }}
          </p>
        </div>

        <!--
          member card — Figma 992:2644, laid out as two counter-travelling
          rows (see `teamRows`). Each row is its own clipped viewport; the
          `.marquee-mask` edge fade means a card is never chopped in half at
          the boundary, and hovering the row pauses it so a name can be read.
        -->
        <!-- Mobile frame 1557:12225 has one clipped horizontal row containing
             all four members. Splitting the data into the two desktop marquee
             rows added an entire extra card row and made the page ~250px too
             tall at 402px. -->
        <div class="marquee-mask relative z-10 overflow-hidden lg:hidden">
          <div class="marquee-track gap-4" style="--marquee-duration: 32s">
            <figure
              v-for="(member, i) in mobileTeamTrack.items"
              :key="i"
              class="flex w-[174px] shrink-0 flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60"
              :aria-hidden="i >= mobileTeamTrack.uniqueCount ? 'true' : undefined"
            >
              <div v-if="member.image" class="aspect-square w-full overflow-hidden rounded-sm">
                <img
                  :src="member.image.src"
                  :srcset="member.image.srcset"
                  :alt="i >= mobileTeamTrack.uniqueCount ? '' : member.image.alt"
                  :width="member.image.width"
                  :height="member.image.height"
                  class="size-full object-cover grayscale transition-[filter,transform] duration-500 ease-brand hover:scale-[1.06] hover:grayscale-0 focus-visible:scale-[1.06] focus-visible:grayscale-0 motion-reduce:transition-none"
                />
              </div>
              <div v-else class="aspect-square w-full rounded-sm bg-neutral-100" />
              <figcaption class="flex flex-col gap-1 px-3 py-2">
                <p class="text-[14px] font-medium text-neutral-900">{{ member.name }}</p>
                <p class="text-[12px] text-neutral-600">{{ member.role }}</p>
              </figcaption>
            </figure>
          </div>
        </div>

        <div class="relative z-10 hidden flex-col gap-[26px] lg:flex">
          <div
            v-for="(row, rowIndex) in teamRows"
            :key="rowIndex"
            class="marquee-mask overflow-hidden"
          >
            <!--
              Row 1 runs toward the inline end, row 2 toward the inline start.
              `marquee-track--reverse` flips the base animation and is itself
              re-flipped under RTL, so the two rows stay mirror images of each
              other in every locale rather than both sliding the same way.
            -->
            <div
              class="marquee-track gap-4 md:gap-6 lg:gap-[26px]"
              :class="rowIndex % 2 === 0 ? 'marquee-track--reverse' : ''"
              :style="{ '--marquee-duration': rowIndex % 2 === 0 ? '60s' : '68s' }"
            >
              <figure
                v-for="(member, i) in row.items"
                :key="i"
                class="flex w-[174px] shrink-0 flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60 lg:w-[228px]"
                :aria-hidden="i >= row.uniqueCount ? 'true' : undefined"
              >
                <!--
                  The Figma source portraits are colour. Keep the resting state
                  desaturated and reveal the original colour when the portrait is
                  hovered or keyboard-focused.
                -->
                <div v-if="member.image" class="aspect-square w-full overflow-hidden rounded-sm">
                  <img
                    :src="member.image.src"
                    :srcset="member.image.srcset"
                    :alt="i >= row.uniqueCount ? '' : member.image.alt"
                    :width="member.image.width"
                    :height="member.image.height"
                    class="size-full object-cover grayscale transition-[filter,transform] duration-500 ease-brand hover:scale-[1.06] hover:grayscale-0 focus-visible:scale-[1.06] focus-visible:grayscale-0 motion-reduce:transition-none"
                  />
                </div>
                <div
                  v-else
                  class="aspect-square w-full rounded-sm bg-neutral-100"
                />

                <figcaption class="flex flex-col gap-1 px-3 py-2 md:px-4">
                  <p class="text-[14px] font-medium text-neutral-900 md:text-title-lg">{{ member.name }}</p>
                  <p class="text-[12px] text-neutral-600 md:text-title-sm">{{ member.role }}</p>
                </figcaption>
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1319:6658 (shared component 1419:9333) -->
  <CtaBanner
    v-if="sections.final_cta"
    :section="sections.final_cta"
    spacing-class="pb-[353px] pt-24 md:pb-[280px]"
  />
</template>
