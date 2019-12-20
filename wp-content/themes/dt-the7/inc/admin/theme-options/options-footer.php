<?php
/**
 * Footer.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options[] = array( 'name' => _x( 'Footer', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'footer' );

$options[] = array( 'name' => _x( 'Footer style', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['footer-style'] = array(
	'name'    => _x( 'Footer background &amp; lines', 'theme-options', 'the7mk2' ),
	'id'      => 'footer-style',
	'std'     => 'content_width_line',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'content_width_line' => array(
			'title' => _x( 'Content-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/footer-style-content-width-line.gif',
		),
		'full_width_line'    => array(
			'title' => _x( 'Full-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/footer-style-full-width-line.gif',
		),
		'solid_background'   => array(
			'title' => _x( 'Background', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/footer-style-background.gif',
		),
	),
);

$options[] = array( 'type' => 'divider' );

$options['footer-bg_color'] = array(
	'name' => _x( 'Color', 'theme-options', 'the7mk2' ),
	'id'   => 'footer-bg_color',
	'std'  => '#1B1B1B',
	'type' => 'alpha_color',
);

$options['footer-decoration'] = array(
	'name'       => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'id'         => 'footer-decoration',
	'std'        => 'none',
	'type'       => 'images',
	'class'      => 'small',
	'divider'    => 'top',
	'options'    => array(
		'none'    => array(
			'title' => _x( 'None', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/footer-style-background.gif',
		),
		'outline' => array(
			'title' => _x( 'Line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/footer-decoration-line.gif',
		),
	),
	'dependency' => array(
		'field'    => 'footer-style',
		'operator' => '==',
		'value'    => 'solid_background',
	),
);

$options['footer-decoration_outline_color'] = array(
	'name'       => _x( 'Decoration outline color', 'theme-options', 'the7mk2' ),
	'id'         => 'footer-decoration_outline_color',
	'std'        => '#FFFFFF',
	'type'       => 'alpha_color',
	'dependency' => array(
		array(
			'field'    => 'footer-style',
			'operator' => '==',
			'value'    => 'solid_background',
		),
		array(
			'field'    => 'footer-decoration',
			'operator' => '==',
			'value'    => 'outline',
		),
	),
);

$options['footer-bg_image'] = array(
	'type'       => 'background_img',
	'name'       => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'id'         => 'footer-bg_image',
	'divider'    => 'top',
	'std'        => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
	'dependency' => array(
		'field'    => 'footer-style',
		'operator' => '==',
		'value'    => 'solid_background',
	),
);

$options['footer-slide-out-mode'] = array(
	'name'       => _x( 'Slide-out mode', 'theme-options', 'the7mk2' ),
	'desc'       => _x( '"Slide-out mode" isn\'t compatible with transparent/semitransparent content area background.', 'theme-options', 'the7mk2' ),
	'id'         => 'footer-slide-out-mode',
	'std'        => '0',
	'type'       => 'images',
	'class'      => 'small',
	'divider'    => 'top',
	'options'    => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/footer-slide-out-mode-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/footer-slide-out-mode-disabled.gif',
		),
	),
	'dependency' => array(
		'field'    => 'footer-style',
		'operator' => '==',
		'value'    => 'solid_background',
	),
);

$options[] = array( 'name' => _x( 'Footer font color', 'theme-options', 'the7mk2' ), 'type' => 'block' );

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

$options['footer-accent_text_color'] = array(
	'name'     => _x( 'Accent color', 'theme-options', 'the7mk2' ),
	'id'       => 'footer-accent_text_color',
	'std'      => '',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use default accent color.', 'theme-options', 'the7mk2' ),
);

$options[] = array( 'name' => _x( 'Footer layout', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['footer-padding'] = array(
	'name'   => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'id'     => 'footer-padding',
	'type'   => 'spacing',
	'std'    => '50px 50px',
	'units'  => 'px',
	'fields' => array(
		_x( 'Top', 'theme-options', 'the7mk2' ),
		_x( 'Bottom', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'divider' );

$options['footer-paddings-columns'] = array(
	'desc'  => _x( 'E.g. 20 pixel padding will give you 40 pixel gap between columns.', 'theme-options', 'the7mk2' ),
	'name'  => _x( 'Padding between footer columns', 'theme-options', 'the7mk2' ),
	'id'    => 'footer-paddings-columns',
	'std'   => '44px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'type' => 'divider' );

$options['footer-layout'] = array(
	'name' => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'desc' => _x( 'E.g. "1/4+1/4+1/2"', 'theme-options', 'the7mk2' ),
	'id'   => 'footer-layout',
	'std'  => '1/4+1/4+1/4+1/4',
	'type' => 'text',
);

$options[] = array( 'type' => 'divider' );

$options['footer-collapse_after'] = array(
	'name'  => _x( 'Collapse to one column after', 'theme-options', 'the7mk2' ),
	'desc'  => _x( "Won't have any effect if responsiveness is disabled.", 'theme-options', 'the7mk2' ),
	'id'    => 'footer-collapse_after',
	'std'   => '760px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array(
	'name' => _x( 'Bottom bar', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'bottom-bar',
);

$options[] = array( 'name' => _x( 'Bottom bar style', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['bottom_bar-enabled'] = array(
	'name'    => _x( 'Bottom bar', 'theme-options', 'the7mk2' ),
	'id'      => 'bottom_bar-enabled',
	'type'    => 'radio',
	'std'     => '1',
	'options' => array(
		'1' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
		'0' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'divider' );

$options['bottom_bar-style'] = array(
	'name'    => _x( 'Bottom bar background &amp; lines', 'theme-options', 'the7mk2' ),
	'id'      => 'bottom_bar-style',
	'std'     => 'content_width_line',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'content_width_line' => array(
			'title' => _x( 'Content-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/bottom_bar-style-content-width-line.gif',
		),
		'full_width_line'    => array(
			'title' => _x( 'Full-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/bottom_bar-style-full-width-line.gif',
		),
		'solid_background'   => array(
			'title' => _x( 'Background', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/bottom_bar-style-background.gif',
		),
	),
);

$options[] = array( 'type' => 'divider' );

$options['bottom_bar-bg_color'] = array(
	'name' => _x( 'Color', 'theme-options', 'the7mk2' ),
	'id'   => 'bottom_bar-bg_color',
	'std'  => '#ffffff',
	'type' => 'alpha_color',
);

$options['bottom_bar-bg_image'] = array(
	'type'       => 'background_img',
	'id'         => 'bottom_bar-bg_image',
	'name'       => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'divider'    => 'top',
	'std'        => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
	'dependency' => array(
		'field'    => 'bottom_bar-style',
		'operator' => '==',
		'value'    => 'solid_background',
	),
);

$options[] = array( 'name' => _x( 'Bottom bar layout', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['bottom_bar-layout'] = array(
	'name'    => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'id'      => 'bottom_bar-layout',
	'std'     => 'logo_left',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'logo_left'   => array(
			'title' => _x( 'Side', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/bb02.gif',
		),
		'split'       => array(
			'title' => _x( 'Split', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/bbsplit.gif',
		),
		'logo_center' => array(
			'title' => _x( 'Centered', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/bb01.gif',
		),
	),
);

$options[] = array( 'type' => 'divider' );

$options['bottom_bar-height'] = array(
	'id'    => 'bottom_bar-height',
	'name'  => _x( 'Height', 'theme-options', 'the7mk2' ),
	'std'   => '60px',
	'type'  => 'number',
	'units' => 'px',
);

$options['bottom_bar-padding'] = array(
	'name'   => _x( 'Paddings', 'theme-options', 'the7mk2' ),
	'id'     => 'bottom_bar-padding',
	'type'   => 'spacing',
	'std'    => '10 10',
	'units'  => 'px',
	'fields' => array(
		_x( 'Top', 'theme-options', 'the7mk2' ),
		_x( 'Bottom', 'theme-options', 'the7mk2' ),
	),
);

$options['bottom_bar-collapse_after'] = array(
	'name'    => _x( 'Enable bottom bar responsive layout after', 'theme-options', 'the7mk2' ),
	'id'      => 'bottom_bar-collapse_after',
	'std'     => '990px',
	'type'    => 'number',
	'units'   => 'px',
	'divider' => 'top',
);
$options['bottom_bar-menu-collapse_after'] = array(
	'name'    => _x( 'Enable custom menu responsive layout after', 'theme-options', 'the7mk2' ),
	'id'      => 'bottom_bar-menu-collapse_after',
	'std'     => '778px',
	'type'    => 'number',
	'units'   => 'px',
	'divider' => 'top',
);

$options[] = array( 'name' => _x( 'Bottom bar font color', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['bottom_bar-color'] = array(
	'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'   => 'bottom_bar-color',
	'std'  => '#757575',
	'type' => 'color',
);

$options[] = array( 'name' => _x( 'Text area', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['bottom_bar-text'] = array(
	'name'     => _x( 'Text area', 'theme-options', 'the7mk2' ),
	'id'       => 'bottom_bar-text',
	'std'      => false,
	'type'     => 'textarea',
	'sanitize' => 'without_sanitize',
);
