"""Customizer phase C5: make the address of text buttons and links editable.

  python tools/extract-link-urls.py <template.php> <page-key> [--write]

For every <a> whose only content is a crux_h() call (a button or text link) and whose href is either a fixed address
inside the site, home_url( "/path/" ), or a fixed outside address, adds a URL field "<text key>_url" whose default is
that address, and replaces the href by  <?php echo crux_url( 'page', 'key_url' ); ?> .
Hrefs that depend on code (event links, anchors #..., site-wide settings) are left alone.
"""
import os, re, sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
THEME = os.path.join(ROOT, 'cruxnxtion-theme')
PHP_RE = re.compile(r'<\?(?:php|=).*?\?>', re.S)
PH_O, PH_C = '', ''
BS = chr(92)


def q(s):
    return "'" + s.replace(BS, BS + BS).replace("'", BS + "'") + "'"


def main():
    path, page = sys.argv[1], sys.argv[2]
    write = '--write' in sys.argv
    full = os.path.join(THEME, path)
    raw = open(full, encoding='utf-8', newline='').read()
    crlf = '\r\n' in raw
    src = raw.replace('\r\n', '\n')
    start = src.find('<body')
    head, body = src[:start], src[start:]
    php = []

    def hide(m):
        php.append(m.group(0))
        return PH_O + str(len(php) - 1) + PH_C
    body = PHP_RE.sub(hide, body)

    manifest_path = os.path.join(THEME, 'inc', 'content', page + '.php')
    manifest = open(manifest_path, encoding='utf-8').read()
    existing = set(re.findall(r"^\t'(\w+)' =>", manifest, re.M))
    new_fields = []
    seen_text_keys = {}
    HOME = re.compile(r"""^<\?php echo esc_url\( home_url\( (["'])(/[^"']*)\1 \) \); \?>$""")
    CALL = re.compile(r"crux_h\(\s*'%s',\s*'(\w+)'\s*\)" % re.escape(page))

    def sub(m):
        open_tag, inner = m.group(1), m.group(3)
        im = re.fullmatch(r'\s*' + PH_O + r'(\d+)' + PH_C + r'\s*', inner)
        if not im:
            return m.group(0)
        cm = CALL.search(php[int(im.group(1))])
        if not cm:
            return m.group(0)
        hm = re.search(r'\bhref="([^"]*)"', open_tag)
        if not hm:
            return m.group(0)
        hv = hm.group(1)
        default = None
        pm = re.fullmatch(PH_O + r'(\d+)' + PH_C, hv)
        if pm:
            hh = HOME.match(php[int(pm.group(1))])
            if hh:
                default = hh.group(2)
        elif re.match(r'https?://', hv):
            default = hv.replace('&amp;', '&')
        if default is None:
            return m.group(0)
        tkey = cm.group(1)
        ukey = tkey + '_url'
        if ukey in existing or any(f[0] == ukey for f in new_fields):
            pass
        else:
            new_fields.append((ukey, tkey, default))
        php.append("<?php echo crux_url( '%s', '%s' ); ?>" % (page, ukey))
        return open_tag.replace('href="' + hv + '"', 'href="' + PH_O + str(len(php) - 1) + PH_C + '"', 1) + inner + m.group(4)

    body = re.sub(r'(<a\b[^<>]*>)(([^<>]*))(</a\s*>)', sub, body)
    for i in range(len(php) - 1, -1, -1):
        body = body.replace(PH_O + str(i) + PH_C, php[i])
    print('%s: %d address fields' % (path, len(new_fields)))
    if not write or not new_fields:
        return
    rows = {}
    for mm in re.finditer(r"^\t'(\w+)' => array\( '((?:[^'" + BS + BS + r"]|" + BS + BS + r".)*)', '((?:[^'" + BS + BS + r"]|" + BS + BS + r".)*)'", manifest, re.M):
        rows[mm.group(1)] = (mm.group(2), mm.group(3))
    add = []
    for ukey, tkey, default in new_fields:
        sec, label = rows.get(tkey, ('Page', tkey))
        label = re.sub(r':.*$', '', label) + ' address'
        add.append("\t%s => array( %s, %s, 'url', %s )," % (q(ukey), q(sec), q(label), q(default)))
    manifest = manifest.rstrip()
    assert manifest.endswith(');')
    manifest = manifest[:-2].rstrip('\n') + '\n' + '\n'.join(add) + '\n);\n'
    open(manifest_path, 'w', encoding='utf-8', newline='').write(manifest)
    new = head + body
    open(full, 'w', encoding='utf-8', newline='').write(new.replace('\n', '\r\n') if crlf else new)
    print('written')


main()
