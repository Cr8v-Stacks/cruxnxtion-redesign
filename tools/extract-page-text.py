"""Customizer phase C2: turn the fixed wording of a page template into editable fields.

  python tools/extract-page-text.py <template.php> <page-key> [--write]

Reads the template, finds every visible piece of text that sits outside PHP code, scripts, styles, forms and
SVG drawings, gives each one a field (id, label, section, type, original wording) and replaces it in the template
with a call that prints the saved value (the original wording when nothing was saved):

    <?php echo crux_h( 'home', 'hero_heading_1' ); ?>

A paragraph, heading or list item that mixes text with bold, italic, line breaks or links becomes ONE field that
keeps those tags (printed through crux_rich()).

Without --write it only prints the fields it would create. With --write it rewrites the template and writes
cruxnxtion-theme/inc/content/<page-key>.php (the fields and their original wording).

Text that a script of the same page compares against is left alone, so no behaviour can break.
"""
import html as htmllib
import os
import re
import sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
THEME = os.path.join(ROOT, 'cruxnxtion-theme')

PHP_RE = re.compile(r'<\?(?:php|=).*?\?>', re.S)
TOKEN_RE = re.compile(
    r'(?P<cmt><!--.*?-->)|(?P<raw><(?P<rawname>script|style|svg|textarea|select|noscript)\b.*?</(?P=rawname)\s*>)|(?P<tag><[^>]+>)|(?P<text>[^<]+)',
    re.S | re.I)
BLOCK_RE = re.compile(r'(<(p|h[1-6]|li|summary)\b[^>]*>)((?:(?!</(?:p|h[1-6]|li|summary)\s*>).)*?)(</(?:p|h[1-6]|li|summary)\s*>)', re.S | re.I)
RICH_PH = re.compile('(\\d+)')
VOID = {'br', 'img', 'hr', 'input', 'meta', 'link', 'source', 'path', 'circle', 'line', 'rect', 'wbr'}
INLINE = {'strong', 'em', 'b', 'i', 'br', 'a', 'span', 'small', 'mark', 'u'}
PH_OPEN, PH_CLOSE = '', ''


def slug(s):
    s = re.sub(r'[^a-z0-9]+', '_', s.lower()).strip('_')
    return s[:28] or 'page'


def section_title(comment):
    c = re.sub(r'^<!--|-->$', '', comment).strip()
    c = re.sub(r'^[\d#.\s]+', '', c)
    c = re.split(r'\s+[—–-]\s+|\(|:', c)[0].strip()
    return c.title() if c.isupper() or c.islower() else c


def kind_of(tag, cls):
    cls = cls or ''
    if tag in ('h1', 'h2', 'h3', 'h4', 'h5', 'h6'):
        return 'heading'
    if tag == 'p':
        return 'paragraph'
    if tag == 'li':
        return 'list item'
    if tag == 'summary':
        return 'question'
    if tag == 'button' or (tag == 'a' and 'bx' in cls.split()):
        return 'button'
    if tag == 'a':
        return 'link'
    if 'eyebrow' in cls or 'kicker' in cls:
        return 'small heading'
    if tag in ('strong', 'b', 'em', 'i'):
        return 'emphasis'
    return 'text'


def resolve(path):
    return path if os.path.isabs(path) or os.path.exists(path) else os.path.join(THEME, path)


