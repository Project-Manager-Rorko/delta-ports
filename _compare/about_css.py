import re, urllib.request, pathlib

html = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\_compare\about-live.html").read_text(
    encoding="utf-8", errors="ignore"
)
posts = re.findall(r"uploads/elementor/css/post-(\d+)\.css", html)
print("posts", posts)
# about page is likely largest content post
for pid in posts:
    url = f"https://vipaccounts.org/delta-ports/wp-content/uploads/elementor/css/post-{pid}.css"
    try:
        css = urllib.request.urlopen(
            urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"}), timeout=40
        ).read().decode("utf-8", "ignore")
    except Exception as e:
        print("fail", pid, e)
        continue
    if "vision-mission" in css or "01ad97a" in css or "Vision" in css:
        print("HIT", pid, len(css))
        pathlib.Path(rf"C:\Users\shanm\Local Sites\delta-ports\_compare\live-css\post-{pid}.css").write_text(
            css, encoding="utf-8"
        )
        for eid in ["01ad97a", "b556dc7", "af0be44", "vision-mission"]:
            if eid in css:
                print("---", eid)
                for m in re.finditer(re.escape(eid), css):
                    start = css.rfind("}", 0, m.start())
                    start = 0 if start < 0 else start + 1
                    end = css.find("}", m.end())
                    print(css[start : end + 1][:400])
                    break
        # all background images
        for u in re.findall(r'url\("([^"]+)"\)', css):
            if "upload" in u:
                print("IMG", u)
