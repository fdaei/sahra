import { nextTick, onMounted, onUnmounted, watch, type Ref } from 'vue'
import { MOTION, directionFactor, gsap, prefersReducedMotion } from '@/lib/motion'
import type { BlobProgress } from '@/lib/blob'

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
function useEffectScope(
  fn: (ctx: { scope: HTMLElement | null }) => void | (() => void),
  target?: MotionTarget,
): void {
  let ctx: gsap.Context | null = null
  /*
   | `fn` may return its own teardown. A gsap.context only captures what was
   | created synchronously inside it, so anything that builds tweens LATER —
   | a matchMedia that fires on a breakpoint change, for instance — has to
   | hand back a disposer of its own or it outlives the component.
   */
  let dispose: (() => void) | undefined

  onMounted(() => {
    if (prefersReducedMotion()) return

    const scope = target ? resolve(target) : null
    if (target && !scope) return

    ctx = gsap.context(() => {
      dispose = fn({ scope }) ?? undefined
    }, scope ?? undefined)
  })

  onUnmounted(() => {
    dispose?.()
    dispose = undefined
    ctx?.revert()
    ctx = null
  })
}

/*
 | Where a reveal fires, as a share of viewport height. Shared by the opt-in
 | A7 reveal below and the page-wide A7b one further down.
 |
 | The near-bottom default assumes the block is roughly viewport-sized, so
 | crossing the line means "the reader is about to see this". That assumption
 | breaks on narrow screens: sections that are ~1 viewport tall on desktop
 | become 1.3x to 2.8x the viewport once they stack, and the 0.7s tween then
 | completes while the reader is still looking at the block's first ~80px.
 | Measured on the live site at 390x664, sections revealed with 6-18% of
 | themselves on screen — the motion was running, just never where anyone
 | could see it.
 |
 | A block taller than the viewport can never animate "as it arrives" from a
 | near-bottom trigger, so it fires later instead, once a substantial band of
 | it is actually on screen.
 */
/*
 | Brand colours used by the services diagram animation.
 |
 | GSAP interpolates concrete values, so these mirror the `--color-paper` and
 | `--color-gold` tokens in app.css rather than reading them at runtime — keep
 | the values in step. The axis arrives at full gold and settles to a softer
 | gold so it stays on-brand against the dark section background.
 */
const PAPER = '#FFFFFF'
const AXIS_DRAWN = 'rgba(189, 147, 59, 1)'
const AXIS_RESTING = 'rgba(189, 147, 59, 0.72)'

const REVEAL_START = 'top 88%'
const REVEAL_START_TALL = 'top 65%'

/** True when `el` is too tall to read as a single arriving gesture. */
function isTallerThanViewport(el: HTMLElement): boolean {
  return el.getBoundingClientRect().height > window.innerHeight * 0.9
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
        scrollTrigger: {
          trigger: el,
          // Same tall-block handling as the page-level reveal — several of
          // these opted-in blocks (Work/Show's 620px and 488px panels) are
          // taller than a phone viewport.
          start: () => (isTallerThanViewport(el) ? REVEAL_START_TALL : REVEAL_START),
          once: true,
        },
      })
    }

    for (const group of groups) {
      const children = Array.from(group.querySelectorAll<HTMLElement>('[data-reveal]'))
      if (children.length === 0) continue

      /*
       | One trigger per VISUAL ROW, not one per group.
       |
       | Triggering the whole group off the container only reads correctly
       | while the container fits the viewport. On a narrow screen these grids
       | collapse to `grid-cols-1`, so a four-card group becomes a ~700px
       | column in a ~660px viewport: the container's top crosses the line
       | while cards 3 and 4 are still hundreds of px below the fold, and they
       | finish their tween entirely off-screen. Measured on the live site,
       | those two cards revealed at 0% visible — which is exactly what "the
       | animations don't run on mobile" looks like to a reader.
       |
       | Bucketing by document Y restores the intent at every breakpoint: a
       | 2-col grid still staggers its pair as one gesture, and a 1-col stack
       | becomes N rows of one, each arriving on its own trigger.
       */
      for (const row of visualRows(children)) {
        gsap.to(row, {
          y: 0,
          opacity: 1,
          duration: MOTION.duration.reveal,
          ease: MOTION.ease.brand,
          stagger: MOTION.stagger.cards,
          scrollTrigger: {
            trigger: row[0],
            start: () => (isTallerThanViewport(row[0]) ? REVEAL_START_TALL : REVEAL_START),
            once: true,
          },
        })
      }
    }
  }, target)
}

/*
 | Deliberately coarse: grid items in one row can differ by a fraction of a
 | pixel from sub-pixel layout, and cards of unequal height still share a row
 | when their tops align.
 */
const ROW_TOLERANCE = 8

