# M&M EnerTech Theme v2.0 — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ship `matmuja-enertech` theme v2.0.0 implementing the approved hybrid-palette redesign in `docs/superpowers/specs/2026-05-18-matmuja-enertech-redesign-design.md`.

**Architecture:** Classic WordPress theme (not block theme). Single `style.css` driven by CSS variables. New `front-page.php` with 8 sections. All editable copy moves to Customizer. Inter + Space Grotesk self-hosted under `assets/fonts/`. Version bumped 1.2.0 → 2.0.0.

**Tech Stack:** PHP 8.0+, WordPress 6.0+, CSS3, vanilla JS, PostCSS for minification (`npm run build` already wired). Testing via [WordPress Playground](https://playground.wordpress.net) — no local install required.

**Working branch:** `redesign/v2.0-impl`, branched off `redesign/v2.0-spec` (which contains the design spec).

**Out of scope per spec §7:** News/blog templates, redesign of inner-page HTML (they pick up the palette via CSS variables only).

---

## Verification model

This is a frontend theme, not application code with unit tests. Each task ends in **two verification gates**:

1. **PHP syntax**: `php -l <file>` returns "No syntax errors detected"
2. **Visual check**: zip the theme, upload to WordPress Playground, confirm rendering matches the spec for that task's section(s)

A helper script for step 2:
```bash
# from repo root
(cd matmuja-enertech && zip -rq /tmp/matmuja-enertech.zip . -x "*.DS_Store") && echo "Upload /tmp/matmuja-enertech.zip in Playground (Site → Theme → Upload)"
```

---

## File inventory

| File | Action | Responsibility |
|---|---|---|
| `matmuja-enertech/theme.json` | Rewrite | WP palette + font-family presets |
| `matmuja-enertech/assets/fonts/` | Create | Self-hosted woff2 files for Inter + Space Grotesk |
| `matmuja-enertech/assets/css/fonts.css` | Create | `@font-face` declarations |
| `matmuja-enertech/functions.php` | Rewrite enqueue block + add customizer | Theme setup + asset loading + customizer fields |
| `matmuja-enertech/inc/customizer.php` | Create | Customizer field registration (split out for size) |
| `matmuja-enertech/style.css` | Full rewrite | Variables, reset, typography, layout, components |
| `matmuja-enertech/header.php` | Rewrite | Body class drives light/dark header |
| `matmuja-enertech/footer.php` | Rewrite | Slim single-row |
| `matmuja-enertech/front-page.php` | Full rewrite | 8 sections per spec §5 |
| `matmuja-enertech/inc/template-tags.php` | Light edits | Helpers for rendering hero SVG, FAQ list, etc. |
| `matmuja-enertech/README.md` | Update | New palette/section docs, customizer reference |
| `matmuja-enertech/style.min.css` | Regenerate via `npm run build` | Minified output (gitignored — already covered) |

---

## Task 1: Branch setup + repo hygiene

**Files:**
- Modify: working branch only (no file content changes)

- [ ] **Step 1: Branch off the spec branch**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git checkout redesign/v2.0-spec
git checkout -b redesign/v2.0-impl
git status   # expect: clean, on redesign/v2.0-impl
```

- [ ] **Step 2: Delete the .drift/ folder used for the drift check**

```bash
rm -rf .drift
echo ".drift/" >> .gitignore   # only if not already present
git add .gitignore
git diff --cached
```

- [ ] **Step 3: Commit**

```bash
git commit -m "chore: ignore .drift/ used for live-vs-repo comparison

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 2: theme.json — palette + typography presets

**Files:**
- Rewrite: `matmuja-enertech/theme.json`

- [ ] **Step 1: Replace theme.json with the new content**

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 2,
  "settings": {
    "color": {
      "palette": [
        { "slug": "brand-gold",       "color": "#c9a84c", "name": "Brand Gold" },
        { "slug": "brand-gold-light", "color": "#e8d5a3", "name": "Brand Gold Light" },
        { "slug": "brand-navy",       "color": "#0f1a2e", "name": "Brand Navy" },
        { "slug": "brand-navy-deep",  "color": "#0b1424", "name": "Brand Navy Deep" },
        { "slug": "surface",          "color": "#ffffff", "name": "Surface" },
        { "slug": "surface-warm",     "color": "#f6f5f0", "name": "Surface Warm" },
        { "slug": "text",             "color": "#0f1a2e", "name": "Text" },
        { "slug": "text-muted",       "color": "#5b6473", "name": "Text Muted" }
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
    "color":      { "background": "#ffffff", "text": "#0f1a2e" },
    "typography": { "fontFamily": "var(--wp--preset--font-family--body)", "lineHeight": "1.6" }
  }
}
```

- [ ] **Step 2: Validate JSON**

```bash
python3 -m json.tool matmuja-enertech/theme.json > /dev/null && echo "JSON OK"
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/theme.json
git commit -m "feat(theme): theme.json palette + Inter/Space Grotesk presets

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 3: Self-host Inter + Space Grotesk

**Files:**
- Create: `matmuja-enertech/assets/fonts/` directory
- Create: `matmuja-enertech/assets/fonts/inter-{400,500,600,700}.woff2`
- Create: `matmuja-enertech/assets/fonts/space-grotesk-{500,600,700}.woff2`
- Create: `matmuja-enertech/assets/css/fonts.css`

- [ ] **Step 1: Create directory and download woff2 files**

```bash
mkdir -p matmuja-enertech/assets/fonts matmuja-enertech/assets/css

# Inter (subset: 400, 500, 600, 700) — latin only for German
for w in 400 500 600 700; do
  curl -fsSL -o matmuja-enertech/assets/fonts/inter-$w.woff2 \
    "https://cdn.jsdelivr.net/fontsource/fonts/inter@latest/latin-$w-normal.woff2"
done

# Space Grotesk (500, 600, 700)
for w in 500 600 700; do
  curl -fsSL -o matmuja-enertech/assets/fonts/space-grotesk-$w.woff2 \
    "https://cdn.jsdelivr.net/fontsource/fonts/space-grotesk@latest/latin-$w-normal.woff2"
done

ls -la matmuja-enertech/assets/fonts/
# Expect: 7 woff2 files, each 10–40 KB
```

- [ ] **Step 2: Create fonts.css with @font-face declarations**

Write to `matmuja-enertech/assets/css/fonts.css`:
```css
/* Inter */
@font-face { font-family: 'Inter'; src: url('../fonts/inter-400.woff2') format('woff2'); font-weight: 400; font-style: normal; font-display: swap; }
@font-face { font-family: 'Inter'; src: url('../fonts/inter-500.woff2') format('woff2'); font-weight: 500; font-style: normal; font-display: swap; }
@font-face { font-family: 'Inter'; src: url('../fonts/inter-600.woff2') format('woff2'); font-weight: 600; font-style: normal; font-display: swap; }
@font-face { font-family: 'Inter'; src: url('../fonts/inter-700.woff2') format('woff2'); font-weight: 700; font-style: normal; font-display: swap; }

/* Space Grotesk */
@font-face { font-family: 'Space Grotesk'; src: url('../fonts/space-grotesk-500.woff2') format('woff2'); font-weight: 500; font-style: normal; font-display: swap; }
@font-face { font-family: 'Space Grotesk'; src: url('../fonts/space-grotesk-600.woff2') format('woff2'); font-weight: 600; font-style: normal; font-display: swap; }
@font-face { font-family: 'Space Grotesk'; src: url('../fonts/space-grotesk-700.woff2') format('woff2'); font-weight: 700; font-style: normal; font-display: swap; }
```

- [ ] **Step 3: Verify woff2 files are valid (not HTML error pages)**

```bash
file matmuja-enertech/assets/fonts/inter-400.woff2
# Expect: "Web Open Font Format (Version 2), TrueType ..."
```

If any file shows as HTML, the CDN URL was wrong — use Google Fonts API as fallback: `curl -fsSL "https://fonts.gstatic.com/s/inter/v..." ` (look up exact URL from `fonts.googleapis.com/css2?family=Inter:wght@400` response).

- [ ] **Step 4: Commit**

```bash
git add matmuja-enertech/assets/fonts/ matmuja-enertech/assets/css/fonts.css
git commit -m "feat(theme): self-host Inter + Space Grotesk (GDPR)

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 4: functions.php — enqueue rewrite + version bump

**Files:**
- Modify: `matmuja-enertech/functions.php` (enqueue block and version-related code)

- [ ] **Step 1: Replace the Google Fonts enqueue with self-hosted fonts.css**

In `matmuja-enertech/functions.php`, replace the `matmuja_scripts()` function body's stylesheet loading with:

```php
function matmuja_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );

    wp_enqueue_style(
        'matmuja-fonts',
        get_template_directory_uri() . '/assets/css/fonts.css',
        [],
        $theme_version
    );

    wp_enqueue_style(
        'matmuja-style',
        get_stylesheet_uri(),
        [ 'matmuja-fonts' ],
        $theme_version
    );

    $script_path = file_exists( get_template_directory() . '/assets/js/main.min.js' )
        ? '/assets/js/main.min.js'
        : '/assets/js/main.js';

    wp_enqueue_script( 'matmuja-script', get_template_directory_uri() . $script_path, [], $theme_version, true );

    wp_localize_script( 'matmuja-script', 'matmujaData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'matmuja-nonce' ),
    ] );

    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'matmuja_scripts' );
