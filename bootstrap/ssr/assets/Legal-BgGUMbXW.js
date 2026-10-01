import { defineComponent, computed, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderClass, ssrInterpolate } from "vue/server-renderer";
import { a as usePage, u as useTranslations } from "../ssr.js";
import { _ as _sfc_main$1 } from "./SeoHead-DbuqnLLJ.js";
import "@inertiajs/core";
import "lodash-es";
import "laravel-precognition";
import "@inertiajs/core/server";
import "@vue/server-renderer";
import "qs-esm";
import "lucide-vue-next";
import "@vueuse/core";
import "gsap";
import "gsap/CustomEase";
import "gsap/ScrollTrigger";
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "Legal",
  __ssrInlineRender: true,
  props: {
    title: {},
    subtitle: {},
    content: {},
    updatedAt: {},
    seo: {}
  },
  setup(__props) {
    const props = __props;
    const page = usePage();
    const { t } = useTranslations();
    const isPrivacy = computed(() => page.url.includes("privacy-policy"));
    const lastUpdated = computed(() => {
      if (!props.updatedAt) return null;
      const date = new Intl.DateTimeFormat(page.props.locale.htmlLang, {
        year: "numeric",
        month: "long",
        numberingSystem: page.props.locale.htmlLang.startsWith("ar") ? "latn" : void 0
      }).format(new Date(props.updatedAt));
      return t("common.last_updated", { date });
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, { meta: __props.seo }, null, _parent));
      _push(`<section class="${ssrRenderClass([isPrivacy.value ? "md:pb-[250px]" : "md:pb-[202px]", "min-h-[2499px] pb-[160px] pt-[160px] md:min-h-0 md:pt-[192px]"])}"><div class="container-sahra"><div class="flex flex-col gap-4 md:gap-6 lg:flex-row lg:items-start lg:justify-between lg:gap-16"><div class="flex max-w-[612px] flex-col gap-4 md:gap-12"><h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-lg">${ssrInterpolate(__props.title)}</h1>`);
      if (__props.subtitle) {
        _push(`<p class="text-body-lg text-neutral-700 md:text-title-sm md:font-medium">${ssrInterpolate(__props.subtitle)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (lastUpdated.value) {
        _push(`<p class="shrink-0 text-[12px] leading-normal text-neutral-700 md:text-title-sm">${ssrInterpolate(lastUpdated.value)}</p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><article class="prose prose-neutral mt-10 max-w-none md:mt-24 prose-headings:mb-4 prose-headings:mt-8 prose-headings:text-[22px] md:prose-headings:mb-6 md:prose-headings:mt-16 md:prose-headings:text-heading-lg prose-headings:font-medium prose-headings:text-neutral-900 first:prose-headings:mt-0 prose-p:my-0 prose-p:text-body-md prose-p:text-neutral-800 md:prose-p:text-body-xl prose-a:text-gold prose-a:no-underline hover:prose-a:underline prose-ul:my-0 prose-ul:list-none prose-ul:ps-0 prose-li:my-0 prose-li:ps-0 prose-li:text-body-md prose-li:text-neutral-800 md:prose-li:text-body-xl prose-li:marker:content-none [&amp;_p+p]:mt-4 md:[&amp;_p+p]:mt-6 [&amp;_p+ul]:mt-0 [&amp;_ul+p]:mt-4 md:[&amp;_ul+p]:mt-6">${__props.content ?? ""}</article></div></section><!--]-->`);
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Legal.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
