<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'layout',
);


$options[] = array(
	'name' => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['header-layout'] = array(
	'id'        => 'header-layout',
	'name'      => _x( 'Choose layout', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'std'       => 'classic',
	'style'     => 'vertical',
	'class'     => 'option-header-layout',
	'options'   => array(
		'classic'   => array(
			'title' => _x( 'Classic', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/h01.gif',
		),
		'inline'    => array(
			'title' => _x( 'Inline', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/h02.gif',
		),
		'split'     => array(
			'title' => _x( 'Split', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/h03.gif',
		),
		'side'      => array(
			'title' => _x( 'Side', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/h04.gif',
		),
		'top_line'  => array(
			'title' => _x( 'Top line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/h05.gif',
		),
		'side_line' => array(
			'title' => _x( 'Side line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/h06.gif',
		),

		'menu_icon' => array(
			'title' => _x( 'Floating menu button', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/h07.gif',
		),
	),
	'show_hide' => array(
		'side'      => array( 'header-below-menu-microwidgets' ),
		'top_line'  => array(
			'header-layout-side-navigation-settings',
			'header-in-top-line-microwidgets',
			'header-below-menu-microwidgets',
		),
		'menu_icon' => array( 'header-layout-side-navigation-settings', 'header-below-menu-microwidgets' ),
		'side_line' => array( 'header-layout-side-navigation-settings', 'header-below-menu-microwidgets' ),
	),
);

/**
 * Classic layout.
 */
$options[] = array(
	'name'       => _x( 'Classic header layout settings', 'theme-options', 'the7mk2' ),
	'id'         => 'header-layout-classic-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'classic',
	),
);

$options['header-classic-height'] = array(
	'id'    => 'header-classic-height',
	'name'  => _x( 'Header height', 'theme-options', 'the7mk2' ),
	'std'   => '140px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-classic-side-padding']    = array(
	'id'     => 'header-classic-side-padding',
	'name'   => _x( 'Header paddings', 'theme-options', 'the7mk2' ),
	'type'   => 'spacing',
	'std'    => '30px 30px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Left', 'theme-options', 'the7mk2' ),
		_x( 'Right', 'theme-options', 'the7mk2' ),
	),
);
$options['header-classic-switch_paddings'] = array(
	'name'  => _x( 'Mobile breakpoint', 'theme-options', 'the7mk2' ),
	'id'    => 'header-classic-switch_paddings',
	'type'  => 'number',
	'std'   => '0px',
	'units' => 'px',
);

$options['header-classic_mobile_paddings'] = array(
	'name'   => _x( 'Mobile paddings', 'theme-options', 'the7mk2' ),
	'id'     => 'header-classic_mobile_paddings',
	'type'   => 'spacing',
	'std'    => '0px 0px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Right', 'theme-options', 'the7mk2' ),
		_x( 'Left', 'theme-options', 'the7mk2' ),
	),
);

$options['header-classic-menu-position'] = array(
	'id'      => 'header-classic-menu-position',
	'name'    => _x( 'Menu position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'left',
	'options' => array(
		'left'    => array(
			'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-menu-position-left.gif',
		),
		'center'  => array(
			'title' => _x( 'Center', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-menu-position-center.gif',
		),
		'justify' => array(
			'title' => _x( 'Justified', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-menu-position-justify.gif',
		),
	),
	'class'   => 'small',
);

$options['header-classic-menu-margin'] = array(
	'id'     => 'header-classic-menu-margin',
	'name'   => _x( 'Menu margin', 'theme-options', 'the7mk2' ),
	'type'   => 'spacing',
	'std'    => '0px 0px',
	'fields' => array(
		_x( 'Top', 'theme-options', 'the7mk2' ),
		_x( 'Bottom', 'theme-options', 'the7mk2' ),
	),
);

$options['header-classic-logo-position'] = array(
	'id'      => 'header-classic-logo-position',
	'name'    => _x( 'Logo position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'left',
	'options' => array(
		'left'   => array(
			'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-logo-position-left.gif',
		),
		'center' => array(
			'title' => _x( 'Center', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-logo-position-center.gif',
		),
	),
	'class'   => 'small',
);

$options['header-classic-is_fullwidth'] = array(
	'id'      => 'header-classic-is_fullwidth',
	'name'    => _x( 'Full width', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-isfullwidth-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-classic-isfullwidth-disabled.gif',
		),
	),
);

/**
 * Inline header.
 */

$options[] = array(
	'name'       => _x( 'Inline header layout settings', 'theme-options', 'the7mk2' ),
	'id'         => 'header-layout-inline-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'inline',
	),
);

$options['header-inline-height'] = array(
	'id'    => 'header-inline-height',
	'name'  => _x( 'Header height', 'theme-options', 'the7mk2' ),
	'std'   => '140px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-inline-side-padding']    = array(
	'id'     => 'header-inline-side-padding',
	'name'   => _x( 'Header paddings', 'theme-options', 'the7mk2' ),
	'type'   => 'spacing',
	'std'    => '30px 30px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Left', 'theme-options', 'the7mk2' ),
		_x( 'Right', 'theme-options', 'the7mk2' ),
	),
);
$options['header-inline-switch_paddings'] = array(
	'name'  => _x( 'Mobile breakpoint', 'theme-options', 'the7mk2' ),
	'id'    => 'header-inline-switch_paddings',
	'type'  => 'number',
	'std'   => '0px',
	'units' => 'px',
);

$options['header-inline_mobile_paddings'] = array(
	'name'   => _x( 'Mobile paddings', 'theme-options', 'the7mk2' ),
	'id'     => 'header-inline_mobile_paddings',
	'type'   => 'spacing',
	'std'    => '0px 0px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Right', 'theme-options', 'the7mk2' ),
		_x( 'Left', 'theme-options', 'the7mk2' ),
	),
);

$options['header-inline-menu-position'] = array(
	'id'      => 'header-inline-menu-position',
	'name'    => _x( 'Menu position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'right',
	'options' => array(
		'left'    => array(
			'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-inline-menu-position-left.gif',
		),
		'right'   => array(
			'title' => _x( 'Right', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-inline-menu-position-right.gif',
		),
		'center'  => array(
			'title' => _x( 'Center', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-inline-menu-position-center.gif',
		),
		'justify' => array(
			'title' => _x( 'Justified', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-inline-menu-position-justify.gif',
		),
	),
	'class'   => 'small',
);

$options['header-inline-is_fullwidth'] = array(
	'id'      => 'header-inline-is_fullwidth',
	'name'    => _x( 'Full width', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-inline-isfullwidth-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-inline-isfullwidth-disabled.gif',
		),
	),
);

/**
 * Split header.
 */
$options[] = array(
	'name'       => _x( 'Split header layout settings', 'theme-options', 'the7mk2' ),
	'id'         => 'header-layout-split-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'split',
	),
);

$options[] = array(
	'desc' => sprintf(
		_x(
			'To display split menu You should <a href="%1$s">create</a> two separate custom menus and <a href="%2$s">assign</a> them to "Split Menu Left" and "Split Menu Right" locations.',
			'theme-options',
			'the7mk2'
		),
		admin_url( 'nav-menus.php' ),
		admin_url( 'nav-menus.php?action=locations' )
	),
	'type' => 'info',
);

$options['header-split-height'] = array(
	'id'    => 'header-split-height',
	'name'  => _x( 'Header height', 'theme-options', 'the7mk2' ),
	'std'   => '100px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-split-side-padding']    = array(
	'id'     => 'header-split-side-padding',
	'name'   => _x( 'Header paddings', 'theme-options', 'the7mk2' ),
	'type'   => 'spacing',
	'std'    => '30px 30px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Left', 'theme-options', 'the7mk2' ),
		_x( 'Right', 'theme-options', 'the7mk2' ),
	),
);
$options['header-split-switch_paddings'] = array(
	'name'  => _x( 'Mobile breakpoint', 'theme-options', 'the7mk2' ),
	'id'    => 'header-split-switch_paddings',
	'type'  => 'number',
	'std'   => '0px',
	'units' => 'px',
);

$options['header-split_mobile_paddings'] = array(
	'name'   => _x( 'Mobile paddings', 'theme-options', 'the7mk2' ),
	'id'     => 'header-split_mobile_paddings',
	'type'   => 'spacing',
	'std'    => '0px 0px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Right', 'theme-options', 'the7mk2' ),
		_x( 'Left', 'theme-options', 'the7mk2' ),
	),
);

$options['header-split-menu-position'] = array(
	'id'      => 'header-split-menu-position',
	'name'    => _x( 'Menu & microwidgets position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'inside',
	'options' => array(
		'justify'      => array(
			'title' => _x( 'Justified', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-split-menu-position-justify.gif',
		),
		'inside'       => array(
			'title' => _x( 'Menu inside, microwidgets outside', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-split-menu-position-inside.gif',
		),
		'fully_inside' => array(
			'title' => _x( 'Menu inside, microwidgets inside', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-split-menu-position-fullyinside.gif',
		),
		'outside'      => array(
			'title' => _x( 'Menu outside, microwidgets outside', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-split-menu-position-outside.gif',
		),
	),
	'class'   => 'small',
);

$options['header-split-is_fullwidth'] = array(
	'id'      => 'header-split-is_fullwidth',
	'name'    => _x( 'Full width', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-split-isfullwidth-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-split-isfullwidth-disabled.gif',
		),
	),
);

/**
 * Side header.
 */
$options[] = array(
	'name'       => _x( 'Side header layout settings', 'theme-options', 'the7mk2' ),
	'id'         => 'header-layout-side-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'side',
	),
);

$options[] = array(
	'name' => _x( 'Navigation area settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-side-width'] = array(
	'id'    => 'header-side-width',
	'name'  => _x( 'Header width', 'theme-options', 'the7mk2' ),
	'std'   => '300px',
	'type'  => 'number',
	'units' => 'px|%',
);

$options['header-side-position'] = array(
	'id'      => 'header-side-position',
	'name'    => _x( 'Header position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'left',
	'options' => array(
		'left'  => array(
			'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-side-position-left.gif',
		),
		'right' => array(
			'title' => _x( 'Right', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-side-position-right.gif',
		),
	),
	'class'   => 'small',
);


$options['header-side-content-padding'] = array(
	'id'   => 'header-side-content-padding',
	'name' => _x( 'Navigation area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Menu settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

presscore_options_apply_template( $options, 'side-header-menu', 'header-side' );

/**
 * Top line header.
 */
$options[] = array(
	'name'       => _x( 'Top line layout settings', 'theme-options', 'the7mk2' ),
	'id'         => 'header-layout-top_line-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'top_line',
	),
);

// Top line.
$options['layout-top_line-height'] = array(
	'id'    => 'layout-top_line-height',
	'name'  => _x( 'Top line height', 'theme-options', 'the7mk2' ),
	'std'   => '130px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-top_line-side-padding']    = array(
	'id'     => 'header-top_line-side-padding',
	'name'   => _x( 'Top line padding', 'theme-options', 'the7mk2' ),
	'type'   => 'spacing',
	'std'    => '30px 30px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Left', 'theme-options', 'the7mk2' ),
		_x( 'Right', 'theme-options', 'the7mk2' ),
	),
);
$options['header-top_line-switch_paddings'] = array(
	'name'  => _x( 'Mobile breakpoint', 'theme-options', 'the7mk2' ),
	'id'    => 'header-top_line-switch_paddings',
	'type'  => 'number',
	'std'   => '0px',
	'units' => 'px',
);

$options['header-top_line_mobile_paddings'] = array(
	'name'   => _x( 'Mobile paddings', 'theme-options', 'the7mk2' ),
	'id'     => 'header-top_line_mobile_paddings',
	'type'   => 'spacing',
	'std'    => '0px 0px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Right', 'theme-options', 'the7mk2' ),
		_x( 'Left', 'theme-options', 'the7mk2' ),
	),
);

$options['layout-top_line-logo-position'] = array(
	'id'      => 'layout-top_line-logo-position',
	'name'    => _x( 'Logo & menu button position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'left',
	'options' => array(
		'left_btn-right_logo'  => array(
			'title' => _x( 'Left button + right logo', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/top-line-left-right.gif',
		),
		'left_btn-center_logo' => array(
			'title' => _x( 'Left button + centered logo', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/top-line-left-center.gif',
		),
		'left'                 => array(
			'title' => _x( 'Right button + left logo', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-slideout-layout-topline-logo-position-left.gif',
		),
		'center'               => array(
			'title' => _x( 'Right button + centered logo', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-slideout-layout-topline-logo-position-center.gif',
		),
	),
	'class'   => 'small',
);

$options['layout-top_line-is_fullwidth'] = array(
	'id'      => 'layout-top_line-is_fullwidth',
	'name'    => _x( 'Full width', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '0',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-topline-fullwidth-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-topline-fullwidth-disabled.gif',
		),
	),
);


/**
 * Side line header.
 */
$options[] = array(
	'name'       => _x( 'Side line layout settings', 'theme-options', 'the7mk2' ),
	'id'         => 'header-layout-side_line-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'side_line',
	),
);

$options['header-side_line-width'] = array(
	'id'    => 'header-side_line-width',
	'name'  => _x( 'Side line width', 'theme-options', 'the7mk2' ),
	'std'   => '60px',
	'type'  => 'number',
	'units' => 'px',
);


/**
 * Menu icon header.
 */
$options[] = array(
	'name'       => _x( 'Floating menu button layout settings', 'theme-options', 'the7mk2' ),
	'id'         => 'header-layout-menu_icon-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => '==',
		'value'    => 'menu_icon',
	),
);

$options['layout-menu_icon-position'] = array(
	'id'      => 'layout-menu_icon-position',
	'name'    => _x( 'Logo & menu button position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'menu_icon_right',
	'options' => array(
		'menu_icon_left'  => array(
			'title' => _x( 'Left button + right logo', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/logo-right.gif',
		),
		'menu_icon_right' => array(
			'title' => _x( 'Right button + left logo', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/logo-left.gif',
		),
	),
	'class'   => 'small',
);

$options['layout-menu_icon-show_floating_logo'] = array(
	'id'      => 'layout-menu_icon-show_floating_logo',
	'name'    => _x( 'Floating logo', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => '1',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-slideout-layout-menuicon-showfloatinglogo-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-slideout-layout-menuicon-showfloatinglogo-disabled.gif',
		),
	),
	'class'   => 'small',
);

/**
 * Navigation settings.
 */

$options[] = array(
	'name'       => _x( 'Navigation', 'theme-options', 'the7mk2' ),
	'id'         => 'navigation-settings',
	'type'       => 'block',
	'dependency' => array(
		'field'    => 'header-layout',
		'operator' => 'IN',
		'value'    => array( 'top_line', 'menu_icon', 'side_line' ),
	),
);

/**
 * Side on click header.
 */
$options[] = array(
	'type'  => 'js_hide_begin',
	'class' => 'header-layout header-layout-side-navigation-settings',
);

$options['header_navigation'] = array(
	'id'        => 'header_navigation',
	'name'      => _x( 'Navigation', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'std'       => 'slide_out',
	'options'   => array(
		'slide_out' => array(
			'title' => _x( 'Side navigation', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/slide-out-header.gif',
		),
		'overlay'   => array(
			'title' => _x( 'Overlay navigation', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/overlay-header.gif',
		),
	),
	'class'     => 'small',
	'show_hide' => array(
		'slide_out' => 'slide_out_navigation_options',
		'overlay'   => 'header-layout-overlay-settings',
	),
);

$options[] = array(
	'type'  => 'js_hide_begin',
	'class' => 'header_navigation slide_out_navigation_options',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Navigation area settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-slide_out-width'] = array(
	'id'    => 'header-slide_out-width',
	'name'  => _x( 'Navigation area width', 'theme-options', 'the7mk2' ),
	'std'   => '300px',
	'type'  => 'number',
	'units' => 'px|%',
);

$options['header-slide_out-position'] = array(
	'id'      => 'header-slide_out-position',
	'name'    => _x( 'Navigation area position', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'left',
	'options' => array(
		'left'  => array(
			'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-side-position-left.gif',
		),
		'right' => array(
			'title' => _x( 'Right', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-side-position-right.gif',
		),
	),
	'class'   => 'small',
);

$options['header-slide_out-content-padding'] = array(
	'id'   => 'header-slide_out-content-padding',
	'name' => _x( 'Navigation area paddings', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 0px 0px 0px',
);

$options['header-slide_out-overlay-animation'] = array(
	'id'      => 'header-slide_out-overlay-animation',
	'name'    => _x( 'Animation on opening', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'fade',
	'options' => array(
		'fade'  => array(
			'title' => _x( 'Fade', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-slideout-overlay-animation-fade.gif',
		),
		'slide' => array(
			'title' => _x( 'Slide', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/header-slideout-overlay-animation-slide.gif',
		),
	),
	'class'   => 'small',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Menu settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

presscore_options_apply_template( $options, 'side-header-menu', 'header-slide_out' );

$options[] = array( 'type' => 'js_hide_end' );

/**
 * Overlay navigation.
 */
$options[] = array(
	'type'  => 'js_hide_begin',
	'class' => 'header_navigation header-layout-overlay-settings',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Navigation area settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

presscore_options_apply_template(
	$options,
	'side-header-content',
	'header-overlay',
	array(
		'content-width'    => array(
			'name' => _x( 'Navigation area width', 'theme-options', 'the7mk2' ),
			'std'  => '400px',
		),
		'content-position' => array(
			'name'    => _x( 'Navigation area position', 'theme-options', 'the7mk2' ),
			'options' => array(
				'left'   => array(
					'src' => '/inc/admin/assets/images/header-overlay-content-position-left.gif',
				),
				'center' => array(
					'src' => '/inc/admin/assets/images/header-overlay-content-position-center.gif',
				),
				'right'  => array(
					'src' => '/inc/admin/assets/images/header-overlay-content-position-right.gif',
				),
			),
		),
	),
	array(
		array(
			array(
				'field'    => 'header_navigation',
				'operator' => '==',
				'value'    => 'overlay',
			),
		),
	)
);

$options['header-overlay-content-padding'] = array(
	'id'         => 'header-overlay-content-padding',
	'name'       => _x( 'Navigation area paddings', 'theme-options', 'the7mk2' ),
	'type'       => 'spacing',
	'std'        => '0px 0px 0px 0px',
	'dependency' => array(
		'field'    => 'header_navigation',
		'operator' => '==',
		'value'    => 'overlay',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'menu settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

presscore_options_apply_template(
	$options,
	'side-header-menu',
	'header-overlay',
	array(),
	array(
		array(
			array(
				'field'    => 'header_navigation',
				'operator' => '==',
				'value'    => 'overlay',
			),
		),
	)
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_end' );
