# Matmuja Fiber — v5 "Lichtleiter" design

**Date:** 2026-05-23
**Codename:** Lichtleiter (light-conductor)
**Direction:** Engineering · technical minimal
**Predecessor:** v4.2 (dark cinematic + 5 neon canvases) — kept on server as rollback

## Why v5

v4 was approved as "modern futuristic" but never went public (maintenance gate stayed on). On review, three things needed to change:

1. The dark + cyan/mint neon palette reads as 2020-era startup-demo, not as a serious German FTTH firm a Stadtwerk would procure from.
2. The 5 always-on canvas animations are visually busy and don't feel premium.
3. The aesthetic doesn't project the gravitas the actual business deserves.

v5 keeps everything that worked — the 7-section structure, the Customizer schema, the team data, the FTTH process narrative — and rebuilds the visual layer around an **engineering-minimal** aesthetic in the spirit of Linear, Tailscale, and Vercel docs, tuned for a Tiefbau / FTTH audience.

## What stays (do not touch)

- 7-section homepage order (Hero → Mission → Phases → Team → Proof → FAQ → CTA). Locked by owner.
- Customizer schema: all `mm_*` field IDs unchanged. Owner's content carries over with zero re-entry.
- Legacy `matmuja_*` Customizer fields (phone, email, social URLs) — still read by `matmuja_schema_markup()` and `footer.php`.
- Deploy model: new theme dir `matmuja-enertech-v5`, v4 stays for instant rollback.
- WP-CLI activation flow on IONOS.

## Palette

| Role | Hex | Notes |
|---|---|---|
| Paper bg | `#f7f8fa` | Page background |
| Card | `#ffffff` | Team cards, stat tiles, FAQ row hover |
| Ink | `#0a0e1a` | Headlines, key numbers, footer band |
| Body | `#5b6373` | Paragraph text |
| Caption | `#9aa1b0` | Mono labels, meta |
| Hairline | `#e4e7ec` | Grids, dividers, inactive diagram stations |
| Brand | `#0040ff` | Primary CTA fill, fiber-light pulse, links |
| Signal | `#ff6b1a` | Active-phase marker, stat underline, used ≤5 times per page |

Rules:
- **No gradient text anywhere.** No glassmorphism. No drop shadows except a 1px ink hairline on cards (`0 0 0 1px #e4e7ec`).
- **No dark mode in v5** — out of scope. Can be added in v5.x.
- Hyperlinks: brand color, underline on hover only.

## Typography

Single family: **Geist** + **Geist Mono** (Vercel, OFL — self-hosted under `assets/fonts/`). Replaces Inter + Space Grotesk.

| Role | Weight | Size |
|---|---|---|
| h1 | Geist 600 | `clamp(48px, 6vw, 88px)`, line-height 1.05, letter-spacing -0.02em |
| h2 | Geist 600 | `clamp(32px, 4vw, 56px)`, line-height 1.1 |
| h3 | Geist 500 | 24px, line-height 1.25 |
| Body | Geist 400 | 17px, line-height 1.6 |
| Mono | Geist Mono 400/500 | 13–14px, letter-spacing 0.04em uppercase for eyebrows |

Uppercase mono is used for: eyebrows (`FTTH · TIEFBAU BIS BUCHSE`), phase numbers (`01 / 05`), stat units (`KM`, `JAHRE`), schematic callouts on the diagram.

Self-hosted files inside the new v5 theme dir:
- `assets/fonts/geist-400.woff2`
- `assets/fonts/geist-500.woff2`
- `assets/fonts/geist-600.woff2`
- `assets/fonts/geist-mono-400.woff2`
- `assets/fonts/geist-mono-500.woff2`

Inter + Space Grotesk woff2 files are simply not copied into the v5 dir (the v4 dir is untouched — it stays as rollback).

## Motion budget

Tight. Three sources only:
1. Hero h1 + subhead fade-up (300ms ease-out, fires once on load).
2. Section reveals: 8px slide-up + opacity, `IntersectionObserver`, fires once per element.
3. The fiber diagram in §3 — the one motion moment that matters.

`prefers-reduced-motion: reduce` collapses everything: no fades, no slide-ups, diagram shows all 5 stations lit at once.

## Section-by-section

