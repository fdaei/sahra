<script setup lang="ts">
import PackageCheckIcon from "@/Components/Icons/PackageCheckIcon.vue";

interface PackageItem {
  id: number;
  value: string;
  label: string;
  suffix: string;
  title: string;
  description: string;
  badge: string;
  features: string[];
  footer: string;
}

defineProps<{
  section: {
    eyebrow: string;
    title: string;
    subtitle: string;
    description: string;
    content: string;
    primaryCta: { label: string; url: string } | null;
    items: PackageItem[];
  };
}>();
</script>

<template>
  <section
    class="relative isolate overflow-hidden bg-black py-12 text-paper md:py-24"
    data-figma-node="1419:9323"
  >
    <!--
      Section fill 1419:9323: the dune IMAGE paint sits in a box taller than
      what's visible — top 68.45% / height 43.35% of the 1440x1287 frame — so
      only its top ~73% shows before the frame edge crops the rest away. The
      outer box (this wrapper) is the visible window, sized off frame WIDTH so
      the crop ratio holds at any viewport; the image inside is the taller,
      object-cover'd source, clipped by the wrapper's overflow-hidden. Do not
      go back to a plain bottom-anchored `h-auto` <img> — that shows the
      image's full, uncropped natural aspect and reads noticeably
      brighter/stronger than the frame, which only ever shows the faded top
      slice.

      There is deliberately only ONE black layer: the section's own `bg-black`.
      A second absolutely-positioned black div used to sit under the image,
      which added no colour but did double the compositing and made the
      section read heavier than the frame at the seams.
    -->
    <div
      class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 aspect-[1440/406] w-full overflow-hidden opacity-40"
    >
      <img
        src="/images/sahra/packages-bg.png"
        alt=""
        class="absolute inset-x-0 top-0 aspect-[1440/558] w-full object-cover"
      />
    </div>

    <div class="mx-auto w-full max-w-[1248px] px-5 md:px-10 xl:px-0">
      <div class="flex flex-col gap-8 md:gap-12">
        <div class="eyebrow">{{ section.eyebrow }}</div>

        <div
          class="grid gap-6 lg:grid-cols-[506px_minmax(0,612px)] lg:justify-between lg:gap-[130px]"
        >
          <h2
            class="max-w-[506px] text-[26px] font-semibold leading-normal text-paper md:text-display-md"
          >
            {{ section.title }}
          </h2>
          <p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-100 md:text-title-sm">
            {{ section.subtitle }}
          </p>
        </div>
      </div>

      <!--
        Row `1195:3959` (the populated 3-card instance — 1419:9323 is a stale
        duplicate with only 2 unbadged cards and must not be used as the
        reference for this row). Cards are `align-items: center`, NOT
        stretch: card width is fixed (400/400/400 at the 1248 reference), but
        height is intrinsic per card. The featured instance (1195:3843) is
        532->565 = 33px taller than the side cards (1195:3804/1195:3920)
        purely from its own content — a 40px price (vs 32px) and a subtitle
        long enough to wrap to 2 lines — centered in the row so it sits
        16.5px above and 16.5px below the side cards. `items-stretch` here
        would force all three to equal height and silently erase that.
      -->
      <div
        class="mt-12 grid items-center gap-6 md:mt-18 md:grid-cols-2"
        :class="{ 'xl:grid-cols-3': section.items.length >= 3 }"
      >
        <article
          v-for="item in section.items"
          :key="item.id"
          class="package-card"
          :class="{ 'package-card--featured': item.badge }"
        >
          <div class="package-card__body">
            <div class="flex items-center gap-2">
              <h3 class="text-[24px] font-medium leading-none text-neutral-50 md:text-[28px]">
                {{ item.title }}
              </h3>
              <span
                v-if="item.badge"
                class="rounded-round bg-gold/15 px-2 py-1 text-[10px] leading-none text-paper md:text-label-md"
              >
                {{ item.badge }}
              </span>
            </div>

            <div>
              <p class="text-label-md leading-none text-neutral-200 md:text-label-lg">
                {{ item.label }}
              </p>
              <p class="mt-2 flex flex-wrap items-baseline gap-1 text-gold">
                <span
                  class="latin-nums leading-normal"
                  :class="item.badge ? 'text-[32px] md:text-[40px]' : 'text-[28px] md:text-[32px]'"
                  >{{ item.value }}</span
                >
                <span class="text-body-lg leading-normal text-gold-300 md:text-title-sm">{{
                  item.suffix
                }}</span>
              </p>
              <p class="mt-4 text-label-md leading-normal text-neutral-300 md:text-body-md">
                {{ item.description }}
              </p>
            </div>

            <div class="h-px bg-neutral-800" aria-hidden="true" />

            <ul class="flex flex-1 flex-col gap-4 md:gap-6">
              <li
                v-for="feature in item.features"
                :key="feature"
                class="flex items-center gap-[10px] text-body-lg leading-none text-neutral-100"
              >
                <!--
                  Check icon leads the label, per the `package checklist`
                  component set 1381:8863 — whose two variants are literally
                  named `ltr` and `rtl`, i.e. the icon sits on the reading-start
                  side and swaps with direction.

                  Nothing here is hard-coded per locale: this is an ordinary
                  flex row in logical flow, so `dir="rtl"` on <html> moves the
                  icon to the right on its own. Do not add `flex-row-reverse`
                  or an `rtl:` variant — that would double-flip it back.
                -->
                <PackageCheckIcon />
                <span class="min-w-0">{{ feature }}</span>
              </li>
            </ul>

            <div class="h-px bg-neutral-800" aria-hidden="true" />
          </div>

          <p class="text-center text-body-lg leading-none text-neutral-100">
            {{ item.footer }}
          </p>
        </article>
      </div>

      <div
        class="mt-12 flex items-end justify-between gap-4 rounded-sm border border-neutral-800 bg-white/[0.07] px-4 py-6 md:mt-18 md:items-center md:gap-8 md:px-16 md:py-16"
      >
        <div class="flex-1">
          <h3 class="text-title-sm leading-none text-paper md:text-title-lg">
            {{ section.content }}
          </h3>
          <p class="mt-3 text-label-md leading-none text-neutral-200 md:mt-2 md:text-body-lg md:text-neutral-100">
            {{ section.description }}
          </p>
        </div>
        <a
          v-if="section.primaryCta"
          :href="section.primaryCta.url"
          class="inline-flex min-h-11 shrink-0 items-center justify-center gap-1 rounded-sm border border-paper px-3 py-3 text-body-md text-paper transition-colors hover:bg-white/10 md:min-h-14 md:border-0 md:bg-gold-700 md:px-8 md:py-4 md:text-title-md md:text-ink md:hover:bg-gold-600"
        >
          {{ section.primaryCta.label }}
        </a>
      </div>
    </div>
  </section>
