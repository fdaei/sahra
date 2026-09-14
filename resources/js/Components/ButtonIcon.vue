<script setup lang="ts">
import {
  ArrowLeft, ArrowRight, ArrowUpRight, Check, CheckCircle, ChevronRight,
  CirclePlus, Download, ExternalLink, Eye, FileText, Mail, MessageCircle,
  Megaphone, Palette, Phone, Play, Send, Share2, ShoppingCart, Sparkles, Star,
  User, Video,
} from 'lucide-vue-next'

const icons = {
  'arrow-left': ArrowLeft, 'arrow-right': ArrowRight, 'arrow-up-right': ArrowUpRight,
  'chevron-right': ChevronRight, check: Check, 'check-circle': CheckCircle,
  'circle-plus': CirclePlus, download: Download, 'external-link': ExternalLink,
  eye: Eye, 'file-text': FileText, mail: Mail, 'message-circle': MessageCircle,
  phone: Phone, play: Play, send: Send, 'shopping-cart': ShoppingCart,
  sparkles: Sparkles, star: Star, user: User, palette: Palette, video: Video,
  megaphone: Megaphone, 'share-2': Share2,
} as const

const props = defineProps<{
  name?: string | null
  hoverName?: string | null
}>()

const isImage = (name?: string | null) =>
  Boolean(name && (name.startsWith('/') || name.startsWith('http://') || name.startsWith('https://')))

const effectiveName = () => props.name || props.hoverName

const hasHoverIcon = () =>
  Boolean(
    props.name &&
    props.hoverName &&
      (isImage(props.hoverName) || icons[props.hoverName as keyof typeof icons]),
  )
</script>

<template>
  <span
    v-if="hasHoverIcon()"
    class="relative inline-flex size-[1em] shrink-0"
    aria-hidden="true"
  >
    <img
      v-if="isImage(props.name)"
      :src="props.name!"
      alt=""
      class="size-full object-contain transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0"
    />
    <component
      :is="icons[props.name as keyof typeof icons]"
      v-else-if="props.name && icons[props.name as keyof typeof icons]"
      class="size-full transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0"
    />
    <img
      v-if="isImage(props.hoverName)"
      :src="props.hoverName!"
      alt=""
      class="absolute inset-0 size-full object-contain opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100"
    />
    <component
      :is="icons[props.hoverName as keyof typeof icons]"
      v-else-if="props.hoverName && icons[props.hoverName as keyof typeof icons]"
      class="absolute inset-0 size-full opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100"
    />
  </span>
  <img
    v-else-if="isImage(effectiveName())"
    :src="effectiveName()!"
    alt=""
    class="size-[1em] shrink-0 object-contain"
    aria-hidden="true"
  />
  <component
    :is="icons[effectiveName() as keyof typeof icons]"
    v-else-if="effectiveName() && icons[effectiveName() as keyof typeof icons]"
    class="size-[1em] shrink-0"
    aria-hidden="true"
  />
</template>
