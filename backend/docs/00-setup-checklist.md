# 00 — Setup checklist (new project)

Follow this list once per website. Tick every box before calling the site “done”.

## A. Prepare folders

1. [ ] Create or open your **website root** (the folder that contains `index.html`).
2. [ ] Copy this package’s `admin/` folder into the website root so URLs work as `/admin/`, `/admin/app.html`.
3. [ ] Copy this package’s `worker/` folder somewhere reachable (example: `backend/worker/`).
4. [ ] Copy `site-helpers/page-shell.example.html` → website `cms/page-shell.html`, then paste your real header/footer into that shell.
5. [ ] (Optional) Copy `site-helpers/cms.js` and `cms-section-nav.js` into your site’s `/assets/` and include them in HTML.

## B. Cloudflare account

6. [ ] You have a Cloudflare account with Workers enabled.
7. [ ] Domain DNS is on Cloudflare (or you will use `*.workers.dev` for testing).
8. [ ] Node.js 18+ installed on your computer.
9. [ ] In `worker/`: run `npm install`, then `npx wrangler login`.

## C. Database

10. [ ] Create D1: `npx wrangler d1 create YOUR_D1_DATABASE_NAME`
11. [ ] Paste the printed `database_id` into `wrangler.toml` → `[[d1_databases]]`
12. [ ] Set `database_name` to the same name you created.
13. [ ] Apply migrations remotely:
    ```bash
    npx wrangler d1 migrations apply YOUR_D1_DATABASE_NAME --remote
    ```

## D. Config file (`wrangler.toml`)

14. [ ] Set `name` (Worker name, lowercase).
15. [ ] Set `[assets] directory` to your **website root** (relative to the `worker/` folder).
16. [ ] Set `routes` / custom domain for your live hostnames.
17. [ ] Set `PUBLIC_SITE_URL` = `https://your-domain.com` (no trailing slash).
18. [ ] Set `ALLOWED_ORIGINS` to include your live origin and local preview origins.
19. [ ] Set `RECIPIENT_EMAIL` and `SENDER_EMAIL`.

See [02-wrangler-config.md](02-wrangler-config.md).

## E. Secrets

20. [ ] `npx wrangler secret put ADMIN_PASSWORD`
21. [ ] `npx wrangler secret put ADMIN_SECRET` (long random string)
22. [ ] (Optional) `npx wrangler secret put RESEND_API_KEY`
23. [ ] (Optional) GitHub token/vars if you use media publish features

See [03-secrets-and-email.md](03-secrets-and-email.md).

## F. Code tweaks for THIS site

24. [ ] Update `PAGE_ALLOWLIST` in `worker/src/index.js` to match your static HTML files.
25. [ ] Update `ALLOWED_SERVICES` if your contact form uses different service names.
26. [ ] Confirm `PAGE_SHELL_PATH` is `cms/page-shell.html` (or change both the constant and the file).

## G. Deploy and test

27. [ ] From `worker/`: `npm run deploy`
28. [ ] Visit `https://your-domain.com/` — homepage loads.
29. [ ] Visit `https://your-domain.com/admin/` — login works with `ADMIN_PASSWORD`.
30. [ ] In Admin → Site CMS: open **Branding** / **Footer** once (footer/tagline/contact auto-fill from your HTML classes).
31. [ ] In Admin → Menus: build Primary + Footer menus (or keep seeded menus).
32. [ ] Submit a test contact form (if you use `/api/contact`) and confirm a lead appears.
33. [ ] Create a test CMS page and open its public URL.

If something fails → [06-troubleshooting.md](06-troubleshooting.md).
