"""Generate a soft networking-vector banner background using AmzGetway brand colors."""
from PIL import Image, ImageDraw
import math
import random
import os

W, H = 1920, 900
OUT = os.path.join(
    os.path.dirname(__file__),
    "..",
    "..",
    "export",
    "site",
    "wp-content",
    "uploads",
    "2019",
    "11",
    "network-vector-bg.png",
)
OUT = os.path.normpath(OUT)


def lerp(a, b, t):
    return tuple(int(a[i] + (b[i] - a[i]) * t) for i in range(3))


# Brand wash: blue #607DFD, orange #F28B15
left = (232, 236, 245)
mid = (242, 240, 245)
right = (250, 236, 224)

img = Image.new("RGBA", (W, H))
px = img.load()
for x in range(W):
    t = x / (W - 1)
    if t < 0.55:
        c = lerp(left, mid, t / 0.55)
    else:
        c = lerp(mid, right, (t - 0.55) / 0.45)
    for y in range(H):
        vy = abs(y - H * 0.45) / (H * 0.55)
        soften = 1 - 0.04 * vy
        px[x, y] = (
            int(c[0] * soften + 255 * (1 - soften)),
            int(c[1] * soften + 255 * (1 - soften)),
            int(c[2] * soften + 255 * (1 - soften)),
            255,
        )

ov = Image.new("RGBA", (W, H), (0, 0, 0, 0))
draw = ImageDraw.Draw(ov)
rng = random.Random(42)


def wave_y(x, phase, amp, base):
    return (
        base
        + amp * math.sin(x * 0.0045 + phase)
        + (amp * 0.35) * math.sin(x * 0.011 + phase * 1.7)
    )


# Flowing growth ribbons (white, low visibility)
for band in range(7):
    base = H * 0.38 + band * 18
    amp = 70 + band * 6
    phase = band * 0.45
    pts = [(x, wave_y(x, phase, amp, base)) for x in range(0, W, 4)]
    alpha = 28 + band * 4
    for i in range(len(pts) - 1):
        draw.line([pts[i], pts[i + 1]], fill=(255, 255, 255, alpha), width=1)

# Secondary warmer ribbons (brand peach tint)
for band in range(4):
    base = H * 0.52 + band * 14
    amp = 55 + band * 5
    phase = 1.2 + band * 0.5
    pts = [(x, wave_y(x, phase, amp, base)) for x in range(0, W, 5)]
    alpha = 18 + band * 3
    for i in range(len(pts) - 1):
        draw.line([pts[i], pts[i + 1]], fill=(255, 248, 240, alpha), width=1)

# Network nodes
nodes = []
for _ in range(55):
    x = rng.randint(int(W * 0.15), W - 40)
    y = int(wave_y(x, 0.8, 90, H * 0.42) + rng.randint(-120, 120))
    y = max(40, min(H - 40, y))
    r = rng.choice([2, 2, 3, 3, 4, 5])
    nodes.append((x, y, r))

for _ in range(8):
    x = rng.randint(int(W * 0.35), W - 60)
    y = int(wave_y(x, 1.0, 80, H * 0.4) + rng.randint(-60, 60))
    y = max(50, min(H - 50, y))
    nodes.append((x, y, rng.randint(6, 9)))

max_dist = 180
for i, (x1, y1, r1) in enumerate(nodes):
    dists = []
    for j, (x2, y2, r2) in enumerate(nodes):
        if j <= i:
            continue
        d = math.hypot(x2 - x1, y2 - y1)
        if d < max_dist:
            dists.append((d, x2, y2))
    dists.sort()
    for d, x2, y2 in dists[:3]:
        a = int(40 * (1 - d / max_dist)) + 10
        draw.line([(x1, y1), (x2, y2)], fill=(255, 255, 255, a), width=1)

for x, y, r in nodes:
    if r >= 5:
        for hr, ha in ((r * 3, 12), (r * 2, 20)):
            draw.ellipse([x - hr, y - hr, x + hr, y + hr], fill=(255, 255, 255, ha))
    draw.ellipse(
        [x - r, y - r, x + r, y + r],
        fill=(255, 255, 255, 90 if r < 5 else 120),
    )
    if r >= 6 and rng.random() < 0.4:
        draw.ellipse([x - 2, y - 2, x + 2, y + 2], fill=(242, 139, 21, 70))

img = Image.alpha_composite(img, ov)
os.makedirs(os.path.dirname(OUT), exist_ok=True)
img.convert("RGB").save(OUT, "PNG", optimize=True)
print("Wrote", OUT, "bytes", os.path.getsize(OUT))
