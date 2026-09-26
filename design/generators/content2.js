// Real events (from the live site), real sponsors page, footer wordmark, per-page image variety. Idempotent; run before post.js/mobile3.js.
const fs=require('fs');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const B=(id)=>'/_blob/'+id;
const rd=(f)=>fs.readFileSync(P+f+'.dc.html','utf8'), wr=(f,t)=>fs.writeFileSync(P+f+'.dc.html',t);
const BLUE='#002671', RED='#BA0000', PU='#8C7AE6';
const tone=(i)=>[[BLUE,'#FFFFFF'],[RED,'#FFFFFF'],[PU,'#10142E']][i%3];

// ---------- real events ----------
const IMG={lasgidi:B('a15ea8703f82f1d0f8577325e8d85a3b'),becoming:B('2f9f2834d9f0829e887b03bccc208656'),hangout:B('352a5c10108a75b7cb713fd1433b8b36'),wedding:B('53df70ef86c4b1d32979af070d98a399'),millennials:B('317371ca97a92f79584d7ff4bae33069'),yagi:B('fa3286e8f930ebdb28b28c54198542fa'),ankara:B('11316a3d9c4317e3d5b7f755df227497'),danceout:B('1d5292715423e2e83b56b3330a94b3b8')};
const EV={
 lasgidi:{d:'25',m:'JAN 2025',t:'LASGIDI Mainland Party',k:'IJGB Edition',s:'Tickets on Eventbrite',img:IMG.lasgidi,desc:'The LASGIDI Mainland Party, IJGB edition.'},
 becoming:{d:'23',m:'APR 2025',t:'Becoming Mr & Mrs Crux Pt.3',k:'Part 3',s:'Tickets on Eventbrite',img:IMG.becoming,desc:'The third edition of our Becoming Mr & Mrs Crux celebration.'},
 danceout:{d:'16',m:'DEC 2023',t:'Dance OUT 2023',k:'Dance night',s:'Sheffield · Late',img:IMG.danceout,desc:'Get ready to groove and move like never before. An electrifying night set to ignite the dance floor.'},
 ankara:{d:'30',m:'NOV 2024',t:'Ankara Festival',k:'Culture',s:'Sat, 14:00',img:IMG.ankara,desc:'The Ankara Festival celebrates the vibrancy and diversity of African culture in the heart of the United Kingdom.'},
 yagi:{d:'28',m:'APR 2023',t:'YAGI Awards',k:'Awards',s:'Fri, 14:30',img:IMG.yagi,desc:'Set to recognise individuals who have done wonderfully well in their services and contributions to the community.'},
 millennials:{d:'29',m:'JAN 2023',t:'Millennials vs Gen Z',k:'Games night',s:'Sun, 17:00',img:IMG.millennials,desc:'Games night with Millennial crowds taking on Gen Z to win ultimate bragging rights.'},
 wedding:{d:'27',m:'AUG 2022',t:'The Wedding Party',k:'Wedding',s:'Sat, 15:00',img:IMG.wedding,desc:'Set up to celebrate the glamorous Nigerian wedding party in the United Kingdom.'},
 hangout:{d:'25',m:'SEP 2021',t:'Crux Nxtion Hangout Out',k:'Social',s:'Sat, 18:00',img:IMG.hangout,desc:'An indoor games hangout: come socialise, make friends, network and vibe.'}
};
const esc=(s)=>s.replace(/&/g,'&amp;');
const rots=['-1deg','0.8deg','-0.6deg','1deg'];
function ticket(e,i,minH,pad){
  const [bg,fg]=tone(i);
  return `      <a href="SingleEventA.dc.html" class="tilt-ticket" style="display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; min-height:${minH}px; --r:${rots[i%4]}; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:${bg}; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
          <span class="bebas" style="font-size:38px; color:${fg}; line-height:1;">${e.d}</span>
          <span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:${fg}; text-align:center;">${e.m}</span>
        </div>
        <div style="flex:1; display:flex; flex-direction:column; min-width:0;">
          <div style="flex:1; position:relative; min-height:${minH-150}px;"><img src="${e.img}" alt="${esc(e.t)}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center top;"></div>
          <div style="padding:${pad-2}px ${pad}px ${pad}px; background:#0D1330; border-top:1.5px dashed #1E2B5E;">
            <span class="eyebrow" style="color:#5B8DEF;">${esc(e.k)}</span>
            <h3 style="font-size:19px; margin:8px 0 4px; font-weight:700; color:#FFFFFF;">${esc(e.t)}</h3>
            <p style="font-size:12.5px; color:#C5CFF5; margin:0 0 10px;">${esc(e.s)}</p>
            <span style="font-weight:700; font-size:12.5px; color:#5B8DEF; border-bottom:1.5px solid #5B8DEF; padding-bottom:2px;">View Details &rarr;</span>
          </div>
        </div>
      </a>
`;}
// Home: the three events the live site features
{
  let t=rd('HomeA');
  const grid=`    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;">
${['lasgidi','becoming','danceout'].map((k,i)=>ticket(EV[k],i,330,18)).join('')}    </div>
  </section>

`;
  t=t.replace(/(  <!-- EVENTS — ticket stub -->[\s\S]*?<\/div>\n    <\/div>\n\n)[\s\S]*?(?=  <!-- ALSO FROM CRUX)/,(m,a)=>a+grid);
  wr('HomeA',t);
}
// Events page: all events from the live site, newest first
{
  let t=rd('EventsA');
  const order=['becoming','lasgidi','ankara','danceout','yagi','millennials','wedding','hangout'];
  const cta=`      <div style="display:flex; flex-direction:column; justify-content:center; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; padding:32px 30px;">
        <span class="eyebrow">Your Night Next</span>
        <h3 class="bebas" style="font-size:30px; margin:10px 0 8px; color:#F4F5FA;">PUT YOUR EVENT ON THE WALL.</h3>
        <p style="font-size:13px; line-height:1.6; color:#A3A9C8; margin:0 0 18px;">Send us a brief and we will plan, book and run it.</p>
        <a href="ContactS.dc.html" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:14px 26px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%); width:fit-content;">Get In Touch</a>
      </div>
`;
  const body=`  <!-- TICKET GRID -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:30px 64px 100px;">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;">
${order.map((k,i)=>ticket(EV[k],i,400,20)).join('')}${cta}    </div>
  </section>

`;
  t=t.replace(/  <!-- TICKET GRID -->[\s\S]*?(?=  <!-- PREFOOTER CTA)/,body);
  wr('EventsA',t);
}
// Archive: year-by-year setlist (different from the ticket wall)
{
  let t=rd('EventsArchiveA');
  const years=[['2025',['becoming','lasgidi']],['2024',['ankara']],['2023',['danceout','yagi','millennials']],['2022',['wedding']],['2021',['hangout']]];
  let n=0;
  const rows=years.map(([y,ks])=>`    <div style="display:grid; grid-template-columns:140px 1fr; gap:40px; padding:34px 0; border-top:1.5px solid #1E2B5E;">
      <div class="bebas" style="font-size:64px; color:#5B8DEF; line-height:1;">${y}</div>
      <div style="display:flex; flex-direction:column; gap:16px;">
${ks.map(k=>{const e=EV[k];const [bg,fg]=tone(n++);return `        <a href="SingleEventA.dc.html" style="display:flex; align-items:center; gap:22px; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; padding:14px; overflow:hidden;">
          <img src="${e.img}" alt="${esc(e.t)}" style="width:120px; height:120px; object-fit:cover; border-radius:8px; flex:0 0 120px;">
          <div style="flex:0 0 78px; text-align:center; background:${bg}; color:${fg}; border-radius:8px; padding:12px 6px;"><div class="bebas" style="font-size:34px; line-height:1;">${e.d}</div><div style="font-size:10px; font-weight:800; letter-spacing:1.4px;">${e.m.split(' ')[0]}</div></div>
          <div style="flex:1;"><span class="eyebrow" style="color:#5B8DEF;">${esc(e.k)}</span><h3 class="bebas" style="font-size:30px; margin:6px 0 6px; color:#F4F5FA;">${esc(e.t)}</h3><p style="font-size:13.5px; line-height:1.55; color:#A3A9C8; margin:0; max-width:560px;">${esc(e.desc)}</p></div>
          <span style="font-weight:700; font-size:13px; color:#5B8DEF; white-space:nowrap; padding-right:10px;">Details &rarr;</span>
        </a>
`;}).join('')}      </div>
    </div>`).join('\n');
  const body=`  <!-- ARCHIVE -->
  <section style="padding:70px 64px 30px;">
    <span class="eyebrow">Past Events</span>
    <h1 class="bebas" style="font-size:88px; margin:14px 0 14px; color:#F4F5FA;">THE ARCHIVE</h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:540px; margin:0;">Every night we have planned, booked and run, year by year.</p>
  </section>
  <section style="padding:20px 64px 90px;">
${rows}
    <div style="border-top:1.5px solid #1E2B5E; padding-top:40px; text-align:center;"><a href="ContactS.dc.html" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Book Your Own Night</a></div>
  </section>

`;
  t=t.replace(/  <!-- ARCHIVE[^\n]*-->[\s\S]*?(?=  <!-- PREFOOTER CTA)/,body);
  wr('EventsArchiveA',t);
}

