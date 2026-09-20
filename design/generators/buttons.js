// One button shape everywhere: the slanted parallelogram. Primary = filled, secondary = slanted outline (ring drawn by ::before),
// chips / tabs / tags / icon buttons use the same shape. Idempotent. Also exported for the mobile build.
const fs=require('fs');
const cheerio=require('cheerio');
const C=require('./common.js'); const P=C.SP+'pub/project/';

const BTN_CSS=`  /* ---- one button shape ---- */
  .bx { position:relative; clip-path:polygon(var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%); border:0 !important; border-radius:0 !important; --bw:1.5px; text-align:center; }
  .bx::before { content:''; position:absolute; inset:0; background:var(--bc,transparent); pointer-events:none; clip-path:polygon(evenodd, var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%, var(--sl,10px) 0, calc(var(--sl,10px) + var(--bw)) var(--bw), calc(100% - var(--bw)) var(--bw), calc(100% - var(--sl,10px) - var(--bw)) calc(100% - var(--bw)), var(--bw) calc(100% - var(--bw)), calc(var(--sl,10px) + var(--bw)) var(--bw), var(--sl,10px) 0); }
  .bx:hover { filter:brightness(1.1); transform:translateY(-2px); }
  .bx:active { transform:none; filter:brightness(.95); }
  .bx { transition:transform .2s ease, filter .2s ease; }
`;

const parse=(s)=>s.split(';').map(x=>x.trim()).filter(Boolean).map(x=>{const i=x.indexOf(':');return [x.slice(0,i).trim(),x.slice(i+1).trim()];});
const ser=(d)=>d.map(([k,v])=>k+':'+v).join('; ')+';';
const get=(d,k)=>{const e=d.find(x=>x[0]===k);return e?e[1]:''};
const del=(d,ks)=>d.filter(x=>!ks.includes(x[0]));
const px=(s)=>{const m=/(\d+(?:\.\d+)?)px/.exec(s||'');return m?parseFloat(m[1]):0};

