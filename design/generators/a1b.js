const fs=require('fs');
const SP='C:/Users/user/AppData/Local/Temp/claude/C--Users-user-OneDrive-Documents-Dev-Playground-Cr8v-Stacks-Events-Website-main/97df7f88-296d-4e3c-80ef-abf4a42b7050/scratchpad/';
const P=SP+'pub/project/'; const BK=SP+'a1_orig/'; fs.mkdirSync(BK,{recursive:true});
for(const f of ['HomeA','ServicesA','AboutA','FAQA']) if(!fs.existsSync(BK+f+'.dc.html')) fs.copyFileSync(P+f+'.dc.html',BK+f+'.dc.html');
const rd=(f)=>fs.readFileSync(BK+f+'.dc.html','utf8');
const rep=(t,a,b)=>{ if(!t.includes(a)) console.log('MISSING:',a.slice(0,60)); return t.split(a).join(b); };
const PU='#8C7AE6', RD='#FF2E3D', NAVY='#10142E', LT='#F2F1F8';
const B=(id)=>'/_blob/'+id;
const MEET=B('5b1a6ab37f0230a96cac807ce57c7983'), BAM=B('a67d85c16f6df90ab7a657160bee9088');
const P7717=B('cf1ceb83917462889e44cacbaceaa722'), P250=B('55eba2e6d619d5c1a571e0d933bb5f80'), P77=B('3fcacd6b5e7c07fd83bdde5b4bebeb1e');
const arrow='<span class="bebas" style="font-size:26px; color:'+PU+'; flex:0 0 auto;">&rarr;</span>';

const fork=`  <!-- ALSO FROM CRUX — consultancy fork -->
  <section style="padding:20px 64px 90px;">
    <div style="display:grid; grid-template-columns:1.1fr 0.9fr; border-radius:22px; overflow:hidden; border:1.5px solid #2A2F5C; background:#1B2048;">
      <div style="padding:60px 56px;">
        <span class="eyebrow">Also From Crux Nxtion</span>
        <h2 class="bebas" style="font-size:54px; margin:14px 0 16px; color:${LT};">GOT A BUSINESS BEHIND THE EVENT?</h2>
        <p style="font-size:15px; line-height:1.7; color:#C7C7DA; max-width:460px; margin:0 0 24px;">Crux Nxtion Consultancy turns business ideas into businesses that work — setup and strategy, branding and marketing, growth, and honest audits.</p>
        <a href="#" style="background:${PU}; color:${NAVY}; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); display:inline-block;">Explore Consultancy &rarr;</a>
      </div>
      <div style="position:relative; min-height:380px;"><img src="${MEET}" alt="A Crux Nxtion Consultancy session" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(27,32,72,0.9) 0%, rgba(140,122,230,0.18) 100%);"></div></div>
    </div>
  </section>

`;
const why=(img,t,d)=>`
      <div style="background:#1B2048; border:1.5px solid #2A2F5C; border-radius:18px; overflow:hidden;">
        <div style="height:220px; overflow:hidden;"><img src="${img}" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div style="padding:26px 28px 30px;"><h3 class="bebas" style="font-size:30px; margin:0 0 10px; color:${LT};">${t}</h3><p style="font-size:14px; line-height:1.65; color:#9A9AC0; margin:0;">${d}</p></div>
      </div>`;
const whySec=`  <!-- WHY CRUX -->
  <section style="padding:20px 64px 100px;">
    <div style="text-align:center; margin-bottom:44px;"><span class="eyebrow">Why Crux Nxtion</span><h2 class="bebas" style="font-size:52px; margin:14px 0 0; color:${LT};">A CREW YOU CAN TRUST WITH THE NIGHT.</h2></div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;">${why(P7717,'ONE CREW, START TO FINISH','The people you brief are the people on the floor — no chain of subcontractors between you and your event.')}${why(P250,'CULTURE-FIRST NIGHTS','From Afrobeats parties to wedding showcases, we know what moves a room and keeps it moving.')}${why(P77,'SHEFFIELD-ROOTED, UK-WIDE','We know the city, the venues and the vendors — and we book and produce across the UK.')}
    </div>
  </section>

`;
const founder=`  <!-- FOUNDER -->
  <section id="founder" style="padding:100px 64px; background:#1B2048; display:grid; grid-template-columns:0.8fr 1.2fr; gap:70px; align-items:center;">
    <div class="tilt-straighten" style="--r:-2deg; transform:rotate(var(--r)); border-radius:22px; overflow:hidden; border:2px solid ${RD}; height:560px;"><img src="${BAM}" alt="Olabamidele 'Bambad' Badmos, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"></div>
    <div>
      <span class="eyebrow">Meet The Founder</span>
      <h2 class="bebas" style="font-size:68px; margin:14px 0 20px; color:${LT};">OLABAMIDELE "BAMBAD" BADMOS.</h2>
      <p style="font-size:16px; line-height:1.8; color:#C7C7DA; max-width:620px; margin:0 0 14px;">Bambad is a Sheffield event producer known as the "Oba of Events". He built Crux Nxtion from a small events crew into one of the city's busiest party and culture brands, selling out more than 76 events across the UK.</p>
      <p style="font-size:16px; line-height:1.8; color:#C7C7DA; max-width:620px; margin:0 0 28px;">His crew now brings the same standard to weddings, cultural nights and private celebrations — and, through Crux Nxtion Consultancy, to the businesses behind them.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap;">
        ${['76+ events sold out','Naija Food Carnival: 400+ guests','Founder, Nxtion Food Market'].map(x=>`<span style="border:1.5px solid #3A3F72; color:#D6D6E8; font-weight:600; font-size:12.5px; padding:10px 18px;">${x}</span>`).join('')}
      </div>
    </div>
  </section>

`;

