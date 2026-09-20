const fs=require('fs');
const C=require('./common.js'); const SP=C.SP; const P=SP+'pub/project/';

// A1 (Events) design system, derived from the logo: blue #002671, red #BA0000; purple is the Consultancy accent.
const NEUT={'#10142E':'#0A0F26','#1B2048':'#111838','#2A2F5C':'#1E2B5E','#3A3F72':'#2C3C78','#F2F1F8':'#F4F5FA','#9A9AC0':'#A3A9C8','#C7C7DA':'#C5CADF','#D6D6E8':'#D5D9EA','#6E6E9A':'#7A82A8','#D6D0F5':'#C5CFF5','#8A8AB4':'#8E96BB','#B9AFF0':'#A9C0F5','#5A5FA0':'#3D4F94','#B8BEDA':'#B4BCDD'};
function themeA1(t){
  t=t.split('background:#8C7AE6').join('@@PB@@');               // purple fills = Consultancy
  const bar=(s)=>s.split('#FF2E3D').join('#002671').split('#10142E').join('#FFFFFF');
  t=t.replace(/(  <!-- SHOUT-OUT BAR -->[\s\S]*?)(  <!-- HEADER)/,(m,a,b)=>bar(a)+b);     // call-out bar = logo blue
  t=t.replace(/(  <!-- MARQUEE -->[\s\S]*?)(  <!-- SERVICES)/,(m,a,b)=>bar(a)+b);          // marquee = logo blue
  t=t.split('background:#FF2E3D; color:#10142E;').join('background:#BA0000; color:#FFFFFF;'); // primary buttons
  let n=0; const T3=[['background:#002671','#FFFFFF'],['background:#BA0000','#FFFFFF'],['@@PB@@','#10142E']]; // ticket stubs: blue, red, purple
  t=t.replace(/<div class="(ticket|strip)-stub" style="([^"]*)">([\s\S]*?)<\/div>/g,(m,cls,st,inner)=>{
    if(!/background:#FF2E3D/.test(st)) return m;
    const [bg,tx]=T3[n++%3];
    return `<div class="${cls}-stub" style="${st.replace('background:#FF2E3D',bg)}">${inner.split('color:#10142E').join('color:'+tx)}</div>`;
  });
  t=t.split('background:#FF2E3D').join('background:#BA0000');
  t=t.split('border:2px solid #FF2E3D').join('border:2px solid #5B8DEF');
  t=t.split('#FF2E3D').join('#E5383B');
  t=t.split('#8C7AE6').join('#5B8DEF');                                                  // accent text = logo-blue tint
  t=t.split('@@PB@@').join('background:#8C7AE6');
  t=t.split('rgba(140,122,230,').join('rgba(91,141,239,').split('rgba(255,46,61,').join('rgba(186,0,0,');
  for(const [k,v] of Object.entries(NEUT)) t=t.split(k).join(v);
  t=t.split('rgba(16,20,46,').join('rgba(10,15,38,').split('rgba(242,241,248,').join('rgba(244,245,250,');
  t=t.replace(/(<!-- [^\n]*-->\n\s*)<section ((?:id="[^"]*" )?)style="([^"]*)"/g,(m,c,id,st)=>{
    if(!/(SERVICES|SERVICE ROWS|EVENTS|GALLERY|WHY CRUX|PROCESS|MINI ABOUT|FAQ —|ALSO FROM|OUR STORY|HOW WE WORK|UPCOMING|PAST|DETAILS|WALL|TICKET GRID)/.test(c)) return m;
    if(/min-height/.test(st)) return m;
    const flex=/display:/.test(st)?'':'display:flex; flex-direction:column; justify-content:center; ';
    return `${c}<section ${id}style="min-height:560px; ${flex}${st}"`;
  });
  t=t.replace('height:700px; overflow:hidden; clip-path','height:660px; overflow:hidden; clip-path');
  return t;
}
module.exports={themeA1,NEUT};
if(require.main===module){
  const FILES={HomeA:'Home',ServicesA:'Services',EventsA:'Events',SingleEventA:'Events',GalleryA:'Gallery',BlogA:'Blog',SingleBlogA:'Blog'};
  for(const [f,active] of Object.entries(FILES)){
    let t=fs.readFileSync(P+f+'.dc.html','utf8');
    t=t.replace(/  <!-- HEADER -->[\s\S]*?<\/header>\n\n?/,C.megaHeader({ctx:'events',active,c:C.C_A1}));
    t=t.replace(/  <!-- PREFOOTER CTA[\s\S]*?(?=  <!-- COLOSSAL FOOTER)/,C.PRECTA);
    t=t.replace('</style>',C.MEGA_CSS+'</style>');
    t=themeA1(t);
    t=C.link(t,'events');
    fs.writeFileSync(P+f+'.dc.html',t);
  }
  console.log('themed');
}
