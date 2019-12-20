<?php
/**
 * Share buttons.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Heading definition.
 */
$options[] = array(
	'name' => _x( 'Share Buttons', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'share-buttons',
);

/**
 * Share buttons settings.
 */
$options[] = array( 'name' => _x( 'Share buttons appearance', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['social_buttons-visibility'] = array(
	'name'    => _x( 'Share buttons appearance', 'theme-options', 'the7mk2' ),
	'id'      => 'social_buttons-visibility',
	'std'     => 'on_hover',
	'type'    => 'images',
	'options' => array(
		'on_hover' => array(
			'title' => _x( 'Show on hover', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/social_buttons-visibility-hover.gif',
		),
		'allways'  => array(
			'title' => _x( 'Always visible', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/social_buttons-visibility-visible.gif',
		),
	),
);

$share_buttons_titles = array(
	'post'           => _x( 'Share this post', 'theme options', 'the7mk2' ),
	'portfolio_post' => _x( 'Share this post', 'theme options', 'the7mk2' ),
	'photo'          => _x( 'Share this image', 'theme options', 'the7mk2' ),
	'page'           => _x( 'Share this page', 'theme options', 'the7mk2' ),
);

foreach ( presscore_themeoptions_get_template_list() as $id => $desc ) {

	/**
	 * Share buttons.
	 */
	$options[] = array( 'name' => $desc, 'type' => 'block' );

	$options["social_buttons-{$id}-button_title"] = array(
		'name' => _x( 'Button title', 'theme options', 'the7mk2' ),
		'id'   => "social_buttons-{$id}-button_title",
		'std'  => ( isset( $share_buttons_titles[ $id ] ) ? $share_buttons_titles[ $id ] : '' ),
		'type' => 'text',
	);

	$options[] = array( 'type' => 'divider' );

	$options[] = array(
		'desc' => _x( 'Drag and drop desired share buttons from right (inactive) to left (active) pane.', 'theme options', 'the7mk2' ),
		'type' => 'info',
	);

	$options["social_buttons-{$id}"] = array(
		'id'   => "social_buttons-{$id}",
		'std'  => array(),
		'type' => 'social_buttons',
	);
}

$options['social_buttons-bottom-placeholder'] = array();