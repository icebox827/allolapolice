<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Submenu', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'submenu',
);


$options[] = array(
	'name'       => _x( 'Submenu for side & overlay navigation', 'theme-options', 'the7mk2' ),
	'id'         => 'submenu-for-side-headers-block',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => 'IN',
		'value'    => array( 'side', 'top_line', 'side_line', 'menu_icon' ),
	),
);

$options['header-side-menu-submenu-position'] = array(
	'id'      => 'header-side-menu-submenu-position',
	'name'    => _x( 'Show', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'side',
	'options' => array(
		'side' => array(
			'title' => _x( 'Sideways', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-side-menu-submenu-position-side.gif',
		),
		'down' => array(
			'title' => _x( 'Downwards', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-side-menu-submenu-position-down.gif',
		),
	),
);


$options[] = array(
	'name'       => _x( 'Submenu & mega menu background color', 'theme-options', 'the7mk2' ),
	'id'         => 'header-menu-submenu-bg-color-block',
	'type'       => 'block',
	'dependency' => array(
		array(
			array(
				'field'    => 'header-layout',
				'operator' => 'NOT_IN',
				'value'    => array( 'side', 'top_line', 'side_line', 'menu_icon' ),
			),
		),
		array(
			array(
				'field'    => 'header-side-menu-submenu-position',
				'operator' => '==',
				'value'    => 'side',
			),
		),
	),
);

$options['header-menu-submenu-bg-color'] = array(
	'id'   => 'header-menu-submenu-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(255,255,255,0.3)',
);


$options[] = array(
	'name' => _x( 'Submenu background settings', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-menu-submenu-bg-width'] = array(
	'id'         => 'header-menu-submenu-bg-width',
	'name'       => _x( 'Submenu background width', 'theme-options', 'the7mk2' ),
	'type'       => 'number',
	'std'        => '240',
	'min'        => 100,
	'dependency' => array(
		array(
			array(
				'field'    => 'header-layout',
				'operator' => 'NOT_IN',
				'value'    => array( 'side', 'top_line', 'side_line', 'menu_icon' ),
			),
		),
		array(
			array(
				'field'    => 'header-side-menu-submenu-position',
				'operator' => '==',
				'value'    => 'side',
			),
		),
	),
);

$options['header-menu-submenu-bg-padding'] = array(
	'name'  => _x( 'Submenu background paddings', 'theme-options', 'the7mk2' ),
	'id'    => 'header-menu-submenu-bg-padding',
	'type'  => 'spacing',
	'std'   => '10px 10px 10px 10px',
	'units' => 'px',
);


$options[] = array(
	'name' => _x( 'Submenu items', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options[] = array(
	'name' => _x( 'Submenu font & icon size', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-submenu-typography'] = array(
	'id'   => 'header-menu-submenu-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
);

$options['header-menu-submenu-icon-size'] = array(
	'id'      => 'header-menu-submenu-icon-size',
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'std'     => 14,
	'options' => array(
		'min' => 8,
		'max' => 50,
	),
);

$options['header-menu-submenu-show_next_lvl_icons'] = array(
	'id'   => 'header-menu-submenu-show_next_lvl_icons',
	'name' => _x( 'Show next level indicator arrows', 'theme-options', 'the7mk2' ),
	'desc' => _x(
		'Icons are always visible if parent menu items are clickable (for side and overlay headers).',
		'theme-options',
		'the7mk2'
	),
	'type' => 'checkbox',
	'std'  => 1,
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Description below submenu items', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-submenu-subtitle-typography'] = array(
	'id'   => 'header-menu-submenu-subtitle-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family' => 'Arial',
		'font_size'   => 10,
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Submenu font, icons & descriptions colors', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-submenu-font-color'] = array(
	'id'   => 'header-menu-submenu-font-color',
	'name' => _x( 'Normal', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#ffffff',
);

$options['header-menu-submenu-hover-font-color-style'] = array(
	'id'      => 'header-menu-submenu-hover-font-color-style',
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

$options['header-menu-submenu-hover-font-color'] = array(
	'id'         => 'header-menu-submenu-hover-font-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-submenu-hover-font-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-submenu-hover-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-menu-submenu-hover-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-menu-submenu-hover-font-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-menu-submenu-active-font-color-style'] = array(
	'id'      => 'header-menu-submenu-active-font-color-style',
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

$options['header-menu-submenu-active-font-color'] = array(
	'id'         => 'header-menu-submenu-active-font-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-menu-submenu-active-font-color-style',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-menu-submenu-active-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-menu-submenu-active-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-menu-submenu-active-font-color-style',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Submenu items margin & padding', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-menu-submenu-item-padding'] = array(
	'id'   => 'header-menu-submenu-item-padding',
	'name' => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '5px 10px 5px 10px',
);

$options['header-menu-submenu-item-margin'] = array(
	'id'   => 'header-menu-submenu-item-margin',
	'name' => _x( 'Margin', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);


$options[] = array(
	'name'       => _x( 'Submenu items hover & active background', 'theme-options', 'the7mk2' ),
	'id'         => 'submenu-active-items-background',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => 'NOT_IN',
		'value'    => array( 'side', 'top_line', 'side_line', 'menu_icon' ),
	),
);

$options['header-menu-submenu-bg-hover'] = array(
	'id'      => 'header-menu-submenu-bg-hover',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'none',
	'options' => array(
		'none'       => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-style-none.gif',
		),
		'background' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-menu-decoration-other-hover-style-background.gif',
		),
	),
);

$options['header-menu-submenu-hover-bg-color-style'] = array(
	'id'         => 'header-menu-submenu-hover-bg-color-style',
	'name'       => _x( 'Hover background color', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'class'      => 'small',
	'std'        => 'accent',
	'options'    => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'header-menu-submenu-bg-hover',
		'operator' => '==',
		'value'    => 'background',
	),
);

$options['header-menu-submenu-hover-bg-opacity'] = array(
	'id'         => 'header-menu-submenu-hover-bg-opacity',
	'name'       => _x( 'Opacity', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 7,
	'dependency' => array(
		array(
			'field'    => 'header-menu-submenu-bg-hover',
			'operator' => '==',
			'value'    => 'background',
		),
		array(
			'field'    => 'header-menu-submenu-hover-bg-color-style',
			'operator' => '==',
			'value'    => 'accent',
		),
	),
);

$options['header-menu-submenu-hover-bg-color'] = array(
	'id'         => 'header-menu-submenu-hover-bg-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		array(
			'field'    => 'header-menu-submenu-bg-hover',
			'operator' => '==',
			'value'    => 'background',
		),
		array(
			'field'    => 'header-menu-submenu-hover-bg-color-style',
			'operator' => '==',
			'value'    => 'color',
		),
	),
);

$options['header-menu-submenu-hover-bg-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-menu-submenu-hover-bg-gradient',
	'std'        => '90deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		array(
			'field'    => 'header-menu-submenu-bg-hover',
			'operator' => '==',
			'value'    => 'background',
		),
		array(
			'field'    => 'header-menu-submenu-hover-bg-color-style',
			'operator' => '==',
			'value'    => 'gradient',
		),
	),
);

$options['header-menu-submenu-active-bg-color-style'] = array(
	'id'         => 'header-menu-submenu-active-bg-color-style',
	'name'       => _x( 'Active background color', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'class'      => 'small',
	'std'        => 'accent',
	'options'    => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'header-menu-submenu-bg-hover',
		'operator' => '==',
		'value'    => 'background',
	),
);

$options['header-menu-submenu-active-bg-opacity'] = array(
	'id'         => 'header-menu-submenu-active-bg-opacity',
	'name'       => _x( 'Opacity', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 7,
	'dependency' => array(
		array(
			'field'    => 'header-menu-submenu-bg-hover',
			'operator' => '==',
			'value'    => 'background',
		),
		array(
			'field'    => 'header-menu-submenu-active-bg-color-style',
			'operator' => '==',
			'value'    => 'accent',
		),
	),
);

$options['header-menu-submenu-active-bg-color'] = array(
	'id'         => 'header-menu-submenu-active-bg-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		array(
			'field'    => 'header-menu-submenu-bg-hover',
			'operator' => '==',
			'value'    => 'background',
		),
		array(
			'field'    => 'header-menu-submenu-active-bg-color-style',
			'operator' => '==',
			'value'    => 'color',
		),
	),
);

$options['header-menu-submenu-active-bg-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-menu-submenu-active-bg-gradient',
	'std'        => '90deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		array(
			'field'    => 'header-menu-submenu-bg-hover',
			'operator' => '==',
			'value'    => 'background',
		),
		array(
			'field'    => 'header-menu-submenu-active-bg-color-style',
			'operator' => '==',
			'value'    => 'gradient',
		),
	),
);

// Mega Menu options.
if ( The7_Admin_Dashboard_Settings::get( 'mega-menu' ) ) {
	require dirname( __FILE__ ) . '/submenu-tab/mega-menu.php';
}
