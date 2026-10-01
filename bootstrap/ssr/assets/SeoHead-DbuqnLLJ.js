import { defineComponent, computed, unref, mergeProps, withCtx, createVNode, resolveDynamicComponent, createTextVNode, toDisplayString, openBlock, createBlock, createCommentVNode, Fragment, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderAttr, ssrRenderVNode, ssrInterpolate } from "vue/server-renderer";
import { a as usePage, i as head_default } from "../ssr.js";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "SeoHead",
  __ssrInlineRender: true,
  props: {
    meta: {},
    breadcrumbs: { default: () => [] }
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const settings = computed(
      () => page.props.settings ?? {
        siteName: "Sahra",
        tagline: "",
        description: "",
        contact: { whatsapp: "", phone: "", email: "", location: "", workingWith: "" },
        socialLinks: [],
        seo: { defaultTitle: "Sahra", defaultDescription: "", defaultImage: null, organizationName: "Sahra" }
      }
    );
    const locale = computed(
      () => page.props.locale ?? {
        current: "en",
        direction: "ltr",
        font: "sans",
        htmlLang: "en",
        supported: []
      }
    );
    const title = computed(() => props.meta.title || settings.value.seo.defaultTitle);
    const description = computed(
      () => props.meta.description || settings.value.seo.defaultDescription
    );
    const image = computed(() => props.meta.image ?? settings.value.seo.defaultImage);
    const organizationLd = computed(
      () => JSON.stringify({
        "@context": "https://schema.org",
        "@type": "Organization",
        name: settings.value.seo.organizationName,
        url: props.meta.canonical,
        logo: image.value,
        email: settings.value.contact.email || void 0,
        telephone: settings.value.contact.phone || void 0,
        address: settings.value.contact.location ? { "@type": "PostalAddress", addressLocality: settings.value.contact.location } : void 0,
        sameAs: settings.value.socialLinks.map((l) => l.url)
      })
    );
    const articleLd = computed(() => {
      if (props.meta.type !== "article") return null;
      return JSON.stringify({
        "@context": "https://schema.org",
        "@type": "Article",
        headline: title.value,
        description: description.value,
        image: image.value ? [image.value] : void 0,
        datePublished: props.meta.publishedAt ?? void 0,
        dateModified: props.meta.modifiedAt ?? props.meta.publishedAt ?? void 0,
        author: props.meta.author ? { "@type": "Person", name: props.meta.author } : { "@type": "Organization", name: settings.value.seo.organizationName },
        publisher: {
          "@type": "Organization",
          name: settings.value.seo.organizationName,
          logo: { "@type": "ImageObject", url: image.value }
        },
        mainEntityOfPage: { "@type": "WebPage", "@id": props.meta.canonical },
        inLanguage: locale.value.htmlLang
      });
    });
    const breadcrumbLd = computed(() => {
      if (props.breadcrumbs.length === 0) return null;
      return JSON.stringify({
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        itemListElement: props.breadcrumbs.map((crumb, index) => ({
          "@type": "ListItem",
          position: index + 1,
          name: crumb.name,
          item: crumb.url
        }))
      });
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(unref(head_default), mergeProps({ title: title.value }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<meta name="description"${ssrRenderAttr("content", description.value)}${_scopeId}><link rel="canonical"${ssrRenderAttr("href", __props.meta.canonical)}${_scopeId}>`);
            if (__props.meta.noindex) {
              _push2(`<meta name="robots" content="noindex, nofollow"${_scopeId}>`);
            } else {
              _push2(`<meta name="robots" content="index, follow, max-image-preview:large"${_scopeId}>`);
            }
            _push2(`<meta property="og:type"${ssrRenderAttr("content", __props.meta.type)}${_scopeId}><meta property="og:title"${ssrRenderAttr("content", title.value)}${_scopeId}><meta property="og:description"${ssrRenderAttr("content", description.value)}${_scopeId}><meta property="og:url"${ssrRenderAttr("content", __props.meta.canonical)}${_scopeId}><meta property="og:site_name"${ssrRenderAttr("content", settings.value.siteName)}${_scopeId}><meta property="og:locale"${ssrRenderAttr("content", locale.value.htmlLang.replace("-", "_"))}${_scopeId}>`);
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
            ssrRenderVNode(_push2, createVNode(resolveDynamicComponent("script"), { type: "application/ld+json" }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`${ssrInterpolate(organizationLd.value)}`);
                } else {
                  return [
                    createTextVNode(toDisplayString(organizationLd.value), 1)
                  ];
                }
              }),
              _: 1
            }), _parent2, _scopeId);
            if (articleLd.value) {
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent("script"), { type: "application/ld+json" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`${ssrInterpolate(articleLd.value)}`);
                  } else {
                    return [
                      createTextVNode(toDisplayString(articleLd.value), 1)
                    ];
                  }
                }),
                _: 1
              }), _parent2, _scopeId);
            } else {
              _push2(`<!---->`);
            }
            if (breadcrumbLd.value) {
              ssrRenderVNode(_push2, createVNode(resolveDynamicComponent("script"), { type: "application/ld+json" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`${ssrInterpolate(breadcrumbLd.value)}`);
                  } else {
                    return [
                      createTextVNode(toDisplayString(breadcrumbLd.value), 1)
                    ];
                  }
                }),
                _: 1
              }), _parent2, _scopeId);
            } else {
              _push2(`<!---->`);
            }
          } else {
            return [
              createVNode("meta", {
                name: "description",
                content: description.value
              }, null, 8, ["content"]),
              createVNode("link", {
                rel: "canonical",
                href: __props.meta.canonical
              }, null, 8, ["href"]),
              __props.meta.noindex ? (openBlock(), createBlock("meta", {
                key: 0,
                name: "robots",
                content: "noindex, nofollow"
              })) : (openBlock(), createBlock("meta", {
                key: 1,
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
              createVNode("meta", {
                property: "og:url",
                content: __props.meta.canonical
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:site_name",
                content: settings.value.siteName
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:locale",
                content: locale.value.htmlLang.replace("-", "_")
              }, null, 8, ["content"]),
              image.value ? (openBlock(), createBlock("meta", {
                key: 2,
                property: "og:image",
                content: image.value
              }, null, 8, ["content"])) : createCommentVNode("", true),
              image.value ? (openBlock(), createBlock("meta", {
                key: 3,
                property: "og:image:alt",
                content: title.value
              }, null, 8, ["content"])) : createCommentVNode("", true),
              __props.meta.type === "article" ? (openBlock(), createBlock(Fragment, { key: 4 }, [
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
                key: 5,
                name: "twitter:image",
                content: image.value
              }, null, 8, ["content"])) : createCommentVNode("", true),
              (openBlock(), createBlock(resolveDynamicComponent("script"), { type: "application/ld+json" }, {
                default: withCtx(() => [
                  createTextVNode(toDisplayString(organizationLd.value), 1)
                ]),
                _: 1
              })),
              articleLd.value ? (openBlock(), createBlock(resolveDynamicComponent("script"), {
                key: 6,
                type: "application/ld+json"
              }, {
                default: withCtx(() => [
                  createTextVNode(toDisplayString(articleLd.value), 1)
                ]),
                _: 1
              })) : createCommentVNode("", true),
              breadcrumbLd.value ? (openBlock(), createBlock(resolveDynamicComponent("script"), {
                key: 7,
                type: "application/ld+json"
              }, {
                default: withCtx(() => [
                  createTextVNode(toDisplayString(breadcrumbLd.value), 1)
                ]),
                _: 1
              })) : createCommentVNode("", true)
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
