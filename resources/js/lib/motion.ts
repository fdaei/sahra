import { gsap } from 'gsap'
import { CustomEase } from 'gsap/CustomEase'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger, CustomEase)

/*
 | The one curve GSAP has no named equivalent for.
 |
 | `power4.out` is close to cubic-bezier(0.22, 1, 0.36, 1) but not the same: it
 | leaves more of its travel to the tail, which reads as a drift rather than the
 | firm settle the venn opening needs. A CustomEase built from the cubic's own
 | control points is exact, and the `C` command below IS that cubic — the two
 | control points and the (1,1) endpoint, verbatim.
 */
CustomEase.create('sahraOpen', 'M0,0 C0.22,1 0.36,1 1,1')

/*
 | The services diagram's own curve, read off the motion reference's keyframe
 | easing (out {x:0.171,y:0.338}, in {x:0.426,y:1}) rather than chosen. It
 | leaves the middle slowly and arrives long and flat, which is what keeps the
 | material feeling heavy as it pulls apart.
 */
CustomEase.create('sahraSpread', 'M0,0 C0.171,0.338 0.426,1 1,1')

/*
 | Centralised motion constants.
 |
 | Figma does not store easing/duration as variables (audit gap G3), so these
 | are the production defaults documented in docs/FIGMA-AUDIT.md §6. Tuning
 | happens here, in one place, rather than scattered through components.
 */
export const MOTION = {
  ease: {
    /** Matches Tailwind's `ease-brand` — used for hover + reveal. */
    brand: 'power3.out',
    /** Snappier, for small state changes. */
    quick: 'power2.out',
    /**
     * cubic-bezier(0.22, 1, 0.36, 1). Long, restrained ease-out for motion
     * that has to feel deliberate rather than snappy — the venn opening.
     */
    open: 'sahraOpen',
    /** cubic-bezier(0.171, 0.338, 0.426, 1) — the services diagram opening. */
    spread: 'sahraSpread',
    /** Linear — marquees and scrub only. */
    none: 'none',
  },
  duration: {
    hero: 0.6,
    reveal: 0.7,
    counter: 2,
    hover: 0.4,
    /** The venn's horizontal opening — the longest single gesture on the site. */
    open: 0.9,
    /** Services diagram, opening Venn to finished orbit. 128 frames at 60fps. */
    mastery: 2.13,
    /*
     | Component state swaps. Unlike the scroll effects, these ARE stored in
     | the file: the Service card (1419:9295 -> 501:722) and testimonial card
     | (1419:9251 -> 414:864) both carry an ON_HOVER/MOUSE_ENTER interaction
     | with SMART_ANIMATE, EASE_OUT, 0.3s. Audit gap G3 is therefore only
     | true of the scroll-driven effects, not of these.
     */
    state: 0.3,
  },
  stagger: {
    hero: 0.08,
    cards: 0.06,
  },
  marquee: {
    /** Seconds for one full loop. Figma A2 (clients) / A6 (testimonials). */
    clients: 28,
    testimonials: 40,
  },
} as const

/** Honour the OS-level reduced-motion preference. */
export function prefersReducedMotion(): boolean {
  if (typeof window === 'undefined') return false
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches
}

/** True when the document is currently rendering right-to-left. */
export function isRtl(): boolean {
  if (typeof document === 'undefined') return false
  return document.documentElement.dir === 'rtl'
}

/**
 * Direction multiplier for horizontal motion.
 * Marquees and slide-ins must travel the opposite way in RTL.
 */
export function directionFactor(): 1 | -1 {
  return isRtl() ? -1 : 1
}

/**
 * Page-scoped GSAP context. Everything registered inside it can be reverted
 * in one call when the Inertia page unmounts.
 */
let pageContext: gsap.Context | null = null

export function initMotion(): void {
  if (typeof window === 'undefined') return

  // Reduced motion: no timelines at all. Elements are visible by default in
  // CSS, and composables no-op, so the page simply renders in its final state.
  if (prefersReducedMotion()) {
    document.documentElement.classList.add('reduced-motion')
    return
  }

  document.documentElement.classList.remove('reduced-motion')

  /*
   | `.will-reveal` sets the hidden start state in CSS so revealed elements do
   | not flash before GSAP measures them. That is only safe while GSAP is
   | actually going to run, so the CSS rule is gated behind this class: if the
   | bundle fails to load or throws before this point, nothing is ever hidden.
   */
  document.documentElement.classList.add('motion-ready')

  pageContext = gsap.context(() => {
    // Individual effects register themselves via composables during component
    // setup. This context exists so they attach to a revertible scope.
  })

  ScrollTrigger.refresh()
}

/**
 * Tear down every animation belonging to the outgoing page.
 * Called on Inertia `before` so nothing leaks across navigations.
 */
export function killPageAnimations(): void {
  pageContext?.revert()
  pageContext = null

  ScrollTrigger.getAll().forEach((trigger) => trigger.kill())
}

/**
 * Register an effect inside the current page context.
 * Returns a cleanup function suitable for `onUnmounted`.
 */
export function registerEffect(fn: () => void): () => void {
  if (prefersReducedMotion()) {
    return () => {}
  }

  const ctx = gsap.context(fn)

  return () => ctx.revert()
}

export { gsap, ScrollTrigger }
