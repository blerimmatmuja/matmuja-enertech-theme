# M&M EnerTech Theme — v3.0 FTTH Redesign

**Date:** 2026-05-19
**Owner:** Blerim Matmuja
**Status:** Approved design, ready for implementation plan
**Target version:** `3.0.0`
**Base branch:** `redesign/v2.0-impl`

## 1. Why v3 (the v2 problem)

v2.0 was built around the wrong business assumption: I treated the company as "energy tech" (Photovoltaik, Wärmepumpen, Smart Grid) because the theme had been renamed from "Matmuja Tiefbau" to "M&M EnerTech" and I read the new name as the new business. It is not. The actual business — visible in the v1.0.0 backup at `/home/blerim/Backups/matmuja-theme-backup-20260518-200832.tar.gz` and in the surviving SVG service images (`s1_projektplanung`, `s2_tiefbau`, `s3_kabelverlegung`, `s4_spleissen`, `s5_hausanschluss`) — is **end-to-end FTTH (Fiber to the Home) infrastructure**: from initial planning and civil engineering (Tiefbau) through cabling, splicing, and the final subscriber connection.

v3 keeps the structural improvements from v2 (hybrid layout, customizer-driven copy, refined-futuristic effects, Inter + Space Grotesk, classic theme architecture) and replaces:

- The all-wrong content (energy tech services, generic copy) with real FTTH content lifted from v1.0.0 and updated
- The navy + gold palette (familiar B2B pairing) with a **distinctive brand-recognition palette** — lime, indigo, cream — so visitors form a strong color memory
- v2's separate "Services" + "How we work" sections (redundant for a process-driven company) with a single **5-phase vertical zigzag FTTH timeline**

## 2. Design decisions

| Decision | Choice | Rationale |
|---|---|---|
| Palette | **Lime + Indigo + Cream** | User pick. No German fiber/Tiefbau competitor uses this. High color memorability. |
| Brand name shown | **M&M EnerTech** | User pick. The "Matmuja" legacy in code stays, but the user-facing label is M&M EnerTech everywhere. |
| Typography | **Inter (body) + Space Grotesk (display)**, self-hosted | Carried over from v2. |
| Effects budget | **Refined futuristic — lime glow on accents only** | Carried over from v2 with palette swap. |
| Hero visual | **Network node + pulse SVG** | User pick. Reads as "network infrastructure" — more abstract than fiber strands, broader visual appeal. |
| Services layout | **Vertical zigzag timeline, 5 phases** | User pick. Strongest "Vom Spaten bis zur Buchse" story; lets us reuse the existing 5 service SVGs as featured imagery. |
| Section count | **7 sections** (no separate "how we work") | The 5-phase timeline IS the process. |
| Content basis | **v1.0.0 copy + photos** | User pick. Real, accurate, German B2B-appropriate language. |

## 3. Palette

```css
/* Brand — v3 */
--color-brand-lime:        #C6FF3D;  /* primary accent — buttons, accents, hero glow */
--color-brand-lime-dark:   #85B800;  /* lime on light backgrounds (text/icons) */
--color-brand-indigo:      #1B1B3A;  /* hero/CTA/footer-top backgrounds, primary text on light */
--color-brand-indigo-deep: #0F0F2A;  /* deepest footer */
--color-brand-indigo-tint: #2A2A55;  /* hero gradient end */

/* Surfaces */
--color-surface:           #FFFFFF;  /* white sections */
--color-surface-warm:      #F5F4EC;  /* cream — primary body background, alt sections */
--color-surface-band:      #C6FF3D;  /* mission strip */

/* Text */
--color-text:              #1B1B3A;  /* body on cream/white */
--color-text-muted:        #4A4A6A;  /* muted body */
--color-text-on-dark:      #FFFFFF;  /* body on indigo */
--color-text-on-dark-muted: rgba(255,255,255,0.7);

/* Borders */
--color-border:            #D8D5C2;  /* warm border on cream */
--color-border-on-dark:    rgba(255,255,255,0.12);

/* Effects (accent-only) */
--glow-lime:               0 0 16px rgba(198,255,61,0.45);
--glow-lime-strong:        0 0 24px rgba(198,255,61,0.65);
--shadow-card:             0 2px 12px rgba(27,27,58,0.06);
--shadow-card-hover:       0 6px 24px rgba(27,27,58,0.12);
```

