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
const footerFont = computed(() =>
  page.props.locale.font === 'arabic' ? 'font-arabic' : 'font-sans',
)

function columnHeading(index: number, fallback: string): string {
  if (index === 0) return t('footer.quick_links')
  if (index === 1) return t('footer.social_links')

  return fallback
}
</script>

<template>
  <footer
    class="relative overflow-hidden rounded-t-lg border-t border-neutral-100 bg-paper
           shadow-[0_-5px_10px_rgba(0,0,0,0.05)]"
    :class="footerFont"
    :lang="page.props.locale.htmlLang"
    :dir="page.props.locale.direction"
  >
    <div class="container-sahra relative py-12">
      <div class="relative z-10 flex flex-col gap-10">
        <div
          class="grid gap-10 md:grid-cols-2
                 lg:grid-cols-[402px_minmax(0,1fr)] lg:justify-between lg:gap-12"
        >
        <!-- Brand -->
        <div class="flex max-w-[402px] flex-col items-start gap-8">
          <BrandLogo variant="full" :height="28" :label="settings.siteName" />
          <p class="text-[16px] font-normal leading-normal text-neutral-600">
            {{ settings.description }}
          </p>
        </div>

          <div
            class="grid gap-10 sm:grid-cols-2
                   lg:grid-cols-[max-content_max-content_minmax(190px,max-content)] lg:gap-[88px]"
          >
            <!-- Menu columns -->
            <nav
              v-for="(column, columnIndex) in columns"
              :key="column.id"
              :aria-label="columnHeading(columnIndex, column.label)"
            >
              <h2 class="text-[16px] font-medium leading-normal text-neutral-900">
                {{ columnHeading(columnIndex, column.label) }}
              </h2>

              <ul class="mt-4 flex flex-col items-start gap-3">
                <li v-for="child in column.children" :key="child.id">
                  <Link
                    :href="child.url"
                    :target="child.target"
                    :rel="child.target === '_blank' ? 'noopener noreferrer' : undefined"
                    class="text-[14px] font-medium leading-normal text-neutral-600
                           transition-colors hover:text-gold"
                  >
                    {{ child.label }}
                  </Link>
                </li>
              </ul>
            </nav>

            <!-- Info -->
            <div>
              <h2 class="text-[16px] font-medium leading-normal text-neutral-900">
                {{ t('footer.info') }}
              </h2>

              <ul class="mt-4 flex flex-col gap-3 text-[14px] font-medium leading-normal text-neutral-600">
                <li v-if="settings.contact.location" class="flex items-center gap-2">
                  <MapPin class="size-4 shrink-0 text-neutral-600" aria-hidden="true" />
                  <span>{{ settings.contact.location }}</span>
                </li>

                <li v-if="settings.contact.phone" class="flex items-center gap-2">
                  <Phone class="size-4 shrink-0 text-neutral-600" aria-hidden="true" />
                  <a
                    :href="`tel:${settings.contact.phone.replace(/\s/g, '')}`"
                    class="latin-nums transition-colors hover:text-gold"
                  >
                    {{ settings.contact.phone }}
                  </a>
                </li>

                <li v-if="settings.contact.email" class="flex items-center gap-2">
                  <Mail class="size-4 shrink-0 text-neutral-600" aria-hidden="true" />
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

        <div
          class="relative z-10 flex flex-col items-center justify-between gap-3
                 border-t border-neutral-300 py-6 text-[14px] font-medium leading-normal
                 text-neutral-600 sm:flex-row"
        >
          <p>{{ t('footer.copyright', { year, name: settings.siteName }) }}</p>

          <div class="flex items-center gap-4">
            <Link :href="privacyUrl" class="underline transition-colors hover:text-gold">
              {{ t('footer.privacy_policy') }}
            </Link>
            <Link :href="termsUrl" class="underline transition-colors hover:text-gold">
              {{ t('footer.terms') }}
            </Link>
          </div>
        </div>
      </div>

      <!-- Watermark is positioned behind the bottom row, as in Figma. -->
      <div
        class="pointer-events-none absolute inset-inline-0 bottom-[-85px] select-none
               text-center font-sans text-[clamp(9rem,21vw,19rem)] font-semibold
               leading-none text-neutral-50"
        aria-hidden="true"
      >
        SAHRA
      </div>
    </div>
  </footer>
</template>
