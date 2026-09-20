const fs=require('fs');
const C=require('./common.js'); const SP=C.SP; const P=SP+'pub/project/';
const home=fs.readFileSync(P+'HomeA.dc.html','utf8');   // a1b output (old palette)
const HEAD=home.slice(0,home.indexOf('  <!-- SHOUT-OUT BAR'));
const SHOUT=home.slice(home.indexOf('  <!-- SHOUT-OUT BAR'),home.indexOf('  <!-- HEADER'));
const FOOT=C.PRECTA+C.FOOTER_OLD;
const B=(id)=>'/_blob/'+id;
const I={e41:'0b8e780372f6dedc7f78fcf0fc7bc456',e49:'e6344ccb855b3a4345d48b5f3209c566',e57:'acc3538ecc2d07c92453962c5dc5fe88',e70:'72dcd59775e18677289c9b5e912d16b7',e77:'3fcacd6b5e7c07fd83bdde5b4bebeb1e',e135:'b1e68ef21b53acd6fc513694c97d58cd',e146:'5b70d603c19ee1c815fc453dd125ca85',e165:'5556f9c57fc1515a9e3373bbbc4576b5',e183:'c8b6670f9dac6a75357ccbce7f844cd1',e250:'55eba2e6d619d5c1a571e0d933bb5f80',a7447:'cca64f06a2bcaa90eccb8e5c1d37e5bb',a7717:'cf1ceb83917462889e44cacbaceaa722',a8460:'8aa3cd8b4b49c977c888b6e97e446120',a8465:'5d2ff88df9e44a1a073b23c7eb8ac29d',a8569:'848d8e1043a6ef12d1cc8d2c2844ece2',meet:'5b1a6ab37f0230a96cac807ce57c7983',bam:'a67d85c16f6df90ab7a657160bee9088'};
const u=(k)=>B(I[k]);
const CSS=`  .pill { border:1.5px solid #2A2F5C; color:#D6D6E8; font-weight:600; font-size:12.5px; padding:10px 20px; border-radius:999px; }
  .pill.on { background:#F2F1F8; color:#10142E; border-color:#F2F1F8; }
  .strip-stub { position: relative; }
  .strip-stub::before, .strip-stub::after { content: ''; position: absolute; bottom: -11px; width: 22px; height: 22px; border-radius: 50%; background: #10142E; z-index: 2; }
  .strip-stub::before { left: 24%; }
  .strip-stub::after { left: 68%; }
`;
const page=(active,body,h)=>HEAD.replace('</style>',CSS+'</style>')+SHOUT+'  <!-- HEADER -->\n  <header></header>\n\n'+body+FOOT+`\n\n</div>\n</x-dc>\n<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":${h}}}'>\nclass Component extends DCLogic {\n  renderVals() {\n    return {};\n  }\n}\n</script>\n</body>\n</html>\n`;
const EB='https://www.eventbrite.co.uk/e/';
const swap=(t,a,b,nw)=>{ const i=t.indexOf(a), j=t.indexOf(b); if(i<0||j<0||j<i){ console.log('swap miss',a.slice(0,30)); return t; } return t.slice(0,i)+nw+t.slice(j); };

// ---------- reusable blocks ----------
const stepCard=(n,t,d,img)=>`
      <div class="tilt-ticket" style="display:flex; flex-direction:column; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:14px; overflow:hidden; --r:${[-1,0.8,-0.8,1][n-1]}deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="${u(img)}" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div class="strip-stub" style="background:#FF2E3D; padding:12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#10142E;">STEP 0${n}</span><span class="bebas" style="font-size:18px; color:#10142E;">${t}</span></div>
        <div style="padding:24px 22px 26px;"><p style="font-size:14px; line-height:1.7; color:#9A9AC0; margin:0;">${d}</p></div>
      </div>`;
