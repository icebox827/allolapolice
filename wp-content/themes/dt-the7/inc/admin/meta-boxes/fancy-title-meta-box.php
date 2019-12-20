<?php
defined( 'ABSPATH' ) || exit;

global $DT_META_BOXES;

$prefix = '_dt_fancy_header_';

$DT_META_BOXES['dt_page_box-fancy_header_options'] = array(
	'id'       => 'dt_page_box-fancy_header_options',
	'title'    => _x( 'Fancy Title Options', 'backend metabox', 'the7mk2' ),
	'pages'    => presscore_get_pages_with_basic_meta_boxes(),
	'context'  => 'normal',
	'priority' => 'high',
	'only_on'  => array(
		'meta_value' => array(
			'_dt_header_title' => 'fancy',
		),
	),
	'fields'   => array(
		array(
			'name' => _x( 'Layout', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}layout_heading",
			'type' => 'heading',
		),
		array(
			'name'    => _x( 'Fancy title layout', 'backend metabox', 'the7mk2' ),
			'id'      => "{$prefix}title_aligment",
			'type'    => 'radio',
			'std'     => 'center',
			'options' => array(
				'left'      => array(
					_x( 'Left title + right breadcrumbs', 'backend metabox', 'the7mk2' ),
					array( 'l-r-page.gif', 75, 50 ),
				),
				'right'     => array(
					_x( 'Right title + left breadcrumbs', 'backend metabox', 'the7mk2' ),
					array( 'r-l-page.gif', 75, 50 ),
				),
				'all_left'  => array(
					_x( 'Left title + left breadcrumbs', 'backend metabox', 'the7mk2' ),
					array( 'l-l-page.gif', 75, 50 ),
				),
				'all_right' => array(
					_x( 'Right title + right breadcrumbs', 'backend metabox', 'the7mk2' ),
					array( 'r-r-page.gif', 75, 50 ),
				),
				'center'    => array(
					_x( 'Centred title + centred breadcrumbs', 'backend metabox', 'the7mk2' ),
					array( 'centre-page.gif', 75, 50 ),
				),
			),
		),
		array(
			'name'        => _x( 'Minimum height (px)', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}height",
			'type'        => 'text',
			'std'         => '300',
			'top_divider' => true,
		),
		array(
			'id'       => "{$prefix}padding-top",
			'name'     => _x( 'Top padding (px or %)', 'backend metabox', 'the7mk2' ),
			'type'     => 'text',
			'std'      => '0px',
			'class'    => 'mini',
			'sanitize' => 'css_width',
		),
		array(
			'id'       => "{$prefix}padding-bottom",
			'name'     => _x( 'Bottom padding (px or %)', 'backend metabox', 'the7mk2' ),
			'type'     => 'text',
			'std'      => '0px',
			'class'    => 'mini',
			'sanitize' => 'css_width',
		),
		array(
			'name'        => _x( 'Breadcrumbs', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}breadcrumbs_heading",
			'type'        => 'heading',
			'top_divider' => true,
		),
		array(
			'name'        => _x( 'Breadcrumbs', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}breadcrumbs",
			'type'        => 'radio',
			'std'         => 'enabled',
			'hide_fields' => array( 'disabled' => array( "{$prefix}breadcrumbs_settings" ) ),
			'options'     => array(
				'enabled'  => _x( 'Enabled', 'backend metabox', 'the7mk2' ),
				'disabled' => _x( 'Disabled', 'backend metabox', 'the7mk2' ),
			),
		),
		array(
			// container begin !!!
			'before' => '<div class="the7-mb-flickering-field ' . "the7-mb-input-{$prefix}breadcrumbs_settings" . '">',

			'name' => _x( 'Breadcrumbs text color', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}breadcrumbs_text_color",
			'type' => 'color',
			'std'  => '#ffffff',
		),
		array(
			'name'    => _x( 'Breadcrumbs background color', 'backend metabox', 'the7mk2' ),
			'id'      => "{$prefix}breadcrumbs_bg_color",
			'type'    => 'radio',
			'std'     => 'disabled',
			'options' => array(
				'disabled' => _x( 'Disabled', 'backend metabox', 'the7mk2' ),
				'black'    => _x( 'Black', 'backend metabox', 'the7mk2' ),
				'white'    => _x( 'White', 'backend metabox', 'the7mk2' ),
			),

			// container end
			'after'   => '</div>',
		),
		array(
			'name'        => _x( 'Title', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}title_heading",
			'type'        => 'heading',
			'top_divider' => true,
		),
		array(
			'name'        => _x( 'Title', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}title_mode",
			'type'        => 'radio',
			'std'         => 'custom',
			'hide_fields' => array( 'generic' => array( "{$prefix}title" ) ),
			'options'     => array(
				'generic' => _x( 'Page title', 'backend metabox', 'the7mk2' ),
				'custom'  => _x( 'Custom title', 'backend metabox', 'the7mk2' ),
			),
		),
		array(
			'name' => _x( 'Custom title', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}title",
			'type' => 'text',
			'std'  => '',
		),
		array(
			'name'     => _x( 'Font size', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}title_font_size",
			'std'      => '30',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 120 ),
			'sanitize' => 'font_size',

		),
		array(
			'name'     => _x( 'Line height', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}title_line_height",
			'std'      => '36',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 140 ),
			'sanitize' => 'font_size',

		),
		array(
			'name' => _x( 'Text transformation', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}text_transform",
			'type' => 'select',
			'std'  => 'none',
			'options' => array(
				'none'       => 'None',
				'uppercase'  => 'Uppercase',
				'lowercase'  => 'Lowercase',
				'capitalize' => 'Capitalize',
			),
		),
		array(
			'name'        => _x( 'Font color', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}title_color_mode",
			'type'        => 'radio',
			'std'         => 'color',
			'hide_fields' => array( 'accent' => array( "{$prefix}title_color_settings" ) ),
			'options'     => $accent_custom_color,
		),
		array(
			// container begin !!!
			'before' => '<div class="the7-mb-flickering-field ' . "the7-mb-input-{$prefix}title_color_settings" . '">',

			'name'  => '&nbsp;',
			'id'    => "{$prefix}title_color",
			'type'  => 'color',
			'std'   => '#ffffff',

			// container end
			'after' => '</div>',
		),
		array(
			'name'        => _x( 'Subtitle', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}subtitle_heading",
			'type'        => 'heading',
			'top_divider' => true,
		),
		array(
			'name' => _x( 'Subtitle', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}subtitle",
			'type' => 'text',
			'std'  => '',
		),
		array(
			'name'     => _x( 'Font size', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}subtitle_font_size",
			'std'      => '18',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 120 ),
			'sanitize' => 'font_size',
		),
		array(
			'name'     => _x( 'Line height', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}subtitle_line_height",
			'std'      => '26',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 140 ),
			'sanitize' => 'font_size',
		),
		array(
			'name' => _x( 'Text transformation', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}subtitle_text_transform",
			'type' => 'select',
			'std'  => 'none',
			'options' => array(
				'none'       => 'None',
				'uppercase'  => 'Uppercase',
				'lowercase'  => 'Lowercase',
				'capitalize' => 'Capitalize',
			),
		),
		array(
			'name'        => _x( 'Subtitle font color', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}subtitle_color_mode",
			'type'        => 'radio',
			'std'         => 'color',
			'hide_fields' => array( 'accent' => array( "{$prefix}subtitle_color_settings" ) ),
			'options'     => $accent_custom_color,
		),
		array(
			// container begin !!!
			'before' => '<div class="the7-mb-flickering-field ' . "the7-mb-input-{$prefix}subtitle_color_settings" . '">',

			'name'  => '&nbsp;',
			'id'    => "{$prefix}subtitle_color",
			'type'  => 'color',
			'std'   => '#ffffff',

			// container end
			'after' => '</div>',
		),
		array(
			'name'        => _x( 'Background', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}bg_heading",
			'type'        => 'heading',
			'top_divider' => true,
		),
		array(
			'name' => _x( 'Background color', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}bg_color",
			'type' => 'color',
			'std'  => '#222222',
		),
		array(
			'name'             => _x( 'Background image', 'backend metabox', 'the7mk2' ),
			'id'               => "{$prefix}bg_image",
			'type'             => 'image_advanced_mk2',
			'max_file_uploads' => 1,
		),
		array(
			'name'    => _x( 'Repeat options', 'backend metabox', 'the7mk2' ),
			'id'      => "{$prefix}bg_repeat",
			'type'    => 'select',
			'options' => $repeat_options,
			'std'     => 'no-repeat',
		),
		array(
			'name'    => _x( 'Position x', 'backend metabox', 'the7mk2' ),
			'id'      => "{$prefix}bg_position_x",
			'type'    => 'select',
			'options' => $position_x_options,
			'std'     => 'center',
		),
		array(
			'name'    => _x( 'Position y', 'backend metabox', 'the7mk2' ),
			'id'      => "{$prefix}bg_position_y",
			'type'    => 'select',
			'options' => $position_y_options,
			'std'     => 'center',
		),
		array(
			'name' => _x( 'Fullscreen', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}bg_fullscreen",
			'type' => 'checkbox',
			'std'  => 1,
		),
		array(
			'name'        => _x( 'Enable color overlay ', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}bg_overlay",
			'type'        => 'checkbox',
			'std'         => 0,
			'hide_fields' => array( "{$prefix}bg_overlay_opacity", "{$prefix}overlay_color" ),
		),
		array(
			'name' => _x( 'Overlay color', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}overlay_color",
			'type' => 'color',
			'std'  => '#000',
		),
		array(
			'name' => _x( 'Overlay opacity', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}bg_overlay_opacity",
			'type' => 'slider',
			'std'  => 50,
		),
		array(
			'name'        => _x( 'Scroll effect', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}scroll_effect",
			'type'        => 'radio',
			'std'         => 'default',
			'options'     => array(
				'default'  => _x( 'Move with the content', 'backend metabox', 'the7mk2' ),
				'fixed'    => _x( "Fixed at it's position", 'backend metabox', 'the7mk2' ),
				'parallax' => _x( 'Vertical parallax on scroll', 'backend metabox', 'the7mk2' ),
			),
			'hide_fields' => array(
				'default' => array( "{$prefix}bg_parallax" ),
				'fixed'   => array( "{$prefix}bg_parallax" ),
			),
		),
		array(
			'id'    => "{$prefix}bg_parallax",
			'name'  => _x( 'Parallax speed', 'backend metabox', 'the7mk2' ),
			'desc'  => _x( 'Enter value between 0 to 1', 'backend metabox', 'the7mk2' ),
			'type'  => 'text',
			'std'   => '0.5',
			'class' => 'mini',
		),
		array(
			'name'        => _x( 'RESPONSIVENESS', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}responsiveness_heading",
			'type'        => 'heading',
			'top_divider' => true,
		),
		array(
			'name'        => _x( 'Responsiveness', 'backend metabox', 'the7mk2' ),
			'id'          => "{$prefix}responsiveness",
			'type'        => 'radio',
			'std'         => 'enabled',
			'hide_fields' => array( 'disabled' => array( "{$prefix}responsiveness_settings" ) ),
			'options'     => array(
				'enabled'  => _x( 'Enabled', 'backend metabox', 'the7mk2' ),
				'disabled' => _x( 'Disabled', 'backend metabox', 'the7mk2' ),
			),
		),
		array(
			'before'   => '<div class="the7-mb-flickering-field ' . "the7-mb-input-{$prefix}responsiveness_settings" . '">',
			'name'     => _x( 'Switch to responsive layout after', 'theme-options', 'the7mk2' ),
			'id'       => "{$prefix}responsiveness_switch",
			'type'     => 'text',
			'std'      => '778px',
			'class'    => 'mini',
			'sanitize' => 'css_width',
		),
		array(
			'name' => _x( 'Responsive title area minimum height (px)', 'backend metabox', 'the7mk2' ),
			'id'   => "{$prefix}responsive_height",
			'type' => 'text',
			'std'  => '70',
		),
		array(
			'name'     => _x( 'Responsive title font size', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}responsive_font_size",
			'std'      => '30',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 120 ),
			'sanitize' => 'font_size',
		),
		array(
			'name'     => _x( 'Responsive title line height', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}responsive_title_line_height",
			'std'      => '38',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 140 ),
			'sanitize' => 'font_size',
		),
		array(
			'name'     => _x( 'Responsive subtitle font size', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}responsive_subtitle_font_size",
			'std'      => '20',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 120 ),
			'sanitize' => 'font_size',
		),
		array(
			'name'     => _x( 'Responsive subtitle line height', 'backend metabox', 'the7mk2' ),
			'id'       => "{$prefix}responsive_subtitle_line_height",
			'std'      => '28',
			'type'     => 'slider',
			'options'  => array( 'min' => 1, 'max' => 140 ),
			'sanitize' => 'font_size',
		),
		array(
			'name'    => _x( 'Breadcrumbs', 'backend metabox', 'the7mk2' ),
			'id'      => "{$prefix}responsive_breadcrumbs",
			'type'    => 'radio',
			'std'     => 'disabled',
			'options' => array(
				'enabled'  => _x( 'Enabled', 'backend metabox', 'the7mk2' ),
				'disabled' => _x( 'Disabled', 'backend metabox', 'the7mk2' ),
			),

			// container end
			'after'   => '</div>',
		),
	),
);
