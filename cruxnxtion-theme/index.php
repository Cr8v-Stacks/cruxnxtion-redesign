<?php
/**
 * Template Name: Crux Nxtion - Template
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php crux_use_page_css( 'home' ); get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'home' ) ); ?>

    <!-- HERO -->
  <section style="position:relative; height:700px; overflow:hidden; clip-path:polygon(0 0,100% 0,100% 92%,0 100%);">
    <img src="<?php echo crux_get_blob_url( "5e2df00e7ead10292f7266fc033953c3" ); ?>" alt="Crowd dancing at a Crux Nxtion Events event" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:saturate(1.05) contrast(1.05);" class="drift">
    <div class="hero-dark-overlay" style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.78) 42%, rgba(10,15,38,0.2) 78%);"></div>
    
    <div style="position:relative; height:100%; display:flex; flex-direction:column; justify-content:center; padding:0px 20px 0px 20px; max-width:760px;" class="reveal">
      <span class="eyebrow" style="font-size:11.5px !important; letter-spacing:0.8px !important; text-transform:none !important; font-weight:700 !important; color:var(--crux-blue,#5B8DEF); margin-bottom:14px; display:inline-block;">Cultural Live Event Production &amp; Business Consultancy</span>

      <h1 class="bebas" style="font-size:52px; margin:0px 0px 18px 0px; color:var(--crux-text,#F4F5FA); line-height:0.95;">WE PLAN IT.<br>WE BOOK IT.<br><span style="color:var(--crux-crimson,#E5383B);">WE RUN IT.</span></h1>
      <p class="hero-desc" style="font-size:16px !important; line-height:1.65; color:#C5CADF; max-width:580px; margin:0px 0px 28px 0px;">Crux Nxtion Events &amp; Consultancy plans, books, and executes the live gatherings people talk about for weeks, while delivering the strategic business solutions that scale the enterprises behind them — your singular crew from the first brief to the final execution.</p>
      <div style="display:flex; gap:16px; flex-wrap:wrap;">
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 30px; --sl:10px;" class="bx">Plan An Event →</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-weight:700; font-size:15px; padding:16px 28px; --sl:10px;" class="bx">Explore Consultancy →</a>
      </div>
    </div>
  </section>

    <!-- MARQUEE — SLANTED TO MATCH HERO CUT -->
  <div class="hero-slanted-marquee" style="background:var(--crux-navy,#002671); padding:18px 0; overflow:hidden; white-space:nowrap; margin-top:-53px; transform:skewY(-2.1deg); transform-origin:left top; z-index:2; position:relative; box-shadow:0 12px 30px rgba(0,0,0,0.4); border-top:1.5px solid rgba(91,141,239,0.4); border-bottom:1.5px solid rgba(91,141,239,0.2);">
    <div style="display:inline-flex; transform:skewY(2.1deg); animation:rc-marquee 22s linear infinite;">
      <span class="bebas" style="font-size:26px; color:#FFFFFF; letter-spacing:1.2px; padding-right:1ch;">EVENT MANAGEMENT &nbsp;•&nbsp; ENTERTAINMENT BOOKING &nbsp;•&nbsp; EVENT DESIGN &nbsp;•&nbsp; ON-SITE COORDINATION &nbsp;•&nbsp; WEDDINGS &nbsp;•&nbsp; CULTURAL NIGHTS &nbsp;•&nbsp; FESTIVALS &nbsp;•&nbsp; CORPORATE GALAS &nbsp;•&nbsp;</span>
      <span class="bebas" style="font-size:26px; color:#FFFFFF; letter-spacing:1.2px; padding-right:1ch;" aria-hidden="true">EVENT MANAGEMENT &nbsp;•&nbsp; ENTERTAINMENT BOOKING &nbsp;•&nbsp; EVENT DESIGN &nbsp;•&nbsp; ON-SITE COORDINATION &nbsp;•&nbsp; WEDDINGS &nbsp;•&nbsp; CULTURAL NIGHTS &nbsp;•&nbsp; FESTIVALS &nbsp;•&nbsp; CORPORATE GALAS &nbsp;•&nbsp;</span>
    </div>
  </div>

  <!-- SERVICES — rider / setlist rows -->
  <section id="services" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:44px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:8px;" class="reveal" data-m="stack">
      <h2 class="bebas" style="font-size:34px; margin:0px 0px 0px 0px; color:var(--crux-text,#F4F5FA);">WHAT WE DO</h2>
      <span style="font-size:12px; color:#7A82A8; letter-spacing:2px; text-transform:uppercase;">Event Services</span>
    </div>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;" class="reveal" data-m="stack">
      <p style="max-width:500px; font-size:13px; color:#8E96BB; margin:0px 0px 0px 0px;">Five services, one crew — from the first brief to the last guest.</p>
      <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="font-weight:700; font-size:13px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;">View All Services →</a>
    </div>
    <div style="border-top:1.5px solid var(--crux-line,#1E2B5E);" class="reveal">

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-blue,#5B8DEF); flex:0 0 54px;">01</span>
        <img src="<?php echo crux_get_blob_url( "e6e06da1a649b213d8dd573ea6511302" ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;">
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;">Event Management &amp; Planning</h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;">Meticulous coordination and planning for private and corporate events.</p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E); background:rgba(244,245,250,0.02);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-crimson,#E5383B); flex:0 0 54px;">02</span>
        <img src="<?php echo crux_get_blob_url( "6e1036b74f617a3d1887a7cf36398cff" ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;">
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;">Entertainment Booking &amp; Talent</h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;">Star power secured and run-of-show handled for every act on the bill.</p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-blue,#5B8DEF); flex:0 0 54px;">03</span>
        <img src="<?php echo crux_get_blob_url( "c5afda4fc4e4d4b0682377d6eb272c90" ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;">
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;">Event Designs &amp; Production</h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;">Themed, creative production for weddings, galas and private launches.</p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E); background:rgba(244,245,250,0.02);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-crimson,#E5383B); flex:0 0 54px;">04</span>
        <img src="<?php echo crux_get_blob_url( "feb81852032e2798160126ebf0d3c7f6" ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;">
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;">On-Site Coordination</h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;">Vendor management and real-time floor coordination, start to close.</p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-blue,#5B8DEF); flex:0 0 54px;">05</span>
        <img src="<?php echo crux_get_blob_url( "2b696c907bf5b4d0dc14a80e8cd60e15" ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;">
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;">Event Marketing &amp; Promotion</h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;">Strategic marketing and promotion that builds buzz and gets the right crowd through the door.</p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>
    </div>
  </section>

  <!-- EVENTS — ticket stub -->
  <section id="events" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:20px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;" class="reveal" data-m="stack">
      <h2 class="bebas" style="font-size:34px; margin:0px 0px 0px 0px; color:var(--crux-text,#F4F5FA);">EVENTS</h2>
      <div style="text-align:right;">
        <p style="max-width:360px; font-size:13.5px; color:#A3A9C8; margin:0px 0px 8px 0px;">Every ticket we've printed, punched by the same crew.</p>
        <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="font-weight:700; font-size:13px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;">View All Events →</a>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;" data-m="g1">
      <a href="<?php echo esc_url( home_url( "/event/dance-out-2023/" ) ); ?>" class="tilt-ticket" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:330px; --r:-1deg; transform:rotate(var(--r)); overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 90px; background:var(--crux-navy,#002671); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
          <span class="bebas" style="font-size:38px; color:#FFFFFF; line-height:1;">25</span>
          <span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:#FFFFFF; text-align:center;">JAN 2025</span>
        </div>
        <div style="flex:1; display:flex; flex-direction:column; min-width:0;">
          <div style="flex:1; position:relative; min-height:180px;"><img src="<?php echo crux_get_blob_url( "a15ea8703f82f1d0f8577325e8d85a3b" ); ?>" alt="LASGIDI Mainland Party" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center top;"></div>
          <div style=" padding:16px 18px 18px 18px; background:#0D1330; border-top:1.5px dashed var(--crux-line,#1E2B5E);">
            <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);">IJGB Edition</span>
            <h3 style="font-size:19px; margin:8px 0px 4px 0px; font-weight:700; color:#FFFFFF;">LASGIDI Mainland Party</h3>
            <p style="font-size:12.5px; color:#C5CFF5; margin:0px 0px 10px 0px;">Tickets on Eventbrite</p>
            <span style="font-weight:700; font-size:12.5px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;">View Details →</span>
          </div>
        </div>
      </a>
      <a href="<?php echo esc_url( home_url( "/event/dance-out-2023/" ) ); ?>" class="tilt-ticket" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:330px; --r:0.8deg; transform:rotate(var(--r)); overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 90px; background:var(--crux-red,#BA0000); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
          <span class="bebas" style="font-size:38px; color:#FFFFFF; line-height:1;">23</span>
          <span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:#FFFFFF; text-align:center;">APR 2025</span>
        </div>
        <div style="flex:1; display:flex; flex-direction:column; min-width:0;">
          <div style="flex:1; position:relative; min-height:180px;"><img src="<?php echo crux_get_blob_url( "2f9f2834d9f0829e887b03bccc208656" ); ?>" alt="Becoming Mr &amp; Mrs Crux Pt.3" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center top;"></div>
          <div style=" padding:16px 18px 18px 18px; background:#0D1330; border-top:1.5px dashed var(--crux-line,#1E2B5E);">
            <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);">Part 3</span>
            <h3 style="font-size:19px; margin:8px 0px 4px 0px; font-weight:700; color:#FFFFFF;">Becoming Mr &amp; Mrs Crux Pt.3</h3>
            <p style="font-size:12.5px; color:#C5CFF5; margin:0px 0px 10px 0px;">Tickets on Eventbrite</p>
            <span style="font-weight:700; font-size:12.5px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;">View Details →</span>
          </div>
        </div>
      </a>
      <a href="<?php echo esc_url( home_url( "/event/dance-out-2023/" ) ); ?>" class="tilt-ticket" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:330px; --r:-0.6deg; transform:rotate(var(--r)); overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 90px; background:var(--crux-purple,#8C7AE6); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
          <span class="bebas" style="font-size:38px; color:var(--crux-ink2,#10142E); line-height:1;">16</span>
          <span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:var(--crux-ink2,#10142E); text-align:center;">DEC 2023</span>
        </div>
        <div style="flex:1; display:flex; flex-direction:column; min-width:0;">
          <div style="flex:1; position:relative; min-height:180px;"><img src="<?php echo crux_get_blob_url( "1d5292715423e2e83b56b3330a94b3b8" ); ?>" alt="Dance OUT 2023" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center top;"></div>
          <div style=" padding:16px 18px 18px 18px; background:#0D1330; border-top:1.5px dashed var(--crux-line,#1E2B5E);">
            <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);">Dance night</span>
            <h3 style="font-size:19px; margin:8px 0px 4px 0px; font-weight:700; color:#FFFFFF;">Dance OUT 2023</h3>
            <p style="font-size:12.5px; color:#C5CFF5; margin:0px 0px 10px 0px;">Sheffield · Late</p>
            <span style="font-weight:700; font-size:12.5px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;">View Details →</span>
          </div>
        </div>
      </a>
    </div>
  </section>

    <!-- ALSO FROM CRUX — consultancy fork -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:40px 20px 44px 20px;" data-m="nomin">
    <div style="display:grid; grid-template-columns:1fr 1fr; min-height:660px; border-radius:26px; overflow:hidden; border:1.5px solid var(--crux-line,#1E2B5E); background:var(--crux-surface,#111838);" class="reveal" data-m="g1">
      <div style=" padding:44px 50px 44px 60px; display:flex; flex-direction:column; justify-content:center;" class="reveal also-from-crux-content">
        <span class="eyebrow" style="color:#B7A6FF !important;">Also From Crux Nxtion</span>
        <h2 class="bebas" style="font-size:40px; margin:14px 0px 18px 0px; color:var(--crux-text,#F4F5FA);">GOT A BUSINESS BEHIND THE EVENT?</h2>
        <p style="font-size:16px; line-height:1.75; color:#C5CADF; max-width:480px; margin:0px 0px 26px 0px;">Crux Nxtion Consultancy turns business ideas into businesses that work. Whether you are starting from scratch, trying to grow, or need a clearer direction, we help you make smarter business moves.</p>
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:34px;">
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">01</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);">From Blueprint to Reality</span></div>
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">02</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);">Infrastructure &amp; Setup (Shop &amp; Office)</span></div>
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">03</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);">Scaling, Advisory &amp; Visas</span></div>
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">04</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);">Go-to-Market Mastery</span></div>
        </div>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink,#0A0F26); font-weight:700; font-size:15px; padding:16px 30px 16px 30px; display:inline-block; width:fit-content; --sl:10px;" class="bx">Explore Consultancy →</a>
      </div>
      <div style="position:relative; overflow:hidden;" class="reveal" data-m="tile">
        <img src="<?php echo crux_get_blob_url( "5b1a6ab37f0230a96cac807ce57c7983" ); ?>" alt="A Crux Nxtion Consultancy session" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
        <div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(27,32,72,0.85) 0%, rgba(91,141,239,0.12) 60%);"></div>



        <div style="position:absolute; left:30px; bottom:30px; right:30px; display:flex; flex-direction:column; gap:10px; z-index:2;">
          <div class="float" style="--r:0deg; align-self:flex-end; max-width:85%; background:var(--crux-line,#1E2B5E); color:var(--crux-text,#F4F5FA); font-size:13px; line-height:1.5; padding:11px 15px; border-radius:16px 16px 4px 16px;">I've got an idea. I just don't know where to start.</div>
          <div style="align-self:flex-start; max-width:85%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink,#0A0F26); font-size:13px; font-weight:600; line-height:1.5; padding:11px 15px; border-radius:16px 16px 16px 4px;">Good — that's the right place to start. Tell us about it.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- GALLERY — ticket wall (matches the Gallery page) -->
  <section id="gallery" style=" padding:30px 20px 44px 20px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;" class="reveal" data-m="stack">
      <div><span class="eyebrow">The Ticket Wall</span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-text,#F4F5FA);">GALLERY</h2><p style="font-size:15px; color:#A3A9C8; max-width:520px; margin:12px 0px 0px 0px;">Every frame, filed like a ticket — punched by the same crew.</p></div>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="font-weight:700; font-size:13px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px; white-space:nowrap;">View Full Gallery →</a>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:34px 26px; align-items:start;" class="reveal" data-m="g2">
      <a href="#" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_get_blob_url( "8779e5d9192fb628e623a9aec1f82362" ); ?>" alt="Crux Nxtion Events frame 1" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:var(--crux-navy,#002671); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;">WEDDING</span><span class="bebas" style="font-size:14px; color:#FFFFFF;">FRAME 01</span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_get_blob_url( "4170d6b6009c07e37d83bae48a68917b" ); ?>" alt="Crux Nxtion Events frame 2" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:var(--crux-red,#BA0000); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;">NIGHT OUT</span><span class="bebas" style="font-size:14px; color:#FFFFFF;">FRAME 02</span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_get_blob_url( "c5afda4fc4e4d4b0682377d6eb272c90" ); ?>" alt="Crux Nxtion Events frame 3" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:var(--crux-purple,#8C7AE6); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:var(--crux-ink,#0A0F26);">LIVE</span><span class="bebas" style="font-size:14px; color:var(--crux-ink,#0A0F26);">FRAME 03</span></div>
      </a>
    </div>
  </section>

  <!-- WHY CRUX -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:20px 20px 44px 20px;" data-m="nomin">
    <div style="text-align:center; margin-bottom:44px;" class="reveal"><span class="eyebrow">Why Crux Nxtion</span><h2 class="bebas" style="font-size:34px; margin:14px 0px 0px 0px; color:var(--crux-text,#F4F5FA);">A CREW YOU CAN TRUST WITH THE NIGHT.</h2></div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;" class="reveal" data-m="g1">
      <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:18px; overflow:hidden;" class="reveal">
        <div style="height:220px; overflow:hidden;"><img src="<?php echo crux_get_blob_url( "2fe0208788cf2d50763c85dd2a44de66" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div style=" padding:26px 28px 30px 28px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-text,#F4F5FA);">ONE CREW, START TO FINISH</h3><p style="font-size:14px; line-height:1.65; color:#A3A9C8; margin:0px 0px 0px 0px;">The people you brief are the people on the floor — no chain of subcontractors between you and your event.</p></div>
      </div>
      <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:18px; overflow:hidden;" class="reveal">
        <div style="height:220px; overflow:hidden;"><img src="<?php echo crux_get_blob_url( "6aa60ee4af0bdb49015bf4224786bd46" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div style=" padding:26px 28px 30px 28px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-text,#F4F5FA);">CULTURE-FIRST NIGHTS</h3><p style="font-size:14px; line-height:1.65; color:#A3A9C8; margin:0px 0px 0px 0px;">From Afrobeats parties to wedding showcases, we know what moves a room and keeps it moving.</p></div>
      </div>
      <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:18px; overflow:hidden;" class="reveal">
        <div style="height:220px; overflow:hidden;"><img src="<?php echo crux_get_blob_url( "a7f19688f4ec09c5590ca71c99b9f400" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div style=" padding:26px 28px 30px 28px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-text,#F4F5FA);">SHEFFIELD-ROOTED, UK-WIDE</h3><p style="font-size:14px; line-height:1.65; color:#A3A9C8; margin:0px 0px 0px 0px;">We know the city, the venues and the vendors — and we book and produce across the UK.</p></div>
      </div>
    </div>
  </section>

  <!-- PROCESS — how we run your event -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:44px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:46px;" class="reveal" data-m="stack">
      <div><span class="eyebrow">How We Run Your Event</span><h2 class="bebas" style="font-size:34px; margin:12px 0px 0px 0px; color:var(--crux-text,#F4F5FA);">FOUR STEPS. ONE CREW. NO STRESS.</h2></div>
      <p style="max-width:340px; font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;">From the first message to the last guest leaving, the same people are with you.</p>
    </div>
    <div style="position:relative; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:-1deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_get_blob_url( "7ad16fa711374cf636fa630f0cf398c0" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div class="strip-stub" style="background:var(--crux-navy,#002671); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;">STEP 01</span><span class="bebas" style="font-size:18px; color:#FFFFFF;">BRIEF</span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;">You tell us the date, the room and what you are celebrating. We ask the right questions.</p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:0.8deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_get_blob_url( "4795dc48859e2b9d81b42757c6317d14" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div class="strip-stub" style="background:var(--crux-red,#BA0000); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;">STEP 02</span><span class="bebas" style="font-size:18px; color:#FFFFFF;">DESIGN</span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;">We shape the concept, the entertainment and every vendor involved.</p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:-0.8deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_get_blob_url( "8127c7ab2af037f167d7a8b67413ab45" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div class="strip-stub" style="background:var(--crux-purple,#8C7AE6); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:var(--crux-ink,#0A0F26);">STEP 03</span><span class="bebas" style="font-size:18px; color:var(--crux-ink,#0A0F26);">PRODUCE</span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;">Staging, sound, décor and promotion — handled by one crew.</p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:1deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_get_blob_url( "f1ffd7a776c034eaead72759fb4440c6" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"></div>
        <div class="strip-stub" style="background:var(--crux-navy,#002671); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;">STEP 04</span><span class="bebas" style="font-size:18px; color:#FFFFFF;">DELIVER</span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;">We are on site through the last guest, so you can enjoy your own event.</p></div>
      </div>
    </div>
  </section>

  <!-- MINI ABOUT — centered manifesto + photo strip -->
  <section id="about" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; background:var(--crux-surface,#111838); padding:44px 20px 44px 20px; text-align:center;" data-m="nomin">
    <span class="eyebrow">Who We Are</span>
    <p class="bebas reveal" style="font-size:34px; line-height:1.08; margin:18px auto 20px; max-width:840px; color:var(--crux-text,#F4F5FA);">A CREW THAT RUNS THE ROOM ITSELF — PLANNING, STAGING, SOUND, AND EVERY VENDOR, IN-HOUSE.</p>
    <p style="font-size:14.5px; line-height:1.7; color:#A3A9C8; max-width:480px; margin:0 auto 46px;" class="reveal">Crux Nxtion Events is a UK-based events and production house, producing across the UK.</p>

    <div class="mini-about-strip reveal" style="display:flex; justify-content:center; align-items:center; gap:18px; margin-bottom:44px;">
      <img class="tilt-straighten" src="<?php echo crux_get_blob_url( "fbd294c148cb8e1a55a31856bc061a40" ); ?>" alt="" style="width:150px; height:190px; object-fit:cover; border-radius:10px; --r:-4deg; transform:rotate(var(--r)); border:2px solid var(--crux-line,#1E2B5E);">
      <img src="<?php echo crux_get_blob_url( "c5afda4fc4e4d4b0682377d6eb272c90" ); ?>" alt="" style="width:170px; height:220px; object-fit:cover; border-radius:10px; z-index:1; border:2px solid var(--crux-blue,#5B8DEF);">
      <img class="tilt-straighten" src="<?php echo crux_get_blob_url( "3f7a3d27a340e99222e15e9e60a98a7d" ); ?>" alt="" style="width:150px; height:190px; object-fit:cover; border-radius:10px; --r:4deg; transform:rotate(var(--r)); border:2px solid var(--crux-line,#1E2B5E);">
    </div>

    <div style="display:flex; gap:12px; justify-content:center;" class="reveal" data-m="wrap">
      <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12px; padding:10px 18px 10px 18px;">In-House Crew</span>
      <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12px; padding:10px 18px 10px 18px;">Full-Service</span>
      <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12px; padding:10px 18px 10px 18px;">Culturally Rooted</span>
    </div>
  </section>

    <!-- FOUNDER — Curated Best Bits for Events -->
  <section id="founder" style="padding:64px 20px; background:var(--crux-surface,#111838); display:grid; grid-template-columns:0.8fr 1.2fr; gap:60px; align-items:center;" data-m="g1">
    <div class="tilt-straighten reveal" style="--r:-2deg; transform:rotate(var(--r)); border-radius:22px; overflow:hidden; border:2px solid var(--crux-blue,#5B8DEF); height:470px;">
      <img src="<?php echo crux_get_blob_url( "a67d85c16f6df90ab7a657160bee9088" ); ?>" alt="Olabamidele 'Bambad' Badmos, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;">
    </div>
    <div class="reveal">
      <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);">Meet The Team</span>
      <h2 class="bebas" style="font-size:54px; margin:14px 0 20px; color:var(--crux-text,#F4F5FA); line-height:0.95;">ABOUT CRUX NXTION EVENTS &amp; CONSULTANCY</h2>
      <p style="font-size:16px; line-height:1.75; color:#C5CADF; max-width:620px; margin:0 0 14px;">Our dynamic operations are led by <strong>Olabamidele Badmos (Bambad)</strong>, a recognized community leader and business strategic development officer with extensive expertise in enterprise growth, marketing, and digital public relations. Backed by a dedicated team of 10 active core members and specialized staff, we combine cultural authenticity with corporate execution.</p>
      <p style="font-size:16px; line-height:1.75; color:#C5CADF; max-width:620px; margin:0 0 26px;">With an extraordinary track record spanning over <strong>70 cultural milestones activated across the United Kingdom</strong> — including <em>YAGI Awards</em>, <em>Black Award Events</em>, <em>Gangs of Lagos: Wedding Story (Parts 1 &amp; 2)</em>, <em>YAGI Trade Fair</em>, <em>Naija Food Carnival</em> (400+ attendees), and <em>Marketplace Festivals (Volumes 1 through 6)</em> — we turn visionary concepts into legendary live gatherings.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:28px;" data-m="wrap">
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;">70+ Cultural Milestones</span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;">10 Core Production Members</span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;">143+ UK Enterprises Scaled</span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;">Sheffield HQ • UK Operations</span>
      </div>
      <a href="<?php echo esc_url( home_url( "/founder/" ) ); ?>" style="background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 28px; --sl:10px;" class="bx">Read The Full Story &rarr;</a>
    </div>
  </section>

    <!-- FAQ — interactive accordion (matching FAQS page design) -->
  <section id="faq" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:65px 64px;" data-m="nomin">
    <div style="text-align:center; margin-bottom:46px;" class="reveal">
      <span class="eyebrow">Good To Know</span>
      <h2 class="bebas" style="font-size:56px; margin:14px 0 10px; color:var(--crux-text,#F4F5FA);">FREQUENTLY ASKED</h2>
      <p style="font-size:14px; color:#A3A9C8; margin:0;">Still curious? <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:var(--crux-blue,#5B8DEF); font-weight:700;">Ask us directly →</a></p>
    </div>
    <div style="max-width:960px; width:100%; margin:0 auto; display:flex; flex-direction:column; gap:14px;" class="reveal">
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);">What kinds of events do you plan and manage?</h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;">Private and corporate events, conferences, weddings, birthday parties, brand activations, concerts, festivals, charity galas, tournaments, inaugurations, workshops, trade shows, and online or hybrid events.</p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);">How far ahead should I get in touch?</h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;">As early as you can. We are booking 2026 and 2027 now, and the earlier we know the date, the more options we have for venues, talent and vendors.</p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);">Do you handle entertainment booking and talent management?</h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;">Yes. Entertainment Booking &amp; Talent Management connects you with top-tier performers, DJs, and artists, and we work directly with talent agencies.</p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);">Can you work with a venue we have already chosen?</h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;">Absolutely. Tell us the room or location and we will build all staging, acoustics, layouts, and production around it.</p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);">Do you work outside Sheffield?</h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;">Our office is at <?php echo esc_html( crux_address( false ) ); ?>. We plan and run events across the entire UK, and our on-site coordination covers destination weddings and corporate retreats as well.</p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);">Can you help promote the event and sell tickets?</h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;">Yes. Event Marketing &amp; Promotion covers social media campaigns, influencer partnerships, content marketing, SEO, listings, ticket sales via Eventbrite, and community engagement.</p>
      </details>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span>Events</span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span>Consultancy</span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
