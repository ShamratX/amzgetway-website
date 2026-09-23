# 02 — wrangler.toml (fill carefully)

File: `worker/wrangler.toml`

This file is a **template**. Every new project must change the placeholders.

## Fields you must set

### `name`

Cloudflare Worker name (lowercase, no spaces). Example: `acme-cms`.

### `routes`

Uncomment and set your domains:

```toml
routes = [
  { pattern = "example.com", custom_domain = true },
  { pattern = "www.example.com", custom_domain = true },
]
```

For early testing you can leave `routes = []` and use the `*.workers.dev` URL (`workers_dev = true`).

### `[assets] directory`

Path to the **website root** (folder that contains `index.html` and `admin/`), relative to the `worker/` folder.

Examples:

| Worker location | Site root | `directory` value |
|-----------------|-----------|-------------------|
| `my-site/backend/worker` | `my-site/` | `"../.."` |
| `my-site/worker` | `my-site/` | `".."` |

Wrong path = 404 on every page.

### `[[d1_databases]]`

- `database_name` — exact name from `wrangler d1 create`
- `database_id` — UUID from create output
- `binding = "DB"` — do not rename (code expects `env.DB`)
- `migrations_dir = "migrations"` — keep as is

### `[vars]`

| Variable | Meaning |
|----------|---------|
| `ALLOWED_ORIGINS` | Comma-separated browser origins allowed to call the API. Include `https://your-domain.com` and local preview URLs. |
| `PUBLIC_SITE_URL` | Canonical site URL, **https**, **no trailing slash**. Used for emails, OG images, www→apex redirect, URL cleanup. |
| `RECIPIENT_EMAIL` | Inbox for contact form notifications |
| `SENDER_EMAIL` | Resend “from” line, e.g. `My Site <hello@example.com>` |

Optional:

```toml
GITHUB_REPO = "org/repo"
GITHUB_BRANCH = "main"
```

## What must NOT go in wrangler.toml

Do **not** put these in the file:

- `ADMIN_PASSWORD`
- `ADMIN_SECRET`
- `RESEND_API_KEY`
- `GITHUB_TOKEN`

Use secrets instead (next doc).

## After editing

Always redeploy:

```bash
cd worker
npm run deploy
```

Vars update on deploy. Secrets update when you `secret put` (no code change needed).
