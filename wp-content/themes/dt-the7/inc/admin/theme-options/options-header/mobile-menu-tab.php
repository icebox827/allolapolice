<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Mobile menu', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'mobile-menu',
);

$options[] = array(
	'name' => _x( 'Mobile navigation area', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options[] = array(
	'name' => _x( 'Menu font', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-menu-typography'] = array(
	'id'   => 'header-mobile-menu-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Arial',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Submenu font', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-submenu-typography'] = array(
	'id'   => 'header-mobile-submenu-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Arial',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-menu-font-color'] = array(
	'id'   => 'header-mobile-menu-font-color',
	'name' => _x( 'Normal font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#ffffff',
);

$options['header-mobile-menu-font-hover-color-style'] = array(
	'name'    => _x( 'Active & hover font color', 'theme-options', 'the7mk2' ),
	'id'      => 'header-mobile-menu-font-hover-color-style',
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu-font-hover-color'] = array(
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'id'         => 'header-mobile-menu-font-hover-color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-mobile-menu-font-hover-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-mobile-menu-font-hover-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-mobile-menu-font-hover-gradient',
	'std'         => '90deg|#ffffff 30%|#ffffff 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-mobile-menu-font-hover-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options[] = array( 'type' => 'divider' );
$options[] = array(
	'name' => _x( 'Menu dividers', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);
$options['header-mobile-menu-show_dividers'] = array(
	'id'      => 'header-mobile-menu-show_dividers',
	'name'    => _x( 'Dividers', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '1',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/en.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/ea-dis.gif',
		),
	),
);
$options['header-mobile-menu-dividers-height'] = array(
	'id'         => 'header-mobile-menu-dividers-height',
	'name'       => _x( 'Thickness', 'theme-options', 'the7mk2' ),
	'std'        => '1px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-mobile-menu-show_dividers',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['header-mobile-menu-dividers-color'] = array(
	'id'         => 'header-mobile-menu-dividers-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => 'rgba(153,153,153,0.12)',
	'dependency' => array(
		'field'    => 'header-mobile-menu-show_dividers',
		'operator' => '==',
		'value'    => '1',
	),
);
$options[] = array(
	'name' => _x( 'Menu background', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-menu-bg-color'] = array(
	'id'   => 'header-mobile-menu-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#111111',
);


$options['header-mobile-content-padding'] = array(
	'id'   => 'header-mobile-content-padding',
	'name' => _x( 'Paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '45px 15px 30px 30px',
	'desc' => _x(
		'There is an extra gap for the menu scrolling - you may want to set right padding smaller than the left one.',
		'theme-options',
		'the7mk2'
	),
);

$options['header-mobile-menu-bg-width'] = array(
	'id'    => 'header-mobile-menu-bg-width',
	'name'  => _x( 'Maximum background width', 'theme-options', 'the7mk2' ),
	'std'   => '400px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-mobile-menu-align'] = array(
	'id'      => 'header-mobile-menu-align',
	'name'    => _x( 'Mobile menu slides from', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'left',
	'options' => array(
		'left'  => array(
			'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-mobile-menu-align-left.gif',
		),
		'right' => array(
			'title' => _x( 'Right', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-mobile-menu-align-right.gif',
		),
	),
	'class'   => 'small',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Website overlay on mobile menu opening', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-overlay-bg-color'] = array(
	'id'   => 'header-mobile-overlay-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(17, 17, 17, 0.5)',
);


$options[] = array(
	'name' => _x( '"Close menu" button', 'theme-options', 'the7mk2' ),
	'id'   => 'header-mobile-close-block',
	'type' => 'block',
);

$options['header-mobile-menu-close_icon-position'] = array(
	'id'      => 'header-mobile-menu-close_icon-position',
	'name'    => _x( 'Choose position', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'right',
	'options' => array(
		'left'    => _x( 'Left', 'theme-options', 'the7mk2' ),
		'center'  => _x( 'Center', 'theme-options', 'the7mk2' ),
		'right'   => _x( 'Right', 'theme-options', 'the7mk2' ),
		'outside' => _x( 'Outside', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu-close_icon-size'] = array(
	'id'   => 'header-mobile-menu-close_icon-size',
	'name' => _x( 'Choose icon', 'theme-options', 'the7mk2' ),
	'std'  => 'fade_medium',

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



$options['header-mobile-menu-close_icon-caption'] = array(
	'id'      => 'header-mobile-menu-close_icon-caption',
	'name'    => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'left'     => _x( 'Before', 'theme-options', 'the7mk2' ),
		'right'    => _x( 'After', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu-close_icon-caption-text'] = array(
	'id'         => 'header-mobile-menu-close_icon-caption-text',
	'name'       => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'       => 'text',
	'std'        => _x( 'Menu', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu-close_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-mobile-menu-close_icon-caption-typography'] = array(
	'id'         => 'header-mobile-menu-close_icon-caption-typography',
	'type'       => 'typography',
	'std'        => array(
		'font_family'    => 'Roboto',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
	'dependency' => array(
		'field'    => 'header-mobile-menu-close_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-mobile-menu-close_icon-caption_gap'] = array(
	'id'         => 'header-mobile-menu-close_icon-caption_gap',
	'name'       => _x( 'Caption gap', 'theme-options', 'the7mk2' ),
	'std'        => '10px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-mobile-menu-close_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-mobile-menu_close_icon-bg-border-width'] = array(
	'id'    => 'header-mobile-menu_close_icon-bg-border-width',
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-mobile-menu_close_icon-bg-border-radius'] = array(
	'id'    => 'header-mobile-menu_close_icon-bg-border-radius',
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-mobile-menu_close_icon-padding'] = array(
	'id'   => 'header-mobile-menu_close_icon-padding',
	'name' => _x( 'Paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '5px 5px 5px 5px',
);

$options['header-mobile-menu_close_icon-margin'] = array(
	'id'   => 'header-mobile-menu_close_icon-margin',
	'name' => _x( 'Margins', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '15px 0px 0px 0px',

	'desc' => _x(
		'Please note there is an extra gap on the right for the menu scrolling.',
		'theme-options',
		'the7mk2'
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Normal', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-menu_close_icon-color'] = array(
	'id'       => 'header-mobile-menu_close_icon-color',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'std'      => '#fff',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_close-caption_color'] = array(
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'       => 'header-mobile-menu_close-caption_color',
	'std'      => '#fff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_close_icon-bg'] = array(
	'id'      => 'header-mobile-menu_close_icon-bg',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_close_icon-bg-color'] = array(
	'id'         => 'header-mobile-menu_close_icon-bg-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_close_icon-bg',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['header-mobile-menu_close_icon-border'] = array(
	'id'      => 'header-mobile-menu_close_icon-border',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_close_icon-border-color'] = array(
	'id'         => 'header-mobile-menu_close_icon-border-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_close_icon-border',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Hover', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['header-mobile-menu_close_icon-hover-color'] = array(
	'id'       => 'header-mobile-menu_close_icon-hover-color',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'std'      => '#fff',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_close-caption_color-hover'] = array(
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'       => 'header-mobile-menu_close-caption_color-hover',
	'std'      => '#fff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_close_icon-bg-hover'] = array(
	'id'      => 'header-mobile-menu_close_icon-bg-hover',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'enabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_icon-hover-bg-color'] = array(
	'id'         => 'header-mobile-menu_icon-hover-bg-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_close_icon-bg-hover',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['header-mobile-menu_close_icon-border-hover'] = array(
	'id'      => 'header-mobile-menu_close_icon-border-hover',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_close_icon-border-color-hover'] = array(
	'id'         => 'header-mobile-menu_close_icon-border-color-hover',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_close_icon-border-hover',
		'operator' => '==',
		'value'    => 'enabled',
	),
);