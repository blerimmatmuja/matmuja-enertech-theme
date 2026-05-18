# M&M EnerTech WordPress Theme

A WordPress theme for M&M EnerTech with a hybrid palette: dark navy hero/footer, light body, antique-gold accent.

## Design

- **Palette:** Navy `#0f1a2e` · Navy deep `#0b1424` · Surface `#fff` · Surface warm `#f6f5f0` · Gold `#c9a84c`
- **Typography:** Inter (body) + Space Grotesk (headings), self-hosted under `assets/fonts/`
- **Effects budget:** gold glow only on `.btn--primary` and the hero radial; no site-wide animation, no glassmorphism

## Homepage sections (`front-page.php`)

1. Hero (dark, split with abstract SVG)
2. Mission strip (gold band)
3. Services (white, 3 cards)
4. How we work (dark, 4 steps)
5. Proof (warm, stats + client logos)
6. FAQ (white, native `<details>` accordion)
7. CTA strip (dark)
8. Footer (deepest navy)

## Customizer

All copy is editable under **Appearance → Customize → M&M EnerTech (v2.0)**, grouped into panels: Hero, Mission, Leistungen, Prozess, Proof, FAQ, CTA.

Stats default to `12+ Jahre` / `150 Projekte` / `DIN zertifiziert` — replace with real numbers before publish.

## Build

```bash
npm install
npm run build   # builds style.min.css and main.min.js
```

## Install

Upload the theme directory (or a zip of it) via **Appearance → Themes → Add New → Upload Theme**, then activate.

## Version history

- **2.0.0** — Hybrid palette redesign, customizer expansion, self-hosted fonts (see `docs/superpowers/specs/2026-05-18-matmuja-enertech-redesign-design.md`)
- 1.2.0 — Media support for service phase images
- 1.1.0 — Modernized terminology
- 1.0.0 — Initial release
