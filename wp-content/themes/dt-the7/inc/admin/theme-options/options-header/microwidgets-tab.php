<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'microwidgets',
);

$options[] = array(
	'name'       => _x( 'Microwidgets layout', 'theme-options', 'the7mk2' ),
	'id'         => 'classic-microwidgets',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'classic',
	),
);

/**
 * Classic layout.
 */

$options['header-classic-show_elements'] = array(
	'id'      => 'header-classic-show_elements',
	'name'    => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'desc'    => 'When enabled, microwidgets can  be rearranged below. You can set them up in dedicated "Microwidgets" tab.',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['header-classic-elements'] = array(
	'id'            => 'header-classic-elements',
	'type'          => 'sortable',
	'std'           => array(),
	'palette_title' => _x( 'Inactive microwidgets', 'theme-options', 'the7mk2' ),
	'items'         => presscore_options_get_header_layout_elements(),
	'fields'        => array(
		'top_bar_left'    => array(
			'title' => _x( 'Microwidgets in top bar (left)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'top_bar_right'   => array(
			'title' => _x( 'Microwidgets in top bar (right)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'near_menu_right' => array(
			'title' => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
		'near_logo_left'  => array(
			'title' => _x( 'Microwidgets near logo (left)', 'theme-options', 'the7mk2' ),
			'class' => 'field-red',
		),
		'near_logo_right' => array(
			'title' => _x( 'Microwidgets near logo (right)', 'theme-options', 'the7mk2' ),
			'class' => 'field-red',
		),
	),
	'dependency'    => array(
		'field'    => 'header-classic-show_elements',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
	'class' => 'classic-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-classic-elements-near_menu' );

$options['header-classic-elements-near_menu_right-padding'] = array(
	'id'   => 'header-classic-elements-near_menu_right-padding',
	'name' => _x( 'Microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array(
	'name'  => _x( 'Microwidgets near logo', 'theme-options', 'the7mk2' ),
	'class' => 'classic-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-classic-elements-near_logo' );

$options['header-classic-elements-near_logo_left-padding'] = array(
	'id'   => 'header-classic-elements-near_logo_left-padding',
	'name' => _x( 'Left microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options['header-classic-elements-near_logo_right-padding'] = array(
	'id'   => 'header-classic-elements-near_logo_right-padding',
	'name' => _x( 'Right microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

/**
 * Inline header.
 */
$options[] = array(
	'name'  => _x( 'Microwidgets layout', 'theme-options', 'the7mk2' ),
	'class' => 'inline-microwidgets',
	'type'  => 'block',
);

$options['header-inline-show_elements'] = array(
	'id'      => 'header-inline-show_elements',
	'name'    => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'desc'    => 'When enabled, microwidgets can  be rearranged below. You can set them up in dedicated "Microwidgets" tab.',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['header-inline-elements'] = array(
	'id'            => 'header-inline-elements',
	'type'          => 'sortable',
	'std'           => array(),
	'palette_title' => _x( 'Inactive microwidgets', 'theme-options', 'the7mk2' ),
	'items'         => presscore_options_get_header_layout_elements(),
	'fields'        => array(
		'top_bar_left'    => array(
			'title' => _x( 'Microwidgets in top bar (left)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'top_bar_right'   => array(
			'title' => _x( 'Microwidgets in top bar (right)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'near_menu_right' => array(
			'title' => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
	),
	'dependency'    => array(
		'field'    => 'header-inline-show_elements',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
	'class' => 'inline-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-inline-elements-near_menu' );

$options['header-inline-elements-near_menu_right-padding'] = array(
	'id'   => 'header-inline-elements-near_menu_right-padding',
	'name' => _x( 'Microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

/**
 * Split header.
 */
$options[] = array(
	'name'  => _x( 'Microwidgets layout', 'theme-options', 'the7mk2' ),
	'class' => 'split-microwidgets',
	'type'  => 'block',
);

$options['header-split-show_elements'] = array(
	'id'      => 'header-split-show_elements',
	'name'    => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'desc'    => 'When enabled, microwidgets can  be rearranged below. You can set them up in dedicated "Microwidgets" tab.',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['header-split-elements'] = array(
	'id'            => 'header-split-elements',
	'type'          => 'sortable',
	'std'           => array(),
	'palette_title' => _x( 'Inactive microwidgets', 'theme-options', 'the7mk2' ),
	'items'         => presscore_options_get_header_layout_elements(),
	'fields'        => array(
		'top_bar_left'    => array(
			'title' => _x( 'Microwidgets in top bar (left)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'top_bar_right'   => array(
			'title' => _x( 'Microwidgets in top bar (right)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'near_menu_left'  => array(
			'title' => _x( 'Microwidgets in navigation area (left)', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
		'near_menu_right' => array(
			'title' => _x( 'Microwidgets in navigation area (right)', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
	),
	'dependency'    => array(
		'field'    => 'header-split-show_elements',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
	'class' => 'split-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-split-elements-near_menu' );

$options['header-split-elements-near_menu_left-padding'] = array(
	'id'   => 'header-split-elements-near_menu_left-padding',
	'name' => _x( 'Left microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options['header-split-elements-near_menu_right-padding'] = array(
	'id'   => 'header-split-elements-near_menu_right-padding',
	'name' => _x( 'Right microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

/**
 * Side header.
 */
$options[] = array(
	'name'  => _x( 'Microwidgets layout', 'theme-options', 'the7mk2' ),
	'class' => 'side-microwidgets',
	'type'  => 'block',
);

$options['header-side-show_elements'] = array(
	'id'      => 'header-side-show_elements',
	'name'    => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'desc'    => _x(
		'When enabled, microwidgets can  be rearranged below. You can set them up in dedicated "Microwidgets" tab.',
		'theme-options',
		'the7mk2'
	),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['header-side-elements'] = array(
	'id'            => 'header-side-elements',
	'type'          => 'sortable',
	'std'           => array(),
	'palette_title' => _x( 'Inactive elements', 'theme-options', 'the7mk2' ),
	'items'         => presscore_options_get_header_layout_elements(),
	'fields'        => array(
		'below_menu' => array(
			'title' => _x( 'Below menu', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
	),
	'dependency'    => array(
		'field'    => 'header-side-show_elements',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
	'class' => 'side-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-side-elements-near_menu' );

$options[] = array( 'type' => 'divider' );

$options['header-side-elements-below_menu-padding'] = array(
	'id'   => 'header-side-elements-below_menu-padding',
	'name' => _x( 'Area below menu padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

/**
 * Top line header.
 */
$options[] = array(
	'name'  => _x( 'Microwidgets layout', 'theme-options', 'the7mk2' ),
	'class' => 'top-line-microwidgets',
	'type'  => 'block',
);

$options['header-top_line-show_elements'] = array(
	'id'      => 'header-top_line-show_elements',
	'name'    => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'desc'    => 'When enabled, microwidgets can  be rearranged below. You can set them up in dedicated "Microwidgets" tab.',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['header-top_line-elements'] = array(
	'id'            => 'header-top_line-elements',
	'type'          => 'sortable',
	'std'           => array(),
	'palette_title' => _x( 'Inactive microwidgets', 'theme-options', 'the7mk2' ),
	'items'         => presscore_options_get_header_layout_elements(),
	'fields'        => array(
		'top_bar_left'   => array(
			'title' => _x( 'Microwidgets in top bar (left)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'top_bar_right'  => array(
			'title' => _x( 'Microwidgets in top bar (right)', 'theme-options', 'the7mk2' ),
			'class' => 'field-blue',
		),
		'side_top_line'  => array(
			'title' => _x( 'Microwidgets in top line (left)', 'theme-options', 'the7mk2' ),
			'class' => 'field-red',
		),
		'top_line_right' => array(
			'title' => _x( 'Microwidgets in top line (right)', 'theme-options', 'the7mk2' ),
			'class' => 'field-red',
		),
		'below_menu'     => array(
			'title' => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
	),
	'dependency'    => array(
		'field'    => 'header-top_line-show_elements',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in top line', 'theme-options', 'the7mk2' ),
	'class' => 'top-line-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-top_line-elements-in_top_line' );

$options['header-top_line-elements-top_line-padding'] = array(
	'id'   => 'header-top_line-elements-top_line-padding',
	'name' => _x( 'Left microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options['header-top_line-elements-top_line_right-padding'] = array(
	'id'   => 'header-top_line-elements-top_line_right-padding',
	'name' => _x( 'Right microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array(
	'name'  => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
	'class' => 'top-line-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-top_line-elements-near_menu' );

$options['header-top_line-elements-below_menu-padding'] = array(
	'id'   => 'header-top_line-elements-below_menu-padding',
	'name' => _x( 'Microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

/**
 * Side line header.
 */
$options[] = array(
	'name'  => _x( 'Microwidgets layout', 'theme-options', 'the7mk2' ),
	'class' => 'side-line-microwidgets',
	'type'  => 'block',
);

$options['header-side_line-show_elements'] = array(
	'id'      => 'header-side_line-show_elements',
	'name'    => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'desc'    => 'When enabled, microwidgets can  be rearranged below. You can set them up in dedicated "Microwidgets" tab.',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['header-side_line-elements'] = array(
	'id'            => 'header-side_line-elements',
	'type'          => 'sortable',
	'std'           => array(),
	'palette_title' => _x( 'Inactive microwidgets', 'theme-options', 'the7mk2' ),
	'items'         => presscore_options_get_header_layout_elements(),
	'fields'        => array(
		'below_menu' => array(
			'title' => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
	),
	'dependency'    => array(
		'field'    => 'header-side_line-show_elements',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
	'class' => 'side-line-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-side_line-elements-near_menu' );

$options['header-side_line-elements-below_menu-padding'] = array(
	'id'   => 'header-side_line-elements-below_menu-padding',
	'name' => _x( 'Microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

/**
 * Menu icons only header.
 */
$options[] = array(
	'name'  => _x( 'Microwidgets layout', 'theme-options', 'the7mk2' ),
	'class' => 'menu-icon-microwidgets',
	'type'  => 'block',
);

$options['header-menu_icon-show_elements'] = array(
	'id'      => 'header-menu_icon-show_elements',
	'name'    => _x( 'Microwidgets', 'theme-options', 'the7mk2' ),
	'desc'    => 'When enabled, microwidgets can  be rearranged below. You can set them up in dedicated "Microwidgets" tab.',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['header-menu_icon-elements'] = array(
	'id'            => 'header-menu_icon-elements',
	'type'          => 'sortable',
	'std'           => array(),
	'palette_title' => _x( 'Inactive microwidgets', 'theme-options', 'the7mk2' ),
	'items'         => presscore_options_get_header_layout_elements(),
	'fields'        => array(
		'below_menu' => array(
			'title' => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
			'class' => 'field-green',
		),
	),
	'dependency'    => array(
		'field'    => 'header-menu_icon-show_elements',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in navigation area', 'theme-options', 'the7mk2' ),
	'class' => 'menu-icon-microwidgets-settings',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'microwidget-font', 'header-menu_icon-elements-near_menu' );

$options['header-menu_icon-elements-below_menu-padding'] = array(
	'id'   => 'header-menu_icon-elements-below_menu-padding',
	'name' => _x( 'Microwidgets area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array(
	'name'  => _x( 'Microwidgets in top bar', 'theme-options', 'the7mk2' ),
	'class' => 'top-bar-microwidgets',
	'type'  => 'block',
);

$options['top_bar-typography'] = array(
	'id'   => 'top_bar-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
);

$options['top_bar-font-color'] = array(
	'id'   => 'top_bar-font-color',
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#686868',
);

$options['top_bar-custom-icon-size'] = array(
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'id'      => 'top_bar-custom-icon-size',
	'std'     => 16,
	'options' => array(
		'min' => 9,
		'max' => 120,
	),
);

$options['top_bar-custom-icon-color'] = array(
	'id'   => 'top_bar-custom-icon-color',
	'name' => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '',
	'desc' => _x( 'Leave empty to use font color.', 'theme-options', 'the7mk2' ),
);

$options[] = array(
	'name'  => _x( 'Microwidgets in mobile header', 'theme-options', 'the7mk2' ),
	'class' => 'mobile-header-microwidgets',
	'type'  => 'block',
);

$options['header-mobile-microwidgets-typography'] = array(
	'id'   => 'header-mobile-microwidgets-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family' => 'Open Sans',
		'font_size'   => 16,
	),
);

$options['header-mobile-microwidgets-font-color'] = array(
	'id'   => 'header-mobile-microwidgets-font-color',
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#000000',
);

$options['header-mobile-microwidgets-custom-icon-size'] = array(
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'id'      => 'header-mobile-microwidgets-custom-icon-size',
	'std'     => 16,
	'options' => array(
		'min' => 9,
		'max' => 120,
	),
);

$options['header-mobile-microwidgets-custom-icon-color'] = array(
	'id'   => 'header-mobile-microwidgets-custom-icon-color',
	'name' => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '',
	'desc' => _x( 'Leave empty to use font color.', 'theme-options', 'the7mk2' ),
);

// Micro-widgets in mobile menu.
$options[] = array(
	'name'  => _x( 'Microwidgets in mobile menu', 'theme-options', 'the7mk2' ),
	'class' => 'mobile-menu-microwidgets',
	'type'  => 'block',
);

$options['menu-mobile-microwidgets-typography'] = array(
	'id'   => 'menu-mobile-microwidgets-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family' => 'Open Sans',
		'font_size'   => 16,
	),
);

$options['menu-mobile-microwidgets-font-color'] = array(
	'id'   => 'menu-mobile-microwidgets-font-color',
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#000000',
);

$options['menu-mobile-microwidgets-custom-icon-size'] = array(
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'id'      => 'menu-mobile-microwidgets-custom-icon-size',
	'std'     => 16,
	'options' => array(
		'min' => 9,
		'max' => 120,
	),
);

$options['menu-mobile-microwidgets-custom-icon-color'] = array(
	'id'   => 'menu-mobile-microwidgets-custom-icon-color',
	'name' => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '',
	'desc' => _x( 'Leave empty to use font color.', 'theme-options', 'the7mk2' ),
);

// Micro-widgets.
$options['header-before-elements-placeholder'] = array();

require dirname( __FILE__ ) . '/microwidgets-tab/search-micro-widget.php';
require dirname( __FILE__ ) . '/microwidgets-tab/multipurpose-micro-widgets.php';
require dirname( __FILE__ ) . '/microwidgets-tab/login-micro-widget.php';
require dirname( __FILE__ ) . '/microwidgets-tab/button-micro-widgets.php';
require dirname( __FILE__ ) . '/microwidgets-tab/text-micro-widgets.php';
require dirname( __FILE__ ) . '/microwidgets-tab/menu-micro-widgets.php';
require dirname( __FILE__ ) . '/microwidgets-tab/social-icons-micro-widget.php';