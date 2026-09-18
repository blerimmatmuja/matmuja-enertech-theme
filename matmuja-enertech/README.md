# M&M Enfaser — v6 "light-through-fiber"

Dark, distinctive WordPress theme for **M&M Enfaser**, a German Glasfaser- and
TK-Dienstleistung firm in Augsburg. Deep-indigo identity with a lavender →
violet → gold signature taken from the company logo: an animated strand in the
hero, and a 5-station process path that a light pulse travels from planning to
the active socket.

**Version:** 6.0.1 · **WordPress:** 6.0+ · **PHP:** 8.0+
**Live deploy dir on server:** `wp-content/themes/matmuja-enertech-v6`
**Predecessor (rollback):** `matmuja-enertech-v5` (light paper "Lichtleiter")

> **Scope note:** this theme describes a pure Glasfaser-/TK-Dienstleistung. The
> business registration deliberately excludes Tiefbau, so Tiefbau and Spaten
> must not appear in copy, process phases, schema markup, or Customizer
> defaults.

## Design

- **Palette (dark only):** base indigo `#13102B` · deep `#0C0A1E` · raised
  `#1B1740` · hairline `#2A2550` · text `#F3F0FB` · muted `#928DB5` · faint
  `#6A6592`.
- **Brand gradient:** `linear-gradient(100deg, #B3A6F7, #8B7BF0 52%, #E6C25E)`
  — lavender → violet → gold.
- **Typography:** Geist + Geist Mono only, self-hosted under `assets/fonts/`
  (five woff2 files). No external font requests — this is a GDPR requirement,
  not a preference.
- **Motion:** tight budget. Reveal fade-up on section entry, the hero strand
  animation, and the process light pulse. Everything collapses to static under
  `prefers-reduced-motion: reduce`.

## Homepage sections (`front-page.php`)

The seven-section order is fixed. Redesigns change visuals, palette, and copy
*inside* sections; they do not reorder, add, or remove them.

1. `#hero` — eyebrow, gradient h1, two CTAs, animated fiber strand figure
2. `#mission` — slim dark band with a large quote
3. `#process` — the 5-phase fiber path (see below)
4. `#team` — intro plus two engineer cards
5. `#proof` — capability tiles plus client strip
6. `#faq` — `<details>` accordion
7. `#cta` — closing gradient CTA strip

The five FTTH phases are **Planung & Koordination → Verlegung → Montage →
Spleißen & Messung → Hausanschluss (APL)**.

Proof tiles describe real capability rather than track record. Invented figures
are a UWG §5 risk for a pre-launch firm and were removed on purpose.

## Plain pages (`page.php`)

Impressum and Datenschutzerklärung use `page.php`, wrapped in `.shell` and
styled by the `.page-content` prose rules in `style.css`. Their text lives in
the WordPress database, not in this repo — a rule such as `.legal-meta` only
takes effect if the post body carries that class.

Header and footer section links resolve to `home_url('/#…')` when the visitor
is not on the front page, so `#process` / `#team` / `#faq` / `#cta` still work
from a subpage.

## Fiber diagram (`assets/js/fiber-diagram.js`)

Enqueued on `is_front_page()` only. Reads the SVG `<path>`'s
`getTotalLength()`, follows scroll via `requestAnimationFrame`, draws the path
by reducing `stroke-dashoffset`, places a travelling glow via
`getPointAtLength()`, and lights the five station markers in sequence.
Reduced-motion users skip the loop; CSS shows all five stations lit.

On narrow viewports the horizontal path is hidden and the phases render as a
vertical gradient-rail timeline with a descending pulse.

## Customizer

Front-page copy is editable through the theme's Customizer settings, including
the five `mm_phase_{1..5}_title` / `_desc` pairs and the client logo slots.
Legacy `matmuja_*` settings (phone, email, address, social URLs) are still read
by `matmuja_schema_markup()` and `footer.php` — keep them.

## Build

```bash
npm install
npm run build   # writes style.min.css and assets/js/main.min.js
```

Both outputs are gitignored; a clean checkout plus `npm run build` should leave
`git status` empty.

## Deploy

```bash
rsync -az --delete matmuja-enertech/ matmuja:~/public/wp-content/themes/matmuja-enertech-v6/
ssh matmuja "cd ~/public && wp theme activate matmuja-enertech-v6"
```

Previous version directories stay on the server as instant rollback. The site
sits behind the `ionos_essentials_maintenance_mode` option (1 = maintenance,
0 = public).

## Version history

- **6.0.1** — Prose styles for plain pages; section links fixed on subpages.
- **6.0.0** — Rebrand M&M EnerTech → M&M Enfaser. Dark indigo identity with the
  light-through-fiber gradient; Tiefbau removed from the registered scope.
- 5.0.0 — "Lichtleiter": light paper aesthetic, scroll-linked SVG fiber path.
- 4.0.0 — Dark cinematic with animated phase canvases (see
  `docs/superpowers/specs/2026-05-20-matmuja-fiber-v4-design.md`).
- 3.0.0 — Lime + indigo FTTH redesign. Too cold/2D — superseded by 4.0.
- 2.0.0 — Navy + gold hybrid palette. Wrong content (energy tech).
- 1.2.0 — Media support for service phase images.
- 1.1.0 — Modernized terminology.
- 1.0.0 — Initial fiber-optic-focused release.
