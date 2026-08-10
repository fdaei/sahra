<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from "vue";
import { ArrowUpRight, Building2 } from "lucide-vue-next";
import { useTranslations } from "@/Composables/useTranslations";
import type { ProjectSummary } from "@/types";

const { t } = useTranslations();

interface SectionContent {
  eyebrow: string;
  title: string;
  subtitle: string;
}

const props = defineProps<{
  section: SectionContent;
  projects: ProjectSummary[];
}>();

const activeIndex = ref(0);
const mobileActiveIndex = ref(0);
const isPaused = ref(false);
const isVisible = ref(false);
const sectionRoot = ref<HTMLElement | null>(null);
const mobileCarousel = ref<HTMLElement | null>(null);
let rotationTimer: number | null = null;
let observer: IntersectionObserver | null = null;
let mobileMedia: MediaQueryList | null = null;
let pointerStartX = 0;
let pointerStartY = 0;
let didSwipe = false;

const activeProject = computed(() => props.projects[activeIndex.value] ?? null);
// The mobile Figma frame has four states/dots while desktop has five rows.
const mobileProjects = computed(() => props.projects.slice(0, 4));
const mobileActiveProject = computed(
  () => mobileProjects.value[mobileActiveIndex.value] ?? null,
);
const canRotate = computed(() => props.projects.length > 1);

function selectProject(index: number): void {
  activeIndex.value = index;
}

function selectMobileProject(index: number): void {
  if (!mobileProjects.value.length) return;

  mobileActiveIndex.value =
    (index + mobileProjects.value.length) % mobileProjects.value.length;
  startRotation();
}

function handlePointerDown(event: PointerEvent): void {
  if (event.pointerType === "mouse" && event.button !== 0) return;

  pointerStartX = event.clientX;
  pointerStartY = event.clientY;
  didSwipe = false;
  mobileCarousel.value?.setPointerCapture(event.pointerId);
  isPaused.value = true;
}

function handlePointerUp(event: PointerEvent): void {
  const deltaX = event.clientX - pointerStartX;
  const deltaY = event.clientY - pointerStartY;

  if (Math.abs(deltaX) >= 44 && Math.abs(deltaX) > Math.abs(deltaY)) {
    didSwipe = true;
    // Physical swipe direction stays natural in both LTR and RTL layouts.
    selectMobileProject(mobileActiveIndex.value + (deltaX < 0 ? 1 : -1));
  }

  isPaused.value = false;
}

function handlePointerCancel(): void {
  isPaused.value = false;
}

function handleCarouselClick(event: MouseEvent): void {
  if (!didSwipe) return;

  event.preventDefault();
  event.stopPropagation();
  didSwipe = false;
}

function stopRotation(): void {
  if (rotationTimer === null) return;
  window.clearInterval(rotationTimer);
  rotationTimer = null;
}

function startRotation(): void {
  stopRotation();

  if (
    !canRotate.value ||
    isPaused.value ||
    !isVisible.value ||
    document.hidden ||
    window.matchMedia("(prefers-reduced-motion: reduce)").matches
  ) {
    return;
  }

  rotationTimer = window.setInterval(() => {
    if (mobileMedia?.matches && mobileProjects.value.length > 1) {
      mobileActiveIndex.value =
        (mobileActiveIndex.value + 1) % mobileProjects.value.length;
      return;
    }

    activeIndex.value = (activeIndex.value + 1) % props.projects.length;
  }, 5500);
}

function handleVisibilityChange(): void {
  startRotation();
}

watch([isPaused, isVisible, () => props.projects.length], startRotation);

watch(
  () => props.projects.length,
  (length) => {
    if (activeIndex.value >= length) activeIndex.value = 0;
    if (mobileActiveIndex.value >= mobileProjects.value.length) {
      mobileActiveIndex.value = 0;
    }
  },
);

onMounted(() => {
  mobileMedia = window.matchMedia("(max-width: 1023px)");
  mobileMedia.addEventListener("change", startRotation);

  observer = new IntersectionObserver(
    ([entry]) => {
      isVisible.value = entry?.isIntersecting ?? false;
    },
    { threshold: 0.35 },
  );

  if (sectionRoot.value) observer.observe(sectionRoot.value);
  document.addEventListener("visibilitychange", handleVisibilityChange);
});

