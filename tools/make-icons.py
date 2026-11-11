#!/usr/bin/env python3
"""MarkU brand icon generator for the TWA (Bubblewrap).

Usage:  python3 tools/make-icons.py <brand-logo.png> [out_dir]
Needs:  pip install pillow

Creates (upload all three to WordPress Media, then put the URLs in twa-manifest.json):
  markU-icon-512.png        -> iconUrl            (full logo, square, 512x512)
  markU-maskable-512.png    -> maskableIconUrl    (logo inside 66% safe zone, solid background)
  markU-monochrome-96.png   -> monochromeIconUrl  (white silhouette on transparent; notification icon)
"""
import sys, os
from PIL import Image

BG = (0x0e, 0x8f, 0x84, 255)   # themeColor #0e8f84

def fit(img, box):
    img = img.copy(); img.thumbnail((box, box), Image.LANCZOS); return img

def paste_center(canvas, img):
    x = (canvas.width - img.width) // 2; y = (canvas.height - img.height) // 2
    canvas.alpha_composite(img, (x, y)); return canvas

def main():
    if len(sys.argv) < 2: sys.exit(__doc__)
    src = Image.open(sys.argv[1]).convert("RGBA")
    out = sys.argv[2] if len(sys.argv) > 2 else "icons-out"; os.makedirs(out, exist_ok=True)
    bbox = src.getbbox()                       # trim transparent border
    if bbox: src = src.crop(bbox)

    # 1. Standard icon: logo at 88% on transparent 512 canvas
    paste_center(Image.new("RGBA", (512, 512), (0, 0, 0, 0)), fit(src, 450)).save(f"{out}/markU-icon-512.png")

    # 2. Maskable: solid background, logo within the inner 66% so no launcher shape crops it
    paste_center(Image.new("RGBA", (512, 512), BG), fit(src, 338)).save(f"{out}/markU-maskable-512.png")

    # 3. Monochrome: every non-transparent pixel -> white (Android tints notification icons)
    alpha = fit(src, 80).getchannel("A")
    mono = Image.new("RGBA", alpha.size, (255, 255, 255, 0)); mono.putalpha(alpha.point(lambda a: 255 if a > 40 else 0))
    paste_center(Image.new("RGBA", (96, 96), (0, 0, 0, 0)), mono).save(f"{out}/markU-monochrome-96.png")

    if src.getchannel("A").getextrema()[0] == 255:
        print("WARNING: logo has no transparency. Monochrome icon will be a white square. "
              "Use a transparent-background PNG of the logo.")
    print("Done ->", out)

if __name__ == "__main__":
    main()
