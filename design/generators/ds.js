const fs=require('fs');
const SP='C:/Users/user/AppData/Local/Temp/claude/C--Users-user-OneDrive-Documents-Dev-Playground-Cr8v-Stacks-Events-Website-main/97df7f88-296d-4e3c-80ef-abf4a42b7050/scratchpad/';
const sw=(hex,name,use,dark)=>`<div style="display:flex; align-items:center; gap:14px; padding:12px 0; border-bottom:1px solid #E1DEF3;"><span style="flex:0 0 56px; height:56px; border-radius:12px; background:${hex}; border:1px solid rgba(0,0,0,0.12);"></span><div><div style="font-size:14px; font-weight:700; color:#10142E;">${name} <span style="font-weight:500; color:#5A5F86;">${hex}</span></div><div style="font-size:12.5px; color:#5A5F86; margin-top:2px;">${use}</div></div></div>`;
const rule=(t,d)=>`<div style="padding:14px 0; border-bottom:1px solid #E1DEF3;"><div style="font-size:13px; font-weight:700; color:#10142E; letter-spacing:1px; text-transform:uppercase;">${t}</div><div style="font-size:13.5px; color:#3A3F66; margin-top:4px; line-height:1.55;">${d}</div></div>`;
const A1=[['#0A0F26','Ink','Page background'],['#111838','Surface','Cards, panels, alternate bands'],['#1E2B5E','Line','Borders, dividers'],['#F4F5FA','Text','Titles and headings'],['#A3A9C8','Muted','Descriptions, captions'],['#5B8DEF','Accent tint','Eyebrows, numbers, links, chip outlines'],['#002671','Logo blue','Call-out bar, marquee, ticket stub tone 1'],['#BA0000','Logo red','Primary buttons, badge, ticket stub tone 2'],['#8C7AE6','Purple','Consultancy accent — ticket stub tone 3, consultancy links, the “Also from Crux” band'],['#1E48B0','Mid blue','Spare blue for depth (never a stub)'],['#E5383B','Red text','Rare highlights only (one word in a headline)']];
const A2=[['#FFFFFF','White','Page background (most sections)'],['#F3F1FC','Tint','Two bands per page, at most'],['#E1DEF3','Line','Borders, dividers'],['#10142E','Ink','Titles, headings, text on purple'],['#5A5F86','Muted','Descriptions, captions'],['#8C7AE6','Purple','Buttons, tabs, fills'],['#6C58DB','Purple text','Eyebrows, numbers, links'],['#D9182A','Red spark','One small accent per section'],['#0A0F26','Photo overlay','Text on photos is always white']];
const html=`<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Design System — Crux Nxtion</title>
<script src="./support.js"></script>
</head>
<body>
<x-dc>
<helmet>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  * { box-sizing: border-box; }
  body { margin: 0; font-family: 'Space Grotesk', system-ui, sans-serif; background: #FFFFFF; color: #10142E; }
  .bebas { font-family: 'Bebas Neue', 'Arial Narrow', sans-serif; letter-spacing: 0.5px; line-height: 0.92; text-transform: uppercase; }
  .eyebrow { font-weight: 600; letter-spacing: 3px; text-transform: uppercase; font-size: 11px; }
</style>
</helmet>
<div style="width:1440px; background:#FFFFFF;">
  <section style="padding:80px 64px 50px;">
    <span class="eyebrow" style="color:#6C58DB;">Crux Nxtion &bull; Design System</span>
    <h1 class="bebas" style="font-size:96px; margin:14px 0 18px;">ONE SYSTEM. TWO MOODS.</h1>
    <p style="font-size:16px; line-height:1.7; color:#3A3F66; max-width:760px; margin:0;">Everything is built from the two colours in the logo. <b>Events (A1)</b> is the dark, nightlife mood. <b>Consultancy and shared pages (A2a)</b> are the light, conversational mood. Same fonts, same buttons, same ticket motif — so the two services always feel like one brand.</p>
  </section>

  <section style="padding:0 64px 60px;">
    <div style="display:flex; gap:24px;">
      <div style="flex:1; border-radius:22px; background:#002671; color:#fff; padding:36px;"><span class="eyebrow" style="color:#fff;">From the logo</span><div class="bebas" style="font-size:56px; margin-top:12px;">#002671</div><div style="font-size:14px; margin-top:6px;">Logo blue</div></div>
      <div style="flex:1; border-radius:22px; background:#BA0000; color:#fff; padding:36px;"><span class="eyebrow" style="color:#fff;">From the logo</span><div class="bebas" style="font-size:56px; margin-top:12px;">#BA0000</div><div style="font-size:14px; margin-top:6px;">Logo red</div></div>
    </div>
  </section>

  <section style="padding:0 64px 60px; display:grid; grid-template-columns:1fr 1fr; gap:60px;">
    <div><h2 class="bebas" style="font-size:52px; margin:0 0 6px;">A1 — EVENTS (DARK)</h2><p style="font-size:13.5px; color:#5A5F86; margin:0 0 14px;">Nightlife mood. Red is a budget, not a theme: no more than about a tenth of any screen.</p>${A1.map(c=>sw(...c)).join('')}</div>
    <div><h2 class="bebas" style="font-size:52px; margin:0 0 6px;">A2a — CONSULTANCY (LIGHT)</h2><p style="font-size:13.5px; color:#5A5F86; margin:0 0 14px;">Conversational mood. Mostly white; tint used sparingly to group sections.</p>${A2.map(c=>sw(...c)).join('')}</div>
  </section>

  <section style="padding:0 64px 60px; display:grid; grid-template-columns:1fr 1fr; gap:60px;">
    <div><h2 class="bebas" style="font-size:52px; margin:0 0 14px;">TYPE</h2>
      ${rule('Display — Bebas Neue','H1 62–96px, H2 52–60px, H3 28–30px. Always uppercase, tight leading.')}
      ${rule('Body — Space Grotesk','Descriptions 14–15px, lead paragraphs 16–17px, line-height 1.6–1.8.')}
      ${rule('Eyebrow','11px, 600, 3px tracking, uppercase, in the accent colour. One per section, above the title.')}
      ${rule('Numbers','01, 02… in Bebas, accent colour.')}
    </div>
    <div><h2 class="bebas" style="font-size:52px; margin:0 0 14px;">RULES</h2>
      ${rule('Titles','White on dark, ink on light. Never coloured, except one highlighted phrase.')}
      ${rule('Descriptions','Muted colour, never pure white or pure black.')}
      ${rule('Text on photos','Always white, over a dark gradient. Never the accent colour except for chips.')}
      ${rule('Sections','Each section fills roughly one screen (about 800px). No thin filler bands.')}
      ${rule('Call-out bar','Sits above the header on every page: logo blue on A1, purple on A2a.')}
      ${rule('60 · 30 · 10','60% ink and photos, 30% logo blue and its tint (bars, marquee, eyebrows, links), 10% accents split between red (actions) and purple (Consultancy). Colour = meaning: blue is Events, purple is Consultancy, red is “do something”.')}
      ${rule('Where CTAs go','Hero primary → Contact. Hero secondary → the most useful next page (Events: upcoming events; Consultancy: How it works). “Explore Consultancy” → Consultancy Home. “View all services” → that service line’s Services page. Ticket cards → the single event. Pre-footer: Plan An Event and Talk Business Strategy → Contact.')}
      ${rule('Motion','Hover lifts on cards, gentle rise on load, floating stickers. Nothing that loops loudly.')}
    </div>
  </section>

  <section style="padding:0 64px 100px;">
    <h2 class="bebas" style="font-size:52px; margin:0 0 24px;">COMPONENTS</h2>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
      <div style="background:#0A0F26; border-radius:22px; padding:36px; color:#F4F5FA;">
        <span class="eyebrow" style="color:#5B8DEF;">A1 · Events</span>
        <h3 class="bebas" style="font-size:44px; margin:12px 0 8px;">TITLE IN WHITE</h3>
        <p style="font-size:14px; line-height:1.65; color:#A3A9C8; margin:0 0 22px;">Description in muted blue-grey. Eyebrow in the accent tint.</p>
        <div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap; margin-bottom:24px;">
          <span style="background:#BA0000; color:#fff; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Primary</span>
          <span style="border:1.5px solid #F4F5FA; color:#F4F5FA; font-weight:700; font-size:15px; padding:14.5px 28px;">Secondary</span>
          <span style="font-weight:700; font-size:13px; color:#5B8DEF; border-bottom:1.5px solid #5B8DEF; padding-bottom:2px;">Text link &rarr;</span>
          <span style="border:1px solid #1E2B5E; color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px; border-radius:999px;">Chip</span>
        </div>
        <div style="display:flex; gap:12px; margin-bottom:22px;">${[['#002671','24','FEB','#fff'],['#BA0000','23','APR','#fff'],['#8C7AE6','16','DEC','#0A0F26']].map(s=>`<div style="width:78px; height:96px; border-radius:10px; background:${s[0]}; display:flex; flex-direction:column; align-items:center; justify-content:center;"><span class="bebas" style="font-size:36px; color:${s[3]};">${s[1]}</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:${s[3]};">${s[2]}</span></div>`).join('')}<div style="flex:1; display:flex; flex-direction:column; justify-content:center; gap:8px;"><div style="background:#002671; color:#fff; font-size:12.5px; font-weight:700; padding:10px 16px; border-radius:8px;">CALL-OUT BAR / MARQUEE — LOGO BLUE</div><div style="font-size:12.5px; color:#A3A9C8;">Ticket stubs alternate blue, red, purple.</div></div></div>
      </div>
      <div style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:36px;">
        <span class="eyebrow" style="color:#6C58DB;">A2a · Consultancy</span>
        <h3 class="bebas" style="font-size:44px; margin:12px 0 8px;">TITLE IN INK</h3>
        <p style="font-size:14px; line-height:1.65; color:#5A5F86; margin:0 0 22px;">Description in muted grey-violet. Eyebrow in purple text.</p>
        <div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap; margin-bottom:24px;">
          <span style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%);">Primary</span>
          <span style="border:1.5px solid #10142E; color:#10142E; font-weight:700; font-size:15px; padding:14.5px 28px;">Secondary</span>
          <span style="font-weight:700; font-size:13px; color:#6C58DB; border-bottom:1.5px solid #6C58DB; padding-bottom:2px;">Text link &rarr;</span>
          <span style="border:1px solid #D2CEEA; color:#3A3F66; font-size:12px; font-weight:600; padding:8px 16px; border-radius:999px;">Chip</span>
        </div>
        <div style="background:#F3F1FC; border-radius:16px; padding:20px; display:flex; gap:12px;"><span style="background:#8C7AE6; color:#10142E; font-size:12.5px; font-weight:700; padding:12px 18px; border-radius:16px 16px 4px 16px;">Purple = us talking</span><span style="background:#fff; border:1.5px solid #E1DEF3; color:#10142E; font-size:12.5px; font-weight:600; padding:12px 18px; border-radius:16px 16px 16px 4px;">White = the client</span></div>
      </div>
    </div>
  </section>
</div>
</x-dc>
<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":2400}}'>
class Component extends DCLogic {
  renderVals() {
    return {};
  }
}
</script>
</body>
</html>
`;
fs.writeFileSync(SP+'pub/project/DesignSystem.dc.html',html);
console.log('ds ok');
