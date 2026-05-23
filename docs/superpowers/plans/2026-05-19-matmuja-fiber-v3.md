# M&M EnerTech v3.0 FTTH — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ship `matmuja-enertech` v3.0.0 implementing the approved FTTH-focused redesign in `docs/superpowers/specs/2026-05-19-matmuja-fiber-v3-design.md`. Lime + Indigo + Cream palette, 5-phase vertical zigzag timeline, network-node hero SVG.

**Architecture:** v3 is a content + palette pivot on top of v2's structural foundation. Same classic WordPress theme, same Inter + Space Grotesk fonts (already self-hosted), same customizer-driven copy pattern. CSS variables drive everything — most v2 component CSS still applies after palette swap. Only `front-page.php` sections 3+4 and the hero SVG need new HTML; the rest is value substitution.

**Tech Stack:** PHP 8.0+, WordPress 6.0+, CSS3, vanilla JS, PostCSS for minification. Testing via [WordPress Playground](https://playground.wordpress.net) — same loop as v2.

**Working branch:** `redesign/v3.0-impl`, branched off `redesign/v3.0-spec` (which contains the spec).

**Out of scope per spec §9:** Self-hosted fonts (already done in v2), `header.php`, `footer.php` (palette inherits via CSS variables), inner-page templates, legacy `matmuja_customize_register` block.

---

## Verification model

PHP CLI is not installed locally — `php -l` is not available. Use:
1. **Node brace counter** for CSS/PHP curly-brace balance:
   ```bash
   node -e "const c=require('fs').readFileSync(process.argv[1],'utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);" <file>
   ```
2. **Visual check** in WordPress Playground at the end (Task 10)

Build the zip with Python (the `zip` CLI is also unavailable):
```python
import zipfile, os
with zipfile.ZipFile('/tmp/matmuja-enertech.zip', 'w', zipfile.ZIP_DEFLATED) as z:
    for root, _, files in os.walk('matmuja-enertech'):
        for f in files:
            if f.endswith('.DS_Store') or f.endswith('.min.css.map'): continue
            p = os.path.join(root, f)
            z.write(p, p)
```

---

## File inventory

| File | Action | Responsibility |
|---|---|---|
| `matmuja-enertech/style.css` | Modify variables + components | Palette swap, drop service-card/process blocks, add ftth-timeline blocks, bump theme `Version: 3.0.0` |
| `matmuja-enertech/theme.json` | Modify palette + font presets | New brand-lime/brand-indigo slugs, background color update |
| `matmuja-enertech/front-page.php` | Rewrite sections 1, 2, 3, 5, 6 (sections 4+5 of v2 merged into one) | New hero SVG, FTTH-flavored copy, replace services+process with single FTTH timeline |
| `matmuja-enertech/inc/customizer.php` | Modify (delete v2 service/process fields, add v3 phase fields + km stat) | Customizer-side schema for new copy |
| `matmuja-enertech/README.md` | Update | Palette/section docs, v3.0 in version history |

No new files. No file deletions. Fonts and templates stay as-is.

---

## Task 1: Branch setup

**Files:**
- Working branch only (no file content changes)

- [ ] **Step 1: Branch off `redesign/v3.0-spec`**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git checkout redesign/v3.0-spec
git checkout -b redesign/v3.0-impl
git status   # expect: clean, on redesign/v3.0-impl
git log --oneline -3
```

Expected `git log` shows `3f1bf52 docs: add v3.0 FTTH redesign spec ...` as the latest commit, with v2 commits beneath it.

- [ ] **Step 2: No commit needed for branch creation alone — proceed to Task 2.**

---

## Task 2: Palette swap — style.css variables + theme.json

**Files:**
- Modify: `matmuja-enertech/style.css` (lines 1–~75 — header comment + `:root` variables only)
- Modify: `matmuja-enertech/theme.json` (full file)

- [ ] **Step 1: Replace the style.css header comment + `:root` block**

Open `matmuja-enertech/style.css`. Find the comment block at the top (`Theme Name: M&M EnerTech ... */`) and the `:root { ... }` block that immediately follows. Replace both — from line 1 through the closing `}` of `:root` — with:

```css
/*
Theme Name: M&M EnerTech
Theme URI: https://www.matmuja.de/
Author: M&M EnerTech UG
Description: Professional WordPress theme for M&M EnerTech — FTTH (Fiber to the Home) end-to-end. Lime + Indigo palette, refined-futuristic accents.
Version: 3.0.0
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: matmuja-tiefbau
Tags: business, fiber-optic, custom-colors, custom-menu, responsive-layout, custom-logo, editor-styles, featured-images, threaded-comments, translation-ready
*/

