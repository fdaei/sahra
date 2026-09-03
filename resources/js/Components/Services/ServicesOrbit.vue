<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useTranslations } from "@/Composables/useTranslations";
import MasteryDiagram from "@/Components/Services/MasteryDiagram.vue";
import type { ServiceItem, SharedProps } from "@/types";

interface ServiceSection {
  eyebrow: string;
  title: string;
  description: string;
  orbitBrandLabel?: string;
  orbitProductLabel?: string;
  orbitCoreLabel?: string;
}
const props = defineProps<{
  section: ServiceSection;
  services: ServiceItem[];
}>();
const { t } = useTranslations();
const page = usePage<SharedProps>();
const root = ref<HTMLElement | null>(null);
const visible = ref(false);
let observer: IntersectionObserver | null = null;
let revealTimer: number | null = null;
/*
 | One brand colour, four steps of it.
 |
 | These were four unrelated hues (yellow / cyan / violet / pink) carried over
 | from the motion reference's own palette. Sahra is black-and-gold, so the
 | cards vary along the gold ramp instead — the tints read apart from each
 | other on the near-black pill, which flat gold at four opacities does not:
 | over ink, low-alpha gold just goes muddy.
 */
/*
 | Horizontal offset per card, in px from the column centre.
 |
 | The reference distributes its primary services down four rows and staggers
 | them sideways; with four cards instead of seven we get one per row, so the
 | stagger is what stops the column reading as a centred stack.
 |
 | Symmetric on purpose — centre, right, left, centre. Offsetting the first and
 | last rows too made the group read as a staircase leaning one way, where the
 | reference's cluster is balanced about the centre line. Logical inset, so it
 | mirrors in RTL.
 */
const activePositions = [
  { x: 50, y: 27 },
  { x: 35, y: 39 },
  { x: 65, y: 39 },
  { x: 31, y: 53 },
  { x: 50, y: 53 },
  { x: 38, y: 68 },
  { x: 64, y: 68 },
];

const accents = [
  "var(--color-gold)",
  "var(--color-gold-900)",
  "var(--color-gold-600)",
  "var(--color-gold-500)",
];
const cards = computed(() =>
  props.services
    .filter((service) => service.homeOrbitGroup === "active")
    .map((service, index) => ({
    ...service,
    href:
      service.externalUrl ||
      `/${page.props.locale.current}/services#${service.slug}`,
    accent: accents[index % accents.length],
    position: activePositions[index % activePositions.length],
    })),
);
/*
 | How far each outer entry leans toward the centre, in px, by row.
 |
 | The reference does not stack its outer services in a straight column — they
 | bow away from the middle around the row below the axis and come back in at
 | the top and bottom, so the two groups read as arcs framing the orbit rather
 | than as two rules. These follow the same near / mid / far / mid rhythm.
 |
 | The product side has five entries in four rows, so its first two share the
 | top row's value.
 */
const brandPositions = [
  { x: 18, y: 23 },
  { x: 11, y: 38 },
  { x: 14, y: 64 },
  { x: 21, y: 79 },
];
const productPositions = [
  { x: 82, y: 21 },
  { x: 90, y: 36 },
  { x: 86, y: 61 },
  { x: 80, y: 76 },
  { x: 88, y: 87 },
];

const brandGhosts = computed(() =>
  props.services.filter((service) => service.homeOrbitGroup === "brand"),
);
const productGhosts = computed(() =>
  props.services.filter((service) => service.homeOrbitGroup === "product"),
);

onMounted(() => {
  if (
    !root.value ||
    window.matchMedia("(prefers-reduced-motion: reduce)").matches
  ) {
    visible.value = true;
    return;
  }
  observer = new IntersectionObserver(
    ([entry]) => {
      if (!entry?.isIntersecting) return;
      // Late on purpose: the pills belong to the finished composition, so
      // they arrive while the dark material is already thinning onto the axis
      // rather than competing with it for attention.
      revealTimer = window.setTimeout(() => {
        visible.value = true;
      }, 1200);
      observer?.disconnect();
    },
    { threshold: 0.2 },
  );
  observer.observe(root.value);
});
onBeforeUnmount(() => {
  observer?.disconnect();
  if (revealTimer !== null) window.clearTimeout(revealTimer);
});
</script>

