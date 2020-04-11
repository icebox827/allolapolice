<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Header', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'header',
);


$options[] = array(
	'name' => _x( 'Navigation area appearance', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-bg-color'] = array(
	'id'   => 'header-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#000000',
);

$options['header-bg-image'] = array(
	'id'   => 'header-bg-image',
	'name' => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'type' => 'background_img',
	'std'  => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
);

$options['header-bg-is_fullscreen'] = array(
	'id'   => 'header-bg-is_fullscreen',
	'name' => _x( 'Fullscreen ', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 0,
);

$options['header-bg-is_fixed'] = array(
	'id'   => 'header-bg-is_fixed',
	'name' => _x( 'Fixed background ', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 0,
);

$options['header-decoration'] = array(
	'id'         => 'header-decoration',
	'name'       => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'type'       => 'images',
	'std'        => 'shadow',
	'options'    => array(
		'disabled'           => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-decoration-disabled.gif',
		),
		'shadow'             => array(
			'title' => _x( 'Shadow', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-decoration-shadow.gif',
		),
		'content-width-line' => array(
			'title' => _x( 'Content-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/topbar-bg-style-contentline.gif',
		),
		'line'               => array(
			'title' => _x( 'Full-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-decoration-line.gif',
		),
	),
	'class'      => 'small',
	'dependency' => array(
		array(
			array(
				'field'    => 'header_navigation',
				'operator' => '!=',
				'value'    => 'overlay',
			),
		),
		array(
			array(
				'field'    => 'header-layout',
				'operator' => 'NOT_IN',
				'value'    => array( 'top_line', 'menu_icon', 'side_line' ),
			),
		),
	),
);

$options['header-decoration-color']     = array(
	'id'         => 'header-decoration-color',
	'name'       => _x( 'Line color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		array(
			array(
				'field'    => 'header_navigation',
				'operator' => '!=',
				'value'    => 'overlay',
			),
			array(

				'field'    => 'header-decoration',
				'operator' => 'IN',
				'value'    => array( 'content-width-line', 'line' ),
			),

		),
		array(
			array(
				'field'    => 'header-layout',
				'operator' => 'NOT_IN',
				'value'    => array( 'top_line', 'menu_icon', 'side_line' ),
			),
			array(
				'field'    => 'header-decoration',
				'operator' => 'IN',
				'value'    => array( 'content-width-line', 'line' ),
			),
		),
	),
);
$options['header-decoration-line_size'] = array(
	'id'         => 'header-decoration-line_size',
	'name'       => _x( 'Line height', 'theme-options', 'the7mk2' ),
	'std'        => '1px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		array(
			array(
				'field'    => 'header_navigation',
				'operator' => '!=',
				'value'    => 'overlay',
			),
			array(
				'field'    => 'header-decoration',
				'operator' => 'IN',
				'value'    => array( 'content-width-line', 'line' ),
			),
		),
		array(
			array(
				'field'    => 'header-layout',
				'operator' => 'NOT_IN',
				'value'    => array( 'top_line', 'menu_icon', 'side_line' ),
			),
			array(
				'field'    => 'header-decoration',
				'operator' => 'IN',
				'value'    => array( 'content-width-line', 'line' ),
			),
		),
	),
);


$options[] = array(
	'name'       => _x( 'Menu background for "Classic" header', 'theme-options', 'the7mk2' ),
	'id'         => 'header-classic-menu-bg-block',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'classic',
	),
);

$options['header-classic-menu-bg-style'] = array(
	'id'      => 'header-classic-menu-bg-style',
	'name'    => _x( 'Menu background / line', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'disabled',
	'options' => array(
		'disabled'       => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-menu-bg-style-disabled.gif',
		),
		'content_line'   => array(
			'title' => _x( 'Content-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-menu-bg-style-contentline.gif',
		),
		'fullwidth_line' => array(
			'title' => _x( 'Full-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-menu-bg-style-fullwidthline.gif',
		),
		'solid'          => array(
			'title' => _x( 'Background', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-menu-bg-style-solid.gif',
		),
	),
	'class'   => 'small',
);

$options['header-classic-menu-bg-color']  = array(
	'id'         => 'header-classic-menu-bg-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-classic-menu-bg-style',
		'operator' => '!=',
		'value'    => 'disabled',
	),
);
$options['header-classic-menu-line_size'] = array(
	'id'         => 'header-classic-menu-line_size',
	'name'       => _x( 'Line height', 'theme-options', 'the7mk2' ),
	'std'        => '1px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		array(
			array(
				'field'    => 'header-classic-menu-bg-style',
				'operator' => '!=',
				'value'    => 'disabled',
			),
			array(
				'field'    => 'header-classic-menu-bg-style',
				'operator' => '!=',
				'value'    => 'solid',
			),
		),
	),
);


$options[] = array(
	'name'       => _x( 'Top line or side line appearance', 'theme-options', 'the7mk2' ),
	'id'         => 'header-mixed-line-block',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => 'IN',
		'value'    => array( 'top_line', 'side_line' ),
	),
);

