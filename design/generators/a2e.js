const fs=require('fs');
const C=require('./common.js');
const SP='C:/Users/user/AppData/Local/Temp/claude/C--Users-user-OneDrive-Documents-Dev-Playground-Cr8v-Stacks-Events-Website-main/97df7f88-296d-4e3c-80ef-abf4a42b7050/scratchpad/';
const P=SP+'pub/project/';
if(!fs.existsSync(SP+'base.html')) fs.writeFileSync(SP+'base.html',fs.readFileSync(P+'HomeA.dc.html','utf8'));
const base=fs.readFileSync(SP+'base.html','utf8'); // A1 home: source of CSS head + shared prefooter/footer (colours flipped below)
const flip=(t)=>{
 t=t.split('#FF2E3D').join('@@R@@').split('#8C7AE6').join('#FF2E3D').split('@@R@@').join('#8C7AE6');
 return t.split('rgba(140,122,230,').join('@@P@@').split('rgba(255,46,61,').join('rgba(140,122,230,').split('@@P@@').join('rgba(255,46,61,');
};
const HEAD0=flip(base.slice(0,base.indexOf('  <!-- SHOUT-OUT BAR')));
const PRE0=flip(base.slice(base.indexOf('  <!-- PREFOOTER CTA'),base.indexOf('</footer>')+9));
const PRE_OLD=PRE0.replace('Ready To Commission The Crew?','Ready When You Are').replace("DON'T SEE YOUR<br>DATE YET?","GOT AN IDEA?<br>LET'S TALK IT THROUGH.").replace('>Book The Room<','>Book A Discovery Call<').replace("Tell us the date and the vibe — we'll handle the rest.","Tell us where you are stuck — we'll take it from there.").replace('/_blob/5556f9c57fc1515a9e3373bbbc4576b5','/_blob/5b1a6ab37f0230a96cac807ce57c7983').replace('Crowd at a Crux Nxtion Events event','Crux Nxtion Consultancy session');
const PRE=C.PRECTA+C.FOOTER_FLIP;
const PU='#8C7AE6', RD='#FF2E3D', NAVY='#10142E';
const B=(id)=>'/_blob/'+id;
const IM={meeting:B('5b1a6ab37f0230a96cac807ce57c7983'),shop:B('53d4feb181f3c6e0619a155bc4be2bf5'),blazer:B('ca942693739cdc74700f9c8d65278358'),store:B('62f016a3e0b0dc275a615ae5af6b3b69'),vendor:B('8f4495361437a1d1961471650d55c60a'),laptop:B('44b7a98d85fefb8a03f8b8e625e3bcdc'),team:B('50cb2790126aab1196125a6f09c951bf'),tshirt:B('19a249fe66d9d8620a7283402ecde11e'),orange:B('a4f578a4b1ff3c642674f670e1eaa25b'),glasses:B('099943029fd5fdb6c2e6c43ae11f3316'),couch:B('e56c3376aee5c9f5027ad93a6f335536'),women:B('263030a5b7aa9f782aeddd3e7f44cb13'),e1:B('c8b6670f9dac6a75357ccbce7f844cd1'),e2:B('5d2ff88df9e44a1a073b23c7eb8ac29d'),e3:B('b1e68ef21b53acd6fc513694c97d58cd')};
const THEMES={
 dark:{name:'A2',bg:'#10142E',bg2:'#1B2048',bd:'#2A2F5C',tx:'#F2F1F8',mu:'#9A9AC0',soft:'#C7C7DA',cb:'#3A3F72',ct:'#D6D6E8',pu:'#8C7AE6',rd:'#FF2E3D',inner:'#10142E'},
 light:{name:'A2a',bg:'#FFFFFF',bg2:'#F3F1FC',bd:'#E1DEF3',tx:'#10142E',mu:'#5A5F86',soft:'#3A3F66',cb:'#D2CEEA',ct:'#3A3F66',pu:'#6C58DB',rd:'#D9182A',inner:'#FFFFFF'}};
const LT='#F2F1F8', LS='#C7C7DA'; // fixed light text used on photos