</template>

<style scoped>
/*
 | Package card — Figma `package content` 1195:3747.
 |
 | Geometry is taken verbatim from the frame: padding 32, column, gap 24,
 | radius 16, 1px #4F4C4D stroke, and the children share the width while the
 | trailing "Best for …" line hugs and centres (Figma `align-items: center`
 | with an `align-self: stretch` content frame — the same result as stretching
 | the body and centring only the footer, which is what the markup does).
 |
 | Values are written against the --spaceNN / --radiusLG aliases declared in
 | app.css so this reads as the design system rather than as loose pixels; the
 | fallbacks keep it correct if the stylesheet order ever changes.
 */
.package-card {
  display: flex;
  min-width: 0;
  flex-direction: column;
  align-items: stretch;
  gap: var(--space24, 24px);
  padding: var(--space32, 32px);
  border: 1px solid #4f4c4d;
  border-radius: var(--radiusLG, 16px);
  /* Base card: white 7% over black 70% — no gold. */
  background:
    linear-gradient(0deg, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0.07) 100%),
    rgba(0, 0, 0, 0.7);
}

.package-card__body {
  display: flex;
  flex: 1 0 0;
  flex-direction: column;
  gap: var(--space24, 24px);
}

/*
 | Featured ("Most Popular") card — `package content` instance 1195:3843 in
 | the populated 3-card row `1195:3959` (not the unbadged pair on 1419:9323,
 | which is a stale duplicate with no featured example at all). Same 7% white
 | overlay as every other card, plus a second gold ramp layer: 180deg,
 | transparent at 19.41% down to gold/40% at 118.87% (past the bottom edge,
 | so the box only ever shows the rising tail of the ramp, not full-strength
 | gold). Height is NOT set here — see the grid's `items-center` — the extra
 | 33px comes from this card's own larger price text and wrapped subtitle.
 */
.package-card--featured {
  background:
    linear-gradient(0deg, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0.07) 100%),
    linear-gradient(180deg, rgba(0, 0, 0, 0) 19.41%, rgba(189, 147, 59, 0.4) 118.87%),
    rgba(0, 0, 0, 0.7);
}

/*
 | Mobile card ("package content" 1687:11332 / 1419:9331 / 1696:11712, all
 | inside the mobile "packages" frame 1696:11854): cards stack instead of
 | sitting side by side, and Figma gives each an explicit height rather than
 | letting it size from content — 421px for the two plain cards, 442px for
 | the featured one (21px taller purely from its own instance, same as the
 | desktop row's 33px — see the featured-card comment above).
 */
@media (max-width: 767px) {
  .package-card {
    height: 421px;
    padding: var(--space24, 24px);
    gap: var(--space16, 16px);
  }

  .package-card--featured {
    height: 442px;
  }

  .package-card__body {
    gap: var(--space16, 16px);
  }
}
</style>
