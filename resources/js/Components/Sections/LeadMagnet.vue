<script setup lang="ts">
interface LeadMagnetSection {
  title: string
  description: string
  primaryCta: { label: string; url: string } | null
}

withDefaults(
  defineProps<{
    section: LeadMagnetSection
    /**
     * On the article page (Figma 604:1464) the strip sits inside the 826px
     * body column, so it drops the section rhythm and the outer container.
     */
    inline?: boolean
  }>(),
  { inline: false },
)
</script>

<template>
  <section :class="inline ? '' : 'py-14 md:py-18 lg:py-24'">
    <div :class="inline ? '' : 'container-sahra'">
      <div
        class="relative min-h-[193px] overflow-hidden rounded-sm bg-black
               px-6 py-8 text-white sm:px-10 lg:px-16 lg:py-16"
      >
        <img
          src="/images/sahra/content-direction-checklist-bg.png"
          alt=""
          width="1024"
          height="1024"
          class="pointer-events-none absolute inset-inline-0 bottom-[-90px] h-auto
                 w-[102.73%] max-w-none object-cover max-lg:inset-0 max-lg:size-full
                 max-lg:object-cover max-lg:object-bottom"
          aria-hidden="true"
          decoding="async"
        />
        <div
          class="pointer-events-none absolute inset-0 bg-[linear-gradient(90deg,rgba(35,31,32,.2),rgba(35,31,32,.2)),linear-gradient(90deg,rgba(0,0,0,.88)_0%,rgba(0,0,0,.3)_58%,rgba(0,0,0,.08)_100%)]"
          aria-hidden="true"
        />

        <div
          class="relative z-10 flex min-h-[65px] flex-col items-start justify-between gap-8
                 md:flex-row md:items-center"
        >
          <div class="flex flex-col items-start gap-2">
            <h2 class="text-[20px] font-medium leading-normal text-white md:text-[22px]">
              {{ section.title }}
            </h2>
            <p class="text-[16px] font-normal leading-normal text-neutral-100">
              {{ section.description }}
            </p>
          </div>

          <a
            v-if="section.primaryCta"
            :href="section.primaryCta.url"
            class="inline-flex shrink-0 items-center justify-center rounded-sm border border-white
                   px-8 py-4 text-[20px] font-medium leading-normal text-white
                   transition-colors duration-300 hover:bg-white hover:text-ink"
          >
            {{ section.primaryCta.label }}
          </a>
        </div>
      </div>
    </div>
  </section>
</template>