$options['header-mixed-bg-color'] = array(
	'id'   => 'header-mixed-bg-color',
	'name' => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#000000',
);


$options['header-mixed-decoration'] = array(
	'id'      => 'header-mixed-decoration',
	'name'    => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'shadow',
	'options' => array(
		'disabled'           => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'shadow'             => _x( 'Shadow', 'theme-options', 'the7mk2' ),
		'content-width-line' => _x( 'Content-width line', 'theme-options', 'the7mk2' ),
		'line'               => _x( 'Line', 'theme-options', 'the7mk2' ),
	),
	'class'   => 'small',
);

$options['header-mixed-decoration-color'] = array(
	'id'         => 'header-mixed-decoration-color',
	'name'       => _x( 'Line color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-mixed-decoration',
		'operator' => 'IN',
		'value'    => array( 'content-width-line', 'line' ),
	),
);

$options['header-mixed-decoration_size'] = array(
	'id'         => 'header-mixed-decoration_size',
	'name'       => _x( 'Line height', 'theme-options', 'the7mk2' ),
	'std'        => '1px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(

		array(
			'field'    => 'header-mixed-decoration',
			'operator' => 'IN',
			'value'    => array( 'content-width-line', 'line' ),
		),

	),
);


$options[]                            = array(
	'name'       => _x( 'Floating top line', 'theme-options', 'the7mk2' ),
	'id'         => 'header-mixed-line-sticky-block',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'top_line',
	),
);
$options['layout-top_line-is_sticky'] = array(
	'id'      => 'layout-top_line-is_sticky',
	'name'    => _x( 'Floating line', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/top-line-floating-on.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/top-line-floating-off.gif',
		),
	),
);

$options['header-mixed-sticky-bg-color'] = array(
	'id'         => 'header-mixed-sticky-bg-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#000000',
	'dependency' => array(
		'field'    => 'layout-top_line-is_sticky',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['header-mixed-floating-top-bar'] = array(
	'id'         => 'header-mixed-floating-top-bar',
	'name'       => _x( 'Floating top bar ', 'theme-options', 'the7mk2' ),
	'type'       => 'checkbox',
	'std'        => 0,
	'dependency' => array(
		'field'    => 'layout-top_line-is_sticky',
		'operator' => '==',
		'value'    => '1',
	),
);


$options[] = array(
	'name'       => _x( 'Hamburger menu appearance', 'theme-options', 'the7mk2' ),
	'id'         => 'header-hamburger-block',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => 'IN',
		'value'    => array( 'top_line', 'side_line', 'menu_icon' ),
	),
);

$options['header-menu_icon-size'] = array(
	'id'   => 'header-menu_icon-size',
	'name' => _x( 'Choose icon', 'theme-options', 'the7mk2' ),

	'type'    => 'images',
	'std'     => 'small',
	'options' => array(
		'small'  => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/burg001.gif',
		),
		'medium' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/burg002.gif',
		),
		'large'  => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/burg003.gif',
		),
		'type_1' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/m4-hov.gif',
		),
		'type_2' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/style022.gif',
		),

		'type_5' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/m8.gif',
		),
		'type_3' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/burg006.gif',
		),
		'type_4' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/m7.gif',
		),
		'type_9' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/m9.gif',
		),

		'type_6' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/burg011.gif',
		),

		'type_7' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/burg017.gif',
		),

		'type_8' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/dot-h.gif',
		),

		'h_dots'  => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/dot-v.gif',
		),
		'type_10' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/dot.gif',
		),

	),
);


