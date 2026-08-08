import '../css/app.css'

import { createApp, h, type DefineComponent } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from 'ziggy-js'

import AppLayout from './Layouts/AppLayout.vue'
import { installTranslations } from './Composables/useTranslations'
import { initMotion, killPageAnimations } from './lib/motion'

const appName = import.meta.env.VITE_APP_NAME ?? 'Sahra'

createInertiaApp({
  title: (title) => (title ? `${title} — ${appName}` : appName),

  resolve: (name) => {
    const page = resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
    )

    // Every page gets the shared chrome unless it opts out by setting
    // `defineOptions({ layout: null })`.
    return page.then((module) => {
      module.default.layout ??= AppLayout
      return module
    })
  },

  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)

    installTranslations(app)

    app.mount(el)
  },

  progress: {
    /*
     | Inertia interpolates this straight into an injected <style> block
     | (background / box-shadow / border-color), so a custom property resolves
     | normally and the palette stays defined in one place — see the :root
     | block in resources/css/app.css.
     */
    color: 'var(--color-gold)',
    showSpinner: false,
  },
})

/*
 | GSAP lifecycle across Inertia navigations.
 |
 | Inertia swaps the page component without a full reload, so ScrollTrigger
 | instances from the previous page would otherwise survive, keep listening,
 | and fight the new page's layout. We tear them down before every navigation
 | and re-initialise once the new page has painted.
 */
router.on('before', () => {
  killPageAnimations()
})

router.on('navigate', () => {
  // Wait for the new DOM to be laid out before measuring scroll positions.
  requestAnimationFrame(() => {
    requestAnimationFrame(() => initMotion())
  })
})

// First load.
initMotion()
