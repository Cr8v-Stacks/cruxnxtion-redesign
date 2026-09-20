// New pages: 404, Sponsors, Past events (dark, Events) + Privacy, Cookies, Terms (light, shared)
const fs=require('fs');
const C=require('./common.js'); const P=C.SP+'pub/project/';
const B=(id)=>'/_blob/'+id;
const IM={a:B('feb81852032e2798160126ebf0d3c7f6'),b:B('4170d6b6009c07e37d83bae48a68917b'),c:B('2643e6061a232eeda4f8344fe6df6166'),d:B('b670d3a0bfa370687d246a6ab941625c'),e:B('99a3c292f4b3a38d253144801b4a9ae3'),f:B('2fe0208788cf2d50763c85dd2a44de66'),g:B('00a901525823b7149b4ebb66e5a9678f'),h:B('1d5292715423e2e83b56b3330a94b3b8'),i:B('c5afda4fc4e4d4b0682377d6eb272c90'),j:B('b094675514894aa0d8e7dd735d187b22'),k:B('e6e06da1a649b213d8dd573ea6511302'),l:B('5e2df00e7ead10292f7266fc033953c3'),m:B('8f947f32de7fe00cf711036348e00351')};
const BLUE='#002671', BL2='#1E48B0', RED='#BA0000', PU='#8C7AE6';

const dark=fs.readFileSync(P+'GalleryA.dc.html','utf8');
const light=fs.readFileSync(P+'ContactS.dc.html','utf8');
const SCRIPT=(w)=>`<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":1440,"height":${w}}}'>
class Component extends DCLogic {
  renderVals() { return {}; }
}
</script>`;
function frame(src,cut,title,h){
  const a=src.indexOf(cut), b=src.indexOf('  <!-- PREFOOTER CTA');
  let pre=src.slice(0,a), post=src.slice(b);
  pre=pre.replace(/<title>[^<]*<\/title>/,'<title>'+title+'</title>');
  // no page is "active" in the header on these pages
  pre=pre.replace(/(<nav[\s\S]*?<\/nav>)/,(nav)=>{
    const m=/<a [^>]*style="color:(#[0-9A-Fa-f]{6}); font-size:13px; font-weight:600;"/.exec(nav); const col=m?m[1]:'#F4F5FA';
    return nav.replace(/style="color:#[0-9A-Fa-f]{6}; font-size:13px; font-weight:600; border-bottom:1\.5px solid #[0-9A-Fa-f]{6};"/,'style="color:'+col+'; font-size:13px; font-weight:600;"');
  });
  if(src===light) post='  <div style="background:#10142E;">\n\n'+post;
  post=post.replace(/<script type="text\/x-dc"[\s\S]*?<\/script>/,SCRIPT(h));
  return [pre,post];
}
const btn=(txt,bg,fg,href,extra='')=>`<a href="${href}" style="background:${bg}; color:${fg}; font-weight:700; font-size:15px; padding:16px 30px; clip-path:polygon(10px 0,100% 0,calc(100% - 10px) 100%,0 100%); ${extra}">${txt}</a>`;
const outline=(txt,href)=>`<a href="${href}" style="border:1.5px solid #5B8DEF; color:#F4F5FA; font-weight:700; font-size:15px; padding:14px 28px; border-radius:6px;">${txt}</a>`;
const stubCol=(i)=>[[BLUE,'#FFFFFF'],[RED,'#FFFFFF'],[PU,'#10142E']][i%3];
const stub=(i,l,r)=>{const [bg,fg]=stubCol(i);return `<div class="strip-stub" style="background:${bg}; padding:12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:${fg}; letter-spacing:1px; text-transform:uppercase;">${l}</span><span class="bebas" style="font-size:14px; color:${fg};">${r}</span></div>`;};
const tilt=['-1deg','0.8deg','-0.6deg','1deg'];

