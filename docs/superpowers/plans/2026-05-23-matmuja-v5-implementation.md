# Matmuja v5 "Lichtleiter" Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ship v5 of the M&M EnerTech WordPress theme — engineering-minimal aesthetic (Linear/Tailscale flavour) in a sibling theme dir, leaving v4 untouched as rollback, and activate it behind the existing maintenance gate on https://matmuja.de.

**Architecture:** Copy v4 dir to a new v5 dir under `matmuja-enertech/` source tree (we work in-place in the same source dir but tag the version differently — the server deploy is to `matmuja-enertech-v5/`). Rewrite the visual layer: light paper + ink + one electric blue + one warm orange, single Geist family, single SVG fiber diagram replacing the 5 canvas system. Keep the 7-section structure, the `mm_*` Customizer schema, and the WP-CLI activation flow on IONOS.

**Tech Stack:** PHP 8 (WordPress theme), vanilla JS, vanilla CSS, self-hosted Geist + Geist Mono woff2, IntersectionObserver + SVG `getPointAtLength()` for the diagram, rsync + WP-CLI for deploy.

**Spec:** `docs/superpowers/specs/2026-05-23-matmuja-v5-design.md`

---

## File Map

| Path | Action |
|---|---|
| `matmuja-enertech/style.css` | Full rewrite (header → v5.0.0, body → v5 tokens + components) |
| `matmuja-enertech/theme.json` | Rewrite palette tokens (light) |
| `matmuja-enertech/functions.php` | Swap enqueues: drop `phase-canvases.js`, add `fiber-diagram.js`; update theme version metadata |
| `matmuja-enertech/header.php` | Rewrite for white sticky header + light nav |
| `matmuja-enertech/footer.php` | Rewrite for dark band footer with 3 cols |
| `matmuja-enertech/front-page.php` | Full rewrite of 7 sections |
| `matmuja-enertech/assets/css/fonts.css` | Swap Inter/Space Grotesk @font-face for Geist/Geist Mono |
| `matmuja-enertech/assets/js/main.js` | Trim: keep mobile menu + section reveals, drop canvas play-state scroll-spy |
| `matmuja-enertech/assets/js/fiber-diagram.js` | **NEW** — SVG path draw + scroll-driven pulse + station reveal |
| `matmuja-enertech/assets/js/phase-canvases.js` | **DELETE** |
| `matmuja-enertech/assets/fonts/inter-*.woff2` | **DELETE** (4 files) |
| `matmuja-enertech/assets/fonts/space-grotesk-*.woff2` | **DELETE** (3 files) |
| `matmuja-enertech/assets/fonts/geist-*.woff2` | **NEW** (5 files: 400, 500, 600 sans + 400, 500 mono) |
| `matmuja-enertech/README.md` | Update for v5 |
| `/mnt/c/Users/Blerimi/Documents/Obsidian Vault/Matmuja/🏠 Matmuja Home.md` | Update for v5 |

Branch: `redesign/v5.0-impl` (already created, spec already committed).

Server deploy target: `wp-content/themes/matmuja-enertech-v5/` on `access-5020163956.webspace-host.com` user `su411687`. v4 stays in place.

---

## Task 1: Install Geist + Geist Mono fonts and swap fonts.css

**Files:**
- Create: `matmuja-enertech/assets/fonts/geist-400.woff2`
- Create: `matmuja-enertech/assets/fonts/geist-500.woff2`
- Create: `matmuja-enertech/assets/fonts/geist-600.woff2`
- Create: `matmuja-enertech/assets/fonts/geist-mono-400.woff2`
- Create: `matmuja-enertech/assets/fonts/geist-mono-500.woff2`
- Delete: `matmuja-enertech/assets/fonts/inter-400.woff2`
- Delete: `matmuja-enertech/assets/fonts/inter-500.woff2`
- Delete: `matmuja-enertech/assets/fonts/inter-600.woff2`
- Delete: `matmuja-enertech/assets/fonts/inter-700.woff2`
- Delete: `matmuja-enertech/assets/fonts/space-grotesk-500.woff2`
- Delete: `matmuja-enertech/assets/fonts/space-grotesk-600.woff2`
- Delete: `matmuja-enertech/assets/fonts/space-grotesk-700.woff2`
- Modify: `matmuja-enertech/assets/css/fonts.css`

- [ ] **Step 1: Download Geist woff2 files**

Geist is OFL-licensed and shipped from `vercel/geist-font`. Use the prebuilt woff2 from their CDN.

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech/assets/fonts/

# Geist sans 400/500/600
curl -sL -o geist-400.woff2 https://vercel.com/font/sans/woff2/Geist-Regular.woff2
curl -sL -o geist-500.woff2 https://vercel.com/font/sans/woff2/Geist-Medium.woff2
curl -sL -o geist-600.woff2 https://vercel.com/font/sans/woff2/Geist-SemiBold.woff2

# Geist mono 400/500
curl -sL -o geist-mono-400.woff2 https://vercel.com/font/mono/woff2/GeistMono-Regular.woff2
curl -sL -o geist-mono-500.woff2 https://vercel.com/font/mono/woff2/GeistMono-Medium.woff2

# Verify each is > 10KB (real font, not error page)
ls -la geist-*.woff2
```

Expected: 5 files, each between 25KB and 60KB.

**If the Vercel URLs 404,** fall back to the GitHub release:
```bash
# Find latest release of vercel/geist-font and pull the .zip with woff2 files
gh release download --repo vercel/geist-font --pattern "*.zip" --dir /tmp/geist
unzip /tmp/geist/*.zip -d /tmp/geist/extracted
# Then copy: cp /tmp/geist/extracted/.../woff2/*.woff2 ./
```

- [ ] **Step 2: Delete old fonts**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech/assets/fonts/
rm -f inter-400.woff2 inter-500.woff2 inter-600.woff2 inter-700.woff2
rm -f space-grotesk-500.woff2 space-grotesk-600.woff2 space-grotesk-700.woff2
ls -la *.woff2
```

Expected: only 5 `geist-*.woff2` files remain.

- [ ] **Step 3: Rewrite `assets/css/fonts.css`**

Overwrite the file with:

```css
/* M&M EnerTech v5 — self-hosted Geist family */

@font-face {
  font-family: 'Geist';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url('../fonts/geist-400.woff2') format('woff2');
}
@font-face {
  font-family: 'Geist';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url('../fonts/geist-500.woff2') format('woff2');
}
@font-face {
  font-family: 'Geist';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url('../fonts/geist-600.woff2') format('woff2');
}
@font-face {
  font-family: 'Geist Mono';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url('../fonts/geist-mono-400.woff2') format('woff2');
}
@font-face {
  font-family: 'Geist Mono';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url('../fonts/geist-mono-500.woff2') format('woff2');
}
```

- [ ] **Step 4: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/assets/fonts/ matmuja-enertech/assets/css/fonts.css
git commit -m "chore(theme): swap Inter+SpaceGrotesk for self-hosted Geist family"
```

---

## Task 2: Rewrite `style.css` to v5 tokens + components

**Files:**
- Modify: `matmuja-enertech/style.css` (full rewrite)

- [ ] **Step 1: Overwrite `style.css`**

Replace the entire file contents with the v5 stylesheet:

