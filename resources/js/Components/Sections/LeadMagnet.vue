<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ArrowUpRight, Mail, UserRound, X } from "lucide-vue-next";
import { useTranslations } from "@/Composables/useTranslations";
import type { SharedProps } from "@/types";

interface LeadMagnetSection {
  title: string;
  description: string;
  primaryCta: { label: string; url: string } | null;
  colors?: {
    title?: string | null;
    description?: string | null;
  };
  image?: {
    src: string;
    alt: string;
    width: number;
    height: number;
  } | null;
  submitUrl?: string;
  downloadUrl?: string;
}

const props = withDefaults(
  defineProps<{
    section: LeadMagnetSection;
    /**
     * On the article page (Figma 604:1464) the strip sits inside the 826px
     * body column, so it drops the section rhythm and the outer container.
     */
    inline?: boolean;
    /**
     * Home mobile 1419:9191 — node 1451:10444, a dedicated compact card
     * (362x132, not a scaled-down version of the desktop banner): px-4 py-6,
     * gap-4, text block + a small bordered pill CTA ("Get checklist" variant,
     * no icon) bottom-aligned in a row. Renders below `md`; the desktop
     * banner below still owns `md:` and up.
     *
     * Only the BOTTOM padding is dropped (`max-md:pb-0`), never `py-0`: the
     * section's own `pt-14` is what separates the card from the black
     * services orbit directly above it on Home, and the next section
     * (ProjectsShowcase) supplies the matching 56px below with its `py-14`.
     */
    mobileOffcanvas?: boolean;
  }>(),
  { inline: false, mobileOffcanvas: false },
);

const { t } = useTranslations();
const page = usePage<SharedProps>();
const isOpen = ref(false);
const isComplete = ref(false);
const dialog = ref<HTMLElement | null>(null);
const form = useForm({
  name: "",
  email: "",
  source: props.inline ? "article" : "home",
  website: "",
});

const newsletterUrl = computed(
  () => props.section.submitUrl || `/${page.props.locale.current}/newsletter`,
);
const downloadUrl = computed(
  () => props.section.downloadUrl || props.section.primaryCta?.url || "",
);

function openModal(): void {
  isComplete.value = false;
  isOpen.value = true;
  document.body.style.overflow = "hidden";
  nextTick(() => dialog.value?.focus());
}

function closeModal(): void {
  isOpen.value = false;
  document.body.style.overflow = "";
  form.clearErrors();
}

function downloadChecklist(): void {
  const url = downloadUrl.value;
  if (!url || /\/contact\/?$/.test(url)) return;

  const link = document.createElement("a");
  link.href = url;
  link.download = "";
  link.rel = "noopener";
  document.body.appendChild(link);
  link.click();
  link.remove();
}

function submit(): void {
  form.post(newsletterUrl.value, {
    preserveScroll: true,
    onSuccess: () => {
      downloadChecklist();
      isComplete.value = true;
      form.reset();
    },
  });
}

onBeforeUnmount(() => {
  document.body.style.overflow = "";
});
</script>

