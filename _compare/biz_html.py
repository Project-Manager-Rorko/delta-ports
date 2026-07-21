import pathlib, re, html as H

live = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").read_text(
    encoding="utf-8", errors="ignore"
)
idx = live.find("Group Delta encompasses companies")
chunk = live[idx - 3000 : idx + 12000]
# find parent background
print("has map bg", "delta-map" in chunk)
print("has dark", "1A1A2E" in chunk or "background" in chunk[:500])
# list button texts
for m in re.finditer(r"elementor-button-text[^>]*>([^<]+)", chunk):
    print("BTN", m.group(1))
for m in re.finditer(r"elementor-heading-title[^>]*>([^<]{1,80})", chunk):
    t = H.unescape(m.group(1)).strip()
    if t:
        print("H", t)
# images in chunk
for m in re.finditer(r'src="(https://[^"]+)"', chunk):
    print("IMG", m.group(1))
# data-settings background
for m in re.finditer(r"background_image[^,]{0,200}", chunk):
    print("BGSET", m.group(0)[:200])
# style background-image
for m in re.finditer(r"url\(([^)]+)\)", chunk):
    print("URL", m.group(1)[:180])
