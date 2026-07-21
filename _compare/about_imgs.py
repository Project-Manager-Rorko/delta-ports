import re, urllib.request, pathlib, html as H

req = urllib.request.Request(
    "https://vipaccounts.org/delta-ports/about-us/",
    headers={"User-Agent": "Mozilla/5.0"},
)
html = urllib.request.urlopen(req, timeout=60).read().decode("utf-8", "ignore")
pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\about-live.html").write_text(
    html, encoding="utf-8"
)

# All full images
imgs = re.findall(r'src="(https://vipaccounts\.org/delta-ports/wp-content/uploads/[^"]+)"', html)
seen = set()
for u in imgs:
    if re.search(r"-\d{2,4}x\d{2,4}\.", u):
        continue
    if u in seen:
        continue
    seen.add(u)
    print(u)

# Vision mission nearby
for key in ["Vision", "Mission", "Operating Philosophy", "Safety and Responsibility"]:
    i = html.find(key)
    print("\n---", key, i)
    if i > 0:
        chunk = html[i : i + 2500]
        for m in re.finditer(r'src="(https://[^"]+)"', chunk):
            print(" ", m.group(1))
