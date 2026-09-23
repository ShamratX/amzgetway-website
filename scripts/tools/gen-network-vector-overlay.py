"""High-quality transparent networking overlay — refined ribbon + mesh on transparent."""
from PIL import Image, ImageDraw, ImageFilter
import math
import random
import os

# Render 2x then downsample for smoother lines
SCALE = 2
W, H = 1920 * SCALE, 900 * SCALE
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
        "network-vector-overlay.png",
    )
)

rng = random.Random(7)
img = Image.new("RGBA", (W, H), (0, 0, 0, 0))
draw = ImageDraw.Draw(img)


def wave_y(x, phase=0.0, amp=1.0, base=0.0, freq=1.0):
    t = x / W
    # smooth S-curve ribbon path (BL -> TR), matching example flow
    path = base + (0.18 * H) * math.sin((t * math.pi * 1.15 * freq) + phase)
    path += (0.06 * H) * math.sin((t * math.pi * 2.4 * freq) + phase * 1.7)
    # gentle upward drift
    path -= t * 0.12 * H
    return path * amp


# --- Dense flowing ribbon (many parallel fine lines) ---
ribbon_lines = 28
ribbon_spread = int(0.22 * H)
base_y = 0.62 * H
blue = (110, 135, 210)
warm = (230, 170, 120)
white = (255, 255, 255)

for i in range(ribbon_lines):
    u = i / (ribbon_lines - 1)
    offset = (u - 0.5) * ribbon_spread
    # center lines slightly stronger
    strength = 1.0 - abs(u - 0.5) * 1.4
    alpha = int(28 + 50 * max(0, strength))
    # mix white with subtle brand tint
    if u < 0.45:
        r = int(white[0] * 0.85 + blue[0] * 0.15)
        g = int(white[1] * 0.85 + blue[1] * 0.15)
        b = int(white[2] * 0.85 + blue[2] * 0.15)
    elif u > 0.65:
        r = int(white[0] * 0.85 + warm[0] * 0.15)
        g = int(white[1] * 0.85 + warm[1] * 0.15)
        b = int(white[2] * 0.85 + warm[2] * 0.15)
    else:
        r, g, b = white
    pts = []
    step = 3
    for x in range(0, W + step, step):
        y = wave_y(x, phase=0.15, amp=1.0, base=base_y) + offset
        # taper opacity near left edge
        pts.append((x, y))
    # draw polyline segments with left/right fade
    for j in range(len(pts) - 1):
        x0 = pts[j][0]
        fade = min(1.0, x0 / (0.12 * W), (W - x0) / (0.08 * W))
        a = max(0, int(alpha * fade))
        if a < 4:
            continue
        draw.line([pts[j], pts[j + 1]], fill=(r, g, b, a), width=max(1, SCALE // 2))

# secondary softer ribbon behind
for i in range(12):
    u = i / 11
    offset = (u - 0.5) * int(0.14 * H) + int(0.08 * H)
    alpha = int(12 + 18 * (1 - abs(u - 0.5)))
    pts = [
        (x, wave_y(x, phase=0.9, amp=0.85, base=base_y * 0.95) + offset)
        for x in range(0, W, 4)
    ]
    for j in range(len(pts) - 1):
        fade = min(1.0, pts[j][0] / (0.15 * W))
        a = int(alpha * fade)
        draw.line([pts[j], pts[j + 1]], fill=(200, 210, 230, a), width=1)

# --- Network mesh along ribbon corridor ---
nodes = []
# structured grid-ish along the path for a cleaner constellation look
for k in range(42):
    t = 0.08 + 0.84 * (k / 41)
    x = int(t * W)
    y = int(wave_y(x, phase=0.15, amp=1.0, base=base_y))
    # scatter slightly
    x += rng.randint(-int(0.02 * W), int(0.02 * W))
    y += rng.randint(-int(0.10 * H), int(0.10 * H))
    r = rng.choice([2, 2, 3, 3, 4]) * SCALE
    nodes.append((x, y, r, False))

# larger glow hubs
hubs = [0.22, 0.38, 0.52, 0.68, 0.82]
for t in hubs:
    x = int(t * W) + rng.randint(-20, 20)
    y = int(wave_y(x, phase=0.15, amp=1.0, base=base_y)) + rng.randint(-40, 40)
    nodes.append((x, y, rng.randint(5, 7) * SCALE, True))

# extra sparse nodes off-path (right side denser like example)
for _ in range(25):
    x = rng.randint(int(0.35 * W), W - 30)
    y = int(wave_y(x, phase=0.15, amp=1.0, base=base_y) + rng.randint(-int(0.2 * H), int(0.18 * H)))
    y = max(20, min(H - 20, y))
    nodes.append((x, y, rng.choice([2, 3, 3, 4]) * SCALE, False))

# connections — prefer nearby, form clean triangles
max_dist = 0.11 * W
for i, (x1, y1, r1, hub1) in enumerate(nodes):
    cand = []
    for j, (x2, y2, r2, hub2) in enumerate(nodes):
        if j <= i:
            continue
        d = math.hypot(x2 - x1, y2 - y1)
        if d < max_dist:
            cand.append((d, x2, y2))
    cand.sort()
    limit = 4 if hub1 else 3
    for d, x2, y2 in cand[:limit]:
        a = int(70 * (1 - d / max_dist)) + 18
        draw.line([(x1, y1), (x2, y2)], fill=(170, 185, 220, a), width=max(1, SCALE // 2))

# draw nodes with soft glow
glow = Image.new("RGBA", (W, H), (0, 0, 0, 0))
gdraw = ImageDraw.Draw(glow)
for x, y, r, hub in nodes:
    if hub or r >= 4 * SCALE:
        for mul, ha in ((3.2, 14), (2.2, 24), (1.5, 36)):
            hr = int(r * mul)
            gdraw.ellipse([x - hr, y - hr, x + hr, y + hr], fill=(220, 230, 245, ha))
    a = 110 if not hub else 150
    draw.ellipse([x - r, y - r, x + r, y + r], fill=(235, 240, 250, a))
    # tiny warm core on hubs (brand orange)
    if hub:
        cr = max(2, r // 3)
        draw.ellipse([x - cr, y - cr, x + cr, y + cr], fill=(242, 139, 21, 90))

img = Image.alpha_composite(glow.filter(ImageFilter.GaussianBlur(radius=2 * SCALE)), img)
# light overall blur for softer vector feel, then sharpen slightly via downsample
img = img.filter(ImageFilter.GaussianBlur(radius=0.6 * SCALE))

# Downsample to final size
final = img.resize((1920, 900), Image.Resampling.LANCZOS)

# Slightly boost alpha so it reads on white without looking heavy
pix = final.load()
for y in range(final.height):
    for x in range(final.width):
        r, g, b, a = pix[x, y]
        if a > 0:
            pix[x, y] = (r, g, b, min(255, int(a * 1.15)))

os.makedirs(os.path.dirname(OUT), exist_ok=True)
final.save(OUT, "PNG", optimize=True)
print("Wrote", OUT, "bytes", os.path.getsize(OUT), final.mode, final.size)
