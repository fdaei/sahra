import { defineComponent, computed, unref, createVNode, resolveDynamicComponent, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderAttr, ssrRenderStyle, ssrInterpolate, ssrRenderList, ssrRenderVNode, ssrRenderClass } from "vue/server-renderer";
import { BadgeCheck, Focus, Repeat2, TrendingUp } from "lucide-vue-next";
import { _ as _sfc_main$1 } from "./SeoHead-DbuqnLLJ.js";
import { C as CtaBanner } from "./CtaBanner-Cb3ia_15.js";
import { _ as _sfc_main$2 } from "./HoverIcon-Cu-t3PJE.js";
import "../ssr.js";
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
const arcRings = "/build/assets/arc-rings-B4rWaPkT.svg";
const duneContours = "/build/assets/dune-contours-DV3d6otK.webp";
const TEAM_ITEM_WIDTH = 254;
const TEAM_TRACK_COVER = 2560;
const MOBILE_TEAM_ITEM_WIDTH = 190;
const MOBILE_TEAM_TRACK_COVER = 800;
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "About",
  __ssrInlineRender: true,
  props: {
    sections: {},
    team: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const hero = computed(() => props.sections.about_hero);
    const story = computed(() => props.sections.story);
    const howWeThink = computed(() => props.sections.how_we_think);
    const team = computed(() => props.sections.team);
    const thinkIcons = [BadgeCheck, Focus, Repeat2, TrendingUp];
    const isUploadedIcon = (icon) => Boolean(icon && (icon.startsWith("/") || /^https?:\/\//.test(icon)));
    const heroImage = computed(() => {
      var _a;
      return ((_a = hero.value) == null ? void 0 : _a.image) ?? null;
    });
    const mobileTeamTrack = computed(() => {
      if (props.team.length === 0) return { items: [], uniqueCount: 0 };
      const repeats = Math.max(
        1,
        Math.ceil(MOBILE_TEAM_TRACK_COVER / MOBILE_TEAM_ITEM_WIDTH / props.team.length)
      );
      const half = Array.from({ length: repeats }, () => props.team).flat();
      return { items: [...half, ...half], uniqueCount: props.team.length };
    });
    const teamRows = computed(() => {
      const members = props.team;
      if (members.length === 0) return [];
      const split = Math.ceil(members.length / 2);
      return [members.slice(0, split), members.slice(split)].filter((row) => row.length > 0).map((row) => {
        const repeats = Math.max(
          1,
          Math.ceil(TEAM_TRACK_COVER / TEAM_ITEM_WIDTH / row.length)
        );
        const half = Array.from({ length: repeats }, () => row).flat();
        return { items: [...half, ...half], uniqueCount: row.length };
      });
    });
    return (_ctx, _push, _parent, _attrs) => {
      var _a, _b;
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, { meta: __props.seo }, null, _parent));
      _push(`<section class="relative overflow-hidden pb-0 pt-[139px] md:pb-[128px] md:pt-[192px]"><div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true"><div class="relative mx-auto h-full w-full max-w-frame"><img${ssrRenderAttr("src", unref(arcRings))} alt="" width="1500" height="1320" class="absolute -top-[506px] start-[672px] w-[1500px] max-w-none"></div></div><div class="container-sahra relative flex flex-col gap-0 lg:gap-[200px]">`);
      if (hero.value) {
        _push(`<div class="grid h-[340px] grid-cols-[1fr_151px] items-start gap-[14px] lg:flex lg:h-auto lg:flex-row lg:items-center lg:justify-between lg:gap-[100px] xl:gap-[250px]"><div class="flex w-full flex-col gap-12 lg:max-w-[506px]"><p class="eyebrow" style="${ssrRenderStyle({ color: hero.value.colors.eyebrow || void 0 })}">${ssrInterpolate(hero.value.eyebrow)}</p><div class="flex flex-col gap-6"><h1 style="${ssrRenderStyle({ color: hero.value.colors.title || void 0 })}"><span class="block font-display text-[32px] font-normal leading-none tracking-[-0.01em] text-gold md:text-[76px]">${ssrInterpolate(hero.value.title)}</span>`);
        if (hero.value.content) {
          _push(`<span class="mt-2 block text-[22px] font-medium leading-normal tracking-[-0.02em] text-neutral-900 md:text-[40px]" style="${ssrRenderStyle({ color: hero.value.colors.content || void 0 })}">${ssrInterpolate(hero.value.content)}</span>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</h1><p class="text-body-md text-neutral-700 md:text-title-sm md:font-medium" style="${ssrRenderStyle({ color: hero.value.colors.description || void 0 })}">${ssrInterpolate(hero.value.description)}</p></div></div><img${ssrRenderAttr("src", ((_a = heroImage.value) == null ? void 0 : _a.src) ?? "/images/sahra/about-hero-sculpture.png")}${ssrRenderAttr("alt", ((_b = heroImage.value) == null ? void 0 : _b.alt) ?? "")} width="321" height="405" class="w-[151px] shrink-0 object-contain lg:w-[321px]"${ssrRenderAttr("aria-hidden", heroImage.value ? void 0 : "true")}></div>`);
      } else {
        _push(`<!---->`);
      }
      if (story.value) {
        _push(`<div class="mt-[115px] flex h-[313px] flex-col gap-8 lg:mt-0 lg:h-auto lg:flex-row lg:justify-between lg:gap-[166px]"><h2 class="text-[22px] font-semibold leading-normal text-neutral-900 md:text-display-md lg:max-w-[472px] lg:shrink-0" style="${ssrRenderStyle({ color: story.value.colors.title || void 0 })}">${ssrInterpolate(story.value.title)}</h2><div class="flex flex-col gap-6 lg:max-w-[612px]"><p class="text-body-md text-neutral-700 md:text-title-sm md:font-medium" style="${ssrRenderStyle({ color: story.value.colors.description || void 0 })}">${ssrInterpolate(story.value.description)}</p>`);
        if (story.value.content) {
          _push(`<p class="text-body-md text-neutral-700 md:text-title-sm md:font-medium" style="${ssrRenderStyle({ color: story.value.colors.content || void 0 })}">${ssrInterpolate(story.value.content)}</p>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div>`);
      } else {
        _push(`<!---->`);
      }
      if (howWeThink.value) {
        _push(`<div class="mt-[81px] flex h-[759px] flex-col gap-[51px] md:gap-12 lg:mt-0 lg:h-auto"><div class="flex flex-col gap-6 lg:flex-row lg:justify-between lg:gap-[348px]"><h2 class="text-[22px] font-semibold md:text-display-md lg:shrink-0" style="${ssrRenderStyle({ color: howWeThink.value.colors.title || void 0 })}">${ssrInterpolate(howWeThink.value.title)}</h2><p class="hidden text-body-md text-neutral-700 md:block md:text-title-sm md:font-medium lg:max-w-[612px]" style="${ssrRenderStyle({ color: howWeThink.value.colors.description || void 0 })}">${ssrInterpolate(howWeThink.value.description)}</p></div><div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4"><!--[-->`);
        ssrRenderList(howWeThink.value.items, (item, i) => {
          _push(`<div class="group flex flex-col gap-4 rounded-sm border-x border-b border-t-[3px] border-gold-400 border-t-gold bg-neutral-50/30 p-6 md:gap-6 md:py-12">`);
          if (isUploadedIcon(item.icon)) {
            _push(ssrRenderComponent(_sfc_main$2, {
              name: item.icon,
              "hover-name": item.hoverIcon,
              class: "size-5 md:size-8"
            }, null, _parent));
          } else {
            ssrRenderVNode(_push, createVNode(resolveDynamicComponent(thinkIcons[i] || unref(TrendingUp)), {
              class: "size-5 shrink-0 text-gold md:size-8",
              "stroke-width": 1.5,
              "aria-hidden": "true"
            }, null), _parent);
          }
          _push(`<div class="flex flex-col gap-2"><h3 class="text-[18px] font-medium text-neutral-900 md:text-title-xl">${ssrInterpolate(item.title)}</h3><p class="text-[14px] text-neutral-800 md:text-title-sm">${ssrInterpolate(item.description)}</p></div></div>`);
        });
        _push(`<!--]--></div></div>`);
      } else {
        _push(`<!---->`);
      }
      if (team.value) {
        _push(`<div class="relative isolate mt-[98px] flex flex-col gap-12 md:gap-24 lg:mt-0"><img${ssrRenderAttr("src", unref(duneContours))} alt="" aria-hidden="true" loading="lazy" decoding="async" width="1160" height="1000" class="pointer-events-none absolute -top-[104px] start-[37px] z-0 hidden w-[1160px] max-w-none opacity-100 lg:block"><div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:justify-between lg:gap-[328px]"><h2 class="max-w-[287px] text-[22px] font-semibold leading-normal [text-wrap:initial] md:text-display-md lg:shrink-0" style="${ssrRenderStyle({ color: team.value.colors.title || void 0 })}">${ssrInterpolate(team.value.title)}</h2><p class="hidden text-title-xl text-neutral-800 md:block lg:max-w-[612px]" style="${ssrRenderStyle({ color: team.value.colors.description || void 0 })}">${ssrInterpolate(team.value.description)}</p></div><div class="marquee-mask relative z-10 overflow-hidden lg:hidden"><div class="marquee-track gap-4" style="${ssrRenderStyle({ "--marquee-duration": "48s" })}"><!--[-->`);
        ssrRenderList(mobileTeamTrack.value.items, (member, i) => {
          _push(`<figure class="flex w-[174px] shrink-0 flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60"${ssrRenderAttr("aria-hidden", i >= mobileTeamTrack.value.uniqueCount ? "true" : void 0)}>`);
          if (member.image) {
            _push(`<div class="aspect-square w-full overflow-hidden rounded-sm"><img${ssrRenderAttr("src", member.image.src)}${ssrRenderAttr("srcset", member.image.srcset)}${ssrRenderAttr("alt", i >= mobileTeamTrack.value.uniqueCount ? "" : member.image.alt)}${ssrRenderAttr("width", member.image.width)}${ssrRenderAttr("height", member.image.height)} class="size-full object-cover grayscale transition-[filter,transform] duration-500 ease-brand hover:scale-[1.06] hover:grayscale-0 focus-visible:scale-[1.06] focus-visible:grayscale-0 motion-reduce:transition-none"></div>`);
          } else {
            _push(`<div class="aspect-square w-full rounded-sm bg-neutral-100"></div>`);
          }
          _push(`<figcaption class="flex flex-col gap-1 px-3 py-2"><p class="text-[14px] font-medium text-neutral-900">${ssrInterpolate(member.name)}</p><p class="text-[12px] text-neutral-600">${ssrInterpolate(member.role)}</p></figcaption></figure>`);
        });
        _push(`<!--]--></div></div><div class="relative z-10 hidden flex-col gap-[26px] lg:flex"><!--[-->`);
        ssrRenderList(teamRows.value, (row, rowIndex) => {
          _push(`<div class="marquee-mask overflow-hidden"><div class="${ssrRenderClass([rowIndex % 2 === 0 ? "marquee-track--reverse" : "", "marquee-track gap-4 md:gap-6 lg:gap-[26px]"])}" style="${ssrRenderStyle({ "--marquee-duration": rowIndex % 2 === 0 ? "90s" : "100s" })}"><!--[-->`);
          ssrRenderList(row.items, (member, i) => {
            _push(`<figure class="flex w-[174px] shrink-0 flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60 lg:w-[228px]"${ssrRenderAttr("aria-hidden", i >= row.uniqueCount ? "true" : void 0)}>`);
            if (member.image) {
              _push(`<div class="aspect-square w-full overflow-hidden rounded-sm"><img${ssrRenderAttr("src", member.image.src)}${ssrRenderAttr("srcset", member.image.srcset)}${ssrRenderAttr("alt", i >= row.uniqueCount ? "" : member.image.alt)}${ssrRenderAttr("width", member.image.width)}${ssrRenderAttr("height", member.image.height)} class="size-full object-cover grayscale transition-[filter,transform] duration-500 ease-brand hover:scale-[1.06] hover:grayscale-0 focus-visible:scale-[1.06] focus-visible:grayscale-0 motion-reduce:transition-none"></div>`);
            } else {
              _push(`<div class="aspect-square w-full rounded-sm bg-neutral-100"></div>`);
            }
            _push(`<figcaption class="flex flex-col gap-1 px-3 py-2 md:px-4"><p class="text-[14px] font-medium text-neutral-900 md:text-title-lg">${ssrInterpolate(member.name)}</p><p class="text-[12px] text-neutral-600 md:text-title-sm">${ssrInterpolate(member.role)}</p></figcaption></figure>`);
          });
          _push(`<!--]--></div></div>`);
        });
        _push(`<!--]--></div></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></section>`);
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/About.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
