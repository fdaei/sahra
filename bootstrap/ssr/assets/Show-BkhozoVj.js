import { defineComponent, computed, ref, unref, createVNode, resolveDynamicComponent, withCtx, createTextVNode, toDisplayString, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderAttr, ssrInterpolate, ssrRenderList, ssrRenderVNode, ssrRenderClass, ssrRenderStyle } from "vue/server-renderer";
import { u as useTranslations, e as useHeroStagger, g as useSectionReveal, l as link_default, _ as _export_sfc } from "../ssr.js";
import { Building2, CalendarDays, Instagram, LayoutGrid, MoveRight, BadgeCheck, ArrowRight } from "lucide-vue-next";
import { _ as _sfc_main$1 } from "./SeoHead-DbuqnLLJ.js";
import { C as CtaBanner } from "./CtaBanner-Cb3ia_15.js";
import { _ as _sfc_main$2 } from "./HoverIcon-Cu-t3PJE.js";
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
const projectArcRings = "/build/assets/arc-rings-project-CK82ydjD.svg";
const deliverablesCardBg = "/build/assets/deliverables-card-bg-Bvd1QNeY.png";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Show",
  __ssrInlineRender: true,
  props: {
    project: {},
    finalCta: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const { t } = useTranslations();
    const info = computed(
      () => [
        {
          icon: Building2,
          label: t("work.industry"),
          value: props.project.industry
        },
        { icon: CalendarDays, label: t("work.year"), value: props.project.year },
        {
          icon: Instagram,
          label: t("work.instagram"),
          value: props.project.instagram,
          href: props.project.instagram ? `https://instagram.com/${props.project.instagram}` : null
        },
        {
          icon: LayoutGrid,
          label: t("work.services"),
          value: props.project.services.join(", ")
        }
      ].filter((row) => row.value)
    );
    const resultIcons = [
      "/icons/sahra/results/roi.svg",
      "/icons/sahra/results/reach.svg",
      "/icons/sahra/results/interaction.svg",
      "/icons/sahra/results/follower.svg",
      "/icons/sahra/results/view.svg"
    ];
    const isUploadedIcon = (icon) => Boolean(icon && (icon.startsWith("/") || /^https?:\/\//.test(icon)));
    const activeShowcaseIndex = ref(0);
    const showcaseFilters = computed(() => [
      t("work.type_post"),
      t("work.type_story"),
      t("work.type_logo")
    ]);
    const pageRoot = ref(null);
    const intro = ref(null);
    useHeroStagger(intro);
    useSectionReveal(pageRoot);
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, { meta: __props.seo }, null, _parent));
      _push(`<div class="relative overflow-x-clip" data-v-101f55b8><div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true" data-v-101f55b8><div class="relative mx-auto h-full w-full max-w-frame" data-v-101f55b8><img${ssrRenderAttr("src", unref(projectArcRings))} alt="" width="1473" height="1563" class="absolute start-[-617px] top-[974px] w-[1473px] max-w-none max-md:start-[-760px] max-md:top-[820px]" data-v-101f55b8></div></div><div class="container-sahra relative z-10 flex flex-col gap-0 pb-0 pt-[160px] md:gap-[144px] md:pb-56 md:pt-[184px]" data-v-101f55b8><div class="flex flex-col gap-0 md:gap-[200px]" data-v-101f55b8><div class="flex flex-col gap-6 md:gap-20" data-v-101f55b8><div class="flex flex-col gap-8 lg:flex-row lg:justify-between lg:gap-[342px]" data-v-101f55b8><div class="flex max-w-[612px] flex-col gap-4 md:gap-6" data-v-101f55b8><h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-[48px]" data-v-101f55b8>${ssrInterpolate(__props.project.title)}</h1>`);
      if (__props.project.excerpt) {
        _push(`<p class="text-[16px] font-normal leading-normal tracking-[-0.02em] text-neutral-700 md:text-[18px] md:font-medium md:tracking-normal" data-v-101f55b8>${ssrInterpolate(__props.project.excerpt)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (info.value.length > 0) {
        _push(`<dl class="grid w-full shrink-0 grid-flow-col grid-cols-2 grid-rows-2 justify-between gap-y-4 md:flex md:w-auto md:flex-col md:gap-6" data-v-101f55b8><!--[-->`);
        ssrRenderList(info.value, (row) => {
          _push(`<div class="flex flex-col gap-1" data-v-101f55b8><dt class="flex items-center gap-2" data-v-101f55b8>`);
          ssrRenderVNode(_push, createVNode(resolveDynamicComponent(row.icon), {
            class: "size-5 shrink-0 text-gold",
            "stroke-width": 1.5,
            "aria-hidden": "true"
          }, null), _parent);
          _push(`<span class="text-[14px] font-medium leading-[18px] text-neutral-1000 md:text-label-lg" data-v-101f55b8>${ssrInterpolate(row.label)}</span></dt><dd class="max-w-[220px] text-[14px] leading-[18px] text-neutral-800 md:text-body-md" data-v-101f55b8>`);
          if (row.href) {
            _push(`<a${ssrRenderAttr("href", row.href)} target="_blank" rel="noopener noreferrer" class="underline decoration-neutral-300 underline-offset-2 hover:text-gold" data-v-101f55b8>${ssrInterpolate(row.value)}</a>`);
          } else {
            _push(`<!--[-->${ssrInterpolate(row.value)}<!--]-->`);
          }
          _push(`</dd></div>`);
        });
        _push(`<!--]--></dl>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.project.banner) {
        _push(`<img${ssrRenderAttr("src", __props.project.banner.src)}${ssrRenderAttr("srcset", __props.project.banner.srcset)}${ssrRenderAttr("alt", __props.project.banner.alt)} width="1248" height="624" class="h-[272px] w-full rounded-lg object-cover shadow-banner md:h-auto md:aspect-[1248/624]" data-v-101f55b8>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.project.challenge) {
        _push(`<section class="will-reveal mt-8 flex min-h-[277px] flex-col gap-8 md:mt-0 md:min-h-0 md:gap-10 lg:flex-row lg:justify-between" data-reveal data-v-101f55b8><h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]" data-v-101f55b8>${ssrInterpolate(unref(t)("work.challenge"))}</h2><div class="flex w-full max-w-[612px] flex-col gap-4 md:gap-6" data-v-101f55b8><p class="text-[18px] font-medium leading-normal text-ink md:text-[32px]" data-v-101f55b8> “${ssrInterpolate(__props.project.challenge)}” </p>`);
        if (__props.project.challengePoints.length > 0) {
          _push(`<ul class="flex flex-col gap-2" data-v-101f55b8><!--[-->`);
          ssrRenderList(__props.project.challengePoints, (point, i) => {
            _push(`<li class="flex items-center gap-2 text-body-md text-neutral-800 md:text-[18px]" data-v-101f55b8>`);
            _push(ssrRenderComponent(unref(MoveRight), {
              class: "size-5 shrink-0 text-gold rtl:-scale-x-100",
              "stroke-width": 1.5,
              "aria-hidden": "true"
            }, null, _parent));
            _push(` ${ssrInterpolate(point)}</li>`);
          });
          _push(`<!--]--></ul>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></section>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.project.goals.length > 0) {
        _push(`<section class="will-reveal mt-[104px] flex flex-col gap-12 md:mt-0" data-reveal data-v-101f55b8><h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]" data-v-101f55b8>${ssrInterpolate(unref(t)("work.goals"))}</h2><ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-v-101f55b8><!--[-->`);
        ssrRenderList(__props.project.goals, (card, i) => {
          _push(`<li class="flex flex-col gap-4 rounded-sm border-x border-b border-t-[3px] border-gold-400 border-t-gold bg-neutral-50/30 p-6 md:gap-6 md:py-12" data-v-101f55b8>`);
          _push(ssrRenderComponent(unref(BadgeCheck), {
            class: "size-6 shrink-0 text-gold md:hidden",
            "stroke-width": 1.5,
            "aria-hidden": "true"
          }, null, _parent));
          _push(`<span class="hidden font-medium leading-none text-gold md:block md:text-[36px]" data-v-101f55b8>${ssrInterpolate(String(i + 1).padStart(2, "0"))}</span><span class="flex flex-col gap-2" data-v-101f55b8><span class="text-[18px] font-medium text-neutral-900 md:text-[24px]" data-v-101f55b8>${ssrInterpolate(card.title)}</span><span class="text-[14px] leading-normal text-neutral-800 md:text-[18px]" data-v-101f55b8>${ssrInterpolate(card.description)}</span></span></li>`);
        });
        _push(`<!--]--></ol></section>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.project.strategy.length > 0) {
        _push(`<section class="will-reveal mt-[90px] flex flex-col gap-12 md:mt-0 md:gap-10 lg:flex-row lg:justify-between" data-reveal data-v-101f55b8><h2 class="shrink-0 text-[22px] font-semibold text-neutral-900 md:text-[40px]" data-v-101f55b8>${ssrInterpolate(unref(t)("work.strategy"))}</h2><ol class="grid w-full max-w-[860px] grid-cols-2" data-v-101f55b8><!--[-->`);
        ssrRenderList(__props.project.strategy, (card, i) => {
          _push(`<li class="flex flex-col gap-4 border-gold-300 p-4 md:p-6 [&amp;:nth-child(odd)]:border-e [&amp;:nth-child(-n+2)]:border-b" data-v-101f55b8><span class="text-[18px] font-medium leading-normal text-gold" data-v-101f55b8>${ssrInterpolate(String(i + 1).padStart(2, "0"))}</span><h3 class="text-[16px] font-medium leading-normal text-gold md:text-[24px]" data-v-101f55b8>${ssrInterpolate(card.title)}</h3><p class="text-[14px] leading-normal text-neutral-700 md:text-[18px]" data-v-101f55b8>${ssrInterpolate(card.description)}</p></li>`);
        });
        _push(`<!--]--></ol></section>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.project.deliverables.length > 0) {
        _push(`<section class="will-reveal mt-[111px] flex flex-col gap-12 md:mt-0" data-reveal data-v-101f55b8><h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]" data-v-101f55b8>${ssrInterpolate(unref(t)("work.deliverables"))}</h2><ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-v-101f55b8><!--[-->`);
        ssrRenderList(__props.project.deliverables, (card, i) => {
          _push(`<li class="deliverables-card relative flex flex-col gap-8 overflow-hidden rounded-sm border border-gold-300 bg-paper p-6 shadow-[2px_2px_10px_rgba(0,0,0,0.05)] md:min-h-[306px] md:gap-12 md:py-6" data-v-101f55b8><img${ssrRenderAttr("src", unref(deliverablesCardBg))} alt="" class="deliverables-card__background pointer-events-none absolute max-w-none opacity-60" aria-hidden="true" data-v-101f55b8><span class="relative z-10 text-[22px] font-medium leading-none text-gold md:text-[36px] md:leading-normal" data-v-101f55b8>${ssrInterpolate(String(i + 1).padStart(2, "0"))}</span><span class="relative z-10 flex flex-col gap-2" data-v-101f55b8><span class="text-[18px] font-medium leading-normal text-neutral-900 md:text-[24px]" data-v-101f55b8>${ssrInterpolate(card.title)}</span><span class="text-[14px] leading-normal text-neutral-800 md:text-[18px]" data-v-101f55b8>${ssrInterpolate(card.description)}</span></span></li>`);
        });
        _push(`<!--]--></ol></section>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.project.showcase.length > 0) {
        _push(`<section class="will-reveal relative mt-[76px] h-[488px] md:mt-0 md:h-auto" data-reveal data-v-101f55b8><div class="md:flex md:items-center md:justify-between" data-v-101f55b8><h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]" data-v-101f55b8>${ssrInterpolate(unref(t)("work.showcase"))}</h2><div class="absolute inset-x-0 top-[79px] flex justify-center gap-16 text-[14px] leading-none md:static md:inset-auto md:shrink-0 md:justify-start" role="tablist"${ssrRenderAttr("aria-label", unref(t)("work.content_types"))} data-v-101f55b8><!--[-->`);
        ssrRenderList(showcaseFilters.value, (label, index) => {
          _push(`<button${ssrRenderAttr("id", `showcase-tab-${index}`)} type="button" role="tab"${ssrRenderAttr("aria-controls", `showcase-panel-${index}`)}${ssrRenderAttr("aria-selected", activeShowcaseIndex.value === index)}${ssrRenderAttr("tabindex", activeShowcaseIndex.value === index ? 0 : -1)} class="${ssrRenderClass([
            activeShowcaseIndex.value === index ? "font-medium text-ink underline decoration-from-font underline-offset-2" : "font-normal hover:text-ink",
            "cursor-pointer whitespace-nowrap text-neutral-700 transition-colors"
          ])}" style="${ssrRenderStyle(index < __props.project.showcase.length ? null : { display: "none" })}" data-v-101f55b8>${ssrInterpolate(label)}</button>`);
        });
        _push(`<!--]--></div></div><ul class="absolute inset-x-0 top-[160px] md:static md:mt-12 md:grid md:grid-cols-2 md:gap-6 lg:grid-cols-3" data-v-101f55b8><!--[-->`);
        ssrRenderList(__props.project.showcase, (image, i) => {
          _push(`<li${ssrRenderAttr("id", `showcase-panel-${i}`)} role="tabpanel"${ssrRenderAttr(
            "aria-labelledby",
            i < showcaseFilters.value.length ? `showcase-tab-${i}` : void 0
          )} class="${ssrRenderClass([activeShowcaseIndex.value === i ? "" : "hidden", "w-[262px] md:w-auto"])}" data-v-101f55b8><img${ssrRenderAttr("src", image.src)}${ssrRenderAttr("srcset", image.srcset)}${ssrRenderAttr("alt", image.alt)} width="400" height="500" class="h-[328px] w-full rounded-sm object-cover md:aspect-[4/5] md:h-auto" data-v-101f55b8></li>`);
        });
        _push(`<!--]--></ul></section>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.project.results.length > 0) {
        _push(`<section class="will-reveal mt-[76px] flex flex-col gap-0 md:mt-0 md:gap-12" data-reveal data-v-101f55b8><h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]" data-v-101f55b8>${ssrInterpolate(unref(t)("work.results"))}</h2><ul class="mt-12 grid grid-cols-2 gap-3 md:mt-0 md:grid-cols-3 md:gap-6 lg:grid-cols-5" data-v-101f55b8><!--[-->`);
        ssrRenderList(__props.project.results, (stat, i) => {
          _push(`<li class="group flex flex-col gap-4 rounded-sm bg-gold-100 px-6 py-4 md:px-8" data-v-101f55b8>`);
          if (isUploadedIcon(stat.icon)) {
            _push(ssrRenderComponent(_sfc_main$2, {
              name: stat.icon,
              "hover-name": stat.hoverIcon,
              class: "size-8"
            }, null, _parent));
          } else {
            _push(`<img${ssrRenderAttr("src", resultIcons[i] || resultIcons[0])} alt="" class="size-8 object-contain object-left" aria-hidden="true" data-v-101f55b8>`);
          }
          _push(`<span class="flex flex-col gap-2" data-v-101f55b8><span class="text-[18px] font-medium leading-normal text-neutral-900 md:text-title-lg" data-v-101f55b8>${ssrInterpolate(stat.label)}</span><span class="latin-nums text-[22px] font-medium leading-normal text-gold md:text-[30px] md:leading-none" data-v-101f55b8>${ssrInterpolate(stat.value)}</span></span></li>`);
        });
        _push(`<!--]--></ul>`);
        if (__props.project.resultsSummary) {
          _push(`<p class="mt-8 whitespace-pre-line text-[16px] leading-normal text-neutral-800 md:mt-0 md:text-[24px] md:font-medium" data-v-101f55b8>${ssrInterpolate(__props.project.resultsSummary)}</p>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</section>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (__props.project.beforeAfter.before || __props.project.beforeAfter.after) {
        _push(`<section class="will-reveal mt-[74px] grid gap-4 md:mt-0 md:gap-6 sm:grid-cols-2" data-reveal data-v-101f55b8>`);
        if (__props.project.beforeAfter.before) {
          _push(`<figure class="flex flex-col gap-3 md:gap-6" data-v-101f55b8><figcaption class="text-center text-[20px] font-medium text-neutral-900 md:text-[28px] md:font-semibold" data-v-101f55b8>${ssrInterpolate(unref(t)("work.before"))}</figcaption><img${ssrRenderAttr("src", __props.project.beforeAfter.before.src)}${ssrRenderAttr("alt", __props.project.beforeAfter.before.alt)} class="h-[181px] w-full rounded-sm object-cover shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:h-[306px]" data-v-101f55b8></figure>`);
        } else {
          _push(`<!---->`);
        }
        if (__props.project.beforeAfter.after) {
          _push(`<figure class="flex flex-col gap-3 md:gap-6" data-v-101f55b8><figcaption class="text-center text-[20px] font-medium text-neutral-900 md:text-[28px] md:font-semibold" data-v-101f55b8>${ssrInterpolate(unref(t)("work.after"))}</figcaption><img${ssrRenderAttr("src", __props.project.beforeAfter.after.src)}${ssrRenderAttr("alt", __props.project.beforeAfter.after.alt)} class="h-[181px] w-full rounded-sm object-cover shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:h-[306px]" data-v-101f55b8></figure>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</section>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.project.next) {
        _push(`<section class="will-reveal mt-[58px] flex flex-col gap-2 md:mt-0 md:gap-8" data-reveal data-v-101f55b8><p class="text-body-lg font-medium text-neutral-800 md:text-[24px]" data-v-101f55b8>${ssrInterpolate(unref(t)("work.next_case_study"))}</p>`);
        _push(ssrRenderComponent(unref(link_default), {
          href: __props.project.next.url,
          class: "group inline-flex w-fit items-center gap-2 rounded-sm text-[26px] font-medium text-neutral-1000 transition-colors hover:text-gold md:gap-4 md:text-[40px]"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`${ssrInterpolate(__props.project.next.title)} `);
              _push2(ssrRenderComponent(unref(ArrowRight), {
                class: "size-8 transition-transform group-hover:translate-x-1 rtl:-scale-x-100 rtl:group-hover:-translate-x-1 md:size-10",
                "stroke-width": 1.5,
                "aria-hidden": "true"
              }, null, _parent2, _scopeId));
            } else {
              return [
                createTextVNode(toDisplayString(__props.project.next.title) + " ", 1),
                createVNode(unref(ArrowRight), {
                  class: "size-8 transition-transform group-hover:translate-x-1 rtl:-scale-x-100 rtl:group-hover:-translate-x-1 md:size-10",
                  "stroke-width": 1.5,
                  "aria-hidden": "true"
                })
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</section>`);
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
      _push(`</div><!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Work/Show.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const Show = /* @__PURE__ */ _export_sfc(_sfc_main, [["__scopeId", "data-v-101f55b8"]]);
export {
  Show as default
};