<template>
  <!--
    Opted out of the page-level reveal: this section choreographs its own
    entrance, and the generic opacity lift would hold the opening Venn
    half-transparent through the first third of the transformation.
  -->
  <section
    ref="root"
    class="services-cloud"
    :class="{ 'is-visible': visible }"
    data-no-reveal
  >
    <div class="container-sahra relative z-10 py-12 md:py-20 lg:py-24">
      <div class="flex flex-col gap-6 lg:gap-12">
        <div class="service-eyebrow">
          <span aria-hidden="true" />{{
            section.eyebrow || t("services.eyebrow")
          }}
        </div>
        <div class="grid gap-4 lg:grid-cols-[506px_1fr] lg:gap-[130px]">
          <h2
            class="max-w-[506px] text-[28px] font-semibold leading-normal text-white md:text-[36px] lg:text-[40px] lg:leading-[1.5]"
          >
            {{ section.title }}
          </h2>
          <p
            class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-200 md:text-[18px]"
          >
            {{ section.description }}
          </p>
        </div>
      </div>

      <div
        class="cloud-diagram"
        role="group"
        :aria-label="t('services.orbit_label')"
      >
        <MasteryDiagram
          :brand-label="section.orbitBrandLabel || t('services.venn_brand')"
          :product-label="section.orbitProductLabel || t('services.venn_product')"
          :core-label="section.orbitCoreLabel || t('services.core')"
        />
        <div class="services-grid">
          <div class="side-col side-col--brand" aria-hidden="true">
            <div
              v-for="(service, index) in brandGhosts"
              :key="service.key"
              class="ghost-service"
              :class="{ 'ghost-service--no-image': !service.image }"
              :style="{
                '--x': `${brandPositions[index % brandPositions.length].x}%`,
                '--y': `${brandPositions[index % brandPositions.length].y}%`,
              }"
            >
              <strong>{{ service.title }}</strong>
            </div>
          </div>
          <div class="mastery-col">
            <article
              v-for="(service, index) in cards"
              :key="service.key"
              class="service-card"
              :class="{ 'service-card--has-image': !!service.image }"
              :style="{
                '--accent': service.accent,
                '--x': `${service.position.x}%`,
                '--y': `${service.position.y}%`,
                '--delay': `${index * 70}ms`,
              }"
            >
              <div class="service-card__content" aria-hidden="true">
                <div class="service-card__asset">
                  <img
                    v-if="service.image"
                    :src="service.image.src"
                    alt=""
                    loading="lazy"
                    decoding="async"
                  />
                  <div v-else class="service-card__fallback" />
                </div>
                <div class="service-card__asset">
                  <img
                    v-if="cards[(index + 1) % cards.length]?.image"
                    :src="cards[(index + 1) % cards.length].image!.src"
                    alt=""
                    loading="lazy"
                    decoding="async"
                  />
                  <div v-else class="service-card__fallback" />
                </div>
              </div>
              <a class="service-card__title" :href="service.href">
                <span class="service-card__icon" aria-hidden="true" />
                <strong>{{ service.title }}</strong>
                <svg
                  class="service-card__arrow"
                  width="12"
                  height="12"
                  viewBox="0 0 11 12"
                  fill="none"
                  aria-hidden="true"
                >
                  <path
                    d="M7.69 4.812 4.022 1.143 5.083.083l5.48 5.48-5.48 5.48-1.06-1.06 3.67-3.67H.188v-1.5H7.69Z"
                    fill="currentColor"
                  />
                </svg>
              </a>
            </article>
          </div>
          <div class="side-col side-col--product" aria-hidden="true">
            <div
              v-for="(service, index) in productGhosts"
              :key="service.key"
              class="ghost-service"
              :class="{ 'ghost-service--no-image': !service.image }"
              :style="{
                '--x': `${productPositions[index % productPositions.length].x}%`,
                '--y': `${productPositions[index % productPositions.length].y}%`,
              }"
            >
              <strong>{{ service.title }}</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.services-cloud {
  position: relative;
  overflow: hidden;
  min-height: 1050px;
  background: #050505;
  color: #fff;
}
.services-cloud::after {
  content: "";
  position: absolute;
  left: 50%;
  bottom: -250px;
  width: 1068px;
  height: 330px;
  translate: -50% 0;
  border-radius: 50%;
  background: rgb(var(--color-gold-rgb) / 35%);
  filter: blur(190px);
  pointer-events: none;
}
.service-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  width: fit-content;
  color: var(--color-gold);
  font-family: var(--font-display);
  font-size: 16px;
  line-height: 1;
}
.service-eyebrow span {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: currentColor;
  box-shadow: 0 0 12px currentColor;
}
.cloud-diagram {
  position: relative;
  min-height: 625px;
  margin-top: 72px;
}
.services-grid {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: minmax(170px, 1fr) minmax(285px, 390px) minmax(
      170px,
      1fr
    );
  gap: 40px;
  align-items: center;
  min-height: 620px;
}
.side-col {
  display: grid;
  gap: 42px;
}
.side-col--brand {
  justify-items: end;
}
.side-col--product {
  justify-items: start;
}
.ghost-service {
  color: rgb(255 255 255/27%);
  font-size: 16px;
  line-height: 1.4;
  opacity: 0;
  transition:
    opacity 0.7s ease,
    transform 0.8s cubic-bezier(0.2, 0.75, 0.2, 1);
}
.side-col--brand .ghost-service {
  transform: translateX(-45px);
}
.side-col--product .ghost-service {
  transform: translateX(45px);
}
.is-visible .ghost-service {
  opacity: 1;
  transform: translateX(0);
}
.ghost-service:nth-child(2) {
  transition-delay: 80ms;
}
.ghost-service:nth-child(3) {
  transition-delay: 160ms;
}
.ghost-service:nth-child(4) {
  transition-delay: 240ms;
}
.ghost-service:nth-child(5) {
  transition-delay: 320ms;
}
.mastery-col {
  display: grid;
  gap: 18px;
  align-content: center;
}
.service-card {
  position: relative;
  display: grid;
  grid-template-rows: 47px 0fr;
  border: 1px solid color-mix(in srgb, var(--accent) 55%, transparent);
  border-radius: 8px;
  background: rgb(23 23 23/92%);
  color: var(--accent);
  opacity: 0;
  transform: scale(0.82);
  transition:
    grid-template-rows 0.35s ease,
    background-color 0.25s ease,
    box-shadow 0.25s ease,
    opacity 0.55s ease var(--delay),
    transform 0.65s cubic-bezier(0.2, 0.75, 0.2, 1) var(--delay);
}
.is-visible .service-card {
  opacity: 1;
  transform: scale(1);
}
.service-card:hover,
.service-card:focus-within {
  grid-template-rows: 47px 150px;
  background: #101010;
  box-shadow:
    0 16px 45px rgb(0 0 0/45%),
    0 0 24px color-mix(in srgb, var(--accent) 12%, transparent);
}
.service-card__title {
  display: flex;
  align-items: center;
  gap: 10px;
  min-width: 0;
  padding: 0 17px;
  color: inherit;
  font-size: 17px;
  text-decoration: none;
}
.service-card__title strong {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.service-card__icon {
  width: 12px;
  height: 12px;
  flex: none;
  rotate: 45deg;
  border: 2px solid currentColor;
  border-radius: 2px;
}
.service-card:nth-child(2) .service-card__icon {
  border-radius: 50%;
}
.service-card:nth-child(3) .service-card__icon {
  width: 9px;
  height: 16px;
  rotate: 0deg;
}
.service-card:nth-child(4) .service-card__icon {
  rotate: 0deg;
  border-radius: 50% 50% 45% 45%;
}
.service-card__arrow {
  margin-inline-start: auto;
  flex: none;
  transition: transform 0.25s ease;
}
.service-card:hover .service-card__arrow,
.service-card:focus-within .service-card__arrow {
  transform: translateX(4px);
}
[dir="rtl"] .service-card__arrow {
  scale: -1 1;
}
.service-card__content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  min-height: 0;
  overflow: hidden;
  padding: 0 8px;
  opacity: 0;
  transition:
    opacity 0.2s ease,
    padding 0.35s ease;
}
.service-card:hover .service-card__content,
.service-card:focus-within .service-card__content {
  padding-block: 0 8px;
  opacity: 1;
  transition-delay: 0.08s;
}
.service-card__asset {
  overflow: hidden;
  min-height: 0;
  border-radius: 6px;
  background: #222;
}
.service-card__asset img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transform: scale(1.06);
  transition: transform 0.55s ease;
}
.service-card:hover img,
.service-card:focus-within img {
  transform: scale(1);
}
.service-card__fallback {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, var(--accent), var(--color-ink) 70%);
  opacity: 0.6;
}
@media (min-width: 768px) {
  .service-eyebrow {
    font-size: 24px;
  }
}
@media (max-width: 1023px) {
  .services-cloud {
    min-height: auto;
  }
  .cloud-diagram {
    min-height: auto;
    margin-top: 48px;
    padding-block: 30px;
  }
  .services-grid {
    grid-template-columns: 1fr;
    min-height: 420px;
  }
  .side-col {
    display: none;
  }
  .mastery-col {
    width: min(100%, 390px);
    margin-inline: auto;
    gap: 12px;
  }
}

