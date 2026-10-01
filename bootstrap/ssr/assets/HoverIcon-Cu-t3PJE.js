import { defineComponent, mergeProps, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderAttr, ssrRenderClass } from "vue/server-renderer";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "HoverIcon",
  __ssrInlineRender: true,
  props: {
    name: {},
    hoverName: {}
  },
  setup(__props) {
    const props = __props;
    const isImage = (name) => Boolean(name && (name.startsWith("/") || /^https?:\/\//.test(name)));
    const baseName = () => props.name || props.hoverName;
    const hasBaseImage = () => isImage(baseName());
    const hasHoverImage = () => isImage(props.hoverName) && hasBaseImage();
    return (_ctx, _push, _parent, _attrs) => {
      if (hasBaseImage()) {
        _push(`<span${ssrRenderAttrs(mergeProps({
          class: "relative inline-flex size-[1em] shrink-0",
          "aria-hidden": "true"
        }, _attrs))}><img${ssrRenderAttr("src", baseName())} alt="" class="${ssrRenderClass([hasHoverImage() ? "transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0" : "", "size-full object-contain"])}">`);
        if (hasHoverImage()) {
          _push(`<img${ssrRenderAttr("src", props.hoverName)} alt="" class="absolute inset-0 size-full object-contain opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100">`);
        } else {
          _push(`<!---->`);
        }
        _push(`</span>`);
      } else {
        _push(`<!---->`);
      }
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/HoverIcon.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