// ---------------- 404 ----------------
{
  const [pre,post]=frame(dark,'  <!-- PAGE HEADING -->','Page not found — Crux Nxtion Events',1500);
  const quick=[['Upcoming Events','EventsA.dc.html','See what is on the ticket wall.'],['Gallery','GalleryA.dc.html','Frames from nights we have run.'],['Our Services','ServicesA.dc.html','Events and consultancy, side by side.'],['Get In Touch','ContactS.dc.html','Tell us the date, we will do the rest.']];
  const body=`  <!-- 404 -->
  <section style="min-height:760px; padding:90px 64px 60px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden;">
    <span aria-hidden="true" class="bebas" style="font-size:300px; line-height:.8; background:linear-gradient(180deg,#F4F5FA 0%,#5B8DEF 40%,#1E2B5E 85%,transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">404</span>
    <span class="eyebrow" style="margin-top:18px;">Off The Guest List</span>
    <h1 class="bebas" style="font-size:78px; margin:14px 0 18px; color:#F4F5FA;">THIS PAGE DIDN'T MAKE THE LINE-UP.</h1>
    <p style="font-size:16px; line-height:1.6; color:#A3A9C8; max-width:520px; margin:0 0 30px;">The link may be old, or the page has moved. Head back to the main room, or pick one of the doors below.</p>
    <div style="display:flex; gap:16px; justify-content:center;">${btn('Back To Home',RED,'#FFFFFF','HomeA.dc.html')}${outline('See Upcoming Events','EventsA.dc.html')}</div>
  </section>
  <section style="padding:10px 64px 100px;">
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px;">
${quick.map((q,i)=>`      <a href="${q[1]}" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(${tilt[i]});">
        <div style="padding:26px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0 0 8px; color:#F4F5FA;">${q[0]}</h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0;">${q[2]}</p></div>
        ${stub(i,'Take me there','&rarr;')}
      </a>`).join('\n')}
    </div>
  </section>

`;
  fs.writeFileSync(P+'Error404A.dc.html',pre+body+post);
}

