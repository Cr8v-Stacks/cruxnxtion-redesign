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
<?php crux_use_page_css( 'contact' ); get_header( null, array( 'body_bg' => '#FFFFFF', 'root_bg' => '#FFFFFF', 'skin' => 'light', 'nav' => 'events', 'wing' => 'events', 'active' => 'contact' ) ); ?>

  <!-- 1 CONTACT -->
  <section style="min-height:860px; display:grid; grid-template-columns:1fr 1fr;">
    <div style="padding:80px 64px;" class="reveal">
      <span class="eyebrow"<?php echo crux_edit_attr( 'contact', 'contact_small_heading_1' ); ?>><?php echo crux_h( 'contact', 'contact_small_heading_1' ); ?></span>
      <h1 class="bebas" style="font-size:72px; margin:14px 0 26px; color:#10142E;"<?php echo crux_edit_attr( 'contact', 'contact_heading_1' ); ?>><?php echo crux_h( 'contact', 'contact_heading_1' ); ?></h1>
      <!-- INTAKE TABS (Slanted .bx - Click multiple to brief all together) -->
      <div class="contact-mode-tabs" id="contact-mode-tabs" role="tablist">
        <button type="button" class="contact-tab-btn bx active" data-tab="events" role="tab" aria-selected="true"<?php echo crux_edit_attr( 'contact', 'contact_button_1' ); ?>><?php echo crux_h( 'contact', 'contact_button_1' ); ?></button>
        <button type="button" class="contact-tab-btn bx" data-tab="consultancy" role="tab" aria-selected="false">Business Strategy</button>
        <button type="button" class="contact-tab-btn bx" data-tab="partner" role="tab" aria-selected="false">Sponsorship &amp; Partnership</button>
      </div>

      <form id="crux-intake-form" onsubmit="event.preventDefault(); return false;" style="display:flex; flex-direction:column; gap:16px; max-width:560px;">
        <input type="hidden" name="inquiry_type" id="inquiry_type" value="events">
        <input type="hidden" name="form_timestamp" value="<?php echo time(); ?>">
        <div id="hidden-services-inputs"></div>
        <div style="display:none;"><input type="text" name="crux_hp" value=""></div>

        <!-- Alert messages box -->
        <div id="contact-alert-box" style="display:none; padding:14px 18px; border-radius:12px; font-size:14px; font-weight:600; line-height:1.5;"></div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" data-m="g1">
          <div>
            <input type="text" name="name" id="inp-name" required placeholder="Your full name *" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
          <div>
            <input type="email" name="email" id="inp-email" required placeholder="Email address *" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <input type="tel" name="phone" id="inp-phone" placeholder="Phone number (optional)" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">

        <!-- Dynamic Service Chips Section -->
        <div>
          <div id="chips-section-title" style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#5A5F86; margin-bottom:12px;">
            What do you need help with? <span style="text-transform:none; letter-spacing:0; font-weight:500;">Select any that fit:</span>
          </div>

          <!-- Group 1: Events Chips -->
          <div id="chips-group-events" class="chips-group" style="display:flex; gap:9px; flex-wrap:wrap;">
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Event planning" aria-pressed="false"><span class="chip-icon">✓</span><span>Event planning</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Entertainment & talent" aria-pressed="false"><span class="chip-icon">✓</span><span>Entertainment &amp; talent</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Design & production" aria-pressed="false"><span class="chip-icon">✓</span><span>Design &amp; production</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Marketing & promotion" aria-pressed="false"><span class="chip-icon">✓</span><span>Marketing &amp; promotion</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="On-site coordination" aria-pressed="false"><span class="chip-icon">✓</span><span>On-site coordination</span></button>
          </div>

          <!-- Group 2: Consultancy Chips -->
          <div id="chips-group-consultancy" class="chips-group" style="display:none; gap:9px; flex-wrap:wrap;">
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Business setup & strategy" aria-pressed="false"><span class="chip-icon">✓</span><span>Business setup &amp; strategy</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Branding & marketing" aria-pressed="false"><span class="chip-icon">✓</span><span>Branding &amp; marketing</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Business growth" aria-pressed="false"><span class="chip-icon">✓</span><span>Business growth</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Activation growth" aria-pressed="false"><span class="chip-icon">✓</span><span>Activation growth</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Audit & advisory" aria-pressed="false"><span class="chip-icon">✓</span><span>Audit &amp; advisory</span></button>
          </div>

          <!-- Group 3: Partner Chips -->
          <div id="chips-group-partner" class="chips-group" style="display:none; gap:9px; flex-wrap:wrap;">
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Event sponsorship" aria-pressed="false"><span class="chip-icon">✓</span><span>Event sponsorship</span></button>
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Brand activation partner" aria-pressed="false"><span class="chip-icon">✓</span><span>Brand activation partner</span></button>
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Vendor & catering partner" aria-pressed="false"><span class="chip-icon">✓</span><span>Vendor &amp; catering partner</span></button>
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Media & talent collaboration" aria-pressed="false"><span class="chip-icon">✓</span><span>Media &amp; talent collaboration</span></button>
          </div>
        </div>

        <!-- Panel 1: Event Details -->
        <div id="panel-event-details" class="intake-panel" style="display:flex; flex-direction:column; gap:12px; padding:20px; border:1.5px solid #D6DDF3; clip-path:polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%); background:#F6F8FE;">
          <span class="bx" style="display:inline-block; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; background:#002671; padding:4px 12px; width:fit-content; --sl:5px;">About your event</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="ev_type" placeholder="Event type (wedding, gala, party...)" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="ev_date" placeholder="Preferred date / month" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="ev_guests" placeholder="Approx. number of guests" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="ev_venue" placeholder="City or prospective venue" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <!-- Panel 2: Business Details -->
        <div id="panel-business-details" class="intake-panel" style="display:none; flex-direction:column; gap:12px; padding:20px; border:1.5px solid #E1DEF3; clip-path:polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%); background:#F7F5FE;">
          <span class="bx" style="display:inline-block; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#10142E; background:#8C7AE6; padding:4px 12px; width:fit-content; --sl:5px;">About your business</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="biz_name" placeholder="Business name (if trading)" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="biz_stage" placeholder="Stage: idea / trading / scaling" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <!-- Panel 3: Partnership Details -->
        <div id="panel-partner-details" class="intake-panel" style="display:none; flex-direction:column; gap:12px; padding:20px; border:1.5px solid #F5C6C6; clip-path:polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%); background:#FFF7F7;">
          <span class="bx" style="display:inline-block; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; background:#BA0000; padding:4px 12px; width:fit-content; --sl:5px;">Sponsorship &amp; Collaboration</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="partner_company" placeholder="Brand / Organization name" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="partner_interest" placeholder="Interest: Sponsor / Vendor / Co-Host" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <textarea name="message" id="inp-message" rows="4" placeholder="Tell us what you have in mind, where you are stuck, or what you would like to achieve." style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;"></textarea>
        
        <p id="route-note-label" class="routeNote" style="font-size:12.5px; color:#5A5F86; margin:0; line-height:1.5;">
          Direct connection: This goes straight to our events crew. We respond within 24 business hours.
        </p>

        <button type="button" id="btn-submit-brief" style="display:flex; align-items:center; justify-content:center; text-align:center; background:#002671; color:#FFFFFF; font-weight:700; font-size:15px; padding:17px; margin-top:6px; --sl:10px; cursor:pointer; width:100%;" class="bx">Submit</button>
      </form>

      <!-- CONTACT CONFIRMATION POPUP MODAL (Executive Dialog) -->
      <div id="contact-confirmation-modal" class="crux-modal-backdrop" style="display:none; position:fixed; inset:0; z-index:100000; background:rgba(10,15,38,0.85); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); align-items:center; justify-content:center; padding:20px; box-sizing:border-box;">
        <div class="crux-modal-card" style="background:#FFFFFF; border:2px solid #002671; border-radius:18px; max-width:540px; width:100%; padding:44px 36px 40px; text-align:center; position:relative; box-shadow:0 30px 80px rgba(0,38,113,0.35); box-sizing:border-box;">
          
          <!-- Close icon button -->
          <button type="button" id="btn-modal-close" style="position:absolute; top:18px; right:18px; width:36px; height:36px; border-radius:50%; background:#F3F1FC; border:1px solid #D2CEEA; color:#10142E; font-size:22px; line-height:1; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:transform .2s ease, background .2s ease;" aria-label="Close dialog">&times;</button>
          
          <!-- Animated SVG Success Badge -->
          <div style="width:76px; height:76px; margin:0 auto 20px; display:flex; align-items:center; justify-content:center;">
            <svg class="crux-modal-check-svg" width="76" height="76" viewBox="0 0 76 76" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="38" cy="38" r="35" stroke="#27AE60" stroke-width="4" stroke-linecap="round" class="crux-circle-animate" style="stroke-dasharray: 220; stroke-dashoffset: 0; animation: strokeCircle 0.6s ease forwards; fill: rgba(39,174,96,0.08);"/>
              <path d="M23 38.5L33 48.5L53 28.5" stroke="#27AE60" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" class="crux-check-animate" style="stroke-dasharray: 50; stroke-dashoffset: 0; animation: strokeCheck 0.4s ease 0.45s forwards;"/>
            </svg>
          </div>

          <h2 class="bebas" style="font-size:42px; color:#10142E; margin:0 0 10px; letter-spacing:0.5px; line-height:0.95;"<?php echo crux_edit_attr( 'contact', 'contact_heading_2' ); ?>><?php echo crux_h( 'contact', 'contact_heading_2' ); ?></h2>
          
          <div id="confirm-summary-badge" class="bx" style="display:inline-block; background:#E8EFFD; --sl:6px; --bc:#C4D3F8; padding:8px 20px; font-size:12.5px; font-weight:700; color:#002671; margin-bottom:18px;"<?php echo crux_edit_attr( 'contact', 'contact_text_1' ); ?>><?php echo crux_h( 'contact', 'contact_text_1' ); ?></div>

          <p id="confirm-msg-body" style="font-size:15px; line-height:1.65; color:#3A3F66; margin:0 0 28px;"<?php echo crux_edit_attr( 'contact', 'contact_paragraph_1' ); ?>><?php echo crux_h( 'contact', 'contact_paragraph_1' ); ?></p>
          
          <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
            <a href="<?php echo esc_url( crux_opt( 'calendly_url' ) ); ?>" id="btn-modal-calendly" target="_blank" rel="noopener" style="display:none; background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:13.5px; padding:13px 22px; --sl:8px; text-decoration:none;" class="bx"<?php echo crux_edit_attr( 'contact', 'contact_button_2' ); ?>><?php echo crux_h( 'contact', 'contact_button_2' ); ?></a>
            <button type="button" id="btn-modal-done" style="background:#002671; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:13px 26px; --sl:8px; cursor:pointer;" class="bx"<?php echo crux_edit_attr( 'contact', 'contact_button_3' ); ?>><?php echo crux_h( 'contact', 'contact_button_3' ); ?></button>
            <button type="button" id="btn-modal-reset" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:13.5px; padding:13px 24px; --sl:8px; cursor:pointer;" class="bx"<?php echo crux_edit_attr( 'contact', 'contact_button_4' ); ?>><?php echo crux_h( 'contact', 'contact_button_4' ); ?></button>
          </div>

        </div>
      </div>
    </div>
    <div style="position:relative; overflow:hidden;" class="reveal">
      <img src="<?php echo crux_img_url( 'contact', 'contact_photo_1' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;" class="drift"<?php echo crux_edit_attr( 'contact', 'contact_photo_1' ); ?>>
      <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.92) 0%, rgba(16,20,46,0.25) 70%);"></div>
      <div style="position:relative; height:100%; display:flex; flex-direction:column; justify-content:flex-end; padding:56px; gap:12px;">
        <div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">✆</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;"><?php echo esc_html( crux_opt( 'phone_events' ) ); ?></span></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">✆</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;"><?php echo esc_html( crux_opt( 'phone_consult' ) ); ?></span></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">@</span><?php $c_mail = crux_opt( 'email' ); ?><a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; font-weight:600; color:#F2F1F8; text-decoration:none;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">●</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;"><?php echo esc_html( crux_address( false ) ); ?></span></div>
        <a href="#" style="color:#F2F1F8; font-weight:700; font-size:13px; border-bottom:1.5px solid #8C7AE6; padding-bottom:2px; width:fit-content; margin-top:6px;"<?php echo crux_edit_attr( 'contact', 'contact_link_1' ); ?>><?php echo crux_h( 'contact', 'contact_link_1' ); ?></a>
      </div>
    </div>
  </section>

  <!-- 2 NEXT -->
  <section style="min-height:640px; padding:100px 64px; background:#F3F1FC;">
    <div style="text-align:center; margin-bottom:50px;" class="reveal"><span class="eyebrow"<?php echo crux_edit_attr( 'contact', 'next_small_heading_1' ); ?>><?php echo crux_h( 'contact', 'next_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:56px; margin:12px 0 0; color:#10142E;"<?php echo crux_edit_attr( 'contact', 'next_heading_1' ); ?>><?php echo crux_h( 'contact', 'next_heading_1' ); ?></h2></div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:20px;" class="reveal"><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">01</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;"<?php echo crux_edit_attr( 'contact', 'next_heading_2' ); ?>><?php echo crux_h( 'contact', 'next_heading_2' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;"<?php echo crux_edit_attr( 'contact', 'next_paragraph_1' ); ?>><?php echo crux_h( 'contact', 'next_paragraph_1' ); ?></p></div></div><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">02</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;"<?php echo crux_edit_attr( 'contact', 'next_heading_3' ); ?>><?php echo crux_h( 'contact', 'next_heading_3' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;"<?php echo crux_edit_attr( 'contact', 'next_paragraph_2' ); ?>><?php echo crux_h( 'contact', 'next_paragraph_2' ); ?></p></div></div><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">03</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;"<?php echo crux_edit_attr( 'contact', 'next_heading_4' ); ?>><?php echo crux_h( 'contact', 'next_heading_4' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;"<?php echo crux_edit_attr( 'contact', 'next_paragraph_3' ); ?>><?php echo crux_h( 'contact', 'next_paragraph_3' ); ?></p></div></div></div>
  </section>


  <div style="background:#10142E;">
  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'light', 'prefooter' => 'events-light', 'wing' => 'events', 'pad' => '90px 24px 44px' ) ); ?>
  </div>

