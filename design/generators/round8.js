const fs=require('fs');const C=require('./common.js');const P=C.SP+'pub/project/';
const rd=(f)=>fs.readFileSync(P+f+'.dc.html','utf8'), wr=(f,t)=>fs.writeFileSync(P+f+'.dc.html',t);
const BAM='/_blob/a67d85c16f6df90ab7a657160bee9088';
// 1 Home founder: the original band design (tilted portrait, accent border, square chips)
{
  let t=rd('HomeA');
  const band=`  <!-- FOUNDER — original design -->
  <section id="founder" style="padding:64px 64px; background:#111838; display:grid; grid-template-columns:0.8fr 1.2fr; gap:70px; align-items:center;">
    <div class="tilt-straighten reveal" style="--r:-2deg; transform:rotate(var(--r)); border-radius:22px; overflow:hidden; border:2px solid #5B8DEF; height:470px;"><img src="${BAM}" alt="Olabamidele 'Bambad' Badmos, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"></div>
    <div class="reveal">
      <span class="eyebrow" style="color:#5B8DEF;">Meet The Founder</span>
      <h2 class="bebas" style="font-size:68px; margin:14px 0 20px; color:#F4F5FA;">OLABAMIDELE "BAMBAD" BADMOS.</h2>
      <p style="font-size:16px; line-height:1.8; color:#C5CADF; max-width:620px; margin:0 0 14px;">Bambad is the Sheffield producer behind every Crux Nxtion night, known as the "Oba of Events". He built the crew, set the standard and still leads it from the first brief to the last guest.</p>
      <p style="font-size:16px; line-height:1.8; color:#C5CADF; max-width:620px; margin:0 0 28px;">Weddings, cultural nights and private celebrations all get the same care, and through Crux Nxtion Consultancy the same thinking now goes to the businesses behind them.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:30px;">
        ${['76+ events sold out','Naija Food Carnival: 400+ guests','Founder, Nxtion Food Market'].map(x=>`<span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:10px 18px;">${x}</span>`).join('')}
      </div>
      <a href="FounderS.dc.html" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 28px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%);">Read The Full Story &rarr;</a>
    </div>
  </section>

`;
  t=t.replace(/  <!-- FOUNDER[^\n]*-->[\s\S]*?(?=  <!-- FAQ)/,band);
  wr('HomeA',t);
}
// 2 the Gallery page's punched-ticket stub styling on every page that uses it
{
  const g=rd('GalleryA'); const m=/  \.strip-stub \{[\s\S]*?\.strip-stub::after \{ left: 68%; \}\n/.exec(g); const css=m?m[0]:'';
  for(const f of fs.readdirSync(P).filter(f=>/\.dc\.html$/.test(f)&&!f.startsWith('M_'))){
    let t=fs.readFileSync(P+f,'utf8');
    if(t.includes('class="strip-stub"')&&!t.includes('.strip-stub {')&&css){ t=t.replace('</style>',css+'</style>'); fs.writeFileSync(P+f,t); console.log('stub css ->',f); }
  }
}
console.log('round8 ok');
