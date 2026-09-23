# 04 — Connect your website

The Worker serves your static files **and** injects CMS data into HTML responses. Your HTML must cooperate.

## 1. Place the admin UI

Copy the package `admin/` folder so it is available at:

- `https://your-domain.com/admin/`
- `https://your-domain.com/admin/app.html`

Usually that means:

```text
SITE_ROOT/admin/index.html
SITE_ROOT/admin/app.html
SITE_ROOT/admin/admin.js
SITE_ROOT/admin/admin-app.js
SITE_ROOT/admin/admin.css
```

`[assets] directory` in wrangler must point at `SITE_ROOT`.

## 2. Page shell (required for “New page”)

Section-builder pages are built from a shell file:

**Default path:** `cms/page-shell.html` (see `PAGE_SHELL_PATH` in `worker/src/index.js`)

1. Copy `site-helpers/page-shell.example.html` → `SITE_ROOT/cms/page-shell.html`
2. Replace the placeholder header/footer with the same chrome as your real pages (CSS/JS links included)
3. Keep a single `<main>...</main>` — the Worker replaces that body

If this file is missing, creating a new CMS page returns an error.

## 3. Optional public helpers

| File | Role |
|------|------|
| `site-helpers/cms.js` | Client-side branding assist (`data-cms="brand.name"`, logo, favicon) |
| `site-helpers/cms-section-nav.js` | Smooth-scroll for menu links with `data-cms-section` |

Example:

```html
<script src="/assets/cms.js" defer></script>
<script src="/assets/cms-section-nav.js" defer></script>
```

Most menu/page text is applied **on the server** by the Worker. The helpers are optional extras.

## 4. HTML hooks the CMS understands

### Branding

```html
<span data-cms="brand.name">My Site</span>
<span data-cms="brand.mark">M</span>
<img class="site-logo" src="/assets/logo.png" alt="" />
<link rel="icon" href="/favicon.ico" />
```

### Footer (auto-captured on first Admin CMS load)

Use these class names on every site that reuses this master CMS. Empty Footer CMS fields are filled from `index.html` automatically when you open Admin → Site CMS:

| Class | Captures |
|-------|----------|
| `.site-logo` / `.site-logo-footer` | Branding logo URL |
| `.footer-tagline` | Tagline under logo |
| `.footer-col-title` (×3) | Services / Contact / Company titles |
| `.footer-contact` `ul` with 4 `li` | Email 1, email 2, phone, WhatsApp |
| `.footer-guarantee-label` / `.footer-guarantee-text` | Guarantee block |
| `.footer-bottom` + `.footer-cta` | Copyright line + CTA |

See `site-helpers/page-shell.example.html` for a complete example. Services/Company **links** still use Admin → Menus.

### Page fields

Use `data-cms="page.field_key"` and `data-cms-src="page.image_key"` on elements you want editable. The Worker can also auto-scan many text nodes depending on page setup.

Mark the page identity:

```html
<body data-cms-page="home">
```

For a static file `services/about.html`, use a matching `data-cms-page` value the admin expects.

### Menus

Header/footer menus are managed in Admin → Menus. The Worker injects them into known header/footer regions. Links with `#section` become:

```html
<a href="/" data-cms-section="contact">Contact</a>
```

Include `cms-section-nav.js` if you want click-to-scroll behavior.

## 5. Static file allowlist

Open `worker/src/index.js` and edit `PAGE_ALLOWLIST`.

List every **static** HTML file that ships in your repo / assets, for example:

```js
const PAGE_ALLOWLIST = [
  "index.html",
  "privacy.html",
  "terms.html",
  "blog/index.html",
  "blog/post.html",
  "services/index.html",
  "404.html",
];
```

Do **not** list pages that only exist in D1 (CMS-created pages).

## 6. Admin “View live” links

Admin builds live URLs from the current browser origin by default.  
If admin is opened on a different host than the public site, set before loading admin scripts:

```html
<script>window.CMS_SITE_ORIGIN = "https://your-domain.com";</script>
```

## 7. Contact form endpoint

POST JSON to `/api/contact` with fields matching the Worker validator (`clientName`, `email`, `service`, etc.).  
`service` must be one of `ALLOWED_SERVICES`.
