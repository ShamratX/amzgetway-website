# 06 — Troubleshooting

## Site shows 404 everywhere

- `[assets] directory` in `wrangler.toml` is wrong (must point at folder containing `index.html`)
- You deployed from the wrong folder
- Custom domain not attached to this Worker

## `/admin` is 404 or blank

- `admin/` folder is not inside the ASSETS site root
- Wrong path: need `/admin/` or `/admin/index.html`

## Login fails / “unauthorized”

- `ADMIN_PASSWORD` secret not set, or set on a different Worker
- `ADMIN_SECRET` missing
- Browser blocked the request (CORS): add your exact origin to `ALLOWED_ORIGINS` (include `https://`, no path)
- Mixed content: site on https but API called on http

## CORS errors in browser console

`ALLOWED_ORIGINS` must include the exact origin, examples:

```text
https://example.com,https://www.example.com,http://127.0.0.1:8787
```

No trailing slash on origins.

## New page create fails (“Could not load page shell”)

- Missing `cms/page-shell.html` in the website ASSETS root
- Or `PAGE_SHELL_PATH` in `worker/src/index.js` does not match the real file path

## Contact form returns validation error

- `service` value not in `ALLOWED_SERVICES`
- Required fields missing (`clientName`, `email`, …)
- Rate limiting (wait and retry)

## Email not arriving

- `RESEND_API_KEY` not set
- `SENDER_EMAIL` domain not verified in Resend
- Check Worker logs for Resend API errors
- Lead may still be saved under Admin → Leads

## CMS text not updating on the live page

- Hard refresh / cache (edge `s-maxage` is short, but browsers may cache)
- Element missing `data-cms` / wrong `data-cms-page`
- You edited a different page path than the one being viewed
- Deploy/ASSETS serving an old copy (redeploy)

## www does not redirect to apex

- Set `PUBLIC_SITE_URL` to the apex URL, e.g. `https://example.com`
- Both hostnames must hit this Worker

## D1 errors / missing tables

```bash
npx wrangler d1 migrations apply YOUR_D1_DATABASE_NAME --remote
```

Confirm `database_id` matches the database you migrated.

## “View” opens wrong domain in admin

Set before admin scripts:

```html
<script>window.CMS_SITE_ORIGIN = "https://your-domain.com";</script>
```

## Still stuck

1. Confirm `npx wrangler whoami`
2. Confirm Worker name in dashboard matches `wrangler.toml` `name`
3. Read the failing network request URL + status in DevTools
4. Check Cloudflare Worker logs for the same timestamp
