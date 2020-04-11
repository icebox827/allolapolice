<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Floating header', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'floating-header',
);


$options[] = array(
	'name' => _x( 'Floating navigation', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-show_floating_navigation'] = array(
	'id'        => 'header-show_floating_navigation',
	'name'      => _x( 'Floating navigation', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'class'     => 'small',
	'std'       => '1',
	'options'   => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-showfloatingnavigation-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-showfloatingnavigation-disabled.gif',
		),
	),
	'show_hide' => array( '1' => true ),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['header-floating_navigation-height'] = array(
	'id'    => 'header-floating_navigation-height',
	'name'  => _x( 'Height', 'theme-options', 'the7mk2' ),
	'std'   => '100px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-floating_navigation-bg-color'] = array(
	'id'   => 'header-floating_navigation-bg-color',
	'name' => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(255,255,255,0.9)',
);

$options['header-floating_navigation-bg-image'] = array(
	'id'   => 'header-floating_navigation-bg-image',
	'name' => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'type' => 'background_img',
	'std'  => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
);

$options['header-floating_navigation-bg-is_fullscreen'] = array(
	'id'   => 'header-floating_navigation-bg-is_fullscreen',
	'name' => _x( 'Fullscreen ', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 0,
);

$options['header-floating_navigation-decoration'] = array(
	'id'      => 'header-floating_navigation-decoration',
	'name'    => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'disabled',
	'options' => array(
		'disabled'           => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-floatingnavigation-decoration-disabled.gif',
		),
		'shadow'             => array(
			'title' => _x( 'Shadow', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-floatingnavigation-decoration-shadow.gif',
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
);

$options['header-floating_navigation-decoration-color']     = array(
	'id'         => 'header-floating_navigation-decoration-color',
	'name'       => _x( 'Line color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-floating_navigation-decoration',
		'operator' => 'IN',
		'value'    => array( 'content-width-line', 'line' ),
	),
);
$options['header-floating_navigation-decoration-line_size'] = array(
	'id'         => 'header-floating_navigation-decoration-line_size',
	'name'       => _x( 'Line height', 'theme-options', 'the7mk2' ),
	'std'        => '1px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(

		array(
			'field'    => 'header-floating_navigation-decoration',
			'operator' => 'IN',
			'value'    => array( 'content-width-line', 'line' ),
		),

	),
);

$options['header-floating_navigation-style'] = array(
	'id'      => 'header-floating_navigation-style',
	'name'    => _x( 'Effect', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'fade',
	'options' => array(
		'fade'   => array(
			'title' => _x( 'Fade on scroll', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-floatingnavigationstyle-fade.gif',
		),
		'slide'  => array(
			'title' => _x( 'Slide on scroll', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-floatingnavigationstyle-slide.gif',
		),
		'sticky' => array(
			'title' => _x( 'Sticky', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-floatingnavigationstyle-sticky.gif',
		),
	),
);

$options['header-floating_navigation-show_after'] = array(
	'id'         => 'header-floating_navigation-show_after',
	'name'       => _x( 'Show after scrolling', 'theme-options', 'the7mk2' ),
	'std'        => '150px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-floating_navigation-style',
		'operator' => 'IN',
		'value'    => array( 'fade', 'slide' ),
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Floating header menu font colors', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-floating_navigation-font-normal'] = array(
	'name'    => _x( 'Normal', 'theme-options', 'the7mk2' ),
	'id'      => 'header-floating_navigation-font-normal',
	'type'    => 'radio',
	'std'     => 'default',
	'options' => array(
		'default' => _x( 'No change', 'theme-options', 'the7mk2' ),
		'color'   => _x( 'Custom color', 'theme-options', 'the7mk2' ),
	),
);

$options['header-floating_navigation-font-color'] = array(
	'id'         => 'header-floating_navigation-font-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-floating_navigation-font-normal',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-floating_navigation-font-hover'] = array(
	'name'    => _x( 'Hover', 'theme-options', 'the7mk2' ),
	'id'      => 'header-floating_navigation-font-hover',
	'type'    => 'radio',
	'std'     => 'default',
	'options' => array(
		'default'  => _x( 'No change', 'theme-options', 'the7mk2' ),
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-floating_navigation-hover-font-color'] = array(
	'id'         => 'header-floating_navigation-hover-font-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-floating_navigation-font-hover',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-floating_navigation-hover-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-floating_navigation-hover-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-floating_navigation-font-hover',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-floating_navigation-font-active'] = array(
	'name'    => _x( 'Active', 'theme-options', 'the7mk2' ),
	'id'      => 'header-floating_navigation-font-active',
	'type'    => 'radio',
	'std'     => 'default',
	'options' => array(
		'default'  => _x( 'No change', 'theme-options', 'the7mk2' ),
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-floating_navigation-active_item-font-color'] = array(
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'id'         => 'header-floating_navigation-active_item-font-color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-floating_navigation-font-active',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-floating_navigation-active_item-font-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-floating_navigation-active_item-font-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg',
	'dependency'  => array(
		'field'    => 'header-floating_navigation-font-active',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options[] = array( 'type' => 'divider' );

$options['header-floating_navigation-top-bar'] = array(
	'id'   => 'header-floating_navigation-top-bar',
	'name' => _x( 'Floating top bar ', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 0,
);

$options[] = array( 'type' => 'js_hide_end' );
