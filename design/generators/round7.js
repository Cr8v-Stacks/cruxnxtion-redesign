const fs=require('fs');const C=require('./common.js');const f=C.SP+'pub/project/DesignSystem.dc.html';
let t=fs.readFileSync(f,'utf8');
// old flat demo spans -> real slanted buttons
t=t.replace(/<span style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon\(10px 0,100% 0,calc\(100% - 10px\) 100%,0 100%\);">Primary<\/span>/g,'<a class="bx" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; --sl:10px;">Primary</a>');
t=t.replace(/<span style="border:1\.5px solid #10142E; color:#10142E; font-weight:700; font-size:15px; padding:14\.5px 28px;">Secondary<\/span>/g,'<a class="bx" style="color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; --sl:10px; --bc:#10142E;">Secondary</a>');
if(!t.includes('BUTTONS — ONE SHAPE')){
  const btn=(txt,st,cls='')=>`<a class="bx" style="font-weight:700; ${st}">${txt}</a>`;
  const rowD=`<div style="background:#0A0F26; border-radius:16px; padding:28px; display:flex; flex-wrap:wrap; gap:14px; align-items:center;">
    ${btn('Primary — Events','background:#BA0000; color:#FFFFFF; font-size:15px; padding:16px 30px; --sl:10px;')}
    ${btn('Secondary','color:#F4F5FA; font-size:15px; padding:16px 30px; --sl:10px; --bc:#5B8DEF;')}
    ${btn('Active tab','background:#1E48B0; color:#FFFFFF; font-size:12.5px; padding:10px 18px; --sl:8px;')}
    ${btn('Inactive tab','color:#A3A9C8; font-size:12.5px; padding:10px 18px; --sl:8px; --bc:#2C3C78;')}
    ${btn('Chip','color:#D5D9EA; font-size:12px; padding:8px 16px; --sl:6px; --bc:#2C3C78;')}
    <span style="font-weight:700; font-size:13px; color:#5B8DEF; border-bottom:1.5px solid #5B8DEF; padding-bottom:2px;">Text link &rarr;</span></div>`;
  const rowL=`<div style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:28px; display:flex; flex-wrap:wrap; gap:14px; align-items:center;">
    ${btn('Primary — Consultancy','background:#8C7AE6; color:#10142E; font-size:15px; padding:16px 30px; --sl:10px;')}
    ${btn('Secondary','color:#10142E; font-size:15px; padding:16px 30px; --sl:10px; --bc:#10142E;')}
    ${btn('Active tab','background:#002671; color:#FFFFFF; font-size:12.5px; padding:10px 18px; --sl:8px;')}
    ${btn('Inactive tab','color:#10142E; font-size:12.5px; padding:10px 18px; --sl:8px; --bc:#D2CEEA;')}
    ${btn('Chip','color:#3A3F66; font-size:12px; padding:8px 16px; --sl:6px; --bc:#D2CEEA;')}
    <span style="font-weight:700; font-size:13px; color:#6C58DB; border-bottom:1.5px solid #6C58DB; padding-bottom:2px;">Text link &rarr;</span></div>`;
  const sec=`  <section style="padding:0 64px 60px;">
    <h2 class="bebas" style="font-size:52px; margin:0 0 8px;">BUTTONS — ONE SHAPE</h2>
    <p style="font-size:15px; line-height:1.7; color:#3A3F66; max-width:820px; margin:0 0 22px;">Every button, tab, chip and tag uses the same slanted shape. Primary is filled; secondary is the same shape drawn as an outline; chips and tags step down in size. Slant: 10px large, 8px medium, 6px small. Red is the action colour on Events pages, purple on Consultancy pages. Only text links stay unshaped.</p>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">${rowD}${rowL}</div>
  </section>

`;
  const marker='  <section style="padding:0 64px 60px; display:grid; grid-template-columns:1fr 1fr; gap:60px;">';
  const i=t.indexOf(marker); t=t.slice(0,i)+sec+t.slice(i);
}
fs.writeFileSync(f,t); console.log('round7 ok');
