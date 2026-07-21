import re, pathlib, urllib.request

live = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").read_text(
    encoding="utf-8", errors="ignore"
)
links = re.findall(r'href="(https://vipaccounts.org/delta-ports/wp-content/[^"]+\.css[^"]*)"', live)
print("css count", len(links))
for u in links:
    print(u)

# also any post css relative
links2 = re.findall(r'href="([^"]*elementor/css/[^"]+)"', live)
print("elementor css", links2)

out = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css")
out.mkdir(exist_ok=True)

interesting = []
for u in links + links2:
    if "post-" in u or "widget-" in u or "frontend" in u or "custom" in u:
        interesting.append(u)

# always grab post css for home if present
for u in links:
    if re.search(r"post-\d+", u):
        interesting.append(u)

interesting = list(dict.fromkeys(interesting))
print("interesting", len(interesting))

combined = []
for u in interesting[:15]:
    try:
        req = urllib.request.Request(u, headers={"User-Agent": "Mozilla/5.0"})
        css = urllib.request.urlopen(req, timeout=40).read().decode("utf-8", "ignore")
        name = re.sub(r"[^a-zA-Z0-9._-]+", "_", u.split("/")[-1])[:80]
        (out / name).write_text(css, encoding="utf-8")
        combined.append(css)
        print("OK", name, len(css))
    except Exception as e:
        print("FAIL", u, e)

all_css = "\n".join(combined)
(out / "combined.css").write_text(all_css, encoding="utf-8")

for kw in [
    "integrate-cap-new-sec",
    "hover-card",
    "3213dda",
    "ef56cf8",
    "ea4ba2e",
    "Awards-new",
    "7f04113",
    "our-business",
    "background-image",
    "min-height",
]:
    print("\n====", kw)
    # print nearby rules
    for m in re.finditer(re.escape(kw), all_css, re.I):
        start = max(0, m.start() - 80)
        end = min(len(all_css), m.end() + 200)
        print(all_css[start:end].replace("\n", " ")[:280])
        break
    # count
    print("count", len(re.findall(re.escape(kw), all_css, re.I)))
