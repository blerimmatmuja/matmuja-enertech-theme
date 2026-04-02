# Matmuja Tiefbau WordPress Theme

A professional WordPress theme inspired by matmuja.de – Germany's leading fiber optic (Glasfaser) civil engineering company.

## Features

- **Modern Design**: Clean, professional design with dark blue and gold color scheme
- **Responsive**: Mobile-first approach, optimized for all devices
- **Performance**: Optimized CSS/JS, lazy loading, and efficient code
- **Accessibility**: WCAG compliant with proper ARIA labels and keyboard navigation
- **SEO Ready**: Schema markup, clean HTML, and semantic structure
- **Customizable**: Extensive WordPress Customizer options
- **Block Editor Support**: Full theme.json configuration for Gutenberg
- **Multilingual**: Translation ready with .pot file

## Design
- **Primary Color**: Dark Blue (#19197a)
- **Accent Color**: Gold/Orange (#f5a623)
- **Font**: Inter (Google Fonts)
- **Layout**: Full-width, responsive, mobile-first

## Sections (Front Page)
1. Hero – Full-screen dark blue hero with headline and CTA
2. Intro – Gold background with company description
3. Services Timeline – Three service blocks with decorative timeline
4. Komplette Lösungen Banner – Bold blue section
5. News/Blog – 3-column grid of latest posts
6. Why Us – Split layout with feature checklist
7. FAQ – Collapsible accordion
8. CTA – Contact call-to-action box
9. Footer – Dark blue with address, links, social icons

## Installation

1. Upload the `matmuja-tiefbau` folder to `/wp-content/themes/`
   OR upload the ZIP via **Appearance → Themes → Add New → Upload Theme**
2. Activate the theme in **Appearance → Themes**
3. Go to **Appearance → Customize** to configure theme options

## Development

### Prerequisites
- Node.js and npm
- WordPress 6.0+
- PHP 8.0+

### Build Commands
```bash
npm install          # Install dependencies
npm run build        # Build minified assets
npm run dev          # Watch for changes during development
```

### File Structure
```
matmuja-tiefbau/
├── style.css              # Main stylesheet
├── functions.php          # Theme functions and setup
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
│       └── main.js        # Main JavaScript
├── inc/
│   └── template-tags.php  # Helper functions
├── languages/
│   └── matmuja-tiefbau.pot # Translation template
├── theme.json             # Block editor configuration
└── package.json           # Build dependencies
```

## Customization

### Customizer Options
- **Company Information**: Contact details, social media links
- **Hero Section**: Title, subtitle, button text, background image
- **Intro Section**: Company description, call-to-action

### Custom Post Types
- **Services**: Manage service offerings
- **References**: Showcase project references

### Menus
- **Primary Menu**: Main navigation
- **Footer Menu**: Footer links
- **Services Dropdown**: Services submenu

## Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Changelog

### 1.0.0
- Initial release
- Modern CSS with custom properties
- Responsive design
- Accessibility improvements
- Performance optimizations
- Schema markup for SEO

## License
GPL-2.0-or-later

## Credits
- Font: [Inter](https://fonts.google.com/specimen/Inter) by Google Fonts
- Icons: Custom SVG illustrations
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
