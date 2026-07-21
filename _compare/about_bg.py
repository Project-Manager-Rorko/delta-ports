import re, pathlib

html = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\about-live.html").read_text(
    encoding="utf-8", errors="ignore"
)
# background urls
for m in re.finditer(r"url\(([^)]+)\)", html):
    u = m.group(1).strip("\"'")
    if "upload" in u:
        print("BG", u)

# near vision
i = html.lower().find("vision")
print(html[i : i + 3500][:3500])
