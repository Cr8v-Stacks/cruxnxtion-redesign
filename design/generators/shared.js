const fs=require('fs');
const SP='C:/Users/user/AppData/Local/Temp/claude/C--Users-user-OneDrive-Documents-Dev-Playground-Cr8v-Stacks-Events-Website-main/97df7f88-296d-4e3c-80ef-abf4a42b7050/scratchpad/';
const P=SP+'pub/project/'; fs.mkdirSync(SP+'meas',{recursive:true});
const A=require('./a2e.js'); const {THEMES,IM,LT,LS,PU,RD,NAVY}=A;
const T=THEMES.light; const X=A.build(T,'dc');
const B=(id)=>'/_blob/'+id;
const J={a7717:B('cf1ceb83917462889e44cacbaceaa722'),a8569:B('848d8e1043a6ef12d1cc8d2c2844ece2'),a7447:B('cca64f06a2bcaa90eccb8e5c1d37e5bb'),bam:B('a67d85c16f6df90ab7a657160bee9088')};
const PRE=A.PRE.replace("GOT AN IDEA?<br>LET'S TALK IT THROUGH.","ONE CREW.<br>TWO WAYS TO WORK.").replace('>Book A Discovery Call<','>Get In Touch<').replace("Tell us where you are stuck — we'll take it from there.","Booking an event or building a business — tell us what you're planning and we'll take it from there.");
const shout=X.shout.replace(/Crux Nxtion Consultancy — now booking discovery calls — <a href="#contact"([^>]*)>tell us where you're stuck &rarr;<\/a>/,'Now booking 2026/2027 — Events &amp; Business Consultancy — <a href="#contact"$1>get in touch &rarr;</a>');
const NAV=['Home','Services','Events','Gallery','About','Contact'];
const CM=require('./common.js');
const header=(a)=>CM.megaHeader({ctx:'shared',active:a,c:CM.C_LIGHT});
const page=(name,active,body,script)=>{
  const head=X.head.replace(/<title>[^<]*<\/title>/,`<title>${name} — Shared (light)</title>`);
  return head+shout+header(active)+body+X.wrapPre+PRE+X.close+script+'\n</body>\n</html>\n';
};
const tabScript=(extra,h)=>`<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":${h}}}'>
class Component extends DCLogic {
  constructor(props) { super(props); this.state = { tab: 'events', open: 0 }; }
  renderVals() {
    const isEvents = this.state.tab === 'events';
    const base = 'border:none; border-radius:999px; padding:12px 26px; font-size:13.5px; font-weight:700; cursor:pointer; font-family:inherit; transition:all .25s ease; ';
    const onE = 'background:#002671; color:#FFFFFF;', onC = 'background:${PU}; color:${NAVY};', off = 'background:transparent; color:${T.tx};';
    const out = {
      isEvents, isConsult: !isEvents,
      eventsTabStyle: base + (isEvents ? onE : off),
      consultTabStyle: base + (!isEvents ? onC : off),
      pickEvents: () => this.setState({ tab: 'events', open: 0 }),
      pickConsult: () => this.setState({ tab: 'consult', open: 0 }),
    };
    ${extra}
    return out;
  }
}
</script>`;
const tabs=()=>`<div style="display:inline-flex; border:1.5px solid ${T.cb}; border-radius:999px; padding:4px; gap:4px; background:${T.bg};"><button onClick="{{pickEvents}}" style="{{eventsTabStyle}}">Events</button><button onClick="{{pickConsult}}" style="{{consultTabStyle}}">Consultancy</button></div>`;
const photoCard=(img,title,desc,span)=>`
      <a href="#" class="bento-tile" style="grid-column:span ${span}; position:relative; overflow:hidden; border-radius:22px; display:block;">
        <img src="${img}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px;"><h3 class="bebas" style="font-size:30px; margin:0 0 6px; color:${LT};">${title}</h3><p style="font-size:13px; line-height:1.6; color:${LS}; margin:0;">${desc}</p></div>
      </a>`;
const grid=(cards)=>`<div style="display:grid; grid-template-columns:repeat(6, minmax(0, 1fr)); grid-template-rows:repeat(2, 320px); gap:16px;">${cards.map((c,i)=>photoCard(c[0],c[1],c[2],i<2?3:2)).join('')}</div>`;
const EV=[[IM.e1,'EVENT MANAGEMENT &amp; PLANNING','Meticulous coordination and planning for private and corporate events.'],[IM.e2,'ENTERTAINMENT BOOKING &amp; TALENT','Star power and top-tier talent, matched to the vibe of your event.'],[IM.e3,'EVENT DESIGNS &amp; PRODUCTION','Themed, creative production for weddings, birthdays and launches.'],[J.a7717,'EVENT MARKETING &amp; PROMOTION','Buzz, visibility and promotion that fills the room.'],[J.a8569,'ON-SITE COORDINATION','Real-time support, venue logistics and day-of management.']];
const CO=[[IM.shop,'BUSINESS SETUP &amp; STRATEGY','Structure, positioning and a clear plan for the business you want to build.'],[IM.blazer,'BRANDING &amp; MARKETING','An identity and a marketing plan that say what you do.'],[IM.store,'BUSINESS GROWTH','A realistic route to more customers and more revenue.'],[IM.vendor,'ACTIVATION GROWTH','Campaigns and activations that turn attention into action.'],[IM.laptop,'BUSINESS AUDIT &amp; ADVISORY','An honest look at what is working — and what to do next.']];

// ============ ABOUT ============
const aboutBody=(mode)=>`  <!-- 1 HERO -->
  <section style="min-height:800px; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; padding:60px 64px;">
    <div>
      <span class="eyebrow">About Crux Nxtion</span>
      <h1 class="bebas" style="font-size:62px; line-height:0.98; white-space:nowrap; margin:18px 0 22px; color:${T.tx};">ONE CREW.<br>TWO WAYS TO BUILD<br><span style="color:${T.pu};">SOMETHING THAT LASTS.</span></h1>
      <p style="font-size:17px; line-height:1.7; color:${T.soft}; max-width:540px; margin:0 0 30px;">We plan, book and run events people talk about for weeks — and we help the businesses behind them get clearer, bolder and better organised. Two services, one Sheffield crew.</p>
      <div style="display:flex; gap:16px;"><a href="#founder" style="background:${PU}; color:${NAVY}; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Meet The Founder</a><a href="#contact" style="border:1.5px solid ${T.tx}; color:${T.tx}; font-weight:700; font-size:15px; padding:14.5px 28px;">Get In Touch</a></div>
    </div>
    <div style="position:relative; height:640px;">
      <img src="${IM.e2}" alt="" style="position:absolute; right:0; top:0; width:400px; height:500px; object-fit:cover; border-radius:26px;">
      <img class="tilt-straighten" src="${IM.meeting}" alt="" style="--r:-5deg; transform:rotate(var(--r)); position:absolute; left:0; bottom:0; width:340px; height:260px; object-fit:cover; border-radius:20px; border:4px solid ${T.bg};">
      <img class="tilt-straighten" src="${IM.e1}" alt="" style="--r:6deg; transform:rotate(var(--r)); position:absolute; left:120px; top:30px; width:200px; height:250px; object-fit:cover; border-radius:16px; border:4px solid ${T.bg};">
      <div class="float" style="--r:6deg; position:absolute; right:-6px; bottom:60px; background:${RD}; color:#FFFFFF; padding:12px 18px; border-radius:10px;"><span class="bebas" style="font-size:20px;">SHEFFIELD, UK</span></div>
    </div>
  </section>

  <!-- 2 STORY -->
  <section style="min-height:760px; padding:100px 64px; background:${T.bg2}; display:grid; grid-template-columns:0.9fr 1.1fr; gap:80px; align-items:center;">
    <h2 class="bebas" style="font-size:66px; margin:0; color:${T.tx};">WE STARTED WITH PARTIES. WE STAYED FOR THE <span style="color:${T.pu};">PLAN BEHIND THEM.</span></h2>
    <div>
      <p style="font-size:16px; line-height:1.85; color:${T.soft}; margin:0 0 18px;">Crux Nxtion Events is your gateway to extraordinary event experiences in the UK. We merge creativity with precision, turning ordinary moments into unforgettable memories — whether it's a corporate function, a wedding celebration or a music festival.</p>
      <p style="font-size:16px; line-height:1.85; color:${T.soft}; margin:0 0 28px;">As our clients grew, they kept asking for the thinking behind the event: the brand, the growth plan, the next move. That's how Crux Nxtion Consultancy began — the same care and attention to detail, pointed at your business.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap;">${['Sheffield, UK','One-stop solution','Client-centric','Creativity with precision'].map(x=>`<span style="border:1px solid ${T.cb}; background:${T.bg}; color:${T.ct}; font-size:12.5px; font-weight:600; padding:10px 18px; border-radius:999px;">${x}</span>`).join('')}</div>
    </div>
  </section>

  <!-- 3 WHAT WE DO — tabs -->
  <section style="min-height:820px; padding:100px 64px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;">
      <div><span class="eyebrow">What We Do</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:${T.tx};">TWO SERVICES. ONE CREW.</h2></div>
      ${tabs()}
    </div>
    <sc-if value="{{isEvents}}" hint-placeholder-val="{{true}}">${grid(EV)}</sc-if>
    <sc-if value="{{isConsult}}" hint-placeholder-val="{{false}}">${grid(CO)}</sc-if>
  </section>

  <!-- 4 DIFFERENCE -->
  <section style="min-height:760px; padding:100px 64px; background:${T.bg2};">
    <div style="text-align:center; margin-bottom:50px;"><span class="eyebrow">The Crux Nxtion Difference</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:${T.tx};">WHY PEOPLE COME BACK.</h2></div>
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:18px;">${[['01','Client-centric','A passion for creativity, pointed at your vision. We turn what you picture into what happens.'],['02','One-stop solution','Planning, booking, design, promotion and on-the-day coordination under one roof.'],['03','Destination-ready','Weddings and corporate retreats away from home, coordinated on the ground.'],['04','Strategy behind the party','Our consultancy arm helps you build the business the event is for.']].map(c=>`
      <div class="bento-tile" style="background:${T.bg}; border:1.5px solid ${T.bd}; border-radius:22px; padding:32px 28px; min-height:300px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:${T.pu}; line-height:0.9;">${c[0]}</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 10px; color:${T.tx};">${c[1].toUpperCase()}</h3><p style="font-size:14px; line-height:1.7; color:${T.soft}; margin:0;">${c[2]}</p></div></div>`).join('')}
    </div>
  </section>

  <!-- 5 FOUNDER -->
  <section id="founder" style="min-height:760px; padding:100px 64px; display:grid; grid-template-columns:0.8fr 1.2fr; gap:70px; align-items:center;">
    <div class="tilt-straighten" style="--r:-2deg; transform:rotate(var(--r)); border-radius:22px; overflow:hidden; border:2px solid ${PU}; height:580px;"><img src="${J.bam}" alt="Olabamidele 'Bambad' Badmos" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"></div>
    <div>
      <span class="eyebrow">Meet The Founder</span>
      <h2 class="bebas" style="font-size:68px; margin:14px 0 20px; color:${T.tx};">OLABAMIDELE "BAMBAD" BADMOS.</h2>
      <p style="font-size:16px; line-height:1.8; color:${T.soft}; max-width:620px; margin:0 0 14px;">Bambad is a Sheffield event producer known as the "Oba of Events". He built Crux Nxtion from a small events crew into one of the city's busiest party and culture brands, selling out more than 76 events across the UK.</p>
      <p style="font-size:16px; line-height:1.8; color:${T.soft}; max-width:620px; margin:0 0 28px;">His crew now brings the same standard to weddings, cultural nights and private celebrations — and, through Crux Nxtion Consultancy, to the businesses behind them.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap;">${['76+ events sold out','Naija Food Carnival: 400+ guests','Founder, Nxtion Food Market'].map(x=>`<span style="border:1px solid ${T.cb}; color:${T.ct}; font-size:12.5px; font-weight:600; padding:10px 18px; border-radius:999px;">${x}</span>`).join('')}</div>
    </div>
  </section>

  <!-- 6 JOURNEY -->
  <section style="min-height:760px; padding:100px 64px; background:${T.bg2};">
    <div style="margin-bottom:60px;"><span class="eyebrow">How We Got Here</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:${T.tx};">FROM THE DANCE FLOOR TO THE BOARDROOM.</h2></div>
    <div style="position:relative; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:22px;">
      <div style="position:absolute; left:28px; right:28px; top:28px; border-top:2px dashed ${T.cb};"></div>
${[['1','An events crew in Sheffield','Hangouts, weddings and dance nights, planned and run end to end.'],['2','76+ events sold out','A reputation for filling rooms across the UK.'],['3','Naija Food Carnival','July 2024 · 400+ guests · 20+ vendors · 45+ dishes.'],['4','Crux Nxtion Consultancy','Turning business ideas into businesses that work.']].map(s=>`
      <div style="position:relative;"><div style="width:56px; height:56px; border-radius:50%; background:${T.bg2}; border:2px dashed ${T.pu}; display:flex; align-items:center; justify-content:center; margin-bottom:22px; position:relative;"><span class="bebas" style="font-size:22px; color:${T.pu};">${s[0]}</span></div><div style="background:${T.bg}; border:1.5px solid ${T.bd}; border-radius:18px; padding:24px;"><h3 class="bebas" style="font-size:28px; margin:0 0 8px; color:${T.tx};">${s[1].toUpperCase()}</h3><p style="font-size:13.5px; line-height:1.65; color:${T.soft}; margin:0;">${s[2]}</p></div></div>`).join('')}
    </div>
  </section>

`;
for(const mode of ['dc','meas']){
  const html=page('About','About',aboutBody(mode),tabScript('',5600));
  fs.writeFileSync((mode==='dc'?P:SP+'meas/')+'AboutS.dc.html',html);
}

// ============ CONTACT ============
const field=`width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid ${T.bd}; border-radius:12px; background:${T.bg}; color:${T.tx};`;
const chip=(ic,txt)=>`<div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.86); border:1.5px solid #3A3F72; border-radius:999px; padding:11px 22px 11px 12px; width:fit-content;"><span style="width:32px; height:32px; border-radius:50%; background:${PU}; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:${NAVY};">${ic}</span><span style="font-size:13px; font-weight:600; color:${LT};">${txt}</span></div>`;
const contactBody=`  <!-- 1 CONTACT -->
  <section style="min-height:860px; display:grid; grid-template-columns:1fr 1fr;">
    <div style="padding:80px 64px;">
      <span class="eyebrow">Get In Touch</span>
      <h1 class="bebas" style="font-size:72px; margin:14px 0 26px; color:${T.tx};">LET'S TALK.</h1>
      <div style="margin-bottom:28px;">${tabs().replace('>Events<','>Book An Event<').replace('>Consultancy<','>Book Consultancy<')}</div>
      <form style="display:flex; flex-direction:column; gap:14px; max-width:520px;">
        <input type="text" placeholder="Your name" style="${field}">
        <input type="email" placeholder="you@email.com" style="${field}">
        <sc-if value="{{isEvents}}" hint-placeholder-val="{{true}}"><div style="display:flex; flex-direction:column; gap:14px;"><input type="text" placeholder="Event type" style="${field}"><input type="text" placeholder="Preferred date" style="${field}"><textarea rows="4" placeholder="Tell us what you're celebrating, and where." style="${field}"></textarea></div></sc-if>
        <sc-if value="{{isConsult}}" hint-placeholder-val="{{false}}"><div style="display:flex; flex-direction:column; gap:14px;"><input type="text" placeholder="Business stage (idea / running / scaling)" style="${field}"><textarea rows="5" placeholder="Tell us what you're building, and where you're stuck." style="${field}"></textarea></div></sc-if>
        <a href="#" style="display:block; text-align:center; background:${PU}; color:${NAVY}; font-weight:700; font-size:15px; padding:17px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); margin-top:6px;">Send Your Brief</a>
      </form>
    </div>
    <div style="position:relative; overflow:hidden;">
      <img src="${IM.e2}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.92) 0%, rgba(16,20,46,0.25) 70%);"></div>
      <div style="position:relative; height:100%; display:flex; flex-direction:column; justify-content:flex-end; padding:56px; gap:12px;">
        ${chip('&#9990;','+44 7762 278076')}${chip('&#9990;','+44 7341 366400')}${chip('@','infoandsales@cruxnxtionevents.net')}${chip('&#9679;','29 Dun Work, Sheffield S3 8FB')}
        <a href="#" style="color:${LT}; font-weight:700; font-size:13px; border-bottom:1.5px solid ${PU}; padding-bottom:2px; width:fit-content; margin-top:6px;">Get directions &rarr;</a>
      </div>
    </div>
  </section>

  <!-- 2 NEXT -->
  <section style="min-height:640px; padding:100px 64px; background:${T.bg2};">
    <div style="text-align:center; margin-bottom:50px;"><span class="eyebrow">What Happens Next</span><h2 class="bebas" style="font-size:56px; margin:12px 0 0; color:${T.tx};">NO FORMS DISAPPEARING INTO THE VOID.</h2></div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:20px;">${[['01','You send a brief','A few lines is plenty — what you\'re planning, or where you\'re stuck.'],['02','We reply and talk it through','A real person comes back to you, usually with a question or two.'],['03','You get a plan','A clear next step, quote or proposal — whichever fits.']].map(c=>`<div class="bento-tile" style="background:${T.bg}; border:1.5px solid ${T.bd}; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:${T.pu}; line-height:0.9;">${c[0]}</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:${T.tx};">${c[1].toUpperCase()}</h3><p style="font-size:14px; line-height:1.65; color:${T.soft}; margin:0;">${c[2]}</p></div></div>`).join('')}</div>
  </section>

