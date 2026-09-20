// Round 5: faster chat, animated bento illustrations, scroll reveals + hero drift, one unified contact form.
const fs=require('fs');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const rd=(f)=>fs.readFileSync(P+f+'.dc.html','utf8'), wr=(f,t)=>fs.writeFileSync(P+f+'.dc.html',t);
const inp="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E;";

const MOTION=`  /* ---- motion ---- */
  @property --p { syntax:'<integer>'; inherits:false; initial-value:0; }
  @keyframes apT4 { 0%,20% { background:transparent; border-color:#FF2E3D; } 28%,86% { background:#8C7AE6; border-color:#8C7AE6; } 94%,100% { background:transparent; border-color:#FF2E3D; } }
  @keyframes apT5 { 0%,44% { background:transparent; border-color:#FF2E3D; } 52%,86% { background:#8C7AE6; border-color:#8C7AE6; } 94%,100% { background:transparent; border-color:#FF2E3D; } }
  @keyframes apBar { 0%,18% { width:55%; } 30% { width:78%; } 54% { width:100%; } 86% { width:100%; } 96%,100% { width:55%; } }
  .ap4 { animation:apT4 7s ease infinite; } .ap5 { animation:apT5 7s ease infinite; } .apbar { animation:apBar 7s ease infinite; }
  @keyframes opSweep { 0%,10% { background-size:0% 3px; } 45%,85% { background-size:100% 3px; } 100% { background-size:0% 3px; } }
  .ophl { background-image:linear-gradient(#8C7AE6,#8C7AE6); background-repeat:no-repeat; background-position:0 100%; background-size:0% 3px; padding-bottom:3px; animation:opSweep 4.5s ease infinite; }
  @keyframes swUp { 0%,100% { transform:scaleY(1); } 30% { transform:scaleY(1.45); } 60% { transform:scaleY(1); } }
  .sw1, .sw2, .sw3 { transform-origin:bottom; animation:swUp 3.2s ease-in-out infinite; } .sw2 { animation-delay:.25s; } .sw3 { animation-delay:.5s; }
  @keyframes rmA { 0%,6% { transform:scaleX(0); } 26%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  @keyframes rmB { 0%,22% { transform:scaleX(0); } 42%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  @keyframes rmC { 0%,38% { transform:scaleX(0); } 58%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  .rm1, .rm2, .rm3 { transform-origin:left; animation:rmA 6s ease infinite; } .rm2 { animation-name:rmB; } .rm3 { animation-name:rmC; }
  @keyframes nowPulse { 0%,100% { box-shadow:0 0 0 0 rgba(140,122,230,.55); } 50% { box-shadow:0 0 0 7px rgba(140,122,230,0); } }
  .nowp { animation:nowPulse 2s ease infinite; }
  @keyframes ring72 { 0%,6% { --p:0; } 30%,88% { --p:72; } 100% { --p:0; } }
  @keyframes ring45 { 0%,6% { --p:0; } 30%,88% { --p:45; } 100% { --p:0; } }
  @keyframes ring88 { 0%,6% { --p:0; } 30%,88% { --p:88; } 100% { --p:0; } }
  .rg { animation-duration:6s; animation-timing-function:ease-out; animation-iteration-count:infinite; counter-reset:n var(--p); }
  .rg72 { animation-name:ring72; } .rg45 { animation-name:ring45; } .rg88 { animation-name:ring88; }
  .rgn::after { content:counter(n); }
  @keyframes revealUp { from { opacity:0; transform:translateY(26px); } to { opacity:1; transform:none; } }
  @supports (animation-timeline: view()) { .reveal { animation:revealUp linear both; animation-timeline:view(); animation-range:entry 0% cover 28%; } }
  @keyframes drift { from { transform:scale(1.02); } to { transform:scale(1.09) translate(-1%,-1%); } }
  .drift { animation:drift 18s ease-in-out infinite alternate; }
  @keyframes sheen { 0% { transform:translateX(-120%); } 60%,100% { transform:translateX(220%); } }
`;

