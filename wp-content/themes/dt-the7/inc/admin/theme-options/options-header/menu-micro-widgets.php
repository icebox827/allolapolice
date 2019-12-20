<?php
defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name'                => _x( 'Menu 1', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-custom_menu-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-menu' );

$options['header-elements-menu-style'] = array(
	'id'      => 'header-elements-menu-style',
	'name'    => _x( 'Desktop menu style', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'dropdown',
	'options' => array(
		'dropdown' => _x( 'Dropdown', 'theme-options', 'the7mk2' ),
		'list'     => _x( 'List', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu-style-first-switch'] = array(
	'id'      => 'header-elements-menu-style-first-switch',
	'name'    => _x( 'First header switch menu style', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'dropdown',
	'options' => array(
		'dropdown' => _x( 'Dropdown', 'theme-options', 'the7mk2' ),
		'list'     => _x( 'List', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu-style-second-switch'] = array(
	'id'      => 'header-elements-menu-style-second-switch',
	'name'    => _x( 'Second header switch menu style', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'dropdown',
	'options' => array(
		'dropdown' => _x( 'Dropdown', 'theme-options', 'the7mk2' ),
		'list'     => _x( 'List', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu-icon'] = array(
	'id'      => 'header-elements-menu-icon',
	'name'    => _x( 'Graphic icon for dropdown style', 'theme-options', 'the7mk2' ),
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'custom',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'custom'   => _x( 'Custom', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu_custom-icon'] = array(
	'name'          => 'Select icon',
	'id'            => 'header-elements-menu_custom-icon',
	'type'          => 'icons_picker',
	'default_icons' => array(
		'dt-icon-the7-menu-011',
		'dt-icon-the7-menu-010',
		'dt-icon-the7-menu-009',
		'the7-mw-icon-dropdown-menu',
		'dt-icon-the7-menu-004',
		'dt-icon-the7-menu-007',
		'dt-icon-the7-menu-005',
		'dt-icon-the7-menu-006',
		'dt-icon-the7-menu-013',
		'dt-icon-the7-menu-014',
		'dt-icon-the7-menu-015',
		'dt-icon-the7-menu-016',
	),
	'std'           => 'the7-mw-icon-dropdown-menu-bold',
	'dependency'    => array(
		'field'    => 'header-elements-menu-icon',
		'operator' => '==',
		'value'    => 'custom',
	),
);



// Menu 2.
$options[] = array(
	'name'                => _x( 'Menu 2', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-menu2-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-menu2' );

$options['header-elements-menu2-style'] = array(
	'id'      => 'header-elements-menu2-style',
	'name'    => _x( 'Desktop menu style', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'dropdown',
	'options' => array(
		'dropdown' => _x( 'Dropdown', 'theme-options', 'the7mk2' ),
		'list'     => _x( 'List', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu2-style-first-switch'] = array(
	'id'      => 'header-elements-menu2-style-first-switch',
	'name'    => _x( 'First header switch menu style', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'dropdown',
	'options' => array(
		'dropdown' => _x( 'Dropdown', 'theme-options', 'the7mk2' ),
		'list'     => _x( 'List', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu2-style-second-switch'] = array(
	'id'      => 'header-elements-menu2-style-second-switch',
	'name'    => _x( 'Second header switch menu style', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'dropdown',
	'options' => array(
		'dropdown' => _x( 'Dropdown', 'theme-options', 'the7mk2' ),
		'list'     => _x( 'List', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu2-icon'] = array(
	'id'      => 'header-elements-menu2-icon',
	'name'    => _x( 'Graphic icon for dropdown style', 'theme-options', 'the7mk2' ),
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'custom',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'custom'   => _x( 'Custom', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-menu2_custom-icon'] = array(
	'name'          => 'Select icon',
	'id'            => 'header-elements-menu2_custom-icon',
	'type'          => 'icons_picker',
	'default_icons' => array(
		'dt-icon-the7-menu-011',
		'dt-icon-the7-menu-010',
		'dt-icon-the7-menu-009',
		'the7-mw-icon-dropdown-menu',
		'dt-icon-the7-menu-004',
		'dt-icon-the7-menu-007',
		'dt-icon-the7-menu-005',
		'dt-icon-the7-menu-006',
		'dt-icon-the7-menu-013',
		'dt-icon-the7-menu-014',
		'dt-icon-the7-menu-015',
		'dt-icon-the7-menu-016',
	),
	'std'           => 'the7-mw-icon-dropdown-menu-bold',
	'dependency'    => array(
		'field'    => 'header-elements-menu2-icon',
		'operator' => '==',
		'value'    => 'custom',
	),
);


