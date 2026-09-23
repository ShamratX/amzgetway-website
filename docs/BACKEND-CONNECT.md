# Backend connect status (AmzGetway)

Master backend package is **wired into this site**. No CMS/API features were removed.

## Connected locally

| Item | Status |
|------|--------|
| `export/site/admin/` | Admin UI at `/admin/` |
| `export/site/cms/page-shell.html` | New-page builder shell |
| `export/site/assets/cms.js` | Branding helper |
| `export/site/assets/cms-section-nav.js` | Section nav helper |
| `export/site/assets/amz-api-forms.js` | CF7 forms → `POST /api/contact` |
| `backend/worker/wrangler.toml` | Assets → `../../export/site`, AmzGetway vars |
| `PAGE_ALLOWLIST` | All 51 public HTML pages |
| `ALLOWED_SERVICES` | Original services **kept** + Amazon/Walmart/Newsletter options |
| GitHub publish vars | `GITHUB_REPO=ShamratX/amzgetway-website` (needs `GITHUB_TOKEN` secret) |

## Your Cloudflare steps (required before live)

```powershell
cd backend\worker
npm install
npx wrangler login
npx wrangler d1 create amzgetway-cms-db
# paste database_id into wrangler.toml
npx wrangler d1 migrations apply amzgetway-cms-db --remote
npx wrangler secret put ADMIN_PASSWORD
npx wrangler secret put ADMIN_SECRET
npx wrangler secret put RESEND_API_KEY
# optional:
npx wrangler secret put GITHUB_TOKEN
npm run deploy
```

Then open `https://<worker>.workers.dev/admin/` and test a contact form submit.

Full checklist: `backend/docs/00-setup-checklist.md`