// ---------- HOME ----------
let h=rd('HomeA');
h=rep(h,"THE ROOM ISN'T<br>READY UNTIL<br><span style=\"color:#FF2E3D;\">WE ARE.</span>",'WE PLAN IT.<br>WE BOOK IT.<br><span style="color:#FF2E3D;">WE RUN IT.</span>');
h=rep(h,'Crux Nxtion Events produces the festivals, galas, and cultural nights that fill a room and keep it moving — sound, staging, and crowd energy, handled in-house.','Crux Nxtion Events plans, books and runs the parties, weddings and cultural nights people talk about for weeks — one crew, from the first brief to the last guest.');
h=h.replace(/SOLD-OUT ENERGY &nbsp;&bull;&nbsp; FESTIVAL PRODUCTION &nbsp;&bull;&nbsp; LIVE SOUND &nbsp;&bull;&nbsp; CULTURAL NIGHTS &nbsp;&bull;&nbsp; CROWD-FIRST STAGING &nbsp;&bull;&nbsp;/g,'EVENT MANAGEMENT &nbsp;&bull;&nbsp; ENTERTAINMENT BOOKING &nbsp;&bull;&nbsp; EVENT DESIGN &nbsp;&bull;&nbsp; ON-SITE COORDINATION &nbsp;&bull;&nbsp; WEDDINGS &nbsp;&bull;&nbsp; CULTURAL NIGHTS &nbsp;&bull;&nbsp;');
h=rep(h,'>WHAT WE RUN<','>WHAT WE DO<');
h=rep(h,'>Production Rider<','>Event Services<');
h=rep(h,'Four disciplines, one crew, on every call sheet.','Five services, one crew — from the first brief to the last guest.');
h=rep(h,'Festival Production','Event Management &amp; Planning');
h=rep(h,'Staging, sound, and crowd flow for national events.','Meticulous coordination and planning for private and corporate events.');
h=rep(h,'Live Sound &amp; Talent','Entertainment Booking &amp; Talent');
h=rep(h,'Booking and run of show for performers and MCs.','Star power secured and run-of-show handled for every act on the bill.');
h=rep(h,'Galas &amp; Private Events','Event Designs &amp; Production');
h=rep(h,'High-energy private celebrations and launches.','Themed, creative production for weddings, galas and private launches.');
h=rep(h,'On-Site Operations','On-Site Coordination');
h=rep(h,'Vendor management and real-time floor coordination.','Vendor management and real-time floor coordination, start to close.');
h=h.replace(/<span style="[^"]*">(LIVE|BOOKED|PRIVATE|ON-SITE)<\/span>/g,arrow);
h=rep(h,'padding:22px 0;','padding:22px 28px;');
{const row5=`      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px; border-bottom:1.5px solid #2A2F5C;">
        <span class="bebas" style="font-size:36px; color:#8C7AE6; flex:0 0 54px;">05</span>
        <img src="/_blob/848d8e1043a6ef12d1cc8d2c2844ece2" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;">
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0 0 4px; font-weight:700;">Event Marketing &amp; Promotion</h3>
          <p style="font-size:13px; color:#9A9AC0; margin:0;">Strategic marketing and promotion that builds buzz and gets the right crowd through the door.</p>
        </div>
        ${arrow}
      </div>
`;
const ev=h.indexOf('  <!-- EVENTS'); const cut=h.lastIndexOf('    </div>\n  </section>',ev); if(cut>0) h=h.slice(0,cut)+row5+h.slice(cut); else console.log('row5 not inserted');}
h=rep(h,'#5A5A56','#6E6E9A');
// ticket / gallery eyebrows: one consistent white
h=h.replace(/<span class="eyebrow"( style="color:#[0-9A-Fa-f]{6};")?>(IJGB Edition|Wedding Showcase|Annual Wrap Party)<\/span>/g,'<span class="eyebrow" style="color:#F2F1F8;">$2</span>');
const process=(()=>{const s=rd('ServicesA');return s.slice(s.indexOf('  <!-- PROCESS TIMELINE'),s.indexOf('  <!-- FAQ TEASER'));})();
h=h.replace('  <!-- GALLERY',fork+'  <!-- GALLERY');
h=h.replace('  <!-- MINI ABOUT',whySec+process+'  <!-- MINI ABOUT');
h=h.replace('  <!-- FAQ — card grid',founder+'  <!-- FAQ — card grid');
h=h.replace(/Festivals, art exhibitions, cultural nights, weddings, and private or corporate events[^<]*/,'Private and corporate events, weddings, cultural nights and parties — planned, booked and run by one crew.');
fs.writeFileSync(P+'HomeA.dc.html',h);