function build(T,mode){ // mode: 'dc' | 'meas'
 const dark=T===THEMES.dark;
 const bubble=(who,text,d)=>who==='c'
  ?`<div class="bubble-in" style="align-self:flex-end; max-width:80%; background:#2A2F5C; color:${LT}; font-size:14px; line-height:1.5; padding:13px 17px; border-radius:18px 18px 4px 18px; animation-delay:${d}s;">${text}</div>`
  :`<div class="bubble-in" style="align-self:flex-start; max-width:80%; background:${PU}; color:${NAVY}; font-size:14px; font-weight:600; line-height:1.5; padding:13px 17px; border-radius:18px 18px 18px 4px; animation-delay:${d}s;">${text}</div>`;
 const chatCard=(rot)=>`<div class="tilt-straighten" style="--r:${rot}deg; transform:rotate(var(--r)); background:rgba(16,20,46,0.86); border:1.5px solid #3A3F72; border-radius:24px; padding:26px; display:flex; flex-direction:column; gap:12px;">
        <div style="display:flex; align-items:center; gap:10px; padding-bottom:14px; border-bottom:2px dashed #2A2F5C;"><span class="pulse-dot" style="width:10px; height:10px; border-radius:50%; background:#3DDC84;"></span><span style="font-size:13px; font-weight:700; color:${LT};">Discovery call</span><span style="font-size:12px; color:#9A9AC0; margin-left:auto;">with Crux Nxtion</span></div>
        ${bubble('c','I\'ve got an idea. I just don\'t know where to start.',0.2)}
        ${bubble('x','Good — that\'s the right place to start. Tell us about it.',0.9)}
        ${bubble('c','Also… we\'re busy, but the business isn\'t really growing.',1.6)}
        ${bubble('x','We\'ll look at both. First: what does a good year look like for you?',2.3)}
        <div style="align-self:flex-start; display:flex; gap:5px; padding:12px 16px; background:#2A2F5C; border-radius:14px;"><span style="width:7px; height:7px; border-radius:50%; background:#9A9AC0;"></span><span style="width:7px; height:7px; border-radius:50%; background:#9A9AC0;"></span><span style="width:7px; height:7px; border-radius:50%; background:#9A9AC0;"></span></div>
      </div>`;
 const heroCopy=(tx,soft)=>`<span class="eyebrow">Crux Nxtion Consultancy &bull; Sheffield</span>
      <h1 class="bebas" style="font-size:62px; line-height:0.98; white-space:nowrap; margin:18px 0 22px; color:${tx};">YOU'VE GOT THE IDEA.<br><span style="color:${dark?PU:T.pu};">LET'S BUILD THE BUSINESS.</span></h1>
      <p style="font-size:17px; line-height:1.7; color:${soft}; max-width:540px; margin:0 0 32px;">Whether you're starting from scratch, trying to grow, or just need a clearer direction — sit down with us. We'll talk it through, then turn it into a plan you can actually follow.</p>
      <div style="display:flex; gap:16px;">
        <a href="#contact" style="background:${PU}; color:${NAVY}; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Book A Discovery Call</a>
        <a href="#how" style="border:1.5px solid ${tx}; color:${tx}; font-weight:700; font-size:15px; padding:14.5px 28px;">See How We Work</a>
      </div>`;
 const hero=dark?`  <!-- 1 HERO -->
  <section style="position:relative; min-height:800px; overflow:hidden; display:grid; grid-template-columns:1.1fr 0.9fr; gap:50px; align-items:center; padding:60px 64px;">
    <img src="${IM.meeting}" alt="Consultants working with clients" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.88) 45%, rgba(16,20,46,0.55) 100%);"></div>
    <div style="position:relative;">${heroCopy(LT,LS)}</div>
    <div style="position:relative;">${chatCard(2)}
      <div class="float" style="--r:-6deg; position:absolute; top:-28px; right:-10px; background:${RD}; color:${LT}; padding:12px 18px; border-radius:10px;"><span class="bebas" style="font-size:20px;">ACTION PLANS,<br>NOT JUST IDEAS.</span></div>
    </div>
  </section>`:`  <!-- 1 HERO -->
  <section style="min-height:800px; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; padding:60px 64px;">
    <div>${heroCopy(T.tx,T.soft)}</div>
    <div style="position:relative; height:660px;">
      <div style="position:absolute; inset:0 0 0 40px; border-radius:32px; overflow:hidden;"><img src="${IM.meeting}" alt="Consultants working with clients" style="width:100%; height:100%; object-fit:cover; object-position:35% center;"></div>
      <div style="position:absolute; left:0; bottom:30px; width:400px;">${chatCard(-2)}</div>
      <div class="float" style="--r:6deg; position:absolute; top:24px; right:-6px; background:${PU}; color:${NAVY}; padding:12px 18px; border-radius:10px;"><span class="bebas" style="font-size:20px;">ACTION PLANS,<br>NOT JUST IDEAS.</span></div>
    </div>
  </section>`;

 const fam=[[IM.tshirt,'top','I have an idea… I just don\'t know where to start.','Setup & Strategy'],[IM.shop,'center','We\'re busy, but the business isn\'t really growing.','Business Growth'],[IM.orange,'top','Our brand doesn\'t say what we actually do.','Branding & Marketing'],[IM.vendor,'center','People know us — they just don\'t buy.','Activation Growth'],[IM.laptop,'center','I need someone honest to look at the whole thing.','Audit & Advisory']];
 const famCard=(f,i)=>`
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid ${T.bd};">
          <img src="${f[0]}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:${f[1]};">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:70px; color:${RD}; line-height:1;">&ldquo;</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:${LT}; margin:0 0 20px;">${f[2]}</p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;">We help with</span><span style="border:1px solid ${PU}; color:${PU}; font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px; border-radius:999px;">${f[3].toUpperCase()}</span></div>
          </div>
        </div>`;
 const stub=(n,l)=>`<div class="ticket-stub" style="flex:0 0 90px; background:${PU}; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;"><span class="bebas" style="font-size:38px; color:${NAVY}; line-height:1;">${n}</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:${NAVY};">${l}</span></div>`;
 const entry=(r,n,l,title,body)=>`
      <a href="#" class="tilt-ticket" style="display:flex; background:${T.bg2}; border:1.5px solid ${T.bd}; border-radius:12px; min-height:300px; --r:${r}deg; transform:rotate(var(--r)); overflow:hidden;">
        ${stub(n,l)}
        <div style="flex:1; padding:28px 24px; display:flex; flex-direction:column; justify-content:flex-end;">
          <span class="eyebrow">Where are you?</span>
          <h3 style="font-size:20px; margin:8px 0 10px; font-weight:700; color:${T.tx};">${title}</h3>
          <p style="font-size:13px; line-height:1.65; color:${T.mu}; margin:0;">${body}</p>
        </div>
      </a>`;

 // panels
 const PANELS=[['01','Setup & Strategy','Business Setup & Strategy','Structure, positioning and a clear operating plan — so the idea has something solid to stand on.','Business model','Positioning','Launch plan',IM.shop],['02','Branding & Marketing','Branding & Marketing','An identity and a marketing plan that say what you do and fit the budget you actually have.','Identity','Messaging','Go-to-market',IM.blazer],['03','Business Growth','Business Growth','A realistic route to more customers and more revenue for a business that is ready to grow.','Growth plan','Offer design','Pipeline',IM.store],['04','Activation Growth','Activation Growth','Campaigns and live activations that get the audience you have moving and buying.','Campaigns','Activations','Partnerships',IM.vendor],['05','Audit & Advisory','Business Audit & Advisory','An honest look at the whole business — what is working, what is not, and the next move.','Audit','Advisory','Action plan',IM.laptop]];
 const pStyle=(on)=>({
  panelStyle:'position:relative; overflow:hidden; border-radius:22px; border:1.5px solid '+(on?PU:T.bd)+'; cursor:pointer; transition:flex .5s ease; flex:'+(on?'5':'1')+' 1 0; min-width:0;',
  imgStyle:'position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:filter .4s ease; filter:brightness('+(on?'0.85':'0.5')+');',
  numStyle:'position:absolute; left:22px; top:20px; font-size:'+(on?'34px':'24px')+'; color:'+PU+';',
  labelStyle:'position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:'+LT+'; white-space:nowrap; transition:opacity .3s ease; opacity:'+(on?'0':'1')+';',
  bodyStyle:'position:absolute; left:0; right:0; bottom:0; padding:36px; transition:opacity .4s ease; opacity:'+(on?'1':'0')+'; pointer-events:none;'});
 const tag=(t)=>`<span style="border:1px solid #5A5FA0; color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; border-radius:999px;">${t}</span>`;
 const panelInner=(p,st,imgSrc)=>`
          <img src="${imgSrc}" alt="" style="${st.imgStyle}">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
          <span class="bebas" style="${st.numStyle}">${p[0]}</span>
          <span class="bebas" style="${st.labelStyle}">${p[1]}</span>
          <div style="${st.bodyStyle}"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:${LT};">${p[2]}</h3><p style="font-size:14.5px; line-height:1.65; color:${LS}; margin:0 0 14px; max-width:460px;">${p[3]}</p><div style="display:flex; gap:8px; flex-wrap:wrap;">${tag(p[4])}${tag(p[5])}${tag(p[6])}</div></div>`;
 const panelsHtml=mode==='meas'
  ?PANELS.map((p,k)=>`<div style="${pStyle(k===0).panelStyle}">${panelInner(p,pStyle(k===0),p[7])}</div>`).join('')
  :`<sc-for list="{{panels}}" as="p" hint-placeholder-count="5">
        <div onClick="{{p.pick}}" onMouseEnter="{{p.pick}}" style="{{p.panelStyle}}">
          <img src="{{p.img}}" alt="" style="{{p.imgStyle}}">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
          <span class="bebas" style="{{p.numStyle}}">{{p.num}}</span>
          <span class="bebas" style="{{p.labelStyle}}">{{p.short}}</span>
          <div style="{{p.bodyStyle}}"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:${LT};">{{p.title}}</h3><p style="font-size:14.5px; line-height:1.65; color:${LS}; margin:0 0 14px; max-width:460px;">{{p.blurb}}</p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="border:1px solid #5A5FA0; color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; border-radius:999px;">{{p.t1}}</span><span style="border:1px solid #5A5FA0; color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; border-radius:999px;">{{p.t2}}</span><span style="border:1px solid #5A5FA0; color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; border-radius:999px;">{{p.t3}}</span></div></div>
        </div>
      </sc-for>`;

 // how it works — stair climb
 const HOW=[['01','WE TALK.','A relaxed first conversation. Tell us the idea, the mess or the goal — we ask the awkward questions.','the story so far','honest questions',IM.team],['02','WE DIG IN.','We look at your numbers, your market and your brand, and find what is really holding things back.','numbers & access','a clear diagnosis',IM.laptop],['03','WE SHAPE THE PLAN.','Priorities, in order, with owners and dates. Something you can actually follow.','decisions','the action plan',IM.couch],['04','WE PUT IT IN MOTION.','Launch, campaign, activation — we help you start, not just advise.','your time','hands-on help',IM.vendor],['05','WE STAY CLOSE.','We check in, adjust and stay close while the plan meets real life.','feedback','ongoing support',IM.women]];
 const howCol=(s,i)=>`
      <div style="position:relative; height:${270+i*38}px; background:${i===4?PU:T.bg}; border:1.5px solid ${i===4?PU:T.bd}; border-radius:20px; padding:0; overflow:visible; display:flex; flex-direction:column;">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:${T.bg2}; border:2px dashed ${dark?PU:T.pu}; display:flex; align-items:center; justify-content:center; z-index:2;"><span class="bebas" style="font-size:22px; color:${dark?PU:T.pu};">${s[0]}</span></div>
        <div style="height:${i<2?86:i<4?100:120}px; margin:0; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="${s[5]}" alt="" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, ${i===4?'rgba(140,122,230,0.5)':'rgba(16,20,46,0.55)'} 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style="padding:16px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0 8px; color:${i===4?NAVY:T.tx};">${s[1]}</h3>
          <p style="font-size:13px; line-height:1.6; color:${i===4?NAVY:T.soft}; margin:0 0 auto;">${s[2]}</p>
          <div style="border-top:1.5px dashed ${i===4?'rgba(16,20,46,0.4)':T.cb}; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:${i===4?NAVY:T.mu};"><b style="letter-spacing:1px; color:${i===4?NAVY:(dark?PU:T.pu)};">YOU BRING</b> ${s[3]}</span><span style="font-size:11px; color:${i===4?NAVY:T.mu};"><b style="letter-spacing:1px; color:${i===4?NAVY:T.rd};">WE BRING</b> ${s[4]}</span></div>
        </div>
      </div>`;

 // plan bento: two photo cards (dark overlay, no blur) + three solid cards; illustration always sits with its text at the bottom
 const DK={mockBg:'rgba(16,20,46,0.86)',mockBd:'#3A3F72',tx:LT,mu:'#9A9AC0',bar:'#3A3F72',hole:'#10142E'};
 const NV={mockBg:'#1B2048',mockBd:'#3A3F72',tx:LT,mu:'#9A9AC0',bar:'#3A3F72',hole:'#1B2048'};
 const LV={mockBg:'#FFFFFF',mockBd:'#D6D0F5',tx:NAVY,mu:'#5A5F86',bar:'#DAD6F0',hole:'#FFFFFF'};
 const shell=(bgStyle,layers,content,style)=>`
      <div class="bento-tile" style="position:relative; overflow:hidden; border-radius:24px; ${bgStyle} ${style}">${layers}
        <div style="position:relative; height:100%; padding:22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;">${content}</div>
      </div>`;
 const photoCard=(img,pos,content,style)=>shell('border:1.5px solid rgba(242,241,248,0.14);',`
        <img src="${img}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:${pos};">
        <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(16,20,46,0.3) 0%, rgba(16,20,46,0.9) 58%, rgba(16,20,46,0.96) 100%);"></div>`,content,style);
 const solidCard=(bg,bd,content,style)=>shell(`background:${bg}; border:1.5px solid ${bd};`,'',content,style);
 const txt=(title,body,get,c)=>`<div><h3 class="bebas" style="font-size:30px; margin:0 0 6px; color:${c[0]};">${title}</h3><p style="font-size:13px; line-height:1.6; color:${c[1]}; margin:0 0 10px;">${body}</p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:${c[2]};">${get}</span></div>`;
 const mk=(inner,p)=>`<div style="background:${p.mockBg}; border:1.5px solid ${p.mockBd}; border-radius:14px; padding:16px;">${inner}</div>`;
 const chk=(on,t,p)=>`<div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span style="width:16px; height:16px; border-radius:5px; ${on?`background:${PU};`:`border:1.5px solid ${RD};`}"></span><span style="font-size:12.5px; color:${on?p.tx:p.mu};">${t}</span></div>`;
 const bar=(w,p)=>`<span style="display:block; height:7px; width:${w}%; background:${p.bar}; border-radius:4px;"></span>`;
 const ring=(v,c,l,p)=>`<div style="text-align:center;"><div style="width:58px; height:58px; border-radius:50%; background:conic-gradient(${c} ${v}%, ${p.bar} 0); display:flex; align-items:center; justify-content:center;"><span style="width:42px; height:42px; border-radius:50%; background:${p.hole}; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:${p.tx};">${v}</span></div><span style="font-size:10.5px; color:${p.mu}; display:block; margin-top:5px;">${l}</span></div>`;
 const eb=(t,c)=>`<span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:${c};">${t}</span>`;
 const plan=`
${photoCard(IM.couch,'center',mk(`${eb('Action plan',PU)}${chk(true,'Define the offer',DK)}${chk(true,'Fix the pricing',DK)}${chk(true,'Choose the first channel',DK)}${chk(false,'Launch the first campaign',DK)}${chk(false,'Review and adjust',DK)}<div style="height:6px; background:#3A3F72; border-radius:3px; margin-top:16px; overflow:hidden;"><div style="width:55%; height:100%; background:${PU};"></div></div>`,DK)+txt('THE ACTION PLAN','A prioritised checklist with owners and dates — what to do this month, and what comes next.','YOU GET: A PLAN TO FOLLOW',[LT,LS,PU]),'grid-column:span 5; grid-row:span 2;')}
${solidCard(PU,PU,mk(`${eb('One-page strategy',PU)}<p class="bebas" style="font-size:22px; margin:8px 0 0; color:${LT}; line-height:1;">WHO YOU SERVE. WHAT YOU SELL. <span style="color:${PU};">HOW YOU WIN.</span></p>`,{mockBg:NAVY,mockBd:NAVY})+txt('THE ONE-PAGER','Your strategy on a single page, so anyone on your team can explain it.','YOU GET: CLARITY',[NAVY,'#1E2350',NAVY]),'grid-column:span 4;')}
${solidCard(NAVY,'#2A2F5C',mk(`${eb('Brand direction',PU)}<div style="display:flex; gap:6px; margin:10px 0 8px;"><span style="flex:1; height:26px; border-radius:7px; background:#10142E; border:1px solid #3A3F72;"></span><span style="flex:1; height:26px; border-radius:7px; background:${PU};"></span><span style="flex:1; height:26px; border-radius:7px; background:${RD};"></span></div><span class="bebas" style="font-size:20px; color:${LT};">Aa — voice &amp; look</span>`,NV)+txt('THE BRAND DIRECTION','Look, voice and message — enough to brief any designer.','YOU GET: A BRAND TO BRIEF',[LT,LS,PU]),'grid-column:span 3;')}
${solidCard('#E9E5FB','#D6D0F5',mk(`${eb('Growth roadmap','#5B45C8')}<div style="display:flex; align-items:center; gap:8px; margin-top:10px;"><span style="background:${PU}; color:${NAVY}; font-size:9.5px; font-weight:800; padding:4px 9px; border-radius:999px;">NOW</span>${bar(70,LV)}</div><div style="display:flex; align-items:center; gap:8px; margin-top:8px;"><span style="border:1px solid #5B45C8; color:#5B45C8; font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:999px;">NEXT</span>${bar(48,LV)}</div><div style="display:flex; align-items:center; gap:8px; margin-top:8px;"><span style="border:1px solid #9A9AC0; color:#5A5F86; font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:999px;">LATER</span>${bar(30,LV)}</div>`,LV)+txt('THE GROWTH ROADMAP','Now, next, later: the sequence that gets you more customers.','YOU GET: A ROUTE TO GROWTH',[NAVY,'#3A3F66','#5B45C8']),'grid-column:span 3;')}
${photoCard(IM.shop,'center',mk(`${eb('Audit scorecard',PU)}<div style="display:flex; justify-content:space-around; margin-top:12px;">${ring(72,PU,'Offer',DK)}${ring(45,RD,'Brand',DK)}${ring(88,PU,'Sales',DK)}</div>`,DK)+txt('THE AUDIT REPORT','An honest read on what\'s working, what isn\'t, and what to fix first.','YOU GET: THE TRUTH, KINDLY',[LT,LS,PU]),'grid-column:span 4;')}`;

 // faq
 const FAQ=[['What if I only have an idea?','That is a fine place to start. Business Setup & Strategy is built for exactly that.'],['Is this only for new businesses?','No. Whether you are starting, growing or just need direction, we meet you where you are.'],['What happens on the discovery call?','We listen, ask questions, and tell you honestly whether and how we can help.'],['Do you just advise, or help do it?','Both. We turn ideas into actionable plans and help you start on them.'],['Do you work outside Sheffield?','Yes — we are Sheffield-based and work with businesses across the UK.'],['How do I book?','Book a discovery call and tell us where you are stuck.']];
 const faqRow=(q,a,on)=>`<div style="background:${T.bg}; border:1.5px solid ${on?PU:T.bd}; border-radius:16px; padding:22px 26px;"><div style="display:flex; justify-content:space-between; align-items:center; gap:20px;"><h3 style="font-size:18px; margin:0; font-weight:700; color:${T.tx};">${q}</h3><span class="bebas" style="font-size:30px; color:${dark?PU:T.pu}; line-height:1;">${on?'−':'+'}</span></div>${on?`<p style="font-size:14.5px; line-height:1.75; color:${T.soft}; margin:14px 0 0; max-width:560px;">${a}</p>`:''}</div>`;
 const faqHtml=mode==='meas'
  ?FAQ.map((f,k)=>faqRow(f[0],f[1],k===0)).join('')
  :`<sc-for list="{{faqs}}" as="f" hint-placeholder-count="6">
        <div onClick="{{f.pick}}" style="{{f.rowStyle}}">
          <div style="display:flex; justify-content:space-between; align-items:center; gap:20px;"><h3 style="font-size:18px; margin:0; font-weight:700; color:${T.tx};">{{f.q}}</h3><span class="bebas" style="font-size:30px; color:${dark?PU:T.pu}; line-height:1;">{{f.sign}}</span></div>
          <sc-if value="{{f.open}}" hint-placeholder-val="{{false}}"><p style="font-size:14.5px; line-height:1.75; color:${T.soft}; margin:14px 0 0; max-width:560px;">{{f.a}}</p></sc-if>
        </div>
      </sc-for>`;

 const shout=`  <!-- SHOUT-OUT BAR -->
  <div style="background:${PU}; padding:10px 64px; display:flex; align-items:center; justify-content:center;">
    <span style="font-size:12.5px; font-weight:700; color:${NAVY}; letter-spacing:0.3px;">Crux Nxtion Consultancy — now booking discovery calls — <a href="#contact" style="color:${NAVY}; font-weight:800; border-bottom:1px solid ${NAVY};">tell us where you're stuck &rarr;</a></span>
  </div>
`;
 const header=(a)=>C.megaHeader({ctx:'consult',active:a,c:dark?C.C_A1:C.C_LIGHT});
 let head=HEAD0.replace(/<title>[^<]*<\/title>/,`<title>Consultancy — Option ${T.name}</title>`).replace('</style>',`
  .bento-tile { transition: transform .3s ease, box-shadow .3s ease; }
  .bento-tile:hover { transform: translateY(-4px); box-shadow: 0 18px 34px rgba(0,0,0,0.28); }
  .bubble-in { animation: rcFadeIn .6s ease-out both; }
  @keyframes rise { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:none; } }
  @keyframes floaty { 0%,100% { transform: translateY(0) rotate(var(--r,0deg)); } 50% { transform: translateY(-8px) rotate(var(--r,0deg)); } }
  @keyframes pulse { 0% { box-shadow:0 0 0 0 rgba(61,220,132,.6); } 70% { box-shadow:0 0 0 8px rgba(61,220,132,0); } 100% { box-shadow:0 0 0 0 rgba(61,220,132,0); } }
  h1, .eyebrow { animation: rise .8s ease both; }
  h1 { animation-delay: .12s; }
  section h2 { animation: rise .7s ease both; }
  .bento-tile img { transition: transform .6s ease; }
  .bento-tile:hover img { transform: scale(1.06); }
  button { transition: transform .2s ease, background .2s ease, opacity .2s ease; }
  button:hover { transform: scale(1.08); }
  .float { animation: floaty 5s ease-in-out infinite; }
  .pulse-dot { animation: pulse 2s infinite; }
  a[style*="clip-path"]:active { transform: translateY(0) scale(.98); }
  ${dark?'':`body { background:${T.bg}; color:${T.tx}; }\n  .eyebrow { color:${T.pu} !important; }\n  .ticket-stub::before, .ticket-stub::after { background:${T.bg} !important; }`}
</style>`);
 head=head.replace('</style>',C.MEGA_CSS+'</style>');
 head=head.replace(/(<div style="width:1440px; background:)#10142E(; overflow:hidden;">)/,`$1${T.bg}$2`);
 if(!dark) head=head.replace('background: #10142E; color: #F2F1F8;','background:#FFFFFF; color:#10142E;');
 const wrapPre=`\n  <div style="background:${NAVY};">\n`;
 const close=`\n  </div>\n\n</div>\n</x-dc>\n`;
 return {head,shout,header,hero,famCard,fam,entry,panelsHtml,howCol,HOW,plan,faqHtml,T,dark,IM,PANELS,FAQ,PRE,wrapPre,close,stub};
}

