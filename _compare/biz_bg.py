import pathlib, re

css = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css\post-3702.css").read_text(
    encoding="utf-8", errors="ignore"
)
# find delta-map rules fully
for m in re.finditer(r"delta-map-sec[^\)]+\)", css):
    start = css.rfind("{", 0, m.start())
    # go back to selector start
    sel_start = css.rfind("}", 0, start)
    sel_start = 0 if sel_start < 0 else sel_start + 1
    end = css.find("}", m.end())
    print(css[sel_start : end + 1].strip()[:500])
    print("---")

# find Our Business heading size
for m in re.finditer(r"Our Business", css):
    pass
# search for large heading near business - look for font-size:56px contexts already have d7a9dd3

# extract brand button section parent - look for marquee class
live = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").read_text(
    encoding="utf-8", errors="ignore"
)
idx = live.find("Group Delta encompasses")
chunk = live[idx - 5000 : idx + 15000]
# class names containing marquee, slider, carousel, brand
classes = set(re.findall(r'class="([^"]+)"', chunk))
for c in sorted(classes):
    if any(k in c.lower() for k in ["marque", "slider", "carousel", "brand", "business", "owl", "swiper", "logo"]):
        print("C", c[:180])
