<script setup lang="ts">
/**
 * Site footer.
 *
 * Figma: 1419:9317 (1440×431). Four columns —
 *   brand + description | Quick Links | Social Links | Info
 * with a large low-contrast "SAHRA" watermark behind the bottom bar and a
 * copyright / legal-links row beneath a hairline rule.
 *
 * The three link columns come from the `footer` menu: each top-level item is a
 * column heading and its children are the links (NavigationBuilder::footer).
 * The Info column renders settings values rather than menu items.
 */
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { MapPin, Phone, Mail } from 'lucide-vue-next'
import BrandLogo from '@/Components/BrandLogo.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { SharedProps } from '@/types'

const page = usePage<SharedProps>()
const { t } = useTranslations()

const columns = computed(() => page.props.navigation.footer)
const settings = computed(() => page.props.settings)
const year = new Date().getFullYear()
const privacyUrl = computed(() => `/${page.props.locale.current}/privacy-policy`)
const termsUrl = computed(() => `/${page.props.locale.current}/terms`)
</script>

<template>
  <footer class="relative overflow-hidden border-t border-neutral-100 pt-16">
    <div class="container-sahra">
      <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.6fr_1fr_1fr_1.2fr]">
        <!-- Brand -->
        <div>
          <BrandLogo variant="full" :height="44" :label="settings.siteName" />
          <p class="mt-4 max-w-xs text-body-md text-neutral-600">
            {{ settings.description }}
          </p>
        </div>

        <!-- Menu columns -->
        <nav
          v-for="column in columns"
          :key="column.id"
          :aria-label="column.label"
        >
          <h2 class="text-label-lg text-neutral-1000">{{ column.label }}</h2>

          <ul class="mt-4 flex flex-col gap-3">
            <li v-for="child in column.children" :key="child.id">
              <Link
                :href="child.url"
                :target="child.target"
                :rel="child.target === '_blank' ? 'noopener noreferrer' : undefined"
                class="text-body-md text-neutral-600 transition-colors hover:text-gold"
              >
                {{ child.label }}
              </Link>
            </li>
          </ul>
        </nav>

        <!-- Info -->
        <div>
          <h2 class="text-label-lg text-neutral-1000">{{ t('footer.info') }}</h2>

          <ul class="mt-4 flex flex-col gap-3 text-body-md text-neutral-600">
            <li v-if="settings.contact.location" class="flex items-start gap-2">
              <MapPin class="mt-0.5 size-4 shrink-0 text-gold" aria-hidden="true" />
              <span>{{ settings.contact.location }}</span>
            </li>

            <li v-if="settings.contact.phone" class="flex items-start gap-2">
              <Phone class="mt-0.5 size-4 shrink-0 text-gold" aria-hidden="true" />
              <a
                :href="`tel:${settings.contact.phone.replace(/\s/g, '')}`"
                class="latin-nums transition-colors hover:text-gold"
              >
                {{ settings.contact.phone }}
              </a>
            </li>

            <li v-if="settings.contact.email" class="flex items-start gap-2">
              <Mail class="mt-0.5 size-4 shrink-0 text-gold" aria-hidden="true" />
              <a
                :href="`mailto:${settings.contact.email}`"
                class="break-all transition-colors hover:text-gold"
              >
                {{ settings.contact.email }}
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Watermark. Decorative only — hidden from assistive tech. -->
    <div
      class="pointer-events-none select-none text-center font-semibold leading-none
             text-gold-100 [font-size:clamp(4rem,18vw,10rem)] translate-y-[28%]"
      aria-hidden="true"
    >
      SAHRA
    </div>

    <div class="container-sahra relative border-t border-neutral-100">
      <div
        class="flex flex-col items-center justify-between gap-3 py-6 text-label-md
               text-neutral-500 sm:flex-row"
      >
        <p>{{ t('footer.copyright', { year, name: settings.siteName }) }}</p>

        <div class="flex items-center gap-6">
          <Link :href="privacyUrl" class="underline transition-colors hover:text-gold">
            {{ t('footer.privacy_policy') }}
          </Link>
          <Link :href="termsUrl" class="underline transition-colors hover:text-gold">
            {{ t('footer.terms') }}
          </Link>
        </div>
      </div>
    </div>
  </footer>
</template>