// ---------------- Sponsors ----------------
{
  const [pre,post]=frame(dark,'  <!-- PAGE HEADING -->','Sponsors & partners — Crux Nxtion Events',2800);
  const tiers=[['Headline Partner','Your brand at the centre of the night.',['Naming presence on flyers, social and stage','Dedicated on-site activation space','Speaking or hosted moment on the run of show','Featured story on the blog and gallery'],IM.l],['Supporting Partner','Visible, valuable, budget-friendly.',['Logo on event marketing and screens','Shout-outs from the MC and host','Product sampling or table presence','Tagged photo and video coverage'],IM.b],['Community Partner','Support the culture, get seen doing it.',['Listing on the partners page','Social thank-you and tagged post','Invite for two to the event','Option to grow into a bigger package'],IM.g]];
  const perks=[['Real crowds','People who come to celebrate and spend, not scroll past.'],['Content that lasts','Photography and video from our team, shared with you.'],['Cultural fit','We pair you with events that match your customers.'],['Easy to run','One crew, one contact. We handle the logistics.']];
  const body=`  <!-- SPONSORS HEADING -->
  <section style="padding:70px 64px 30px; display:grid; grid-template-columns:1.1fr .9fr; gap:56px; align-items:end;">
    <div><span class="eyebrow">Sponsors &amp; Partners</span>
    <h1 class="bebas" style="font-size:88px; margin:14px 0 16px; color:#F4F5FA;">PUT YOUR BRAND<br><span style="color:#E5383B;">IN THE ROOM.</span></h1>
    <p style="font-size:16px; line-height:1.65; color:#A3A9C8; max-width:540px; margin:0 0 26px;">Weddings, cultural nights and festivals put your name in front of a loyal, engaged crowd. Partner with Crux Nxtion Events and be part of the story, not just the banner.</p>
    <div style="display:flex; gap:16px;">${btn('Become A Partner',RED,'#FFFFFF','ContactS.dc.html')}${outline('See Upcoming Events','EventsA.dc.html')}</div></div>
    <div style="position:relative; height:420px; border-radius:16px; overflow:hidden; border:1.5px solid #1E2B5E;"><img src="${IM.l}" alt="Guests at a Crux Nxtion event" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg,rgba(10,15,38,.75),rgba(10,15,38,0) 55%);"></div></div>
  </section>

  <!-- PACKAGES -->
  <section style="padding:60px 64px 40px;">
    <span class="eyebrow">Ways To Partner</span><h2 class="bebas" style="font-size:60px; margin:12px 0 34px; color:#F4F5FA;">THREE TICKETS IN.</h2>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px; align-items:start;">
${tiers.map((t,i)=>`      <div style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(${tilt[i]});">
        <div style="position:relative; height:200px;"><img src="${t[3]}" alt="" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        ${stub(i,'Tier 0'+(i+1),'PARTNER')}
        <div style="padding:22px 22px 26px;"><h3 class="bebas" style="font-size:34px; margin:0 0 6px; color:#F4F5FA;">${t[0]}</h3><p style="font-size:14px; color:#A3A9C8; margin:0 0 16px;">${t[1]}</p>
        <ul style="margin:0; padding:0; list-style:none; display:flex; flex-direction:column; gap:10px;">${t[2].map(x=>`<li style="font-size:13.5px; color:#D5D9EA; line-height:1.45; padding-left:20px; position:relative;"><span style="position:absolute; left:0; color:#5B8DEF;">&#10003;</span>${x}</li>`).join('')}</ul></div>
      </div>`).join('\n')}
    </div>
  </section>

  <!-- WHY PARTNER -->
  <section style="padding:70px 64px 60px;">
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:22px;">
${perks.map((p,i)=>`      <div style="border-top:3px solid ${['#5B8DEF',RED,PU,'#5B8DEF'][i]}; padding-top:18px;"><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#F4F5FA;">${p[0]}</h3><p style="font-size:14px; line-height:1.6; color:#A3A9C8; margin:0;">${p[1]}</p></div>`).join('\n')}
    </div>
  </section>

  <!-- ENQUIRY -->
  <section style="padding:30px 64px 100px;">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0; background:#111838; border:1.5px solid #1E2B5E; border-radius:16px; overflow:hidden;">
      <div style="padding:46px 44px;"><span class="eyebrow">Start The Conversation</span><h2 class="bebas" style="font-size:52px; margin:12px 0 14px; color:#F4F5FA;">TELL US ABOUT YOUR BRAND.</h2><p style="font-size:15px; line-height:1.65; color:#A3A9C8; margin:0 0 20px;">Share who you want to reach and we will suggest the events and package that fit. You will hear back within two working days.</p><p style="font-size:14px; color:#D5D9EA; margin:0; line-height:1.9;">infoandsales@cruxnxtionevents.net<br>+44 7341 366400</p></div>
      <form style="padding:40px 44px; background:#0D1330; display:flex; flex-direction:column; gap:14px;">
        <input type="text" placeholder="Your name" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA;">
        <input type="text" placeholder="Company or brand" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA;">
        <input type="email" placeholder="you@company.com" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA;">
        <textarea rows="4" placeholder="What are you hoping to achieve?" style="font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #1E2B5E; border-radius:10px; background:#111838; color:#F4F5FA; resize:none;"></textarea>
        <button type="button" style="border:none; cursor:pointer; background:${RED}; color:#fff; font-weight:700; font-size:15px; padding:16px; border-radius:10px; font-family:inherit;">Send Enquiry</button>
      </form>
    </div>
  </section>

`;
  fs.writeFileSync(P+'SponsorsA.dc.html',pre+body+post);
}

// ---------------- Past events (archive) ----------------
{
  const [pre,post]=frame(dark,'  <!-- PAGE HEADING -->','Past events — Crux Nxtion Events',3000);
  const ev=[['Ankara Festival','Cultural night',IM.j,'Sheffield'],['Dance OUT 2023','Dance & live acts',IM.h,'Sheffield'],['YAGI Awards','Awards night',IM.g,'UK'],['Millennials vs Gen Z','Party',IM.i,'Sheffield'],['The Wedding Party','Wedding showcase',IM.c,'UK'],['Crux Nxtion Hangout Out','Social',IM.m,'Sheffield'],['LASGIDI Mainland Party','IJGB Edition',IM.g,'UK'],['Becoming Mr & Mrs Crux','Couples night',IM.a,'Sheffield'],['Nxtion Food Market','Food & culture',IM.b,'Sheffield']];
  const chips=['All','Weddings','Parties','Cultural','Awards','Food'];
  const body=`  <!-- ARCHIVE HEADING -->
  <section style="padding:70px 64px 20px;">
    <span class="eyebrow">Past Events</span>
    <h1 class="bebas" style="font-size:88px; margin:14px 0 14px; color:#F4F5FA;">THE ARCHIVE</h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:540px; margin:0 0 26px;">Every night we have planned, booked and run, filed like a ticket stub.</p>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">${chips.map((c,i)=>`<a href="#" style="font-size:12.5px; font-weight:700; padding:10px 20px; border-radius:999px; ${i===0?`background:${BL2}; color:#fff;`:'border:1.5px solid #1E2B5E; color:#A3A9C8;'}">${c}</a>`).join('')}</div>
  </section>
  <section style="padding:30px 64px 90px;">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:34px 26px; align-items:start;">
${ev.map((e,i)=>`      <a href="SingleEventA.dc.html" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(${tilt[i%4]});">
        <div style="position:relative; height:${[260,300,240][i%3]}px;"><img src="${e[2]}" alt="${e[0].replace('&','and')}" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        ${stub(i,e[1],'PAST EVENT')}
        <div style="padding:18px 20px 22px;"><h3 class="bebas" style="font-size:30px; margin:0 0 4px; color:#F4F5FA;">${e[0]}</h3><p style="font-size:13px; color:#A3A9C8; margin:0;">${e[3]}, United Kingdom</p></div>
      </a>`).join('\n')}
    </div>
    <div style="text-align:center; margin-top:56px;">${btn('Book Your Own Night',RED,'#FFFFFF','ContactS.dc.html')}</div>
  </section>

`;
  fs.writeFileSync(P+'EventsArchiveA.dc.html',pre+body+post);
}

// ---------------- Legal pages (light) ----------------
const CO='Crux Nxtion Events', ADDR='29 Dun Work, Sheffield S3 8FB, United Kingdom', MAIL='infoandsales@cruxnxtionevents.net';
function legal(file,title,eyebrow,intro,sections){
  const [pre,post]=frame(light,'  <!-- 1 CONTACT -->',title+' — Crux Nxtion Events',2200);
  const toc=sections.map((s,i)=>`<a href="#s${i+1}" style="display:block; font-size:14px; color:#5A5F86; padding:9px 0 9px 14px; border-left:2px solid #E1DEF3;">${i+1}. ${s[0]}</a>`).join('');
  const body=`  <!-- LEGAL -->
  <section style="padding:70px 64px 30px; background:#F3F1FC; border-bottom:1px solid #E1DEF3;">
    <span class="eyebrow">${eyebrow}</span>
    <h1 class="bebas" style="font-size:80px; margin:14px 0 14px; color:#10142E;">${title.toUpperCase()}</h1>
    <p style="font-size:15px; line-height:1.65; color:#5A5F86; max-width:640px; margin:0 0 6px;">${intro}</p>
    <p style="font-size:12.5px; color:#8A8FB0; margin:12px 0 0;">Last updated 19 September 2026</p>
  </section>
  <section style="padding:56px 64px 100px; display:grid; grid-template-columns:280px 1fr; gap:64px; align-items:start;">
    <div style="position:sticky; top:24px;"><div style="font-size:11px; letter-spacing:2.6px; font-weight:700; color:#6C58DB; margin-bottom:12px;">ON THIS PAGE</div>${toc}
      <div style="margin-top:26px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:14px; padding:18px 18px;"><b style="font-size:14px; color:#10142E;">Questions?</b><p style="font-size:13px; line-height:1.55; color:#5A5F86; margin:6px 0 10px;">Email us and a real person will reply.</p><a href="ContactS.dc.html" style="font-weight:700; font-size:13px; color:#6C58DB;">Contact us &rarr;</a></div></div>
    <div style="max-width:760px;">
${sections.map((s,i)=>`      <div id="s${i+1}" style="margin-bottom:40px;"><h2 class="bebas" style="font-size:38px; margin:0 0 12px; color:#10142E;">${i+1}. ${s[0]}</h2>${s[1].map(p=>`<p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 12px;">${p}</p>`).join('')}</div>`).join('\n')}
    </div>
  </section>

`;
  fs.writeFileSync(P+file,pre+body+post);
}
legal('PrivacyS.dc.html','Privacy Policy','Legal',`How ${CO} collects, uses and protects your personal information. We keep it plain and short.`,[
 ['Who we are',[`${CO} is an events and business consultancy company based in Sheffield, United Kingdom (${ADDR}). We are the controller of the personal information described in this policy. You can reach us at ${MAIL}.`]],
 ['What we collect',['When you enquire, book or subscribe we collect your name, email address, phone number, the details of your event or business, and anything you choose to tell us.','When you visit the website we collect basic technical data such as your IP address, browser and pages visited, through cookies and similar tools (see our Cookie Policy).','If you buy tickets for one of our events through a third-party ticketing platform, that platform handles your payment details, not us.']],
 ['How we use it',['To reply to enquiries, plan and deliver events, and provide consultancy services.','To send updates you have asked for. You can opt out at any time.','To improve our website, to keep it secure and to meet legal obligations.']],
 ['Legal basis',['We rely on contract (to deliver what you have booked), legitimate interests (running and improving our business), consent (marketing and non-essential cookies) and legal obligation (for example, accounting records).']],
 ['Who we share it with',['Only people who help us deliver our services: venues, suppliers, ticketing and payment platforms, website hosting, analytics and email providers. We do not sell your personal information.']],
 ['How long we keep it',['Enquiry and booking records are kept for as long as needed to deliver the service and for up to six years afterwards for accounting and legal reasons. Marketing contacts are kept until you unsubscribe.']],
 ['Your rights',['Under UK GDPR you can ask to see, correct, delete or restrict the use of your information, object to certain uses, and request a copy of the data you gave us. You can also withdraw consent at any time.',`To use any of these rights, email ${MAIL}. If you are unhappy with how we handle your data you can complain to the Information Commissioner's Office at ico.org.uk.`]],
 ['Changes to this policy',['We may update this policy from time to time. The date at the top shows when it last changed.']]]);
legal('CookiesS.dc.html','Cookie Policy','Legal',`What cookies are, which ones we use, and how to control them.`,[
 ['What are cookies',['Cookies are small text files stored on your device when you visit a website. They help the site work, remember your choices and understand how it is used.']],
 ['Cookies we use',['<b>Essential</b> cookies keep the site secure and working, for example remembering your cookie choice. They cannot be switched off.','<b>Analytics</b> cookies help us understand which pages are useful, using anonymous or aggregated data. We only set these if you accept.','<b>Marketing</b> cookies, where used, help us show relevant Crux Nxtion content on other platforms. We only set these if you accept.']],
 ['Third-party cookies',['Some content, such as embedded videos, maps, social feeds and ticketing pages, is provided by other companies who may set their own cookies. Please check their policies for details.']],
 ['Managing your choices',['You can change your consent at any time using the cookie settings link in the site footer. You can also block or delete cookies in your browser settings, but parts of the site may not work as intended.']],
 ['Contact',[`Questions about cookies? Email ${MAIL}.`]]]);
legal('TermsS.dc.html','Terms & Conditions','Legal',`The ground rules for using our website and booking our services.`,[
 ['About these terms',[`These terms apply to your use of this website and to any enquiry you make with ${CO} (${ADDR}). By using the site you agree to them.`]],
 ['Event bookings and services',['A booking or consultancy engagement is only confirmed once we have agreed the scope, price and date in writing and any deposit has been received.','Each booking is covered by a written proposal or agreement that sets out deposits, payment dates, changes and cancellation. Where that document differs from these terms, the document applies.']],
 ['Tickets to our events',['Tickets are sold through third-party platforms and are subject to their terms as well as any event-specific conditions on the ticket page. Age limits and venue rules apply and entry may be refused where they are not met.']],
 ['Photography and filming',['We photograph and film at our events for marketing and to share memories. Notices will be displayed at the venue. If you would rather not appear, please tell a member of the crew.']],
 ['Our content',['All text, images, logos and designs on this website belong to '+CO+' or its licensors. You may not copy or reuse them without written permission.']],
 ['Liability',['We take care to keep the website accurate but provide it as is. Nothing in these terms limits liability that cannot lawfully be limited, including for death or personal injury caused by negligence or for fraud.']],
 ['Governing law',['These terms are governed by the laws of England and Wales and disputes are subject to the courts of England and Wales.']],
 ['Contact',[`Email ${MAIL} with any questions about these terms.`]]]);

// keep link map: new page names
console.log('newpages ok');