// ---------- sponsors (content from the live /sponsor page) ----------
{
  let t=rd('SponsorsA');
  const S=[['3e237813fb9f6842a00a00f493717e50',''],['abbeaf5f563caf0a36336c5e0219cdc0',''],['de1eac2cea70d9ffc75148b9accd0833','ML'],['0dabf904386bf3c567390a985651785e','Phemzy Studios'],['31c531a4db0e51855507e872d273fc64',''],['0e3450f2f8f0a4ce5afd084843a3cb2f','Dotun Omiyale'],['e2d1c89ac716ea5f92ab8e31be53bade',''],['15e555b5257378f29e72ecde1fb7e5f3','DJ03'],['85b05c3630e70a76a40b1411919f2987',''],['0f86db33ccd6204138c27980499a58e1','D20 Pasties'],['2d13a2f72d6824fb6334d5366984c9df','Livingbangel Beauty Lounge'],['18373137dc739154d5a9c88a4f075201','Food Emporium UK'],['1a6f99c10b46fe8f6da34271f5eaf048',''],['5d9392be79f6ba3f1fb18b1923e80c13',''],['4ae9886f77ee1545ce79727e031a2c76','Sokid Photography'],['c205c0a2e87784d728fe729edd731e2e','Zee Jewels'],['fc86f6756c4525131aadac80ca442a7b',"Rosella's Wonder"]];
  const body=`  <!-- SPONSORS HEADING -->
  <section style="padding:70px 64px 40px; display:grid; grid-template-columns:1.15fr .85fr; gap:56px; align-items:center;">
    <div><span class="eyebrow">Sponsors &amp; Partners</span>
    <h1 class="bebas" style="font-size:80px; margin:14px 0 16px; color:#F4F5FA;">OUR SPONSORS<br><span style="color:#E5383B;">AND PARTNERSHIP.</span></h1>
    <h2 style="font-size:19px; line-height:1.4; font-weight:700; margin:0 0 14px; color:#F4F5FA; max-width:560px;">Join the celebration: your gateway to extraordinary partnerships with Crux Nxtion Events.</h2>
    <p style="font-size:15.5px; line-height:1.7; color:#A3A9C8; max-width:560px; margin:0 0 26px;">Welcome to the heart of collaboration. We are passionate about creating extraordinary experiences, and we believe in doing it together. Our partnership and vendors section is where connections spark, creativity thrives, and magic happens.</p>
    <div style="display:flex; gap:16px;"><a href="ContactS.dc.html" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Become A Partner</a><a href="EventsA.dc.html" style="border:1.5px solid #5B8DEF; color:#F4F5FA; font-weight:700; font-size:15px; padding:14px 28px; border-radius:6px;">See Our Events</a></div></div>
    <div style="position:relative; height:440px; border-radius:16px; overflow:hidden; border:1.5px solid #1E2B5E;"><img src="${B('2b696c907bf5b4d0dc14a80e8cd60e15')}" alt="Vendors serving guests at a Crux Nxtion event" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg,rgba(10,15,38,.7),rgba(10,15,38,0) 55%);"></div></div>
  </section>

  <!-- PARTNER WALL -->
  <section style="padding:50px 64px 70px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;"><div><span class="eyebrow">Vendors &amp; Partners</span><h2 class="bebas" style="font-size:56px; margin:12px 0 0; color:#F4F5FA;">THE PEOPLE BEHIND THE NIGHT.</h2></div><p style="max-width:380px; font-size:14px; line-height:1.6; color:#A3A9C8; margin:0;">Caterers, photographers, DJs, beauty and jewellery brands who have joined our events.</p></div>
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px 22px; align-items:start;">
${S.map(([id,name],i)=>{const [bg,fg]=tone(i);return `      <div style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(${rots[i%4]});">
        <div style="position:relative; aspect-ratio:1/1; background:#F4F5FA;"><img src="${B(id)}" alt="${name||'Crux Nxtion partner'}" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:${bg}; padding:11px 16px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:11.5px; font-weight:800; color:${fg}; letter-spacing:.8px; text-transform:uppercase;">${name||'Partner'}</span><span class="bebas" style="font-size:14px; color:${fg};">${String(i+1).padStart(2,'0')}</span></div>
      </div>`;}).join('\n')}
    </div>
  </section>

  <!-- ENQUIRY -->
  <section style="padding:30px 64px 100px;">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0; background:#111838; border:1.5px solid #1E2B5E; border-radius:16px; overflow:hidden;">
      <div style="padding:46px 44px;"><span class="eyebrow">Partner With Us</span><h2 class="bebas" style="font-size:52px; margin:12px 0 14px; color:#F4F5FA;">WANT YOUR BRAND ON THE WALL?</h2><p style="font-size:15px; line-height:1.65; color:#A3A9C8; margin:0 0 20px;">Tell us who you are and what you do. We will match you with the right event.</p><p style="font-size:14px; color:#D5D9EA; margin:0; line-height:1.9;">infoandsales@cruxnxtion.co.uk<br>+44 7341 366400</p></div>
      <form style="padding:40px 44px; background:#0D1330; display:flex; flex-direction:column; gap:14px;">
        <input type="text" placeholder="Your name" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA;">
        <input type="text" placeholder="Business or brand" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA;">
        <input type="email" placeholder="you@company.com" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA;">
        <textarea rows="4" placeholder="What do you offer, or what are you looking for?" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA; resize:none;"></textarea>
        <button type="button" style="border:none; cursor:pointer; background:${RED}; color:#fff; font-weight:700; font-size:15px; padding:16px; border-radius:10px; font-family:inherit;">Send Enquiry</button>
      </form>
    </div>
  </section>

`;
  t=t.replace(/  <!-- SPONSORS HEADING -->[\s\S]*?(?=  <!-- PREFOOTER CTA)/,body);
  wr('SponsorsA',t);
}

