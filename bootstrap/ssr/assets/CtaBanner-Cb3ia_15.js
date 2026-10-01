import { defineComponent, ref, computed, mergeProps, unref, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderAttr, ssrRenderStyle, ssrInterpolate, ssrRenderComponent } from "vue/server-renderer";
import { a as usePage, h as useParallax, d as _sfc_main$1, _ as _export_sfc } from "../ssr.js";
import { ArrowRight } from "lucide-vue-next";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "CtaBanner",
  __ssrInlineRender: true,
  props: {
    spacingClass: {},
    section: {}
  },
  setup(__props) {
    const page = usePage();
    const glow = ref(null);
    useParallax(glow, 20);
    const horizonSrc = computed(
      () => page.props.locale.direction === "rtl" ? "/images/sahra/dark-gold-horizon-bg-rtl.png" : "/images/sahra/dark-gold-horizon-bg.png"
    );
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({
        dir: unref(page).props.locale.direction,
        class: __props.spacingClass || "pb-[176px] pt-[176px]"
      }, _attrs))} data-v-6e1fb9a2><div class="container-sahra" data-v-6e1fb9a2><div class="relative flex min-h-[359px] flex-col justify-center gap-2 overflow-hidden rounded-lg bg-ink p-6 md:min-h-[483px] md:p-14" data-v-6e1fb9a2><img${ssrRenderAttr("src", horizonSrc.value)} alt="" width="1672" height="941" class="pointer-events-none absolute inset-x-0 -top-[10%] h-[120%] w-full object-cover object-center" aria-hidden="true" decoding="async" data-v-6e1fb9a2><div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/75 via-black/40 to-black/10 rtl:bg-gradient-to-l" aria-hidden="true" data-v-6e1fb9a2></div><p class="relative z-10 font-display text-[16px] leading-6 text-gold md:text-[24px] md:leading-[26px]" style="${ssrRenderStyle({ color: __props.section.colors.eyebrow || void 0 })}" data-v-6e1fb9a2>${ssrInterpolate(__props.section.eyebrow)}</p><div class="relative z-10 flex flex-col gap-6 md:gap-10" data-v-6e1fb9a2><div class="flex flex-col gap-10 md:gap-12" data-v-6e1fb9a2><div class="flex flex-col gap-4 md:gap-6" data-v-6e1fb9a2><h2 class="text-[24px] font-semibold leading-normal text-paper md:text-display-md lg:max-w-[505px]" style="${ssrRenderStyle({ color: __props.section.colors.title || void 0 })}" data-v-6e1fb9a2>${ssrInterpolate(__props.section.title)}</h2><p class="text-body-md text-neutral-100 md:text-title-sm md:font-medium lg:max-w-[715px]" style="${ssrRenderStyle({ color: __props.section.colors.description || void 0 })}" data-v-6e1fb9a2>${ssrInterpolate(__props.section.description)}</p></div>`);
      if (__props.section.primaryCta) {
        _push(`<a${ssrRenderAttr("href", __props.section.primaryCta.url)} class="final-cta-button group inline-flex w-fit items-center gap-1 self-start rounded-sm bg-paper px-3 py-3 text-body-md text-ink transition-colors hover:bg-gold hover:text-white md:px-6 md:text-title-sm" data-v-6e1fb9a2>${ssrInterpolate(__props.section.primaryCta.label)} `);
        if (__props.section.primaryCta.icon || __props.section.primaryCta.hoverIcon) {
          _push(ssrRenderComponent(_sfc_main$1, {
            name: __props.section.primaryCta.icon,
            "hover-name": __props.section.primaryCta.hoverIcon,
            class: "size-5 md:size-6"
          }, null, _parent));
        } else {
          _push(ssrRenderComponent(unref(ArrowRight), {
            class: "hidden size-5 shrink-0 rtl:-scale-x-100 md:block md:size-6",
            "aria-hidden": "true"
          }, null, _parent));
        }
        _push(`</a>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.section.subtitle) {
        _push(`<p class="text-[12px] font-medium leading-normal text-neutral-300 md:text-title-sm md:text-neutral-100" style="${ssrRenderStyle({ color: __props.section.colors.subtitle || void 0 })}" data-v-6e1fb9a2>${ssrInterpolate(__props.section.subtitle)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div></div></section>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/CtaBanner.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const CtaBanner = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-6e1fb9a2"]]);
export {
  CtaBanner as C
};
