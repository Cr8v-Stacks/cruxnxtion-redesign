const fs=require('fs');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const ctxOf={HomeA2a:'consult',ServicesA2a:'consult',AboutS:'shared',ContactS:'shared',FAQS:'shared'};
for(const [f,ctx] of Object.entries(ctxOf)){
  const p=P+f+'.dc.html'; if(!fs.existsSync(p)) continue;
  fs.writeFileSync(p,C.link(fs.readFileSync(p,'utf8'),ctx));
}
// mega-menu boards (open state) for both moods
const mega=(src,name,h)=>{
  let t=fs.readFileSync(P+src+'.dc.html','utf8');
  const i=t.indexOf('</header>')+9;
  t=t.slice(0,i).replace('class="mega"','class="mega open"').replace('class="mega" ','class="mega open" ')+`\n\n  <div style="height:${h}px;"></div>\n\n</div>\n</x-dc>\n<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":${h+330}}}'>\nclass Component extends DCLogic {\n  renderVals() {\n    return {};\n  }\n}\n</script>\n</body>\n</html>\n`;
  t=t.replace(/<title>[^<]*<\/title>/,'<title>'+name+'</title>');
  fs.writeFileSync(P+name.replace(/[^A-Za-z0-9]/g,'')+'.dc.html',t);
};
mega('HomeA','Mega menu events',360); mega('AboutS','Mega menu light',360);
console.log('finished');