```

Delete any existing `wp_enqueue_style( 'matmuja-google-fonts', ... )` line and the `add_action( 'wp_enqueue_scripts', 'matmuja_scripts' )` duplicate if present.

- [ ] **Step 2: Add the customizer include**

At the bottom of `functions.php`, add (if not already present):
```php
require_once get_template_directory() . '/inc/customizer.php';
```

- [ ] **Step 3: PHP lint**

```bash
php -l matmuja-enertech/functions.php
# Expect: "No syntax errors detected"
```

- [ ] **Step 4: Commit**

```bash
git add matmuja-enertech/functions.php
git commit -m "feat(theme): enqueue self-hosted fonts, prep customizer include

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 5: style.css base — variables, reset, typography, layout

**Files:**
- Rewrite: `matmuja-enertech/style.css` (sections 1-4 only — components in Task 6)

- [ ] **Step 1: Write the new style.css skeleton with variables, reset, typography, layout**

Open `matmuja-enertech/style.css` and replace its entire contents with:

```css
/*
Theme Name: M&M EnerTech
Theme URI: https://www.matmuja.de/
Author: M&M EnerTech UG
Description: Professional WordPress theme for M&M EnerTech — hybrid palette redesign with refined-futuristic accents.
Version: 2.0.0
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: matmuja-tiefbau
Tags: business, energy, custom-colors, custom-menu, responsive-layout, custom-logo, editor-styles, featured-images, threaded-comments, translation-ready
*/

/* === 1. VARIABLES === */
:root {
  /* Brand */
  --color-brand-gold:        #c9a84c;
  --color-brand-gold-light:  #e8d5a3;
  --color-brand-navy:        #0f1a2e;
  --color-brand-navy-deep:   #0b1424;
  --color-brand-navy-tint:   #1a2949;

  /* Surfaces */
  --color-surface:           #ffffff;
  --color-surface-warm:      #f6f5f0;
  --color-surface-band:      #c9a84c;

  /* Text */
  --color-text:              #0f1a2e;
  --color-text-muted:        #5b6473;
  --color-text-on-dark:      #ffffff;
  --color-text-on-dark-muted: rgba(255, 255, 255, 0.7);

  /* Borders */
  --color-border:            #eaeaea;
  --color-border-on-dark:    rgba(255, 255, 255, 0.12);

  /* Effects (accent-only) */
  --glow-gold:               0 0 16px rgba(201, 168, 76, 0.4);
  --glow-gold-strong:        0 0 24px rgba(201, 168, 76, 0.6);
  --shadow-card:             0 2px 12px rgba(15, 26, 46, 0.06);
  --shadow-card-hover:       0 6px 24px rgba(15, 26, 46, 0.10);

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

/* === 2. RESET === */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; font-size: 16px; -webkit-text-size-adjust: 100%; }
body {
  font-family: var(--font-body);
  color: var(--color-text);
  background: var(--color-surface);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
img, svg { max-width: 100%; height: auto; display: block; }
a { color: inherit; text-decoration: none; transition: color var(--transition); }
a:hover { color: var(--color-brand-gold); }
ul, ol { list-style: none; }
button { cursor: pointer; border: none; background: none; font-family: inherit; }

/* === 3. TYPOGRAPHY === */
h1, h2, h3, h4 {
  font-family: var(--font-display);
  font-weight: 600;
  line-height: 1.1;
  letter-spacing: -0.02em;
  color: inherit;
}
h1 { font-size: var(--text-3xl); }
h2 { font-size: var(--text-2xl); }
h3 { font-size: var(--text-xl); }
h4 { font-size: var(--text-lg); }
@media (min-width: 768px) {
  h1 { font-size: var(--text-4xl); }
  h2 { font-size: var(--text-3xl); }
}
p { margin-bottom: 1em; }
p:last-child { margin-bottom: 0; }

.eyebrow {
  font-family: var(--font-body);
  font-size: 0.6875rem;
  font-weight: 600;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--color-text-muted);
}
.eyebrow--on-dark { color: var(--color-brand-gold); }

/* === 4. LAYOUT === */
.container { max-width: var(--container); margin: 0 auto; padding: 0 1.5rem; }
.section { padding: 5rem 0; }
@media (max-width: 767px) { .section { padding: 3rem 0; } }

.section--dark      { background: var(--color-brand-navy);      color: var(--color-text-on-dark); }
.section--dark-deep { background: var(--color-brand-navy-deep); color: var(--color-text-on-dark); }
.section--warm      { background: var(--color-surface-warm); }
.section--band      { background: var(--color-brand-gold); color: var(--color-brand-navy); padding: 2rem 0; }

/* Sections 5 (components) will be appended in Task 6 */
```