`;
for(const mode of ['dc','meas']){
  fs.writeFileSync((mode==='dc'?P:SP+'meas/')+'ContactS.dc.html',page('Contact','Contact',contactBody,tabScript('',2300)));
}

// ============ FAQ ============
const FQ={events:[['What kinds of events do you plan?','Private and corporate events, weddings, birthdays, music concerts, festivals and cultural nights — from the first brief to the last guest leaving.'],['How far ahead should I book?','As early as you can. For weddings and peak weekends, a few months gives us room to book talent and vendors.'],['Do you handle entertainment and talent?','Yes. Entertainment booking and talent management is part of the service, from DJs to headline performers.'],['Can you work with a venue we have already picked?','Absolutely. Tell us the room and we will build around it.'],['Do you work outside Sheffield?','We are Sheffield-based and produce across the UK, including destination events.'],['Can you help promote the event?','Yes — social campaigns, influencer partnerships, listings and more are all part of event marketing and promotion.']],
 consult:[['What if I only have an idea?','That is a fine place to start. Business Setup & Strategy is built for exactly that.'],['Is consultancy only for new businesses?','No. Whether you are starting, growing or just need direction, we meet you where you are.'],['What happens on the discovery call?','We listen, ask questions, and tell you honestly whether and how we can help.'],['Do you just advise, or help do it?','Both. We turn ideas into actionable plans and help you start on them.'],['Is it only for events businesses?','No. We work with founders and brands across retail, food, hospitality and services.'],['How do I book?','Send a brief through the contact page and tell us where you are stuck.']]};
const faqStatic=(k)=>FQ[k].map((q,i)=>`<div style="background:${T.bg}; border:1.5px solid ${i===0?PU:T.bd}; border-radius:16px; padding:22px 26px;"><div style="display:flex; justify-content:space-between; align-items:center; gap:20px;"><h3 style="font-size:18px; margin:0; font-weight:700; color:${T.tx};">${q[0]}</h3><span class="bebas" style="font-size:30px; color:${T.pu};">${i===0?'−':'+'}</span></div>${i===0?`<p style="font-size:14.5px; line-height:1.75; color:${T.soft}; margin:14px 0 0;">${q[1]}</p>`:''}</div>`).join('');
const faqBody=(mode)=>`  <!-- 1 FAQ -->
  <section style="min-height:900px; padding:80px 64px 100px;">
    <div style="display:grid; grid-template-columns:1fr auto; align-items:end; gap:40px; margin-bottom:44px;">
      <div><span class="eyebrow">Good To Know</span><h1 class="bebas" style="font-size:72px; margin:14px 0 0; color:${T.tx};">ASK US <span style="color:${T.pu};">ANYTHING.</span></h1></div>
      ${tabs()}
    </div>
    <div style="display:grid; grid-template-columns:1.4fr 0.6fr; gap:40px; align-items:start;">
      <div style="display:flex; flex-direction:column; gap:12px;">
      ${mode==='meas'?faqStatic('events'):`<sc-for list="{{faqs}}" as="f" hint-placeholder-count="6">
        <div onClick="{{f.pick}}" style="{{f.rowStyle}}">
          <div style="display:flex; justify-content:space-between; align-items:center; gap:20px;"><h3 style="font-size:18px; margin:0; font-weight:700; color:${T.tx};">{{f.q}}</h3><span class="bebas" style="font-size:30px; color:${T.pu}; line-height:1;">{{f.sign}}</span></div>
          <sc-if value="{{f.open}}" hint-placeholder-val="{{false}}"><p style="font-size:14.5px; line-height:1.75; color:${T.soft}; margin:14px 0 0;">{{f.a}}</p></sc-if>
        </div>
      </sc-for>`}
      </div>
      <div style="position:relative; border-radius:24px; overflow:hidden; min-height:520px;">
        <img src="${IM.women}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.2) 65%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:28px;"><h2 class="bebas" style="font-size:44px; margin:0 0 10px; color:${LT};">STILL STUCK?</h2><p style="font-size:13.5px; line-height:1.6; color:${LS}; margin:0 0 16px;">Tell us what you're planning and a real person will get back to you.</p><a href="#contact" style="background:${PU}; color:${NAVY}; font-weight:700; font-size:14px; padding:13px 24px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); display:inline-block;">Ask us directly</a></div>
      </div>
    </div>
  </section>

`;
const faqScript=`const FQ = ${JSON.stringify(FQ)};
    const list = FQ[this.state.tab];
    out.faqs = list.map((q, k) => {
      const on = k === this.state.open;
      return { q: q[0], a: q[1], open: on, sign: on ? '−' : '+', pick: () => this.setState({ open: on ? -1 : k }), rowStyle: 'background:${T.bg}; border:1.5px solid ' + (on ? '${PU}' : '${T.bd}') + '; border-radius:16px; padding:22px 26px; cursor:pointer; transition:border-color .25s ease;' };
    });`;
for(const mode of ['dc','meas']){
  fs.writeFileSync((mode==='dc'?P:SP+'meas/')+'FAQS.dc.html',page('FAQ','Contact',faqBody(mode),tabScript(faqScript,1500)));
}
console.log('shared ok');