$options['header-menu_icon-caption']      = array(
	'id'      => 'header-menu_icon-caption',
	'name'    => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'left'     => _x( 'Before', 'theme-options', 'the7mk2' ),
		'right'    => _x( 'After', 'theme-options', 'the7mk2' ),
	),
);
$options['header-menu_icon-caption-text'] = array(
	'id'         => 'header-menu_icon-caption-text',
	'name'       => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'       => 'text',
	'std'        => _x( 'Menu', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-menu_icon-caption-typography'] = array(
	'id'         => 'header-menu_icon-caption-typography',
	'type'       => 'typography',
	'std'        => array(
		'font_family'    => 'Roboto',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
	'dependency' => array(
		'field'    => 'header-menu_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);
$options['header-menu_icon-caption_gap']        = array(
	'id'         => 'header-menu_icon-caption_gap',
	'name'       => _x( 'Caption gap', 'theme-options', 'the7mk2' ),
	'std'        => '10px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-menu_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-menu_icon-bg-border-width'] = array(
	'id'    => 'header-menu_icon-bg-border-width',
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-menu_icon-bg-border-radius'] = array(
	'id'    => 'header-menu_icon-bg-border-radius',
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);
$options['header-menu_icon-caption-padding']  = array(
	'id'   => 'header-menu_icon-caption-padding',
	'name' => _x( 'Paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '5px 10px 5px 10px',
);

$options['header-menu_icon-margin'] = array(
	'id'   => 'header-menu_icon-margin',
	'name' => _x( 'Margins', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Normal', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['header-menu_icon-color'] = array(
	'id'       => 'header-menu_icon-color',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'std'      => '#ffffff',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-menu_icon-caption_color'] = array(
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'       => 'header-menu_icon-caption_color',
	'std'      => '#ffffff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-menu_icon-bg'] = array(
	'id'      => 'header-menu_icon-bg',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_icon-bg-color'] = array(
	'id'         => 'header-menu_icon-bg-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_icon-bg',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['header-menu_icon-border'] = array(
	'id'      => 'header-menu_icon-border',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_icon-border-color'] = array(
	'id'         => 'header-menu_icon-border-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_icon-border',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Hover', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu_icon-color-hover'] = array(
	'id'       => 'header-menu_icon-color-hover',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'std'      => '#ffffff',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'sanitize' => 'empty_color',
);

$options['header-menu_icon-caption_color-hover'] = array(
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'       => 'header-menu_icon-caption_color-hover',
	'std'      => '#ffffff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'sanitize' => 'empty_color',
);

$options['header-menu_icon-bg-hover'] = array(
	'id'      => 'header-menu_icon-bg-hover',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_icon-bg-color-hover'] = array(
	'id'         => 'header-menu_icon-bg-color-hover',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_icon-bg-hover',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['header-menu_icon-border-hover'] = array(
	'id'      => 'header-menu_icon-border-hover',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_icon-border-hover-color'] = array(
	'id'         => 'header-menu_icon-border-hover-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_icon-border-hover',
		'operator' => '==',
		'value'    => 'enabled',
	),
);


$options[] = array(
	'name'       => _x( '"Close menu" button', 'theme-options', 'the7mk2' ),
	'id'         => 'header-close-block',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => 'IN',
		'value'    => array( 'top_line', 'side_line', 'menu_icon' ),
	),
);

$options['header-menu-close_icon-position'] = array(
	'id'      => 'header-menu-close_icon-position',
	'name'    => _x( 'Choose position', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'outside',
	'options' => array(
		'left'    => _x( 'Left', 'theme-options', 'the7mk2' ),
		'center'  => _x( 'Center', 'theme-options', 'the7mk2' ),
		'right'   => _x( 'Right', 'theme-options', 'the7mk2' ),
		'outside' => _x( 'Outside', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu-close_icon-size'] = array(
	'id'      => 'header-menu-close_icon-size',
	'name'    => _x( 'Choose icon', 'theme-options', 'the7mk2' ),
	'std'     => 'fade_medium',
	'type'    => 'images',
	'options' => array(
		'minus-medium'  => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/x1.gif',
		),
		'fade_medium'   => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/mmx001.gif',
		),
		'rotate_medium' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/x-rotate.gif',
		),

		'fade_big'   => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/x-26.gif',
		),
		'fade_thin'  => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/x-12.gif',
		),
		'fade_small' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/x6.gif',
		),
		'v_dots'     => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/dot-h.gif',
		),
		'h_dots'     => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/dot-v.gif',
		),

		'scale_dot' => array(
			'title' => '',
			'src'   => '/inc/admin/assets/images/dot.gif',
		),
	),
);