const process=`  <!-- PROCESS — how we run your event -->
  <section style="padding:90px 64px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:46px;">
      <div><span class="eyebrow">How We Run Your Event</span><h2 class="bebas" style="font-size:56px; margin:12px 0 0; color:#F2F1F8;">FOUR STEPS. ONE CREW. NO STRESS.</h2></div>
      <p style="max-width:340px; font-size:14px; line-height:1.7; color:#9A9AC0; margin:0;">From the first message to the last guest leaving, the same people are with you.</p>
    </div>
    <div style="position:relative; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px;">${stepCard(1,'BRIEF','You tell us the date, the room and what you are celebrating. We ask the right questions.','e250')}${stepCard(2,'DESIGN','We shape the concept, the entertainment and every vendor involved.','a8465')}${stepCard(3,'PRODUCE','Staging, sound, décor and promotion — handled by one crew.','e77')}${stepCard(4,'DELIVER','We are on site through the last guest, so you can enjoy your own event.','e183')}
    </div>
  </section>

`;
const faqQs=[['What kinds of events do you plan?','Private and corporate events, weddings, birthdays, music concerts, festivals and cultural nights — from the first brief to the last guest leaving.'],['How far ahead should I book?','As early as you can. For weddings and peak weekends, a few months gives us room to book talent and vendors.'],['Do you handle entertainment and talent?','Yes. Entertainment booking and talent management is part of the service, from DJs to headline performers.'],['Can you work with a venue we have already picked?','Absolutely. Tell us the room and we will build around it.'],['Do you work outside Sheffield?','We are Sheffield-based and produce across the UK, including destination events.'],['Can you help promote the event?','Yes — social campaigns, influencer partnerships, listings and more are all part of event marketing and promotion.']];
const faqCard=(q,i)=>`
      <div style="background:#1B2048; border:1.5px solid #2A2F5C; border-radius:14px; padding:26px 28px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px;"><h3 style="font-size:17px; margin:0; font-weight:700;">${q[0]}</h3><span class="bebas" style="font-size:28px; color:#8C7AE6;">&minus;</span></div>
        <p style="font-size:14px; line-height:1.75; color:#9A9AC0; margin:14px 0 0;">${q[1]}</p>
      </div>`;
const faqSec=`  <!-- FAQ — card grid -->
  <section id="faq" style="padding:90px 64px;">
    <div style="text-align:center; margin-bottom:46px;"><span class="eyebrow">Good To Know</span><h2 class="bebas" style="font-size:56px; margin:14px 0 10px; color:#F2F1F8;">FREQUENTLY ASKED</h2><p style="font-size:14px; color:#9A9AC0; margin:0;">Still curious? <a href="#" style="color:#8C7AE6; font-weight:700;">Ask us directly &rarr;</a></p></div>
    <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:18px; align-items:start;">${faqQs.map(faqCard).join('')}
    </div>
  </section>

`;
const fork=`  <!-- ALSO FROM CRUX — consultancy fork -->
  <section style="padding:40px 64px 100px;">
    <div style="display:grid; grid-template-columns:1fr 1fr; min-height:660px; border-radius:26px; overflow:hidden; border:1.5px solid #2A2F5C; background:#1B2048;">
      <div style="padding:70px 60px; display:flex; flex-direction:column; justify-content:center;">
        <span class="eyebrow" style="color:#B7A6FF !important;">Also From Crux Nxtion</span>
        <h2 class="bebas" style="font-size:64px; margin:14px 0 18px; color:#F2F1F8;">GOT A BUSINESS BEHIND THE EVENT?</h2>
        <p style="font-size:16px; line-height:1.75; color:#C7C7DA; max-width:480px; margin:0 0 26px;">Crux Nxtion Consultancy turns business ideas into businesses that work. Whether you are starting from scratch, trying to grow, or need a clearer direction, we help you make smarter business moves.</p>
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:34px;">${['Business Setup &amp; Strategy','Branding &amp; Marketing','Business Growth','Business Audit &amp; Advisory'].map((s,i)=>`<div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">0${i+1}</span><span style="font-size:14.5px; font-weight:600; color:#F2F1F8;">${s}</span></div>`).join('')}</div>
        <a href="#" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); display:inline-block; width:fit-content;">Explore Consultancy &rarr;</a>
      </div>
      <div style="position:relative; overflow:hidden;">
        <img src="${u('meet')}" alt="A Crux Nxtion Consultancy session" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
        <div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(27,32,72,0.85) 0%, rgba(140,122,230,0.12) 60%);"></div>
        <div style="position:absolute; left:40px; bottom:40px; right:40px; display:flex; flex-direction:column; gap:10px;">
          <div class="float" style="--r:0deg; align-self:flex-end; max-width:78%; background:#2A2F5C; color:#F2F1F8; font-size:14px; line-height:1.5; padding:13px 17px; border-radius:18px 18px 4px 18px;">I've got an idea. I just don't know where to start.</div>
          <div style="align-self:flex-start; max-width:78%; background:#8C7AE6; color:#10142E; font-size:14px; font-weight:600; line-height:1.5; padding:13px 17px; border-radius:18px 18px 18px 4px;">Good — that's the right place to start. Tell us about it.</div>
        </div>
      </div>
    </div>
  </section>

