<?php
/**
 * Theme config helpers
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'presscore_config_base_init' ) ) :

	function presscore_config_base_init( $new_post_id = null ) {
		static $init_done = false;
		if ( $init_done ) {
			return;
		}

		$config = Presscore_Config::get_instance();
		$post_id = $config->get('post_id');
		if ( ! $post_id ) {

			$new_post_id = apply_filters( 'presscore_config_post_id_filter', $new_post_id );
			if ( $new_post_id ) {
				$post_id = $new_post_id;
				$config->set( 'post_id', $post_id );
			}
		}

		do_action( 'presscore_config_before_base_init' );

		if ( ! $post_id ) {
			presscore_config_populate_archive_vars();
			$init_done = true;
			return;
		}

		//////////////////////
		// common settings //
		//////////////////////

		presscore_config_get_theme_option();
		presscore_config_populate_page_overrides();
		presscore_config_populate_header_options();
		presscore_config_populate_sidebar_and_footer_options();
		presscore_config_logo_options();

		/////////////////////////////
		// config for post types //
		/////////////////////////////

		$cur_post_type = get_post_type( $post_id );
		$template = $config->get('template');
		switch ( $cur_post_type ) {

			case 'page':

				$config->set( 'page_id', $post_id );

				if ( 'blog' == $template ) {
					presscore_congif_populate_blog_vars();
				}
				break;

			case 'post':
				presscore_congif_populate_single_post_vars();
				break;

			case 'attachment':
				presscore_congif_populate_single_attachment_vars();
				break;

		}

		do_action( "presscore_config_base_init_{$cur_post_type}", $template );
		do_action( 'presscore_config_base_init', $cur_post_type, $template );

		$init_done = true;
	}

endif;

/////////////
// ARCHIVE //
/////////////

if ( ! function_exists( 'presscore_config_populate_archive_vars' ) ) :

	function presscore_config_populate_archive_vars() {
		presscore_config_get_theme_option();
		presscore_config_populate_page_overrides();
		presscore_config_populate_header_options();
		presscore_config_logo_options();

		$config = presscore_get_config();

		$config->set( 'logo.header.regular', of_get_option( 'header-logo_regular', array('', 0) ) );
		$config->set( 'logo.header.hd', of_get_option( 'header-logo_hd', array('', 0) ) );

		$config->set( 'show_titles', true );
		$config->set( 'show_excerpts', true );

		$config->set( 'show_links', true );
		$config->set( 'show_details', true );
		$config->set( 'show_zoom', true );

		$config->set( 'post.meta.fields.date', true );
		$config->set( 'post.meta.fields.categories', true );
		$config->set( 'post.meta.fields.comments', true );
		$config->set( 'post.meta.fields.author', true );
		$config->set( 'post.meta.fields.media_number', true );

		$config->set( 'post.preview.width.min', 320 );
		$config->set( 'post.preview.mini_images.enabled', true );
		$config->set( 'post.preview.load.effect', 'fade_in' );
		$config->set( 'post.preview.background.enabled', true );
		$config->set( 'post.preview.background.style', 'fullwidth' );
		$config->set( 'post.preview.description.alignment', 'left' );
		$config->set( 'post.preview.description.style', 'under_image' );

		$config->set( 'post.preview.hover.animation', 'fade' );
		$config->set( 'post.preview.hover.color', 'accent' );
		$config->set( 'post.preview.hover.content.visibility', 'on_hoover' );

		$config->set( 'post.fancy_date.enabled', false );

		$config->set( 'template.columns.number', 3 );
		$config->set( 'load_style', 'default' );
		$config->set( 'image_layout', 'original' );
		$config->set( 'all_the_same_width', true );
		$config->set( 'item_padding', 10 );

		if ( is_home() ) {
			$config->set( 'sidebar_position', 'right' );
			$config->set( 'footer_show', true );
		} else {
			$config->set( 'sidebar_position', 'disabled' );
		}
	}

endif;

/////////////////
// SINGLE POST //
/////////////////

if ( ! function_exists( 'presscore_congif_populate_single_post_vars' ) ) :

	function presscore_congif_populate_single_post_vars() {
		$config = Presscore_Config::get_instance();
		$post_id = $config->get( 'post_id' );

		/////////////////////////////
		// post meta information //
		/////////////////////////////

		// general meta switch
		if ( of_get_option( 'general-blog_meta_on', 1 ) ) {

			// date
			$config->set( 'post.meta.fields.date', of_get_option( 'general-blog_meta_date', 1 ) );

			// categories
			$config->set( 'post.meta.fields.categories', of_get_option( 'general-blog_meta_categories', 1 ) );

			// comments
			$config->set( 'post.meta.fields.comments', of_get_option( 'general-blog_meta_comments', 1 ) );

			// author
			$config->set( 'post.meta.fields.author', of_get_option( 'general-blog_meta_author', 1 ) );

			// tags
			$config->set( 'post.meta.fields.tags', of_get_option( 'general-blog_meta_tags', 1 ) );

		} else {

			// turn off all
			$config->set( 'post.meta.fields.date', 0 );
			$config->set( 'post.meta.fields.categories',0 );
			$config->set( 'post.meta.fields.comments', 0 );
			$config->set( 'post.meta.fields.author', 0 );

		}

		///////////////////////////////
		// post navigation buttons //
		///////////////////////////////

		$config->set( 'post.navigation.arrows.enabled', of_get_option( 'general-next_prev_in_blog', 1 ) );

		$show_back_button = of_get_option( 'general-show_back_button_in_post', 0 );
		$config->set( 'post.navigation.back_button.enabled', $show_back_button );

		if ( $show_back_button ) {
			$post_back_url = get_post_meta( $post_id, '_dt_post_options_back_button', true );
			$config->set( 'post.navigation.back_button.url', $post_back_url ? $post_back_url : of_get_option( 'general-post_back_button_url' ) );
		}

		$config->set( 'post.author_block', of_get_option( 'general-show_author_in_blog', true ) );

		$config->set( 'post.fancy_date.enabled', of_get_option( 'post-show_fancy_date' ) );
		$config->set( 'post.fancy_category.enabled', of_get_option( 'post-show_fancy_categories' ) );
	}

endif;

///////////////////
// BLOG TEMPLATE //
///////////////////

if ( ! function_exists( 'presscore_congif_populate_blog_vars' ) ) :

	function presscore_congif_populate_blog_vars() {

		$config = Presscore_Config::get_instance();
		$post_id = $config->get( 'post_id' );

		$prefix = '_dt_blog_options_';

		// populate options
		$config->set( 'image_layout', get_post_meta( $post_id, "{$prefix}image_layout", true ) );
		$config->set( 'thumb_proportions', get_post_meta( $post_id, "{$prefix}thumb_proportions", true ) );
		$config->set( 'posts_per_page', get_post_meta( $post_id, "{$prefix}ppp", true ) );
		$config->set( 'all_the_same_width', get_post_meta( $post_id, "{$prefix}posts_same_width", true ) );
		$config->set( 'show_all_pages', get_post_meta( $post_id, "{$prefix}show_all_pages", true ) );
		$config->set( 'full_width', get_post_meta( $post_id, "{$prefix}full_width", true ) );
		$config->set( 'show_excerpts', get_post_meta( $post_id, "{$prefix}show_exerpts", true ), true );
		$config->set( 'show_details', get_post_meta( $post_id, "{$prefix}show_details", true ), true );

		//////////////////
		// Load style //
		//////////////////

		$config->set( 'load_style', get_post_meta( $post_id, "{$prefix}load_style", true ), 'default' );
		$config->set( 'post.preview.load.effect', get_post_meta( $post_id, "{$prefix}load_effect", true ), 'fade_in' );

		/////////////////////////////
		// post meta information //
		/////////////////////////////

		// date
		$config->set( 'post.meta.fields.date', get_post_meta( $post_id, "{$prefix}show_date_in_post_meta", true ), true );

		// categories
		$config->set( 'post.meta.fields.categories', get_post_meta( $post_id, "{$prefix}show_categories_in_post_meta", true ), true );

		// comments
		$config->set( 'post.meta.fields.comments', get_post_meta( $post_id, "{$prefix}show_comments_in_post_meta", true ), true );

		// author
		$config->set( 'post.meta.fields.author', get_post_meta( $post_id, "{$prefix}show_author_in_post_meta", true ), true );

		// filter
		// for categorizer compatibility
		if ( !$config->get('order') ) {
			$config->set( 'order', get_post_meta( $post_id, "{$prefix}order", true ) );
		}

		if ( !$config->get('orderby') ) {
			$config->set( 'orderby', get_post_meta( $post_id, "{$prefix}orderby", true ) );
		}

		if ( !$config->get('display') ) {
			$config->set( 'display', get_post_meta( $post_id, "_dt_blog_display", true ) );
		}

		$config->set( 'template.posts_filter.terms.enabled', get_post_meta( $post_id, "{$prefix}show_filter", true ) );
		$config->set( 'template.posts_filter.orderby.enabled', get_post_meta( $post_id, "{$prefix}show_orderby", true ) );
		$config->set( 'template.posts_filter.order.enabled', get_post_meta( $post_id, "{$prefix}show_order", true ) );

		///////////////////////////////////
		// template speciffic settings //
		///////////////////////////////////

		$current_layout_type = presscore_get_current_layout_type();
		if ( 'masonry' == $current_layout_type ) {
			$background_under_posts = get_post_meta( $post_id, "{$prefix}bg_under_masonry_posts", true );

			$config->set( 'post.preview.background.enabled', ! in_array( $background_under_posts, array( 'disabled', '' ) ) );
			$config->set( 'post.preview.background.style', $background_under_posts, false );

			$config->set( 'post.preview.description.alignment', get_post_meta( $post_id, "{$prefix}post_content_alignment", true ), 'left' );
			$config->set( 'post.preview.description.style', 'under_image' );

			$config->set( 'layout', get_post_meta( $post_id, "{$prefix}layout", true ), 'masonry' );
		} else if ( 'list' == $current_layout_type ) {
			$config->set( 'post.preview.background.enabled', get_post_meta( $post_id, "{$prefix}bg_under_list_posts", true ), false );
			$config->set( 'post.preview.media.width', get_post_meta( $post_id, "{$prefix}thumb_width", true ), 30 );

			$config->set( 'layout', get_post_meta( $post_id, "{$prefix}list_layout", true ), 'list' );
		}

		//////////////////
		// fancy date //
		//////////////////

		// enable fancy date
		$config->set( 'post.fancy_date.enabled', get_post_meta( $post_id, "{$prefix}enable_fancy_date", true ), true );

		/////////////////////
		// posts preview //
		/////////////////////

		$config->set( 'item_padding', get_post_meta( $post_id, "{$prefix}item_padding", true ), 20 );
		$config->set( 'post.preview.width.min', get_post_meta( $post_id, "{$prefix}target_width", true ), 370 );
		$config->set( 'template.columns.number', get_post_meta( $post_id, "{$prefix}columns_number", true ), 3 );
	}

endif;

/////////////////////
// HEADER SETTINGS //
/////////////////////

if ( ! function_exists( 'presscore_config_populate_header_options' ) ) :

	function presscore_config_populate_header_options() {

		$config = Presscore_Config::get_instance();
		$post_id = $config->get( 'post_id' );

		///////////////////////
		// Header settings //
		///////////////////////

		$prefix = '_dt_header_';

		$header_title = get_post_meta( $post_id, "{$prefix}title", true );
		$config->set( 'header_title', ( $header_title ? $header_title : null ), 'enabled' );

		if ( in_array( $header_title, array( 'fancy', 'slideshow' ) ) ) {
			$config->set( 'header_background', get_post_meta( $post_id, "{$prefix}background", true ), 'normal' );
			$config->set( 'header.transparent.background.opacity', get_post_meta( $post_id, "{$prefix}transparent_bg_opacity", true ), 50 );
			$config->set( 'header.transparent.background.color', get_post_meta( $post_id, "{$prefix}transparent_bg_color", true ), '#000000' );
			$config->set( 'top_bar.transparent.background.opacity', get_post_meta( $post_id, "{$prefix}transparent_top_bar_bg_opacity", true ), 25 );
			$config->set( 'top_bar.transparent.background.color', get_post_meta( $post_id, "{$prefix}transparent_top_bar_bg_color", true ), '#ffffff' );
			$config->set( 'header.transparent.color_scheme', get_post_meta( $post_id, "{$prefix}transparent_bg_color_scheme", true ), 'from_options' );
			$config->set( 'page_title.background.mode', '__fancy' );
		} elseif ( 'disabled' === $header_title ) {
			$config->set( 'header_background', get_post_meta( $post_id, "{$prefix}disabled_background", true ), 'normal' );
			$config->set( 'header.transparent.background.opacity', get_post_meta( $post_id, "{$prefix}disabled_transparent_bg_opacity", true ), 50 );
			$config->set( 'header.transparent.background.color', get_post_meta( $post_id, "{$prefix}disabled_transparent_bg_color", true ), '#000000' );
			$config->set( 'top_bar.transparent.background.opacity', get_post_meta( $post_id, "{$prefix}disabled_transparent_top_bar_bg_opacity", true ), 25 );
			$config->set( 'top_bar.transparent.background.color', get_post_meta( $post_id, "{$prefix}disabled_transparent_top_bar_bg_color", true ), '#ffffff' );
			$config->set( 'header.transparent.color_scheme', get_post_meta( $post_id, "{$prefix}disabled_transparent_bg_color_scheme", true ), 'from_options' );
			$config->set( 'page_title.background.mode', '__fancy' );
		}

		$config->set( 'header.slideshow.header_below', get_post_meta( $post_id, "{$prefix}background_below_slideshow", true ), 'disabled' );

		switch ( $config->get( 'header.layout', 'inline' ) ) {
			case 'side':
				$config->set( 'header_background', 'normal' );
				break;
		}

		////////////////////////////
		// Fancy header options //
		////////////////////////////

		$prefix = '_dt_fancy_header_';

		// title
		$config->set( 'fancy_header.title', get_post_meta( $post_id, "{$prefix}title", true ), '' );
		$config->set( 'fancy_header.title.mode', get_post_meta( $post_id, "{$prefix}title_mode", true ), 'custom' );
		$config->set( 'fancy_header.title.aligment', get_post_meta( $post_id, "{$prefix}title_aligment", true ), 'center' );

		// subtitle
		$config->set( 'fancy_header.subtitle', get_post_meta( $post_id, "{$prefix}subtitle", true ), '' );
		$config->set( 'fancy_header.title.color.mode', get_post_meta( $post_id, "{$prefix}title_color_mode", true ), 'color' );
		$config->set( 'fancy_header.subtitle.color.mode', get_post_meta( $post_id, "{$prefix}subtitle_color_mode", true ), 'color' );
		


		// background
		$config->set( 'fancy_header.bg.color', get_post_meta( $post_id, "{$prefix}bg_color", true ), '#000000' );
		$config->set( 'fancy_header.bg.image', get_post_meta( $post_id, "{$prefix}bg_image", true ) );
		$config->set( 'fancy_header.bg.repeat', get_post_meta( $post_id, "{$prefix}bg_repeat", true ) );
		$config->set( 'fancy_header.bg.position.x', get_post_meta( $post_id, "{$prefix}bg_position_x", true ) );
		$config->set( 'fancy_header.bg.position.y', get_post_meta( $post_id, "{$prefix}bg_position_y", true ) );
		$config->set( 'fancy_header.bg.fullscreen', get_post_meta( $post_id, "{$prefix}bg_fullscreen", true ) );
		$config->set( 'fancy_header.bg.overlay', get_post_meta( $post_id, "{$prefix}bg_overlay", true ) );
		$config->set( 'fancy_header.bg.fixed', get_post_meta( $post_id, "{$prefix}scroll_effect", true ) );
		$config->set( 'fancy_header.parallax.speed', (float) get_post_meta( $post_id, "{$prefix}bg_parallax", true ) );

		$config->set( 'fancy_header.bg.color', get_post_meta( $post_id, "{$prefix}bg_color", true ), '#000000' );

		// breadcrumbs
		$config->set( 'fancy_header.breadcrumbs', get_post_meta( $post_id, "{$prefix}breadcrumbs", true ), 'enabled' );
		$config->set( 'fancy_header.responsive.breadcrumbs', get_post_meta( $post_id, "{$prefix}responsive_breadcrumbs", true ), 'disabled' );
		$config->set( 'fancy_header.breadcrumbs.text_color', get_post_meta( $post_id, "{$prefix}breadcrumbs_text_color", true ) );
		$config->set( 'fancy_header.breadcrumbs.bg_color', get_post_meta( $post_id, "{$prefix}breadcrumbs_bg_color", true ) );

		/////////////////////////
		// Slideshow options //
		/////////////////////////

		$prefix = '_dt_slideshow_';

		$config->set( 'slideshow_mode', get_post_meta( $post_id, "{$prefix}mode", true ) );

		$config->set( 'slideshow_sliders', get_post_meta( $post_id, "{$prefix}sliders", false ) );
		$config->set( 'slideshow_layout', get_post_meta( $post_id, "{$prefix}layout", true ) );

		$slider_prop = get_post_meta( $post_id, "{$prefix}slider_proportions", true );
		if ( empty($slider_prop) ) {
			$slider_prop = array( 'width' => 1200, 'height' => 500 );
		}
		$config->set( 'slideshow_slider_width', $slider_prop['width'] );
		$config->set( 'slideshow_slider_height', $slider_prop['height'] );

		$config->set( 'slideshow_slider_scaling', get_post_meta( $post_id, "{$prefix}scaling", true ) );

		$config->set( 'slideshow_autoslide_interval', get_post_meta( $post_id, "{$prefix}autoslide_interval", true ) );
		$config->set( 'slideshow_autoplay', get_post_meta( $post_id, "{$prefix}autoplay", true ) );
		$config->set( 'slideshow_hide_captions', get_post_meta( $post_id, "{$prefix}hide_captions", true ) );

		$config->set( 'slideshow_revolution_slider', get_post_meta( $post_id, "{$prefix}revolution_slider", true ) );

		$config->set( 'slideshow_layer_slider', get_post_meta( $post_id, "{$prefix}layer_slider", true ) );
		$config->set( 'slideshow_layer_bg_and_paddings', get_post_meta( $post_id, "{$prefix}layer_show_bg_and_paddings", true ) );

		//////////////////////
		// photo scroller //
		//////////////////////

		$config->set( 'slideshow.photo_scroller.layout', get_post_meta( $post_id, "{$prefix}photo_scroller_layout", true ), 'fullscreen' );
		$config->set( 'slideshow.photo_scroller.background.color', get_post_meta( $post_id, "{$prefix}photo_scroller_bg_color", true ), '#000000' );
		$config->set( 'slideshow.photo_scroller.overlay.enabled', get_post_meta( $post_id, "{$prefix}photo_scroller_overlay", true ), true );

		$config->set( 'slideshow.photo_scroller.padding.top', get_post_meta( $post_id, "{$prefix}photo_scroller_top_padding", true ), 0 );
		$config->set( 'slideshow.photo_scroller.padding.bottom', get_post_meta( $post_id, "{$prefix}photo_scroller_bottom_padding", true ), 0 );
		$config->set( 'slideshow.photo_scroller.padding.side', get_post_meta( $post_id, "{$prefix}photo_scroller_side_paddings", true ), 0 );

		$config->set( 'slideshow.photo_scroller.inactive.opacity', get_post_meta( $post_id, "{$prefix}photo_scroller_inactive_opacity", true ), 15 );
		$config->set( 'slideshow.photo_scroller.thumbnails.visibility', get_post_meta( $post_id, "{$prefix}photo_scroller_thumbnails_visibility", true ), 'show' );

		$config->set( 'slideshow.photo_scroller.autoplay.mode', get_post_meta( $post_id, "{$prefix}photo_scroller_autoplay", true ), 'play' );
		$config->set( 'slideshow.photo_scroller.autoplay.speed', get_post_meta( $post_id, "{$prefix}photo_scroller_autoplay_speed", true ), 4000 );

		$config->set( 'slideshow.photo_scroller.thumbnail.width', get_post_meta( $post_id, "{$prefix}photo_scroller_thumbnails_width", true ), 0 );
		$config->set( 'slideshow.photo_scroller.thumbnail.height', get_post_meta( $post_id, "{$prefix}photo_scroller_thumbnails_height", true ), 85 );

		$config->set( 'slideshow.photo_scroller.behavior.landscape.width.max', get_post_meta( $post_id, "{$prefix}photo_scroller_ls_max_width", true ), '100' );
		$config->set( 'slideshow.photo_scroller.behavior.landscape.width.min', get_post_meta( $post_id, "{$prefix}photo_scroller_ls_min_width", true ), '0' );
		$config->set( 'slideshow.photo_scroller.behavior.landscape.fill.desktop', get_post_meta( $post_id, "{$prefix}photo_scroller_ls_fill_dt", true ), 'fit' );
		$config->set( 'slideshow.photo_scroller.behavior.landscape.fill.mobile', get_post_meta( $post_id, "{$prefix}photo_scroller_ls_fill_mob", true ), 'fit' );

		$config->set( 'slideshow.photo_scroller.behavior.portrait.width.max', get_post_meta( $post_id, "{$prefix}photo_scroller_pt_max_width", true ), '100' );
		$config->set( 'slideshow.photo_scroller.behavior.portrait.width.min', get_post_meta( $post_id, "{$prefix}photo_scroller_pt_min_width", true ), '0' );
		$config->set( 'slideshow.photo_scroller.behavior.portrait.fill.desktop', get_post_meta( $post_id, "{$prefix}photo_scroller_pt_fill_dt", true ), 'fit' );
		$config->set( 'slideshow.photo_scroller.behavior.portrait.fill.mobile', get_post_meta( $post_id, "{$prefix}photo_scroller_pt_fill_mob", true ), 'fit' );
	}

endif;

if ( ! function_exists( 'presscore_config_logo_options' ) ) :

	function presscore_config_logo_options() {
		$config = presscore_config();
		$post_id = $config->get( 'post_id' );

		$config->set( 'logo.header.regular', of_get_option( 'header-logo_regular', array( '', 0 ) ) );
		$config->set( 'logo.header.hd', of_get_option( 'header-logo_hd', array( '', 0 ) ) );

		$config->set( 'logo.header.transparent.style', of_get_option( 'header-style-transparent-choose_logo' ) );
		$config->set( 'logo.header.transparent.regular', of_get_option( 'header-style-transparent-logo_regular', array( '', 0 ) ) );
		$config->set( 'logo.header.transparent.hd', of_get_option( 'header-style-transparent-logo_hd', array( '', 0 ) ) );

		$config->set( 'logo.header.floating.regular', of_get_option( 'header-style-floating-logo_regular', array( '', 0 ) ) );
		$config->set( 'logo.header.floating.hd', of_get_option( 'header-style-floating-logo_hd', array( '', 0 ) ) );

		if ( presscore_header_is_transparent() && ! presscore_header_layout_is_side() ) {
			$config->set( 'header.mobile.logo.first_switch', of_get_option( 'header-transparent-mobile-first_switch-logo' ) );
			$config->set( 'header.mobile.logo.second_switch', of_get_option( 'header-transparent-mobile-second_switch-logo' ) );
		}
	}

endif;

//////////////////////
// SIDEBAR SETTINGS //
//////////////////////

if ( ! function_exists( 'presscore_config_populate_sidebar_and_footer_options' ) ) :

	function presscore_config_populate_sidebar_and_footer_options() {

		$config = presscore_config();

		$post_id = $config->get( 'post_id' );

		/////////////////////////
		// Template settings //
		/////////////////////////

		$prefix = '_dt_sidebar_';

		// Sidebar options
		$config->set( 'sidebar_position', get_post_meta( $post_id, "{$prefix}position", true ), 'right' );
		$config->set( 'sidebar_hide_on_mobile', get_post_meta( $post_id, "{$prefix}hide_on_mobile", true ), false );
		$config->set( 'sidebar_widgetarea_id', get_post_meta( $post_id, "{$prefix}widgetarea_id", true ) );

		// Footer options
		$prefix = '_dt_footer_';
		$config->set( 'footer_show', get_post_meta( $post_id, "{$prefix}show", true ), true );
		$config->set( 'footer_hide_on_mobile', get_post_meta( $post_id, "{$prefix}hide_on_mobile", true ), false );
		$config->set( 'footer_widgetarea_id', get_post_meta( $post_id, "{$prefix}widgetarea_id", true ) );

	}

endif;

function presscore_config_populate_page_overrides() {
	$config = presscore_config();
	$post_id = $config->get( 'post_id' );

	$prefix = '_dt_page_overrides_';
	$config->set( 'page.top_margin', get_post_meta( $post_id, "{$prefix}top_margin", true ) );
	$config->set( 'page.bottom_margin', get_post_meta( $post_id, "{$prefix}bottom_margin", true ) );
}

////////////////////////
// BLOG POST SETTINGS //
////////////////////////

if ( ! function_exists( 'presscore_populate_post_config' ) ) :

	function presscore_populate_post_config( $target_post_id = 0 ) {

		$config = Presscore_Config::get_instance();
		global $post;

		if ( $target_post_id ) {
			$post_id = $target_post_id;

		} elseif ( $post && !empty( $post->ID ) ) {
			$post_id = $post->ID;

		} else {
			return false;

		}

		$prefix = '_dt_post_options_';

		/////////////////////////
		// post preview width //
		/////////////////////////

		if ( 'list' == presscore_get_current_layout_type() ) {

			$post_preview_media_width = $config->get( 'post.preview.media.width' );
			if ( $post_preview_media_width >= 100 ) {
				$post_preview_width = 'wide';

			} else {
				$post_preview_width = get_post_meta( $post_id, "{$prefix}preview", true );

			}

		} else {
			$post_preview_width = get_post_meta( $post_id, "{$prefix}preview", true );

		}

		$config->set( 'post.preview.width', $post_preview_width, 'normal' );
		$config->set( 'post.preview.gallery.style', 'slideshow' );
		$config->set( 'post.preview.gallery.sideshow.proportions', array( 'width' => 3, 'height' => 2 ) );

		return true;
	}

endif;

if ( ! function_exists( 'presscore_congif_populate_single_attachment_vars' ) ) :

	function presscore_congif_populate_single_attachment_vars( $target_post_id = 0 ) {

		global $post;

		if ( $target_post_id ) {
			$post_id = $target_post_id;

		} elseif ( $post && !empty( $post->ID ) ) {
			$post_id = $post->ID;

		} else {
			return false;

		}

		$config = presscore_get_config();

		$config->set( 'sidebar_position', 'disabled' );
		$config->set( 'footer_show', false );

		return true;
	}

endif;

if ( ! function_exists( 'presscore_config_get_theme_option' ) ) :

	function presscore_config_get_theme_option() {
		$config = presscore_config();

		$config->map( array(
			'template.content.boxes.background.decoration'        => array( 'option', 'general-content_boxes_decoration', 'none' ),
			'template.content.width'                              => array( 'option', 'general-content_width', '1200px' ),
			'template.beautiful_loading.enabled'                  => array( 'option', 'general-beautiful_loading', 'enabled' ),
			'template.beautiful_loading.loadr.style'              => array( 'option', 'general-loader_style', 'double_circles' ),
			'template.beautiful_loading.loadr.custom_code'        => array( 'option', 'general-custom_loader' ),
			'template.lightbox.overlay.opacity'                          => array( 'option', 'general-lightbox_overlay_opacity', 85 ),
			'template.accent.color.mode'                          => array( 'option', 'general-accent_color_mode', 'color' ),
			'template.layout'                                     => array( 'option', 'general-layout', 'wide' ),
			'template.posts_filter.style'                         => array( 'option', 'general-filter_style', 'ios' ),
			'template.images.hover.style'                         => array( 'option', 'image_hover-style', 'none' ),

			'buttons.style'                                       => array( 'option', 'buttons-style', 'flat' ),
			'buttons.background'                                  => array( 'option', 'buttons-color_mode', 'accent' ),
			'buttons.text.color'                                  => array( 'option', 'buttons-text_color_mode', 'accent' ),
			'buttons.hover.background'                            => array( 'option', 'buttons-hover_color_mode', 'accent' ),
			'buttons.hover.text.color'                            => array( 'option', 'buttons-text_hover_color_mode', 'accent' ),
			'header.floating_navigation.style'                    => array( 'option', 'header-floating_navigation-style', 'fade' ),
			'header.floating_navigation.logo.style'               => array( 'option', 'header-style-floating-choose_logo', 'custom' ),
			'header.floating_navigation.enabled'                  => array( 'option', 'header-show_floating_navigation', '1' ),
			'header.floating_navigation.show_after'               => array( 'option', 'header-floating_navigation-show_after', '150' ),
			'header.floating_navigation.decoraion'                => array( 'option', 'header-floating_navigation-decoration' ),
			'header.floating_top-bar.enabled'                => array( 'option', 'header-floating_navigation-top-bar', '0' ),
			
			'header.top_bar.background.mode'                      => array( 'option', 'top_bar-bg-style', 'content_line' ),
			'header.top_bar.transparent.line'                      => array( 'option', 'top_bar-line-in-transparent-header' ),
			'page_title.enabled'                                  => array( 'option', 'general-show_titles' ),
			'page_title.align'                                    => array( 'option', 'general-title_align' ),
			'page_title.font.color'                               => array( 'option', 'general-title_color' ),
			'page_title.height'                                   => array( 'option', 'general-title_height' ),
			'page_title.breadcrumbs.enabled'                      => array( 'option', 'general-show_breadcrumbs' ),
			'page_title.breadcrumbs.mobile.enabled'                      => array( 'option', 'general-title_responsive_breadcrumbs' ),
			'page_title.breadcrumbs.font.color'                   => array( 'option', 'general-breadcrumbs_color' ),
			'page_title.breadcrumbs.background.mode'              => array( 'option', 'general-breadcrumbs_bg_color' ),
			'page_title.background.mode'                          => array( 'option', 'general-title_bg_mode' ),
			'page_title.background.img'                          => array( 'option', 'general-title_enable_bg_img' ),
			'page_title.background.color'                         => array( 'option', 'general-title_bg_color' ),
			'page_title.decoration'                               => array( 'option', 'general-title_decoration', 'none' ),
			'page_title.background.image'                         => array( 'option', 'general-title_bg_image' ),
			'page_title.background.fullscreen'                    => array( 'option', 'general-title_bg_fullscreen' ),
			'page_title.background.responsiveness'                         => array( 'option', 'general-titles_responsiveness' ),
			'page_title.background.overlay'                         => array( 'option', 'general-title_bg_overlay' ),
			'page_title.background.parallax'                => array( 'option', 'general-title_scroll_effect' ),
			'page_title.background.parallax_speed'                => array( 'option', 'general-title_bg_parallax' ),
			'header_background'                                   => array( 'option', 'header-background', 'normal' ),
			'header.transparent.background.opacity'               => array( 'option', 'header-transparent_bg_opacity', 50 ),
			'header.transparent.background.color'                 => array( 'option', 'header-transparent_bg_color', '#000000' ),
			'header.transparent.color_scheme'                     => array( 'option', 'page_title-background-style-transparent-color_scheme' ),
			'header.layout'                                       => array( 'option', 'header-layout', 'inline' ),
			'header.navigation'                                       => array( 'option', 'header_navigation' ),
			'header.mobile.logo.first_switch.layout'              => array( 'option', 'header-mobile-first_switch-layout' ),
			'header.mobile.logo.second_switch.layout'             => array( 'option', 'header-mobile-second_switch-layout' ),
			'header.mobile.logo.first_switch'                     => array( 'option', 'header-mobile-first_switch-logo', 'mobile' ),
			'header.mobile.logo.second_switch'                    => array( 'option', 'header-mobile-second_switch-logo', 'mobile' ),
			'header.mobile.floatin_navigation'                    => array( 'option', 'header-mobile-floating_navigation' ),
			'header.mobile.menu.align'                            => array( 'option', 'header-mobile-menu-align', 'left' ),
			'header.mobile.menu_icon.size'                              => array( 'option', 'header-mobile-menu_icon-size' ),
			'header.mobile.menu_icon.bg.enable'                              => array( 'option', 'header-mobile-menu_icon-bg-enable' ),
			'header.menu.submenu.parent_clickable'                => array( 'option', 'header-menu-submenu-parent_is_clickable', true ),
			'header.menu.hover.decoration.style'                  => array( 'option', 'menu-decoration_style', '' ),
			'header.decoration'                                   => array( 'option', 'header-decoration', 'shadow' ),
			'header.elements.search.caption'                      => array( 'option', 'header-elements-search-caption' ),
			'header.elements.search.input.caption'                      => array( 'option', 'header-elements-search-input-caption' ),
			'header.elements.search.icon.enabled'                 => array( 'option', 'header-elements-search-icon', 'custom'),
			'header.elements.search.icon.custom'                 => array( 'option', 'header-elements-search_custom-icon', true ),
			'header.elements.search.style'                 => array( 'option', 'microwidgets-search_style', true ),
			'header.elements.search.icon'                 => array( 'option', 'microwidgets-search_icon', true ),
			'header.elements.search.custom.icon'                 => array( 'option', 'microwidgets-search_custom-icon', true ),
			'header.elements.login.caption'                       => array( 'option', 'header-elements-login-caption' ),
			'header.elements.logout.caption'                      => array( 'option', 'header-elements-logout-caption' ),
			'header.elements.login.icon.enabled'                  => array( 'option', 'header-elements-login-icon', 'custom' ),
			'header.elements.login.url'                           => array( 'option', 'header-elements-login-url' ),

			'product.related.show_cart_btn'                  => array( 'option', 'woocommerce-related_btn'),
		) );

		$sidebar_style = of_get_option( 'sidebar-visual_style', 'with_dividers' );
		$config->set( 'sidebar.style', $sidebar_style );
		$config->set( 'sidebar.style.dividers.vertical', 'with_dividers' === $sidebar_style && of_get_option( 'sidebar-divider-vertical', true ) );
		$config->set( 'sidebar.style.dividers.horizontal', 'with_widgets_bg' !== $sidebar_style && of_get_option( 'sidebar-divider-horizontal', true ) );
		$config->set( 'sidebar.style.background.decoration', of_get_option( 'sidebar-decoration', 'none' ) );
		$config->set( 'sidebar.sticky', of_get_option( 'sidebar-floating' ) );

		// footer
		$footer_style = of_get_option( 'footer-style', 'full_width_line' );
		$config->set( 'template.footer.style', $footer_style );

		if ( 'solid_background' == $footer_style ) {
			$footer_slideout_mode = of_get_option( 'footer-slide-out-mode', false );
		} else {
			$footer_slideout_mode = false;
		}
		$config->set( 'template.footer.background.slideout_mode', $footer_slideout_mode );

		$config->set( 'template.footer.layout', of_get_option( 'footer-layout', '1/4+1/4+1/4+1/4' ) );
		$config->set( 'template.footer.decoration', of_get_option( 'footer-decoration', 'none' ) );

		// bottom bar
		$config->set( 'template.bottom_bar.enabled', of_get_option( 'bottom_bar-enabled' ) );
		$config->set( 'template.bottom_bar.style', of_get_option( 'bottom_bar-style', 'full_width_line' ) );
		$config->set( 'template.bottom_bar.layout', of_get_option( 'bottom_bar-layout', 'logo_left' ) );
		$config->set( 'template.bottom_bar.copyrights', of_get_option( 'bottom_bar-copyrights', '' ) );
		$config->set( 'template.bottom_bar.text', of_get_option( 'bottom_bar-text', '' ) );
		$config->set( 'template.bottom_bar.credits', of_get_option( 'bottom_bar-credits', true ) );

		// header layouts
		$header = 'header-' . $config->get( 'header.layout' ) . '-';
		$header_mixed = 'header-' . $config->get( 'header.navigation' ) . '-';

		$header_raw = $config->get( 'header.layout' );
        if ( in_array( $header_raw, array( 'top_line', 'side_line', 'menu_icon' ) ) ) {
            // Config for mixed headers
            $config->map( array(
               'header.logo.position'                                     => array( 'option', "{$header_mixed}logo-position" ),
               'header.menu.position'                                     => array( 'option', "{$header_mixed}menu-position" ),
               'header.content.position'                                  => array( 'option', "{$header_mixed}content-position" ),
				'header.position'                                          => array( 'option', "{$header_mixed}position" ),
				'header.menu.items.alignment'                              => array( 'option', "{$header_mixed}menu-items_alignment" ),
				'header.menu.items.link'                                   => array( 'option', "{$header_mixed}menu-items_link" ),
            ));
        } else {
            $header = 'header-' . $header_raw . '-';
            // Config for inline headers
            $config->map( array(
               'header.logo.position'                                     => array( 'option', "{$header}logo-position" ),
               'header.menu.position'                                     => array( 'option', "{$header}menu-position" ),
               'header.content.position'                                  => array( 'option', "{$header}content-position" ),
				'header.position'                                          => array( 'option', "{$header}position" ),
				'header.menu.items.alignment'                              => array( 'option', "{$header}menu-items_alignment" ),
				'header.menu.items.link'                                   => array( 'option', "{$header}menu-items_link" ),
            ));
        }

		$config->map( array(
			'header.elements.enabled'                                  => array( 'option', "{$header}show_elements" ),
			'header.elements'                                          => array( 'option', "{$header}elements" ),
			'header.is_fullwidth'                                      => array( 'option', "{$header}is_fullwidth" ),
			'header.menu.items.margins.style'                          => array( 'option', 'header-menu-item-surround_margins-style' ),
			'header.menu.background.style'                             => array( 'option', "{$header}menu-bg-style" ),
			'header.menu.show_next_lvl_icons'                          => array( 'option', 'header-menu-show_next_lvl_icons', true ),
			'header.menu.dividers.enabled'                             => array( 'option', 'header-menu-show_dividers' ),
			'header.menu.dividers.surround'                            => array( 'option', 'header-menu-dividers-surround' ),
			'header.menu.decoration.style'                             => array( 'option', 'header-menu-decoration-style' ),
			'header.menu.decoration.style.underline.direction'         => array( 'option', 'header-menu-decoration-underline-direction' ),
			'header.menu.decoration.style.other.hover.style'           => array( 'option', 'header-menu-decoration-other-hover-style' ),
			'header.menu.decoration.style.other.hover.line.enabled'    => array( 'option', 'header-menu-decoration-other-hover-line' ),
			'header.menu.decoration.style.other.active.style'          => array( 'option', 'header-menu-decoration-other-active-style' ),
			'header.menu.decoration.style.other.active.line.enabled'   => array( 'option', 'header-menu-decoration-other-active-line' ),
			'header.menu.decoration.style.other.links.is_justified'    => array( 'option', 'header-menu-decoration-other-links-is_justified' ),
			'header.menu.hover.color.style'                            => array( 'option', 'header-menu-hover-font-color-style' ),
			'header.menu.submenu.hover.color.style'                    => array( 'option', 'header-menu-submenu-hover-font-color-style' ),
			'header.menu.submenu.show_next_lvl_icons'                  => array( 'option', 'header-menu-submenu-show_next_lvl_icons', true ),
			'header.menu.submenu.background.hover.style'               => array( 'option', 'header-menu-submenu-bg-hover' ),
			
			'header.layout.slide_out.animation'                        => array( 'option', "header-slide_out-overlay-animation" ),
			
			'header.layout.side.menu.submenu.position'                 => array( 'option', 'header-side-menu-submenu-position' ),
			'header.decoration'                                        => array( 'option', 'header-decoration' ),
			'header.mixed.decoration'                                  => array( 'option', 'header-mixed-decoration' ),
			'header.mixed.menu_icon.size'                              => array( 'option', 'header-menu_icon-size' ),
			'header.mixed.view'                                        => array( 'option', "{$header}layout" ),
			'header.mixed.navigation'                                  => array( 'option', 'header_navigation' ),
			'header.mixed.view.menu_icon.floating_logo.enabled'        => array( 'option', "layout-menu_icon-show_floating_logo" ),
			'header.mixed.view.menu_icon.position'        => array( 'option', "layout-menu_icon-position" ),
			'header.mixed.view.top_line.is_fullwidth'                  => array( 'option', "layout-top_line-is_fullwidth" ),
			'header.mixed.view.top_line.is_sticky'                     => array( 'option', "layout-top_line-is_sticky" ),
			'header.mixed.view.top_line.logo.position'                 => array( 'option', "layout-top_line-logo-position" ),
			'header.mixed.view.side_line.position'                     => array( 'option', "layout-side_line-position" ),
			'header.mixed.view.side_line_v.position'                     => array( 'option', "layout-side_line-v_position" ),
			'header.mixed.floating_top-bar.enabled'                => array( 'option', 'header-mixed-floating-top-bar', '0' ),
		) );
	}

endif;

if ( ! function_exists( 'presscore_config_filter_values' ) ) :

	function presscore_config_filter_values() {
		$config = presscore_get_config();

		if ( $config->get( 'justified_grid' ) ) {

			if ( 'on_hoover' == $config->get( 'post.preview.description.style' ) ) {
				$config->set( 'post.preview.description.style', 'on_hoover_centered' );
			}
		}
	}

	add_action( 'presscore_config_base_init', 'presscore_config_filter_values' );

endif;
