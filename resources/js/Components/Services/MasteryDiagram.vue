<script setup lang="ts">
/*
 | The services diagram, from opening Venn to finished orbit.
 |
 | One dark silhouette does the whole journey (see lib/blob.ts): two solid
 | overlapping circles melt into a peanut, stretch into a dumbbell, thin to a
 | filament, and end as the two dots on the horizontal axis. Nothing is
 | cross-faded into place — the dots on the finished axis are the Brand and
 | Product circles the section opened with.
 |
 | Around it, three things resolve at the same time: the labels travel outward
 | from inside the circles to the ends of the axis and turn from white to ink,
 | Service Mastery rises out of the overlap to the top of the composition, and
 | the two dashed rings fade up behind as the material leaves the middle.
 |
 | Not a Figma node: the services frame draws the finished rings only, with no
 | opening state, so the transformation is authored against the motion
 | reference rather than extracted.
 |
 | The markup renders the FINISHED composition. The motion layer rewinds it,
 | gated behind `motion-ready`, so reduced motion and a failed bundle both
 | leave a complete diagram rather than an empty box.
 */
import { computed, reactive, ref, useId } from "vue";
import { useElementSize, useMediaQuery } from "@vueuse/core";
import { useMasteryOpen } from "@/Composables/useMotion";
import { blobPath, resolveBlob, type BlobProgress } from "@/lib/blob";

defineProps<{
  leftLabel: string;
  rightLabel: string;
  coreLabel: string;
}>();

const stage = ref<HTMLElement | null>(null);

/* Unique per instance, so two diagrams on one page cannot share a clip. */
const clipId = useId();

/*
 | The viewBox is the element's own pixel box, so SVG units and CSS pixels are
 | the same thing — which is what lets the labels be plain absolutely
 | positioned HTML that lands exactly where the geometry does, at a real font
 | size, with no letterboxing to correct for.
 */
const { width, height } = useElementSize(stage);
const isMobile = useMediaQuery("(max-width: 639px)");

/* Resting value: the diagram is finished until the motion layer rewinds it. */
const progress = reactive<BlobProgress>({ t: 1 });

const shape = computed(() =>
  resolveBlob({ width: width.value, height: height.value }, progress.t),
);

const path = computed(() => blobPath(shape.value));

/*
 | The axis is pinned to the two lobe centres, so it grows with the material
 | instead of arriving over it: by the time the bridge has thinned away, the
 | dotted line is already strung between the same two dots.
 */
const axis = computed(() =>
  isMobile.value
    ? {
        x1: shape.value.cx,
        y1: shape.value.cy - shape.value.separation,
        x2: shape.value.cx,
        y2: shape.value.cy + shape.value.separation,
      }
    : {
        x1: shape.value.cx - shape.value.separation,
        y1: shape.value.cy,
        x2: shape.value.cx + shape.value.separation,
        y2: shape.value.cy,
      },
);

const blobTransform = computed(() =>
  isMobile.value
    ? `rotate(90 ${shape.value.cx} ${shape.value.cy})`
    : undefined,
);

const rings = computed(() =>
  isMobile.value
    ? {
        inner: Math.min(width.value * 0.36, height.value * 0.3),
        outer: Math.min(width.value * 0.59, height.value * 0.47),
      }
    : {
        inner: Math.min(138, width.value * 0.141),
        outer: Math.min(240, width.value * 0.245),
      },
);

useMasteryOpen(stage, progress);
</script>

<template>
  <div ref="stage" class="mastery-stage" aria-hidden="true">
    <!--
      Two layers only so the rings sit behind the axis; both stay below the
      service columns. Nothing needs lifting over them — the row rhythm in
      ServicesOrbit.vue leaves the axis its own empty corridor.
    -->
    <svg
      class="mastery-svg mastery-svg--behind"
      :viewBox="`0 0 ${width} ${height}`"
      focusable="false"
    >
      <g data-mastery="rings" class="mastery-rings">
        <circle
          data-mastery="ring-inner"
          :cx="shape.cx"
          :cy="shape.cy"
          :r="rings.inner"
        />
        <circle
          data-mastery="ring-outer"
          :cx="shape.cx"
          :cy="shape.cy"
          :r="rings.outer"
        />
      </g>

    </svg>

    <svg
      class="mastery-svg mastery-svg--front"
      :viewBox="`0 0 ${width} ${height}`"
      focusable="false"
    >
      <!-- The bridge thins onto this, so it only resolves at the very end. -->
      <line
        data-mastery="axis"
        class="mastery-axis"
        :x1="axis.x1"
        :y1="axis.y1"
        :x2="axis.x2"
        :y2="axis.y2"
      />

      <!-- The one silhouette. Opening Venn and closing dots are both this. -->
      <path
        data-mastery="blob"
        class="mastery-blob"
        :d="path"
        :transform="blobTransform"
      />

      <!--
        The darker core of the opening Venn — a fill treatment ON the
        silhouette, never part of it.
        
        One lobe drawn and clipped to the other, so the renderer produces the
        overlap; nothing here computes an intersection, and the shape below is
        still the single path. It fades out over the few frames in which the
        lobes actually part, after which there is no overlap left to shade.
      -->
      <defs>
        <clipPath :id="clipId">
          <circle
            :cx="shape.cx - shape.separation"
            :cy="shape.cy"
            :r="shape.radius"
          />
        </clipPath>
      </defs>
      <g data-mastery="core" :clip-path="`url(#${clipId})`">
        <circle
          class="mastery-core"
          :cx="shape.cx + shape.separation"
          :cy="shape.cy"
          :r="shape.radius"
        />
      </g>
    </svg>

    <div class="mastery-axis-layout">
      <span class="mastery-label mastery-label--left" data-mastery-label="left">{{ leftLabel }}</span>
      <span class="mastery-axis-slot" aria-hidden="true" />
      <span class="mastery-label mastery-label--right" data-mastery-label="right">{{ rightLabel }}</span>
    </div>
    <span class="mastery-label mastery-label--core" data-mastery-label="core">{{
      coreLabel
    }}</span>
  </div>