// ---------- footer wordmark: CRUX over NXTION, no red mark ----------
const files=fs.readdirSync(P).filter(f=>/\.dc\.html$/.test(f)&&!f.startsWith('M_'));
for(const f of files){
  let t=fs.readFileSync(P+f,'utf8'); const o=t;
  t=t.replace(/<span class="bebas" style="([^"]*)">CRUX<\/span>\s*<span aria-hidden="true"[^>]*><\/span>/,(m,st)=>{
    const small=st.replace(/font-size:clamp\([^)]*\)/,'font-size:clamp(30px,6.4vw,82px)').replace(/line-height:[0-9.]+/,'line-height:1');
    return `<span class="bebas" style="${st}">CRUX</span>\n      <span class="bebas" style="${small} letter-spacing:0.5em; margin-top:10px; padding-left:0.5em;">NXTION</span>`;
  });
  if(t!==o) fs.writeFileSync(P+f,t);
}

// ---------- image variety ----------
const POOL=['6e1036b74f617a3d1887a7cf36398cff','8779e5d9192fb628e623a9aec1f82362','6aa60ee4af0bdb49015bf4224786bd46','aa52e28c3ca12b7f14d33300c774fb48','7ad16fa711374cf636fa630f0cf398c0','4795dc48859e2b9d81b42757c6317d14','f1ffd7a776c034eaead72759fb4440c6','fbd294c148cb8e1a55a31856bc061a40','1ebf529508af3e82c1e2c01b3a050fe1','3f7a3d27a340e99222e15e9e60a98a7d','a7f19688f4ec09c5590ca71c99b9f400','8127c7ab2af037f167d7a8b67413ab45','bf42e259f88bbdfe62f46891f7be933e','dbd393a97ba45e6ef842a123d68e1e3a','858951235d0096aa93d5ab4f5700b9fe','2ac34ca28659fc891269a1b0faf25ac1','d57ccda2fda77b95b0e9ecc255260db5','bf598dabf623c991f65ec61b98d88a5a'];
const STOCK=['bf595f0e22accb6b2801bb0f88d33355','d5cee87c23f7a89a05af485a53a07b24','052d83d28ee851b93069420ea3c10f8f','97f6e11f46029a4f9812d43722c1bcf4','8cbbf8075ea65369e575c4f2b9fd9e4c','d7ec7e8129482dec3e004a136575df53','de1f229044e51fea8eef0e8e07331cbe','4f18304ff3dad6215b2bb23021322a98','b7834baeaf5a08921ea7b06e7153a0e4','3238a37a61a05d3d68a477d3353ed318','f2cab31b5f52f79e8928b36dc05b5048','b3edce4c6ce4ef4e78901fac7d5dda36','b743eeff30f479ffe1816732bdbcd970','c86da0396ac7432d102182af40903c45','acfa6013b39c80f99a7e5ed2f56a1926','abea62acd7a243acfe15bc7b2b7c887e','8f4495361437a1d1961471650d55c60a','53d4feb181f3c6e0619a155bc4be2bf5','44b7a98d85fefb8a03f8b8e625e3bcdc','e56c3376aee5c9f5027ad93a6f335536','263030a5b7aa9f782aeddd3e7f44cb13','ca942693739cdc74700f9c8d65278358','62f016a3e0b0dc275a615ae5af6b3b69','50cb2790126aab1196125a6f09c951bf','19a249fe66d9d8620a7283402ecde11e','a4f578a4b1ff3c642674f670e1eaa25b','099943029fd5fdb6c2e6c43ae11f3316','5b1a6ab37f0230a96cac807ce57c7983'];
const MEGA='f269f7683bdb441b9b45df1336cd1485';  // one dedicated photo for the "Not sure which?" menu card
const FIXED=new Set(['e4d72651b77d4c3cc1c086d9f6031149','a67d85c16f6df90ab7a657160bee9088',MEGA,...Object.entries(IMG).filter(([k])=>k!=='danceout').map(([k,x])=>x.slice(7))]);
const PREPAGE=['HomeA','ServicesA','EventsA','SingleEventA','GalleryA','BlogA','SingleBlogA','EventsArchiveA','Error404A','SponsorsA','HomeA2a','ServicesA2a','AboutS','ContactS','FAQS','PrivacyS','CookiesS','TermsS'];
files.forEach((f)=>{
  let t=fs.readFileSync(P+f,'utf8'); const name=f.replace('.dc.html','');
  // mega-menu card
  t=t.replace(/(<div class="mega-panel"[\s\S]*?<div style="position:relative; border-radius:18px; overflow:hidden; min-height:260px;"><img src="\/_blob\/)([0-9a-f]{32})/,'$1'+MEGA);
  // pre-footer band: a different photo on each page
  const pi=Math.max(0,PREPAGE.indexOf(name));
  t=t.replace(/(<!-- PREFOOTER CTA[\s\S]*?<img src="\/_blob\/)([0-9a-f]{32})/,'$1'+POOL[(pi*5+3)%POOL.length]);
  // dedupe: a photo appears once per page
  const seen=new Set(); const SRC=/A2a$/.test(name)?STOCK:POOL; let pool=SRC.filter(id=>!t.includes(id)); let k=(pi*7)%Math.max(1,pool.length);
  const IS_A2A=/A2a$|S$/.test(name);
  t=t.replace(/\/_blob\/([0-9a-f]{32})/g,(m,id)=>{
    if(FIXED.has(id)) return m;
    if(!seen.has(id)){ seen.add(id); return m; }
    if(!pool.length) return m;
    const r=pool.splice(k%pool.length,1)[0]; seen.add(r); return '/_blob/'+r;
  });
  fs.writeFileSync(P+f,t);
});
console.log('content2 ok');
