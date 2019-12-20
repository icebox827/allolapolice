<?php
/**
 * Arhive content.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

presscore_config()->set( 'show_details', false );
presscore_get_template_part( 'theme', 'blog/masonry/blog-masonry-post' );
