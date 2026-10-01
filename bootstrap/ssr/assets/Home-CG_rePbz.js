import { defineComponent, ref, useId, reactive, computed, mergeProps, unref, useSSRContext, onMounted, onBeforeUnmount, watch, createVNode, resolveDynamicComponent } from "vue";
import { ssrRenderAttrs, ssrRenderAttr, ssrInterpolate, ssrRenderComponent, ssrRenderList, ssrRenderClass, ssrRenderStyle, ssrRenderVNode, ssrIncludeBooleanAttr } from "vue/server-renderer";
import { c as useMasteryOpen, _ as _export_sfc, u as useTranslations, a as usePage, d as _sfc_main$7, e as useHeroStagger, f as useCounters, g as useSectionReveal } from "../ssr.js";
import { ArrowUpRight, Building2, ChartNoAxesCombined, TrendingUp, UsersRound, BadgeCheck, Copy, Gem, ClipboardCheck, CalendarDays, CirclePlus, CircleMinus } from "lucide-vue-next";
import { _ as _sfc_main$9 } from "./SeoHead-DbuqnLLJ.js";
import { C as CtaBanner } from "./CtaBanner-Cb3ia_15.js";
import { _ as _sfc_main$8 } from "./HoverIcon-Cu-t3PJE.js";
import { useElementSize, useMediaQuery } from "@vueuse/core";
import { _ as _sfc_main$a } from "./LeadMagnet-DYdv05Sc.js";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "@vue/server-renderer";
import "qs-esm";
import "gsap";
import "gsap/CustomEase";
import "gsap/ScrollTrigger";
const KEYFRAMES = [
  [0, 0.04028, 0.09201, 0.08264],
  [0.0315, 0.04236, 0.09201, 0.0816],
  [0.063, 0.05035, 0.09201, 0.07917],
  [0.0945, 0.06701, 0.09201, 0.07743],
  [0.1102, 0.08056, 0.09201, 0.07535],
  [0.126, 0.10104, 0.09132, 0.07569],
  [0.1417, 0.12326, 0.08576, 0.05243],
  [0.1575, 0.14722, 0.07986, 0.02326],
  [0.1732, 0.16979, 0.07465, 764e-5],
  [0.189, 0.19097, 0.06979, 556e-5],
  [0.2205, 0.22674, 0.06181, 382e-5],
  [0.252, 0.25486, 0.0559, 208e-5],
  [0.315, 0.29583, 0.04965, 139e-5],
  [0.378, 0.32465, 0.04375, 104e-5],
  [0.4409, 0.34583, 0.03681, 139e-5],
  [0.5039, 0.36215, 0.02951, 139e-5],
  [0.6299, 0.38333, 0.01701, 0],
  [0.7559, 0.39444, 833e-5, 0],
  [0.8819, 0.39965, 382e-5, 0],
  [1, 0.40035, 313e-5, 0]
];
const MIN_WAIST = 4e-4;
const CENTRE_HANDLE = 0.78;
const LOBE_HANDLE = 0.9;
const LOBE_HANDLE_CAP = 0.35;
const MIN_ATTACH = 0.75;
const ATTACH_FLARE = 1.15;
const FLARE_END = 0.97;
const FLARE_FADE = 0.12;
const MIN_ARC_SPAN = 0.02;
function lerp(from, to, t) {
  return from + (to - from) * t;
}
function attachAngle(radius, separation, waist, t) {
  const ratio = waist / radius;
  const union = Math.asin(Math.max(0, Math.min(1, ratio)));
  if (separation <= radius) return union;
  const flared = Math.asin(Math.max(0, Math.min(1, ratio * ATTACH_FLARE)));
  const fade = Math.max(0, Math.min(1, (FLARE_END - t) / FLARE_FADE));
  return Math.max(flared, MIN_ATTACH * fade, MIN_ARC_SPAN);
}
function resolveBlob(box, t) {
  const clamped = Math.max(0, Math.min(1, t));
  let index = KEYFRAMES.length - 1;
  for (let i = 1; i < KEYFRAMES.length; i += 1) {
    if (KEYFRAMES[i][0] >= clamped) {
      index = i;
      break;
    }
  }
  const [t0, s0, r0, w0] = KEYFRAMES[index - 1] ?? KEYFRAMES[0];
  const [t1, s1, r1, w1] = KEYFRAMES[index];
  const span = t1 - t0;
  const local = span > 0 ? (clamped - t0) / span : 0;
  const radius = lerp(r0, r1, local) * box.width;
  const waist = Math.max(lerp(w0, w1, local), MIN_WAIST) * box.width;
  return {
    cx: box.width / 2,
    cy: box.height / 2,
    radius,
    separation: lerp(s0, s1, local) * box.width,
    waist,
    /*
     | Derived, not measured. Putting the bridge's ends where the lobe is
     | exactly as tall as the bridge is what makes the junction continuous —
     | and at t=0 it lands them on the two circles' crossing points, so the
     | outline below emits the plain union of two circles with no special case.
     */
    attach: attachAngle(radius, lerp(s0, s1, local) * box.width, waist, clamped)
  };
}
function blobPath(shape) {
  const { cx, cy, radius, separation, waist, attach } = shape;
  if (radius <= 0) return "";
  const cos = Math.cos(attach);
  const sin = Math.sin(attach);
  const ax = radius * cos;
  const ay = radius * sin;
  const leftX = cx - separation;
  const rightX = cx + separation;
  const topLeft = [leftX + ax, cy - ay];
  const bottomLeft = [leftX + ax, cy + ay];
  const topRight = [rightX - ax, cy - ay];
  const bottomRight = [rightX - ax, cy + ay];
  const gap = Math.max(0, separation - ax);
  const centreHandle = CENTRE_HANDLE * gap;
  const lobeHandle = Math.min(LOBE_HANDLE * gap, LOBE_HANDLE_CAP * radius);
  const lobeDx = lobeHandle * sin;
  const lobeDy = lobeHandle * cos;
  const p = (n) => n.toFixed(2);
  const arc = `A ${p(radius)} ${p(radius)} 0 1 1`;
  return [
    `M ${p(topRight[0])} ${p(topRight[1])}`,
    `${arc} ${p(bottomRight[0])} ${p(bottomRight[1])}`,
    `C ${p(bottomRight[0] - lobeDx)} ${p(bottomRight[1] - lobeDy)}`,
    `${p(cx + centreHandle)} ${p(cy + waist)} ${p(cx)} ${p(cy + waist)}`,
    `C ${p(cx - centreHandle)} ${p(cy + waist)}`,
    `${p(bottomLeft[0] + lobeDx)} ${p(bottomLeft[1] - lobeDy)} ${p(bottomLeft[0])} ${p(bottomLeft[1])}`,
    `${arc} ${p(topLeft[0])} ${p(topLeft[1])}`,
    `C ${p(topLeft[0] + lobeDx)} ${p(topLeft[1] + lobeDy)}`,
    `${p(cx - centreHandle)} ${p(cy - waist)} ${p(cx)} ${p(cy - waist)}`,
    `C ${p(cx + centreHandle)} ${p(cy - waist)}`,
    `${p(topRight[0] - lobeDx)} ${p(topRight[1] + lobeDy)} ${p(topRight[0])} ${p(topRight[1])}`,
    "Z"
  ].join(" ");
}
const _sfc_main$6 = /* @__PURE__ */ defineComponent({
  __name: "MasteryDiagram",
  __ssrInlineRender: true,
  props: {
    leftLabel: {},
    rightLabel: {},
    coreLabel: {}
  },
  setup(__props) {
    const stage = ref(null);
    const clipId = useId();
    const { width, height } = useElementSize(stage);
    const isMobile = useMediaQuery("(max-width: 639px)");
    const progress = reactive({ t: 1 });
    const shape = computed(
      () => resolveBlob({ width: width.value, height: height.value }, progress.t)
    );
    const path = computed(() => blobPath(shape.value));
    const axis = computed(
      () => isMobile.value ? {
        x1: shape.value.cx,
        y1: shape.value.cy - shape.value.separation,
        x2: shape.value.cx,
        y2: shape.value.cy + shape.value.separation
      } : {
        x1: shape.value.cx - shape.value.separation,
        y1: shape.value.cy,
        x2: shape.value.cx + shape.value.separation,
        y2: shape.value.cy
      }
    );
    const blobTransform = computed(
      () => isMobile.value ? `rotate(90 ${shape.value.cx} ${shape.value.cy})` : void 0
    );
    const rings = computed(
      () => isMobile.value ? {
        inner: Math.min(width.value * 0.36, height.value * 0.3),
        outer: Math.min(width.value * 0.59, height.value * 0.47)
      } : {
        inner: Math.min(138, width.value * 0.141),
        outer: Math.min(240, width.value * 0.245)
      }
    );
    useMasteryOpen(stage, progress);
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        ref_key: "stage",
        ref: stage,
        class: "mastery-stage",
        "aria-hidden": "true"
      }, _attrs))} data-v-00e2fec6><svg class="mastery-svg mastery-svg--behind"${ssrRenderAttr("viewBox", `0 0 ${unref(width)} ${unref(height)}`)} focusable="false" data-v-00e2fec6><g data-mastery="rings" class="mastery-rings" data-v-00e2fec6><circle data-mastery="ring-inner"${ssrRenderAttr("cx", shape.value.cx)}${ssrRenderAttr("cy", shape.value.cy)}${ssrRenderAttr("r", rings.value.inner)} data-v-00e2fec6></circle><circle data-mastery="ring-outer"${ssrRenderAttr("cx", shape.value.cx)}${ssrRenderAttr("cy", shape.value.cy)}${ssrRenderAttr("r", rings.value.outer)} data-v-00e2fec6></circle></g></svg><svg class="mastery-svg mastery-svg--front"${ssrRenderAttr("viewBox", `0 0 ${unref(width)} ${unref(height)}`)} focusable="false" data-v-00e2fec6><line data-mastery="axis" class="mastery-axis"${ssrRenderAttr("x1", axis.value.x1)}${ssrRenderAttr("y1", axis.value.y1)}${ssrRenderAttr("x2", axis.value.x2)}${ssrRenderAttr("y2", axis.value.y2)} data-v-00e2fec6></line><path data-mastery="blob" class="mastery-blob"${ssrRenderAttr("d", path.value)}${ssrRenderAttr("transform", blobTransform.value)} data-v-00e2fec6></path><defs data-v-00e2fec6><clipPath${ssrRenderAttr("id", unref(clipId))} data-v-00e2fec6><circle${ssrRenderAttr("cx", shape.value.cx - shape.value.separation)}${ssrRenderAttr("cy", shape.value.cy)}${ssrRenderAttr("r", shape.value.radius)} data-v-00e2fec6></circle></clipPath></defs><g data-mastery="core"${ssrRenderAttr("clip-path", `url(#${unref(clipId)})`)} data-v-00e2fec6><circle class="mastery-core"${ssrRenderAttr("cx", shape.value.cx + shape.value.separation)}${ssrRenderAttr("cy", shape.value.cy)}${ssrRenderAttr("r", shape.value.radius)} data-v-00e2fec6></circle></g></svg><div class="mastery-axis-layout" data-v-00e2fec6><span class="mastery-label mastery-label--left" data-mastery-label="left" data-v-00e2fec6>${ssrInterpolate(__props.leftLabel)}</span><span class="mastery-axis-slot" aria-hidden="true" data-v-00e2fec6></span><span class="mastery-label mastery-label--right" data-mastery-label="right" data-v-00e2fec6>${ssrInterpolate(__props.rightLabel)}</span></div><span class="mastery-label mastery-label--core" data-mastery-label="core" data-v-00e2fec6>${ssrInterpolate(__props.coreLabel)}</span></div>`);
    };
  }
});
const _sfc_setup$6 = _sfc_main$6.setup;
_sfc_main$6.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Services/MasteryDiagram.vue");
  return _sfc_setup$6 ? _sfc_setup$6(props, ctx) : void 0;
};
const MasteryDiagram = /* @__PURE__ */ _export_sfc(_sfc_main$6, [["__scopeId", "data-v-00e2fec6"]]);
const _sfc_main$5 = /* @__PURE__ */ defineComponent({
  __name: "ServicesOrbit",
  __ssrInlineRender: true,
  props: {
    section: {},
    services: {}
  },
  setup(__props) {
    const props = __props;
    const { t } = useTranslations();
    const page = usePage();
    const root = ref(null);
    const visible = ref(false);
    let observer = null;
    let revealTimer = null;
    const activePositions = [
      { x: 50, y: 27 },
      { x: 35, y: 39 },
      { x: 65, y: 39 },
      { x: 31, y: 53 },
      { x: 50, y: 53 },
      { x: 38, y: 68 },
      { x: 64, y: 68 }
    ];
    const accents = [
      "var(--color-gold)",
      "var(--color-gold-900)",
      "var(--color-gold-600)",
      "var(--color-gold-500)"
    ];
    const cards = computed(
      () => props.services.filter((service) => service.homeOrbitGroup === "active").map((service, index) => ({
        ...service,
        displayTitle: service.title,
        href: service.externalUrl || `/${page.props.locale.current}/services#${service.slug}`,
        accent: accents[index % accents.length],
        position: activePositions[index % activePositions.length]
      }))
    );
    const brandPositions = [
      { x: 18, y: 23 },
      { x: 11, y: 38 },
      { x: 14, y: 64 },
      { x: 21, y: 79 }
    ];
    const productPositions = [
      { x: 82, y: 21 },
      { x: 90, y: 36 },
      { x: 86, y: 61 },
      { x: 80, y: 76 },
      { x: 88, y: 87 }
    ];
    const brandGhosts = computed(
      () => props.services.filter((service) => service.homeOrbitGroup === "brand")
    );
    const productGhosts = computed(
      () => props.services.filter((service) => service.homeOrbitGroup === "product")
    );
    const leftAxisLabel = computed(() => t("services.axis_left"));
    const rightAxisLabel = computed(() => t("services.axis_right"));
    onMounted(() => {
      if (!root.value || window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        visible.value = true;
        return;
      }
      observer = new IntersectionObserver(
        ([entry]) => {
          if (!(entry == null ? void 0 : entry.isIntersecting)) return;
          revealTimer = window.setTimeout(() => {
            visible.value = true;
          }, 1200);
          observer == null ? void 0 : observer.disconnect();
        },
        { threshold: 0.2 }
      );
      observer.observe(root.value);
    });
    onBeforeUnmount(() => {
      observer == null ? void 0 : observer.disconnect();
      if (revealTimer !== null) window.clearTimeout(revealTimer);
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({
        ref_key: "root",
        ref: root,
        class: ["services-cloud", { "is-visible": visible.value }],
        "data-no-reveal": ""
      }, _attrs))} data-v-e35c6034><div class="container-sahra relative z-10 py-12 md:py-20 lg:py-24" data-v-e35c6034><div class="flex flex-col gap-6 lg:gap-12" data-v-e35c6034><div class="service-eyebrow" data-v-e35c6034><span aria-hidden="true" data-v-e35c6034></span>${ssrInterpolate(__props.section.eyebrow || unref(t)("services.eyebrow"))}</div><div class="grid gap-4 lg:grid-cols-[506px_1fr] lg:gap-[130px]" data-v-e35c6034><h2 class="max-w-[506px] text-[28px] font-semibold leading-normal text-white md:text-[36px] lg:text-[40px] lg:leading-[1.5]" data-v-e35c6034>${ssrInterpolate(__props.section.title)}</h2><p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-200 md:text-[18px]" data-v-e35c6034>${ssrInterpolate(__props.section.description)}</p></div></div><div class="cloud-diagram" role="group"${ssrRenderAttr("aria-label", unref(t)("services.orbit_label"))} data-v-e35c6034>`);
      _push(ssrRenderComponent(MasteryDiagram, {
        "left-label": leftAxisLabel.value,
        "right-label": rightAxisLabel.value,
        "core-label": __props.section.orbitCoreLabel || unref(t)("services.core")
      }, null, _parent));
      _push(`<div class="services-grid" data-v-e35c6034><div class="side-col side-col--brand" aria-hidden="true" data-v-e35c6034><!--[-->`);
      ssrRenderList(brandGhosts.value, (service, index) => {
        _push(`<div class="${ssrRenderClass([{ "ghost-service--no-image": !service.image }, "ghost-service"])}" style="${ssrRenderStyle({
          "--x": `${brandPositions[index % brandPositions.length].x}%`,
          "--y": `${brandPositions[index % brandPositions.length].y}%`
        })}" data-v-e35c6034><strong data-v-e35c6034>${ssrInterpolate(service.title)}</strong></div>`);
      });
      _push(`<!--]--></div><div class="mastery-col" data-v-e35c6034><!--[-->`);
      ssrRenderList(cards.value, (service, index) => {
        var _a;
        _push(`<article class="${ssrRenderClass([{ "service-card--has-image": !!service.image }, "service-card"])}" style="${ssrRenderStyle({
          "--accent": service.accent,
          "--x": `${service.position.x}%`,
          "--y": `${service.position.y}%`,
          "--delay": `${index * 70}ms`
        })}" data-v-e35c6034><div class="service-card__content" aria-hidden="true" data-v-e35c6034><div class="service-card__asset" data-v-e35c6034>`);
        if (service.image) {
          _push(`<img${ssrRenderAttr("src", service.image.src)} alt="" loading="lazy" decoding="async" data-v-e35c6034>`);
        } else {
          _push(`<div class="service-card__fallback" data-v-e35c6034></div>`);
        }
        _push(`</div><div class="service-card__asset" data-v-e35c6034>`);
        if ((_a = cards.value[(index + 1) % cards.value.length]) == null ? void 0 : _a.image) {
          _push(`<img${ssrRenderAttr("src", cards.value[(index + 1) % cards.value.length].image.src)} alt="" loading="lazy" decoding="async" data-v-e35c6034>`);
        } else {
          _push(`<div class="service-card__fallback" data-v-e35c6034></div>`);
        }
        _push(`</div></div><a class="service-card__title group"${ssrRenderAttr("href", service.href)} data-v-e35c6034>`);
        if (service.icon || service.hoverIcon) {
          _push(`<span class="service-card__icon service-card__icon--asset" aria-hidden="true" data-v-e35c6034>`);
          _push(ssrRenderComponent(_sfc_main$7, {
            name: service.icon,
            "hover-name": service.hoverIcon,
            class: "size-full"
          }, null, _parent));
          _push(`</span>`);
        } else {
          _push(`<span class="service-card__icon" aria-hidden="true" data-v-e35c6034></span>`);
        }
        _push(`<strong data-v-e35c6034>${ssrInterpolate(service.displayTitle)}</strong><svg class="service-card__arrow" width="12" height="12" viewBox="0 0 11 12" fill="none" aria-hidden="true" data-v-e35c6034><path d="M7.69 4.812 4.022 1.143 5.083.083l5.48 5.48-5.48 5.48-1.06-1.06 3.67-3.67H.188v-1.5H7.69Z" fill="currentColor" data-v-e35c6034></path></svg></a></article>`);
      });
      _push(`<!--]--></div><div class="side-col side-col--product" aria-hidden="true" data-v-e35c6034><!--[-->`);
      ssrRenderList(productGhosts.value, (service, index) => {
        _push(`<div class="${ssrRenderClass([{ "ghost-service--no-image": !service.image }, "ghost-service"])}" style="${ssrRenderStyle({
          "--x": `${productPositions[index % productPositions.length].x}%`,
          "--y": `${productPositions[index % productPositions.length].y}%`
        })}" data-v-e35c6034><strong data-v-e35c6034>${ssrInterpolate(service.title)}</strong></div>`);
      });
      _push(`<!--]--></div></div></div></div></section>`);
    };
  }
});
const _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Services/ServicesOrbit.vue");
  return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
