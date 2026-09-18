# M&M Enfaser — WordPress Theme

WordPress theme for **M&M Enfaser** (matmuja.de), a German FTTH / Glasfaser- and
TK-Dienstleistung firm in Augsburg.

> This file exists so sessions in this repo don't inherit the Begleiter
> `CLAUDE.md` one directory up. This is a **PHP WordPress theme**, not a
> Python/FastAPI project.

---

## Stack and layout

```
matmuja-enertech/          # the theme itself — this is what gets deployed
├── style.css              # AUTHORITATIVE version number (Version: header)
├── functions.php          # Customizer fields, schema markup
├── header.php footer.php
├── front-page.php         # the 7-section homepage
├── page.php               # plain pages (Impressum, Datenschutz)
└── assets/                # self-hosted Geist fonts, js
```

`package.json` exists **only** to run the PostCSS/Terser build. Its `name`,
`version`, and `author` fields are stale (they still say "tiefbau" and
"EnerTech UG") and are not the source of truth for anything.

## Version

The `Version:` header in `matmuja-enertech/style.css` is the single
authoritative version — it is what WordPress reads. Bump it by hand, then
record the change in `CHANGELOG.md`. This repo deliberately has **no** `VERSION`
file: a second version number would just drift from the one WordPress uses.

## Commands

```bash
# Build minified assets (both outputs are gitignored)
npm run build

# Deploy: rsync the theme dir, then activate
rsync -az --delete matmuja-enertech/ matmuja:~/public/wp-content/themes/matmuja-enertech-v6/
ssh matmuja "cd ~/public && wp theme activate matmuja-enertech-v6"

# Rollback (previous version dirs are kept on the server for exactly this)
ssh matmuja "cd ~/public && wp theme activate matmuja-enertech-v5"

# Maintenance gate: 1 = redirect / → /maintenance, 0 = public
ssh matmuja "cd ~/public && wp option update ionos_essentials_maintenance_mode 0"
```

Server access is the key-based **`matmuja` SSH alias**. Never ask for or store
the SSH password.

## Local environment constraints (WSL)

- **No PHP CLI.** `php -l` is unavailable. Sanity-check templates by balancing
  braces/parens with `node`, and never claim a template change is verified.
- **No `zip` CLI.** Use `python3 -m zipfile` to produce upload archives.
- Build artifacts `style.min.css` and `assets/js/main.min.js` are gitignored —
  running `npm run build` should leave `git status` clean.

## Locked decisions — do not relitigate

- **The 7-section front-page order is fixed:** Hero → Mission strip → FTTH
  5-phase timeline → Über uns/Team → Proof → FAQ → CTA strip. Redesigns swap
  visuals, palette, and copy *inside* sections. If asked to add or reorder a
  section, push back and confirm it is really intended.
- **Do not reintroduce Tiefbau or Spaten** anywhere — copy, phases, schema, or
  Customizer defaults. The registered Geschäftszweck is pure Glasfaser-/TK-
  Dienstleistung, and mentioning Tiefbau contradicts the business registration.
- **Dark-only identity.** Indigo base with a lavender → violet → gold gradient.
- **No external font or asset requests.** Geist and Geist Mono are self-hosted
  for GDPR reasons; an external Google Fonts `@import` is a defect, not a
  convenience.
- Proof-section figures must describe real capability, never invented track
  record (UWG §5 risk).

## Content that lives on the server, not in this repo

Impressum (post 45) and Datenschutzerklärung (post 46) are WordPress pages. The
theme styles them via `page.php` and `.page-content`, but their text lives in
the WordPress database. A CSS rule such as `.legal-meta` only takes effect if
the post body carries that class — it cannot be verified from this repo.

## Customizer

Fields use the `mm_*` prefix (hero, mission, the five `mm_phase_{1..5}_*`
groups, proof, FAQ, CTA). Legacy `matmuja_*` fields (phone, email, address,
social URLs) are still read by `matmuja_schema_markup()` and `footer.php` —
keep them.

## Skill routing

When the user's request matches an available skill, invoke it via the Skill tool. When in doubt, invoke the skill.

Key routing rules:
- Product ideas/brainstorming → invoke /office-hours
- Strategy/scope → invoke /plan-ceo-review
- Architecture → invoke /plan-eng-review
- Design system/plan review → invoke /design-consultation or /plan-design-review
- Full review pipeline → invoke /autoplan
- Bugs/errors → invoke /investigate
- QA/testing site behavior → invoke /qa or /qa-only
- Code review/diff check → invoke /review
- Visual polish → invoke /design-review
- Ship/deploy/PR → invoke /ship or /land-and-deploy
- Save progress → invoke /context-save
- Resume context → invoke /context-restore
- Author a backlog-ready spec/issue → invoke /spec
