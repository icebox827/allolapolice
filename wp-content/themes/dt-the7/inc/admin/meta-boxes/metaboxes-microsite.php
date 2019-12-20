<?php
/**
 * Microsite meta boxes.
 *
 * @package the7
 * @since 2.2.0
 */

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) { exit; }

$nav_menus_clear = array( -1 => _x( 'Default menu', 'backend metabox', 'the7mk2' ) );
$nav_menus = wp_get_nav_menus();
foreach ( $nav_menus as $nav_menu ) {
	$nav_menus_clear[ $nav_menu->term_id ] = wp_html_excerpt( $nav_menu->name, 40, '&hellip;' );
}

$logo_field_title = _x( 'Logo:', 'backend metabox', 'the7mk2' );
$logo_hd_field_title = _x( 'High-DPI (retina) logo:', 'backend metabox', 'the7mk2' );

$prefix = '_dt_microsite_';

$DT_META_BOXES[] = array(
	'id'       => 'dt_page_box-microsite',
	'title'    => _x( 'Microsite', 'backend metabox', 'the7mk2' ),
	'pages'    => array( 'page', 'post', 'dt_portfolio' ),
	'context'  => 'side',
	'priority' => 'default',
	'fields'   => array(

		array(
			'name'    => _x( 'Page layout:', 'backend metabox', 'the7mk2' ),
			'id'      => "{$prefix}page_layout",
			'type'    => 'radio',
			'std'     => 'wide',
			'options' => array(
				'wide'  => _x( 'Full-width', 'backend metabox', 'the7mk2' ),
				'boxed' => _x( 'Boxed', 'backend metabox', 'the7mk2' ),
			),
		),

		array(
			'name'        => _x( 'Hide:', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}hidden_parts",
			'type'        => 'checkbox_list',
			'options'     => array(
				'top_bar'       => _x( 'top bar', 'backend metabox', 'the7mk2' ),
				'header'        => _x( 'header &amp; top bar', 'backend metabox', 'the7mk2' ),
				'floating_menu' => _x( 'floating menu', 'backend metabox', 'the7mk2' ),
				'content'       => _x( 'content area', 'backend metabox', 'the7mk2' ),
				'bottom_bar'    => _x( 'bottom bar', 'backend metabox', 'the7mk2' ),
			),
			'top_divider' => true,
		),

		array(
			'name'        => _x( 'Beautiful loading:', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}page_loading",
			'type'        => 'radio',
			'std'         => 'enabled',
			'options'     => array(
				'enabled'  => _x( 'Enabled', 'backend metabox', 'the7mk2' ),
				'disabled' => _x( 'Disabled', 'backend metabox', 'the7mk2' ),
			),
			'top_divider' => true,
		),

		array(
			'name'        => _x( 'Primary menu:', 'backend', 'the7mk2' ),
			'id'          => "{$prefix}primary_menu",
			'type'        => 'select',
			'options'     => $nav_menus_clear,
			'placeholder' => _x( 'Primary Menu location', 'backend metabox', 'the7mk2' ),
			'std'         => '',
			'top_divider' => true,
		),

		array(
			'name'        => _x( 'Split Menu Left:', 'backend', 'the7mk2' ),
			'id'          => "{$prefix}split_left_menu",
			'type'        => 'select',
			'options'     => $nav_menus_clear,
			'placeholder' => _x( 'Split Menu Left location', 'backend metabox', 'the7mk2' ),
			'std'         => '',
		),

		array(
			'name'        => _x( 'Split Menu Right:', 'backend', 'the7mk2' ),
			'id'          => "{$prefix}split_right_menu",
			'type'        => 'select',
			'options'     => $nav_menus_clear,
			'placeholder' => _x( 'Split Menu Right location', 'backend metabox', 'the7mk2' ),
			'std'         => '',
		),

		array(
			'name'        => _x( 'Mobile Menu:', 'backend', 'the7mk2' ),
			'id'          => "{$prefix}mobile_menu",
			'type'        => 'select',
			'options'     => $nav_menus_clear,
			'placeholder' => _x( 'Mobile Menu location', 'backend metabox', 'the7mk2' ),
			'std'         => '',
		),

	),
	'only_on' => array( 'template' => array( 'template-microsite.php' ) ),
);

