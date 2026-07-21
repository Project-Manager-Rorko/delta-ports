import re
import urllib.request
import pathlib
import struct

img_dir = pathlib.Path(
    r"C:\Users\shanm\Local Sites\delta-ports\app\public\wp-content\themes\delta-ports\assets\images"
)

# Inspect local files
for name in [
    "our-leadership-update1.webp",
    "our-leadership-update2.webp",
    "our-operation-delta-port1.webp",
    "delta-map-sec-bg-new-scaled-1.webp",
    "our-operation-img1.png",
]:
    p = img_dir / name
    if not p.exists():
        print("MISSING", name)
        continue
    data = p.read_bytes()[:32]
    print(name, "size", p.stat().st_size, "head", data[:16])

# Live leadership + home images
for page in [
    "https://vipaccounts.org/delta-ports/leadership/",
    "https://vipaccounts.org/delta-ports/",
]:
    print("\n===", page)
    html = urllib.request.urlopen(page, timeout=60).read().decode("utf-8", "ignore")
    urls = re.findall(
        r"https://vipaccounts\.org/delta-ports/wp-content/uploads/[^\"'\s>]+\.(?:webp|jpg|jpeg|png)",
        html,
        re.I,
    )
    seen = set()
    for u in urls:
        if u in seen:
            continue
        seen.add(u)
        low = u.lower()
        if any(
            k in low
            for k in [
                "leader",
                "leadership",
                "operation",
                "ahmed",
                "shamil",
                "mohi",
                "media-update",
                "awards",
            ]
        ):
            # skip tiny thumbs
            if re.search(r"-\d{2,4}x\d{2,4}\.", u):
                continue
            print(u)

# Download full-size leadership photos
targets = [
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-leadership-update1.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-leadership-update2.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-leadership-update3.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-leadership-update4.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-leadership-update5.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-leadership-update6.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-operation-delta-port1.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-operation-delta-port2.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-operation-delta-port3.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-operation-delta-port4.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/leadership-new-updated-banner.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/des-banner-Port-leadership.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/des-banner-Port-leadership-1.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/03/media-update1.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/03/media-update2.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/03/media-update3.webp",
]

print("\n=== DOWNLOAD ===")
for u in targets:
    name = u.rsplit("/", 1)[-1]
    dest = img_dir / name
    try:
        urllib.request.urlretrieve(u, dest)
        data = dest.read_bytes()
        print("OK", name, dest.stat().st_size, "RIFF" if data[:4] == b"RIFF" else data[:8])
    except Exception as e:
        print("FAIL", name, e)
