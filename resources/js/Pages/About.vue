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

  <section class="section-first relative overflow-hidden pb-[128px]">
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

    <div class="container-sahra relative flex flex-col gap-24 lg:gap-[200px]">
      <!-- Hero — Figma 1043:1735 -->
      <div
        v-if="hero"
        class="flex flex-col items-center gap-12 lg:flex-row lg:justify-between lg:gap-[100px] xl:gap-[250px]"
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
                class="block font-display text-[44px] font-normal leading-none tracking-[-0.01em] text-gold md:text-[76px]"
                >{{ hero.title }}</span
              >
              <span
                v-if="hero.content"
                class="mt-2 block text-[26px] font-medium leading-[1.2] tracking-[-0.02em] text-neutral-900 md:text-[40px]"
                :style="{ color: hero.colors.content || undefined }"
                >{{ hero.content }}</span
              >
            </h1>
            <p
              class="text-title-sm font-medium text-neutral-700"
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
          class="w-[240px] shrink-0 object-contain lg:w-[321px]"
          :aria-hidden="heroImage ? undefined : 'true'"
        />
      </div>

      <!-- Story — Figma 1288:4149 -->
      <div
        v-if="story"
        class="flex flex-col gap-8 lg:flex-row lg:justify-between lg:gap-[166px]"
      >
        <!--
          Heading — Figma I1319:6508;1186:4909: Poppins SemiBold 40, black/900
          #393637, leading `normal`. The `display-md` token bakes in
          line-height 1.5, which is 25% looser than the file, so leading is
          overridden here; colour is set explicitly because the token carries
          none and the inherited body ink is black/1000, one step too dark.
        -->
        <h2
          class="text-display-md leading-[1.2] text-neutral-900 lg:max-w-[472px] lg:shrink-0"
          :style="{ color: story.colors.title || undefined }"
        >
          {{ story.title }}
        </h2>

        <div class="flex flex-col gap-6 lg:max-w-[612px]">
          <p
            class="text-title-sm font-medium text-neutral-700"
            :style="{ color: story.colors.description || undefined }"
          >
            {{ story.description }}
          </p>
          <p
            v-if="story.content"
            class="text-title-sm font-medium text-neutral-700"
            :style="{ color: story.colors.content || undefined }"
          >
            {{ story.content }}
          </p>
        </div>
      </div>

      <!-- How we think — Figma 1288:4182 -->
      <div v-if="howWeThink" class="flex flex-col gap-12">
        <div
          class="flex flex-col gap-6 lg:flex-row lg:justify-between lg:gap-[348px]"
        >
          <h2
            class="text-display-md lg:shrink-0"
            :style="{ color: howWeThink.colors.title || undefined }"
          >
            {{ howWeThink.title }}
          </h2>
          <p
            class="text-title-sm font-medium text-neutral-700 lg:max-w-[612px]"
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
            class="flex flex-col gap-6 rounded-sm border-t-[3px] border-t-gold bg-neutral-50/30 px-6 py-12"
          >
            <img
              :src="item.icon || '/icons/sahra/goal.svg'"
              alt=""
              width="32"
              height="32"
              class="size-8"
            />
            <div class="flex flex-col gap-2">
              <h3 class="text-title-xl text-neutral-900">{{ item.title }}</h3>
              <p class="text-title-sm text-neutral-800">
                {{ item.description }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Team — Figma 1288:4194 -->
      <div v-if="team" class="relative isolate flex flex-col gap-24">
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
            class="max-w-[287px] text-display-md leading-normal [text-wrap:initial] lg:shrink-0"
            :style="{ color: team.colors.title || undefined }"
          >
            {{ team.title }}
          </h2>
          <p
            class="text-title-xl text-neutral-800 lg:max-w-[612px]"
            :style="{ color: team.colors.description || undefined }"
          >
            {{ team.description }}
          </p>
        </div>

        <!-- member card — Figma 992:2644 -->
        <div
          class="relative z-10 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-5 lg:gap-[26px]"
        >
          <figure
            v-for="(member, i) in props.team"
            :key="i"
            class="flex flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60"
          >
            <!--
              Figma renders every member portrait desaturated (992:2644) while
              the source uploads are colour, so the grayscale is applied here
              rather than baked into the asset — an admin can swap the photo in
              Filament without having to pre-process it.
            -->
            <img
              v-if="member.image"
              :src="member.image.src"
              :srcset="member.image.srcset"
              :alt="member.image.alt"
              :width="member.image.width"
              :height="member.image.height"
              class="aspect-square w-full rounded-sm object-cover grayscale"
            />
            <div
              v-else
              class="aspect-square w-full rounded-sm bg-neutral-100"
            />

            <figcaption class="flex flex-col gap-1 px-4 py-2">
              <p class="text-title-lg text-neutral-900">{{ member.name }}</p>
              <p class="text-title-sm text-neutral-600">{{ member.role }}</p>
            </figcaption>
          </figure>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1319:6658 (shared component 1419:9333) -->
  <CtaBanner v-if="sections.final_cta" :section="sections.final_cta" />
</template>