function homePage(T,mode){
 const X=build(T,mode); const {dark}=X;
 const body=`${X.hero}

  <!-- 2 SOUND FAMILIAR -->
  <section style="min-height:860px; padding:90px 0 80px; background:${T.bg};">
    <div style="padding:0 64px; display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;">
      <div><span class="eyebrow">Sound Familiar?</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:${T.tx};">THINGS FOUNDERS SAY<br>BEFORE THEY CALL US.</h2></div>
      <div style="display:flex; gap:12px;"><button onClick="{{prev}}" aria-label="Previous" style="{{prevStyle}}">&larr;</button><button onClick="{{next}}" aria-label="Next" style="{{nextStyle}}">&rarr;</button></div>
    </div>
    <div style="overflow:hidden; padding-left:64px;"><div style="{{trackStyle}}">${X.fam.map(X.famCard).join('')}
    </div></div>
  </section>

  <!-- 3 START WHERE YOU ARE -->
  <section style="min-height:760px; padding:110px 64px 60px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;">
      <h2 class="bebas" style="font-size:60px; margin:0; color:${T.tx};">START WHERE YOU ARE</h2>
      <p style="max-width:380px; font-size:14px; color:${T.mu}; margin:0;">We don't just give you ideas — we help you turn them into actionable plans.</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:24px;">
${X.entry(-1,'01','START','Starting from scratch','Business setup and strategy: structure, positioning and a launch plan.')}
${X.entry(0.8,'02','GROW','Trying to grow','Business growth and activation growth: the plan and the campaigns behind it.')}
${X.entry(-0.8,'03','CLEAR','Need a clearer direction','A business audit and advisory session, ending in an action plan you can follow.')}
    </div>
  </section>

  <!-- 4 WHAT WE DO -->
  <section id="services" style="min-height:860px; padding:70px 64px 90px; background:${T.bg};">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:34px;">
      <div><span class="eyebrow">What We Do</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:${T.tx};">FIVE WAYS WE HELP.</h2></div>
      <p style="max-width:340px; font-size:13.5px; color:${T.mu}; margin:0;">Hover or tap a panel to open it.</p>
    </div>
    <div style="display:flex; gap:14px; height:620px;">
      ${X.panelsHtml}
    </div>
  </section>

  <!-- 5 HOW IT WORKS — the climb -->
  <section id="how" style="min-height:900px; padding:90px 64px 70px; background:${T.bg2};">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:64px;">
      <div><span class="eyebrow">How It Works</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:${T.tx};">FIVE STEPS.<br>ONE CLIMB. WE'RE ON THE ROPE WITH YOU.</h2></div>
      <p style="max-width:330px; font-size:14px; line-height:1.7; color:${T.mu}; margin:0;">No jargon, no 90-page deck. Every step builds on the last, and you always know what's next.</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(5, minmax(0, 1fr)); gap:16px; align-items:end;">${X.HOW.map(X.howCol).join('')}
    </div>
  </section>

  <!-- 6 WHAT YOU WALK AWAY WITH -->
  <section style="padding:100px 64px 100px; background:${T.bg};">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;">
      <div><span class="eyebrow">What You Walk Away With</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:${T.tx};">THINGS YOU CAN ACTUALLY USE.</h2></div>
      <p style="max-width:340px; font-size:13.5px; color:${T.mu}; margin:0;">Samples shown for illustration.</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(12, minmax(0, 1fr)); grid-template-rows:repeat(2, 340px); gap:16px;">${X.plan}
    </div>
  </section>

  <!-- 7 WHY US -->
  <section style="min-height:740px; padding:100px 64px; display:grid; grid-template-columns:1fr 1fr; gap:70px; align-items:center;">
    <div>
      <span class="eyebrow">Why Us</span>
      <h2 class="bebas" style="font-size:62px; margin:14px 0 22px; color:${T.tx};">WE LEARNED TO BUILD BUSINESSES BY RUNNING ROOMS.</h2>
      <p style="font-size:15.5px; line-height:1.8; color:${T.soft}; margin:0 0 16px;">Crux Nxtion started as an events crew in Sheffield. Every event is a small business with a deadline: a budget, a brand, a launch, a crowd to win over. Do that enough times and you learn what makes a plan hold up under pressure.</p>
      <p style="font-size:15.5px; line-height:1.8; color:${T.soft}; margin:0 0 26px;">Consultancy is what happened when founders started asking for the same thinking behind their business, not just their party.</p>
      <a href="#" style="font-weight:700; font-size:14px; color:${dark?PU:T.pu}; border-bottom:1.5px solid ${dark?PU:T.pu}; padding-bottom:2px;">See the events side &rarr;</a>
    </div>
    <div style="position:relative; height:480px;">
      <img class="tilt-straighten" src="${X.IM.e1}" alt="" style="--r:-6deg; transform:rotate(var(--r)); position:absolute; left:0; top:30px; width:250px; height:310px; object-fit:cover; border-radius:14px; border:2px solid ${T.bd};">
      <img src="${X.IM.e2}" alt="" style="position:absolute; left:190px; top:90px; width:290px; height:350px; object-fit:cover; border-radius:14px; border:2px solid ${PU}; z-index:1;">
      <img class="tilt-straighten" src="${X.IM.e3}" alt="" style="--r:6deg; transform:rotate(var(--r)); position:absolute; right:0; top:0; width:220px; height:290px; object-fit:cover; border-radius:14px; border:2px solid ${T.bd};">
    </div>
  </section>

  <!-- 8 FOUNDER TEASER -->
  <section id="founder" style="padding:70px 64px; background:${T.bg}; display:grid; grid-template-columns:auto 1fr auto; gap:48px; align-items:center; border-top:1px solid ${T.bd}; border-bottom:1px solid ${T.bd};">
    <div style="width:170px; height:210px; border-radius:16px; overflow:hidden; border:2px solid ${PU};"><img src="/_blob/a67d85c16f6df90ab7a657160bee9088" alt="Bambad, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"></div>
    <div><span class="eyebrow">Who You'll Work With</span><h2 class="bebas" style="font-size:44px; margin:12px 0 10px; color:${T.tx};">A PRODUCER WHO LEARNED BY FILLING ROOMS.</h2><p style="font-size:15px; line-height:1.7; color:${T.soft}; margin:0; max-width:640px;">Consultancy at Crux Nxtion is led by the founder who built the events side from nothing. Read how that experience shapes the way we advise.</p></div>
    <a href="#" style="background:${PU}; color:${NAVY}; font-weight:700; font-size:14px; padding:15px 28px; clip-path:polygon(8px 0,100% 0,calc(100% - 8px) 100%,0 100%); white-space:nowrap;">Meet The Founder &rarr;</a>
  </section>

  <!-- 9 FAQ -->
  <section style="min-height:820px; padding:100px 64px; background:${T.bg2}; display:grid; grid-template-columns:0.8fr 1.2fr; gap:70px; align-items:start;">
    <div style="position:relative; border-radius:24px; overflow:hidden; height:640px;">
      <img src="${X.IM.women}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.25) 65%);"></div>
      <div style="position:absolute; left:0; right:0; bottom:0; padding:32px;">
        <span class="eyebrow" style="color:${PU} !important;">Good To Know</span>
        <h2 class="bebas" style="font-size:52px; margin:10px 0 14px; color:${LT};">STILL WONDERING?</h2>
        <a href="#contact" style="background:${PU}; color:${NAVY}; font-weight:700; font-size:14px; padding:14px 26px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); display:inline-block;">Ask us directly</a>
      </div>
    </div>
    <div style="display:flex; flex-direction:column; gap:12px; padding-top:6px;">
      ${X.faqHtml}
    </div>
  </section>

`;
 const scriptTxt=script(X);
 let out=X.head+X.shout+X.header('Home')+body+X.wrapPre+X.PRE+X.close+scriptTxt+'\n</body>\n</html>\n';
 // COMPACT: keep every board under the 8000px canvas limit
 out=out.replace(/min-height:(\d+)px/g,(m,v)=>+v>=700?'min-height:'+Math.round(v*0.78)+'px':m)
  .split('padding:100px 64px 100px').join('padding:70px 64px 70px').split('padding:100px 64px').join('padding:70px 64px')
  .split('padding:90px 0 80px').join('padding:64px 0 56px').split('padding:110px 64px 60px').join('padding:70px 64px 50px')
  .split('padding:90px 64px 70px').join('padding:70px 64px 60px').split('height:620px;').join('height:520px;').split('repeat(2, 340px)').join('repeat(2, 330px)');
 return out;
}

