import { defineComponent, computed, unref, mergeProps, withCtx, createVNode, resolveDynamicComponent, createTextVNode, toDisplayString, openBlock, createBlock, createCommentVNode, Fragment, renderList, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderAttr, ssrRenderList, ssrRenderVNode, ssrInterpolate } from "vue/server-renderer";
import { a as usePage, i as head_default } from "../ssr.js";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "SeoHead",
  __ssrInlineRender: true,
  props: {
    meta: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const siteName = computed(() => {
      var _a;
      return ((_a = page.props.settings) == null ? void 0 : _a.siteName) ?? "Sahra";
    });
    const htmlLang = computed(() => {
      var _a;
      return ((_a = page.props.locale) == null ? void 0 : _a.htmlLang) ?? "en";
    });
    const title = computed(() => {
      var _a;
      return props.meta.title || ((_a = page.props.settings) == null ? void 0 : _a.seo.defaultTitle) || siteName.value;
    });
    const description = computed(
      () => {
        var _a;
        return props.meta.description || ((_a = page.props.settings) == null ? void 0 : _a.seo.defaultDescription) || "";
      }
    );
    const image = computed(() => {
      var _a;
      return props.meta.image ?? ((_a = page.props.settings) == null ? void 0 : _a.seo.defaultImage) ?? null;
    });
    const jsonLd = computed(() => (props.meta.jsonLd ?? []).map((graph) => JSON.stringify(graph)));
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(unref(head_default), mergeProps({ title: title.value }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<meta name="description"${ssrRenderAttr("content", description.value)}${_scopeId}>`);
            if (__props.meta.canonical) {
              _push2(`<link rel="canonical"${ssrRenderAttr("href", __props.meta.canonical)}${_scopeId}>`);
            } else {
              _push2(`<!---->`);
            }
            if (__props.meta.noindex) {
              _push2(`<meta name="robots" content="noindex, follow"${_scopeId}>`);
            } else {
              _push2(`<meta name="robots" content="index, follow, max-image-preview:large"${_scopeId}>`);
            }
            _push2(`<meta property="og:type"${ssrRenderAttr("content", __props.meta.type)}${_scopeId}><meta property="og:title"${ssrRenderAttr("content", title.value)}${_scopeId}><meta property="og:description"${ssrRenderAttr("content", description.value)}${_scopeId}>`);
            if (__props.meta.canonical) {
              _push2(`<meta property="og:url"${ssrRenderAttr("content", __props.meta.canonical)}${_scopeId}>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`<meta property="og:site_name"${ssrRenderAttr("content", siteName.value)}${_scopeId}><meta property="og:locale"${ssrRenderAttr("content", htmlLang.value.replace("-", "_"))}${_scopeId}>`);
            if (image.value) {
              _push2(`<meta property="og:image"${ssrRenderAttr("content", image.value)}${_scopeId}>`);
            } else {
              _push2(`<!---->`);
            }
            if (image.value) {
              _push2(`<meta property="og:image:alt"${ssrRenderAttr("content", title.value)}${_scopeId}>`);
            } else {
              _push2(`<!---->`);
            }
            if (__props.meta.type === "article") {
              _push2(`<!--[-->`);
              if (__props.meta.publishedAt) {
                _push2(`<meta property="article:published_time"${ssrRenderAttr("content", __props.meta.publishedAt)}${_scopeId}>`);
              } else {
                _push2(`<!---->`);
              }
              if (__props.meta.modifiedAt) {
                _push2(`<meta property="article:modified_time"${ssrRenderAttr("content", __props.meta.modifiedAt)}${_scopeId}>`);
              } else {
                _push2(`<!---->`);
              }
              if (__props.meta.author) {
                _push2(`<meta property="article:author"${ssrRenderAttr("content", __props.meta.author)}${_scopeId}>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`<!--]-->`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`<meta name="twitter:card"${ssrRenderAttr("content", image.value ? "summary_large_image" : "summary")}${_scopeId}><meta name="twitter:title"${ssrRenderAttr("content", title.value)}${_scopeId}><meta name="twitter:description"${ssrRenderAttr("content", description.value)}${_scopeId}>`);
            if (image.value) {
              _push2(`<meta name="twitter:image"${ssrRenderAttr("content", image.value)}${_scopeId}>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`<!--[-->`);
            ssrRenderList(jsonLd.value, (graph, index) => {
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent("script"), {
                key: index,
                type: "application/ld+json"
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`${ssrInterpolate(graph)}`);
                  } else {
                    return [
                      createTextVNode(toDisplayString(graph), 1)
                    ];
                  }
                }),
                _: 2
              }), _parent2, _scopeId);
            });
            _push2(`<!--]-->`);
          } else {
            return [
              createVNode("meta", {
                name: "description",
                content: description.value
              }, null, 8, ["content"]),
              __props.meta.canonical ? (openBlock(), createBlock("link", {
                key: 0,
                rel: "canonical",
                href: __props.meta.canonical
              }, null, 8, ["href"])) : createCommentVNode("", true),
              __props.meta.noindex ? (openBlock(), createBlock("meta", {
                key: 1,
                name: "robots",
                content: "noindex, follow"
              })) : (openBlock(), createBlock("meta", {
                key: 2,
                name: "robots",
                content: "index, follow, max-image-preview:large"
              })),
              createVNode("meta", {
                property: "og:type",
                content: __props.meta.type
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:title",
                content: title.value
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:description",
                content: description.value
              }, null, 8, ["content"]),
              __props.meta.canonical ? (openBlock(), createBlock("meta", {
                key: 3,
                property: "og:url",
                content: __props.meta.canonical
              }, null, 8, ["content"])) : createCommentVNode("", true),
              createVNode("meta", {
                property: "og:site_name",
                content: siteName.value
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:locale",
                content: htmlLang.value.replace("-", "_")
              }, null, 8, ["content"]),
              image.value ? (openBlock(), createBlock("meta", {
                key: 4,
                property: "og:image",
                content: image.value
              }, null, 8, ["content"])) : createCommentVNode("", true),
              image.value ? (openBlock(), createBlock("meta", {
                key: 5,
                property: "og:image:alt",
                content: title.value
              }, null, 8, ["content"])) : createCommentVNode("", true),
              __props.meta.type === "article" ? (openBlock(), createBlock(Fragment, { key: 6 }, [
                __props.meta.publishedAt ? (openBlock(), createBlock("meta", {
                  key: 0,
                  property: "article:published_time",
                  content: __props.meta.publishedAt
                }, null, 8, ["content"])) : createCommentVNode("", true),
                __props.meta.modifiedAt ? (openBlock(), createBlock("meta", {
                  key: 1,
                  property: "article:modified_time",
                  content: __props.meta.modifiedAt
                }, null, 8, ["content"])) : createCommentVNode("", true),
                __props.meta.author ? (openBlock(), createBlock("meta", {
                  key: 2,
                  property: "article:author",
                  content: __props.meta.author
                }, null, 8, ["content"])) : createCommentVNode("", true)
              ], 64)) : createCommentVNode("", true),
              createVNode("meta", {
                name: "twitter:card",
                content: image.value ? "summary_large_image" : "summary"
              }, null, 8, ["content"]),
              createVNode("meta", {
                name: "twitter:title",
                content: title.value
              }, null, 8, ["content"]),
              createVNode("meta", {
                name: "twitter:description",
                content: description.value
              }, null, 8, ["content"]),
              image.value ? (openBlock(), createBlock("meta", {
                key: 7,
                name: "twitter:image",
                content: image.value
              }, null, 8, ["content"])) : createCommentVNode("", true),
              (openBlock(true), createBlock(Fragment, null, renderList(jsonLd.value, (graph, index) => {
                return openBlock(), createBlock(resolveDynamicComponent("script"), {
                  key: index,
                  type: "application/ld+json"
                }, {
                  default: withCtx(() => [
                    createTextVNode(toDisplayString(graph), 1)
                  ]),
                  _: 2
                }, 1024);
              }), 128))
            ];
          }
        }),
        _: 1
      }, _parent));
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/SeoHead.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
