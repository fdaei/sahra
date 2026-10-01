import { defineComponent, computed, ref, unref, createVNode, resolveDynamicComponent, withCtx, openBlock, createBlock, createCommentVNode, createTextVNode, toDisplayString, useSSRContext } from "vue";
import { ssrRenderComponent, ssrInterpolate, ssrRenderList, ssrRenderVNode, ssrRenderAttr } from "vue/server-renderer";
import { a as usePage, u as useTranslations, l as link_default, _ as _export_sfc } from "../ssr.js";
import { CalendarDays, PenLine, Tag, Check, Link2, Linkedin } from "lucide-vue-next";
import { _ as _sfc_main$1 } from "./SeoHead-DbuqnLLJ.js";
import { C as CtaBanner } from "./CtaBanner-Cb3ia_15.js";
import { _ as _sfc_main$2 } from "./LeadMagnet-DYdv05Sc.js";
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
const leadMagnetMarker = "[[lead_magnet]]";
const leadMagnetSentinel = "\0LEAD_MAGNET\0";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Show",
  __ssrInlineRender: true,
  props: {
    post: {},
    leadMagnet: {},
    finalCta: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const { t } = useTranslations();
    const meta = computed(
      () => {
        var _a, _b;
        return [
          {
            icon: CalendarDays,
            label: t("blog.date"),
            value: props.post.publishedAt
          },
          {
            icon: PenLine,
            label: t("blog.written_by"),
            value: ((_a = props.post.author) == null ? void 0 : _a.name) ?? ""
          },
          {
            icon: Tag,
            label: t("blog.subject"),
            value: ((_b = props.post.category) == null ? void 0 : _b.name) ?? ""
          }
        ].filter((row) => row.value);
      }
    );
    const articleParts = computed(() => {
      const html = props.post.content;
      if (!props.leadMagnet) return [{ type: "html", html }];
      if (html.includes(leadMagnetMarker)) {
        const markedHtml = html.replace(
          /<(?:p|div)>\s*\[\[lead_magnet\]\]\s*<\/(?:p|div)>/gi,
          leadMagnetSentinel
        ).replace(/\[\[lead_magnet\]\]/gi, leadMagnetSentinel);
        return markedHtml.split(leadMagnetSentinel).flatMap((part, index, parts) => {
          const entries = [];
          if (part.trim()) entries.push({ type: "html", html: part });
          if (index < parts.length - 1) entries.push({ type: "leadMagnet" });
          return entries;
        });
      }
      if (html.length < 1200) return [{ type: "html", html }];
      const headings = [...html.matchAll(/<h[23][\s>]/gi)].map((m) => m.index ?? 0);
      const cut = headings.find((i) => i > html.length / 2);
      if (cut === void 0) return [{ type: "html", html }];
      return [
        { type: "html", html: html.slice(0, cut) },
        { type: "leadMagnet" },
        { type: "html", html: html.slice(cut) }
      ];
    });
    const copied = ref(false);
    const shareUrl = computed(() => props.seo.canonical);
    const xShare = computed(
      () => `https://x.com/intent/tweet?url=${encodeURIComponent(shareUrl.value)}&text=${encodeURIComponent(props.post.title)}`
    );
    const linkedInShare = computed(
      () => `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl.value)}`
    );
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, {
        meta: __props.seo,
        breadcrumbs: [
          {
            name: unref(t)("blog.related"),
            url: `/${unref(page).props.locale.current}/insights`
          },
          { name: __props.post.title, url: __props.seo.canonical }
        ]
      }, null, _parent));
      _push(`<div class="container-sahra flex flex-col gap-0 pb-0 pt-[160px] md:gap-24 md:pb-32 md:pt-[184px]" data-v-450829b0><div class="flex flex-col gap-11 md:gap-16" data-v-450829b0><div class="flex flex-col gap-[38px] lg:flex-row lg:items-start lg:justify-between lg:gap-10" data-v-450829b0><div class="flex min-h-[181px] max-w-[612px] flex-col gap-6 md:min-h-0" data-v-450829b0><h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-[40px]" data-v-450829b0>${ssrInterpolate(__props.post.title)}</h1>`);
      if (__props.post.subtitle) {
        _push(`<p class="text-[16px] font-normal leading-normal text-neutral-700 md:text-[18px] md:font-medium" data-v-450829b0>${ssrInterpolate(__props.post.subtitle)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (meta.value.length > 0) {
        _push(`<dl class="grid min-h-[106px] w-full max-w-[346px] shrink-0 grid-cols-2 grid-rows-2 gap-x-[92px] gap-y-[26px] md:flex md:min-h-0 md:w-auto md:flex-col md:gap-6" data-v-450829b0><!--[-->`);
        ssrRenderList(meta.value, (row) => {
          _push(`<div class="flex flex-col gap-1" data-v-450829b0><dt class="flex items-center gap-2" data-v-450829b0>`);
          ssrRenderVNode(_push, createVNode(resolveDynamicComponent(row.icon), {
            class: "size-5 shrink-0 text-gold",
            "stroke-width": 1.5,
            "aria-hidden": "true"
          }, null), _parent);
          _push(`<span class="text-label-lg text-neutral-1000" data-v-450829b0>${ssrInterpolate(row.label)}</span></dt><dd class="text-body-md text-neutral-800" data-v-450829b0>${ssrInterpolate(row.value)}</dd></div>`);
        });
        _push(`<!--]--></dl>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.post.image) {
        _push(`<img${ssrRenderAttr("src", __props.post.image.src)}${ssrRenderAttr("srcset", __props.post.image.srcset)}${ssrRenderAttr("alt", __props.post.image.alt)} width="1248" height="624" class="h-[272px] w-full rounded-lg border border-neutral-100 object-cover shadow-card md:h-auto md:aspect-[1248/624]" data-v-450829b0>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="mt-[35px] flex min-h-[85px] flex-col gap-4 max-md:sticky max-md:top-24 max-md:z-20 max-md:bg-paper max-md:pb-3 md:hidden" data-v-450829b0><p class="text-[14px] font-medium leading-[21px] text-neutral-900" data-v-450829b0>${ssrInterpolate(unref(t)("blog.share"))}</p><div class="flex gap-4" data-v-450829b0><button type="button" class="share-button size-12"${ssrRenderAttr("aria-label", copied.value ? unref(t)("blog.link_copied") : unref(t)("blog.copy_link"))} data-v-450829b0>`);
      ssrRenderVNode(_push, createVNode(resolveDynamicComponent(copied.value ? unref(Check) : unref(Link2)), {
        class: "size-5",
        "aria-hidden": "true"
      }, null), _parent);
      _push(`</button><a${ssrRenderAttr("href", xShare.value)} target="_blank" rel="noopener noreferrer" class="share-button size-12" aria-label="X" data-v-450829b0><span class="text-[18px] font-medium" data-v-450829b0>X</span></a><a${ssrRenderAttr("href", linkedInShare.value)} target="_blank" rel="noopener noreferrer" class="share-button size-12" aria-label="LinkedIn" data-v-450829b0>`);
      _push(ssrRenderComponent(unref(Linkedin), {
        class: "size-5",
        "stroke-width": 1.5,
        "aria-hidden": "true"
      }, null, _parent));
      _push(`</a></div></div><div class="mt-6 flex justify-center gap-10 md:mt-0" data-v-450829b0><div class="hidden w-[119px] shrink-0 lg:block" aria-hidden="true" data-v-450829b0></div><div class="flex w-full max-w-[826px] flex-col gap-10 md:gap-18" data-v-450829b0><!--[-->`);
      ssrRenderList(articleParts.value, (part, index) => {
        _push(`<!--[-->`);
        if (part.type === "html") {
          _push(`<article class="prose prose-neutral max-w-none max-md:[&amp;_h3]:mb-6 max-md:[&amp;_h3]:mt-10 max-md:[&amp;_h3]:text-[20px] max-md:[&amp;_h3]:font-medium max-md:[&amp;_h3]:leading-[30px] max-md:[&amp;_h3:first-child]:mt-0 max-md:[&amp;_h3:first-child]:leading-[33px] max-md:[&amp;_p]:m-0 max-md:[&amp;_p]:text-[14px] max-md:[&amp;_p]:leading-[21px] prose-headings:font-medium prose-a:text-gold prose-a:no-underline hover:prose-a:underline" data-v-450829b0>${part.html ?? ""}</article>`);
        } else if (__props.leadMagnet) {
          _push(ssrRenderComponent(_sfc_main$2, {
            class: "max-md:hidden",
            section: __props.leadMagnet,
            inline: ""
          }, null, _parent));
        } else {
          _push(`<!---->`);
        }
        _push(`<!--]-->`);
      });
      _push(`<!--]-->`);
      if (__props.post.tags.length > 0) {
        _push(`<div class="border-t border-neutral-100 pt-8" data-v-450829b0><p class="mb-3 text-label-md text-neutral-500" data-v-450829b0>${ssrInterpolate(unref(t)("blog.tags"))}</p><ul class="flex flex-wrap gap-2" data-v-450829b0><!--[-->`);
        ssrRenderList(__props.post.tags, (tag) => {
          _push(`<li class="rounded-round border border-neutral-200 px-4 py-2 text-label-md text-neutral-700" data-v-450829b0>${ssrInterpolate(tag.name)}</li>`);
        });
        _push(`<!--]--></ul></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="hidden w-[119px] shrink-0 flex-col items-center gap-6 lg:sticky lg:top-32 lg:flex lg:self-start" data-v-450829b0><p class="text-center text-label-lg text-neutral-900" data-v-450829b0>${ssrInterpolate(unref(t)("blog.share"))}</p><div class="flex flex-col gap-4" data-v-450829b0><button type="button" class="share-button size-[68px]"${ssrRenderAttr("aria-label", copied.value ? unref(t)("blog.link_copied") : unref(t)("blog.copy_link"))} data-v-450829b0>`);
      ssrRenderVNode(_push, createVNode(resolveDynamicComponent(copied.value ? unref(Check) : unref(Link2)), {
        class: "size-6",
        "aria-hidden": "true"
      }, null), _parent);
      _push(`</button><a${ssrRenderAttr("href", xShare.value)} target="_blank" rel="noopener noreferrer" class="share-button size-[68px]" aria-label="X" data-v-450829b0><svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-v-450829b0><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" data-v-450829b0></path></svg></a><a${ssrRenderAttr("href", linkedInShare.value)} target="_blank" rel="noopener noreferrer" class="share-button size-[68px]" aria-label="LinkedIn" data-v-450829b0>`);
      _push(ssrRenderComponent(unref(Linkedin), {
        class: "size-6",
        "stroke-width": 1.5,
        "aria-hidden": "true"
      }, null, _parent));
      _push(`</a></div></div></div>`);
      if (__props.post.related.length > 0) {
        _push(`<section class="mt-16 flex flex-col gap-10 md:mt-0 md:gap-12" data-v-450829b0><h2 class="text-[22px] font-semibold leading-normal text-neutral-900 md:text-[40px]" data-v-450829b0>${ssrInterpolate(unref(t)("blog.related"))}</h2><ul class="flex gap-4 overflow-x-auto md:grid md:gap-6 md:overflow-visible sm:grid-cols-2 lg:grid-cols-3" data-v-450829b0><!--[-->`);
        ssrRenderList(__props.post.related, (related) => {
          _push(`<li class="w-[268px] shrink-0 md:w-auto" data-v-450829b0>`);
          _push(ssrRenderComponent(unref(link_default), {
            href: related.url,
            class: "group flex flex-col gap-4 rounded-lg"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                if (related.image) {
                  _push2(`<img${ssrRenderAttr("src", related.image.src)}${ssrRenderAttr("srcset", related.image.srcset)}${ssrRenderAttr("alt", related.image.alt)} width="400" height="400" class="size-[268px] rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px] md:w-full" data-v-450829b0${_scopeId}>`);
                } else {
                  _push2(`<!---->`);
                }
                _push2(`<div class="flex flex-col gap-4" data-v-450829b0${_scopeId}><div class="flex items-center gap-4" data-v-450829b0${_scopeId}><time${ssrRenderAttr("datetime", related.publishedAtIso)} class="flex items-center gap-2 text-body-md text-neutral-500" data-v-450829b0${_scopeId}>`);
                _push2(ssrRenderComponent(unref(CalendarDays), {
                  class: "size-6 text-gold",
                  "stroke-width": 1.5,
                  "aria-hidden": "true"
                }, null, _parent2, _scopeId));
                _push2(` ${ssrInterpolate(related.publishedAt)}</time><span class="flex items-center gap-2 text-body-md text-neutral-500" data-v-450829b0${_scopeId}><span class="inline-block size-1 rounded-full bg-gold" aria-hidden="true" data-v-450829b0${_scopeId}></span> ${ssrInterpolate(unref(t)("blog.reading_time", { minutes: related.readingTime }))}</span></div><h3 class="text-title-lg text-neutral-900" data-v-450829b0${_scopeId}>${ssrInterpolate(related.title)}</h3></div>`);
              } else {
                return [
                  related.image ? (openBlock(), createBlock("img", {
                    key: 0,
                    src: related.image.src,
                    srcset: related.image.srcset,
                    alt: related.image.alt,
                    width: "400",
                    height: "400",
                    class: "size-[268px] rounded-lg border border-neutral-100 object-cover shadow-card transition-transform duration-500 ease-brand group-hover:scale-[1.02] md:h-[400px] md:w-full"
                  }, null, 8, ["src", "srcset", "alt"])) : createCommentVNode("", true),
                  createVNode("div", { class: "flex flex-col gap-4" }, [
                    createVNode("div", { class: "flex items-center gap-4" }, [
                      createVNode("time", {
                        datetime: related.publishedAtIso,
                        class: "flex items-center gap-2 text-body-md text-neutral-500"
                      }, [
                        createVNode(unref(CalendarDays), {
                          class: "size-6 text-gold",
                          "stroke-width": 1.5,
                          "aria-hidden": "true"
                        }),
                        createTextVNode(" " + toDisplayString(related.publishedAt), 1)
                      ], 8, ["datetime"]),
                      createVNode("span", { class: "flex items-center gap-2 text-body-md text-neutral-500" }, [
                        createVNode("span", {
                          class: "inline-block size-1 rounded-full bg-gold",
                          "aria-hidden": "true"
                        }),
                        createTextVNode(" " + toDisplayString(unref(t)("blog.reading_time", { minutes: related.readingTime })), 1)
                      ])
                    ]),
                    createVNode("h3", { class: "text-title-lg text-neutral-900" }, toDisplayString(related.title), 1)
                  ])
                ];
              }
            }),
            _: 2
          }, _parent));
          _push(`</li>`);
        });
        _push(`<!--]--></ul></section>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.finalCta) {
        _push(ssrRenderComponent(CtaBanner, {
          section: __props.finalCta,
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Insights/Show.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const Show = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-450829b0"]]);
export {
  Show as default
};
