import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import logical from 'tailwindcss-logical'

/**
 * Design tokens for file HuuGewZFHRm2ekVUFPDQhR, page "User interface" (1:2).
 *
 * PROVENANCE — read this before trusting a value.
 *
 * The file binds almost nothing to named Figma variables. A `get_figma_data`
 * sweep of page 1:2 (2026-08-07, AUDIT/figma-final/report.md) surfaced exactly
 * four named variables in the whole page:
 *
 *   black/100 #E9E9E9 · black/200 #D3D2D2 · gold/100 #F9F5EC · Color/White #FFFFFF
 *
 * Those four are verified 1:1 against `neutral.100`, `neutral.200`, `gold.100`
 * and `paper` below. Every other value here was transcribed from raw node
 * fills, not read from a variable, and is therefore UNVERIFIED against a
 * design token. Treat it as the implementation's best record of the design,
 * not as authoritative.
 *
 * The audit ran against the Framelink Figma MCP, which has no
 * `get_variable_defs`. If the Dev Mode MCP is reconnected, re-read the
 * variable collections and reconcile this file against them.
 *
 * @type {import('tailwindcss').Config}
 */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{js,ts,vue}',
    './app/Filament/**/*.php',
    './vendor/filament/**/*.blade.php',
  ],

  darkMode: 'class',

  theme: {
    // Breakpoints. The file provides 1440 desktop and 402 mobile frames only;
    // md/lg are derived (documented in docs/RESPONSIVE-QA.md, gap G1).
    screens: {
      xs: '480px',
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
      '2xl': '1440px',
      '3xl': '1600px',
    },

    extend: {
      colors: {
        // Figma: "primary black" / "primary white" / "primary gold"
        ink: '#231F20',
        paper: '#FFFFFF', // verified — Figma variable `Color/White`
        gold: {
          DEFAULT: '#BD933B', // primary gold
          // Warm page tint behind the featured insight card (Blog list frames).
          50: '#FBF9F5',
          100: '#F9F5EC', // verified — Figma variable `gold/100`
          200: '#F2E9D8',
          // Package-card price rule. Was inlined as `text-[#ecdfc5]`.
          300: '#ECDFC5',
          400: '#E5D4B1',
          500: '#DEC99D',
          600: '#D7BE89',
          700: '#D1B476',
          800: '#CAA962',
          900: '#C49E4F',
        },
        // Figma: black/50 … black/1000
        neutral: {
          // Testimonial-card default chip. Was inlined as `bg-[#f8f7f8]`.
          25: '#F8F7F8',
          50: '#F4F3F4',
          100: '#E9E9E9', // verified — Figma variable `black/100`
          200: '#D3D2D2', // verified — Figma variable `black/200`
          300: '#BDBCBD',
          500: '#918F90',
          600: '#7B7979',
          700: '#656363',
          800: '#4F4C4D',
          900: '#393637',
          1000: '#231F20',
        },
      },

      /*
       | Spacing scale. Transcribed from observed auto-layout padding and gap
       | values on page 1:2 — the file exposes no named `space*` variables.
       | Merged over Tailwind's defaults, so 2.5/5/20 (10/20/80px) remain
       | available for the handful of nodes that use them.
       */
      spacing: {
        1: '4px',
        2: '8px',
        3: '12px',
        4: '16px',
        6: '24px',
        8: '32px',
        10: '40px',
        12: '48px',
        14: '56px',
        16: '64px',
        18: '72px',
        24: '96px',
        28: '112px',
      },

      // Radii observed on page 1:2 nodes; no named radius variables exist.
      borderRadius: {
        xs: '4px',
        sm: '8px',
        md: '12px',
        lg: '16px',
        round: '1000px',
      },

      fontFamily: {
        // EN — Poppins (Figma "EN-Desktop/*")
        sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        // FA/AR — Doran FaNum (Figma "AR-Desktop/*"), Vazirmatn fallback.
        // See docs/ASSET-MANIFEST.md §10 — Doran is commercially licensed.
        arabic: ['"Doran FaNum"', 'Vazirmatn', 'Tahoma', 'sans-serif'],
        /*
         | Display accent — eyebrows, hero accent runs, package prices.
         | Idealist is Latin-only (see its unicode-range in fonts.css), so
         | fa/ar fall through to the Arabic display face rather than to a
         | generic serif. Use `font-display` instead of hardcoding the stack.
         */
        display: ['Idealist', '"Doran FaNum"', 'Vazirmatn', 'serif'],
      },

      fontSize: {
        /*
         | Figma type tokens.
         |
         | Every text node in the file leaves line height on "Auto"
         | (`lineHeightUnit: INTRINSIC_%`), which Figma renders at Poppins'
         | natural 1.5 — verified across the Home, Services, About and
         | Privacy frames: 48→72, 40→60, 30→45, 20→30, 14→21. Only two nodes
         | in the whole file override it. So 1.5 IS the design, and the frame
         | heights the layout is built from assume it; tightening display
         | leading here would shorten every heading block against the file.
         */
        'label-md': ['12px', { lineHeight: '1.5', fontWeight: '500' }],
        'label-lg': ['14px', { lineHeight: '1.5', fontWeight: '500' }],
        'body-md': ['14px', { lineHeight: '1.5', fontWeight: '400' }],
        'body-lg': ['16px', { lineHeight: '1.5', fontWeight: '400' }],
        // Figma 20/400 — legal body copy, service section intros.
        'body-xl': ['20px', { lineHeight: '1.5', fontWeight: '400' }],
        'title-sm': ['18px', { lineHeight: '1.5', fontWeight: '400' }],
        'title-md': ['20px', { lineHeight: '1.5', fontWeight: '500' }],
        'title-lg': ['22px', { lineHeight: '1.5', fontWeight: '500' }],
        // Figma 24/500 — card titles, final-CTA headline.
        'title-xl': ['24px', { lineHeight: '1.5', fontWeight: '500' }],
        // Figma 26/600 and 28/500 — legal/section sub-heads.
        'heading-sm': ['26px', { lineHeight: '1.5', fontWeight: '600' }],
        'heading-md': ['28px', { lineHeight: '1.5', fontWeight: '500' }],
        // Figma 30/500 — legal section headings.
        'heading-lg': ['30px', { lineHeight: '1.5', fontWeight: '500' }],
        // Figma 32/400 — package price lines.
        'heading-xl': ['32px', { lineHeight: '1.5', fontWeight: '400' }],
        'display-sm': ['36px', { lineHeight: '1.5', fontWeight: '500' }],
        'display-md': ['40px', { lineHeight: '1.5', fontWeight: '600' }],
        'display-lg': ['48px', { lineHeight: '1.5', fontWeight: '600' }],
      },

      maxWidth: {
        // Figma desktop content track: 1248 …
        container: '1248px',
        // … inside a 1440 frame. `.container-sahra` caps on the frame and
        // subtracts the 96 gutter as padding, which yields the 1248 track.
        frame: '1440px',
      },

      boxShadow: {
        // Figma: shadow-[4px_4px_12px_0px_rgba(0,0,0,0.05)] on project cards
        card: '4px 4px 12px 0px rgba(0, 0, 0, 0.05)',
        // Figma 414:862: 1.9536679983px offsets, 5.861003876px blur, no spread
        testimonial: '1.954px 1.954px 5.861px rgba(0, 0, 0, 0.05)',
        // Figma: 3.321px blur on case-study banner
        banner: '3.321px 3.321px 9.962px rgba(0, 0, 0, 0.05)',
      },

      backdropBlur: {
        // Figma: header backdrop-blur-[15px]
        header: '15px',
      },

      transitionTimingFunction: {
        /*
         | CSS-side brand ease. NOTE: this is NOT the same curve as
         | `MOTION.ease.brand` in lib/motion.ts, which is GSAP's `power3.out`
         | (a cubic ease-out with no exact bezier equivalent). The two are
         | visually close but numerically different; see the INFO item in
         | AUDIT/figma-final/report.md §6. Figma stores no easing for the
         | scroll effects, so neither can currently be validated against it.
         */
        brand: 'cubic-bezier(0.22, 1, 0.36, 1)',
      },

      zIndex: {
        header: '50',
        overlay: '60',
        menu: '70',
        modal: '80',
      },

      keyframes: {
        'fade-up': {
          '0%': { opacity: '0', transform: 'translateY(24px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },

      animation: {
        'fade-up': 'fade-up 0.6s cubic-bezier(0.22, 1, 0.36, 1) both',
      },
    },
  },

  plugins: [forms, typography, logical],
}
