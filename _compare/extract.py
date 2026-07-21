import re, html, pathlib

base = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare")

for name in ["port-led", "cargo", "logistics"]:
    live = (base / f"{name}-live.html").read_text(encoding="utf-8", errors="ignore")
    local = (base / f"{name}-local.html").read_text(encoding="utf-8", errors="ignore")

    def headings(s):
        hs = re.findall(r"<h([1-4])[^>]*>(.*?)</h\1>", s, re.I | re.S)
        out = []
        for lvl, t in hs:
            t = re.sub(r"<[^>]+>", "", t)
            t = html.unescape(re.sub(r"\s+", " ", t)).strip()
            if t and len(t) < 140:
                out.append(f"H{lvl}: {t}")
        return out

    def imgs(s):
        srcs = re.findall(r'src=["\']([^"\']+)["\']', s, re.I)
        keep = []
        for x in srcs:
            xl = x.lower()
            if any(xl.endswith(e) for e in [".webp", ".jpg", ".jpeg", ".png", ".svg"]):
                if "logo" in xl or "gravatar" in xl or "emoji" in xl:
                    continue
                keep.append(x)
        seen = set()
        u = []
        for x in keep:
            if x not in seen:
                seen.add(x)
                u.append(x)
        return u

    def lists(s):
        items = re.findall(r"<li[^>]*>(.*?)</li>", s, re.I | re.S)
        out = []
        for t in items:
            t = re.sub(r"<[^>]+>", "", t)
            t = html.unescape(re.sub(r"\s+", " ", t)).strip()
            if 3 < len(t) < 160:
                out.append(t)
        # unique
        seen = set()
        u = []
        for x in out:
            if x not in seen:
                seen.add(x)
                u.append(x)
        return u

    lh, loh = headings(live), headings(local)
    print("=" * 60)
    print(name.upper())
    print("LIVE headings", len(lh))
    for h in lh:
        print(" ", h)
    print("LOCAL headings", len(loh))
    for h in loh:
        print(" ", h)
    print("LIVE list items unique", len(lists(live)))
    for i in lists(live)[:60]:
        print("  •", i)
    print("LIVE images", len(imgs(live)))
    for i in imgs(live)[:30]:
        print(" ", i)
    print()
