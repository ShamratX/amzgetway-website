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

## Resend (contact email)

`wrangler.toml` already has:

- `RECIPIENT_EMAIL` = `contact@amzgetway.com` (inbox)
- `SENDER_EMAIL` = `AMZgetway <contact@amzgetway.com>` (must be on a **verified** Resend domain)

### Steps

1. [resend.com](https://resend.com) → Domains → add/verify **amzgetway.com**
2. API Keys → create key
3. Run:

```powershell
cd "D:\Desktop\Important files\amzgetway\backend\worker"
npx wrangler secret put RESEND_API_KEY
npm run deploy
```

4. Test a contact form on the live site → email should arrive + lead in `/admin`

Without the secret, leads still save in D1; email is skipped.

## Cloudflare checklist (already mostly done)

```powershell
cd backend\worker
npx wrangler secret put ADMIN_PASSWORD
npx wrangler secret put ADMIN_SECRET
npx wrangler secret put RESEND_API_KEY
npm run deploy
```

Full package docs: `backend/docs/03-secrets-and-email.md`