/* Capability-map layout. Geometry only: motion and interactions stay intact. */
.services-cloud {
  min-height: auto;
  background: #f7f7f7;
  color: var(--color-ink);
}
.services-cloud::after {
  display: none;
}
.services-cloud :is(h2, p) {
  color: var(--color-ink) !important;
}
.cloud-diagram {
  position: relative;
  width: min(100%, 980px);
  height: 560px;
  min-height: 560px;
  margin: 68px auto 0;
  overflow: visible;
}
.cloud-diagram :deep(.mastery-stage) {
  width: 100%;
  height: 100%;
}
.services-grid {
  position: absolute;
  inset: 0;
  z-index: 2;
  display: block;
  width: 100%;
  height: 100%;
  min-height: 0;
}
.side-col,
.mastery-col {
  display: contents;
}
.ghost-service,
.service-card {
  position: absolute;
  inset-inline-start: var(--x);
  top: var(--y);
  width: max-content;
  height: 38px;
  translate: -50% -50%;
}
.ghost-service {
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 220px;
  padding: 0 14px;
  border: 1px solid rgb(var(--color-ink-rgb) / 13%);
  border-radius: 999px;
  background: rgb(255 255 255 / 72%);
  color: rgb(var(--color-ink-rgb) / 34%);
  font-size: 14px;
  font-weight: 500;
  line-height: 1;
  opacity: 0;
  transform: translateX(0) scale(0.96);
}
.side-col--brand .ghost-service,
.side-col--product .ghost-service {
  inset-inline-end: auto;
  transform: translateX(0) scale(0.96);
}
.is-visible .ghost-service {
  opacity: 1;
  transform: translateX(0) scale(1);
}
.service-card {
  display: block;
  max-width: 250px;
  border: 0;
  border-radius: 999px;
  background: transparent;
  opacity: 0;
  transform: scale(0.82);
  transition:
    opacity 0.5s ease var(--delay),
    transform 0.8s cubic-bezier(0.89, 0.34, 0.2, 0.83) var(--delay);
}
.is-visible .service-card {
  opacity: 1;
  transform: scale(1);
}
.service-card__title {
  height: 38px;
  gap: 9px;
  padding: 0 14px;
  border: 1px solid var(--color-ink);
  border-radius: 999px;
  background: var(--color-ink);
  color: var(--accent);
  font-size: 14px;
  font-weight: 600;
  line-height: 1;
}
.service-card__title strong {
  color: var(--color-paper);
}
.service-card__icon {
  width: 12px;
  height: 12px;
  border: 0;
  background: currentColor;
}
.service-card__arrow {
  width: 10px;
  height: 10px;
  margin-inline-start: 3px;
}
.service-card__content {
  bottom: 38px;
}
.service-card--has-image:hover,
.service-card--has-image:focus-within,
.service-card--has-image:hover .service-card__title,
.service-card--has-image:focus-within .service-card__title {
  border-color: var(--color-gold);
  background: var(--color-gold);
  color: var(--color-paper);
}
.service-card--has-image:hover .service-card__title strong,
.service-card--has-image:focus-within .service-card__title strong,
.service-card--has-image:hover .service-card__title .service-card__icon,
.service-card--has-image:focus-within .service-card__title .service-card__icon {
  color: var(--color-paper);
}

