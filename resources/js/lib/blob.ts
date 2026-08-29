/*
 | The dark material in the services diagram — ONE silhouette, start to finish.
 |
 | The section opens as a Venn (two solid overlapping circles) and ends as the
 | orbit diagram's horizontal axis (two endpoint dots joined by a dotted line).
 | Everything between is the same shape: the lobes melt into a peanut, the
 | bridge snaps thin, and the masses shrink into the endpoint dots. Nothing is
 | ever cross-faded — the dots on the finished axis ARE the Brand and Product
 | circles the section opened with.
 |
 | WHY A TABLE RATHER THAN EASING CURVES
 | -------------------------------------
 | The three measurements below do not share a curve. Between t=0.11 and t=0.19
 | the waist collapses to a fifteenth of its height while the radius barely
 | moves and the separation runs on smoothly — the bridge SNAPS, and no single
 | ease reproduces that against the motion reference. Fitting three curves by
 | eye was what made the first attempt read as two circles sliding apart, so
 | the shape is driven from measured keyframes instead and the timeline just
 | walks `t` from 0 to 1 linearly.
 |
 | Values are fractions of the diagram width, so the composition scales with
 | whatever box it is given.
 */

/** The measured box the diagram is drawn into, in CSS pixels. */
export interface BlobBox {
  width: number
  height: number
}

/** What the timeline animates: one scalar, walked linearly from 0 to 1. */
export interface BlobProgress {
  t: number
}

/** The silhouette's numbers at one instant. */
export interface BlobShape {
  cx: number
  cy: number
  radius: number
  separation: number
  waist: number
  /** Angle from horizontal at which the bridge leaves each lobe. */
  attach: number
}

/**
 * Keyframes: [t, half-separation, lobe radius, waist half-height], every value
 * a fraction of the width. Dense through the snap (t 0.10-0.20), sparse in the
 * long tail where nothing surprising happens.
 */
const KEYFRAMES: ReadonlyArray<readonly [number, number, number, number]> = [
  [0.0, 0.04028, 0.09201, 0.08264],
  [0.0315, 0.04236, 0.09201, 0.0816],
  [0.063, 0.05035, 0.09201, 0.07917],
  [0.0945, 0.06701, 0.09201, 0.07743],
  [0.1102, 0.08056, 0.09201, 0.07535],
  [0.126, 0.10104, 0.09132, 0.07569],
  [0.1417, 0.12326, 0.08576, 0.05243],
  [0.1575, 0.14722, 0.07986, 0.02326],
  [0.1732, 0.16979, 0.07465, 0.00764],
  [0.189, 0.19097, 0.06979, 0.00556],
  [0.2205, 0.22674, 0.06181, 0.00382],
  [0.252, 0.25486, 0.0559, 0.00208],
  [0.315, 0.29583, 0.04965, 0.00139],
  [0.378, 0.32465, 0.04375, 0.00104],
  [0.4409, 0.34583, 0.03681, 0.00139],
  [0.5039, 0.36215, 0.02951, 0.00139],
  [0.6299, 0.38333, 0.01701, 0.0],
  [0.7559, 0.39444, 0.00833, 0.0],
  [0.8819, 0.39965, 0.00382, 0.0],
  [1.0, 0.40035, 0.00313, 0.0],
]

/**
 * Floor on the waist, as a share of the width — about half a pixel.
 *
 * The reference lets the bridge reach zero, which would break the silhouette
 * into two disconnected dots for the last third. Holding a hairline keeps it
 * one continuous shape all the way to rest, under the dotted axis that fades
 * in over it.
 */
const MIN_WAIST = 0.0004

/** Centre-side bridge handle, as a share of the gap it has to span. */
const CENTRE_HANDLE = 0.78

/*
 | Lobe-side bridge handle: a share of the gap, capped against the lobe.
 |
 | Much shorter than the centre handle on purpose. The tangent at the junction
 | is close to vertical, so a long handle here throws the edge straight up off
 | the lobe and the bridge comes out bow-tied — wide at both ends, pinched in
 | the middle — instead of the reference's flat run between two concave necks.
 |
 | The radius cap is what makes it behave differently at the two ends of the
 | animation. Early on the gap is tiny and the cap is slack, so the handle is
 | gap-bound and the shoulder stays broad and soft; once the masses pull apart
 | the cap binds instead and holds the junction tight against a shrinking lobe.
 */
const LOBE_HANDLE = 0.9
const LOBE_HANDLE_CAP = 0.35

/*
 | Floor on the attach angle once the lobes have parted.
 |
 | `asin(waist / radius)` alone would walk the junction down to the lobe's
 | inner extreme as the bridge thins, where the circle's tangent is vertical
 | and no handle length gives a clean join. Holding it ~35deg up the lobe keeps
 | a horizontal component in the tangent, which is what draws the concave
 | fillet the reference has where the filament meets each mass.
 */
const MIN_ATTACH = 0.75

/*
 | Pushes the junction a little higher up the lobe than the bridge's own
 | half-height, once the lobes have parted. Sitting it exactly at the waist
 | makes the bridge leave horizontally and the shoulder reads as a crease; a
 | few degrees above turns that into the wide shallow valley the reference has
 | while the mass is still one body.
 */
const ATTACH_FLARE = 1.15

/*
 | Where the flare gives out.
 |
 | The neck has to survive almost to the end — the reference still shows a
 | flared join either side of the filament well past the point where its waist
 | measures zero. But it cannot survive TO the end: held all the way, the
 | flare leaves a dark spindle strung between the two dots, and the finished
 | axis is supposed to be a pale dotted line. So the floor is walked off over
 | the last stretch, by which time the dotted axis is fully drawn over it.
 */