function normalize(html){
  const $=cheerio.load(html,{},false);
  const conv=(el,{bc,sl})=>{
    let d=parse($(el).attr('style')||'');
    d=del(d,['clip-path','border','border-radius','border-top','border-bottom','border-left','border-right']);
    d.push(['--sl',sl+'px']); if(bc) d.push(['--bc',bc]);
    $(el).attr('style',ser(d)); $(el).addClass('bx');
  };
  const inlineOnly=(el)=>$(el).children().toArray().every(k=>['span','svg','i','b','strong','path','em'].includes(k.name));
  const txtLen=(el)=>$(el).text().trim().length;

  $('a, button, span, div').each((i,el)=>{
    const st=$(el).attr('style')||''; if(!st||$(el).hasClass('bx')) return;
    if(/\{\{/.test(st)) return;                          // JS-styled ones are handled in the script patch below
    if($(el).closest('.mdrawer, header nav').length && el.name==='a' && !/border|clip-path/.test(st)) return;
    const d=parse(st); const tag=el.name;
    const cp=get(d,'clip-path'), bd=get(d,'border'), br=get(d,'border-radius'), bg=get(d,'background')||get(d,'background-color');
    const abs=/absolute/.test(get(d,'position'));
    const py=px(get(d,'padding').split(' ')[0]);
    if(abs) return;
    const isBtnTag=(tag==='a'||tag==='button');
    // 1 primary buttons (already slanted)
    if(isBtnTag && /polygon\(/.test(cp) && txtLen(el)<60){ conv(el,{sl:py>=14?10:8}); return; }
    // 2 secondary outline buttons (border, short label, no block children)
    if(isBtnTag && /solid/.test(bd) && !bg.match(/gradient/) && txtLen(el)>0 && txtLen(el)<40 && inlineOnly(el) && py>=6){
      const col=(/(#[0-9A-Fa-f]{3,8}|rgba?\([^)]*\))/.exec(bd)||[])[1];
      conv(el,{bc:col,sl:py>=14?10:8}); return; }
    // 2b filled rounded buttons (radius <= 14px)
    if(isBtnTag && bg && !/gradient/.test(bg) && px(br)>0 && px(br)<=14 && txtLen(el)>0 && txtLen(el)<30 && inlineOnly(el) && py>=8){ conv(el,{sl:py>=14?10:8}); return; }
    // 3 filled pills / icon buttons that are links or buttons
    if(isBtnTag && /(999px|50%)/.test(br) && (bg||/solid/.test(bd)) && (txtLen(el)<40) && inlineOnly(el)){
      const col=/solid/.test(bd)?(/(#[0-9A-Fa-f]{3,8}|rgba?\([^)]*\))/.exec(bd)||[])[1]:'';
      conv(el,{bc:col,sl:(px(get(d,'width'))&&px(get(d,'width'))<=64)?7:(py>=14?9:7)}); return; }
    // 4 tags / chips (non-interactive spans and divs)
    if((tag==='span'||tag==='div') && /999px/.test(br) && (bg||/solid/.test(bd)) && txtLen(el)>0 && txtLen(el)<45 && inlineOnly(el) && !$(el).children('a,button').length){
      const col=/solid/.test(bd)?(/(#[0-9A-Fa-f]{3,8}|rgba?\([^)]*\))/.exec(bd)||[])[1]:'';
      conv(el,{bc:col,sl:6}); return; }
  });

  // segmented controls (pill container holding 2+ buttons): drop the container's pill/border, space the buttons
  $('div').each((i,el)=>{
    const d=parse($(el).attr('style')||''); const br=get(d,'border-radius'); if(!/999px/.test(br)) return;
    const kids=$(el).children('a,button').toArray(); if(kids.length<2||kids.length!==$(el).children().length) return;
    let n=del(d,['border','border-radius','padding','background','background-color']); n.push(['gap','6px']);
    $(el).attr('style',ser(n));
    kids.forEach(k=>{ if(!$(k).hasClass('bx')){ // unconverted (inactive) tabs get the ring too
      const kd=parse($(k).attr('style')||''); const bg=get(kd,'background')||get(kd,'background-color'); const col=(/(#[0-9A-Fa-f]{6})/.exec(get(kd,'color'))||[])[1];
      let n2=del(kd,['clip-path','border','border-radius']); n2.push(['--sl','8px']); if(!bg||bg==='transparent') n2.push(['--bc',col?col+'55':'#88888855']);
      $(k).attr('style',ser(n2)).addClass('bx'); } });
  });

  // JS-styled buttons: give them the class, and patch the style strings in the component script
  $('button, a').each((i,el)=>{ if(/\{\{[^}]*(style|Style|Chip)[^}]*\}\}/.test($(el).attr('style')||'')) $(el).addClass('bx'); });
  let out=$.html();
  out=out.replace(/<script type="text\/x-dc"[\s\S]*?<\/script>/,(s)=>{
    if(!/pickEvents|const base = 'border-radius:999px|const btn = 'width:48px/.test(s)) return s;
    s=s.replace(/border:none; border-radius:999px; padding:12px 26px;/,"border:none; --sl:8px; padding:12px 26px;");
    s=s.replace(/off = 'background:transparent; color:#10142E;'/,"off = 'background:transparent; color:#10142E; --bc:#10142E55;'");
    s=s.replace("const base = 'border-radius:999px; padding:10px 16px;","const base = '--sl:8px; padding:10px 16px;");
    s=s.replace(/border:1\.5px solid (#[0-9A-Fa-f]{6});/g,'--bc:$1;');
    s=s.replace("const btn = 'width:48px; height:48px; border-radius:50%;","const btn = 'width:48px; height:48px; --sl:9px;");
    s=s.replace(/border:1\.5px solid ' \+ OFF \+ ';/g,"--bc:' + OFF + ';").replace(/border:1\.5px solid ' \+ TXT \+ ';/g,"--bc:' + TXT + ';").replace(/border:1\.5px solid #8C7AE6;/g,'--bc:#8C7AE6;');
    return s;
  });
  if(!out.includes('.bx {')) out=out.replace('</style>',BTN_CSS+'</style>');
  return out;
}
module.exports={normalize,BTN_CSS};

if(require.main===module){
  const files=fs.readdirSync(P).filter(f=>/\.dc\.html$/.test(f)&&!f.startsWith('M_'));
  for(const f of files){ const t=fs.readFileSync(P+f,'utf8'); fs.writeFileSync(P+f,normalize(t)); }
  const mc=P+'M_CookieBanner.dc.html'; if(fs.existsSync(mc)) fs.writeFileSync(mc,normalize(fs.readFileSync(mc,'utf8')));
  console.log('buttons ok',files.length);
}
