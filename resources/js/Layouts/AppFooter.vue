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
    <div class="container-sahra relative py-6 md:py-12">
      <div class="relative z-10 flex flex-col gap-2 md:gap-10">
        <div
          class="grid gap-10 md:grid-cols-2
                 lg:flex lg:items-start lg:justify-between lg:gap-0"
        >
        <!-- Brand -->
        <div class="flex max-w-[402px] flex-col items-start gap-4 md:gap-8">
          <!-- Figma 1083:2762 — wordmark over rule, 87×28, no gold mark. -->
          <BrandLogo
            variant="footer"
            :height="28"
            :label="settings.siteName"
            class="h-[28px] w-[87px]"
          />
          <p class="text-[12px] font-normal leading-normal text-neutral-600 md:text-[16px]">
            {{ settings.description }}
          </p>
        </div>

          <div
            class="grid grid-cols-2 gap-x-10 gap-y-10
                   lg:flex lg:shrink-0 lg:items-start lg:gap-[88px]"
          >
            <!-- Menu columns -->
            <nav
              v-for="(column, columnIndex) in columns"
              :key="column.id"
              :aria-label="columnHeading(columnIndex, column.label)"
            >
              <h2 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-[16px]">
                {{ columnHeading(columnIndex, column.label) }}
              </h2>

              <ul class="mt-3 flex flex-col items-start gap-2 md:mt-4 md:gap-3">
                <!--
                  A bare `<li>` keeps `display: list-item` even as a flex
                  child, so without its own font-size it rendered at the
                  ambient 16px/24px line-height instead of the 14px/21px the
                  link inside it actually uses — 3px too tall per row, 18px
                  across the 6-item Quick Links column, which was the entire
                  source of the footer's height drift from Figma (431 vs the
                  live 451). Matching the size here directly fixes it.
                -->
                <li
                  v-for="child in column.children"
                  :key="child.id"
                  class="text-[14px] leading-normal"
                >
                  <Link
                    :href="child.url"
                    :target="child.target"
                    :rel="child.target === '_blank' ? 'noopener noreferrer' : undefined"
                    class="text-[14px] font-normal leading-normal text-neutral-600
                           transition-colors hover:text-gold md:font-medium"
                  >
                    {{ child.label }}
                  </Link>
                </li>
              </ul>
            </nav>

            <!-- Info -->
            <div class="col-span-2 lg:col-span-1">
              <h2 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-[16px]">
                {{ t('footer.info') }}
              </h2>

              <ul
                class="mt-3 flex flex-col gap-2 text-[14px] font-normal leading-normal
                       text-neutral-600 md:mt-4 md:gap-3 md:font-medium"
              >
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
          class="relative z-10 flex flex-col items-start justify-between gap-4
                 border-t border-neutral-300 py-6 text-[12px] font-medium leading-normal
                 text-neutral-600 sm:flex-row sm:items-center sm:gap-3 sm:text-[14px]"
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

      <!--
        Watermark — Figma 1065:2315. This is the Sahra logotype drawn as
        vector paths with a built-in linear gradient (#231F20 at 15% fading to
        transparent), not text: setting "SAHRA" in Poppins gets the wrong
        letterforms and a flat fill. Exported at its native 1248x305.

        VERTICAL POSITION. The file places the group at y=264 inside a 431-tall
        footer at its natural 304.46 height, so it runs 137.46px PAST the
        bottom edge and the footer clips it — only the upper ~55% of the
        letterforms is ever visible. Sitting it flush at `bottom-0` (as it did)
        showed the whole wordmark and read too high against the frame.

        137.46 / 304.46 = 45.15% of the artwork's OWN height, so the offset is
        a self-relative translate rather than a pixel value: `bottom`
        percentages resolve against the containing block, which would drift as
        the footer grows, while `translateY` resolves against the element and
        therefore holds at every breakpoint and in every locale.
      -->
      <img
        src="/icons/sahra/footer-wordmark.svg"
        alt=""
        width="1248"
        height="305"
        class="pointer-events-none absolute inset-inline-0 bottom-0 w-full
               translate-y-[45.15%] select-none"
        aria-hidden="true"
        decoding="async"
      />
    </div>
  </footer>
</template>
