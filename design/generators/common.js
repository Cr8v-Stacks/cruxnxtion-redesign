const fs=require('fs');
const SP='C:/Users/user/AppData/Local/Temp/claude/C--Users-user-OneDrive-Documents-Dev-Playground-Cr8v-Stacks-Events-Website-main/97df7f88-296d-4e3c-80ef-abf4a42b7050/scratchpad/';
const base=fs.readFileSync(SP+'base.html','utf8');
const flip=(t)=>{
  t=t.split('#FF2E3D').join('@@R@@').split('#8C7AE6').join('#FF2E3D').split('@@R@@').join('#8C7AE6');
  return t.split('rgba(140,122,230,').join('@@P@@').split('rgba(255,46,61,').join('rgba(140,122,230,').split('@@P@@').join('rgba(255,46,61,');
};
const FOOTER_OLD=base.slice(base.indexOf('  <!-- COLOSSAL FOOTER'),base.indexOf('</footer>')+9);
const FOOTER_FLIP=flip(FOOTER_OLD);

// One pre-footer CTA for every page (cinematic photo band with film-strip edges)
const strip=(pos)=>`<div style="position:absolute; left:0; right:0; ${pos}:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>`;
const PRECTA=`  <!-- PREFOOTER CTA — cinematic band -->
  <section style="position:relative; height:560px; overflow:hidden;">
    <img src="/_blob/280011a5d680e8c37c2727dbbc465ee8" alt="A Crux Nxtion Events crowd" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; inset:0; background:linear-gradient(100deg, rgba(10,15,38,0.97) 0%, rgba(10,15,38,0.78) 52%, rgba(10,15,38,0.4) 100%);"></div>
    ${strip('top')}${strip('bottom')}
    <div style="position:relative; z-index:1; height:100%; display:flex; flex-direction:column; justify-content:center; padding:0 64px;">
      <span class="eyebrow" style="color:#A9C0F5 !important;">Ready When You Are</span>
      <h2 class="bebas" style="font-size:84px; margin:16px 0 18px; color:#FFFFFF; max-width:820px;">GOT A DATE, OR JUST A DIRECTION?</h2>
      <p style="font-size:16px; line-height:1.7; color:#C5CADF; max-width:520px; margin:0 0 32px;">Planning an event or building a business — tell us what you have in mind and a real person will come back to you.</p>
      <div style="display:flex; gap:16px;">
        <a href="#" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:17px 32px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Plan An Event &rarr;</a>
        <a href="#" style="background:#8C7AE6; color:#0A0F26; font-weight:700; font-size:15px; padding:17px 32px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Talk Business Strategy &rarr;</a>
      </div>
    </div>
  </section>

`;

// ---- link map ----
const F=(n)=>n+'.dc.html';
const HOME={events:'HomeA',consult:'HomeA2a',shared:'HomeA'}, SVC={events:'ServicesA',consult:'ServicesA2a',shared:'ServicesA'};
function linkMap(ctx){
  return {'Home':HOME[ctx],'Services':SVC[ctx],'Events':'EventsA','Gallery':'GalleryA','About':'AboutS','Contact':'ContactS','FAQ':'FAQS','Blog':'BlogA','Book The Room':'ContactS','Book A Discovery Call':'ContactS','Get In Touch':'ContactS','Plan An Event':'ContactS','Talk Business Strategy':'ContactS','See The Gallery':'GalleryA','Explore Consultancy':'HomeA2a','Explore Events':'HomeA','View All Services':SVC[ctx],'View All Events':'EventsA','View Full Gallery':'GalleryA','See The Events Side':'HomeA','Meet The Founder':'AboutS','Read Our FAQ':'FAQS','Ask us directly':'ContactS','Ask Us Directly':'ContactS','Book An Event':'ContactS','Book Consultancy':'ContactS','Send Your Brief':'ContactS','See Upcoming Events':'EventsA','Read The Story':'SingleBlogA','Ask A Question':'ContactS','Business Consultancy':'HomeA2a','See What We Do':SVC[ctx]};
}
function link(html,ctx){
  const M=linkMap(ctx);
  return html.replace(/<a href="[^"]*"([^>]*)>([^<]*)<\/a>/g,(m,attrs,txt)=>{
    const t=txt.replace(/&rarr;|→/g,'').replace(/&nbsp;/g,' ').replace(/\s+/g,' ').trim();
    const k=Object.keys(M).find(x=>x.toLowerCase()===t.toLowerCase());
    return k?`<a href="${F(M[k])}"${attrs}>${txt}</a>`:m;
  });
}