/** Bucket elements into visual rows by their position in the document. */
function visualRows(elements: HTMLElement[]): HTMLElement[][] {
  const rows = new Map<number, HTMLElement[]>()

  for (const el of elements) {
    // Document-relative, so the buckets survive being measured mid-scroll.
    const y = el.getBoundingClientRect().top + window.scrollY
    const key = Math.round(y / ROW_TOLERANCE)
    const row = rows.get(key)

    if (row) row.push(el)
    else rows.set(key, [el])
  }

  return [...rows.entries()].sort(([a], [b]) => a - b).map(([, row]) => row)
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
            scrollTrigger: {
              trigger: el,
              // Function form so a resize or orientation change re-measures:
              // a block that was viewport-sized in landscape is a tall stack
              // in portrait, and vice versa.
              start: () => (isTallerThanViewport(el) ? REVEAL_START_TALL : REVEAL_START),
              once: true,
            },
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
 * so the numeric run is isolated and its prefix/suffix preserved. Western,
 * Persian, and Arabic-Indic digit sets are normalised for the calculation and
 * converted back to the active digit set on every animation frame.
 */
export function useCounters(target?: MotionTarget): void {
  useEffectScope(({ scope }) => {
    const root: ParentNode = scope ?? document

    for (const el of Array.from(root.querySelectorAll<HTMLElement>('[data-counter]'))) {
      const text = el.textContent?.trim() ?? ''
      const match = text.match(/^([^\p{N}]*?)([\p{N}][\p{N},.٬٫]*)([^\p{N}]*)$/u)
      if (!match) continue

      const [, prefix, digits, suffix] = match
      const asciiDigits = digits
        .replace(/[٠-٩]/g, (digit) => String('٠١٢٣٤٥٦٧٨٩'.indexOf(digit)))
        .replace(/[۰-۹]/g, (digit) => String('۰۱۲۳۴۵۶۷۸۹'.indexOf(digit)))
        .replace(/٬/g, ',')
        .replace(/٫/g, '.')
      const decimals = asciiDigits.includes('.')
        ? (asciiDigits.split('.')[1]?.length ?? 0)
        : 0
      const endValue = Number(asciiDigits.replace(/,/g, ''))
      if (!Number.isFinite(endValue)) continue

      const state = { value: 0 }
      const grouped = /[,٬]/.test(digits)
      const groupSeparator = digits.includes('٬') ? '٬' : ','
      const decimalSeparator = digits.includes('٫') ? '٫' : '.'
      const documentLanguage = document.documentElement.lang.toLowerCase()
      const digitSet = /[٠-٩]/.test(digits) || documentLanguage.startsWith('ar')
        ? '٠١٢٣٤٥٦٧٨٩'
        : /[۰-۹]/.test(digits) || documentLanguage.startsWith('fa')
          ? '۰۱۲۳۴۵۶۷۸۹'
          : '0123456789'

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
          const localised = shown
            .replace(/,/g, groupSeparator)
            .replace(/\./g, decimalSeparator)
            .replace(/\d/g, (digit) => digitSet[Number(digit)] ?? digit)
          el.textContent = `${prefix}${localised}${suffix}`
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
export function useScrubRotate(
  target: MotionTarget,
  options: { degrees?: number; media?: string } = {},
): void {
  const { degrees = 8, media } = options

  useEffectScope(({ scope }) => {
    if (!scope) return

    const spin = (): void => {
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
    }

    if (!media) {
      spin()
      return
    }

    /*
     | Breakpoint-scoped rotation.
     |
     | A stage can swap which ring it draws at a breakpoint, leaving the other
     | at `display: none`. A ScrollTrigger measured on a display:none element
     | gets a zero-height rect, so its start and end collapse onto the same
     | scroll position and the scrub never advances — the ring that IS on
     | screen sits perfectly still. matchMedia builds the tween only while its
     | query matches and reverts it (killing the trigger) when it stops, so
     | rotating through a resize or an orientation change stays correct.
     */
    const mm = gsap.matchMedia()
    mm.add(media, () => spin())

    return () => mm.revert()
  }, target)
}

/**
 * Services diagram — the opening Venn becoming the orbit composition.
 *
 * One silhouette carries the whole transformation (see lib/blob.ts), so the
 * three geometry channels below are the animation; everything else resolves
 * around them. They deliberately run at different lengths: `pinch` is nearly
 * done while `spread` is barely moving, which is what makes the material melt
 * together BEFORE it pulls apart, rather than sliding apart as two circles.
 *
 * The silhouette itself is one LINEAR tween. Its shape comes from measured
 * keyframes (lib/blob.ts), so easing it here would double-apply the reference's
 * own timing — the snap in the middle of that table is exactly what no single
 * curve reproduced when this was three eased channels.
 *
 * The labels are moved, never swapped: Brand and Product travel out from
 * inside their circles to the ends of the axis and remain white;
 * Service Mastery rises from the overlap to the top of the composition.
 *
 * Not a Figma audit item: the file draws the finished rings only, with no
 * opening state to extract (see the note on MasteryDiagram.vue).
 */
export function useMasteryOpen(stage: MotionTarget, progress: BlobProgress): void {
  useEffectScope(({ scope }) => {
    if (!scope) return

    const blob = scope.querySelector<SVGPathElement>('[data-mastery="blob"]')
    if (!blob) return

    const core = scope.querySelector<SVGGElement>('[data-mastery="core"]')
    const rings = scope.querySelector<SVGGElement>('[data-mastery="rings"]')
    const inner = scope.querySelector<SVGCircleElement>('[data-mastery="ring-inner"]')
    const outer = scope.querySelector<SVGCircleElement>('[data-mastery="ring-outer"]')
    const axis = scope.querySelector<SVGLineElement>('[data-mastery="axis"]')
    const brand = scope.querySelector<HTMLElement>('[data-mastery-label="brand"]')
    const product = scope.querySelector<HTMLElement>('[data-mastery-label="product"]')
    const coreLabel = scope.querySelector<HTMLElement>('[data-mastery-label="core"]')

    const { width, height } = scope.getBoundingClientRect()
    if (width === 0) return

    /*
     | Where the labels start, in px from where they finish. Brand and Product
     | begin inside their own circle (the reference's 38% inset) and end just
     | outside their endpoint dot; Service Mastery begins in the overlap and
     | ends at the top. Measured rather than declared so the travel stays right
     | at any width — and mirrored in RTL, where the two sides swap.
     */
    const sideTravel = (width * 0.38 - 50) * directionFactor()
    const coreTravel = height * 0.46 - 40

    // Rotating a dashed ring reads as movement; a plain one would not. The
    // origin is the composition centre, not the node's own box, so the rings
    // turn in place rather than orbiting.
    const spin = { svgOrigin: `${width / 2} ${height / 2}` }

    /*
     | The component renders the FINISHED composition, so reduced motion, a
     | failed bundle, and the moment before this runs all leave a complete
     | diagram. Rewinding to the opening Venn is therefore the first thing the
     | effect does, and only ever when it is going to play.
     */
    Object.assign(progress, { t: 0 })

    const tl = gsap.timeline({
      scrollTrigger: { trigger: scope, start: REVEAL_START, once: true },
    })

    /*
     | Shown outright, not faded in. The hidden state exists only to keep the
     | finished diagram off screen until the section arrives (see the
     | motion-ready gate in the component); the reference opens on a solid
     | Venn, and any fade here leaves it washed out through the first third of
     | its own transformation.
     */
    tl.set(scope, { opacity: 1 }, 0)

    // The material: melt, pull apart, shrink into the endpoint dots.
    tl.to(progress, { t: 1, duration: MOTION.duration.mastery, ease: MOTION.ease.none }, 0)

    // The darker core belongs to the overlap, and goes with it.
    if (core) {
      tl.fromTo(core, { opacity: 1 }, { opacity: 0, duration: 0.13, ease: MOTION.ease.none }, 0.13)
    }

    // The rings are not part of the opening — they arrive as the middle empties.
    if (rings && inner && outer) {
      tl.fromTo(rings, { opacity: 0 }, { opacity: 1, duration: 0.6, ease: MOTION.ease.quick }, 0.35)
        .fromTo(inner, { rotation: -720, ...spin }, { rotation: 0, duration: 1.8, ease: MOTION.ease.quick, ...spin }, 0.2)
        .fromTo(outer, { rotation: 720, ...spin }, { rotation: 0, duration: 1.8, ease: MOTION.ease.quick, ...spin }, 0.2)
    }

    /*
     | The axis arrives early and dark, while the bridge is still thick, and
     | only then pales to the finished stroke. That ordering is what sells the
     | handoff: the reader never sees a line fade in over a gap, they see the
     | material itself thin out into one.
     */
    if (axis) {
      tl.fromTo(axis, { opacity: 0 }, { opacity: 1, duration: 0.35, ease: MOTION.ease.quick }, 0.36)
        .fromTo(
          axis,
          { stroke: AXIS_DRAWN },
          { stroke: AXIS_RESTING, duration: 0.9, ease: MOTION.ease.none },
          0.9,
        )
    }

    // Labels travel and recolour — the same elements throughout.
    if (brand && product) {
      tl.fromTo(
        [brand, product],
        {
          x: (i: number) => (i === 0 ? sideTravel : -sideTravel),
          color: PAPER,
        },
        {
          x: 0,
          color: PAPER,
          duration: 1.2,
          ease: MOTION.ease.spread,
        },
        0.05,
      )
    }

    if (coreLabel) {
      tl.fromTo(
        coreLabel,
        { y: coreTravel, color: PAPER },
        {
          y: 0,
          color: PAPER,
          duration: 1,
          ease: MOTION.ease.spread,
        },
        0.1,
      )
    }
  }, stage)
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