`;
const teaser=`  <!-- FOUNDER TEASER -->
  <section id="founder" style="padding:70px 64px; background:#1B2048; display:grid; grid-template-columns:auto 1fr auto; gap:48px; align-items:center;">
    <div style="width:170px; height:210px; border-radius:16px; overflow:hidden; border:2px solid #8C7AE6;"><img src="${u('bam')}" alt="Bambad, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"></div>
    <div><span class="eyebrow">The Producer Behind The Crew</span><h2 class="bebas" style="font-size:44px; margin:12px 0 10px; color:#F2F1F8;">EVERY NIGHT STARTS WITH ONE PRODUCER'S STANDARD.</h2><p style="font-size:15px; line-height:1.7; color:#C7C7DA; margin:0; max-width:640px;">Bambad set the bar for how Crux Nxtion plans, books and runs a room. His story is the reason the crew works the way it does.</p></div>
    <a href="#" style="background:#FF2E3D; color:#10142E; font-weight:700; font-size:14px; padding:15px 28px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%); white-space:nowrap;">Meet The Founder &rarr;</a>
  </section>

`;

// ---------- HOME ----------
let h=home;
h=swap(h,'  <!-- ALSO FROM CRUX','  <!-- GALLERY',fork);
h=swap(h,'  <!-- PROCESS TIMELINE','  <!-- MINI ABOUT',process);
h=swap(h,'  <!-- FOUNDER','  <!-- FAQ — card grid',teaser);
h=swap(h,'  <!-- FAQ — card grid','  <!-- PREFOOTER',faqSec);
h=h.replace('href="#contact" style="background:#FF2E3D; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px;','href="#contact" style="background:#FF2E3D; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px;');
h=h.replace('>See The Gallery<','>See Upcoming Events<');
fs.writeFileSync(P+'HomeA.dc.html',h);

// ---------- SERVICES (events story blocks) ----------
const SV=[['01','e250','Event Management &amp; Planning','A corporate function, a wedding celebration or a music festival — and no idea where to start.','We coordinate every detail from concept to execution, so you are a guest at your own event.',['A run of show','Vendors sorted','One point of contact'],'Conferences, seminars, product launches, weddings, birthdays, brand activations and galas.'],
['02','a7717','Entertainment Booking &amp; Talent Management','You want the night to feel like a show.','We book performers, artists and entertainers who match your vibe — and keep an eye on who is current.',['A shortlist of acts','Bookings &amp; logistics','Run-of-show timings'],'Private and corporate events, music concerts and festivals.'],
['03','e49','Event Designs &amp; Production','You can picture it — you just cannot build it.','We turn the vision into a themed, styled space: concept, décor, staging and lighting.',['Concept &amp; mood','Décor &amp; styling','Staging'],'Weddings, engagement celebrations and birthday parties.'],
['04','a8569','Event Marketing &amp; Promotion','The event is great. Nobody knows about it yet.','Social campaigns, influencer partnerships, listings and offline promotion that build buzz and fill the room.',['A campaign plan','Social &amp; influencer','Listings &amp; SEO'],'Music concerts, festivals and ticketed nights.'],
['05','e70','On-Site Coordination','On the day, everything needs to just work.','Real-time support, venue logistics and vendor management, start to close.',['A floor team','Vendor management','Day-of management'],'Destination-packed events, large guest lists and multi-vendor productions.']];
const block=(s,i)=>`
      <div style="display:grid; grid-template-columns:${i%2?'1fr 0.9fr':'0.9fr 1fr'}; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:22px; overflow:hidden;">
        <div style="order:${i%2?2:1}; position:relative; min-height:400px;">
          <img src="${u(s[1])}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);">
          <div style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(0,38,113,0.35) 0%, rgba(16,20,46,0.55) 100%);"></div>
          <div class="ticket-stub" style="position:absolute; left:0; top:36px; background:#FF2E3D; padding:14px 22px 14px 26px; border-radius:0 10px 10px 0;"><span class="bebas" style="font-size:30px; color:#10142E;">${s[0]}</span></div>
        </div>
        <div style="order:${i%2?1:2}; padding:44px 46px;">
          <h3 class="bebas" style="font-size:46px; margin:0 0 18px; color:#F2F1F8;">${s[2].toUpperCase()}</h3>
          <div style="background:#10142E; border:1.5px solid #2A2F5C; border-radius:14px 14px 14px 4px; padding:16px 18px; margin-bottom:12px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#8C7AE6; font-weight:700;">You might be planning</span><p style="font-size:16px; font-weight:600; margin:6px 0 0; color:#F2F1F8;">${s[3]}</p></div>
          <div style="background:#002671; border-radius:14px 14px 4px 14px; padding:16px 18px; margin-bottom:22px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; font-weight:800;">We'll handle</span><p style="font-size:14.5px; line-height:1.6; font-weight:600; margin:6px 0 0; color:#FFFFFF;">${s[4]}</p></div>
          <span class="eyebrow">You leave with</span>
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin:12px 0 18px;">${s[5].map(x=>`<span style="border:1px solid #3A3F72; color:#D6D6E8; font-size:12px; font-weight:600; padding:8px 16px; border-radius:999px;">${x}</span>`).join('')}</div>
          <p style="font-size:12.5px; color:#9A9AC0; margin:0;"><b style="letter-spacing:1.3px; color:#8C7AE6;">GOOD FOR</b> &nbsp;${s[6]}</p>
        </div>
      </div>`;
const servicesBody=`  <!-- PAGE HEADING -->
  <section style="padding:80px 64px 50px; display:grid; grid-template-columns:1.2fr 0.8fr; gap:60px; align-items:end;">
    <div><span class="eyebrow">Event Services</span><h1 class="bebas" style="font-size:96px; margin:16px 0 0; color:#F2F1F8;">FIVE SERVICES.<br><span style="color:#FF2E3D;">ONE CREW.</span></h1></div>
    <p style="font-size:16px; line-height:1.75; color:#C7C7DA; margin:0;">Everything your event needs, from the first brief to the last guest leaving. Pick the one that sounds like your week — or tell us the date and we will work out the rest.</p>
  </section>

  <!-- SERVICE ROWS -->
  <section style="padding:20px 64px 100px;"><div style="display:flex; flex-direction:column; gap:28px;">${SV.map(block).join('')}</div></section>