```css
/*
Theme Name: M&M EnerTech
Theme URI: https://www.matmuja.de/
Author: M&M EnerTech UG
Description: Engineering-minimal WordPress theme for M&M EnerTech — light paper aesthetic, single Geist family, and a scroll-linked SVG fiber diagram for the FTTH process.
Version: 5.0.0
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: matmuja-tiefbau
Tags: business, fiber-optic, light, custom-colors, custom-menu, responsive-layout, custom-logo, editor-styles, featured-images, threaded-comments, translation-ready
*/

/* ─── TOKENS ─────────────────────────────────────────────── */
:root {
  --paper: #f7f8fa;
  --card: #ffffff;
  --ink: #0a0e1a;
  --body: #5b6373;
  --caption: #9aa1b0;
  --hairline: #e4e7ec;
  --brand: #0040ff;
  --brand-hover: #002fd0;
  --signal: #ff6b1a;

  --font-sans: 'Geist', system-ui, -apple-system, sans-serif;
  --font-mono: 'Geist Mono', ui-monospace, 'SF Mono', Menlo, monospace;

  --shell-max: 1200px;
  --gutter: clamp(20px, 4vw, 48px);
  --section-y: clamp(80px, 10vw, 140px);
}

/* ─── RESET ──────────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; }
html { -webkit-text-size-adjust: 100%; scroll-behavior: smooth; }
body {
  margin: 0;
  background: var(--paper);
  color: var(--body);
  font-family: var(--font-sans);
  font-size: 17px;
  line-height: 1.6;
  font-weight: 400;
  -webkit-font-smoothing: antialiased;
}
img, svg { display: block; max-width: 100%; height: auto; }
a { color: var(--brand); text-decoration: none; }
a:hover { text-decoration: underline; }
button { font: inherit; cursor: pointer; }
h1, h2, h3, h4, h5 { color: var(--ink); font-family: var(--font-sans); margin: 0; }
p { margin: 0; }

/* ─── TYPE ───────────────────────────────────────────────── */
.h1 { font-weight: 600; font-size: clamp(48px, 6vw, 88px); line-height: 1.05; letter-spacing: -0.02em; }
.h2 { font-weight: 600; font-size: clamp(32px, 4vw, 56px); line-height: 1.1; letter-spacing: -0.01em; }
.h3 { font-weight: 500; font-size: 24px; line-height: 1.25; }
.eyebrow {
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--caption);
}
.mono { font-family: var(--font-mono); }

/* ─── LAYOUT ─────────────────────────────────────────────── */
.shell { max-width: var(--shell-max); margin: 0 auto; padding: 0 var(--gutter); }
section { padding: var(--section-y) 0; }

/* ─── BUTTONS ────────────────────────────────────────────── */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 22px;
  font-weight: 500;
  font-size: 15px;
  border-radius: 999px;
  transition: background 0.15s ease, color 0.15s ease;
}
.btn-primary {
  background: var(--brand);
  color: #fff;
}
.btn-primary:hover { background: var(--brand-hover); text-decoration: none; color: #fff; }
.btn-ghost {
  background: transparent;
  color: var(--ink);
  padding: 14px 0;
}
.btn-ghost:hover { color: var(--brand); text-decoration: none; }

/* ─── HEADER ─────────────────────────────────────────────── */
.site-header {
  position: sticky;
  top: 0;
  z-index: 50;
  background: var(--card);
  border-bottom: 1px solid var(--hairline);
}
.site-header .shell {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 68px;
}
.wordmark {
  font-weight: 600;
  font-size: 18px;
  letter-spacing: -0.02em;
  color: var(--ink);
}
.wordmark:hover { text-decoration: none; }
.primary-nav { display: flex; gap: 28px; align-items: center; }
.primary-nav a {
  color: var(--body);
  font-size: 15px;
  font-weight: 500;
}
.primary-nav a:hover { color: var(--ink); text-decoration: none; }
.nav-cta {
  padding: 8px 16px;
  background: var(--brand);
  color: #fff;
  border-radius: 999px;
  font-size: 14px;
}
.nav-cta:hover { background: var(--brand-hover); text-decoration: none; color: #fff; }
.nav-toggle { display: none; background: none; border: 0; color: var(--ink); }
@media (max-width: 768px) {
  .primary-nav { display: none; }
  .nav-toggle { display: block; }
  .primary-nav.open {
    display: flex;
    position: absolute;
    inset: 68px 0 auto 0;
    background: var(--card);
    flex-direction: column;
    padding: 24px var(--gutter);
    border-bottom: 1px solid var(--hairline);
  }
}

/* ─── HERO ───────────────────────────────────────────────── */
.hero { padding-top: calc(var(--section-y) * 1.2); }
.hero .shell {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: clamp(40px, 6vw, 80px);
  align-items: center;
}
.hero h1 { margin-top: 20px; color: var(--ink); }
.hero .lede {
  margin-top: 24px;
  font-size: clamp(18px, 1.4vw, 21px);
  color: var(--body);
  max-width: 56ch;
}
.hero-ctas { margin-top: 36px; display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
.hero-art { display: flex; justify-content: flex-end; }
.hero-art svg { width: min(280px, 100%); height: auto; }
@media (max-width: 768px) {
  .hero .shell { grid-template-columns: 1fr; }
  .hero-art { order: -1; }
  .hero-art svg { width: 64px; }
}

/* ─── MISSION STRIP ──────────────────────────────────────── */
.mission { padding: 80px 0; border-top: 1px solid var(--ink); margin-top: 40px; }
.mission blockquote {
  margin: 0;
  font-weight: 500;
  font-size: clamp(22px, 2.4vw, 32px);
  line-height: 1.25;
  color: var(--ink);
  max-width: 60ch;
}
.mission .attrib {
  margin-top: 20px;
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--caption);
}

/* ─── PHASE DIAGRAM (§3) ─────────────────────────────────── */
.phases { background: var(--paper); }
.phases .shell { max-width: 1280px; }
.phases header { margin-bottom: 48px; max-width: 56ch; }
.phases header h2 { margin-top: 12px; }
.phases header p { margin-top: 16px; color: var(--body); font-size: 17px; }

.fiber-stage {
  position: relative;
  min-height: 180vh;
}
.fiber-svg-wrap {
  position: sticky;
  top: 12vh;
  width: 100%;
  height: 70vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
.fiber-svg { width: 100%; height: 100%; max-height: 520px; overflow: visible; }
.fiber-path { fill: none; stroke: var(--hairline); stroke-width: 2; stroke-linecap: round; }
.fiber-path.draw { stroke: var(--brand); stroke-dasharray: var(--path-len); stroke-dashoffset: var(--path-len); }
.fiber-station {
  transition: fill 0.2s ease, stroke 0.2s ease;
}
.fiber-station circle.bg { fill: var(--paper); stroke: var(--hairline); stroke-width: 2; }
.fiber-station.passed circle.bg { fill: var(--brand); stroke: var(--brand); }
.fiber-station.active circle.bg { fill: var(--card); stroke: var(--signal); stroke-width: 3; }
.fiber-station text { font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.08em; fill: var(--caption); text-transform: uppercase; }
.fiber-station.passed text, .fiber-station.active text { fill: var(--ink); }
.fiber-pulse {
  fill: var(--brand);
  filter: drop-shadow(0 0 8px rgba(0, 64, 255, 0.5));
}
.fiber-captions { position: relative; margin-top: 32px; min-height: 160px; }
.fiber-caption {
  position: absolute;
  inset: 0;
  opacity: 0;
  transition: opacity 0.3s ease;
  max-width: 60ch;
  margin: 0 auto;
  text-align: center;
}
.fiber-caption.active { opacity: 1; }
.fiber-caption .num { font-family: var(--font-mono); font-size: 12px; letter-spacing: 0.12em; color: var(--signal); text-transform: uppercase; }
.fiber-caption h3 { margin-top: 8px; }
.fiber-caption p { margin-top: 12px; color: var(--body); }

@media (max-width: 768px) {
  .fiber-stage { min-height: 0; }
  .fiber-svg-wrap { position: static; height: auto; }
  .fiber-svg { max-height: none; }
}

/* ─── TEAM (§4) ──────────────────────────────────────────── */
.team .shell { display: grid; grid-template-columns: 1fr 2fr; gap: clamp(40px, 6vw, 80px); }
.team header { max-width: 36ch; }
.team header p { margin-top: 16px; color: var(--body); }
.team-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
.team-card {
  background: var(--card);
  border: 1px solid var(--hairline);
  padding: 32px;
  border-radius: 4px;
}
.team-portrait {
  width: 96px;
  height: 96px;
  background: var(--paper);
  border: 1px solid var(--hairline);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-mono);
  font-size: 28px;
  font-weight: 500;
  color: var(--ink);
  letter-spacing: 0.04em;
}
.team-card h3 { margin-top: 24px; font-size: 22px; font-weight: 600; }
.team-card .role {
  margin-top: 6px;
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--caption);
}
.team-card .bio { margin-top: 16px; font-size: 15px; }
.team-skills { margin-top: 20px; display: flex; flex-wrap: wrap; gap: 6px; }
.team-skills span {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  border: 1px solid var(--hairline);
  padding: 4px 8px;
  color: var(--body);
}
@media (max-width: 900px) {
  .team .shell { grid-template-columns: 1fr; }
  .team-grid { grid-template-columns: 1fr; }
}

/* ─── PROOF (§5) ─────────────────────────────────────────── */
.proof header { text-align: center; margin-bottom: 48px; }
.proof .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.stat {
  background: var(--card);
  border: 1px solid var(--hairline);
  padding: 32px;
  border-radius: 4px;
}
.stat .num {
  font-family: var(--font-mono);
  font-weight: 500;
  font-size: clamp(36px, 4vw, 48px);
  color: var(--ink);
  line-height: 1;
}
.stat .underline { width: 40%; height: 2px; background: var(--signal); margin-top: 12px; }
.stat .unit {
  margin-top: 16px;
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--caption);
}
.stat .label { margin-top: 8px; color: var(--body); font-size: 15px; }
.client-strip {
  margin-top: 64px;
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
  align-items: center;
  justify-content: center;
}
.client-strip img {
  height: 32px;
  filter: grayscale(1);
  opacity: 0.55;
  transition: opacity 0.15s ease;
}
.client-strip img:hover { opacity: 1; }
@media (max-width: 768px) { .proof .stats { grid-template-columns: 1fr 1fr; } }

/* ─── FAQ (§6) ───────────────────────────────────────────── */
.faq .shell { max-width: 760px; }
.faq header { text-align: center; margin-bottom: 32px; }
.faq details {
  border-top: 1px solid var(--hairline);
  padding: 24px 0;
}
.faq details:last-of-type { border-bottom: 1px solid var(--hairline); }
.faq summary {
  list-style: none;
  cursor: pointer;
  font-family: var(--font-sans);
  font-weight: 500;
  font-size: 18px;
  color: var(--ink);
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
}
.faq summary::-webkit-details-marker { display: none; }
.faq summary::after {
  content: '+';
  color: var(--ink);
  font-family: var(--font-mono);
  font-size: 20px;
  transition: transform 0.2s ease;
}
.faq details[open] summary::after { content: '−'; }
.faq details > div { margin-top: 16px; color: var(--body); font-size: 16px; line-height: 1.6; }

/* ─── CTA STRIP (§7) ─────────────────────────────────────── */
.cta-strip { background: var(--paper); border-top: 1px solid var(--hairline); }
.cta-strip .shell {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  flex-wrap: wrap;
}
.cta-strip h2 { font-size: clamp(28px, 3vw, 40px); max-width: 24ch; }
.cta-strip .contact {
  margin-top: 24px;
  width: 100%;
  font-family: var(--font-mono);
  font-size: 13px;
  letter-spacing: 0.06em;
  color: var(--caption);
  text-transform: uppercase;
}
.cta-strip .contact a { color: var(--caption); }
.cta-strip .contact a:hover { color: var(--ink); text-decoration: none; }

/* ─── FOOTER ─────────────────────────────────────────────── */
.site-footer {
  background: var(--ink);
  color: #fff;
  padding: 64px 0 32px;
}
.site-footer .shell {
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr;
  gap: 48px;
}
.site-footer .wordmark { color: #fff; font-size: 20px; }
.site-footer .tagline {
  margin-top: 12px;
  color: rgba(255, 255, 255, 0.6);
  font-size: 14px;
  max-width: 32ch;
}
.site-footer h4 {
  color: rgba(255, 255, 255, 0.6);
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  font-weight: 500;
  margin-bottom: 16px;
}
.site-footer ul { list-style: none; padding: 0; margin: 0; }
.site-footer li { margin-bottom: 10px; }
.site-footer a { color: #fff; font-size: 15px; }
.site-footer a:hover { color: rgba(255, 255, 255, 0.7); text-decoration: none; }
.footer-bottom {
  max-width: var(--shell-max);
  margin: 48px auto 0;
  padding: 24px var(--gutter) 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: rgba(255, 255, 255, 0.5);
  font-family: var(--font-mono);
  font-size: 12px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}
.footer-social { display: flex; gap: 16px; }
.footer-social a {
  width: 32px;
  height: 32px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
@media (max-width: 768px) {
  .site-footer .shell { grid-template-columns: 1fr; }
  .footer-bottom { flex-direction: column; gap: 16px; }
}

/* ─── REVEAL ANIMATIONS ──────────────────────────────────── */
.reveal { opacity: 0; transform: translateY(8px); transition: opacity 0.4s ease, transform 0.4s ease; }
.reveal.in { opacity: 1; transform: translateY(0); }

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation: none !important; transition: none !important; }
  html { scroll-behavior: auto; }
  .reveal { opacity: 1; transform: none; }
  .fiber-path.draw { stroke-dashoffset: 0; }
  .fiber-station { opacity: 1 !important; }
  .fiber-caption { opacity: 1 !important; position: relative; margin-top: 24px; }
  .fiber-svg-wrap { position: static; height: auto; }
}
```

