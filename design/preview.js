// Builds a local, self-contained preview of every page. Usage (from the repo root):
//   node design/preview.js && npx serve design/preview
// then open http://localhost:3000. Pages reference images as /_blob/<id>; here those are mapped to design/images/by-blob-id/<id>.jpg.
const fs = require('fs'), path = require('path');
const D = __dirname, OUT = path.join(D, 'preview');
fs.rmSync(OUT, { recursive: true, force: true });
fs.mkdirSync(OUT, { recursive: true });
fs.cpSync(path.join(D, 'images/by-blob-id'), path.join(OUT, 'img'), { recursive: true });
fs.copyFileSync(path.join(D, 'runtime/support.js'), path.join(OUT, 'support.js'));
const canvas = JSON.parse(fs.readFileSync(path.join(D, 'pages/canvas.json'), 'utf8'));
const pages = fs.readdirSync(path.join(D, 'pages')).filter(f => f.endsWith('.dc.html'));
for (const f of pages) {
  let t = fs.readFileSync(path.join(D, 'pages', f), 'utf8');
  t = t.replace(/\/_blob\/([0-9a-f]{32})/g, 'img/$1.jpg');
  t = t.replace('<head>', '<head><meta name="viewport" content="width=device-width,initial-scale=1">');
  t = t.replace(/\.dc\.html/g, '.html');
  fs.writeFileSync(path.join(OUT, f.replace('.dc.html', '.html')), t);
}
const rows = (canvas.order || pages).map(f => {
  const b = canvas.boards[f] || {};
  const n = f.replace('.dc.html', '');
  return `<a href="${n}.html">${b.title || n}</a>`;
});
fs.writeFileSync(path.join(OUT, 'index.html'), `<!doctype html><meta charset="utf-8"><title>Crux Nxtion redesign — preview</title><style>body{font:16px system-ui;max-width:720px;margin:40px auto;padding:0 20px}a{display:block;padding:9px 0;border-bottom:1px solid #ddd;text-decoration:none;color:#123}</style><h1>Crux Nxtion redesign</h1><p>Mobile pages (Mobile —) are 390px wide; open them in a narrow window.</p>${rows.join('')}`);
console.log('preview built:', pages.length, 'pages ->', OUT);
