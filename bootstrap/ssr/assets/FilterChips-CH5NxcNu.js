import { defineComponent, mergeProps, unref, withCtx, createTextVNode, toDisplayString, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderComponent, ssrInterpolate, ssrRenderList } from "vue/server-renderer";
import { u as useTranslations, l as link_default } from "../ssr.js";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "FilterChips",
  __ssrInlineRender: true,
  props: {
    items: {},
    active: {},
    paramName: {},
    basePath: {},
    extraParams: {},
    direction: { default: "column" }
  },
  setup(__props) {
    const props = __props;
    const { t } = useTranslations();
    function hrefFor(slug) {
      const params = new URLSearchParams();
      for (const [key, value] of Object.entries(props.extraParams ?? {})) {
        if (value) params.set(key, value);
      }
      if (slug) params.set(props.paramName, slug);
      const query = params.toString();
      return query ? `${props.basePath}?${query}` : props.basePath;
    }
    function classesFor(slug) {
      return props.active === slug ? "text-[16px] font-medium text-neutral-1000 md:text-[18px] md:font-normal" : "text-[14px] font-medium text-neutral-500 hover:text-neutral-800 md:text-[16px] md:font-normal";
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        role: "group",
        class: ["flex gap-4", __props.direction === "column" ? "mt-16 mb-12 items-center overflow-x-auto md:mt-0 md:mb-0 md:items-start lg:flex-col lg:overflow-visible" : "flex-wrap items-center gap-x-8"]
      }, _attrs))}>`);
      _push(ssrRenderComponent(unref(link_default), {
        href: hrefFor(null),
        class: [classesFor(null), "w-fit shrink-0 whitespace-nowrap rounded-xs transition-colors"],
        "aria-current": __props.active === null ? "true" : void 0
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(unref(t)("common.all"))}`);
          } else {
            return [
              createTextVNode(toDisplayString(unref(t)("common.all")), 1)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<!--[-->`);
      ssrRenderList(__props.items, (item) => {
        _push(ssrRenderComponent(unref(link_default), {
          key: item.slug,
          href: hrefFor(item.slug),
          class: [classesFor(item.slug), "w-fit shrink-0 whitespace-nowrap rounded-xs transition-colors"],
          "aria-current": __props.active === item.slug ? "true" : void 0
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`${ssrInterpolate(item.name)}`);
            } else {
              return [
                createTextVNode(toDisplayString(item.name), 1)
              ];
            }
          }),
          _: 2
        }, _parent));
      });
      _push(`<!--]--></div>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/FilterChips.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