</div>





<script>
(function() {
  function initCruxContactEngine() {
    var tabsContainer = document.getElementById('contact-mode-tabs');
    var contactForm = document.getElementById('crux-intake-form');
    if (!tabsContainer || !contactForm) return;
    if (contactForm.getAttribute('data-engine-ready') === 'true') return;
    contactForm.setAttribute('data-engine-ready', 'true');

    var tabButtons = tabsContainer.querySelectorAll('.contact-tab-btn');
    var groupEvents = document.getElementById('chips-group-events');
    var groupConsultancy = document.getElementById('chips-group-consultancy');
    var groupPartner = document.getElementById('chips-group-partner');

    var panelEvents = document.getElementById('panel-event-details');
    var panelConsultancy = document.getElementById('panel-business-details');
    var panelPartner = document.getElementById('panel-partner-details');

    var typeInput = document.getElementById('inquiry_type');
    var hiddenServices = document.getElementById('hidden-services-inputs');
    var routeNote = document.getElementById('route-note-label');
    var submitBtn = document.getElementById('btn-submit-brief');
    var confirmModal = document.getElementById('contact-confirmation-modal');
    var confirmBadge = document.getElementById('confirm-summary-badge');
    var confirmBody = document.getElementById('confirm-msg-body');
    var modalCloseBtn = document.getElementById('btn-modal-close');
    var modalDoneBtn = document.getElementById('btn-modal-done');
    var modalResetBtn = document.getElementById('btn-modal-reset');

    var nameInput = document.getElementById('inp-name');
    var emailInput = document.getElementById('inp-email');
    var alertBox = document.getElementById('contact-alert-box');

    // Tab brief state: array of selected wings (allows clean switching and multi-service selection)
    var activeTabs = ['events'];

    function updateTabsUI() {
      // 1. Update tab buttons
      tabButtons.forEach(function(btn) {
        var t = btn.getAttribute('data-tab');
        if (activeTabs.indexOf(t) !== -1) {
          btn.classList.add('active');
          btn.setAttribute('aria-selected', 'true');
        } else {
          btn.classList.remove('active');
          btn.setAttribute('aria-selected', 'false');
        }
      });

      // 2. Show/Hide chip groups
      var hasEvents = activeTabs.indexOf('events') !== -1;
      var hasConsultancy = activeTabs.indexOf('consultancy') !== -1;
      var hasPartner = activeTabs.indexOf('partner') !== -1;

      if (groupEvents) groupEvents.style.display = hasEvents ? 'flex' : 'none';
      if (groupConsultancy) groupConsultancy.style.display = hasConsultancy ? 'flex' : 'none';
      if (groupPartner) groupPartner.style.display = hasPartner ? 'flex' : 'none';

      // 3. Show/Hide detail panels
      if (panelEvents) panelEvents.style.display = hasEvents ? 'flex' : 'none';
      if (panelConsultancy) panelConsultancy.style.display = hasConsultancy ? 'flex' : 'none';
      if (panelPartner) panelPartner.style.display = hasPartner ? 'flex' : 'none';

      // 4. Update route note & button styling
      if (activeTabs.length === 3) {
        if (routeNote) routeNote.textContent = 'Direct connection: Your multi-wing brief will be transmitted directly to our events, business consultancy, and partnership teams. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasEvents && hasConsultancy) {
        if (routeNote) routeNote.textContent = 'Direct connection: This brief connects directly with both our events and business strategy leads. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasEvents && hasPartner) {
        if (routeNote) routeNote.textContent = 'Direct connection: This brief connects directly with our events and partnership leads. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasConsultancy && hasPartner) {
        if (routeNote) routeNote.textContent = 'Direct connection: This brief connects directly with our business consultancy and partnership leads. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#8C7AE6';
          submitBtn.style.color = '#10142E';
        }
      } else if (hasEvents) {
        if (routeNote) routeNote.textContent = 'Direct connection: This goes straight to our events crew. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasConsultancy) {
        if (routeNote) routeNote.textContent = 'Direct connection: This goes straight to our consultancy & business advisory team. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#8C7AE6';
          submitBtn.style.color = '#10142E';
        }
      } else if (hasPartner) {
        if (routeNote) routeNote.textContent = 'Direct connection: This goes straight to our executive partnerships & sponsorship team. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#BA0000';
          submitBtn.style.color = '#FFFFFF';
        }
      }

      // Ensure button text is strictly Submit
      if (submitBtn && submitBtn.textContent !== 'Submitting...') {
        submitBtn.textContent = 'Submit';
      }

      syncServicesAndTabsInputs();
    }

    function selectTab(tabName) {
      activeTabs = [tabName];
      updateTabsUI();
    }

    function syncServicesAndTabsInputs() {
      if (!hiddenServices) return;
      hiddenServices.innerHTML = '';

      // Determine active wings based on active tabs, selected chips, and filled fields
      var effectiveTabs = [].concat(activeTabs);
      var allSelectedChips = document.querySelectorAll('.chip-btn.selected');

      allSelectedChips.forEach(function(chip) {
        var cat = chip.getAttribute('data-cat');
        if (cat === 'e' && effectiveTabs.indexOf('events') === -1) effectiveTabs.push('events');
        if (cat === 'c' && effectiveTabs.indexOf('consultancy') === -1) effectiveTabs.push('consultancy');
        if (cat === 'p' && effectiveTabs.indexOf('partner') === -1) effectiveTabs.push('partner');
      });

      // 1. Synchronize selected_tabs[]
      effectiveTabs.forEach(function(t) {
        var tInput = document.createElement('input');
        tInput.type = 'hidden';
        tInput.name = 'selected_tabs[]';
        tInput.value = t;
        hiddenServices.appendChild(tInput);
      });

      // 2. Synchronize inquiry_type
      if (typeInput) {
        if (effectiveTabs.length === 3) {
          typeInput.value = 'all';
        } else if (effectiveTabs.length === 2) {
          if (effectiveTabs.indexOf('events') !== -1 && effectiveTabs.indexOf('consultancy') !== -1) {
            typeInput.value = 'both';
          } else {
            typeInput.value = effectiveTabs.join(',');
          }
        } else {
          typeInput.value = effectiveTabs[0] || 'events';
        }
      }

      // 3. Synchronize service chips across ALL groups
      allSelectedChips.forEach(function(chip) {
        var sName = chip.getAttribute('data-name');
        if (sName) {
          var sInput = document.createElement('input');
          sInput.type = 'hidden';
          sInput.name = 'services[]';
          sInput.value = sName;
          hiddenServices.appendChild(sInput);
        }
      });
    }

    // Tab buttons click handler (switch active wing)
    tabButtons.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var tab = this.getAttribute('data-tab');
        if (tab) selectTab(tab);
      });
    });

    // Chip click handlers (multi-select)
    var allChips = document.querySelectorAll('.chip-btn');
    allChips.forEach(function(chip) {
      chip.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.toggle('selected');
        this.setAttribute('aria-pressed', this.classList.contains('selected') ? 'true' : 'false');
        syncServicesAndTabsInputs();
      });
    });

    // Handle initial state from URL query or hash
    var searchParams = new URLSearchParams(window.location.search);
    var qType = (searchParams.get('type') || '').toLowerCase();
    var hash = (window.location.hash || '').toLowerCase();

    if (qType === 'consultancy' || qType === 'business' || hash.indexOf('consultancy') !== -1 || hash.indexOf('business') !== -1) {
      activeTabs = ['consultancy'];
    } else if (qType === 'partner' || qType === 'sponsorship' || qType === 'sponsor' || hash.indexOf('partner') !== -1 || hash.indexOf('sponsor') !== -1) {
      activeTabs = ['partner'];
    } else {
      activeTabs = ['events'];
    }
    updateTabsUI();

    function showAlert(msg, isError) {
      if (!alertBox) return;
      alertBox.textContent = msg;
      alertBox.style.display = 'block';
      if (isError) {
        alertBox.style.background = '#FFF0F0';
        alertBox.style.border = '1.5px solid #E5383B';
        alertBox.style.color = '#BA0000';
      } else {
        alertBox.style.background = '#E8F8F0';
        alertBox.style.border = '1.5px solid #27AE60';
        alertBox.style.color = '#10142E';
      }
      alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideAlert() {
      if (alertBox) alertBox.style.display = 'none';
    }

    function triggerShake(el) {
      if (!el) return;
      el.classList.add('input-error-shake');
      setTimeout(function() {
        el.classList.remove('input-error-shake');
      }, 500);
      el.focus();
    }

    // Submit handler
    function doSubmit() {
      hideAlert();

      if (!nameInput || !nameInput.value.trim()) {
        showAlert('Please provide your name so we know who to address.', true);
        triggerShake(nameInput);
        return;
      }

      if (!emailInput || !emailInput.value.trim() || !emailInput.value.includes('@')) {
        showAlert('Please provide a valid email address so we can reply to you.', true);
        triggerShake(emailInput);
        return;
      }

      // Check honeypot
      var hp = contactForm.querySelector('input[name="crux_hp"]');
      if (hp && hp.value.trim()) {
        return; // Spambot silently ignored
      }

      // Loading state
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.pointerEvents = 'none';
        submitBtn.style.opacity = '0.75';
        var isDarkText = (activeTabs.length === 1 && activeTabs[0] === 'consultancy');
        var spinnerClass = isDarkText ? 'crux-spinner crux-spinner--dark' : 'crux-spinner';
        submitBtn.innerHTML = '<span class="' + spinnerClass + '"></span> Submitting...';
      }

      syncServicesAndTabsInputs();

      var formData = new FormData(contactForm);
      formData.append('action', 'crux_submit_inquiry');
      if (window.crux_ajax_obj && window.crux_ajax_obj.nonce) {
        formData.append('security', window.crux_ajax_obj.nonce);
      }

      var ajaxUrl = (window.crux_ajax_obj && window.crux_ajax_obj.ajax_url) ? window.crux_ajax_obj.ajax_url : '/wp-admin/admin-ajax.php';

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      })
      .then(function(res) {
        return res.json();
      })
      .then(function(data) {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.style.pointerEvents = 'auto';
          submitBtn.style.opacity = '1';
          submitBtn.innerHTML = 'Submit';
        }

        if (data && data.success) {
          // Keep form accessible in background, open popup modal
          if (confirmBadge) {
            if (activeTabs.length === 3) {
              confirmBadge.textContent = 'All Wings Brief (Events, Consultancy & Partnership)';
              confirmBadge.style.color = '#FFFFFF';
              confirmBadge.style.background = '#002671';
              confirmBadge.style.borderColor = '#002671';
            } else if (activeTabs.length === 2) {
              if (activeTabs.indexOf('events') !== -1 && activeTabs.indexOf('consultancy') !== -1) {
                confirmBadge.textContent = 'Events & Consultancy Brief';
                confirmBadge.style.color = '#FFFFFF';
                confirmBadge.style.background = '#002671';
              } else if (activeTabs.indexOf('events') !== -1 && activeTabs.indexOf('partner') !== -1) {
                confirmBadge.textContent = 'Events & Partnership Brief';
                confirmBadge.style.color = '#FFFFFF';
                confirmBadge.style.background = '#002671';
              } else {
                confirmBadge.textContent = 'Consultancy & Partnership Brief';
                confirmBadge.style.color = '#10142E';
                confirmBadge.style.background = '#8C7AE6';
              }
            } else if (activeTabs[0] === 'consultancy') {
              confirmBadge.textContent = 'Business Strategy Inquiry';
              confirmBadge.style.color = '#10142E';
              confirmBadge.style.background = '#8C7AE6';
              confirmBadge.style.borderColor = '#D5CEFA';
            } else if (activeTabs[0] === 'partner') {
              confirmBadge.textContent = 'Sponsorship & Partnership Inquiry';
              confirmBadge.style.color = '#FFFFFF';
              confirmBadge.style.background = '#BA0000';
              confirmBadge.style.borderColor = '#F5C6C6';
            } else {
              confirmBadge.textContent = 'Event Planning Inquiry';
              confirmBadge.style.color = '#FFFFFF';
              confirmBadge.style.background = '#002671';
              confirmBadge.style.borderColor = '#C4D3F8';
            }
          }

          if (confirmBody && data.data && data.data.message) {
            confirmBody.textContent = data.data.message;
          }

          var modalCalBtn = document.getElementById('btn-modal-calendly');
          if (modalCalBtn) {
            modalCalBtn.style.display = (activeTabs.indexOf('consultancy') !== -1 || activeTabs.length === 3) ? 'inline-block' : 'none';
          }

          if (confirmModal) {
            confirmModal.style.display = 'flex';
          }
        } else {
          var err = (data && data.data && data.data.message) ? data.data.message : 'Error submitting inquiry. Please try again or email <?php echo esc_js( crux_opt( 'email' ) ); ?> directly.';
          showAlert(err, true);
        }
      })
      .catch(function(err) {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.style.pointerEvents = 'auto';
          submitBtn.style.opacity = '1';
          submitBtn.innerHTML = 'Submit';
        }
        showAlert('Could not connect to server. Please try again or email us directly at <?php echo esc_js( crux_opt( 'email' ) ); ?>.', true);
      });
    }

    if (submitBtn) {
      submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        doSubmit();
      });
    }

    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      e.stopPropagation();
      doSubmit();
    });

    // Modal Control Functions
    function closeModal() {
      if (confirmModal) confirmModal.style.display = 'none';
    }

    function resetFormState() {
      contactForm.reset();
      allChips.forEach(function(c) {
        c.classList.remove('selected');
        c.setAttribute('aria-pressed', 'false');
      });
      activeTabs = ['events'];
      updateTabsUI();
      syncServicesAndTabsInputs();
      closeModal();
      tabsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    if (modalCloseBtn) {
      modalCloseBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closeModal();
      });
    }

    if (modalDoneBtn) {
      modalDoneBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closeModal();
      });
    }

    if (modalResetBtn) {
      modalResetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        resetFormState();
      });
    }

    if (confirmModal) {
      confirmModal.addEventListener('click', function(e) {
        if (e.target === confirmModal) {
          closeModal();
        }
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCruxContactEngine);
  } else {
    initCruxContactEngine();
  }
})();
</script>