- [ ] **Step 2: Visual sanity check the variables file is valid CSS**

```bash
# Bare-minimum lint: no stray braces
node -e "const fs=require('fs'); const c=fs.readFileSync('matmuja-enertech/style.css','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);"
# Expect: open and close equal
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/style.css
git commit -m "feat(theme): rewrite style.css base — variables, reset, typography, layout

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 6: style.css components — buttons, cards, FAQ accordion, hero, footer

**Files:**
- Modify: `matmuja-enertech/style.css` (append components section)

- [ ] **Step 1: Append the components section**

Append the following to `matmuja-enertech/style.css`:

```css
/* === 5. COMPONENTS === */

/* --- Buttons --- */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.875rem 1.5rem;
  border-radius: var(--radius);
  font-family: var(--font-body);
  font-weight: 600;
  font-size: var(--text-sm);
  transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
}
.btn--primary {
  background: var(--color-brand-gold);
  color: var(--color-brand-navy);
  box-shadow: var(--glow-gold);
}
.btn--primary:hover { transform: translateY(-1px); box-shadow: var(--glow-gold-strong); color: var(--color-brand-navy); }
.btn--ghost {
  background: transparent;
  color: var(--color-text-on-dark);
  border: 1px solid var(--color-border-on-dark);
}
.btn--ghost:hover { background: rgba(255, 255, 255, 0.06); color: var(--color-text-on-dark); }

/* --- Service card --- */
.service-card {
  background: var(--color-surface);
  border: 1px solid var(--color-border);
  border-radius: var(--radius);
  padding: 1.5rem;
  transition: border-color var(--transition), box-shadow var(--transition), transform var(--transition);
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
  margin-bottom: 1rem;
  display: flex; align-items: center; justify-content: center;
  color: var(--color-brand-navy);
}
.service-card__title { font-size: var(--text-lg); margin-bottom: 0.5rem; }
.service-card__desc  { color: var(--color-text-muted); font-size: var(--text-sm); }

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 1.5rem;
  margin-top: 2.5rem;
}

