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

const props = defineProps<{ icon: string }>()

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

const component = computed(() => icons[props.icon] ?? Link2)
</script>

<template>
  <component :is="component" aria-hidden="true" />
</template>
