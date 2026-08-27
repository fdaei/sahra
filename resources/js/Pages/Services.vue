<script setup lang="ts">
/**
 * Services page — Figma node 1323:7189 (desktop) / 1626:12562 (mobile).
 *
 * Stack is Figma 1726:11747 (col gap 224): the heading block 1323:7505
 * (col gap 48 — eyebrow, then title 48/600 over subtitle 18/500 at gap 24),
 * then 1726:11742 holding four "service section" instances (1264:3486, the
 * component the docs/FIGMA-AUDIT.md anchor node instantiates) at gap 224,
 * then the shared final CTA card.
 *
 * Each service section is a space-between row: a 507-wide content column
 * (title 40/600, then description 20/500 over the feature list at gap 48)
 * against a 604x786 image at radius 8. The image side alternates.
 *
 * No detail routes exist in the design (FIGMA-AUDIT §4).
 */
import arcRingsL from '~img/decor/arc-rings-service-l.svg'
import arcRingsR from '~img/decor/arc-rings-service-r.svg'
import CtaBanner from '@/Components/CtaBanner.vue'
import SeoHead from '@/Components/SeoHead.vue'
import type { SeoMeta, ServiceItem } from '@/types'

interface SectionContent {
  eyebrow: string
  title: string
  subtitle: string
  description: string
  content: string
  colors: Record<'eyebrow' | 'title' | 'subtitle' | 'description' | 'content', string | null>
  primaryCta: { label: string; url: string } | null
  secondaryCta: { label: string; url: string } | null
  image: { src: string; alt: string; width: number; height: number } | null
  items: Array<{ value: string; title: string; description: string; icon: string | null }>
}

defineProps<{
  heading: { eyebrow: string; title: string; description: string }
  services: ServiceItem[]
  sections: Record<string, SectionContent>
  seo: SeoMeta
}>()
</script>

<template>
  <SeoHead :meta="seo" />

  <!--
    Decorative arc rings — the two "Clip path group" layers on 1323:7189.
    Positions come from each node's inset against the 1440x5858 frame, not
    from its metadata x/y: the mirrored layer reports x=2263 in a different
    coordinate space, while its inset resolves to left 667. Reading the inset
    is the reliable route.

      1323:7199 (right)  inset -1.59% / -57.2% / 70.63% / 46.32%
                         -> top -93, left 667, 1597x1814, mirrored (-scale-x)
      1323:7190 (left)   inset 38.14% / 11.3% / 24.55% / -44.9%
                         -> top 2234, left -647, 1924x2186

    They are anchored to *elements* rather than to those absolute page offsets,
    because the service list is CMS-driven: a different number of services
    changes the page height and any fixed offset would drift off its section.
    The right layer sits behind the heading and first service, the left layer
    behind the middle of the list — which is where the frame puts them.
  -->
  <section class="relative overflow-hidden pt-[160px] md:pt-[184px]">
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
      <div class="relative mx-auto h-full w-full max-w-frame">
        <img
          :src="arcRingsR"
          alt=""
          width="1597"
          height="1814"
          class="absolute -top-[93px] start-[667px] w-[1597px] max-w-none"
        />
      </div>
    </div>

    <div class="container-sahra relative flex flex-col gap-[72px] lg:gap-[200px]">
      <!-- Heading — Figma 1323:7505 / "Main title & tag" 1363:7520 -->
      <div class="flex h-[184px] max-w-[612px] flex-col gap-6 md:h-auto md:gap-12">
        <p class="eyebrow">{{ heading.eyebrow }}</p>

        <div class="flex flex-col gap-6">
          <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">{{ heading.title }}</h1>
          <p class="text-[16px] leading-normal text-neutral-700 md:text-title-sm md:font-medium">{{ heading.description }}</p>
        </div>
      </div>

      <!-- Service sections — Figma 1726:11742, gap 224 -->
      <div class="relative flex flex-col gap-24 lg:gap-[224px]">
        <!-- 1323:7190 — enters from the inline-start edge, centred on the list. -->
        <div
          class="pointer-events-none absolute inset-x-0 top-1/2 -z-10 hidden -translate-y-1/2 lg:block"
          aria-hidden="true"
        >
          <img
            :src="arcRingsL"
            alt=""
            width="1924"
            height="2186"
            loading="lazy"
            class="absolute -top-[1093px] -start-[647px] w-[1924px] max-w-none"
          />
        </div>

        <article
          v-for="(service, i) in services"
          :key="service.slug"
          class="flex flex-col gap-10 lg:h-auto lg:flex-row lg:items-start lg:justify-between lg:gap-[137px]"
          :class="[
            i % 2 === 1 ? 'lg:flex-row-reverse' : '',
            i < 2 ? 'max-lg:h-[628px]' : 'max-lg:h-[612px]',
          ]"
        >
          <div class="order-2 flex flex-col gap-6 lg:order-none lg:max-w-[507px] lg:gap-10 lg:py-12">
            <h2 class="text-[24px] font-semibold leading-normal text-neutral-900 md:text-display-md">{{ service.title }}</h2>

            <div class="flex flex-col gap-6 lg:gap-12">
              <p class="text-[16px] leading-normal text-neutral-800 md:text-title-md">{{ service.description }}</p>

              <ul v-if="service.features.length > 0" class="flex flex-col gap-4">
                <li
                  v-for="(feature, fi) in service.features"
                  :key="fi"
                  class="ms-6 list-disc text-[16px] font-medium leading-normal text-neutral-800 md:ms-[27px] md:text-title-sm"
                >
                  {{ feature }}
                </li>
              </ul>
            </div>
          </div>

          <img
            v-if="service.image"
            :src="service.image.src"
            :srcset="service.image.srcset"
            :alt="service.image.alt"
            class="order-1 h-[272px] w-full rounded-sm object-cover lg:order-none lg:h-auto lg:aspect-[604/786] lg:w-[604px] lg:shrink-0"
          />
          <div
            v-else
            class="order-1 h-[272px] w-full rounded-sm bg-neutral-100 lg:order-none lg:h-auto lg:aspect-[604/786] lg:w-[604px] lg:shrink-0"
          />
        </article>
      </div>
    </div>
  </section>

  <!-- Final CTA — Figma 1323:7506 (shared component 1419:9333) -->
  <CtaBanner
    v-if="sections.final_cta"
    :section="sections.final_cta"
    spacing-class="pb-[176px] pt-[176px]"
  />
</template>
