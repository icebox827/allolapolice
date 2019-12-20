<?php
/**
 * Template Name: Microsite
 *
 * Template Post Type: post, page, dt_portfolio
 *
 * @since   3.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

presscore_config()->set( 'template', 'microsite' );
get_header();

if ( presscore_is_content_visible() ) {
	presscore_get_template_part( 'theme', 'microsite/microsite', get_post_type() );
}

get_footer();