const ServicesOrbit = /* @__PURE__ */ _export_sfc(_sfc_main$5, [["__scopeId", "data-v-e35c6034"]]);
const _sfc_main$4 = {};
function _sfc_ssrRender(_ctx, _push, _parent, _attrs) {
  _push(`<span${ssrRenderAttrs(mergeProps({
    class: "relative block size-4 shrink-0 overflow-hidden md:size-6",
    "aria-hidden": "true"
  }, _attrs))}><img src="/icons/Frame.svg" alt="" class="absolute inset-[8.33%] size-[83.34%]"></span>`);
}
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Icons/PackageCheckIcon.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const PackageCheckIcon = /* @__PURE__ */ _export_sfc(_sfc_main$4, [["ssrRender", _sfc_ssrRender]]);
const _sfc_main$3 = /* @__PURE__ */ defineComponent({
  __name: "PackagesSection",
  __ssrInlineRender: true,
  props: {
    section: {}
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({
        class: "relative isolate overflow-hidden bg-black py-12 text-paper md:py-24",
        "data-figma-node": "1419:9323"
      }, _attrs))} data-v-841fb8bb><div class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 aspect-[1440/406] w-full overflow-hidden opacity-40" data-v-841fb8bb><img src="/images/sahra/packages-bg.png" alt="" class="absolute inset-x-0 top-0 aspect-[1440/558] w-full object-cover" data-v-841fb8bb></div><div class="mx-auto w-full max-w-[1248px] px-5 md:px-10 xl:px-0" data-v-841fb8bb><div class="flex flex-col gap-8 md:gap-12" data-v-841fb8bb><div class="eyebrow" data-v-841fb8bb>${ssrInterpolate(__props.section.eyebrow)}</div><div class="grid gap-6 lg:grid-cols-[506px_minmax(0,612px)] lg:justify-between lg:gap-[130px]" data-v-841fb8bb><h2 class="max-w-[506px] text-[26px] font-semibold leading-normal text-paper md:text-display-md" data-v-841fb8bb>${ssrInterpolate(__props.section.title)}</h2><p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-100 md:text-title-sm" data-v-841fb8bb>${ssrInterpolate(__props.section.subtitle)}</p></div></div><div class="${ssrRenderClass([{ "xl:grid-cols-3": __props.section.items.length >= 3 }, "mt-12 grid items-center gap-6 md:mt-18 md:grid-cols-2"])}" data-v-841fb8bb><!--[-->`);
      ssrRenderList(__props.section.items, (item) => {
        _push(`<article class="${ssrRenderClass([{ "package-card--featured": item.badge }, "package-card"])}" data-v-841fb8bb><div class="package-card__body" data-v-841fb8bb><div class="flex items-center gap-2" data-v-841fb8bb><h3 class="text-[24px] font-medium leading-none text-neutral-50 md:text-[28px]" data-v-841fb8bb>${ssrInterpolate(item.title)}</h3>`);
        if (item.badge) {
          _push(`<span class="rounded-round bg-gold/15 px-2 py-1 text-[10px] leading-none text-paper md:text-label-md" data-v-841fb8bb>${ssrInterpolate(item.badge)}</span>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div><div data-v-841fb8bb><p class="text-label-md leading-none text-neutral-200 md:text-label-lg" data-v-841fb8bb>${ssrInterpolate(item.label)}</p><p class="mt-2 flex flex-wrap items-baseline gap-1 text-gold" data-v-841fb8bb><span class="${ssrRenderClass([item.badge ? "text-[32px] md:text-[40px]" : "text-[28px] md:text-[32px]", "latin-nums leading-normal"])}" data-v-841fb8bb>${ssrInterpolate(item.value)}</span><span class="text-body-lg leading-normal text-gold-300 md:text-title-sm" data-v-841fb8bb>${ssrInterpolate(item.suffix)}</span></p><p class="mt-4 text-label-md leading-normal text-neutral-300 md:text-body-md" data-v-841fb8bb>${ssrInterpolate(item.description)}</p></div><div class="h-px bg-neutral-800" aria-hidden="true" data-v-841fb8bb></div><ul class="flex flex-1 flex-col gap-4 md:gap-6" data-v-841fb8bb><!--[-->`);
        ssrRenderList(item.features, (feature) => {
          _push(`<li class="flex items-center gap-[10px] text-body-lg leading-none text-neutral-100" data-v-841fb8bb>`);
          _push(ssrRenderComponent(PackageCheckIcon, null, null, _parent));
          _push(`<span class="min-w-0" data-v-841fb8bb>${ssrInterpolate(feature)}</span></li>`);
        });
        _push(`<!--]--></ul><div class="h-px bg-neutral-800" aria-hidden="true" data-v-841fb8bb></div></div><p class="text-center text-body-lg leading-none text-neutral-100" data-v-841fb8bb>${ssrInterpolate(item.footer)}</p></article>`);
      });
      _push(`<!--]--></div><div class="mt-12 flex items-end justify-between gap-4 rounded-sm border border-neutral-800 bg-white/[0.07] px-4 py-6 md:mt-18 md:items-center md:gap-8 md:px-16 md:py-16" data-v-841fb8bb><div class="flex-1" data-v-841fb8bb><h3 class="text-title-sm leading-none text-paper md:text-title-lg" data-v-841fb8bb>${ssrInterpolate(__props.section.content)}</h3><p class="mt-3 text-label-md leading-none text-neutral-200 md:mt-2 md:text-body-lg md:text-neutral-100" data-v-841fb8bb>${ssrInterpolate(__props.section.description)}</p></div>`);
      if (__props.section.primaryCta) {
        _push(`<a${ssrRenderAttr("href", __props.section.primaryCta.url)} class="group inline-flex min-h-11 shrink-0 items-center justify-center gap-1 rounded-sm border border-paper px-3 py-3 text-body-md text-paper transition-colors hover:border-gold hover:bg-gold hover:text-white md:min-h-14 md:px-8 md:py-4 md:text-title-md" data-v-841fb8bb>${ssrInterpolate(__props.section.primaryCta.label)} `);
        _push(ssrRenderComponent(_sfc_main$7, {
          name: __props.section.primaryCta.icon,
          "hover-name": __props.section.primaryCta.hoverIcon
        }, null, _parent));
        _push(`</a>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div></section>`);
    };
  }
});
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Sections/PackagesSection.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const PackagesSection = /* @__PURE__ */ _export_sfc(_sfc_main$3, [["__scopeId", "data-v-841fb8bb"]]);
const _sfc_main$2 = /* @__PURE__ */ defineComponent({
  __name: "ProcessSection",
  __ssrInlineRender: true,
  props: {
    section: {}
  },
  setup(__props) {
    const singleAssetIcons = {
      discovery: "/icons/sahra/process/discovery.svg",
      strategy: "/icons/sahra/process/strategy.svg",
      production: "/icons/sahra/process/setting.svg",
      approval: "/icons/sahra/process/approval.svg",
      publishing: "/icons/sahra/process/publishing.svg",
      optimization: "/icons/sahra/process/optimization.svg"
    };
    const iconKeys = [
      "discovery",
      "strategy",
      "production",
      "approval",
      "publishing",
      "optimization"
    ];
    const iconKey = (item, index) => item.icon && iconKeys.includes(item.icon) ? item.icon : iconKeys[index];
    const isUploadedIcon = (icon) => Boolean(icon && (icon.startsWith("/") || /^https?:\/\//.test(icon)));
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({ class: "h-[959px] bg-paper py-14 md:h-auto md:py-24 lg:py-28" }, _attrs))}><div class="container-sahra"><div class="flex flex-col gap-8 md:gap-12"><div class="eyebrow mb-0">${ssrInterpolate(__props.section.eyebrow)}</div><div class="grid gap-6 md:grid-cols-[minmax(0,505px)_minmax(0,612px)] md:justify-between"><h2 class="max-w-[505px] text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-md">${ssrInterpolate(__props.section.title)}</h2><p class="max-w-[612px] text-[16px] leading-normal text-neutral-700 md:text-title-sm">${ssrInterpolate(__props.section.subtitle)}</p></div></div><div class="mt-9 flex flex-col md:mt-16 md:grid md:grid-cols-2 md:gap-x-6 md:gap-y-12 lg:mt-24 lg:grid-cols-3"><!--[-->`);
      ssrRenderList(__props.section.items, (item, index) => {
        _push(`<article class="group flex min-h-[97px] min-w-0 items-center gap-6 border-b border-gold-300 px-2 py-6 md:min-h-0 md:flex-col md:items-start md:gap-8 md:border-0 md:bg-transparent md:p-4"><span class="latin-nums shrink-0 text-[24px] font-semibold leading-none text-gold-700 md:border-b md:border-gold md:pb-1 md:text-[36px] md:font-medium">${ssrInterpolate(item.value)}</span><div class="flex min-w-0 flex-1 flex-col items-start gap-1 md:w-full md:gap-[11px]"><div class="flex min-w-0 items-center gap-1"><span class="relative hidden size-10 shrink-0 items-center justify-center rounded-round p-1 drop-shadow-[1px_1px_5px_rgba(0,0,0,0.08)] md:flex">`);
        if (isUploadedIcon(item.icon)) {
          _push(ssrRenderComponent(_sfc_main$8, {
            name: item.icon,
            "hover-name": item.hoverIcon,
            class: "size-9"
          }, null, _parent));
        } else if (singleAssetIcons[iconKey(item, index)]) {
          _push(`<img${ssrRenderAttr("src", singleAssetIcons[iconKey(item, index)])} alt="" class="size-9 object-contain" width="36" height="36">`);
        } else {
          _push(`<!---->`);
        }
        _push(`</span><h3 class="min-w-0 text-[16px] font-medium leading-normal text-neutral-900 md:text-title-lg">${ssrInterpolate(item.title)}</h3></div><p class="text-[12px] leading-normal text-neutral-700 md:text-body-lg">${ssrInterpolate(item.description)}</p></div></article>`);
      });
      _push(`<!--]--></div></div></section>`);
    };
  }
});
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Sections/ProcessSection.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "ProjectsShowcase",
  __ssrInlineRender: true,
  props: {
    section: {},
    projects: {}
  },
  setup(__props) {
    const { t } = useTranslations();
    const props = __props;
    const activeIndex = ref(0);
    const mobileActiveIndex = ref(0);
    const isPaused = ref(false);
    const isVisible = ref(false);
    const supportsHover = ref(false);
    const sectionRoot = ref(null);
    ref(null);
    let rotationTimer = null;
    let observer = null;
    let mobileMedia = null;
    const activeProject = computed(() => props.projects[activeIndex.value] ?? null);
    const mobileProjects = computed(() => props.projects.slice(0, 4));
    const mobileActiveProject = computed(
      () => mobileProjects.value[mobileActiveIndex.value] ?? null
    );
    const canRotate = computed(() => props.projects.length > 1);
    function stopRotation() {
      if (rotationTimer === null) return;
      window.clearInterval(rotationTimer);
      rotationTimer = null;
    }
    function startRotation() {
      stopRotation();
      if (!canRotate.value || isPaused.value || !isVisible.value || document.hidden || window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        return;
      }
      rotationTimer = window.setInterval(() => {
        if ((mobileMedia == null ? void 0 : mobileMedia.matches) && mobileProjects.value.length > 1) {
          mobileActiveIndex.value = (mobileActiveIndex.value + 1) % mobileProjects.value.length;
          return;
        }
        activeIndex.value = (activeIndex.value + 1) % props.projects.length;
      }, 5500);
    }
    function handleVisibilityChange() {
      startRotation();
    }
    watch([isPaused, isVisible, () => props.projects.length], startRotation);
    watch(
      () => props.projects.length,
      (length) => {
        if (activeIndex.value >= length) activeIndex.value = 0;
        if (mobileActiveIndex.value >= mobileProjects.value.length) {
          mobileActiveIndex.value = 0;
        }
      }
    );
    onMounted(() => {
      mobileMedia = window.matchMedia("(max-width: 1023px)");
      mobileMedia.addEventListener("change", startRotation);
      supportsHover.value = window.matchMedia(
        "(hover: hover) and (pointer: fine)"
      ).matches;
      observer = new IntersectionObserver(
        ([entry]) => {
          isVisible.value = (entry == null ? void 0 : entry.isIntersecting) ?? false;
        },
        // The section is taller than a phone viewport, so a high threshold could
        // never be met on mobile and the rotation would never start.
        { threshold: 0.15 }
      );
      if (sectionRoot.value) observer.observe(sectionRoot.value);
      document.addEventListener("visibilitychange", handleVisibilityChange);
    });
    onBeforeUnmount(() => {
      stopRotation();
      observer == null ? void 0 : observer.disconnect();
      mobileMedia == null ? void 0 : mobileMedia.removeEventListener("change", startRotation);
      document.removeEventListener("visibilitychange", handleVisibilityChange);
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({
        ref_key: "sectionRoot",
        ref: sectionRoot,
        class: "overflow-hidden py-14 md:py-24 lg:py-28",
        "aria-labelledby": "projects-showcase-title"
      }, _attrs))} data-v-76c3530f><div class="container-sahra" data-v-76c3530f><div class="flex flex-col gap-20 lg:gap-24" data-v-76c3530f><header class="flex flex-col gap-8 lg:gap-12" data-v-76c3530f><div class="inline-flex w-fit items-center gap-1 font-display text-[16px] leading-none text-gold md:text-[24px]" data-v-76c3530f><span class="size-2 rotate-45 rounded-round bg-gold shadow-[-2px_-2px_12px_rgba(189,147,59,0.5),2px_2px_12px_rgba(189,147,59,0.5)]" aria-hidden="true" data-v-76c3530f></span><span data-v-76c3530f>${ssrInterpolate(__props.section.eyebrow)}</span></div><div class="grid items-start gap-6 lg:grid-cols-2 lg:justify-between xl:grid-cols-[506px_612px] xl:gap-0" data-v-76c3530f><h2 id="projects-showcase-title" class="max-w-[506px] text-[26px] font-semibold leading-normal text-neutral-900 lg:text-[40px]" data-v-76c3530f>${ssrInterpolate(__props.section.title)}</h2>`);
      if (__props.section.subtitle) {
        _push(`<p class="max-w-[612px] text-[16px] font-medium leading-[1.5] text-neutral-700 lg:text-[18px]" data-v-76c3530f>${ssrInterpolate(__props.section.subtitle)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></header>`);
      if (mobileProjects.value.length) {
        _push(`<div class="project-mobile-carousel flex touch-pan-y select-none flex-col items-center gap-6 lg:hidden" role="region" aria-roledescription="carousel"${ssrRenderAttr("aria-label", unref(t)("common.projects"))} data-v-76c3530f>`);
        if (mobileActiveProject.value) {
          _push(`<article class="flex w-full flex-col gap-6" aria-live="polite" data-v-76c3530f><div class="flex flex-col gap-2" data-v-76c3530f><div class="flex items-center justify-between gap-4" data-v-76c3530f><h3 class="truncate text-[24px] font-medium leading-none text-neutral-900" data-v-76c3530f>${ssrInterpolate(mobileActiveProject.value.title)}</h3><a${ssrRenderAttr("href", mobileActiveProject.value.url)} class="inline-flex shrink-0 items-center gap-1 text-[14px] font-medium leading-none text-neutral-900" data-v-76c3530f>${ssrInterpolate(unref(t)("work.view_case_study"))} `);
          _push(ssrRenderComponent(unref(ArrowUpRight), {
            class: "size-4 rtl:-scale-x-100",
            "stroke-width": 1.5
          }, null, _parent));
          _push(`</a></div><div class="flex flex-col gap-3" data-v-76c3530f><span class="flex items-center gap-2 text-[12px] font-medium leading-none text-neutral-500" data-v-76c3530f>`);
          _push(ssrRenderComponent(unref(Building2), {
            class: "size-4 text-gold",
            "stroke-width": 1.5
          }, null, _parent));
          _push(` ${ssrInterpolate(mobileActiveProject.value.industry)}</span><p class="text-[14px] font-normal leading-normal text-neutral-800" data-v-76c3530f>${ssrInterpolate(mobileActiveProject.value.excerpt)}</p></div></div><a${ssrRenderAttr("href", mobileActiveProject.value.url)} class="aspect-[362/453] w-full overflow-hidden rounded-lg bg-neutral-50" draggable="false" data-v-76c3530f>`);
          if (mobileActiveProject.value.image) {
            _push(`<img${ssrRenderAttr("src", mobileActiveProject.value.image.src)}${ssrRenderAttr("srcset", mobileActiveProject.value.image.srcset)}${ssrRenderAttr("alt", mobileActiveProject.value.image.alt)} class="size-full object-cover"${ssrRenderAttr("width", mobileActiveProject.value.image.width)}${ssrRenderAttr("height", mobileActiveProject.value.image.height)} draggable="false" data-v-76c3530f>`);
          } else {
            _push(`<!---->`);
          }
          _push(`</a></article>`);
        } else {
          _push(`<!---->`);
        }
        _push(`<div class="flex min-h-6 items-center justify-center gap-2" role="group"${ssrRenderAttr("aria-label", unref(t)("common.pagination"))} data-v-76c3530f><!--[-->`);
        ssrRenderList(mobileProjects.value, (project, index) => {
          _push(`<button type="button" class="${ssrRenderClass([mobileActiveIndex.value === index ? "w-5 bg-gold" : "w-[10px] bg-neutral-300", "h-[10px] rounded-round transition-[width,background-color] duration-300 ease-out"])}"${ssrRenderAttr("aria-label", `${index + 1}: ${project.title}`)}${ssrRenderAttr("aria-current", mobileActiveIndex.value === index ? "true" : void 0)} data-v-76c3530f></button>`);
        });
        _push(`<!--]--></div></div>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.projects.length) {
        _push(`<div class="hidden items-center gap-4 lg:grid lg:grid-cols-[minmax(0,612px)_minmax(0,530px)] lg:justify-between lg:gap-10 xl:grid-cols-[612px_530px] xl:gap-0" data-v-76c3530f><div class="order-1 flex min-w-0 flex-col lg:order-1" role="tablist"${ssrRenderAttr("aria-label", unref(t)("common.projects"))} data-v-76c3530f><!--[-->`);
        ssrRenderList(__props.projects, (project, index) => {
          _push(`<article class="${ssrRenderClass([{ "is-active": activeIndex.value === index }, "project-slide-row"])}" data-v-76c3530f><div class="group py-4 lg:py-6" data-v-76c3530f><span class="flex items-center justify-between gap-4" data-v-76c3530f><button class="min-w-0 text-start" type="button" role="tab"${ssrRenderAttr("id", `project-tab-${index}`)}${ssrRenderAttr("aria-selected", activeIndex.value === index)} aria-controls="project-panel"${ssrRenderAttr("tabindex", activeIndex.value === index ? 0 : -1)} data-v-76c3530f><span class="project-slide-title min-w-0 text-[26px] font-normal leading-[1.5] text-neutral-500 transition-[color,font-size] duration-500 ease-brand lg:text-[32px]" data-v-76c3530f>${ssrInterpolate(project.title)}</span></button>`);
          if (activeIndex.value === index) {
            _push(`<a${ssrRenderAttr("href", project.url)} class="hidden shrink-0 items-center gap-2 text-body-lg font-medium text-neutral-900 hover:text-gold sm:flex" data-v-76c3530f>${ssrInterpolate(unref(t)("work.view_case_study"))} `);
            _push(ssrRenderComponent(unref(ArrowUpRight), {
              class: "size-5 rtl:-scale-x-100",
              "stroke-width": 1.5
            }, null, _parent));
            _push(`</a>`);
          } else {
            _push(`<!---->`);
          }
          _push(`</span><button class="block w-full text-start" type="button"${ssrRenderAttr("tabindex", activeIndex.value === index ? 0 : -1)} data-v-76c3530f><span class="project-slide-details grid text-start"${ssrRenderAttr("aria-hidden", activeIndex.value !== index)} data-v-76c3530f><span class="min-h-0 overflow-hidden" data-v-76c3530f><span class="mt-4 flex items-center gap-2 text-label-lg text-neutral-500" data-v-76c3530f>`);
          _push(ssrRenderComponent(unref(Building2), {
            class: "size-5 text-gold",
            "stroke-width": 1.5
          }, null, _parent));
          _push(` ${ssrInterpolate(project.industry)}</span><span class="mt-4 block max-w-[600px] text-body-lg text-neutral-800" data-v-76c3530f>${ssrInterpolate(project.excerpt)}</span></span></span></button>`);
          if (activeIndex.value === index) {
            _push(`<a${ssrRenderAttr("href", project.url)} class="mt-4 inline-flex items-center gap-2 text-body-lg font-medium text-neutral-900 sm:hidden" data-v-76c3530f>${ssrInterpolate(unref(t)("work.view_case_study"))} `);
            _push(ssrRenderComponent(unref(ArrowUpRight), {
              class: "size-5 rtl:-scale-x-100",
              "stroke-width": 1.5
            }, null, _parent));
            _push(`</a>`);
          } else {
            _push(`<!---->`);
          }
          _push(`</div><div class="project-slide-rule" aria-hidden="true" data-v-76c3530f><span data-v-76c3530f></span></div></article>`);
        });
        _push(`<!--]--></div><div class="order-2 flex min-w-0 flex-col gap-6 lg:order-2" data-v-76c3530f><div class="aspect-[362/453] w-full overflow-hidden rounded-lg bg-neutral-50 lg:aspect-[530/663]" data-v-76c3530f>`);
        if (activeProject.value) {
          _push(`<a id="project-panel"${ssrRenderAttr("href", activeProject.value.url)} role="tabpanel"${ssrRenderAttr("aria-labelledby", `project-tab-${activeIndex.value}`)} class="block size-full" data-v-76c3530f>`);
          if (activeProject.value.image) {
            _push(`<img${ssrRenderAttr("src", activeProject.value.image.src)}${ssrRenderAttr("srcset", activeProject.value.image.srcset)}${ssrRenderAttr("alt", activeProject.value.image.alt)} class="size-full object-cover"${ssrRenderAttr("width", activeProject.value.image.width)}${ssrRenderAttr("height", activeProject.value.image.height)} data-v-76c3530f>`);
          } else {
            _push(`<!---->`);
          }
          _push(`</a>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div>`);
        if (__props.projects.length > 1) {
          _push(`<div class="flex min-h-6 items-center justify-center gap-2" role="group"${ssrRenderAttr("aria-label", unref(t)("common.pagination"))} data-v-76c3530f><!--[-->`);
          ssrRenderList(__props.projects, (project, index) => {
            _push(`<button type="button" class="${ssrRenderClass([activeIndex.value === index ? "w-5 bg-gold hover:bg-gold" : "w-[10px] bg-neutral-300 hover:bg-neutral-400", "h-[10px] rounded-round transition-[width,background-color] duration-300 ease-out"])}"${ssrRenderAttr("aria-label", `${index + 1}: ${project.title}`)}${ssrRenderAttr("aria-current", activeIndex.value === index ? "true" : void 0)} data-v-76c3530f></button>`);
          });
          _push(`<!--]--></div>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div></section>`);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Sections/ProjectsShowcase.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const ProjectsShowcase = /* @__PURE__ */ _export_sfc(_sfc_main$1, [["__scopeId", "data-v-76c3530f"]]);
const heroCtaSolid = "flex items-center gap-1 whitespace-nowrap rounded-sm bg-ink px-4 py-[10px] text-[13px] font-medium text-paper transition-colors hover:bg-gold hover:text-white md:px-8 md:py-4 md:text-title-md";
const heroCtaOutline = "flex items-center gap-1 whitespace-nowrap rounded-sm border border-ink bg-paper px-4 py-[9px] text-[13px] font-medium text-ink transition-colors hover:border-gold hover:text-gold md:px-8 md:py-[15px] md:text-title-md";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Home",
  __ssrInlineRender: true,
  props: {
    sections: {},
    services: {},
    projects: {},
    clients: {},
    testimonials: {},
    posts: {},
    faqs: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const hero = computed(() => props.sections.hero);
    const isUploadedIcon = (icon) => Boolean(icon && (icon.startsWith("/") || /^https?:\/\//.test(icon)));
    const heroImage = computed(() => {
      var _a;
      return ((_a = hero.value) == null ? void 0 : _a.image) ?? null;
    });
    const kpi = computed(() => props.sections.kpi);
    const process = computed(() => props.sections.process);
    const packages = computed(() => props.sections.packages);
    const whyUs = computed(() => props.sections.why_us);
    const reviews = computed(() => props.sections.reviews);
    const insights = computed(() => props.sections.insights);
    const faqSection = computed(() => props.sections.faq);
    const faqSubtitle = computed(
      () => {
        var _a;
        return ((_a = faqSection.value) == null ? void 0 : _a.subtitle) || {
          en: "Because every creative decision is built around brand clarity, consistency, and growth.",
          fa: "چون هر تصمیم خلاقانه بر شفافیت، انسجام و رشد برند استوار است.",
          ar: "لأن كل قرار إبداعي يقوم على وضوح العلامة واتساقها ونموها."
        }[page.props.locale.current];
      }
    );
    const insightsSubtitle = computed(() => {
      var _a, _b;
      if (((_a = insights.value) == null ? void 0 : _a.description) || ((_b = insights.value) == null ? void 0 : _b.subtitle)) {
        return insights.value.description || insights.value.subtitle;
      }
      return {
        en: "Because every creative decision is built around brand clarity, consistency, and growth.",
        fa: "چون هر تصمیم خلاقانه بر شفافیت، انسجام و رشد برند استوار است.",
        ar: "لأن كل قرار إبداعي يقوم على وضوح العلامة واتساقها ونموها."
      }[page.props.locale.current];
    });
    const testimonialTrack = computed(() => {
      const source = props.testimonials;
      if (source.length === 0) return [];
      const perHalf = Math.max(1, Math.ceil(2560 / 354 / source.length));
      const half = Array.from({ length: perHalf }, () => source).flat();
      return [...half, ...half];
    });
    const testimonialRail = ref(null);
    const activeTestimonial = ref(0);
    let testimonialTimer;
    let testimonialPausedUntil = 0;
    let testimonialDirection = 1;
    function railStep(rail) {
      const [a, b] = rail.children;
      return b ? Math.abs(b.offsetLeft - a.offsetLeft) : rail.clientWidth;
    }
    function goToTestimonial(index) {
      const rail = testimonialRail.value;
      if (!rail) return;
      const dir = getComputedStyle(rail).direction === "rtl" ? -1 : 1;
      rail.scrollTo({ left: dir * index * railStep(rail), behavior: "smooth" });
    }
    onMounted(() => {
      if (props.testimonials.length < 2) return;
      if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
      testimonialTimer = setInterval(() => {
        const rail = testimonialRail.value;
        if (!rail || rail.offsetParent === null || Date.now() < testimonialPausedUntil) return;
        const next = activeTestimonial.value + testimonialDirection;
        if (next >= props.testimonials.length || next < 0) {
          testimonialDirection *= -1;
          goToTestimonial(activeTestimonial.value + testimonialDirection);
          return;
        }
        goToTestimonial(next);
      }, 5e3);
    });
    onBeforeUnmount(() => clearInterval(testimonialTimer));
    const heroCtas = computed(() => {
      var _a, _b;
      const primary = ((_a = hero.value) == null ? void 0 : _a.primaryCta) ?? null;
      const secondary = ((_b = hero.value) == null ? void 0 : _b.secondaryCta) ?? null;
      const ordered = [primary, secondary];
      return ordered.filter(
        (cta) => cta !== null
      );
    });
    const whyUsIcons = [BadgeCheck, Copy, Gem, ClipboardCheck];
    const kpiIcons = [ChartNoAxesCombined, TrendingUp, UsersRound];
    const heroStack = ref(null);
    useHeroStagger(heroStack);
    useCounters();
    useSectionReveal();
    return (_ctx, _push, _parent, _attrs) => {
      var _a, _b, _c;
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$9, { meta: __props.seo }, null, _parent));
      if (hero.value) {
        _push(`<section class="relative min-h-[765px] overflow-hidden md:min-h-[904px]">`);
        if (heroImage.value) {
          _push(`<img${ssrRenderAttr("src", heroImage.value.src)}${ssrRenderAttr("alt", heroImage.value.alt)}${ssrRenderAttr("width", heroImage.value.width)}${ssrRenderAttr("height", heroImage.value.height)} class="absolute inset-0 size-full object-cover">`);
        } else {
          _push(`<div class="absolute inset-0 bg-[url(&#39;/images/sahra/hero-brand-preview-mobile.webp&#39;)] bg-[length:100%_100%] bg-center bg-no-repeat md:bg-[url(&#39;/images/sahra/hero-brand-preview.png&#39;)] rtl:-scale-x-100" aria-hidden="true"></div>`);
        }
        _push(`<div class="mx-auto w-full max-w-frame"><div class="relative z-10 flex w-[731px] max-w-full flex-col gap-12 px-5 pb-10 pt-36 md:ms-24 md:max-w-[calc(100%-3rem)] md:gap-14 md:px-0 md:pb-0 md:pt-[176px]"><div class="flex w-fit items-center gap-2 rounded-round bg-gold-100 p-2"><span class="inline-block size-2 rotate-45 bg-gold-700" aria-hidden="true"></span><span class="text-label-md text-neutral-800" style="${ssrRenderStyle({ color: hero.value.colors.eyebrow || void 0 })}">${ssrInterpolate(hero.value.eyebrow)}</span></div><div class="flex flex-col gap-8 md:gap-12"><h1 class="text-[28px] font-medium leading-normal tracking-[-0.02em] text-neutral-900 md:text-[48px] md:leading-[80px] md:tracking-[-0.05em]" style="${ssrRenderStyle({ color: hero.value.colors.title || void 0 })}"><span class="block text-[28px] md:text-[56px]">${ssrInterpolate(hero.value.title)}</span><span class="block w-fit font-display text-[36px] leading-normal tracking-normal md:text-[96px] md:leading-[80px]" style="${ssrRenderStyle({
          color: hero.value.colors.content || "var(--primary-gold, #BD933B)"
        })}">${ssrInterpolate(hero.value.content)}</span><span class="block text-[28px] md:text-[56px]">${ssrInterpolate(hero.value.description)}</span></h1><p class="w-full max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-[18px]" style="${ssrRenderStyle({ color: hero.value.colors.subtitle || void 0 })}">${ssrInterpolate(hero.value.subtitle)}</p></div><div class="flex flex-wrap items-center gap-2 md:gap-[10px]"><!--[-->`);
        ssrRenderList(heroCtas.value, (cta, i) => {
          _push(`<a${ssrRenderAttr("href", cta.url)} class="${ssrRenderClass([i === 0 ? heroCtaSolid : heroCtaOutline, "group"])}">${ssrInterpolate(cta.label)} `);
          _push(ssrRenderComponent(_sfc_main$7, {
            name: cta.icon,
            "hover-name": cta.hoverIcon
          }, null, _parent));
          _push(`</a>`);
        });
        _push(`<!--]--></div></div></div></section>`);
      } else {
        _push(`<!---->`);
      }
      if (kpi.value) {
        _push(`<section class="relative z-20 -mt-[117px] py-0 md:mt-0 md:py-24 lg:-mt-[54px] lg:py-28 lg:pt-0"><div class="container-sahra grid grid-cols-3 gap-2 text-center md:container-narrow md:gap-4" data-reveal-group><!--[-->`);
        ssrRenderList(kpi.value.items, (item, i) => {
          _push(`<div class="group edge-gold will-reveal flex h-[77px] flex-col items-center justify-center gap-2 rounded-[4px] px-3 py-3 md:h-auto md:px-3 md:py-6" data-reveal><div class="flex items-center justify-center gap-1 md:gap-4">`);
          if (isUploadedIcon(item.icon)) {
            _push(ssrRenderComponent(_sfc_main$8, {
              name: item.icon,
              "hover-name": item.hoverIcon,
              class: "size-4 md:size-8"
            }, null, _parent));
          } else {
            ssrRenderVNode(_push, createVNode(resolveDynamicComponent(kpiIcons[i] || unref(TrendingUp)), {
              class: "size-4 text-gold md:size-8",
              "stroke-width": 1.5
            }, null), _parent);
          }
          _push(`<p class="latin-nums text-[18px] font-medium leading-none text-ink md:text-[32px]" data-counter>${ssrInterpolate(item.value)}</p></div><div class="flex flex-col items-center gap-1"><p class="whitespace-nowrap text-[12px] font-medium leading-normal text-gold md:text-title-sm">${ssrInterpolate(item.title)}</p><p class="hidden text-body-md text-neutral-700 md:block">${ssrInterpolate(item.description)}</p></div></div>`);
        });
        _push(`<!--]--></div></section>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<section class="section pb-[92px] pt-[88px] md:pb-24 md:pt-0 lg:mt-[19px] lg:pb-28"><div class="container-narrow flex flex-col gap-8"><h2 class="text-center text-[16px] font-medium leading-normal text-neutral-600 md:text-[22px]">${ssrInterpolate((_a = __props.sections.trust_proof) == null ? void 0 : _a.title)} <span class="text-[20px] leading-normal text-neutral-900 md:text-[28px]">${ssrInterpolate((_b = __props.sections.trust_proof) == null ? void 0 : _b.content)}</span> ${ssrInterpolate((_c = __props.sections.trust_proof) == null ? void 0 : _c.subtitle)}</h2><div class="marquee-mask overflow-hidden"><div class="marquee-track items-center gap-12" style="${ssrRenderStyle({ "--marquee-duration": "28s" })}"><!--[-->`);
      ssrRenderList(2, (copy) => {
        _push(`<!--[--><!--[-->`);
        ssrRenderList(__props.clients, (client, i) => {
          _push(`<span class="group flex size-32 shrink-0 items-center justify-center"${ssrRenderAttr("aria-hidden", copy === 2 ? "true" : void 0)}><img${ssrRenderAttr("src", client.logo)}${ssrRenderAttr("alt", copy === 2 ? "" : client.name)} class="size-full object-contain p-2 grayscale transition-[filter] duration-300 ease-out group-hover:grayscale-0 group-focus-within:grayscale-0"></span>`);
        });
        _push(`<!--]--><!--]-->`);
      });
      _push(`<!--]--></div></div></div></section>`);
      if (__props.sections.services_cloud) {
        _push(ssrRenderComponent(ServicesOrbit, {
          class: "lg:mt-[23px]",
          section: __props.sections.services_cloud,
          services: __props.services
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (__props.sections.lead_magnet) {
        _push(ssrRenderComponent(_sfc_main$a, {
          class: "lg:mt-[48px]",
          section: __props.sections.lead_magnet,
          "mobile-offcanvas": ""
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (__props.sections.projects_showcase) {
        _push(ssrRenderComponent(ProjectsShowcase, {
          class: "max-md:min-h-[971px] lg:-mt-[64px]",
          section: __props.sections.projects_showcase,
          projects: __props.projects
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (process.value) {
        _push(ssrRenderComponent(_sfc_main$2, {
          class: "max-md:!h-[944px] lg:mt-[7px]",
          section: process.value
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (packages.value) {
        _push(ssrRenderComponent(PackagesSection, {
          class: "max-md:mt-[80px] lg:mt-[126px]",
          section: packages.value
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (whyUs.value) {
        _push(`<section class="py-14 md:py-24 lg:mt-[92px] lg:py-28"><div class="container-sahra"><div class="eyebrow" style="${ssrRenderStyle({ color: whyUs.value.colors.eyebrow || void 0 })}">${ssrInterpolate(whyUs.value.eyebrow)}</div><div class="mt-6 grid gap-12 lg:mt-8 lg:grid-cols-[506px_1fr] lg:items-center lg:justify-between lg:gap-8"><div class="flex flex-col gap-6 md:gap-10"><h2 class="text-[26px] font-semibold leading-normal md:text-display-md" style="${ssrRenderStyle({ color: whyUs.value.colors.title || void 0 })}">${ssrInterpolate(whyUs.value.title)}</h2><p class="text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm" style="${ssrRenderStyle({ color: whyUs.value.colors.subtitle || void 0 })}">${ssrInterpolate(whyUs.value.subtitle)}</p></div><div class="grid grid-cols-1 gap-6 md:grid-cols-2 md:gap-x-10 md:gap-y-12" data-reveal-group><!--[-->`);
        ssrRenderList(whyUs.value.items, (item, i) => {
          _push(`<div class="group will-reveal flex min-h-[140px] flex-col items-start gap-3 rounded-sm border border-gold-200 bg-gold-100 p-6 shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:gap-4 md:p-8" data-reveal>`);
          if (isUploadedIcon(item.icon)) {
            _push(ssrRenderComponent(_sfc_main$8, {
              name: item.icon,
              "hover-name": item.hoverIcon,
              class: "size-6 md:size-8"
            }, null, _parent));
          } else if (item.title.trim().toLocaleLowerCase() === "end-to-end support") {
            _push(`<svg class="size-6 md:size-8" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1 1V6.33333C1 7.04058 1.28095 7.71885 1.78105 8.21895C2.28115 8.71905 2.95942 9 3.66667 9H9" stroke="#BD933B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>`);
          } else {
            ssrRenderVNode(_push, createVNode(resolveDynamicComponent(whyUsIcons[i] || unref(BadgeCheck)), {
              class: "size-6 text-gold md:size-8",
              "stroke-width": 1.5
            }, null), _parent);
          }
          _push(`<div class="flex flex-col gap-2"><h3 class="text-[16px] font-medium text-neutral-900 md:text-title-md">${ssrInterpolate(item.title)}</h3><p class="max-w-[212px] text-[12px] leading-normal text-neutral-600 md:text-body-lg">${ssrInterpolate(item.description)}</p></div></div>`);
        });
        _push(`<!--]--></div></div></div></section>`);
      } else {
        _push(`<!---->`);
      }
      if (reviews.value) {
        _push(`<section class="h-auto overflow-visible py-14 md:h-auto md:py-24 lg:-mt-[100px] lg:py-28"><div class="container-sahra"><div class="eyebrow" style="${ssrRenderStyle({ color: reviews.value.colors.eyebrow || void 0 })}">${ssrInterpolate(reviews.value.eyebrow)}</div><div class="mt-8 grid items-start gap-6 md:mt-12 lg:grid-cols-[505px_1fr] lg:gap-[132px]"><h2 class="text-[26px] font-semibold leading-normal md:text-display-md" style="${ssrRenderStyle({ color: reviews.value.colors.title || void 0 })}">${ssrInterpolate(reviews.value.title)}</h2>`);
        if (reviews.value.subtitle) {
          _push(`<p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm" style="${ssrRenderStyle({ color: reviews.value.colors.subtitle || void 0 })}">${ssrInterpolate(reviews.value.subtitle)}</p>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div><div class="container-sahra mt-10 md:mt-10"><div class="marquee-mask hidden h-[246px] overflow-hidden md:block md:h-[297px]"><div class="marquee-track h-full items-center gap-[26px]" style="${ssrRenderStyle({ "--marquee-duration": "40s" })}"><!--[-->`);
        ssrRenderList(testimonialTrack.value, (t, i) => {
          _push(`<div class="testimonial-card flex h-[220px] w-[328px] shrink-0 flex-col rounded-sm border-[0.5px] p-5 shadow-testimonial md:h-[246px] md:p-6"${ssrRenderAttr("aria-hidden", i >= __props.testimonials.length ? "true" : void 0)}><p class="text-body-md leading-normal text-neutral-800">${ssrInterpolate(t.quote)}</p><div class="mt-auto flex items-center gap-2">`);
          if (t.avatar) {
            _push(`<img${ssrRenderAttr("src", t.avatar.src)}${ssrRenderAttr("alt", t.avatar.alt)} class="size-12 rounded-full object-cover">`);
          } else {
            _push(`<!---->`);
          }
          _push(`<div><p class="text-label-lg text-neutral-700">${ssrInterpolate(t.name)}</p><p class="mt-1 text-label-md text-neutral-600">${ssrInterpolate(t.role)}</p></div></div></div>`);
        });
        _push(`<!--]--></div></div>`);
        if (__props.testimonials.length) {
          _push(`<div class="md:hidden"><div class="testimonial-rail -mx-5 flex snap-x snap-mandatory gap-4 overflow-x-auto px-5 py-2"><!--[-->`);
          ssrRenderList(__props.testimonials, (t, i) => {
            _push(`<div class="testimonial-card flex h-[246px] w-full shrink-0 snap-center flex-col rounded-sm border-[0.5px] p-6 shadow-testimonial"><p class="text-[14px] leading-normal text-neutral-800">${ssrInterpolate(t.quote)}</p><div class="mt-auto flex items-center gap-2">`);
            if (t.avatar) {
              _push(`<img${ssrRenderAttr("src", t.avatar.src)}${ssrRenderAttr("alt", t.avatar.alt)} class="size-12 rounded-full object-cover">`);
            } else {
              _push(`<!---->`);
            }
            _push(`<div><p class="text-label-lg text-neutral-700">${ssrInterpolate(t.name)}</p><p class="mt-1 text-label-md text-neutral-600">${ssrInterpolate(t.role)}</p></div></div></div>`);
          });
          _push(`<!--]--></div>`);
          if (__props.testimonials.length) {
            _push(`<div class="mt-6 flex h-[10px] items-center justify-center gap-2"><!--[-->`);
            ssrRenderList(__props.testimonials, (_, i) => {
              _push(`<button type="button" class="${ssrRenderClass([i === activeTestimonial.value ? "bg-gold-600" : "bg-neutral-200", "size-[10px] rounded-full transition-colors duration-300"])}"${ssrRenderAttr("aria-label", `${i + 1} / ${__props.testimonials.length}`)}${ssrRenderAttr("aria-current", i === activeTestimonial.value ? "true" : void 0)}></button>`);
            });
            _push(`<!--]--></div>`);
          } else {
            _push(`<!---->`);
          }
          _push(`</div>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></section>`);
      } else {
        _push(`<!---->`);
      }
      if (insights.value) {
        _push(`<section class="h-[1111px] overflow-hidden py-14 md:h-auto md:py-24 lg:-mt-[10px] lg:py-28"><div class="container-sahra flex flex-col gap-10 md:gap-12"><div class="flex flex-col gap-8 md:gap-12"><div class="eyebrow" style="${ssrRenderStyle({ color: insights.value.colors.eyebrow || void 0 })}">${ssrInterpolate(insights.value.eyebrow)}</div><div class="grid items-start gap-8 lg:grid-cols-[505px_1fr] lg:gap-[132px]"><h2 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-md" style="${ssrRenderStyle({ color: insights.value.colors.title || void 0 })}">${ssrInterpolate(insights.value.title)}</h2>`);
        if (insightsSubtitle.value) {
          _push(`<p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm" style="${ssrRenderStyle({
            color: insights.value.colors.description || insights.value.colors.subtitle || void 0
          })}">${ssrInterpolate(insightsSubtitle.value)}</p>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div><div class="grid gap-6 lg:h-[424px] lg:grid-cols-2" data-reveal-group>`);
        if (__props.posts[0]) {
          _push(`<a${ssrRenderAttr("href", __props.posts[0].url)} class="group will-reveal flex min-h-[457px] flex-col gap-6 overflow-hidden rounded-sm bg-[#fbf9f5] p-4 shadow-card md:grid md:h-auto md:min-h-0 md:grid-cols-[279px_270px] md:justify-between md:gap-0" data-reveal><div class="h-[248px] overflow-hidden rounded-sm border border-neutral-100 shadow-card md:h-[392px]">`);
          if (__props.posts[0].image) {
            _push(`<img${ssrRenderAttr("src", __props.posts[0].image.src)}${ssrRenderAttr("alt", __props.posts[0].image.alt)} class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.04]">`);
          } else {
            _push(`<!---->`);
          }
          _push(`</div><div class="flex min-w-0 flex-1 flex-col gap-6 md:justify-between md:gap-0 md:py-0"><div class="flex items-center gap-2 text-[12px] leading-normal text-neutral-700 md:text-body-md">`);
          _push(ssrRenderComponent(unref(CalendarDays), {
            class: "size-4 text-gold md:size-6",
            "stroke-width": 1.5
          }, null, _parent));
          _push(`<span>${ssrInterpolate(__props.posts[0].publishedAt)}</span></div><h3 class="text-[16px] font-semibold leading-normal text-gold md:text-title-md">${ssrInterpolate(__props.posts[0].title)}</h3><p class="text-[13px] leading-normal text-neutral-700 md:text-body-md">${ssrInterpolate(__props.posts[0].excerpt)}</p><span class="ms-auto hidden size-10 items-center justify-center rounded-round border border-neutral-800 bg-ink text-paper transition-colors group-hover:border-transparent group-hover:bg-gold group-hover:text-white md:flex md:size-12">`);
          _push(ssrRenderComponent(unref(ArrowUpRight), {
            class: "size-8 rtl:-scale-x-100",
            "stroke-width": 1.25
          }, null, _parent));
          _push(`</span></div></a>`);
        } else {
          _push(`<!---->`);
        }
        _push(`<div class="will-reveal flex flex-col gap-3 md:gap-6" data-reveal><!--[-->`);
        ssrRenderList(__props.posts.slice(1, 3), (post, index) => {
          _push(`<a${ssrRenderAttr("href", post.url)} class="${ssrRenderClass([index === 0 ? "border-b border-neutral-200 pb-6" : "", "group grid h-[120px] grid-cols-[120px_1fr] gap-4 md:h-auto md:flex-1 md:gap-6 sm:grid-cols-[188px_1fr]"])}"><div class="aspect-square size-[120px] overflow-hidden rounded-sm md:size-[188px]">`);
          if (post.image) {
            _push(`<img${ssrRenderAttr("src", post.image.src)}${ssrRenderAttr("alt", post.image.alt)} class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.04]">`);
          } else {
            _push(`<!---->`);
          }
          _push(`</div><div class="flex flex-col justify-center gap-3 md:gap-6"><div class="flex items-center gap-2 text-[12px] leading-normal text-neutral-700 md:text-body-md">`);
          _push(ssrRenderComponent(unref(CalendarDays), {
            class: "size-4 text-gold md:size-6",
            "stroke-width": 1.5
          }, null, _parent));
          _push(`<span>${ssrInterpolate(post.publishedAt)}</span></div><h3 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-title-md">${ssrInterpolate(post.title)}</h3></div></a>`);
        });
        _push(`<!--]--></div></div></div></section>`);
      } else {
        _push(`<!---->`);
      }
      if (faqSection.value) {
        _push(`<section class="py-14 md:py-24 lg:-mt-[98px] lg:py-28"><div class="container-sahra"><div class="eyebrow" style="${ssrRenderStyle({ color: faqSection.value.colors.eyebrow || void 0 })}">${ssrInterpolate(faqSection.value.eyebrow)}</div><div class="mt-8 grid gap-8 md:mt-12 lg:grid-cols-[497px_1fr]"><div class="flex flex-col justify-between gap-8"><h2 class="text-[26px] font-semibold leading-normal md:text-display-md" style="${ssrRenderStyle({ color: faqSection.value.colors.title || void 0 })}">${ssrInterpolate(faqSection.value.title)}</h2>`);
        if (faqSubtitle.value) {
          _push(`<p class="text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm" style="${ssrRenderStyle({ color: faqSection.value.colors.subtitle || void 0 })}">${ssrInterpolate(faqSubtitle.value)}</p>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div><div class="flex flex-col gap-3 md:gap-6" data-reveal-group><!--[-->`);
        ssrRenderList(__props.faqs, (faq, i) => {
          _push(`<details name="faq-accordion"${ssrIncludeBooleanAttr(i === 1) ? " open" : ""} class="group will-reveal rounded-sm border border-gold-200 bg-gold-100 p-4 md:p-8" data-reveal><summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-[14px] font-medium text-neutral-900 md:text-title-sm [&amp;::-webkit-details-marker]:hidden">${ssrInterpolate(faq.question)} <span class="relative size-6 shrink-0 text-neutral-800">`);
          _push(ssrRenderComponent(unref(CirclePlus), {
            class: "absolute inset-0 size-6 group-open:hidden",
            "stroke-width": 1.5
          }, null, _parent));
          _push(ssrRenderComponent(unref(CircleMinus), {
            class: "absolute inset-0 hidden size-6 group-open:block",
            "stroke-width": 1.5
          }, null, _parent));
          _push(`</span></summary><p class="mt-3 text-[12px] leading-normal text-neutral-700 md:mt-4 md:text-body-lg">${ssrInterpolate(faq.answer)}</p></details>`);
        });
        _push(`<!--]--></div></div></div></section>`);
      } else {
        _push(`<!---->`);
      }
      if (__props.sections.final_cta) {
        _push(ssrRenderComponent(CtaBanner, {
          class: "lg:mb-[61px] lg:mt-[82px]",
          section: __props.sections.final_cta,
          "spacing-class": "pb-[182px] pt-24 md:pb-[260px]"
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Home.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
