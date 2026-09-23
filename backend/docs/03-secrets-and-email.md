# 03 — Secrets and email

Run these from the `worker/` folder while logged in with Wrangler.

## Required secrets

### Admin password

```bash
npx wrangler secret put ADMIN_PASSWORD
```

Type a strong password when prompted. This is what you type on `/admin` login.

### Admin signing secret

```bash
npx wrangler secret put ADMIN_SECRET
```

Use a long random string (32+ characters). Used to sign admin session tokens.  
If you change this later, all existing admin sessions stop working (users must log in again).

## Optional: contact email (Resend)

1. Create a [Resend](https://resend.com) account.
2. Verify your sending domain.
3. Create an API key.
4. Set:

```bash
npx wrangler secret put RESEND_API_KEY
```

5. In `wrangler.toml` `[vars]`, set:

```toml
RECIPIENT_EMAIL = "you@example.com"
SENDER_EMAIL = "My Site <hello@your-verified-domain.com>"
```

If `RESEND_API_KEY` is missing, leads still save to D1, but email is skipped (check Worker logs).

## Optional: GitHub media / publish

Only if you use admin features that write files to a GitHub repo:

```bash
npx wrangler secret put GITHUB_TOKEN
```

And set `GITHUB_REPO` / `GITHUB_BRANCH` in `[vars]`.

## Contact form service names

The API only accepts service values listed in `ALLOWED_SERVICES` inside `worker/src/index.js`.

Default master values:

- General inquiry
- Support
- Sales
- Not sure

Your HTML `<select name="service">` options must match these strings **exactly**, or change the Set in code to match your form.

## Security notes

- Admin token is stored in the browser `localStorage` key `cms_admin_token`.
- Always use HTTPS on the live domain.
- Restrict `ALLOWED_ORIGINS` to real sites you control.
- Do not share `ADMIN_PASSWORD` or commit `.dev.vars` with real secrets.
