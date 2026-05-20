# M&M EnerTech WordPress Theme

A WordPress theme for M&M EnerTech — end-to-end FTTH (Fiber to the Home) infrastructure. Dark cinematic aesthetic with animated phase canvases and per-phase neon accents.

## Design

- **Palette:** Background `#060610` · Card `#020408` · Cyan `#00b4ff` · Mint `#00ffcc` (brand gradient). Per-phase: cyan (Planung), orange (Tiefbau), mint (Verlegung), purple (Spleißen), green (Hausanschluss/Ziellinie).
- **Typography:** Inter (body) + Space Grotesk (display), self-hosted under `assets/fonts/`
- **Effects:** Cyan-mint gradient on all hero/headline text. Per-phase neon glow around each phase canvas. Pulsing dot badge in eyebrows. Scroll-reveal fade for phase rows.

## Homepage sections (`front-page.php`)

1. Hero (radial-gradient dark, centered gradient h1, two pill CTAs)
2. Mission strip (dark band, gradient text)
3. FTTH 5-phase timeline — each phase is an alternating row with an animated `<canvas>` (cyan/orange/mint/purple/green)
4. Proof (darker, 4 gradient stat tiles + client logos)
5. FAQ (dark cards, cyan plus icon)
6. CTA strip (dark radial)
7. Footer (deepest, brand wordmark in gradient)

The 5 FTTH phases are: **Smart Planning → Precision Tiefbau → Kabelverlegung → Spleißen & Messung → Hausanschluss / FTTH**. Each has 4 bullet points of detail visible in the timeline.

## Phase canvases

`assets/js/phase-canvases.js` (~650 lines) is enqueued only on `is_front_page()` and runs 5 `requestAnimationFrame` loops — one per phase — each drawing a phase-specific animated visualization. The script also wires up an `IntersectionObserver` that adds a `.show` class for the scroll-reveal fade-in.

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
