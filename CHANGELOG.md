# Changelog

All notable changes to the M&M Enfaser WordPress theme.

The authoritative version number is the `Version:` header in
`matmuja-enertech/style.css` — that is the value WordPress itself reads. This
file records what changed in each of those versions.

Versions before 6.0.0 predate this changelog; see `git log` for their history.

## [6.0.1] - 2026-09-12

### Added
- Prose styling for `page.php`, so plain WordPress pages (Impressum,
  Datenschutzerklärung) render in the v6 identity instead of falling back to
  unstyled markup. Covers headings, lists, links, `address`, and a `legal-meta`
  line for the small print.

### Fixed
- Navigation and footer section links now work from subpages. `#process`,
  `#team`, `#faq`, and `#cta` previously pointed at anchors that only exist on
  the front page, so clicking them from `/impressum` went nowhere. They now
  resolve to `home_url('/#…')` when the visitor is not on the front page.
- `page.php` used a `.container` wrapper that no longer exists in the v6
  stylesheet; switched to the v6 `.shell` wrapper so page content is actually
  constrained and padded.

### Changed
- Homepage copy aligned with the registered Geschäftszweck: pure Glasfaser- and
  TK-Dienstleistung, with Tiefbau removed from the hero, mission, process
  phases, team, FAQ, footer, and schema markup. Tagline is now "Von der Planung
  bis zur Buchse". (2026-07-15)
- Proof section reworked from invented track-record numbers to honest
  capability tiles for a pre-launch firm — `2 INGENIEURE · 5 PHASEN · DIN
  KONFORM · 0 € ERSTBERATUNG`. The previous figures were a UWG §5 risk.
  (2026-07-14)

## [6.0.0] - 2026-07-12

### Changed
- Rebranded M&M EnerTech to **M&M Enfaser** with a new dark
  "light-through-fiber" identity: deep-indigo base with a lavender → violet →
  gold gradient taken from the new logo.
- Hero carries an animated fiber strand; the process section is a horizontal
  SVG path with five stations and a travelling gold pulse, degrading to a
  vertical gradient-rail timeline on mobile.
- Committed to a dark-only palette. Geist and Geist Mono remain self-hosted
  (no external font requests, GDPR-safe).
- The seven-section front-page structure is unchanged and is treated as fixed.
