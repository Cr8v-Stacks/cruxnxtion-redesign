const fs=require('fs');
const SP='C:/Users/user/AppData/Local/Temp/claude/C--Users-user-OneDrive-Documents-Dev-Playground-Cr8v-Stacks-Events-Website-main/97df7f88-296d-4e3c-80ef-abf4a42b7050/scratchpad/';
const D={DesignSystem:2986,Megamenuevents:600,Megamenulight:600,HomeA:7968,HomeA2a:7752,ServicesA:4974,ServicesA2a:4745,AboutS:6168,ContactS:2921,FAQS:4419,EventsA:2964,SingleEventA:2901,GalleryA:3439,EventsArchiveA:3338,BlogA:2932,SingleBlogA:2828,Error404A:2342,SponsorsA:4552,PrivacyS:3160,CookiesS:2552,TermsS:2930,CookieBanner:780};
const M={M_AboutS:7641,M_ContactS:3658,M_FAQS:4719,M_EventsA:5070,M_SingleEventA:4242,M_GalleryA:3950,M_BlogA:3727,M_SingleBlogA:3200,M_Error404A:2369,M_SponsorsA:5114,M_EventsArchiveA:6022,M_PrivacyS:4114,M_CookiesS:2978,M_TermsS:3690,M_ServicesA2a:7341,M_CookieBanner:844};
const S=JSON.parse(fs.readFileSync(SP+'msplit.json','utf8'));
const H={}; for(const k in D) H[k]=Math.min(8000,D[k]+60); H.CookieBanner=780;
for(const k in M) H[k]=Math.min(8000,M[k]+(k==='M_CookieBanner'?0:60));
for(const k in S){ H['M_'+k]=S[k].cut; H['M_'+k+'_2']=S[k].total-S[k].cut+40; }
const T={DesignSystem:'Design System — Events (A1) & Consultancy (A2a)',Megamenuevents:'Mega menu open — Events pages',Megamenulight:'Mega menu open — light pages',HomeA:'Home — Events (A1)',HomeA2a:'Home — Consultancy (A2a)',ServicesA:'Services — Events (A1)',ServicesA2a:'Services — Consultancy (A2a)',AboutS:'About',ContactS:'Contact',FAQS:'FAQ',EventsA:'Events',SingleEventA:'Single event',GalleryA:'Gallery',EventsArchiveA:'Past events (archive)',BlogA:'Blog',SingleBlogA:'Single blog post',Error404A:'404 — page not found',SponsorsA:'Sponsors & partners',PrivacyS:'Privacy policy',CookiesS:'Cookie policy',TermsS:'Terms & conditions',CookieBanner:'Cookie banner'};
const R=[
 ['Design system & mega menu',['DesignSystem','Megamenuevents','Megamenulight']],
 ['Home — Events',['HomeA','M_HomeA','M_HomeA_2']],
 ['Home — Consultancy',['HomeA2a','M_HomeA2a','M_HomeA2a_2']],
 ['Services — Events',['ServicesA','M_ServicesA','M_ServicesA_2']],
 ['Services — Consultancy',['ServicesA2a','M_ServicesA2a']],
 ['About',['AboutS','M_AboutS']],
 ['Contact',['ContactS','M_ContactS']],
 ['FAQ',['FAQS','M_FAQS']],
 ['Events',['EventsA','M_EventsA']],
 ['Single event',['SingleEventA','M_SingleEventA']],
 ['Gallery',['GalleryA','M_GalleryA']],
 ['Past events (archive)',['EventsArchiveA','M_EventsArchiveA']],
 ['Blog',['BlogA','M_BlogA']],
 ['Single blog post',['SingleBlogA','M_SingleBlogA']],
 ['404',['Error404A','M_Error404A']],
 ['Sponsors & partners',['SponsorsA','M_SponsorsA']],
 ['Privacy policy',['PrivacyS','M_PrivacyS']],
 ['Cookie policy',['CookiesS','M_CookiesS']],
 ['Terms & conditions',['TermsS','M_TermsS']],
 ['Cookie consent — small card, no scrim, dismissible (click to try)',['CookieBanner','M_CookieBanner']],
];
const title=(id)=>{ if(T[id]) return T[id]; const b=id.replace(/^M_/,'').replace(/_2$/,''); const part=/_2$/.test(id)?' (2/2)':(S[b]?' (1/2)':''); return 'Mobile — '+(T[b]||b)+part; };
const boards={},order=[],notes={};let y=0;
R.forEach(([name,ids],ri)=>{ let x=0,m=0;
  ids.forEach(id=>{ const w=id.startsWith('M_')?390:1440; boards[id+'.dc.html']={x,y,w,h:H[id],title:title(id),is_interactive:true}; order.push(id+'.dc.html'); x+=w+80; m=Math.max(m,H[id]); });
  notes['row-'+ri]={x:0,y:y-140,text:name.toUpperCase(),kind:'title1',maxW:5960};
  y+=m+260; });
notes['note-1']={x:0,y:-460,text:"Each row: desktop page, then its mobile version(s) to the right. Events pages are dark; Consultancy and shared pages are light. Long mobile pages continue on the next board (1/2, 2/2).",size:'s',color:'purple',maxW:2400};
fs.writeFileSync(SP+'pub/project/canvas.json',JSON.stringify({v:3,createdOnFiles:{v:1,at:'2026-09-18T18:40:00Z'},title:'Crux Nxtion Events — Option Redesign',launch:{view:'canvas'},pages:[],boards,order,notes,designSystems:[]},null,2));
console.log(order.length, Object.entries(boards).filter(([k,v])=>v.h>=8000).map(x=>x[0]));
