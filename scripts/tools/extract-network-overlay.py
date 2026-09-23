"""Key white networking strokes from black-bg art → transparent overlay."""
from PIL import Image, ImageFilter
import os

_ROOT = os.path.normpath(os.path.join(os.path.dirname(__file__), "..", ".."))
SRC = os.path.normpath(
    os.path.join(
        os.path.expanduser("~"),
        ".cursor",
        "projects",
        "d-Desktop-Important-files-amzgetway",
        "assets",
        "network-vector-blackbg.png",
    )
)
OUT = os.path.normpath(
    os.path.join(_ROOT, "export", "site", "wp-content", "uploads", "2019", "11", "network-vector-overlay.png")
)

im = Image.open(SRC).convert("RGB").resize((1920, 900), Image.Resampling.LANCZOS)
px = im.load()
out = Image.new("RGBA", im.size, (0, 0, 0, 0))
dst = out.load()
W, H = im.size

for y in range(H):
    for x in range(W):
        r, g, b = px[x, y]
        lum = 0.299 * r + 0.587 * g + 0.114 * b
        # black bg → ignore; white/gray strokes → alpha
        if lum < 18:
            continue
        # map luminance to alpha; keep soft glow tails
        alpha = int(min(210, (lum / 255.0) * 220))
        if alpha < 10:
            continue
        # soft cool-white stroke (reads well on pure white page)
        # slightly blue-tinted for brand, low key
        nr = min(255, int(180 + lum * 0.25))
        ng = min(255, int(190 + lum * 0.22))
        nb = min(255, int(210 + lum * 0.18))
        dst[x, y] = (nr, ng, nb, alpha)

# Soften jagged AI edges slightly
out = out.filter(ImageFilter.GaussianBlur(radius=0.45))

os.makedirs(os.path.dirname(OUT), exist_ok=True)
out.save(OUT, "PNG", optimize=True)
print("wrote", OUT, os.path.getsize(OUT))
print("corner", out.getpixel((15, 15)))
print("center", out.getpixel((960, 450)))
vis = sum(1 for p in out.getdata() if p[3] > 20)
print(f"visible {vis}/{W*H} ({100*vis/(W*H):.2f}%)")
