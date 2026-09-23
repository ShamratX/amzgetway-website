# 05 — Deploy and admin use

## Deploy

```bash
cd worker
npm run deploy
```

Wrangler uploads the Worker code and binds ASSETS from your configured website directory.

### Local preview

```bash
npx wrangler d1 migrations apply YOUR_D1_DATABASE_NAME --local
npm run dev
```

Open the local URL Wrangler prints. Admin: `/admin/`.

## First login

1. Go to `https://YOUR-DOMAIN/admin/`
2. Enter `ADMIN_PASSWORD`
3. You land on the dashboard

If login fails: check the secret was set on the **same** Worker name you deployed, and that `ALLOWED_ORIGINS` includes your origin.

## Admin sections (overview)

| Nav item | Use for |
|----------|---------|
| Dashboard | Quick status |
| Leads | Contact form submissions |
| Posts | Blog posts |
| Pages | Edit page content / create pages / SEO |
| Menus | Primary + footer navigation |
| Settings | Branding and related options |
| Advanced | Lower-level / developer tools |

## Typical first-day setup

1. **Settings** — site name, mark letter, logo URL, favicon URL  
2. **Menus** — add Home, main sections, Contact; assign Primary + Footer locations  
3. **Pages** — open homepage and edit visible text/images  
4. **New page** (if needed) — requires `cms/page-shell.html`  
5. Submit a test lead and confirm it appears under **Leads**

## Creating a new page

1. Admin → Pages → create new  
2. Enter title (slug is generated)  
3. Worker loads `cms/page-shell.html`, injects default Hero section, stores HTML in D1  
4. Public URL is usually `https://YOUR-DOMAIN/{slug}` (clean URL, no `.html`)

Edit sections later from the page builder UI.

## Redeploy when

- You change Worker JS (`worker/src/**`)
- You change `wrangler.toml` vars / routes / assets path
- You change static site files that are served from ASSETS (deploy picks up the folder again)

Secrets alone do **not** require a code deploy after `secret put`, but you may still redeploy for consistency.

## Updating this master later

When you improve `backend_cms_master`, copy only the changed `worker/src`, `admin`, or `docs` files into each client project.  
Never overwrite a live project’s `wrangler.toml` database_id or secrets with the template.
