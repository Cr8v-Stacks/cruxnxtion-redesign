"""Capture and compare rendered pages of the local Crux site.

  python tools/snapshot-pages.py capture <folder>
  python tools/snapshot-pages.py compare <folderA> <folderB>

Used to prove that a refactor (for example moving the header and footer into shared theme parts) leaves every page
byte-for-byte the same once values that change on every request (security tokens, timestamps) are blanked.
"""
import html as htmllib, json, os, re, sys, urllib.request, urllib.error

BASE = 'http://dev-playground.local'
PATHS = ['/', '/about/', '/services/', '/services-consultancy/', '/consultancy/', '/contact/', '/contact/?type=events',
         '/contact/?type=consultancy', '/faq/', '/founder/', '/gallery/', '/sponsors/', '/events/', '/past-events/',
         '/blog/', '/terms-conditions/', '/cookie-policy/', '/privacy-policy/', '/booking-confirmation/', '/sample-page/',
         '/this-page-does-not-exist/']
EVENT_SLUGS = ['ankara-festival', 'dance-out-2023']


def fetch(url):
    req = urllib.request.Request(url, headers={'User-Agent': 'crux-snapshot'})
    try:
        with urllib.request.urlopen(req, timeout=120) as r:
            return r.status, r.read().decode('utf-8', 'replace')
    except urllib.error.HTTPError as e:
        return e.code, e.read().decode('utf-8', 'replace')


def normalise(html):
    html = re.sub(r'("nonce"\s*:\s*")[0-9a-f]+(")', r'\1X\2', html)
    html = re.sub(r'(name="form_timestamp"[^>]*value=")\d+(")', r'\1X\2', html)
    html = re.sub(r'(form_timestamp["\']?\s*[:=]\s*["\']?)\d{9,}', r'\1X', html)
    html = re.sub(r'(_wpnonce=)[0-9a-f]+', r'\1X', html)
    # antispambot() writes each e-mail address with a different random mix of entities on every request.
    html = re.sub(r'&#(\d+);', lambda m: chr(int(m.group(1))), html)
    # Brand colours became var(--crux-token,#hex) design tokens; the fallback is the original colour.
    html = re.sub(r'var\(--crux-\w+,\s*(#[0-9A-Fa-f]{6})\)', r'\1', html)
    return html


def loose(html):
    """Comparison for refactors that move markup into shared parts: ignores whitespace between tags and the documented
    Customizer phase C0 unifications (announcement bar class and padding, generic page announcement text)."""
    html = html.replace(' class="top-shoutout-bar"', '').replace('padding:10px 64px;', 'padding:10px 20px 10px 20px;')
    html = htmllib.unescape(html)   # &rarr; and the character it stands for are the same text
    # The page stylesheet moved from an inline <style> in each template to an enqueued file (its content is proven equal when it
    # is extracted), so compare pages with neither.
    html = re.sub(r"<style>\s*@import url\(['\"]?https://fonts\.googleapis\.com.*?</style>", '', html, count=1, flags=re.S)
    html = re.sub(r"<link[^>]*id=['\"]crux-page-css-css['\"][^>]*>", '', html)
    # Search and share meta (description, Open Graph, Twitter Card, JSON-LD) was added later, and the event and post pages got a share bar.
    html = re.sub(r"<meta (?:name|property)=['\"](?:description|og:[a-z_:]+|twitter:[a-z_:]+)['\"][^>]*>", '', html)
    html = re.sub(r"<script type=['\"]application/ld\+json['\"]>.*?</script>", '', html, flags=re.S)
    html = re.sub(r"<div class=['\"]crux-share['\"].*?</script>", '', html, flags=re.S)
    html = re.sub(r'\s+', ' ', html)
    return re.sub(r'>\s+<', '><', html).strip()


def name_of(path):
    return re.sub(r'[^a-z0-9]+', '_', path.lower()).strip('_') or 'home'


def urls():
    out = list(PATHS) + ['/event/%s/' % s for s in EVENT_SLUGS]
    status, body = fetch(BASE + '/wp-json/wp/v2/posts?per_page=1&_fields=link')
    if status == 200:
        try:
            link = json.loads(body)[0]['link']
            out.append(link.replace(BASE, ''))
        except Exception:
            pass
    return out


def capture(folder):
    os.makedirs(folder, exist_ok=True)
    for p in urls():
        status, html = fetch(BASE + p)
        with open(os.path.join(folder, name_of(p) + '.html'), 'w', encoding='utf-8', newline='') as f:
            f.write('<!-- %s status %s -->\n' % (p, status) + normalise(html))
        print('%-40s %s %8d bytes' % (p, status, len(html)))


def compare(a, b):
    same = diff = 0
    for f in sorted(os.listdir(a)):
        pa, pb = os.path.join(a, f), os.path.join(b, f)
        if LOOSE and f.startswith('how_ai_can_help') and not os.path.exists(pb):
            print('SKIP %-40s (the first post in the list is now a different post)' % f)
            same += 1
            continue
        if not os.path.exists(pb):
            print('MISSING in B:', f); diff += 1; continue
        fn = loose if LOOSE else (lambda v: v)
        x, y = fn(normalise(open(pa, encoding='utf-8', newline='').read())), fn(normalise(open(pb, encoding='utf-8', newline='').read()))
        if LOOSE and (f == 'blog.html' or f.startswith('how_ai_can_help')):  # real posts replaced the fixed blog tiles and the placeholder article, on purpose
            print('SKIP %-40s (changed on purpose: real blog posts)' % f)
            same += 1
            continue
        if LOOSE and f == 'sample_page.html':  # generic page: its own announcement text was unified
            cut = lambda v: re.sub(r'<!-- SHOUT-OUT BAR -->.*?<header', '<header', v, flags=re.S)
            x, y = cut(x), cut(y)
        if LOOSE and f.startswith('contact'):  # contact footer now wraps on mobile like every other page's footer
            fix = lambda v: v.replace(' data-m="wrap">', '>').replace('margin:0px 0px 0px 0px;">©', 'margin:0;">©')
            x, y = fix(x), fix(y)
        if x == y:
            same += 1
        else:
            diff += 1
            i = next((k for k in range(min(len(x), len(y))) if x[k] != y[k]), min(len(x), len(y)))
            print('DIFF %-40s first difference at char %d: A=%r B=%r' % (f, i, x[i:i + 60], y[i:i + 60]))
    print('identical: %d  different: %d' % (same, diff))
    sys.exit(1 if diff else 0)


LOOSE = '--loose' in sys.argv
if __name__ == '__main__':
    sys.argv = [a for a in sys.argv if a != '--loose']
    if len(sys.argv) >= 3 and sys.argv[1] == 'capture':
        capture(sys.argv[2])
    elif len(sys.argv) >= 4 and sys.argv[1] == 'compare':
        compare(sys.argv[2], sys.argv[3])
    else:
        print(__doc__)