### Header
- Background `#ffffff`, sticky, bottom border `1px #e4e7ec`.
- Left: wordmark `M&M EnerTech` in Geist 600, ink. No gradient.
- Right: nav links (Prozess · Über uns · FAQ · Kontakt) in body color, hover → ink. Small filled-blue "Kontakt aufnehmen" button at the end.
- Fallback nav identical to v4 when no menu assigned in admin.

### §1 Hero
- Paper bg, no gradient.
- Left column (2/3 width on desktop): eyebrow mono `FTTH · TIEFBAU BIS BUCHSE`, h1 ink, subhead in body color (2 lines max), two CTAs side-by-side — primary filled `#0040ff` "Projekt anfragen", secondary text-button "Unser Prozess →" with hairline-ink right-arrow.
- Right column (1/3): small line-art SVG of a fiber cross-section (3-color: brand blue strand, ink jacket, signal-orange marker dot). Static.
- On mobile: stacks, SVG drops to a 64×64 inline element above the eyebrow.

### §2 Mission strip
- Paper bg, slim section (~120px desktop).
- Ink rule (1px, full width) above.
- Big quote in Geist 500 28–32px, ink. Two-line max.
- Attribution below in mono caption: `ING. BLERIM MATMUJA · ING. INDRIT MATMUJA`.

### §3 Phase diagram (centerpiece)

Replaces v4's 5 separate canvases with **one SVG fiber path**.

- Desktop: horizontal left-to-right path spanning ~80% viewport width. The section is `min-height: 180vh` with the SVG `position: sticky; top: 12vh` so the diagram parks center-screen and the pulse advances as the user scrolls past it.
- Mobile: vertical top-to-bottom path inline in the section (NOT sticky scrolljacking). Section is tall enough to show all 5 stations stacked; pulse position is tied to section scroll-progress so it still feels alive without hijacking scroll.
- Path drawn with `stroke-dasharray` / `stroke-dashoffset`. As the user scrolls into the section, the dashoffset reduces to "draw" the line.
- A glowing blue dot (the light pulse) travels along the path at scroll-progress position. Uses `getPointAtLength()` on the SVG path.
- 5 station markers at fixed positions along the path:
  1. Satellite/map icon — Planung
  2. Trench cross-section — Tiefbau
  3. Conduit (Leerrohr) — Kabelverlegung
  4. Splice closure — Spleißen & Messung
  5. Wall socket — Hausanschluss / FTTH-AP
- For each station: as the pulse crosses, the phase title + 2-line description fades in on the alternating side of the path (top/bottom desktop, left/right mobile).
- Currently-active station: `#ff6b1a` 2px ring around marker. Passed stations: brand blue solid fill. Upcoming stations: hairline grey fill.
- Reduced-motion fallback: all 5 stations lit blue at once, all text visible, no pulse.
- New JS file: `assets/js/fiber-diagram.js`, target ≤ 200 lines including reduced-motion branch. Delete `phase-canvases.js`.

Customizer fields stay the same (`mm_phase_1_title`, `mm_phase_1_desc`, etc.) — they just render into the diagram captions instead of into per-phase canvas blocks.

### §4 Über uns / Team
- Paper bg, section padding generous (120px vertical desktop, 80px mobile).
- Two-line section intro on left, two engineer cards on right in 2-col grid (stacks on mobile).
- Each card: white bg, 1px hairline, 32px padding.
  - Portrait: 96×96 square. If real photo: render B/W with 1px hairline. If no photo (default): mono initials (`BM`, `IM`) on paper bg with 1px ink rule.
  - Name in Geist 600 22px ink.
  - Role line in mono 13px caption color (e.g., `ING. · IT / FTTH-AKTIVIERUNG`).
  - 2-line bio in body color.
  - Skill chips: mono 12px, hairline border, 4px padding, no fill. Wrap to multiple lines.

### §5 Proof
- 4 stat tiles in a 4-col grid (2×2 on mobile).
- Each tile: white bg, 1px hairline, 32px padding.
  - Number in Geist Mono 500 48px ink.
  - 2px wide `#ff6b1a` underline directly below number, ~40% width of number.
  - Unit in mono 13px caption.
  - Label in body 15px below.
