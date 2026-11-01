import '../css/app.css'

import { createApp, h, type DefineComponent } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from 'ziggy-js'

import AppLayout from './Layouts/AppLayout.vue'
import { installTranslations } from './Composables/useTranslations'
import { initMotion, killPageAnimations, ScrollTrigger } from './lib/motion'

type ScrollPosition = { left: number; top: number }

const historyScrollKey = '__sahraScrollPosition'
let pendingHistoryScroll: ScrollPosition | null = null

function saveCurrentScrollPosition(): void {
  const state = window.history.state

  // Keep this alongside Inertia's encrypted history payload. Inertia restores
  // its own position during the component swap, which is too early for our
  // out-in page transition: a short destination page can clamp that value.
  window.history.replaceState(
    {
      ...(state && typeof state === 'object' ? state : {}),
      [historyScrollKey]: { left: window.scrollX, top: window.scrollY },
    },
    '',
    window.location.href,
  )
}

function positionFromHistoryState(state: unknown): ScrollPosition | null {
  if (!state || typeof state !== 'object') return null

  const position = (state as Record<string, unknown>)[historyScrollKey]
  if (!position || typeof position !== 'object') return null

  const { left, top } = position as Record<string, unknown>
  return typeof left === 'number' && Number.isFinite(left)
    && typeof top === 'number' && Number.isFinite(top)
    ? { left, top }
    : null
}

function restoreHistoryScroll(): void {
  const position = pendingHistoryScroll
  pendingHistoryScroll = null

  if (position) window.scrollTo(position.left, position.top)
}

createInertiaApp({
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
    // Blade HTML is not Vue SSR markup. Mount replaces it synchronously;
    // hydrating it would produce mismatches and duplicate page content.
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
  saveCurrentScrollPosition()
  killPageAnimations()
})

router.on('navigate', () => {
  // Inertia has now set the destination scroll position. Discard GSAP's
  // cached position so its next refresh cannot restore the outgoing page.
  ScrollTrigger.clearScrollMemory()
  ScrollTrigger.getScrollFunc(window)(window.scrollY)

  // Wait for the new DOM to be laid out before measuring scroll positions.
  requestAnimationFrame(() => {
    requestAnimationFrame(() => initMotion())
  })

  if (pendingHistoryScroll) {
    // AppLayout emits this after its out-in transition has mounted the full
    // destination page. Restoring here prevents the browser from clamping a
    // deep history position against the outgoing page's shorter document.
    window.addEventListener('sahra:page-entered', restoreHistoryScroll, { once: true })
    window.setTimeout(restoreHistoryScroll, 500)
  }
})

window.addEventListener('popstate', (event) => {
  pendingHistoryScroll = positionFromHistoryState(event.state)
})

// First load.
initMotion()
