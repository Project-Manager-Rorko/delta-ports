import re, html, pathlib

live = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").read_text(encoding="utf-8", errors="ignore")

# Find Our Business block - search for unique text
markers = [
    "Our Business",
    "Group Delta encompasses",
    "MT Cargo Handled",
    "Awards, Recognition",
    "Our Operations",
    "Port-Led Operations",
    "Cargo & Terminal Infrastructure",
]


def extract_between(start_kw, end_kw=None, after=0, length=8000):
    i = live.lower().find(start_kw.lower(), after)
    if i < 0:
        return "", -1
    j = i + length
    if end_kw:
        k = live.lower().find(end_kw.lower(), i + 20)
        if k > i:
            j = k
    return live[i:j], i


# Business section: from "Our Business" heading near encompasses
chunk, pos = extract_between("Group Delta encompasses companies", "Awards, Recognition", length=12000)
if not chunk:
    chunk, pos = extract_between("Our Business", "Media", length=12000)
print("BUSINESS POS", pos, "LEN", len(chunk))
# Clean text
texts = re.findall(r">([^<]{3,120})<", chunk)
print("BUSINESS TEXTS:")
for t in texts:
    t = html.unescape(re.sub(r"\s+", " ", t)).strip()
    if t and "elementor" not in t.lower() and not t.startswith("{"):
        print(" |", t)

imgs = re.findall(r'src="(https://[^"]+)"', chunk)
print("BUSINESS IMGS:")
for u in imgs:
    if any(x in u.lower() for x in ["business", "logo", "upload", "svg", "webp", "png"]):
        print(" ", u)

# Operations section
chunk2, pos2 = extract_between("Our Operations", "Sustainability", length=15000)
print("\nOPS POS", pos2, "LEN", len(chunk2))
texts2 = re.findall(r">([^<]{3,160})<", chunk2)
print("OPS TEXTS:")
for t in texts2:
    t = html.unescape(re.sub(r"\s+", " ", t)).strip()
    if t and "elementor" not in t.lower() and "menu" not in t.lower():
        print(" |", t)
imgs2 = re.findall(r'src="(https://[^"]+)"', chunk2)
print("OPS IMGS:")
for u in imgs2:
    print(" ", u)

# Awards
chunk3, pos3 = extract_between("Awards, Recognition", "Our Business", length=8000)
print("\nAWARDS POS", pos3, "LEN", len(chunk3))
imgs3 = re.findall(r'src="(https://[^"]+)"', chunk3)
print("AWARDS IMGS:")
for u in imgs3:
    print(" ", u)
# image dimensions hints
for u in imgs3:
    m = re.search(r"-(\d+)x(\d+)\.", u)
    if m:
        print("  size hint", m.group(1), m.group(2), u)
    else:
        print("  full", u)

# Write cleaned business HTML snippet for reference
pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\business-raw.html").write_text(chunk[:15000], encoding="utf-8")
pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\ops-raw.html").write_text(chunk2[:15000], encoding="utf-8")