`+process;
fs.writeFileSync(P+'ServicesA.dc.html',page('Services',servicesBody,4800));

// ---------- EVENTS (Option C: The Ticket Wall) ----------
const tk=(day,mon,eb,title,place,img,href,r)=>`
      <a href="${href}" class="tilt-ticket" style="display:flex; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:12px; min-height:340px; --r:${r}deg; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:#FF2E3D; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
          <span class="bebas" style="font-size:38px; color:#10142E; line-height:1;">${day}</span>
          <span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:#10142E;">${mon}</span>
        </div>
        <div style="flex:1; position:relative;">
          <img src="${u(img)}" alt="${title}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.55) 45%, rgba(16,20,46,0.15) 100%);"></div>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:20px;">
            <span class="eyebrow">${eb}</span>
            <h3 style="font-size:19px; margin:8px 0 4px; font-weight:700; color:#F2F1F8;">${title}</h3>
            <p style="font-size:12.5px; color:#C5CFF5; margin:0 0 12px;">${place}</p>
            <span style="font-weight:700; font-size:12.5px; color:#8C7AE6; border-bottom:1.5px solid #8C7AE6; padding-bottom:2px;">View Details &rarr;</span>
          </div>
        </div>
      </a>`;
const EV=[['24','FEB','IJGB Edition','LASGIDI Mainland Party','Sheffield, UK','a7447'],['23','APR','Wedding Showcase','Becoming Mr &amp; Mrs Crux Pt.3','Sheffield, UK','a8460'],['30','NOV 2024','Cultural Festival','Ankara Festival','United Kingdom','e135'],['16','DEC 2023','Dance Night','Dance OUT 2023 With Crux Nxtion Events','Sheffield, UK','e146'],['28','APR 2023','Awards','YAGI Awards','United Kingdom','e183'],['29','JAN 2023','Games Night','Millennials vs Gen Z','United Kingdom','e77'],['27','AUG 2022','Wedding Party','The Wedding Party','United Kingdom','e41'],['25','SEP 2021','Hangout','Crux Nxtion Hangout Out','Indoor Games Hangout 1.0','e250']];
const eventsBody=`  <!-- PAGE HEADING -->
  <section style="padding:70px 64px 20px;">
    <span class="eyebrow">The Ticket Wall</span>
    <h1 class="bebas" style="font-size:88px; margin:14px 0 14px; color:#F2F1F8;">EVENTS</h1>
    <p style="font-size:15px; color:#9A9AC0; max-width:560px; margin:0;">Every ticket we've printed, punched by the same crew — weddings, dance nights, awards and festivals across the UK.</p>
  </section>

  <!-- TICKET GRID -->
  <section style="padding:30px 64px 100px;">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;">${EV.map((e,i)=>tk(...e,'SingleEventA.dc.html',[-1,0.8,-0.8][i%3])).join('')}
      <div style="grid-column:span 1; display:flex; flex-direction:column; justify-content:center; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:12px; padding:32px 30px;">
        <span class="eyebrow">Stay In The Loop</span>
        <h3 class="bebas" style="font-size:30px; margin:10px 0 8px; color:#F2F1F8;">MORE FROM THE ARCHIVE</h3>
        <p style="font-size:13px; line-height:1.6; color:#9A9AC0; margin:0 0 18px;">Follow along for more from us, or send us a brief and we'll add your event to the wall.</p>
        <a href="#" style="background:#FF2E3D; color:#10142E; font-weight:700; font-size:13.5px; padding:14px 26px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%); width:fit-content;">Get In Touch</a>
      </div>
    </div>
  </section>

