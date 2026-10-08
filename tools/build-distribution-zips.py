"""Build the upload zips into dist/ (git-ignored).

  python tools/build-distribution-zips.py

Rules (the client's host limits upload size, and a zip must have exactly one top folder with forward slashes):
  - one small zip per plugin: cr8v-events-core, cr8v-event-ticketing (tests left out), crux-nxtion-core
  - the theme code zip holds everything except photos and videos
  - photos and videos go into numbered zips of about 4.5 MB each, same top folder; extract them over the theme folder
"""
import os, sys, zipfile

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
DIST = os.path.join(ROOT, 'dist')
MEDIA = ('.png', '.jpg', '.jpeg', '.webp', '.gif', '.mp4', '.webm', '.mov', '.avif')
LIMIT = int(4.5 * 1024 * 1024)
SKIP_DIRS = {'.git', 'node_modules', '__pycache__'}


def files_of(folder, skip=()):
    base = os.path.join(ROOT, folder)
    for dp, dn, fn in os.walk(base):
        dn[:] = sorted(d for d in dn if d not in SKIP_DIRS and os.path.relpath(os.path.join(dp, d), base).replace(os.sep, '/') not in skip)
        for f in sorted(fn):
            full = os.path.join(dp, f)
            yield full, folder + '/' + os.path.relpath(full, base).replace(os.sep, '/')


def write(zip_name, items):
    path = os.path.join(DIST, zip_name)
    with zipfile.ZipFile(path, 'w', zipfile.ZIP_DEFLATED) as z:
        for full, arc in items:
            z.write(full, arc)
    print('%-42s %8.2f MB  %d files' % (zip_name, os.path.getsize(path) / 1048576, len(items)))


def main():
    os.makedirs(DIST, exist_ok=True)
    for f in os.listdir(DIST):
        if f.endswith('.zip'):
            os.remove(os.path.join(DIST, f))
    write('cr8v-events-core.zip', list(files_of('cr8v-events-core')))
    write('cr8v-event-ticketing.zip', list(files_of('cr8v-event-ticketing', skip=('tests',))))
    write('crux-nxtion-core.zip', list(files_of('crux-nxtion-core')))
    # Raw photo drafts that the theme never references stay out (they are git-ignored for the same reason).
    theme = list(files_of('cruxnxtion-theme', skip=('assets/images/crux-photos', 'assets/images/live-site', 'assets/images/reference', 'assets/images/stock')))
    write('cruxnxtion-theme-code.zip', [t for t in theme if not t[1].lower().endswith(MEDIA)])
    media = [t for t in theme if t[1].lower().endswith(MEDIA)]
    chunk, size, n = [], 0, 1
    for item in media:
        s = os.path.getsize(item[0])
        if chunk and size + s > LIMIT:
            write('cruxnxtion-theme-media-%02d.zip' % n, chunk)
            chunk, size, n = [], 0, n + 1
        chunk.append(item)
        size += s
    if chunk:
        write('cruxnxtion-theme-media-%02d.zip' % n, chunk)
    # Self-check: one top folder, forward slashes.
    for f in sorted(os.listdir(DIST)):
        if f.endswith('.zip'):
            names = zipfile.ZipFile(os.path.join(DIST, f)).namelist()
            tops = {x.split('/')[0] for x in names}
            if len(tops) != 1 or any(chr(92) in x for x in names):
                sys.exit('BAD ZIP LAYOUT: ' + f)
    print('all zips have one top folder and forward-slash paths')


main()
