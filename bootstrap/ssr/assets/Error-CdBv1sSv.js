import { defineComponent, computed, unref, withCtx, createTextVNode, toDisplayString, createVNode, useSSRContext } from "vue";
import { ssrRenderComponent, ssrInterpolate } from "vue/server-renderer";
import { a as usePage, u as useTranslations, l as link_default } from "../ssr.js";
import { ArrowRight } from "lucide-vue-next";
import { _ as _sfc_main$1 } from "./SeoHead-DbuqnLLJ.js";
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
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Error",
  __ssrInlineRender: true,
  props: {
    status: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const { t } = useTranslations();
    const known = [403, 404, 429, 500, 503];
    const key = computed(() => known.includes(props.status) ? String(props.status) : "500");
    const title = computed(() => t(`errors.${key.value}.title`));
    const message = computed(() => t(`errors.${key.value}.message`));
    const currentLocale = computed(() => {
      var _a;
      return ((_a = page.props.locale) == null ? void 0 : _a.current) ?? "en";
    });
    const homeUrl = computed(() => `/${currentLocale.value}`);
    return (_ctx, _push, _parent, _attrs) => {
      var _a;
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, {
        meta: {
          title: title.value,
          description: message.value,
          image: null,
          canonical: ((_a = unref(page).props.alternates) == null ? void 0 : _a[currentLocale.value]) ?? null,
          type: "website",
          noindex: true
        }
      }, null, _parent));
      _push(`<section class="section section-first h-[874px] overflow-hidden md:h-[1024px]"><div class="container-sahra flex flex-col items-center text-center">`);
      if (__props.status === 404) {
        _push(`<img src="/images/sahra/404-horizon.png" alt="" width="560" height="560" class="w-full max-w-[560px]" aria-hidden="true">`);
      } else {
        _push(`<p class="latin-nums bg-gradient-to-br from-gold-400 to-gold bg-clip-text font-semibold leading-none text-transparent [font-size:clamp(5rem,20vw,10rem)]" aria-hidden="true">${ssrInterpolate(__props.status)}</p>`);
      }
      _push(`<div class="flex max-w-[506px] flex-col items-center gap-8 md:-mt-16"><div class="flex flex-col items-center gap-4"><h1 class="text-heading-xl font-medium">${ssrInterpolate(title.value)}</h1><p class="text-title-sm font-medium text-neutral-700">${ssrInterpolate(message.value)}</p></div>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: homeUrl.value,
        class: "inline-flex items-center gap-1 rounded-sm bg-ink px-8 py-4 text-title-lg text-paper transition-colors hover:bg-gold hover:text-white"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(unref(t)("errors.back_home"))} `);
            _push2(ssrRenderComponent(unref(ArrowRight), {
              class: "size-6 shrink-0 rtl:-scale-x-100",
              "aria-hidden": "true"
            }, null, _parent2, _scopeId));
          } else {
            return [
              createTextVNode(toDisplayString(unref(t)("errors.back_home")) + " ", 1),
              createVNode(unref(ArrowRight), {
                class: "size-6 shrink-0 rtl:-scale-x-100",
                "aria-hidden": "true"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div></section><!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Error.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