`;
fs.writeFileSync(P+'EventsA.dc.html',page('Events',eventsBody,2600));

// ---------- SINGLE EVENT (Option C) ----------
const single=`  <!-- BREADCRUMB -->
  <div style="padding:20px 64px 0;"><span style="font-size:13px; color:#6E6E9A;"><a href="#" style="color:#6E6E9A;">Home</a> / <a href="#" style="color:#6E6E9A;">Events</a> / <span style="color:#F2F1F8; font-weight:600;">Dance OUT 2023</span></span></div>

  <!-- HERO BANNER -->
  <section style="position:relative; margin:24px 64px 0; overflow:hidden; height:460px; clip-path:polygon(0 0,100% 0,100% 94%,0 100%); border:1.5px solid #2A2F5C;">
    <img src="${u('e146')}" alt="Dance OUT 2023" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.94) 0%, rgba(16,20,46,0.2) 60%);"></div>
    <div class="float" style="--r:-8deg; position:absolute; top:24px; right:24px; width:96px; height:96px; border-radius:50%; border:2px dashed #8C7AE6; display:flex; align-items:center; justify-content:center; background:rgba(16,20,46,0.55);"><span class="bebas" style="font-size:16px; color:#8C7AE6; text-align:center; line-height:1.1;">16<br>DEC</span></div>
    <div style="position:absolute; left:0; right:0; bottom:0; padding:36px;"><span class="eyebrow">Dance Night</span><h1 class="bebas" style="font-size:64px; margin:12px 0 0; color:#F2F1F8;">DANCE OUT 2023 WITH CRUX NXTION EVENTS</h1></div>
  </section>

  <!-- EVENT DETAILS -->
  <section style="padding:56px 64px; display:grid; grid-template-columns:1.6fr 1fr; gap:56px; align-items:start;">
    <div>
      <h2 class="bebas" style="font-size:32px; margin:0 0 16px; color:#F2F1F8;">ABOUT THIS EVENT</h2>
      <p style="font-size:15px; line-height:1.8; color:#B8BEDA; margin:0 0 20px;">Get ready to groove and move like never before with Dance Out 2023! This electrifying night is set to ignite the dance floor and send you home with a story to tell.</p>
      <p style="font-size:15px; line-height:1.8; color:#B8BEDA; margin:0 0 32px;">Tickets and full details are on Eventbrite. Want a night like this for your own crowd? Our crew plans, books and runs it end to end.</p>
      <h3 style="font-size:16px; margin:0 0 14px; font-weight:700; color:#F2F1F8;">From The Gallery</h3>
      <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:14px;">${['e250','e77','e183'].map(k=>`<img src="${u(k)}" alt="" style="width:100%; height:170px; object-fit:cover; border-radius:10px; border:1.5px solid #2A2F5C;">`).join('')}</div>
    </div>
    <div style="background:#1B2048; border:1.5px solid #2A2F5C; border-radius:16px; padding:28px;">
      <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:22px;">
        <div style="display:flex; gap:18px; align-items:center;">
          <div class="ticket-stub" style="width:52px; height:52px; border-radius:8px; background:#FF2E3D; display:flex; flex-direction:column; align-items:center; justify-content:center; flex:0 0 52px;"><span style="font-size:9px; font-weight:800; letter-spacing:1px; color:#10142E;">DEC</span><span class="bebas" style="font-size:20px; color:#10142E;">16</span></div>
          <div><div style="font-size:13.5px; font-weight:700; color:#F2F1F8;">Saturday, 16 December 2023</div><div style="font-size:12.5px; color:#9A9AC0;">10:00 PM &mdash; Late</div></div>
        </div>
        <div style="display:flex; gap:14px; align-items:center;">
          <div style="width:44px; height:44px; border-radius:10px; background:rgba(140,122,230,0.12); display:flex; align-items:center; justify-content:center; flex:0 0 44px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12z" stroke="#8C7AE6" stroke-width="1.6"/><circle cx="12" cy="9" r="2.4" stroke="#8C7AE6" stroke-width="1.6"/></svg></div>
          <div><div style="font-size:13.5px; font-weight:700; color:#F2F1F8;">Sheffield</div><div style="font-size:12.5px; color:#9A9AC0;">United Kingdom</div></div>
        </div>
      </div>
      <a href="${EB}dance-out-2023-with-crux-nxtion-events-tickets-769718547897" style="display:block; text-align:center; background:#FF2E3D; color:#10142E; font-weight:700; font-size:15px; padding:16px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); margin-bottom:12px;">Reserve Your Spot</a>
      <a href="#" style="display:block; text-align:center; border:1.5px solid #F2F1F8; color:#F2F1F8; font-weight:700; font-size:14px; padding:14px;">Ask A Question</a>
    </div>
  </section>

  <!-- YOU MIGHT ALSO LIKE -->
  <section style="padding:20px 64px 100px;">
    <h2 class="bebas" style="font-size:36px; margin:0 0 28px; color:#F2F1F8;">YOU MIGHT ALSO LIKE</h2>
    <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:24px;">${[['e135','Cultural Festival • 30 Nov 2024','Ankara Festival','United Kingdom'],['e183','Awards • 28 Apr 2023','YAGI Awards','United Kingdom']].map(c=>`
      <a href="SingleEventA.dc.html" style="display:flex; flex-direction:column; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:14px; overflow:hidden;"><div style="height:200px;"><img src="${u(c[0])}" alt="" style="width:100%; height:100%; object-fit:cover; display:block;"></div><div style="padding:20px; display:flex; flex-direction:column; gap:8px;"><span class="eyebrow">${c[1]}</span><h3 style="font-size:17px; margin:0; font-weight:700; color:#F2F1F8;">${c[2]}</h3><p style="font-size:12.5px; color:#9A9AC0; margin:0;">${c[3]}</p></div></a>`).join('')}
    </div>
  </section>

`;
fs.writeFileSync(P+'SingleEventA.dc.html',page('Events',single,2500));

