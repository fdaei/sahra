<script setup lang="ts">
import {
  ArrowLeft, ArrowRight, ArrowUpRight, Check, CheckCircle, ChevronRight,
  CirclePlus, Download, ExternalLink, Eye, FileText, Mail, MessageCircle,
  Phone, Play, Send, ShoppingCart, Sparkles, Star, User,
} from 'lucide-vue-next'

const icons = {
  'arrow-left': ArrowLeft, 'arrow-right': ArrowRight, 'arrow-up-right': ArrowUpRight,
  'chevron-right': ChevronRight, check: Check, 'check-circle': CheckCircle,
  'circle-plus': CirclePlus, download: Download, 'external-link': ExternalLink,
  eye: Eye, 'file-text': FileText, mail: Mail, 'message-circle': MessageCircle,
  phone: Phone, play: Play, send: Send, 'shopping-cart': ShoppingCart,
  sparkles: Sparkles, star: Star, user: User,
} as const

const props = defineProps<{ name?: string | null }>()

const isImage = (name?: string | null) =>
  Boolean(name && (name.startsWith('/') || name.startsWith('http://') || name.startsWith('https://')))
</script>

<template>
  <img
    v-if="isImage(props.name)"
    :src="props.name!"
    alt=""
    class="size-[1em] shrink-0 object-contain"
    aria-hidden="true"
  />
  <component
    :is="icons[props.name as keyof typeof icons]"
    v-else-if="props.name && icons[props.name as keyof typeof icons]"
    class="size-[1em] shrink-0"
    aria-hidden="true"
  />
</template>
