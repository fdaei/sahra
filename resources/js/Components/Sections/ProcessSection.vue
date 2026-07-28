<script setup lang="ts">
interface ProcessItem {
  value: string;
  title: string;
  description: string;
  icon: string | null;
}

defineProps<{
  section: {
    eyebrow: string;
    title: string;
    subtitle: string;
    items: ProcessItem[];
  };
}>();

const singleAssetIcons: Record<string, string> = {
  discovery: "/icons/sahra/process/discovery.svg",
  strategy: "/icons/sahra/process/strategy.svg",
  publishing: "/icons/sahra/process/publishing.svg",
  optimization: "/icons/sahra/process/optimization.svg",
};

const iconKeys = [
  "discovery",
  "strategy",
  "production",
  "approval",
  "publishing",
  "optimization",
];

const iconKey = (item: ProcessItem, index: number): string =>
  item.icon && iconKeys.includes(item.icon) ? item.icon : iconKeys[index];
</script>

<template>
  <section class="bg-paper py-14 md:py-24 lg:py-28">
    <div class="container-sahra">
      <div class="flex flex-col gap-12">
        <div class="eyebrow mb-0">{{ section.eyebrow }}</div>

        <div
          class="grid gap-6 md:grid-cols-[minmax(0,505px)_minmax(0,612px)] md:justify-between"
        >
          <h2
            class="max-w-[505px] text-display-sm text-neutral-900 md:text-display-md"
          >
            {{ section.title }}
          </h2>
          <p class="max-w-[612px] text-title-sm text-neutral-700">
            {{ section.subtitle }}
          </p>
        </div>
      </div>

      <div
        class="mt-16 grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:mt-24 lg:grid-cols-3 lg:gap-y-12"
      >
        <article
          v-for="(item, index) in section.items"
          :key="item.value"
          class="flex min-w-0 flex-col items-start gap-8 p-4"
        >
          <span
            class="latin-nums border-b border-gold pb-1 text-[36px] font-medium leading-none text-gold-700"
          >
            {{ item.value }}
          </span>

          <div class="flex w-full flex-col items-start gap-[11px]">
            <div class="flex min-w-0 items-center gap-1">
              <span
                class="relative flex size-10 shrink-0 items-center justify-center rounded-round p-1 drop-shadow-[1px_1px_5px_rgba(0,0,0,0.08)]"
              >
                <img
                  v-if="singleAssetIcons[iconKey(item, index)]"
                  :src="singleAssetIcons[iconKey(item, index)]"
                  alt=""
                  class="size-9 object-contain"
                  width="36"
                  height="36"
                />

                <span
                  v-else-if="iconKey(item, index) === 'production'"
                  class="relative block h-9 w-[30px]"
                >
                  <img
                    src="/icons/sahra/process/production-1.svg"
                    alt=""
                    class="absolute left-0 top-[15%] h-[76%] w-[69%]"
                  />
                  <img
                    src="/icons/sahra/process/production-2.svg"
                    alt=""
                    class="absolute left-[43%] top-0 h-[43%] w-[39%]"
                  />
                  <img
                    src="/icons/sahra/process/production-3.svg"
                    alt=""
                    class="absolute right-0 top-[46%] h-[54%] w-[44%]"
                  />
                </span>

                <span
                  v-else-if="iconKey(item, index) === 'approval'"
                  class="relative block h-9 w-[30px]"
                >
                  <img
                    src="/icons/sahra/process/approval-1.svg"
                    alt=""
                    class="absolute left-[19%] top-0 h-[19%] w-[38%]"
                  />
                  <img
                    src="/icons/sahra/process/approval-2.svg"
                    alt=""
                    class="absolute left-0 top-[11%] h-[80%] w-[75%]"
                  />
                  <img
                    src="/icons/sahra/process/approval-3.svg"
                    alt=""
                    class="absolute right-0 top-[54%] h-[38%] w-[37%]"
                  />
                </span>
              </span>

              <h3 class="min-w-0 text-title-lg text-neutral-900">
                {{ item.title }}
              </h3>
            </div>

            <p class="text-body-lg text-neutral-700">
              {{ item.description }}
            </p>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>
