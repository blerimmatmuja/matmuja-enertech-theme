# M&M EnerTech — v5 "Lichtleiter"

Engineering-minimal WordPress theme for the M&M EnerTech FTTH/Tiefbau business.
Light paper aesthetic, single Geist family, and a scroll-linked SVG fiber
diagram that traces all 5 process phases as one continuous strand.

**Version:** 5.0.0 · **WordPress:** 6.0+ · **PHP:** 8.0+
**Live deploy dir on server:** `wp-content/themes/matmuja-enertech-v5`
**Predecessor (rollback):** `matmuja-enertech-v4` (dark cinematic + 5 canvases)

## Design

- **Palette:** Paper `#f7f8fa` · Card `#ffffff` · Ink `#0a0e1a` · Body `#5b6373` · Brand blue `#0040ff` · Signal orange `#ff6b1a` (sparing).
- **Typography:** Geist + Geist Mono only — self-hosted under `assets/fonts/`.
- **Motion:** Tight budget. Reveal fade-up on section entry; one big scroll-linked SVG diagram in §3. Everything collapses to static under `prefers-reduced-motion: reduce`.

## Homepage sections (`front-page.php`)

1. Hero — eyebrow + ink h1 + two CTAs, line-art fiber cross-section right
2. Mission strip — slim, big quote in ink, mono attribution
3. FTTH phase diagram — single SVG fiber path, blue pulse rides along on scroll, 5 stations light up in sequence
4. Über uns / Team — 2 engineer cards with mono-initial portraits and skill chips
5. Proof — 4 stat tiles with signal-orange underlines + greyscale client strip
6. FAQ — `<details>` accordion, hairline dividers, mono +/− toggle
7. CTA strip — paper bg, ink h2, primary blue button, mono contact line

The 5 FTTH phases are: **Planung → Tiefbau → Kabelverlegung → Spleißen & Messung → Hausanschluss**.

## Fiber diagram (`assets/js/fiber-diagram.js`)

~95 lines. Enqueued only on `is_front_page()`. Reads the SVG `<path>`'s
`getTotalLength()`, listens to scroll via `requestAnimationFrame`, and
(a) reduces `stroke-dashoffset` to draw the path, (b) places a glowing
blue circle along the path via `getPointAtLength()`, and (c) toggles
`.active`/`.passed` on the 5 station markers. Reduced-motion users skip
the loop entirely; CSS shows all 5 stations lit by default.

## Customizer

All copy is editable under **Appearance → Customize → M&M EnerTech (v4.0)**, grouped into panels: Hero, Mission, FTTH-Prozess, Proof, FAQ, CTA.

Stats default to placeholders (`12+ Jahre Tiefbau`, `1200 km Faser verlegt`, `150 Projekte`, `DIN zertifiziert`) — replace with real numbers before publish.

## Build

```bash
npm install
npm run build   # builds style.min.css and main.min.js
```

## Install

Upload the theme directory (or a zip of it) via **Appearance → Themes → Add New → Upload Theme**, then activate. Existing v1 / v2 / v3 theme directories remain available as rollback options.

## Version history

- **4.0.0** — Dark cinematic with animated phase canvases (see `docs/superpowers/specs/2026-05-20-matmuja-fiber-v4-design.md`)
- 3.0.0 — FTTH redesign with lime + indigo palette and 5-phase timeline. Felt too cold/2D — superseded by 4.0.
- 2.0.0 — Hybrid palette refactor (navy + gold). Wrong content (energy tech) — superseded by 3.0.
- 1.2.0 — Media support for service phase images
- 1.1.0 — Modernized terminology
- 1.0.0 — Initial fiber-optic-focused release
