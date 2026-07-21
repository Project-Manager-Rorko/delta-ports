"""Detailed local vs live diff: headings, key phrases, structure."""
import re, html, pathlib, urllib.request

OUT = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare")
LIVE = "https://vipaccounts.org/delta-ports"
LOCAL = "http://delta-ports.local"

PAGES = [
    ("/", "home"),
    ("/about-us/", "about"),
    ("/leadership/", "leadership"),
    ("/led-operation-new/", "port-led"),
    ("/cargo-handling-capabilities/", "cargo"),
    ("/integrated-port-logistics/", "logistics"),
    ("/sustainability/", "sustainability"),
    ("/contact-us/", "contact"),
]


def fetch(url):
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    with urllib.request.urlopen(req, timeout=60) as r:
        return r.read().decode("utf-8", "ignore")


def clean_text(s):
    s = re.sub(r"<script[^>]*>.*?</script>", " ", s, flags=re.I | re.S)
    s = re.sub(r"<style[^>]*>.*?</style>", " ", s, flags=re.I | re.S)
    s = re.sub(r"<[^>]+>", " ", s)
    s = html.unescape(re.sub(r"\s+", " ", s)).strip().lower()
    return s


def headings(s):
    out = []
    for m in re.finditer(r"<h([1-3])[^>]*>(.*?)</h\1>", s, re.I | re.S):
        t = re.sub(r"<[^>]+>", " ", m.group(2))
        t = html.unescape(re.sub(r"\s+", " ", t)).strip()
        if t and len(t) < 120 and "footer" not in t.lower():
            out.append(t)
    return out


def has_video(s):
    return bool(re.search(r"<video|backgroundType.:.video|type=.video/mp4", s, re.I))


def img_count(s):
    return len(re.findall(r"<img[^>]+src=", s, re.I))


KEY_PHRASES = {
    "home": [
        "accelerating india",
        "partnering with industry leaders",
        "one-stop destination",
        "leadership at delta ports ensures",
        "our operations",
        "port-led operations",
        "cargo & terminal",
        "integrated port logistics",
        "sustainability",
        "media & updates",
        "awards, recognition",
        "our business",
        "delta marmagoa",
        "25m+",
        "ceramic pro",
    ],
    "port-led": [
        "mormugao",
        "eq-3",
        "italgru",
        "how cargo moves",
        "vessel arrival",
        "116k",
        "12.80",
    ],
    "cargo": [
        "6 million",
        "mobile harbour",
        "covered storage",
        "cctv",
        "weather-sensitive",
    ],
    "logistics": [
        "railway sidings",
        "cable-stayed",
        "rail connectivity",
        "road & highway",
    ],
    "leadership": ["ahmed mohiuddin", "shamil ahmed", "sudhir hegde"],
    "sustainability": ["mist cannon", "battery-powered", "solar"],
    "about": ["vision", "mission", "operating philosophy"],
    "contact": ["mangalore", "bangalore", "dammam"],
}

for path, name in PAGES:
    print("\n" + "=" * 60)
    print(name.upper(), path)
    try:
        live = fetch(LIVE + path)
        local = fetch(LOCAL + path)
    except Exception as e:
        print("FETCH FAIL", e)
        continue
    (OUT / f"{name}-live.html").write_text(live, encoding="utf-8")
    (OUT / f"{name}-local.html").write_text(local, encoding="utf-8")

    lh, loh = headings(live), headings(local)
    print(f"  sizes: live={len(live)} local={len(local)}")
    print(f"  headings: live={len(lh)} local={len(loh)}")
    print(f"  images: live={img_count(live)} local={img_count(local)}")
    print(f"  video: live={has_video(live)} local={has_video(local)}")

    # Missing live headings (rough)
    local_blob = clean_text(local)
    missing_h = []
    for h in lh:
        key = re.sub(r"\s+", " ", h).strip().lower()[:40]
        if key and key not in local_blob and len(key) > 6:
            if "home upgrade" in key or "accelerating india's" == key:
                continue
            missing_h.append(h)
    if missing_h:
        print("  MISSING live headings on local:")
        for h in missing_h[:12]:
            print("   -", h)

    phrases = KEY_PHRASES.get(name, [])
    for p in phrases:
        ok = p in local_blob
        print(f"  phrase [{'OK' if ok else 'MISS'}]: {p}")

print("\nDone.")
