#!/usr/bin/env python3
"""Replace the brand hex colours in the theme's CSS and inline styles with var(--crux-<token>, <hex>).

The fallback is the original hex, so nothing changes until a colour is set in the Customizer.
Only CSS files, style="..." attributes and <style> blocks are touched (SVG presentation attributes and JS cannot use var()).
Idempotent: values already wrapped in var() are left alone.
"""
import re
import sys
from pathlib import Path

TOKENS = {
    "navy": "002671", "blue": "5B8DEF", "red": "BA0000", "crimson": "E5383B", "purple": "8C7AE6",
    "violet": "6C58DB", "ink": "0A0F26", "ink2": "10142E", "surface": "111838", "line": "1E2B5E", "text": "F4F5FA",
}
BY_HEX = {v.lower(): k for k, v in TOKENS.items()}
HEX = re.compile(r"(?<![\w&])#([0-9A-Fa-f]{6})(?![0-9A-Fa-f])")
WRAPPED = re.compile(r"var\(--crux-\w+,\s*#[0-9A-Fa-f]{6}\)")


def sub_hex(chunk):
    out, last = [], 0
    for w in WRAPPED.finditer(chunk):
        out.append(HEX.sub(repl, chunk[last:w.start()]))
        out.append(w.group(0))
        last = w.end()
    out.append(HEX.sub(repl, chunk[last:]))
    return "".join(out)


def repl(m):
    tok = BY_HEX.get(m.group(1).lower())
    return "var(--crux-%s,#%s)" % (tok, m.group(1)) if tok else m.group(0)


def process_php(text):
    text = re.sub(r'(style=")([^"]*)(")', lambda m: m.group(1) + sub_hex(m.group(2)) + m.group(3), text)
    text = re.sub(r"('(?:body_bg|root_bg)'\s*=>\s*')(#[0-9A-Fa-f]{6})(')", lambda m: m.group(1) + sub_hex(m.group(2)) + m.group(3), text)
    text = re.sub(r"(\.style\.\w+\s*=\s*')(#[0-9A-Fa-f]{6})(')", lambda m: m.group(1) + sub_hex(m.group(2)) + m.group(3), text)
    text = re.sub(r"(\? \$\w+\['badge_bg'\] : ')(#[0-9A-Fa-f]{6})(')", lambda m: m.group(1) + sub_hex(m.group(2)) + m.group(3), text)
    text = re.sub(r"(<style[^>]*>)(.*?)(</style>)", lambda m: m.group(1) + sub_hex(m.group(2)) + m.group(3), text, flags=re.S)
    return text


def main(root):
    root = Path(root)
    files = [p for p in root.glob("*.php")] + list((root / "parts").glob("*.php"))
    files += list((root / "inc" / "content").glob("*.php"))
    files += [p for p in (root / "inc").glob("*.php") if p.name not in ("blog-seed-data.php", "customizer-colours.php")]
    changed = 0
    for p in files:
        t = p.read_text(encoding="utf-8")
        n = process_php(t)
        if n != t:
            p.write_text(n, encoding="utf-8", newline="")
            changed += 1
    for p in (root / "assets" / "css").glob("*.css"):
        t = p.read_text(encoding="utf-8")
        n = sub_hex(t)
        if n != t:
            p.write_text(n, encoding="utf-8", newline="")
            changed += 1
    print("files changed:", changed)


if __name__ == "__main__":
    main(sys.argv[1] if len(sys.argv) > 1 else "cruxnxtion-theme")
