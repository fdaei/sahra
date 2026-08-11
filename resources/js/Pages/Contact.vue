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
import { computed, onBeforeUnmount, onMounted, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { getCountryDataList, getEmojiFlag } from "countries-list";
import {
  BadgeCheck,
  Building2,
  ChevronDown,
  Check,
  Layers3,
  Mail,
  MapPin,
  MessageCircle,
  Search,
  UserRound,
} from "lucide-vue-next";
import SeoHead from "@/Components/SeoHead.vue";
import SocialIcon from "@/Components/SocialIcon.vue";
import { useTranslations } from "@/Composables/useTranslations";
import type { SeoMeta, SharedProps } from "@/types";

interface SectionContent {
  eyebrow: string;
  title: string;
  subtitle: string;
  description: string;
  content: string;
  colors: Record<
    "eyebrow" | "title" | "subtitle" | "description" | "content",
    string | null
  >;
  primaryCta: { label: string; url: string } | null;
  secondaryCta: { label: string; url: string } | null;
  image: { src: string; alt: string; width: number; height: number } | null;
  items: Array<{
    value: string;
    title: string;
    description: string;
    icon: string | null;
  }>;
}

const props = defineProps<{
  sections: Record<string, SectionContent>;
  heading: { eyebrow: string; title: string; description: string };
  services: { id: number; title: string }[];
  seo: SeoMeta;
}>();

const { t } = useTranslations();
const page = usePage<SharedProps>();

/*
 | Contact details panel — Figma 466:1216. Four rows: WhatsApp, Phone, Email
 | and "Working With", each an outlined 48px disc against a label/value pair.
 | Values come from the cached SiteSettings so the admin owns them.
 */
const details = computed(() => {
  const c = page.props.settings.contact;

  return [
    {
      icon: MessageCircle,
      label: t("forms.details.whatsapp"),
      value: c.whatsapp,
      href: `https://wa.me/${c.whatsapp.replace(/\D/g, "")}`,
    },
    {
      icon: MapPin,
      label: t("forms.details.location"),
      value: c.location,
      href: null,
    },
    {
      icon: Mail,
      label: t("forms.details.email"),
      value: c.email,
      href: `mailto:${c.email}`,
    },
    {
      icon: Building2,
      label: t("forms.details.working_with"),
      value: c.workingWith,
      href: null,
    },
  ].filter((row) => row.value);
});

const socialLinks = computed(() => page.props.settings.socialLinks);

const form = useForm({
  name: "",
  brand_name: "",
  phone: "",
  email: "",
  message: "",
  service_ids: [] as number[],
  website: "",
  form_started_at: 0,
});

const countries = computed(() => {
  const locale = page.props.locale.current;
  const displayNames = new Intl.DisplayNames([locale], { type: "region" });

  return getCountryDataList()
    .flatMap((country) =>
      country.phone.map((phone) => ({
        id: `${country.iso2}-${phone}`,
        code: `+${phone}`,
        flag: getEmojiFlag(country.iso2),
        name: displayNames.of(country.iso2) || country.name,
        iso2: country.iso2,
      })),
    )
    .sort((a, b) => {
      if (a.iso2 === "OM") return -1;
      if (b.iso2 === "OM") return 1;
      return a.name.localeCompare(b.name, locale);
    });
});
const selectedCountry = ref(countries.value[0]);
const countrySearch = ref("");
const countryOpen = ref(false);
const servicesOpen = ref(false);
const countryPicker = ref<HTMLElement | null>(null);
const servicesPicker = ref<HTMLElement | null>(null);

const filteredCountries = computed(() => {
  const query = countrySearch.value.trim().toLocaleLowerCase();
  if (!query) return countries.value;
  return countries.value.filter(({ name, code }) =>
    `${name} ${code}`.toLocaleLowerCase().includes(query),
  );
});

const selectedServicesLabel = computed(() => {
  const selected = props.services
    .filter(({ id }) => form.service_ids.includes(id))
    .map(({ title }) => title);
  return selected.length
    ? selected.join(", ")
    : t("forms.contact.services_placeholder");
});

function chooseCountry(country: (typeof countries.value)[number]): void {
  selectedCountry.value = country;
  countryOpen.value = false;
  countrySearch.value = "";
}

function toggleService(id: number): void {
  form.service_ids = form.service_ids.includes(id)
    ? form.service_ids.filter((serviceId) => serviceId !== id)
    : [...form.service_ids, id];
  form.clearErrors("service_ids");
}

function closePopovers(event: MouseEvent): void {
  const target = event.target as Node;
  if (!countryPicker.value?.contains(target)) countryOpen.value = false;
  if (!servicesPicker.value?.contains(target)) servicesOpen.value = false;
}

onMounted(() => {
  form.form_started_at = Date.now();
  document.addEventListener("click", closePopovers);
});
onBeforeUnmount(() => document.removeEventListener("click", closePopovers));

function submit(): void {
  form
    .transform((data) => ({
      ...data,
      phone: data.phone.trim()
        ? `${selectedCountry.value.code} ${data.phone.trim()}`
        : "",
    }))
    .post(window.location.pathname, {
      preserveScroll: true,
      onSuccess: () =>
        form.reset(
          "name",
          "brand_name",
          "phone",
          "email",
          "message",
          "service_ids",
        ),
    });
}
</script>

<template>
  <SeoHead :meta="seo" />

  <!--
    Contact — Figma 447:790. The whole page is one 1248x854 card (453:878) at
    radius 16 over a photographic fill, holding a translucent form panel
    (457:991, blur 20) beside a 423-wide column (1288:4130) that carries the
    contact-details panel and the social row.
  -->
  <section
    class="section min-h-[1945px] pb-32 pt-[136px] md:min-h-0 md:pb-[204px] md:pt-[184px]"
  >
    <div class="container-sahra max-md:px-0">
      <div
        class="relative overflow-visible rounded-lg bg-neutral-100 lg:min-h-[854px] lg:pe-6"
      >
        <img
          src="/images/sahra/contact-bg.png"
          alt=""
          width="1487"
          height="1058"
          class="pointer-events-none absolute inset-0 size-full rounded-lg object-cover object-center opacity-60"
          aria-hidden="true"
          decoding="async"
        />

        <div
          class="relative z-10 flex min-h-[854px] flex-col items-stretch gap-16 lg:flex-row lg:items-center lg:gap-9"
        >
          <!-- Form panel — Figma 457:991 -->
          <div
            class="flex flex-col gap-8 rounded-lg bg-white/10 p-6 backdrop-blur-[10px] md:p-12 lg:h-[854px] lg:w-[765px]"
          >
            <div class="flex flex-col gap-6 md:gap-12">
              <p
                class="eyebrow text-[16px] before:!size-[6px] md:text-[24px] md:before:!size-[11.31px]"
              >
                {{ heading.eyebrow }}
              </p>
              <div class="flex flex-col gap-4 md:gap-6">
                <h1
                  class="text-[26px] font-semibold md:max-w-[620px] md:text-display-md"
                >
                  {{ heading.title }}
                </h1>
                <p
                  class="text-body-lg font-normal text-neutral-700 md:text-title-sm md:font-medium"
                >
                  {{ heading.description }}
                </p>
              </div>
            </div>

            <!-- Contact form -->
            <form
              class="flex min-h-0 flex-1 flex-col gap-6"
              novalidate
              @submit.prevent="submit"
            >
              <!-- Honeypot — hidden from sighted and AT users, bots fill it in. -->
              <div class="hidden" aria-hidden="true">
                <label for="website">Website</label>
                <input
                  id="website"
                  v-model="form.website"
                  type="text"
                  name="website"
                  tabindex="-1"
                  autocomplete="off"
                />
              </div>

              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                  <label
                    for="name"
                    class="mb-2 block text-label-lg text-neutral-800"
                    >{{ t("forms.contact.name") }}</label
                  >
                  <div
                    class="flex items-center gap-2 rounded-sm border bg-paper/80 p-3 transition-colors hover:border-neutral-200 focus-within:border-ink"
                    :class="
                      form.errors.name
                        ? '!border-[#c94a4a] !bg-[#fdf5f5]'
                        : 'border-gold-300'
                    "
                  >
                    <UserRound
                      class="size-6 shrink-0 text-neutral-600"
                      :stroke-width="1.5"
                      aria-hidden="true"
                    />
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      :placeholder="t('forms.contact.name_placeholder')"
                      class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"
                      :aria-invalid="form.errors.name ? 'true' : undefined"
                      :aria-describedby="
                        form.errors.name ? 'name-error' : undefined
                      "
                    />
                  </div>
                  <p
                    v-if="form.errors.name"
                    id="name-error"
                    role="alert"
                    class="mt-1 text-[10px] leading-none text-[#c94a4a]"
                  >
                    {{ form.errors.name }}
                  </p>
                </div>

                <div>
                  <label
                    for="brand"
                    class="mb-2 block text-label-lg text-neutral-800"
                    >{{ t("forms.contact.brand") }}</label
                  >
                  <div
                    class="flex items-center gap-2 rounded-sm border bg-paper/80 p-3 transition-colors hover:border-neutral-200 focus-within:border-ink"
                    :class="
                      form.errors.brand_name
                        ? '!border-[#c94a4a] !bg-[#fdf5f5]'
                        : 'border-gold-300'
                    "
                  >
                    <BadgeCheck
                      class="size-6 shrink-0 text-neutral-600"
                      :stroke-width="1.5"
                      aria-hidden="true"
                    />
                    <input
                      id="brand"
                      v-model="form.brand_name"
                      type="text"
                      :placeholder="t('forms.contact.brand_placeholder')"
                      class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"
                      :aria-invalid="
                        form.errors.brand_name ? 'true' : undefined
                      "
                      :aria-describedby="
                        form.errors.brand_name ? 'brand-error' : undefined
                      "
                    />
                  </div>
                  <p
                    v-if="form.errors.brand_name"
                    id="brand-error"
                    role="alert"
                    class="mt-1 text-[10px] leading-none text-[#c94a4a]"
                  >
                    {{ form.errors.brand_name }}
                  </p>
                </div>
              </div>

              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div ref="countryPicker" class="relative min-w-0">
                  <label
                    for="phone"
                    class="mb-2 block text-label-lg text-neutral-800"
                    >{{ t("forms.contact.phone") }}</label
                  >
                  <div
                    class="flex h-12 overflow-hidden rounded-sm border bg-paper/80 transition-colors hover:border-neutral-200 focus-within:border-ink"
                    :class="
                      form.errors.phone
                        ? '!border-[#c94a4a] !bg-[#fdf5f5]'
                        : 'border-gold-300'
                    "
                  >
                    <button
                      type="button"
                      class="flex items-center gap-2 border-e border-inherit px-3 text-body-md"
                      :aria-expanded="countryOpen"
                      aria-controls="country-options"
                      @click="countryOpen = !countryOpen"
                    >
                      <span class="text-lg" aria-hidden="true">{{
                        selectedCountry.flag
                      }}</span>
                      <ChevronDown
                        class="size-4 text-neutral-700 transition-transform"
                        :class="countryOpen ? 'rotate-180' : ''"
                        :stroke-width="1.5"
                        aria-hidden="true"
                      />
                    </button>
                    <span
                      class="flex items-center ps-3 text-body-md text-neutral-500"
                      dir="ltr"
                      >{{ selectedCountry.code }}</span
                    >
                    <input
                      id="phone"
                      v-model="form.phone"
                      type="tel"
                      :placeholder="t('forms.contact.phone_placeholder')"
                      class="min-w-0 flex-1 border-0 bg-transparent px-1 pe-4 py-3 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"
                      dir="ltr"
                      :aria-invalid="form.errors.phone ? 'true' : undefined"
                      :aria-describedby="
                        form.errors.phone ? 'phone-error' : undefined
                      "
                    />
                  </div>
                  <div
                    v-if="countryOpen"
                    id="country-options"
                    class="absolute z-30 mt-2 w-full overflow-hidden rounded-sm border border-neutral-200 bg-paper/95 shadow-lg backdrop-blur"
                  >
                    <label
                      class="flex h-12 items-center gap-2 border-b border-neutral-200 px-3"
                    >
                      <Search
                        class="size-5 shrink-0 text-neutral-600"
                        :stroke-width="1.5"
                        aria-hidden="true"
                      />
                      <span class="sr-only">{{
                        t("forms.contact.country_search")
                      }}</span>
                      <input
                        v-model="countrySearch"
                        type="search"
                        :placeholder="t('forms.contact.country_search')"
                        class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"
                        autofocus
                      />
                    </label>
                    <div class="max-h-[min(24rem,50vh)] overflow-y-auto overscroll-contain">
                      <button
                        v-for="country in filteredCountries"
                        :key="country.id"
                        type="button"
                        class="flex h-12 w-full items-center gap-2 border-b border-neutral-200 px-3 text-body-md last:border-b-0 hover:bg-neutral-50"
                        @click="chooseCountry(country)"
                      >
                        <span class="text-lg" aria-hidden="true">{{
                          country.flag
                        }}</span>
                        <span>{{ country.name }} ({{ country.code }})</span>
                      </button>
                      <p
                        v-if="filteredCountries.length === 0"
                        class="px-3 py-4 text-body-md text-neutral-500"
                      >
                        {{ t("forms.contact.country_empty") }}
                      </p>
                    </div>
                  </div>
                  <p
                    v-if="form.errors.phone"
                    id="phone-error"
                    role="alert"
                    class="mt-1 text-[10px] leading-none text-[#c94a4a]"
                  >
                    {{ form.errors.phone }}
                  </p>
                </div>

                <div
                  v-if="services.length > 0"
                  ref="servicesPicker"
                  class="relative min-w-0"
                >
                  <label
                    for="services"
                    class="mb-2 block text-label-lg text-neutral-800"
                    >{{ t("forms.contact.services") }}</label
                  >
                  <button
                    id="services"
                    type="button"
                    class="relative flex h-12 w-full items-center rounded-sm border bg-paper/80 text-start transition-colors hover:border-neutral-200 focus:border-ink"
                    :class="
                      form.errors.service_ids
                        ? '!border-[#c94a4a] !bg-[#fdf5f5]'
                        : 'border-gold-300'
                    "
                    :aria-expanded="servicesOpen"
                    aria-controls="service-options"
                    @click="servicesOpen = !servicesOpen"
                  >
                    <Layers3
                      class="pointer-events-none ms-4 size-6 shrink-0 text-neutral-600"
                      :stroke-width="1.5"
                      aria-hidden="true"
                    />
                    <span
                      class="min-w-0 flex-1 truncate px-2 pe-10 text-body-md"
                      :class="
                        form.service_ids.length
                          ? 'text-neutral-900'
                          : 'text-neutral-500'
                      "
                    >
                      {{ selectedServicesLabel }}
                    </span>
                    <ChevronDown
                      class="pointer-events-none absolute end-4 size-5 text-neutral-700 transition-transform"
                      :class="servicesOpen ? 'rotate-180' : ''"
                      :stroke-width="1.5"
                      aria-hidden="true"
                    />
                  </button>
                  <div
                    v-if="servicesOpen"
                    id="service-options"
                    class="absolute z-30 mt-2 w-full overflow-hidden rounded-sm border border-neutral-200 bg-paper/95 shadow-lg backdrop-blur"
                  >
                    <label
                      v-for="service in services"
                      :key="service.id"
                      class="flex h-12 cursor-pointer items-center justify-between gap-3 border-b border-neutral-200 px-3 text-body-md last:border-b-0 hover:bg-neutral-50"
                    >
                      <span>{{ service.title }}</span>
                      <input
                        type="checkbox"
                        class="peer sr-only"
                        :checked="form.service_ids.includes(service.id)"
                        @change="toggleService(service.id)"
                      />
                      <span
                        class="flex size-5 shrink-0 items-center justify-center rounded-[4px] border-[1.5px] border-neutral-400 peer-checked:border-neutral-700"
                      >
                        <Check
                          v-if="form.service_ids.includes(service.id)"
                          class="size-4 text-neutral-700"
                          :stroke-width="2"
                          aria-hidden="true"
                        />
                      </span>
                    </label>
                  </div>
                  <p
                    v-if="form.errors.service_ids"
                    role="alert"
                    class="mt-1 text-[10px] leading-none text-[#c94a4a]"
                  >
                    {{ form.errors.service_ids }}
                  </p>
                </div>
              </div>

              <div class="flex min-h-0 flex-1 flex-col">
                <label
                  for="message"
                  class="mb-2 block text-label-lg text-neutral-800"
                  >{{ t("forms.contact.message") }}</label
                >
                <textarea
                  id="message"
                  v-model="form.message"
                  rows="4"
                  :placeholder="t('forms.contact.message_placeholder')"
                  class="min-h-[80px] w-full flex-1 resize-none rounded-sm border bg-paper/80 p-3 text-body-md shadow-none transition-colors placeholder:text-neutral-500 hover:border-neutral-200 focus:border-ink focus:ring-0"
                  :class="
                    form.errors.message
                      ? '!border-[#c94a4a] !bg-[#fdf5f5]'
                      : 'border-gold-300'
                  "
                  :aria-invalid="form.errors.message ? 'true' : undefined"
                  :aria-describedby="
                    form.errors.message ? 'message-error' : undefined
                  "
                />
                <!-- message is validated (max:5000) but had no error outlet, so an over-long message failed silently. -->
                <p
                  v-if="form.errors.message"
                  id="message-error"
                  role="alert"
                  class="mt-1 text-[10px] leading-none text-[#c94a4a]"
                >
                  {{ form.errors.message }}
                </p>
              </div>

              <button
                type="submit"
                :disabled="form.processing"
                class="inline-flex w-full items-center justify-center gap-1 rounded-sm bg-ink px-6 py-3 text-body-lg text-paper transition-opacity hover:opacity-90 disabled:opacity-50 md:px-8 md:py-4 md:text-title-md"
              >
                {{
                  form.processing
                    ? t("common.sending")
                    : t("forms.contact.submit")
                }}
              </button>
            </form>
          </div>

          <!-- Details + socials column — Figma 1288:4130 -->
          <div
            class="mx-5 flex flex-col justify-between gap-14 lg:mx-0 lg:h-[724px] lg:w-[423px] lg:gap-16"
          >
            <!-- Contact details panel — Figma 466:1216 -->
            <div
              class="flex flex-col gap-8 rounded-lg bg-white/10 p-6 backdrop-blur-[7.5px] lg:h-[467px] lg:justify-center lg:gap-10 lg:bg-white/30 lg:p-8"
            >
              <h2 class="text-title-sm font-medium text-neutral-900">
                {{ t("forms.details.title") }}
              </h2>

              <ul class="flex flex-col gap-4 lg:gap-6">
                <li
                  v-for="(row, i) in details"
                  :key="row.label"
                  class="flex items-center gap-4"
                  :class="
                    i < details.length - 1
                      ? 'border-b border-neutral-200 pb-4 lg:pb-6'
                      : ''
                  "
                >
                  <span
                    class="flex size-12 shrink-0 items-center justify-center rounded-round"
                  >
                    <component
                      :is="row.icon"
                      class="size-6 text-neutral-700"
                      :stroke-width="1.5"
                      aria-hidden="true"
                    />
                  </span>

                  <span class="flex min-w-0 flex-col gap-1">
                    <span class="text-label-lg text-neutral-900">{{
                      row.label
                    }}</span>
                    <a
                      v-if="row.href"
                      :href="row.href"
                      class="truncate text-body-md text-neutral-700 hover:text-gold"
                    >
                      {{ row.value }}
                    </a>
                    <span v-else class="text-body-md text-neutral-700">{{
                      row.value
                    }}</span>
                  </span>
                </li>
              </ul>
            </div>

            <!-- Follow block — Figma 1288:4129 -->
            <div
              v-if="socialLinks.length > 0"
              class="flex flex-col gap-6 lg:gap-10"
            >
              <p
                class="text-label-lg font-medium text-neutral-800 lg:text-body-lg"
              >
                {{ t("forms.details.follow") }}
              </p>

              <ul class="flex items-center justify-between gap-4">
                <li v-for="link in socialLinks" :key="link.platform">
                  <a
                    :href="link.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    :aria-label="link.label"
                    class="flex size-12 items-center justify-center text-neutral-700 transition-colors hover:text-gold lg:size-10"
                  >
                    <SocialIcon :icon="link.icon" class="size-6" />
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
