// Mobile = the same desktop pages, re-oriented for 390px. Layout decisions are made per element (cheerio) and applied with
// data-m attributes, because the canvas runtime re-serialises inline styles (so attribute-substring CSS is unreliable).
const fs=require('fs');
const cheerio=require('cheerio');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const LOGO='/_blob/e4d72651b77d4c3cc1c086d9f6031149';
const PAGES=['HomeA','HomeA2a','ServicesA','ServicesA2a','AboutS','ContactS','FAQS','EventsA','SingleEventA','GalleryA','BlogA','SingleBlogA','Error404A','SponsorsA','EventsArchiveA','PrivacyS','CookiesS','TermsS','FounderS'];
const EV=C.EVS.map(s=>s[0]), CO=C.COS.map(s=>s[0]);

// ---- style helpers
const px=(s)=>{const m=/^(\d+(?:\.\d+)?)px$/.exec(s);return m?parseFloat(m[1]):null;};
function fixPadding(v){
  const t=v.trim().split(/\s+/); if(!t.every(x=>x==='0'||px(x)!==null)) return v;
  const n=t.map(x=>x==='0'?0:px(x)); let a,b,c,d;
  if(n.length===1)[a,b,c,d]=[n[0],n[0],n[0],n[0]]; else if(n.length===2)[a,b,c,d]=[n[0],n[1],n[0],n[1]]; else if(n.length===3)[a,b,c,d]=[n[0],n[1],n[2],n[1]]; else [a,b,c,d]=n;
  const H=(x)=>x>=40?20:x, V=(x)=>x>56?44:x;
  return [V(a),H(b),V(c),H(d)].map(x=>x+'px').join(' ');
}
function fixMargin(v){
  const t=v.trim().split(/\s+/); if(!t.every(x=>x==='0'||px(x)!==null)) return v;
  const n=t.map(x=>x==='0'?0:px(x)); let a,b,c,d;
  if(n.length===1)[a,b,c,d]=[n[0],n[0],n[0],n[0]]; else if(n.length===2)[a,b,c,d]=[n[0],n[1],n[0],n[1]]; else if(n.length===3)[a,b,c,d]=[n[0],n[1],n[2],n[1]]; else [a,b,c,d]=n;
  const H=(x)=>x>=40?20:x;
  return [a,H(b),c,H(d)].map(x=>x+'px').join(' ');
}
function fixStyle(st){
  st=st.replace(/(^|;)\s*margin:([^;]+)/g,(m,p,v)=>p+' margin:'+fixMargin(v));
  st=st.replace(/(^|;)\s*padding:([^;]+)/g,(m,p,v)=>p+' padding:'+fixPadding(v));
  st=st.replace(/font-size:(\d+(?:\.\d+)?)px/g,(m,n)=>{n=parseFloat(n);const r=n>=110?60:n>=90?52:n>=76?44:n>=60?40:n>=46?34:n>=40?32:n;return 'font-size:'+r+'px';});
  return st;
}
const prop=(s,p)=>{const m=new RegExp('(?:^|;)\\s*'+p+':\\s*([^;]+)').exec(s||'');return m?m[1].trim():'';};

