# Audit: static export vs recovered WP (2026-09-22)

## Verdict
Content/assets were largely present, but **motion fidelity was broken** by our own static CSS.

## Root cause (proven)
Earlier inject forced:

```css
.elementor-invisible, [data-settings*="animation"], .rs-layer, ... {
  visibility: visible !important;
  opacity: 1 !important;
}
```

Elementor scroll animations (`fadeInLeft`, `zoomIn`, `pulse`, etc.) **require** `.elementor-invisible` until the element enters the viewport. Forcing visible removed loading/scroll animation and caused flat “flash” appearance vs WP.

## Other findings
| Item | WP | Static (before fix) | Notes |
|------|----|--------------------|-------|
| Animation CSS files | linked | linked + on disk | OK |
| `elementor-invisible` | present | present but overridden | broken by CSS |
| RevSlider `dummy.png` | lazy → real | stayed dummy until JS | banner flash |
| Missing page assets (home) | — | 0 missing | OK |
| Host leftovers | clean | cleaned | OK |

## Fix applied
1. Removed force-visible on animated elements (85 HTML files)
2. Kept full-bleed banner / container layout fixes
3. Swapped RevSlider `dummy.png` → real `data-lazyload` images
4. Smart fallback after 2.8s only if sections still stuck invisible
5. Updated `scripts/03-postprocess.ps1` so re-exports don’t regress

## How to verify
1. Hard refresh: http://127.0.0.1:8090/?anim=2 (Ctrl+Shift+R)
2. Compare side-by-side: http://127.0.0.1:8080/
3. Scroll home slowly — sections should fade/zoom/pulse in like WP
4. Banner should show real images, not flash blank/dummy
