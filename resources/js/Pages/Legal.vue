<script setup lang="ts">
/**
 * Legal page — shared template for Privacy Policy (Figma 1031:2101 / mobile
 * 1590:10953) and Terms & Conditions (1072:2618 / mobile 1590:11500). Both
 * render the same rich-text body from a Page's translated `content` column.
 *
 * Header is Figma 1091:3353 — a space-between row: a 612-wide column holding
 * the title (48/600) above the intro (18/500) at gap 48, with the
 * last-updated line (18/400) pushed to the far end. Body is 1031:2213: one
 * column at gap 64, each section a heading (30/500) over copy (20/400) at
 * gap 24.
 */
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SeoHead from '@/Components/SeoHead.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { SeoMeta, SharedProps } from '@/types'

const props = defineProps<{
  title: string
  subtitle: string
  content: string
  updatedAt: string | null
  seo: SeoMeta
}>()

const page = usePage<SharedProps>()
const { t } = useTranslations()
const isPrivacy = computed(() => page.url.includes('privacy-policy'))

/**
 * Figma reads "Last updated: July 2026" — month and year only, so a same-month
 * content edit doesn't visibly churn the page.
 */
const lastUpdated = computed(() => {
  if (!props.updatedAt) return null

  const date = new Intl.DateTimeFormat(page.props.locale.htmlLang, {
    year: 'numeric',
    month: 'long',
  }).format(new Date(props.updatedAt))

  return t('common.last_updated', { date })
})
</script>

<template>
  <SeoHead :meta="seo" />

  <section
    class="min-h-[2499px] pb-[160px] pt-[160px] md:min-h-0 md:pt-[192px]"
    :class="isPrivacy ? 'md:pb-[250px]' : 'md:pb-[202px]'"
  >
    <div class="container-sahra">
      <!-- Figma 1091:3353 — title/intro column, last-updated at the far end. -->
      <div class="flex flex-col gap-4 md:gap-6 lg:flex-row lg:items-start lg:justify-between lg:gap-16">
        <div class="flex max-w-[612px] flex-col gap-4 md:gap-12">
          <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">{{ title }}</h1>
          <p v-if="subtitle" class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">
            {{ subtitle }}
          </p>
        </div>

        <p v-if="lastUpdated" class="shrink-0 text-[12px] leading-normal text-neutral-700 md:text-title-sm">
          {{ lastUpdated }}
        </p>
      </div>

      <!--
        Figma 1031:2213. `prose` gives the rich text sane defaults; the
        modifiers below pin it to the file's own metrics. Lists are rendered
        unmarked because the design sets them as plain lines inside the
        paragraph stack, not as bulleted lists.
      -->
      <article
        class="prose prose-neutral mt-10 max-w-none md:mt-24
               prose-headings:mb-4 prose-headings:mt-8 prose-headings:text-[22px]
               md:prose-headings:mb-6 md:prose-headings:mt-16 md:prose-headings:text-heading-lg
               prose-headings:font-medium prose-headings:text-neutral-900
               first:prose-headings:mt-0
               prose-p:my-0 prose-p:text-body-md prose-p:text-neutral-800 md:prose-p:text-body-xl
               prose-a:text-gold prose-a:no-underline hover:prose-a:underline
               prose-ul:my-0 prose-ul:list-none prose-ul:ps-0
               prose-li:my-0 prose-li:ps-0 prose-li:text-body-md prose-li:text-neutral-800 md:prose-li:text-body-xl
               prose-li:marker:content-none
               [&_p+p]:mt-4 md:[&_p+p]:mt-6 [&_p+ul]:mt-0 [&_ul+p]:mt-4 md:[&_ul+p]:mt-6"
        v-html="content"
      />
    </div>
  </section>
</template>
