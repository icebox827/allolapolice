<?php
/**
 * Albums slug options.
 *
 * @package the7
 * @since 3.1.5
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$new_options['general-post_type_gallery_slug'] = array(
	'id' => 'general-post_type_gallery_slug',
	'name' => _x('Albums slug', 'theme-options', 'dt-the7-core'),
	'std' => 'dt_gallery',
	'type' => 'text',
	'class' => 'mini',
);

// add new options
if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'posts_slugs_placeholder' );
}

// cleanup
unset( $new_options );
