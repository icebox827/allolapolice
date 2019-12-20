<?php
/**
 * Wizard options.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$options[] = array( 'name' => _x( 'General', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'general' );

$options[] = array( 'name' => _x( 'Layout', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-layout'] = array(
	'name'      => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'id'        => 'general-layout',
	'type'      => 'images',
	'std'       => 'wide',
	'class'     => 'small',
	'options'   => array(
		'wide'  => array(
			'title' => _x( 'Wide', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-layout-wide.gif',
		),
		'boxed' => array(
			'title' => _x( 'Boxed', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-layout-boxed.gif',
		),
	),
	'show_hide' => array( 'boxed' => true ),
);

$options[] = array( 'type' => 'js_hide_begin' );

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Background under the box', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['general-boxed_bg_color'] = array(
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'id'   => 'general-boxed_bg_color',
	'type' => 'color',
	'std'  => '#ffffff',
);

$options['general-boxed_bg_image'] = array(
	'name' => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'id'   => 'general-boxed_bg_image',
	'type' => 'background_img',
	'std'  => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
);

$options['general-boxed_bg_fullscreen'] = array(
	'name' => _x( 'Fullscreen ', 'theme-options', 'the7mk2' ),
	'id'   => 'general-boxed_bg_fullscreen',
	'type' => 'checkbox',
	'std'  => 0,
);

$options['general-boxed_bg_fixed'] = array(
	'name' => _x( 'Fixed background ', 'theme-options', 'the7mk2' ),
	'id'   => 'general-boxed_bg_fixed',
	'type' => 'checkbox',
	'std'  => 0,
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'name' => _x( 'Background', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-bg_color'] = array(
	'name' => _x( 'Color', 'theme-options', 'the7mk2' ),
	'id'   => 'general-bg_color',
	'type' => 'alpha_color',
	'std'  => '#252525',
);

$options[] = array( 'name' => _x( 'Text', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options[] = array(
	'name' => _x( 'Headings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['fonts-h1_font_family'] = array(
	'name'    => _x( 'Headings font family', 'theme-options', 'the7mk2' ),
	'id'      => 'fonts-h1_font_family',
	'std'     => 'Open Sans:600',
	'type'    => 'web_fonts',
	'options' => apply_filters( 'presscore_options_get_web_fonts', array(
		'Arial:600'               => 'Arial Bold',
		'Arvo:700'                => 'Arvo (700)',
		'Cormorant Infant:700'    => 'Cormorant Infant (700)',
		'Cormorant Upright:700'   => 'Cormorant Upright (700)',
		'Dosis:700'               => 'Dosis Bold (700)',
		'Exo:700'                 => 'Exo (700)',
		'Fira Sans Condensed:700' => 'Fira Sans Condensed (700)',
		'Fira Sans:700'           => 'Fira Sans (700)',
		'Georgia:600'             => 'Georgia Bold',
		'Istok Web:700'           => 'Istok Web (700)',
		'Lato:700'                => 'Lato Bold (700)',
		'Libre Franklin:700'      => 'Libre Franklin (700)',
		'Merriweather:700'        => 'Merriweather Bold (700)',
		'Open Sans:700'           => 'Open Sans (700)',
		'Oswald:700'              => 'Oswald (700)',
		'Playfair Display:700'    => 'Playfair Display (700)',
		'PT Sans:700'             => 'PT Sans Bold (700)',
		'PT Serif:700'            => 'PT Serif (700)',
		'Raleway:700'             => 'Raleway (700)',
		'Roboto Condensed:700'    => 'Roboto Condensed (700)',
		'Roboto Slab:700'         => 'Roboto Slab (700)',
		'Roboto:700'              => 'Roboto Bold (700)',
		'Source Sans Pro:700'     => 'Source Sans Pro (700)',
		'Tahoma:600'              => 'Tahoma Bold',
		'Times New Roman:600'     => 'Times New Roman Bold',
		'Trebuchet MS:600'        => 'Trebuchet MS Bold',
		'Ubuntu:700'              => 'Ubuntu Bold (700)',
		'Vollkorn:700'            => 'Vollkorn (700)',
		'Work Sans:700'           => 'Work Sans (700)',
	) ),
);

$options['content-headers_color'] = array(
	'name' => _x( 'Headings color', 'theme-options', 'the7mk2' ),
	'id'   => 'content-headers_color',
	'std'  => '#252525',
	'type' => 'color',
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Basic fonts', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['fonts-font_family'] = array(
	'name'    => _x( 'Text font family', 'theme-options', 'the7mk2' ),
	'id'      => 'fonts-font_family',
	'std'     => 'Open Sans',
	'type'    => 'web_fonts',
	'options' => apply_filters( 'presscore_options_get_web_fonts', array(
		'Arial'               => 'Arial',
		'Arvo'                => 'Arvo',
		'Cormorant Infant'    => 'Cormorant Infant',
		'Cormorant Upright'   => 'Cormorant Upright',
		'Dosis'               => 'Dosis',
		'Exo'                 => 'Exo',
		'Fira Sans Condensed' => 'Fira Sans Condensed',
		'Fira Sans'           => 'Fira Sans',
		'Georgia'             => 'Georgia',
		'Istok Web'           => 'Istok Web',
		'Lato'                => 'Lato',
		'Libre Franklin'      => 'Libre Franklin',
		'Merriweather'        => 'Merriweather',
		'Open Sans'           => 'Open Sans',
		'Oswald'              => 'Oswald',
		'Playfair Display'    => 'Playfair Display',
		'PT Sans'             => 'PT Sans',
		'PT Serif'            => 'PT Serif',
		'Raleway'             => 'Raleway',
		'Roboto Condensed'    => 'Roboto Condensed',
		'Roboto Slab'         => 'Roboto Slab',
		'Roboto'              => 'Roboto',
		'Source Sans Pro'     => 'Source Sans Pro',
		'Tahoma'              => 'Tahoma',
		'Times New Roman'     => 'Times New Roman',
		'Trebuchet MS'        => 'Trebuchet MS',
		'Ubuntu'              => 'Ubuntu',
		'Vollkorn'            => 'Vollkorn',
		'Work Sans'           => 'Work Sans',
	) ),
);

$options['content-primary_text_color'] = array(
	'name' => _x( 'Primary text color', 'theme-options', 'the7mk2' ),
	'id'   => 'content-primary_text_color',
	'std'  => '#686868',
	'type' => 'color',
);

$options['content-secondary_text_color'] = array(
	'name' => _x( 'Secondary text color', 'theme-options', 'the7mk2' ),
	'id'   => 'content-secondary_text_color',
	'std'  => '#999999',
	'type' => 'color',
);

$options[] = array( 'name' => _x( 'Color accent', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-accent_color_mode'] = array(
	'name'    => _x( 'Accent color', 'theme-options', 'the7mk2' ),
	'id'      => 'general-accent_color_mode',
	'std'     => 'color',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'color'    => array(
			'title' => _x( 'Solid color', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/color-accent.gif',
		),
		'gradient' => array(
			'title' => _x( 'Gradient', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/color-custom-gradient.gif',
		),
	),
);

$options['general-accent_bg_color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'general-accent_bg_color',
	'std'        => '#D73B37',
	'type'       => 'color',
	'dependency' => array(
		'field'    => 'general-accent_color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['general-accent_bg_color_gradient'] = array(
	'name'       => '&nbsp;',
	'type'       => 'gradient_picker',
	'id'         => 'general-accent_bg_color_gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'general-accent_color_mode',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options[] = array( 'name' => _x( 'Buttons style', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['buttons-style'] = array(
	'name'    => 'Choose buttons style',
	'id'      => 'buttons-style',
	'std'     => 'flat',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'flat'   => array(
			'title' => _x( 'Flat', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/buttons-style-flat.gif',
		),
		'3d'     => array(
			'title' => _x( '3D', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/buttons-style-3d.gif',
		),
		'shadow' => array(
			'title' => _x( 'Shadow', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/buttons-style-shadow.gif',
		),
	),
);

$options[] = array(
	'name' => _x( 'Top Bar & Header', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'top-bar-header',
);

$options[] = array( 'name' => _x( 'Header layout', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options[] = array(
	'desc' => sprintf( _x( 'You can set up micro widgets layout and content <a href="%s">here</a>.', 'theme-options', 'the7mk2' ), admin_url( 'admin.php?page=of-header-menu&tab=microwidgets-tab' ) ),
	'type' => 'info',
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
		'classic' => array( 'header-layout-classic-settings' ),
		'inline'  => array( 'header-layout-inline-settings' ),
		'split'   => array( 'header-layout-split-settings' ),
		'side'    => array( 'header-layout-side-settings' ),
	),
);

$options[] = array( 'type' => 'divider' );

/**
 * Classic layout.
 */
