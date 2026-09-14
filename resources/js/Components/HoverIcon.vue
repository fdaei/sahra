<script setup lang="ts">
const props = defineProps<{
  name?: string | null
  hoverName?: string | null
}>()

const isImage = (name?: string | null) =>
  Boolean(name && (name.startsWith('/') || /^https?:\/\//.test(name)))

const baseName = () => props.name || props.hoverName
const hasBaseImage = () => isImage(baseName())
const hasHoverImage = () => isImage(props.hoverName) && hasBaseImage()
</script>

<template>
  <span
    v-if="hasBaseImage()"
    class="relative inline-flex size-[1em] shrink-0"
    aria-hidden="true"
  >
    <img
      :src="baseName()!"
      alt=""
      class="size-full object-contain"
      :class="hasHoverImage() ? 'transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0' : ''"
    />
    <img
      v-if="hasHoverImage()"
      :src="props.hoverName!"
      alt=""
      class="absolute inset-0 size-full object-contain opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100"
    />
  </span>
</template>
