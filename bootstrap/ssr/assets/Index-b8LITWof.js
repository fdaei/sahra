import { defineComponent, computed, ref, unref, withCtx, openBlock, createBlock, Fragment, renderList, createCommentVNode, createVNode, toDisplayString, createTextVNode, useSSRContext } from "vue";
import { ssrRenderComponent, ssrInterpolate, ssrRenderList, ssrRenderAttr, ssrRenderClass } from "vue/server-renderer";
import { a as usePage, u as useTranslations, l as link_default } from "../ssr.js";
import { CalendarDays, ArrowUpRight, ChevronDown } from "lucide-vue-next";
import { C as CtaBanner } from "./CtaBanner-Cb3ia_15.js";
import { _ as _sfc_main$2 } from "./FilterChips-CH5NxcNu.js";
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
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    heading: {},
    featured: {},
    posts: {},
    categories: {},
    filters: {},
    sections: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const { t } = useTranslations();
    const basePath = computed(() => `/${page.props.locale.current}/insights`);
    const leadRow = computed(() => props.posts.data.slice(0, 2));
    const restRows = computed(() => props.posts.data.slice(2));
    const visibleRestPosts = ref(2);
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, { meta: __props.seo }, null, _parent));
      _push(`<div class="container-sahra flex flex-col gap-16 pb-0 pt-[160px] md:gap-24 md:pb-32 md:pt-[192px]"><div class="flex flex-col gap-16 lg:flex-row lg:items-start lg:justify-between"><div class="flex h-[184px] max-w-[612px] flex-col gap-6 md:h-auto md:gap-12"><p class="eyebrow">${ssrInterpolate(__props.heading.eyebrow)}</p><div class="flex flex-col gap-6"><h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">${ssrInterpolate(__props.heading.title)}</h1><p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">${ssrInterpolate(__props.heading.description)}</p></div></div>`);
      if (__props.categories.length > 0) {
        _push(ssrRenderComponent(_sfc_main$2, {
          items: __props.categories,
          active: __props.filters.category,
          "param-name": "category",
          "base-path": basePath.value,
          "extra-params": { q: __props.filters.q },
          direction: "column"
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.featured) {
        _push(ssrRenderComponent(unref(link_default), {
          href: __props.featured.url,
          class: "group flex min-h-[521px] flex-col gap-6 rounded-sm bg-gold-50 p-2 md:min-h-0 md:gap-8 md:rounded-lg md:p-4 lg:flex-row lg:items-center"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              if (__props.featured.image) {
                _push2(`<picture${_scopeId}><!--[-->`);
                ssrRenderList(__props.featured.image.formats, (source, format) => {
                  _push2(`<source${ssrRenderAttr("type", `image/${format}`)}${ssrRenderAttr("srcset", source.srcset)}${ssrRenderAttr("sizes", __props.featured.image.sizes)}${_scopeId}>`);
                });
                _push2(`<!--]-->`);
                if (__props.featured.image) {
                  _push2(`<img${ssrRenderAttr("src", __props.featured.image.src)}${ssrRenderAttr("srcset", __props.featured.image.srcset)}${ssrRenderAttr("sizes", __props.featured.image.sizes)}${ssrRenderAttr("alt", __props.featured.image.alt)} loading="eager" fetchpriority="high" decoding="async" width="612" height="459" class="h-[248px] w-full shrink-0 rounded-sm border border-neutral-100 object-cover shadow-card md:aspect-[612/459] md:h-auto md:rounded-lg lg:w-[612px]"${_scopeId}>`);
                } else {
                  _push2(`<!---->`);
                }
                _push2(`</picture>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`<div class="flex flex-1 flex-col gap-4 md:gap-12"${_scopeId}>`);
              if (__props.featured.category) {
                _push2(`<span class="w-fit rounded-round bg-gold-600 px-2 py-1 text-[12px] leading-4 text-paper md:text-body-md"${_scopeId}>${ssrInterpolate(__props.featured.category.name)}</span>`);
              } else {
                _push2(`<!---->`);
              }
              _push2(`<div class="flex flex-col gap-4 md:gap-[72px]"${_scopeId}><div class="flex flex-col gap-6"${_scopeId}><h2 class="text-[18px] font-medium text-neutral-900 md:text-[32px]"${_scopeId}>${ssrInterpolate(__props.featured.title)}</h2><p class="line-clamp-3 text-[14px] leading-normal text-neutral-800 md:line-clamp-none md:text-body-lg"${_scopeId}>${ssrInterpolate(__props.featured.excerpt)}</p></div><div class="flex flex-wrap items-center justify-between gap-4"${_scopeId}><div class="flex items-center gap-4"${_scopeId}><time${ssrRenderAttr("datetime", __props.featured.publishedAtIso)} class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"${_scopeId}>`);
              _push2(ssrRenderComponent(unref(CalendarDays), {
                class: "size-4 text-gold md:size-6",
                "stroke-width": 1.5,
                "aria-hidden": "true"
              }, null, _parent2, _scopeId));
              _push2(` ${ssrInterpolate(__props.featured.publishedAt)}</time><span class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"${_scopeId}><span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"${_scopeId}></span> ${ssrInterpolate(unref(t)("blog.reading_time", { minutes: __props.featured.readingTime }))}</span></div><span class="flex items-center gap-2 text-[14px] font-medium text-neutral-900 md:text-body-lg"${_scopeId}>${ssrInterpolate(unref(t)("common.read_article"))} `);
              _push2(ssrRenderComponent(unref(ArrowUpRight), {
                class: "size-4 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1 rtl:-scale-x-100 rtl:group-hover:-translate-x-1 md:size-6",
                "stroke-width": 1.5,
                "aria-hidden": "true"
              }, null, _parent2, _scopeId));
              _push2(`</span></div></div></div>`);
            } else {
              return [
                __props.featured.image ? (openBlock(), createBlock("picture", { key: 0 }, [
                  (openBlock(true), createBlock(Fragment, null, renderList(__props.featured.image.formats, (source, format) => {
                    return openBlock(), createBlock("source", {
                      key: format,
                      type: `image/${format}`,
                      srcset: source.srcset,
                      sizes: __props.featured.image.sizes
                    }, null, 8, ["type", "srcset", "sizes"]);
                  }), 128)),
                  __props.featured.image ? (openBlock(), createBlock("img", {
                    key: 0,
                    src: __props.featured.image.src,
                    srcset: __props.featured.image.srcset,
                    sizes: __props.featured.image.sizes,
                    alt: __props.featured.image.alt,
                    loading: "eager",
                    fetchpriority: "high",
                    decoding: "async",
                    width: "612",
                    height: "459",
                    class: "h-[248px] w-full shrink-0 rounded-sm border border-neutral-100 object-cover shadow-card md:aspect-[612/459] md:h-auto md:rounded-lg lg:w-[612px]"
                  }, null, 8, ["src", "srcset", "sizes", "alt"])) : createCommentVNode("", true)
                ])) : createCommentVNode("", true),
                createVNode("div", { class: "flex flex-1 flex-col gap-4 md:gap-12" }, [
                  __props.featured.category ? (openBlock(), createBlock("span", {
                    key: 0,
                    class: "w-fit rounded-round bg-gold-600 px-2 py-1 text-[12px] leading-4 text-paper md:text-body-md"
                  }, toDisplayString(__props.featured.category.name), 1)) : createCommentVNode("", true),
                  createVNode("div", { class: "flex flex-col gap-4 md:gap-[72px]" }, [
                    createVNode("div", { class: "flex flex-col gap-6" }, [
                      createVNode("h2", { class: "text-[18px] font-medium text-neutral-900 md:text-[32px]" }, toDisplayString(__props.featured.title), 1),
                      createVNode("p", { class: "line-clamp-3 text-[14px] leading-normal text-neutral-800 md:line-clamp-none md:text-body-lg" }, toDisplayString(__props.featured.excerpt), 1)
                    ]),
                    createVNode("div", { class: "flex flex-wrap items-center justify-between gap-4" }, [
                      createVNode("div", { class: "flex items-center gap-4" }, [
                        createVNode("time", {
                          datetime: __props.featured.publishedAtIso,
                          class: "flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"
                        }, [
                          createVNode(unref(CalendarDays), {
                            class: "size-4 text-gold md:size-6",
                            "stroke-width": 1.5,
                            "aria-hidden": "true"
                          }),
                          createTextVNode(" " + toDisplayString(__props.featured.publishedAt), 1)
                        ], 8, ["datetime"]),
                        createVNode("span", { class: "flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md" }, [
                          createVNode("span", {
                            class: "inline-block size-1 rounded-full bg-gold",
                            "aria-hidden": "true"
                          }),
                          createTextVNode(" " + toDisplayString(unref(t)("blog.reading_time", { minutes: __props.featured.readingTime })), 1)
                        ])
                      ]),
                      createVNode("span", { class: "flex items-center gap-2 text-[14px] font-medium text-neutral-900 md:text-body-lg" }, [
                        createTextVNode(toDisplayString(unref(t)("common.read_article")) + " ", 1),
                        createVNode(unref(ArrowUpRight), {
                          class: "size-4 transition-transform group-hover:translate-x-1 group-hover:-translate-y-1 rtl:-scale-x-100 rtl:group-hover:-translate-x-1 md:size-6",
                          "stroke-width": 1.5,
                          "aria-hidden": "true"
                        })
                      ])
                    ])
                  ])
                ])
              ];
            }
          }),
          _: 1
        }, _parent));
      } else {
        _push(`<!---->`);
      }
      if (__props.posts.data.length === 0 && !__props.featured) {
        _push(`<p class="py-16 text-center text-body-lg text-neutral-500">${ssrInterpolate(unref(t)("common.empty_posts"))}</p>`);
      } else {
        _push(`<div class="flex flex-col gap-16 md:gap-24">`);
        if (leadRow.value.length > 0) {
          _push(`<ul class="grid gap-16 sm:grid-cols-2 sm:gap-6"><!--[-->`);
          ssrRenderList(leadRow.value, (post) => {
            _push(`<li>`);
            _push(ssrRenderComponent(unref(link_default), {
              href: post.url,
              class: "group flex min-h-[412.5px] flex-col gap-4 rounded-lg md:min-h-0"
            }, {
              default: withCtx((_, _push2, _parent2, _scopeId) => {
                if (_push2) {
                  if (post.image) {
                    _push2(`<picture${_scopeId}><!--[-->`);
                    ssrRenderList(post.image.formats, (source, format) => {
                      _push2(`<source${ssrRenderAttr("type", `image/${format}`)}${ssrRenderAttr("srcset", source.srcset)}${ssrRenderAttr("sizes", post.image.sizes)}${_scopeId}>`);
                    });
                    _push2(`<!--]-->`);
                    if (post.image) {
                      _push2(`<img${ssrRenderAttr("src", post.image.src)}${ssrRenderAttr("srcset", post.image.srcset)}${ssrRenderAttr("sizes", post.image.sizes)}${ssrRenderAttr("alt", post.image.alt)} loading="lazy" decoding="async" width="612" height="400" class="h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"${_scopeId}>`);
                    } else {
                      _push2(`<!---->`);
                    }
                    _push2(`</picture>`);
                  } else {
                    _push2(`<!---->`);
                  }
                  _push2(`<div class="flex flex-col gap-4"${_scopeId}><div class="flex items-center gap-4"${_scopeId}><time${ssrRenderAttr("datetime", post.publishedAtIso)} class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"${_scopeId}>`);
                  _push2(ssrRenderComponent(unref(CalendarDays), {
                    class: "size-4 text-gold md:size-6",
                    "stroke-width": 1.5,
                    "aria-hidden": "true"
                  }, null, _parent2, _scopeId));
                  _push2(` ${ssrInterpolate(post.publishedAt)}</time><span class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"${_scopeId}><span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"${_scopeId}></span> ${ssrInterpolate(unref(t)("blog.reading_time", { minutes: post.readingTime }))}</span></div><h3 class="text-[18px] font-medium text-neutral-900 md:text-[28px]"${_scopeId}>${ssrInterpolate(post.title)}</h3></div>`);
                } else {
                  return [
                    post.image ? (openBlock(), createBlock("picture", { key: 0 }, [
                      (openBlock(true), createBlock(Fragment, null, renderList(post.image.formats, (source, format) => {
                        return openBlock(), createBlock("source", {
                          key: format,
                          type: `image/${format}`,
                          srcset: source.srcset,
                          sizes: post.image.sizes
                        }, null, 8, ["type", "srcset", "sizes"]);
                      }), 128)),
                      post.image ? (openBlock(), createBlock("img", {
                        key: 0,
                        src: post.image.src,
                        srcset: post.image.srcset,
                        sizes: post.image.sizes,
                        alt: post.image.alt,
                        loading: "lazy",
                        decoding: "async",
                        width: "612",
                        height: "400",
                        class: "h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"
                      }, null, 8, ["src", "srcset", "sizes", "alt"])) : createCommentVNode("", true)
                    ])) : createCommentVNode("", true),
                    createVNode("div", { class: "flex flex-col gap-4" }, [
                      createVNode("div", { class: "flex items-center gap-4" }, [
                        createVNode("time", {
                          datetime: post.publishedAtIso,
                          class: "flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"
                        }, [
                          createVNode(unref(CalendarDays), {
                            class: "size-4 text-gold md:size-6",
                            "stroke-width": 1.5,
                            "aria-hidden": "true"
                          }),
                          createTextVNode(" " + toDisplayString(post.publishedAt), 1)
                        ], 8, ["datetime"]),
                        createVNode("span", { class: "flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md" }, [
                          createVNode("span", {
                            class: "inline-block size-1 rounded-full bg-gold",
                            "aria-hidden": "true"
                          }),
                          createTextVNode(" " + toDisplayString(unref(t)("blog.reading_time", { minutes: post.readingTime })), 1)
                        ])
                      ]),
                      createVNode("h3", { class: "text-[18px] font-medium text-neutral-900 md:text-[28px]" }, toDisplayString(post.title), 1)
                    ])
                  ];
                }
              }),
              _: 2
            }, _parent));
            _push(`</li>`);
          });
          _push(`<!--]--></ul>`);
        } else {
          _push(`<!---->`);
        }
        if (restRows.value.length > 0) {
          _push(`<ul class="grid gap-x-6 gap-y-16 sm:grid-cols-2 md:gap-y-24 lg:grid-cols-3"><!--[-->`);
          ssrRenderList(restRows.value, (post, postIndex) => {
            _push(`<li class="${ssrRenderClass(postIndex >= visibleRestPosts.value ? "max-sm:hidden" : "")}">`);
            _push(ssrRenderComponent(unref(link_default), {
              href: post.url,
              class: "group flex min-h-[412.5px] flex-col gap-4 rounded-lg md:min-h-0"
            }, {
              default: withCtx((_, _push2, _parent2, _scopeId) => {
                if (_push2) {
                  if (post.image) {
                    _push2(`<picture${_scopeId}><!--[-->`);
                    ssrRenderList(post.image.formats, (source, format) => {
                      _push2(`<source${ssrRenderAttr("type", `image/${format}`)}${ssrRenderAttr("srcset", source.srcset)}${ssrRenderAttr("sizes", post.image.sizes)}${_scopeId}>`);
                    });
                    _push2(`<!--]-->`);
                    if (post.image) {
                      _push2(`<img${ssrRenderAttr("src", post.image.src)}${ssrRenderAttr("srcset", post.image.srcset)}${ssrRenderAttr("sizes", post.image.sizes)}${ssrRenderAttr("alt", post.image.alt)} loading="lazy" decoding="async" width="400" height="400" class="h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"${_scopeId}>`);
                    } else {
                      _push2(`<!---->`);
                    }
                    _push2(`</picture>`);
                  } else {
                    _push2(`<!---->`);
                  }
                  _push2(`<div class="flex flex-col gap-4"${_scopeId}><div class="flex items-center gap-4"${_scopeId}><time${ssrRenderAttr("datetime", post.publishedAtIso)} class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"${_scopeId}>`);
                  _push2(ssrRenderComponent(unref(CalendarDays), {
                    class: "size-4 text-gold md:size-6",
                    "stroke-width": 1.5,
                    "aria-hidden": "true"
                  }, null, _parent2, _scopeId));
                  _push2(` ${ssrInterpolate(post.publishedAt)}</time><span class="flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"${_scopeId}><span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"${_scopeId}></span> ${ssrInterpolate(unref(t)("blog.reading_time", { minutes: post.readingTime }))}</span></div><h3 class="text-[18px] font-medium text-neutral-900 md:text-title-lg"${_scopeId}>${ssrInterpolate(post.title)}</h3></div>`);
                } else {
                  return [
                    post.image ? (openBlock(), createBlock("picture", { key: 0 }, [
                      (openBlock(true), createBlock(Fragment, null, renderList(post.image.formats, (source, format) => {
                        return openBlock(), createBlock("source", {
                          key: format,
                          type: `image/${format}`,
                          srcset: source.srcset,
                          sizes: post.image.sizes
                        }, null, 8, ["type", "srcset", "sizes"]);
                      }), 128)),
                      post.image ? (openBlock(), createBlock("img", {
                        key: 0,
                        src: post.image.src,
                        srcset: post.image.srcset,
                        sizes: post.image.sizes,
                        alt: post.image.alt,
                        loading: "lazy",
                        decoding: "async",
                        width: "400",
                        height: "400",
                        class: "h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px]"
                      }, null, 8, ["src", "srcset", "sizes", "alt"])) : createCommentVNode("", true)
                    ])) : createCommentVNode("", true),
                    createVNode("div", { class: "flex flex-col gap-4" }, [
                      createVNode("div", { class: "flex items-center gap-4" }, [
                        createVNode("time", {
                          datetime: post.publishedAtIso,
                          class: "flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md"
                        }, [
                          createVNode(unref(CalendarDays), {
                            class: "size-4 text-gold md:size-6",
                            "stroke-width": 1.5,
                            "aria-hidden": "true"
                          }),
                          createTextVNode(" " + toDisplayString(post.publishedAt), 1)
                        ], 8, ["datetime"]),
                        createVNode("span", { class: "flex items-center gap-2 text-[12px] text-neutral-500 md:text-body-md" }, [
                          createVNode("span", {
                            class: "inline-block size-1 rounded-full bg-gold",
                            "aria-hidden": "true"
                          }),
                          createTextVNode(" " + toDisplayString(unref(t)("blog.reading_time", { minutes: post.readingTime })), 1)
                        ])
                      ]),
                      createVNode("h3", { class: "text-[18px] font-medium text-neutral-900 md:text-title-lg" }, toDisplayString(post.title), 1)
                    ])
                  ];
                }
              }),
              _: 2
            }, _parent));
            _push(`</li>`);
          });
          _push(`<!--]--></ul>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div>`);
      }
      if (restRows.value.length > visibleRestPosts.value) {
        _push(`<button type="button" class="mx-auto inline-flex items-center gap-2 text-body-lg font-medium text-neutral-900 transition-colors hover:text-gold">${ssrInterpolate(unref(t)("common.more_insights"))} `);
        _push(ssrRenderComponent(unref(ChevronDown), {
          class: "size-6 shrink-0",
          "aria-hidden": "true"
        }, null, _parent));
        _push(`</button>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.posts.lastPage > 1) {
        _push(`<nav class="flex items-center justify-center gap-4"${ssrRenderAttr("aria-label", unref(t)("common.pagination"))}>`);
        if (__props.posts.prevPageUrl) {
          _push(ssrRenderComponent(unref(link_default), {
            href: __props.posts.prevPageUrl,
            class: "rounded-sm border border-neutral-200 px-6 py-3 text-label-lg text-neutral-800 transition-colors hover:border-ink"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(`${ssrInterpolate(unref(t)("common.previous"))}`);
              } else {
                return [
                  createTextVNode(toDisplayString(unref(t)("common.previous")), 1)
                ];
              }
            }),
            _: 1
          }, _parent));
        } else {
          _push(`<!---->`);
        }
        _push(`<span class="latin-nums text-body-md text-neutral-500">${ssrInterpolate(__props.posts.currentPage)} / ${ssrInterpolate(__props.posts.lastPage)}</span>`);
        if (__props.posts.nextPageUrl) {
          _push(ssrRenderComponent(unref(link_default), {
            href: __props.posts.nextPageUrl,
            class: "rounded-sm border border-neutral-200 px-6 py-3 text-label-lg text-neutral-800 transition-colors hover:border-ink"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(`${ssrInterpolate(unref(t)("common.next"))}`);
              } else {
                return [
                  createTextVNode(toDisplayString(unref(t)("common.next")), 1)
                ];
              }
            }),
            _: 1
          }, _parent));
        } else {
          _push(`<!---->`);
        }
        _push(`</nav>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Insights/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
