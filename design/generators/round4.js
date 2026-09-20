// Round 4: Contact (needs chosen inside the form), long FAQ, animated hero chat, new stock photos in the pool.
const fs=require('fs');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const rd=(f)=>fs.readFileSync(P+f+'.dc.html','utf8'), wr=(f,t)=>fs.writeFileSync(P+f+'.dc.html',t);
const inp="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E;";

// ---------------- CONTACT ----------------
{
  let t=rd('ContactS');
  if(t.includes('toggleEv')) { console.log('contact already done'); } else {
  const a=t.indexOf('      <div style="margin-bottom:28px;"><div style="display:inline-flex;');
  const b=t.indexOf('      </form>\n')+'      </form>\n'.length;
  const form=`      <form style="display:flex; flex-direction:column; gap:14px; max-width:540px;">
        <div><div style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#5A5F86; margin-bottom:10px;">What can we help with? <span style="text-transform:none; letter-spacing:0; font-weight:500;">Pick one or both.</span></div>
          <div style="display:flex; gap:8px; flex-wrap:wrap;"><button type="button" onClick="{{toggleEv}}" style="{{evChip}}">Event services</button><button type="button" onClick="{{toggleCo}}" style="{{coChip}}">Consultancy</button><button type="button" onClick="{{toggleBoth}}" style="{{bothChip}}">Both</button></div></div>
        <input type="text" placeholder="Your name" style="${inp}">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;"><input type="email" placeholder="you@email.com" style="${inp}"><input type="text" placeholder="Phone (optional)" style="${inp}"></div>
        <sc-if value="{{noneSel}}" hint-placeholder-val="{{false}}"><p style="font-size:13.5px; color:#5A5F86; margin:0; padding:14px 16px; background:#F3F1FC; border-radius:12px;">Pick what you need above and we will show the right questions.</p></sc-if>
        <sc-if value="{{ev}}" hint-placeholder-val="{{true}}"><div style="display:flex; flex-direction:column; gap:12px; padding:18px; border:1.5px solid #D6DDF3; border-radius:16px; background:#F6F8FE;">
          <span style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#002671;">Your event</span>
          <div style="display:flex; gap:8px; flex-wrap:wrap;"><sc-for list="{{evOpts}}" as="o" hint-placeholder-count="5"><button type="button" onClick="{{o.pick}}" style="{{o.style}}">{{o.label}}</button></sc-for></div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;"><input type="text" placeholder="Event type (wedding, gala, party...)" style="${inp}"><input type="text" placeholder="Preferred date" style="${inp}"></div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;"><input type="text" placeholder="Approx. number of guests" style="${inp}"><input type="text" placeholder="City or venue" style="${inp}"></div>
        </div></sc-if>
        <sc-if value="{{co}}" hint-placeholder-val="{{false}}"><div style="display:flex; flex-direction:column; gap:12px; padding:18px; border:1.5px solid #E1DEF3; border-radius:16px; background:#F7F5FE;">
          <span style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#6C58DB;">Your business</span>
          <div style="display:flex; gap:8px; flex-wrap:wrap;"><sc-for list="{{coOpts}}" as="o" hint-placeholder-count="5"><button type="button" onClick="{{o.pick}}" style="{{o.style}}">{{o.label}}</button></sc-for></div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;"><input type="text" placeholder="Business name (if you have one)" style="${inp}"><input type="text" placeholder="Stage: idea / running / scaling" style="${inp}"></div>
        </div></sc-if>
        <textarea rows="4" placeholder="{{msgHint}}" style="${inp}"></textarea>
        <a href="ContactS.dc.html" style="display:block; text-align:center; background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:17px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); margin-top:6px;">Send Your Brief</a>
      </form>
`;
  t=t.slice(0,a)+form+t.slice(b);
  const script=`<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":2800}}'>
class Component extends DCLogic {
  constructor(props) { super(props); this.state = { ev: true, co: false, e: {}, c: {} }; }
  renderVals() {
    const s = this.state;
    const chip = 'border:1.5px solid #D2CEEA; border-radius:999px; padding:11px 20px; font-size:13.5px; font-weight:700; cursor:pointer; font-family:inherit; transition:all .2s ease; ';
    const both = s.ev && s.co;
    const opt = (on, col) => 'border-radius:999px; padding:9px 15px; font-size:12.5px; font-weight:600; cursor:pointer; font-family:inherit; transition:all .2s ease; ' + (on ? 'background:' + col + '; border:1.5px solid ' + col + '; color:#FFFFFF;' : 'background:#FFFFFF; border:1.5px solid #D2CEEA; color:#10142E;');
    const EV = ['Event planning', 'Entertainment & talent', 'Design & production', 'Marketing & promotion', 'On-site coordination'];
    const CO = ['Business setup & strategy', 'Branding & marketing', 'Business growth', 'Activation growth', 'Audit & advisory'];
    return {
      ev: s.ev, co: s.co, noneSel: !s.ev && !s.co,
      evChip: chip + (s.ev && !both ? 'background:#002671; color:#FFFFFF; border-color:#002671;' : 'background:#FFFFFF; color:#10142E;'),
      coChip: chip + (s.co && !both ? 'background:#8C7AE6; color:#10142E; border-color:#8C7AE6;' : 'background:#FFFFFF; color:#10142E;'),
      bothChip: chip + (both ? 'background:#10142E; color:#FFFFFF; border-color:#10142E;' : 'background:#FFFFFF; color:#10142E;'),
      toggleEv: () => this.setState({ ev: !s.ev }),
      toggleCo: () => this.setState({ co: !s.co }),
      toggleBoth: () => this.setState({ ev: true, co: true }),
      evOpts: EV.map((l, i) => ({ label: l, style: opt(!!s.e[i], '#002671'), pick: () => this.setState({ e: Object.assign({}, s.e, { [i]: !s.e[i] }) }) })),
      coOpts: CO.map((l, i) => ({ label: l, style: opt(!!s.c[i], '#6C58DB'), pick: () => this.setState({ c: Object.assign({}, s.c, { [i]: !s.c[i] }) }) })),
      msgHint: both ? "Tell us about the event and the business, and where you're stuck." : (s.co ? "Tell us what you're building, and where you're stuck." : "Tell us what you're celebrating, and where."),
    };
  }
}
</script>`;
  t=t.replace(/<script type="text\/x-dc"[\s\S]*?<\/script>/,script);
  wr('ContactS',t);
  }
}