@media (max-width: 1023px) {
  .cloud-diagram {
    width: min(100%, 760px);
    height: 500px;
    min-height: 500px;
    margin-top: 48px;
    padding: 0;
    overflow: hidden;
  }
  .ghost-service {
    font-size: 12px;
    padding-inline: 10px;
  }
  .service-card__title {
    font-size: 13px;
  }
}

@media (max-width: 639px) {
  .cloud-diagram {
    height: 500px;
    min-height: 500px;
    margin-top: 36px;
  }
  .side-col {
    display: none;
  }
  .mastery-col {
    position: absolute;
    inset: 102px 0 auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
    justify-items: center;
  }
  .service-card {
    position: relative;
    inset: auto;
    top: auto;
    translate: none;
  }
  .service-card__content {
    display: none;
  }
}
@media (max-width: 520px) {
  .services-grid {
    min-height: 360px;
  }
  .service-card__title {
    font-size: 15px;
  }
  .service-card:hover,
  .service-card:focus-within {
    grid-template-rows: 47px 132px;
  }
}
@media (hover: none) {
  .service-card:focus-within {
    grid-template-rows: 47px 132px;
  }
}
@media (prefers-reduced-motion: reduce) {
  .ghost-service,
  .service-card,
  .service-card__arrow,
  .service-card__content,
  .service-card__asset img {
    transition: none !important;
  }
}

