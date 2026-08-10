import { nextTick, onMounted, onUnmounted, watch, type Ref } from 'vue'
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

/*
 |=============================================================================
 | A7b — GLOBAL SECTION REVEAL
 |=============================================================================
 |
 | `useSectionReveal` above is opt-in: it only touches elements an author
 | tagged with [data-reveal]. That covered a handful of card grids on Home and
 | left every other page with no scroll motion at all. This gives EVERY page
 | the same subtle lift as each block enters the viewport — 20px up, 0 -> 1
 | opacity — without needing an attribute on every section.
 |
 | It is deliberately conservative about what it touches:
 |
 |   - Blocks already carrying [data-reveal]/[data-reveal-group] are skipped,
 |     so the existing staggers keep ownership of their own section and nothing
 |     animates twice.
 |   - Blocks already on screen at load are skipped entirely and never hidden.
 |     The effect is "content rises as it ARRIVES"; hiding the hero to fade it
 |     back in on first paint is a different (and worse) effect, and it would
 |     fight the A1 hero stagger.
 |   - `data-no-reveal` opts a block out; `data-reveal-section` opts a non-
 |     <section> block in.
 |
 | `clearProps` on completion removes the inline transform. That matters beyond
 | tidiness: a lingering `transform` on a section makes it the containing block
 | for any `position: fixed` descendant.
 */
const AUTO_REVEAL_DISTANCE = 20

/** Blocks that should carry the page-level reveal, outermost-first. */
function autoRevealTargets(root: HTMLElement): HTMLElement[] {
  const blocks = Array.from(
    root.querySelectorAll<HTMLElement>('section, [data-reveal-section]'),
  )

  // Only the outermost of any nested pair — a section inside a section is one
  // gesture, not two.
  const outermost = blocks.filter(
    (el) => !blocks.some((other) => other !== el && other.contains(el)),
  )

  /*
   | Several pages (Insights/Show, Work/Index) put their whole body in a plain
   | container <div> and use <section> only for a trailing block, so sections
   | alone would leave most of the page static. Pick up top-level children that
   | neither contain nor sit inside an already-chosen section.
   */
  const looseTopLevel = Array.from(root.children).filter(
    (el): el is HTMLElement =>
      el instanceof HTMLElement &&
      !outermost.some(
        (section) =>
          section === el || section.contains(el) || el.contains(section),
      ),
  )

  return [...outermost, ...looseTopLevel].filter((el) => {
    if (el.hasAttribute('data-no-reveal')) return false

    // Owned by useSectionReveal — leave it alone.
    if (el.matches('[data-reveal], [data-reveal-group]')) return false
    if (el.querySelector('[data-reveal], [data-reveal-group]')) return false

    // Already visible at load: show it, do not animate it.
    return el.getBoundingClientRect().top > window.innerHeight * 0.85
  })
}

/**
 * A7b — applies the shared section reveal across the whole page, and re-applies
 * it after each Inertia navigation. Call once, from AppLayout.
 *
 * @param pageKey Reactive Inertia page component name. Changing it re-scans the
 *                new DOM; the layout itself never unmounts, so without this the
 *                effect would only ever run on the first page loaded.
 */
export function useAutoReveal(pageKey: Ref<string>): void {
  let ctx: gsap.Context | null = null

  function run(): void {
    ctx?.revert()
    ctx = null

    if (prefersReducedMotion()) return

    const main = document.getElementById('main')
    if (!main) return

    const targets = autoRevealTargets(main)
    if (targets.length === 0) return

    ctx = gsap.context(() => {
      /*
       | Each block gets its OWN trigger. One shared trigger across the whole
       | set would fire every tween the moment the first block crossed the
       | line, so the rest of the page would have finished animating long
       | before the reader reached it.
       */
      for (const el of targets) {
        gsap.fromTo(
          el,
          { y: AUTO_REVEAL_DISTANCE, opacity: 0 },
          {
            y: 0,
            opacity: 1,
            duration: MOTION.duration.reveal,
            ease: MOTION.ease.brand,
            clearProps: 'transform,opacity',
            scrollTrigger: { trigger: el, start: 'top 88%', once: true },
          },
        )
      }
    }, main)
  }

  onMounted(() => {
    void nextTick(run)
  })

  watch(pageKey, () => {
    // Two frames: the outgoing page has to leave and the incoming one has to
    // be laid out before any of it can be measured. Mirrors app.ts's own
    // re-init cadence on `router.on('navigate')`.
    void nextTick(() => {
      requestAnimationFrame(() => requestAnimationFrame(run))
    })
  })

  onUnmounted(() => {
    ctx?.revert()
    ctx = null
  })
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
