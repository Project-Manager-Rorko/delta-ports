"""Full local vs live page audit for Delta Ports."""
import re, html, urllib.request, pathlib, json

OUT = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare")
OUT.mkdir(exist_ok=True)
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
    ("/privacy-policy/", "privacy"),
    ("/terms-conditions/", "terms"),
]


def fetch(url):
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    with urllib.request.urlopen(req, timeout=60) as r:
        return r.read().decode("utf-8", "ignore")


def headings(s):
    out = []
    for m in re.finditer(r"<h([1-4])[^>]*>(.*?)</h\1>", s, re.I | re.S):
        t = re.sub(r"<[^>]+>", " ", m.group(2))
        t = html.unescape(re.sub(r"\s+", " ", t)).strip()
        if t and len(t) < 140:
            out.append(f"H{m.group(1)}:{t}")
    return out


def text_blob(s):
    s = re.sub(r"<script[^>]*>.*?</script>", " ", s, flags=re.I | re.S)
    s = re.sub(r"<style[^>]*>.*?</style>", " ", s, flags=re.I | re.S)
    t = re.sub(r"<[^>]+>", " ", s)
    return html.unescape(re.sub(r"\s+", " ", t)).strip().lower()


def section_around(s, keyword, radius=2500):
    i = s.lower().find(keyword.lower())
    if i < 0:
        return ""
    return s[max(0, i - 200) : i + radius]


report = []
for path, name in PAGES:
    row = {"page": name, "path": path}
    try:
        live = fetch(LIVE + path)
        (OUT / f"{name}-live.html").write_text(live, encoding="utf-8")
        row["live_len"] = len(live)
        row["live_h"] = headings(live)
    except Exception as e:
        row["live_err"] = str(e)
        live = ""
    try:
        local = fetch(LOCAL + path)
        (OUT / f"{name}-local.html").write_text(local, encoding="utf-8")
        row["local_len"] = len(local)
        row["local_h"] = headings(local)
    except Exception as e:
        row["local_err"] = str(e)
        local = ""
    if live and local:
        lb, lo = text_blob(live), text_blob(local)
        # sample key phrases from live headings
        missing = []
        for h in row.get("live_h", []):
            key = h.split(":", 1)[-1].strip().lower()[:50]
            if key and key not in lo and len(key) > 8:
                missing.append(h)
        row["missing_headings"] = missing
    report.append(row)
    print("===", name, "live", row.get("live_len"), "local", row.get("local_len"))
    if row.get("missing_headings"):
        print("  missing H:", row["missing_headings"][:12])

# Extract home live structure for Our Business / Awards / Operations
if (OUT / "home-live.html").exists():
    live = (OUT / "home-live.html").read_text(encoding="utf-8", errors="ignore")
    for key in ["Our Business", "Awards, Recognition", "Our Operations", "Media"]:
        chunk = section_around(live, key, 4000)
        (OUT / f"home-live-section-{key[:12].replace(' ','_')}.html").write_text(chunk, encoding="utf-8")
        print("\n--- LIVE SECTION", key, "len", len(chunk))
        # class names near keyword
        classes = re.findall(r'class="([^"]{0,200})"', chunk)
        print(" classes sample:", classes[:15])
        imgs = re.findall(r'src="([^"]+)"', chunk)
        print(" imgs:", [i for i in imgs if "upload" in i or "theme" in i][:12])

(OUT / "audit-report.json").write_text(json.dumps(report, indent=2), encoding="utf-8")
print("\nWrote audit-report.json")