const MCSS=`
  html, body { overflow-x:hidden; }
  img { max-width:100%; }
  [data-m~=root] { width:390px !important; max-width:390px !important; position:relative; }
  [data-m~=g1] { display:grid !important; grid-template-columns:minmax(0,1fr) !important; grid-template-rows:none !important; grid-auto-rows:auto !important; gap:18px !important; }
  [data-m~=g2] { display:grid !important; grid-template-columns:repeat(2,minmax(0,1fr)) !important; grid-template-rows:none !important; grid-auto-rows:auto !important; gap:12px !important; }
  [data-m~=span] { grid-column:auto !important; grid-row:auto !important; }
  [data-m~=tile] { min-height:260px; }
  [data-m~=g1] > *:not([data-m~=tile]):not([data-m~=herovis]):not([data-m~=collage]), [data-m~=g2] > *:not([data-m~=tile]):not([data-m~=herovis]):not([data-m~=collage]) { height:auto !important; min-height:0 !important; }
  [data-m~=imgfirst] { order:-1; }
  [data-m~=stack] { display:flex !important; flex-direction:column !important; align-items:flex-start !important; justify-content:flex-start !important; gap:16px !important; }
  [data-m~=stack] > * { text-align:left !important; max-width:100% !important; }
  [data-m~=ctas] { display:flex !important; flex-direction:column !important; align-items:stretch !important; gap:12px !important; }
  [data-m~=ctas] > * { text-align:center !important; }
  [data-m~=wrap] { flex-wrap:wrap !important; gap:10px !important; }
  [data-m~=full] { width:100% !important; max-width:100% !important; min-width:0 !important; flex:none !important; }
  [data-m~=nomin] { min-height:0 !important; }
  [data-m~=hide] { display:none !important; }
  [data-m~=static] { position:static !important; }
  [data-m~=scroller] { overflow-x:auto !important; padding-left:20px !important; scroll-snap-type:x mandatory; scrollbar-width:none; }
  [data-m~=track] { transform:none !important; padding-right:20px; gap:14px !important; }
  [data-m~=track] > * { flex:0 0 290px !important; height:430px !important; scroll-snap-align:start; }
  [data-m~=svcrow] { display:grid !important; grid-template-columns:auto minmax(0,1fr) auto !important; column-gap:14px !important; row-gap:14px !important; align-items:center !important; flex-wrap:nowrap !important; padding:16px 0 !important; }
  [data-m~=svcrow] > img { grid-column:1 / -1; grid-row:1; width:100% !important; height:150px !important; flex:none !important; border-radius:12px !important; }
  [data-m~=svcrow] > *:not(img) { grid-row:2; min-width:0; flex:none !important; }
  [data-m~=ovl] { background:linear-gradient(180deg, rgba(10,15,38,.5) 0%, rgba(10,15,38,.9) 55%, rgba(10,15,38,.96) 100%) !important; }
  [data-m~=collage] { width:167% !important; max-width:none !important; transform:scale(.6); transform-origin:0 0; margin-bottom:-256px !important; }
  [data-m~=herovis] { height:auto !important; display:block !important; position:relative; border-radius:24px; overflow:hidden; background:linear-gradient(160deg,#F3F1FC,#E6E0FA); padding:64px 14px 16px; }
  [data-m~=hv-img] { display:none !important; }
  [data-m~=hv-chat] { position:relative !important; left:auto !important; right:auto !important; bottom:auto !important; top:auto !important; width:100% !important; }
  [data-m~=hv-chat] .cb { font-size:13px !important; padding:10px 14px !important; }
  [data-m~=hv-badge] { position:absolute !important; top:12px !important; right:12px !important; left:auto !important; }
  [data-m~=imgtop] { flex-direction:column !important; align-items:stretch !important; gap:14px !important; }
  [data-m~=imgtop] > img { width:100% !important; height:220px !important; flex:none !important; }
  [data-m~=imgtop] > * { flex:none !important; max-width:100% !important; }
  [data-m~=hero] { min-height:520px !important; }
  h1 { line-height:.95 !important; }
  .mega-panel { display:none !important; }
  header { padding:10px 20px !important; }
  header > nav, header > div { display:none !important; }
  .mnav-btn { display:flex !important; }
  input.mnav { display:none; }
  .mdrawer { display:none; position:absolute; left:0; right:0; z-index:200; padding:8px 20px 28px; }
  input.mnav:checked ~ .mdrawer { display:block; animation:mslide .3s ease both; }
  @keyframes mslide { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:none; } }
  .mdrawer a.mlink { display:block; font-family:'Bebas Neue','Arial Narrow',sans-serif; font-size:34px; letter-spacing:.5px; text-transform:uppercase; padding:12px 0; }
  .mdrawer details summary { list-style:none; cursor:pointer; }
  .mdrawer details summary::-webkit-details-marker { display:none; }
  .mdrawer .msub { display:block; padding:9px 0 9px 14px; font-size:14.5px; }
  .msw { position:absolute; top:764px; left:0; right:0; height:80px; z-index:90; display:flex; justify-content:center; align-items:center; pointer-events:none; background:linear-gradient(180deg, rgba(10,15,38,0) 0%, rgba(10,15,38,.55) 100%); }
  .msw > div { pointer-events:auto; display:flex; padding:4px; gap:8px; }
`;

