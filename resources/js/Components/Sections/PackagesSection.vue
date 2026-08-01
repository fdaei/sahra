<script setup lang="ts">
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
    class="relative isolate overflow-hidden bg-black py-14 text-paper md:py-24 lg:py-28"
    data-figma-node="1419:9323"
  >
    <img
      src="/images/sahra/packages-bg.png"
      alt=""
      class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 h-auto w-full opacity-40"
    />
    <div class="pointer-events-none absolute inset-0 -z-20 bg-black" />

    <div class="mx-auto w-full max-w-[1248px] px-5 md:px-10 xl:px-0">
      <div class="flex flex-col gap-12">
        <div class="packages-eyebrow">{{ section.eyebrow }}</div>

        <div
          class="grid gap-6 lg:grid-cols-[506px_minmax(0,612px)] lg:justify-between lg:gap-[130px]"
        >
          <h2
            class="max-w-[506px] text-display-sm text-paper md:text-display-md"
          >
            {{ section.title }}
          </h2>
          <p class="max-w-[612px] text-title-sm font-medium text-neutral-100">
            {{ section.subtitle }}
          </p>
        </div>
      </div>

      <div
        class="mt-14 grid items-stretch gap-6 md:mt-18 md:grid-cols-2"
        :class="{ 'xl:grid-cols-3': section.items.length >= 3 }"
      >
        <article
          v-for="item in section.items"
          :key="item.id"
          class="flex min-w-0 flex-col rounded-lg border border-neutral-800 bg-white/[0.07] p-6 md:p-8"
          :class="{
            'border-gold/40 bg-[linear-gradient(135deg,rgba(189,147,59,0.20),rgba(255,255,255,0.07))]':
              item.badge,
          }"
        >
          <div class="flex items-center gap-2">
            <h3 class="text-[28px] font-medium leading-none text-neutral-50">
              {{ item.title }}
            </h3>
            <span
              v-if="item.badge"
              class="rounded-round bg-gold/15 px-2 py-1 text-label-md leading-none text-paper"
            >
              {{ item.badge }}
            </span>
          </div>

          <div class="mt-6">
            <p class="text-label-lg leading-none text-neutral-200">
              {{ item.label }}
            </p>
            <p class="mt-2 flex flex-wrap items-baseline gap-1 text-gold">
              <span class="latin-nums text-[32px] leading-none">{{
                item.value
              }}</span>
              <span class="text-title-sm leading-none text-[#ecdfc5]">{{
                item.suffix
              }}</span>
            </p>
            <p class="mt-4 text-body-md leading-normal text-neutral-300">
              {{ item.description }}
            </p>
          </div>

          <div class="my-6 h-px bg-neutral-800" aria-hidden="true" />

          <ul class="flex flex-1 flex-col gap-6">
            <li
              v-for="feature in item.features"
              :key="feature"
              class="flex items-center gap-[10px] text-body-lg leading-none text-neutral-100"
            >
              <span class="relative size-6 shrink-0" aria-hidden="true">
                <img
                  src="/icons/package-check-ring.svg"
                  alt=""
                  class="absolute inset-0 size-6"
                />
                <img
                  src="/icons/package-check-mark.svg"
                  alt=""
                  class="absolute inset-0 size-6"
                />
              </span>
              <span>{{ feature }}</span>
            </li>
          </ul>

          <div class="my-6 h-px bg-neutral-800" aria-hidden="true" />
          <p class="text-center text-body-lg leading-none text-neutral-100">
            {{ item.footer }}
          </p>
        </article>
      </div>

      <div
        class="mt-14 flex flex-col gap-8 rounded-sm border border-neutral-800 bg-white/[0.07] p-6 md:mt-18 md:flex-row md:items-center md:justify-between md:px-16 md:py-16"
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
.packages-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  color: #bd933b;
  font-family: Idealist, 'Doran FaNum', Vazirmatn, serif;
  font-size: 24px;
  line-height: 1;
}

.packages-eyebrow::before {
  width: 8px;
  height: 8px;
  flex: none;
  border-radius: 9999px;
  background: #bd933b;
  box-shadow:
    -2px -2px 12px rgb(189 147 59 / 50%),
    2px 2px 12px rgb(189 147 59 / 50%);
  content: "";
}
</style>

