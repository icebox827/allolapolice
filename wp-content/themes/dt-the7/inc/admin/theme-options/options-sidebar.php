<?php
/**
 * Sidebar.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page definition.
 */
$options[] = array(
	'page_title' => _x( 'Sidebar', 'theme-options', 'the7mk2' ),
	'menu_title' => _x( 'Sidebar', 'theme-options', 'the7mk2' ),
	'menu_slug'  => 'of-sidebar-menu',
	'type'       => 'page',
);

/**
 * Heading definition.
 */
$options[] = array( 'name' => _x( 'Sidebar', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'sidebar' );

// block begin
$options[] = array( 'name' => _x( 'Sidebar settings', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['sidebar-width'] = array(
	'name'  => _x( 'Sidebar width', 'theme-options', 'the7mk2' ),
	'id'    => 'sidebar-width',
	'std'   => '30%',
	'type'  => 'number',
	'units' => 'px|%',
);

$options[] = array( 'type' => 'divider' );

$options['sidebar-vertical_distance'] = array(
	'name'  => _x( 'Vertical distance between widgets', 'theme-options', 'the7mk2' ),
	'id'    => 'sidebar-vertical_distance',
	'std'   => '60px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'type' => 'divider' );

$options['sidebar-distance_to_content'] = array(
	'name'  => _x( 'Distance between content area & sidebar', 'theme-options', 'the7mk2' ),
	'id'    => 'sidebar-distance_to_content',
	'std'   => '50px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'type' => 'divider' );

$options['sidebar-visual_style'] = array(
	'name'      => _x( 'Sidebar style', 'theme-options', 'the7mk2' ),
	'id'        => 'sidebar-visual_style',
	'std'       => 'with_dividers',
	'type'      => 'images',
	'class'     => 'small',
	'options'   => array(
		'with_dividers'   => array(
			'title' => _x( 'Dividers', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/sidebar-visual_style-dividers.gif',
		),
		'with_bg'         => array(
			'title' => _x( 'Background behind whole sidebar', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/sidebar-visual_style-background-behind-whole-sidebar.gif',
		),
		'with_widgets_bg' => array(
			'title' => _x( 'Background behind each widget', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/sidebar-visual_style-background-behind-each-widget.gif',
		),
	),
	'show_hide' => array(
		'with_dividers'   => array( 'sidebar-dividers-vertical', 'sidebar-dividers-horizontal' ),
		'with_bg'         => array( 'sidebar-bg-settings', 'sidebar-dividers-horizontal' ),
		'with_widgets_bg' => 'sidebar-bg-settings',
	),
);

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'sidebar-visual_style sidebar-dividers-vertical' );

$options['sidebar-divider-vertical'] = array(
	'name'    => _x( 'Vertical divider', 'theme-options', 'the7mk2' ),
	'id'      => 'sidebar-divider-vertical',
	'std'     => '1',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/sidebar-divider-vertical-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/sidebar-divider-vertical-disabled.gif',
		),
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'sidebar-visual_style sidebar-dividers-horizontal' );

$options['sidebar-divider-horizontal'] = array(
	'name'    => _x( 'Dividers between widgets', 'theme-options', 'the7mk2' ),
	'id'      => 'sidebar-divider-horizontal',
	'std'     => '1',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/sidebar-divider-horizontal-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/sidebar-divider-vertical-disabled.gif',
		),
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'sidebar-visual_style sidebar-bg-settings' );

$options['sidebar-bg_color'] = array(
	'desc' => '',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'id'   => 'sidebar-bg_color',
	'std'  => '#ffffff',
	'type' => 'alpha_color',
);

$options['sidebar-bg_image'] = array(
	'type' => 'background_img',
	'id'   => 'sidebar-bg_image',
	'name' => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'std'  => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
);

$options['sidebar-decoration'] = array(
	'name'      => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'id'        => 'sidebar-decoration',
	'std'       => 'none',
	'type'      => 'images',
	'class'     => 'small',
	'show_hide' => array( 'outline' => true ),
	'options'   => array(
		'none'    => array(
			'title' => _x( 'None', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-content_boxes_decoration-none.gif',
		),
		'shadow'  => array(
			'title' => _x( 'Shadow', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-content_boxes_decoration-shadow.gif',
		),
		'outline' => array(
			'title' => _x( 'Outline', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-content_boxes_decoration-outline.gif',
		),
	),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['sidebar-decoration_outline_color'] = array(
	'name' => _x( 'Decoration outline color', 'theme-options', 'the7mk2' ),
	'id'   => 'sidebar-decoration_outline_color',
	'std'  => '#FFFFFF',
	'type' => 'alpha_color',
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_end' );

$options['sidebar-floating'] = array(
	'id'   => 'sidebar-floating',
	'name' => _x( 'Sticky sidebar ', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 0,
);

$options[] = array( 'name' => _x( 'Text', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['sidebar-headers_color'] = array(
	'name' => _x( 'Headings color', 'theme-options', 'the7mk2' ),
	'id'   => 'sidebar-headers_color',
	'std'  => '#000000',
	'type' => 'color',
);

$options['sidebar-primary_text_color'] = array(
	'name' => _x( 'Text color', 'theme-options', 'the7mk2' ),
	'id'   => 'sidebar-primary_text_color',
	'std'  => '#686868',
	'type' => 'color',
);

/**
 * Responsive.
 */
$options[] = array( 'name' => _x( 'Responsiveness', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['sidebar-responsiveness'] = array(
	'name'  => _x( 'Move sidebar below content after', 'theme-options', 'the7mk2' ),
	'id'    => 'sidebar-responsiveness',
	'std'   => '970px',
	'type'  => 'number',
	'units' => 'px',
);
