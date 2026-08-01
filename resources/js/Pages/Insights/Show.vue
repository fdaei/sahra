<script setup lang="ts">
/**
 * Single article — Figma 604:1464 (desktop, LTR) / 1352:7391 (RTL) /
 * 1543:11175 (mobile).
 *
 * Frame geometry:
 *   page    1222:4369 column, gap 224, width 1248
 *   head    1222:4364 column, gap 64
 *     info  1219:4239 row space-between → [title + subtitle] [meta list]
 *     cover   604:1533 fill × 624, radius 16, 1px black/100, shadow 4/4/12
 *   body    1222:4363 row, gap 40 → [119 spacer] [article 826] [share rail 119]
 *     rail    622:1143 column align center gap 24; label 14/500 centred,
 *             then three 68×68 buttons stacked with gap 16
 *   related 1220:4342 column, gap 48
 *
 * Authors place the lead-magnet strip inside the article with the
 * [[lead_magnet]] placeholder. Older articles without the placeholder retain
 * the original midpoint placement until an editor chooses an exact position.
 */
import { computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import {
  CalendarDays,
  Check,
  Link2,
  Linkedin,
  PenLine,
  Tag,
} from "lucide-vue-next";
import SeoHead from "@/Components/SeoHead.vue";
import CtaBanner from "@/Components/CtaBanner.vue";
import LeadMagnet from "@/Components/Sections/LeadMagnet.vue";
import { useTranslations } from "@/Composables/useTranslations";
import type { PostDetail, SeoMeta, SharedProps } from "@/types";

const props = defineProps<{
  post: PostDetail;
  leadMagnet: InstanceType<typeof LeadMagnet>["$props"]["section"] | null;
  finalCta: InstanceType<typeof CtaBanner>["$props"]["section"] | null;
  seo: SeoMeta;
}>();

const page = usePage<SharedProps>();
const { t } = useTranslations();

/** Meta list — Figma "infos" 1016:1839. Rows drop when the field is empty. */
const meta = computed(() =>
  [
    {
      icon: CalendarDays,
      label: t("blog.date"),
      value: props.post.publishedAt,
    },
    {
      icon: PenLine,
      label: t("blog.written_by"),
      value: props.post.author?.name ?? "",
    },
    {
      icon: Tag,
      label: t("blog.subject"),
      value: props.post.category?.name ?? "",
    },
  ].filter((row) => row.value),
);

type ArticlePart = { type: "html"; html: string } | { type: "leadMagnet" };

const leadMagnetMarker = "[[lead_magnet]]";
const leadMagnetSentinel = "\u0000LEAD_MAGNET\u0000";

/**
 * Replace authored placeholders with component entries while keeping the
 * article HTML around them intact. Trix may wrap a marker-only line in either
 * a paragraph or a div, so remove that wrapper before splitting.
 */
const articleParts = computed<ArticlePart[]>(() => {
  const html = props.post.content;

  if (!props.leadMagnet) return [{ type: "html", html }];

  if (html.includes(leadMagnetMarker)) {
    const markedHtml = html
      .replace(
        /<(?:p|div)>\s*\[\[lead_magnet\]\]\s*<\/(?:p|div)>/gi,
        leadMagnetSentinel,
      )
      .replace(/\[\[lead_magnet\]\]/gi, leadMagnetSentinel);

    return markedHtml
      .split(leadMagnetSentinel)
      .flatMap<ArticlePart>((part, index, parts) => {
        const entries: ArticlePart[] = [];

        if (part.trim()) entries.push({ type: "html", html: part });
        if (index < parts.length - 1) entries.push({ type: "leadMagnet" });

        return entries;
      });
  }

  if (html.length < 1200) return [{ type: "html", html }];

  const headings = [...html.matchAll(/<h[23][\s>]/gi)].map((m) => m.index ?? 0);
  const cut = headings.find((i) => i > html.length / 2);

  if (cut === undefined) return [{ type: "html", html }];

  return [
    { type: "html", html: html.slice(0, cut) },
    { type: "leadMagnet" },
    { type: "html", html: html.slice(cut) },
  ];
});

const copied = ref(false);

async function copyLink(): Promise<void> {
  try {
    await navigator.clipboard.writeText(window.location.href);
    copied.value = true;
    setTimeout(() => (copied.value = false), 2000);
  } catch {
    copied.value = false;
  }
}

const shareUrl = computed(() => props.seo.canonical);

const xShare = computed(
  () =>
    `https://x.com/intent/tweet?url=${encodeURIComponent(shareUrl.value)}&text=${encodeURIComponent(props.post.title)}`,
);

const linkedInShare = computed(
  () =>
    `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl.value)}`,
);
</script>

<template>
  <SeoHead
    :meta="seo"
    :breadcrumbs="[
      {
        name: t('blog.related'),
        url: `/${page.props.locale.current}/insights`,
      },
      { name: post.title, url: seo.canonical },
    ]"
  />

  <div
    class="container-sahra flex flex-col gap-24 pb-32 pt-[136px] md:gap-[144px] md:pt-[184px] lg:gap-[224px]"
  >
    <!-- Head — Figma 1222:4364 (column, gap 64) -->
    <div class="flex flex-col gap-16">
      <div
        class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-between"
      >
        <div class="flex max-w-[612px] flex-col gap-6">
          <h1 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
            {{ post.title }}
          </h1>
          <p
            v-if="post.subtitle"
            class="text-[18px] font-medium text-neutral-700"
          >
            {{ post.subtitle }}
          </p>
        </div>

        <dl v-if="meta.length > 0" class="flex shrink-0 flex-col gap-6">
          <div v-for="row in meta" :key="row.label" class="flex flex-col gap-1">
            <dt class="flex items-center gap-2">
              <component
                :is="row.icon"
                class="size-5 shrink-0 text-gold"
                :stroke-width="1.5"
                aria-hidden="true"
              />
              <span class="text-label-lg text-neutral-1000">{{
                row.label
              }}</span>
            </dt>
            <dd class="text-body-md text-neutral-800">{{ row.value }}</dd>
          </div>
        </dl>
      </div>

      <img
        v-if="post.image"
        :src="post.image.src"
        :srcset="post.image.srcset"
        :alt="post.image.alt"
        width="1248"
        height="624"
        class="aspect-[1248/624] w-full rounded-lg border border-neutral-100 object-cover shadow-card"
      />
    </div>

    <!-- Body + share rail — Figma 1222:4363 -->
    <div class="flex justify-center gap-10">
      <!-- Balancing rail: present in the frame (1222:4343) at zero opacity. -->
      <div class="hidden w-[119px] shrink-0 lg:block" aria-hidden="true" />

      <div class="flex w-full max-w-[826px] flex-col gap-18">
        <template v-for="(part, index) in articleParts" :key="index">
          <article
            v-if="part.type === 'html'"
            class="prose prose-neutral max-w-none prose-headings:font-medium prose-a:text-gold prose-a:no-underline hover:prose-a:underline"
            v-html="part.html"
          />

          <LeadMagnet v-else-if="leadMagnet" :section="leadMagnet" inline />
        </template>

        <div
          v-if="post.tags.length > 0"
          class="border-t border-neutral-100 pt-8"
        >
          <p class="mb-3 text-label-md text-neutral-500">
            {{ t("blog.tags") }}
          </p>
          <ul class="flex flex-wrap gap-2">
            <li
              v-for="tag in post.tags"
              :key="tag.slug"
              class="rounded-round border border-neutral-200 px-4 py-2 text-label-md text-neutral-700"
            >
              {{ tag.name }}
            </li>
          </ul>
        </div>
      </div>

      <!-- Share rail — Figma 622:1143 -->
      <div
        class="hidden w-[119px] shrink-0 flex-col items-center gap-6 lg:flex"
      >
        <p class="text-center text-label-lg text-neutral-900">
          {{ t("blog.share") }}
        </p>

        <div class="flex flex-col gap-4">
          <button
            type="button"
            class="flex size-[68px] items-center justify-center rounded-round border border-neutral-200 text-neutral-800 transition-colors hover:border-ink hover:text-ink"
            :aria-label="copied ? t('blog.link_copied') : t('blog.copy_link')"
            @click="copyLink"
          >
            <component
              :is="copied ? Check : Link2"
              class="size-6"
              aria-hidden="true"
            />
          </button>

          <a
            :href="xShare"
            target="_blank"
            rel="noopener noreferrer"
            class="flex size-[68px] items-center justify-center rounded-round border border-neutral-200 text-neutral-800 transition-colors hover:border-ink hover:text-ink"
            aria-label="X"
          >
            <svg
              class="size-5"
              viewBox="0 0 24 24"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
              />
            </svg>
          </a>

          <a
            :href="linkedInShare"
            target="_blank"
            rel="noopener noreferrer"
            class="flex size-[68px] items-center justify-center rounded-round border border-neutral-200 text-neutral-800 transition-colors hover:border-ink hover:text-ink"
            aria-label="LinkedIn"
          >
            <Linkedin class="size-6" :stroke-width="1.5" aria-hidden="true" />
          </a>
        </div>
      </div>
    </div>

    <!-- Related — Figma 1220:4342, "blog card" 1228:4645 -->
    <section v-if="post.related.length > 0" class="flex flex-col gap-12">
      <h2 class="text-[32px] font-semibold text-neutral-900 md:text-[40px]">
        {{ t("blog.related") }}
      </h2>

      <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <li v-for="related in post.related" :key="related.slug">
          <Link
            :href="related.url"
            class="group flex flex-col gap-4 rounded-lg"
          >
            <img
              v-if="related.image"
              :src="related.image.src"
              :srcset="related.image.srcset"
              :alt="related.image.alt"
              width="400"
              height="400"
              class="h-[400px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02]"
            />
            <div class="flex flex-col gap-4">
              <div class="flex items-center gap-4">
                <time
                  :datetime="related.publishedAtIso"
                  class="flex items-center gap-2 text-body-md text-neutral-500"
                >
                  <CalendarDays
                    class="size-6 text-gold"
                    :stroke-width="1.5"
                    aria-hidden="true"
                  />
                  {{ related.publishedAt }}
                </time>
                <span
                  class="flex items-center gap-2 text-body-md text-neutral-500"
                >
                  <span
                    class="inline-block size-1 rounded-full bg-gold"
                    aria-hidden="true"
                  />
                  {{ t("blog.reading_time", { minutes: related.readingTime }) }}
                </span>
              </div>
              <h3 class="text-title-lg text-neutral-900">
                {{ related.title }}
              </h3>
            </div>
          </Link>
        </li>
      </ul>
    </section>
  </div>

  <CtaBanner v-if="finalCta" :section="finalCta" />
</template>
