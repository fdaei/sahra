<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from "vue";
import { ArrowUpRight, Building2 } from "lucide-vue-next";
import type { ProjectSummary } from "@/types";

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
const isPaused = ref(false);
const isVisible = ref(false);
const sectionRoot = ref<HTMLElement | null>(null);
let rotationTimer: number | null = null;
let observer: IntersectionObserver | null = null;

const activeProject = computed(() => props.projects[activeIndex.value] ?? null);
const canRotate = computed(() => props.projects.length > 1);

function selectProject(index: number): void {
  activeIndex.value = index;
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
  },
);

onMounted(() => {
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
  document.removeEventListener("visibilitychange", handleVisibilityChange);
});
</script>

<template>
  <section
    ref="sectionRoot"
    class="h-[965px] overflow-hidden py-14 md:h-auto md:py-24 lg:py-28"
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
              class="max-w-[506px] text-[26px] font-semibold leading-[1.2] text-neutral-900 lg:text-[40px]"
            >
              {{ section.title }}
            </h2>
            <p
              v-if="section.subtitle"
              class="max-w-[612px] text-[16px] font-medium leading-[1.45] text-neutral-700 lg:text-[18px]"
            >
              {{ section.subtitle }}
            </p>
          </div>
        </header>

        <div
          v-if="projects.length"
          class="grid items-center gap-4 lg:grid-cols-[minmax(0,612px)_minmax(0,530px)] lg:justify-between lg:gap-10 xl:grid-cols-[612px_530px] xl:gap-0"
        >
          <div
            class="order-1 flex min-w-0 flex-col lg:order-1"
            role="tablist"
            aria-label="Projects"
          >
            <article
              v-for="(project, index) in projects"
              :key="project.slug"
              class="project-slide-row max-lg:hidden"
              :class="{ 'is-active max-lg:!block': activeIndex === index }"
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
                    :aria-controls="`project-panel-${index}`"
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
                      class="project-slide-title min-w-0 text-[26px] font-normal leading-tight text-neutral-500 transition-[color,font-size] duration-500 ease-brand lg:text-[32px]"
                    >
                      {{ project.title }}
                    </span>
                  </button>

                  <a
                    v-if="activeIndex === index"
                    :href="project.url"
                    class="hidden shrink-0 items-center gap-2 text-body-lg font-medium text-neutral-900 hover:text-gold sm:flex"
                  >
                    View Case Study
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
                        class="mt-4 block max-w-[600px] text-body-lg leading-relaxed text-neutral-800"
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
                  View Case Study
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
            <Transition name="project-image" mode="out-in">
              <a
                v-if="activeProject"
                :id="`project-panel-${activeIndex}`"
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
  color: #231f20;
  font-size: 40px;
  font-weight: 500;
}

.project-slide-rule {
  position: relative;
  height: 1px;
  background: #d3d2d2;
  transition: background-color 400ms ease;
}

.project-slide-rule span {
  position: absolute;
  inset-block-start: 50%;
  inset-inline-start: 50%;
  width: 8px;
  height: 8px;
  background: #d3d2d2;
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
  background: #dec99d;
}

.project-slide-row:last-child .project-slide-rule {
  opacity: 0;
}

.project-slide-row.is-active .project-slide-rule span {
  background: #c49e4f;
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

@media (prefers-reduced-motion: reduce) {
  .project-slide-details,
  .project-slide-title,
  .project-slide-rule,
  .project-slide-rule span,
  .project-image-enter-active,
  .project-image-leave-active {
    transition: none;
  }
}
</style>
