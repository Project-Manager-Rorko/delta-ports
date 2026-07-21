import re, urllib.request, pathlib

live = urllib.request.urlopen("https://vipaccounts.org/delta-ports/", timeout=60).read().decode("utf-8", "ignore")
urls = re.findall(r"https://vipaccounts\.org/delta-ports/wp-content/uploads/[^\"'\s>]+\.(?:webp|jpg|jpeg|png)", live, re.I)
seen = set()
out = []
for u in urls:
    if u not in seen:
        seen.add(u)
        out.append(u)
print("TOTAL", len(out))
for u in out:
    low = u.lower()
    if any(k in low for k in ["leader", "leadership", "operation", "media", "award", "banner", "ahmed", "shamil", "mohi"]):
        print(u)

# download leadership-ish
dest = pathlib.Path(r"C:\Users\shanm\Local Sites\delta-ports\app\public\wp-content\themes\delta-ports\assets\images")
want = [u for u in out if any(k in u.lower() for k in ["leader", "leadership", "our-leadership", "des-banner-port-leadership", "port-leadership"])]
print("WANT", len(want))
for u in want:
    name = u.split("/")[-1].split("?")[0]
    path = dest / name
    try:
        urllib.request.urlretrieve(u, path)
        print("OK", name, path.stat().st_size)
    except Exception as e:
        print("FAIL", name, e)