<template>
  <section
    :class="[
      inline ? '' : 'py-14 md:py-18 lg:py-24',
      mobileOffcanvas ? 'max-md:pb-0' : '',
    ]"
  >
    <!--
      Mobile-only compact card — Figma 1451:10444 (362x132). A distinct
      layout from the desktop banner below, not a scaled-down version of it:
      small bordered pill CTA, text+button in one bottom-aligned row.
    -->
    <div v-if="mobileOffcanvas" class="container-sahra md:hidden">
      <div
        class="relative flex w-full items-end justify-between gap-4 overflow-hidden rounded-sm bg-black px-4 py-6 text-white"
      >
        <img
          src="/images/sahra/lead-magnet-large.png"
          alt=""
          class="pointer-events-none absolute inset-0 size-full object-cover"
          aria-hidden="true"
        />
        <div
          class="pointer-events-none absolute inset-0 bg-[linear-gradient(90deg,rgba(0,0,0,0)_0%,rgba(0,0,0,1)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))] rtl:bg-[linear-gradient(270deg,rgba(0,0,0,0)_0%,rgba(0,0,0,1)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))]"
          aria-hidden="true"
        />
        <div class="relative z-10 flex flex-col items-start gap-3">
          <p
            class="text-[18px] font-normal leading-normal text-white"
            :style="{ color: section.colors?.title || undefined }"
          >
            {{ section.title }}
          </p>
          <p
            class="text-[12px] font-medium leading-normal text-neutral-200"
            :style="{ color: section.colors?.description || undefined }"
          >
            {{ section.description }}
          </p>
        </div>
        <button
          v-if="section.primaryCta"
          type="button"
          class="relative z-10 shrink-0 rounded-sm border border-white px-3 py-3 text-[14px] font-normal leading-normal text-white transition-colors duration-300 hover:border-gold hover:bg-gold hover:text-ink"
          @click="openModal"
        >
          {{ section.primaryCta.label }}
        </button>
      </div>
    </div>

    <div
      :class="[
        inline ? '' : 'container-sahra',
        mobileOffcanvas ? 'max-md:hidden' : '',
      ]"
    >
      <div
        class="relative mx-auto w-full max-w-[1101px] overflow-hidden bg-black text-white"
        :class="
          inline
            ? 'min-h-[123px] rounded-sm p-8 rtl:min-h-[128px]'
            : 'min-h-[193px] rounded-sm px-8 py-10 sm:px-12 lg:p-16 rtl:min-h-[200px]'
        "
      >
        <!--
          The article and home banners use independent crops. On Home the
          square artwork keeps its natural aspect ratio and is anchored below
          the frame; scaling it to several times the banner height makes the
          gold streaks far larger than the composition in Figma.
        -->
        <img
          :src="
            section.image?.src ||
            (inline
              ? '/images/sahra/lead-magnet-small.png'
              : '/images/sahra/lead-magnet-large.png')
          "
          :alt="section.image?.alt || ''"
          :width="inline ? 1536 : 1024"
          height="1024"
          class="pointer-events-none absolute max-w-none"
          :class="
            section.image?.src
              ? 'inset-0 size-full object-cover'
              : inline
                ? 'left-[-22.52%] top-[-290.02%] h-[606.35%] w-[137.77%]'
                : 'inset-inline-0 bottom-[-90px] h-auto w-[102.73%] object-cover rtl:-scale-x-100 max-lg:inset-0 max-lg:size-full max-lg:object-cover max-lg:object-bottom'
          "
          :aria-hidden="section.image?.alt ? undefined : 'true'"
          decoding="async"
        />
        <!--
          Small page: one uniform 30% black scrim.
          Big page: directional black ramp plus the 20% #231f20 wash.
        -->
        <div
          class="pointer-events-none absolute inset-0"
          :class="
            inline
              ? 'bg-black/30'
              : 'bg-[linear-gradient(90deg,rgba(0,0,0,1)_0%,rgba(0,0,0,0)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))] rtl:bg-[linear-gradient(270deg,rgba(0,0,0,1)_0%,rgba(0,0,0,0)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))]'
          "
          aria-hidden="true"
        />

        <!--
          Figma 1419:9322 is `align-items: flex-end` — the copy block and the
          button both sit on the bottom padding edge, not on the vertical
          centre. `items-center` left the button floating half a line above
          the subtitle's baseline.
        -->
        <div
          class="relative z-10 flex flex-col items-start justify-between gap-8 md:flex-row md:items-end"
          :class="inline ? 'min-h-[59px]' : 'min-h-[65px] rtl:min-h-[72px]'"
        >
          <div class="flex flex-col items-start gap-2">
            <h2
              class="font-medium leading-normal text-white"
              :class="inline ? 'text-[20px]' : 'text-[20px] md:text-[22px]'"
              :style="{ color: section.colors?.title || undefined }"
            >
              {{ section.title }}
            </h2>
            <p
              class="font-normal leading-normal text-neutral-100"
              :class="inline ? 'text-[14px]' : 'text-[16px]'"
              :style="{ color: section.colors?.description || undefined }"
            >
              {{ section.description }}
            </p>
          </div>

          <button
            v-if="section.primaryCta"
            type="button"
            class="inline-flex shrink-0 items-center justify-center rounded-sm border border-white font-normal leading-normal text-white transition-colors duration-300 hover:border-gold hover:bg-gold hover:text-ink"
            :class="inline ? 'px-6 py-3 text-[18px]' : 'px-8 py-4 text-[20px]'"
            @click="openModal"
          >
            {{ section.primaryCta.label }}
          </button>
        </div>
      </div>
    </div>

    <Teleport to="body">
      <div
        v-if="isOpen"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 p-5 backdrop-blur-[5px]"
        role="presentation"
        @click.self="closeModal"
        @keydown.esc="closeModal"
      >
        <div
          ref="dialog"
          class="relative flex max-h-[calc(100vh-40px)] w-full max-w-[706px] flex-col items-center overflow-y-auto rounded-lg bg-white p-6 outline-none md:p-12"
          role="dialog"
          aria-modal="true"
          :aria-labelledby="
            isComplete ? 'checklist-success-title' : 'checklist-title'
          "
          tabindex="-1"
        >
          <button
            type="button"
            class="absolute end-4 top-4 rounded-full p-2 text-neutral-700 transition-colors hover:bg-neutral-100"
            :aria-label="t('forms.newsletter.close')"
            @click="closeModal"
          >
            <X class="size-5" aria-hidden="true" />
          </button>

          <template v-if="isComplete">
            <img
              src="/images/sahra/checklist-success.svg"
              alt=""
              width="96"
              height="94"
              class="mb-12 size-24 object-contain"
              aria-hidden="true"
            />
            <h2
              id="checklist-success-title"
              class="max-w-[520px] text-center text-[24px] font-medium leading-normal text-neutral-900"
            >
              {{ t("forms.newsletter.downloaded") }}<br />
              {{ t("forms.newsletter.sent") }}
            </h2>
            <a
              :href="`/${page.props.locale.current}/contact`"
              class="mt-8 inline-flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-ink"
            >
              {{ t("forms.newsletter.consultation") }}
              <ArrowUpRight
                class="size-6 rtl:-scale-x-100"
                aria-hidden="true"
              />
            </a>
          </template>

          <template v-else>
            <div class="flex w-full flex-col items-center gap-6 text-center">
              <h2
                id="checklist-title"
                class="text-[26px] font-medium leading-normal text-neutral-900 md:text-[32px]"
              >
                {{ t("forms.newsletter.title") }}
              </h2>
              <p
                class="max-w-[612px] text-[14px] leading-normal text-neutral-700"
              >
                {{ t("forms.newsletter.description") }}
              </p>
            </div>

            <form
              class="mt-4 flex w-full max-w-[396px] flex-col gap-6 md:mt-8"
              novalidate
              @submit.prevent="submit"
            >
              <div class="hidden" aria-hidden="true">
                <label for="checklist-website">Website</label>
                <input
                  id="checklist-website"
                  v-model="form.website"
                  tabindex="-1"
                  autocomplete="off"
                />
              </div>

              <div>
                <label
                  for="checklist-name"
                  class="mb-2 block text-[14px] font-medium text-neutral-800"
                  >{{ t("forms.newsletter.name") }}</label
                >
                <div
                  class="flex items-center gap-2 rounded-sm border border-gold-300 bg-white/80 p-3 focus-within:border-ink"
                >
                  <UserRound
                    class="size-6 shrink-0 text-neutral-600"
                    :stroke-width="1.5"
                    aria-hidden="true"
                  />
                  <input
                    id="checklist-name"
                    v-model="form.name"
                    type="text"
                    autocomplete="name"
                    required
                    :placeholder="t('forms.newsletter.name_placeholder')"
                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-[14px] focus:ring-0"
                  />
                </div>
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                  {{ form.errors.name }}
                </p>
              </div>

              <div>
                <label
                  for="checklist-email"
                  class="mb-2 block text-[14px] font-medium text-neutral-800"
                  >{{ t("forms.newsletter.email") }}</label
                >
                <div
                  class="flex items-center gap-2 rounded-sm border border-gold-300 bg-white/80 p-3 focus-within:border-ink"
                >
                  <Mail
                    class="size-6 shrink-0 text-neutral-600"
                    :stroke-width="1.5"
                    aria-hidden="true"
                  />
                  <input
                    id="checklist-email"
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    required
                    :placeholder="t('forms.newsletter.email_placeholder')"
                    class="min-w-0 flex-1 border-0 bg-transparent p-0 text-[14px] focus:ring-0"
                  />
                </div>
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                  {{ form.errors.email }}
                </p>
              </div>

              <button
                type="submit"
                class="mx-auto rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-ink disabled:opacity-60"
                :disabled="form.processing"
              >
                {{ t("forms.newsletter.submit") }}
              </button>
            </form>
            <p
              class="mt-8 text-center text-[12px] font-medium text-neutral-700"
            >
              {{ t("forms.newsletter.privacy") }}
            </p>
          </template>
        </div>
      </div>
    </Teleport>
  </section>
</template>
