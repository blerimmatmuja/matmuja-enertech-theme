# M&M EnerTech WordPress Theme

A WordPress theme for M&M EnerTech — end-to-end FTTH (Fiber to the Home) infrastructure: Tiefbau, Verlegung, Spleißen, Hausanschluss. Lime + Indigo brand palette.

## Design

- **Palette:** Lime `#C6FF3D` · Indigo `#1B1B3A` · Indigo deep `#0F0F2A` · Cream `#F5F4EC` · White `#FFFFFF`
- **Typography:** Inter (body) + Space Grotesk (display), self-hosted under `assets/fonts/`
- **Effects budget:** lime glow only on `.btn--primary` and the `.ftth-phase--final` visual; no site-wide animation, no glassmorphism

## Homepage sections (`front-page.php`)

1. Hero (indigo, network-node + pulse SVG)
2. Mission strip (lime band)
3. FTTH 5-phase timeline (cream, vertical zigzag with the 5 service SVGs)
4. Proof (indigo, 4 stats + client logos)
5. FAQ (cream, native `<details>` accordion)
6. CTA strip (indigo)
7. Footer (deepest indigo)

The 5 FTTH phases are: **Smart Planning → Precision Tiefbau → Kabelverlegung → Spleißen & Messung → Hausanschluss / FTTH**.

## Customizer

All copy is editable under **Appearance → Customize → M&M EnerTech (v3.0)**, grouped into panels: Hero, Mission, FTTH-Prozess, Proof, FAQ, CTA.

Stats default to placeholders (`12+ Jahre Tiefbau`, `1200 km Faser verlegt`, `150 Projekte`, `DIN zertifiziert`) — replace with real numbers before publish.

## Build

```bash
npm install
npm run build   # builds style.min.css and main.min.js
```

## Install

Upload the theme directory (or a zip of it) via **Appearance → Themes → Add New → Upload Theme**, then activate. Existing v1 / v2 theme directories remain available as rollback options.

## Version history

- **3.0.0** — FTTH redesign with lime + indigo palette and 5-phase timeline (see `docs/superpowers/specs/2026-05-19-matmuja-fiber-v3-design.md`)
- 2.0.0 — Hybrid palette refactor (navy + gold). Wrong content — superseded by 3.0.
- 1.2.0 — Media support for service phase images
- 1.1.0 — Modernized terminology
- 1.0.0 — Initial fiber-optic-focused release
