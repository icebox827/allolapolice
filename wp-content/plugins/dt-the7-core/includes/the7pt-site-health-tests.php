<?php
/**
 * The7 Elements site health tests.
 *
 * @package The7Elements\Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add the7 Elements tests.
 *
 * @param array $tests Tests array.
 *
 * @return array
 */
function the7pt_add_site_health_tests( $tests ) {
	$tests['direct']['the7_unused_elements'] = array(
		'label' => __( 'The7 Elements unused post types', 'dt-the7-core' ),
		'test'  => 'the7pt_site_health_unused_post_types_test',
	);

	return $tests;
}

add_filter( 'site_status_tests', 'the7pt_add_site_health_tests' );

/**
 * Tests for unused post types.
 *
 * @return array
 */
function the7pt_site_health_unused_post_types_test() {
	global $wpdb;

	$result = array(
		'label'       => __( 'All active The7 Elements post types are in use', 'dt-the7-core' ),
		'status'      => 'good',
		'badge'       => array(
			'label' => __( 'Performance', 'dt-the7-core' ),
			'color' => 'blue',
		),
		'description' => sprintf(
			'<p>%s</p>',
			__( 'Disabling unused post types increase overall installation performance.', 'dt-the7-core' )
		),
		'actions'     => '',
		'test'        => 'the7pt_site_health_unused_post_types_test',
	);

	if ( ! class_exists( 'The7_Admin_Dashboard_Settings' ) ) {
		return $result;
	}

	$unused_post_types = array();
	$query             = "SELECT post_type, COUNT(*) AS num_posts FROM {$wpdb->posts} GROUP BY post_type";
	$posts_count       = (array) $wpdb->get_results( $query, ARRAY_A );
	$posts_count       = wp_list_pluck( $posts_count, 'num_posts', 'post_type' );

	$modules_to_post_types = array(
		'albums'       => 'dt_gallery',
		'portfolio'    => 'dt_portfolio',
		'benefits'     => 'dt_benefits',
		'logos'        => 'dt_logos',
		'team'         => 'dt_team',
		'testimonials' => 'dt_testimonials',
		'slideshow'    => 'dt_slideshow',
	);
	foreach ( $modules_to_post_types as $module => $post_type ) {
		if ( empty( $posts_count[ $post_type ] ) && The7_Admin_Dashboard_Settings::get( $module ) ) {
			$post_type_object = get_post_type_object( $post_type );
			if ( $post_type_object ) {
				$unused_post_types[] = '<li>' . $post_type_object->labels->name . '</li>';
			}
		}
	}

	if ( $unused_post_types ) {
		$unused_post_types = '<br><ol>' . implode( '', $unused_post_types ) . '</ol><br>';

		$result['status']         = 'recommended';
		$result['label']          = __( 'Some of the The7 Elements post types can be disabled', 'dt-the7-core' );
		$result['badge']['color'] = 'blue';
		$result['actions']        = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'admin.php?page=the7-dashboard' ) ),
			__( 'Manage The7 Post Types and Elements', 'dt-the7-core' )
		);
		$result['description']    = sprintf(
			'<p>%s</p>',
			sprintf(
				// translators: $s - remote server url.
				__(
					'Following post types are not used:%sIt is recommended to disable unused post types to increase overall installation performance.',
					'dt-the7-core'
				),
				$unused_post_types
			)
		);
	}

	return $result;
}