onBeforeUnmount(() => {
  stopRotation();
  observer?.disconnect();
  mobileMedia?.removeEventListener("change", startRotation);
  document.removeEventListener("visibilitychange", handleVisibilityChange);
});
</script>

<template>
  <section
    ref="sectionRoot"
    class="overflow-hidden py-14 md:py-24 lg:py-28"
    aria-labelledby="projects-showcase-title"
    @mouseenter="isPaused = true"
    @mouseleave="isPaused = false"
    @focusin="isPaused = true"
    @focusout="isPaused = false"
  >
    <div class="container-sahra">
      <div class="flex flex-col gap-10 lg:gap-24">
        <header class="flex flex-col gap-8 lg:gap-12">
          <div
            class="inline-flex w-fit items-center gap-1 font-display text-[16px] leading-none text-gold md:text-[24px]"
          >
            <span
              class="size-2 rotate-45 rounded-round bg-gold shadow-[-2px_-2px_12px_rgba(189,147,59,0.5),2px_2px_12px_rgba(189,147,59,0.5)]"
              aria-hidden="true"
            />
            <span>{{ section.eyebrow }}</span>
          </div>

          <div
            class="grid items-start gap-6 lg:grid-cols-2 lg:justify-between xl:grid-cols-[506px_612px] xl:gap-0"
          >
            <h2
              id="projects-showcase-title"
              class="max-w-[506px] text-[26px] font-semibold leading-normal text-neutral-900 lg:text-[40px]"
            >
              {{ section.title }}
            </h2>
            <p
              v-if="section.subtitle"
              class="max-w-[612px] text-[16px] font-medium leading-[1.5] text-neutral-700 lg:text-[18px]"
            >
              {{ section.subtitle }}
            </p>
          </div>
        </header>

        <!-- Mobile carousel — Figma 1465:10846 (362×627, four states). -->
        <div
          v-if="mobileProjects.length"
          ref="mobileCarousel"
          class="project-mobile-carousel flex touch-pan-y select-none flex-col items-center gap-6 lg:hidden"
          role="region"
          aria-roledescription="carousel"
          :aria-label="t('common.projects')"
          @pointerdown="handlePointerDown"
          @pointerup="handlePointerUp"
          @pointercancel="handlePointerCancel"
          @click.capture="handleCarouselClick"
        >
          <Transition name="project-mobile" mode="out-in">
            <article
              v-if="mobileActiveProject"
              :key="mobileActiveProject.slug"
              class="flex w-full flex-col gap-6"
              aria-live="polite"
            >
              <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between gap-4">
                  <h3 class="truncate text-[24px] font-medium leading-none text-neutral-900">
                    {{ mobileActiveProject.title }}
                  </h3>
                  <a
                    :href="mobileActiveProject.url"
                    class="inline-flex shrink-0 items-center gap-1 text-[14px] font-medium leading-none text-neutral-900"
                  >
                    {{ t("work.view_case_study") }}
                    <ArrowUpRight class="size-4" :stroke-width="1.5" />
                  </a>
                </div>

                <div class="flex flex-col gap-3">
                  <span class="flex items-center gap-2 text-[12px] font-medium leading-none text-neutral-500">
                    <Building2 class="size-4 text-gold" :stroke-width="1.5" />
                    {{ mobileActiveProject.industry }}
                  </span>
                  <p class="text-[14px] font-normal leading-normal text-neutral-800">
                    {{ mobileActiveProject.excerpt }}
                  </p>
                </div>
              </div>

              <a
                :href="mobileActiveProject.url"
                class="aspect-[362/453] w-full overflow-hidden rounded-lg bg-neutral-50"
                draggable="false"
              >
                <img
                  v-if="mobileActiveProject.image"
                  :src="mobileActiveProject.image.src"
                  :srcset="mobileActiveProject.image.srcset"
                  :alt="mobileActiveProject.image.alt"
                  class="size-full object-cover"
                  :width="mobileActiveProject.image.width"
                  :height="mobileActiveProject.image.height"
                  draggable="false"
                />
              </a>
            </article>
          </Transition>

          <div
            class="flex min-h-6 items-center justify-center gap-2"
            role="group"
            :aria-label="t('common.pagination')"
          >
            <button
              v-for="(project, index) in mobileProjects"
              :key="project.slug"
              type="button"
              class="h-[10px] rounded-round bg-neutral-300 transition-[width,background-color] duration-300 ease-out"
              :class="mobileActiveIndex === index ? 'w-5 bg-gold-600' : 'w-[10px]'"
              :aria-label="`${index + 1}: ${project.title}`"
              :aria-current="mobileActiveIndex === index ? 'true' : undefined"
              @click="selectMobileProject(index)"
            />
          </div>
        </div>

        <div
          v-if="projects.length"
          class="hidden items-center gap-4 lg:grid lg:grid-cols-[minmax(0,612px)_minmax(0,530px)] lg:justify-between lg:gap-10 xl:grid-cols-[612px_530px] xl:gap-0"
        >
          <div
            class="order-1 flex min-w-0 flex-col lg:order-1"
            role="tablist"
            :aria-label="t('common.projects')"
          >
            <article
              v-for="(project, index) in projects"
              :key="project.slug"
              class="project-slide-row"
              :class="{ 'is-active': activeIndex === index }"
            >
              <div
                class="group py-4 lg:py-6"
                @mouseenter="selectProject(index)"
              >
                <span class="flex items-center justify-between gap-4">
                  <button
                    class="min-w-0 text-start"
                    type="button"
                    role="tab"
                    :id="`project-tab-${index}`"
                    :aria-selected="activeIndex === index"
                    aria-controls="project-panel"
                    :tabindex="activeIndex === index ? 0 : -1"
                    @click="selectProject(index)"
                    @focus="selectProject(index)"
                    @keydown.left.prevent="
                      selectProject(
                        (index - 1 + projects.length) % projects.length,
                      )
                    "
                    @keydown.right.prevent="
                      selectProject((index + 1) % projects.length)
                    "
                  >
                    <span
                      class="project-slide-title min-w-0 text-[26px] font-normal leading-[1.5] text-neutral-500 transition-[color,font-size] duration-500 ease-brand lg:text-[32px]"
                    >
                      {{ project.title }}
                    </span>
                  </button>

                  <a
                    v-if="activeIndex === index"
                    :href="project.url"
                    class="hidden shrink-0 items-center gap-2 text-body-lg font-medium text-neutral-900 hover:text-gold sm:flex"
                  >
                    {{ t("work.view_case_study") }}
                    <ArrowUpRight class="size-5" :stroke-width="1.5" />
                  </a>
                </span>

                <button
                  class="block w-full text-start"
                  type="button"
                  :tabindex="activeIndex === index ? 0 : -1"
                  @click="selectProject(index)"
                >
                  <span
                    class="project-slide-details grid text-start"
                    :aria-hidden="activeIndex !== index"
                  >
                    <span class="min-h-0 overflow-hidden">
                      <span
                        class="mt-4 flex items-center gap-2 text-label-lg text-neutral-500"
                      >
                        <Building2
                          class="size-5 text-gold"
                          :stroke-width="1.5"
                        />
                        {{ project.industry }}
                      </span>
                      <span
                        class="mt-4 block max-w-[600px] text-body-lg text-neutral-800"
                      >
                        {{ project.excerpt }}
                      </span>
                    </span>
                  </span>
                </button>

                <a
                  v-if="activeIndex === index"
                  :href="project.url"
                  class="mt-4 inline-flex items-center gap-2 text-body-lg font-medium text-neutral-900 sm:hidden"
                >
                  {{ t("work.view_case_study") }}
                  <ArrowUpRight class="size-5" :stroke-width="1.5" />
                </a>
              </div>

              <div class="project-slide-rule" aria-hidden="true">
                <span />
              </div>
            </article>
          </div>

          <div
            class="order-2 aspect-[362/453] w-full overflow-hidden rounded-lg bg-neutral-50 lg:order-2 lg:aspect-[530/663]"
          >
            <!--
              One shared panel, not one per tab: the design cross-fades a
              single image well rather than stacking four. The id must
              therefore be stable — keying it to activeIndex left every
              inactive tab's aria-controls pointing at a node that does not
              exist. aria-labelledby still tracks the active tab.
            -->
            <Transition name="project-image" mode="out-in">
              <a
                v-if="activeProject"
                id="project-panel"
                :key="activeProject.slug"
                :href="activeProject.url"
                role="tabpanel"
                :aria-labelledby="`project-tab-${activeIndex}`"
                class="block size-full"
              >
                <img
                  v-if="activeProject.image"
                  :src="activeProject.image.src"
                  :srcset="activeProject.image.srcset"
                  :alt="activeProject.image.alt"
                  class="size-full object-cover"
                  :width="activeProject.image.width"
                  :height="activeProject.image.height"
                />
              </a>
            </Transition>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.project-slide-details {
  grid-template-rows: 0fr;
  opacity: 0;
  transform: translateY(-8px);
  transition:
    grid-template-rows 500ms cubic-bezier(0.22, 1, 0.36, 1),
    opacity 300ms ease,
    transform 500ms cubic-bezier(0.22, 1, 0.36, 1);
}

