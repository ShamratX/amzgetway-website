# PROJECT_BRAIN — master-backend-for-every-frontend

## Purpose

Brand-agnostic Cloudflare CMS kit that can be copied beside any static frontend.

## Architecture

- Worker (`worker/src/index.js`): public + admin APIs, asset serving, D1 binding `DB`
- Admin static UI under `admin/`
- Optional helpers in `site-helpers/`
- Long-form English docs in `docs/`

## Public vs admin surfaces

- Public examples: contact POST, posts GET, cms GET
- Admin: login, CMS mutations, leads, posts, pages, media, publish

## Config / secrets (names)

Vars: `ALLOWED_ORIGINS`, `PUBLIC_SITE_URL`, `RECIPIENT_EMAIL`, `SENDER_EMAIL`, optional GitHub repo/branch  
Secrets: `ADMIN_PASSWORD`, `ADMIN_SECRET`, optional `RESEND_API_KEY`, `GITHUB_TOKEN`

## Gotchas

- Keep `PUBLIC_SITE_URL` exact (https, no trailing slash)
- Page builder needs `cms/page-shell.html`
- Migrations must be applied remote before production admin use