/* Ramotion services system — measured in Playwright at 1440px. */
.services-cloud {
  min-height: auto;
  background: #050505;
  color: var(--color-paper);
}
.services-cloud::after {
  display: block;
  left: 0;
  bottom: -110px;
  width: 100%;
  height: 360px;
  translate: none;
  border-radius: 0;
  background: radial-gradient(
    ellipse 65% 85% at 50% 100%,
    rgb(var(--color-gold-rgb) / 62%) 0%,
    rgb(var(--color-gold-rgb) / 32%) 38%,
    transparent 76%
  );
  box-shadow: none;
  filter: blur(28px);
}
.services-cloud :is(h2, p) {
  color: var(--color-paper) !important;
}
/* Gold, as everywhere else on the site — the reference's flat ink was not ours. */
.service-eyebrow {
  color: var(--color-gold);
}
.cloud-diagram {
  height: 628px;
  min-height: 628px;
  margin-top: 56px;
  overflow: hidden;
}
/*
 | All three columns share one row rhythm: 40px rows on a 74px pitch, starting
 | at y=188. That is the reference's own grid, and it is what keeps the
 | horizontal axis clear — rows land at 208/282/356/430, so the axis at y=319
 | falls in the gap between the second and third rows and no service can ever
 | sit on it. The corridor is a property of the layout, not of stacking order.
 */
.services-grid {
  grid-template-columns: 312px 624px 312px;
  gap: 0;
  min-height: 336px;
  height: 336px;
  top: 188px;
  align-items: start;
}
.side-col {
  height: 336px;
  grid-template-columns: 1fr;
  grid-template-rows: repeat(4, 40px);
  gap: 34px;
  align-content: start;
}
/*
 | Five entries, four rows — the two narrowest share the top one.
 |
 | The reference does the same on its own five-entry side (it doubles a middle
 | row), which is what keeps both outer columns spanning the same band. Giving
 | the fifth entry a row of its own instead would hang it a full row below
 | everything else on one side only.
 */
