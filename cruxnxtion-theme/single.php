<?php
/**
 * Template Name: Single Blog Template
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_catalog = array(
    'behind-dance-out-2023' => array(
        'title' => 'BEHIND DANCE OUT 2023: HOW WE FILL A DANCE FLOOR',
        'category' => 'EVENT RECAP',
        'read_time' => '9 min read',
        'hero_img' => 'b094675514894aa0d8e7dd735d187b22',
        'points' => array(
            array('num' => '1.', 'title' => 'START WITH THE CROWD', 'text' => 'Before the venue, the lineup or the lighting, decide who the night is for. Everything else follows from that answer.'),
            array('num' => '2.', 'title' => 'BOOK FOR THE ROOM', 'text' => 'A great DJ in the wrong room is a wasted booking. We match entertainment to the space, the time of night and the energy we want on the floor.'),
            array('num' => '3.', 'title' => 'KEEP THE ENERGY MOVING', 'text' => 'Gaps kill a dance floor. We plan the run of show so the music, the hosts and the breaks build rather than interrupt.'),
            array('num' => '4.', 'title' => 'BE ON THE FLOOR', 'text' => 'The best fixes happen in the moment. That is why the crew that planned the night is the crew standing in the room.')
        ),
        'quote' => 'A NIGHT LIKE THIS IS PLANNED IN THE DETAILS NOBODY NOTICES.'
    ),
    'planning-a-nigerian-wedding-party-in-the-uk' => array(
        'title' => 'PLANNING A NIGERIAN WEDDING PARTY IN THE UK',
        'category' => 'GUIDES',
        'read_time' => '7 min read',
        'hero_img' => '2f9f2834d9f0829e887b03bccc208656',
        'points' => array(
            array('num' => '1.', 'title' => 'BALANCE TRADITION & UK VENUE CURFEWS', 'text' => 'Cultural celebrations require careful timing. Securing venues that permit traditional catering, live bands, and late sound hours is the first priority.'),
            array('num' => '2.', 'title' => 'THE DUAL RUN OF SHOW', 'text' => 'Seamless transitions from the solemn ceremony and family entrances to the all-out high-energy reception keep guests energized throughout the day.'),
            array('num' => '3.', 'title' => 'VENDORS WHO UNDERSTAND THE CULTURE', 'text' => 'From MCs who command the crowd to photographers who capture the colors and live drummers, cultural synergy makes all the difference.'),
            array('num' => '4.', 'title' => 'ON-SITE GUEST CARE', 'text' => 'With extended families traveling from across the globe, attentive VIP hospitality and floor coordination ensure zero friction on the big day.')
        ),
        'quote' => 'A WEDDING SHOULD FEEL LIKE A LANDMARK CELEBRATION, NOT A LOGISTICS STRESS TEST.'
    ),
    'what-entertainment-booking-really-involves' => array(
        'title' => 'WHAT ENTERTAINMENT BOOKING REALLY INVOLVES',
        'category' => 'BEHIND THE SCENES',
        'read_time' => '6 min read',
        'hero_img' => '4795dc48859e2b9d81b42757c6317d14',
        'points' => array(
            array('num' => '1.', 'title' => 'DIRECT ARTIST & AGENCY ACCESS', 'text' => 'Navigating talent riders, performance contracts, travel logistics, and technical specifications requires established industry relationships.'),
            array('num' => '2.', 'title' => 'AV & SOUND COMPLIANCE', 'text' => 'Headline acts require specific sound setups and monitor engineers. Getting the audio rig calibrated in advance avoids embarrassing showstoppers.'),
            array('num' => '3.', 'title' => 'CONTINGENCY MANAGEMENT', 'text' => 'Travel delays, flight cancellations, and equipment failures happen. Professional booking means having real-time contingencies ready.')
        ),
        'quote' => 'TALENT BRINGS THE CROWD, BUT PRODUCTION KEEPS THEM TALKING.'
    ),
    'how-far-ahead-should-you-book-your-event' => array(
        'title' => 'HOW FAR AHEAD SHOULD YOU BOOK YOUR EVENT?',
        'category' => 'GUIDES',
        'read_time' => '5 min read',
        'hero_img' => '5d2ff88df9e44a1a073b23c7eb8ac29d',
        'points' => array(
            array('num' => '1.', 'title' => 'PEAK UK CALENDAR DATES', 'text' => 'Summer dates, bank holiday weekends, and December galas fill up over 8 to 12 months in advance across major UK cities.'),
            array('num' => '2.', 'title' => 'LICENSING & PERMITS LEAD TIME', 'text' => 'Applying for Temporary Event Notices (TENs) or council clearances requires minimum statutory notice periods.'),
            array('num' => '3.', 'title' => 'MARKETING WINDOWS FOR TICKET SALES', 'text' => 'To sell out a ticketed experience, allowing an 8 to 12 week promotion window ensures early-bird momentum and viral hype.')
        ),
        'quote' => 'TIME IS THE GREATEST LEVERAGE IN EVENT PRODUCTION.'
    ),
    'from-events-crew-to-consultancy' => array(
        'title' => 'FROM EVENTS CREW TO CONSULTANCY: WHY WE STARTED',
        'category' => 'OUR STORY',
        'read_time' => '8 min read',
        'hero_img' => 'c5afda4fc4e4d4b0682377d6eb272c90',
        'points' => array(
            array('num' => '1.', 'title' => 'SEEING THE GAPS FIRSTHAND', 'text' => 'We spent years producing events for founders, brands, and creatives. Behind every great event was a business that needed structure, clearer positioning, and sustainable operations.'),
            array('num' => '2.', 'title' => 'OPERATIONAL RIGOR APPLIED TO BUSINESS', 'text' => 'Live events demand zero margin for error. We take that same relentless execution mindset and apply it to business strategy, revenue models, and brand setups.'),
            array('num' => '3.', 'title' => 'NOT JUST ADVICE — REAL DIRECTION', 'text' => 'Too much consulting is vague theory. We build practical playbooks, customer acquisition systems, and brand identities that founders can execute immediately.')
        ),
        'quote' => 'EXPERIENCE IN THE FIELD BEATS THEORY IN A SLIDE DECK.'
    ),
    'ankara-festival-in-photos' => array(
        'title' => 'ANKARA FESTIVAL, IN PHOTOS',
        'category' => 'EVENT RECAP',
        'read_time' => '4 min read',
        'hero_img' => '99a3c292f4b3a38d253144801b4a9ae3',
        'points' => array(
            array('num' => '1.', 'title' => 'CELEBRATING AFRICAN TEXTILES & FASHION', 'text' => 'From vibrant wax prints to contemporary streetwear interpretations, the runway captured the creativity and cultural pride of our community.'),
            array('num' => '2.', 'title' => 'SOUNDS & LIVE PERFORMANCES', 'text' => 'Live talking drums, Afrobeats DJ sets, and guest vocalists kept the energy at peak levels throughout the exhibition halls.'),
            array('num' => '3.', 'title' => 'COMMUNITY MARKETPLACE & FOOD', 'text' => 'Over 20 independent diaspora food vendors and artisan crafters showcased authentic flavors and products to thousands of attendees.')
        ),
        'quote' => 'CULTURE IS NOT JUST PRESERVED; IT IS CELEBRATED IN MOTION.'
    )
);

$req_uri = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
$parts = explode( '/', $req_uri );
$current_slug = end( $parts );

if ( isset( $blog_catalog[ $current_slug ] ) ) {
    $post_data = $blog_catalog[ $current_slug ];
} elseif ( have_posts() ) {
    the_post();
    $post_data = array(
        'title' => strtoupper( get_the_title() ),
        'category' => 'JOURNAL',
        'read_time' => '5 min read',
        'hero_img' => 'b094675514894aa0d8e7dd735d187b22',
        'points' => array(
            array('num' => '•', 'title' => 'INSIGHTS & STRATEGY', 'text' => get_the_excerpt() ? get_the_excerpt() : 'Crux Nxtion event planning and business consulting perspectives.')
        ),
        'quote' => 'TURNING IDEAS INTO EXPERIENCES THAT RESONATE.'
    );
} else {
    $clean_title = ucwords( str_replace( array('-', '_'), ' ', $current_slug ) );
    $post_data = array(
        'title' => strtoupper( $clean_title ),
        'category' => 'JOURNAL',
        'read_time' => '6 min read',
        'hero_img' => 'b094675514894aa0d8e7dd735d187b22',
        'points' => array(
            array('num' => '1.', 'title' => 'EXECUTION & DETAIL', 'text' => 'From creative concept to on-the-ground delivery, success lies in intentional design and relentless execution.')
        ),
        'quote' => 'TURNING BOLD IDEAS INTO UNFORGETTABLE EXPERIENCES.'
    );
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="background:#0A0F26; margin:0; padding:0;">
<?php wp_body_open(); ?>



<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  * { box-sizing: border-box; }
  body { margin: 0; font-family: 'Space Grotesk', system-ui, sans-serif; background: #0A0F26; color: #F4F5FA; }
  a { color: #5B8DEF; text-decoration: none; }
  a:hover { color: #E5383B; }
  .bebas { font-family: 'Bebas Neue', 'Arial Narrow', sans-serif; letter-spacing: 0.5px; line-height: 0.9; text-transform: uppercase; }
  .eyebrow { font-weight: 600; letter-spacing: 3px; text-transform: uppercase; font-size: 11px; color: #5B8DEF; }
  .ticket-stub { position: relative; }
  .ticket-stub::before, .ticket-stub::after { content: ''; position: absolute; right: -11px; width: 20px; height: 20px; border-radius: 50%; background: #0A0F26; z-index: 2; }
  .ticket-stub::before { top: -10px; }
  .ticket-stub::after { bottom: -10px; }
  @keyframes rc-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  @keyframes rc-marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  /* Micro-animations */
  body { animation: rcFadeIn .5s ease-out; }
  @keyframes rcFadeIn { from { opacity: 0; } to { opacity: 1; } }
  img { transition: transform .5s ease; }
  a:hover img { transform: scale(1.05); }
  a { transition: color .2s ease, filter .3s ease, box-shadow .3s ease, border-color .25s ease; }
  a:hover { filter: brightness(1.08); }
  a:active { filter: brightness(0.94); }
  .ticket { transition: box-shadow .3s ease, filter .3s ease; }
  .ticket:hover { box-shadow: 0 18px 34px rgba(0,0,0,0.22); }
  header nav a { position: relative; }
  header nav a::after { content: ''; position: absolute; left: 0; bottom: -6px; width: 0; height: 2px; background: currentColor; transition: width .3s ease; }
  header nav a:hover::after { width: 100%; }
  a[style*="border-radius:999px"], a[style*="clip-path:polygon"] { transition: transform .25s ease, box-shadow .25s ease, filter .25s ease; }
  a[style*="border-radius:999px"]:hover, a[style*="clip-path:polygon"]:hover { transform: translateY(-3px); box-shadow: 0 14px 26px rgba(0,0,0,0.22); }
  .tilt-ticket { transition: transform .3s ease, box-shadow .3s ease; }
  .tilt-ticket:hover { transform: rotate(calc(var(--r) * 1.8)) translateY(-4px) !important; box-shadow: 0 18px 34px rgba(0,0,0,0.22); }
  .tilt-straighten { transition: transform .35s ease; }
  .tilt-straighten:hover { transform: rotate(0deg) scale(1.04) !important; }
  .tilt-in { transition: transform .35s ease; }
  .tilt-in:hover { transform: rotate(var(--r, 3deg)) scale(1.03) !important; }
  .pill { border:1.5px solid #1E2B5E; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:10px 20px; border-radius:999px; }
  .pill.on { background:#F4F5FA; color:#0A0F26; border-color:#F4F5FA; }
  .strip-stub { position: relative; }
  .strip-stub::before, .strip-stub::after { content: ''; position: absolute; bottom: -11px; width: 22px; height: 22px; border-radius: 50%; background: #0A0F26; z-index: 2; }
  .strip-stub::before { left: 24%; }
  .strip-stub::after { left: 68%; }

    /* Services Dropdown (Focused Floating Card) */
  .crux-nav-dropdown { position: relative !important; display: inline-flex !important; align-items: center !important; height: 100% !important; padding: 18px 0 !important; }
  .crux-nav-trigger { display: inline-flex !important; align-items: center !important; gap: 6px !important; font-size: 14px !important; font-weight: 600 !important; letter-spacing: 0.2px !important; text-decoration: none !important; line-height: 1 !important; cursor: pointer !important; transition: color .2s ease !important; }
  .crux-nav-trigger::after { content: '' !important; position: absolute !important; left: 0 !important; bottom: 8px !important; width: 0 !important; height: 2px !important; background: currentColor !important; transition: width .3s ease !important; }
  .crux-nav-dropdown:hover .crux-nav-trigger::after, .crux-nav-dropdown:focus-within .crux-nav-trigger::after { width: 100% !important; }
  .crux-nav-dropdown:hover .crux-chevron, .crux-nav-dropdown:focus-within .crux-chevron { transform: rotate(180deg) !important; }
  .crux-services-card { position: absolute !important; top: calc(100% - 6px) !important; left: 50% !important; transform: translateX(-50%) translateY(8px) !important; width: 580px !important; opacity: 0 !important; visibility: hidden !important; pointer-events: none !important; transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s !important; border-radius: 12px !important; z-index: 1000 !important; }
  .crux-nav-dropdown:hover .crux-services-card, .crux-nav-dropdown:focus-within .crux-services-card { opacity: 1 !important; visibility: visible !important; pointer-events: auto !important; transform: translateX(-50%) translateY(0) !important; }
  .c-dlink { display: flex !important; align-items: center !important; gap: 10px !important; padding: 7px 8px !important; border-radius: 6px !important; text-decoration: none !important; transition: transform .2s ease, background .2s ease !important; }
  .c-dlink:hover { transform: translateX(4px) !important; }
  body.drawer-open, html.drawer-open { overflow: hidden !important; }
  .mdrawer { display: flex !important; flex-direction: column !important; position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999 !important; overflow-y: auto !important; -webkit-overflow-scrolling: touch; padding: 0 !important; box-sizing: border-box !important; opacity: 0; visibility: hidden; pointer-events: none; transform: translateY(-8px); transition: opacity .25s ease, transform .25s ease, visibility .25s; }
  .mdrawer.is-open { opacity: 1 !important; visibility: visible !important; pointer-events: auto !important; transform: translateY(0) !important; }
  details.mdrawer-acc summary::-webkit-details-marker { display: none; }
  details.mdrawer-acc summary { list-style: none; }
  details.mdrawer-acc[open] .acc-icon { transform: rotate(45deg); color: #BA0000 !important; }
  .mdrawer-body .msub { display: block; padding: 6px 0; font-size: 13.5px; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.05); }
  .mdrawer-body .msub:last-child { border-bottom: none; }
  /* ---- motion ---- */
  @property --p { syntax:'<integer>'; inherits:false; initial-value:0; }
  @keyframes apT4 { 0%,20% { background:transparent; border-color:#FF2E3D; } 28%,86% { background:#8C7AE6; border-color:#8C7AE6; } 94%,100% { background:transparent; border-color:#FF2E3D; } }
  @keyframes apT5 { 0%,44% { background:transparent; border-color:#FF2E3D; } 52%,86% { background:#8C7AE6; border-color:#8C7AE6; } 94%,100% { background:transparent; border-color:#FF2E3D; } }
  @keyframes apBar { 0%,18% { width:55%; } 30% { width:78%; } 54% { width:100%; } 86% { width:100%; } 96%,100% { width:55%; } }
  .ap4 { animation:apT4 7s ease infinite; } .ap5 { animation:apT5 7s ease infinite; } .apbar { animation:apBar 7s ease infinite; }
  @keyframes opSweep { 0%,10% { background-size:0% 3px; } 45%,85% { background-size:100% 3px; } 100% { background-size:0% 3px; } }
  .ophl { background-image:linear-gradient(#8C7AE6,#8C7AE6); background-repeat:no-repeat; background-position:0 100%; background-size:0% 3px; padding-bottom:3px; animation:opSweep 4.5s ease infinite; }
  @keyframes swUp { 0%,100% { transform:scaleY(1); } 30% { transform:scaleY(1.45); } 60% { transform:scaleY(1); } }
  .sw1, .sw2, .sw3 { transform-origin:bottom; animation:swUp 3.2s ease-in-out infinite; } .sw2 { animation-delay:.25s; } .sw3 { animation-delay:.5s; }
  @keyframes rmA { 0%,6% { transform:scaleX(0); } 26%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  @keyframes rmB { 0%,22% { transform:scaleX(0); } 42%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  @keyframes rmC { 0%,38% { transform:scaleX(0); } 58%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  .rm1, .rm2, .rm3 { transform-origin:left; animation:rmA 6s ease infinite; } .rm2 { animation-name:rmB; } .rm3 { animation-name:rmC; }
  @keyframes nowPulse { 0%,100% { box-shadow:0 0 0 0 rgba(140,122,230,.55); } 50% { box-shadow:0 0 0 7px rgba(140,122,230,0); } }
  .nowp { animation:nowPulse 2s ease infinite; }
  @keyframes ring72 { 0%,6% { --p:0; } 30%,88% { --p:72; } 100% { --p:0; } }
  @keyframes ring45 { 0%,6% { --p:0; } 30%,88% { --p:45; } 100% { --p:0; } }
  @keyframes ring88 { 0%,6% { --p:0; } 30%,88% { --p:88; } 100% { --p:0; } }
  .rg { animation-duration:6s; animation-timing-function:ease-out; animation-iteration-count:infinite; counter-reset:n var(--p); }
  .rg72 { animation-name:ring72; } .rg45 { animation-name:ring45; } .rg88 { animation-name:ring88; }
  .rgn::after { content:counter(n); }
  @keyframes revealUp { from { opacity:0; transform:translateY(26px); } to { opacity:1; transform:none; } }
  @supports (animation-timeline: view()) { .reveal { animation:revealUp linear both; animation-timeline:view(); animation-range: entry 0% cover 18%; } }
  @keyframes drift { from { transform:scale(1.02); } to { transform:scale(1.09) translate(-1%,-1%); } }
  .drift { animation:drift 18s ease-in-out infinite alternate; }
  @keyframes sheen { 0% { transform:translateX(-120%); } 60%,100% { transform:translateX(220%); } }
  /* ---- one button shape ---- */
  .bx { position:relative; clip-path:polygon(var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%); border:0 !important; border-radius:0 !important; --bw:1.5px; text-align:center; }
  .bx::before { content:''; position:absolute; inset:0; background:var(--bc,transparent); pointer-events:none; clip-path:polygon(evenodd, var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%, var(--sl,10px) 0, calc(var(--sl,10px) + var(--bw)) var(--bw), calc(100% - var(--bw)) var(--bw), calc(100% - var(--sl,10px) - var(--bw)) calc(100% - var(--bw)), var(--bw) calc(100% - var(--bw)), calc(var(--sl,10px) + var(--bw)) var(--bw), var(--sl,10px) 0); }
  .bx:hover { filter:brightness(1.1); transform:translateY(-2px); }
  .bx:active { transform:none; filter:brightness(.95); }
  .bx { transition:transform .2s ease, filter .2s ease; }

  

  

  html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    /* USE overflow-x: clip so horizontal scroll is prevented WITHOUT breaking position: sticky! */
    overflow-x: clip !important;
    box-sizing: border-box;
    scroll-behavior: smooth;
  }
  *, *::before, *::after {
    box-sizing: border-box;
  }
  img {
    max-width: 100%;
    height: auto;
  }

  /* Full-bleed 100% root container — edge-to-edge layout, never pillarboxed */
  [data-m~=root] {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    position: relative;
    box-sizing: border-box;
    overflow-x: clip !important;
    overflow-y: visible !important;
  }

  /* Sticky Navigation Header with Glassmorphism */
  header {
    position: sticky !important;
    top: 0 !important;
    z-index: 1000 !important;
    backdrop-filter: blur(14px) !important;
    -webkit-backdrop-filter: blur(14px) !important;
    transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease !important;
  }
  header nav a {
    position: relative;
    transition: color .2s ease;
  }
  header nav a::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 0;
    height: 2px;
    background: currentColor;
    transition: width .3s ease;
  }
  header nav a:hover::after {
    width: 100%;
  }

  /* Slanted Header Switcher Frame */
  .header-switcher {
    transition: all .2s ease;
  }
  .header-switcher a.crux-sw-inactive:hover {
    color: #FFFFFF !important;
  }
  .header-switcher--light a.crux-sw-inactive:hover {
    color: #10142E !important;
  }

  /* Rotating Rosette Badge Animation (Matching Red Cap Entertainment) */
  .prefooter__badge-link:hover {
    transform: scale(1.08);
  }
  @keyframes rc-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
  @media (prefers-reduced-motion: reduce) {
    .prefooter__badge-img { animation: none !important; }
  }

  /* Scroll-Driven Reveal Engine (Fast 18% viewport entry threshold) */
  @keyframes revealUp {
    from { opacity: 0; transform: translateY(22px); }
    to { opacity: 1; transform: none; }
  }
  @supports (animation-timeline: view()) {
    .reveal {
      animation: revealUp linear both;
      animation-timeline: view();
      animation-range: entry 0% cover 18%;
    }
  }

  /* TICKET MOTION ENGINE:
     - Straight in resting state -> becomes tilted on hover (-1.5deg)
     - Tilted in resting state (--r set) -> becomes straight (0deg) on hover!
     - Entire ticket (frame, notch, stub, image, text) moves as ONE single solid object!
  */
  .tilt-ticket, .ticket {
    transition: transform .35s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow .35s ease, filter .3s ease !important;
    will-change: transform;
  }
  .tilt-ticket[style*="--r"]:hover, .tilt-ticket[style*="rotate"]:hover {
    transform: rotate(0deg) translateY(-6px) scale(1.02) !important;
    box-shadow: 0 20px 38px rgba(0,0,0,0.32) !important;
  }
  .tilt-ticket:not([style*="--r"]):hover {
    transform: rotate(-1.5deg) translateY(-6px) scale(1.02) !important;
    box-shadow: 0 20px 38px rgba(0,0,0,0.32) !important;
  }
  .tilt-ticket img, .ticket img,
  .tilt-ticket:hover img, .ticket:hover img,
  a.tilt-ticket:hover img, a.ticket:hover img {
    transform: none !important;
    transition: none !important;
  }

  /* Card and tile hover elevation */
  .bento-tile {
    transition: transform .3s ease, box-shadow .3s ease;
  }
  .bento-tile:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 34px rgba(0,0,0,0.28);
  }

  /* Accordion details styling */
  details > summary::-webkit-details-marker {
    display: none;
  }
  details[open] {
    border-color: #5B8DEF !important;
  }
  details[open] .fq-plus {
    transform: rotate(45deg);
    background: #BA0000 !important;
  }

  /* Subtle interactive feedback on touch devices */
  @media (hover: none) {
    .bx:active, .tilt-ticket:active, .bento-tile:active {
      transform: scale(0.98) !important;
    }
  }

  /* Desktop Viewport (> 900px) */
  @media (min-width: 901px) {
    header {
      min-height: 80px !important;
      padding: 14px 64px !important;
    }
    header > nav {
      display: flex !important;
    }
    header > .header-desktop-actions, header > div.header-desktop-actions {
      display: flex !important;
    }
    .mnav-btn, .crux-mnav-btn {
      display: none !important;
    }
    .mdrawer {
      display: none !important;
    }
    .msw {
      display: none !important;
    }
    .carousel-track {
      display: flex !important;
      gap: 24px !important;
    }
    .consultancy-panels-container .cpanel:hover {
      flex: 5 1 0 !important;
      border-color: #8C7AE6 !important;
    }
    .consultancy-panels-container .cpanel:hover .cpanel-label {
      display: none !important;
    }
    .consultancy-panels-container .cpanel:hover .cpanel-body {
      display: block !important;
    }
    .consultancy-panels-container .cpanel:hover img {
      filter: brightness(0.85) !important;
    }

    /* Desktop Section Padding & Typography: Restores full 64px side breathing room */
    [data-m~=root] > section, [data-m~=root] > div > section {
      padding-left: 64px !important;
      padding-right: 64px !important;
    }
    .hero-content {
      padding: 0 64px !important;
    }
    h1.hero-title, [data-m~=root] section h1 {
      font-size: clamp(56px, 6.8vw, 104px) !important;
      line-height: 0.92 !important;
    }
  }

  /* Mobile Viewport / Minimized Browser (<= 900px) */
  @media (max-width: 900px) {
    [data-m~=root] {
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;
      overflow-x: clip !important;
    }
    header {
      padding: 10px 20px !important;
    }
    header > nav {
      display: none !important;
    }
    header > .header-desktop-actions, header > div.header-desktop-actions {
      display: none !important;
    }
    .mnav-btn, .crux-mnav-btn {
      display: flex !important;
    }
    body.drawer-open, html.drawer-open { overflow: hidden !important; }
    .mdrawer {
      display: none;
      position: fixed !important;
      inset: 0 !important;
      width: 100vw !important;
      height: 100vh !important;
      z-index: 99999 !important;
      padding: 0 !important;
      box-sizing: border-box !important;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch;
    }
    
    .mdrawer-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      flex-shrink: 0;
    }
    .mdrawer-close-btn {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      font-size: 24px;
      line-height: 1;
      cursor: pointer;
      user-select: none;
    }
    .mdrawer-body {
      padding: 10px 24px 40px;
      flex: 1;
      overflow-y: auto;
    }
    @keyframes mslide {
      from { opacity: 0; transform: translateY(-8px); }
      to { opacity: 1; transform: none; }
    }
    .mdrawer a.mlink, .mdrawer span.mlink, .mdrawer .mlink {
      display: block;
      font-family: 'Bebas Neue', 'Arial Narrow', sans-serif !important;
      font-size: 32px !important;
      letter-spacing: .5px !important;
      text-transform: uppercase !important;
      padding: 12px 0;
      opacity: 1 !important;
      -webkit-text-fill-color: initial !important;
    }
    .mdrawer details summary {
      list-style: none;
      cursor: pointer;
    }
    .mdrawer details summary::-webkit-details-marker {
      display: none;
    }
    .mdrawer .msub {
      display: block;
      padding: 9px 0 9px 14px;
      font-size: 14.5px;
    }

    /* Fixed Bottom Switcher */
    .msw {
      position: fixed !important;
      bottom: 20px !important;
      top: auto !important;
      left: 0 !important;
      right: 0 !important;
      height: auto !important;
      z-index: 900 !important;
      display: flex !important;
      justify-content: center !important;
      align-items: center !important;
      pointer-events: none !important;
    }
    .msw > div {
      pointer-events: auto !important;
    }

    /* Prefooter badge responsive scaling */
    [data-m~=prefooter-inner] {
      padding-left: 20px !important;
      padding-right: 20px !important;
      flex-direction: column !important;
      align-items: flex-start !important;
    }
    .prefooter__badge {
      width: 130px !important;
      height: 130px !important;
      flex: 0 0 130px !important;
      margin-top: 10px !important;
    }

    /* Grid columns collapsing without overflow */
    [data-m~=g1] {
      display: grid !important;
      grid-template-columns: 1fr !important;
      grid-template-rows: none !important;
      grid-auto-rows: auto !important;
      gap: 18px !important;
    }
    [data-m~=g2] {
      display: grid !important;
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      grid-template-rows: none !important;
      grid-auto-rows: auto !important;
      gap: 12px !important;
    }
    [data-m~=span] {
      grid-column: auto !important;
      grid-row: auto !important;
    }
    [data-m~=tile] {
      min-height: 260px;
    }
    [data-m~=g1] > *:not([data-m~=tile]):not([data-m~=herovis]):not([data-m~=collage]),
    [data-m~=g2] > *:not([data-m~=tile]):not([data-m~=herovis]):not([data-m~=collage]) {
      height: auto !important;
      min-height: 0 !important;
    }
    [data-m~=imgfirst] {
      order: -1 !important;
    }
    [data-m~=stack] {
      display: flex !important;
      flex-direction: column !important;
      align-items: flex-start !important;
      justify-content: flex-start !important;
      gap: 16px !important;
    }
    [data-m~=stack] > * {
      text-align: left !important;
      max-width: 100% !important;
    }
    [data-m~=ctas] {
      display: flex !important;
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
    }
    [data-m~=ctas] > * {
      text-align: center !important;
    }
    [data-m~=wrap] {
      flex-wrap: wrap !important;
      gap: 10px !important;
    }
    [data-m~=full] {
      width: 100% !important;
      max-width: 100% !important;
      min-width: 0 !important;
      flex: none !important;
    }
    [data-m~=nomin] {
      min-height: 0 !important;
    }
    [data-m~=hide] {
      display: none !important;
    }
    [data-m~=static] {
      position: static !important;
    }
    [data-m~=scroller] {
      overflow-x: auto !important;
      padding-left: 20px !important;
      scroll-snap-type: x mandatory;
      scrollbar-width: none;
    }
    [data-m~=track] {
      transform: none !important;
      padding-right: 20px;
      gap: 14px !important;
    }
    [data-m~=track] > * {
      flex: 0 0 290px !important;
      height: 430px !important;
      scroll-snap-align: start;
    }
    [data-m~=svcrow] {
      display: grid !important;
      grid-template-columns: auto minmax(0, 1fr) auto !important;
      column-gap: 14px !important;
      row-gap: 14px !important;
      align-items: center !important;
      flex-wrap: nowrap !important;
      padding: 16px 0 !important;
    }
    [data-m~=svcrow] > img {
      grid-column: 1 / -1 !important;
      grid-row: 1 !important;
      width: 100% !important;
      height: 200px !important;
    }
    [data-m~=svcrow] > [data-m~=price] {
      grid-column: 1 / -1 !important;
      justify-self: start !important;
      font-size: 28px !important;
    }
    [data-m~=imgtop] {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 14px !important;
    }
    [data-m~=imgtop] > img {
      width: 100% !important;
      height: 220px !important;
      flex: none !important;
    }
    [data-m~=imgtop] > * {
      flex: none !important;
      max-width: 100% !important;
    }
    [data-m~=hero] {
      min-height: 520px !important;
    }
    h1 {
      line-height: 0.95 !important;
      font-size: clamp(34px, 8.5vw, 68px) !important;
    }
    .mega-panel {
      display: none !important;
    }

    /* Mobile panel accordion */
    .consultancy-panels-container {
      flex-direction: column !important;
      height: auto !important;
    }
    .consultancy-panels-container .cpanel {
      flex: none !important;
      width: 100% !important;
      height: 260px !important;
    }
    .consultancy-panels-container .cpanel .cpanel-label {
      display: none !important;
    }
    .consultancy-panels-container .cpanel .cpanel-body {
      display: block !important;
    }

    /* Fixed wide padding overrides */
    [style*="padding:0 64px"], [style*="padding: 0 64px"], [style*="padding:0px 64px"],
    [style*="padding:10px 64px"], [style*="padding: 10px 64px"],
    [style*="padding:20px 64px"], [style*="padding: 20px 64px"],
    [style*="padding:44px 64px"], [style*="padding: 44px 64px"],
    [style*="padding:60px 64px"], [style*="padding: 60px 64px"],
    [style*="padding:65px 64px"], [style*="padding: 65px 64px"],
    [style*="padding:70px 64px"], [style*="padding: 70px 64px"],
    [style*="padding:72px 64px"], [style*="padding: 72px 64px"],
    [style*="padding:80px 64px"], [style*="padding: 80px 64px"] {
      padding-left: 20px !important;
      padding-right: 20px !important;
    }
    section[style*="grid-template-columns"] {
      grid-template-columns: 1fr !important;
      gap: 24px !important;
    }

    /* Faster mobile reveal (12% viewport entry threshold) */
    @supports (animation-timeline: view()) {
      .reveal {
        animation-range: entry 0% cover 12% !important;
      }
    }

    /* Mobile Hero Tightening & White Space Removal */
    [data-m~=root] > section:first-of-type,
    section[data-m~=g1]:first-of-type,
    [data-m~=hero] {
      padding-top: 74px !important;
    padding-bottom: 56px !important;
      padding-left: 20px !important;
      padding-right: 20px !important;
      min-height: 0 !important;
      gap: 28px !important;
    }

    /* Consultancy Mobile Hero: Hide consultant photo, display discovery card + action badge */
    [data-m~=hv-img] {
      display: none !important;
    }
    [data-m~=herovis] {
      height: auto !important;
      min-height: 0 !important;
      display: block !important;
      position: relative !important;
      border-radius: 24px !important;
      overflow: hidden !important;
      background: linear-gradient(160deg, #F3F1FC, #E6E0FA) !important;
      padding: 64px 14px 16px !important;
      margin-top: 14px !important;
    }
    [data-m~=hv-chat] {
      position: relative !important;
      left: auto !important;
      right: auto !important;
      bottom: auto !important;
      top: auto !important;
      width: 100% !important;
      margin: 0 !important;
    }
    [data-m~=hv-chat] .tilt-straighten {
      transform: none !important;
      background: rgba(16,20,46,0.96) !important;
      backdrop-filter: blur(16px) !important;
      -webkit-backdrop-filter: blur(16px) !important;
      padding: 20px !important;
    }
    [data-m~=hv-chat] .cb {
      font-size: 13px !important;
      padding: 10px 14px !important;
    }
    [data-m~=hv-badge] {
      position: absolute !important;
      top: 12px !important;
      right: 12px !important;
      left: auto !important;
      margin: 0 !important;
    }
  }

    .mega:hover .mega-menu { display: block !important; }
    .mega:hover .mega-chevron { transform: rotate(180deg); }
  
  /* Slanted Header Switcher Pod & Hover States */
  .crux-sw-pod { transition: transform .2s ease, box-shadow .2s ease; }
  .crux-sw-pod:hover { transform: translateY(-1px); }
  .crux-sw-tab--inactive-dark:hover { color: #FFFFFF !important; background: rgba(255,255,255,0.08) !important; }
  .crux-sw-tab--inactive-light:hover { color: #10142E !important; background: rgba(108,88,219,0.12) !important; }

  </style>


<div style="width:100%; max-width:100%; margin:0; background:#0A0F26; overflow-x:clip;" data-m="root">

  <!-- SHOUT-OUT BAR -->
  <div style="background:#002671; padding:10px 20px 10px 20px; display:flex; align-items:center; justify-content:center; gap:10px;">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 11l18-7-7 18-2-8-9-3z" stroke="#FFFFFF" stroke-width="1.8" stroke-linejoin="round"></path></svg>
    <span style="font-size:12.5px; font-weight:700; color:#FFFFFF; letter-spacing:0.3px;">Now booking <?php echo date( "Y" ); ?>/<?php echo (int) date( "Y" ) + 1; ?> across the UK — <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="color:#FFFFFF; font-weight:800; border-bottom:1px solid #FFFFFF;">get in touch →</a></span>
  </div>

  <!-- HEADER -->
  <header style="position:sticky; top:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; min-height:80px; padding:14px 20px; border-bottom:1px solid rgba(30,43,94,0.85); background:rgba(10,15,38,0.94); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
    <nav style="display:flex; align-items:center; gap:28px;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Home</a>
      <div class="mega" style="position:relative;">
        <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px; display:inline-flex; align-items:center; gap:6px;">
          <span>Services</span>
          <svg class="mega-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" style="transition:transform 0.2s ease;">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <div class="mega-menu" style="display:none; position:absolute; left:-180px; top:100%; width:840px; background:#0B112C; border:1px solid #1E2B5E; padding:32px; box-shadow:0 30px 60px rgba(0,0,0,0.5); border-radius:14px; z-index:9999;">
          <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:28px;">
            <!-- Column 1: EVENTS -->
            <div>
              <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;"><span class="bebas" style="font-size:24px; color:#F4F5FA;">EVENTS</span><span style="font-size:10px; letter-spacing:1.5px; font-weight:700; color:#5B8DEF;">FOR YOUR NIGHT</span></div>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Event Planning &amp; Management</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">End-to-end execution</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Entertainment &amp; Talent</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">DJs, hosts, live performers</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Event Designs &amp; Production</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Weddings, birthdays, launches</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Event Marketing &amp; Promotion</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Buzz that fills the room</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">On-Site Coordination</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Day-of logistics &amp; support</span>
                </span>
              </a>
            </div>
            <!-- Column 2: CONSULTANCY -->
            <div>
              <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;"><span class="bebas" style="font-size:24px; color:#F4F5FA;">CONSULTANCY</span><span style="font-size:10px; letter-spacing:1.5px; font-weight:700; color:#B7A6FF;">FOR YOUR BUSINESS</span></div>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Business Setup &amp; Strategy</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">From idea to a plan</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Branding &amp; Marketing</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Say what you do</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Business Growth</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">More customers &amp; revenue</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Commercial Fitout &amp; Setup</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Unit sourcing &amp; shopfitting</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Specialized Visas &amp; Advisory</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Global talent &amp; founder visas</span>
                </span>
              </a>
            </div>
            <!-- Column 3: NOT SURE WHICH? Photo Card -->
            <div style="position:relative; border-radius:14px; overflow:hidden; min-height:240px; display:flex; flex-direction:column; justify-content:flex-end;">
              <img src="<?php echo crux_get_blob_url( 'f269f7683bdb441b9b45df1336cd1485' ); ?>" alt="Crux Nxtion Founder Bambad" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center 20%;">
              <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.95) 0%, rgba(10,15,38,0.3) 70%);"></div>
              <div style="position:relative; z-index:1; padding:20px;">
                <span class="bebas" style="font-size:24px; color:#FFFFFF; display:block; margin-bottom:8px;">NOT SURE WHICH?</span>
                <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="display:inline-block; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:10px 18px; --sl:8px; text-decoration:none;" class="bx">Book A Call &rarr;</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">About</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#5B8DEF; font-size:14px; font-weight:600; letter-spacing:0.2px; border-bottom:1.5px solid #5B8DEF;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Contact</a>
    </nav>
        <div class="header-desktop-actions" style="display:flex; align-items:center; gap:16px;">
      <div class="site-wing-toggle crux-sw-pod crux-sw-pod--dark" style="display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 4px 16px rgba(0,0,0,0.35); filter:drop-shadow(0 2px 6px rgba(0,0,0,0.25));">
        <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:3px; gap:3px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
          <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">Events</a>
          <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">Consultancy</a>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:12px 22px; --sl:8px;" class="bx">Plan An Event</a>
    </div>
    <button type="button" class="crux-mnav-btn" id="crux-mnav-toggle" aria-label="Open navigation menu" aria-expanded="false" style="display:none; background:transparent; border:none; padding:10px; cursor:pointer; flex-direction:column; gap:5px; color:#F4F5FA;">
      <i style="display:block; width:24px; height:2px; background:currentColor;"></i>
      <i style="display:block; width:24px; height:2px; background:currentColor;"></i>
      <i style="display:block; width:16px; height:2px; align-self:flex-end; background:currentColor;"></i>
    </button>
  </header>
  
  <!-- MOBILE DRAWER OVERLAY -->
  <div class="mdrawer" id="crux-mobile-drawer" style="background:#0A0F26;" role="dialog" aria-modal="true" aria-label="Crux Nxtion Navigation">
    <div class="mdrawer-topbar" style="border-bottom:1px solid #1E2B5E;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;">
        <img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion" style="height:36px; width:auto; background:#FFFFFF; padding:4px 12px; border-radius:6px; display:block;">
      </a>
      <button type="button" class="mdrawer-close-btn" id="crux-mdrawer-close" aria-label="Close menu" style="background:rgba(255,255,255,0.08); border:none; color:#F4F5FA; cursor:pointer; display:flex; align-items:center; justify-content:center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    
    <div class="mdrawer-body">

      <!-- Navigation Links -->
      <div class="mdrawer-nav-links">
        <a class="mlink" href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Home</a>
        
        <!-- Accordion Services -->
        <details class="mdrawer-acc" style="border-bottom:1px solid #1E2B5E;">
          <summary style="display:flex; align-items:center; justify-content:space-between; cursor:pointer; padding:14px 0;">
            <span class="mlink" style="color:#F4F5FA !important; opacity:1 !important;">Services</span>
            <span class="acc-icon" style="color:#FF2E3D; font-size:22px; font-weight:700; transition:transform .2s ease;">▾</span>
          </summary>
          <div style="padding:4px 0 16px;">
            <!-- Events sub-box -->
            <div style="background:rgba(0,38,113,0.22); border:1px solid rgba(91,141,239,0.3); border-radius:8px; padding:12px 14px; margin-bottom:12px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:#5B8DEF; text-transform:uppercase;">EVENTS WING</span>
                <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="font-size:11px; font-weight:700; color:#5B8DEF; text-decoration:none;">All &rarr;</a>
              </div>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">Event Management &amp; Planning</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">Entertainment Booking &amp; Talent</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">Design &amp; Audio-Visual Production</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">On-Site Floor Coordination</a>
            </div>

            <!-- Consultancy sub-box -->
            <div style="background:rgba(140,122,230,0.12); border:1px solid rgba(140,122,230,0.3); border-radius:8px; padding:12px 14px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:#B7A6FF; text-transform:uppercase;">CONSULTANCY WING</span>
                <a href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="font-size:11px; font-weight:700; color:#B7A6FF; text-decoration:none;">All &rarr;</a>
              </div>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Business Setup &amp; Strategy</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Commercial Fitout &amp; Setup</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Brand Growth &amp; Scaling</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Specialized Visas &amp; Advisory</a>
            </div>
          </div>
        </details>

        <a class="mlink" href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Events</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Gallery</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">About</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Blog</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Contact</a>
      </div>

      <!-- Dual Action CTAs -->
      <div style="display:flex; flex-direction:column; gap:10px; margin-top:24px;">
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="display:block; text-align:center; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx">Plan An Event &rarr;</a>
        <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="display:block; text-align:center; background:#8C7AE6; color:#10142E; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx">Book Discovery Call (Calendly) &rarr;</a>
      </div>

      <!-- Contact & Direct Telephony -->
      <div style="margin-top:24px; padding-top:18px; border-top:1px solid #1E2B5E; display:flex; flex-direction:column; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5B8DEF" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"></path></svg>
          <a href="tel:+447448614051" style="font-size:13px; color:#C5CADF; text-decoration:none; font-weight:600;">+44 7448 614051</a>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8C7AE6" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <?php $c_mail = 'infoandsales@cruxnxtion.co.uk'; ?>
          <a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; color:#C5CADF; text-decoration:none; font-weight:600;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- BREADCRUMB -->
  <div style=" padding:20px 20px 0px 20px;"><span style="font-size:13px; color:#7A82A8;"><a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#7A82A8;">Home</a> / <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#7A82A8;">Blog</a> / <span style="color:#F4F5FA; font-weight:600;"><?php echo esc_html( $post_data["title"] ); ?></span></span></div>

  <!-- ARTICLE HEADER -->
  <section style=" padding:40px 20px 30px 20px; max-width:1000px;">
    <span class="eyebrow"><?php echo esc_html( $post_data['category'] ); ?></span>
    <h1 class="bebas" style="font-size:40px; margin:14px 0px 18px 0px; color:#F4F5FA; line-height:0.95;"><?php echo esc_html( $post_data['title'] ); ?></h1>
    <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;" class="reveal">Crux Nxtion Events &nbsp;•&nbsp; <?php echo esc_html( $post_data['read_time'] ); ?></p>
  </section>
  <section style=" margin:0px 20px 0px 20px; height:420px; overflow:hidden; border-radius:16px; border:1.5px solid #1E2B5E;"><img src="<?php echo crux_get_blob_url( $post_data['hero_img'] ); ?>" alt="<?php echo esc_attr( $post_data['title'] ); ?>" style="width:100%; height:100%; object-fit:cover;"></section>

  <!-- ARTICLE -->
  <section style=" padding:56px 20px 44px 20px; display:grid; grid-template-columns:1.6fr 0.8fr; gap:70px; align-items:start;" data-m="g1">
    <div class="reveal">
      <?php foreach ( $post_data['points'] as $pt ) : ?>
      <div style="margin-bottom:34px;">
        <h2 class="bebas" style="font-size:34px; margin:0px 0px 10px 0px; color:#F4F5FA;"><span style="color:#5B8DEF;"><?php echo esc_html( $pt['num'] ); ?></span> <?php echo esc_html( $pt['title'] ); ?></h2>
        <p style="font-size:16px; line-height:1.85; color:#B4BCDD; margin:0px;"><?php echo esc_html( $pt['text'] ); ?></p>
      </div>
      <?php endforeach; ?>
      <?php if ( ! empty( $post_data['quote'] ) ) : ?>
      <div style="border-left:4px solid #5B8DEF; padding:6px 0px 6px 24px; margin:34px 0px;">
        <p class="bebas" style="font-size:34px; line-height:1.15; margin:0px; color:#F4F5FA;">"<?php echo esc_html( $post_data['quote'] ); ?>"</p>
      </div>
      <?php endif; ?>
    </div>
    <div style="background:#111838; border:1.5px solid #1E2B5E; border-radius:16px; padding:28px;" class="reveal">
      <span class="eyebrow">Recent Posts</span>
      <?php foreach ( $blog_catalog as $bslug => $bitem ) :
          if ( $bslug === $current_slug ) continue;
      ?>
      <a href="<?php echo esc_url( home_url( "/blog/" . $bslug . "/" ) ); ?>" style="display:block; padding:16px 0; border-bottom:1px solid #1E2B5E; color:#F4F5FA;">
        <span style="font-size:11px; letter-spacing:1.5px; color:#5B8DEF; font-weight:700;"><?php echo esc_html( $bitem['category'] ); ?></span>
        <span style="display:block; font-size:15px; font-weight:700; margin-top:6px;"><?php echo esc_html( $bitem['title'] ); ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

    <!-- PREFOOTER CTA — cinematic band with spinning rosette badge -->
  <section style="position:relative; min-height:540px; overflow:hidden; display:flex; align-items:center;">
    <img src="<?php echo crux_get_blob_url( 'aa52e28c3ca12b7f14d33300c774fb48' ); ?>" alt="Crux Nxtion event crowd" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; inset:0; background:linear-gradient(100deg, rgba(10,15,38,0.97) 0%, rgba(10,15,38,0.82) 52%, rgba(10,15,38,0.5) 100%);"></div>
    <div style="position:absolute; left:0; right:0; top:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:absolute; left:0; right:0; bottom:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:relative; z-index:1; width:100%; display:flex; justify-content:space-between; align-items:center; gap:40px; padding:0 64px; flex-wrap:wrap;" class="reveal" data-m="prefooter-inner">
      <div style="max-width:760px; padding:40px 0;">
        <span class="eyebrow" style="color:#A9C0F5 !important;">Ready When You Are</span>
        <h2 class="bebas" style="font-size:clamp(44px, 5.5vw, 76px); line-height:0.95; margin:16px 0 18px; color:#FFFFFF; max-width:820px;">GOT A DATE, OR JUST A DIRECTION?</h2>
        <p style="font-size:16px; line-height:1.7; color:#C5CADF; max-width:540px; margin:0 0 32px;">Planning an event or building a business — tell us what you have in mind and a real person will come back to you.</p>
        <div style="display:flex; gap:16px;" data-m="ctas">
          <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Plan An Event →</a>
          <a href="<?php echo esc_url( home_url( "/contact/?type=consultancy" ) ); ?>" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Talk Business Strategy →</a>
        </div>
      </div>
      <div class="prefooter__badge" style="width:160px; height:160px; flex:0 0 160px;">
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" class="prefooter__badge-link" aria-label="Plan An Event" style="display:block; width:100%; height:100%; text-decoration:none; transition:transform .3s ease;">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prefooter-badge-events.svg' ); ?>" class="prefooter__badge-img" alt="Plan An Event — spinning badge" style="width:100%; height:100%; object-fit:contain; animation:rc-spin 14s linear infinite; filter:drop-shadow(0 12px 28px rgba(0,0,0,0.5));">
        </a>
      </div>
    </div>
  </section>

  <!-- COLOSSAL FOOTER -->
  <footer id="contact" style="background:#0A0F26; padding:44px 24px 44px 24px; text-align:center; position:relative; overflow:hidden;">
    <div style="position:relative; margin-bottom:40px;">
      <span class="bebas" style="font-size:clamp(80px,17vw,220px); line-height:0.82; display:block; background:linear-gradient(180deg, #F4F5FA 0%, #A9C0F5 25%, #1E2B5E 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative;">CRUX</span>
      <span class="bebas" style="font-size:clamp(30px,6.4vw,82px); line-height:1; display:block; background:linear-gradient(180deg, #F4F5FA 0%, #A9C0F5 25%, #1E2B5E 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative; letter-spacing:0.5em; margin-top:10px; padding-left:0.5em;">NXTION</span>
    </div>
    <div style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:32px; margin-bottom:32px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Home</a>
      <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Services</a>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">About</a>
      <a href="<?php echo esc_url( home_url( "/faq/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">FAQ</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/sponsors/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Sponsors</a>
    </div>
    <div style="display:flex; justify-content:center; gap:14px; margin-bottom:44px;" data-m="wrap">
      <a href="#" aria-label="Instagram" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(244,245,250,0.05); color:#F4F5FA; --sl:7px; --bc:rgba(244,245,250,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.5"></rect><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"></circle><circle cx="17.4" cy="6.6" r="1" fill="currentColor"></circle></svg></a>
      <a href="#" aria-label="TikTok" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(244,245,250,0.05); color:#F4F5FA; --sl:7px; --bc:rgba(244,245,250,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M14 3v10.5a3.5 3.5 0 1 1-3-3.46" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path d="M14 3c.4 2.6 2.2 4.4 4.8 4.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
      <a href="#" aria-label="WhatsApp" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(244,245,250,0.05); color:#F4F5FA; --sl:7px; --bc:rgba(244,245,250,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 20l1.4-4.1A8 8 0 1 1 9 19.5L4 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path><path d="M8.5 9.5c0 3.5 3 6.5 6.5 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
    </div>
    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:8px 26px; margin-bottom:20px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( "/privacy-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Privacy Policy</a>
      <a href="<?php echo esc_url( home_url( "/cookie-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Cookie Policy</a>
      <a href="<?php echo esc_url( home_url( "/terms-conditions/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Terms &amp; Conditions</a>
    </div>
    <div style="width:100%; max-width:900px; height:1px; background:#1E2B5E; margin:0 auto 24px;"></div>
    <p style="font-size:13px; color:#7A82A8; margin:0px 0px 0px 0px;">&copy; <?php echo date( "Y" ); ?> Crux Nxtion Events • Sheffield, United Kingdom • All Rights Reserved</p>
  </footer>

<div class="msw">
  <div style="pointer-events:auto; display:inline-flex; align-items:center; background:rgba(10,15,38,0.95); border:1.5px solid #1E2B5E; padding:5px 6px; gap:6px; clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.6); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; min-width:130px; font-size:13px; font-weight:700; background:#1E48B0; color:#FFFFFF; --sl:7px; text-decoration:none;" class="bx">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
      <span>Events</span>
    </a>
    <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; min-width:130px; font-size:13px; font-weight:700; color:#A3A9C8; background:transparent; --sl:7px; --bc:#A3A9C855; text-decoration:none;" class="bx">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
      <span>Consultancy</span>
    </a>
  </div>
</div></div></div>





<?php wp_footer(); ?>
</body>
</html>