$options['header-menu-close_icon-caption'] = array(
	'id'      => 'header-menu-close_icon-caption',
	'name'    => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'left'     => _x( 'Before', 'theme-options', 'the7mk2' ),
		'right'    => _x( 'After', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu-close_icon-caption-text'] = array(
	'id'         => 'header-menu-close_icon-caption-text',
	'name'       => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'       => 'text',
	'std'        => _x( 'Navigation', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu-close_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-menu-close_icon-caption-typography'] = array(
	'id'         => 'header-menu-close_icon-caption-typography',
	'type'       => 'typography',
	'std'        => array(
		'font_family'    => 'Roboto',
		'font_size'      => 16,
		'text_transform' => 'uppercase',
	),
	'dependency' => array(
		'field'    => 'header-menu-close_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-menu-close_icon-caption_gap'] = array(
	'id'         => 'header-menu-close_icon-caption_gap',
	'name'       => _x( 'Caption gap', 'theme-options', 'the7mk2' ),
	'std'        => '20px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-menu-close_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-menu_close_icon-bg-border-width'] = array(
	'id'    => 'header-menu_close_icon-bg-border-width',
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-menu_close_icon-bg-border-radius'] = array(
	'id'    => 'header-menu_close_icon-bg-border-radius',
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-menu_close_icon-padding'] = array(
	'id'   => 'header-menu_close_icon-padding',
	'name' => _x( 'Paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '15px 15px 15px 15px',
);

$options['header-menu_close_icon-margin'] = array(
	'id'   => 'header-menu_close_icon-margin',
	'name' => _x( 'Margins', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Normal', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu_close_icon-color'] = array(
	'id'       => 'header-menu_close_icon-color',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'std'      => '#ffffff',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-menu_close_icon-caption_color'] = array(
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'       => 'header-menu_close_icon-caption_color',
	'std'      => '#ffffff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-menu_close_icon-bg'] = array(
	'id'      => 'header-menu_close_icon-bg',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_close_icon-bg-color'] = array(
	'id'         => 'header-menu_close_icon-bg-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_close_icon-bg',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['header-menu_close_icon-border'] = array(
	'id'      => 'header-menu_close_icon-border',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_close_icon-border-color'] = array(
	'id'         => 'header-menu_close_icon-border-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_close_icon-border',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Hover', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['header-menu_close_icon-hover-color'] = array(
	'id'       => 'header-menu_close_icon-hover-color',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'std'      => '#ffffff',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-menu_close_icon-caption_color-hover'] = array(
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'       => 'header-menu_close_icon-caption_color-hover',
	'std'      => '#ffffff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-menu_close_icon-bg-hover'] = array(
	'id'      => 'header-menu_close_icon-bg-hover',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_icon-hover-bg-color'] = array(
	'id'         => 'header-menu_icon-hover-bg-color',
	'name'       => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_close_icon-bg-hover',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['header-menu_close_icon-border-hover'] = array(
	'id'      => 'header-menu_close_icon-border-hover',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu_close_icon-border-color-hover'] = array(
	'id'         => 'header-menu_close_icon-border-color-hover',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-menu_close_icon-border-hover',
		'operator' => '==',
		'value'    => 'enabled',
	),
);


$options[] = array(
	'name'       => _x( 'Website overlay on navigation opening', 'theme-options', 'the7mk2' ),
	'id'         => 'header-overlay-block',
	'type'       => 'block',
	'dependency' => array(
		array(
			'field'    => 'header-layout',
			'operator' => 'IN',
			'value'    => array( 'top_line', 'side_line', 'menu_icon' ),
		),
		array(
			'field'    => 'header_navigation',
			'operator' => '==',
			'value'    => 'slide_out',
		),
	),
);

$options['header-slide_out-overlay-bg-color-style'] = array(
	'id'      => 'header-slide_out-overlay-bg-color-style',
	'name'    => _x( 'Color', 'theme options', 'the7mk2' ),
	'desc'    => 'Of outline or background',
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-slide_out-overlay-bg-color'] = array(
	'id'         => 'header-slide_out-overlay-bg-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-slide_out-overlay-bg-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-slide_out-overlay-bg-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-slide_out-overlay-bg-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-slide_out-overlay-bg-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-slide_out-overlay-bg-opacity'] = array(
	'id'         => 'header-slide_out-overlay-bg-opacity',
	'name'       => _x( 'Opacity', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 50,
	'dependency' => array(
		'field'    => 'header-slide_out-overlay-bg-color-style',
		'operator' => '==',
		'value'    => 'accent',
	),
);