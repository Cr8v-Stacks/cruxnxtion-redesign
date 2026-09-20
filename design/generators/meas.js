const fs=require('fs');
const SP='C:/Users/user/AppData/Local/Temp/claude/C--Users-user-OneDrive-Documents-Dev-Playground-Cr8v-Stacks-Events-Website-main/97df7f88-296d-4e3c-80ef-abf4a42b7050/scratchpad/';
const P=SP+'pub/project/';
const out=SP+'mroot/'; fs.mkdirSync(out,{recursive:true});
const files=fs.readdirSync(P).filter(f=>f.endsWith('.dc.html'));
for(const f of files){
  let src=fs.existsSync(SP+'meas/'+f)?SP+'meas/'+f:P+f;
  let t=fs.readFileSync(src,'utf8');
  t=t.replace(/<script src="\.\/support\.js"><\/script>/,'').replace(/<x-dc>|<\/x-dc>|<helmet>|<\/helmet>/g,'');
  t=t.replace(/<sc-if value="\{\{isConsult\}\}"[^>]*>[\s\S]*?<\/sc-if>/g,'');
  t=t.split('{{trackStyle}}').join('display:flex; gap:24px;');
  t=t.replace(/<script type="text\/x-dc"[\s\S]*?<\/script>/,'');
  t=t.replace(/\/_blob\/([0-9a-f]{32})/g,'img/$1.jpg');
  t=t.replace('<head>','<head><meta name="viewport" content="width=device-width,initial-scale=1">');
  const IMGS=fs.readdirSync(out+'img').map(x=>x.replace('.jpg',''));
  fs.writeFileSync(out+f.replace('.dc.html','.html'),t);
}
const names=files.map(f=>f.replace('.dc.html',''));
fs.writeFileSync(out+'index.html','<!doctype html><html><body style="margin:0">'+names.map(n=>`<iframe id="f_${n}" src="${n}.html" style="width:1440px;height:400px;border:0;display:block"></iframe>`).join('')+'</body></html>');
console.log(names.join(','));
