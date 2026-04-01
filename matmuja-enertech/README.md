# Matmuja Tiefbau WordPress Theme

A professional WordPress theme inspired by matmuja.de – Germany's leading fiber optic (Glasfaser) civil engineering company.

## Design
- **Primary Color**: Dark Blue (#19197a)
- **Accent Color**: Gold/Orange (#f5a623)
- **Font**: Inter (loaded from Google Fonts)
- **Layout**: Full-width, responsive, mobile-first

## Sections (Front Page)
1. Hero – Full-screen dark blue hero with headline and CTA
2. Intro – Gold background with company description
3. Services Timeline – Three service blocks with decorative timeline
4. Full-Turnkey Banner – Bold blue section
5. News/Blog – 3-column grid of latest posts
6. Why Us – Split layout with feature checklist
7. FAQ – Collapsible accordion
8. CTA – Contact call-to-action box
9. Footer – Dark blue with address, links, social icons

## Files
```
matmuja-tiefbau/
├── style.css              # Theme header + all CSS
├── functions.php          # Theme setup, CPTs, customizer
├── front-page.php         # Homepage template
├── index.php              # Blog/archive listing
├── single.php             # Single post
├── page.php               # Static page
├── archive.php            # Category/tag archives
├── 404.php                # 404 error page
├── search.php             # Search results
├── header.php             # Site header & navbar
├── footer.php             # Site footer
├── sidebar.php            # Sidebar template
├── comments.php           # Comments template
├── assets/
│   └── js/
│       └── main.js        # Vanilla JS (nav, FAQ, scroll reveal)
├── inc/
│   └── template-tags.php  # Helper functions
└── languages/
    └── matmuja-tiefbau.pot  # Translation template
```

## Installation
1. Upload the `matmuja-tiefbau` folder to `/wp-content/themes/`
   OR upload the ZIP via **Appearance → Themes → Add New → Upload Theme**
2. Activate the theme in **Appearance → Themes**
3. Go to **Appearance → Menus** to set up navigation
4. Go to **Appearance → Customize** to configure:
   - Company phone, email, and address
   - Hero section text and image
   - Instagram / LinkedIn URLs
5. Set your front page: **Settings → Reading → A static page → Front page**

## Custom Post Types
- **Services** (`/dienstleistungen`) – individual service pages
- **References** (`/referenzen`) – client reference cards

## Customizer Options
All configurable under **Appearance → Customize**:
- Company Information (phone, email, address, social links)
- Hero Section (eyebrow, title, button text/URL, background image)

## Requirements
- WordPress 6.0+
- PHP 8.0+
