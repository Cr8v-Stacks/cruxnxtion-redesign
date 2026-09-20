// Round 6: About founder band restored to the original (A1) design, a real Founder page, founder links.
const fs=require('fs');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const rd=(f)=>fs.readFileSync(P+f+'.dc.html','utf8'), wr=(f,t)=>fs.writeFileSync(P+f+'.dc.html',t);
const BAM='/_blob/a67d85c16f6df90ab7a657160bee9088';
const B=(id)=>'/_blob/'+id;

// 1 About: the original dark founder band (tilted portrait with accent border, square chips), under "who we are"
{
  let t=rd('AboutS');
  const band=`  <!-- 5 FOUNDER — original design -->
  <section id="founder" style="padding:100px 64px; background:#111838; display:grid; grid-template-columns:0.8fr 1.2fr; gap:70px; align-items:center;">
    <div class="tilt-straighten reveal" style="--r:-2deg; transform:rotate(var(--r)); border-radius:22px; overflow:hidden; border:2px solid #5B8DEF; height:560px;"><img src="${BAM}" alt="Olabamidele 'Bambad' Badmos, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"></div>
    <div class="reveal">
      <span class="eyebrow" style="color:#5B8DEF;">Meet The Founder</span>
      <h2 class="bebas" style="font-size:68px; margin:14px 0 20px; color:#F4F5FA;">OLABAMIDELE "BAMBAD" BADMOS.</h2>
      <p style="font-size:16px; line-height:1.8; color:#C5CADF; max-width:620px; margin:0 0 14px;">Bambad is a Sheffield event producer known as the "Oba of Events". He built Crux Nxtion from a small events crew into one of the city's busiest party and culture brands, selling out more than 76 events across the UK.</p>
      <p style="font-size:16px; line-height:1.8; color:#C5CADF; max-width:620px; margin:0 0 28px;">His crew now brings the same standard to weddings, cultural nights and private celebrations, and, through Crux Nxtion Consultancy, to the businesses behind them.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:30px;">
        ${['76+ events sold out','Naija Food Carnival: 400+ guests','Founder, Nxtion Food Market'].map(x=>`<span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:10px 18px;">${x}</span>`).join('')}
      </div>
      <a href="FounderS.dc.html" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 28px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%);">Read The Full Story &rarr;</a>
    </div>
  </section>

