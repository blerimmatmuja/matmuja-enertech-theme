# M&M EnerTech Theme — v2.0 Redesign

**Date:** 2026-05-18
**Owner:** Blerim Matmuja
**Status:** Approved design, ready for implementation plan
**Target version:** `2.0.0`

## 1. Why

The current theme (v1.2.0) is built around a near-black palette (`#1a1a2e` body, `#2d1b69` cards, `#12092a` footer) with light gold text. The owner finds it too dark for everyday reading and brand perception. The site reads as a "futuristic" demo more than a credible energy-technology business.

This redesign keeps M&M EnerTech's brand cue — antique gold (`#c9a84c`) — and the dramatic dark hero/footer, but moves all content sections to a light background. Effects (glow, glassmorphism, animated gradients) are reduced from site-wide treatment to accent-only polish.

## 2. Design decisions

| Decision | Choice | Rationale |
|---|---|---|
| Palette | **Hybrid** — dark hero/footer, light body, gold accent | User pick. Fixes contrast/readability without abandoning the brand's dark drama. |
| Personality | **Refined futuristic** — glow on accents only | User pick. Preserves what's distinctive about the current site; drops what makes it feel like a tech demo. |
| Typography | **Inter** (body) + **Space Grotesk** (headlines) | User pick. Space Grotesk gives headlines a geometric, slightly distinctive feel; Inter handles the rest. |
| Hero treatment | **Split — headline left, abstract SVG right** | User pick. No photography required — ships immediately. |
| Sections | **8 sections, no News/Blog** | User pick. News only matters if posts are actually published. |
| Content | **Placeholders, user fills later** | User pick. Spec marks every placeholder explicitly. |

## 3. Palette

```css
/* Brand */
--color-brand-gold:        #c9a84c;
--color-brand-gold-light:  #e8d5a3;
--color-brand-navy:        #0f1a2e;  /* hero/footer/CTA backgrounds */
--color-brand-navy-deep:   #0b1424;  /* footer base */
--color-brand-navy-tint:   #1a2949;  /* hero gradient end */

/* Surfaces */
--color-surface:           #ffffff;  /* primary content background */
--color-surface-warm:      #f6f5f0;  /* alt content background (proof, alternating) */
--color-surface-band:      #c9a84c;  /* mission strip background */

/* Text */
--color-text:              #0f1a2e;  /* body text on light */
--color-text-muted:        #5b6473;  /* muted body */
--color-text-on-dark:      #ffffff;  /* body text on navy */
--color-text-on-dark-muted: rgba(255,255,255,0.7);

/* Borders / lines */
--color-border:            #eaeaea;
--color-border-on-dark:    rgba(255,255,255,0.12);

/* Effects (accent-only) */
--glow-gold:               0 0 16px rgba(201,168,76,0.4);
--shadow-card:             0 2px 12px rgba(15,26,46,0.06);
--shadow-card-hover:       0 6px 24px rgba(15,26,46,0.10);
```

