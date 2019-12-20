<?php
/**
 * Gallery masonry/grid.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'weight'            => -1,
	'name'              => __( 'Media Gallery Masonry and Grid', 'the7mk2' ),
	'description'       => __( 'Images from Media Library', 'the7mk2' ),
	'base'              => 'dt_gallery_masonry',
	'class'             => 'dt_vc_sc_gallery_masonry',
	'icon'              => 'dt_vc_ico_media_gallery',
	'category'          => __( 'by Dream-Theme', 'the7mk2' ),
	'params'            => array(
		// General group.
		array(
			'type'        => 'attach_images',
			'heading'     => __( 'Images', 'the7mk2' ),
			'param_name'  => 'include',
			'description' => __( 'Select images from media library.', 'the7mk2' ),
		),
		// - Layout Settings.
		array(
			'heading'    => __( 'Layout, Columns & Responsiveness', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'          => __( 'Mode', 'the7mk2' ),
			'param_name'       => 'mode',
			'type'             => 'dropdown',
			'value'            => array(
				'Masonry' => 'masonry',
				'Grid'    => 'grid',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// - Columns & Responsiveness.
		array(
			'heading'          => __( 'Responsiveness mode', 'the7mk2' ),
			'param_name'       => 'responsiveness',
			'type'             => 'dropdown',
			'value'            => array(
				'Browser width based' => 'browser_width_based',
				'Post width based'    => 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Browser width based.
		array(
			'heading'    => __( 'Number of columns', 'the7mk2' ),
			'param_name' => 'bwb_columns',
			'type'       => 'dt_responsive_columns',
			'value'      => 'desktop:6|h_tablet:4|v_tablet:3|phone:2',
			'dependency' => array(
				'element' => 'responsiveness',
				'value'   => 'browser_width_based',
			),
		),
		// -- Post width based.
		array(
			'heading'          => __( 'Column minimum width', 'the7mk2' ),
			'param_name'       => 'pwb_column_min_width',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'responsiveness',
				'value'   => 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Desired columns number', 'the7mk2' ),
			'param_name'       => 'pwb_columns',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => '',
			'max'              => 12,
			'description'      => __( 'Affects only masonry layout', 'the7mk2' ),
			'dependency'       => array( 'element' => 'responsiveness', 'value' => 'post_width_based' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Gap between columns', 'the7mk2' ),
			'param_name'       => 'gap_between_posts',
			'type'             => 'dt_number',
			'value'            => '5px',
			'units'            => 'px',
			'description'      => __( 'Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Loading effect', 'the7mk2' ),
			'param_name'       => 'loading_effect',
			'type'             => 'dropdown',
			'value'            => array(
				'None'             => 'none',
				'Fade in'          => 'fade_in',
				'Move up'          => 'move_up',
				'Scale up'         => 'scale_up',
				'Fall perspective' => 'fall_perspective',
				'Fly'              => 'fly',
				'Flip'             => 'flip',
				'Helix'            => 'helix',
				'Scale'            => 'scale',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),


		// - Image Settings.
		array(
			'heading'    => __( 'Image Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'          => __( 'Image sizing', 'the7mk2' ),
			'param_name'       => 'image_sizing',
			'type'             => 'dropdown',
			'std'              => 'proportional',
			'value'            => array(
				'Preserve images proportions' => 'proportional',
				'Resize images'               => 'resize',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'headings'    => array( __( 'Width', 'the7mk2' ), __( 'Height', 'the7mk2' ) ),
			'param_name'  => 'resized_image_dimensions',
			'type'        => 'dt_dimensions',
			'value'       => '1x1',
			'dependency'  => array(
				'element' => 'image_sizing',
				'value'   => 'resize',
			),
			'description' => __( 'Set image proportions, for example: 4x3, 3x2.', 'the7mk2' ),
		),
		array(
			'heading'          => __( 'Image border radius', 'the7mk2' ),
			'param_name'       => 'image_border_radius',
			'type'             => 'dt_number',
			'value'            => '0',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"type" => "dropdown",
			"heading" => __("Image decoration", 'the7mk2'),
			"param_name" => "image_decoration",
			"value" => array(
				"None" => "none",
				"Shadow" => "shadow",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading' => __('Horizontal length', 'the7mk2'),
			'param_name' => 'shadow_h_length',
			'type' => 'dt_number',
			'value' => '0px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading' => __('Vertical length', 'the7mk2'),
			'param_name' => 'shadow_v_length',
			'type' => 'dt_number',
			'value' => '4px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading' => __('Blur radius', 'the7mk2'),
			'param_name' => 'shadow_blur_radius',
			'type' => 'dt_number',
			'value' => '12px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading' => __('Spread', 'the7mk2'),
			'param_name' => 'shadow_spread',
			'type' => 'dt_number',
			'value' => '3px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			"heading"		=> __("Shadow color", 'the7mk2'),
			"type"			=> "colorpicker",
			"param_name"	=> "shadow_color",
			"value"			=> 'rgba(0,0,0,.25)',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading'          => __( 'Scale animation on hover', 'the7mk2' ),
			'param_name'       => 'image_scale_animation_on_hover',
			'type'             => 'dropdown',
			'std'              => 'quick_scale',
			'value'            => array(
				'Disabled'    => 'disabled',
				'Quick scale' => 'quick_scale',
				'Slow scale'  => 'slow_scale',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),

		array(
			'heading'          => __( 'Hover background color', 'the7mk2' ),
			'param_name'       => 'image_hover_bg_color',
			'type'             => 'dropdown',
			'std'              => 'default',
			'value'            => array(
				'Disabled'    => 'disabled',
				'Default'    => 'default',
				'Mono color' => 'solid_rollover_bg',
				'Gradient'    => 'gradient_rollover_bg',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),

		array(
			'heading'     => __( 'Background color', 'the7mk2' ),
			'param_name'  => 'custom_rollover_bg_color',
			'type'        => 'colorpicker',
			'value'       => 'rgba(0,0,0,0.5)',
			'dependency'  => array(
				'element' => 'image_hover_bg_color',
				'value'   => 'solid_rollover_bg',
			),
		),
		array(
			'heading'    => __( 'Gradient', 'the7mk2' ),
			'param_name' => 'custom_rollover_bg_gradient',
			'type'       => 'dt_gradient_picker',
			'value'      => '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
			'dependency' => array(
				'element' => 'image_hover_bg_color',
				'value'   => 'gradient_rollover_bg',
			),
		),

		array(
			'heading'          => __( 'Hover background animation', 'dt-the7-core' ),
			'param_name'       => 'hover_animation',
			'type'             => 'dropdown',
			'value'            => array(
				'Fade'                    => 'fade',
				'Direction aware'         => 'direction_aware',
				'Reverse direction aware' => 'redirection_aware',
				'Scale in'                => 'scale_in',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'image_hover_bg_color',
				'value'   => 'gradient_overlay',
				'value'   => array( 'solid_rollover_bg', 'gradient_rollover_bg' ),
			),
		),

		array(
			'heading'    => __( 'Open in popup on click', 'the7mk2' ),
			'param_name' => 'on_click',
			'type'       => 'dt_switch',
			'value'      => 'popup',
			'options'    => array(
				'Yes' => 'popup',
				'No'  => 'none',
			),
		),

		//Icons

		array(
			'group'      => __( 'Hover Icon', 'the7mk2' ),
			'heading'    => __( 'Show icon on image hover', 'the7mk2' ),
			'param_name' => 'show_zoom',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Hover Icon', 'the7mk2' ),
			'heading'    => __( 'Choose image zoom icon', 'the7mk2' ),
			'param_name' => 'gallery_image_zoom_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icomoon-the7-font-the7-zoom-06',
			'dependency' => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Icon Size & Background', 'the7mk2' ),
			'param_name'       => 'dt_project_icon_title',
			'type'             => 'dt_title',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Icon size', 'the7mk2' ),
			'param_name'       => 'project_icon_size',
			'type'             => 'dt_number',
			'value'            => '32px',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Icon color', 'the7mk2' ),
			'description'      => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'       => 'project_icon_color',
			'type'             => 'colorpicker',
			'value'            => 'rgba(255,255,255,1)',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),

		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Background size', 'the7mk2' ),
			'param_name'       => 'project_icon_bg_size',
			'type'             => 'dt_number',
			'value'            => '44px',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Paint background', 'the7mk2' ),
			'param_name'       => 'project_icon_bg',
			'type'             => 'dt_switch',
			'value'            => 'n',
			'options'          => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Background color', 'the7mk2' ),
			'param_name'       => 'project_icon_bg_color',
			'type'             => 'colorpicker',
			'value'            => 'rgba(255,255,255,0.3)',
			'dependency'       => array(
				'element' => 'project_icon_bg',
				'value'   => 'y',
			),
			'description'      => __( 'Live empty to use accent color.', 'the7mk2' ),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Border radius', 'the7mk2' ),
			'param_name'       => 'project_icon_border_radius',
			'type'             => 'dt_number',
			'value'            => '100px',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Border width', 'the7mk2' ),
			'param_name'       => 'project_icon_border_width',
			'type'             => 'dt_number',
			'value'            => '0',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Border color', 'the7mk2' ),
			'description'      => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'       => 'project_icon_border_color',
			'type'             => 'colorpicker',
			'value'            => '',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		// - Pagination group.
		array(
			'heading'    => __( 'Pagination', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'heading'          => __( 'Pagination mode', 'the7mk2' ),
			'param_name'       => 'loading_mode',
			'type'             => 'dropdown',
			'std'              => 'disabled',
			'value'            => array(
				'Disabled'           => 'disabled',
				'JavaScript pages'   => 'js_pagination',
				'"Load more" button' => 'js_more',
				'Infinite scroll'    => 'js_lazy_loading',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Pagination', 'the7mk2' ),
		),
		// -- JavaScript pages.
		array(
			'heading'          => __( 'Number of images to display on one page', 'the7mk2' ),
			'param_name'       => 'jsp_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'the7mk2' ),
			'group'            => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'heading'    => __( 'Show all pages in paginator', 'the7mk2' ),
			'param_name' => 'jsp_show_all_pages',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'group'      => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'heading'     => __( 'Gap before pagination', 'the7mk2' ),
			'param_name'  => 'jsp_gap_before_pagination',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'dependency'  => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'description' => __( 'Leave empty to use default gap', 'the7mk2' ),
			'group'       => __( 'Pagination', 'the7mk2' ),
		),
		// -- js Load more.
		array(
			'heading'          => __( 'Number of images to display on one page', 'the7mk2' ),
			'param_name'       => 'jsm_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_more',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'the7mk2' ),
			'group'            => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'heading'     => __( 'Gap before pagination', 'the7mk2' ),
			'param_name'  => 'jsm_gap_before_pagination',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'dependency'  => array(
				'element' => 'loading_mode',
				'value'   => 'js_more',
			),
			'description' => __( 'Leave empty to use default gap', 'the7mk2' ),
			'group'       => __( 'Pagination', 'the7mk2' ),
		),
		// -- js Infinite scroll.
		array(
			'heading'          => __( 'Number of images to display on one page', 'the7mk2' ),
			'param_name'       => 'jsl_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_lazy_loading',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'the7mk2' ),
			'group'            => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'heading'    => __( 'Color Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'group'      => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'heading'     => __( 'Font color', 'the7mk2' ),
			'param_name'  => 'navigation_font_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( 'Leave empty to use headings color.', 'the7mk2' ),
			'group'       => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'heading'     => __( 'Accent color', 'the7mk2' ),
			'param_name'  => 'navigation_accent_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( 'Leave empty to use accent color.', 'the7mk2' ),
			'group'       => __( 'Pagination', 'the7mk2' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'CSS box', 'the7mk2' ),
			'param_name' => 'css_dt_gallery',
			'group'      => __( 'Design Options', 'the7mk2' ),
		),
	),
);