// ---------------- FAQ (one long page, two sections) ----------------
{
  let t=rd('FAQS');
  const EV=[
   ['What kinds of events do you plan and manage?','Private and corporate events, conferences, weddings, birthday parties, brand activations, concerts, festivals, charity galas, tournaments, inaugurations, workshops, trade shows, and online or hybrid events.'],
   ['What are your event services?','Five: Event Management & Planning, Entertainment Booking & Talent Management, Event Designs & Production, Event Marketing & Promotion, and On-Site Coordination. Use one or combine them.'],
   ['Where are you based, and do you work outside Sheffield?','Our office is at 29 Dun Work, Sheffield S3 8FB. We plan and run events across the UK, and our on-site coordination covers destination weddings and corporate retreats too.'],
   ['How do I get started?','Send us a brief through the contact page, or email infoandsales@cruxnxtionevents.net or call +44 7341 366400. Tell us the type of event, the date and roughly how many guests, and we will take it from there.'],
   ['How far ahead should I get in touch?','As early as you can. We are booking 2026 and 2027 now, and the earlier we know the date, the more options we have for venues, talent and vendors.'],
   ['Do you book DJs, artists and performers?','Yes. Entertainment Booking & Talent Management connects you with top-tier performers, artists and entertainers, and we work with talent agencies.'],
   ['Can you design and style the event?','Yes. That covers themed events, wedding design, corporate stage productions, lighting design, audio-visual production, event branding and signage, furniture and layout design, and virtual or hybrid production.'],
   ['Can you help us promote the event?','Yes. Event Marketing & Promotion covers social media campaigns, influencer partnerships, content marketing, SEO, partnership marketing, event listings and directories, offline marketing, referral programmes and community engagement.'],
   ['What does on-site coordination include?','Someone from our crew on the day handling vendor management, logistics, the run of the show and real-time problem solving, so you can enjoy your event.'],
   ['Can you work with a venue we have already chosen?','Yes. Tell us the room and we will plan around it.'],
   ['Do you run your own events, and how do I get tickets?','Yes. Events like the Ankara Festival, YAGI Awards and the Becoming Mr & Mrs Crux series are ours. Tickets are sold through Eventbrite, and each event page links there.'],
   ['Do you plan weddings?','Yes, from traditional and cultural celebrations to destination weddings. Have a look at The Wedding Party and Becoming Mr & Mrs Crux on our Events page.'],
   ['Can my business sponsor an event or become a vendor?','Yes. See the Sponsors page for the partners and vendors we already work with, then get in touch to join them.'],
   ['Where can I see your past events?','On the Events and Gallery pages, which show flyers, dates and photos from the nights we have run.']
  ];
  const CO=[
   ['What is Crux Nxtion Consultancy?','Business consultancy for people turning ideas into businesses that work. Five services: Business Setup & Strategy, Branding & Marketing, Business Growth, Activation Growth, and Business Audit & Advisory.'],
   ['What if I only have an idea?','That is a fine place to start. Business Setup & Strategy is built for exactly that: the model, the positioning and a launch plan.'],
   ['Is consultancy only for new businesses?','No. Whether you are starting, growing or just need direction, we meet you where you are.'],
   ['What happens on the discovery call?','We listen, ask questions, and tell you honestly whether and how we can help. You leave knowing your next step.'],
   ['What will I walk away with?','Something you can use: an action plan, a one-page strategy, brand direction, a growth roadmap or an audit report, depending on what you need.'],
   ['Do you just advise, or help do it?','Both. We turn ideas into actionable plans and help you start on them.'],
   ['Can you help with my brand and marketing?','Yes. Branding & Marketing sharpens your identity and message, then builds a go-to-market plan sized to your real budget.'],
   ['What is the difference between Business Growth and Activation Growth?','Business Growth finds what is capping your revenue and builds a plan to fix it. Activation Growth turns attention into customers through campaigns, live activations and partnerships.'],
   ['What is a business audit?','An honest second opinion. We look at what is working, what is not and what to fix first, and give you a clear scorecard and report.'],
   ['Is it only for events businesses?','No. We work with founders and brands across retail, food, hospitality and services.'],
   ['Can I book consultancy and events together?','Yes. Many people need both, for example a launch event alongside a brand and marketing plan. Choose both on the contact form.'],
   ['How do I book?','Send a brief through the contact page and tell us where you are stuck.']
  ];
  const det=(q,a,acc)=>`        <details style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px;"><summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;"><h3 style="font-size:17px; margin:0; font-weight:700; color:#10142E;">${q.replace(/&/g,'&amp;')}</h3><span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:${acc}; color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span></summary><p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;">${a.replace(/&/g,'&amp;')}</p></details>
`;
  const section=(id,eyebrow,title,col,acc,list,blurb)=>`    <div id="${id}" style="display:grid; grid-template-columns:320px 1fr; gap:64px; align-items:start; padding:64px 0; border-top:1.5px solid #E1DEF3;">
      <div style="position:sticky; top:24px;"><span class="eyebrow" style="color:${col};">${eyebrow}</span><h2 class="bebas" style="font-size:56px; margin:12px 0 12px; color:#10142E;">${title}</h2><p style="font-size:14.5px; line-height:1.65; color:#5A5F86; margin:0;">${blurb}</p></div>
      <div style="display:flex; flex-direction:column; gap:12px;">
${list.map(x=>det(x[0],x[1],acc)).join('')}      </div>
    </div>
`;
  const body=`  <!-- 1 FAQ -->
  <section style="padding:70px 64px 30px; background:#F3F1FC; border-bottom:1px solid #E1DEF3;">
    <span class="eyebrow">Questions</span>
    <h1 class="bebas" style="font-size:80px; margin:14px 0 14px; color:#10142E;">FREQUENTLY ASKED.</h1>
    <p style="font-size:16px; line-height:1.65; color:#5A5F86; max-width:620px; margin:0 0 24px;">Everything people ask us about events and about consultancy, in one place. Jump to the section you need.</p>
    <div style="display:flex; gap:10px; flex-wrap:wrap;"><a href="#events" style="background:#002671; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:12px 24px; border-radius:999px;">Events (${EV.length})</a><a href="#consultancy" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:13.5px; padding:12px 24px; border-radius:999px;">Consultancy (${CO.length})</a></div>
  </section>
  <section style="padding:0 64px 40px;">
${section('events','For your night','EVENTS','#002671','#002671',EV,'Planning, booking, design, promotion and running the day.')}${section('consultancy','For your business','CONSULTANCY','#6C58DB','#8C7AE6',CO,'Turning business ideas into businesses that work.')}
    <div style="border-top:1.5px solid #E1DEF3; padding:48px 0 30px; display:flex; justify-content:space-between; align-items:center; gap:24px;"><div><h3 class="bebas" style="font-size:40px; margin:0 0 6px; color:#10142E;">STILL STUCK?</h3><p style="font-size:15px; color:#5A5F86; margin:0;">Ask us directly. A real person replies.</p></div><a href="ContactS.dc.html" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Get In Touch</a></div>
  </section>

`;
  t=t.replace(/  <!-- 1 FAQ -->[\s\S]*?(?=  <!-- PREFOOTER CTA)/,body);
  t=t.replace('</style>','  details > summary::-webkit-details-marker { display:none; }\n  details[open] { border-color:#8C7AE6 !important; }\n  details[open] .fq-plus { transform:rotate(45deg); }\n  html { scroll-behavior:smooth; }\n</style>');
  t=t.replace(/<script type="text\/x-dc"[\s\S]*?<\/script>/,`<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":3600}}'>\nclass Component extends DCLogic {\n  renderVals() { return {}; }\n}\n</script>`);
  wr('FAQS',t);
}