// ---------- Consultancy home ----------
{
  let t=rd('HomeA2a');
  if(!t.includes('@keyframes apT4')){
    t=t.replace(/animation-duration:14s;/,'animation-duration:8s;').replace('.cdot { animation:cdot 1.1s','.cdot { animation:cdot .8s');
    t=t.replace('</style>',MOTION+'</style>');
    // action plan: the two open boxes tick, the bar fills
    t=t.replace(/<span style="width:16px; height:16px; border-radius:5px; border:1\.5px solid #FF2E3D;"><\/span>/,'<span class="ap4" style="width:16px; height:16px; border-radius:5px; border:1.5px solid #FF2E3D;"></span>');
    t=t.replace(/<span style="width:16px; height:16px; border-radius:5px; border:1\.5px solid #FF2E3D;"><\/span>/,'<span class="ap5" style="width:16px; height:16px; border-radius:5px; border:1.5px solid #FF2E3D;"></span>');
    t=t.replace('<div style="width:55%; height:100%; background:#8C7AE6;"></div>','<div class="apbar" style="width:55%; height:100%; background:#8C7AE6;"></div>');
    // one-pager
    t=t.replace('<span style="color:#8C7AE6;">HOW YOU WIN.</span>','<span class="ophl" style="color:#8C7AE6;">HOW YOU WIN.</span>');
    // brand direction swatches
    t=t.replace('<span style="flex:1; height:26px; border-radius:7px; background:#10142E; border:1px solid #3A3F72;"></span><span style="flex:1; height:26px; border-radius:7px; background:#8C7AE6;"></span><span style="flex:1; height:26px; border-radius:7px; background:#FF2E3D;"></span>','<span class="sw1" style="flex:1; height:26px; border-radius:7px; background:#10142E; border:1px solid #3A3F72;"></span><span class="sw2" style="flex:1; height:26px; border-radius:7px; background:#8C7AE6;"></span><span class="sw3" style="flex:1; height:26px; border-radius:7px; background:#FF2E3D;"></span>');
    // roadmap
    t=t.replace('<span style="background:#8C7AE6; color:#10142E; font-size:9.5px; font-weight:800; padding:4px 9px; border-radius:999px;">NOW</span><span style="display:block; height:7px; width:70%;','<span class="nowp" style="background:#8C7AE6; color:#10142E; font-size:9.5px; font-weight:800; padding:4px 9px; border-radius:999px;">NOW</span><span class="rm1" style="display:block; height:7px; width:70%;');
    t=t.replace('NEXT</span><span style="display:block; height:7px; width:48%;','NEXT</span><span class="rm2" style="display:block; height:7px; width:48%;');
    t=t.replace('LATER</span><span style="display:block; height:7px; width:30%;','LATER</span><span class="rm3" style="display:block; height:7px; width:30%;');
    // audit rings
    for(const [c,v] of [['#8C7AE6',72],['#FF2E3D',45],['#8C7AE6',88]]){
      t=t.replace(`<div style="width:58px; height:58px; border-radius:50%; background:conic-gradient(${c} ${v}%, #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span style="width:42px; height:42px; border-radius:50%; background:#10142E; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;">${v}</span></div>`,
        `<div class="rg rg${v}" style="--p:${v}; width:58px; height:58px; border-radius:50%; background:conic-gradient(${c} calc(var(--p) * 1%), #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span class="rgn" style="width:42px; height:42px; border-radius:50%; background:#10142E; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;"></span></div>`);
    }
    wr('HomeA2a',t);
  }
}

// ---------- reveal on scroll + slow drift on hero photos, every desktop page ----------
{
  const cheerio=require('cheerio');
  const files=fs.readdirSync(P).filter(f=>/\.dc\.html$/.test(f)&&!f.startsWith('M_')&&!/^(Megamenu|CookieBanner|DesignSystem)/.test(f));
  for(const f of files){
    let t=fs.readFileSync(P+f,'utf8');
    if(!t.includes('@keyframes revealUp')) t=t.replace('</style>',MOTION+'</style>');
    if(!t.includes('data-rv')){
      const $=cheerio.load(t,{},false);
      $('section').each((i,s)=>{ if($(s).closest('header,footer').length) return; if(/PREFOOTER|FOOTER/i.test($(s).prev().text())) return;
        $(s).children('div,h2,p,a').slice(0,6).each((j,el)=>{ if(/position:\s*absolute/.test($(el).attr('style')||'')) return; $(el).addClass('reveal'); });
        $(s).find('[style*="grid-template-columns"]').first().children().each((j,el)=>{ if(j<9 && !/position:\s*absolute/.test($(el).attr('style')||'')) $(el).addClass('reveal'); });
      });
      // hero photo drift (first section image that fills its box)
      $('section').first().find('img').each((i,im)=>{ if(/position:\s*absolute/.test($(im).attr('style')||'')&&/inset:\s*0/.test($(im).attr('style')||'')) $(im).addClass('drift'); });
      $('body').attr('data-rv','1');
      t=$.html();
    }
    fs.writeFileSync(P+f,t);
  }
}

