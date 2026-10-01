import { defineComponent, unref, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderAttr, ssrInterpolate, ssrRenderList, ssrRenderClass } from "vue/server-renderer";
import { C as CtaBanner } from "./CtaBanner-Cb3ia_15.js";
import { _ as _sfc_main$1 } from "./SeoHead-DbuqnLLJ.js";
import "../ssr.js";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "@vue/server-renderer";
import "qs-esm";
import "lucide-vue-next";
import "@vueuse/core";
import "gsap";
import "gsap/CustomEase";
import "gsap/ScrollTrigger";
const arcRingsL = "/build/assets/arc-rings-service-l-DKi-nr9N.svg";
const arcRingsR = "/build/assets/arc-rings-service-r-B_-z7jxo.svg";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Services",
  __ssrInlineRender: true,
  props: {
    heading: {},
    services: {},
    sections: {},
    seo: {}
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, { meta: __props.seo }, null, _parent));
      _push(`<section class="relative overflow-hidden pt-[160px] md:pt-[184px]"><div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true"><div class="relative mx-auto h-full w-full max-w-frame"><img${ssrRenderAttr("src", unref(arcRingsR))} alt="" width="1597" height="1814" class="absolute -top-[93px] start-[667px] w-[1597px] max-w-none"></div></div><div class="container-sahra relative flex flex-col gap-[72px] lg:gap-[200px]"><div class="flex h-[184px] max-w-[612px] flex-col gap-6 md:h-auto md:gap-12"><p class="eyebrow">${ssrInterpolate(__props.heading.eyebrow)}</p><div class="flex flex-col gap-6"><h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">${ssrInterpolate(__props.heading.title)}</h1><p class="text-[16px] leading-normal text-neutral-700 md:text-title-sm md:font-medium">${ssrInterpolate(__props.heading.description)}</p></div></div><div class="relative flex flex-col gap-24 lg:gap-[224px]"><div class="pointer-events-none absolute inset-x-0 top-1/2 -z-10 hidden -translate-y-1/2 lg:block" aria-hidden="true"><img${ssrRenderAttr("src", unref(arcRingsL))} alt="" width="1924" height="2186" loading="lazy" class="absolute -top-[1093px] -start-[647px] w-[1924px] max-w-none"></div><!--[-->`);
      ssrRenderList(__props.services, (service, i) => {
        _push(`<article class="${ssrRenderClass([[
          i % 2 === 1 ? "lg:flex-row-reverse" : "",
          i < 2 ? "max-lg:h-[628px]" : "max-lg:h-[612px]"
        ], "flex flex-col gap-10 lg:h-auto lg:flex-row lg:items-start lg:justify-between lg:gap-[137px]"])}"><div class="order-2 flex flex-col gap-6 lg:order-none lg:max-w-[507px] lg:gap-10 lg:py-12"><h2 class="text-[24px] font-semibold leading-normal text-neutral-900 md:text-display-md">${ssrInterpolate(service.title)}</h2><div class="flex flex-col gap-6 lg:gap-12"><p class="text-[16px] leading-normal text-neutral-800 md:text-title-md">${ssrInterpolate(service.description)}</p>`);
        if (service.features.length > 0) {
          _push(`<ul class="flex flex-col gap-4"><!--[-->`);
          ssrRenderList(service.features, (feature, fi) => {
            _push(`<li class="ms-6 list-disc text-[16px] font-medium leading-normal text-neutral-800 md:ms-[27px] md:text-title-sm">${ssrInterpolate(feature)}</li>`);
          });
          _push(`<!--]--></ul>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div>`);
        if (service.image) {
          _push(`<img${ssrRenderAttr("src", service.image.src)}${ssrRenderAttr("srcset", service.image.srcset)}${ssrRenderAttr("alt", service.image.alt)} class="order-1 h-[272px] w-full rounded-sm object-cover lg:order-none lg:h-auto lg:aspect-[604/786] lg:w-[604px] lg:shrink-0">`);
        } else {
          _push(`<div class="order-1 h-[272px] w-full rounded-sm bg-neutral-100 lg:order-none lg:h-auto lg:aspect-[604/786] lg:w-[604px] lg:shrink-0"></div>`);
        }
        _push(`</article>`);
      });
      _push(`<!--]--></div></div></section>`);
      if (__props.sections.final_cta) {
        _push(ssrRenderComponent(CtaBanner, {
          section: __props.sections.final_cta,
          "spacing-class": "pb-[176px] pt-[176px]"
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`<!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Services.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
