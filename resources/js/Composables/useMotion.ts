import { onMounted, onUnmounted, type Ref } from 'vue'
import { MOTION, directionFactor, gsap, prefersReducedMotion } from '@/lib/motion'

/*
 | Scroll- and load-driven motion, audit items A1/A3/A4/A7/A11
 | (docs/FIGMA-AUDIT.md §6).
 |
 | WHY THESE VALUES ARE NOT READ FROM FIGMA
 | ----------------------------------------
 | `get_motion_context` on the Home frame (1419:9192, recursive) returns
 | `{"nodes":[]}` — the file stores no keyframe tracks at all, which confirms
 | audit gap G3. The only motion the file does store is the component-state
 | `interactions` array (SMART_ANIMATE / EASE_OUT / 0.3s), already captured as
 | `MOTION.duration.state`. Everything here therefore uses the production
 | defaults centralised in lib/motion.ts rather than extracted curves; tune
 | them there, not in components.
 |
 | Every composable below:
 |   - no-ops under `prefers-reduced-motion: reduce`, leaving the final state,
 |   - owns a gsap.context so the effect reverts on unmount, which is what
 |     keeps ScrollTriggers from surviving an Inertia page swap.
 */

/** Element or template ref accepted by the composables. */
type MotionTarget = Ref<HTMLElement | null> | (() => HTMLElement | null)

function resolve(target: MotionTarget): HTMLElement | null {
  return typeof target === 'function' ? target() : target.value
}

/**
 * Runs `fn` inside a page-scoped GSAP context on mount and reverts it on
 * unmount. Reverting restores the inline styles GSAP wrote, so a reveal that
 * has already played leaves the element at its natural (visible) state.
 */
function useEffectScope(fn: (ctx: { scope: HTMLElement | null }) => void, target?: MotionTarget): void {
  let ctx: gsap.Context | null = null

  onMounted(() => {
    if (prefersReducedMotion()) return

    const scope = target ? resolve(target) : null
    if (target && !scope) return

    ctx = gsap.context(() => fn({ scope }), scope ?? undefined)
  })

  onUnmounted(() => {
    ctx?.revert()
    ctx = null
  })
}

/**
 * A7 — section reveal. Every `[data-reveal]` descendant lifts into place once,
 * on scroll entry. Children of a `[data-reveal-group]` stagger together so a
 * card grid arrives as one gesture rather than N independent ones.
 *
 * Elements carry `.will-reveal` in markup, which sets the hidden start state in
 * CSS to avoid a flash before GSAP measures. That rule is gated behind
 * `html.motion-ready` (set by initMotion) so a JS failure can never leave the
 * page permanently blank.
 */
export function useSectionReveal(target?: MotionTarget): void {
  useEffectScope(({ scope }) => {
    const root: ParentNode = scope ?? document
    const groups = Array.from(root.querySelectorAll<HTMLElement>('[data-reveal-group]'))
    const singles = Array.from(root.querySelectorAll<HTMLElement>('[data-reveal]')).filter(
      (el) => !el.closest('[data-reveal-group]'),
    )

    for (const el of singles) {
      gsap.to(el, {
        y: 0,
        opacity: 1,
        duration: MOTION.duration.reveal,
        ease: MOTION.ease.brand,
        scrollTrigger: { trigger: el, start: 'top 85%', once: true },
      })
    }

    for (const group of groups) {
      const children = Array.from(group.querySelectorAll<HTMLElement>('[data-reveal]'))
      if (children.length === 0) continue

      gsap.to(children, {
        y: 0,
        opacity: 1,
        duration: MOTION.duration.reveal,
        ease: MOTION.ease.brand,
        stagger: MOTION.stagger.cards,
        scrollTrigger: { trigger: group, start: 'top 85%', once: true },
      })
    }
  }, target)
}

/**
 * A1 — hero stagger-in on load. Direct children of the target rise together
 * with a short offset. Uses `from` (not `to`) because the hero is above the
 * fold: it must not depend on a scroll event ever firing.
 */
export function useHeroStagger(target: MotionTarget): void {
  useEffectScope(({ scope }) => {
    const children = scope ? Array.from(scope.children) : []
    if (children.length === 0) return

    gsap.from(children, {
      y: 24,
      opacity: 0,
      duration: MOTION.duration.hero,
      ease: MOTION.ease.quick,
      stagger: MOTION.stagger.hero,
      clearProps: 'transform,opacity',
    })
  }, target)
}

/**
 * A3 — KPI counters. Counts up to the number already rendered in the element,
 * so the final DOM text is the source of truth and the value stays correct
 * when JS is unavailable or motion is reduced.
 *
 * The displayed strings carry affixes and are locale-formatted ("+70k", "%95"),
 * so the numeric run is isolated and its prefix/suffix preserved. Non-Latin
 * digit sets (fa/ar) are left untouched rather than mis-parsed — the value is
 * simply not animated.
 */
export function useCounters(target?: MotionTarget): void {
  useEffectScope(({ scope }) => {
    const root: ParentNode = scope ?? document

    for (const el of Array.from(root.querySelectorAll<HTMLElement>('[data-counter]'))) {
      const text = el.textContent?.trim() ?? ''
      const match = text.match(/^(\D*?)(\d[\d,.]*)(\D*)$/)
      if (!match) continue

      const [, prefix, digits, suffix] = match
      const decimals = digits.includes('.') ? (digits.split('.')[1]?.length ?? 0) : 0
      const endValue = Number(digits.replace(/,/g, ''))
      if (!Number.isFinite(endValue)) continue

      const state = { value: 0 }
      const grouped = digits.includes(',')

      gsap.to(state, {
        value: endValue,
        duration: MOTION.duration.counter,
        ease: 'power1.out',
        scrollTrigger: { trigger: el, start: 'top 90%', once: true },
        onUpdate: () => {
          const shown = grouped
            ? state.value.toLocaleString('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals,
              })
            : state.value.toFixed(decimals)
          el.textContent = `${prefix}${shown}${suffix}`
        },
        // Snap back to the exact authored string so no rounding artefact sticks.
        onComplete: () => {
          el.textContent = text
        },
      })
    }
  }, target)
}

/**
 * A4 — services orbit scrub. Rotates the ring across the viewport as the
 * section scrolls (−8°→8°, linear, no easing: it is tied to scroll position,
 * not time). Direction flips in RTL so the ring turns with the reading order.
 */
export function useScrubRotate(target: MotionTarget, degrees = 8): void {
  useEffectScope(({ scope }) => {
    if (!scope) return
    const sweep = degrees * directionFactor()

    gsap.fromTo(
      scope,
      { rotation: -sweep },
      {
        rotation: sweep,
        ease: MOTION.ease.none,
        scrollTrigger: {
          trigger: scope,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true,
        },
      },
    )
  }, target)
}

/**
 * A11 — final-CTA glow parallax. Drifts the decorative layer against the
 * scroll so the gold ellipse sits behind the card with depth. Purely
 * decorative, so it is safe to skip entirely under reduced motion.
 */
export function useParallax(target: MotionTarget, distance = 40): void {
  useEffectScope(({ scope }) => {
    if (!scope) return

    gsap.fromTo(
      scope,
      { yPercent: -distance / 2 },
      {
        yPercent: distance / 2,
        ease: MOTION.ease.none,
        scrollTrigger: {
          trigger: scope.parentElement ?? scope,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true,
        },
      },
    )
  }, target)
}
