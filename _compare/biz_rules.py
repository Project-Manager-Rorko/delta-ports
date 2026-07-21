import re, pathlib

css = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css\post-3702.css").read_text(
    encoding="utf-8", errors="ignore"
)
for kw in ["9f02efb", "d52efc9", "896c8fe", "d7a9dd3", "4cba280", "988e078", "ffd534b", "a65b8d9"]:
    print("\n====", kw)
    for m in re.finditer(re.escape(kw), css):
        start = css.rfind("}", 0, m.start())
        start = 0 if start < 0 else start + 1
        end = css.find("}", m.end())
        print(css[start : end + 1].strip()[:450])

# download component-7 and mob ops
import urllib.request

dest = pathlib.Path(
    r"C:\Users\shanm\Local Sites\delta-ports\app\public\wp-content\themes\delta-ports\assets\images"
)
for u in [
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/Component-7.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-operation-delta-port1.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-operation-delta-port2.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/06/our-operation-delta-port3.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/05/mob-operation-01.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/05/mob-operation-02.webp",
    "https://vipaccounts.org/delta-ports/wp-content/uploads/2026/05/mob-operation-03.webp",
]:
    name = u.rsplit("/", 1)[-1]
    try:
        urllib.request.urlretrieve(u, dest / name)
        print("DL", name, (dest / name).stat().st_size)
    except Exception as e:
        print("FAIL", name, e)