// ---------- GALLERY (Option C2: ticket photo grid) ----------
const cats=['WEDDING','NIGHT OUT','LIVE','CULTURE','CREW','PRIVATE'];
const gk=['e41','a8465','e250','e57','a7717','e77','e135','e49','e183','a8569','e70','e146','a7447','e165','a8460'];
const gf=(k,i)=>`
      <a href="#" style="display:flex; flex-direction:column; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:12px; overflow:hidden; transform:rotate(${[-1,0.8,-0.8,0.6,-0.6,1][i%6]}deg);">
        <div style="position:relative; height:${[240,280,220][i%3]}px;"><img src="${u(k)}" alt="Crux Nxtion Events frame ${i+1}" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#FF2E3D; padding:12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#10142E;">${cats[i%6]}</span><span class="bebas" style="font-size:14px; color:#10142E;">FRAME ${String(i+1).padStart(2,'0')}</span></div>
      </a>`;
const galleryBody=`  <!-- PAGE HEADING -->
  <section style="padding:70px 64px 20px;">
    <span class="eyebrow">The Ticket Wall</span>
    <h1 class="bebas" style="font-size:88px; margin:14px 0 14px; color:#F2F1F8;">GALLERY</h1>
    <p style="font-size:15px; color:#9A9AC0; max-width:520px; margin:0;">Every frame, filed like a ticket — punched by the same crew.</p>
  </section>

  <!-- TICKET PHOTO GRID -->
  <section style="padding:30px 64px 100px;">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:34px 26px; align-items:start;">${gk.map(gf).join('')}
    </div>
  </section>

`;
fs.writeFileSync(P+'GalleryA.dc.html',page('Gallery',galleryBody,4200));

