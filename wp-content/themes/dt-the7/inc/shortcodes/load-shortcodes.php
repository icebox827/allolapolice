<?php
/**
 * Shortcodes setup.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once PRESSCORE_SHORTCODES_DIR . '/class-dt-vc-responsive-columns-param.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/class-register-button-wp-3.9.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/class-shortcode.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/class-shortcode-masonry-posts.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/puny-shortcodes-functions.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/shortcodes-animation-functions.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/shortcodes-hooks.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/class-the7-vc-taxonomy-autocomplete.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/class-the7-vc-posts-autocomplete.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/class-the7-orphaned-shortcodes-handler.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/shortcodes-functions.php';
require_once PRESSCORE_SHORTCODES_INCLUDES_DIR . '/abstract-dt-shortcode-with-inline-css.php';

/**
 * Handle shortcodes outside of page content.
 */
$orphaned_shortcodes_handler = new The7_Orphaned_Shortcodes_Handler();
add_action( 'admin_init', array( $orphaned_shortcodes_handler, 'add_cache_invalidation_hooks' ) );
add_action( 'presscore_body_top', array( $orphaned_shortcodes_handler, 'add_hooks' ) );
add_action( 'presscore_before_main_container', array( $orphaned_shortcodes_handler, 'remove_hooks' ) );
add_action( 'dynamic_sidebar_before', array( $orphaned_shortcodes_handler, 'add_hooks' ) );
add_action( 'dynamic_sidebar_after', array( $orphaned_shortcodes_handler, 'remove_hooks' ) );
add_action( 'presscore_credits', array( $orphaned_shortcodes_handler, 'add_hooks' ) );

/**
 * Register theme template parts dir.
 */
presscore_template_manager()->add_path( 'shortcodes', 'inc/shortcodes/includes' );

$tinymce_button = new DT_ADD_MCE_BUTTON('', '');

// List of shortcodes folders to include
// All folders located in /include
$presscore_shortcodes = array(
	'accordion',
	'animated-text',
	'banner',
	'before-after',
	'blog-posts',
	'blog-list',
	'blog-masonry',
	'blog-carousel',
	'blog-posts-small',
	'blog-slider',
	'box',
	'button',
	'call-to-action',
	'code',
	'columns',
	'contact-form',
	'divider',
	'fancy-image',
	'fancy-separators-vc',
	'fancy-titles-vc',
	'fancy-video-vc',
	'gallery',
	'gap',
	'highlight',
	'list',
	'list-vc',
	'map',
	'progress-bars',
	'quote',
	'shortcode-teasers',
	'simple-login',
	'social-icons',
	'stripes',
	'tabs',
	'toggles',
	'tooltips',
	'breadcrumbs',
	'carousel',
	'default-button',
	'soc-icons',
	'single-soc-icon',
	'media-gallery-masonry',
	'media-gallery-carousel',
	'icon',
	'text-with-icon',
);

if ( dt_is_woocommerce_enabled() ) {
	$presscore_shortcodes[] = 'products-carousel';
	$presscore_shortcodes[] = 'products-masonry';
}

$presscore_shortcodes = apply_filters( 'presscore_shortcodes', $presscore_shortcodes );

foreach ( $presscore_shortcodes as $shortcode_dirname ) {
	include_once locate_template( 'inc/shortcodes/includes/' . $shortcode_dirname . '/' . $shortcode_dirname . '.php' );
}
