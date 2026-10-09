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
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'blog' ) ); ?>

  <!-- PAGE HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow">Notes From The Crew</span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 14px 0px; color:var(--crux-text,#F4F5FA);">THE JOURNAL</h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:540px; margin:0px 0px 0px 0px;" class="reveal">Event recaps, planning guides and stories from the crew — filed like a ticket, punched by the same people.</p>
  </section>

  <!-- TICKET GRID -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:30px 20px 44px 20px;" data-m="nomin">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <a href="<?php echo esc_url( home_url( "/blog/behind-dance-out-2023/" ) ); ?>" class="ticket reveal" style="grid-column:span 3; display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="span tile">
        <div class="ticket-stub" style="flex:0 0 110px; background:var(--crux-navy,#002671); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:16px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;">FEATURED</span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_get_blob_url( "b094675514894aa0d8e7dd735d187b22" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(10,15,38,0.94) 0%, rgba(10,15,38,0.55) 45%, rgba(10,15,38,0.15) 100%);"></div>
        <div style="position:absolute; left:0; top:0; bottom:0; display:flex; flex-direction:column; justify-content:center; padding:36px 36px 36px 36px; max-width:580px;"><span class="eyebrow">Event Recap</span><h2 class="bebas" style="font-size:38px; margin:12px 0px 12px 0px; color:var(--crux-text,#F4F5FA);">BEHIND DANCE OUT 2023: HOW WE FILL A DANCE FLOOR</h2><p style="font-size:14px; color:#C5CFF5; line-height:1.6; margin:0px 0px 16px 0px;">A behind-the-scenes look at how one crew plans, books and runs a night built to keep people moving.</p><span style="font-weight:700; font-size:12.5px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px; width:fit-content;">Read The Story →</span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/planning-a-nigerian-wedding-party-in-the-uk/" ) ); ?>" class="ticket reveal" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:var(--crux-red,#BA0000); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;">GUIDES</span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_get_blob_url( "feb81852032e2798160126ebf0d3c7f6" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow">Guides</span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:var(--crux-text,#F4F5FA);">Planning A Nigerian Wedding Party In The UK</h3><span style="font-size:11.5px; color:#C5CFF5;">7 min read</span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/what-entertainment-booking-really-involves/" ) ); ?>" class="ticket reveal" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:var(--crux-purple,#8C7AE6); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:var(--crux-ink,#0A0F26); writing-mode:vertical-rl; letter-spacing:2px;">NOTES</span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_get_blob_url( "2fe0208788cf2d50763c85dd2a44de66" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow">Behind The Scenes</span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:var(--crux-text,#F4F5FA);">What Entertainment Booking Really Involves</h3><span style="font-size:11.5px; color:#C5CFF5;">6 min read</span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/how-far-ahead-should-you-book-your-event/" ) ); ?>" class="ticket reveal" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:var(--crux-navy,#002671); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;">GUIDES</span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_get_blob_url( "1d5292715423e2e83b56b3330a94b3b8" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow">Guides</span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:var(--crux-text,#F4F5FA);">How Far Ahead Should You Book Your Event?</h3><span style="font-size:11.5px; color:#C5CFF5;">5 min read</span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/from-events-crew-to-consultancy/" ) ); ?>" class="ticket reveal" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:var(--crux-red,#BA0000); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;">STORY</span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_get_blob_url( "c5afda4fc4e4d4b0682377d6eb272c90" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow">Our Story</span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:var(--crux-text,#F4F5FA);">From Events Crew To Consultancy: Why We Started</h3><span style="font-size:11.5px; color:#C5CFF5;">8 min read</span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/ankara-festival-in-photos/" ) ); ?>" class="ticket reveal" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:var(--crux-purple,#8C7AE6); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:var(--crux-ink,#0A0F26); writing-mode:vertical-rl; letter-spacing:2px;">RECAP</span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_get_blob_url( "99a3c292f4b3a38d253144801b4a9ae3" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow">Event Recap</span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:var(--crux-text,#F4F5FA);">Ankara Festival, In Photos</h3><span style="font-size:11.5px; color:#C5CFF5;">4 min read</span></div></div>
      </a>
      <div style="grid-column:span 3; display:flex; align-items:center; justify-content:space-between; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; padding:32px 36px 32px 36px;" class="reveal" data-m="span"><div><span class="eyebrow">Have A Story We Should Cover?</span><h3 class="bebas" style="font-size:28px; margin:10px 0px 0px 0px; color:var(--crux-text,#F4F5FA);">SEND US A NOTE</h3></div><a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:13.5px; padding:14px 26px 14px 26px; --sl:10px;" class="bx">Get In Touch</a></div>
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
