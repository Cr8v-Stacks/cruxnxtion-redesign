"""Proves the colour-token rewrite changed no colour: every CSS file, with var(--crux-x,#hex) turned back into #hex, must equal git HEAD."""
import glob, re, subprocess

bad = 0
for f in sorted(glob.glob('cruxnxtion-theme/assets/css/*.css')):
    f = f.replace(chr(92), '/')
    new = open(f, encoding='utf-8').read().replace('\r\n', '\n')
    new = re.sub(r'var\(--crux-\w+,(#[0-9A-Fa-f]{6})\)', r'\1', new)
    old = subprocess.run(['git', 'show', 'HEAD:' + f], capture_output=True).stdout.decode('utf-8').replace('\r\n', '\n')
    if old != new:
        bad += 1
        print('DIFF', f)
print('css files differing:', bad)