$DT_META_BOXES[] = array(
	'id'       => 'dt_page_box-microsite_logo',
	'title'    => _x( 'Microsite Logo', 'backend metabox', 'the7mk2' ),
	'pages'    => array( 'page', 'post', 'dt_portfolio' ),
	'context'  => 'normal',
	'priority' => 'default',
	'fields'   => array(
		array(
			'name'        => _x( 'Logos target link:', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}logo_link",
			'type'        => 'text',
			'std'         => '',
		),

		array(
			'name' => _x( 'MAIN', 'backend metabox', 'the7mk2' ),
			'id'   => 'main_logo_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}main_logo_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}main_logo_regular", "{$prefix}main_logo_hd" ),
			)
		),

		array(
			'name'             => $logo_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}main_logo_regular",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => $logo_hd_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}main_logo_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name' => _x( 'TRANSPARENT HEADER', 'backend metabox', 'the7mk2' ),
			'id'   => 'transparent_logo_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}transparent_logo_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}transparent_logo_regular", "{$prefix}transparent_logo_hd" ),
			)
		),

		array(
			'name'             => $logo_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}transparent_logo_regular",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => $logo_hd_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}transparent_logo_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name' => _x( 'TOP LINE / SIDE LINE / FLOATING MENU BUTTON', 'backend metabox', 'the7mk2' ),
			'id'   => 'transparent_logo_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}mixed_logo_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}mixed_logo_regular", "{$prefix}mixed_logo_hd" ),
			)
		),

		array(
			'name'             => $logo_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}mixed_logo_regular",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => $logo_hd_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}mixed_logo_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name' => _x( 'FLOATING NAVIGATION', 'backend metabox', 'the7mk2' ),
			'id'   => 'floating_logo_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}floating_logo_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}floating_logo_regular", "{$prefix}floating_logo_hd" ),
			)
		),

		array(
			'name'             => $logo_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}floating_logo_regular",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => $logo_hd_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}floating_logo_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name' => _x( 'MOBILE HEADER', 'backend metabox', 'the7mk2' ),
			'id'   => 'transparent_logo_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}mobile_logo_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}mobile_logo_regular", "{$prefix}mobile_logo_hd" ),
			)
		),

		array(
			'name'             => $logo_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}mobile_logo_regular",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => $logo_hd_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}mobile_logo_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name' => _x( 'TRANSPARENT MOBILE HEADER', 'backend metabox', 'the7mk2' ),
			'id'   => 'transparent_logo_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}transparent_mobile_logo_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}transparent_mobile_logo_regular", "{$prefix}transparent_mobile_logo_hd" ),
			)
		),

		array(
			'name'             => $logo_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}transparent_mobile_logo_regular",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => $logo_hd_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}transparent_mobile_logo_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name' => _x( 'BOTTOM BAR', 'backend metabox', 'the7mk2' ),
			'id'   => 'bottom_logo_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}bottom_logo_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}bottom_logo_regular", "{$prefix}bottom_logo_hd" ),
			)
		),

		array(
			'name'             => $logo_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}bottom_logo_regular",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => $logo_hd_field_title,
			'desc'             => _x( 'Leave empty to hide logo.', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}bottom_logo_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name' => _x( 'FAVICON', 'backend metabox', 'the7mk2' ),
			'id'   => 'favicon_heading',
			'type' => 'heading',
		),

		array(
			'name'        => '',
			'id'          => "{$prefix}favicon_type",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Default', 'backend metabox', 'the7mk2' ),
				'custom' => _x( 'Custom', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields'	=> array(
				'default'	=> array("{$prefix}favicon"),
			)
		),

		array(
			'name'             => _x( 'Favicon:', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}favicon",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),

		array(
			'name'             => _x( 'High-DPI (retina) favicon:', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}favicon_hd",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),
	),
    'only_on' => array( 'template' => array( 'template-microsite.php' ) ),
);

unset( $nav_menus_clear, $logo_field_title, $logo_hd_field_title );
