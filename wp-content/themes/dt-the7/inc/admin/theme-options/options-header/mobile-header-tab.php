<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Mobile header', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'mobile-header',
);


$options[] = array(
	'name' => _x( 'Tablet breakpoint', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

presscore_options_apply_template(
	$options,
	'mobile-header',
	'header-mobile-first_switch',
	array(
		'after'  => array(
			'std'  => '1024px',
			'desc' => _x(
				'To skip this breakpoint, set the same value as in the phone breakpoint.',
				'theme-options',
				'the7mk2'
			),
		),
		'height' => array( 'std' => '150' ),
		'layout' => array(
			'type'    => 'images',
			'options' => array(
				'left_right'   => array(
					'title' => _x( 'Left menu + right logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-firstswitch-layout-l-r.gif',
				),
				'left_center'  => array(
					'title' => _x( 'Left menu + centered logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-firstswitch-layout-l-c.gif',
				),
				'right_left'   => array(
					'title' => _x( 'Right menu + left logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-firstswitch-layout-r-l.gif',
				),
				'right_center' => array(
					'title' => _x( 'Right menu + centered logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-firstswitch-layout-r-c.gif',
				),
			),
			'class'   => 'small',
		),
	)
);


$options[] = array(
	'name' => _x( 'Phone breakpoint', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

presscore_options_apply_template(
	$options,
	'mobile-header',
	'header-mobile-second_switch',
	array(
		'after'  => array(
			'std'  => '760px',
			'desc' => _x( 'To skip this breakpoint, set it to 0.', 'theme-options', 'the7mk2' ),
		),
		'height' => array( 'std' => '100' ),
		'layout' => array(
			'type'    => 'images',
			'options' => array(
				'left_right'   => array(
					'title' => _x( 'Left menu + right logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-secondswitch-layout-l-r.gif',
				),
				'left_center'  => array(
					'title' => _x( 'Left menu + centered logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-secondswitch-layout-l-c.gif',
				),
				'right_left'   => array(
					'title' => _x( 'Right menu + left logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-secondswitch-layout-r-l.gif',
				),
				'right_center' => array(
					'title' => _x( 'Right menu + centered logo', 'theme-options', 'the7mk2' ),
					'src'   => '/inc/admin/assets/images/header-mobile-secondswitch-layout-r-c.gif',
				),
			),
			'class'   => 'small',
		),
	)
);


$options[] = array(
	'name' => _x( 'Mobile header', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options[] = array(
	'name' => _x( 'Header background', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-header-bg-color'] = array(
	'id'   => 'header-mobile-header-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#ffffff',
);

$options['header-mobile-decoration'] = array(
	'id'      => 'header-mobile-decoration',
	'name'    => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'shadow',
	'options' => array(
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
	'class'   => 'small',
);

$options['header-mobile-decoration-color'] = array(
	'id'         => 'header-mobile-decoration-color',
	'name'       => _x( 'Line color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-mobile-decoration',
		'operator' => 'IN',
		'value'    => array( 'content-width-line', 'line' ),
	),

);

$options['header-mobile-decoration-line_size'] = array(
	'id'         => 'header-mobile-decoration-line_size',
	'name'       => _x( 'Line height', 'theme-options', 'the7mk2' ),
	'std'        => '1px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-mobile-decoration',
		'operator' => 'IN',
		'value'    => array( 'content-width-line', 'line' ),
	),
);


$options[] = array(
	'name' => _x( 'Floating mobile header', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-mobile-floating_navigation'] = array(
	'id'      => 'header-mobile-floating_navigation',
	'name'    => _x( 'Floating mobile header', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'menu_icon',
	'options' => array(
		'disabled'  => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-mobile-floating_navigation-disabled.gif',
		),
		'sticky'    => array(
			'title' => _x( 'Sticky mobile header', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-mobile-floating_navigation-sticky-header.gif',
		),
		'menu_icon' => array(
			'title' => _x( 'Floating menu button', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-mobile-floating_navigation-icon.gif',
		),
	),
	'class'   => 'small',
);


$options[] = array(
	'name' => _x( '"Open menu" button', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-mobile-menu_icon-size'] = array(
	'id'      => 'header-mobile-menu_icon-size',
	'name'    => _x( 'Choose icon', 'theme-options', 'the7mk2' ),
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

$options['header-mobile-menu_icon-caption'] = array(
	'id'      => 'header-mobile-menu_icon-caption',
	'name'    => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'left'     => _x( 'Before', 'theme-options', 'the7mk2' ),
		'right'    => _x( 'After', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_icon-caption-text'] = array(
	'id'         => 'header-mobile-menu_icon-caption-text',
	'name'       => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'type'       => 'text',
	'std'        => _x( 'Menu', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-mobile-menu_icon-caption-typography'] = array(
	'id'         => 'header-mobile-menu_icon-caption-typography',
	'type'       => 'typography',
	'std'        => array(
		'font_family'    => 'Roboto',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
	'dependency' => array(
		'field'    => 'header-mobile-menu_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-mobile-menu_icon-caption_gap'] = array(
	'id'         => 'header-mobile-menu_icon-caption_gap',
	'name'       => _x( 'Caption gap', 'theme-options', 'the7mk2' ),
	'std'        => '10px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'header-mobile-menu_icon-caption',
		'operator' => 'IN',
		'value'    => array( 'left', 'right' ),
	),
);

$options['header-mobile-menu_icon-bg-border-width'] = array(
	'id'    => 'header-mobile-menu_icon-bg-border-width',
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-mobile-menu_icon-bg-border-radius'] = array(
	'id'    => 'header-mobile-menu_icon-bg-border-radius',
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-mobile-menu_icon-caption-padding'] = array(
	'id'   => 'header-mobile-menu_icon-caption-padding',
	'name' => _x( 'Paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '5px 10px 5px 10px',
);

$options['header-mobile-menu_icon-margin'] = array(
	'id'   => 'header-mobile-menu_icon-margin',
	'name' => _x( 'Margins', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Normal', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['header-mobile-menu_icon-color'] = array(
	'id'       => 'header-mobile-menu_icon-color',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'std'      => '#fff',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_icon-caption_color'] = array(
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'       => 'header-mobile-menu_icon-caption_color',
	'std'      => '#fff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_icon-bg-enable'] = array(
	'id'      => 'header-mobile-menu_icon-bg-enable',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => '1',
	'options' => array(
		'0' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'1' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_icon-bg-color'] = array(
	'id'         => 'header-mobile-menu_icon-bg-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_icon-bg-enable',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['header-mobile-menu_icon-border'] = array(
	'id'      => 'header-mobile-menu_icon-border',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_icon-border-color'] = array(
	'id'         => 'header-mobile-menu_icon-border-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_icon-border',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Hover', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-mobile-menu_icon-color-hover'] = array(
	'id'       => 'header-mobile-menu_icon-color-hover',
	'name'     => _x( 'Icon color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'std'      => '#fff',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_icon-caption_color-hover'] = array(
	'id'       => 'header-mobile-menu_icon-caption_color-hover',
	'name'     => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'std'      => '#fff',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
);

$options['header-mobile-menu_icon-bg-hover'] = array(
	'id'      => 'header-mobile-menu_icon-bg-hover',
	'name'    => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => '1',
	'options' => array(
		'0' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'1' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_icon-bg-color-hover'] = array(
	'id'         => 'header-mobile-menu_icon-bg-color-hover',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'dependency' => array(
		'field'    => 'header-mobile-menu_icon-bg-hover',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['header-mobile-menu_icon-border-hover'] = array(
	'id'      => 'header-mobile-menu_icon-border-hover',
	'name'    => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'enabled'  => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$options['header-mobile-menu_icon-border-hover-color'] = array(
	'id'         => 'header-mobile-menu_icon-border-hover-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '',
	'sanitize'   => 'empty_alpha_color',
	'desc'       => _x( 'Leave empty to use accent color.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		'field'    => 'header-mobile-menu_icon-border-hover',
		'operator' => '==',
		'value'    => 'enabled',
	),
);
