import { defineComponent, computed, ref, watch, unref, withCtx, createVNode, openBlock, createBlock, toDisplayString, createTextVNode, createCommentVNode, Fragment, renderList, useSSRContext } from "vue";
import { ssrRenderComponent, ssrInterpolate, ssrRenderList, ssrRenderClass, ssrRenderAttr } from "vue/server-renderer";
import { a as usePage, u as useTranslations, l as link_default } from "../ssr.js";
import { Building2, ChevronDown } from "lucide-vue-next";
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
const PAGE_SIZE = 6;
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    heading: {},
    projects: {},
    filters: {},
    activeFilter: {},
    sections: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const { t } = useTranslations();
    const basePath = computed(() => `/${page.props.locale.current}/work`);
    const shown = ref(PAGE_SIZE);
    const showMobileOverflow = ref(false);
    const visibleProjects = computed(() => props.projects.slice(0, shown.value));
    const hasMore = computed(() => props.projects.length > shown.value);
    watch(() => props.activeFilter, () => {
      shown.value = PAGE_SIZE;
      showMobileOverflow.value = false;
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, { meta: __props.seo }, null, _parent));
      _push(`<div class="container-sahra flex flex-col gap-12 pb-0 pt-[160px] md:pb-32 md:pt-[184px] lg:gap-[120px]"><div class="flex flex-col gap-16 lg:flex-row lg:items-center lg:justify-between lg:gap-10"><div class="flex h-[184px] max-w-[611px] flex-col gap-6 md:h-auto md:gap-12"><p class="eyebrow">${ssrInterpolate(__props.heading.eyebrow)}</p><div class="flex flex-col gap-6"><h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">${ssrInterpolate(__props.heading.title)}</h1><p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">${ssrInterpolate(__props.heading.description)}</p></div></div>`);
      if (__props.filters.length > 0) {
        _push(ssrRenderComponent(_sfc_main$2, {
          items: __props.filters,
          active: __props.activeFilter,
          "param-name": "service",
          "base-path": basePath.value,
          direction: "column"
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="flex flex-col items-center gap-16 md:gap-24">`);
      if (__props.projects.length === 0) {
        _push(`<p class="py-16 text-center text-body-lg text-neutral-500">${ssrInterpolate(unref(t)("common.empty_projects"))}</p>`);
      } else {
        _push(`<ul class="grid w-full gap-x-6 gap-y-16 sm:grid-cols-2 md:gap-y-24"><!--[-->`);
        ssrRenderList(visibleProjects.value, (project, projectIndex) => {
          _push(`<li class="${ssrRenderClass([
            !showMobileOverflow.value && projectIndex >= 4 ? "max-sm:hidden" : "",
            "max-sm:h-[490px] max-sm:overflow-hidden"
          ])}">`);
          _push(ssrRenderComponent(unref(link_default), {
            href: project.url,
            class: "group flex flex-col gap-4 rounded-md md:gap-10"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(`<div class="overflow-hidden rounded-md border border-neutral-100 shadow-card"${_scopeId}>`);
                if (project.image) {
                  _push2(`<img${ssrRenderAttr("src", project.image.src)}${ssrRenderAttr("srcset", project.image.srcset)}${ssrRenderAttr("alt", project.image.alt)} width="612" height="612" class="aspect-square w-full object-cover transition-transform duration-500 ease-brand group-hover:scale-[1.06]"${_scopeId}>`);
                } else {
                  _push2(`<div class="aspect-square w-full bg-neutral-100"${_scopeId}></div>`);
                }
                _push2(`</div><div class="flex flex-col gap-6"${_scopeId}><div class="flex flex-col gap-4"${_scopeId}><div class="flex items-center justify-between gap-4"${_scopeId}><h2 class="text-[22px] font-semibold text-neutral-900 md:text-[36px]"${_scopeId}>${ssrInterpolate(project.title)}</h2>`);
                if (project.industry) {
                  _push2(`<span class="flex items-center gap-2 text-[12px] font-medium text-neutral-500 md:text-label-lg"${_scopeId}>`);
                  _push2(ssrRenderComponent(unref(Building2), {
                    class: "size-4 shrink-0 text-gold md:size-6",
                    "stroke-width": 1.5,
                    "aria-hidden": "true"
                  }, null, _parent2, _scopeId));
                  _push2(` ${ssrInterpolate(project.industry)}</span>`);
                } else {
                  _push2(`<!---->`);
                }
                _push2(`</div><p class="text-body-md text-neutral-700 md:text-body-lg"${_scopeId}>${ssrInterpolate(project.excerpt)}</p></div>`);
                if (project.services.length > 0) {
                  _push2(`<ul class="flex max-h-0 flex-wrap items-center gap-2 overflow-hidden opacity-0 transition-[max-height,opacity] duration-500 ease-brand group-hover:max-h-16 group-hover:opacity-100 group-focus-visible:max-h-16 group-focus-visible:opacity-100"${_scopeId}><!--[-->`);
                  ssrRenderList(project.services, (service, i) => {
                    _push2(`<li class="flex items-center gap-2 text-body-md text-neutral-500"${_scopeId}>`);
                    if (i > 0) {
                      _push2(`<span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true"${_scopeId}></span>`);
                    } else {
                      _push2(`<!---->`);
                    }
                    _push2(` ${ssrInterpolate(service)}</li>`);
                  });
                  _push2(`<!--]--></ul>`);
                } else {
                  _push2(`<!---->`);
                }
                _push2(`</div>`);
              } else {
                return [
                  createVNode("div", { class: "overflow-hidden rounded-md border border-neutral-100 shadow-card" }, [
                    project.image ? (openBlock(), createBlock("img", {
                      key: 0,
                      src: project.image.src,
                      srcset: project.image.srcset,
                      alt: project.image.alt,
                      width: "612",
                      height: "612",
                      class: "aspect-square w-full object-cover transition-transform duration-500 ease-brand group-hover:scale-[1.06]"
                    }, null, 8, ["src", "srcset", "alt"])) : (openBlock(), createBlock("div", {
                      key: 1,
                      class: "aspect-square w-full bg-neutral-100"
                    }))
                  ]),
                  createVNode("div", { class: "flex flex-col gap-6" }, [
                    createVNode("div", { class: "flex flex-col gap-4" }, [
                      createVNode("div", { class: "flex items-center justify-between gap-4" }, [
                        createVNode("h2", { class: "text-[22px] font-semibold text-neutral-900 md:text-[36px]" }, toDisplayString(project.title), 1),
                        project.industry ? (openBlock(), createBlock("span", {
                          key: 0,
                          class: "flex items-center gap-2 text-[12px] font-medium text-neutral-500 md:text-label-lg"
                        }, [
                          createVNode(unref(Building2), {
                            class: "size-4 shrink-0 text-gold md:size-6",
                            "stroke-width": 1.5,
                            "aria-hidden": "true"
                          }),
                          createTextVNode(" " + toDisplayString(project.industry), 1)
                        ])) : createCommentVNode("", true)
                      ]),
                      createVNode("p", { class: "text-body-md text-neutral-700 md:text-body-lg" }, toDisplayString(project.excerpt), 1)
                    ]),
                    project.services.length > 0 ? (openBlock(), createBlock("ul", {
                      key: 0,
                      class: "flex max-h-0 flex-wrap items-center gap-2 overflow-hidden opacity-0 transition-[max-height,opacity] duration-500 ease-brand group-hover:max-h-16 group-hover:opacity-100 group-focus-visible:max-h-16 group-focus-visible:opacity-100"
                    }, [
                      (openBlock(true), createBlock(Fragment, null, renderList(project.services, (service, i) => {
                        return openBlock(), createBlock("li", {
                          key: service,
                          class: "flex items-center gap-2 text-body-md text-neutral-500"
                        }, [
                          i > 0 ? (openBlock(), createBlock("span", {
                            key: 0,
                            class: "inline-block size-1 rounded-full bg-gold",
                            "aria-hidden": "true"
                          })) : createCommentVNode("", true),
                          createTextVNode(" " + toDisplayString(service), 1)
                        ]);
                      }), 128))
                    ])) : createCommentVNode("", true)
                  ])
                ];
              }
            }),
            _: 2
          }, _parent));
          _push(`</li>`);
        });
        _push(`<!--]--></ul>`);
      }
      if (hasMore.value || !showMobileOverflow.value && __props.projects.length > 4) {
        _push(`<button type="button" class="inline-flex items-center gap-1 text-body-md font-medium text-neutral-900 md:gap-2 md:text-body-lg transition-colors hover:text-gold">${ssrInterpolate(unref(t)("common.more_works"))} `);
        _push(ssrRenderComponent(unref(ChevronDown), {
          class: "size-4 shrink-0 md:size-6",
          "aria-hidden": "true"
        }, null, _parent));
        _push(`</button>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div>`);
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Work/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