/* --- Process steps --- */
.process-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1.5rem;
  margin-top: 2.5rem;
}
.process-step__num {
  font-family: var(--font-display);
  font-size: var(--text-3xl);
  font-weight: 700;
  color: var(--color-brand-gold);
  line-height: 1;
  margin-bottom: 0.5rem;
}
.process-step__title { font-size: var(--text-lg); margin-bottom: 0.25rem; }
.process-step__desc  { color: var(--color-text-on-dark-muted); font-size: var(--text-sm); }

/* --- Proof stats + logos --- */
.proof-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
  text-align: center;
}
.proof-stat__value {
  font-family: var(--font-display);
  font-size: var(--text-3xl);
  font-weight: 700;
  color: var(--color-brand-navy);
}
.proof-stat__label {
  font-size: var(--text-xs);
  color: var(--color-text-muted);
  letter-spacing: 0.15em;
  text-transform: uppercase;
}
.proof-logos {
  display: flex; flex-wrap: wrap; justify-content: center; align-items: center;
  gap: 2rem;
  opacity: 0.55;
  filter: grayscale(100%);
}
.proof-logos img { max-height: 40px; width: auto; }

/* --- FAQ (native details) --- */
.faq-list { max-width: 800px; margin: 2.5rem auto 0; }
.faq-item { border-top: 1px solid var(--color-border); }
.faq-item:last-child { border-bottom: 1px solid var(--color-border); }
.faq-item summary {
  list-style: none;
  cursor: pointer;
  padding: 1.25rem 0;
  display: flex; justify-content: space-between; align-items: center;
  font-family: var(--font-display);
  font-weight: 600;
  font-size: var(--text-lg);
}
.faq-item summary::-webkit-details-marker { display: none; }
.faq-item summary::after {
  content: '+';
  font-family: var(--font-display);
  font-size: 1.5rem;
  color: var(--color-brand-gold);
  transition: transform var(--transition);
}
.faq-item[open] summary::after { transform: rotate(45deg); }
.faq-item__answer { padding: 0 0 1.25rem; color: var(--color-text-muted); }

/* --- Hero (split) --- */
.hero { padding: 5rem 0; overflow: hidden; }
.hero__grid {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 3rem;
  align-items: center;
}
.hero__headline {
  font-size: var(--text-3xl);
  margin: 1rem 0 1.25rem;
}
@media (min-width: 768px) { .hero__headline { font-size: var(--text-4xl); } }
.hero__sub { color: var(--color-text-on-dark-muted); font-size: var(--text-lg); margin-bottom: 2rem; max-width: 32rem; }
.hero__ctas { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.hero__visual {
  position: relative;
  aspect-ratio: 1 / 1;
  background:
    radial-gradient(circle at 30% 50%, rgba(201, 168, 76, 0.35) 0%, transparent 60%),
    linear-gradient(135deg, var(--color-brand-navy-tint) 0%, var(--color-brand-navy) 100%);
  border-radius: var(--radius-lg);
  overflow: hidden;
}
@media (max-width: 767px) {
  .hero__grid { grid-template-columns: 1fr; }
  .hero__visual { aspect-ratio: 16 / 9; }
}

/* --- Mission strip --- */
.mission-strip {
  text-align: center;
  font-family: var(--font-display);
  font-size: var(--text-xl);
  font-weight: 500;
  line-height: 1.4;
  max-width: 60ch;
  margin: 0 auto;
}

/* --- CTA strip --- */
.cta-strip { text-align: center; }
.cta-strip h2 { margin-bottom: 1.5rem; }

/* --- Site header --- */
.site-header {
  padding: 1.25rem 0;
  background: var(--color-surface);
  border-bottom: 1px solid var(--color-border);
}
body.home .site-header,
body.front-page .site-header {
  background: var(--color-brand-navy);
  color: var(--color-text-on-dark);
  border-bottom-color: var(--color-border-on-dark);
}
.site-header__inner {
  display: flex; justify-content: space-between; align-items: center;
  gap: 2rem;
}
.site-header__brand { font-family: var(--font-display); font-weight: 700; }
.site-nav { display: flex; gap: 1.5rem; font-size: var(--text-sm); }

/* --- Site footer --- */
.site-footer {
  padding: 2rem 0;
  background: var(--color-brand-navy-deep);
  color: var(--color-text-on-dark-muted);
  font-size: var(--text-sm);
}
.site-footer__inner {
  display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;
  gap: 1rem;
}
.site-footer a { color: var(--color-text-on-dark-muted); }
.site-footer a:hover { color: var(--color-brand-gold); }
```

- [ ] **Step 2: Brace balance check**

```bash
node -e "const fs=require('fs'); const c=fs.readFileSync('matmuja-enertech/style.css','utf8'); const o=(c.match(/{/g)||[]).length; const cl=(c.match(/}/g)||[]).length; console.log('open:',o,'close:',cl); process.exit(o===cl?0:1);"
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/style.css
git commit -m "feat(theme): style.css components — buttons, cards, hero, FAQ, header, footer

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 7: header.php — light/dark via body class

**Files:**
- Rewrite: `matmuja-enertech/header.php`

- [ ] **Step 1: Replace header.php**

```php
<?php
/**
 * Theme header
 *
 * @package matmuja-tiefbau
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container site-header__inner">
        <a class="site-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                bloginfo( 'name' );
            } ?>
        </a>
        <nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'matmuja-tiefbau' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-nav__list',
                'fallback_cb'    => '__return_empty_string',
                'depth'          => 1,
            ] );
            ?>
        </nav>
    </div>
</header>

<main class="site-main">
```

- [ ] **Step 2: PHP lint**

```bash
php -l matmuja-enertech/header.php
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/header.php
git commit -m "feat(theme): slim header.php with body-class-driven light/dark

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 8: footer.php — slim single-row

**Files:**
- Rewrite: `matmuja-enertech/footer.php`

- [ ] **Step 1: Replace footer.php**

```php
<?php
/**
 * Theme footer
 *
 * @package matmuja-tiefbau
 */
?>
</main><!-- .site-main -->

<footer class="site-footer">
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
        </div>
        <nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'matmuja-tiefbau' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'site-footer__legal-list',
                'fallback_cb'    => '__return_empty_string',
                'depth'          => 1,
            ] );
            ?>
        </nav>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
