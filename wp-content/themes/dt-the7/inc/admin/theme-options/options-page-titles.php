<?php
/**
 * Page titles settings.
 *
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options[] = array( 'name' => _x( 'Layout', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'layout' );

$options[] = array( 'name' => _x( 'Title area layout', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-title_align'] = array(
	'id'      => 'general-title_align',
	'name'    => _x( 'Title area layout', 'theme-options', 'the7mk2' ),
	'desc'    => _x( 'Title and breadcrumbs interposition', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'left',
	'options' => array(
		'left'      => array(
			'title' => _x( 'Left title + right breadcrumbs', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/l-r.gif',
		),
		'right'     => array(
			'title' => _x( 'Right title + left breadcrumbs', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/r-l.gif',
		),
		'all_left'  => array(
			'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/l-l.gif',
		),
		'all_right' => array(
			'title' => _x( 'Right', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/r-r.gif',
		),
		'center'    => array(
			'title' => _x( 'Centered', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/centre.gif',
		),
	),
);

$options[] = array( 'type' => 'divider' );

$options['general-title_height'] = array(
	'id'    => 'general-title_height',
	'name'  => _x( 'Title area height', 'theme-options', 'the7mk2' ),
	'std'   => '170px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'type' => 'divider' );

$options['page_title-padding'] = array(
	'name'   => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'id'     => 'page_title-padding',
	'type'   => 'spacing',
	'std'    => '0px 0px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Top', 'theme-options', 'the7mk2' ),
		_x( 'Bottom', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'name' => _x( 'Style', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'style' );

$options[] = array( 'name' => _x( 'Title area style', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-title_bg_mode'] = array(
	'id'        => 'general-title_bg_mode',
	'name'      => _x( 'Choose style', 'theme-options', 'the7mk2' ),
	'type'      => 'images',
	'class'     => 'small',
	'std'       => 'content_line',
	'options'   => array(
		'disabled'     => array(
			'title' => _x( 'Plain', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-title_bg_mode-disabled.gif',
		),
		'background'   => array(
			'title' => _x( 'Background', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/centre.gif',
		),
		'gradient'     => array(
			'title' => _x( 'Gradient', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-title_bg_mode-gradient.gif',
		),
		'content_line' => array(
			'title' => _x( 'Decorative line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-title_bg_mode-content-width-line.gif',
		),
	),
	'show_hide' => array(
		'background'   => array(
			'general-title-bg-mode-main-container',
			'general-title-bg-image',
			'general-title-bg-solid-color',
		),
		'gradient'     => array( 'general-title-bg-mode-main-container', 'general-title-bg-gradient-color' ),
		'content_line' => array( 'general-title-line-mode-main-container' ),
	),
);

$options[] = array(
	'type'  => 'js_hide_begin',
	'class' => 'general-title_bg_mode general-title-bg-mode-main-container',
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'general-title_bg_mode general-title-bg-solid-color' );

$options[] = array( 'name' => _x( 'Background', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['general-title_bg_color'] = array(
	'id'   => 'general-title_bg_color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#ffffff',
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Border', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['general-title_decoration'] = array(
	'id'        => 'general-title_decoration',
	'name'      => _x( 'Border', 'theme-options', 'the7mk2' ),
	'type'      => 'radio',
	'class'     => 'small',
	'desc'      => _x( 'Decorative line below background.', 'theme-options', 'the7mk2' ),
	'std'       => 'none',
	'show_hide' => array( 'outline' => true ),
	'options'   => array(
		'outline' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
		'none'    => _x( 'Disabled', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['general-title_decoration_outline_color'] = array(
	'id'   => 'general-title_decoration_outline_color',
	'name' => _x( 'Border color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#FFFFFF',
);

$options['general-title_decoration_outline_height'] = array(
	'name'  => _x( 'Border height', 'theme-options', 'the7mk2' ),
	'id'    => 'general-title_decoration_outline_height',
	'std'   => '1px',
	'type'  => 'number',
	'units' => 'px',
);

$options['general-title_decoration_outline_style'] = array(
	'name'    => _x( 'Border style', 'theme-options', 'the7mk2' ),
	'id'      => 'general-title_decoration_outline_style',
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'solid',
	'options' => array(
		'solid'  => _x( 'Solid', 'theme-options', 'the7mk2' ),
		'dotted' => _x( 'Dotted', 'theme-options', 'the7mk2' ),
		'dashed' => _x( 'Dashed', 'theme-options', 'the7mk2' ),
		'double' => _x( 'Double', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'divider' );

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'general-title_bg_mode general-title-bg-gradient-color' );

$options[] = array( 'name' => _x( 'Gradient', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['general-title_bg_gradient'] = array(
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'gradient_picker',
	'id'   => 'general-title_bg_gradient',
	'std'  => '135deg|#ffffff 30%|#000000 100%',
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'general-title_bg_mode general-title-bg-image' );

$options[] = array( 'name' => _x( 'Background Image', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['general-title_enable_bg_img'] = array(
	'id'        => 'general-title_enable_bg_img',
	'name'      => _x( 'Background Image', 'theme-options', 'the7mk2' ),
	'type'      => 'radio',
	'class'     => 'small',
	'std'       => 'disabled',
	'show_hide' => array( 'enabled' => true ),
	'options'   => array(
		'enabled'  => _x( 'Enabled', 'backend metabox', 'the7mk2' ),
		'disabled' => _x( 'Disabled', 'backend metabox', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['general-title_bg_image'] = array(
	'id'   => 'general-title_bg_image',
	'name' => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'type' => 'background_img',
	'std'  => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
);

$options['general-title_bg_fullscreen'] = array(
	'id'   => 'general-title_bg_fullscreen',
	'name' => _x( 'Fullscreen ', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 0,
);

$options['general-title_bg_overlay'] = array(
	'id'   => 'general-title_bg_overlay',
	'name' => _x( 'Enable color overlay ', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => 0,
);

$options['general-title_overlay_color'] = array(
	'id'         => 'general-title_overlay_color',
	'name'       => _x( 'Overlay color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => 'rgba(0,0,0,0.5)',
	'dependency' => array(
		'field'    => 'general-title_bg_overlay',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-title_scroll_effect'] = array(
	'name'      => _x( 'Scroll effect', 'theme-options', 'the7mk2' ),
	'id'        => 'general-title_scroll_effect',
	'type'      => 'radio',
	'std'       => 'default',
	'options'   => array(
		'default'  => _x( 'Move with the content', 'theme-options', 'the7mk2' ),
		'fixed'    => _x( "Fixed at it's position", 'theme-options', 'the7mk2' ),
		'parallax' => _x( 'Vertical parallax on scroll', 'theme-options', 'the7mk2' ),
	),
	'show_hide' => array( 'custom' => true ),
);

$options['general-title_bg_parallax'] = array(
	'id'         => 'general-title_bg_parallax',
	'name'       => _x( 'Parallax speed', 'theme-options', 'the7mk2' ),
	'desc'       => _x( 'Enter value between 0 to 1', 'theme-options', 'the7mk2' ),
	'type'       => 'text',
	'std'        => '0.5',
	'class'      => 'mini',
	'dependency' => array(
		'field'    => 'general-title_scroll_effect',
		'operator' => '==',
		'value'    => 'parallax',
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Header', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['header-background'] = array(
	'id'        => 'header-background',
	'name'      => _x( 'Header style', 'theme-options', 'the7mk2' ),
	'std'       => 'normal',
	'type'      => 'images',
	'class'     => 'small',
	'options'   => array(
		'normal'      => array(
			'src'   => '/inc/admin/assets/images/header-background-default.gif',
			'title' => _x( 'Default', 'theme-options', 'the7mk2' ),
			//'title_width' => 100,
		),
		'overlap'     => array(
			'src'   => '/inc/admin/assets/images/header-background-overlapping.gif',
			'title' => _x( 'Overlapping', 'theme-options', 'the7mk2' ),
			//'title_width' => 100,
		),
		'transparent' => array(
			'src'   => '/inc/admin/assets/images/header-background-transparent.gif',
			'title' => _x( 'Transparent', 'theme-options', 'the7mk2' ),
			//'title_width' => 100,
		),
	),
	'show_hide' => array(
		'transparent' => true,
	),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['header-transparent_bg_color'] = array(
	'id'   => 'header-transparent_bg_color',
	'name' => _x( 'Header color', 'backend metabox', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(0,0,0,0.5)',
);

$options['top-bar-transparent_bg_color'] = array(
	'id'   => 'top-bar-transparent_bg_color',
	'name' => _x( 'Top bar color', 'backend metabox', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(0,0,0,0.5)',
);

$options['page_title-background-style-transparent-color_scheme'] = array(
	'id'      => 'page_title-background-style-transparent-color_scheme',
	'name'    => _x( 'Color scheme', 'theme-options', 'the7mk2' ),
	'desc'    => _x( 'Affects menu color, microwidgets etc.', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'from_options',
	'options' => array(
		'from_options' => _x( 'From Theme Options', 'theme-options', 'the7mk2' ),
		'light'        => _x( 'Light', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array(
	'type'  => 'js_hide_begin',
	'class' => 'general-title_bg_mode general-title-line-mode-main-container',
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Decorative line', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['general-title_decoration_line_color'] = array(
	'id'   => 'general-title_decoration_line_color',
	'name' => _x( 'Сolor', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(51, 51, 51, 0.11)',
);

$options['general-title_decoration_line_height'] = array(
	'name'  => _x( 'Height', 'theme-options', 'the7mk2' ),
	'id'    => 'general-title_decoration_line_height',
	'std'   => '1px',
	'type'  => 'number',
	'units' => 'px',
);

$options['general-title_decoration_line_style'] = array(
	'name'    => _x( 'Style', 'theme-options', 'the7mk2' ),
	'id'      => 'general-title_decoration_line_style',
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'solid',
	'options' => array(
		'solid'  => _x( 'Solid', 'theme-options', 'the7mk2' ),
		'dotted' => _x( 'Dotted', 'theme-options', 'the7mk2' ),
		'dashed' => _x( 'Dashed', 'theme-options', 'the7mk2' ),
		'double' => _x( 'Double', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'name' => _x( 'Title', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'title' );

$options[] = array( 'name' => _x( 'Page title', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-show_titles'] = array(
	'id'      => 'general-show_titles',
	'name'    => _x( 'Page title', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => '1',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-showtitles-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-showtitles-disabled.gif',
		),
	),
);

$options['general-page-title-typography'] = array(
	'id'         => 'general-page-title-typography',
	'type'       => 'typography',
	'std'        => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 20,
		'line_height'    => 20,
		'text_transform' => 'none',
	),
	'dependency' => array(
		'field'    => 'general-show_titles',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-title_color'] = array(
	'id'         => 'general-title_color',
	'name'       => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#222222',
	'dependency' => array(
		'field'    => 'general-show_titles',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array(
	'name' => _x( 'Breadcrumbs', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'breadcrumbs',
);

$options[] = array( 'name' => _x( 'Breadcrumbs', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-show_breadcrumbs'] = array(
	'id'        => 'general-show_breadcrumbs',
	'name'      => _x( 'Breadcrumbs', 'theme-options', 'the7mk2' ),
	'std'       => '1',
	'type'      => 'images',
	'class'     => 'small',
	'show_hide' => array( '1' => true ),
	'options'   => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-showbreadcrumbs-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-showbreadcrumbs-disabled.gif',
		),
	),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Font', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['breadcrumbs-typography'] = array(
	'id'         => 'breadcrumbs-typography',
	'type'       => 'typography',
	'std'        => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 12,
		'line_height'    => 16,
		'text_transform' => 'none',
	),
	'dependency' => array(
		'field'    => 'general-show_breadcrumbs',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-breadcrumbs_color'] = array(
	'id'         => 'general-breadcrumbs_color',
	'name'       => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'general-show_breadcrumbs',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array( 'type' => 'divider' );

$options['breadcrumbs_padding'] = array(
	'id'         => 'breadcrumbs_padding',
	'name'       => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'type'       => 'spacing',
	'std'        => '3px 12px 2px 12px',
	'units'      => 'px|%',
	'dependency' => array(
		'field'    => 'general-show_breadcrumbs',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['breadcrumbs_margin'] = array(
	'id'         => 'breadcrumbs_margin',
	'name'       => _x( 'Margin', 'theme-options', 'the7mk2' ),
	'type'       => 'spacing',
	'std'        => '0px 0px 0px 0px',
	'units'      => 'px|%',
	'dependency' => array(
		'field'    => 'general-show_breadcrumbs',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Background & border', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['general-breadcrumbs_bg_color'] = array(
	'id'         => 'general-breadcrumbs_bg_color',
	'name'       => _x( 'Background & border', 'theme-options', 'the7mk2' ),
	'type'       => 'images',
	'class'      => 'small',
	'std'        => 'disabled',
	'options'    => array(
		'enabled'  => array(
			'title' => _x( 'Enabled', 'backend metabox', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-breadcrumbsbgcolor-black.gif',
		),
		'disabled' => array(
			'title' => _x( 'Disabled', 'backend metabox', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-breadcrumbsbgcolor-disabled.gif',
		),
	),
	'dependency' => array(
		'field'    => 'general-show_breadcrumbs',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['breadcrumbs_bg_color'] = array(
	'id'         => 'breadcrumbs_bg_color',
	'name'       => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => 'rgba(255,255,255,0.2)',
	'dependency' => array(
		'field'    => 'general-breadcrumbs_bg_color',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['breadcrumbs_border_radius'] = array(
	'name'       => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'id'         => 'breadcrumbs_border_radius',
	'std'        => '2px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'general-breadcrumbs_bg_color',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['breadcrumbs_border_width'] = array(
	'name'       => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'id'         => 'breadcrumbs_border_width',
	'std'        => '0px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'general-breadcrumbs_bg_color',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options['breadcrumbs_border_color'] = array(
	'id'         => 'breadcrumbs_border_color',
	'name'       => _x( 'Border color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => 'rgba(255,255,255,0.5)',
	'dependency' => array(
		'field'    => 'general-breadcrumbs_bg_color',
		'operator' => '==',
		'value'    => 'enabled',
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array(
	'name' => _x( 'Responsiveness', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'responsiveness',
);

$options[] = array( 'name' => _x( 'Responsive layout ', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-titles_responsiveness'] = array(
	'id'        => 'general-titles_responsiveness',
	'name'      => _x( 'Responsive layout', 'theme-options', 'the7mk2' ),
	'type'      => 'radio',
	'class'     => 'small',
	'std'       => '0',
	'options'   => array(
		'1' => _x( 'Enabled', 'theme-options', 'the7mk2' ),

		'0' => _x( 'Disabled', 'theme-options', 'the7mk2' ),

	),
	'show_hide' => array(
		'1' => true,
	),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options['general-titles-responsiveness-switch'] = array(
	'name'  => _x( 'Switch to responsive layout after', 'theme-options', 'the7mk2' ),
	'id'    => 'general-titles-responsiveness-switch',
	'std'   => '990px',
	'type'  => 'number',
	'units' => 'px',
);

$options['general-responsive_title_height'] = array(
	'name'  => _x( 'Responsive title area height', 'theme-options', 'the7mk2' ),
	'id'    => 'general-responsive_title_height',
	'std'   => '150px',
	'type'  => 'number',
	'units' => 'px',
);

$options['general-responsive_title_size'] = array(
	'name'     => _x( 'Responsive title font size', 'theme-options', 'the7mk2' ),
	'id'       => 'general-responsive_title_size',
	'std'      => '20',
	'type'     => 'slider',
	'options'  => array( 'min' => 1, 'max' => 120 ),
	'sanitize' => 'font_size',
);

$options['general-responsive_title_line_height'] = array(
	'name'     => _x( 'Responsive title line height', 'theme-options', 'the7mk2' ),
	'id'       => 'general-responsive_title_line_height',
	'std'      => '30',
	'type'     => 'slider',
	'options'  => array( 'min' => 1, 'max' => 150 ),
	'sanitize' => 'font_size',
);

$options['general-title_responsive_breadcrumbs'] = array(
	'name' => _x( 'Disable breadcrumbs', 'theme-options', 'the7mk2' ),
	'id'   => 'general-title_responsive_breadcrumbs',
	'type' => 'checkbox',
	'std'  => '0',
);

$options[] = array( 'type' => 'js_hide_end' );