// ---------- BLOG (Option C: The Journal — sample posts) ----------
const POSTS=[['FEATURED','Event Recap','Behind Dance OUT 2023: How We Fill A Dance Floor','A behind-the-scenes look at how one crew plans, books and runs a night built to keep people moving.','e146','9 min read'],['GUIDES','Guides','Planning A Nigerian Wedding Party In The UK','The venue, the vendors, the music and the timeline — where to start and what to book first.','e41','7 min read'],['NOTES','Behind The Scenes','What Entertainment Booking Really Involves','From shortlist to soundcheck: how talent gets matched to the vibe of your night.','a7717','6 min read'],['GUIDES','Guides','How Far Ahead Should You Book Your Event?','A simple timeline for weddings, birthdays and corporate dates.','e77','5 min read'],['STORY','Our Story','From Events Crew To Consultancy: Why We Started','Why the team that runs your night now helps run your business.','e183','8 min read'],['RECAP','Event Recap','Ankara Festival, In Photos','A celebration of the vibrancy and diversity of African culture, in pictures.','e135','4 min read']];
const post=(p,i)=>i===0?`
      <a href="SingleBlogA.dc.html" class="ticket" style="grid-column:span 3; display:flex; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:12px; min-height:340px; overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 110px; background:#FF2E3D; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:16px; color:#10142E; writing-mode:vertical-rl; letter-spacing:2px;">${p[0]}</span></div>
        <div style="flex:1; position:relative;"><img src="${u(p[4])}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(16,20,46,0.94) 0%, rgba(16,20,46,0.55) 45%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; top:0; bottom:0; display:flex; flex-direction:column; justify-content:center; padding:36px; max-width:580px;"><span class="eyebrow">${p[1]}</span><h2 class="bebas" style="font-size:38px; margin:12px 0 12px; color:#F2F1F8;">${p[2].toUpperCase()}</h2><p style="font-size:14px; color:#D6D0F5; line-height:1.6; margin:0 0 16px;">${p[3]}</p><span style="font-weight:700; font-size:12.5px; color:#8C7AE6; border-bottom:1.5px solid #8C7AE6; padding-bottom:2px; width:fit-content;">Read The Story &rarr;</span></div></div>
      </a>`:`
      <a href="SingleBlogA.dc.html" class="ticket" style="display:flex; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:12px; min-height:340px; overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 60px; background:#FF2E3D; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#10142E; writing-mode:vertical-rl; letter-spacing:2px;">${p[0]}</span></div>
        <div style="flex:1; position:relative;"><img src="${u(p[4])}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.5) 45%, rgba(16,20,46,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px;"><span class="eyebrow">${p[1]}</span><h3 style="font-size:17px; margin:8px 0 6px; font-weight:700; color:#F2F1F8;">${p[2]}</h3><span style="font-size:11.5px; color:#C5CFF5;">${p[5]}</span></div></div>
      </a>`;
const blogBody=`  <!-- PAGE HEADING -->
  <section style="padding:70px 64px 20px;">
    <span class="eyebrow">Notes From The Crew</span>
    <h1 class="bebas" style="font-size:88px; margin:14px 0 14px; color:#F2F1F8;">THE JOURNAL</h1>
    <p style="font-size:15px; color:#9A9AC0; max-width:540px; margin:0;">Event recaps, planning guides and stories from the crew — filed like a ticket, punched by the same people.</p>
  </section>

  <!-- TICKET GRID -->
  <section style="padding:30px 64px 100px;">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;">${POSTS.map(post).join('')}
      <div style="grid-column:span 3; display:flex; align-items:center; justify-content:space-between; background:#1B2048; border:1.5px solid #2A2F5C; border-radius:12px; padding:32px 36px;"><div><span class="eyebrow">Have A Story We Should Cover?</span><h3 class="bebas" style="font-size:28px; margin:10px 0 0; color:#F2F1F8;">SEND US A NOTE</h3></div><a href="#" style="background:#FF2E3D; color:#10142E; font-weight:700; font-size:13.5px; padding:14px 26px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%);">Get In Touch</a></div>
    </div>
  </section>

`;
fs.writeFileSync(P+'BlogA.dc.html',page('Blog',blogBody,2700));