`;
  t=t.replace(/  <!-- 5 FOUNDER[^\n]*-->[\s\S]*?(?=  <!-- 6 JOURNEY)/,band);
  wr('AboutS',t);
}

// 2 Founder page (light, shared)
{
  const light=rd('ContactS');
  const a=light.indexOf('  <!-- 1 CONTACT -->'), b=light.indexOf('  <!-- PREFOOTER CTA');
  let pre=light.slice(0,a).replace(/<title>[^<]*<\/title>/,'<title>The founder — Crux Nxtion Events</title>');
  pre=pre.replace(/(<nav[\s\S]*?<\/nav>)/,(nav)=>{ const m=/<a [^>]*style="color:(#[0-9A-Fa-f]{6}); font-size:13px; font-weight:600;"/.exec(nav); const col=m?m[1]:'#10142E'; return nav.replace(/style="color:#[0-9A-Fa-f]{6}; font-size:13px; font-weight:600; border-bottom:1\.5px solid #[0-9A-Fa-f]{6};"/,'style="color:'+col+'; font-size:13px; font-weight:600;"'); });
  let post='  <div style="background:#10142E;">\n\n'+light.slice(b).replace(/<script type="text\/x-dc"[\s\S]*?<\/script>/,`<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":3000}}'>\nclass Component extends DCLogic {\n  renderVals() { return {}; }\n}\n</script>`);
  const chips=['76+ events sold out','Naija Food Carnival: 400+ guests','Founder, Nxtion Food Market','Sheffield, UK'];
  const stat=(n,l,c)=>`<div class="reveal" style="border-top:3px solid ${c}; padding-top:16px;"><div class="bebas" style="font-size:72px; color:#10142E; line-height:.9;">${n}</div><p style="font-size:14px; line-height:1.55; color:#5A5F86; margin:8px 0 0;">${l}</p></div>`;
  const body=`  <!-- FOUNDER HERO -->
  <section style="padding:70px 64px 80px; display:grid; grid-template-columns:0.85fr 1.15fr; gap:72px; align-items:center;">
    <div class="tilt-straighten" style="--r:-2deg; transform:rotate(var(--r)); border-radius:24px; overflow:hidden; border:2px solid #8C7AE6; height:640px;"><img src="${BAM}" alt="Olabamidele 'Bambad' Badmos" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"></div>
    <div>
      <span class="eyebrow">The Founder</span>
      <h1 class="bebas" style="font-size:88px; margin:14px 0 8px; color:#10142E;">OLABAMIDELE<br><span style="color:#6C58DB;">"BAMBAD" BADMOS.</span></h1>
      <p style="font-size:14px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#5A5F86; margin:0 0 22px;">Founder, Crux Nxtion Events &amp; Consultancy</p>
      <p style="font-size:17px; line-height:1.8; color:#3A3F66; max-width:600px; margin:0 0 26px;">Bambad is a Sheffield event producer known as the "Oba of Events". He built Crux Nxtion from a small events crew into one of the city's busiest party and culture brands.</p>
      <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:30px;">${chips.map(x=>`<span style="border:1px solid #D2CEEA; background:#FFFFFF; color:#3A3F66; font-size:12.5px; font-weight:600; padding:10px 18px; border-radius:999px;">${x}</span>`).join('')}</div>
      <div style="display:flex; gap:14px;"><a href="ContactS.dc.html" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Work With Bambad</a><a href="EventsA.dc.html" style="border:1.5px solid #10142E; color:#10142E; font-weight:700; font-size:15px; padding:14.5px 28px;">See The Events</a></div>
    </div>
  </section>

  <!-- STORY -->
  <section style="padding:90px 64px; background:#F3F1FC; display:grid; grid-template-columns:0.9fr 1.1fr; gap:80px; align-items:start;">
    <h2 class="bebas reveal" style="font-size:64px; margin:0; color:#10142E;">FROM A SMALL CREW TO <span style="color:#6C58DB;">A SHEFFIELD BRAND.</span></h2>
    <div class="reveal">
      <p style="font-size:16px; line-height:1.85; color:#3A3F66; margin:0 0 18px;">Bambad started by putting on nights people wanted to come back to. Event by event, the crew grew, the rooms got bigger, and Crux Nxtion became one of Sheffield's busiest party and culture brands, selling out more than 76 events across the UK.</p>
      <p style="font-size:16px; line-height:1.85; color:#3A3F66; margin:0 0 18px;">Along the way he learned what it takes to turn an idea into something people queue for: the planning, the talent, the promotion and the run of the night. That experience is the backbone of every Crux Nxtion event.</p>
      <p style="font-size:16px; line-height:1.85; color:#3A3F66; margin:0;">It is also why he opened Nxtion Food Market on Abbeydale Road, and why Crux Nxtion Consultancy exists: the same thinking, pointed at your business.</p>
    </div>
  </section>

  <!-- NUMBERS -->
  <section style="padding:90px 64px;">
    <span class="eyebrow reveal">Track Record</span><h2 class="bebas reveal" style="font-size:56px; margin:12px 0 44px; color:#10142E;">THE WORK, IN A FEW LINES.</h2>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:40px;">
      ${stat('76+','events sold out across the UK, from private parties to cultural nights.','#6C58DB')}
      ${stat('400+','guests at the Naija Food Carnival.','#BA0000')}
      ${stat('2','brands under one roof: Crux Nxtion Events and Crux Nxtion Consultancy.','#002671')}
    </div>
  </section>

  <!-- PHOTO STRIP -->
  <section style="padding:0 64px 100px;">
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:18px;">
      ${[['d57ccda2fda77b95b0e9ecc255260db5','-1.5deg'],['b3edce4c6ce4ef4e78901fac7d5dda36','1deg'],['8127c7ab2af037f167d7a8b67413ab45','-0.8deg'],['bf42e259f88bbdfe62f46891f7be933e','1.4deg']].map(([id,r])=>`<div class="reveal" style="height:340px; border-radius:16px; overflow:hidden; border:1.5px solid #E1DEF3; transform:rotate(${r});"><img src="${B(id)}" alt="Crux Nxtion event" style="width:100%; height:100%; object-fit:cover; display:block;"></div>`).join('')}
    </div>
  </section>

`;
  wr('FounderS',pre+body+post);
}

// 3 every "Meet The Founder" link goes to the founder page
for(const f of fs.readdirSync(P).filter(f=>/\.dc\.html$/.test(f)&&!f.startsWith('M_')&&f!=='FounderS.dc.html')){
  let t=fs.readFileSync(P+f,'utf8'); const o=t;
  t=t.replace(/(<a href=")[^"]*("[^>]*>Meet The Founder)/g,'$1FounderS.dc.html$2');
  if(t!==o) fs.writeFileSync(P+f,t);
}
console.log('round6 ok');
