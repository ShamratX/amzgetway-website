# Scripts

```
scripts/
├── pipeline/     Active build steps
├── tools/        Image generators
└── archive/      Old one-off patches (already applied to the site)
```

## Pipeline

Run from repo root, or `cd scripts\pipeline` then execute:

| Script | Purpose |
|--------|---------|
| `collect-urls.ps1` | Build `export/url-list.txt` |
| `mirror.ps1` | Crawl + sync into `export/site` |
| `postprocess.ps1` | Host rewrite + static fixes |
| `qa.ps1` | Smoke checks → `qa/report.txt` |

Needs local WordPress on `http://127.0.0.1:8080/`.

## Tools

Python generators under `tools/` write into `export/site/wp-content/uploads/`.

## Archive

Historical patches only. Do not re-run unless you regenerated a fresh mirror and need the same fixes again.
