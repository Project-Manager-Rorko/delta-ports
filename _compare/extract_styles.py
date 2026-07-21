import re, pathlib, json

live = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").read_text(encoding="utf-8", errors="ignore")

# Find style tags content related to ops/business/awards
styles = re.findall(r"<style[^>]*>(.*?)</style>", live, re.I | re.S)
all_css = "\n".join(styles)
print("style blocks", len(styles), "css len", len(all_css))

for kw in [
    "integrate-cap-new-sec",
    "hover-card",
    "our-open-new-sec",
    "Awards-new",
    "our-business",
    "bsi-text",
    "all-heading-new-sec",
]:
    hits = [line.strip() for line in all_css.splitlines() if kw.lower() in line.lower()]
    print(f"\n=== {kw} ({len(hits)}) ===")
    for h in hits[:25]:
        print(h[:200])

# element settings with background image for ops cards
# data-settings often has background
for m in re.finditer(r'integrate-cap-new-sec[^>]{0,200}data-settings="([^"]+)"', live):
    raw = __import__("html").unescape(m.group(1))
    print("\nSETTINGS", raw[:300])

# background-image urls near integrate-cap
for m in re.finditer(r"integrate-cap-new-sec[\s\S]{0,800}?url\(([^)]+)\)", live):
    print("BG", m.group(1)[:200])

# also look for --background / style= background on those containers
for m in re.finditer(r'(class="[^"]*integrate-cap-new-sec[^"]*"[^>]*)>', live):
    tag = m.group(1)
    if "style=" in tag or "background" in tag:
        print("TAG", tag[:300])

# Find elementor CSS file links and try inline element styles for image 3213dda etc
for eid in ["3213dda", "ef56cf8", "ea4ba2e", "cc1efdd", "7f04113"]:
    # post-3213dda or elementor-element-3213dda in css
    hits = re.findall(rf"\.elementor-element-{eid}[^{{]*\{{[^}}]+}}", all_css)
    print(f"\nEID {eid} rules", len(hits))
    for h in hits[:8]:
        print(h[:250])

# business brand images
idx = live.find("Ceramic Pro")
print("\nCeramic context", live[idx - 500 : idx + 300] if idx > 0 else "none")

# awards image container CSS
hits = [line for line in all_css.splitlines() if "4065" in line or "Awards" in line or "award" in line.lower()]
print("\nAwards css lines", len(hits))
for h in hits[:20]:
    print(h.strip()[:200])
