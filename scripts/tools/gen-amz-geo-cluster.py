"""Original soft gray polygon clusters — sized/placed like Avas-style reference
(large mid-banner row), NOT copying project assets or the screenshot pixels.
"""
from PIL import Image, ImageDraw, ImageFilter
import os

OUT = os.path.normpath(
    os.path.join(
        os.path.dirname(__file__),
        "..",
        "..",
        "export",
        "site",
        "wp-content",
        "uploads",
        "2019",
        "11",
        "amz-geo-cluster.png",
    )
)

BW, BH = 1920, 750  # banner-ish aspect
# Muted lavender-gray, soft on white
FILL = (170, 174, 200, 95)
FILL_SOFT = (165, 169, 195, 75)


def rounded_poly(draw, pts, fill, radius=22):
    draw.polygon(pts, fill=fill)
    for x, y in pts:
        draw.ellipse([x - radius, y - radius, x + radius, y + radius], fill=fill)
    for i in range(len(pts)):
        x1, y1 = pts[i]
        x2, y2 = pts[(i + 1) % len(pts)]
        draw.line([(x1, y1), (x2, y2)], fill=fill, width=radius * 2)


def make_cluster(draw, ox, oy, scale=1.0, fill=FILL):
    s = scale
    g = 8 * s  # white gap between pieces
    a = [
        (ox + 24 * s, oy + 40 * s),
        (ox + 110 * s, oy + 18 * s),
        (ox + 155 * s, oy + 62 * s),
        (ox + 135 * s, oy + 128 * s),
        (ox + 48 * s, oy + 145 * s),
        (ox + 12 * s, oy + 92 * s),
    ]
    b = [
        (ox + 168 * s + g, oy + 28 * s),
        (ox + 250 * s, oy + 16 * s),
        (ox + 292 * s, oy + 70 * s),
        (ox + 262 * s, oy + 132 * s),
        (ox + 172 * s + g, oy + 120 * s),
    ]
    c = [
        (ox + 30 * s, oy + 162 * s + g),
        (ox + 128 * s, oy + 150 * s + g),
        (ox + 152 * s, oy + 215 * s),
        (ox + 98 * s, oy + 255 * s),
        (ox + 24 * s, oy + 232 * s),
    ]
    d = [
        (ox + 170 * s + g, oy + 150 * s + g),
        (ox + 255 * s, oy + 155 * s + g),
        (ox + 278 * s, oy + 205 * s),
        (ox + 225 * s, oy + 240 * s),
        (ox + 165 * s + g, oy + 215 * s),
    ]
    for pts in (a, b, c, d):
        rounded_poly(draw, pts, fill, radius=int(16 * s))


banner = Image.new("RGBA", (BW, BH), (0, 0, 0, 0))

# Large clusters across the VERTICAL CENTER (like reference), evenly spaced
# Reference rhythm: big shapes behind headline area, repeating horizontally
cluster_w = 320
scale = 1.15
y = int(BH * 0.28)  # mid-upper band where headline sits
xs = [40, 420, 800, 1180, 1560]

for i, x in enumerate(xs):
    tile = Image.new("RGBA", (340, 310), (0, 0, 0, 0))
    td = ImageDraw.Draw(tile)
    make_cluster(td, 8, 8, scale=scale, fill=FILL if i % 2 == 0 else FILL_SOFT)
    tile = tile.filter(ImageFilter.GaussianBlur(radius=0.85))
    banner.alpha_composite(tile, (x, y))

os.makedirs(os.path.dirname(OUT), exist_ok=True)
banner.save(OUT, "PNG", optimize=True)
print("wrote", OUT, banner.size, os.path.getsize(OUT))
print("sample mid", banner.getpixel((500, 350)))
print("corner", banner.getpixel((10, 10)))
