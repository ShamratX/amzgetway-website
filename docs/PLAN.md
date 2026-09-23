# AmzGetway → Cloudflare Pages (zero missing design)

## Goal
Ship a **static** site to Cloudflare Pages that matches the recovered WordPress at `http://127.0.0.1:8080/` — same navbar, banner/CTA, sections, images, footer, fonts, CSS. No redesign.

## Source of truth
- Live local WP (Docker): `http://127.0.0.1:8080/`
- Files: `D:\Amzgetway Backup\amzgetway-local\site\`
- Crash backup: `D:\Amzgetway Backup\RECOVERY_2026-09-22_22-15\`
- Project output: `D:\Desktop\Important files\amzgetway\export\site\`

## Lessons from prior chat (must not repeat)
1. Old `:8088` / `amzgetway-cf` was a **partial** export — blank page, broken banner, missing nav/footer.
2. Nav/footer need Avas license bypass (already in `mu-plugins/force-local-urls.php`).
3. Banner CTA clips if Bootstrap `.container` traps RevSlider — container fix already in mu-plugin.
4. Broken hosts (`wordpress`, `//amzgetway.com`, doubled `http:http://`) hide Elementor/RevSlider.
5. Static pages need **working asset URLs** OR forced-visible CSS — RevSlider/Elementor hide content until JS runs.

## Acceptance (done when all pass)
- [x] All sitemap pages (pages + services) HTTP 200 in export (51/51)
- [x] Homepage: logo + main menu + RevSlider banner + CTA text + footer widgets
- [x] No `http://wordpress` or live `amzgetway.com` asset hosts in exported HTML (emails kept as @amzgetway.com)
- [x] Uploads + theme + plugin CSS/JS present for linked assets (~514 MB / 14,930 files)
- [ ] Side-by-side QA: WP `:8080` vs static `:8090` — **your visual sign-off**
- [ ] Preview URL for sign-off before Cloudflare upload — **http://127.0.0.1:8090/**

## Non-goals (honest limits)
- wp-admin / PHP forms will not submit on Pages (design stays; wire Formspree/Worker later)
- Content newer than the **23 Mar 2026** Softaculous backup is not in this recover

## Build steps
1. **Verify WP** — nav/banner/footer OK on `:8080` (done)
2. **URL inventory** — Yoast page + service sitemaps + critical assets
3. **Fresh mirror** — crawl every page; sync `wp-content/uploads`, theme, needed plugin assets
4. **Post-process** — rewrite hosts to relative/`./` paths; strip query-cache file name traps; inject static visibility/slider fixes
5. **QA** — automated checks + manual hard-refresh preview
6. **Cloudflare** — upload `export/site` to Pages + attach domain (after your sign-off)

## Stop condition
Acceptance checklist above passes on static preview. Do not upload to Cloudflare until you confirm the preview.
