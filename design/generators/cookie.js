// Non-intrusive cookie banner: small card, no scrim, dismissible, re-openable chip.
const fs=require('fs');const C=require('./common.js');const P=C.SP+'pub/project/';
const HERO='/_blob/5e2df00e7ead10292f7266fc033953c3';
function page(mobile){
  const W=mobile?390:1440,H=mobile?844:780;
  const cardW=mobile?'calc(100% - 24px)':'380px';
  const pos=mobile?'left:12px; right:12px; bottom:12px;':'left:24px; bottom:24px;';
  return `<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cookie banner — ${mobile?'mobile':'desktop'}</title>
<script src="./support.js"></script>
</head>
<body>
<x-dc>
<helmet>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  * { box-sizing:border-box; }
  body { margin:0; font-family:'Space Grotesk',system-ui,sans-serif; background:#0A0F26; color:#F4F5FA; }
  a { text-decoration:none; color:inherit; }
  .bebas { font-family:'Bebas Neue','Arial Narrow',sans-serif; letter-spacing:.5px; line-height:.92; text-transform:uppercase; }
  @keyframes ckin { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:none; } }
  .ck { animation:ckin .45s ease both; }
  .sw { width:38px; height:22px; border-radius:999px; position:relative; flex:0 0 38px; }
  .sw i { position:absolute; top:3px; width:16px; height:16px; border-radius:50%; background:#fff; }
</style>
</helmet>

<div style="position:relative; width:${W}px; height:${H}px; overflow:hidden; background:#0A0F26;">
  <img src="${HERO}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
  <div style="position:absolute; inset:0; background:linear-gradient(${mobile?'180deg':'90deg'}, rgba(10,15,38,.62) 0%, rgba(10,15,38,.94) ${mobile?'70%':'62%'});"></div>
  <div style="position:relative; padding:${mobile?'60px 20px':'120px 64px'}; max-width:${mobile?'100%':'760px'};">
    <span style="font-weight:600; letter-spacing:3px; text-transform:uppercase; font-size:11px; color:#5B8DEF;">UK-based &bull; live events</span>
    <h1 class="bebas" style="font-size:${mobile?54:104}px; margin:16px 0 0; color:#F4F5FA;">WE PLAN IT.<br>WE BOOK IT.<br><span style="color:#E5383B;">WE RUN IT.</span></h1>
  </div>

  <sc-if value="{{open}}" hint-placeholder-val="{{true}}">
    <div class="ck" style="position:absolute; ${pos} width:${cardW}; background:#111838; border:1.5px solid #1E2B5E; border-radius:16px; padding:${mobile?'18px 18px 16px':'22px 22px 18px'}; box-shadow:0 18px 40px rgba(0,0,0,.45); z-index:20;">
      <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
        <div><span style="font-weight:700; font-size:15px; color:#F4F5FA;">A quick word on cookies</span>
        <p style="font-size:13px; line-height:1.55; color:#A3A9C8; margin:6px 0 0;">We use a few to keep the site working and, if you say yes, to see which pages help. <a href="CookiesS.dc.html" style="color:#5B8DEF; border-bottom:1px solid #5B8DEF;">Cookie policy</a></p></div>
        <button onClick="{{dismiss}}" aria-label="Close" style="border:none; background:transparent; color:#A3A9C8; font-size:22px; line-height:1; cursor:pointer; padding:0 2px;">&times;</button>
      </div>
      <sc-if value="{{prefs}}" hint-placeholder-val="{{false}}">
        <div style="margin-top:14px; display:flex; flex-direction:column; gap:10px; border-top:1px solid #1E2B5E; padding-top:14px;">
          <div style="display:flex; justify-content:space-between; align-items:center; gap:14px;"><div><b style="font-size:13px;">Essential</b><div style="font-size:12px; color:#8E96BB;">Keeps the site secure and working</div></div><span class="sw" style="background:#3D4F94; opacity:.7;"><i style="right:3px;"></i></span></div>
          <div onClick="{{toggleA}}" style="display:flex; justify-content:space-between; align-items:center; gap:14px; cursor:pointer;"><div><b style="font-size:13px;">Analytics</b><div style="font-size:12px; color:#8E96BB;">Helps us improve pages</div></div><span class="sw" style="{{swA}}"><i style="{{knobA}}"></i></span></div>
          <div onClick="{{toggleM}}" style="display:flex; justify-content:space-between; align-items:center; gap:14px; cursor:pointer;"><div><b style="font-size:13px;">Marketing</b><div style="font-size:12px; color:#8E96BB;">Relevant Crux content elsewhere</div></div><span class="sw" style="{{swM}}"><i style="{{knobM}}"></i></span></div>
        </div>
      </sc-if>
      <div style="display:flex; gap:8px; margin-top:16px; flex-wrap:wrap;">
        <button onClick="{{acceptAll}}" style="border:none; cursor:pointer; background:#BA0000; color:#fff; font-family:inherit; font-weight:700; font-size:13px; padding:11px 18px; border-radius:8px;">Accept all</button>
        <button onClick="{{essential}}" style="cursor:pointer; background:transparent; color:#F4F5FA; border:1.5px solid #3D4F94; font-family:inherit; font-weight:700; font-size:13px; padding:10px 16px; border-radius:8px;">Essential only</button>
        <button onClick="{{togglePrefs}}" style="cursor:pointer; background:transparent; color:#A3A9C8; border:none; font-family:inherit; font-weight:600; font-size:13px; padding:11px 6px; text-decoration:underline;">{{prefsLabel}}</button>
      </div>
    </div>
  </sc-if>
  <sc-if value="{{closed}}" hint-placeholder-val="{{false}}">
    <button onClick="{{reopen}}" class="ck" style="position:absolute; ${mobile?'left:12px; bottom:12px;':'left:24px; bottom:24px;'} z-index:20; cursor:pointer; background:#111838; color:#A3A9C8; border:1.5px solid #1E2B5E; border-radius:999px; font-family:inherit; font-weight:600; font-size:12px; padding:9px 14px;">Cookie settings</button>
  </sc-if>
</div>
</x-dc>
<script type="text/x-dc" data-dc-script data-props='{"$preview":{"width":${W},"height":${H}}}'>
class Component extends DCLogic {
  constructor(props) { super(props); this.state = { open: true, prefs: false, a: false, m: false }; }
  renderVals() {
    const s = this.state;
    const on = 'background:#BA0000;', off = 'background:#3D4F94;';
    return {
      open: s.open, closed: !s.open, prefs: s.prefs,
      prefsLabel: s.prefs ? 'Hide preferences' : 'Preferences',
      swA: s.a ? on : off, swM: s.m ? on : off,
      knobA: s.a ? 'right:3px;' : 'left:3px;', knobM: s.m ? 'right:3px;' : 'left:3px;',
      dismiss: () => this.setState({ open: false }),
      reopen: () => this.setState({ open: true }),
      acceptAll: () => this.setState({ open: false, a: true, m: true }),
      essential: () => this.setState({ open: false, a: false, m: false }),
      togglePrefs: () => this.setState({ prefs: !s.prefs }),
      toggleA: () => this.setState({ a: !s.a }),
      toggleM: () => this.setState({ m: !s.m }),
    };
  }
}
</script>
</body>
</html>
`;}
fs.writeFileSync(P+'CookieBanner.dc.html',page(false));
fs.writeFileSync(P+'M_CookieBanner.dc.html',page(true));
console.log('cookie ok');
