import re, urllib.request, pathlib

urls = [
    "https://vipaccounts.org/delta-ports/wp-content/uploads/elementor/css/post-3702.css?ver=1784316638",
    "https://vipaccounts.org/delta-ports/wp-content/themes/hello-theme-child-new/style.css?ver=1783686406",
]
out = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css")
out.mkdir(exist_ok=True)
all_css = ""
for u in urls:
    req = urllib.request.Request(u, headers={"User-Agent": "Mozilla/5.0"})
    css = urllib.request.urlopen(req, timeout=60).read().decode("utf-8", "ignore")
    name = u.split("/")[-1].split("?")[0]
    (out / name).write_text(css, encoding="utf-8")
    all_css += "\n" + css
    print("OK", name, len(css))

(out / "home-live-styles.css").write_text(all_css, encoding="utf-8")

# extract rules for key elements
keys = [
    "3213dda",
    "ef56cf8",
    "ea4ba2e",
    "integrate-cap",
    "hover-card",
    "7f04113",
    "62d6f4f",
    "f7450fa",
    "d946b54",
    "cc1efdd",
    "a65b8d9",
    "our-business",
    "Awards",
]
for k in keys:
    print("\n========", k)
    # find all occurrences with surrounding braces
    for m in re.finditer(re.escape(k), all_css, re.I):
        # expand to full rule approx
        start = all_css.rfind("}", 0, m.start())
        start = 0 if start < 0 else start + 1
        end = all_css.find("}", m.end())
        if end < 0:
            continue
        rule = all_css[start : end + 1].strip()
        if len(rule) > 15:
            print(rule[:400])