```

- [ ] **Step 2: PHP lint**

```bash
php -l matmuja-enertech/footer.php
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/footer.php
git commit -m "feat(theme): slim footer.php — single-row contact/legal

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 9: front-page.php — hero + mission strip + services (sections 1-3)

**Files:**
- Rewrite: `matmuja-enertech/front-page.php`

- [ ] **Step 1: Create the new front-page.php with sections 1-3 only**

```php
<?php
/**
 * Front page template — v2.0
 *
 * @package matmuja-tiefbau
 */

get_header();

$mm = function ( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
};
?>

<!-- 1. HERO -->
<section class="hero section--dark">
    <div class="container">
        <div class="hero__grid">
            <div class="hero__content">
                <p class="eyebrow eyebrow--on-dark"><?php bloginfo( 'name' ); ?></p>
                <h1 class="hero__headline">
                    <?php echo esc_html( $mm( 'mm_hero_headline', __( 'Energietechnik, neu gedacht.', 'matmuja-tiefbau' ) ) ); ?>
                </h1>
                <p class="hero__sub">
                    <?php echo esc_html( $mm( 'mm_hero_sub', __( 'Smarte Lösungen für Industrie, Gewerbe und nachhaltige Quartiere.', 'matmuja-tiefbau' ) ) ); ?>
                </p>
                <div class="hero__ctas">
                    <a class="btn btn--primary" href="<?php echo esc_url( $mm( 'mm_hero_cta_primary_url', '#kontakt' ) ); ?>">
                        <?php echo esc_html( $mm( 'mm_hero_cta_primary', __( 'Beratung anfragen', 'matmuja-tiefbau' ) ) ); ?>
                    </a>
                    <a class="btn btn--ghost" href="<?php echo esc_url( $mm( 'mm_hero_cta_secondary_url', '#leistungen' ) ); ?>">
                        <?php echo esc_html( $mm( 'mm_hero_cta_secondary', __( 'Leistungen', 'matmuja-tiefbau' ) ) ); ?>
                    </a>
                </div>
            </div>
            <div class="hero__visual" aria-hidden="true">
                <svg viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice" style="position:absolute;inset:0;width:100%;height:100%;opacity:0.5">
                    <defs>
                        <pattern id="hero-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="#c9a84c" stroke-width="0.2"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#hero-grid)"/>
                    <circle cx="50" cy="50" r="20" fill="none" stroke="#c9a84c" stroke-width="0.4"/>
                    <circle cx="50" cy="50" r="32" fill="none" stroke="#c9a84c" stroke-width="0.2"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- 2. MISSION STRIP -->
<section class="section--band">
    <div class="container">
        <p class="mission-strip">
            <?php echo esc_html( $mm( 'mm_mission_text', __( 'Wir bringen smarte Energietechnik dorthin, wo sie wirklich Wirkung entfaltet.', 'matmuja-tiefbau' ) ) ); ?>
        </p>
    </div>
</section>

<!-- 3. SERVICES -->
<section id="leistungen" class="section">
    <div class="container">
        <p class="eyebrow"><?php esc_html_e( 'Was wir tun', 'matmuja-tiefbau' ); ?></p>
        <h2><?php echo esc_html( $mm( 'mm_services_heading', __( 'Unsere Leistungen', 'matmuja-tiefbau' ) ) ); ?></h2>
        <div class="services-grid">
            <?php for ( $i = 1; $i <= 3; $i++ ) :
                $title = $mm( "mm_service_{$i}_title", '' );
                $desc  = $mm( "mm_service_{$i}_desc", '' );
                if ( ! $title ) {
                    $defaults = [
                        1 => [ __( 'Photovoltaik', 'matmuja-tiefbau' ), __( 'Planung und Installation für Industrie und Gewerbe.', 'matmuja-tiefbau' ) ],
                        2 => [ __( 'Wärmepumpen', 'matmuja-tiefbau' ), __( 'Effiziente Heizungssysteme der nächsten Generation.', 'matmuja-tiefbau' ) ],
                        3 => [ __( 'Speicher & Smart Grid', 'matmuja-tiefbau' ), __( 'Intelligente Energiespeicher und Netzintegration.', 'matmuja-tiefbau' ) ],
                    ];
                    $title = $defaults[ $i ][0];
                    $desc  = $defaults[ $i ][1];
                }
                ?>
                <div class="service-card">
                    <div class="service-card__icon" aria-hidden="true"></div>
                    <h3 class="service-card__title"><?php echo esc_html( $title ); ?></h3>
                    <p class="service-card__desc"><?php echo esc_html( $desc ); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
```

