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

/*
 | Figma 951:3598 — the arch sculpture cutout beside the hero copy. It is
 | page furniture rather than authored content, so it ships as a static
 | export (see docs/ASSET-MANIFEST.md) and the CMS image, when one is set,
 | takes precedence.
 */
const heroImage = computed(() => hero.value?.image ?? null);
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
      <div v-if="howWeThink" class="mt-[81px] flex h-[759px] flex-col gap-8 md:gap-12 lg:mt-0 lg:h-auto">
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
            class="text-body-md text-neutral-700 md:text-title-sm md:font-medium lg:max-w-[612px]"
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
            class="flex flex-col gap-4 rounded-sm border border-gold-400 px-6 py-6 md:gap-6 md:border-x-0 md:border-b-0 md:border-t-[3px] md:bg-neutral-50/30 md:py-12"
          >
            <img
              :src="item.icon || '/icons/sahra/goal.svg'"
              alt=""
              width="32"
              height="32"
              class="size-5 md:size-8"
            />
            <div class="flex flex-col gap-2">
              <h3 class="text-[16px] font-medium text-neutral-900 md:text-title-xl">{{ item.title }}</h3>
              <p class="text-[12px] text-neutral-800 md:text-title-sm">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Team — Figma 1288:4194 -->
      <div v-if="team" class="relative isolate mt-[98px] flex h-[381px] flex-col gap-12 md:gap-24 lg:mt-0 lg:h-auto">
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

        <!-- member card — Figma 992:2644 -->
        <div
          class="relative z-10 flex gap-4 overflow-hidden md:grid md:grid-cols-3 md:gap-6 lg:grid-cols-5 lg:gap-[26px]"
        >
          <figure
            v-for="(member, i) in props.team"
            :key="i"
            class="flex w-[174px] shrink-0 flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60 md:w-auto"
          >
            <!--
              The Figma source portraits are colour. Keep the resting state
              desaturated and reveal the original colour when the portrait is
              hovered or keyboard-focused.
            -->
            <img
              v-if="member.image"
              :src="member.image.src"
              :srcset="member.image.srcset"
              :alt="member.image.alt"
              :width="member.image.width"
              :height="member.image.height"
              class="aspect-square w-full rounded-sm object-cover grayscale transition-[filter] duration-300 hover:grayscale-0 focus-visible:grayscale-0 motion-reduce:transition-none"
            />
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
  </section>

  <!-- Final CTA — Figma 1319:6658 (shared component 1419:9333) -->
  <CtaBanner
    v-if="sections.final_cta"
    :section="sections.final_cta"
    spacing-class="pb-[327px] pt-24 md:pb-[280px]"
  />
</template>
