"""Extract detailed structure for key home sections from live HTML."""
import re, html, pathlib

live = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").read_text(
    encoding="utf-8", errors="ignore"
)
# refresh live
import urllib.request
req = urllib.request.Request("https://vipaccounts.org/delta-ports/", headers={"User-Agent": "Mozilla/5.0"})
live = urllib.request.urlopen(req, timeout=60).read().decode("utf-8", "ignore")
pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").write_text(live, encoding="utf-8")

sections = [
    ("Partnering with Industry Leaders", "One-Stop Destination"),
    ("One-Stop Destination", "Leadership"),
    ("Leadership", "Projects"),
    ("Our Operations", "Sustainability"),
    ("Awards, Recognition", "Our Business"),
    ("Our Business", "© 2026"),
]

for start, end in sections:
    i = live.find(start)
    j = live.find(end, i + 20) if i >= 0 else -1
    if i < 0:
        print("NOT FOUND", start)
        continue
    chunk = live[max(0, i - 400) : (j if j > i else i + 8000)]
    print("\n" + "=" * 70)
    print("SECTION:", start, "len", len(chunk))
    # headings
    for m in re.finditer(r"<h([1-5])[^>]*>(.*?)</h\1>", chunk, re.I | re.S):
        t = html.unescape(re.sub(r"<[^>]+>", " ", m.group(2)))
        t = re.sub(r"\s+", " ", t).strip()
        if t:
            print(f"  H{m.group(1)}: {t[:100]}")
    # images
    imgs = re.findall(r'src="(https://[^"]+)"', chunk)
    seen = set()
    for u in imgs:
        if u in seen:
            continue
        seen.add(u)
        if any(x in u.lower() for x in ["upload", "logo", "award", "leader", "operation", "media", "map", "component"]):
            print("  IMG:", u.split("/")[-1][:80])
    # key classes
    classes = re.findall(r'class="([^"]{10,120})"', chunk)
    interesting = [c for c in classes if any(k in c for k in ["integrate", "hover", "marquee", "carousel", "bento", "team", "business", "award", "logo", "counter"])]
    print("  classes:", interesting[:12])
    # text snippets
    texts = []
    for m in re.finditer(r">([^<]{30,160})<", chunk):
        t = html.unescape(re.sub(r"\s+", " ", m.group(1))).strip()
        if t and "elementor" not in t.lower() and "function" not in t.lower():
            texts.append(t)
    print("  texts:")
    for t in texts[:8]:
        print("   •", t[:140])