// ---------- SINGLE BLOG ----------
const sec=(n,t,d)=>`<div style="margin-bottom:34px;"><h2 class="bebas" style="font-size:34px; margin:0 0 10px; color:#F2F1F8;"><span style="color:#8C7AE6;">${n}.</span> ${t}</h2><p style="font-size:16px; line-height:1.85; color:#B8BEDA; margin:0;">${d}</p></div>`;
const singleBlog=`  <!-- BREADCRUMB -->
  <div style="padding:20px 64px 0;"><span style="font-size:13px; color:#6E6E9A;"><a href="#" style="color:#6E6E9A;">Home</a> / <a href="#" style="color:#6E6E9A;">Journal</a> / <span style="color:#F2F1F8; font-weight:600;">How We Fill A Dance Floor</span></span></div>

  <!-- ARTICLE HEADER -->
  <section style="padding:40px 64px 30px; max-width:1000px;">
    <span class="eyebrow">Event Recap</span>
    <h1 class="bebas" style="font-size:72px; margin:14px 0 18px; color:#F2F1F8;">BEHIND DANCE OUT 2023: HOW WE FILL A DANCE FLOOR</h1>
    <p style="font-size:13px; color:#9A9AC0; margin:0;">Crux Nxtion Events &nbsp;&bull;&nbsp; 9 min read</p>
  </section>
  <section style="margin:0 64px; height:420px; overflow:hidden; border-radius:16px; border:1.5px solid #2A2F5C;"><img src="${u('e146')}" alt="" style="width:100%; height:100%; object-fit:cover;"></section>

  <!-- ARTICLE -->
  <section style="padding:56px 64px 80px; display:grid; grid-template-columns:1.6fr 0.8fr; gap:70px; align-items:start;">
    <div>
      ${sec(1,'START WITH THE CROWD','Before the venue, the lineup or the lighting, decide who the night is for. Everything else follows from that answer.')}
      ${sec(2,'BOOK FOR THE ROOM','A great DJ in the wrong room is a wasted booking. We match entertainment to the space, the time of night and the energy we want on the floor.')}
      <div style="border-left:4px solid #8C7AE6; padding:6px 0 6px 24px; margin:0 0 34px;"><p class="bebas" style="font-size:34px; line-height:1.15; margin:0; color:#F2F1F8;">"A NIGHT LIKE THIS IS PLANNED IN THE DETAILS NOBODY NOTICES."</p></div>
      ${sec(3,'KEEP THE ENERGY MOVING','Gaps kill a dance floor. We plan the run of show so the music, the hosts and the breaks build rather than interrupt.')}
      ${sec(4,'BE ON THE FLOOR','The best fixes happen in the moment. That is why the crew that planned the night is the crew standing in the room.')}
      <p style="font-size:12.5px; color:#6E6E9A; margin:24px 0 0;">Sample article — real posts to replace this copy.</p>
    </div>
    <div style="background:#1B2048; border:1.5px solid #2A2F5C; border-radius:16px; padding:28px;"><span class="eyebrow">Recent Posts</span>${POSTS.slice(1,4).map(p=>`<a href="SingleBlogA.dc.html" style="display:block; padding:16px 0; border-bottom:1px solid #2A2F5C; color:#F2F1F8;"><span style="font-size:11px; letter-spacing:1.5px; color:#8C7AE6; font-weight:700;">${p[1].toUpperCase()}</span><span style="display:block; font-size:15px; font-weight:700; margin-top:6px;">${p[2]}</span></a>`).join('')}</div>
  </section>

`;
fs.writeFileSync(P+'SingleBlogA.dc.html',page('Blog',singleBlog,2500));
console.log('a1new ok');