<!-- BOTTOM STICKY CONSULTANCY BOOKING BUTTON -->
<div class="contact-sticky-booking" id="contact-sticky-booking">
  <div class="crux-sw-pod crux-sw-pod--light" style="pointer-events:auto; margin:0 auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #C4BAEE 0%, #8C7AE6 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(16,20,46,0.28); filter:drop-shadow(0 6px 16px rgba(16,20,46,0.18));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#10142E; padding:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( crux_opt( 'calendly_url' ) ); ?>" target="_blank" rel="noopener" class="contact-sticky-booking-btn" style="display:inline-flex; align-items:center; justify-content:center; gap:10px; padding:11px 22px; font-family:'Space Grotesk',system-ui,sans-serif; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#8C7AE6; color:#10142E; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 10px rgba(140,122,230,0.45); transition:all .2s ease;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#10142E" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; flex-shrink:0;">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
          <line x1="16" y1="2" x2="16" y2="6"></line>
          <line x1="8" y1="2" x2="8" y2="6"></line>
          <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <span style="font-weight:800; letter-spacing:0.4px;"<?php echo crux_edit_attr( 'contact', 'bottom_sticky_consultancy_bo_text_1' ); ?>><?php echo crux_h( 'contact', 'bottom_sticky_consultancy_bo_text_1' ); ?></span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10142E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; flex-shrink:0;">
          <line x1="5" y1="12" x2="19" y2="12"></line>
          <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
      </a>
    </div>
  </div>
</div>

<?php get_footer(); ?>