- Client logos below the tiles: greyscale strip, 6 logo slots, height 32px, opacity 0.6, hover → opacity 1.

### §6 FAQ
- `<details>` accordion, max-width 720px centered.
- Each row: hairline divider top, 24px vertical padding.
- Question in Geist 500 18px ink, left-aligned.
- +/− toggle in ink, right-aligned, no background, no animation beyond rotation.
- Answer in body 16px line-height 1.6, indented 0 (full-width).

### §7 CTA strip
- Paper bg, generous vertical padding.
- Layout: h2 ink left (Geist 600 40px, 2 lines max), primary filled-blue button right.
- Below the row: small mono caption with phone + email pulled from `matmuja_phone` / `matmuja_email` Customizer fields.

### Footer
- `#0a0e1a` band, white text.
- 3-column on desktop, stacks on mobile.
  - Col 1: wordmark `M&M EnerTech` in display white, short tagline below.
  - Col 2: contact (phone, email, address from `matmuja_*` Customizer).
  - Col 3: links — Impressum, Datenschutz, Kontakt.
- Bottom strip: `© 2026 M&M EnerTech` left, social icons right (Instagram + LinkedIn, hairline outline only).

## Architecture

### File changes from v4
| Path | v4 | v5 |
|---|---|---|
| `style.css` | Dark cinematic tokens | Light technical tokens — full rewrite (target ≤ 800 lines source) |
| `assets/js/main.js` | Section reveals, mobile menu | Same purpose, simplified — drop scroll-spy that drove per-canvas play state |
| `assets/js/phase-canvases.js` | 650-line canvas engine | **Deleted** |
| `assets/js/fiber-diagram.js` | — | **New**, ≤ 200 lines |
| `assets/fonts/inter-*.woff2` | 4 files | **Deleted** |
| `assets/fonts/space-grotesk-*.woff2` | 3 files | **Deleted** |
| `assets/fonts/geist-*.woff2` | — | **New**, 5 files |
| `functions.php` | enqueues Inter + Space Grotesk + phase-canvases.js | Enqueue Geist + Geist Mono + fiber-diagram.js |
| `front-page.php` | 7 sections with per-canvas blocks in §3 | 7 sections with single SVG block in §3 |
| `header.php` / `footer.php` | Dark theme | Light theme; footer keeps dark band |
| `theme.json` | Dark palette tokens | Light palette tokens |
| `inc/customizer.php` | `mm_*` fields | **Unchanged** — schema preserved |

### Bundle budget
- CSS: ≤ 30KB minified
- JS: ≤ 15KB minified (down from ~22KB in v4 because phase-canvases.js is gone)
- Fonts: 5 × Geist woff2 files, ≤ 200KB total (Geist is ~25–45KB per weight)
- No external requests at runtime (no Google Fonts, no CDN).

## Out of scope for v5

- Dark mode
- Animated hero (3D fiber spool, video bg, etc.)
- Real photography pipeline (we draft with mono-initial placeholders; owner supplies photos later)
- Blog / case studies pages
- Language switcher (German only for now)
- Cookie banner (no third-party tracking shipped)

## Deploy

- New theme dir on server: `wp-content/themes/matmuja-enertech-v5`.
- v4 dir stays in place. Rollback = `wp theme activate matmuja-enertech-v4`.
- Maintenance gate stays `1` until owner reviews v5 in Customizer preview, then flip to `0` to go public.
- SSH user `su411687` on `access-5020163956.webspace-host.com`. Owner confirmed 2026-05-23 the existing password is still valid.

## Acceptance criteria

1. `matmuja-enertech-v5` activates on the server with no PHP fatals and renders the full homepage with default Customizer values.
2. All 7 sections present, in the correct order, with no leftover dark-theme CSS bleeding through.
3. The fiber diagram in §3 animates on scroll on a modern desktop browser and falls back to the static "all 5 lit" state under `prefers-reduced-motion: reduce`.
4. Customizer panel "M&M EnerTech (v4.0)" still shows all `mm_*` fields and edits update the front-end live.
5. Lighthouse on desktop ≥ 95 across Performance / Accessibility / Best Practices / SEO.
6. No console errors on first paint or after scrolling through the homepage.
7. v4 theme dir untouched on server, can be re-activated as instant rollback.