- [ ] **Step 2: Sanity-check the CSS file**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
wc -l style.css
grep -c "}" style.css
grep -c "{" style.css
```

Expected: brace counts match, line count between 350 and 500.

- [ ] **Step 3: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/style.css
git commit -m "feat(theme): v5 stylesheet — light tokens + Geist + component system"
```

---

## Task 3: Rewrite `theme.json` with light palette

**Files:**
- Modify: `matmuja-enertech/theme.json`

- [ ] **Step 1: Overwrite `theme.json`**

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 2,
  "settings": {
    "color": {
      "palette": [
        { "slug": "paper",   "color": "#f7f8fa", "name": "Paper" },
        { "slug": "card",    "color": "#ffffff", "name": "Card" },
        { "slug": "ink",     "color": "#0a0e1a", "name": "Ink" },
        { "slug": "body",    "color": "#5b6373", "name": "Body" },
        { "slug": "caption", "color": "#9aa1b0", "name": "Caption" },
        { "slug": "brand",   "color": "#0040ff", "name": "Brand Blue" },
        { "slug": "signal",  "color": "#ff6b1a", "name": "Signal Orange" }
      ]
    },
    "typography": {
      "fontFamilies": [
        { "fontFamily": "Geist, system-ui, sans-serif", "slug": "geist", "name": "Geist" },
        { "fontFamily": "'Geist Mono', ui-monospace, monospace", "slug": "geist-mono", "name": "Geist Mono" }
      ]
    }
  }
}
```

- [ ] **Step 2: Verify JSON is valid**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
node -e "JSON.parse(require('fs').readFileSync('theme.json','utf8'))" && echo OK
```

Expected: `OK`.