// ---------- SERVICES ----------
let s=rd('ServicesA');
const svc=[['01','5b70d603c19ee1c815fc453dd125ca85','Event Management &amp; Planning','Meticulous coordination and planning for private and corporate events — from the first brief to the final guest leaving.',['Corporate events','Private events','Budgets &amp; vendors']],
['02','cf1ceb83917462889e44cacbaceaa722','Entertainment Booking &amp; Talent','Star power secured and run-of-show handled for every act on the bill.',['DJs &amp; live acts','MCs &amp; hosts','Run of show']],
['03','e6344ccb855b3a4345d48b5f3209c566','Event Designs &amp; Production','Themed, creative production for weddings, galas and private launches.',['Decor &amp; styling','Sound &amp; lighting','Staging']],
['04','72dcd59775e18677289c9b5e912d16b7','On-Site Coordination','Vendor management and real-time floor coordination, start to close.',['Vendor management','Floor team','Guest experience']],
['05','848d8e1043a6ef12d1cc8d2c2844ece2','Event Marketing &amp; Promotion','Strategic marketing and promotion that builds buzz, boosts visibility and gets the right crowd through the door.',['Social media campaigns','Influencer partnerships','Listings &amp; SEO']]];
const tag=(t)=>`<span style="border:1px solid #2A2F5C; color:#D6D6E8; font-size:11.5px; font-weight:600; padding:7px 14px; border-radius:999px;">${t}</span>`;
const rows=svc.map((r,i)=>`
      <div style="display:flex; align-items:flex-start; gap:32px; padding:36px 28px; border-bottom:1.5px solid #2A2F5C; ${i%2?'background:rgba(242,241,248,0.02);':''}">
        <span class="bebas" style="font-size:52px; color:${PU}; flex:0 0 90px;">${r[0]}</span>
        <img src="/_blob/${r[1]}" alt="" style="width:130px; height:130px; object-fit:cover; border-radius:12px; flex:0 0 130px;">
        <div style="flex:1;"><h3 style="font-size:24px; margin:0 0 10px; font-weight:700; text-transform:uppercase; letter-spacing:0.3px;">${r[2]}</h3><p style="font-size:14px; color:#9A9AC0; line-height:1.65; margin:0 0 14px; max-width:600px;">${r[3]}</p><div style="display:flex; gap:10px; flex-wrap:wrap;">${r[4].map(tag).join('')}</div></div>
        ${arrow}
      </div>`).join('');
const a=s.indexOf('  <!-- PAGE HEADING'), b=s.indexOf('  <!-- PROCESS TIMELINE');
s=s.slice(0,a)+`  <!-- PAGE HEADING -->
  <section style="padding:70px 64px 20px;">
    <span class="eyebrow">Event Services</span>
    <h1 class="bebas" style="font-size:88px; margin:14px 0 14px; color:${LT};">WHAT WE DO</h1>
    <p style="font-size:15px; color:#9A9AC0; max-width:560px; margin:0;">Everything your event needs, from the first brief to the last guest leaving — planned, booked, designed and run by one crew.</p>
  </section>

  <!-- SERVICE ROWS -->
  <section style="padding:30px 64px 20px;">
    <div style="border-top:1.5px solid #2A2F5C;">${rows}
    </div>
  </section>

`+s.slice(b);
fs.writeFileSync(P+'ServicesA.dc.html',s);

// ---------- ABOUT ----------
let ab=rd('AboutA');
ab=ab.replace(/CRUX NXTION GREW OUT OF ONE FRUSTRATION[^<]*/,'CRUX NXTION STARTED WITH ONE GOAL — EVENTS PEOPLE STILL TALK ABOUT LONG AFTER THE LAST SONG.');
ab=ab.replace(/We built the opposite:[^<]*/,'One crew, hired once, present for every stage of the work — from a private party to a cultural night, across the UK.');
const w0=ab.indexOf('  <!-- WHERE WE WORK'), w1=ab.indexOf('  <!-- OUR CREW');
ab=ab.slice(0,w0)+founder+ab.slice(w1);
ab=rep(ab,'On-Site Operations','On-Site Coordination');
fs.writeFileSync(P+'AboutA.dc.html',ab);
let fq=rd('FAQA');
fq=fq.replace(/Festivals, exhibitions, cultural nights, weddings, and private or corporate events[^<]*/,'Private and corporate events, weddings, cultural nights and parties — planned, booked and run by one crew.').replace(/The earlier the better, especially for full festival or exhibition productions./,'The earlier the better, especially for weddings and weekend dates.');
fs.writeFileSync(P+'FAQA.dc.html',fq);
console.log('ok');
