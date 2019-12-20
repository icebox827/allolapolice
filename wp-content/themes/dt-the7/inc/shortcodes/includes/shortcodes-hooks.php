<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'save_post', 'the7_save_shortcode_inline_css', 1, 2 );
add_filter( 'the_excerpt', 'the7_shortcodeaware_excerpt_filter', 9 );
add_filter( 'the7_shortcodeaware_excerpt', 'the7_shortcodeaware_excerpt_filter' );

if ( ! function_exists( 'the7_save_shortcode_inline_css' ) ) {

	/**
	 * Store shortcodes inline css from post content.
	 *
	 * @param int     $postID
	 * @param WP_Post $post
	 */
	function the7_save_shortcode_inline_css( $postID, $post ) {
		// Do not fire for revisions and while importing posts.
		if ( defined( 'WP_LOAD_IMPORTERS' ) || wp_is_post_revision( $post ) ) {
			return;
		}

		if ( ! class_exists( 'the7_lessc', false ) ) {
			include PRESSCORE_DIR . '/vendor/lessphp/the7_lessc.inc.php';
		}

		$css = the7_generate_shortcode_css( $post->post_content );

		if ( $css ) {
			update_post_meta( $postID, 'the7_shortcodes_dynamic_css', $css );
		} else {
			delete_post_meta( $postID, 'the7_shortcodes_dynamic_css' );
		}
	}
}

if ( ! function_exists( 'the7_generate_shortcode_css' ) ) {

	/**
	 * Collect shortcodes inline css.
	 *
	 * @param string $content
	 *
	 * @return array
	 */
	function the7_generate_shortcode_css( $content ) {
		if ( empty( $content ) ) {
			return array();
		}

		$css = array();
		preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );
		foreach ( $shortcodes[2] as $index => $tag ) {
			$attr_array    = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
			$shortcode_css = (array) apply_filters( "the7_generate_sc_{$tag}_css", array(), $attr_array );
			unset( $shortcode_css[0] );
			reset( $shortcode_css );
			$uid = key( $shortcode_css );
			if ( $shortcode_css && ! array_key_exists( $uid, $css ) ) {
				$css[ $uid ] = $shortcode_css[ $uid ];
			}
			if ( ! empty( $shortcodes[5][ $index ] ) ) {
				$shortcodes_css = the7_generate_shortcode_css( $shortcodes[5][ $index ] );
				$css            = array_merge( $css, $shortcodes_css );
			}
		}

		return $css;
	}
}

if ( ! function_exists( 'the7_shortcodeaware_excerpt_filter' ) ) {

	/**
	 * Return current post autoexcerpt after doing shortcodes if $output is empty.
	 * Fix for situation when get_the_excerpt() returns empty string because of content contain only shortcodes.
	 *
	 * @since 6.3.1
	 *
	 * @param string $output
	 *
	 * @return string
	 */
	function the7_shortcodeaware_excerpt_filter( $output ) {
		global $post;

		if ( empty( $output ) && ! empty( $post->post_content ) ) {
			add_filter( 'strip_shortcodes_tagnames', 'the7_shortcodes_to_strip_from_auto_exerpt' );
			$content = strip_shortcodes( $post->post_content );
			remove_filter( 'strip_shortcodes_tagnames', 'the7_shortcodes_to_strip_from_auto_exerpt' );

			$text           = wp_strip_all_tags( do_shortcode( $content ) );
			$excerpt_length = apply_filters( 'excerpt_length', 55 );
			$excerpt_more   = apply_filters( 'excerpt_more', ' [...]' );

			return wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}

		return $output;
	}
}

if ( ! function_exists( 'the7_shortcodes_to_strip_from_auto_exerpt' ) ) {

	/**
	 * Return list of shortcodes to strip from autoexcerpt.
	 *
	 * @since 6.3.1
	 *
	 * @param array $_
	 *
	 * @return array
	 */
	function the7_shortcodes_to_strip_from_auto_exerpt( $_ ) {
		return array(
			'dt_item',
			'dt_banner',
			'dt_before_after',
			'dt_blog_posts',
			'dt_blog_list',
			'dt_blog_masonry',
			'dt_blog_carousel',
			'dt_blog_posts_small',
			'dt_blog_scroller',
			'dt_box',
			'dt_button',
			'dt_call_to_action',
			'dt_code',
			'dt_code_final',
			'dt_cell',
			'dt_contact_form',
			'dt_divider',
			'dt_fancy_image',
			'dt_fancy_separator',
			'dt_fancy_video_vc',
			'dt_gap',
			'dt_map',
			'dt_progress_bars',
			'dt_progress_bar',
			'dt_teaser',
			'dt_simple_login_form',
			'dt_social_icons',
			'dt_social_icon',
			'dt_breadcrumbs',
			'dt_carousel',
			'dt_default_button',
			'dt_soc_icons',
			'dt_single_soc_icon',
			'dt_products_carousel',
			'dt_products_masonry',
			'dt_portfolio',
			'dt_portfolio_jgrid',
			'dt_portfolio_slider',
			'dt_portfolio_masonry',
			'dt_portfolio_carousel',
			'dt_gallery_masonry',
			'dt_media_gallery_carousel',
			'dt_albums',
			'dt_albums_masonry',
			'dt_albums_carousel',
			'dt_albums_jgrid',
			'dt_albums_scroller',
			'dt_photos_masonry',
			'dt_photos_jgrid',
			'dt_small_photos',
			'dt_team',
			'dt_team_carousel',
			'dt_team_masonry',
			'dt_testimonials',
			'dt_testimonials_carousel',
			'dt_testimonials_masonry',
			'dt_slideshow',
			'dt_gallery_photos_masonry',
			'dt_photos_carousel',
			'dt_benefits_vc',
			'dt_logos',
			'featured_products',
			'recent_products',
			'product_page',
			'product_category',
			'product_categories',
			'products',
			'sale_products',
			'best_selling_products',
			'top_rated_products',
			'related_products',
			'product',
			'vc_flickr',
			'vc_basic_grid',
			'vc_media_grid',
			'vc_masonry_grid',
			'vc_masonry_media_grid',
			'rev_slider_vc',
			'rev_slider',
			'go_pricing',
		);
	}
}
