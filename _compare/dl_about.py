import re, urllib.request, pathlib

req = urllib.request.Request(
    "https://vipaccounts.org/delta-ports/about-us/",
    headers={"User-Agent": "Mozilla/5.0"},
)
html = urllib.request.urlopen(req, timeout=60).read().decode("utf-8", "ignore")
imgs = re.findall(
    r"https://vipaccounts\.org/delta-ports/wp-content/uploads/[^\"']+\.(?:webp|jpg|png|svg)",
    html,
    re.I,
)
seen = set()
d = pathlib.Path(
    r"C:\Users\shanm\Local Sites\delta-ports\app\public\wp-content\themes\delta-ports\assets\images"
)
for u in imgs:
    if u in seen:
        continue
    seen.add(u)
    if re.search(r"-\d{2,4}x\d{2,4}\.", u):
        continue
    n = u.rsplit("/", 1)[-1]
    try:
        urllib.request.urlretrieve(u, d / n)
        print("OK", n, (d / n).stat().st_size)
    except Exception as e:
        print("FAIL", n, e)
print("unique", len(seen))
