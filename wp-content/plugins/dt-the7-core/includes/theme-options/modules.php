<?php
/**
 * Modules options.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$new_options = array();

$new_options[] = array( "name" => _x("Advanced", "theme-options", 'dt-the7-core'), "type" => "heading", "id" => "advanced" );

$new_options[] = array( 'name' => _x( 'Post types', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$new_options['modules-portfolio-status'] = array(
	'id' => 'modules-portfolio-status',
	'name' => _x( 'Portfolio', 'theme-options', 'dt-the7-core' ),
	'type' => 'radio',
	'std' => 'enabled',
	'options' => array(
		'enabled' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
		'disabled' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
	),
);

$new_options['modules-testimonials-status'] = array(
	'id' => 'modules-testimonials-status',
	'name' => _x( 'Testimonials', 'theme-options', 'dt-the7-core' ),
	'type' => 'radio',
	'std' => 'enabled',
	'options' => array(
		'enabled' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
		'disabled' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
	),
);

$new_options['modules-team-status'] = array(
	'id' => 'modules-team-status',
	'name' => _x( 'Team', 'theme-options', 'dt-the7-core' ),
	'type' => 'radio',
	'std' => 'enabled',
	'options' => array(
		'enabled' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
		'disabled' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
	),
);

$new_options['modules-logos-status'] = array(
	'id' => 'modules-logos-status',
	'name' => _x( 'Partners, Clients, etc.', 'theme-options', 'dt-the7-core' ),
	'type' => 'radio',
	'std' => 'enabled',
	'options' => array(
		'enabled' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
		'disabled' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
	),
);

$new_options['modules-benefits-status'] = array(
	'id' => 'modules-benefits-status',
	'name' => _x( 'Benefits', 'theme-options', 'dt-the7-core' ),
	'type' => 'radio',
	'std' => 'enabled',
	'options' => array(
		'enabled' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
		'disabled' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
	),
);

$new_options['modules-albums-status'] = array(
	'id' => 'modules-albums-status',
	'name' => _x( 'Photo Albums', 'theme-options', 'dt-the7-core' ),
	'type' => 'radio',
	'std' => 'enabled',
	'options' => array(
		'enabled' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
		'disabled' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
	),
);

$new_options['modules-slideshow-status'] = array(
	'id' => 'modules-slideshow-status',
	'name' => _x( 'Slideshows', 'theme-options', 'dt-the7-core' ),
	'type' => 'radio',
	'std' => 'enabled',
	'options' => array(
		'enabled' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
		'disabled' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
	),
);

$new_options[] = array( "name" => _x("Slugs", "theme-options", 'dt-the7-core'), "type" => "block" );

$new_options['posts_slugs_placeholder'] = array();

// add new options
if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'blog_and_portfolio_advanced_tab_placeholder' );
}

// cleanup
unset( $new_options );
