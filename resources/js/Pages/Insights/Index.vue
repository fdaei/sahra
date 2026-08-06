<script setup lang="ts">
/**
 * Blog listing — Figma 569:1175 (desktop, LTR) / 1353:7935 (RTL) /
 * 1530:10875 (mobile).
 *
 * Frame geometry:
 *   heading row        title block left, filter list 569:1184 right
 *   featured  609:1017 row, padding 16, gap 32, fill #FBF9F5, radius 16
 *     image   571:1116 612×459, radius 16, 1px black/100, shadow 4/4/12
 *     body    609:1016 column gap 48 → badge, then column gap 72
 *       copy  587:1220 column gap 24 → title 32/500 black-900,
 *                                      excerpt 16/400 black-800
 *       meta  587:1227 row space-between → date + read time, "Read Article" cta
 *   rows    1228:4571 row, gap 24 — the design runs one 2-up row, then 3-up
 *   card    1228:4645 column gap 16
 *     img            fill × 400, radius 16, 1px black/100, shadow 4/4/12
 *     info           row gap 16: calendar icon + date, gold 4px dot + read time
 *     title          28/500 black-900
 *
 * The featured card is only present on an unfiltered first page — see
 * PostController@index.
 */
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { ArrowUpRight, CalendarDays, ChevronDown } from "lucide-vue-next";
import CtaBanner from "@/Components/CtaBanner.vue";
import FilterChips from "@/Components/FilterChips.vue";
import SeoHead from "@/Components/SeoHead.vue";
import { useTranslations } from "@/Composables/useTranslations";
import type { PostSummary, SeoMeta, SharedProps } from "@/types";

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
  heading: { eyebrow: string; title: string; description: string };
  featured: PostSummary | null;
  posts: {
    data: PostSummary[];
    currentPage: number;
    lastPage: number;
    total: number;
    nextPageUrl: string | null;
    prevPageUrl: string | null;
  };
  categories: { slug: string; name: string }[];
  filters: { category: string | null; q: string | null };
  sections: Record<string, SectionContent>;
  seo: SeoMeta;
}>();

const page = usePage<SharedProps>();
const { t } = useTranslations();

const basePath = computed(() => `/${page.props.locale.current}/insights`);

/**
 * The frame lays the first two cards out 2-up (612 wide) and everything
 * after them 3-up (400 wide), so the split is part of the design, not an
 * arbitrary breakpoint.
 */
const leadRow = computed(() => props.posts.data.slice(0, 2));
const restRows = computed(() => props.posts.data.slice(2));
</script>