/* === 1. VARIABLES === */
:root {
  /* Brand — v3 */
  --color-brand-lime:        #C6FF3D;
  --color-brand-lime-dark:   #85B800;
  --color-brand-indigo:      #1B1B3A;
  --color-brand-indigo-deep: #0F0F2A;
  --color-brand-indigo-tint: #2A2A55;

  /* Surfaces */
  --color-surface:           #FFFFFF;
  --color-surface-warm:      #F5F4EC;
  --color-surface-band:      #C6FF3D;

  /* Text */
  --color-text:              #1B1B3A;
  --color-text-muted:        #4A4A6A;
  --color-text-on-dark:      #FFFFFF;
  --color-text-on-dark-muted: rgba(255, 255, 255, 0.7);

  /* Borders */
  --color-border:            #D8D5C2;
  --color-border-on-dark:    rgba(255, 255, 255, 0.12);

  /* Effects (accent-only) */
  --glow-lime:               0 0 16px rgba(198, 255, 61, 0.45);
  --glow-lime-strong:        0 0 24px rgba(198, 255, 61, 0.65);
  --shadow-card:             0 2px 12px rgba(27, 27, 58, 0.06);
  --shadow-card-hover:       0 6px 24px rgba(27, 27, 58, 0.12);

  /* Typography */
  --font-body:    'Inter', system-ui, sans-serif;
  --font-display: 'Space Grotesk', 'Inter', system-ui, sans-serif;

  --text-xs:   0.75rem;
  --text-sm:   0.875rem;
  --text-base: 1rem;
  --text-lg:   1.125rem;
  --text-xl:   1.5rem;
  --text-2xl:  2rem;
  --text-3xl:  3rem;
  --text-4xl:  4rem;

  /* Layout */
  --container: 1200px;
  --radius:    8px;
  --radius-lg: 12px;

  --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
```

The rest of style.css (reset, typography, layout, components from v2) stays in place for now — Task 3 will edit individual component blocks.

- [ ] **Step 2: Replace theme.json entirely**

Write to `matmuja-enertech/theme.json`:

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 2,
  "settings": {
    "color": {
      "palette": [
        { "slug": "brand-lime",        "color": "#C6FF3D", "name": "Brand Lime" },
        { "slug": "brand-lime-dark",   "color": "#85B800", "name": "Brand Lime Dark" },
        { "slug": "brand-indigo",      "color": "#1B1B3A", "name": "Brand Indigo" },
        { "slug": "brand-indigo-deep", "color": "#0F0F2A", "name": "Brand Indigo Deep" },
        { "slug": "surface",           "color": "#FFFFFF", "name": "Surface" },
        { "slug": "surface-warm",      "color": "#F5F4EC", "name": "Surface Warm" },
        { "slug": "text",              "color": "#1B1B3A", "name": "Text" },
        { "slug": "text-muted",        "color": "#4A4A6A", "name": "Text Muted" }
      ]
    },
    "typography": {
      "fontFamilies": [
        { "fontFamily": "'Inter', system-ui, sans-serif", "slug": "body", "name": "Inter" },
        { "fontFamily": "'Space Grotesk', 'Inter', system-ui, sans-serif", "slug": "display", "name": "Space Grotesk" }
      ]
    },
    "spacing": { "units": ["px", "em", "rem", "%", "vh", "vw"] },
    "layout":  { "contentSize": "800px", "wideSize": "1200px" }
  },
  "styles": {
    "color":      { "background": "#F5F4EC", "text": "#1B1B3A" },
    "typography": { "fontFamily": "var(--wp--preset--font-family--body)", "lineHeight": "1.6" }
  }
}
```

- [ ] **Step 3: Validate JSON + brace balance**

```bash
python3 -m json.tool matmuja-enertech/theme.json > /dev/null && echo "JSON OK"
node -e "const c=require('fs').readFileSync('matmuja-enertech/style.css','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('css open:',o,'close:',cl); process.exit(o===cl?0:1);"
```

Both should succeed (JSON OK + balanced braces).

- [ ] **Step 4: Commit**

```bash
git add matmuja-enertech/style.css matmuja-enertech/theme.json
git commit -m "feat(theme): v3 palette — lime + indigo + cream

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 3: style.css components — drop v2 service/process blocks, add FTTH timeline

**Files:**
- Modify: `matmuja-enertech/style.css` (components section, Task 6 of v2)

- [ ] **Step 1: Find and DELETE the v2 service-card and process blocks**

In `matmuja-enertech/style.css`, find and remove these entire blocks (they live in the "5. COMPONENTS" section):

- `/* --- Service card --- */` — through end of `.service-card__icon img { ... }` (everything `.service-card`, `.service-card__icon`, `.service-card__icon img`, `.service-card__title`, `.service-card__desc`, `.services-grid`)
- `/* --- Process steps --- */` — through end of `.process-step__desc { ... }` (everything `.process-grid`, `.process-step__num`, `.process-step__title`, `.process-step__desc`)

Use `grep -n "service-card\|services-grid\|process-grid\|process-step" matmuja-enertech/style.css` first to see exact line ranges. Delete those line ranges.

- [ ] **Step 2: Append the v3 FTTH timeline components to style.css**

Append the following at the end of the "5. COMPONENTS" section, before any subsequent section comment:

```css
/* --- FTTH Timeline --- */
.ftth-header { text-align: center; margin-bottom: 1rem; }
.ftth-header h2 { margin-top: 0.25rem; }

.ftth-timeline {
  list-style: none;
  padding: 0;
  margin: 3rem 0 0;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.ftth-phase {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  align-items: center;
  padding: 2rem 0 2rem 1.5rem;
  border-left: 2px solid var(--color-brand-lime);
  position: relative;
}
.ftth-phase__content { display: flex; flex-direction: column; gap: 0.5rem; }
.ftth-phase__number {
  font-family: var(--font-body);
  font-size: var(--text-xs);
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--color-text-muted);
  margin: 0;
}
.ftth-phase__title { margin: 0; }
.ftth-phase__desc  { color: var(--color-text-muted); margin: 0; }
.ftth-phase__cta {
  font-family: var(--font-body);
  font-size: var(--text-sm);
  font-weight: 600;
  color: var(--color-brand-lime-dark);
  margin-top: 0.5rem;
  display: inline-block;
}
.ftth-phase__cta:hover { color: var(--color-brand-indigo); }

.ftth-phase__visual {
  background: var(--color-brand-indigo);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  aspect-ratio: 1 / 1;
  max-width: 280px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--color-brand-lime);
}
.ftth-phase__visual img,
.ftth-phase__visual svg {
  width: 100%;
  height: 100%;
  object-fit: contain;
}
.ftth-phase__visual img {
  /* Tint monochrome SVG to lime — fallback to inlined SVG if this fails visually */
  filter: brightness(0) invert(1) sepia(1) hue-rotate(40deg) saturate(8);
}