</template>

<style scoped>
/*
 | No z-index: the whole diagram belongs behind the service columns, and DOM
 | order already puts it there. Adding one would only open a stacking context
 | to no purpose.
 */
.mastery-stage {
  position: absolute;
  inset: 0;
  pointer-events: none;
  /*
   | The circles, rings, axis and labels are geometry, not prose: they must
   | read the same way regardless of page direction. Without this, `dir="rtl"`
   | (fa/ar) reverses the flex row below and swaps which end Marketing/Growth
   | land on, even though the SVG coordinates themselves never move.
   */
  direction: ltr;
}

/*
 | Mirrors the `.will-reveal` contract in app.css: the hidden start state is
 | opt-in from JS, so if the bundle never loads, the diagram is simply there.
 */
@media (prefers-reduced-motion: no-preference) {
  :where(html.motion-ready) .mastery-stage {
    opacity: 0;
  }
}

.mastery-svg {
  position: absolute;
  inset: 0;
  display: block;
  width: 100%;
  height: 100%;
  overflow: visible;
}
/*
 | No transform-box/transform-origin here: the motion layer spins these about
 | the composition centre in user units (svgOrigin), and a fill-box origin
 | would be resolved against each circle's own bounding box instead, which
 | swings the rings around the diagram rather than turning them in place.
 */
.mastery-rings circle {
  fill: none;
  /* Gold orbit rings remain visible without competing with the service pills. */
  stroke: rgb(var(--color-gold-rgb) / 62%);
  stroke-width: 2;
  stroke-dasharray: 2 6;
}
.mastery-axis {
  /* Resting value only — the motion layer draws and settles the gold stroke. */
  stroke: rgb(var(--color-gold-rgb) / 72%);
  stroke-width: 2;
  stroke-dasharray: 1 5;
  stroke-linecap: round;
}
.mastery-blob {
  fill: var(--color-gold);
}
/*
 | Black at partial alpha rather than a second hardcoded near-black, so the
 | overlap stays a fixed step darker than the blob if `--color-ink` ever moves.
 */
.mastery-core {
  fill: var(--color-gold-900);
  fill-opacity: 0.72;
}

.mastery-axis-layout {
  position: absolute;
  inset: 0;
}
.mastery-axis-slot {
  display: none;
}
.mastery-label {
  color: var(--color-paper);
  font-size: 20px;
  font-weight: 500;
  line-height: 1.2;
}
.mastery-axis-layout .mastery-label {
  position: absolute;
  top: 50%;
  translate: 0 -50%;
  max-inline-size: 35%;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.mastery-label--left {
  inset-inline-start: -40px;
  text-align: end;
}
.mastery-label--right {
  inset-inline-end: -40px;
  text-align: start;
}
.mastery-label--core {
  position: absolute;
  left: 50%;
  top: 8px;
  translate: -50% 0;
  max-width: 7em;
}

@media (max-width: 1023px) {
  .mastery-label {
    font-size: 15px;
  }
}

@media (max-width: 639px) {
  .mastery-label--core {
    display: none;
  }
  /*
   | Mobile axis is vertical and has the full stage height to work with, so
   | the fragile shared-space problem above doesn't apply — go back to a
   | plain top/spacer/bottom stack, and let long labels wrap normally.
   */
  .mastery-axis-layout {
    /*
     | Must span the FULL stage height, not just its own content height: the
     | slot below needs real room to flex-grow into so it lines up with where
     | the SVG axis line actually sits, and the stack needs to be anchored top
     | AND bottom for `justify-content: stretch` to have anything to stretch
     | across. Anchoring only the bottom (`top: auto`) let the whole group
     | float lower than the line's top endpoint, so Marketing landed beside
     | the line instead of above it.
     */
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: stretch;
    align-items: center;
    padding-block: 24px 18px;
  }
  .mastery-axis-slot {
    display: block;
    order: 2;
    flex: 1 1 0;
    inline-size: 2px;
    min-block-size: 0;
    block-size: auto;
  }
  .mastery-axis-layout .mastery-label {
    position: static;
    translate: none;
    order: 1;
    max-inline-size: 100%;
    overflow: visible;
    white-space: pre-line;
    overflow-wrap: break-word;
    text-align: center;
  }
  .mastery-axis-layout .mastery-label--right {
    order: 3;
  }
}
</style>