function script(X){
 const {T,PANELS,FAQ}=X;
 const PU_='#8C7AE6';
 return `<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":9000}}'>
class Component extends DCLogic {
  constructor(props) { super(props); this.state = { idx: 0, panel: 0, faq: 0 }; }
  renderVals() {
    const max = 2, i = this.state.idx, open = this.state.panel;
    const btn = 'width:48px; height:48px; border-radius:50%; font-size:18px; cursor:pointer; font-family:inherit; ';
    const BD = '${T.bd}', TXT = '${T.tx}', OFF = '${T.cb}';
    const PANELS = ${JSON.stringify(PANELS)};
    const panels = PANELS.map((p, k) => {
      const on = k === open;
      return {
        num: p[0], short: p[1], title: p[2], blurb: p[3], t1: p[4], t2: p[5], t3: p[6], img: p[7],
        pick: () => this.setState({ panel: k }),
        panelStyle: 'position:relative; overflow:hidden; border-radius:22px; border:1.5px solid ' + (on ? '${PU_}' : BD) + '; cursor:pointer; transition:flex .5s ease; flex:' + (on ? '5' : '1') + ' 1 0; min-width:0;',
        imgStyle: 'position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:filter .4s ease; filter:brightness(' + (on ? '0.85' : '0.5') + ');',
        numStyle: 'position:absolute; left:22px; top:20px; font-size:' + (on ? '34px' : '24px') + '; color:${PU_};',
        labelStyle: 'position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap; transition:opacity .3s ease; opacity:' + (on ? '0' : '1') + ';',
        bodyStyle: 'position:absolute; left:0; right:0; bottom:0; padding:36px; transition:opacity .4s ease; opacity:' + (on ? '1' : '0') + '; pointer-events:none;',
      };
    });
    const FAQ = ${JSON.stringify(FAQ)};
    const faqs = FAQ.map((q, k) => {
      const on = k === this.state.faq;
      return {
        q: q[0], a: q[1], open: on, sign: on ? '−' : '+',
        pick: () => this.setState({ faq: on ? -1 : k }),
        rowStyle: 'background:${T.bg}; border:1.5px solid ' + (on ? '${PU_}' : BD) + '; border-radius:16px; padding:22px 26px; cursor:pointer;',
      };
    });
    return {
      trackStyle: 'display:flex; gap:24px; transition:transform .5s ease; transform:translateX(-' + (i * 424) + 'px);',
      prevStyle: btn + (i === 0 ? 'background:transparent; border:1.5px solid ' + OFF + '; color:' + OFF + ';' : 'background:transparent; border:1.5px solid ' + TXT + '; color:' + TXT + ';'),
      nextStyle: btn + (i === max ? 'background:${PU_}; border:1.5px solid ' + OFF + '; color:#10142E; opacity:.35;' : 'background:${PU_}; border:1.5px solid ${PU_}; color:#10142E;'),
      prev: () => this.setState({ idx: Math.max(0, i - 1) }),
      next: () => this.setState({ idx: Math.min(max, i + 1) }),
      panels, faqs,
    };
  }
}
</script>`;
}

