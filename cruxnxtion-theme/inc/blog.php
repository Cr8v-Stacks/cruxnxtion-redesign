<?php
/**
 * Crux Nxtion - blog helpers: post cards, pagination, share bar, reading time.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Whole minutes to read a text (220 words a minute), at least 1. */
function crux_read_minutes( $content ) {
	$words = str_word_count( wp_strip_all_tags( (string) $content ) );
	return max( 1, (int) ceil( $words / 220 ) );
}

/** Name of the first category of a post, or "Journal". */
function crux_post_category_name( $post_id = 0 ) {
	$pid  = $post_id ? $post_id : get_the_ID();
	if ( 'post' !== get_post_type( $pid ) ) {
		$obj = get_post_type_object( get_post_type( $pid ) );
		return $obj ? $obj->labels->singular_name : __( 'Journal', 'cruxnxtion' );
	}
	$cats = get_the_category( $pid );
	return $cats ? $cats[0]->name : __( 'Journal', 'cruxnxtion' );
}

/**
 * One post as a ticket card, inside the loop. $size: 'feature' (wide) or 'tile'.
 */
function crux_render_post_card( $size = 'tile' ) {
	$thumb    = get_the_post_thumbnail_url( get_the_ID(), 'large' );
	$category = crux_post_category_name();
	$read     = crux_h( 'blog', 'post_list_text_1' );
	$photo    = $thumb
		? '<img src="' . esc_url( $thumb ) . '" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">'
		: '<div style="position:absolute; inset:0; background:linear-gradient(135deg, var(--crux-navy,#002671) 0%, var(--crux-ink2,#10142E) 100%);"></div>';
	$when     = get_the_date( 'j M Y' );
	if ( 'feature' === $size ) {
		echo '<a href="' . esc_url( get_permalink() ) . '" class="ticket reveal" style="grid-column:span 3; display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="span tile">';
		echo '<div class="ticket-stub" style="flex:0 0 110px; background:var(--crux-navy,#002671); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:16px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;">' . esc_html( strtoupper( $category ) ) . '</span></div>';
		echo '<div style="flex:1; position:relative;">' . $photo . '<div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(10,15,38,0.94) 0%, rgba(10,15,38,0.55) 45%, rgba(10,15,38,0.15) 100%);"></div>'; // phpcs:ignore WordPress.Security.EscapeOutput
		echo '<div style="position:absolute; left:0; top:0; bottom:0; display:flex; flex-direction:column; justify-content:center; padding:36px; max-width:580px;"><span class="eyebrow">' . esc_html( $when . ' · ' . crux_read_minutes( get_the_content() ) . ' min read' ) . '</span><h2 class="bebas" style="font-size:38px; margin:12px 0; color:var(--crux-text,#F4F5FA);">' . esc_html( get_the_title() ) . '</h2><p style="font-size:14px; color:#C5CFF5; line-height:1.6; margin:0 0 16px;">' . esc_html( wp_trim_words( get_the_excerpt(), 28 ) ) . '</p><span style="font-weight:700; font-size:12.5px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px; width:fit-content;">' . $read . '</span></div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput
		echo '</a>';
		return;
	}
	echo '<a href="' . esc_url( get_permalink() ) . '" class="ticket reveal" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">';
	echo '<div class="ticket-stub" style="flex:0 0 60px; background:var(--crux-red,#BA0000); display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;">' . esc_html( strtoupper( wp_trim_words( $category, 3, '' ) ) ) . '</span></div>';
	echo '<div style="flex:1; position:relative;">' . $photo . '<div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>'; // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<div style="position:absolute; left:0; right:0; bottom:0; padding:20px;"><span class="eyebrow">' . esc_html( $when ) . '</span><h3 style="font-size:17px; margin:8px 0 6px; font-weight:700; color:var(--crux-text,#F4F5FA);">' . esc_html( get_the_title() ) . '</h3><span style="font-size:11.5px; color:#C5CFF5;">' . esc_html( crux_read_minutes( get_the_content() ) . ' min read' ) . '</span></div></div>';
	echo '</a>';
}

/** Numbered pagination for the main query. */
function crux_pagination() {
	$links = paginate_links(
		array(
			'type'      => 'array',
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
		)
	);
	if ( ! $links ) {
		return;
	}
	echo '<nav class="crux-pagination" aria-label="Pages">';
	foreach ( $links as $l ) {
		echo wp_kses_post( $l );
	}
	echo '</nav>';
}

/** WhatsApp, X, Facebook and copy-link buttons for a page. */
function crux_share_bar( $url, $title ) {
	$u = rawurlencode( $url );
	$t = rawurlencode( $title );
	static $script = false;
	echo '<div class="crux-share" aria-label="' . esc_attr__( 'Share', 'cruxnxtion' ) . '"><span class="crux-share__label">' . esc_html__( 'Share', 'cruxnxtion' ) . '</span>';
	echo '<a href="https://wa.me/?text=' . esc_attr( $t . '%20' . $u ) . '" target="_blank" rel="noopener">WhatsApp</a>';
	echo '<a href="https://twitter.com/intent/tweet?url=' . esc_attr( $u ) . '&amp;text=' . esc_attr( $t ) . '" target="_blank" rel="noopener">X</a>';
	echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . esc_attr( $u ) . '" target="_blank" rel="noopener">Facebook</a>';
	echo '<button type="button" class="crux-share__copy" data-url="' . esc_url( $url ) . '">' . esc_html__( 'Copy link', 'cruxnxtion' ) . '</button></div>';
	if ( ! $script ) {
		$script = true;
		echo '<script>document.addEventListener("click",function(e){var b=e.target.closest(".crux-share__copy");if(!b){return;}var u=b.getAttribute("data-url");if(navigator.clipboard){navigator.clipboard.writeText(u);}b.textContent="Copied";setTimeout(function(){b.textContent="Copy link";},1800);});</script>';
	}
}
