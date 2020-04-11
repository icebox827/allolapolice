<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

function the7_elementor_elements_widget_post_types() {
	$post_types = array_intersect_key(
		get_post_types( [], 'object' ),
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

	$supported_post_types['current_query'] = __( 'Archive (current query)', 'the7mk2' );

	return $supported_post_types;
}
