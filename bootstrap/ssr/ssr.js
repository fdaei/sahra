import { createHeadManager, router, config as config$1, isUrlMethodPair, formDataToObject, mergeDataIntoQueryString, getScrollableParent, useInfiniteScroll, UseFormUtils, FormComponentResetSymbol, resetFormFields, shouldIntercept, shouldNavigate, getInitialPageFromDOM, setupProgress } from "@inertiajs/core";
import { ref, shallowRef, defineComponent, markRaw, h, computed, onMounted, watch, onBeforeUnmount, provide, onUnmounted, Fragment, reactive, createSSRApp, mergeProps, createVNode, resolveDynamicComponent, useSSRContext, unref, useModel, nextTick, withCtx, createTextVNode, toDisplayString } from "vue";
import { escape, cloneDeep, has, set, get, isEqual } from "lodash-es";
import { createValidator, toSimpleValidationErrors, resolveName } from "laravel-precognition";
import createServer from "@inertiajs/core/server";
import { renderToString } from "@vue/server-renderer";
import { stringify, parse } from "qs-esm";
import { ssrRenderAttrs, ssrRenderAttr, ssrRenderVNode, ssrRenderComponent, ssrInterpolate, ssrRenderList, ssrRenderClass, ssrRenderTeleport, ssrRenderSlot } from "vue/server-renderer";
import { Share2, Megaphone, Video, Palette, User, Star, Sparkles, ShoppingCart, Send, Play, Phone, MessageCircle, Mail, FileText, Eye, ExternalLink, Download, CirclePlus, CheckCircle, Check, ChevronRight, ArrowUpRight, ArrowRight, ArrowLeft, Globe, ChevronDown, X, Menu, MapPin } from "lucide-vue-next";
import { onClickOutside, onKeyStroke, useScrollLock } from "@vueuse/core";
import { gsap } from "gsap";
import { CustomEase } from "gsap/CustomEase";
import { ScrollTrigger } from "gsap/ScrollTrigger";
var remember = {
  created() {
    if (!this.$options.remember) {
      return;
    }
    if (Array.isArray(this.$options.remember)) {
      this.$options.remember = { data: this.$options.remember };
    }
    if (typeof this.$options.remember === "string") {
      this.$options.remember = { data: [this.$options.remember] };
    }
    if (typeof this.$options.remember.data === "string") {
      this.$options.remember = { data: [this.$options.remember.data] };
    }
    const rememberKey = this.$options.remember.key instanceof Function ? this.$options.remember.key.call(this) : this.$options.remember.key;
    const restored = router.restore(rememberKey);
    const rememberable = this.$options.remember.data.filter((key2) => {
      return !(this[key2] !== null && typeof this[key2] === "object" && this[key2].__rememberable === false);
    });
    const hasCallbacks = (key2) => {
      return this[key2] !== null && typeof this[key2] === "object" && typeof this[key2].__remember === "function" && typeof this[key2].__restore === "function";
    };
    rememberable.forEach((key2) => {
      if (this[key2] !== void 0 && restored !== void 0 && restored[key2] !== void 0) {
        hasCallbacks(key2) ? this[key2].__restore(restored[key2]) : this[key2] = restored[key2];
      }
      this.$watch(
        key2,
        () => {
          router.remember(
            rememberable.reduce(
              (data, key3) => ({
                ...data,
                [key3]: cloneDeep(hasCallbacks(key3) ? this[key3].__remember() : this[key3])
              }),
              {}
            ),
            rememberKey
          );
        },
        { immediate: true, deep: true }
      );
    });
  }
};
var remember_default = remember;
var reservedFormKeys = null;
var bootstrapping = false;
function validateFormDataKeys(data) {
  if (bootstrapping) {
    return;
  }
  if (reservedFormKeys === null) {
    bootstrapping = true;
    reservedFormKeys = new Set(Object.keys(useForm({})));
    bootstrapping = false;
  }
  const conflicts = Object.keys(data).filter((key2) => reservedFormKeys.has(key2));
  if (conflicts.length > 0) {
    console.error(
      `[Inertia] useForm() data contains field(s) that conflict with form properties: ${conflicts.map((k) => `"${k}"`).join(", ")}. These fields will be overwritten by form methods/properties. Please rename these fields.`
    );
  }
}
function useForm(...args) {
  let { rememberKey, data, precognitionEndpoint } = UseFormUtils.parseUseFormArguments(...args);
  const restored = rememberKey ? router.restore(rememberKey) : null;
  let defaults = typeof data === "function" ? cloneDeep(data()) : cloneDeep(data);
  validateFormDataKeys(defaults);
  let cancelToken = null;
  let recentlySuccessfulTimeoutId;
  let transform = (data2) => data2;
  let validatorRef = null;
  let rememberExcludeKeys = [];
  let defaultsCalledInOnSuccess = false;
  const form = reactive({
    ...restored ? restored.data : cloneDeep(defaults),
    isDirty: false,
    errors: restored ? restored.errors : {},
    hasErrors: false,
    processing: false,
    progress: null,
    wasSuccessful: false,
    recentlySuccessful: false,
    withPrecognition(...args2) {
      precognitionEndpoint = UseFormUtils.createWayfinderCallback(...args2);
      const formWithPrecognition = this;
      let withAllErrors = null;
      const validator = createValidator((client) => {
        const { method, url } = precognitionEndpoint();
        const transformedData = cloneDeep(transform(this.data()));
        return client[method](url, transformedData);
      }, cloneDeep(defaults));
      validatorRef = validator;
      validator.on("validatingChanged", () => {
        formWithPrecognition.validating = validator.validating();
      }).on("validatedChanged", () => {
        formWithPrecognition.__valid = validator.valid();
      }).on("touchedChanged", () => {
        formWithPrecognition.__touched = validator.touched();
      }).on("errorsChanged", () => {
        const validationErrors = withAllErrors ?? config.get("form.withAllErrors") ? validator.errors() : toSimpleValidationErrors(validator.errors());
        this.errors = {};
        this.setError(validationErrors);
        formWithPrecognition.__valid = validator.valid();
      });
      const tap = (value, callback) => {
        callback(value);
        return value;
      };
      Object.assign(formWithPrecognition, {
        __touched: [],
        __valid: [],
        validating: false,
        validator: () => validator,
        withAllErrors: () => tap(formWithPrecognition, () => withAllErrors = true),
        valid: (field) => formWithPrecognition.__valid.includes(field),
        invalid: (field) => field in this.errors,
        setValidationTimeout: (duration) => tap(formWithPrecognition, () => validator.setTimeout(duration)),
        validateFiles: () => tap(formWithPrecognition, () => validator.validateFiles()),
        withoutFileValidation: () => tap(formWithPrecognition, () => validator.withoutFileValidation()),
        touch: (field, ...fields) => {
          if (Array.isArray(field)) {
            validator.touch(field);
          } else if (typeof field === "string") {
            validator.touch([field, ...fields]);
          } else {
            validator.touch(field);
          }
          return formWithPrecognition;
        },
        touched: (field) => typeof field === "string" ? formWithPrecognition.__touched.includes(field) : formWithPrecognition.__touched.length > 0,
        validate: (field, config3) => {
          if (typeof field === "object" && !("target" in field)) {
            config3 = field;
            field = void 0;
          }
          if (field === void 0) {
            validator.validate(config3);
          } else {
            const fieldName = resolveName(field);
            const transformedData = transform(this.data());
            validator.validate(fieldName, get(transformedData, fieldName), config3);
          }
          return formWithPrecognition;
        },
        setErrors: (errors) => tap(formWithPrecognition, () => this.setError(errors)),
        forgetError: (field) => tap(
          formWithPrecognition,
          () => this.clearErrors(resolveName(field))
        )
      });
      return formWithPrecognition;
    },
    data() {
      return Object.keys(defaults).reduce((carry, key2) => {
        return set(carry, key2, get(this, key2));
      }, {});
    },
    transform(callback) {
      transform = callback;
      return this;
    },
    defaults(fieldOrFields, maybeValue) {
      if (typeof data === "function") {
        throw new Error("You cannot call `defaults()` when using a function to define your form data.");
      }
      defaultsCalledInOnSuccess = true;
      if (typeof fieldOrFields === "undefined") {
        defaults = cloneDeep(this.data());
        this.isDirty = false;
      } else {
        defaults = typeof fieldOrFields === "string" ? set(cloneDeep(defaults), fieldOrFields, maybeValue) : Object.assign({}, cloneDeep(defaults), fieldOrFields);
      }
      validatorRef == null ? void 0 : validatorRef.defaults(defaults);
      return this;
    },
    reset(...fields) {
      const resolvedData = typeof data === "function" ? cloneDeep(data()) : cloneDeep(defaults);
      const clonedData = cloneDeep(resolvedData);
      if (fields.length === 0) {
        defaults = clonedData;
        Object.assign(this, resolvedData);
      } else {
        fields.filter((key2) => has(clonedData, key2)).forEach((key2) => {
          set(defaults, key2, get(clonedData, key2));
          set(this, key2, get(resolvedData, key2));
        });
      }
      validatorRef == null ? void 0 : validatorRef.reset(...fields);
      return this;
    },
    setError(fieldOrFields, maybeValue) {
      const errors = typeof fieldOrFields === "string" ? { [fieldOrFields]: maybeValue } : fieldOrFields;
      Object.assign(this.errors, errors);
      this.hasErrors = Object.keys(this.errors).length > 0;
      validatorRef == null ? void 0 : validatorRef.setErrors(errors);
      return this;
    },
    clearErrors(...fields) {
      this.errors = Object.keys(this.errors).reduce(
        (carry, field) => ({
          ...carry,
          ...fields.length > 0 && !fields.includes(field) ? { [field]: this.errors[field] } : {}
        }),
        {}
      );
      this.hasErrors = Object.keys(this.errors).length > 0;
      if (validatorRef) {
        if (fields.length === 0) {
          validatorRef.setErrors({});
        } else {
          fields.forEach(validatorRef.forgetError);
        }
      }
      return this;
    },
    resetAndClearErrors(...fields) {
      this.reset(...fields);
      this.clearErrors(...fields);
      return this;
    },
    submit(...args2) {
      const { method, url, options } = UseFormUtils.parseSubmitArguments(args2, precognitionEndpoint);
      defaultsCalledInOnSuccess = false;
      const _options = {
        ...options,
        onCancelToken: (token) => {
          cancelToken = token;
          if (options.onCancelToken) {
            return options.onCancelToken(token);
          }
        },
        onBefore: (visit) => {
          this.wasSuccessful = false;
          this.recentlySuccessful = false;
          clearTimeout(recentlySuccessfulTimeoutId);
          if (options.onBefore) {
            return options.onBefore(visit);
          }
        },
        onStart: (visit) => {
          this.processing = true;
          if (options.onStart) {
            return options.onStart(visit);
          }
        },
        onProgress: (event) => {
          this.progress = event ?? null;
          if (options.onProgress) {
            return options.onProgress(event);
          }
        },
        onSuccess: async (page2) => {
          this.processing = false;
          this.progress = null;
          this.clearErrors();
          this.wasSuccessful = true;
          this.recentlySuccessful = true;
          recentlySuccessfulTimeoutId = setTimeout(
            () => this.recentlySuccessful = false,
            config.get("form.recentlySuccessfulDuration")
          );
          const onSuccess = options.onSuccess ? await options.onSuccess(page2) : null;
          if (!defaultsCalledInOnSuccess) {
            defaults = cloneDeep(this.data());
            this.isDirty = false;
          }
          return onSuccess;
        },
        onError: (errors) => {
          this.processing = false;
          this.progress = null;
          this.clearErrors().setError(errors);
          if (options.onError) {
            return options.onError(errors);
          }
        },
        onCancel: () => {
          this.processing = false;
          this.progress = null;
          if (options.onCancel) {
            return options.onCancel();
          }
        },
        onFinish: (visit) => {
          this.processing = false;
          this.progress = null;
          cancelToken = null;
          if (options.onFinish) {
            return options.onFinish(visit);
          }
        }
      };
      const transformedData = transform(this.data());
      if (method === "delete") {
        router.delete(url, { ..._options, data: transformedData });
      } else {
        router[method](url, transformedData, _options);
      }
    },
    get(url, options) {
      this.submit("get", url, options);
    },
    post(url, options) {
      this.submit("post", url, options);
    },
    put(url, options) {
      this.submit("put", url, options);
    },
    patch(url, options) {
      this.submit("patch", url, options);
    },
    delete(url, options) {
      this.submit("delete", url, options);
    },
    cancel() {
      if (cancelToken) {
        cancelToken.cancel();
      }
    },
    dontRemember(...keys) {
      rememberExcludeKeys = keys;
      return this;
    },
    __rememberable: rememberKey === null,
    __remember() {
      const data2 = this.data();
      if (rememberExcludeKeys.length > 0) {
        const filtered = { ...data2 };
        rememberExcludeKeys.forEach((k) => delete filtered[k]);
        return { data: filtered, errors: this.errors };
      }
      return { data: data2, errors: this.errors };
    },
    __restore(restored2) {
      Object.assign(this, restored2.data);
      this.setError(restored2.errors);
    }
  });
  const typedForm = form;
  watch(
    typedForm,
    (newValue) => {
      typedForm.isDirty = !isEqual(typedForm.data(), defaults);
      const storedData = router.restore(rememberKey);
      const newData = cloneDeep(newValue.__remember());
      if (rememberKey && !isEqual(storedData, newData)) {
        router.remember(newData, rememberKey);
      }
    },
    { immediate: true, deep: true }
  );
  return precognitionEndpoint ? typedForm.withPrecognition(precognitionEndpoint) : typedForm;
}
var component = ref(void 0);
var page = ref();
var layout = shallowRef(null);
var key = ref(void 0);
var headManager;
var App = defineComponent({
  name: "Inertia",
  props: {
    initialPage: {
      type: Object,
      required: true
    },
    initialComponent: {
      type: Object,
      required: false
    },
    resolveComponent: {
      type: Function,
      required: false
    },
    titleCallback: {
      type: Function,
      required: false,
      default: (title) => title
    },
    onHeadUpdate: {
      type: Function,
      required: false,
      default: () => () => {
      }
    }
  },
  setup({ initialPage, initialComponent, resolveComponent, titleCallback, onHeadUpdate }) {
    component.value = initialComponent ? markRaw(initialComponent) : void 0;
    page.value = { ...initialPage, flash: initialPage.flash ?? {} };
    key.value = void 0;
    const isServer = typeof window === "undefined";
    headManager = createHeadManager(isServer, titleCallback || ((title) => title), onHeadUpdate || (() => {
    }));
    if (!isServer) {
      router.init({
        initialPage,
        resolveComponent,
        swapComponent: async (options) => {
          component.value = markRaw(options.component);
          page.value = options.page;
          key.value = options.preserveState ? key.value : Date.now();
        },
        onFlash: (flash) => {
          page.value = { ...page.value, flash };
        }
      });
      router.on("navigate", () => headManager.forceUpdate());
    }
    return () => {
      if (component.value) {
        component.value.inheritAttrs = !!component.value.inheritAttrs;
        const child = h(component.value, {
          ...page.value.props,
          key: key.value
        });
        if (layout.value) {
          component.value.layout = layout.value;
          layout.value = null;
        }
        if (component.value.layout) {
          if (typeof component.value.layout === "function") {
            return component.value.layout(h, child);
          }
          return (Array.isArray(component.value.layout) ? component.value.layout : [component.value.layout]).concat(child).reverse().reduce((child2, layout2) => {
            layout2.inheritAttrs = !!layout2.inheritAttrs;
            return h(layout2, { ...page.value.props }, () => child2);
          });
        }
        return child;
      }
    };
  }
});
var app_default = App;
var plugin = {
  install(app) {
    router.form = useForm;
    Object.defineProperty(app.config.globalProperties, "$inertia", { get: () => router });
    Object.defineProperty(app.config.globalProperties, "$page", { get: () => page.value });
    Object.defineProperty(app.config.globalProperties, "$headManager", { get: () => headManager });
    app.mixin(remember_default);
  }
};
function usePage() {
  return reactive({
    props: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.props;
    }),
    url: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.url;
    }),
    component: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.component;
    }),
    version: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.version;
    }),
    clearHistory: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.clearHistory;
    }),
    deferredProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.deferredProps;
    }),
    mergeProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.mergeProps;
    }),
    prependProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.prependProps;
    }),
    deepMergeProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.deepMergeProps;
    }),
    matchPropsOn: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.matchPropsOn;
    }),
    rememberedState: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.rememberedState;
    }),
    encryptHistory: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.encryptHistory;
    }),
    scrollProps: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.scrollProps;
    }),
    flash: computed(() => {
      var _a;
      return (_a = page.value) == null ? void 0 : _a.flash;
    })
  });
}
async function createInertiaApp({
  id = "app",
  resolve: resolve2,
  setup,
  title,
  progress: progress2 = {},
  page: page2,
  render,
  defaults = {}
}) {
  config.replace(defaults);
  const isServer = typeof window === "undefined";
  const useScriptElementForInitialPage = config.get("future.useScriptElementForInitialPage");
  const initialPage = page2 || getInitialPageFromDOM(id, useScriptElementForInitialPage);
  const resolveComponent = (name) => Promise.resolve(resolve2(name)).then((module) => module.default || module);
  let head = [];
  const vueApp = await Promise.all([
    resolveComponent(initialPage.component),
    router.decryptHistory().catch(() => {
    })
  ]).then(([initialComponent]) => {
    const props = {
      initialPage,
      initialComponent,
      resolveComponent,
      titleCallback: title
    };
    if (isServer) {
      const ssrSetup = setup;
      return ssrSetup({
        el: null,
        App: app_default,
        props: { ...props, onHeadUpdate: (elements) => head = elements },
        plugin
      });
    }
    const csrSetup = setup;
    return csrSetup({
      el: document.getElementById(id),
      App: app_default,
      props,
      plugin
    });
  });
  if (!isServer && progress2) {
    setupProgress(progress2);
  }
  if (isServer && render) {
    const element = () => {
      if (!useScriptElementForInitialPage) {
        return h("div", {
          id,
          "data-page": JSON.stringify(initialPage),
          innerHTML: vueApp ? render(vueApp) : ""
        });
      }
      return [
        h("script", {
          "data-page": id,
          type: "application/json",
          innerHTML: JSON.stringify(initialPage).replace(/\//g, "\\/")
        }),
        h("div", {
          id,
          innerHTML: vueApp ? render(vueApp) : ""
        })
      ];
    };
    const body = await render(
      createSSRApp({
        render: () => element()
      })
    );
    return { head, body };
  }
}
defineComponent({
  name: "Deferred",
  props: {
    data: {
      type: [String, Array],
      required: true
    }
  },
  render() {
    var _a, _b;
    const keys = Array.isArray(this.$props.data) ? this.$props.data : [this.$props.data];
    if (!this.$slots.fallback) {
      throw new Error("`<Deferred>` requires a `<template #fallback>` slot");
    }
    return keys.every((key2) => this.$page.props[key2] !== void 0) ? (_b = (_a = this.$slots).default) == null ? void 0 : _b.call(_a) : this.$slots.fallback();
  }
});
var noop = () => void 0;
var FormContextKey = Symbol("InertiaFormContext");
defineComponent({
  name: "Form",
  slots: Object,
  props: {
    action: {
      type: [String, Object],
      default: ""
    },
    method: {
      type: String,
      default: "get"
    },
    headers: {
      type: Object,
      default: () => ({})
    },
    queryStringArrayFormat: {
      type: String,
      default: "brackets"
    },
    errorBag: {
      type: [String, null],
      default: null
    },
    showProgress: {
      type: Boolean,
      default: true
    },
    transform: {
      type: Function,
      default: (data) => data
    },
    options: {
      type: Object,
      default: () => ({})
    },
    resetOnError: {
      type: [Boolean, Array],
      default: false
    },
    resetOnSuccess: {
      type: [Boolean, Array],
      default: false
    },
    setDefaultsOnSuccess: {
      type: Boolean,
      default: false
    },
    onCancelToken: {
      type: Function,
      default: noop
    },
    onBefore: {
      type: Function,
      default: noop
    },
    onStart: {
      type: Function,
      default: noop
    },
    onProgress: {
      type: Function,
      default: noop
    },
    onFinish: {
      type: Function,
      default: noop
    },
    onCancel: {
      type: Function,
      default: noop
    },
    onSuccess: {
      type: Function,
      default: noop
    },
    onError: {
      type: Function,
      default: noop
    },
    onSubmitComplete: {
      type: Function,
      default: noop
    },
    disableWhileProcessing: {
      type: Boolean,
      default: false
    },
    invalidateCacheTags: {
      type: [String, Array],
      default: () => []
    },
    validateFiles: {
      type: Boolean,
      default: false
    },
    validationTimeout: {
      type: Number,
      default: 1500
    },
    withAllErrors: {
      type: Boolean,
      default: null
    }
  },
  setup(props, { slots, attrs, expose }) {
    const getTransformedData = () => {
      const [_url, data] = getUrlAndData();
      return props.transform(data);
    };
    const form = useForm({}).withPrecognition(
      () => method.value,
      () => getUrlAndData()[0]
    ).transform(getTransformedData).setValidationTimeout(props.validationTimeout);
    if (props.validateFiles) {
      form.validateFiles();
    }
    if (props.withAllErrors ?? config$1.get("form.withAllErrors")) {
      form.withAllErrors();
    }
    const formElement = ref();
    const method = computed(
      () => isUrlMethodPair(props.action) ? props.action.method : props.method.toLowerCase()
    );
    const isDirty = ref(false);
    const defaultData = ref(new FormData());
    const onFormUpdate = (event) => {
      var _a;
      if (event.type === "reset" && ((_a = event.detail) == null ? void 0 : _a[FormComponentResetSymbol])) {
        event.preventDefault();
      }
      isDirty.value = event.type === "reset" ? false : !isEqual(getData(), formDataToObject(defaultData.value));
    };
    const formEvents = ["input", "change", "reset"];
    onMounted(() => {
      defaultData.value = getFormData();
      form.defaults(getData());
      formEvents.forEach((e) => formElement.value.addEventListener(e, onFormUpdate));
    });
    watch(
      () => props.validateFiles,
      (value) => value ? form.validateFiles() : form.withoutFileValidation()
    );
    watch(
      () => props.validationTimeout,
      (value) => form.setValidationTimeout(value)
    );
    onBeforeUnmount(() => formEvents.forEach((e) => {
      var _a;
      return (_a = formElement.value) == null ? void 0 : _a.removeEventListener(e, onFormUpdate);
    }));
    const getFormData = (submitter) => new FormData(formElement.value, submitter);
    const getData = (submitter) => formDataToObject(getFormData(submitter));
    const getUrlAndData = (submitter) => {
      return mergeDataIntoQueryString(
        method.value,
        isUrlMethodPair(props.action) ? props.action.url : props.action,
        getData(submitter),
        props.queryStringArrayFormat
      );
    };
    const submit = (submitter) => {
      const [url, data] = getUrlAndData(submitter);
      const formTarget = submitter == null ? void 0 : submitter.getAttribute("formtarget");
      if (formTarget === "_blank" && method.value === "get") {
        window.open(url, "_blank");
        return;
      }
      const maybeReset = (resetOption) => {
        if (!resetOption) {
          return;
        }
        if (resetOption === true) {
          reset();
        } else if (resetOption.length > 0) {
          reset(...resetOption);
        }
      };
      const submitOptions = {
        headers: props.headers,
        queryStringArrayFormat: props.queryStringArrayFormat,
        errorBag: props.errorBag,
        showProgress: props.showProgress,
        invalidateCacheTags: props.invalidateCacheTags,
        onCancelToken: props.onCancelToken,
        onBefore: props.onBefore,
        onStart: props.onStart,
        onProgress: props.onProgress,
        onFinish: props.onFinish,
        onCancel: props.onCancel,
        onSuccess: (...args) => {
          var _a, _b;
          (_a = props.onSuccess) == null ? void 0 : _a.call(props, ...args);
          (_b = props.onSubmitComplete) == null ? void 0 : _b.call(props, exposed);
          maybeReset(props.resetOnSuccess);
          if (props.setDefaultsOnSuccess === true) {
            defaults();
          }
        },
        onError: (...args) => {
          var _a;
          (_a = props.onError) == null ? void 0 : _a.call(props, ...args);
          maybeReset(props.resetOnError);
        },
        ...props.options
      };
      form.transform(() => props.transform(data)).submit(method.value, url, submitOptions);
      form.transform(getTransformedData);
    };
    const reset = (...fields) => {
      resetFormFields(formElement.value, defaultData.value, fields);
      form.reset(...fields);
    };
    const clearErrors = (...fields) => {
      form.clearErrors(...fields);
    };
    const resetAndClearErrors = (...fields) => {
      clearErrors(...fields);
      reset(...fields);
    };
    const defaults = () => {
      defaultData.value = getFormData();
      isDirty.value = false;
    };
    const exposed = {
      get errors() {
        return form.errors;
      },
      get hasErrors() {
        return form.hasErrors;
      },
      get processing() {
        return form.processing;
      },
      get progress() {
        return form.progress;
      },
      get wasSuccessful() {
        return form.wasSuccessful;
      },
      get recentlySuccessful() {
        return form.recentlySuccessful;
      },
      get validating() {
        return form.validating;
      },
      clearErrors,
      resetAndClearErrors,
      setError: (fieldOrFields, maybeValue) => form.setError(typeof fieldOrFields === "string" ? { [fieldOrFields]: maybeValue } : fieldOrFields),
      get isDirty() {
        return isDirty.value;
      },
      reset,
      submit,
      defaults,
      getData,
      getFormData,
      // Precognition
      touch: form.touch,
      valid: form.valid,
      invalid: form.invalid,
      touched: form.touched,
      validate: (field, config3) => form.validate(...UseFormUtils.mergeHeadersForValidation(field, config3, props.headers)),
      validator: () => form.validator()
    };
    expose(exposed);
    provide(FormContextKey, exposed);
    return () => {
      return h(
        "form",
        {
          ...attrs,
          ref: formElement,
          action: isUrlMethodPair(props.action) ? props.action.url : props.action,
          method: method.value,
          onSubmit: (event) => {
            event.preventDefault();
            submit(event.submitter);
          },
          inert: props.disableWhileProcessing && form.processing
        },
        slots.default ? slots.default(exposed) : []
      );
    };
  }
});
var Head = defineComponent({
  props: {
    title: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      provider: this.$headManager.createProvider()
    };
  },
  beforeUnmount() {
    this.provider.disconnect();
  },
  methods: {
    isUnaryTag(node) {
      return typeof node.type === "string" && [
        "area",
        "base",
        "br",
        "col",
        "embed",
        "hr",
        "img",
        "input",
        "keygen",
        "link",
        "meta",
        "param",
        "source",
        "track",
        "wbr"
      ].indexOf(node.type) > -1;
    },
    renderTagStart(node) {
      node.props = node.props || {};
      node.props[this.provider.preferredAttribute()] = node.props["head-key"] !== void 0 ? node.props["head-key"] : "";
      const attrs = Object.keys(node.props).reduce((carry, name) => {
        const value = String(node.props[name]);
        if (["key", "head-key"].includes(name)) {
          return carry;
        } else if (value === "") {
          return carry + ` ${name}`;
        } else {
          return carry + ` ${name}="${escape(value)}"`;
        }
      }, "");
      return `<${String(node.type)}${attrs}>`;
    },
    renderTagChildren(node) {
      const { children } = node;
      if (typeof children === "string") {
        return children;
      }
      if (Array.isArray(children)) {
        return children.reduce((html, child) => {
          return html + this.renderTag(child);
        }, "");
      }
      return "";
    },
    isFunctionNode(node) {
      return typeof node.type === "function";
    },
    isComponentNode(node) {
      return typeof node.type === "object";
    },
    isCommentNode(node) {
      return /(comment|cmt)/i.test(node.type.toString());
    },
    isFragmentNode(node) {
      return /(fragment|fgt|symbol\(\))/i.test(node.type.toString());
    },
    isTextNode(node) {
      return /(text|txt)/i.test(node.type.toString());
    },
    renderTag(node) {
      if (this.isTextNode(node)) {
        return String(node.children);
      } else if (this.isFragmentNode(node)) {
        return "";
      } else if (this.isCommentNode(node)) {
        return "";
      }
      let html = this.renderTagStart(node);
      if (node.children) {
        html += this.renderTagChildren(node);
      }
      if (!this.isUnaryTag(node)) {
        html += `</${String(node.type)}>`;
      }
      return html;
    },
    addTitleElement(elements) {
      if (this.title && !elements.find((tag) => tag.startsWith("<title"))) {
        elements.push(`<title ${this.provider.preferredAttribute()}>${escape(this.title)}</title>`);
      }
      return elements;
    },
    renderNodes(nodes) {
      const elements = nodes.flatMap((node) => this.resolveNode(node)).map((node) => this.renderTag(node)).filter((node) => node);
      return this.addTitleElement(elements);
    },
    resolveNode(node) {
      if (this.isFunctionNode(node)) {
        return this.resolveNode(node.type());
      } else if (this.isComponentNode(node)) {
        console.warn(`Using components in the <Head> component is not supported.`);
        return [];
      } else if (this.isTextNode(node) && node.children) {
        return node;
      } else if (this.isFragmentNode(node) && node.children) {
        return node.children.flatMap((child) => this.resolveNode(child));
      } else if (this.isCommentNode(node)) {
        return [];
      } else {
        return node;
      }
    }
  },
  render() {
    this.provider.update(this.renderNodes(this.$slots.default ? this.$slots.default() : []));
  }
});
var head_default = Head;
var resolveHTMLElement = (value, fallback) => {
  if (!value) {
    return fallback;
  }
  if (typeof value === "string") {
    return document.querySelector(value);
  }
  if (typeof value === "function") {
    return value() || null;
  }
  return fallback;
};
defineComponent({
  name: "InfiniteScroll",
  slots: Object,
  props: {
    data: {
      type: String,
      required: true
    },
    buffer: {
      type: Number,
      default: 0
    },
    onlyNext: {
      type: Boolean,
      default: false
    },
    onlyPrevious: {
      type: Boolean,
      default: false
    },
    as: {
      type: String,
      default: "div"
    },
    manual: {
      type: Boolean,
      default: false
    },
    manualAfter: {
      type: Number,
      default: 0
    },
    preserveUrl: {
      type: Boolean,
      default: false
    },
    reverse: {
      type: Boolean,
      default: false
    },
    autoScroll: {
      type: Boolean,
      default: void 0
    },
    itemsElement: {
      type: [String, Function, Object],
      default: null
    },
    startElement: {
      type: [String, Function, Object],
      default: null
    },
    endElement: {
      type: [String, Function, Object],
      default: null
    }
  },
  inheritAttrs: false,
  setup(props, { slots, attrs, expose }) {
    var _a;
    const itemsElementRef = ref(null);
    const startElementRef = ref(null);
    const endElementRef = ref(null);
    const itemsElement = computed(
      () => resolveHTMLElement(props.itemsElement, itemsElementRef.value)
    );
    const scrollableParent = computed(() => getScrollableParent(itemsElement.value));
    const startElement = computed(
      () => resolveHTMLElement(props.startElement, startElementRef.value)
    );
    const endElement = computed(() => resolveHTMLElement(props.endElement, endElementRef.value));
    const loadingPrevious = ref(false);
    const loadingNext = ref(false);
    const requestCount = ref(0);
    const hasPreviousPage = ref(false);
    const hasNextPage = ref(false);
    const syncStateFromDataManager = () => {
      requestCount.value = dataManager.getRequestCount();
      hasPreviousPage.value = dataManager.hasPrevious();
      hasNextPage.value = dataManager.hasNext();
    };
    const {
      dataManager,
      elementManager,
      flush: flushInfiniteScroll
    } = useInfiniteScroll({
      // Data
      getPropName: () => props.data,
      inReverseMode: () => props.reverse,
      shouldFetchNext: () => !props.onlyPrevious,
      shouldFetchPrevious: () => !props.onlyNext,
      shouldPreserveUrl: () => props.preserveUrl,
      // Elements
      getTriggerMargin: () => props.buffer,
      getStartElement: () => startElement.value,
      getEndElement: () => endElement.value,
      getItemsElement: () => itemsElement.value,
      getScrollableParent: () => scrollableParent.value,
      // Request callbacks
      onBeforePreviousRequest: () => loadingPrevious.value = true,
      onBeforeNextRequest: () => loadingNext.value = true,
      onCompletePreviousRequest: ({ completed }) => {
        loadingPrevious.value = false;
        if (completed) {
          syncStateFromDataManager();
        }
      },
      onCompleteNextRequest: ({ completed }) => {
        loadingNext.value = false;
        if (completed) {
          syncStateFromDataManager();
        }
      },
      onDataReset: syncStateFromDataManager
    });
    syncStateFromDataManager();
    if (typeof window === "undefined") {
      const scrollProp = (_a = usePage().scrollProps) == null ? void 0 : _a[props.data];
      if (scrollProp) {
        hasPreviousPage.value = !!scrollProp.previousPage;
        hasNextPage.value = !!scrollProp.nextPage;
      }
    }
    const autoLoad = computed(() => !manualMode.value);
    const manualMode = computed(
      () => props.manual || props.manualAfter > 0 && requestCount.value >= props.manualAfter
    );
    const scrollToBottom = () => {
      if (scrollableParent.value) {
        scrollableParent.value.scrollTo({
          top: scrollableParent.value.scrollHeight,
          behavior: "instant"
        });
      } else {
        window.scrollTo({
          top: document.body.scrollHeight,
          behavior: "instant"
        });
      }
    };
    onMounted(() => {
      elementManager.setupObservers();
      elementManager.processServerLoadedElements(dataManager.getLastLoadedPage());
      const shouldAutoScroll = props.autoScroll !== void 0 ? props.autoScroll : props.reverse;
      if (shouldAutoScroll) {
        scrollToBottom();
      }
      if (autoLoad.value) {
        elementManager.enableTriggers();
      }
    });
    onUnmounted(flushInfiniteScroll);
    watch(
      () => [autoLoad.value, props.onlyNext, props.onlyPrevious],
      ([enabled]) => {
        enabled ? elementManager.enableTriggers() : elementManager.disableTriggers();
      }
    );
    expose({
      fetchNext: dataManager.fetchNext,
      fetchPrevious: dataManager.fetchPrevious,
      hasPrevious: dataManager.hasPrevious,
      hasNext: dataManager.hasNext
    });
    return () => {
      var _a2, _b, _c;
      const renderElements = [];
      const sharedExposed = {
        loadingPrevious: loadingPrevious.value,
        loadingNext: loadingNext.value,
        hasPrevious: hasPreviousPage.value,
        hasNext: hasNextPage.value
      };
      if (!props.startElement) {
        const headerAutoMode = autoLoad.value && !props.onlyNext;
        const exposedPrevious = {
          loading: loadingPrevious.value,
          fetch: dataManager.fetchPrevious,
          autoMode: headerAutoMode,
          manualMode: !headerAutoMode,
          hasMore: hasPreviousPage.value,
          ...sharedExposed
        };
        renderElements.push(
          h(
            "div",
            { ref: startElementRef },
            slots.previous ? slots.previous(exposedPrevious) : loadingPrevious.value ? (_a2 = slots.loading) == null ? void 0 : _a2.call(slots, exposedPrevious) : void 0
          )
        );
      }
      renderElements.push(
        h(
          props.as,
          { ...attrs, ref: itemsElementRef },
          (_b = slots.default) == null ? void 0 : _b.call(slots, {
            loading: loadingPrevious.value || loadingNext.value,
            loadingPrevious: loadingPrevious.value,
            loadingNext: loadingNext.value
          })
        )
      );
      if (!props.endElement) {
        const footerAutoMode = autoLoad.value && !props.onlyPrevious;
        const exposedNext = {
          loading: loadingNext.value,
          fetch: dataManager.fetchNext,
          autoMode: footerAutoMode,
          manualMode: !footerAutoMode,
          hasMore: hasNextPage.value,
          ...sharedExposed
        };
        renderElements.push(
          h(
            "div",
            { ref: endElementRef },
            slots.next ? slots.next(exposedNext) : loadingNext.value ? (_c = slots.loading) == null ? void 0 : _c.call(slots, exposedNext) : void 0
          )
        );
      }
      return h(Fragment, {}, props.reverse ? [...renderElements].reverse() : renderElements);
    };
  }
});
var noop2 = () => {
};
var Link = defineComponent({
  name: "Link",
  props: {
    as: {
      type: [String, Object],
      default: "a"
    },
    data: {
      type: Object,
      default: () => ({})
    },
    href: {
      type: [String, Object],
      default: ""
    },
    method: {
      type: String,
      default: "get"
    },
    replace: {
      type: Boolean,
      default: false
    },
    preserveScroll: {
      type: [Boolean, String, Function],
      default: false
    },
    preserveState: {
      type: [Boolean, String, Function],
      default: null
    },
    preserveUrl: {
      type: Boolean,
      default: false
    },
    only: {
      type: Array,
      default: () => []
    },
    except: {
      type: Array,
      default: () => []
    },
    headers: {
      type: Object,
      default: () => ({})
    },
    queryStringArrayFormat: {
      type: String,
      default: "brackets"
    },
    async: {
      type: Boolean,
      default: false
    },
    prefetch: {
      type: [Boolean, String, Array],
      default: false
    },
    cacheFor: {
      type: [Number, String, Array],
      default: 0
    },
    onStart: {
      type: Function,
      default: noop2
    },
    onProgress: {
      type: Function,
      default: noop2
    },
    onFinish: {
      type: Function,
      default: noop2
    },
    onBefore: {
      type: Function,
      default: noop2
    },
    onCancel: {
      type: Function,
      default: noop2
    },
    onSuccess: {
      type: Function,
      default: noop2
    },
    onError: {
      type: Function,
      default: noop2
    },
    onCancelToken: {
      type: Function,
      default: noop2
    },
    onPrefetching: {
      type: Function,
      default: noop2
    },
    onPrefetched: {
      type: Function,
      default: noop2
    },
    cacheTags: {
      type: [String, Array],
      default: () => []
    },
    viewTransition: {
      type: [Boolean, Object],
      default: false
    }
  },
  setup(props, { slots, attrs }) {
    const inFlightCount = ref(0);
    const hoverTimeout = ref();
    const prefetchModes = computed(() => {
      if (props.prefetch === true) {
        return ["hover"];
      }
      if (props.prefetch === false) {
        return [];
      }
      if (Array.isArray(props.prefetch)) {
        return props.prefetch;
      }
      return [props.prefetch];
    });
    const cacheForValue = computed(() => {
      if (props.cacheFor !== 0) {
        return props.cacheFor;
      }
      if (prefetchModes.value.length === 1 && prefetchModes.value[0] === "click") {
        return 0;
      }
      return config.get("prefetch.cacheFor");
    });
    onMounted(() => {
      if (prefetchModes.value.includes("mount")) {
        prefetch();
      }
    });
    onUnmounted(() => {
      clearTimeout(hoverTimeout.value);
    });
    const method = computed(
      () => isUrlMethodPair(props.href) ? props.href.method : (props.method ?? "get").toLowerCase()
    );
    const as = computed(() => {
      if (typeof props.as !== "string" || props.as.toLowerCase() !== "a") {
        return props.as;
      }
      return method.value !== "get" ? "button" : props.as.toLowerCase();
    });
    const mergeDataArray = computed(
      () => mergeDataIntoQueryString(
        method.value,
        isUrlMethodPair(props.href) ? props.href.url : props.href,
        props.data || {},
        props.queryStringArrayFormat
      )
    );
    const href = computed(() => mergeDataArray.value[0]);
    const data = computed(() => mergeDataArray.value[1]);
    const elProps = computed(() => {
      if (as.value === "button") {
        return { type: "button" };
      }
      if (as.value === "a" || typeof as.value !== "string") {
        return { href: href.value };
      }
      return {};
    });
    const baseParams = computed(() => ({
      data: data.value,
      method: method.value,
      replace: props.replace,
      preserveScroll: props.preserveScroll,
      preserveState: props.preserveState ?? method.value !== "get",
      preserveUrl: props.preserveUrl,
      only: props.only,
      except: props.except,
      headers: props.headers,
      async: props.async
    }));
    const visitParams = computed(() => ({
      ...baseParams.value,
      viewTransition: props.viewTransition,
      onCancelToken: props.onCancelToken,
      onBefore: props.onBefore,
      onStart: (visit) => {
        var _a;
        inFlightCount.value++;
        (_a = props.onStart) == null ? void 0 : _a.call(props, visit);
      },
      onProgress: props.onProgress,
      onFinish: (visit) => {
        var _a;
        inFlightCount.value--;
        (_a = props.onFinish) == null ? void 0 : _a.call(props, visit);
      },
      onCancel: props.onCancel,
      onSuccess: props.onSuccess,
      onError: props.onError
    }));
    const prefetch = () => {
      router.prefetch(
        href.value,
        {
          ...baseParams.value,
          onPrefetching: props.onPrefetching,
          onPrefetched: props.onPrefetched
        },
        {
          cacheFor: cacheForValue.value,
          cacheTags: props.cacheTags
        }
      );
    };
    const regularEvents = {
      onClick: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
          router.visit(href.value, visitParams.value);
        }
      }
    };
    const prefetchHoverEvents = {
      onMouseenter: () => {
        hoverTimeout.value = setTimeout(() => {
          prefetch();
        }, config.get("prefetch.hoverDelay"));
      },
      onMouseleave: () => {
        clearTimeout(hoverTimeout.value);
      },
      onClick: regularEvents.onClick
    };
    const prefetchClickEvents = {
      onMousedown: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
          prefetch();
        }
      },
      onKeydown: (event) => {
        if (shouldNavigate(event)) {
          event.preventDefault();
          prefetch();
        }
      },
      onMouseup: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
          router.visit(href.value, visitParams.value);
        }
      },
      onKeyup: (event) => {
        if (shouldNavigate(event)) {
          event.preventDefault();
          router.visit(href.value, visitParams.value);
        }
      },
      onClick: (event) => {
        if (shouldIntercept(event)) {
          event.preventDefault();
        }
      }
    };
    return () => {
      return h(
        as.value,
        {
          ...attrs,
          ...elProps.value,
          "data-loading": inFlightCount.value > 0 ? "" : void 0,
          ...(() => {
            if (prefetchModes.value.includes("hover")) {
              return prefetchHoverEvents;
            }
            if (prefetchModes.value.includes("click")) {
              return prefetchClickEvents;
            }
            return regularEvents;
          })()
        },
        slots
      );
    };
  }
});
var link_default = Link;
defineComponent({
  name: "WhenVisible",
  slots: Object,
  props: {
    data: {
      type: [String, Array]
    },
    params: {
      type: Object
    },
    buffer: {
      type: Number,
      default: 0
    },
    as: {
      type: String,
      default: "div"
    },
    always: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      loaded: false,
      fetching: false,
      observer: null
    };
  },
  unmounted() {
    var _a;
    (_a = this.observer) == null ? void 0 : _a.disconnect();
  },
  computed: {
    keys() {
      return this.data ? Array.isArray(this.data) ? this.data : [this.data] : [];
    }
  },
  created() {
    const page2 = usePage();
    this.$watch(
      () => this.keys.map((key2) => page2.props[key2]),
      () => {
        const exists = this.keys.length > 0 && this.keys.every((key2) => page2.props[key2] !== void 0);
        this.loaded = exists;
        if (exists && !this.always) {
          return;
        }
        if (!this.observer || !exists) {
          this.$nextTick(this.registerObserver);
        }
      },
      { immediate: true }
    );
  },
  methods: {
    registerObserver() {
      var _a;
      if (typeof window === "undefined") {
        return;
      }
      (_a = this.observer) == null ? void 0 : _a.disconnect();
      this.observer = new IntersectionObserver(
        (entries) => {
          if (!entries[0].isIntersecting) {
            return;
          }
          if (this.fetching) {
            return;
          }
          if (!this.always && this.loaded) {
            return;
          }
          this.fetching = true;
          const reloadParams = this.getReloadParams();
          router.reload({
            ...reloadParams,
            onStart: (e) => {
              var _a2;
              this.fetching = true;
              (_a2 = reloadParams.onStart) == null ? void 0 : _a2.call(reloadParams, e);
            },
            onFinish: (e) => {
              var _a2, _b;
              this.loaded = true;
              this.fetching = false;
              (_a2 = reloadParams.onFinish) == null ? void 0 : _a2.call(reloadParams, e);
              if (!this.always) {
                (_b = this.observer) == null ? void 0 : _b.disconnect();
              }
            }
          });
        },
        {
          rootMargin: `${this.$props.buffer}px`
        }
      );
      this.observer.observe(this.$el.nextSibling);
    },
    getReloadParams() {
      const reloadParams = { ...this.$props.params };
      if (this.$props.data) {
        reloadParams.only = Array.isArray(this.$props.data) ? this.$props.data : [this.$props.data];
      }
      return reloadParams;
    }
  },
  render() {
    const els = [];
    if (this.$props.always || !this.loaded) {
      els.push(h(this.$props.as));
    }
    if (!this.loaded) {
      els.push(this.$slots.fallback ? this.$slots.fallback({}) : null);
    } else if (this.$slots.default) {
      els.push(this.$slots.default({ fetching: this.fetching }));
    }
    return els;
  }
});
var config = config$1.extend({});
async function resolvePageComponent(path, pages) {
  for (const p of Array.isArray(path) ? path : [path]) {
    const page2 = pages[p];
    if (typeof page2 === "undefined") {
      continue;
    }
    return typeof page2 === "function" ? page2() : page2;
  }
  throw new Error(`Page not found: ${path}`);
}
function r() {
  return r = Object.assign ? Object.assign.bind() : function(t) {
    for (var e = 1; e < arguments.length; e++) {
      var r2 = arguments[e];
      for (var n2 in r2) ({}).hasOwnProperty.call(r2, n2) && (t[n2] = r2[n2]);
    }
    return t;
  }, r.apply(null, arguments);
}
class n {
  constructor(t, e, r2) {
    var n2, i2;
    this.name = t, this.definition = e, this.bindings = null != (n2 = e.bindings) ? n2 : {}, this.wheres = null != (i2 = e.wheres) ? i2 : {}, this.config = r2;
  }
  get template() {
    const t = `${this.origin}/${this.definition.uri}`.replace(/\/+$/, "");
    return "" === t ? "/" : t;
  }
  get origin() {
    return this.config.absolute ? this.definition.domain ? `${this.config.url.match(/^\w+:\/\//)[0]}${this.definition.domain}${this.config.port ? `:${this.config.port}` : ""}` : this.config.url : "";
  }
  get parameterSegments() {
    var t, e;
    return null != (t = null == (e = this.template.match(/{[^}?]+\??}/g)) ? void 0 : e.map((t2) => ({ name: t2.replace(/{|\??}/g, ""), required: !/\?}$/.test(t2) }))) ? t : [];
  }
  matchesUrl(e) {
    var r2;
    if (!this.definition.methods.includes("GET")) return false;
    const n2 = this.template.replace(/[.*+$()[\]]/g, "\\$&").replace(/(\/?){([^}?]*)(\??)}/g, (t, e2, r3, n3) => {
      var i3;
      const s3 = `(?<${r3}>${(null == (i3 = this.wheres[r3]) ? void 0 : i3.replace(/(^\^)|(\$$)/g, "")) || "[^/?]+"})`;
      return n3 ? `(${e2}${s3})?` : `${e2}${s3}`;
    }).replace(/^\w+:\/\//, ""), [i2, s2] = e.replace(/^\w+:\/\//, "").split("?"), o2 = null != (r2 = new RegExp(`^${n2}/?$`).exec(i2)) ? r2 : new RegExp(`^${n2}/?$`).exec(decodeURI(i2));
    if (o2) {
      for (const t in o2.groups) o2.groups[t] = "string" == typeof o2.groups[t] ? decodeURIComponent(o2.groups[t]) : o2.groups[t];
      return { params: o2.groups, query: parse(s2) };
    }
    return false;
  }
  compile(t) {
    return this.parameterSegments.length ? this.template.replace(/{([^}?]+)(\??)}/g, (e, r2, n2) => {
      var i2, s2;
      if (!n2 && [null, void 0].includes(t[r2])) throw new Error(`Ziggy error: '${r2}' parameter is required for route '${this.name}'.`);
      if (this.wheres[r2] && !new RegExp(`^${n2 ? `(${this.wheres[r2]})?` : this.wheres[r2]}$`).test(null != (s2 = t[r2]) ? s2 : "")) throw new Error(`Ziggy error: '${r2}' parameter '${t[r2]}' does not match required format '${this.wheres[r2]}' for route '${this.name}'.`);
      return encodeURI(null != (i2 = t[r2]) ? i2 : "").replace(/%7C/g, "|").replace(/%25/g, "%").replace(/\$/g, "%24");
    }).replace(this.config.absolute ? /(\.[^/]+?)(\/\/)/ : /(^)(\/\/)/, "$1/").replace(/\/+$/, "") : this.template;
  }
}
class i extends String {
  constructor(t, e, i2 = true, s2) {
    if (super(), this.t = null != s2 ? s2 : "undefined" != typeof Ziggy ? Ziggy : null == globalThis ? void 0 : globalThis.Ziggy, !this.t && "undefined" != typeof document && document.getElementById("ziggy-routes-json") && (globalThis.Ziggy = JSON.parse(document.getElementById("ziggy-routes-json").textContent), this.t = globalThis.Ziggy), this.t = r({}, this.t, { absolute: i2 }), t) {
      if (!this.t.routes[t]) throw new Error(`Ziggy error: route '${t}' is not in the route list.`);
      this.i = new n(t, this.t.routes[t], this.t), this.o = this.u(e);
    }
  }
  toString() {
    const t = Object.keys(this.o).filter((t2) => !this.i.parameterSegments.some(({ name: e }) => e === t2)).filter((t2) => "_query" !== t2).reduce((t2, e) => r({}, t2, { [e]: this.o[e] }), {});
    return this.i.compile(this.o) + stringify(r({}, t, this.o._query), { addQueryPrefix: true, arrayFormat: "indices", encodeValuesOnly: true, skipNulls: true, encoder: (t2, e) => "boolean" == typeof t2 ? Number(t2) : e(t2) });
  }
  h(t) {
    t ? this.t.absolute && t.startsWith("/") && (t = this.l().host + t) : t = this.m();
    let e = {};
    const [i2, s2] = Object.entries(this.t.routes).find(([r2, i3]) => e = new n(r2, i3, this.t).matchesUrl(t)) || [void 0, void 0];
    return r({ name: i2 }, e, { route: s2 });
  }
  m() {
    const { host: t, pathname: e, search: r2 } = this.l();
    return (this.t.absolute ? t + e : e.replace(this.t.url.replace(/^\w*:\/\/[^/]+/, ""), "").replace(/^\/+/, "/")) + r2;
  }
  current(t, e) {
    const { name: i2, params: s2, query: o2, route: u } = this.h();
    if (!t) return i2;
    const h2 = new RegExp(`^${t.replace(/\./g, "\\.").replace(/\*/g, ".*")}$`).test(i2);
    if ([null, void 0].includes(e) || !h2) return h2;
    const a = new n(i2, u, this.t);
    e = this.u(e, a);
    const l = r({}, s2, o2);
    if (Object.values(e).every((t2) => !t2) && !Object.values(l).some((t2) => void 0 !== t2)) return true;
    const c = (t2, e2) => Object.entries(t2).every(([t3, r2]) => Array.isArray(r2) && Array.isArray(e2[t3]) ? r2.every((r3) => e2[t3].includes(r3) || e2[t3].includes(decodeURIComponent(r3))) : "object" == typeof r2 && "object" == typeof e2[t3] && null !== r2 && null !== e2[t3] ? c(r2, e2[t3]) : e2[t3] == r2 || e2[t3] == decodeURIComponent(r2));
    return c(e, l);
  }
  l() {
    var t, e, r2, n2, i2, s2;
    const { host: o2 = "", pathname: u = "", search: h2 = "" } = "undefined" != typeof window ? window.location : {};
    return { host: null != (t = null == (e = this.t.location) ? void 0 : e.host) ? t : o2, pathname: null != (r2 = null == (n2 = this.t.location) ? void 0 : n2.pathname) ? r2 : u, search: null != (i2 = null == (s2 = this.t.location) ? void 0 : s2.search) ? i2 : h2 };
  }
  get params() {
    const { params: t, query: e } = this.h();
    return r({}, t, e);
  }
  get routeParams() {
    return this.h().params;
  }
  get queryParams() {
    return this.h().query;
  }
  has(t) {
    return this.t.routes.hasOwnProperty(t);
  }
  u(t = {}, e = this.i) {
    null != t || (t = {}), t = ["string", "number"].includes(typeof t) ? [t] : t;
    const n2 = e.parameterSegments.filter(({ name: t2 }) => !this.t.defaults[t2]);
    return Array.isArray(t) ? t = t.reduce((t2, e2, i2) => r({}, t2, n2[i2] ? { [n2[i2].name]: e2 } : "object" == typeof e2 ? e2 : { [e2]: "" }), {}) : 1 !== n2.length || t.hasOwnProperty(n2[0].name) || !t.hasOwnProperty(Object.values(e.bindings)[0]) && !t.hasOwnProperty("id") || (t = { [n2[0].name]: t }), r({}, this.p(e), this.$(t, e));
  }
  p(t) {
    return t.parameterSegments.filter(({ name: t2 }) => this.t.defaults[t2]).reduce((t2, { name: e }, n2) => r({}, t2, { [e]: this.t.defaults[e] }), {});
  }
  $(t, { bindings: e, parameterSegments: n2 }) {
    return Object.entries(t).reduce((t2, [i2, s2]) => {
      if (!s2 || "object" != typeof s2 || Array.isArray(s2) || !n2.some(({ name: t3 }) => t3 === i2)) return r({}, t2, { [i2]: s2 });
      const o2 = s2.hasOwnProperty(e[i2]) ? e[i2] : s2.hasOwnProperty("id") ? "id" : void 0;
      if (void 0 === o2) throw new Error(`Ziggy error: object passed as '${i2}' parameter is missing route model binding key '${e[i2]}'.`);
      return r({}, t2, { [i2]: s2[o2] });
    }, {});
  }
  valueOf() {
    return this.toString();
  }
}
function s(t, e, r2, n2) {
  const s2 = new i(t, e, r2, n2);
  return t ? s2.toString() : s2;
}
const o = { install(t, e) {
  const r2 = (t2, r3, n2, i2 = e) => s(t2, r3, n2, i2);
  parseInt(t.version) > 2 ? (t.config.globalProperties.route = r2, t.provide("route", r2)) : t.mixin({ methods: { route: r2 } });
} };
const _sfc_main$6 = /* @__PURE__ */ defineComponent({
  __name: "ButtonIcon",
  __ssrInlineRender: true,
  props: {
    name: {},
    hoverName: {}
  },
  setup(__props) {
    const icons = {
      "arrow-left": ArrowLeft,
      "arrow-right": ArrowRight,
      "arrow-up-right": ArrowUpRight,
      "chevron-right": ChevronRight,
      check: Check,
      "check-circle": CheckCircle,
      "circle-plus": CirclePlus,
      download: Download,
      "external-link": ExternalLink,
      eye: Eye,
      "file-text": FileText,
      mail: Mail,
      "message-circle": MessageCircle,
      phone: Phone,
      play: Play,
      send: Send,
      "shopping-cart": ShoppingCart,
      sparkles: Sparkles,
      star: Star,
      user: User,
      palette: Palette,
      video: Video,
      megaphone: Megaphone,
      "share-2": Share2
    };
    const props = __props;
    const isImage = (name) => Boolean(name && (name.startsWith("/") || name.startsWith("http://") || name.startsWith("https://")));
    const effectiveName = () => props.name || props.hoverName;
    const hasHoverIcon = () => Boolean(
      props.name && props.hoverName && (isImage(props.hoverName) || icons[props.hoverName])
    );
    return (_ctx, _push, _parent, _attrs) => {
      if (hasHoverIcon()) {
        _push(`<span${ssrRenderAttrs(mergeProps({
          class: "relative inline-flex size-[1em] shrink-0",
          "aria-hidden": "true"
        }, _attrs))}>`);
        if (isImage(props.name)) {
          _push(`<img${ssrRenderAttr("src", props.name)} alt="" class="size-full object-contain transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0">`);
        } else if (props.name && icons[props.name]) {
          ssrRenderVNode(_push, createVNode(resolveDynamicComponent(icons[props.name]), { class: "size-full transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0" }, null), _parent);
        } else {
          _push(`<!---->`);
        }
        if (isImage(props.hoverName)) {
          _push(`<img${ssrRenderAttr("src", props.hoverName)} alt="" class="absolute inset-0 size-full object-contain opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100">`);
        } else if (props.hoverName && icons[props.hoverName]) {
          ssrRenderVNode(_push, createVNode(resolveDynamicComponent(icons[props.hoverName]), { class: "absolute inset-0 size-full opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100" }, null), _parent);
        } else {
          _push(`<!---->`);
        }
        _push(`</span>`);
      } else if (isImage(effectiveName())) {
        _push(`<img${ssrRenderAttrs(mergeProps({
          src: effectiveName(),
          alt: "",
          class: "size-[1em] shrink-0 object-contain",
          "aria-hidden": "true"
        }, _attrs))}>`);
      } else if (effectiveName() && icons[effectiveName()]) {
        ssrRenderVNode(_push, createVNode(resolveDynamicComponent(icons[effectiveName()]), mergeProps({
          class: "size-[1em] shrink-0",
          "aria-hidden": "true"
        }, _attrs), null), _parent);
      } else {
        _push(`<!---->`);
      }
    };
  }
});
const _sfc_setup$6 = _sfc_main$6.setup;
_sfc_main$6.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/ButtonIcon.vue");
  return _sfc_setup$6 ? _sfc_setup$6(props, ctx) : void 0;
};
const _sfc_main$5 = /* @__PURE__ */ defineComponent({
  __name: "BrandLogo",
  __ssrInlineRender: true,
  props: {
    variant: { default: "full" },
    height: { default: 48 },
    label: { default: "Sahra" }
  },
  setup(__props) {
    const sources = {
      // Vector export of Figma 158:156 — the mark is 13 paths, never rasterise it.
      full: "/icons/sahra/logo-full.svg",
      mark: "/icons/sahra/logo-mark.svg",
      footer: "/icons/sahra/logo-footer.svg"
    };
    const ratios = {
      full: 212 / 91,
      mark: 1,
      footer: 87 / 28
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<img${ssrRenderAttrs(mergeProps({
        src: sources[__props.variant],
        alt: __props.label,
        height: __props.height,
        width: Math.round(__props.height * ratios[__props.variant]),
        "aria-hidden": __props.label === "" ? "true" : void 0,
        class: "shrink-0",
        decoding: "async"
      }, _attrs))}>`);
    };
  }
});
const _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/BrandLogo.vue");
  return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
const _sfc_main$4 = /* @__PURE__ */ defineComponent({
  __name: "LanguageSwitcher",
  __ssrInlineRender: true,
  setup(__props) {
    const page2 = usePage();
    const root = ref(null);
    function close() {
      if (root.value) root.value.open = false;
    }
    onClickOutside(root, close);
    onKeyStroke("Escape", close);
    function isCurrent(code) {
      return code === page2.props.locale.current;
    }
    const currentLabel = computed(
      () => {
        var _a;
        return ((_a = page2.props.locale.supported.find((o2) => isCurrent(o2.code))) == null ? void 0 : _a.native) ?? page2.props.locale.current.toUpperCase();
      }
    );
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<details${ssrRenderAttrs(mergeProps({
        ref_key: "root",
        ref: root,
        class: "relative"
      }, _attrs))}><summary class="flex cursor-pointer list-none items-center gap-2 rounded-xs p-2 text-label-lg text-neutral-800 transition-colors hover:text-gold focus-visible:ring-2 focus-visible:ring-gold [&amp;::-webkit-details-marker]:hidden"${ssrRenderAttr("aria-label", _ctx.$t("common.change_language"))}><span class="flex items-center gap-1">`);
      _push(ssrRenderComponent(unref(Globe), {
        class: "size-5",
        "aria-hidden": "true"
      }, null, _parent));
      _push(`<span>${ssrInterpolate(currentLabel.value)}</span></span>`);
      _push(ssrRenderComponent(unref(ChevronDown), {
        class: "size-5 transition-transform [details[open]_&]:rotate-180",
        "aria-hidden": "true"
      }, null, _parent));
      _push(`</summary><ul class="absolute inset-inline-end-0 top-full z-menu mt-2 min-w-44 overflow-hidden rounded-sm border border-neutral-100 bg-paper py-1 shadow-card"><!--[-->`);
      ssrRenderList(unref(page2).props.locale.supported, (option) => {
        _push(`<li><a${ssrRenderAttr("href", unref(page2).props.alternates[option.code])}${ssrRenderAttr("lang", option.code)}${ssrRenderAttr("dir", option.direction)}${ssrRenderAttr("aria-current", isCurrent(option.code) ? "true" : void 0)} class="${ssrRenderClass([isCurrent(option.code) ? "text-gold" : "text-neutral-800", "flex w-full items-center justify-between gap-3 px-4 py-3 text-start text-body-md transition-colors hover:bg-gold hover:text-white focus-visible:bg-gold focus-visible:text-white focus-visible:outline-none"])}"><span>${ssrInterpolate(option.native)}</span>`);
        if (isCurrent(option.code)) {
          _push(ssrRenderComponent(unref(Check), {
            class: "size-4 shrink-0",
            "aria-hidden": "true"
          }, null, _parent));
        } else {
          _push(`<!---->`);
        }
        _push(`</a></li>`);
      });
      _push(`<!--]--></ul></details>`);
    };
  }
});
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/LanguageSwitcher.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
function resolve$1(translations, key2) {
  const value = key2.split(".").reduce(
    (carry, segment) => carry && typeof carry === "object" ? carry[segment] : void 0,
    translations
  );
  return typeof value === "string" ? value : void 0;
}
function interpolate(line, replacements) {
  return Object.entries(replacements).reduce(
    (carry, [token, value]) => carry.replace(new RegExp(`:${token}\\b`, "g"), String(value)).replace(new RegExp(`\\{${token}\\}`, "g"), String(value)),
    line
  );
}
function useTranslations() {
  const page2 = usePage();
  function t(key2, replacements = {}) {
    const line = resolve$1(page2.props.translations ?? {}, key2);
    if (line === void 0) {
      return key2;
    }
    return interpolate(line, replacements);
  }
  function tChoice(key2, count, replacements = {}) {
    const line = t(key2, { ...replacements, count });
    const [singular, plural] = line.split("|");
    return count === 1 ? singular : plural ?? singular;
  }
  return { t, tChoice };
}
function installTranslations(app) {
  app.config.globalProperties.$t = (key2, replacements = {}) => {
    const { t } = useTranslations();
    return t(key2, replacements);
  };
}
const _sfc_main$3 = /* @__PURE__ */ defineComponent({
  __name: "MobileMenu",
  __ssrInlineRender: true,
  props: {
    "open": { type: Boolean, ...{ default: false } },
    "openModifiers": {}
  },
  emits: ["update:open"],
  setup(__props) {
    const open = useModel(__props, "open");
    const page2 = usePage();
    const { t } = useTranslations();
    const closeButton = ref(null);
    const scrollLocked = useScrollLock(
      typeof document !== "undefined" ? document.body : null
    );
    const items = computed(() => page2.props.navigation.header.filter((i2) => !i2.isCta));
    const cta = computed(() => page2.props.navigation.header.find((i2) => i2.isCta) ?? null);
    function isActive(url) {
      const current = new URL(page2.url, window.location.origin).pathname;
      const target = new URL(url, window.location.origin).pathname;
      const homePath = `/${page2.props.locale.current}`;
      if (target === homePath) return current === homePath;
      return current === target || current.startsWith(`${target}/`);
    }
    watch(open, async (isOpen) => {
      var _a;
      scrollLocked.value = isOpen;
      if (isOpen) {
        await nextTick();
        (_a = closeButton.value) == null ? void 0 : _a.focus();
      }
    });
    onKeyStroke("Escape", () => {
      if (open.value) open.value = false;
    });
    watch(
      () => page2.url,
      () => {
        open.value = false;
      }
    );
    return (_ctx, _push, _parent, _attrs) => {
      ssrRenderTeleport(_push, (_push2) => {
        if (open.value) {
          _push2(`<div class="fixed inset-0 z-overlay bg-ink/40 lg:hidden" aria-hidden="true" data-v-90f312d6></div>`);
        } else {
          _push2(`<!---->`);
        }
        if (open.value) {
          _push2(`<div role="dialog" aria-modal="true"${ssrRenderAttr("aria-label", unref(t)("common.primary_navigation"))} class="fixed end-0 top-0 z-menu flex h-dvh w-[min(88vw,22rem)] min-h-0 flex-col bg-paper pb-safe pt-safe shadow-card lg:hidden" data-v-90f312d6><div class="flex items-center justify-between px-5 py-6" data-v-90f312d6>`);
          _push2(ssrRenderComponent(_sfc_main$5, {
            variant: "full",
            height: 40,
            label: ""
          }, null, _parent));
          _push2(`<button type="button" class="touch-target -me-2 inline-flex size-11 items-center justify-center rounded-sm text-neutral-900"${ssrRenderAttr("aria-label", unref(t)("common.close_menu"))} data-v-90f312d6>`);
          _push2(ssrRenderComponent(unref(X), {
            class: "size-6",
            "aria-hidden": "true"
          }, null, _parent));
          _push2(`</button></div><nav class="flex-1 overflow-y-auto px-5"${ssrRenderAttr("aria-label", unref(t)("common.primary_navigation"))} data-v-90f312d6><ul class="flex flex-col" data-v-90f312d6><!--[-->`);
          ssrRenderList(items.value, (item) => {
            _push2(`<li class="border-b border-neutral-100" data-v-90f312d6>`);
            _push2(ssrRenderComponent(unref(link_default), {
              href: item.url,
              target: item.target,
              class: ["block py-5 text-title-md transition-colors hover:text-gold", isActive(item.url) ? "font-medium text-ink" : "text-neutral-800"],
              "aria-current": isActive(item.url) ? "page" : void 0,
              onClick: ($event) => open.value = false
            }, {
              default: withCtx((_, _push3, _parent2, _scopeId) => {
                if (_push3) {
                  _push3(`${ssrInterpolate(item.label)}`);
                } else {
                  return [
                    createTextVNode(toDisplayString(item.label), 1)
                  ];
                }
              }),
              _: 2
            }, _parent));
            _push2(`</li>`);
          });
          _push2(`<!--]--></ul></nav><div class="flex flex-col gap-4 border-t border-neutral-100 px-5 py-6" data-v-90f312d6>`);
          if (cta.value) {
            _push2(ssrRenderComponent(unref(link_default), {
              href: cta.value.url,
              class: "inline-flex items-center justify-center rounded-sm bg-ink px-6 py-4 text-label-lg text-paper transition-colors hover:bg-gold hover:text-white group",
              onClick: ($event) => open.value = false
            }, {
              default: withCtx((_, _push3, _parent2, _scopeId) => {
                if (_push3) {
                  _push3(`${ssrInterpolate(cta.value.label)} `);
                  _push3(ssrRenderComponent(_sfc_main$6, {
                    name: cta.value.icon,
                    "hover-name": cta.value.hoverIcon
                  }, null, _parent2, _scopeId));
                } else {
                  return [
                    createTextVNode(toDisplayString(cta.value.label) + " ", 1),
                    createVNode(_sfc_main$6, {
                      name: cta.value.icon,
                      "hover-name": cta.value.hoverIcon
                    }, null, 8, ["name", "hover-name"])
                  ];
                }
              }),
              _: 1
            }, _parent));
          } else {
            _push2(`<!---->`);
          }
          _push2(`</div></div>`);
        } else {
          _push2(`<!---->`);
        }
      }, "body", false, _parent);
    };
  }
});
const _export_sfc = (sfc, props) => {
  const target = sfc.__vccOpts || sfc;
  for (const [key2, val] of props) {
    target[key2] = val;
  }
  return target;
};
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/MobileMenu.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const MobileMenu = /* @__PURE__ */ _export_sfc(_sfc_main$3, [["__scopeId", "data-v-90f312d6"]]);
const _sfc_main$2 = /* @__PURE__ */ defineComponent({
  __name: "AppHeader",
  __ssrInlineRender: true,
  props: {
    minimal: { type: Boolean }
  },
  setup(__props) {
    const page2 = usePage();
    const { t } = useTranslations();
    const mobileOpen = ref(false);
    const navItems = computed(() => {
      var _a;
      return ((_a = page2.props.navigation) == null ? void 0 : _a.header) ?? [];
    });
    const items = computed(() => navItems.value.filter((i2) => !i2.isCta));
    const cta = computed(() => navItems.value.find((i2) => i2.isCta) ?? null);
    const currentLocale = computed(() => {
      var _a;
      return ((_a = page2.props.locale) == null ? void 0 : _a.current) ?? "en";
    });
    const siteName = computed(() => {
      var _a;
      return ((_a = page2.props.settings) == null ? void 0 : _a.siteName) ?? "Sahra";
    });
    function isActive(url) {
      const current = new URL(page2.url, "http://sahra.local").pathname;
      const target = new URL(url, "http://sahra.local").pathname;
      const homePath = `/${currentLocale.value}`;
      if (target === homePath) return current === homePath;
      return current === target || current.startsWith(`${target}/`);
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><header class="pointer-events-none fixed inset-inline-0 top-0 z-header backdrop-blur-header bg-white/5"><div class="${ssrRenderClass([__props.minimal ? "justify-between" : "lg:gap-[262px]", "mx-auto flex w-full max-w-frame items-center px-5 py-6 lg:px-24"])}">`);
      _push(ssrRenderComponent(unref(link_default), {
        href: `/${currentLocale.value}`,
        class: "pointer-events-auto w-[120px] shrink-0 rounded-sm focus-visible:ring-2 focus-visible:ring-gold lg:w-[140px]",
        "aria-label": siteName.value
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$5, {
              variant: "full",
              height: 56,
              label: siteName.value,
              class: "h-[48px] w-[120px] lg:h-[56px] lg:w-[140px]"
            }, null, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$5, {
                variant: "full",
                height: 56,
                label: siteName.value,
                class: "h-[48px] w-[120px] lg:h-[56px] lg:w-[140px]"
              }, null, 8, ["label"])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<div class="${ssrRenderClass([__props.minimal ? "ms-auto" : "w-[846px] justify-between", "pointer-events-auto hidden items-center lg:flex"])}">`);
      if (!__props.minimal) {
        _push(`<nav${ssrRenderAttr("aria-label", unref(t)("common.primary_navigation"))}><ul class="flex items-center gap-6"><!--[-->`);
        ssrRenderList(items.value, (item) => {
          _push(`<li>`);
          _push(ssrRenderComponent(unref(link_default), {
            href: item.url,
            target: item.target,
            class: ["flex items-center justify-center px-1 py-1 text-title-sm transition-colors", isActive(item.url) ? "font-medium text-ink" : "font-medium text-neutral-800 hover:text-ink"],
            "aria-current": isActive(item.url) ? "page" : void 0
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(`${ssrInterpolate(item.label)}`);
              } else {
                return [
                  createTextVNode(toDisplayString(item.label), 1)
                ];
              }
            }),
            _: 2
          }, _parent));
          _push(`</li>`);
        });
        _push(`<!--]--></ul></nav>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="flex items-center justify-center gap-4">`);
      if (!__props.minimal) {
        _push(ssrRenderComponent(_sfc_main$4, null, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (cta.value) {
        _push(ssrRenderComponent(unref(link_default), {
          href: cta.value.url,
          class: "group flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-title-sm text-paper transition-colors hover:bg-gold hover:text-white"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`${ssrInterpolate(cta.value.label)} `);
              _push2(ssrRenderComponent(_sfc_main$6, {
                name: cta.value.icon,
                "hover-name": cta.value.hoverIcon
              }, null, _parent2, _scopeId));
            } else {
              return [
                createTextVNode(toDisplayString(cta.value.label) + " ", 1),
                createVNode(_sfc_main$6, {
                  name: cta.value.icon,
                  "hover-name": cta.value.hoverIcon
                }, null, 8, ["name", "hover-name"])
              ];
            }
          }),
          _: 1
        }, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div>`);
      if (!__props.minimal) {
        _push(`<div class="pointer-events-auto ms-auto flex items-center gap-1 lg:hidden">`);
        _push(ssrRenderComponent(_sfc_main$4, null, null, _parent));
        _push(`<button type="button" class="touch-target -me-2 inline-flex size-11 items-center justify-center rounded-sm text-ink"${ssrRenderAttr("aria-label", unref(t)("common.open_menu"))} aria-haspopup="dialog"${ssrRenderAttr("aria-expanded", mobileOpen.value)}>`);
        _push(ssrRenderComponent(unref(Menu), {
          class: "size-6",
          "aria-hidden": "true"
        }, null, _parent));
        _push(`</button></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></header>`);
      _push(ssrRenderComponent(MobileMenu, {
        open: mobileOpen.value,
        "onUpdate:open": ($event) => mobileOpen.value = $event
      }, null, _parent));
      _push(`<!--]-->`);
    };
  }
});
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/AppHeader.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "AppFooter",
  __ssrInlineRender: true,
  setup(__props) {
    const page2 = usePage();
    const { t } = useTranslations();
    const columns = computed(() => page2.props.navigation.footer);
    const settings = computed(() => page2.props.settings);
    const year = (/* @__PURE__ */ new Date()).getFullYear();
    const privacyUrl = computed(() => `/${page2.props.locale.current}/privacy-policy`);
    const termsUrl = computed(() => `/${page2.props.locale.current}/terms`);
    const footerFont = computed(
      () => page2.props.locale.font === "arabic" ? "font-arabic" : "font-sans"
    );
    function columnHeading(index, fallback) {
      if (index === 0) return t("footer.quick_links");
      if (index === 1) return t("footer.social_links");
      return fallback;
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<footer${ssrRenderAttrs(mergeProps({
        class: ["relative overflow-hidden rounded-t-lg border-t border-neutral-100 bg-paper shadow-[0_-5px_10px_rgba(0,0,0,0.05)]", footerFont.value],
        lang: unref(page2).props.locale.htmlLang,
        dir: unref(page2).props.locale.direction
      }, _attrs))}><div class="container-sahra relative py-6 md:py-12"><div class="relative z-10 flex flex-col gap-2 md:gap-10"><div class="grid gap-10 md:grid-cols-2 lg:flex lg:items-start lg:justify-between lg:gap-0"><div class="flex max-w-[402px] flex-col items-start gap-4 md:gap-8">`);
      _push(ssrRenderComponent(_sfc_main$5, {
        variant: "footer",
        height: 28,
        label: settings.value.siteName,
        class: "h-[28px] w-[87px]"
      }, null, _parent));
      _push(`<p class="text-[12px] font-normal leading-normal text-neutral-600 md:text-[16px]">${ssrInterpolate(settings.value.description)}</p></div><div class="grid grid-cols-2 gap-x-10 gap-y-10 lg:flex lg:shrink-0 lg:items-start lg:gap-[88px]"><!--[-->`);
      ssrRenderList(columns.value, (column, columnIndex) => {
        _push(`<nav${ssrRenderAttr("aria-label", columnHeading(columnIndex, column.label))}><h2 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-[16px]">${ssrInterpolate(columnHeading(columnIndex, column.label))}</h2><ul class="mt-3 flex flex-col items-start gap-2 md:mt-4 md:gap-3"><!--[-->`);
        ssrRenderList(column.children, (child) => {
          _push(`<li class="text-[14px] leading-normal">`);
          _push(ssrRenderComponent(unref(link_default), {
            href: child.url,
            target: child.target,
            rel: child.target === "_blank" ? "noopener noreferrer" : void 0,
            class: "text-[14px] font-normal leading-normal text-neutral-600 transition-colors hover:text-gold md:font-medium"
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                _push2(`${ssrInterpolate(child.label)}`);
              } else {
                return [
                  createTextVNode(toDisplayString(child.label), 1)
                ];
              }
            }),
            _: 2
          }, _parent));
          _push(`</li>`);
        });
        _push(`<!--]--></ul></nav>`);
      });
      _push(`<!--]--><div class="col-span-2 lg:col-span-1"><h2 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-[16px]">${ssrInterpolate(unref(t)("footer.info"))}</h2><ul class="mt-3 flex flex-col gap-2 text-[14px] font-normal leading-normal text-neutral-600 md:mt-4 md:gap-3 md:font-medium">`);
      if (settings.value.contact.location) {
        _push(`<li class="flex items-center gap-2">`);
        _push(ssrRenderComponent(unref(MapPin), {
          class: "size-4 shrink-0 text-neutral-600",
          "aria-hidden": "true"
        }, null, _parent));
        _push(`<span>${ssrInterpolate(settings.value.contact.location)}</span></li>`);
      } else {
        _push(`<!---->`);
      }
      if (settings.value.contact.phone) {
        _push(`<li class="flex items-center gap-2">`);
        _push(ssrRenderComponent(unref(Phone), {
          class: "size-4 shrink-0 text-neutral-600",
          "aria-hidden": "true"
        }, null, _parent));
        _push(`<a${ssrRenderAttr("href", `tel:${settings.value.contact.phone.replace(/\s/g, "")}`)} class="latin-nums transition-colors hover:text-gold">${ssrInterpolate(settings.value.contact.phone)}</a></li>`);
      } else {
        _push(`<!---->`);
      }
      if (settings.value.contact.email) {
        _push(`<li class="flex items-center gap-2">`);
        _push(ssrRenderComponent(unref(Mail), {
          class: "size-4 shrink-0 text-neutral-600",
          "aria-hidden": "true"
        }, null, _parent));
        _push(`<a${ssrRenderAttr("href", `mailto:${settings.value.contact.email}`)} class="break-all transition-colors hover:text-gold">${ssrInterpolate(settings.value.contact.email)}</a></li>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</ul></div></div></div><div class="relative z-10 flex flex-col items-start justify-between gap-4 border-t border-neutral-300 py-6 text-[12px] font-medium leading-normal text-neutral-600 sm:flex-row sm:items-center sm:gap-3 sm:text-[14px]"><p>${ssrInterpolate(unref(t)("footer.copyright", { year: unref(year), name: settings.value.siteName }))}</p><div class="flex items-center gap-4">`);
      _push(ssrRenderComponent(unref(link_default), {
        href: privacyUrl.value,
        class: "underline transition-colors hover:text-gold"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(unref(t)("footer.privacy_policy"))}`);
          } else {
            return [
              createTextVNode(toDisplayString(unref(t)("footer.privacy_policy")), 1)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(unref(link_default), {
        href: termsUrl.value,
        class: "underline transition-colors hover:text-gold"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(unref(t)("footer.terms"))}`);
          } else {
            return [
              createTextVNode(toDisplayString(unref(t)("footer.terms")), 1)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div></div></div><img src="/icons/sahra/footer-wordmark.svg" alt="" width="1248" height="305" class="pointer-events-none absolute inset-inline-0 bottom-0 w-full translate-y-[45.15%] select-none" aria-hidden="true" decoding="async"></div></footer>`);
    };
  }
});
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/AppFooter.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
gsap.registerPlugin(ScrollTrigger, CustomEase);
CustomEase.create("sahraOpen", "M0,0 C0.22,1 0.36,1 1,1");
CustomEase.create("sahraSpread", "M0,0 C0.171,0.338 0.426,1 1,1");
const MOTION = {
  ease: {
    /** Matches Tailwind's `ease-brand` — used for hover + reveal. */
    brand: "power3.out",
    /** Snappier, for small state changes. */
    quick: "power2.out",
    /** cubic-bezier(0.171, 0.338, 0.426, 1) — the services diagram opening. */
    spread: "sahraSpread",
    /** Linear — marquees and scrub only. */
    none: "none"
  },
  duration: {
    hero: 0.6,
    reveal: 0.7,
    counter: 2,
    /** Services diagram, opening Venn to finished orbit. 128 frames at 60fps. */
    mastery: 2.13
  },
  stagger: {
    hero: 0.08,
    cards: 0.06
  }
};
function prefersReducedMotion() {
  if (typeof window === "undefined") return false;
  return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
}
function isRtl() {
  if (typeof document === "undefined") return false;
  return document.documentElement.dir === "rtl";
}
function directionFactor() {
  return isRtl() ? -1 : 1;
}
function resolve(target) {
  return typeof target === "function" ? target() : target.value;
}
function useEffectScope(fn, target) {
  let ctx = null;
  let dispose;
  onMounted(() => {
    if (prefersReducedMotion()) return;
    const scope = target ? resolve(target) : null;
    if (target && !scope) return;
    ctx = gsap.context(() => {
      dispose = fn({ scope }) ?? void 0;
    }, scope ?? void 0);
  });
  onUnmounted(() => {
    dispose == null ? void 0 : dispose();
    dispose = void 0;
    ctx == null ? void 0 : ctx.revert();
    ctx = null;
  });
}
const PAPER = "#FFFFFF";
const AXIS_DRAWN = "rgba(189, 147, 59, 1)";
const AXIS_RESTING = "rgba(189, 147, 59, 0.72)";
const REVEAL_START = "top 88%";
const REVEAL_START_TALL = "top 65%";
function isTallerThanViewport(el) {
  return el.getBoundingClientRect().height > window.innerHeight * 0.9;
}
function useSectionReveal(target) {
  useEffectScope(({ scope }) => {
    const root = scope ?? document;
    const groups = Array.from(root.querySelectorAll("[data-reveal-group]"));
    const singles = Array.from(root.querySelectorAll("[data-reveal]")).filter(
      (el) => !el.closest("[data-reveal-group]")
    );
    for (const el of singles) {
      gsap.to(el, {
        y: 0,
        opacity: 1,
        duration: MOTION.duration.reveal,
        ease: MOTION.ease.brand,
        scrollTrigger: {
          trigger: el,
          // Same tall-block handling as the page-level reveal — several of
          // these opted-in blocks (Work/Show's 620px and 488px panels) are
          // taller than a phone viewport.
          start: () => isTallerThanViewport(el) ? REVEAL_START_TALL : REVEAL_START,
          once: true
        }
      });
    }
    for (const group of groups) {
      const children = Array.from(group.querySelectorAll("[data-reveal]"));
      if (children.length === 0) continue;
      for (const row of visualRows(children)) {
        gsap.to(row, {
          y: 0,
          opacity: 1,
          duration: MOTION.duration.reveal,
          ease: MOTION.ease.brand,
          stagger: MOTION.stagger.cards,
          scrollTrigger: {
            trigger: row[0],
            start: () => isTallerThanViewport(row[0]) ? REVEAL_START_TALL : REVEAL_START,
            once: true
          }
        });
      }
    }
  }, target);
}
const ROW_TOLERANCE = 8;
function visualRows(elements) {
  const rows = /* @__PURE__ */ new Map();
  for (const el of elements) {
    const y = el.getBoundingClientRect().top + window.scrollY;
    const key2 = Math.round(y / ROW_TOLERANCE);
    const row = rows.get(key2);
    if (row) row.push(el);
    else rows.set(key2, [el]);
  }
  return [...rows.entries()].sort(([a], [b]) => a - b).map(([, row]) => row);
}
const AUTO_REVEAL_DISTANCE = 20;
function autoRevealTargets(root) {
  const blocks = Array.from(
    root.querySelectorAll("section, [data-reveal-section]")
  );
  const outermost = blocks.filter(
    (el) => !blocks.some((other) => other !== el && other.contains(el))
  );
  const looseTopLevel = Array.from(root.children).filter(
    (el) => el instanceof HTMLElement && !outermost.some(
      (section) => section === el || section.contains(el) || el.contains(section)
    )
  );
  return [...outermost, ...looseTopLevel].filter((el) => {
    if (el.hasAttribute("data-no-reveal")) return false;
    if (el.matches("[data-reveal], [data-reveal-group]")) return false;
    if (el.querySelector("[data-reveal], [data-reveal-group]")) return false;
    return el.getBoundingClientRect().top > window.innerHeight * 0.85;
  });
}
function useAutoReveal(pageKey) {
  let ctx = null;
  function run() {
    ctx == null ? void 0 : ctx.revert();
    ctx = null;
    if (prefersReducedMotion()) return;
    const main = document.getElementById("main");
    if (!main) return;
    const targets = autoRevealTargets(main);
    if (targets.length === 0) return;
    ctx = gsap.context(() => {
      for (const el of targets) {
        gsap.fromTo(
          el,
          { y: AUTO_REVEAL_DISTANCE, opacity: 0 },
          {
            y: 0,
            opacity: 1,
            duration: MOTION.duration.reveal,
            ease: MOTION.ease.brand,
            clearProps: "transform,opacity",
            scrollTrigger: {
              trigger: el,
              // Function form so a resize or orientation change re-measures:
              // a block that was viewport-sized in landscape is a tall stack
              // in portrait, and vice versa.
              start: () => isTallerThanViewport(el) ? REVEAL_START_TALL : REVEAL_START,
              once: true
            }
          }
        );
      }
    }, main);
  }
  onMounted(() => {
    void nextTick(run);
  });
  watch(pageKey, () => {
    void nextTick(() => {
      requestAnimationFrame(() => requestAnimationFrame(run));
    });
  });
  onUnmounted(() => {
    ctx == null ? void 0 : ctx.revert();
    ctx = null;
  });
}
function useHeroStagger(target) {
  useEffectScope(({ scope }) => {
    const children = scope ? Array.from(scope.children) : [];
    if (children.length === 0) return;
    gsap.from(children, {
      y: 24,
      opacity: 0,
      duration: MOTION.duration.hero,
      ease: MOTION.ease.quick,
      stagger: MOTION.stagger.hero,
      clearProps: "transform,opacity"
    });
  }, target);
}
function useCounters(target) {
  useEffectScope(({ scope }) => {
    var _a, _b;
    const root = scope ?? document;
    for (const el of Array.from(root.querySelectorAll("[data-counter]"))) {
      const text = ((_a = el.textContent) == null ? void 0 : _a.trim()) ?? "";
      const match = text.match(/^([^\p{N}]*?)([\p{N}][\p{N},.٬٫]*)([^\p{N}]*)$/u);
      if (!match) continue;
      const [, prefix, digits, suffix] = match;
      const asciiDigits = digits.replace(/[٠-٩]/g, (digit) => String("٠١٢٣٤٥٦٧٨٩".indexOf(digit))).replace(/[۰-۹]/g, (digit) => String("۰۱۲۳۴۵۶۷۸۹".indexOf(digit))).replace(/٬/g, ",").replace(/٫/g, ".");
      const decimals = asciiDigits.includes(".") ? ((_b = asciiDigits.split(".")[1]) == null ? void 0 : _b.length) ?? 0 : 0;
      const endValue = Number(asciiDigits.replace(/,/g, ""));
      if (!Number.isFinite(endValue)) continue;
      const state = { value: 0 };
      const grouped = /[,٬]/.test(digits);
      const groupSeparator = digits.includes("٬") ? "٬" : ",";
      const decimalSeparator = digits.includes("٫") ? "٫" : ".";
      const documentLanguage = document.documentElement.lang.toLowerCase();
      const digitSet = /[٠-٩]/.test(digits) || documentLanguage.startsWith("ar") ? "٠١٢٣٤٥٦٧٨٩" : /[۰-۹]/.test(digits) || documentLanguage.startsWith("fa") ? "۰۱۲۳۴۵۶۷۸۹" : "0123456789";
      gsap.to(state, {
        value: endValue,
        duration: MOTION.duration.counter,
        ease: "power1.out",
        scrollTrigger: { trigger: el, start: "top 90%", once: true },
        onUpdate: () => {
          const shown = grouped ? state.value.toLocaleString("en-US", {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
          }) : state.value.toFixed(decimals);
          const localised = shown.replace(/,/g, groupSeparator).replace(/\./g, decimalSeparator).replace(/\d/g, (digit) => digitSet[Number(digit)] ?? digit);
          el.textContent = `${prefix}${localised}${suffix}`;
        },
        // Snap back to the exact authored string so no rounding artefact sticks.
        onComplete: () => {
          el.textContent = text;
        }
      });
    }
  }, target);
}
function useMasteryOpen(stage, progress) {
  useEffectScope(({ scope }) => {
    if (!scope) return;
    const blob = scope.querySelector('[data-mastery="blob"]');
    if (!blob) return;
    const core = scope.querySelector('[data-mastery="core"]');
    const rings = scope.querySelector('[data-mastery="rings"]');
    const inner = scope.querySelector('[data-mastery="ring-inner"]');
    const outer = scope.querySelector('[data-mastery="ring-outer"]');
    const axis = scope.querySelector('[data-mastery="axis"]');
    const brand = scope.querySelector('[data-mastery-label="left"]');
    const product = scope.querySelector('[data-mastery-label="right"]');
    const coreLabel = scope.querySelector('[data-mastery-label="core"]');
    const { width, height } = scope.getBoundingClientRect();
    if (width === 0) return;
    const mobile = window.matchMedia("(max-width: 639px)").matches;
    const openingSeparation = width * 0.04028;
    const direction = directionFactor();
    const labelTravel = (label, first) => {
      const bounds = label.getBoundingClientRect();
      const labelX = bounds.left + bounds.width / 2;
      const labelY = bounds.top + bounds.height / 2;
      const stageX = scope.getBoundingClientRect().left + width / 2;
      const stageY = scope.getBoundingClientRect().top + height / 2;
      return mobile ? { x: stageX - labelX, y: stageY + (first ? -openingSeparation : openingSeparation) - labelY } : { x: stageX + (first ? -direction : direction) * openingSeparation - labelX, y: stageY - labelY };
    };
    const brandTravel = brand ? labelTravel(brand, true) : { x: 0, y: 0 };
    const productTravel = product ? labelTravel(product, false) : { x: 0, y: 0 };
    const coreTravel = height * 0.46 - 40;
    const spin = { svgOrigin: `${width / 2} ${height / 2}` };
    Object.assign(progress, { t: 0 });
    const tl = gsap.timeline({
      scrollTrigger: { trigger: scope, start: REVEAL_START, once: true }
    });
    tl.set(scope, { opacity: 1 }, 0);
    tl.to(progress, { t: 1, duration: MOTION.duration.mastery, ease: MOTION.ease.none }, 0);
    if (core) {
      tl.fromTo(core, { opacity: 1 }, { opacity: 0, duration: 0.13, ease: MOTION.ease.none }, 0.13);
    }
    if (rings && inner && outer) {
      tl.fromTo(rings, { opacity: 0 }, { opacity: 1, duration: 0.6, ease: MOTION.ease.quick }, 0.35).fromTo(inner, { rotation: -720, ...spin }, { rotation: 0, duration: 1.8, ease: MOTION.ease.quick, ...spin }, 0.2).fromTo(outer, { rotation: 720, ...spin }, { rotation: 0, duration: 1.8, ease: MOTION.ease.quick, ...spin }, 0.2);
    }
    if (axis) {
      tl.fromTo(axis, { opacity: 0 }, { opacity: 1, duration: 0.35, ease: MOTION.ease.quick }, 0.36).fromTo(
        axis,
        { stroke: AXIS_DRAWN },
        { stroke: AXIS_RESTING, duration: 0.9, ease: MOTION.ease.none },
        0.9
      );
    }
    if (brand && product) {
      tl.fromTo(
        [brand, product],
        {
          x: (i2) => i2 === 0 ? brandTravel.x : productTravel.x,
          y: (i2) => i2 === 0 ? brandTravel.y : productTravel.y,
          color: PAPER
        },
        {
          x: 0,
          y: 0,
          color: PAPER,
          duration: 1.2,
          ease: MOTION.ease.spread
        },
        0.05
      );
    }
    if (coreLabel) {
      tl.fromTo(
        coreLabel,
        { y: coreTravel, color: PAPER },
        {
          y: 0,
          color: PAPER,
          duration: 1,
          ease: MOTION.ease.spread
        },
        0.1
      );
    }
  }, stage);
}
function useParallax(target, distance = 40) {
  useEffectScope(({ scope }) => {
    if (!scope) return;
    gsap.fromTo(
      scope,
      { yPercent: -distance / 2 },
      {
        yPercent: distance / 2,
        ease: MOTION.ease.none,
        scrollTrigger: {
          trigger: scope.parentElement ?? scope,
          start: "top bottom",
          end: "bottom top",
          scrub: true
        }
      }
    );
  }, target);
}
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "AppLayout",
  __ssrInlineRender: true,
  setup(__props) {
    const page2 = usePage();
    const flash = computed(() => page2.props.flash ?? { success: null, error: null });
    const isErrorPage = computed(() => page2.component === "Error");
    useAutoReveal(computed(() => page2.component));
    const announcement = computed(() => flash.value.success ?? flash.value.error ?? "");
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$2, { minimal: isErrorPage.value }, null, _parent));
      _push(`<main id="main" class="min-h-screen-safe"><div>`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</div></main>`);
      if (!isErrorPage.value) {
        _push(ssrRenderComponent(_sfc_main$1, null, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`<div role="status" aria-live="polite" aria-atomic="true" class="sr-only">${ssrInterpolate(announcement.value)}</div>`);
      if (flash.value.success && unref(page2).component !== "Contact" || flash.value.error) {
        _push(`<div class="${ssrRenderClass([flash.value.success ? "bg-ink text-paper" : "bg-red-600 text-white", "fixed inset-inline-0 bottom-6 z-modal mx-auto w-fit max-w-[90vw] rounded-sm px-6 py-4 text-body-md shadow-card pb-safe"])}">${ssrInterpolate(flash.value.success ?? flash.value.error)}</div>`);
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/AppLayout.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
createServer(
  (page2) => createInertiaApp({
    page: page2,
    render: renderToString,
    resolve: (name) => {
      const component2 = resolvePageComponent(
        `./Pages/${name}.vue`,
        /* @__PURE__ */ Object.assign({ "./Pages/About.vue": () => import("./assets/About-C1rFoRdQ.js"), "./Pages/Contact.vue": () => import("./assets/Contact-C2p0oy4C.js"), "./Pages/Error.vue": () => import("./assets/Error-CdBv1sSv.js"), "./Pages/Home.vue": () => import("./assets/Home-CG_rePbz.js"), "./Pages/Insights/Index.vue": () => import("./assets/Index-b8LITWof.js"), "./Pages/Insights/Show.vue": () => import("./assets/Show-DqgXtWJQ.js"), "./Pages/Legal.vue": () => import("./assets/Legal-BgGUMbXW.js"), "./Pages/Services.vue": () => import("./assets/Services-DmJLGA2Q.js"), "./Pages/Work/Index.vue": () => import("./assets/Index-DledACm0.js"), "./Pages/Work/Show.vue": () => import("./assets/Show-BkhozoVj.js") })
      );
      return component2.then((module) => {
        var _a;
        (_a = module.default).layout ?? (_a.layout = _sfc_main);
        return module;
      });
    },
    setup({ App: App2, props, plugin: plugin2 }) {
      const app = createSSRApp({ render: () => h(App2, props) }).use(plugin2).use(o);
      installTranslations(app);
      return app;
    }
  })
);
export {
  _export_sfc as _,
  usePage as a,
  useForm as b,
  useMasteryOpen as c,
  _sfc_main$6 as d,
  useHeroStagger as e,
  useCounters as f,
  useSectionReveal as g,
  useParallax as h,
  head_default as i,
  link_default as l,
  useTranslations as u
};
