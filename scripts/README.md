# Scripts

```
scripts/
└── pipeline/     Active build steps
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