// ---------- services page ----------
const MORE=[["Every business starts as a rough idea. We help you pressure-test it, decide who it is for, price it sensibly and set up the structure to run it — so launch day feels like the next step, not a leap.","First-time founders, side hustles going full-time, new product lines."],["Good work deserves a brand that says so. We define your voice, your look and your message, then turn it into a marketing plan sized to your real budget — social, local, partnerships and word of mouth.","Businesses that look smaller than they are, rebrands, new launches."],["Growth is rarely one big idea — it is the right few moves in the right order. We find what is capping your revenue, sharpen the offer and build a simple pipeline you can keep feeding.","Established businesses stuck on a plateau."],["Some businesses have the audience but not the action. We design campaigns, live activations and partnerships that turn attention into enquiries and sales — drawing on years of getting crowds into rooms.","Retail, food, hospitality and community brands."],["An outside view is hard to get from the inside. We audit your offer, brand, numbers and customers, tell you plainly what is working and what is not, and hand you a prioritised action plan.","Owners who want a second opinion before the next big decision."]];
const SV=[['01','START','Business Setup & Strategy','Starting from scratch and not sure what the business should even look like?','We work out the model, the positioning and the operating plan — then a launch plan you can follow.',['A clear business model','Positioning that makes sense','A step-by-step launch plan'],'53d4feb181f3c6e0619a155bc4be2bf5'],['02','BRAND','Branding & Marketing','You do good work, but your brand doesn\'t say so.','We sharpen the identity and the message, then build a marketing plan that fits your real budget.',['Identity and messaging','A go-to-market plan','A brand you can brief anyone on'],'ca942693739cdc74700f9c8d65278358'],['03','GROW','Business Growth','Busy, but the business isn\'t really growing.','We find the constraint, design the offer and map a realistic route to more customers and revenue.',['A growth plan with priorities','A sharper offer','A simple pipeline'],'62f016a3e0b0dc275a615ae5af6b3b69'],['04','ACTIVATE','Activation Growth','People know you — they just don\'t act.','We design campaigns and activations that turn an audience into customers, and help you run them.',['Campaign concepts','Live activation ideas','Partnerships to pursue'],'8f4495361437a1d1961471650d55c60a'],['05','AUDIT','Business Audit & Advisory','You want an honest second opinion.','We look at the whole business, tell you what\'s working and what isn\'t, and recommend the next move.',['An honest audit','What to fix first','An action plan'],'44b7a98d85fefb8a03f8b8e625e3bcdc']];
function servicesPage(T){
 const X=build(T,'dc'); const dark=X.dark;
 const block=(s,i)=>`
      <div style="display:grid; grid-template-columns:${i%2?'1fr 0.9fr':'0.9fr 1fr'}; background:${T.bg2}; border:1.5px solid ${T.bd}; border-radius:22px; overflow:hidden;">
        <div style="order:${i%2?2:1}; position:relative; min-height:400px;">
          <img src="/_blob/${s[6]}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);">
          <div style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(140,122,230,0.3) 0%, rgba(16,20,46,0.55) 100%);"></div>
          <div class="ticket-stub" style="position:absolute; left:0; top:36px; background:${PU}; padding:14px 22px 14px 26px; border-radius:0 10px 10px 0;"><span class="bebas" style="font-size:30px; color:${NAVY};">${s[0]} / ${s[1]}</span></div>
        </div>
        <div style="order:${i%2?1:2}; padding:44px 46px;">
          <h3 class="bebas" style="font-size:46px; margin:0 0 18px; color:${T.tx};">${s[2].toUpperCase()}</h3>
          <div style="background:${T.bg}; border:1.5px solid ${T.bd}; border-radius:14px 14px 14px 4px; padding:16px 18px; margin-bottom:12px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:${T.rd}; font-weight:700;">You might be saying</span><p style="font-size:16px; font-weight:600; margin:6px 0 0; color:${T.tx};">${s[3]}</p></div>
          <div style="background:${PU}; border-radius:14px 14px 4px 14px; padding:16px 18px; margin-bottom:22px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:${NAVY}; font-weight:800;">We'll say</span><p style="font-size:14.5px; line-height:1.6; font-weight:600; margin:6px 0 0; color:${NAVY};">${s[4]}</p></div>
          <p style="font-size:14px; line-height:1.75; color:${T.soft}; margin:0 0 20px;">${MORE[i][0]}</p>
          <span class="eyebrow">You leave with</span>
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:12px;">${s[5].map(x=>`<span style="border:1px solid ${T.cb}; color:${T.ct}; font-size:12px; font-weight:600; padding:8px 16px; border-radius:999px;">${x}</span>`).join('')}</div>
          <p style="font-size:12.5px; color:${T.mu}; margin:18px 0 0;"><b style="letter-spacing:1.3px; color:${dark?PU:T.pu};">GOOD FOR</b> &nbsp;${MORE[i][1]}</p>
        </div>
      </div>`;
 const body=`  <!-- PAGE HEADING -->
  <section style="padding:80px 64px 50px; display:grid; grid-template-columns:1.2fr 0.8fr; gap:60px; align-items:end;">
    <div><span class="eyebrow">Consultancy Services</span><h1 class="bebas" style="font-size:96px; margin:16px 0 0; color:${T.tx};">FIVE WAYS<br><span style="color:${dark?PU:T.pu};">WE HELP.</span></h1></div>
    <p style="font-size:16px; line-height:1.75; color:${T.soft}; margin:0;">Each one starts with a conversation and ends with a plan you can act on. Pick the one that sounds like your week — or book a call and we'll work out which fits.</p>
  </section>
  <section style="padding:20px 64px 100px;"><div style="display:flex; flex-direction:column; gap:28px;">${SV.map(block).join('')}</div></section>

`;
 const sc=`<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":4600}}'>\nclass Component extends DCLogic {\n  renderVals() {\n    return {};\n  }\n}\n</script>`;
 return X.head.replace(/Consultancy — Option/,'Services — Option')+X.shout+X.header('Services')+body+X.wrapPre+X.PRE+X.close+sc+'\n</body>\n</html>\n';
}

module.exports={build,THEMES,IM,PRE,HEAD0,homePage,servicesPage,LT,LS,PU,RD,NAVY};
if(require.main===module){
fs.writeFileSync(P+'HomeA2a.dc.html',homePage(THEMES.light,'dc'));
fs.writeFileSync(P+'ServicesA2a.dc.html',servicesPage(THEMES.light));
// measurement copies (static)
fs.mkdirSync(SP+'meas',{recursive:true});
fs.writeFileSync(SP+'meas/HomeA2a.dc.html',homePage(THEMES.light,'meas'));
}
console.log('ok');
