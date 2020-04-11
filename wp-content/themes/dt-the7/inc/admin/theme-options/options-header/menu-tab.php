<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Menu', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'menu',
);


$options[] = array(
	'name' => _x( 'Menu font', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options[] = array(
	'name' => _x( 'Menu', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-typography'] = array(
	'id'   => 'header-menu-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
);

$options['header-menu-icon-size'] = array(
	'id'       => 'header-menu-icon-size',
	'name'     => _x( 'Icons size', 'theme-options', 'the7mk2' ),
	'type'     => 'slider',
	'std'      => 16,
	'options'  => array(
		'min' => 1,
		'max' => 120,
	),
	'sanitize' => 'font_size',
);

$options['header-menu-show_next_lvl_icons'] = array(
	'id'   => 'header-menu-show_next_lvl_icons',
	'name' => _x( 'Show next level indicator arrows', 'theme-options', 'the7mk2' ),
	'desc' => _x(
		'Icons are always visible if parent menu items are clickable (for side and overlay headers).',
		'theme-options',
		'the7mk2'
	),
	'type' => 'checkbox',
	'std'  => 1,
);

$options['header-menu-submenu-parent_is_clickable'] = array(
	'id'   => 'header-menu-submenu-parent_is_clickable',
	'name' => _x( 'Make parent menu items clickable', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 1,
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Description below menu items', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-subtitle-typography'] = array(
	'id'   => 'header-menu-subtitle-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family' => 'Arial',
		'font_size'   => 10,
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Font colors', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-font-color'] = array(
	'id'   => 'header-menu-font-color',
	'name' => _x( 'Normal', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#ffffff',
);

$options['header-menu-hover-font-color-style'] = array(
	'id'      => 'header-menu-hover-font-color-style',
	'name'    => _x( 'Hover', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu-hover-font-color'] = array(
	'id'         => 'header-menu-hover-font-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-hover-font-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-hover-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-menu-hover-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-menu-hover-font-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-menu-active_item-font-color-style'] = array(
	'id'      => 'header-menu-active_item-font-color-style',
	'name'    => _x( 'Active', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu-active_item-font-color'] = array(
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'id'         => 'header-menu-active_item-font-color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-active_item-font-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-active_item-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-menu-active_item-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-menu-active_item-font-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Menu items margin & padding', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-item-padding'] = array(
	'id'   => 'header-menu-item-padding',
	'name' => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '5px 10px 5px 10px',
);

$options['header-menu-item-margin'] = array(
	'id'   => 'header-menu-item-margin',
	'name' => _x( 'Margin', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array(
	'type'              => 'js_hide_begin',
	'class'             => 'menu-top-headers-indention',
	'hidden_by_default' => false,
);

$options['header-menu-item-surround_margins-style'] = array(
	'id'      => 'header-menu-item-surround_margins-style',
	'name'    => _x( 'Side margin for first and last menu items', 'theme-options', 'the7mk2' ),
	'desc'    => _x( 'Works for top headers only', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'regular',
	'options' => array(
		'regular'  => array(
			'title' => _x( 'Regular', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-item-surroundmargins-style-regular.gif',
		),
		'double'   => array(
			'title' => _x( 'Double', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-item-surroundmargins-style-double.gif',
		),
		'custom'   => array(
			'title' => _x( 'Custom', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-item-surroundmargins-style-custom.gif',
		),
		'disabled' => array(
			'title' => _x( 'Remove', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-item-surroundmargins-style-disabled.gif',
		),
	),
	'style'   => 'vertical',
);

$options['header-menu-item-surround_margins-custom-margin'] = array(
	'name'       => _x( 'Custom margin', 'theme-options', 'the7mk2' ),
	'type'       => 'number',
	'id'         => 'header-menu-item-surround_margins-custom-margin',
	'std'        => '0px',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-menu-item-surround_margins-style',
		'operator' => '==',
		'value'    => 'custom',
	),
);

$options['header-menu-decoration-other-links-is_justified'] = array(
	'id'      => 'header-menu-decoration-other-links-is_justified',
	'name'    => _x( 'Full height & full width links', 'theme-options', 'the7mk2' ),
	'desc'    => _x( 'Works for top headers only', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-links-isjustified-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-links-isjustified-disabled.gif',
		),
	),
);

$options[] = array( 'type' => 'js_hide_end' );


$options[] = array(
	'name' => _x( 'Dividers', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-menu-show_dividers'] = array(
	'id'        => 'header-menu-show_dividers',
	'name'      => _x( 'Dividers', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'class'     => 'small',
	'std'       => '0',
	'options'   => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-showdividers-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-showdividers-disabled.gif',
		),
	),
	'show_hide' => array( '1' => true ),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['header-menu-dividers-height-style'] = array(
	'id'      => 'header-menu-dividers-height-style',
	'name'    => _x( 'Divider length', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'full',
	'options' => array(
		'full'   => array(
			'title' => _x( '100%', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-dividers-height-style-full.gif',
		),
		'custom' => array(
			'title' => _x( 'Custom (in px)', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-showdividers-enabled.gif',
		),
	),
);

$options['header-menu-dividers-height'] = array(
	'id'         => 'header-menu-dividers-height',
	'name'       => _x( 'Length', 'theme-options', 'the7mk2' ),
	'std'        => '20px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-menu-dividers-height-style',
		'operator' => '==',
		'value'    => 'custom',
	),
);
$options['header-menu-dividers-width']  = array(
	'id'    => 'header-menu-dividers-width',
	'name'  => _x( 'Thickness', 'theme-options', 'the7mk2' ),
	'std'   => '1px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-menu-dividers-surround'] = array(
	'id'      => 'header-menu-dividers-surround',
	'name'    => _x( 'First & last dividers', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-showdividers-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-dividers-surround-disabled.gif',
		),
	),
);

$options['header-menu-dividers-color'] = array(
	'id'   => 'header-menu-dividers-color',
	'name' => _x( 'Dividers color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(153,153,153,0.3)',
);

$options[] = array( 'type' => 'js_hide_end' );


$options[] = array(
	'name'  => _x( 'Decoration styles for horizontal headers', 'theme-options', 'the7mk2' ),
	'class' => 'menu-horizontal-decoration-block',
	'type'  => 'block',
);

$options['header-menu-decoration-style'] = array(
	'id'        => 'header-menu-decoration-style',
	'name'      => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'class'     => 'small',
	'std'       => 'none',
	'options'   => array(
		'none'      => array(
			'title' => _x( 'None', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-style-none.gif',
		),
		'underline' => array(
			'title' => _x( 'Underline', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-style-underline.gif',
		),
		'other'     => array(
			'title' => _x( 'Background / outline / line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-style-other.gif',
		),
	),
	'show_hide' => array(
		'underline' => 'decoration-underline',
		'other'     => 'decoration-other',
	),
);

$options[] = array(
	'type'  => 'js_hide_begin',
	'class' => 'header-menu-decoration-style decoration-underline',
);

$options['header-menu-decoration-underline-direction'] = array(
	'id'      => 'header-menu-decoration-underline-direction',
	'name'    => _x( 'Direction', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'divider' => 'top',
	'std'     => 'left_to_right',
	'options' => array(
		'left_to_right' => array(
			'title' => _x( 'Left to right', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-underline-direction-lefttoright.gif',
		),
		'from_center'   => array(
			'title' => _x( 'From center', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-underline-direction-fromcenter.gif',
		),
		'upwards'       => array(
			'title' => _x( 'Upwards', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-underline-direction-upwards.gif',
		),
		'downwards'     => array(
			'title' => _x( 'Downwards', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-underline-direction-downwards.gif',
		),
	),
);

$options['header-menu-decoration-underline-color-style'] = array(
	'id'      => 'header-menu-decoration-underline-color-style',
	'name'    => _x( 'Underline color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'divider' => 'top',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu-decoration-underline-color'] = array(
	'id'         => 'header-menu-decoration-underline-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-decoration-underline-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-decoration-underline-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-menu-decoration-underline-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-menu-decoration-underline-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-menu-decoration-underline-line_size'] = array(
	'id'    => 'header-menu-decoration-underline-line_size',
	'name'  => _x( 'Line size', 'theme-options', 'the7mk2' ),
	'std'   => '2px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array(
	'type'  => 'js_hide_begin',
	'class' => 'header-menu-decoration-style decoration-other',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Hover', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-decoration-other-hover-style'] = array(
	'id'      => 'header-menu-decoration-other-hover-style',
	'name'    => _x( 'Hover style', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'outline',
	'options' => array(
		'outline'    => array(
			'title' => _x( 'Outline', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-hover-style-outline.gif',
		),
		'background' => array(
			'title' => _x( 'Background', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-hover-style-background.gif',
		),
	),
);

$options['header-menu-decoration-other-hover-color-style'] = array(
	'id'      => 'header-menu-decoration-other-hover-color-style',
	'name'    => _x( 'Hover color', 'theme-options', 'the7mk2' ),
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

$options['header-menu-decoration-other-hover-color'] = array(
	'id'         => 'header-menu-decoration-other-hover-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-hover-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-decoration-other-hover-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-menu-decoration-other-hover-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-hover-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-menu-decoration-other-opacity'] = array(
	'id'         => 'header-menu-decoration-other-opacity',
	'name'       => _x( 'Hover opacity', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 100,
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-hover-color-style',
		'operator' => '==',
		'value'    => 'accent',
	),
);

$options['header-menu-decoration-other-hover-line'] = array(
	'id'        => 'header-menu-decoration-other-hover-line',
	'name'      => _x( 'Hover line', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'class'     => 'small',
	'std'       => '0',
	'options'   => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-hover-line-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-hover-line-disabled.gif',
		),
	),
	'show_hide' => array( '1' => true ),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['header-menu-decoration-other-hover-line-color-style'] = array(
	'id'      => 'header-menu-decoration-other-hover-line-color-style',
	'name'    => _x( 'Hover line color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu-decoration-other-hover-line-color'] = array(
	'id'         => 'header-menu-decoration-other-hover-line-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-hover-line-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-decoration-other-hover-line-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-menu-decoration-other-hover-line-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-hover-line-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-menu-decoration-other-hover-line-opacity'] = array(
	'id'         => 'header-menu-decoration-other-hover-line-opacity',
	'name'       => _x( 'Hover line opacity', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 100,
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-hover-line-color-style',
		'operator' => '==',
		'value'    => 'accent',
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Active', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-decoration-other-active-style'] = array(
	'id'      => 'header-menu-decoration-other-active-style',
	'name'    => _x( 'Active style', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'outline',
	'options' => array(
		'outline'    => array(
			'title' => _x( 'Outline', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-active-style-outline.gif',
		),
		'background' => array(
			'title' => _x( 'Background', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-active-style-background.gif',
		),
	),
);

$options['header-menu-decoration-other-active-color-style'] = array(
	'id'      => 'header-menu-decoration-other-active-color-style',
	'name'    => _x( 'Active color', 'theme-options', 'the7mk2' ),
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

$options['header-menu-decoration-other-active-color'] = array(
	'id'         => 'header-menu-decoration-other-active-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-active-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-decoration-other-active-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-menu-decoration-other-active-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-active-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-menu-decoration-other-active-opacity'] = array(
	'id'         => 'header-menu-decoration-other-active-opacity',
	'name'       => _x( 'Active opacity', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 100,
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-active-color-style',
		'operator' => '==',
		'value'    => 'accent',
	),
);

$options['header-menu-decoration-other-active-line'] = array(
	'id'        => 'header-menu-decoration-other-active-line',
	'name'      => _x( 'Active line', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'class'     => 'small',
	'std'       => '0',
	'options'   => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-active-line-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-active-line-disabled.gif',
		),
	),
	'show_hide' => array( '1' => true ),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['header-menu-decoration-other-active-line-color-style'] = array(
	'id'      => 'header-menu-decoration-other-active-line-color-style',
	'name'    => _x( 'Active line color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-menu-decoration-other-active-line-color'] = array(
	'id'         => 'header-menu-decoration-other-active-line-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-active-line-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-decoration-other-active-line-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-menu-decoration-other-active-line-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-active-line-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-menu-decoration-other-active-line-opacity'] = array(
	'id'         => 'header-menu-decoration-other-active-line-opacity',
	'name'       => _x( 'Active line opacity', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 100,
	'dependency' => array(
		'field'    => 'header-menu-decoration-other-active-line-color-style',
		'operator' => '==',
		'value'    => 'accent',
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options['header-menu-decoration-other-border-radius'] = array(
	'id'      => 'header-menu-decoration-other-border-radius',
	'name'    => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'divider' => 'top',
	'std'     => 0,
	'options' => array(
		'min' => 0,
		'max' => 120,
	),
);

$options['header-menu-decoration-other-line_size'] = array(
	'id'      => 'header-menu-decoration-other-line_size',
	'name'    => _x( 'Line size', 'theme-options', 'the7mk2' ),
	'std'     => '2px',
	'type'    => 'number',
	'units'   => 'px',
	'divider' => 'top',
);

$options[] = array( 'type' => 'js_hide_end' );