.project-slide-row.is-active .project-slide-details {
  grid-template-rows: 1fr;
  opacity: 1;
  transform: translateY(0);
}

.project-slide-row.is-active .project-slide-title {
  color: var(--color-ink);
  font-size: 40px;
  font-weight: 500;
}

.project-slide-rule {
  position: relative;
  height: 1px;
  background: var(--color-neutral-200);
  transition: background-color 400ms ease;
}

.project-slide-rule span {
  position: absolute;
  inset-block-start: 50%;
  inset-inline-start: 50%;
  width: 8px;
  height: 8px;
  background: var(--color-neutral-200);
  box-shadow:
    -2px -2px 12px rgb(35 31 32 / 20%),
    2px 2px 12px rgb(35 31 32 / 20%);
  transform: translate(-50%, -50%) rotate(45deg);
  transition:
    background-color 400ms ease,
    box-shadow 400ms ease,
    transform 500ms cubic-bezier(0.22, 1, 0.36, 1);
}

[dir="rtl"] .project-slide-rule span {
  transform: translate(50%, -50%) rotate(45deg);
}

.project-slide-row.is-active .project-slide-rule {
  background: var(--color-gold-500);
}

.project-slide-row:last-child .project-slide-rule {
  opacity: 0;
}

.project-slide-row.is-active .project-slide-rule span {
  background: var(--color-gold-900);
  box-shadow:
    -2px -2px 12px rgb(189 147 59 / 50%),
    2px 2px 12px rgb(189 147 59 / 50%);
  transform: translate(-50%, -50%) rotate(45deg) scale(1.1);
}

