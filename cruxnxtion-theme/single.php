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
?>
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => '#0A0F26', 'root_bg' => '#0A0F26', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'blog' ) ); ?>

  <!-- BREADCRUMB -->
  <div style=" padding:20px 20px 0px 20px;"><span style="font-size:13px; color:#7A82A8;"><a href="<?php echo crux_url( 'single_post', 'breadcrumb_link_1_url' ); ?>" style="color:#7A82A8;"<?php echo crux_edit_attr( 'single_post', 'breadcrumb_link_1' ); ?>><?php echo crux_h( 'single_post', 'breadcrumb_link_1' ); ?></a> / <a href="<?php echo crux_url( 'single_post', 'breadcrumb_link_2_url' ); ?>" style="color:#7A82A8;"<?php echo crux_edit_attr( 'single_post', 'breadcrumb_link_2' ); ?>><?php echo crux_h( 'single_post', 'breadcrumb_link_2' ); ?></a> / <span style="color:#F4F5FA; font-weight:600;"><?php echo esc_html( $post_data["title"] ); ?></span></span></div>

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
      <span class="eyebrow"<?php echo crux_edit_attr( 'single_post', 'article_small_heading_1' ); ?>><?php echo crux_h( 'single_post', 'article_small_heading_1' ); ?></span>
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

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'single_post', 'article_text_1' ); ?>><?php echo crux_h( 'single_post', 'article_text_1' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'single_post', 'article_text_2' ); ?>><?php echo crux_h( 'single_post', 'article_text_2' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