/* Alternating sides — desktop only */
.ftth-phase--left  .ftth-phase__visual  { order: 1; }
.ftth-phase--left  .ftth-phase__content { order: 2; text-align: right; }
.ftth-phase--right .ftth-phase__visual  { order: 2; }
.ftth-phase--right .ftth-phase__content { order: 1; }
.ftth-phase--left  .ftth-phase__content { align-items: flex-end; }

/* Phase 5 — featured "finish line" */
.ftth-phase--final .ftth-phase__number  { color: var(--color-brand-lime-dark); }
.ftth-phase--final .ftth-phase__visual  {
  background: linear-gradient(135deg, var(--color-brand-indigo) 0%, var(--color-brand-indigo-tint) 100%);
  box-shadow: var(--glow-lime-strong);
}

@media (max-width: 767px) {
  .ftth-phase {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  .ftth-phase--left  .ftth-phase__content,
  .ftth-phase--right .ftth-phase__content {
    text-align: left;
    align-items: flex-start;
    order: 2;
  }
  .ftth-phase--left  .ftth-phase__visual,
  .ftth-phase--right .ftth-phase__visual {
    order: 1;
    max-width: 200px;
  }
}
```

- [ ] **Step 3: Verify v2 service/process selectors are gone and v3 is present**

```bash
grep -nE "service-card|services-grid|process-grid|process-step" matmuja-enertech/style.css
# Expect: NO matches
echo "---"
grep -nE "ftth-phase|ftth-timeline|ftth-header" matmuja-enertech/style.css | head -10
# Expect: multiple matches
echo "---"
node -e "const c=require('fs').readFileSync('matmuja-enertech/style.css','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);"
```

- [ ] **Step 4: Commit**

```bash
git add matmuja-enertech/style.css
git commit -m "feat(theme): swap service-card/process CSS for FTTH timeline blocks

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 4: front-page.php — hero SVG swap

**Files:**
- Modify: `matmuja-enertech/front-page.php` (hero `__visual` block only)

- [ ] **Step 1: Replace the entire `<div class="hero__visual" ...>` block**

In `matmuja-enertech/front-page.php`, find the existing hero visual block (it currently contains an SVG with a `<pattern id="hero-grid">` and two concentric circles at center). Replace the entire `<div class="hero__visual" aria-hidden="true"> ... </div>` block — including opening and closing div tags — with:

```php
            <div class="hero__visual" aria-hidden="true" style="color: var(--color-brand-lime);">
                <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
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

The inline `style="color: var(--color-brand-lime);"` is what makes every `currentColor` reference resolve to lime, including the gradient stops and grid lines.

- [ ] **Step 2: Brace balance check on PHP**

```bash
node -e "const c=require('fs').readFileSync('matmuja-enertech/front-page.php','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);"
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/front-page.php
git commit -m "feat(theme): replace hero SVG with network-node + pulse

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 5: front-page.php — hero, mission, CTA, eyebrow copy updates (FTTH-flavored)

**Files:**
- Modify: `matmuja-enertech/front-page.php` (default strings inside the `$mm(...)` calls and the `<p class="eyebrow">` literal labels)

- [ ] **Step 1: Update hero defaults**

In `matmuja-enertech/front-page.php`, change these defaults:

1. The eyebrow inside the hero (currently `<?php bloginfo( 'name' ); ?>`): change to:
   ```php
   <p class="eyebrow eyebrow--on-dark">M&amp;M EnerTech · Glasfaser</p>
   ```

2. Hero headline default — find this line:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_headline', __( 'Energietechnik, neu gedacht.', 'matmuja-tiefbau' ) ) ); ?>
   ```
   Replace the default string:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_headline', __( 'Vom Spaten bis zur Buchse.', 'matmuja-tiefbau' ) ) ); ?>
   ```

3. Hero sub default — find:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_sub', __( 'Smarte Lösungen für Industrie, Gewerbe und nachhaltige Quartiere.', 'matmuja-tiefbau' ) ) ); ?>
   ```
   Replace default string:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_sub', __( 'Glasfaserinfrastruktur von A bis Z — Tiefbau, Verlegung, Spleißen, Hausanschluss.', 'matmuja-tiefbau' ) ) ); ?>
   ```

4. Hero primary CTA default text — find:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_cta_primary', __( 'Beratung anfragen', 'matmuja-tiefbau' ) ) ); ?>
   ```
   Replace default:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_cta_primary', __( 'FTTH anfragen', 'matmuja-tiefbau' ) ) ); ?>
   ```

5. Hero secondary CTA default text — find:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_cta_secondary', __( 'Leistungen', 'matmuja-tiefbau' ) ) ); ?>
   ```
   Replace default:
   ```php
   <?php echo esc_html( $mm( 'mm_hero_cta_secondary', __( '5 Phasen ansehen', 'matmuja-tiefbau' ) ) ); ?>
   ```

6. Hero secondary CTA URL default — find:
   ```php
   <a class="btn btn--ghost" href="<?php echo esc_url( $mm( 'mm_hero_cta_secondary_url', '#leistungen' ) ); ?>">
   ```
   Replace `#leistungen` with `#prozess`.

- [ ] **Step 2: Update mission strip default**

Find:
```php
<?php echo esc_html( $mm( 'mm_mission_text', __( 'Wir bringen smarte Energietechnik dorthin, wo sie wirklich Wirkung entfaltet.', 'matmuja-tiefbau' ) ) ); ?>
```

Replace default string:
```php
<?php echo esc_html( $mm( 'mm_mission_text', __( 'Glasfaser komplett aus einer Hand — wir übernehmen jede Phase vom ersten Spatenstich bis zur aktiven Buchse.', 'matmuja-tiefbau' ) ) ); ?>
```

- [ ] **Step 3: Update CTA strip defaults**

Find the CTA strip headline:
```php
<h2><?php echo esc_html( $mm( 'mm_cta_headline', __( 'Bereit für die Energiezukunft?', 'matmuja-tiefbau' ) ) ); ?></h2>
```

Replace default:
```php
<h2><?php echo esc_html( $mm( 'mm_cta_headline', __( 'Bereit für Ihr Glasfaserprojekt?', 'matmuja-tiefbau' ) ) ); ?></h2>
```

Find CTA button text:
```php
<?php echo esc_html( $mm( 'mm_cta_button_text', __( 'Beratung anfragen', 'matmuja-tiefbau' ) ) ); ?>
```

Replace default:
```php
<?php echo esc_html( $mm( 'mm_cta_button_text', __( 'Kostenlose Erstberatung', 'matmuja-tiefbau' ) ) ); ?>
```

- [ ] **Step 4: Brace balance + commit**

```bash
node -e "const c=require('fs').readFileSync('matmuja-enertech/front-page.php','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);"

git add matmuja-enertech/front-page.php
git commit -m "feat(theme): FTTH-flavored hero/mission/CTA defaults

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 6: front-page.php — replace services + how-we-work sections with FTTH timeline

**Files:**
- Modify: `matmuja-enertech/front-page.php` (replace section 3 + section 4 with a single new section)

- [ ] **Step 1: Find the section boundaries to delete**

Find both `<!-- 3. SERVICES -->` and `<!-- 4. HOW WE WORK -->` comments. Delete everything from `<!-- 3. SERVICES -->` through the closing `</section>` of the How-We-Work section (inclusive). The result of the deletion: after the Mission Strip's `</section>`, the next code should be the Proof section comment `<!-- 5. PROOF -->`.

After deletion, **re-number** the remaining sections: 5 → 4 (Proof), 6 → 5 (FAQ), 7 → 6 (CTA). Update the HTML comments accordingly:
- `<!-- 5. PROOF -->` → `<!-- 4. PROOF -->`
- `<!-- 6. FAQ -->` → `<!-- 5. FAQ -->`
- `<!-- 7. CTA STRIP -->` → `<!-- 6. CTA STRIP -->`

- [ ] **Step 2: Insert the new FTTH timeline section in place of what you deleted**

Where the two old sections were (between `<!-- 2. MISSION STRIP -->`'s closing `</section>` and the new `<!-- 4. PROOF -->`), insert:

```php

<!-- 3. FTTH TIMELINE -->
<section id="prozess" class="section section--warm">
    <div class="container">
        <div class="ftth-header">
            <p class="eyebrow"><?php esc_html_e( 'Unser Glasfaser-Prozess', 'matmuja-tiefbau' ); ?></p>
            <h2><?php echo esc_html( $mm( 'mm_ftth_heading', __( 'In 5 Phasen zum Hausanschluss', 'matmuja-tiefbau' ) ) ); ?></h2>
        </div>

        <ol class="ftth-timeline">
            <?php
            $phase_defaults = [
                1 => [
                    'title' => __( 'Smart Planning &amp; Design', 'matmuja-tiefbau' ),
                    'desc'  => __( 'GIS-gestützte Trassenplanung mit KI-Optimierung — von der Adressvalidierung bis zur 3D-Visualisierung.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Projektplanung starten', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-1-projektplanung',
                    'svg'   => 's1_projektplanung_mm.svg',
                ],
                2 => [
                    'title' => __( 'Precision Tiefbau', 'matmuja-tiefbau' ),
                    'desc'  => __( 'GPS-gesteuerte minimalinvasive Verfahren, die Bestandsnetze schonen und Trassen präzise vorbereiten.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Tiefbau-Details', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-2-tiefbauarbeiten',
                    'svg'   => 's2_tiefbau_mm.svg',
                ],
                3 => [
                    'title' => __( 'Kabelverlegung', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Mikrorohr-Systeme und Glasfaser-Einblasen mit Schutz für bestehende Infrastruktur.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Verlegung verstehen', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-3-kabelverlegung',
                    'svg'   => 's3_kabelverlegung_mm.svg',
                ],
                4 => [
                    'title' => __( 'Spleißen &amp; Messung', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Präzise Faser-zu-Faser-Verbindung, OTDR-Abnahmemessung, dokumentierte Qualitätssicherung.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Spleiß-Standards', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-4-spleissen',
                    'svg'   => 's4_spleissen_mm.svg',
                ],
                5 => [
                    'title' => __( 'Hausanschluss / FTTH', 'matmuja-tiefbau' ),
                    'desc'  => __( 'Die aktive Buchse beim Endkunden — bereit für Gigabit. Das Ziel der ganzen Reise.', 'matmuja-tiefbau' ),
                    'cta'   => __( 'Hausanschluss anfragen', 'matmuja-tiefbau' ),
                    'url'   => '/stufe-5-hausanschluss',
                    'svg'   => 's5_hausanschluss_mm.svg',
                ],
            ];

            for ( $i = 1; $i <= 5; $i++ ) :
                $title = $mm( "mm_phase_{$i}_title",    $phase_defaults[ $i ]['title'] );
                $desc  = $mm( "mm_phase_{$i}_desc",     $phase_defaults[ $i ]['desc'] );
                $cta   = $mm( "mm_phase_{$i}_cta_text", $phase_defaults[ $i ]['cta'] );
                $url   = $mm( "mm_phase_{$i}_cta_url",  $phase_defaults[ $i ]['url'] );
                $side  = ( $i % 2 === 1 ) ? 'right' : 'left';  /* odd phases: visual right; even: visual left */
                $final = ( 5 === $i ) ? ' ftth-phase--final' : '';
                $svg   = $phase_defaults[ $i ]['svg'];
                ?>
                <li class="ftth-phase ftth-phase--<?php echo esc_attr( $side ); ?><?php echo $final; ?>">
                    <div class="ftth-phase__content">
                        <p class="ftth-phase__number"><?php printf( esc_html__( 'Phase %02d', 'matmuja-tiefbau' ), $i ); ?><?php if ( 5 === $i ) : ?> · <?php esc_html_e( 'Ziellinie', 'matmuja-tiefbau' ); ?><?php endif; ?></p>
                        <h3 class="ftth-phase__title"><?php echo esc_html( $title ); ?></h3>
                        <p class="ftth-phase__desc"><?php echo esc_html( $desc ); ?></p>
                        <?php if ( $cta && $url ) : ?>
                            <a class="ftth-phase__cta" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $cta ); ?> &rarr;</a>
                        <?php endif; ?>
                    </div>
                    <div class="ftth-phase__visual" aria-hidden="true">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $svg ); ?>" alt="" loading="lazy">
                    </div>
                </li>
            <?php endfor; ?>
        </ol>
    </div>
</section>
```

- [ ] **Step 3: Add `mm_proof_km` rendering inside the existing Proof section**

In the now-renumbered `<!-- 4. PROOF -->` section, find the `<div class="proof-stats">` element. It currently has three `.proof-stat` divs (years, projects, cert). Replace the second one (`projects`) with two stats — keep projects, add `km`:

Find:
```php
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_projects', '150' ) ); ?></div>
                <div class="proof-stat__label"><?php esc_html_e( 'Projekte', 'matmuja-tiefbau' ); ?></div>
            </div>
```

Replace with two stat tiles (km, projects):
```php
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_km', '1200' ) ); ?> km</div>
                <div class="proof-stat__label"><?php esc_html_e( 'Faser verlegt', 'matmuja-tiefbau' ); ?></div>
            </div>
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_projects', '150' ) ); ?></div>
                <div class="proof-stat__label"><?php esc_html_e( 'Projekte', 'matmuja-tiefbau' ); ?></div>
            </div>
```

This now gives 4 stat tiles in the proof grid (years, km, projects, cert) — the existing `.proof-stats` CSS uses `repeat(auto-fit, minmax(160px, 1fr))` so it wraps gracefully.

Also update the years label from `'Jahre'` to `'Jahre Tiefbau'`:

Find:
```php
                <div class="proof-stat__label"><?php esc_html_e( 'Jahre', 'matmuja-tiefbau' ); ?></div>
```
Replace:
```php
                <div class="proof-stat__label"><?php esc_html_e( 'Jahre Tiefbau', 'matmuja-tiefbau' ); ?></div>
```

- [ ] **Step 4: Brace balance + commit**

```bash
node -e "const c=require('fs').readFileSync('matmuja-enertech/front-page.php','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);"

git add matmuja-enertech/front-page.php
git commit -m "feat(theme): FTTH 5-phase timeline replaces services + how-we-work

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 7: Customizer — remove v2 service/process fields, add v3 phase fields

**Files:**
- Modify: `matmuja-enertech/inc/customizer.php`

- [ ] **Step 1: Locate the v2 service block (lines ~59–64)**

In `matmuja-enertech/inc/customizer.php`, find the `// Services (3)` comment block. It currently registers `mm_services_heading` and a 3-iteration loop for service title/desc/icon. DELETE that entire block:

```php
    // Services (3)
    $text( 'mm_services_heading', 'mm_services', __( 'Section heading', 'matmuja-tiefbau' ), 'Unsere Leistungen' );
    for ( $i = 1; $i <= 3; $i++ ) {
        $text(     "mm_service_{$i}_title", 'mm_services', sprintf( __( 'Service %d title', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_service_{$i}_desc",  'mm_services', sprintf( __( 'Service %d description', 'matmuja-tiefbau' ), $i ) );
        $image(    "mm_service_{$i}_icon",  'mm_services', sprintf( __( 'Service %d icon (optional, square image)', 'matmuja-tiefbau' ), $i ) );
    }
```

- [ ] **Step 2: Locate the v2 process block and DELETE it**

```php
    // Process (4)
    $text( 'mm_process_heading', 'mm_process', __( 'Section heading', 'matmuja-tiefbau' ), 'So arbeiten wir' );
    for ( $i = 1; $i <= 4; $i++ ) {
        $text(     "mm_process_step_{$i}_title", 'mm_process', sprintf( __( 'Step %d title', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_process_step_{$i}_desc",  'mm_process', sprintf( __( 'Step %d description', 'matmuja-tiefbau' ), $i ) );
    }
```

- [ ] **Step 3: Locate the `$sections` array and rename**

Find the `$sections = [ ... ]` array near the top of the function. Replace these two lines:
```php
        'mm_services' => __( 'Leistungen', 'matmuja-tiefbau' ),
        'mm_process'  => __( 'Prozess', 'matmuja-tiefbau' ),
```

With a single line:
```php
        'mm_ftth'     => __( 'FTTH-Prozess', 'matmuja-tiefbau' ),
```

The full `$sections` array after edit should have **6** entries (was 7): `mm_hero`, `mm_mission`, `mm_ftth`, `mm_proof`, `mm_faq`, `mm_cta`.

- [ ] **Step 4: Insert the v3 phase block where the v2 service block was**

In place of the deleted service+process blocks, insert the new FTTH phases block:

```php
    // FTTH phases (5)
    $text( 'mm_ftth_heading', 'mm_ftth', __( 'Section heading', 'matmuja-tiefbau' ), 'In 5 Phasen zum Hausanschluss' );
    $phase_defaults = [
        1 => [ 'Smart Planning & Design',  'GIS-gestützte Trassenplanung mit KI-Optimierung — von der Adressvalidierung bis zur 3D-Visualisierung.',  'Projektplanung starten',  '/stufe-1-projektplanung' ],
        2 => [ 'Precision Tiefbau',         'GPS-gesteuerte minimalinvasive Verfahren, die Bestandsnetze schonen und Trassen präzise vorbereiten.',     'Tiefbau-Details',         '/stufe-2-tiefbauarbeiten' ],
        3 => [ 'Kabelverlegung',            'Mikrorohr-Systeme und Glasfaser-Einblasen mit Schutz für bestehende Infrastruktur.',                       'Verlegung verstehen',     '/stufe-3-kabelverlegung' ],
        4 => [ 'Spleißen & Messung',        'Präzise Faser-zu-Faser-Verbindung, OTDR-Abnahmemessung, dokumentierte Qualitätssicherung.',                'Spleiß-Standards',        '/stufe-4-spleissen' ],
        5 => [ 'Hausanschluss / FTTH',      'Die aktive Buchse beim Endkunden — bereit für Gigabit. Das Ziel der ganzen Reise.',                       'Hausanschluss anfragen',  '/stufe-5-hausanschluss' ],
    ];
    for ( $i = 1; $i <= 5; $i++ ) {
        list( $pt, $pd, $pc, $pu ) = $phase_defaults[ $i ];
        $text(     "mm_phase_{$i}_title",    'mm_ftth', sprintf( __( 'Phase %d title', 'matmuja-tiefbau' ),       $i ), $pt );
        $textarea( "mm_phase_{$i}_desc",     'mm_ftth', sprintf( __( 'Phase %d description', 'matmuja-tiefbau' ), $i ), $pd );
        $text(     "mm_phase_{$i}_cta_text", 'mm_ftth', sprintf( __( 'Phase %d CTA label', 'matmuja-tiefbau' ),   $i ), $pc );
        $url(      "mm_phase_{$i}_cta_url",  'mm_ftth', sprintf( __( 'Phase %d CTA URL', 'matmuja-tiefbau' ),     $i ), $pu );
    }
```

- [ ] **Step 5: Add `mm_proof_km` field**

Find the existing Proof block:
```php
    // Proof
    $text( 'mm_proof_years',    'mm_proof', __( 'Stat: years',    'matmuja-tiefbau' ), '12' );
    $text( 'mm_proof_projects', 'mm_proof', __( 'Stat: projects', 'matmuja-tiefbau' ), '150' );
```

Insert a new line between years and projects:
```php
    // Proof
    $text( 'mm_proof_years',    'mm_proof', __( 'Stat: years',    'matmuja-tiefbau' ), '12' );
    $text( 'mm_proof_km',       'mm_proof', __( 'Stat: km fiber', 'matmuja-tiefbau' ), '1200' );
    $text( 'mm_proof_projects', 'mm_proof', __( 'Stat: projects', 'matmuja-tiefbau' ), '150' );
```

- [ ] **Step 6: Brace balance + verify**

```bash
node -e "const c=require('fs').readFileSync('matmuja-enertech/inc/customizer.php','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);"

# v2 names gone:
grep -nE "mm_service_|mm_process_|mm_services_heading|mm_process_heading" matmuja-enertech/inc/customizer.php
# Expect: no matches

# v3 names present:
grep -oE "mm_phase_[a-z0-9_]+|mm_ftth_heading|mm_proof_km" matmuja-enertech/inc/customizer.php | sort -u
# Expect: 21 unique IDs (mm_phase_{1..5}_title|desc|cta_text|cta_url = 20, plus mm_ftth_heading and mm_proof_km)
```

- [ ] **Step 7: Commit**

```bash
git add matmuja-enertech/inc/customizer.php
git commit -m "feat(theme): customizer — swap v2 services/process for FTTH phases

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 8: Cross-file consistency check

This is a verification-only task (no edits unless drift is found).

- [ ] **Step 1: Confirm every mm_* ID used in front-page.php is registered in customizer.php**

```bash
grep -oE "mm_[a-z_0-9]+" matmuja-enertech/front-page.php | sort -u > /tmp/v3_fp_ids
grep -oE "mm_[a-z_0-9]+" matmuja-enertech/inc/customizer.php | sort -u > /tmp/v3_cust_ids
echo "=== IDs in front-page but NOT in customizer (should be empty) ==="
comm -23 /tmp/v3_fp_ids /tmp/v3_cust_ids
echo "=== IDs in customizer but NOT in front-page (these are section IDs + extras — review) ==="
comm -13 /tmp/v3_fp_ids /tmp/v3_cust_ids
```

If the first comm output is non-empty, the implementation has missing customizer registrations — fix by adding them in customizer.php before proceeding. The second output is informational; expected entries are `mm_v2` (legacy panel ID, OK), `mm_ftth`, `mm_hero`, `mm_mission`, `mm_proof`, `mm_faq`, `mm_cta` (section IDs).

**Note:** the panel ID was named `mm_v2` in Task 11 of the v2 plan and was carried over. For v3 it's a stale name but cosmetic — leave it for backward compatibility with any saved customizer state. If you want a cleaner label, change `'title' => __( 'M&M EnerTech (v2.0)', 'matmuja-tiefbau' )` to `'M&M EnerTech (v3.0)'` in customizer.php. **Default: update the label only, not the panel ID.**

- [ ] **Step 2: Update the panel title to v3.0**

Find in `matmuja-enertech/inc/customizer.php`:
```php
        'title'    => __( 'M&M EnerTech (v2.0)', 'matmuja-tiefbau' ),
```
Replace with:
```php
        'title'    => __( 'M&M EnerTech (v3.0)', 'matmuja-tiefbau' ),
```

- [ ] **Step 3: Confirm no remaining v2-energy-tech copy strings linger**

```bash
grep -inE "energietechnik|photovoltaik|wärmepumpe|smart grid|nachhaltige quartiere" matmuja-enertech/front-page.php matmuja-enertech/inc/customizer.php
# Expect: no matches (or only matches inside the legacy matmuja_customize_register block — which is in functions.php, not these files)
```

If any match comes from `front-page.php` or `inc/customizer.php`, that's leftover v2 copy that needs updating — fix and re-run.

- [ ] **Step 4: Confirm SVG service images are present**

```bash
ls matmuja-enertech/assets/images/s{1,2,3,4,5}_*.svg
# Expect: all 5 SVG files listed
```

- [ ] **Step 5: Commit (panel title only)**

```bash
git add matmuja-enertech/inc/customizer.php
git commit -m "chore(theme): customizer panel title v2.0 → v3.0

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 9: README update

**Files:**
- Modify: `matmuja-enertech/README.md`

- [ ] **Step 1: Replace README.md content**

Write to `matmuja-enertech/README.md`:

```markdown
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
```

- [ ] **Step 2: Commit**

```bash
git add matmuja-enertech/README.md
git commit -m "docs(theme): update README for v3.0 FTTH redesign

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 10: Build assets + zip + Playground verification

**Files:**
- Generate: `matmuja-enertech/style.min.css`, `matmuja-enertech/assets/js/main.min.js`, `/tmp/matmuja-enertech-v3.zip` (none committed — all gitignored / temp)

- [ ] **Step 1: Build minified assets**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
npm run build 2>&1 | tail -5
ls -la matmuja-enertech/style.min.css matmuja-enertech/assets/js/main.min.js
file matmuja-enertech/style.min.css
```

Expect: build succeeds, `style.min.css` exists (~20–35 KB), `main.min.js` exists.

- [ ] **Step 2: Build the upload zip (Python — `zip` CLI not installed)**

```bash
python3 -c "
import zipfile, os
out = '/tmp/matmuja-enertech-v3.zip'
if os.path.exists(out): os.remove(out)
with zipfile.ZipFile(out, 'w', zipfile.ZIP_DEFLATED) as z:
    for root, _, files in os.walk('matmuja-enertech'):
        for f in files:
            if f.endswith('.DS_Store') or f.endswith('.min.css.map'): continue
            p = os.path.join(root, f)
            z.write(p, p)
print('OK', os.path.getsize(out), 'bytes')
"
ls -la /tmp/matmuja-enertech-v3.zip
python3 -c "import zipfile; z=zipfile.ZipFile('/tmp/matmuja-enertech-v3.zip'); print('files:', len(z.namelist())); print('\n'.join(sorted(z.namelist())[:15]))"
```

Expect: zip exists at ~150–200 KB, 30+ files including all 5 SVG service images, all 7 woff2 fonts, customizer.php.

- [ ] **Step 3: Visual verification in WordPress Playground**

Open https://playground.wordpress.net in a browser. In the Playground UI:
1. Sidebar → Site → Themes → Upload Theme → select `/tmp/matmuja-enertech-v3.zip`
2. Activate "M&M EnerTech" v3.0.0 (it will appear alongside any other M&M EnerTech versions you've previously uploaded)
3. Settings → Reading → Front page displays → "A static page" → create a new "Home" page, set as front page
4. View the site

**Verify against the spec § 5 + 6:**

- [ ] **Hero:** indigo background, lime eyebrow `M&M ENERTECH · GLASFASER`, headline `Vom Spaten bis zur Buchse.` in Space Grotesk, lime "FTTH anfragen" button (with glow), ghost "5 Phasen ansehen" button, network-node SVG (5 dots + lines + pulse rings) on the right, all in lime
- [ ] **Mission strip:** lime band, indigo Space Grotesk text reading `Glasfaser komplett aus einer Hand — wir übernehmen jede Phase vom ersten Spatenstich bis zur aktiven Buchse.`
- [ ] **FTTH timeline:** cream background, header `Unser Glasfaser-Prozess / In 5 Phasen zum Hausanschluss`, 5 phase rows alternating SVG left/right (phase 1 right, phase 2 left, phase 3 right, phase 4 left, phase 5 right). Each row has lime left border. SVGs render inside dark indigo rounded squares, tinted lime by CSS filter. Phase 5 ("Hausanschluss / FTTH") has the `Ziellinie` label and a visible glow on its SVG card.
- [ ] **Proof:** indigo background, 4 lime stat tiles (`12+ Jahre Tiefbau`, `1200 km Faser verlegt`, `150 Projekte`, `DIN zertifiziert`), placeholder client logos below
- [ ] **FAQ:** cream, plus icon in lime-dark rotates on open
- [ ] **CTA strip:** indigo, headline `Bereit für Ihr Glasfaserprojekt?`, single lime button `Kostenlose Erstberatung` with glow
- [ ] **Footer:** deepest indigo, single row (brand + contact left, social + legal right)

**If the SVG tint looks wrong** (phase visual squares show grey/dark or no image at all): the `filter: brightness(0) invert(1) sepia(1) hue-rotate(40deg) saturate(8)` trick failed because the v1 SVGs aren't monochrome. Two fallback options:

A. **Inline the SVGs** — change `<img src=".../sN_*.svg">` in `front-page.php` to `<?php include get_template_directory() . '/assets/images/sN_*.svg'; ?>`, then in each SVG file replace `fill="..."` attributes with `fill="currentColor"`.

B. **Just keep them as-is** — remove the `filter:` line from `.ftth-phase__visual img` in style.css; the SVGs render in their original colors against the indigo background.

Pick A for brand consistency, B if A's SVG editing is too much work for now.

- [ ] **Step 4: Lighthouse spot check**

In Chrome DevTools (Playground site URL), run Lighthouse → Mobile → Performance + Accessibility.
- Performance ≥ 80 (Playground is slow — real prod ≥ 90 is the spec's bar)
- Accessibility ≥ 95

- [ ] **Step 5: Final state check + STOP for human review**

```bash
git log --oneline redesign/v3.0-spec..HEAD
# Expect: 7-9 commits (Tasks 2-9, possibly 8 if Task 8 step 5 commits separately)
git status
# Expect: clean (style.min.css and main.min.js are gitignored)
git diff redesign/v2.0-impl..HEAD --stat
# Expect: 4-5 files modified (style.css, theme.json, front-page.php, inc/customizer.php, README.md)
```

Do **not** push to remote, do **not** SFTP to the live server. The implementation branch lives locally. Human reviews the Playground render and the diff, then decides on the deploy strategy (upload zip via WP admin to a new dir `matmuja-enertech-v3/`, activate via WP UI — keeps v2 dir as fallback).
