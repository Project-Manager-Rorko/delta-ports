# Delta Ports — Gutenberg Block Theme

## Requirements met

- **No PHP/HTML static page content** — all pages seeded into `post_content` as Gutenberg blocks
- **Geist** font on all headings & paragraphs (`font-family: "geist", sans-serif !important`)
- **Source-matched colors** (`#1A1A2E`, `#F5F5F5`, `#EC2633`, etc.)
- **All 11 pages + 3 posts** with section inventory
- **Page speed** — self-hosted woff2, deferred JS, lazy images, no Elementor
- **SEO** — Yoast SEO plugin + meta titles/descriptions on seed

## Start the site

1. Open **Local** app
2. Start site **delta-ports** (domain: `delta-ports.local`)
3. In wp-admin: **Appearance → Themes → activate “Delta Ports”**
4. **Tools → Delta Ports Seed → Run Seed** (check “Force overwrite” once)
5. **Plugins → activate** Contact Form 7 + Yoast SEO
6. Edit any page under **Pages** — Block Editor

## Admin

- Local one-click admin user: `radmin` (as configured in Local)
- Seed: Tools → Delta Ports Seed

## Source (read-only)

https://vipaccounts.org/delta-ports — never modified.