// ---------------- Consultancy hero chat: nudge + looping animation ----------------
{
  let t=rd('HomeA2a');
  t=t.replace('<div style="position:absolute; left:0; bottom:30px; width:400px;"><div class="tilt-straighten"','<div style="position:absolute; left:-30px; bottom:12px; width:400px;"><div class="tilt-straighten"');
  let n=0;
  t=t.replace(/<div class="bubble-in" style="([^"]*?)animation-delay:[0-9.]+s;">/g,(m,st)=>{n++;return `<div class="bubble-in cb cb${n}" style="${st}">`;});
  // typing dots: identify the 3-dot block that follows the last bubble
  t=t.replace(/<div style="align-self:flex-start; display:flex; gap:5px; padding:12px 16px; background:#2A2F5C; border-radius:14px;">([\s\S]*?)<\/div>/,(m,inner)=>{
    let k=0; const dots=inner.replace(/<span style="/g,()=>{k++;return `<span class="cdot cdot${k}" style="`;});
    return `<div class="cb cbt" style="align-self:flex-start; display:flex; gap:5px; padding:12px 16px; background:#2A2F5C; border-radius:14px;">${dots}</div>`;});
  const css=`  .cb { opacity:0; animation-duration:14s; animation-iteration-count:infinite; animation-timing-function:ease; animation-fill-mode:both; }
  .cb1 { animation-name:cb1; } .cb2 { animation-name:cb2; } .cb3 { animation-name:cb3; } .cb4 { animation-name:cb4; } .cbt { animation-name:cbt; }
  @keyframes cb1 { 0%,2% { opacity:0; transform:translateY(12px); } 6%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cb2 { 0%,17% { opacity:0; transform:translateY(12px); } 21%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cb3 { 0%,34% { opacity:0; transform:translateY(12px); } 38%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cb4 { 0%,51% { opacity:0; transform:translateY(12px); } 55%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cbt { 0%,10%,15%,28%,32%,44%,48%,60% { opacity:0; } 11%,14%,29%,31%,45%,47%,62%,90% { opacity:1; } 96%,100% { opacity:0; } }
  .cdot { animation:cdot 1.1s ease-in-out infinite; } .cdot2 { animation-delay:.16s; } .cdot3 { animation-delay:.32s; }
  @keyframes cdot { 0%,70%,100% { transform:translateY(0); opacity:.45; } 35% { transform:translateY(-4px); opacity:1; } }
`;
  if(!t.includes('@keyframes cb1')) t=t.replace('</style>',css+'</style>');
  wr('HomeA2a',t);
  console.log('bubbles',n);
}
console.log('round4 ok');
