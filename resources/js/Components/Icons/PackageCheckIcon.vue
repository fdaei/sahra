<script setup lang="ts">
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import type { SharedProps } from "@/types";

const page = usePage<SharedProps>();
const isArabic = computed(() => page.props.locale.current === "ar");
</script>

<template>
  <span
    class="relative block size-4 shrink-0 overflow-hidden md:size-6"
    aria-hidden="true"
  >
    <img
      src="/icons/package-check-ring.svg"
      alt=""
      class="absolute inset-[8.33%] size-[83.34%]"
    />
    <img
      src="/icons/package-check-mark.svg"
      alt=""
      class="package-check-mark absolute left-[37.5%] top-[41.67%] h-[22.92%] w-[31.25%]"
      :class="{ '-scale-x-100': isArabic }"
    />
  </span>
</template>
