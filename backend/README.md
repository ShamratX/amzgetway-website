# Backend CMS Master

Reusable **Cloudflare Worker + Admin CMS** package. Copy this folder into any static HTML website project, fill in config, deploy — no client branding baked in.

This package is **generic**. It does not include a finished website design. You bring your own HTML/CSS/JS.

---

## What you get

| Folder | Purpose |
|--------|---------|
| `worker/` | Cloudflare Worker (API, D1 CMS, contact/leads, serve site assets) |
| `admin/` | Password-protected admin UI (`/admin`) |
| `site-helpers/` | Optional JS + example page shell for your public site |
| `docs/` | Step-by-step setup guides (English) |

---

## What this CMS can do

- Edit site **branding** (name, logo, favicon)
- Edit **menus** (header / footer)
- Edit **page text & images** on HTML that uses `data-cms` hooks (or auto-scanned fields)
- Create **new pages** with a section builder (needs a page shell HTML file)
- Manage **blog posts** and **contact form leads**
- Send lead emails via **Resend** (optional)
- Optional publish/images via **GitHub** (optional)

---

## Recommended project layout

Put this package **next to** (or inside) your website root. Example:

```text
my-website/                 ← your HTML site root (index.html, assets/, …)
  index.html
  assets/
  cms/
    page-shell.html         ← required for “New page” builder (copy from site-helpers)
  admin/                    ← copy from this package’s admin/
  backend/
    worker/                 ← copy from this package’s worker/
```

Or keep the whole master folder and point `[assets] directory` in `wrangler.toml` at your site root.

---

## Quick start (checklist)

Do these **in order**. Details are in `docs/`.

1. [ ] Copy `worker/` and `admin/` into your project (see layout above)
2. [ ] Install Node.js 18+, then in `worker/`: `npm install`
3. [ ] Log in to Cloudflare: `npx wrangler login`
4. [ ] Create D1 database → paste `database_id` into `worker/wrangler.toml`
5. [ ] Set Worker `name`, `routes` / domain, `[assets] directory`, emails, `PUBLIC_SITE_URL`, `ALLOWED_ORIGINS`
6. [ ] Run D1 migrations (remote)
7. [ ] Set secrets: `ADMIN_PASSWORD`, `ADMIN_SECRET`, and optionally `RESEND_API_KEY`
8. [ ] Copy `admin/` so it is served at `/admin` from your site root
9. [ ] Copy page shell → `cms/page-shell.html` on the site
10. [ ] Optionally add `site-helpers/cms.js` and `cms-section-nav.js` to your site assets
11. [ ] `npm run deploy` from `worker/`
12. [ ] Open `https://YOUR-DOMAIN/admin`, sign in, set branding + menus

Full walkthrough: **[docs/00-setup-checklist.md](docs/00-setup-checklist.md)**

---

## Docs index

| Doc | Read when… |
|-----|------------|
| [00-setup-checklist.md](docs/00-setup-checklist.md) | First install on a new project |
| [01-cloudflare-and-d1.md](docs/01-cloudflare-and-d1.md) | Creating the Worker + D1 database |
| [02-wrangler-config.md](docs/02-wrangler-config.md) | Filling `wrangler.toml` correctly |
| [03-secrets-and-email.md](docs/03-secrets-and-email.md) | Admin password + Resend email |
| [04-connect-your-website.md](docs/04-connect-your-website.md) | HTML hooks, admin folder, page shell |
| [05-deploy-and-admin.md](docs/05-deploy-and-admin.md) | Deploy + day-to-day admin use |
| [06-troubleshooting.md](docs/06-troubleshooting.md) | Common errors and fixes |

---

## Important rules

1. **One Worker per website.** Do not reuse another site’s `database_id` or secrets.
2. **Never commit real secrets** into `wrangler.toml`. Use `wrangler secret put`.
3. **`PUBLIC_SITE_URL`** must match your live `https://` domain (no trailing slash).
4. **`PAGE_ALLOWLIST`** in `worker/src/index.js` must list your **static** HTML files. CMS-created pages stay in D1 — do not put them on that list.
5. New builder pages need **`cms/page-shell.html`** in the website assets (see `site-helpers/page-shell.example.html`).

---

## Local development

```bash
cd worker
npm install
npx wrangler d1 migrations apply YOUR_D1_DATABASE_NAME --local
npm run dev
```

Then open the printed `localhost` URL. Admin: `/admin`.

---

## License / reuse

Use this as a master template for client projects. Replace placeholders (`example.com`, emails, Worker name) every time.
