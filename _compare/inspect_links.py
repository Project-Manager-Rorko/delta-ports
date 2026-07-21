import pathlib, re

t = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\home-live.html").read_text(
    encoding="utf-8", errors="ignore"
)
print("len", len(t))
print("stylesheet count", t.lower().count("stylesheet"))
# any css
for m in re.finditer(r".{0,60}\.css.{0,80}", t):
    s = m.group(0)
    if "font" in s.lower() and "css" in s:
        continue
    print(s[:140])
print("--- link tags sample ---")
for m in re.finditer(r"<link[^>]+>", t[:50000]):
    print(m.group(0)[:200])