.side-col--product {
  grid-template-columns: auto auto;
  column-gap: 10px;
  justify-content: start;
}
.side-col--product .ghost-service:nth-child(1) {
  grid-area: 1 / 1;
}
.side-col--product .ghost-service:nth-child(2) {
  grid-area: 1 / 2;
}
.side-col--product .ghost-service:nth-child(n + 3) {
  grid-column: 1 / span 2;
}
/* Positive `--fan` leans an entry toward the centre, whichever side it is on. */
.side-col--brand .ghost-service {
  position: relative;
  inset-inline-start: var(--fan, 0);
}
.side-col--product .ghost-service {
  position: relative;
  inset-inline-end: var(--fan, 0);
}
/*
 | Both outer columns lean toward the middle, not centred in their own column.
 | Centred left a wide empty gutter either side of the primary cluster that the
 | reference does not have — its outer entries sit much closer in. `start`/`end`
 | are flow-relative, so this mirrors correctly in RTL.
 */
.side-col--brand {
  justify-items: end;
}
.side-col--product {
  justify-items: start;
}
.ghost-service {
  display: flex;
  align-items: center;
  justify-content: center;
  width: max-content;
  max-width: 250px;
  height: 40px;
  padding: 0 13px;
  border: 2px solid rgb(var(--color-gold-rgb) / 70%);
  border-radius: 20px;
  color: var(--color-paper);
  font-size: 17px;
  font-weight: 500;
  background: #050505;
}
.side-col--brand .ghost-service,
.side-col--product .ghost-service {
  transform: translateX(0);
}
/*
 | One card per row, not a 2x2 block: the reference runs its primary services
 | the full height of the inner orbit, and paired rows left the lower half of
 | ours empty.
 */
.mastery-col {
  display: grid;
  grid-template-columns: 1fr;
  grid-auto-rows: 40px;
  gap: 34px 0;
  height: 336px;
  align-content: start;
  justify-items: center;
}
.service-card {
  display: block;
  width: max-content;
  max-width: 285px;
  height: 40px;
  border: 0;
  border-radius: 20px;
  background: var(--color-paper);
  /* Staggered off the column centre — see `nudges` above. */
  inset-inline-start: var(--nudge, 0);
  color: var(--color-ink);
  opacity: 0;
  transform: scale(0);
  transition:
    opacity 0.5s ease var(--delay),
    transform 0.8s cubic-bezier(0.89, 0.34, 0.2, 0.83) var(--delay);
}
.is-visible .service-card {
  opacity: 1;
  transform: scale(1);
}
.service-card:hover,
.service-card:focus-within {
  display: block;
  background: var(--color-paper);
  box-shadow: none;
}
.service-card__title {
  height: 40px;
  padding: 0 14px;
  border: 2px solid var(--color-paper);
  border-radius: 20px;
  background: var(--color-paper);
  color: var(--color-ink);
  font-size: 17px;
}
.service-card__title strong {
  color: var(--color-ink);
}
.service-card__title .service-card__icon {
  color: var(--accent);
}
.service-card__icon {
  width: 14px;
  height: 14px;
  border: 0;
  background: currentColor;
}
.service-card__arrow {
  margin-inline-start: 5px;
}
.service-card__content {
  position: absolute;
  z-index: 5;
  left: 50%;
  bottom: 40px;
  display: block;
  width: 220px;
  height: 165px;
  min-height: 165px;
  padding: 0;
  overflow: visible;
  opacity: 0;
  pointer-events: none;
  translate: -50% 0;
  transition: opacity 0.25s ease;
}
.service-card:hover .service-card__content,
.service-card:focus-within .service-card__content {
  padding: 0;
  opacity: 1;
}
.service-card__asset {
  position: absolute;
  inset: 0;
  width: 220px;
  height: 165px;
  border-radius: 8px;
  background: #fff;
  box-shadow: 0 8px 30px rgb(0 0 0/12%);
  transform: translate(-40px, 20px) rotate(-24deg) scale(0.6);
  transition: transform 0.3s ease;
}
.service-card__asset:nth-child(2) {
  transform: translate(-20px, 20px) rotate(-8deg) scale(0.5);
  opacity: 0;
  transition:
    transform 0.5s ease,
    opacity 0.5s ease;
}
.service-card:hover .service-card__asset:first-child,
.service-card:focus-within .service-card__asset:first-child {
  transform: rotate(-4deg);
}
.service-card:hover .service-card__asset:nth-child(2),
.service-card:focus-within .service-card__asset:nth-child(2) {
  transform: translate(85px, -8px) rotate(8deg) scale(0.9);
  opacity: 1;
}
.service-card__asset img {
  transform: none;
}
.service-card:hover img,
.service-card:focus-within img {
  transform: none;
}
@media (max-width: 1279px) and (min-width: 1024px) {
  .services-grid {
    left: 50%;
    width: 1248px;
    translate: -50% 0;
  }
}
@media (max-width: 1023px) {
  .cloud-diagram {
    height: 540px;
    min-height: 540px;
  }
  .services-grid {
    top: 116px;
    display: grid;
    grid-template-columns: 1fr;
    width: 100%;
    height: auto;
    min-height: 0;
  }
  .mastery-col {
    display: grid;
    width: min(100%, 390px);
    height: auto;
    grid-template-columns: 1fr;
    grid-auto-rows: 40px;
    gap: 16px;
    margin-inline: auto;
  }
  .side-col {
    display: none;
  }
  .service-card {
    justify-self: center;
  }
  .service-card__content {
    display: none;
  }
}

