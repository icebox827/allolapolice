<?php
/**
 * Mega Menu options.
 *
 * @package The7\Admin
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Mega menu background settings', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-mega-menu-submenu-bg-padding'] = array(
	'id'   => 'header-mega-menu-submenu-bg-padding',
	'name' => _x( 'Mega menu background paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 10px 0px 10px',
);

$options['header-mega-menu-submenu-column-padding'] = array(
	'id'   => 'header-mega-menu-submenu-column-padding',
	'name' => _x( 'Mega menu column paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '20px 10px 20px 10px',
);

$options['header-mega-menu-submenu-column-width'] = array(
	'id'    => 'header-mega-menu-submenu-column-width',
	'name'  => _x( 'Mega menu column width', 'theme-options', 'the7mk2' ),
	'type'  => 'number',
	'std'   => '240px',
	'units' => 'px',
	'min'   => 100,
	'desc'  => _x( 'For non fullwidth mega menu layouts', 'theme-options', 'the7mk2' ),
);

$options[] = array(
	'name'  => _x( 'Mega menu items', 'theme-options', 'the7mk2' ),
	'class' => 'mega-menu-block',
	'type'  => 'block',
);

$options[] = array(
	'name' => _x( 'Mega menu font & icon size', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mega-menu-title-typography'] = array(
	'id'   => 'header-mega-menu-title-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Roboto:700',
		'font_size'      => 18,
		'text_transform' => 'none',
	),
);

$options['header-mega-menu-title-icon-size'] = array(
	'id'      => 'header-mega-menu-title-icon-size',
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'std'     => 18,
	'options' => array(
		'min' => 8,
		'max' => 50,
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Mega menu font & icon colors', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mega-menu-title-font-color'] = array(
	'id'   => 'header-mega-menu-title-font-color',
	'name' => _x( 'Normal', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#333333',
);

$options['header-mega-menu-title-hover-font-color-style'] = array(
	'id'      => 'header-mega-menu-title-hover-font-color-style',
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

$options['header-mega-menu-title-hover-font-color'] = array(
	'id'         => 'header-mega-menu-title-hover-font-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-mega-menu-title-hover-font-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-mega-menu-title-hover-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-mega-menu-title-hover-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-mega-menu-title-hover-font-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-mega-menu-title-active_item-font-color-style'] = array(
	'id'      => 'header-mega-menu-title-active_item-font-color-style',
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

$options['header-mega-menu-title-active_item-font-color'] = array(
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'id'         => 'header-mega-menu-title-active_item-font-color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-mega-menu-title-active_item-font-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-mega-menu-title-active_item-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-mega-menu-title-active_item-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-mega-menu-title-active_item-font-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Description below mega menu items', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mega-menu-desc-typography'] = array(
	'id'   => 'header-mega-menu-desc-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family' => 'Roboto:700',
		'font_size'   => 13,
	),
);

$options['header-mega-menu-desc-font-color'] = array(
	'id'   => 'header-mega-menu-desc-font-color',
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#333333',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Mega menu widgets', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mega-menu-widget-title-color'] = array(
	'id'   => 'header-mega-menu-widget-title-color',
	'name' => _x( 'Titles color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#333333',
);

$options['header-mega-menu-widget-font-color'] = array(
	'id'   => 'header-mega-menu-widget-font-color',
	'name' => _x( 'Text color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#333333',
);

$options['header-mega-menu-widget-accent-color'] = array(
	'id'   => 'header-mega-menu-widget-accent-color',
	'name' => _x( 'Accent color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '',
	'desc' => _x( 'Leave empty to use default accent color.', 'theme-options', 'the7mk2' ),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Mega menu items padding', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mega-menu-items-padding'] = array(
	'id'   => 'header-mega-menu-items-padding',
	'name' => _x( 'Mega menu items padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 10px 0px',
);
