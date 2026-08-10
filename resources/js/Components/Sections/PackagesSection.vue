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
    class="relative isolate h-[1852px] overflow-hidden bg-black py-14 text-paper md:h-auto md:py-24 lg:py-28"
    data-figma-node="1419:9323"
  >
    <!--
      Section fill 1419:9323 is a single IMAGE paint anchored to the bottom at
      its natural aspect ratio over a flat #000000 base, carried at 40% so the
      dune reads as a texture rather than a photograph. It must not cover the
      section height: the large black area above it is part of the composition.

      There is deliberately only ONE black layer: the section's own `bg-black`.
      A second absolutely-positioned black div used to sit under the image,
      which added no colour but did double the compositing and made the
      section read heavier than the frame at the seams.
    -->
    <img
      src="/images/sahra/packages-bg.png"
      alt=""
      class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 h-auto w-full opacity-40"
    />

    <div class="mx-auto w-full max-w-[1248px] px-5 md:px-10 xl:px-0">
      <div class="flex flex-col gap-8 md:gap-12">
        <div class="packages-eyebrow">{{ section.eyebrow }}</div>

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

      <div
        class="mt-10 grid items-stretch gap-4 md:mt-18 md:grid-cols-2 md:gap-6"
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
              <h3 class="text-[22px] font-medium leading-none text-neutral-50 md:text-[28px]">
                {{ item.title }}
              </h3>
              <span
                v-if="item.badge"
                class="rounded-round bg-gold/15 px-2 py-1 text-label-md leading-none text-paper"
              >
                {{ item.badge }}
              </span>
            </div>

            <div>
              <p class="text-label-lg leading-none text-neutral-200">
                {{ item.label }}
              </p>
              <p class="mt-2 flex flex-wrap items-baseline gap-1 text-gold">
                <span class="latin-nums text-[32px] leading-none">{{
                  item.value
                }}</span>
                <span class="text-title-sm leading-none text-gold-300">{{
                  item.suffix
                }}</span>
              </p>
              <p class="mt-4 text-body-md leading-normal text-neutral-300">
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
        class="mt-10 flex flex-col gap-5 rounded-sm border border-neutral-800 bg-white/[0.07] p-4 md:mt-18 md:flex-row md:items-center md:justify-between md:gap-8 md:px-16 md:py-16"
      >
        <div>
          <h3 class="text-title-lg font-medium leading-none text-paper">
            {{ section.content }}
          </h3>
          <p class="mt-2 text-body-lg leading-none text-neutral-100">
            {{ section.description }}
          </p>
        </div>
        <a
          v-if="section.primaryCta"
          :href="section.primaryCta.url"
          class="inline-flex min-h-14 shrink-0 items-center justify-center rounded-sm bg-gold-700 px-8 py-4 text-title-md font-medium leading-none text-ink transition-colors hover:bg-gold-600"
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
 | Featured ("Most Popular") card.
 |
 | The gold is a BOTTOM-UP glow, not a diagonal tint: the 180deg ramp starts
 | fully transparent above the card (-19.41%) and only reaches gold/40% below
 | it (118.87%), so the visible band is the tail of the ramp — a soft light
 | rising off the bottom edge and dissolving well before the title. Both stops
 | sit outside 0–100% on purpose; clamping them to 0/100 turns it back into
 | the flat gold wash this replaced.
 */
.package-card--featured {
  background:
    linear-gradient(0deg, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0.07) 100%),
    linear-gradient(180deg, rgba(0, 0, 0, 0) -19.41%, rgba(189, 147, 59, 0.4) 118.87%),
    rgba(0, 0, 0, 0.7);
}

@media (max-width: 767px) {
  .package-card {
    padding: var(--space16, 16px);
  }
}

.packages-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  color: var(--color-gold);
  font-family: Idealist, 'Doran FaNum', Vazirmatn, serif;
  font-size: 24px;
  line-height: 1;
}

.packages-eyebrow::before {
  width: 8px;
  height: 8px;
  flex: none;
  border-radius: 9999px;
  background: var(--color-gold);
  box-shadow:
    -2px -2px 12px rgb(189 147 59 / 50%),
    2px 2px 12px rgb(189 147 59 / 50%);
  content: "";
}
</style>
