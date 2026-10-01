<script setup lang="ts">
/**
 * Maps a SocialLink's stored `icon` slug onto a lucide component.
 *
 * The slugs are seeded by database/seeders/SiteSettingsSeeder.php and are
 * editable in the admin, so an unknown value must not blow up the page — it
 * falls back to a neutral link glyph.
 */
import { computed } from 'vue'
import { Instagram, Linkedin, MessageCircle, Twitter, Youtube, Facebook, Link2 } from 'lucide-vue-next'

const props = defineProps<{
  icon: string
  hoverIcon?: string | null
}>()

const icons: Record<string, typeof Link2> = {
  instagram: Instagram,
  linkedin: Linkedin,
  'message-circle': MessageCircle,
  whatsapp: MessageCircle,
  twitter: Twitter,
  x: Twitter,
  youtube: Youtube,
  facebook: Facebook,
}

const imageIcons: Record<string, string> = {
  instagram: '/icons/sahra/contact/social.svg',
  linkedin: '/icons/sahra/contact/social-1.svg',
  'message-circle': '/icons/sahra/contact/social-2.svg',
  whatsapp: '/icons/sahra/contact/social-2.svg',
  twitter: '/icons/sahra/contact/social-3.svg',
  x: '/icons/sahra/contact/social-3.svg',
  youtube: '/icons/sahra/contact/social-4.svg',
}

const component = computed(() => icons[props.icon] ?? Link2)
const imageSource = computed(() => imageIcons[props.icon] ?? (props.icon.startsWith('/') || /^https?:\/\//.test(props.icon) ? props.icon : null))
const isImage = computed(() => Boolean(imageSource.value))
const hoverComponent = computed(() =>
  props.hoverIcon && !props.hoverIcon.startsWith('/') && !/^https?:\/\//.test(props.hoverIcon)
    ? icons[props.hoverIcon] ?? Link2
    : null,
)
const isHoverImage = computed(() =>
  Boolean(props.hoverIcon && (props.hoverIcon.startsWith('/') || /^https?:\/\//.test(props.hoverIcon))),
)
const hasHover = computed(() => Boolean(props.hoverIcon && (isHoverImage.value || hoverComponent.value)))
</script>

<template>
  <span v-if="hasHover" class="relative inline-flex size-[1em] shrink-0" aria-hidden="true">
    <img
      v-if="isImage"
      :src="imageSource!"
      alt=""
      class="size-full object-contain transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0"
    />
    <component
      v-else
      :is="component"
      class="size-full transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0"
    />
    <img
      v-if="isHoverImage"
      :src="props.hoverIcon!"
      alt=""
      class="absolute inset-0 size-full object-contain opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100"
    />
    <component
      v-else
      :is="hoverComponent"
      class="absolute inset-0 size-full opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100"
    />
  </span>
  <img v-else-if="isImage" :src="imageSource!" alt="" aria-hidden="true" />
  <component v-else :is="component" aria-hidden="true" />
</template>
