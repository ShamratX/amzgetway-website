# 01 — Cloudflare and D1

## What you need

- Cloudflare account
- Domain (optional for first test; `workers.dev` works)
- Wrangler CLI (installed via `npm install` inside `worker/`)

## Login

```bash
cd worker
npm install
npx wrangler login
```

A browser window opens. Approve access.

## Create a D1 database

Each website needs its **own** database.

```bash
npx wrangler d1 create my_site_cms
```

Example output:

```text
[[d1_databases]]
binding = "DB"
database_name = "my_site_cms"
database_id = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
```

Copy that block into `wrangler.toml` (this package already has a placeholder — replace the values).

## Apply migrations

Migrations live in `worker/migrations/`. They create tables for leads, posts, pages HTML, media, and the site CMS document.

**Remote (production):**

```bash
npx wrangler d1 migrations apply my_site_cms --remote
```

**Local (for `wrangler dev`):**

```bash
npx wrangler d1 migrations apply my_site_cms --local
```

Run these again only when you add new migration files.

## Bindings this Worker expects

| Binding / var | Role |
|---------------|------|
| `DB` | D1 database |
| `ASSETS` | Static website files (from `[assets] directory`) |
| Secrets | `ADMIN_PASSWORD`, `ADMIN_SECRET`, optional `RESEND_API_KEY`, optional `GITHUB_TOKEN` |

Without `ASSETS`, the Worker cannot serve HTML or build new pages from a shell.

## Custom domain

In Cloudflare Dashboard → Workers & Pages → your Worker → Triggers / Domains:

- Attach `your-domain.com` and `www.your-domain.com`, **or**
- Set `routes` in `wrangler.toml` (see next doc).

The Worker uses `PUBLIC_SITE_URL` to decide apex host. If that is `https://example.com`, requests to `www.example.com` redirect to the apex.
