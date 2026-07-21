import re, pathlib

css = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css\post-3702.css").read_text(
    encoding="utf-8", errors="ignore"
)
child = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css\style.css").read_text(
    encoding="utf-8", errors="ignore"
)
all_css = css + "\n" + child

# Awards image widget ids from earlier: 7f04113, 62d6f4f, f7450fa, and maybe more
# search Awards-new in css
print("Awards-new in css", "Awards-new" in all_css)
for kw in ["4065", "4064", "4063", "7f04113", "62d6f4f", "f7450fa", "1e4da35", "d946b54", "67fd498", "737b60d"]:
    print("\n==", kw)
    for m in re.finditer(re.escape(kw), all_css):
        start = all_css.rfind("}", 0, m.start())
        start = 0 if start < 0 else start + 1
        end = all_css.find("}", m.end())
        if end < 0:
            continue
        print(all_css[start : end + 1].strip()[:350])

# business related - berths metrics and brand grid
for kw in ["9f02efb", "d52efc9", "896c8fe", "d7a9dd3", "4cba280", "988e078", "ffd534b", "Marmagoa", "25M"]:
    if kw in all_css:
        print("found", kw)

# search background map business section
for m in re.finditer(r"delta-map-sec[^\)]+", all_css):
    start = max(0, m.start() - 200)
    print(all_css[start : m.end() + 100][:350])
    break

# extract full integrate-cap and hover-card from child style
for block_name in [".integrate-cap-new-sec", ".hover-card"]:
    i = child.find(block_name)
    print("\nCHILD", block_name, "at", i)
    if i >= 0:
        print(child[i : i + 1200])
