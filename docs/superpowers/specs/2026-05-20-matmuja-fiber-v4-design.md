# M&M EnerTech v4.0 — Dark Cinematic FTTH

**Date:** 2026-05-20
**Owner:** Blerim Matmuja
**Status:** Approved, implementing
**Target version:** `4.0.0`
**Base:** `redesign/v3.0-impl`

## Why v4

v3 (lime + indigo + cream) shipped and is live behind maintenance mode. Owner feedback: "too cold and too 2D". Wants more dynamic, modern, futuristic.

The owner pointed to `glasfaser-phasen.html` — a standalone HTML page he generated showing the 5 FTTH phases with **animated `<canvas>` visualizations** and a dark cinematic palette with per-phase neon accents. v4 adopts that aesthetic wholesale: dark base, animated canvases replace SVGs, cyan-to-mint gradient brand mark, per-phase color identity.

## Design decisions

| Decision | Choice | Rationale |
|---|---|---|
| Palette | **Dark cinematic** — near-black base, cyan-mint gradient accent, 5 per-phase neon colors | User pick. Direct match to the reference HTML. |
| Phase visuals | **Animated `<canvas>` elements**, code lifted from `glasfaser-phasen.html` and shipped as `assets/js/phase-canvases.js` | User pick. Replaces v3's tinted SVGs. |
| Animation cost | **Always-on**, no lazy/reduced-motion gating | User pick. Lighthouse Performance will dip 5–15 pts on mobile; trade accepted. |
| Brand mark | **Linear gradient `#00b4ff → #00ffcc`** on the hero `<h1>` (and the M&M EnerTech wordmark) | Lifted from reference. Memorable, distinctive. |
| Body type/font | **Inter + Space Grotesk** (carried over) | No change. |
| Section structure | **7 sections (same as v3)** | No change. Hero, mission, FTTH timeline, proof, FAQ, CTA, footer. |
| Customizer schema | **Same as v3** (no field changes) | No content surface changes; only visuals + palette. |

## Palette (CSS variables)

```css
:root {
  /* Base — deep space */
  --color-bg:                #060610;  /* body */
  --color-bg-elevated:       #0a1a3a;  /* hero radial center, mission strip */
  --color-bg-card:           #020408;  /* canvas-wrap card background */

  /* Text */
  --color-text:              #e0e8ff;  /* body on dark */
  --color-text-muted:        #506080;  /* secondary text */
  --color-text-bright:       #ffffff;

  /* Brand gradient (used via text-fill-clip on h1/h2/wordmark) */
  --gradient-brand:          linear-gradient(135deg, #00b4ff 0%, #00ffcc 100%);

  /* Per-phase neon — used as accent text + border + glow */
  --color-phase-1:           #00b4ff;  /* cyan — Smart Planning */
  --color-phase-2:           #ff8c00;  /* orange — Tiefbau */
  --color-phase-3:           #00ffcc;  /* mint — Kabelverlegung */
  --color-phase-4:           #bf00ff;  /* purple — Spleißen */
  --color-phase-5:           #00ff88;  /* green — Hausanschluss / Ziellinie */

  /* Effects */
  --glow-cyan:               0 0 70px rgba(0, 130, 255, 0.18);
  --shadow-card:             0 0 70px rgba(0, 130, 255, 0.18);

  /* Typography (unchanged from v3) */
  --font-body:    'Inter', 'Segoe UI', system-ui, sans-serif;
  --font-display: 'Space Grotesk', 'Inter', system-ui, sans-serif;

  --text-xs:   0.75rem;
  --text-sm:   0.875rem;
  --text-base: 1rem;
  --text-lg:   1.125rem;
  --text-xl:   1.5rem;
  --text-2xl:  2rem;
  --text-3xl:  3rem;
  --text-4xl:  4rem;
  --text-hero: clamp(2.2rem, 5vw, 4rem);

  --container: 1380px;
  --radius:    12px;
  --radius-lg: 18px;
  --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
```

## Files to touch (delta from v3)

| File | Change |
|---|---|
| `style.css` | Major rewrite — new palette, dark body, gradient text utility, per-phase color hooks, canvas-wrap card style, scroll-reveal classes. Theme `Version: 4.0.0`. |
| `theme.json` | Palette presets updated to dark base + per-phase colors. |
| `front-page.php` | Hero gets gradient h1. Each phase row: `<img>` swapped for `<div class="canvas-wrap"><canvas id="cN" width="600" height="400"></canvas></div>` + phase-specific accent color. |
| `assets/js/phase-canvases.js` | NEW. Lifted from `/home/blerim/Repo/glasfaser-phasen.html` (lines 124–775 of `<script>`). 650 lines, 5 IIFE canvas drawing loops + IntersectionObserver for scroll-reveal. |
| `functions.php` | Enqueue `phase-canvases.js` only on `is_front_page()` so blog/page templates don't pay the cost. |
| `inc/customizer.php` | Panel title v3.0 → v4.0. No field changes. |
| `README.md` | v4.0 entry in version history. |

## Per-phase accent application

Each `.ftth-phase` element gets a phase-N modifier class that sets CSS custom properties:

```css
.ftth-phase[data-phase="1"] { --phase-accent: var(--color-phase-1); }
.ftth-phase[data-phase="2"] { --phase-accent: var(--color-phase-2); }
.ftth-phase[data-phase="3"] { --phase-accent: var(--color-phase-3); }
.ftth-phase[data-phase="4"] { --phase-accent: var(--color-phase-4); }
.ftth-phase[data-phase="5"] { --phase-accent: var(--color-phase-5); }

.ftth-phase__number { color: var(--phase-accent); }
.ftth-phase__title  { color: var(--phase-accent); }
.ftth-phase__cta    { color: var(--phase-accent); }
.ftth-phase         { border-left-color: var(--phase-accent); }
.canvas-wrap        { box-shadow: 0 0 70px rgba(0, 0, 0, 0.4); border: 1px solid color-mix(in srgb, var(--phase-accent) 30%, transparent); }
```

The `data-phase` attribute drives styling, so PHP just emits `data-phase="<?php echo $i; ?>"` in the loop.

## Acceptance criteria

- Theme `Version: 4.0.0` in `style.css` header
- All 7 sections render; visual is dark-cinematic
- Hero `<h1>` displays cyan-to-mint gradient text
- 5 phase canvases animate continuously (cyan/orange/mint/purple/green)
- Each phase's accent color (border, title, number, CTA) matches the canvas color
- Lighthouse mobile: Performance ≥ 65 (animation cost accepted), Accessibility ≥ 95
- No regression on inner pages (palette propagates via CSS variables)
- v3 customizer field IDs still valid — no content loss

## Risks

- **Animation CPU on mobile** — 5 continuously running canvases is heavier than v3's static SVGs. IntersectionObserver in the lifted JS pauses off-screen canvases via the `.show` class gate; let's trust that. If real-device testing shows jank, add `prefers-reduced-motion` later.
- **Per-phase colors fight brand cohesion** — five distinct accents on one page is loud. Mitigated by the canvas itself dominating each phase row (the color is "contained" to one phase at a time as the user scrolls). The wordmark + buttons still use the cyan-mint gradient for cohesion.
- **Body text contrast on near-black** — `#e0e8ff` on `#060610` is ~16:1, well above AA. Muted text `#506080` on `#060610` is ~3.8:1 — passes AA-large only. Acceptable for secondary text (the muted color is only used for hero sub and footer captions).
