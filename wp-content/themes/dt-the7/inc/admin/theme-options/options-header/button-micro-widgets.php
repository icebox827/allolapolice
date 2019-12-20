<?php
defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name'                => _x( 'Button 1', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-button-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-button-1' );

presscore_options_apply_template( $options, 'header-element-button', 'header-elements-button-1' );

// Button 2.
$options[] = array(
	'name'                => _x( 'Button 2', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-button-2-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);
presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-button-2' );

presscore_options_apply_template( $options, 'header-element-button', 'header-elements-button-2' );