$options[] = array( 'type' => 'js_hide_begin', 'class' => 'header-layout header-layout-classic-settings' );

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

$options[] = array( 'type' => 'divider' );

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

$options[] = array( 'type' => 'js_hide_end' );

/**
 * Inline header.
 */
$options[] = array( 'type' => 'js_hide_begin', 'class' => 'header-layout header-layout-inline-settings' );

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

$options[] = array( 'type' => 'js_hide_end' );

/**
 * Split header.
 */
$options[] = array( 'type' => 'js_hide_begin', 'class' => 'header-layout header-layout-split-settings' );

$options[] = array(
	'desc' => sprintf( _x( 'To display split menu You should <a href="%1$s">create</a> two separate custom menus and <a href="%2$s">assign</a> them to "Split Menu Left" and "Split Menu Right" locations.', 'theme-options', 'the7mk2' ), admin_url( 'nav-menus.php' ), admin_url( 'nav-menus.php?action=locations' ) ),
	'type' => 'info',
);

$options['header-split-menu-position'] = array(
	'id'      => 'header-split-menu-position',
	'name'    => _x( 'Menu position', 'theme-options', 'the7mk2' ),
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

$options[] = array( 'type' => 'js_hide_end' );

/**
 * Side header.
 */
$options[] = array( 'type' => 'js_hide_begin', 'class' => 'header-layout header-layout-side-settings' );

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

$options[] = array( 'type' => 'js_hide_end' );

$options['header_navigation'] = array(
	'id'         => 'header_navigation',
	'name'       => _x( 'Navigation', 'theme-options', 'the7mk2' ),
	'type'       => 'images',
	'std'        => 'slide_out',
	'options'    => array(
		'slide_out' => array(
			'title' => _x( 'Side', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/slide-out-header.gif',
		),
		'overlay'   => array(
			'title' => _x( 'Overlay', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/overlay-header.gif',
		),
	),
	'class'      => 'small',
	'dependency' => array(
		array(
			array(
				'field'    => 'header-layout',
				'operator' => '==',
				'value'    => 'top_line',
			),
		),
		array(
			array(
				'field'    => 'header-layout',
				'operator' => '==',
				'value'    => 'side_line',
			),
		),
		array(
			array(
				'field'    => 'header-layout',
				'operator' => '==',
				'value'    => 'menu_icon',
			),
		),
	),
);

$options[] = array( 'name' => _x( 'Header', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['header-bg-color'] = array(
	'id'   => 'header-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#000000',
);

$options['header-menu-font-color'] = array(
	'id'   => 'header-menu-font-color',
	'name' => _x( 'Menu font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#ffffff',
);

$options['header-menu-submenu-bg-color'] = array(
	'id'         => 'header-menu-submenu-bg-color',
	'name'       => _x( 'Submenu background color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => 'rgba(255,255,255,0.3)',
	'dependency' => array(
		array(
			array(
				'field'    => 'header-layout',
				'operator' => '==',
				'value'    => 'classic',
			),
		),
		array(
			array(
				'field'    => 'header-layout',
				'operator' => '==',
				'value'    => 'inline',
			),
		),
		array(
			array(
				'field'    => 'header-layout',
				'operator' => '==',
				'value'    => 'split',
			),
		),
	),
);

$options['header-menu-submenu-font-color'] = array(
	'id'   => 'header-menu-submenu-font-color',
	'name' => _x( 'Submenu font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#ffffff',
);

$options[] = array(
	'name'  => _x( 'Top bar', 'theme-options', 'the7mk2' ),
	'class' => 'header-top_bar-block',
	'type'  => 'block',
);

$options['top_bar-font-color'] = array(
	'id'   => 'top_bar-font-color',
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#686868',
);

$options['top_bar-bg-color'] = array(
	'id'      => 'top_bar-bg-color',
	'name'    => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type'    => 'alpha_color',
	'std'     => '#ffffff',
	'divider' => 'top',
);


$options[] = array(
	'name'  => _x( 'Floating navigation', 'theme-options', 'the7mk2' ),
	'class' => 'header-floating-nav-block',
	'type'  => 'block',
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

$options[] = array( 'type' => 'divider' );

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

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'name' => _x( 'Mobile header', 'theme-options', 'the7mk2' ), 'type' => 'block' );

presscore_options_apply_template( $options, 'mobile-header', 'header-mobile-second_switch', array(
	'after'  => array( 'name' => _x( 'Switch after', 'theme-options', 'the7mk2' ) ),
	'height' => false,
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
		'divider' => false,
	),
) );

$options[] = array( 'name' => _x( 'Branding', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'branding' );

$options[] = array( 'name' => _x( 'Main', 'theme-options', 'the7mk2' ), 'type' => 'block' );

presscore_options_apply_template( $options, 'logo', 'header' );

$options[] = array( 'name' => _x( 'Transparent header', 'theme-options', 'the7mk2' ), 'type' => 'block' );

presscore_options_apply_template( $options, 'logo', 'header-style-transparent' );

$options[] = array(
	'name'  => _x( 'Menu icon / top line / side line', 'theme-options', 'the7mk2' ),
	'class' => 'branding-menu-icon-block',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'logo', 'header-style-mixed' );

$options[] = array(
	'name'  => _x( 'Floating navigation', 'theme-options', 'the7mk2' ),
	'class' => 'branding-floating-nav-block',
	'type'  => 'block',
);

presscore_options_apply_template( $options, 'logo', 'header-style-floating' );

$options[] = array( 'name' => _x( 'Mobile', 'theme-options', 'the7mk2' ), 'type' => 'block' );

presscore_options_apply_template( $options, 'logo', 'header-style-mobile' );

$options[] = array( 'name' => _x( 'Bottom bar', 'theme-options', 'the7mk2' ), 'type' => 'block' );

presscore_options_apply_template( $options, 'logo', 'bottom_bar' );

$options[] = array( 'name' => _x( 'Favicon', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-favicon'] = array(
	'id'   => 'general-favicon',
	'name' => _x( 'Regular (16x16 px)', 'theme-options', 'the7mk2' ),
	'type' => 'upload',
	'std'  => '',
);

$options['general-favicon_hd'] = array(
	'id'   => 'general-favicon_hd',
	'name' => _x( 'High-DPI (32x32 px)', 'theme-options', 'the7mk2' ),
	'type' => 'upload',
	'std'  => '',
);

$options[] = array( 'name' => _x( 'Copyright information', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['bottom_bar-copyrights'] = array(
	'id'       => 'bottom_bar-copyrights',
	'name'     => _x( 'Copyright information', 'theme-options', 'the7mk2' ),
	'type'     => 'textarea',
	'std'      => false,
	'sanitize' => 'without_sanitize',
);

$options['bottom_bar-credits'] = array(
	'id'   => 'bottom_bar-credits',
	'name' => _x( 'Give credits to Dream-Theme', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => '1',
);

$options[] = array(
	'name' => _x( 'Sidebar & Footer', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'sidebar-footer',
);

$options[] = array( 'name' => _x( 'Sidebar', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['sidebar-visual_style'] = array(
	'name'    => _x( 'Style', 'theme-options', 'the7mk2' ),
	'id'      => 'sidebar-visual_style',
	'std'     => 'with_dividers',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
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
);

$options[] = array( 'name' => _x( 'Footer', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['footer-bg_color'] = array(
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'id'   => 'footer-bg_color',
	'std'  => '#1B1B1B',
	'type' => 'alpha_color',
);

$options['footer-headers_color'] = array(
	'name' => _x( 'Headings color', 'theme-options', 'the7mk2' ),
	'id'   => 'footer-headers_color',
	'std'  => '#ffffff',
	'type' => 'color',
);

$options['footer-primary_text_color'] = array(
	'name' => _x( 'Content color', 'theme-options', 'the7mk2' ),
	'id'   => 'footer-primary_text_color',
	'std'  => '#828282',
	'type' => 'color',
);

$options['footer-layout'] = array(
	'name' => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'desc' => _x( "E.g. '1/4+1/4+1/2'", 'theme-options', 'the7mk2' ),
	'id'   => 'footer-layout',
	'std'  => '1/3+1/3+1/3',
	'type' => 'text',
);

$options[] = array( 'name' => _x( 'Bottom bar', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['bottom_bar-bg_color'] = array(
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'id'   => 'bottom_bar-bg_color',
	'std'  => '#ffffff',
	'type' => 'alpha_color',
);

$options['bottom_bar-color'] = array(
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'   => 'bottom_bar-color',
	'std'  => '#757575',
	'type' => 'color',
);