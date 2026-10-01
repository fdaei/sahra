import { defineComponent, computed, mergeProps, createVNode, resolveDynamicComponent, useSSRContext, ref, watch, nextTick, onMounted, onBeforeUnmount, unref } from "vue";
import { ssrRenderAttrs, ssrRenderAttr, ssrRenderVNode, ssrRenderComponent, ssrInterpolate, ssrRenderClass, ssrRenderList, ssrIncludeBooleanAttr, ssrRenderTeleport } from "vue/server-renderer";
import { u as useTranslations, a as usePage, b as useForm } from "../ssr.js";
import { getCountryDataList } from "countries-list";
import { Facebook, Youtube, Twitter, MessageCircle, Linkedin, Instagram, Link2, MapPin, Mail, Building2, UserRound, BadgeCheck, ChevronDown, Search, Layers3, Check, X, ArrowUpRight } from "lucide-vue-next";
import { _ as _sfc_main$2 } from "./SeoHead-DbuqnLLJ.js";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "@vue/server-renderer";
import "qs-esm";
import "@vueuse/core";
import "gsap";
import "gsap/CustomEase";
import "gsap/ScrollTrigger";
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "SocialIcon",
  __ssrInlineRender: true,
  props: {
    icon: {},
    hoverIcon: {}
  },
  setup(__props) {
    const props = __props;
    const icons = {
      instagram: Instagram,
      linkedin: Linkedin,
      "message-circle": MessageCircle,
      whatsapp: MessageCircle,
      twitter: Twitter,
      x: Twitter,
      youtube: Youtube,
      facebook: Facebook
    };
    const component = computed(() => icons[props.icon] ?? Link2);
    const isImage = computed(() => props.icon.startsWith("/") || /^https?:\/\//.test(props.icon));
    const hoverComponent = computed(
      () => props.hoverIcon && !props.hoverIcon.startsWith("/") && !/^https?:\/\//.test(props.hoverIcon) ? icons[props.hoverIcon] ?? Link2 : null
    );
    const isHoverImage = computed(
      () => Boolean(props.hoverIcon && (props.hoverIcon.startsWith("/") || /^https?:\/\//.test(props.hoverIcon)))
    );
    const hasHover = computed(() => Boolean(props.hoverIcon && (isHoverImage.value || hoverComponent.value)));
    return (_ctx, _push, _parent, _attrs) => {
      if (hasHover.value) {
        _push(`<span${ssrRenderAttrs(mergeProps({
          class: "relative inline-flex size-[1em] shrink-0",
          "aria-hidden": "true"
        }, _attrs))}>`);
        if (isImage.value) {
          _push(`<img${ssrRenderAttr("src", props.icon)} alt="" class="size-full object-contain transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0">`);
        } else {
          ssrRenderVNode(_push, createVNode(resolveDynamicComponent(component.value), { class: "size-full transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0" }, null), _parent);
        }
        if (isHoverImage.value) {
          _push(`<img${ssrRenderAttr("src", props.hoverIcon)} alt="" class="absolute inset-0 size-full object-contain opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100">`);
        } else {
          ssrRenderVNode(_push, createVNode(resolveDynamicComponent(hoverComponent.value), { class: "absolute inset-0 size-full opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100" }, null), _parent);
        }
        _push(`</span>`);
      } else if (isImage.value) {
        _push(`<img${ssrRenderAttrs(mergeProps({
          src: props.icon,
          alt: "",
          "aria-hidden": "true"
        }, _attrs))}>`);
      } else {
        ssrRenderVNode(_push, createVNode(resolveDynamicComponent(component.value), mergeProps({ "aria-hidden": "true" }, _attrs), null), _parent);
      }
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/SocialIcon.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Contact",
  __ssrInlineRender: true,
  props: {
    sections: {},
    heading: {},
    services: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const { t } = useTranslations();
    const page = usePage();
    const details = computed(() => {
      const c = page.props.settings.contact;
      return [
        {
          icon: MessageCircle,
          label: t("forms.details.whatsapp"),
          value: c.whatsapp,
          href: `https://wa.me/${c.whatsapp.replace(/\D/g, "")}`
        },
        {
          icon: MapPin,
          label: t("forms.details.location"),
          value: c.location,
          href: null
        },
        {
          icon: Mail,
          label: t("forms.details.email"),
          value: c.email,
          href: `mailto:${c.email}`
        },
        {
          icon: Building2,
          label: t("forms.details.working_with"),
          value: c.workingWith,
          href: null
        }
      ].filter((row) => row.value);
    });
    const socialLinks = computed(() => page.props.settings.socialLinks);
    const form = useForm({
      name: "",
      brand_name: "",
      phone: "",
      email: "",
      message: "",
      service_ids: [],
      website: "",
      form_started_at: 0
    });
    const countries = computed(() => {
      const locale = page.props.locale.current;
      const displayNames = new Intl.DisplayNames([locale], { type: "region" });
      return getCountryDataList().flatMap(
        (country) => country.phone.map((phone) => ({
          id: `${country.iso2}-${phone}`,
          code: `+${phone}`,
          flagClass: `fi fi-${country.iso2.toLowerCase()}`,
          name: displayNames.of(country.iso2) || country.name,
          iso2: country.iso2
        }))
      ).sort((a, b) => {
        if (a.iso2 === "OM") return -1;
        if (b.iso2 === "OM") return 1;
        return a.name.localeCompare(b.name, locale);
      });
    });
    const selectedCountry = ref(countries.value[0]);
    const countrySearch = ref("");
    const countryOpen = ref(false);
    const serviceSearch = ref("");
    const servicesOpen = ref(false);
    const countryPicker = ref(null);
    const servicesPicker = ref(null);
    const successDialog = ref(null);
    const successOpen = ref(false);
    watch(
      () => page.props.flash.success,
      (message) => {
        if (!message) return;
        successOpen.value = true;
        document.body.style.overflow = "hidden";
        nextTick(() => {
          var _a;
          return (_a = successDialog.value) == null ? void 0 : _a.focus();
        });
      },
      { immediate: true }
    );
    const filteredCountries = computed(() => {
      const query = countrySearch.value.trim().toLocaleLowerCase();
      if (!query) return countries.value;
      return countries.value.filter(
        ({ name, code }) => `${name} ${code}`.toLocaleLowerCase().includes(query)
      );
    });
    const selectedServicesLabel = computed(() => {
      const selected = props.services.filter(({ id }) => form.service_ids.includes(id)).map(({ title }) => title);
      return selected.length ? selected.join(", ") : t("forms.contact.services_placeholder");
    });
    const filteredServices = computed(() => {
      const query = serviceSearch.value.trim().toLocaleLowerCase();
      if (!query) return props.services;
      return props.services.filter(
        ({ title }) => title.toLocaleLowerCase().includes(query)
      );
    });
    function closePopovers(event) {
      var _a, _b;
      const target = event.target;
      if (!((_a = countryPicker.value) == null ? void 0 : _a.contains(target))) countryOpen.value = false;
      if (!((_b = servicesPicker.value) == null ? void 0 : _b.contains(target))) {
        servicesOpen.value = false;
        serviceSearch.value = "";
      }
    }
    onMounted(() => {
      form.form_started_at = Date.now();
      document.addEventListener("click", closePopovers);
    });
    onBeforeUnmount(() => {
      document.removeEventListener("click", closePopovers);
      document.body.style.overflow = "";
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$2, { meta: __props.seo }, null, _parent));
      _push(`<section class="section min-h-[1945px] pb-32 pt-[136px] md:min-h-0 md:pb-[204px] md:pt-[184px]"><div class="container-sahra max-md:px-0"><div class="relative overflow-visible rounded-lg bg-neutral-100 lg:min-h-[854px] lg:pe-6"><img src="/images/sahra/contact-bg.png" alt="" width="1487" height="1058" class="pointer-events-none absolute inset-0 size-full rounded-lg object-cover object-center opacity-60" aria-hidden="true" decoding="async"><div class="relative z-10 flex min-h-[854px] flex-col items-stretch gap-16 lg:flex-row lg:items-center lg:gap-9"><div class="flex flex-col gap-8 rounded-lg bg-white/10 p-6 backdrop-blur-[10px] md:p-12 lg:h-[854px] lg:w-[765px]"><div class="flex flex-col gap-6 md:gap-12"><p class="eyebrow text-[16px] before:!size-[6px] md:text-[24px] md:before:!size-[11.31px]">${ssrInterpolate(__props.heading.eyebrow)}</p><div class="flex flex-col gap-4 md:gap-6"><h1 class="text-[26px] font-semibold md:max-w-[620px] md:text-display-md">${ssrInterpolate(__props.heading.title)}</h1><p class="max-w-[520px] text-body-lg font-normal leading-relaxed text-neutral-700 md:text-title-sm md:font-medium">${ssrInterpolate(__props.heading.description)}</p></div></div><form class="flex min-h-0 flex-1 flex-col gap-6" novalidate><div class="hidden" aria-hidden="true"><label for="website">Website</label><input id="website"${ssrRenderAttr("value", unref(form).website)} type="text" name="website" tabindex="-1" autocomplete="off"></div><div class="grid grid-cols-1 gap-6 sm:grid-cols-2"><div><label for="name" class="mb-2 block text-label-lg text-neutral-800">${ssrInterpolate(unref(t)("forms.contact.name"))}</label><div class="${ssrRenderClass([
        unref(form).errors.name ? "!border-[#c94a4a] !bg-[#fdf5f5]" : "border-gold-300",
        "flex items-center gap-2 rounded-sm border bg-paper/80 p-3 transition-colors hover:border-neutral-200 focus-within:border-ink"
      ])}">`);
      _push(ssrRenderComponent(unref(UserRound), {
        class: "size-6 shrink-0 text-neutral-600",
        "stroke-width": 1.5,
        "aria-hidden": "true"
      }, null, _parent));
      _push(`<input id="name"${ssrRenderAttr("value", unref(form).name)} type="text"${ssrRenderAttr("placeholder", unref(t)("forms.contact.name_placeholder"))} class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"${ssrRenderAttr("aria-invalid", unref(form).errors.name ? "true" : void 0)}${ssrRenderAttr(
        "aria-describedby",
        unref(form).errors.name ? "name-error" : void 0
      )}></div>`);
      if (unref(form).errors.name) {
        _push(`<p id="name-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">${ssrInterpolate(unref(form).errors.name)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div><label for="brand" class="mb-2 block text-label-lg text-neutral-800">${ssrInterpolate(unref(t)("forms.contact.brand"))}</label><div class="${ssrRenderClass([
        unref(form).errors.brand_name ? "!border-[#c94a4a] !bg-[#fdf5f5]" : "border-gold-300",
        "flex items-center gap-2 rounded-sm border bg-paper/80 p-3 transition-colors hover:border-neutral-200 focus-within:border-ink"
      ])}">`);
      _push(ssrRenderComponent(unref(BadgeCheck), {
        class: "size-6 shrink-0 text-neutral-600",
        "stroke-width": 1.5,
        "aria-hidden": "true"
      }, null, _parent));
      _push(`<input id="brand"${ssrRenderAttr("value", unref(form).brand_name)} type="text"${ssrRenderAttr("placeholder", unref(t)("forms.contact.brand_placeholder"))} class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0"${ssrRenderAttr(
        "aria-invalid",
        unref(form).errors.brand_name ? "true" : void 0
      )}${ssrRenderAttr(
        "aria-describedby",
        unref(form).errors.brand_name ? "brand-error" : void 0
      )}></div>`);
      if (unref(form).errors.brand_name) {
        _push(`<p id="brand-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">${ssrInterpolate(unref(form).errors.brand_name)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div><div class="grid grid-cols-1 gap-6 sm:grid-cols-2"><div class="relative min-w-0"><label for="phone" class="mb-2 block text-label-lg text-neutral-800">${ssrInterpolate(unref(t)("forms.contact.phone"))}</label><div dir="ltr" class="${ssrRenderClass([
        unref(form).errors.phone ? "!border-[#c94a4a] !bg-[#fdf5f5]" : "border-gold-300",
        "flex h-12 overflow-hidden rounded-sm border bg-paper/80 transition-colors hover:border-neutral-200 focus-within:border-ink"
      ])}"><button type="button" class="flex items-center gap-2 border-e border-inherit px-3 text-body-md"${ssrRenderAttr("aria-expanded", countryOpen.value)} aria-controls="country-options"><span class="${ssrRenderClass([selectedCountry.value.flagClass, "shrink-0 overflow-hidden rounded-[2px] text-lg"])}" aria-hidden="true"></span>`);
      _push(ssrRenderComponent(unref(ChevronDown), {
        class: ["size-4 text-neutral-700 transition-transform", countryOpen.value ? "rotate-180" : ""],
        "stroke-width": 1.5,
        "aria-hidden": "true"
      }, null, _parent));
      _push(`</button><span class="flex items-center ps-3 text-body-md text-neutral-500" dir="ltr">${ssrInterpolate(selectedCountry.value.code)}</span><input id="phone"${ssrRenderAttr("value", unref(form).phone)} type="tel"${ssrRenderAttr("placeholder", unref(t)("forms.contact.phone_placeholder"))} class="min-w-0 flex-1 border-0 bg-transparent px-1 pe-4 py-3 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0" dir="ltr"${ssrRenderAttr("aria-invalid", unref(form).errors.phone ? "true" : void 0)}${ssrRenderAttr(
        "aria-describedby",
        unref(form).errors.phone ? "phone-error" : void 0
      )}></div>`);
      if (countryOpen.value) {
        _push(`<div id="country-options" class="absolute z-30 mt-2 w-full overflow-hidden rounded-sm border border-neutral-200 bg-paper/95 shadow-lg backdrop-blur"><label class="flex h-12 items-center gap-2 border-b border-neutral-200 px-3">`);
        _push(ssrRenderComponent(unref(Search), {
          class: "size-5 shrink-0 text-neutral-600",
          "stroke-width": 1.5,
          "aria-hidden": "true"
        }, null, _parent));
        _push(`<span class="sr-only">${ssrInterpolate(unref(t)("forms.contact.country_search"))}</span><input${ssrRenderAttr("value", countrySearch.value)} type="search"${ssrRenderAttr("placeholder", unref(t)("forms.contact.country_search"))} class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0" autofocus></label><div class="max-h-[min(24rem,50vh)] overflow-y-auto overscroll-contain"><!--[-->`);
        ssrRenderList(filteredCountries.value, (country) => {
          _push(`<button type="button" class="flex h-12 w-full items-center gap-2 border-b border-neutral-200 px-3 text-body-md last:border-b-0 hover:bg-neutral-50"><span class="${ssrRenderClass([country.flagClass, "shrink-0 overflow-hidden rounded-[2px] text-lg"])}" aria-hidden="true"></span><span>${ssrInterpolate(country.name)} (${ssrInterpolate(country.code)})</span></button>`);
        });
        _push(`<!--]-->`);
        if (filteredCountries.value.length === 0) {
          _push(`<p class="px-3 py-4 text-body-md text-neutral-500">${ssrInterpolate(unref(t)("forms.contact.country_empty"))}</p>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div>`);
      } else {
        _push(`<!---->`);
      }
      if (unref(form).errors.phone) {
        _push(`<p id="phone-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">${ssrInterpolate(unref(form).errors.phone)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.services.length > 0) {
        _push(`<div class="relative min-w-0"><label for="services" class="mb-2 block text-label-lg text-neutral-800">${ssrInterpolate(unref(t)("forms.contact.services"))}</label><button id="services" type="button" class="${ssrRenderClass([
          unref(form).errors.service_ids ? "!border-[#c94a4a] !bg-[#fdf5f5]" : "border-gold-300",
          "relative flex h-12 w-full items-center rounded-sm border bg-paper/80 text-start transition-colors hover:border-neutral-200 focus:border-ink"
        ])}"${ssrRenderAttr("aria-expanded", servicesOpen.value)} aria-controls="service-options">`);
        _push(ssrRenderComponent(unref(Layers3), {
          class: "pointer-events-none ms-4 size-6 shrink-0 text-neutral-600",
          "stroke-width": 1.5,
          "aria-hidden": "true"
        }, null, _parent));
        _push(`<span class="${ssrRenderClass([
          unref(form).service_ids.length ? "text-neutral-900" : "text-neutral-500",
          "min-w-0 flex-1 truncate px-2 pe-10 text-body-md"
        ])}">${ssrInterpolate(selectedServicesLabel.value)}</span>`);
        _push(ssrRenderComponent(unref(ChevronDown), {
          class: ["pointer-events-none absolute end-4 size-5 text-neutral-700 transition-transform", servicesOpen.value ? "rotate-180" : ""],
          "stroke-width": 1.5,
          "aria-hidden": "true"
        }, null, _parent));
        _push(`</button>`);
        if (servicesOpen.value) {
          _push(`<div id="service-options" class="absolute z-30 mt-2 w-full overflow-hidden rounded-sm border border-neutral-200 bg-paper/95 shadow-lg backdrop-blur"><label for="service-search" class="flex h-12 items-center gap-2 border-b border-neutral-200 px-3">`);
          _push(ssrRenderComponent(unref(Search), {
            class: "size-5 shrink-0 text-neutral-600",
            "stroke-width": 1.5,
            "aria-hidden": "true"
          }, null, _parent));
          _push(`<span class="sr-only">${ssrInterpolate(unref(t)("forms.contact.service_search"))}</span><input id="service-search"${ssrRenderAttr("value", serviceSearch.value)} type="search"${ssrRenderAttr("placeholder", unref(t)("forms.contact.service_search"))} class="min-w-0 flex-1 border-0 bg-transparent p-0 text-body-md shadow-none placeholder:text-neutral-500 focus:ring-0" autofocus></label><div class="max-h-[min(24rem,50vh)] overflow-y-auto overscroll-contain"><!--[-->`);
          ssrRenderList(filteredServices.value, (service) => {
            _push(`<label class="flex h-12 cursor-pointer items-center justify-between gap-3 border-b border-neutral-200 px-3 text-body-md last:border-b-0 hover:bg-neutral-50"><span>${ssrInterpolate(service.title)}</span><input type="checkbox" class="peer sr-only"${ssrIncludeBooleanAttr(unref(form).service_ids.includes(service.id)) ? " checked" : ""}><span class="flex size-5 shrink-0 items-center justify-center rounded-[4px] border-[1.5px] border-neutral-400 peer-checked:border-neutral-700">`);
            if (unref(form).service_ids.includes(service.id)) {
              _push(ssrRenderComponent(unref(Check), {
                class: "size-4 text-neutral-700",
                "stroke-width": 2,
                "aria-hidden": "true"
              }, null, _parent));
            } else {
              _push(`<!---->`);
            }
            _push(`</span></label>`);
          });
          _push(`<!--]-->`);
          if (filteredServices.value.length === 0) {
            _push(`<p class="px-3 py-4 text-body-md text-neutral-500">${ssrInterpolate(unref(t)("forms.contact.service_empty"))}</p>`);
          } else {
            _push(`<!---->`);
          }
          _push(`</div></div>`);
        } else {
          _push(`<!---->`);
        }
        if (unref(form).errors.service_ids) {
          _push(`<p role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">${ssrInterpolate(unref(form).errors.service_ids)}</p>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="flex min-h-0 flex-1 flex-col"><label for="message" class="mb-2 block text-label-lg text-neutral-800">${ssrInterpolate(unref(t)("forms.contact.message"))}</label><textarea id="message" rows="2"${ssrRenderAttr("placeholder", unref(t)("forms.contact.message_placeholder"))} class="${ssrRenderClass([
        unref(form).errors.message ? "!border-[#c94a4a] !bg-[#fdf5f5]" : "border-gold-300",
        "h-20 min-h-0 w-full resize-none rounded-sm border bg-paper/80 p-3 text-body-md shadow-none transition-colors placeholder:text-neutral-500 hover:border-neutral-200 focus:border-ink focus:ring-0"
      ])}"${ssrRenderAttr("aria-invalid", unref(form).errors.message ? "true" : void 0)}${ssrRenderAttr(
        "aria-describedby",
        unref(form).errors.message ? "message-error" : void 0
      )}>${ssrInterpolate(unref(form).message)}</textarea>`);
      if (unref(form).errors.message) {
        _push(`<p id="message-error" role="alert" class="mt-1 text-[10px] leading-none text-[#c94a4a]">${ssrInterpolate(unref(form).errors.message)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><button type="submit"${ssrIncludeBooleanAttr(unref(form).processing) ? " disabled" : ""} class="inline-flex w-full items-center justify-center gap-1 rounded-sm bg-ink px-6 py-3 text-body-lg text-paper transition-colors hover:bg-gold hover:text-white disabled:opacity-50 md:px-8 md:py-4 md:text-title-md">${ssrInterpolate(unref(form).processing ? unref(t)("common.sending") : unref(t)("forms.contact.submit"))}</button></form></div><div class="mx-5 flex flex-col justify-between gap-14 lg:mx-0 lg:h-[724px] lg:w-[423px] lg:gap-16"><div class="flex flex-col gap-8 rounded-lg bg-white/10 p-6 backdrop-blur-[7.5px] lg:h-[467px] lg:justify-center lg:gap-10 lg:bg-white/30 lg:p-8"><h2 class="text-title-sm font-medium text-neutral-900">${ssrInterpolate(unref(t)("forms.details.title"))}</h2><ul class="flex flex-col gap-4 lg:gap-6"><!--[-->`);
      ssrRenderList(details.value, (row, i) => {
        _push(`<li class="${ssrRenderClass([
          i < details.value.length - 1 ? "border-b border-neutral-200 pb-4 lg:pb-6" : "",
          "flex items-center gap-4"
        ])}"><span class="flex size-12 shrink-0 items-center justify-center rounded-round">`);
        ssrRenderVNode(_push, createVNode(resolveDynamicComponent(row.icon), {
          class: "size-6 text-neutral-700",
          "stroke-width": 1.5,
          "aria-hidden": "true"
        }, null), _parent);
        _push(`</span><span class="flex min-w-0 flex-col gap-1"><span class="text-label-lg text-neutral-900">${ssrInterpolate(row.label)}</span>`);
        if (row.href) {
          _push(`<a${ssrRenderAttr("href", row.href)} class="truncate text-body-md text-neutral-700 hover:text-gold">${ssrInterpolate(row.value)}</a>`);
        } else {
          _push(`<span class="text-body-md text-neutral-700">${ssrInterpolate(row.value)}</span>`);
        }
        _push(`</span></li>`);
      });
      _push(`<!--]--></ul></div>`);
      if (socialLinks.value.length > 0) {
        _push(`<div class="flex flex-col gap-6 lg:gap-10"><p class="text-label-lg font-medium text-neutral-800 lg:text-body-lg">${ssrInterpolate(unref(t)("forms.details.follow"))}</p><ul class="flex items-center justify-between gap-4"><!--[-->`);
        ssrRenderList(socialLinks.value, (link) => {
          _push(`<li><a${ssrRenderAttr("href", link.url)} target="_blank" rel="noopener noreferrer"${ssrRenderAttr("aria-label", link.label)} class="group flex size-12 items-center justify-center text-neutral-700 transition-colors hover:text-gold lg:size-10">`);
          _push(ssrRenderComponent(_sfc_main$1, {
            icon: link.icon,
            "hover-icon": link.hoverIcon,
            class: "size-6"
          }, null, _parent));
          _push(`</a></li>`);
        });
        _push(`<!--]--></ul></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div></div></div></section>`);
      ssrRenderTeleport(_push, (_push2) => {
        if (successOpen.value) {
          _push2(`<div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 p-5 backdrop-blur-[5px]" role="presentation"><div class="relative flex max-h-[calc(100vh-40px)] w-full max-w-[706px] flex-col items-center overflow-y-auto rounded-lg bg-white p-6 outline-none md:p-12" role="dialog" aria-modal="true" aria-labelledby="contact-success-title" tabindex="-1"><button type="button" class="absolute end-4 top-4 rounded-full p-2 text-neutral-700 transition-colors hover:bg-neutral-100"${ssrRenderAttr("aria-label", unref(t)("forms.newsletter.close"))}>`);
          _push2(ssrRenderComponent(unref(X), {
            class: "size-5",
            "aria-hidden": "true"
          }, null, _parent));
          _push2(`</button><img src="/images/sahra/checklist-success.svg" alt="" width="96" height="94" class="mb-12 size-24 object-contain" aria-hidden="true"><h2 id="contact-success-title" class="max-w-[520px] text-center text-[24px] font-medium leading-normal text-neutral-900">${ssrInterpolate(unref(page).props.flash.success)}</h2><a${ssrRenderAttr("href", `/${unref(page).props.locale.current}/contact`)} class="mt-8 inline-flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-white">${ssrInterpolate(unref(t)("forms.newsletter.consultation"))} `);
          _push2(ssrRenderComponent(unref(ArrowUpRight), {
            class: "size-6 rtl:-scale-x-100",
            "aria-hidden": "true"
          }, null, _parent));
          _push2(`</a></div></div>`);
        } else {
          _push2(`<!---->`);
        }
      }, "body", false, _parent);
      _push(`<!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Contact.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
