import { defineComponent, ref, computed, onBeforeUnmount, mergeProps, unref, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderStyle, ssrInterpolate, ssrRenderComponent, ssrRenderClass, ssrRenderAttr, ssrRenderTeleport, ssrIncludeBooleanAttr } from "vue/server-renderer";
import { u as useTranslations, a as usePage, b as useForm, d as _sfc_main$1 } from "../ssr.js";
import { X, ArrowUpRight, UserRound, Mail } from "lucide-vue-next";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "LeadMagnet",
  __ssrInlineRender: true,
  props: {
    section: {},
    inline: { type: Boolean, default: false },
    mobileOffcanvas: { type: Boolean, default: false }
  },
  setup(__props) {
    const props = __props;
    const { t } = useTranslations();
    const page = usePage();
    const isOpen = ref(false);
    const isComplete = ref(false);
    const deliveryResult = ref({
      downloaded: false,
      emailed: false,
      email_failed: false
    });
    ref(null);
    const form = useForm({
      name: "",
      email: "",
      source: props.inline ? "article" : "home",
      website: ""
    });
    computed(
      () => props.section.submitUrl || `/${page.props.locale.current}/newsletter`
    );
    computed(
      () => {
        var _a;
        return props.section.downloadUrl || ((_a = props.section.primaryCta) == null ? void 0 : _a.url) || "";
      }
    );
    onBeforeUnmount(() => {
      document.body.style.overflow = "";
    });
    return (_ctx, _push, _parent, _attrs) => {
      var _a, _b, _c, _d, _e, _f, _g, _h;
      _push(`<section${ssrRenderAttrs(mergeProps({
        class: [
          __props.inline ? "" : "py-14 md:py-18 lg:py-24",
          __props.mobileOffcanvas ? "max-md:pb-0" : ""
        ]
      }, _attrs))}>`);
      if (__props.mobileOffcanvas) {
        _push(`<div class="container-sahra md:hidden"><div class="relative flex w-full items-end justify-between gap-4 overflow-hidden rounded-sm bg-black px-4 py-6 text-white"><img src="/images/sahra/lead-magnet-large.png" alt="" class="pointer-events-none absolute inset-0 size-full object-cover" aria-hidden="true"><div class="pointer-events-none absolute inset-0 bg-[linear-gradient(90deg,rgba(0,0,0,0)_0%,rgba(0,0,0,1)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))] rtl:bg-[linear-gradient(270deg,rgba(0,0,0,0)_0%,rgba(0,0,0,1)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))]" aria-hidden="true"></div><div class="relative z-10 flex flex-col items-start gap-3"><p class="text-[18px] font-normal leading-normal text-white" style="${ssrRenderStyle({ color: ((_a = __props.section.colors) == null ? void 0 : _a.title) || void 0 })}">${ssrInterpolate(__props.section.title)}</p><p class="text-[12px] font-medium leading-normal text-neutral-200" style="${ssrRenderStyle({ color: ((_b = __props.section.colors) == null ? void 0 : _b.description) || void 0 })}">${ssrInterpolate(__props.section.description)}</p></div>`);
        if (__props.section.primaryCta) {
          _push(`<button type="button" class="group relative z-10 shrink-0 rounded-sm border border-white px-3 py-3 text-[14px] font-normal leading-normal text-white transition-colors duration-300 hover:border-gold hover:bg-gold hover:text-white">${ssrInterpolate(__props.section.primaryCta.label)} `);
          _push(ssrRenderComponent(_sfc_main$1, {
            name: __props.section.primaryCta.icon,
            "hover-name": __props.section.primaryCta.hoverIcon
          }, null, _parent));
          _push(`</button>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="${ssrRenderClass([
        __props.inline ? "" : "container-sahra",
        __props.mobileOffcanvas ? "max-md:hidden" : ""
      ])}"><div class="${ssrRenderClass([
        __props.inline ? "min-h-[123px] rounded-sm p-8 rtl:min-h-[128px]" : "min-h-[193px] rounded-sm px-8 py-10 sm:px-12 lg:p-16 rtl:min-h-[200px]",
        "relative mx-auto w-full max-w-[1101px] overflow-hidden bg-black text-white"
      ])}"><img${ssrRenderAttr(
        "src",
        ((_c = __props.section.image) == null ? void 0 : _c.src) || (__props.inline ? "/images/sahra/lead-magnet-small.png" : "/images/sahra/lead-magnet-large.png")
      )}${ssrRenderAttr("alt", ((_d = __props.section.image) == null ? void 0 : _d.alt) || "")}${ssrRenderAttr("width", __props.inline ? 1536 : 1024)} height="1024" class="${ssrRenderClass([
        ((_e = __props.section.image) == null ? void 0 : _e.src) ? "inset-0 size-full object-cover" : __props.inline ? "left-[-22.52%] top-[-290.02%] h-[606.35%] w-[137.77%]" : "inset-inline-0 bottom-[-90px] h-auto w-[102.73%] object-cover rtl:-scale-x-100 max-lg:inset-0 max-lg:size-full max-lg:object-cover max-lg:object-bottom",
        "pointer-events-none absolute max-w-none"
      ])}"${ssrRenderAttr("aria-hidden", ((_f = __props.section.image) == null ? void 0 : _f.alt) ? void 0 : "true")} decoding="async"><div class="${ssrRenderClass([
        __props.inline ? "bg-black/30" : "bg-[linear-gradient(90deg,rgba(0,0,0,1)_0%,rgba(0,0,0,0)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))] rtl:bg-[linear-gradient(270deg,rgba(0,0,0,1)_0%,rgba(0,0,0,0)_100%),linear-gradient(rgba(35,31,32,.2),rgba(35,31,32,.2))]",
        "pointer-events-none absolute inset-0"
      ])}" aria-hidden="true"></div><div class="${ssrRenderClass([__props.inline ? "min-h-[59px]" : "min-h-[65px] rtl:min-h-[72px]", "relative z-10 flex flex-col items-start justify-between gap-8 md:flex-row md:items-end"])}"><div class="flex flex-col items-start gap-2"><h2 class="${ssrRenderClass([__props.inline ? "text-[20px]" : "text-[20px] md:text-[22px]", "font-medium leading-normal text-white"])}" style="${ssrRenderStyle({ color: ((_g = __props.section.colors) == null ? void 0 : _g.title) || void 0 })}">${ssrInterpolate(__props.section.title)}</h2><p class="${ssrRenderClass([__props.inline ? "text-[14px]" : "text-[16px]", "font-normal leading-normal text-neutral-100"])}" style="${ssrRenderStyle({ color: ((_h = __props.section.colors) == null ? void 0 : _h.description) || void 0 })}">${ssrInterpolate(__props.section.description)}</p></div>`);
      if (__props.section.primaryCta) {
        _push(`<button type="button" class="${ssrRenderClass([__props.inline ? "px-6 py-3 text-[18px]" : "px-8 py-4 text-[20px]", "group inline-flex shrink-0 items-center justify-center rounded-sm border border-white font-normal leading-normal text-white transition-colors duration-300 hover:border-gold hover:text-gold"])}">${ssrInterpolate(__props.section.primaryCta.label)} `);
        _push(ssrRenderComponent(_sfc_main$1, {
          name: __props.section.primaryCta.icon,
          "hover-name": __props.section.primaryCta.hoverIcon
        }, null, _parent));
        _push(`</button>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div></div>`);
      ssrRenderTeleport(_push, (_push2) => {
        var _a2;
        if (isOpen.value) {
          _push2(`<div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 p-5 backdrop-blur-[5px]" role="presentation"><div class="relative flex max-h-[calc(100vh-40px)] w-full max-w-[706px] flex-col items-center overflow-y-auto rounded-lg bg-white p-6 outline-none md:p-12" role="dialog" aria-modal="true"${ssrRenderAttr(
            "aria-labelledby",
            isComplete.value ? "checklist-success-title" : "checklist-title"
          )} tabindex="-1"><button type="button" class="absolute end-4 top-4 rounded-full p-2 text-neutral-700 transition-colors hover:bg-neutral-100"${ssrRenderAttr("aria-label", unref(t)("forms.newsletter.close"))}>`);
          _push2(ssrRenderComponent(unref(X), {
            class: "size-5",
            "aria-hidden": "true"
          }, null, _parent));
          _push2(`</button>`);
          if (isComplete.value) {
            _push2(`<!--[--><img src="/images/sahra/checklist-success.svg" alt="" width="96" height="94" class="mb-12 size-24 object-contain" aria-hidden="true"><h2 id="checklist-success-title" class="max-w-[520px] text-center text-[24px] font-medium leading-normal text-neutral-900">`);
            if (deliveryResult.value.downloaded) {
              _push2(`<!--[-->${ssrInterpolate(unref(t)("forms.newsletter.downloaded"))}<!--]-->`);
            } else {
              _push2(`<!---->`);
            }
            if (deliveryResult.value.downloaded && (deliveryResult.value.emailed || deliveryResult.value.email_failed)) {
              _push2(`<br>`);
            } else {
              _push2(`<!---->`);
            }
            if (deliveryResult.value.emailed) {
              _push2(`<!--[-->${ssrInterpolate(unref(t)("forms.newsletter.emailed"))}<!--]-->`);
            } else if (deliveryResult.value.email_failed) {
              _push2(`<!--[-->${ssrInterpolate(unref(t)("forms.newsletter.email_failed"))}<!--]-->`);
            } else if (!deliveryResult.value.downloaded && !((_a2 = __props.section.delivery) == null ? void 0 : _a2.email)) {
              _push2(`<!--[-->${ssrInterpolate(unref(t)("forms.newsletter.sent"))}<!--]-->`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`</h2><a${ssrRenderAttr("href", `/${unref(page).props.locale.current}/contact`)} class="mt-8 inline-flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-white">${ssrInterpolate(unref(t)("forms.newsletter.consultation"))} `);
            _push2(ssrRenderComponent(unref(ArrowUpRight), {
              class: "size-6 rtl:-scale-x-100",
              "aria-hidden": "true"
            }, null, _parent));
            _push2(`</a><!--]-->`);
          } else {
            _push2(`<!--[--><div class="flex w-full flex-col items-center gap-6 text-center"><h2 id="checklist-title" class="text-[26px] font-medium leading-normal text-neutral-900 md:text-[32px]">${ssrInterpolate(unref(t)("forms.newsletter.title"))}</h2><p class="max-w-[612px] text-[14px] leading-normal text-neutral-700">${ssrInterpolate(unref(t)("forms.newsletter.description"))}</p></div><form class="mt-4 flex w-full max-w-[396px] flex-col gap-6 md:mt-8" novalidate><div class="hidden" aria-hidden="true"><label for="checklist-website">Website</label><input id="checklist-website"${ssrRenderAttr("value", unref(form).website)} tabindex="-1" autocomplete="off"></div><div><label for="checklist-name" class="mb-2 block text-[14px] font-medium text-neutral-800">${ssrInterpolate(unref(t)("forms.newsletter.name"))}</label><div class="flex items-center gap-2 rounded-sm border border-gold-300 bg-white/80 p-3 focus-within:border-ink">`);
            _push2(ssrRenderComponent(unref(UserRound), {
              class: "size-6 shrink-0 text-neutral-600",
              "stroke-width": 1.5,
              "aria-hidden": "true"
            }, null, _parent));
            _push2(`<input id="checklist-name"${ssrRenderAttr("value", unref(form).name)} type="text" autocomplete="name" required${ssrRenderAttr("placeholder", unref(t)("forms.newsletter.name_placeholder"))} class="min-w-0 flex-1 border-0 bg-transparent p-0 text-[14px] focus:ring-0"></div>`);
            if (unref(form).errors.name) {
              _push2(`<p class="mt-1 text-sm text-red-600">${ssrInterpolate(unref(form).errors.name)}</p>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`</div><div><label for="checklist-email" class="mb-2 block text-[14px] font-medium text-neutral-800">${ssrInterpolate(unref(t)("forms.newsletter.email"))}</label><div class="flex items-center gap-2 rounded-sm border border-gold-300 bg-white/80 p-3 focus-within:border-ink">`);
            _push2(ssrRenderComponent(unref(Mail), {
              class: "size-6 shrink-0 text-neutral-600",
              "stroke-width": 1.5,
              "aria-hidden": "true"
            }, null, _parent));
            _push2(`<input id="checklist-email"${ssrRenderAttr("value", unref(form).email)} type="email" autocomplete="email" required${ssrRenderAttr("placeholder", unref(t)("forms.newsletter.email_placeholder"))} class="min-w-0 flex-1 border-0 bg-transparent p-0 text-[14px] focus:ring-0"></div>`);
            if (unref(form).errors.email) {
              _push2(`<p class="mt-1 text-sm text-red-600">${ssrInterpolate(unref(form).errors.email)}</p>`);
            } else {
              _push2(`<!---->`);
            }
            _push2(`</div><button type="submit" class="mx-auto rounded-sm bg-ink px-6 py-3 text-[18px] text-white transition-colors hover:bg-gold hover:text-white disabled:opacity-60"${ssrIncludeBooleanAttr(unref(form).processing) ? " disabled" : ""}>${ssrInterpolate(unref(t)("forms.newsletter.submit"))}</button></form><p class="mt-8 text-center text-[12px] font-medium text-neutral-700">${ssrInterpolate(unref(t)("forms.newsletter.privacy"))}</p><!--]-->`);
          }
          _push2(`</div></div>`);
        } else {
          _push2(`<!---->`);
        }
      }, "body", false, _parent);
      _push(`</section>`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Sections/LeadMagnet.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
