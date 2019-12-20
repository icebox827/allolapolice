<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$new_options = array();

$new_options[] = array( 'name' => _x( 'Social buttons in products', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$new_options['social_buttons-product-button_title'] = array(
	'name' => _x( 'Button title', 'theme options', 'the7mk2' ),
	'id'   => 'social_buttons-product-button_title',
	'std'  => _x( 'Share this product', 'theme options', 'the7mk2' ),
	'type' => 'text',
);

$new_options[] = array( 'type' => 'divider' );

$new_options[] = array(
	'desc' => _x( 'Drag and drop desired share buttons from right (inactive) to left (active) pane.', 'theme options', 'the7mk2' ),
	'type' => 'info',
);

$new_options['social_buttons-product'] = array(
	'id'   => 'social_buttons-product',
	'std'  => array(),
	'type' => 'social_buttons',
);

// add new options
if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'social_buttons-bottom-placeholder' );
}

// cleanup
unset( $new_options );