- [ ] **Step 2: PHP lint**

```bash
php -l matmuja-enertech/front-page.php
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/front-page.php
git commit -m "feat(theme): front-page sections 1-3 (hero, mission, services)

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 10: front-page.php — how-we-work + proof + FAQ + CTA (sections 4-7)

**Files:**
- Modify: `matmuja-enertech/front-page.php` (append before `get_footer()`)

- [ ] **Step 1: Append sections 4-7 to front-page.php, then add `get_footer();`**

Append to `matmuja-enertech/front-page.php`:

```php

<!-- 4. HOW WE WORK -->
<section class="section section--dark">
    <div class="container">
        <p class="eyebrow eyebrow--on-dark"><?php esc_html_e( 'Unser Vorgehen', 'matmuja-tiefbau' ); ?></p>
        <h2><?php echo esc_html( $mm( 'mm_process_heading', __( 'So arbeiten wir', 'matmuja-tiefbau' ) ) ); ?></h2>
        <div class="process-grid">
            <?php
            $process_defaults = [
                1 => [ __( 'Analyse', 'matmuja-tiefbau' ), __( 'Bestandsaufnahme und Bedarfsklärung vor Ort.', 'matmuja-tiefbau' ) ],
                2 => [ __( 'Konzept', 'matmuja-tiefbau' ), __( 'Maßgeschneidertes Konzept inkl. Wirtschaftlichkeit.', 'matmuja-tiefbau' ) ],
                3 => [ __( 'Umsetzung', 'matmuja-tiefbau' ), __( 'Realisierung durch zertifizierte Fachpartner.', 'matmuja-tiefbau' ) ],
                4 => [ __( 'Service', 'matmuja-tiefbau' ), __( 'Monitoring, Wartung und kontinuierliche Optimierung.', 'matmuja-tiefbau' ) ],
            ];
            for ( $i = 1; $i <= 4; $i++ ) :
                $title = $mm( "mm_process_step_{$i}_title", $process_defaults[ $i ][0] );
                $desc  = $mm( "mm_process_step_{$i}_desc",  $process_defaults[ $i ][1] );
                ?>
                <div class="process-step">
                    <div class="process-step__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></div>
                    <h3 class="process-step__title"><?php echo esc_html( $title ); ?></h3>
                    <p class="process-step__desc"><?php echo esc_html( $desc ); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- 5. PROOF -->
