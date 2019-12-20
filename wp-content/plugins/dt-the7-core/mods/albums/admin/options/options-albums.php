<?php
/**
 * Templates settings
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$new_options = array();

/**
 * Heading definition.
 */
$new_options[] = array(
	'name' => _x( 'Gallery', 'theme-options', 'dt-the7-core' ),
	'type' => 'heading',
	'id'   => 'gallery',
);

/**
 * Previous &amp; next buttons
 */
$new_options[] = array(
	'name' => _x( 'Previous & next buttons', 'theme-options', 'dt-the7-core' ),
	'type' => 'block',
);

// checkbox
$new_options['general-next_prev_in_album'] = array(
	'name'    => _x( 'Show in gallery albums', 'theme-options', 'dt-the7-core' ),
	'id'      => 'general-next_prev_in_album',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 1,
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/general-next-prev-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

/**
 * Back button.
 */
$new_options[] = array( 'name' => _x( 'Back button', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$new_options['general-show_back_button_in_album'] = array(
	'name'      => _x( 'Back button', 'theme-options', 'dt-the7-core' ),
	'id'        => 'general-show_back_button_in_album',
	'std'       => '0',
	'type'      => 'images',
	'class'     => 'small',
	'options'   => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/general-show-back-button-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$new_options['general-album_back_button_url'] = array(
	'name'       => _x( 'Back button url', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-album_back_button_url',
	'type'       => 'text',
	'std'        => '',
	'class'      => 'wide',
	'dependency' => array(
		'field'    => 'general-show_back_button_in_album',
		'operator' => '==',
		'value'    => '1',
	),
);

/**
 * Meta information.
 */
$new_options[] = array( 'name' => _x( 'Meta information', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$new_options['general-album_meta_on'] = array(
	'name'      => _x( 'Meta information', 'theme-options', 'dt-the7-core' ),
	'id'        => 'general-album_meta_on',
	'std'       => '1',
	'type'      => 'images',
	'class'     => 'small',
	'options'   => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/general-album_meta_on-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
	'show_hide' => array( '1' => true ),
);

$new_options[] = array( 'type' => 'js_hide_begin' );

$new_options['general-album_meta_date'] = array(
	'name' => _x( 'Date', 'theme-options', 'dt-the7-core' ),
	'id'   => 'general-album_meta_date',
	'type' => 'checkbox',
	'std'  => 1,
);

$new_options['general-album_meta_author'] = array(
	'name' => _x( 'Author', 'theme-options', 'dt-the7-core' ),
	'id'   => 'general-album_meta_author',
	'type' => 'checkbox',
	'std'  => 1,
);

$new_options['general-album_meta_categories'] = array(
	'name' => _x( 'Categories', 'theme-options', 'dt-the7-core' ),
	'id'   => 'general-album_meta_categories',
	'type' => 'checkbox',
	'std'  => 1,
);

$new_options['general-album_meta_comments'] = array(
	'name' => _x( 'Comments', 'theme-options', 'dt-the7-core' ),
	'id'   => 'general-album_meta_comments',
	'type' => 'checkbox',
	'std'  => 1,
);

$new_options[] = array( 'type' => 'js_hide_end' );

// add new options
if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'blog_and_portfolio_placeholder' );
}

// cleanup
unset( $new_options );