// ---- header with mega menu + service switcher ----
const MEGA_CSS=`
  .mega-panel { display:none; position:absolute; left:0; right:0; top:100%; z-index:40; }
  .mega:hover .mega-panel, .mega.open .mega-panel { display:block; }
  .mega > a::after { display:none; }
  .mega-panel a { transition: transform .2s ease, background .2s ease; }
  .mega-panel a.mrow:hover { transform: translateX(4px); }
`;
const EVS=[['Event Management & Planning','Private and corporate events'],['Entertainment Booking & Talent','Star power for your bill'],['Event Designs & Production','Weddings, birthdays, launches'],['Event Marketing & Promotion','Buzz that fills the room'],['On-Site Coordination','Day-of logistics and support']];
const COS=[['Business Setup & Strategy','From idea to a plan'],['Branding & Marketing','Say what you do'],['Business Growth','More customers, more revenue'],['Activation Growth','Turn attention into action'],['Business Audit & Advisory','An honest second opinion']];
const NAVL=['Home','Services','Events','Gallery','About','Blog','Contact'];
function megaHeader(o){
  const {ctx,active,c,open}=o;
  const cta=ctx==='events'?'Book The Room':ctx==='consult'?'Book A Discovery Call':'Get In Touch';
  const link_=(x)=>{ const on=x===active; return `<a href="${F(linkMap(ctx)[x])}" style="color:${on?c.accent:c.tx}; font-size:13px; font-weight:600;${on?` border-bottom:1.5px solid ${c.accent};`:''}">${x}</a>`; };
  const row=(name,desc,href,dot)=>`<a class="mrow" href="${F(href)}" style="display:flex; gap:14px; align-items:flex-start; padding:10px 0; color:${c.tx};"><span style="width:8px; height:8px; border-radius:50%; background:${dot}; margin-top:6px; flex:0 0 8px;"></span><span><span style="display:block; font-size:14px; font-weight:700; color:${c.tx};">${name}</span><span style="display:block; font-size:12px; color:${c.muted}; margin-top:2px;">${desc}</span></span></a>`;
  const navHtml=NAVL.map(x=>x==='Services'
    ?`<div class="mega${open?' open':''}" style="position:static; padding:22px 0;"><a href="${F(SVC[ctx])}" style="color:${active==='Services'?c.accent:c.tx}; font-size:13px; font-weight:600;${active==='Services'?` border-bottom:1.5px solid ${c.accent};`:''}">Services &#9662;</a>
        <div class="mega-panel" style="background:${c.panelBg}; border-top:1px solid ${c.bd}; border-bottom:1px solid ${c.bd}; box-shadow:0 30px 50px rgba(0,0,0,0.25); padding:36px 64px 40px;">
          <div style="display:grid; grid-template-columns:1fr 1fr 0.9fr; gap:48px;">
            <div><div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;"><span class="bebas" style="font-size:26px; color:${c.tx};">EVENTS</span><span style="font-size:11px; letter-spacing:1.5px; font-weight:700; color:${c.evText};">FOR YOUR NIGHT</span></div>${EVS.map(e=>row(e[0],e[1],'ServicesA',c.evDot)).join('')}</div>
            <div><div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;"><span class="bebas" style="font-size:26px; color:${c.tx};">CONSULTANCY</span><span style="font-size:11px; letter-spacing:1.5px; font-weight:700; color:${c.coText};">FOR YOUR BUSINESS</span></div>${COS.map(e=>row(e[0],e[1],'ServicesA2a',c.coDot)).join('')}</div>
            <div style="position:relative; border-radius:18px; overflow:hidden; min-height:260px;"><img src="/_blob/5b1a6ab37f0230a96cac807ce57c7983" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.95) 0%, rgba(10,15,38,0.2) 70%);"></div><div style="position:absolute; left:0; right:0; bottom:0; padding:22px;"><span class="bebas" style="font-size:26px; color:#FFFFFF; display:block; margin-bottom:8px;">NOT SURE WHICH?</span><a href="${F('ContactS')}" style="display:inline-block; background:${c.ctaBg}; color:${c.ctaTx}; font-weight:700; font-size:13px; padding:11px 20px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%);">Book A Call</a></div></div>
          </div>
        </div></div>`
    :link_(x)).join('\n      ');
  const seg=(label,href,on,dot)=>`<a href="${F(href)}" style="font-size:12px; font-weight:700; padding:8px 16px; border-radius:999px; ${on?`background:${dot}; color:${dot==='#8C7AE6'?'#0A0F26':'#FFFFFF'};`:`color:${c.muted};`}">${label}</a>`;
  return `  <!-- HEADER -->
  <header style="position:relative; z-index:30; display:flex; align-items:center; justify-content:space-between; padding:0 64px; border-bottom:1px solid ${c.bd}; background:${c.bg};">
    <a href="${F(HOME[ctx])}" class="bebas" style="font-size:26px; color:${c.tx};">CRUX <span style="color:${c.accent};">NXTION</span></a>
    <nav style="display:flex; align-items:center; gap:30px;">
      ${navHtml}
    </nav>
    <div style="display:flex; align-items:center; gap:16px;">
      <div style="display:flex; border:1.5px solid ${c.bd}; border-radius:999px; padding:3px;">${seg('Events','HomeA',ctx==='events','#002671'.replace('#002671',c.evSeg))}${seg('Consultancy','HomeA2a',ctx==='consult','#8C7AE6')}</div>
      <a href="${F('ContactS')}" style="background:${c.ctaBg}; color:${c.ctaTx}; font-weight:700; font-size:13px; padding:12px 22px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%);">${cta}</a>
    </div>
  </header>

`;
}
// colour sets. Note: A1 sets use the *pre-theme* palette (a1c converts them).
const C_A1={bg:'#10142E',bd:'#2A2F5C',tx:'#F2F1F8',accent:'#8C7AE6',muted:'#9A9AC0',panelBg:'#1B2048',ctaBg:'#FF2E3D',ctaTx:'#10142E',evDot:'#5B8DEF',coDot:'#8C7AE6',evText:'#5B8DEF',coText:'#B7A6FF',evSeg:'#1E48B0'};
const C_LIGHT={bg:'#FFFFFF',bd:'#E1DEF3',tx:'#10142E',accent:'#6C58DB',muted:'#5A5F86',panelBg:'#FFFFFF',ctaBg:'#8C7AE6',ctaTx:'#0A0F26',evDot:'#002671',coDot:'#8C7AE6',evText:'#002671',coText:'#6C58DB',evSeg:'#002671'};
module.exports={SP,flip,FOOTER_OLD,FOOTER_FLIP,PRECTA,link,linkMap,megaHeader,MEGA_CSS,C_A1,C_LIGHT,EVS,COS};
