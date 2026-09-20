const fs=require('fs');const P='pub/project/';fs.mkdirSync('mroot/rt',{recursive:true});
if(!fs.existsSync('mroot/rt/support.js'))fs.copyFileSync('artifact-files/99bf2331-0253-49ed-a9ca-8a7a6fb6515e/artifact-type/dc-runtime.js','mroot/rt/support.js');
for(const f of fs.readdirSync(P).filter(f=>f.endsWith('.dc.html'))){let t=fs.readFileSync(P+f,'utf8');t=t.replace(/\/_blob\/([0-9a-f]{32})/g,'../img/$1.jpg');t=t.replace('<head>','<head><meta name="viewport" content="width=device-width,initial-scale=1">');fs.writeFileSync('mroot/rt/'+f.replace('.dc.html','.html'),t)}
console.log('rt ok');