// ---------- Contact: ONE form; the form itself works out what to ask ----------
{
  let t=rd('ContactS');
  const a=t.indexOf('      <form '), b=t.indexOf('      </form>\n')+'      </form>\n'.length;
  if(a>0 && !t.includes('routeNote')){
    const form=`      <form style="display:flex; flex-direction:column; gap:14px; max-width:540px;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;"><input type="text" placeholder="Your name" style="${inp}"><input type="email" placeholder="you@email.com" style="${inp}"></div>
        <input type="text" placeholder="Phone (optional)" style="${inp}">
        <div><div style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#5A5F86; margin-bottom:10px;">What do you need help with? <span style="text-transform:none; letter-spacing:0; font-weight:500;">Tick anything that fits.</span></div>
          <div style="display:flex; gap:8px; flex-wrap:wrap;"><sc-for list="{{opts}}" as="o" hint-placeholder-count="10"><button type="button" onClick="{{o.pick}}" style="{{o.style}}">{{o.label}}</button></sc-for></div></div>
        <sc-if value="{{noneSel}}" hint-placeholder-val="{{false}}"><p style="font-size:13.5px; color:#5A5F86; margin:0; padding:14px 16px; background:#F3F1FC; border-radius:12px;">Not sure yet? No problem. Just tell us what you have in mind below.</p></sc-if>
        <sc-if value="{{ev}}" hint-placeholder-val="{{true}}"><div style="display:flex; flex-direction:column; gap:12px; padding:18px; border:1.5px solid #D6DDF3; border-radius:16px; background:#F6F8FE;">
          <span style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#002671;">About your event</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;"><input type="text" placeholder="Event type (wedding, gala, party...)" style="${inp}"><input type="text" placeholder="Preferred date" style="${inp}"></div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;"><input type="text" placeholder="Approx. number of guests" style="${inp}"><input type="text" placeholder="City or venue" style="${inp}"></div>
        </div></sc-if>
        <sc-if value="{{co}}" hint-placeholder-val="{{false}}"><div style="display:flex; flex-direction:column; gap:12px; padding:18px; border:1.5px solid #E1DEF3; border-radius:16px; background:#F7F5FE;">
          <span style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#6C58DB;">About your business</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;"><input type="text" placeholder="Business name (if you have one)" style="${inp}"><input type="text" placeholder="Stage: idea / running / scaling" style="${inp}"></div>
        </div></sc-if>
        <textarea rows="4" placeholder="Tell us what you have in mind, and where you are stuck." style="${inp}"></textarea>
        <p class="routeNote" style="font-size:12.5px; color:#5A5F86; margin:0;">{{routeNote}}</p>
        <a href="ContactS.dc.html" style="display:block; text-align:center; background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:17px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); margin-top:6px;">Send Your Brief</a>
      </form>
`;
    t=t.slice(0,a)+form+t.slice(b);
    const script=`<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":2800}}'>
class Component extends DCLogic {
  constructor(props) { super(props); this.state = { sel: { 0: true } }; }
  renderVals() {
    const s = this.state.sel;
    const ALL = [['Event planning','e'],['Entertainment & talent','e'],['Design & production','e'],['Marketing & promotion','e'],['On-site coordination','e'],['Business setup & strategy','c'],['Branding & marketing','c'],['Business growth','c'],['Activation growth','c'],['Audit & advisory','c']];
    const base = 'border-radius:999px; padding:10px 16px; font-size:12.5px; font-weight:600; cursor:pointer; font-family:inherit; transition:all .2s ease; ';
    const ev = ALL.some((o, i) => o[1] === 'e' && s[i]), co = ALL.some((o, i) => o[1] === 'c' && s[i]);
    return {
      ev, co, noneSel: !ev && !co,
      opts: ALL.map((o, i) => ({ label: o[0], pick: () => { const cur = this.state.sel; this.setState({ sel: Object.assign({}, cur, { [i]: !cur[i] }) }); },
        style: base + (s[i] ? (o[1] === 'e' ? 'background:#002671; border:1.5px solid #002671; color:#FFFFFF;' : 'background:#8C7AE6; border:1.5px solid #8C7AE6; color:#10142E;') : 'background:#FFFFFF; border:1.5px solid #D2CEEA; color:#10142E;') })),
      routeNote: ev && co ? 'We will bring in both crews: events and consultancy will each pick this up.' : ev ? 'This goes straight to our events crew.' : co ? 'This goes straight to our consultancy team.' : 'We will read it and point you to the right person.',
    };
  }
}
</script>`;
    t=t.replace(/<script type="text\/x-dc"[\s\S]*?<\/script>/,script);
    wr('ContactS',t);
  }
}
console.log('round5 ok');
