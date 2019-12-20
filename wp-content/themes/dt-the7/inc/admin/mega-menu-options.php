<?php
/**
 * Mega menu options.
 *
 * @since   7.5.0
 *
 * @package The7\Admin
 */

defined( 'ABSPATH' ) || exit;

return array(
	array(
		'name'    => _x( 'Icon Type', 'admin', 'the7mk2' ),
		'id'      => 'menu-item-icon-type',
		'type'    => 'select',
		'std'     => 'none',
		'options' => array(
			'none'  => _x( 'No Icon', 'admin', 'the7mk2' ),
			'html'  => _x( 'HTML', 'admin', 'the7mk2' ),
			'image' => _x( 'Image', 'admin', 'the7mk2' ),
			'icon'  => _x( 'Icon', 'admin', 'the7mk2' ),
		),
	),
	array(
		'name'       => _x( 'Image', 'admin', 'the7mk2' ),
		'id'         => 'menu-item-image',
		'type'       => 'upload',
		'mode'       => 'full',
		'std'        => '',
		'dependency' => array(
			'field'    => 'menu-item-icon-type',
			'operator' => '==',
			'value'    => 'image',
		),
	),
	array(
		'name'       => _x( 'Icon', 'admin', 'the7mk2' ),
		'id'         => 'menu-item-icon',
		'type'       => 'icons_picker',
		'std'        => '',
		'dependency' => array(
			'field'    => 'menu-item-icon-type',
			'operator' => '==',
			'value'    => 'icon',
		),
	),
	array(
		'name'       => _x( 'Position', 'theme-options', 'the7mk2' ),
		'id'         => 'menu-item-image-position',
		'type'       => 'select',
		'std'        => 'left',
		'options'    => array(
			'top'       => _x( 'Top centered', 'theme-options', 'the7mk2' ),
			'top_align_left'=> _x( 'Top aligned left', 'theme-options', 'the7mk2' ),
			'right'     => _x( 'Right', 'theme-options', 'the7mk2' ),
			'right_top' => _x( 'Right with menu item only', 'theme-options', 'the7mk2' ),
			'left'      => _x( 'Left', 'theme-options', 'the7mk2' ),
			'left_top'  => _x( 'Left with menu item only', 'theme-options', 'the7mk2' ),
		),
		'dependency' => array(
			'field'    => 'menu-item-icon-type',
			'operator' => 'IN',
			'value'    => array( 'image', 'icon' ),
		),
	),
	array(
		'name'       => _x( 'Size', 'theme-options', 'the7mk2' ),
		'id'         => 'menu-item-image-size',
		'type'       => 'spacing',
		'std'        => '50px 50px',
		'fields'     => array(
			__( 'Width', 'the7mk2' ),
			__( 'Height', 'the7mk2' ),
		),
		'units'      => 'px',
		'dependency' => array(
			'field'    => 'menu-item-icon-type',
			'operator' => '==',
			'value'    => 'image',
		),
	),
	array(
		'name'       => _x( 'Border radius', 'theme-options', 'the7mk2' ),
		'id'         => 'menu-item-image-border-radius',
		'type'       => 'number',
		'std'        => '0px',
		'units'      => 'px',
		'dependency' => array(
			'field'    => 'menu-item-icon-type',
			'operator' => '==',
			'value'    => 'image',
		),
	),
	array(
		'name'       => _x( 'Padding', 'theme-options', 'the7mk2' ),
		'id'         => 'menu-item-image-padding',
		'type'       => 'spacing',
		'std'        => '0px 6px 0px 0px',
		'dependency' => array(
			'field'    => 'menu-item-icon-type',
			'operator' => 'IN',
			'value'    => array( 'image', 'icon' ),
		),
	),
	array(
		'name'       => _x( 'HTML', 'admin', 'the7mk2' ),
		'id'         => 'menu-item-icon-html',
		'type'       => 'textarea',
		'std'        => false,
		'dependency' => array(
			'field'    => 'menu-item-icon-type',
			'operator' => '==',
			'value'    => 'html',
		),
	),
	array(
		'name'       => _x( 'Enable Mega Menu', 'admin', 'the7mk2' ),
		'id'         => 'mega-menu',
		'type'       => 'switch',
		'std'        => 'off',
		'options'    => array(
			'on'  => _x( 'Yes', 'admin', 'the7mk2' ),
			'off' => _x( 'No', 'admin', 'the7mk2' ),
		),
		'dependency' => array(
			'field'    => 'item-depth',
			'operator' => '==',
			'value'    => '0',
		),
		'divider'    => 'top',
	),
	array(
		'name'       => _x( 'Fullwidth', 'admin', 'the7mk2' ),
		'id'         => 'mega-menu-fullwidth',
		'type'       => 'switch',
		'std'        => 'off',
		'options'    => array(
			'on'  => _x( 'Yes', 'admin', 'the7mk2' ),
			'off' => _x( 'No', 'admin', 'the7mk2' ),
		),
		'dependency' => array(
			array(
				'field'    => 'mega-menu',
				'operator' => '==',
				'value'    => 'on',
			),
			array(
				'field'    => 'item-depth',
				'operator' => '==',
				'value'    => '0',
			),
		),
	),
	array(
		'name'       => _x( 'Number of columns', 'admin', 'the7mk2' ),
		'id'         => 'mega-menu-columns',
		'type'       => 'select',
		'std'        => '3',
		'options'    => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
		'class'      => 'mini',
		'dependency' => array(
			array(
				'field'    => 'mega-menu',
				'operator' => '==',
				'value'    => 'on',
			),
			array(
				'field'    => 'item-depth',
				'operator' => '==',
				'value'    => '0',
			),
		),
	),
	array(
		'name'       => _x( 'Hide title in mega menu', 'admin', 'the7mk2' ),
		'desc'       => _x( "Doesn't apply to menu on mobile or in side header.", 'mega menu settings', 'the7mk2' ),
		'id'         => 'mega-menu-hide-title',
		'type'       => 'switch',
		'std'        => 'off',
		'options'    => array(
			'on'  => _x( 'Yes', 'admin', 'the7mk2' ),
			'off' => _x( 'No', 'admin', 'the7mk2' ),
		),
		'dependency' => array(
			array(
				'field'    => 'parent-mega-menu',
				'operator' => '==',
				'value'    => 'on',
			),
			array(
				'field'    => 'item-depth',
				'operator' => '==',
				'value'    => '1',
			),
		),
		'divider'    => 'top',
	),
	array(
		'name'       => _x( 'Remove link', 'admin', 'the7mk2' ),
		'id'         => 'mega-menu-remove-link',
		'type'       => 'switch',
		'std'        => 'off',
		'options'    => array(
			'on'  => _x( 'Yes', 'admin', 'the7mk2' ),
			'off' => _x( 'No', 'admin', 'the7mk2' ),
		),
		'dependency' => array(
			array(
				'field'    => 'parent-mega-menu',
				'operator' => '==',
				'value'    => 'on',
			),
			array(
				'field'    => 'item-depth',
				'operator' => '==',
				'value'    => '1',
			),
		),
	),
	array(
		'name'       => _x( 'This item should start a new row', 'admin', 'the7mk2' ),
		'desc'       => _x( "Doesn't apply to menu on mobile or in side header.", 'mega menu settings', 'the7mk2' ),
		'id'         => 'mega-menu-start-new-row',
		'type'       => 'switch',
		'std'        => 'off',
		'options'    => array(
			'on'  => _x( 'Yes', 'admin', 'the7mk2' ),
			'off' => _x( 'No', 'admin', 'the7mk2' ),
		),
		'dependency' => array(
			array(
				'field'    => 'parent-mega-menu',
				'operator' => '==',
				'value'    => 'on',
			),
			array(
				'field'    => 'item-depth',
				'operator' => '==',
				'value'    => '1',
			),
		),
	),
	array(
		'name'       => _x( 'This item should start a new column', 'admin', 'the7mk2' ),
		'id'         => 'mega-menu-start-new-column',
		'type'       => 'switch',
		'std'        => 'off',
		'options'    => array(
			'on'  => _x( 'Yes', 'admin', 'the7mk2' ),
			'off' => _x( 'No', 'admin', 'the7mk2' ),
		),
		'dependency' => array(
			array(
				'field'    => 'parent-mega-menu',
				'operator' => '==',
				'value'    => 'on',
			),
			array(
				'field'    => 'item-depth',
				'operator' => '==',
				'value'    => '2',
			),
		),
		'divider'    => 'top',
	),
	array(
		'name'       => _x( 'Widget area to display', 'admin', 'the7mk2' ),
		'desc'       => _x( 'Select a widget area to be used as the content for the column.', 'admin', 'the7mk2' ),
		'id'         => 'mega-menu-widgets',
		'type'       => 'select',
		'std'        => 'none',
		'options'    => array_merge(
			presscore_get_widgetareas_options(),
			array( 'none' => _x( 'None', 'admin', 'the7mk2' ) )
		),
		'dependency' => array(
			array(
				'field'    => 'parent-mega-menu',
				'operator' => '==',
				'value'    => 'on',
			),
			array(
				'field'    => 'item-depth',
				'operator' => '!=',
				'value'    => '0',
			),
		),
		'divider'    => 'top',
	),
	array(
		'name'       => _x( 'Hide menu item on mobile', 'admin', 'the7mk2' ),
		'desc'       => _x( 'This setting hide menu item and its child items in mobile menu.', 'admin', 'the7mk2' ),
		'id'         => 'mega-menu-hide-on-mobile',
		'type'       => 'switch',
		'std'        => 'off',
		'options'    => array(
			'on'  => _x( 'Yes', 'admin', 'the7mk2' ),
			'off' => _x( 'No', 'admin', 'the7mk2' ),
		),
		'dependency' => array(
			array(
				array(
					'field'    => 'mega-menu',
					'operator' => '==',
					'value'    => 'on',
				),
			),
			array(
				array(
					'field'    => 'parent-mega-menu',
					'operator' => '==',
					'value'    => 'on',
				),
			),
		),
		'divider'    => 'top',
	),
);