const FLARE_END = 0.97
const FLARE_FADE = 0.12

/** Never quite zero: the lobe arcs need two distinct endpoints to exist. */
const MIN_ARC_SPAN = 0.02

function lerp(from: number, to: number, t: number): number {
  return from + (to - from) * t
}

/**
 * Where the bridge meets each lobe.
 *
 * While the circles still overlap this is exactly the crossing point, so the
 * outline is the plain union of two circles and the opening frame needs no
 * special case. Once they part, it is held away from the lobe's inner extreme
 * — see MIN_ATTACH.
 */
function attachAngle(
  radius: number,
  separation: number,
  waist: number,
  t: number,
): number {
  const ratio = waist / radius
  const union = Math.asin(Math.max(0, Math.min(1, ratio)))

  if (separation <= radius) return union

  const flared = Math.asin(Math.max(0, Math.min(1, ratio * ATTACH_FLARE)))
  const fade = Math.max(0, Math.min(1, (FLARE_END - t) / FLARE_FADE))

  return Math.max(flared, MIN_ATTACH * fade, MIN_ARC_SPAN)
}

/** The silhouette's numbers at `t`, walking the keyframe table. */
export function resolveBlob(box: BlobBox, t: number): BlobShape {
  const clamped = Math.max(0, Math.min(1, t))

  let index = KEYFRAMES.length - 1
  for (let i = 1; i < KEYFRAMES.length; i += 1) {
    if (KEYFRAMES[i][0] >= clamped) {
      index = i
      break
    }
  }

  const [t0, s0, r0, w0] = KEYFRAMES[index - 1] ?? KEYFRAMES[0]
  const [t1, s1, r1, w1] = KEYFRAMES[index]
  const span = t1 - t0
  const local = span > 0 ? (clamped - t0) / span : 0

  const radius = lerp(r0, r1, local) * box.width
  const waist = Math.max(lerp(w0, w1, local), MIN_WAIST) * box.width

  return {
    cx: box.width / 2,
    cy: box.height / 2,
    radius,
    separation: lerp(s0, s1, local) * box.width,
    waist,
    /*
     | Derived, not measured. Putting the bridge's ends where the lobe is
     | exactly as tall as the bridge is what makes the junction continuous —
     | and at t=0 it lands them on the two circles' crossing points, so the
     | outline below emits the plain union of two circles with no special case.
     */
    attach: attachAngle(radius, lerp(s0, s1, local) * box.width, waist, clamped),
  }
}

/**
 * The silhouette as a single closed path.
 *
 * Two arcs (the outer face of each lobe) joined by four cubics (the bridge,
 * flared symmetrically above and below). Both arcs are drawn the long way
 * round — `large-arc 1, sweep 1` — so each lobe keeps its full outer face and
 * only the inner sliver is given over to the bridge.
 */
export function blobPath(shape: BlobShape): string {
  const { cx, cy, radius, separation, waist, attach } = shape

  if (radius <= 0) return ''

  const cos = Math.cos(attach)
  const sin = Math.sin(attach)
  const ax = radius * cos
  const ay = radius * sin
  const leftX = cx - separation
  const rightX = cx + separation

  const topLeft = [leftX + ax, cy - ay]
  const bottomLeft = [leftX + ax, cy + ay]
  const topRight = [rightX - ax, cy - ay]
  const bottomRight = [rightX - ax, cy + ay]

  /*
   | Handles are sized off the gap the bridge actually spans, so a bridge with
   | nothing to span has no handles and the cubics collapse to points. The
   | lobe-side handle is capped against the lobe radius: without that, a wide
   | gap drags the curve away from the lobe it is supposed to grow out of, and
   | the flared junction the reference has at the neck disappears.
   */
  const gap = Math.max(0, separation - ax)
  const centreHandle = CENTRE_HANDLE * gap
  const lobeHandle = Math.min(LOBE_HANDLE * gap, LOBE_HANDLE_CAP * radius)
  const lobeDx = lobeHandle * sin
  const lobeDy = lobeHandle * cos

  const p = (n: number): string => n.toFixed(2)
  const arc = `A ${p(radius)} ${p(radius)} 0 1 1`

  return [
    `M ${p(topRight[0])} ${p(topRight[1])}`,
    `${arc} ${p(bottomRight[0])} ${p(bottomRight[1])}`,
    `C ${p(bottomRight[0] - lobeDx)} ${p(bottomRight[1] - lobeDy)}`,
    `${p(cx + centreHandle)} ${p(cy + waist)} ${p(cx)} ${p(cy + waist)}`,
    `C ${p(cx - centreHandle)} ${p(cy + waist)}`,
    `${p(bottomLeft[0] + lobeDx)} ${p(bottomLeft[1] - lobeDy)} ${p(bottomLeft[0])} ${p(bottomLeft[1])}`,
    `${arc} ${p(topLeft[0])} ${p(topLeft[1])}`,
    `C ${p(topLeft[0] + lobeDx)} ${p(topLeft[1] + lobeDy)}`,
    `${p(cx - centreHandle)} ${p(cy - waist)} ${p(cx)} ${p(cy - waist)}`,
    `C ${p(cx + centreHandle)} ${p(cy - waist)}`,
    `${p(topRight[0] - lobeDx)} ${p(topRight[1] + lobeDy)} ${p(topRight[0])} ${p(topRight[1])}`,
    'Z',
  ].join(' ')
}
