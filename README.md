# AmzGetway

Static Cloudflare Pages site — mirrored from the local WordPress recovery.

## Preview (localhost)

**Must run from `export\site`** (project root e chalale directory listing ashbe).

Terminal 1 — server:

```powershell
cd "D:\Desktop\Important files\amzgetway\export\site"
python -m http.server 8090
```

Terminal 2 — open browser:

```powershell
Start-Process "http://127.0.0.1:8090/"
```

Hard refresh: Ctrl+Shift+R.

| Preview | URL |
|---------|-----|
| Local static | http://127.0.0.1:8090/ |
| Source WP | http://127.0.0.1:8080/ |

## Live site (Cloudflare)

```powershell
# Open live site in browser
Start-Process "https://amzgetway.com"

# Admin CMS
Start-Process "https://amzgetway.com/admin/"
```

| Live | URL |
|------|-----|
| Website | https://amzgetway.com |
| Admin | https://amzgetway.com/admin/ |
| Workers.dev (fallback) | Cloudflare → Workers → **amzgetway-cms** → Visit |

## Deploy (Worker + site)

```powershell
cd backend\worker
npm run deploy
Start-Process "https://amzgetway.com"
```

## Resend (form emails)

1. Verify domain **amzgetway.com** at [resend.com](https://resend.com)
2. Create API key, then:

```powershell
cd "D:\Desktop\Important files\amzgetway\backend\worker"
npx wrangler secret put RESEND_API_KEY
npm run deploy
```

Inbox: `contact@amzgetway.com` · From: `AMZgetway <contact@amzgetway.com>`  
(Details: `docs/BACKEND-CONNECT.md`)

## Project layout

```
amzgetway/
├── README.md
├── .gitignore
├── docs/                 Plan + audits
├── export/
│   ├── url-list.txt
│   └── site/             ← static site (Cloudflare assets)
├── backend/              ← master-backend (Worker + Admin CMS)
│   ├── worker/           API + D1
│   ├── admin/            /admin UI (copy/serve with site)
│   ├── docs/             setup guides
│   └── site-helpers/     optional CMS JS
├── scripts/
│   ├── pipeline/
│   ├── tools/
│   └── archive/
└── qa/
```

## Backend

Reusable package from [master-backend-for-every-frontend](https://github.com/ShamratX/master-backend-for-every-frontend).

**Connected** — admin, CMS shell, form bridge, wrangler assets.  
Setup notes: **`docs/BACKEND-CONNECT.md`**.

## Rebuild pipeline (optional)

From `scripts/pipeline/` (needs local WP on `:8080`):

1. `collect-urls.ps1`
2. `mirror.ps1`
3. `postprocess.ps1`
4. `qa.ps1` → writes `qa/report.txt`

See `scripts/README.md`.

## Notes

- Contact forms post to Worker `/api/contact` (leads in Admin).
- Content is from the Softaculous backup used for recovery.