/* Keep the coordinate map last so the legacy measured-grid rules cannot win. */
.cloud-diagram {
  width: min(100%, 980px);
  height: 560px;
  min-height: 560px;
  margin: 68px auto 0;
  overflow: visible;
}
.services-grid {
  position: absolute;
  inset: 0;
  display: block;
  width: 100%;
  height: 100%;
  min-height: 0;
  translate: none;
}
.side-col,
.mastery-col {
  display: contents;
}
.ghost-service,
.service-card {
  position: absolute;
  inset-inline-start: var(--x);
  inset-inline-end: auto;
  top: var(--y);
  width: max-content;
  height: 38px;
  translate: -50% -50%;
}
.ghost-service {
  max-width: 220px;
  padding: 0 14px;
  border: 1px solid rgb(var(--color-ink-rgb) / 13%);
  border-radius: 999px;
  background: rgb(255 255 255 / 72%);
  color: rgb(var(--color-ink-rgb) / 34%);
  font-size: 14px;
  transform: scale(0.96);
}
.ghost-service.ghost-service--no-image {
  border-color: var(--color-neutral-200);
  background: #000;
  color: var(--color-neutral-200);
}
.side-col--brand .ghost-service,
.side-col--product .ghost-service {
  position: absolute;
  inset-inline-start: var(--x);
  inset-inline-end: auto;
  transform: scale(0.96);
}
.is-visible .ghost-service {
  transform: scale(1);
}
.service-card {
  max-width: 250px;
  border-radius: 999px;
  inset-inline-start: var(--x);
  transform: scale(0.82);
}
.is-visible .service-card {
  transform: scale(1);
}
.service-card__title {
  height: 38px;
  gap: 9px;
  padding: 0 14px;
  border-radius: 999px;
  font-size: 14px;
  font-weight: 600;
}
.service-card__icon {
  width: 12px;
  height: 12px;
}
.service-card__arrow {
  width: 10px;
  height: 10px;
  margin-inline-start: 3px;
}
.service-card__content {
  bottom: 38px;
}

@media (max-width: 1023px) {
  .cloud-diagram {
    width: min(100%, 760px);
    height: 500px;
    min-height: 500px;
    margin-top: 48px;
    padding: 0;
    overflow: hidden;
  }
  .services-grid {
    inset: 0;
    top: 0;
    display: block;
    height: 100%;
  }
  .side-col,
  .mastery-col {
    display: contents;
  }
}

@media (max-width: 639px) {
  .cloud-diagram {
    margin-top: 36px;
  }
  .side-col {
    display: none;
  }
  .mastery-col {
    position: absolute;
    inset: 102px 0 auto;
    display: grid;
    width: 100%;
    height: auto;
    grid-template-columns: 1fr;
    grid-auto-rows: 38px;
    gap: 12px;
    margin: 0;
    justify-items: center;
  }
  .service-card {
    position: relative;
    inset: auto;
    top: auto;
    translate: none;
  }
}
</style>
