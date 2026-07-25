import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

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
    /** Linear — marquees and scrub only. */
    none: 'none',
  },
  duration: {
    hero: 0.6,
    reveal: 0.7,
    counter: 2,
    hover: 0.4,
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
