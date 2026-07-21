import pathlib, re

c = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css\post-3702.css").read_text(
    encoding="utf-8", errors="ignore"
)
print("map count", c.count("delta-map"))
i = c.find("delta-map")
print(c[i - 200 : i + 250] if i >= 0 else "none")
imgs = set(re.findall(r'url\("([^"]+)"\)', c))
for u in sorted(imgs):
    low = u.lower()
    if any(k in low for k in ["map", "business", "operation", "award", "component", "leader"]):
        print(u)
