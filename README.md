# AmzGetway

Static Cloudflare Pages site — mirrored from the local WordPress recovery.

## Preview (localhost)

```powershell
cd export\site
python -m http.server 8090
```

Open **http://127.0.0.1:8090/** (hard refresh: Ctrl+Shift+R).

| Preview | URL |
|---------|-----|
| Static (deploy this) | http://127.0.0.1:8090/ |
| Source WP | http://127.0.0.1:8080/ |

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

**Connected to this site** (admin, CMS shell, form bridge, wrangler assets).  
Features kept; Cloudflare D1 + secrets + deploy still needed — see **`docs/BACKEND-CONNECT.md`**.

## Deploy

After visual sign-off on `:8090`, upload **`export/site`** to Cloudflare Pages (Direct Upload).

## Rebuild pipeline (optional)

From `scripts/pipeline/` (needs local WP on `:8080`):

1. `collect-urls.ps1`
2. `mirror.ps1`
3. `postprocess.ps1`
4. `qa.ps1` → writes `qa/report.txt`

See `docs/PLAN.md` and `scripts/README.md`.

## Notes

- Contact forms are visual only on Pages (no PHP). Wire Formspree/Worker later if needed.
- Content is from the Softaculous backup used for recovery.