[dir="rtl"] .project-slide-row.is-active .project-slide-rule span {
  transform: translate(50%, -50%) rotate(45deg) scale(1.1);
}

.project-image-enter-active,
.project-image-leave-active {
  transition:
    opacity 450ms cubic-bezier(0.22, 1, 0.36, 1),
    transform 550ms cubic-bezier(0.22, 1, 0.36, 1);
}

.project-image-enter-from {
  opacity: 0;
  transform: scale(1.035) translateY(12px);
}

.project-image-leave-to {
  opacity: 0;
  transform: scale(0.985) translateY(-8px);
}

@media (max-width: 639px) {
  .project-slide-row.is-active .project-slide-title {
    font-size: 30px;
  }
}

.project-mobile-enter-active,
.project-mobile-leave-active {
  transition:
    opacity 300ms ease-out,
    transform 300ms ease-out;
}

.project-mobile-enter-from {
  opacity: 0;
  transform: translateX(20px);
}

.project-mobile-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}

[dir="rtl"] .project-mobile-enter-from {
  transform: translateX(-20px);
}

[dir="rtl"] .project-mobile-leave-to {
  transform: translateX(20px);
}

@media (prefers-reduced-motion: reduce) {
  .project-slide-details,
  .project-slide-title,
  .project-slide-rule,
  .project-slide-rule span,
  .project-image-enter-active,
  .project-image-leave-active,
  .project-mobile-enter-active,
  .project-mobile-leave-active {
    transition: none;
  }
}
</style>