<section class="section section--warm">
    <div class="container">
        <div class="proof-stats">
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_years', '12' ) ); ?>+</div>
                <div class="proof-stat__label"><?php esc_html_e( 'Jahre', 'matmuja-tiefbau' ); ?></div>
            </div>
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_projects', '150' ) ); ?></div>
                <div class="proof-stat__label"><?php esc_html_e( 'Projekte', 'matmuja-tiefbau' ); ?></div>
            </div>
            <div class="proof-stat">
                <div class="proof-stat__value"><?php echo esc_html( $mm( 'mm_proof_cert', 'DIN' ) ); ?></div>
                <div class="proof-stat__label"><?php esc_html_e( 'zertifiziert', 'matmuja-tiefbau' ); ?></div>
            </div>
        </div>
        <div class="proof-logos" aria-label="<?php esc_attr_e( 'Kunden', 'matmuja-tiefbau' ); ?>">
            <?php
            for ( $i = 1; $i <= 6; $i++ ) {
                $logo = $mm( "mm_client_logo_{$i}", '' );
                if ( $logo ) {
                    printf( '<img src="%s" alt="" loading="lazy">', esc_url( $logo ) );
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- 6. FAQ -->
<section class="section">
    <div class="container">
        <p class="eyebrow"><?php esc_html_e( 'Häufige Fragen', 'matmuja-tiefbau' ); ?></p>
        <h2><?php echo esc_html( $mm( 'mm_faq_heading', __( 'FAQ', 'matmuja-tiefbau' ) ) ); ?></h2>
        <div class="faq-list">
            <?php
            $faq_defaults = [
                [ __( 'Wie läuft eine Erstberatung ab?', 'matmuja-tiefbau' ), __( 'Wir analysieren Ihre Situation vor Ort und entwickeln ein passendes Konzept.', 'matmuja-tiefbau' ) ],
                [ __( 'Welche Förderungen sind möglich?', 'matmuja-tiefbau' ), __( 'Wir prüfen Bundes-, Landes- und KfW-Förderungen für jedes Projekt.', 'matmuja-tiefbau' ) ],
                [ __( 'Wie lange dauert eine typische Umsetzung?', 'matmuja-tiefbau' ), __( 'Je nach Projektgröße zwischen 4 und 16 Wochen ab Auftragserteilung.', 'matmuja-tiefbau' ) ],
            ];
            for ( $i = 1; $i <= 5; $i++ ) :
                $q = $mm( "mm_faq_{$i}_q", $faq_defaults[ $i - 1 ][0] ?? '' );
                $a = $mm( "mm_faq_{$i}_a", $faq_defaults[ $i - 1 ][1] ?? '' );
                if ( ! $q ) { continue; }
                ?>
                <details class="faq-item">
                    <summary><?php echo esc_html( $q ); ?></summary>
                    <div class="faq-item__answer"><?php echo esc_html( $a ); ?></div>
                </details>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- 7. CTA STRIP -->
<section id="kontakt" class="section section--dark">
    <div class="container cta-strip">
        <h2><?php echo esc_html( $mm( 'mm_cta_headline', __( 'Bereit für die Energiezukunft?', 'matmuja-tiefbau' ) ) ); ?></h2>
        <a class="btn btn--primary" href="<?php echo esc_url( $mm( 'mm_cta_button_url', 'mailto:info@matmuja.de' ) ); ?>">
            <?php echo esc_html( $mm( 'mm_cta_button_text', __( 'Beratung anfragen', 'matmuja-tiefbau' ) ) ); ?>
        </a>
    </div>
</section>

<?php get_footer(); ?>
```

- [ ] **Step 2: PHP lint**

```bash
php -l matmuja-enertech/front-page.php
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/front-page.php
git commit -m "feat(theme): front-page sections 4-7 (process, proof, FAQ, CTA)

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 11: Customizer fields — register all 30+ settings in panels

**Files:**
- Create: `matmuja-enertech/inc/customizer.php`

- [ ] **Step 1: Create inc/customizer.php**

```php
<?php
/**
 * Customizer settings for v2.0.
 *
 * @package matmuja-tiefbau
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( WP_Customize_Manager $wp ) {

    $wp->add_panel( 'mm_v2', [
        'title'    => __( 'M&M EnerTech (v2.0)', 'matmuja-tiefbau' ),
        'priority' => 30,
    ] );

    $sections = [
        'mm_hero'     => __( 'Hero', 'matmuja-tiefbau' ),
        'mm_mission'  => __( 'Mission strip', 'matmuja-tiefbau' ),
        'mm_services' => __( 'Leistungen', 'matmuja-tiefbau' ),
        'mm_process'  => __( 'Prozess', 'matmuja-tiefbau' ),
        'mm_proof'    => __( 'Proof', 'matmuja-tiefbau' ),
        'mm_faq'      => __( 'FAQ', 'matmuja-tiefbau' ),
        'mm_cta'      => __( 'CTA', 'matmuja-tiefbau' ),
    ];
    foreach ( $sections as $id => $label ) {
        $wp->add_section( $id, [ 'title' => $label, 'panel' => 'mm_v2' ] );
    }

    $text = function ( $id, $section, $label, $default = '' ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
        $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'text' ] );
    };
    $textarea = function ( $id, $section, $label, $default = '' ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
        $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'textarea' ] );
    };
    $url = function ( $id, $section, $label, $default = '' ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ] );
        $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'url' ] );
    };
    $image = function ( $id, $section, $label ) use ( $wp ) {
        $wp->add_setting( $id, [ 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ] );
        $wp->add_control( new WP_Customize_Image_Control( $wp, $id, [ 'label' => $label, 'section' => $section ] ) );
    };

    // Hero
    $text( 'mm_hero_headline', 'mm_hero', __( 'Headline', 'matmuja-tiefbau' ), 'Energietechnik, neu gedacht.' );
    $textarea( 'mm_hero_sub', 'mm_hero', __( 'Sub-headline', 'matmuja-tiefbau' ), 'Smarte Lösungen für Industrie, Gewerbe und nachhaltige Quartiere.' );
    $text( 'mm_hero_cta_primary',     'mm_hero', __( 'Primary CTA label', 'matmuja-tiefbau' ), 'Beratung anfragen' );
    $url(  'mm_hero_cta_primary_url', 'mm_hero', __( 'Primary CTA URL', 'matmuja-tiefbau' ), '#kontakt' );
    $text( 'mm_hero_cta_secondary',     'mm_hero', __( 'Secondary CTA label', 'matmuja-tiefbau' ), 'Leistungen' );
    $url(  'mm_hero_cta_secondary_url', 'mm_hero', __( 'Secondary CTA URL', 'matmuja-tiefbau' ), '#leistungen' );

    // Mission
    $textarea( 'mm_mission_text', 'mm_mission', __( 'Mission sentence', 'matmuja-tiefbau' ),
        'Wir bringen smarte Energietechnik dorthin, wo sie wirklich Wirkung entfaltet.' );

    // Services (3)
    $text( 'mm_services_heading', 'mm_services', __( 'Section heading', 'matmuja-tiefbau' ), 'Unsere Leistungen' );
    for ( $i = 1; $i <= 3; $i++ ) {
        $text(     "mm_service_{$i}_title", 'mm_services', sprintf( __( 'Service %d title', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_service_{$i}_desc",  'mm_services', sprintf( __( 'Service %d description', 'matmuja-tiefbau' ), $i ) );
    }

    // Process (4)
    $text( 'mm_process_heading', 'mm_process', __( 'Section heading', 'matmuja-tiefbau' ), 'So arbeiten wir' );
    for ( $i = 1; $i <= 4; $i++ ) {
        $text(     "mm_process_step_{$i}_title", 'mm_process', sprintf( __( 'Step %d title', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_process_step_{$i}_desc",  'mm_process', sprintf( __( 'Step %d description', 'matmuja-tiefbau' ), $i ) );
    }

    // Proof
    $text( 'mm_proof_years',    'mm_proof', __( 'Stat: years',    'matmuja-tiefbau' ), '12' );
    $text( 'mm_proof_projects', 'mm_proof', __( 'Stat: projects', 'matmuja-tiefbau' ), '150' );
    $text( 'mm_proof_cert',     'mm_proof', __( 'Stat: cert label', 'matmuja-tiefbau' ), 'DIN' );
    for ( $i = 1; $i <= 6; $i++ ) {
        $image( "mm_client_logo_{$i}", 'mm_proof', sprintf( __( 'Client logo %d', 'matmuja-tiefbau' ), $i ) );
    }

    // FAQ (5)
    $text( 'mm_faq_heading', 'mm_faq', __( 'Section heading', 'matmuja-tiefbau' ), 'FAQ' );
    for ( $i = 1; $i <= 5; $i++ ) {
        $text(     "mm_faq_{$i}_q", 'mm_faq', sprintf( __( 'Q%d', 'matmuja-tiefbau' ), $i ) );
        $textarea( "mm_faq_{$i}_a", 'mm_faq', sprintf( __( 'A%d', 'matmuja-tiefbau' ), $i ) );
    }

    // CTA
    $text( 'mm_cta_headline',    'mm_cta', __( 'Headline', 'matmuja-tiefbau' ), 'Bereit für die Energiezukunft?' );
    $text( 'mm_cta_button_text', 'mm_cta', __( 'Button text', 'matmuja-tiefbau' ), 'Beratung anfragen' );
    $url(  'mm_cta_button_url',  'mm_cta', __( 'Button URL', 'matmuja-tiefbau' ), 'mailto:info@matmuja.de' );
} );
```

- [ ] **Step 2: PHP lint**

```bash
php -l matmuja-enertech/inc/customizer.php
```

- [ ] **Step 3: Commit**

```bash
git add matmuja-enertech/inc/customizer.php
git commit -m "feat(theme): customizer fields grouped under M&M EnerTech (v2.0) panel

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

---

## Task 12: Build assets + visual verification in WordPress Playground

**Files:**
- Generate: `matmuja-enertech/style.min.css` (build artifact)

- [ ] **Step 1: Install npm deps if missing, build minified CSS**

```bash
[ -d node_modules ] || npm install
npm run build
ls -la matmuja-enertech/style.min.css
# Expect: file exists, size between 20–60 KB
```

If `npm run build-css` fails because `style.css` overwrites itself (the package.json `watch-css` script does that), check the postcss command and adjust to use a different output path if needed.

- [ ] **Step 2: Zip the theme for Playground upload**

```bash
rm -f /tmp/matmuja-enertech.zip
(cd matmuja-enertech && zip -rq /tmp/matmuja-enertech.zip . -x "*.DS_Store" "*.min.css.map")
ls -la /tmp/matmuja-enertech.zip
```

- [ ] **Step 3: Visual check in Playground**

Open https://playground.wordpress.net in a browser. In the Playground UI:
1. Sidebar → Site → Themes → Upload Theme → select `/tmp/matmuja-enertech.zip`
2. Activate "M&M EnerTech"
3. Settings → Reading → Front page displays → "A static page" → create a new "Home" page, set as front page
4. View the site

**Verify against the spec:**
- [ ] Hero: dark background, gold eyebrow, headline in Space Grotesk, two buttons (gold w/ glow, ghost), SVG grid+circles on the right
- [ ] Mission strip: gold band with centered serif-feel sentence
- [ ] Services: three cards, gold border on hover, gold square icon
- [ ] How we work: dark navy background, four numbered steps in gold
- [ ] Proof: warm cream background, three big stats, logo placeholders empty
- [ ] FAQ: white background, plus icon rotates to × on open
- [ ] CTA strip: dark navy, single gold button with glow
- [ ] Footer: deepest navy, single row

If any section is broken, fix the related task's files and re-run `npm run build` + re-upload.

- [ ] **Step 4: Lighthouse spot check**

In Chrome DevTools (Playground site URL), run Lighthouse → Mobile → Performance + Accessibility.
- Performance ≥ 80 (Playground is slower than real prod — 80 is acceptable here, real ≥ 90 is the spec's bar on a real server)
- Accessibility ≥ 95

- [ ] **Step 5: Do NOT commit `style.min.css`**

`.gitignore` already excludes `*.min.css` and `*.min.js` (build artifacts). The minified CSS gets regenerated by `npm run build` at deploy time and shipped inside the theme zip. No commit needed here.

---

## Task 13: README + final cleanup

**Files:**
- Update: `matmuja-enertech/README.md`

- [ ] **Step 1: Replace README.md content**

```markdown
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
```

- [ ] **Step 2: Commit**

```bash
git add matmuja-enertech/README.md
git commit -m "docs(theme): update README for v2.0 hybrid palette

Co-Authored-By: Claude Opus 4.7 <noreply@anthropic.com>"
```

- [ ] **Step 3: Final branch state check**

```bash
git log --oneline redesign/v2.0-spec..HEAD
# Expect: ~12 commits, all on redesign/v2.0-impl
```

- [ ] **Step 4: STOP for human review before any deploy**

Do **not** push to remote, do **not** SFTP to the IONOS webspace. The implementation branch lives locally. Human reviews the Playground render and the diff, then decides on the deploy strategy (likely: upload zip via WP admin as a new theme dir, switch active theme — keeps v1.0/v1.1 dirs as fallback).