function build(name){
  let html=fs.readFileSync(P+name+'.dc.html','utf8');
  const ctx=(name==='HomeA2a'||name==='ServicesA2a')?'consult':(/S$/.test(name)?'shared':'events');
  const $=cheerio.load(html,{}, false);
  const add=(el,tok)=>{const c=$(el).attr('data-m')||'';if(!c.split(' ').includes(tok))$(el).attr('data-m',(c+' '+tok).trim());};

  // header colours
  const hdr=$('header').first();
  const hbg=(prop(hdr.attr('style'),'background')||'#0A0F26').split(' ')[0];
  const isDark=/^#/.test(hbg)&&parseInt(hbg.slice(1,3),16)<100;
  const fg=isDark?'#F4F5FA':'#10142E', line=isDark?'#1E2B5E':'#E1DEF3', acc=isDark?'#5B8DEF':'#6C58DB', soft=isDark?'#A3A9C8':'#5A5FA0';

  // 1 shrink inline styles
  $('[style]').each((i,el)=>{const s=$(el).attr('style'); if(s.includes('{{')) return; $(el).attr('style',fixStyle(s));});

  // 2 root
  const root=$('div').filter((i,el)=>/width:\s*1440px/.test($(el).attr('style')||'')).first(); add(root,'root');

  // 3 classify layout elements
  $('[style]').each((i,el)=>{
    const $el=$(el), s=$el.attr('style')||''; if(s.includes('{{')&&!/display/.test(s)) return;
    const tag=el.name; const inHeader=$el.closest('header').length>0; const inDrawer=$el.closest('.mdrawer').length>0;
    const kids=$el.children().toArray();
    const disp=prop(s,'display');
    // decorative badge
    if(/border:\s*2px dashed/.test(s)&&/position:\s*absolute/.test(s)) { add(el,'hide'); return; }
    // composite visual: relative box of absolutely-positioned layers
    if(/position:s*relative/.test(s)&&(px(prop(s,'height'))||0)>=480&&kids.length>=3&&kids.every(k=>/position:s*absolute/.test($(k).attr('style')||''))&&(kids.some(k=>(px(prop($(k).attr('style'),'width'))||0)>=300)||kids.filter(k=>/rotate/.test($(k).attr('style')||'')).length>=2)&&!$el.closest('header').length){
      const chatMode=kids.some(k=>$(k).text().trim().length>60);
      if(!chatMode){ add(el,'collage'); return; }
      add(el,'herovis');
      let seenImg=false; kids.forEach(k=>{const txt=$(k).text().trim().length; if(k.name==='img'||$(k).find('img').length){ if(seenImg) add(k,'hide'); else { add(k,'hv-img'); seenImg=true; } } else add(k,txt>60?'hv-chat':'hv-badge');});
      return;
    }
    // grids
    if(/grid/.test(disp)&&!inHeader){
      const tpl=prop(s,'grid-template-columns');
      let cols=1; const rep=/repeat\((\d+)/.exec(tpl); if(rep) cols=+rep[1]; else cols=tpl.replace(/\([^)]*\)/g,'x').split(/\s+/).filter(Boolean).length;
      if(cols>=2){
        const avg=kids.length?kids.reduce((a,k)=>a+$(k).text().trim().length,0)/kids.length:0;
        const hasImg=kids.some(k=>$(k).find('img').length);
        const small=avg<70&&!hasImg;
        const photoCards=kids.length>=3&&kids.every(k=>$(k).find('img').length&&$(k).text().trim().length<40);
        add(el, ((cols>=4&&(avg<60||(hasImg&&avg<40)))||(cols===2&&small&&kids.length>=4)||photoCards)?'g2':'g1');
        kids.forEach(k=>{const ks=$(k).attr('style')||''; if(/grid-(row|column)/.test(ks)) add(k,'span'); if($(k).find('img').filter((i,im)=>/position:\s*absolute/.test($(im).attr('style')||'')).length) add(k,'tile');});
      }
      return;
    }
    // flex rows
    if(/flex/.test(disp)&&!/column/.test(prop(s,'flex-direction'))&&!/animation/.test(s)&&!inHeader&&!inDrawer&&tag!=='nav'&&tag!=='button'&&!$el.hasClass('msw')){
      if(kids.length<2) return;
      const btnLike=(k)=>(k.name==='a'||k.name==='button')&&!((px(prop($(k).attr('style'),'width'))||999)<=64)&&!$(k).attr('aria-label')&&/background|border/.test($(k).attr('style')||'')&&$(k).text().trim().length<40;
      const txt=(k)=>$(k).text().trim().length;
      const sb=/space-between/.test(prop(s,'justify-content'));
      const headingKid=kids.some(k=>/^h[12]$/.test(k.name)||$(k).find('h1,h2').length);
      const longP=kids.some(k=>k.name==='p'&&txt(k)>50||($(k).children('p').length&&txt(k)>90));
      const iconRow=kids.length===2&&kids.some(k=>$(k).find('img').length||txt(k)<=3);
      const first=kids[0]; if(first&&first.name==='img'&&(px(prop($(first).attr('style'),'width'))||0)>=80&&(px(prop($(first).attr('style'),'width'))||0)<=200&&kids.length>=2&&!/^[0-9][0-9]$/.test($(kids[0]).text().trim())&&!kids.some(k=>k.name==='img'&&k!==first)){ add(el,'imgtop'); return; }
      const smallImg=kids.find(k=>k.name==='img'&&(px(prop($(k).attr('style'),'width'))||999)<=110);
      if(smallImg&&kids.length>=3&&/^[0-9][0-9]$/.test($(kids[0]).text().trim())){ add(el,'svcrow'); return; }
      if(kids.every(btnLike)){ add(el,'ctas'); return; }
      if(headingKid&&!iconRow){ add(el,'stack'); return; }
      if(sb&&longP){ add(el,'stack'); return; }
      const fixedW=kids.some(k=>{const ks=$(k).attr('style')||''; const w=px(prop(ks,'width'))||0; const fb=/flex:\s*0 0 (\d+)px/.exec(ks); return w>=200||(fb&&+fb[1]>=200);});
      if(fixedW&&!$el.attr('data-m')){ add(el,'wrap'); }
      else if(kids.length>=3&&kids.every(k=>txt(k)<45&&!$(k).find('img').length)) add(el,'wrap');
      else if(kids.length>=3&&!iconRow) add(el,'wrap');
    }
  });

  // 4 fixed widths / sections
  $('[style]').each((i,el)=>{
    const $el=$(el), s=$el.attr('style')||''; if(s.includes('{{')) return;
    const w=px(prop(s,'width')), fb=/flex:\s*0 0 (\d+)px/.exec(s), mw=px(prop(s,'min-width'));
    if(((w&&w>=340&&!/%/.test(prop(s,'width')))||(mw&&mw>=340))&&el.name!=='img'&&!$el.attr('data-m')?.includes('root')&&!$el.closest('[data-m~=scroller]').length&&!$el.hasClass('msw')) add(el,'full');
    if(/position:\s*sticky/.test(s)&&el.name!=='header') add(el,'static');
    if(el.name==='section'){
      const mh=px(prop(s,'min-height'))||0;
      const heroLike=$el.children('img').length&&/position:\s*absolute/.test($el.children('img').first().attr('style')||'');
      if(mh>=300) add(el,heroLike?'hero':'nomin');
    }
  });
  // hero with clip-path & fixed height
  $('section[style]').each((i,el)=>{const s=$(el).attr('style'); if(/clip-path/.test(s)&&/height:\s*660px/.test(s)) $(el).attr('style',s.replace(/height:\s*660px/,'height:700px'));});

  // 5 header: hamburger + drawer + sticky switcher
  const btn=`<label for="mnav" class="mnav-btn" style="display:none; flex-direction:column; gap:5px; padding:10px; cursor:pointer;"><i style="display:block; width:24px; height:2px; background:${fg};"></i><i style="display:block; width:24px; height:2px; background:${fg};"></i><i style="display:block; width:16px; height:2px; align-self:flex-end; background:${fg};"></i></label>`;
  const svc=(arr,href,col)=>arr.map(s=>`<a class="msub" href="${href}" style="color:${fg}; border-left:2px solid ${col}; margin-left:6px;">${s}</a>`).join('');
  const home=ctx==='consult'?'HomeA2a.dc.html':'HomeA.dc.html';
  const cta=ctx==='consult'||ctx==='shared'?['Book A Discovery Call','#8C7AE6','#10142E']:['Book The Room','#BA0000','#FFFFFF'];
  const seg=(on)=>on==='e'?'background:#1E48B0; color:#fff;':on==='c'?'background:#8C7AE6; color:#10142E;':`color:${soft};`;
  const drawer=`<div class="mdrawer" style="background:${hbg}; border-bottom:1px solid ${line}; box-shadow:0 24px 40px rgba(0,0,0,.35);">
    <div style="display:flex; padding:4px; gap:2px; border-radius:999px; border:1.5px solid ${line}; margin:8px 0 10px;"><a href="HomeA.dc.html" style="flex:1; text-align:center; padding:11px 0; border-radius:999px; font-size:13px; font-weight:700; ${seg(ctx==='events'?'e':'')}">Events</a><a href="HomeA2a.dc.html" style="flex:1; text-align:center; padding:11px 0; border-radius:999px; font-size:13px; font-weight:700; ${seg(ctx==='consult'?'c':'')}">Consultancy</a></div>
    <a class="mlink" href="${home}" style="color:${fg}; border-bottom:1px solid ${line};">Home</a>
    <details style="border-bottom:1px solid ${line};"><summary><span class="mlink" style="display:flex; justify-content:space-between; color:${fg};">Services <span style="color:${acc};">+</span></span></summary>
      <div style="padding-bottom:14px;"><div style="font-size:11px; letter-spacing:2px; font-weight:700; color:${acc}; margin:4px 0 2px;">EVENTS</div>${svc(EV,'ServicesA.dc.html','#5B8DEF')}<div style="font-size:11px; letter-spacing:2px; font-weight:700; color:#8C7AE6; margin:14px 0 2px;">CONSULTANCY</div>${svc(CO,'ServicesA2a.dc.html','#8C7AE6')}</div></details>
    ${[['Events','EventsA'],['Gallery','GalleryA'],['About','AboutS'],['Blog','BlogA'],['Contact','ContactS']].map(([n,f])=>`<a class="mlink" href="${f}.dc.html" style="color:${fg}; border-bottom:1px solid ${line};">${n}</a>`).join('')}
    <a href="ContactS.dc.html" style="display:block; text-align:center; margin-top:20px; background:${cta[1]}; color:${cta[2]}; font-weight:700; font-size:14.5px; padding:16px 20px; border-radius:10px;">${cta[0]}</a>
  </div>`;
  if(hdr.length){ hdr.append(btn); hdr.before('<input type="checkbox" id="mnav" class="mnav">'); hdr.after(drawer); }
  const sw=`<div class="msw"><div style="background:rgba(10,15,38,.94); border:1px solid #1E2B5E;"><a href="HomeA.dc.html" style="padding:12px 22px; border-radius:999px; font-size:13px; font-weight:700; ${ctx==='consult'?'color:#A3A9C8;':'background:#1E48B0; color:#fff;'}">Events</a><a href="HomeA2a.dc.html" style="padding:12px 22px; border-radius:999px; font-size:13px; font-weight:700; ${ctx==='consult'?'background:#8C7AE6; color:#10142E;':'color:#A3A9C8;'}">Consultancy</a></div></div>`;
  root.append(sw);

  // 6 JS-driven parts on the Consultancy home: carousel -> native swipe, panels -> vertical accordion
  if(name==='HomeA2a'){
    const track=$('div').filter((i,el)=>($(el).attr('style')||'').includes('{{trackStyle}}')).first();
    add(track,'track'); add(track.parent(),'scroller');
    $('button').filter((i,el)=>/\{\{(prev|next)\}\}/.test($(el).attr('onclick')||'')).each((i,el)=>add($(el).parent(),'hide'));
    const pcont=$('sc-for[list="{{panels}}"]').first().parent();
    pcont.attr('style','display:flex; flex-direction:column; gap:12px; height:auto;');
  }
  html=$.html();
  if(name==='HomeA2a'){
    html=html.replace("transition:flex .5s ease; flex:' + (on ? '5' : '1') + ' 1 0; min-width:0;'","transition:height .45s ease; height:' + (on ? '420px' : '88px') + '; flex:none; min-width:0;'");
    html=html.replace(/labelStyle: '[^\n]*',\n/,"labelStyle: 'position:absolute; left:64px; top:26px; font-size:26px; color:#F2F1F8; white-space:nowrap; transition:opacity .3s ease; opacity:' + (on ? '0' : '1') + ';',\n");
    html=html.replace("bodyStyle: 'position:absolute; left:0; right:0; bottom:0; padding:36px;","bodyStyle: 'position:absolute; left:0; right:0; bottom:0; padding:22px;");
    html=html.replace("(on ? '34px' : '24px')","(on ? '30px' : '26px')");
  }
  // 7 CSS, preview, title
  html=html.replace('</style>',MCSS+'</style>');
  html=require('./buttons').normalize(html);
  html=html.replace(/"\$preview":\{"width":1440,"height":\d+\}/,'"$preview":{"width":390,"height":4000}');
  html=html.replace(/<title>([^<]*)<\/title>/,(m,t)=>'<title>'+t+' — Mobile</title>');
  return html;
}
const SPLIT=JSON.parse(fs.existsSync(C.SP+'msplit.json')?fs.readFileSync(C.SP+'msplit.json','utf8'):'{}');
for(const n of PAGES){
  const html=build(n); fs.writeFileSync(P+'M_'+n+'.dc.html',html);
  const sp=SPLIT[n];
  if(sp){ // sp = {cut, total}
    const i=html.lastIndexOf('</div>', html.indexOf('</x-dc>'))+6;
    let h2=html.slice(0,i)+'</div></div>'+html.slice(i);
    h2=h2.replace(/<div [^>]*data-m="root"[^>]*>/,(m)=>'<div style="height:'+(sp.total-sp.cut+20)+'px; overflow:hidden; width:390px;"><div style="margin-top:-'+sp.cut+'px; width:390px;">'+m);
    fs.writeFileSync(P+'M_'+n+'_2.dc.html',h2);
  } else { try{fs.unlinkSync(P+'M_'+n+'_2.dc.html')}catch(e){} }
}
console.log('mobile3 ok',PAGES.length);