<template>
  <SeoHead :meta="seo" />

  <div
    class="container-sahra flex flex-col gap-12 pb-32 pt-[160px] md:gap-24 md:pt-[192px]"
  >
    <!-- Heading + filters -->
    <div
      class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-between"
    >
      <!-- "Main title & tag" 1016:1891 — eyebrow, gap 48, then title over
           subtitle at gap 24. -->
      <div class="flex max-w-[612px] flex-col gap-12">
        <p class="eyebrow">{{ heading.eyebrow }}</p>
        <div class="flex flex-col gap-6">
          <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">
            {{ heading.title }}
          </h1>
          <p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">
            {{ heading.description }}
          </p>
        </div>
      </div>

      <FilterChips
        v-if="categories.length > 0"
        :items="categories"
        :active="filters.category"
        param-name="category"
        :base-path="basePath"
        :extra-params="{ q: filters.q }"
        direction="column"
      />
    </div>

    <!-- Featured — Figma 609:1017 -->
    <Link
      v-if="featured"
      :href="featured.url"
      class="group flex flex-col gap-4 rounded-lg md:gap-8 md:bg-[#FBF9F5] md:p-4 lg:flex-row lg:items-center"
    >
      <img
        v-if="featured.image"
        :src="featured.image.src"
        :srcset="featured.image.srcset"
        :alt="featured.image.alt"
        width="612"
        height="459"
        class="aspect-[612/459] w-full shrink-0 rounded-lg border border-neutral-100 object-cover shadow-card lg:w-[612px]"
      />

      <div class="flex flex-1 flex-col gap-4 md:gap-12">
        <span
          v-if="featured.category"
          class="w-fit rounded-round bg-gold-600 px-2 py-1 text-body-md text-paper"
        >
          {{ featured.category.name }}
        </span>

        <div class="flex flex-col gap-4 md:gap-[72px]">
          <div class="flex flex-col gap-6">
            <h2 class="text-[18px] font-medium text-neutral-900 md:text-[32px]">
              {{ featured.title }}
            </h2>
            <p class="hidden text-body-lg text-neutral-800 md:block">{{ featured.excerpt }}</p>
          </div>

          <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
              <time
                :datetime="featured.publishedAtIso"
                class="flex items-center gap-2 text-body-md text-neutral-500"
              >
                <CalendarDays
                  class="size-6 text-gold"
                  :stroke-width="1.5"
                  aria-hidden="true"
                />
                {{ featured.publishedAt }}
              </time>
              <span
                class="flex items-center gap-2 text-body-md text-neutral-500"
              >
                <span
                  class="inline-block size-1 rounded-full bg-gold"
                  aria-hidden="true"
                />
                {{ t("blog.reading_time", { minutes: featured.readingTime }) }}
              </span>
            </div>

            <span
              class="hidden items-center gap-2 text-body-lg font-medium text-neutral-900 md:flex"
            >
              {{ t("common.read_article") }}
              <ArrowUpRight
                class="size-6 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1 rtl:-scale-x-100"
                :stroke-width="1.5"
                aria-hidden="true"
              />
            </span>
          </div>
        </div>
      </div>
    </Link>

    <p
      v-if="posts.data.length === 0 && !featured"
      class="py-16 text-center text-body-lg text-neutral-500"
    >
      {{ t("common.empty_posts") }}
    </p>

    <!-- Card rows — 1228:4571 (2-up) then 3-up -->
    <div v-else class="flex flex-col gap-16 md:gap-24">
      <ul v-if="leadRow.length > 0" class="grid gap-6 sm:grid-cols-2">
        <li v-for="post in leadRow" :key="post.slug">
          <Link :href="post.url" class="group flex flex-col gap-4 rounded-lg">
            <img
              v-if="post.image"
              :src="post.image.src"
              :srcset="post.image.srcset"
              :alt="post.image.alt"
              width="612"
              height="400"
              class="h-[245px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"
            />
            <div class="flex flex-col gap-4">
              <div class="flex items-center gap-4">
                <time
                  :datetime="post.publishedAtIso"
                  class="flex items-center gap-2 text-body-md text-neutral-500"
                >
                  <CalendarDays
                    class="size-6 text-gold"
                    :stroke-width="1.5"
                    aria-hidden="true"
                  />
                  {{ post.publishedAt }}
                </time>
                <span
                  class="flex items-center gap-2 text-body-md text-neutral-500"
                >
                  <span
                    class="inline-block size-1 rounded-full bg-gold"
                    aria-hidden="true"
                  />
                  {{ t("blog.reading_time", { minutes: post.readingTime }) }}
                </span>
              </div>
              <h3
                class="text-[18px] font-medium text-neutral-900 md:text-[28px]"
              >
                {{ post.title }}
              </h3>
            </div>
          </Link>
        </li>
      </ul>

      <ul
        v-if="restRows.length > 0"
        class="grid gap-x-6 gap-y-24 sm:grid-cols-2 lg:grid-cols-3"
      >
        <li
          v-for="(post, postIndex) in restRows"
          :key="post.slug"
          :class="postIndex >= 2 ? 'max-sm:hidden' : ''"
        >
          <Link :href="post.url" class="group flex flex-col gap-4 rounded-lg">
            <img
              v-if="post.image"
              :src="post.image.src"
              :srcset="post.image.srcset"
              :alt="post.image.alt"
              width="400"
              height="400"
              class="h-[245px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"
            />
            <div class="flex flex-col gap-4">
              <div class="flex items-center gap-4">
                <time
                  :datetime="post.publishedAtIso"
                  class="flex items-center gap-2 text-body-md text-neutral-500"
                >
                  <CalendarDays
                    class="size-6 text-gold"
                    :stroke-width="1.5"
                    aria-hidden="true"
                  />
                  {{ post.publishedAt }}
                </time>
                <span
                  class="flex items-center gap-2 text-body-md text-neutral-500"
                >
                  <span
                    class="inline-block size-1 rounded-full bg-gold"
                    aria-hidden="true"
                  />
                  {{ t("blog.reading_time", { minutes: post.readingTime }) }}
                </span>
              </div>
              <h3 class="text-[18px] font-medium text-neutral-900 md:text-title-lg">{{ post.title }}</h3>
            </div>
          </Link>
        </li>
      </ul>
    </div>

    <div
      v-if="posts.data.length > 0 && posts.lastPage === 1"
      class="mx-auto inline-flex items-center gap-2 text-body-lg font-medium text-neutral-900"
    >
      {{ t("common.load_more") }}
      <ChevronDown class="size-6 shrink-0" aria-hidden="true" />
    </div>

    <!-- Pagination -->
    <nav
      v-if="posts.lastPage > 1"
      class="flex items-center justify-center gap-4"
      :aria-label="t('common.pagination')"
    >
      <Link
        v-if="posts.prevPageUrl"
        :href="posts.prevPageUrl"
        class="rounded-sm border border-neutral-200 px-6 py-3 text-label-lg text-neutral-800 transition-colors hover:border-ink"
      >
        {{ t("common.previous") }}
      </Link>
      <span class="latin-nums text-body-md text-neutral-500">
        {{ posts.currentPage }} / {{ posts.lastPage }}
      </span>
      <Link
        v-if="posts.nextPageUrl"
        :href="posts.nextPageUrl"
        class="rounded-sm border border-neutral-200 px-6 py-3 text-label-lg text-neutral-800 transition-colors hover:border-ink"
      >
        {{ t("common.next") }}
      </Link>
    </nav>
  </div>

  <!-- Final CTA — Figma 1419:9333 (shared component) -->
  <CtaBanner
    v-if="sections.final_cta"
    :section="sections.final_cta"
    spacing-class="pb-[226px] pt-24 md:pb-[304px]"
  />
</template>
