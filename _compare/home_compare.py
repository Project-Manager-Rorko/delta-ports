import re, html, pathlib

base = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare")
live = (base / "home-live.html").read_text(encoding="utf-8", errors="ignore")
local = (base / "home-local.html").read_text(encoding="utf-8", errors="ignore")


def headings(s):
    out = []
    for m in re.finditer(r"<h([1-4])[^>]*>(.*?)</h\1>", s, re.I | re.S):
        t = re.sub(r"<[^>]+>", " ", m.group(2))
        t = html.unescape(re.sub(r"\s+", " ", t)).strip()
        if t and len(t) < 160:
            out.append(f"H{m.group(1)}: {t}")
    return out


def texts(s, min_len=40):
    # strip scripts/styles
    s = re.sub(r"<script[^>]*>.*?</script>", " ", s, flags=re.I | re.S)
    s = re.sub(r"<style[^>]*>.*?</style>", " ", s, flags=re.I | re.S)
    # keep body-ish content only if possible
    m = re.search(r"<main[^>]*>(.*?)</main>", s, re.I | re.S)
    if m:
        s = m.group(1)
    chunks = re.findall(r">([^<]{20,})<", s)
    out = []
    seen = set()
    for c in chunks:
        t = html.unescape(re.sub(r"\s+", " ", c)).strip()
        if len(t) < min_len:
            continue
        if t.lower() in seen:
            continue
        # skip menu/footer noise somewhat
        if any(x in t.lower() for x in ["cookie", "jquery", "document.", "function(", "© 2026"]):
            continue
        seen.add(t.lower())
        out.append(t)
    return out


def imgs(s):
    srcs = re.findall(r'src=["\']([^"\']+)["\']', s, re.I)
    out = []
    seen = set()
    for u in srcs:
        low = u.lower()
        if not any(low.endswith(e) for e in [".webp", ".jpg", ".jpeg", ".png", ".svg", ".mp4", ".webm"]):
            continue
        if any(k in low for k in ["logo", "gravatar", "emoji", "icon-"]):
            continue
        if u not in seen:
            seen.add(u)
            out.append(u)
    return out


lh, loh = headings(live), headings(local)
print("=" * 70)
print("LIVE HEADINGS", len(lh))
for h in lh:
    print(" ", h)
print("\nLOCAL HEADINGS", len(loh))
for h in loh:
    print(" ", h)

lt, lot = texts(live), texts(local)
print("\n" + "=" * 70)
print("LIVE TEXT snippets", len(lt))
for t in lt[:80]:
    print(" •", t[:180])
print("\nLOCAL TEXT snippets", len(lot))
for t in lot[:80]:
    print(" •", t[:180])

# missing phrases from live not in local (normalized)
def norm(s):
    return re.sub(r"\s+", " ", s).strip().lower()

local_blob = norm(re.sub(r"<[^>]+>", " ", local))
missing = []
for t in lt:
    n = norm(t)
    if len(n) < 50:
        continue
    # check substantial substring
    key = n[:80]
    if key not in local_blob and n not in local_blob:
        missing.append(t)

print("\n" + "=" * 70)
print("LIKELY MISSING FROM LOCAL (live text not found)", len(missing))
for t in missing[:60]:
    print(" -", t[:200])

print("\nLIVE IMGS", len(imgs(live)))
for i in imgs(live)[:40]:
    print(" ", i)
print("\nLOCAL IMGS", len(imgs(local)))
for i in imgs(local)[:40]:
    print(" ", i)
