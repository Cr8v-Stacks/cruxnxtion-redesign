// Idempotent post-processing on the generated desktop pages: real logo, legal links, home gallery = gallery page design.
const fs=require('fs');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const LOGO='/_blob/e4d72651b77d4c3cc1c086d9f6031149';
const files=fs.readdirSync(P).filter(f=>/\.dc\.html$/.test(f)&&!f.startsWith('M_'));
const galleryHtml=fs.readFileSync(P+'GalleryA.dc.html','utf8');
const frames=(galleryHtml.match(/      <a href="#" style="display:flex; flex-direction:column;[\s\S]*?<\/a>\n/g)||[]).slice(0,3);
const HOMEGAL=`  <!-- GALLERY — ticket wall (matches the Gallery page) -->
  <section id="gallery" style="padding:30px 64px 60px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;">
      <div><span class="eyebrow">The Ticket Wall</span><h2 class="bebas" style="font-size:64px; margin:12px 0 0; color:#F4F5FA;">GALLERY</h2><p style="font-size:15px; color:#A3A9C8; max-width:520px; margin:12px 0 0;">Every frame, filed like a ticket — punched by the same crew.</p></div>
      <a href="GalleryA.dc.html" style="font-weight:700; font-size:13px; color:#5B8DEF; border-bottom:1.5px solid #5B8DEF; padding-bottom:2px; white-space:nowrap;">View Full Gallery &rarr;</a>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:34px 26px; align-items:start;">
${frames.join('')}    </div>
  </section>

`;
for(const f of files){
  let t=fs.readFileSync(P+f,'utf8'); const o=t;
  // real logo in the header
  t=t.replace(/<a href="([^"]*)" class="bebas" style="font-size:26px; color:#[0-9A-Fa-f]+;">CRUX <span style="[^"]*">NXTION<\/span><\/a>/,
    (m,h)=>`<a href="${h}" style="display:flex; align-items:center;"><img src="${LOGO}" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px; border-radius:8px;"></a>`);
  // legal + extra links in the footer (dark on every page)
  if(!t.includes('PrivacyS.dc.html')&&t.includes('<!-- COLOSSAL FOOTER')){
    t=t.replace(/(<a href="FAQS\.dc\.html" style="[^"]*">FAQ<\/a>)/,(m,a)=>a+'\n      '+a.replace('FAQS.dc.html','BlogA.dc.html').replace('>FAQ<','>Blog<')+'\n      '+a.replace('FAQS.dc.html','SponsorsA.dc.html').replace('>FAQ<','>Sponsors<'));
    const legal=`    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:8px 26px; margin-bottom:20px;">
      <a href="PrivacyS.dc.html" style="font-size:12.5px; color:#8E96BB;">Privacy Policy</a>
      <a href="CookiesS.dc.html" style="font-size:12.5px; color:#8E96BB;">Cookie Policy</a>
      <a href="TermsS.dc.html" style="font-size:12.5px; color:#8E96BB;">Terms &amp; Conditions</a>
    </div>
`;
    t=t.replace(/(    <div style="width:100%; max-width:900px; height:1px)/,legal+'$1');
  }
  // home gallery = gallery page
  if(f==='HomeA.dc.html'&&frames.length){
    t=t.replace(/  <!-- GALLERY — [^\n]*-->[\s\S]*?(?=  <!-- WHY CRUX)/,HOMEGAL);
  }
  if(t!==o) fs.writeFileSync(P+f,t);
}
console.log('post ok, frames',frames.length);