- [ ] **Step 3: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/theme.json
git commit -m "feat(theme): v5 theme.json — light palette + Geist family"
```

---

## Task 4: Update `functions.php` enqueues and version

**Files:**
- Modify: `matmuja-enertech/functions.php` (lines around 73–82 and around the file header)

- [ ] **Step 1: Replace the v4 phase-canvases enqueue block**

Find this block in `functions.php`:

```php
    // v4: animated phase canvases — front page only
    if ( is_front_page() ) {
        wp_enqueue_script(
            'matmuja-phase-canvases',
            get_template_directory_uri() . '/assets/js/phase-canvases.js',
            [],
            $theme_version,
            true
```

Use Edit tool to swap the comment + script handle + filename to:

```php
    // v5: scroll-linked SVG fiber diagram — front page only
    if ( is_front_page() ) {
        wp_enqueue_script(
            'matmuja-fiber-diagram',
            get_template_directory_uri() . '/assets/js/fiber-diagram.js',
            [],
            $theme_version,
            true
```

Find the `);` that closes this block (the next line after `true`) and leave it intact.

- [ ] **Step 2: Update the docblock at top of `functions.php`**

Edit lines 1–6 from:

```php
<?php
/**
 * Matmuja Tiefbau - Theme Functions
 *
 * @package matmuja-tiefbau
 */
```

…to:

```php
<?php
/**
 * M&M EnerTech v5 - Theme Functions
 *
 * @package matmuja-tiefbau
 */
```

- [ ] **Step 3: PHP brace balance sanity check**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
node -e "const s=require('fs').readFileSync('functions.php','utf8'); const o=(s.match(/\{/g)||[]).length, c=(s.match(/\}/g)||[]).length; console.log('open',o,'close',c); process.exit(o===c?0:1)"
```

Expected: open and close counts match.

- [ ] **Step 4: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/functions.php
git commit -m "feat(theme): v5 enqueues — swap phase-canvases for fiber-diagram"
```

---

## Task 5: Rewrite `header.php`

**Files:**
- Modify: `matmuja-enertech/header.php` (full rewrite)

- [ ] **Step 1: Overwrite `header.php`**

```php
<?php
/**
 * Theme header — v5
 *
 * @package matmuja-tiefbau
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#f7f8fa">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
    <div class="shell">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wordmark" rel="home">
            M&amp;M EnerTech
        </a>

        <button class="nav-toggle" aria-label="Menü öffnen" aria-expanded="false" type="button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
        </button>

        <nav class="primary-nav" aria-label="Hauptnavigation">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ] );
            } else {
                ?>
                <a href="#phases">Prozess</a>
                <a href="#team">Über uns</a>
                <a href="#faq">FAQ</a>
                <?php
            }
            ?>
            <a class="nav-cta" href="#cta">Kontakt aufnehmen</a>
        </nav>
    </div>
</header>
```

- [ ] **Step 2: PHP brace balance check**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
node -e "const s=require('fs').readFileSync('header.php','utf8'); const o=(s.match(/\{/g)||[]).length, c=(s.match(/\}/g)||[]).length; console.log('open',o,'close',c); process.exit(o===c?0:1)"
```

Expected: counts match.

- [ ] **Step 3: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/header.php
git commit -m "feat(theme): v5 header — white sticky bar, light nav, fallback menu"
```

---

## Task 6: Rewrite `front-page.php` — full 7-section template

**Files:**
- Modify: `matmuja-enertech/front-page.php` (full rewrite)

- [ ] **Step 1: Overwrite `front-page.php`**

```php
<?php
/**
 * Front page template — v5 "Lichtleiter"
 *
 * @package matmuja-tiefbau
 */

get_header();

$mm = [
    'hero_eyebrow' => get_theme_mod( 'mm_hero_eyebrow', 'FTTH · TIEFBAU BIS BUCHSE' ),
    'hero_h1'      => get_theme_mod( 'mm_hero_h1',      'Glasfaser bauen wir bis zur letzten Hauswand.' ),
    'hero_lede'    => get_theme_mod( 'mm_hero_lede',    'M&M EnerTech ist ein deutscher FTTH-Tiefbaubetrieb mit zwei Ingenieuren an der Spitze. Vom Spaten bis zur Buchse — alle fünf Phasen aus einer Hand.' ),
    'hero_cta1'    => get_theme_mod( 'mm_hero_cta1_text', 'Projekt anfragen' ),
    'hero_cta1_url'=> get_theme_mod( 'mm_hero_cta1_url',  '#cta' ),
    'hero_cta2'    => get_theme_mod( 'mm_hero_cta2_text', 'Unser Prozess' ),
    'mission'      => get_theme_mod( 'mm_mission',      'Wir bauen Glasfaser so, dass sie hält — vom ersten Spatenstich bis zum aktiven Anschluss in der Wohnung.' ),
    'phases_eyebrow' => get_theme_mod( 'mm_phases_eyebrow', 'DER PROZESS' ),
    'phases_h2'    => get_theme_mod( 'mm_phases_h2',    'Vom Spaten bis zur Buchse.' ),
    'phases_lede'  => get_theme_mod( 'mm_phases_lede',  'Fünf Phasen, eine Verantwortung. Wir übernehmen die gesamte Wertschöpfungskette — und am Ende leuchtet bei Ihnen das Licht.' ),
    'team_eyebrow' => get_theme_mod( 'mm_team_eyebrow', 'ÜBER UNS' ),
    'team_h2'      => get_theme_mod( 'mm_team_h2',      'Zwei Ingenieure. Eine durchgehende Kette.' ),
    'team_lede'    => get_theme_mod( 'mm_team_lede',    'Ein Bauleiter für den Untergrund, ein Aktivierer für das Signal. Beide Ing. — beide vor Ort.' ),
    'proof_h2'     => get_theme_mod( 'mm_proof_h2',     'Was wir gebaut haben.' ),
    'faq_h2'       => get_theme_mod( 'mm_faq_h2',       'Häufige Fragen.' ),
    'cta_h2'       => get_theme_mod( 'mm_cta_h2',       'Bereit für den nächsten FTTH-Abschnitt?' ),
    'cta_btn'      => get_theme_mod( 'mm_cta_btn',      'Projekt anfragen' ),
];

$phases = [
    1 => [ 'title' => get_theme_mod( 'mm_phase_1_title', 'Planung' ),            'desc' => get_theme_mod( 'mm_phase_1_desc', 'GIS-gestützte Trassenplanung mit Netzbetreibern und Stadtwerken — vom Übergabepunkt bis zur Hauswand.' ) ],
    2 => [ 'title' => get_theme_mod( 'mm_phase_2_title', 'Tiefbau' ),            'desc' => get_theme_mod( 'mm_phase_2_desc', 'Präziser Tiefbau mit minimaler Eingriffstiefe. Microtrenching, klassischer Tiefbau und Pflugverlegung — je nach Untergrund.' ) ],
    3 => [ 'title' => get_theme_mod( 'mm_phase_3_title', 'Kabelverlegung' ),     'desc' => get_theme_mod( 'mm_phase_3_desc', 'Verlegung der Leerrohre und Einblasen der Faser. Saubere Übergabepunkte, dokumentierte Trassen.' ) ],
    4 => [ 'title' => get_theme_mod( 'mm_phase_4_title', 'Spleißen & Messung' ), 'desc' => get_theme_mod( 'mm_phase_4_desc', 'Spleißarbeiten an Muffe und Hausverteiler. OTDR-Messung dokumentiert jede einzelne Faser.' ) ],
    5 => [ 'title' => get_theme_mod( 'mm_phase_5_title', 'Hausanschluss' ),      'desc' => get_theme_mod( 'mm_phase_5_desc', 'FTTH-Anschluss bis zur aktiven Buchse. Übergabe an den Endkunden, Abnahmeprotokoll, fertig.' ) ],
];

$stats = [
    [ 'num' => get_theme_mod( 'mm_stat_1_num',   '12+' ),  'unit' => get_theme_mod( 'mm_stat_1_unit', 'JAHRE' ),       'label' => get_theme_mod( 'mm_stat_1_label', 'Tiefbau-Erfahrung' ) ],
    [ 'num' => get_theme_mod( 'mm_stat_2_num',   '1200' ), 'unit' => get_theme_mod( 'mm_stat_2_unit', 'KM' ),          'label' => get_theme_mod( 'mm_stat_2_label', 'Faser verlegt' ) ],
    [ 'num' => get_theme_mod( 'mm_stat_3_num',   '150' ),  'unit' => get_theme_mod( 'mm_stat_3_unit', 'PROJEKTE' ),    'label' => get_theme_mod( 'mm_stat_3_label', 'Abgeschlossen' ) ],
    [ 'num' => get_theme_mod( 'mm_stat_4_num',   'DIN' ),  'unit' => get_theme_mod( 'mm_stat_4_unit', 'ZERTIFIZIERT' ),'label' => get_theme_mod( 'mm_stat_4_label', 'Qualitätsstandard' ) ],
];

$faqs = [
    [ 'q' => get_theme_mod( 'mm_faq_1_q', 'Übernehmen Sie auch nur einzelne Phasen?' ),
      'a' => get_theme_mod( 'mm_faq_1_a', 'Ja. Häufig kommen wir für Tiefbau oder Spleißarbeiten dazu — können aber jederzeit den gesamten Anschluss übernehmen, wenn gewünscht.' ) ],
    [ 'q' => get_theme_mod( 'mm_faq_2_q', 'In welcher Region arbeiten Sie?' ),
      'a' => get_theme_mod( 'mm_faq_2_a', 'Schwerpunkt Süddeutschland, Projekte auch bundesweit nach Abstimmung.' ) ],
    [ 'q' => get_theme_mod( 'mm_faq_3_q', 'Wer sind Ihre üblichen Auftraggeber?' ),
      'a' => get_theme_mod( 'mm_faq_3_a', 'Netzbetreiber, Stadtwerke und kommunale Versorger. Hausanschlüsse direkt für Endkunden ebenfalls möglich.' ) ],
    [ 'q' => get_theme_mod( 'mm_faq_4_q', 'Wie schnell können Sie starten?' ),
      'a' => get_theme_mod( 'mm_faq_4_a', 'Kurzfristige Termine nach Verfügbarkeit. Vor jeder Beauftragung gibt es eine kostenlose Vor-Ort-Begehung.' ) ],
];
?>

<!-- §1 Hero -->
<section class="hero" id="hero">
    <div class="shell">
        <div class="hero-text">
            <div class="eyebrow"><?php echo esc_html( $mm['hero_eyebrow'] ); ?></div>
            <h1 class="h1"><?php echo esc_html( $mm['hero_h1'] ); ?></h1>
            <p class="lede"><?php echo esc_html( $mm['hero_lede'] ); ?></p>
            <div class="hero-ctas">
                <a class="btn btn-primary" href="<?php echo esc_url( $mm['hero_cta1_url'] ); ?>"><?php echo esc_html( $mm['hero_cta1'] ); ?></a>
                <a class="btn btn-ghost" href="#phases"><?php echo esc_html( $mm['hero_cta2'] ); ?> <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <div class="hero-art" aria-hidden="true">
            <!-- fiber cross-section: jacket / strand / signal marker -->
            <svg viewBox="0 0 240 240" xmlns="http://www.w3.org/2000/svg">
                <circle cx="120" cy="120" r="100" fill="none" stroke="#0a0e1a" stroke-width="2"/>
                <circle cx="120" cy="120" r="56"  fill="none" stroke="#0040ff" stroke-width="2"/>
                <circle cx="120" cy="120" r="6"   fill="#ff6b1a"/>
                <line x1="120" y1="20" x2="120" y2="64"  stroke="#0a0e1a" stroke-width="1"/>
                <line x1="120" y1="176" x2="120" y2="220" stroke="#0a0e1a" stroke-width="1"/>
                <line x1="20" y1="120" x2="64" y2="120"  stroke="#0a0e1a" stroke-width="1"/>
                <line x1="176" y1="120" x2="220" y2="120" stroke="#0a0e1a" stroke-width="1"/>
                <text x="120" y="14" text-anchor="middle" font-family="Geist Mono, monospace" font-size="9" fill="#9aa1b0" letter-spacing="1">JACKET</text>
                <text x="120" y="236" text-anchor="middle" font-family="Geist Mono, monospace" font-size="9" fill="#9aa1b0" letter-spacing="1">STRAND</text>
            </svg>
        </div>
    </div>
</section>

<!-- §2 Mission strip -->
<section class="mission" id="mission">
    <div class="shell">
        <blockquote>„<?php echo esc_html( $mm['mission'] ); ?>"</blockquote>
        <div class="attrib">ING. BLERIM MATMUJA · ING. INDRIT MATMUJA</div>
    </div>
</section>

<!-- §3 Phase diagram -->
<section class="phases" id="phases">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow"><?php echo esc_html( $mm['phases_eyebrow'] ); ?></div>
            <h2 class="h2"><?php echo esc_html( $mm['phases_h2'] ); ?></h2>
            <p><?php echo esc_html( $mm['phases_lede'] ); ?></p>
        </header>

        <div class="fiber-stage" data-fiber-stage>
            <div class="fiber-svg-wrap">
                <svg class="fiber-svg" viewBox="0 0 1200 320" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path class="fiber-path" d="M 60 240 C 220 240, 280 60, 440 60 S 660 240, 820 240 S 1040 60, 1140 60" />
                    <path class="fiber-path draw" data-fiber-draw d="M 60 240 C 220 240, 280 60, 440 60 S 660 240, 820 240 S 1040 60, 1140 60" />

                    <?php
                    // 5 station positions along the path (approximate, set per percent)
                    $station_t = [ 0.05, 0.27, 0.5, 0.73, 0.95 ];
                    foreach ( $station_t as $i => $t ) :
                        $idx = $i + 1;
                    ?>
                        <g class="fiber-station" data-station="<?php echo $idx; ?>" data-station-t="<?php echo $t; ?>">
                            <circle class="bg" r="18"/>
                            <text dy="42" text-anchor="middle">0<?php echo $idx; ?> / 05</text>
                        </g>
                    <?php endforeach; ?>

                    <circle class="fiber-pulse" data-fiber-pulse r="6"/>
                </svg>
            </div>

            <div class="fiber-captions" aria-live="polite">
                <?php foreach ( $phases as $i => $p ) : ?>
                    <div class="fiber-caption<?php echo $i === 1 ? ' active' : ''; ?>" data-caption="<?php echo $i; ?>">
                        <div class="num">PHASE 0<?php echo $i; ?> / 05</div>
                        <h3 class="h3"><?php echo esc_html( $p['title'] ); ?></h3>
                        <p><?php echo esc_html( $p['desc'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- §4 Team -->
<section class="team" id="team">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow"><?php echo esc_html( $mm['team_eyebrow'] ); ?></div>
            <h2 class="h2"><?php echo esc_html( $mm['team_h2'] ); ?></h2>
            <p><?php echo esc_html( $mm['team_lede'] ); ?></p>
        </header>

        <div class="team-grid">
            <article class="team-card reveal">
                <div class="team-portrait">BM</div>
                <h3>Ing. Blerim Matmuja</h3>
                <div class="role">ING. · IT / FTTH-AKTIVIERUNG</div>
                <p class="bio">Digitale Infrastruktur, GIS-Planung, IoT und FTTH-Aktivierung. Übergabe an den Endkunden ist sein Tisch.</p>
                <div class="team-skills">
                    <span>GIS</span><span>FTTH-Aktivierung</span><span>OTDR</span><span>IoT</span><span>Netzwerktechnik</span>
                </div>
            </article>
            <article class="team-card reveal">
                <div class="team-portrait">IM</div>
                <h3>Ing. Indrit Matmuja</h3>
                <div class="role">ING. · TIEFBAU / SPLEISSEN</div>
                <p class="bio">Maschinenbau und Elektrotechnik. Bauleitung, Tiefbau, Spleißarbeiten — der erste Spatenstich ist sein Tisch.</p>
                <div class="team-skills">
                    <span>Tiefbau</span><span>Spleißen</span><span>Maschinenbau</span><span>Elektrotechnik</span><span>Bauleitung</span>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- §5 Proof -->
<section class="proof" id="proof">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow">ZAHLEN</div>
            <h2 class="h2"><?php echo esc_html( $mm['proof_h2'] ); ?></h2>
        </header>
        <div class="stats">
            <?php foreach ( $stats as $s ) : ?>
                <div class="stat reveal">
                    <div class="num"><?php echo esc_html( $s['num'] ); ?></div>
                    <div class="underline" aria-hidden="true"></div>
                    <div class="unit"><?php echo esc_html( $s['unit'] ); ?></div>
                    <div class="label"><?php echo esc_html( $s['label'] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        $logos = [];
        for ( $i = 1; $i <= 6; $i++ ) {
            $url = get_theme_mod( 'mm_client_logo_' . $i );
            if ( $url ) { $logos[] = $url; }
        }
        if ( ! empty( $logos ) ) : ?>
            <div class="client-strip">
                <?php foreach ( $logos as $url ) : ?>
                    <img src="<?php echo esc_url( $url ); ?>" alt="" loading="lazy">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- §6 FAQ -->
<section class="faq" id="faq">
    <div class="shell">
        <header class="reveal">
            <div class="eyebrow">FAQ</div>
            <h2 class="h2"><?php echo esc_html( $mm['faq_h2'] ); ?></h2>
        </header>
        <?php foreach ( $faqs as $f ) : ?>
            <details>
                <summary><?php echo esc_html( $f['q'] ); ?></summary>
                <div><?php echo esc_html( $f['a'] ); ?></div>
            </details>
        <?php endforeach; ?>
    </div>
</section>

<!-- §7 CTA strip -->
<section class="cta-strip" id="cta">
    <div class="shell">
        <h2 class="h2"><?php echo esc_html( $mm['cta_h2'] ); ?></h2>
        <a class="btn btn-primary" href="mailto:<?php echo esc_attr( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?>"><?php echo esc_html( $mm['cta_btn'] ); ?></a>
        <div class="contact">
            <a href="tel:<?php echo esc_attr( get_theme_mod( 'matmuja_phone', '' ) ); ?>"><?php echo esc_html( get_theme_mod( 'matmuja_phone', '+49 — — —' ) ); ?></a>
            &nbsp;·&nbsp;
            <a href="mailto:<?php echo esc_attr( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?>"><?php echo esc_html( get_theme_mod( 'matmuja_email', 'info@matmuja.de' ) ); ?></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
```

- [ ] **Step 2: PHP brace balance**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
node -e "const s=require('fs').readFileSync('front-page.php','utf8'); const o=(s.match(/\{/g)||[]).length, c=(s.match(/\}/g)||[]).length; console.log('open',o,'close',c); process.exit(o===c?0:1)"
```

Expected: counts match.

- [ ] **Step 3: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/front-page.php
git commit -m "feat(theme): v5 front-page — 7 sections with single fiber diagram"
```

---

## Task 7: Create `fiber-diagram.js` and delete `phase-canvases.js`

**Files:**
- Create: `matmuja-enertech/assets/js/fiber-diagram.js`
- Delete: `matmuja-enertech/assets/js/phase-canvases.js`

- [ ] **Step 1: Create `assets/js/fiber-diagram.js`**

```javascript
/**
 * M&M EnerTech v5 — scroll-linked SVG fiber diagram.
 *
 * Single SVG path traced left-to-right. As the user scrolls past the section,
 * (a) the path is drawn (stroke-dashoffset), (b) a blue pulse dot rides along
 * the path via getPointAtLength(), and (c) the active station gets highlighted
 * and the matching caption fades in.
 *
 * Reduced-motion users: skip all of the above; CSS handles the static fallback.
 */
(function () {
  'use strict';

  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return; // CSS already shows everything lit
  }

  document.addEventListener('DOMContentLoaded', function () {
    const stage = document.querySelector('[data-fiber-stage]');
    if (!stage) return;
    const svg = stage.querySelector('.fiber-svg');
    const drawPath = stage.querySelector('[data-fiber-draw]');
    const pulse = stage.querySelector('[data-fiber-pulse]');
    const stations = Array.from(stage.querySelectorAll('.fiber-station'));
    const captions = Array.from(stage.querySelectorAll('.fiber-caption'));
    if (!drawPath || !pulse || stations.length === 0) return;

    const totalLen = drawPath.getTotalLength();
    drawPath.style.setProperty('--path-len', totalLen);
    drawPath.style.strokeDasharray = totalLen;
    drawPath.style.strokeDashoffset = totalLen;

    // Place each station marker at its parametric position along the path.
    stations.forEach(function (g) {
      const t = parseFloat(g.dataset.stationT || '0');
      const p = drawPath.getPointAtLength(totalLen * t);
      g.setAttribute('transform', 'translate(' + p.x + ',' + p.y + ')');
    });

    // Scroll-driven update.
    let ticking = false;
    function update() {
      ticking = false;
      const rect = stage.getBoundingClientRect();
      const vh = window.innerHeight;
      // progress: 0 when stage top hits viewport bottom; 1 when stage bottom hits viewport top
      const total = rect.height + vh;
      let progress = (vh - rect.top) / total;
      progress = Math.max(0, Math.min(1, progress));

      // Map progress (0..1) to path traversal — but only count the middle 60% of scroll
      // so the diagram fully draws before the section leaves the viewport.
      const t = Math.max(0, Math.min(1, (progress - 0.2) / 0.6));

      // Draw the path up to t.
      drawPath.style.strokeDashoffset = totalLen * (1 - t);

      // Move the pulse to position t along the path.
      const point = drawPath.getPointAtLength(totalLen * t);
      pulse.setAttribute('cx', point.x);
      pulse.setAttribute('cy', point.y);
      pulse.style.opacity = t > 0.001 && t < 0.999 ? 1 : 0;

      // Highlight active station + sync caption.
      let activeIdx = 0;
      stations.forEach(function (g, i) {
        const st = parseFloat(g.dataset.stationT || '0');
        g.classList.remove('active', 'passed');
        if (t >= st - 0.04 && t <= st + 0.08) {
          g.classList.add('active');
          activeIdx = i;
        } else if (t > st) {
          g.classList.add('passed');
        }
      });
      // If past last station, lock active to last
      if (t >= 0.95) activeIdx = stations.length - 1;
      captions.forEach(function (c, i) {
        c.classList.toggle('active', i === activeIdx);
      });
    }

    function onScroll() {
      if (!ticking) {
        window.requestAnimationFrame(update);
        ticking = true;
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', function () {
      // Re-place stations on resize since SVG geometry may reflow.
      const len = drawPath.getTotalLength();
      drawPath.style.strokeDasharray = len;
      stations.forEach(function (g) {
        const t = parseFloat(g.dataset.stationT || '0');
        const p = drawPath.getPointAtLength(len * t);
        g.setAttribute('transform', 'translate(' + p.x + ',' + p.y + ')');
      });
      update();
    });

    update();
  });
})();
```

- [ ] **Step 2: Delete `phase-canvases.js`**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
rm assets/js/phase-canvases.js
```

- [ ] **Step 3: Verify file count and JS syntax**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
ls assets/js/
node -c assets/js/fiber-diagram.js && echo "fiber-diagram.js OK"
node -c assets/js/main.js && echo "main.js OK"
```

Expected: only `main.js`, `main.min.js`, `fiber-diagram.js` present. Both `node -c` checks print OK.

- [ ] **Step 4: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/assets/js/fiber-diagram.js
git rm matmuja-enertech/assets/js/phase-canvases.js
git commit -m "feat(theme): v5 fiber-diagram.js + drop phase-canvases.js"
```

---

## Task 8: Rewrite `footer.php`

**Files:**
- Modify: `matmuja-enertech/footer.php` (full rewrite)

- [ ] **Step 1: Overwrite `footer.php`**

```php
<?php
/**
 * Theme footer — v5
 *
 * @package matmuja-tiefbau
 */
$phone = get_theme_mod( 'matmuja_phone', '' );
$email = get_theme_mod( 'matmuja_email', 'info@matmuja.de' );
$address = get_theme_mod( 'matmuja_address', '' );
$instagram = get_theme_mod( 'matmuja_instagram', '' );
$linkedin  = get_theme_mod( 'matmuja_linkedin', '' );
?>
<footer class="site-footer" role="contentinfo">
    <div class="shell">
        <div class="footer-brand">
            <div class="wordmark">M&amp;M EnerTech</div>
            <p class="tagline">FTTH end-to-end. Vom Spaten bis zur Buchse.</p>
        </div>
        <div class="footer-contact">
            <h4>Kontakt</h4>
            <ul>
                <?php if ( $phone ) : ?>
                    <li><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                <?php endif; ?>
                <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
                <?php if ( $address ) : ?>
                    <li><?php echo nl2br( esc_html( $address ) ); ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Rechtliches</h4>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/impressum' ) ); ?>">Impressum</a></li>
                <li><a href="<?php echo esc_url( home_url( '/datenschutz' ) ); ?>">Datenschutz</a></li>
                <li><a href="#cta">Kontakt</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div>© <?php echo esc_html( date( 'Y' ) ); ?> M&amp;M EnerTech UG</div>
        <div class="footer-social">
            <?php if ( $instagram ) : ?>
                <a href="<?php echo esc_url( $instagram ); ?>" aria-label="Instagram" target="_blank" rel="noopener">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/></svg>
                </a>
            <?php endif; ?>
            <?php if ( $linkedin ) : ?>
                <a href="<?php echo esc_url( $linkedin ); ?>" aria-label="LinkedIn" target="_blank" rel="noopener">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="8" y1="10" x2="8" y2="17"/><circle cx="8" cy="7" r="0.5" fill="currentColor"/><path d="M12 17v-4a2 2 0 0 1 4 0v4M12 10v7"/></svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
```

- [ ] **Step 2: PHP brace balance**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
node -e "const s=require('fs').readFileSync('footer.php','utf8'); const o=(s.match(/\{/g)||[]).length, c=(s.match(/\}/g)||[]).length; console.log('open',o,'close',c); process.exit(o===c?0:1)"
```

Expected: counts match.

- [ ] **Step 3: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/footer.php
git commit -m "feat(theme): v5 footer — dark band with 3-column layout"
```

---

## Task 9: Trim `assets/js/main.js`

**Files:**
- Modify: `matmuja-enertech/assets/js/main.js` (rewrite)

- [ ] **Step 1: Overwrite `main.js`**

```javascript
/**
 * M&M EnerTech v5 — main script.
 *
 * Two responsibilities:
 *   1. Mobile nav toggle.
 *   2. .reveal IntersectionObserver to fade in elements when they enter view.
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // Mobile nav toggle.
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.primary-nav');
    if (toggle && nav) {
      toggle.addEventListener('click', function () {
        const open = nav.classList.toggle('open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    }

    // Reveal on scroll.
    const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce) {
      document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('in'); });
      return;
    }
    const io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          io.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
  });
})();
```

- [ ] **Step 2: JS syntax check**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
node -c assets/js/main.js && echo OK
```

Expected: `OK`.

- [ ] **Step 3: Delete the stale minified bundle (will be rebuilt by `npm run build` later or by hand)**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
rm -f assets/js/main.min.js style.min.css
```

- [ ] **Step 4: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/assets/js/main.js
git rm -f matmuja-enertech/assets/js/main.min.js matmuja-enertech/style.min.css 2>/dev/null || true
git commit -m "feat(theme): v5 main.js — mobile nav + reveal observer only" --allow-empty
```

---

## Task 10: Bundle minified assets

**Files:**
- Modify: `matmuja-enertech/assets/js/main.min.js` (regenerated)
- Modify: `matmuja-enertech/style.min.css` (regenerated)

- [ ] **Step 1: Check whether `npm run build` exists and works**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
cat package.json | grep -A 5 '"scripts"'
```

If `build` script is present, run it:

```bash
npm run build
```

If not, fall back to manual minify with `terser` and `csso` (already in `node_modules` per memory):

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
npx terser matmuja-enertech/assets/js/main.js -o matmuja-enertech/assets/js/main.min.js -c -m
npx csso matmuja-enertech/style.css -o matmuja-enertech/style.min.css
```

- [ ] **Step 2: Verify size budgets**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech
ls -la style.min.css assets/js/main.min.js assets/js/fiber-diagram.js
```

Expected:
- `style.min.css` ≤ 30KB
- `main.min.js` ≤ 5KB
- `fiber-diagram.js` ≤ 8KB (unminified, served as-is per enqueue)

If any are over budget, prune unused selectors / comments before continuing.

- [ ] **Step 3: Commit (build artifacts are normally gitignored — only commit if needed for deploy)**

Build artifacts (`style.min.css`, `main.min.js`) are listed in `.gitignore` per project memory. They will be rebuilt at deploy time from the source. Skip the commit if `git status` shows nothing tracked-relevant.

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git status
# If only gitignored files changed, no commit needed.
```

---

## Task 11: Update `README.md`

**Files:**
- Modify: `matmuja-enertech/README.md`

- [ ] **Step 1: Read existing README**

```bash
head -40 /home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech/README.md
```

- [ ] **Step 2: Replace the top section with v5 wording**

Use Edit to replace the existing title + summary paragraph at the top of the README with exactly:

```markdown
# M&M EnerTech — v5 "Lichtleiter"

Engineering-minimal WordPress theme for the M&M EnerTech FTTH/Tiefbau business.
Light paper aesthetic, single Geist family, and a scroll-linked SVG fiber
diagram that traces all 5 process phases as one continuous strand.

**Version:** 5.0.0 · **WordPress:** 6.0+ · **PHP:** 8.0+
**Live deploy dir on server:** `wp-content/themes/matmuja-enertech-v5`
**Predecessor (rollback):** `matmuja-enertech-v4` (dark cinematic + 5 canvases)
```

Leave everything below the top section intact — the build / deploy / customizer sections are version-agnostic.

- [ ] **Step 3: Commit**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git add matmuja-enertech/README.md
git commit -m "docs(theme): update README for v5 Lichtleiter"
```

---

## Task 12: Build deploy zip

**Files:**
- Create: `/home/blerim/Repo/matmuja-enertech-theme/matmuja-enertech-v5.zip`

- [ ] **Step 1: Create the v5 zip with rename to v5 dir**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
rm -f matmuja-enertech-v5.zip

python3 <<'PY'
import os, zipfile, fnmatch

SRC = 'matmuja-enertech'
DEST_DIR = 'matmuja-enertech-v5'
OUT = 'matmuja-enertech-v5.zip'
EXCLUDE = {
    'node_modules', '.git', '.DS_Store',
}

with zipfile.ZipFile(OUT, 'w', zipfile.ZIP_DEFLATED) as z:
    for root, dirs, files in os.walk(SRC):
        dirs[:] = [d for d in dirs if d not in EXCLUDE]
        for f in files:
            if f in EXCLUDE: continue
            full = os.path.join(root, f)
            rel = os.path.relpath(full, SRC)
            arc = os.path.join(DEST_DIR, rel)
            z.write(full, arc)
print(f'Wrote {OUT}')
PY

ls -la matmuja-enertech-v5.zip
unzip -l matmuja-enertech-v5.zip | head -20
```

Expected: zip exists, top-level dir inside zip is `matmuja-enertech-v5/`.

- [ ] **Step 2: Sanity check zip contents**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
unzip -l matmuja-enertech-v5.zip | grep -E "(style.css|theme.json|fiber-diagram|geist-)" | head -10
```

Expected: lines for `style.css`, `theme.json`, `fiber-diagram.js`, and 5 Geist font files all present.

---

## Task 13: Deploy to IONOS

**Files:** (server-side)
- Create: `/wp-content/themes/matmuja-enertech-v5/` (full theme)

**Pre-req:** SSH password `s97UvMXaEKE4nP` (confirmed valid by owner 2026-05-23). Host: `access-5020163956.webspace-host.com`, user `su411687`.

- [ ] **Step 1: Upload the zip via sshpass + sftp**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme

sshpass -p 's97UvMXaEKE4nP' sftp -oStrictHostKeyChecking=no su411687@access-5020163956.webspace-host.com <<'SFTP'
cd matmuja.de/wp-content/themes
put matmuja-enertech-v5.zip
bye
SFTP
```

Expected: `Uploading matmuja-enertech-v5.zip ... 100%`.

- [ ] **Step 2: Unzip on the server**

```bash
sshpass -p 's97UvMXaEKE4nP' ssh -oStrictHostKeyChecking=no su411687@access-5020163956.webspace-host.com \
  'cd matmuja.de/wp-content/themes && unzip -oq matmuja-enertech-v5.zip && rm matmuja-enertech-v5.zip && ls -d matmuja-enertech-v*'
```

Expected output lists at minimum:
```
matmuja-enertech-v1.1.0-final
matmuja-enertech-v2
matmuja-enertech-v3
matmuja-enertech-v4
matmuja-enertech-v5
```

- [ ] **Step 3: Activate v5 via WP-CLI**

```bash
sshpass -p 's97UvMXaEKE4nP' ssh -oStrictHostKeyChecking=no su411687@access-5020163956.webspace-host.com \
  'cd matmuja.de && wp theme activate matmuja-enertech-v5'
```

Expected: `Success: Switched to 'M&M EnerTech' theme.`

- [ ] **Step 4: Verify maintenance gate is still on (do NOT go public yet)**

```bash
sshpass -p 's97UvMXaEKE4nP' ssh -oStrictHostKeyChecking=no su411687@access-5020163956.webspace-host.com \
  'cd matmuja.de && wp option get ionos_essentials_maintenance_mode'
```

Expected: `1`. (If `0`, the public will see v5 immediately — owner has not approved that yet.)

---

## Task 14: Smoke-check the new theme

- [ ] **Step 1: Curl the homepage as an admin-bypass (via Customizer preview URL) or as a logged-in user**

Easiest: render the homepage on the server with WP-CLI:

```bash
sshpass -p 's97UvMXaEKE4nP' ssh -oStrictHostKeyChecking=no su411687@access-5020163956.webspace-host.com \
  'cd matmuja.de && wp eval "echo apply_filters( \"the_content\", \"\" ); echo \"\n---\n\"; \$t = wp_get_theme(); echo \"Active theme: \" . \$t->get(\"Name\") . \" v\" . \$t->get(\"Version\");"'
```

Expected: prints `Active theme: M&M EnerTech v5.0.0`.

- [ ] **Step 2: Check for PHP fatals in error log**

```bash
sshpass -p 's97UvMXaEKE4nP' ssh -oStrictHostKeyChecking=no su411687@access-5020163956.webspace-host.com \
  'tail -50 matmuja.de/wp-content/debug.log 2>/dev/null || echo "no debug.log present"'
```

Expected: no `Fatal error` lines since the activation timestamp.

- [ ] **Step 3: HEAD the homepage to verify HTTP 200**

```bash
curl -sI -A "Mozilla/5.0 (Macintosh; admin-preview)" https://matmuja.de/ | head -10
```

Note: behind maintenance gate, public unauthenticated requests hit the gate page. That's expected. Authenticated admin preview goes through.

- [ ] **Step 4: Rollback rehearsal — verify v4 still activates cleanly (one line, then back to v5)**

```bash
sshpass -p 's97UvMXaEKE4nP' ssh -oStrictHostKeyChecking=no su411687@access-5020163956.webspace-host.com \
  'cd matmuja.de && wp theme activate matmuja-enertech-v4 && wp theme activate matmuja-enertech-v5 && wp theme list --field=name --status=active'
```

Expected: prints `matmuja-enertech-v5` at the end. (We just verified the rollback path works without leaving the site on v4.)

---

## Task 15: Update Obsidian home doc

**Files:**
- Modify: `/mnt/c/Users/Blerimi/Documents/Obsidian Vault/Matmuja/🏠 Matmuja Home.md`

- [ ] **Step 1: Update the "Active state" callout to point at v5**

Use Edit on the home doc to change the active theme dir line from `matmuja-enertech-v4` (Version 4.2, commit aa71e23) to `matmuja-enertech-v5` (Version 5.0.0, current HEAD of `redesign/v5.0-impl`). Add a one-line summary of what changed.

- [ ] **Step 2: Add a "v5 Lichtleiter" section that links to the spec note**

Insert near the "Current design" section: a brief one-paragraph callout describing v5 and a wikilink `[[v5 Lichtleiter — design spec]]` to the mirrored spec.

- [ ] **Step 3: Move the v4 section under a `## Rollback (v4)` heading**

So v5 is now "current design" and v4 is "fallback".

(No commit step — Obsidian vault is outside git.)

---

## Task 16: Push branch and open PR

- [ ] **Step 1: Push branch**

```bash
cd /home/blerim/Repo/matmuja-enertech-theme
git push -u origin redesign/v5.0-impl
```

- [ ] **Step 2: Open PR against master**

```bash
gh pr create --base master --head redesign/v5.0-impl --title "v5 Lichtleiter — engineering-minimal redesign" --body "$(cat <<'EOF'
## Summary

- New engineering-minimal aesthetic (Linear/Tailscale flavour) replacing v4's dark cinematic look
- Single SVG fiber diagram replaces the 5 canvas system
- Single Geist family replaces Inter + Space Grotesk
- Light paper palette + one electric blue + one warm orange
- 7-section structure preserved; Customizer schema unchanged so content carries over

## What stayed the same

- 7-section homepage order
- `mm_*` Customizer field IDs
- Legacy `matmuja_*` Customizer fields (phone, email, address, social — still read by schema markup + footer)
- Deploy model (sibling theme dir; v4 stays as rollback)

## Test plan

- [x] PHP brace balance + JS `node -c` on all changed files
- [x] CSS/JS bundle within budget (≤ 30KB CSS, ≤ 15KB JS)
- [x] Theme activates on IONOS without PHP fatals (verified via WP-CLI)
- [x] v4 still re-activates cleanly (rollback rehearsal in Task 14)
- [ ] Owner reviews v5 in Customizer preview before flipping the maintenance gate

## Rollback

`wp theme activate matmuja-enertech-v4` — v4 dir untouched.
EOF
)"
```

Expected: PR URL printed.

- [ ] **Step 3: Print PR URL for the owner**

```bash
gh pr view --json url --jq .url
```

---

## Done conditions

1. v5 theme dir live on IONOS, activated, behind maintenance gate.
2. v4 dir present and re-activatable on demand.
3. PR open against `master` with the full diff.
4. Obsidian home doc reflects v5 as current.
5. Owner can open Customizer preview and tour all 7 sections; all `mm_*` content carries over; the fiber diagram animates on scroll on desktop and falls back gracefully on `prefers-reduced-motion`.