**WCAG note:** body text on `--color-surface` (#0f1a2e on #fff) is 16.7:1 — well above AA. Mission strip (#0f1a2e on #c9a84c) is 7.8:1 — passes AA. Body text on navy (#fff on #0f1a2e) is 16.7:1.

## 4. Typography

```css
--font-body:    'Inter', system-ui, sans-serif;
--font-display: 'Space Grotesk', 'Inter', system-ui, sans-serif;

--text-xs:   0.75rem;   /* 12px */
--text-sm:   0.875rem;  /* 14px */
--text-base: 1rem;      /* 16px */
--text-lg:   1.125rem;  /* 18px */
--text-xl:   1.5rem;    /* 24px */
--text-2xl:  2rem;      /* 32px */
--text-3xl:  3rem;      /* 48px — hero headline */
--text-4xl:  4rem;      /* 64px — hero headline desktop */
```

- All headings (`h1`–`h4`) use `--font-display` with `letter-spacing: -0.02em` and `line-height: 1.05–1.15`.
- Body uses `--font-body` with `line-height: 1.6`.
- Eyebrow labels (uppercase mini-labels above section titles): `--font-body`, `font-size: 0.6875rem`, `letter-spacing: 0.2em`, `text-transform: uppercase`, color `--color-brand-gold` on dark / `--color-text-muted` on light.

## 5. Page structure (front-page.php)

| # | Section | Background | Notes |
|---|---|---|---|
| 1 | Hero | navy (`--color-brand-navy`) | Split: 1.2fr content / 1fr abstract SVG with radial gold glow + line grid. Headline (Space Grotesk), sub, two CTAs (primary gold w/ glow, secondary ghost). |
| 2 | Mission strip | gold (`--color-brand-gold`) | One centered sentence, Space Grotesk, max-width 60ch. Customizable string. |
| 3 | Services | white | "Unsere Leistungen" + 3 service cards. Card: gold icon square, title, 2-line description. Hover: gold border + `--shadow-card-hover`. |
| 4 | How we work | navy | 4-step horizontal process (Analyse → Konzept → Umsetzung → Service). Big gold numerals. |
| 5 | Proof | warm (`--color-surface-warm`) | 3 stat tiles with `{{years}} / {{projects}} / DIN` placeholders + grayscale client logo row (placeholders). |
| 6 | FAQ | white | Native `<details>` accordion. Plus icon in gold rotates on open. |
| 7 | CTA strip | navy | Centered headline + single gold button with glow. |
| 8 | Footer | navy-deep (`--color-brand-navy-deep`) | Slimmer than current. Single row: contact left, legal links right. Social icons inline. |

The current "Komplette Lösungen" banner is merged into the mission strip. The current "Why Us" section is merged into "How we work". The News/Blog section is removed from `front-page.php` (the archive template still works for `/blog/`).

## 6. Components

### Buttons

```css
.btn-primary {
  background: var(--color-brand-gold);
  color: var(--color-brand-navy);
  padding: 0.875rem 1.5rem;
  border-radius: 6px;
  font-family: var(--font-body);
  font-weight: 600;
  box-shadow: var(--glow-gold);
  transition: transform 0.2s, box-shadow 0.2s;
}
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 0 24px rgba(201,168,76,0.6); }

.btn-ghost {
  background: transparent;
  color: var(--color-text-on-dark);
  border: 1px solid var(--color-border-on-dark);
  padding: 0.875rem 1.5rem;
  border-radius: 6px;
}
```

Glow only on `.btn-primary`. No glow on body links, headings, or cards.

### Service card

```css
.service-card {
  background: var(--color-surface);
  border: 1px solid var(--color-border);
  border-radius: 8px;
  padding: 1.5rem;
  transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
}
.service-card:hover {
  border-color: var(--color-brand-gold);
  box-shadow: var(--shadow-card-hover);
  transform: translateY(-2px);
}
.service-card__icon {
  width: 2.5rem; height: 2.5rem;
  background: var(--color-brand-gold);
  border-radius: 6px;
}
```

### Effects budget

Allowed: gold glow on primary CTAs, hero radial-glow background, subtle card lift on hover, FAQ icon rotate, mission strip stays flat.

Removed from current theme: site-wide animated gradient background, `text-shadow` glow on all hovers, glassmorphism (`backdrop-filter`), `float` animation, `neon-effect`.

## 7. Files to touch

| File | Change |
|---|---|
| `matmuja-enertech/style.css` | Full rewrite. New CSS variables, new component styles. ~600 lines target (down from ~1200). |
| `matmuja-enertech/theme.json` | New palette + typography presets. Add Space Grotesk font family. |
| `matmuja-enertech/front-page.php` | Rewrite to 8-section structure above. Drop News section markup. |
| `matmuja-enertech/header.php` | Light header on inner pages, dark on front (CSS-driven via body class). |
| `matmuja-enertech/footer.php` | Slim single-row layout. |
| `matmuja-enertech/functions.php` | Enqueue Space Grotesk from Google Fonts (or self-host); bump theme version to 2.0.0. Add customizer settings for mission strip text, stat values, hero copy. |
| `matmuja-enertech/inc/template-tags.php` | Adjust as needed for new section rendering. |
| `matmuja-enertech/README.md` | Update color/section docs. |

Out of scope for v2.0.0:
- News/blog templates (still functional but not on front page)
- New 404/search/archive templates (palette-only CSS update via variables)
- New images/photography
- Translation files beyond existing strings

## 8. Placeholders the user must fill before publish

| Placeholder | Where | Default for now |
|---|---|---|
| Hero headline | Customizer | "Energietechnik, neu gedacht." |
| Hero sub | Customizer | "Smarte Lösungen für Industrie, Gewerbe und nachhaltige Quartiere." |
| Mission sentence | Customizer | "Wir bringen smarte Energietechnik dorthin, wo sie wirklich Wirkung entfaltet." |
| 3 service titles + descriptions | Customizer | "Photovoltaik" / "Wärmepumpen" / "Speicher & Smart Grid" with generic descriptions |
| Process step labels | Customizer | "Analyse" / "Konzept" / "Umsetzung" / "Service" |
| `{{years}}`, `{{projects}}` stats | Customizer | "12" / "150" — flagged as TODO in admin |
| Client logos | Customizer (image upload x6) | Grayscale placeholder boxes |
| FAQ items | Customizer (repeater) | 5 starter Q/A |
| CTA headline | Customizer | "Bereit für die Energiezukunft?" |

## 9. Customizer expansion

The current theme already has Customizer support. v2.0 extends it with:

- `mm_hero_headline`, `mm_hero_sub`, `mm_hero_cta_primary`, `mm_hero_cta_secondary`
- `mm_mission_text`
- `mm_service_{1,2,3}_title`, `mm_service_{1,2,3}_desc`, `mm_service_{1,2,3}_icon` (dashicon name or upload)
- `mm_process_step_{1..4}_title`, `mm_process_step_{1..4}_desc`
- `mm_proof_years`, `mm_proof_projects`, `mm_proof_cert`
- `mm_client_logos[]` (repeater, image)
- `mm_faq_items[]` (repeater, q/a)
- `mm_cta_headline`, `mm_cta_button_text`, `mm_cta_button_url`

## 10. Acceptance criteria

- Theme version bumped to `2.0.0` in `style.css` and `functions.php`
- All 8 sections render on `front-page.php` with the structure in §5
- Lighthouse on the front page: Performance ≥90, Accessibility ≥95
- No `backdrop-filter`, no site-wide animation, no `text-shadow` on body links
- Gold glow only on `.btn-primary` and hero radial background
- All copy strings are translatable (`__()` / `_e()` with `matmuja-tiefbau` text domain)
- All customizer fields above are registered with sane defaults
- Builds with `npm run build` (existing pipeline)
- Existing inner-page templates (`page.php`, `single.php`, `archive.php`, `404.php`) still render correctly with the new palette via CSS variables — no per-template HTML changes required

## 11. Risks & open questions

- **Translation text domain mismatch**: theme name is "matmuja-enertech" but text domain is `matmuja-tiefbau` (legacy from earlier theme). **Decision: keep `matmuja-tiefbau`** — no breaking change to existing translations.
- **Font hosting**: **Decision: self-host** Inter + Space Grotesk under `assets/fonts/` as woff2. GDPR-cleaner for a German site, no third-party request. Implementation will fetch fonts at build time (or commit the woff2 files directly).
- **Customizer scope**: 30+ new settings is a lot. Group under sections: "Hero", "Mission", "Leistungen", "Prozess", "Proof", "FAQ", "CTA". Use `WP_Customize_Manager` panels.
- **Live-vs-repo drift**: Not yet verified. Done as a separate task before implementation; if live has hand-edited PHP, the diff must be folded into the repo first.