def main():
    path, page = sys.argv[1], sys.argv[2]
    write = '--write' in sys.argv
    raw = open(resolve(path), encoding='utf-8', newline='').read()
    crlf = '\r\n' in raw
    src = raw.replace('\r\n', '\n')

    php = []

    def hide(m):
        php.append(m.group(0))
        return PH_OPEN + str(len(php) - 1) + PH_CLOSE

    body_start = src.find('<body')
    head, body = src[:body_start], src[body_start:]
    body = PHP_RE.sub(hide, body)

    # Paragraph-like elements that mix text with inline tags become ONE field holding the inner HTML.
    rich = []

    def hide_rich(m):
        inner = m.group(3)
        tags = re.findall(r'</?\s*([a-zA-Z0-9]+)', inner)
        if not tags or any(t.lower() not in INLINE for t in tags) or PH_OPEN in inner:
            return m.group(0)
        if not re.search(r'[A-Za-z]{2}', htmllib.unescape(re.sub(r'<[^>]+>', '', inner))):
            return m.group(0)
        rich.append(inner)
        return m.group(1) + '' + str(len(rich) - 1) + '' + m.group(4)

    body = BLOCK_RE.sub(hide_rich, body)
    scripts = htmllib.unescape(' '.join(m.group(0) for m in re.finditer(r'<script\b.*?</script>', body, re.S | re.I)))

    out = []
    fields = []          # (key, label, section, type, default)
    used = set()
    counters = {}
    stack = []           # (tag, class, in_form)
    section = 'Page'
    for m in TOKEN_RE.finditer(body):
        tok = m.group(0)
        if m.group('cmt'):
            line_start = body[:m.start()].rsplit('\n', 1)[-1]
            if line_start.strip() == '' and len(line_start) <= 4:
                t = section_title(tok)
                if t:
                    section = t
            out.append(tok)
        elif m.group('raw'):
            out.append(tok)
        elif m.group('tag'):
            out.append(tok)
            nm = re.match(r'</?\s*([a-zA-Z0-9]+)', tok)
            if not nm:
                continue
            name = nm.group(1).lower()
            if tok.startswith('</'):
                for i in range(len(stack) - 1, -1, -1):
                    if stack[i][0] == name:
                        del stack[i:]
                        break
            elif not tok.endswith('/>') and name not in VOID:
                cm = re.search(r'class\s*=\s*"([^"]*)"', tok)
                in_form = name == 'form' or (stack[-1][2] if stack else False)
                stack.append((name, cm.group(1) if cm else '', in_form))
        else:
            text = tok
            core = text.strip()
            in_form = stack[-1][2] if stack else False
            parent = stack[-1] if stack else ('', '', False)
            rm = RICH_PH.fullmatch(core)
            is_rich = bool(rm)
            plain = rich[int(rm.group(1))].strip() if rm else htmllib.unescape(core)
            wanted = (
                core and PH_OPEN not in core and not in_form and parent[0] not in ('title', 'option', 'label', 'th', 'td')
                and (is_rich or re.search(r'[A-Za-z]{2}', plain) or re.fullmatch(r'[\d.,]+\s?[+%KkMm]+', plain))
                and (is_rich or plain not in scripts)
            )
            if not wanted:
                out.append(text)
                continue
            lead = text[:len(text) - len(text.lstrip())]
            trail = text[len(text.rstrip()):]
            fn = 'crux_rich' if is_rich else 'crux_h'
            seen = [f for f in fields if f[2] == section and f[4] == plain]
            if seen:   # the same wording twice in one section (a looping ticker, for example) is one field
                out.append("%s<?php echo %s( '%s', '%s' ); ?>%s" % (lead, fn, page, seen[0][0], trail))
                continue
            kind = kind_of(parent[0], parent[1])
            ck = (section, kind)
            counters[ck] = counters.get(ck, 0) + 1
            n = counters[ck]
            key = slug(section) + '_' + slug(kind) + '_' + str(n)
            while key in used:
                key += 'x'
            used.add(key)
            hint = re.sub(r'\s+', ' ', re.sub(r'<[^>]+>', '', plain)).strip()
            hint = (hint[:34].rstrip() + '...') if len(hint) > 36 else hint
            label = '%s: %s %d (%s)' % (section, kind, n, hint)
            typ = 'rich' if is_rich else ('textarea' if len(plain) >= 90 else 'text')
            fields.append((key, label, section, typ, plain))
            out.append("%s<?php echo %s( '%s', '%s' ); ?>%s" % (lead, fn, page, key, trail))
    new_body = ''.join(out)
    for i in range(len(php) - 1, -1, -1):
        new_body = new_body.replace(PH_OPEN + str(i) + PH_CLOSE, php[i])
    new_src = head + new_body

    print('%s: %d fields' % (path, len(fields)))
    by = {}
    for f in fields:
        by.setdefault(f[2], []).append(f)
    for s, fl in by.items():
        print('  [%s] %d' % (s, len(fl)))
        for f in fl[:80]:
            print('     %-34s %-9s %s' % (f[0], f[3], f[4][:78].replace('\n', ' ')))
    if not write:
        return

    def q(s):
        return "'" + s.replace('\\', '\\\\').replace("'", "\\'") + "'"
    lines = ['<?php', '/**', ' * Editable wording of the "%s" page: field => section, label, type, original wording.' % page,
             ' * Generated by tools/extract-page-text.py; labels and sections may be edited by hand.', ' */', "if ( ! defined( 'ABSPATH' ) ) {", '\texit;', '}', 'return array(']
    for key, label, sec, typ, default in fields:
        lines.append("\t%s => array( %s, %s, %s, %s )," % (q(key), q(sec), q(label), q(typ), q(default)))
    lines.append(');')
    os.makedirs(os.path.join(THEME, 'inc', 'content'), exist_ok=True)
    open(os.path.join(THEME, 'inc', 'content', page + '.php'), 'w', encoding='utf-8', newline='').write('\n'.join(lines) + '\n')
    open(resolve(path), 'w', encoding='utf-8', newline='').write(new_src.replace('\n', '\r\n') if crlf else new_src)
    print('written')


main()
