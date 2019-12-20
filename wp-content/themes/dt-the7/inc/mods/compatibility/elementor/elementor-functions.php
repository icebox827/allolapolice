<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

function the7_elementor_elements_widget_post_types() {
	$post_types           = get_post_types( [], 'object' );
	$post_types           = array_intersect_key(
		$post_types,
		[
			'post'            => '',
			'dt_portfolio'    => '',
			'dt_team'         => '',
			'dt_testimonials' => '',
			'dt_gallery'      => '',
		]
	);
	$supported_post_types = [];
	foreach ( $post_types as $post_type ) {
		$supported_post_types[ $post_type->name ] = $post_type->label;
	}

	return $supported_post_types;
}