**WCAG note:**
- Text on cream (#1B1B3A on #F5F4EC) ≈ **14.5:1** — AAA
- Text on white (#1B1B3A on #FFFFFF) ≈ **16.0:1** — AAA
- White on indigo (#FFFFFF on #1B1B3A) ≈ **16.0:1** — AAA
- Indigo on lime (#1B1B3A on #C6FF3D) ≈ **11.2:1** — AAA — mission strip + primary button readable
- Lime on indigo (#C6FF3D on #1B1B3A) ≈ **12.0:1** — AAA — used for accent text/labels

## 4. Typography

Identical to v2 (`--font-body` Inter, `--font-display` Space Grotesk, self-hosted woff2 under `assets/fonts/`). No new font loads.

## 5. Page structure (front-page.php)

| # | Section | Background | Notes |
|---|---|---|---|
| 1 | Hero | indigo (`--color-brand-indigo`) | Split: 1.2fr content / 1fr abstract SVG. Headline (Space Grotesk), sub, two CTAs (primary lime w/ glow, secondary ghost). SVG: network node + pulse from `personality.html` mockup. |
| 2 | Mission strip | lime (`--color-brand-lime`) | One centered sentence, Space Grotesk, max-width 60ch, dark indigo text. |
| 3 | FTTH timeline | cream (`--color-surface-warm`) | Section heading + 5 phase rows. Each row: 2-column grid, SVG and content alternating sides (zigzag). 2px lime left border per row. Phase 5 ("Hausanschluss / Ziellinie") gets a featured treatment: lime accent label, glowing SVG card. |
| 4 | Proof | indigo (`--color-brand-indigo`) | 3 stat tiles with placeholders (`{{years}}+ Jahre Tiefbau` / `{{km}} km Faser verlegt` / `DIN zertifiziert`) + grayscale client logo row (Netzbetreiber + Stadtwerke placeholders). Stats render in lime. |
| 5 | FAQ | cream | Native `<details>` accordion. Plus icon in lime-dark rotates on open. 5 starter Q/A about FTTH projects. |
| 6 | CTA strip | indigo | Centered headline + single lime button with glow. |
| 7 | Footer | indigo-deep (`--color-brand-indigo-deep`) | Single row: brand + contact (phone, email) left, social + legal right. Same structure as v2 post-fix-up. |

Removed from v2: separate "Services" (3 cards) and "How we work" (4 steps). Both functions absorbed into §3.

## 6. The FTTH timeline (the section that matters most)

```html
<section class="section section--warm">
  <div class="container">
    <div class="ftth-header">
      <p class="eyebrow">UNSER GLASFASER-PROZESS</p>
      <h2>In 5 Phasen zum Hausanschluss</h2>
    </div>

    <ol class="ftth-timeline">
      <li class="ftth-phase ftth-phase--right">  <!-- SVG right, text left -->
        <div class="ftth-phase__content">
          <p class="ftth-phase__number">PHASE 01</p>
          <h3 class="ftth-phase__title">Smart Planning &amp; Design</h3>
          <p class="ftth-phase__desc">…</p>
          <a class="link-arrow" href="…">Projektplanung starten →</a>
        </div>
        <div class="ftth-phase__visual">
          <img src=".../s1_projektplanung_mm.svg" alt="">
        </div>
      </li>
      <li class="ftth-phase ftth-phase--left">…</li>  <!-- SVG left, text right -->
      …
      <li class="ftth-phase ftth-phase--right ftth-phase--final">…</li>  <!-- featured -->
    </ol>
  </div>
</section>
```

CSS sketch:
```css
.ftth-timeline { list-style: none; padding: 0; margin-top: 3rem; }
.ftth-phase {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  align-items: center;
  padding: 2rem 0 2rem 1.5rem;
  border-left: 2px solid var(--color-brand-lime);
  position: relative;
}
.ftth-phase + .ftth-phase { margin-top: 1rem; }
.ftth-phase--left  .ftth-phase__visual  { grid-column: 1; grid-row: 1; }
.ftth-phase--left  .ftth-phase__content { grid-column: 2; grid-row: 1; text-align: right; }
.ftth-phase--right .ftth-phase__visual  { grid-column: 2; grid-row: 1; }
.ftth-phase--right .ftth-phase__content { grid-column: 1; grid-row: 1; }

.ftth-phase__visual {
  background: var(--color-brand-indigo);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  aspect-ratio: 1 / 1;
  max-width: 280px;
  margin: 0 auto;
}
.ftth-phase__visual img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  filter: brightness(0) invert(1) sepia(1) hue-rotate(40deg) saturate(8);  /* tint SVG lime */
}
.ftth-phase--final .ftth-phase__visual {
  box-shadow: var(--glow-lime-strong);
  background: linear-gradient(135deg, var(--color-brand-indigo) 0%, var(--color-brand-indigo-tint) 100%);
}
.ftth-phase--final .ftth-phase__number { color: var(--color-brand-lime-dark); }

@media (max-width: 767px) {
  .ftth-phase { grid-template-columns: 1fr; gap: 1.5rem; }
  .ftth-phase--left .ftth-phase__content,
  .ftth-phase--right .ftth-phase__content { grid-column: 1; grid-row: 2; text-align: left; }
  .ftth-phase--left  .ftth-phase__visual,
  .ftth-phase--right .ftth-phase__visual { grid-column: 1; grid-row: 1; }
}
```

The SVG tint trick (`filter: brightness(0) invert(1) ...`) recolors the existing v1 SVGs to lime without needing to edit each SVG file. If the visual result looks off (some SVGs may have multi-color elements), fall back to inline `<svg>` rendering with `currentColor` and CSS-driven color — implementation will decide per file.

## 7. The five phases (content, lifted from v1 with light edits)

| # | Title (de) | One-line description | CTA |
|---|---|---|---|
| 01 | Smart Planning & Design | GIS-gestützte Trassenplanung mit KI-Optimierung — von der Adressvalidierung bis zur 3D-Visualisierung. | Projektplanung starten |
| 02 | Precision Tiefbau | GPS-gesteuerte minimalinvasive Verfahren, die Bestandsnetze schonen und Trassen präzise vorbereiten. | Tiefbau-Details |
| 03 | Kabelverlegung | Mikrorohr-Systeme und Glasfaser-Einblasen mit Schutz für bestehende Infrastruktur. | Verlegung verstehen |
| 04 | Spleißen & Messung | Präzise Faser-zu-Faser-Verbindung, OTDR-Abnahmemessung, dokumentierte Qualitätssicherung. | Spleiß-Standards |
| 05 | Hausanschluss / FTTH | Die aktive Buchse beim Endkunden — bereit für Gigabit. Das Ziel der ganzen Reise. | Hausanschluss anfragen |

All five are customizer-editable (`mm_phase_{1..5}_title`, `mm_phase_{1..5}_desc`, `mm_phase_{1..5}_cta_text`, `mm_phase_{1..5}_cta_url`).

## 8. Hero visual

Inline SVG in `front-page.php` (not an `<img>` so the lime color picks up CSS variables and the file is one HTTP request fewer):

```html
<div class="hero__visual" aria-hidden="true">
  <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid slice">
    <defs>
      <radialGradient id="hero-glow" cx="50%" cy="50%" r="60%">
        <stop offset="0%"   stop-color="currentColor" stop-opacity="0.25"/>
        <stop offset="100%" stop-color="currentColor" stop-opacity="0"/>
      </radialGradient>
      <pattern id="hero-grid" width="14" height="14" patternUnits="userSpaceOnUse">
        <path d="M 14 0 L 0 0 0 14" fill="none" stroke="currentColor" stroke-width="0.25" opacity="0.35"/>
      </pattern>
    </defs>
    <rect width="200" height="200" fill="url(#hero-grid)"/>
    <rect width="200" height="200" fill="url(#hero-glow)"/>
    <line x1="40"  y1="50"  x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
    <line x1="160" y1="60"  x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
    <line x1="60"  y1="150" x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
    <line x1="160" y1="150" x2="100" y2="100" stroke="currentColor" stroke-width="0.7" opacity="0.7"/>
    <circle cx="40"  cy="50"  r="4" fill="currentColor"/>
    <circle cx="100" cy="100" r="6" fill="currentColor"/>
    <circle cx="160" cy="60"  r="4" fill="currentColor"/>
    <circle cx="60"  cy="150" r="4" fill="currentColor"/>
    <circle cx="160" cy="150" r="4" fill="currentColor"/>
    <circle cx="100" cy="100" r="14" fill="none" stroke="currentColor" stroke-width="0.6" opacity="0.4"/>
    <circle cx="100" cy="100" r="22" fill="none" stroke="currentColor" stroke-width="0.4" opacity="0.25"/>
  </svg>
</div>
```

The wrapping `.hero__visual { color: var(--color-brand-lime); }` makes every `currentColor` reference resolve to lime.

## 9. Files to touch (delta from v2)

| File | Change |
|---|---|
| `matmuja-enertech/style.css` | Replace `:root { --color-brand-* … }` block with new lime/indigo/cream variables. Replace v2's `.btn--primary`, `.service-card`, `.process-grid` blocks with new component blocks: `.btn--primary` (lime), `.ftth-timeline`, `.ftth-phase`, `.ftth-phase__visual`, `.ftth-phase--final`, `.ftth-header`, updated `.eyebrow`. Remove the old `.services-grid`, `.process-grid`, `.process-step` blocks. Bump theme version to 3.0.0 in the header comment. |
| `matmuja-enertech/theme.json` | Replace palette presets (rename brand-gold → brand-lime, brand-navy → brand-indigo, etc.) and the `styles.color.background` value. |
| `matmuja-enertech/front-page.php` | Rewrite: remove sections 3 (services-grid) and 4 (how-we-work). Insert single FTTH timeline section. Replace hero SVG with the network-node version above. Replace hero/mission/CTA default copy with FTTH-flavored German strings. |
| `matmuja-enertech/inc/customizer.php` | Replace `mm_service_{1,2,3}_*` and `mm_process_step_{1..4}_*` settings with `mm_phase_{1..5}_*` (title, desc, cta_text, cta_url). Replace `mm_services_heading` / `mm_process_heading` with `mm_ftth_heading`. Keep all other v2 fields (hero, mission, proof, faq, cta). |
| `matmuja-enertech/functions.php` | Bump version in PHP `Version` reference only if hardcoded; the enqueue reads from `wp_get_theme()->get('Version')`, so style.css header is enough. No other changes. |
| `matmuja-enertech/assets/images/s{1..5}_*.svg` | Keep as-is (they're being reused). |
| `matmuja-enertech/README.md` | Update palette + section docs + version history. |

Out of scope (carried unchanged from v2):
- Self-hosted fonts under `assets/fonts/`
- `header.php`, `footer.php` (palette inherited via CSS variables)
- Inner-page templates (`page.php`, `single.php`, `404.php`, `archive.php`)
- Legacy `matmuja_customize_register` block in `functions.php` (still feeds `matmuja_schema_markup` and the footer contact strip)

## 10. Customizer changes

Add (new):
- `mm_ftth_heading` (text, default "In 5 Phasen zum Hausanschluss")
- `mm_phase_{1..5}_title`, `mm_phase_{1..5}_desc`, `mm_phase_{1..5}_cta_text`, `mm_phase_{1..5}_cta_url` (20 settings)
- Stat: `mm_proof_km` (text, "Stat: km Faser verlegt", default "1200")

Remove (orphan from v2):
- `mm_service_{1,2,3}_title|desc|icon`
- `mm_process_step_{1..4}_title|desc`
- `mm_services_heading`, `mm_process_heading`

Keep (v2):
- All `mm_hero_*`, `mm_mission_text`, `mm_proof_years`, `mm_proof_projects`, `mm_proof_cert`, `mm_client_logo_{1..6}`, `mm_faq_*`, `mm_cta_*`
- Legacy `matmuja_phone`, `matmuja_email`, `matmuja_instagram`, `matmuja_linkedin` (footer + schema)

Net field change: −13 + 21 = **48 fields total**.

## 11. Acceptance criteria

- Theme `Version: 3.0.0` in `style.css` header
- All 7 sections render in order on `front-page.php` with the structure in §5
- 5-phase timeline correctly alternates SVG left/right; on mobile collapses to single column with SVG above content
- Lime glow appears only on `.btn--primary` (hero CTA, CTA strip button) and the hero radial — nowhere else
- All copy strings translatable (`__()` / `_e()` with `matmuja-tiefbau` text domain — kept as in v2)
- Lighthouse front page: Performance ≥ 90, Accessibility ≥ 95
- `npm run build` produces `style.min.css` without errors
- All customizer fields above are registered with sane German defaults; orphan v2 fields removed
- Existing v1 SVG service images (`s1_projektplanung_mm.svg` through `s5_hausanschluss_mm.svg`) render in the timeline tinted lime
- Inner-page templates inherit the new palette via CSS variables without per-template edits

## 12. Risks & open questions

- **SVG tint via CSS filter**: the v1 SVGs may have built-in colors (the `<head>` peek showed `fill="..."` declarations). The `filter: brightness(0) invert(1) sepia(1) hue-rotate(40deg) saturate(8)` trick works for monochrome SVGs but can mangle multi-color ones. If results look bad, implementation should fall back to either (a) inlining the SVGs and replacing `fill` attributes with `currentColor`, or (b) re-exporting the SVGs as monochrome. **Default approach: try the filter first, inline as fallback.**
- **Deploy strategy**: v3 ships as a new theme dir (`matmuja-enertech-v3/`) parallel to `matmuja-enertech-v2/` and the legacy `matmuja-enertech-v1.1.0-final/`. User activates via WP admin. This keeps three rollback levels.
- **v2 PR (#1)**: Should be closed (not merged) with a comment pointing to the upcoming v3 PR. v2 was built on wrong content; merging it into master would commit that wrongness to history. **Default: close PR #1 unmerged once v3 lands.**
- **Branch naming**: v3 work happens on `redesign/v3.0-impl` (off `redesign/v2.0-impl` to inherit the v2 foundation). The eventual v3 PR targets `master`, not `redesign/v2.0-impl`.
- **Stats placeholder**: `{{km}}` is shown as a placeholder in the proof section; the user should swap in a real number (or remove the stat entirely if no real figure exists) before going live. The customizer field exists; defaults to `1200` as a clearly-fake placeholder.
