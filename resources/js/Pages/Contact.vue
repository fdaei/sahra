<script setup lang="ts">
/**
 * Contact page — Figma node 1363:8934 (desktop) / 1494:9544 (mobile).
 *
 * Form fields per App\Http\Requests\ContactSubmissionRequest: name,
 * brand_name, phone, email, message, service_ids[]. Two silent spam guards
 * are wired here to match the backend: a visually-hidden honeypot
 * (`website`, must stay empty) and `form_started_at` (ms timestamp captured
 * on mount, rejected server-side if submitted under 3s).
 */
import { onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import SeoHead from '@/Components/SeoHead.vue'
import { useTranslations } from '@/Composables/useTranslations'
import type { SeoMeta } from '@/types'

interface SectionContent {
  eyebrow: string
  title: string
  subtitle: string
  description: string
  content: string
  colors: Record<'eyebrow' | 'title' | 'subtitle' | 'description' | 'content', string | null>
  primaryCta: { label: string; url: string } | null
  secondaryCta: { label: string; url: string } | null
  image: { src: string; alt: string; width: number; height: number } | null
  items: Array<{ value: string; title: string; description: string; icon: string | null }>
}

defineProps<{
  sections: Record<string, SectionContent>
  heading: { eyebrow: string; title: string; description: string }
  services: { id: number; title: string }[]
  seo: SeoMeta
}>()

const { t } = useTranslations()

const form = useForm({
  name: '',
  brand_name: '',
  phone: '',
  email: '',
  message: '',
  service_ids: [] as number[],
  website: '',
  form_started_at: 0,
})

onMounted(() => {
  form.form_started_at = Date.now()
})

function submit(): void {
  form.post(window.location.pathname, {
    preserveScroll: true,
    onSuccess: () => form.reset('name', 'brand_name', 'phone', 'email', 'message', 'service_ids'),
  })
}
</script>

<template>
  <SeoHead :meta="seo" />

  <!-- Contact heading — Figma 1363:8934 -->
  <section class="section">
    <div class="container-sahra grid gap-14 lg:grid-cols-2">
      <div>
        <div class="eyebrow">{{ heading.eyebrow }}</div>
        <h1 class="text-display-md">{{ heading.title }}</h1>
        <p class="mt-6 max-w-md text-body-lg text-neutral-600">{{ heading.description }}</p>
      </div>

      <!-- Contact form -->
      <form class="flex flex-col gap-6" novalidate @submit.prevent="submit">
        <!-- Honeypot — hidden from sighted and AT users, bots fill it in. -->
        <div class="hidden" aria-hidden="true">
          <label for="website">Website</label>
          <input id="website" v-model="form.website" type="text" name="website" tabindex="-1" autocomplete="off" />
        </div>

        <div>
          <label for="name" class="mb-2 block text-label-lg text-neutral-800">{{ t('forms.contact.name') }}</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            :placeholder="t('forms.contact.name_placeholder')"
            class="w-full rounded-sm border border-neutral-200 px-4 py-3 text-body-lg focus:border-ink"
          />
          <p v-if="form.errors.name" class="mt-1 text-label-md text-red-600">{{ form.errors.name }}</p>
        </div>

        <div>
          <label for="brand" class="mb-2 block text-label-lg text-neutral-800">{{ t('forms.contact.brand') }}</label>
          <input
            id="brand"
            v-model="form.brand_name"
            type="text"
            :placeholder="t('forms.contact.brand_placeholder')"
            class="w-full rounded-sm border border-neutral-200 px-4 py-3 text-body-lg focus:border-ink"
          />
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
          <div>
            <label for="phone" class="mb-2 block text-label-lg text-neutral-800">{{ t('forms.contact.phone') }}</label>
            <input
              id="phone"
              v-model="form.phone"
              type="tel"
              placeholder="+968"
              class="w-full rounded-sm border border-neutral-200 px-4 py-3 text-body-lg focus:border-ink"
            />
            <p v-if="form.errors.phone" class="mt-1 text-label-md text-red-600">{{ form.errors.phone }}</p>
          </div>

          <div>
            <label for="email" class="mb-2 block text-label-lg text-neutral-800">{{ t('forms.newsletter.email') }}</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="w-full rounded-sm border border-neutral-200 px-4 py-3 text-body-lg focus:border-ink"
            />
            <p v-if="form.errors.email" class="mt-1 text-label-md text-red-600">{{ form.errors.email }}</p>
          </div>
        </div>

        <div v-if="services.length > 0">
          <p class="mb-2 text-label-lg text-neutral-800">{{ t('forms.contact.services') }}</p>
          <div class="flex flex-wrap gap-3">
            <label
              v-for="service in services"
              :key="service.id"
              class="flex cursor-pointer items-center gap-2 rounded-round border px-4 py-2 text-label-md"
              :class="form.service_ids.includes(service.id) ? 'border-ink bg-ink text-paper' : 'border-neutral-200 text-neutral-700'"
            >
              <input
                type="checkbox"
                :value="service.id"
                v-model="form.service_ids"
                class="sr-only"
              />
              {{ service.title }}
            </label>
          </div>
        </div>

        <div>
          <label for="message" class="mb-2 block text-label-lg text-neutral-800">{{ t('forms.contact.message') }}</label>
          <textarea
            id="message"
            v-model="form.message"
            rows="4"
            :placeholder="t('forms.contact.message_placeholder')"
            class="w-full rounded-sm border border-neutral-200 px-4 py-3 text-body-lg focus:border-ink"
          />
        </div>

        <button
          type="submit"
          :disabled="form.processing"
          class="mt-2 inline-flex items-center justify-center gap-1 rounded-sm bg-ink px-8 py-4
                 text-title-md text-paper transition-opacity hover:opacity-90 disabled:opacity-50"
        >
          {{ form.processing ? t('common.sending') : t('forms.contact.submit') }}
        </button>
      </form>
    </div>
  </section>
</template>
