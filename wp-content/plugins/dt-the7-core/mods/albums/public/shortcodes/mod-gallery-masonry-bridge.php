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
	'name'              => __( 'Photos Masonry and Grid', 'dt-the7-core' ),
	'description'       => __( 'Images from Photo Albums post type', 'dt-the7-core' ),
	'base'              => 'dt_gallery_photos_masonry',
	'class'             => 'dt_vc_sc_gallery_masonry',
	'icon'              => 'dt_vc_ico_photos',
	'category'          => __( 'by Dream-Theme', 'dt-the7-core' ),
	'params'            => array(
		// General group.

		array(
			'heading' => __('Show', 'dt-the7-core'),
			'param_name' => 'post_type',
			'type' => 'dropdown',
			'std' => 'category',
			'value' => array(
				'Images from all albums' => 'posts',
				'Images from albums in categories' => 'category',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose albums', 'dt-the7-core' ),
			'param_name' => 'posts',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept album ID, title. Leave empty to show images from all albums.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'posts',
			),
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose albums categories', 'dt-the7-core' ),
			'param_name' => 'category',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept album category ID, title, slug. Leave empty to show images from all albums.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'category',
			),
		),
		array(
			'heading' => __('Order', 'dt-the7-core'),
			'param_name' => 'order',
			'type' => 'dropdown',
			'std' => 'desc',
			'value' => array(
				'Ascending' => 'asc',
				'Descending' => 'desc',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Order by', 'dt-the7-core' ),
			'param_name'       => 'orderby',
			'type'             => 'dropdown',
			'value'            => array(
				'Date'          => 'date',
				'Name'          => 'title',
				'ID'            => 'ID',
				'Modified'      => 'modified',
				'Comment count' => 'comment_count',
				'Menu order'    => 'menu_order',
				'Rand'          => 'rand',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Pagination', 'dt-the7-core' ),
		),
		// - Layout Settings.
		array(
			'heading'    => __( 'Layout, Columns & Responsiveness', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'          => __( 'Mode', 'dt-the7-core' ),
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
			'heading'          => __( 'Responsiveness mode', 'dt-the7-core' ),
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
			'heading'    => __( 'Number of columns', 'dt-the7-core' ),
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
			'heading'          => __( 'Column minimum width', 'dt-the7-core' ),
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
			'heading'          => __( 'Desired columns number', 'dt-the7-core' ),
			'param_name'       => 'pwb_columns',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => '',
			'max'              => 12,
			'description'      => __( 'Affects only masonry layout', 'dt-the7-core' ),
			'dependency'       => array( 'element' => 'responsiveness', 'value' => 'post_width_based' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Gap between columns', 'dt-the7-core' ),
			'param_name'       => 'gap_between_posts',
			'type'             => 'dt_number',
			'value'            => '5px',
			'units'            => 'px',
			'description'      => __( 'Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Loading effect', 'dt-the7-core' ),
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
			'heading'    => __( 'Image Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'          => __( 'Image sizing', 'dt-the7-core' ),
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
			'headings'    => array( __( 'Width', 'dt-the7-core' ), __( 'Height', 'dt-the7-core' ) ),
			'param_name'  => 'resized_image_dimensions',
			'type'        => 'dt_dimensions',
			'value'       => '1x1',
			'dependency'  => array(
				'element' => 'image_sizing',
				'value'   => 'resize',
			),
			'description' => __( 'Set image proportions, for example: 4x3, 3x2.', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Image border radius', 'dt-the7-core' ),
			'param_name'       => 'image_border_radius',
			'type'             => 'dt_number',
			'value'            => '0',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"type" => "dropdown",
			"heading" => __("Image decoration", 'dt-the7-core'),
			"param_name" => "image_decoration",
			"value" => array(
				"None" => "none",
				"Shadow" => "shadow",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading' => __('Horizontal length', 'dt-the7-core'),
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
			'heading' => __('Vertical length', 'dt-the7-core'),
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
			'heading' => __('Blur radius', 'dt-the7-core'),
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
			'heading' => __('Spread', 'dt-the7-core'),
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
			"heading"		=> __("Shadow color", 'dt-the7-core'),
			"type"			=> "colorpicker",
			"param_name"	=> "shadow_color",
			"value"			=> 'rgba(0,0,0,.25)',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading'          => __( 'Scale animation on hover', 'dt-the7-core' ),
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
			'heading'          => __( 'Hover background color', 'dt-the7-core' ),
			'param_name'       => 'image_hover_bg_color',
			'type'             => 'dropdown',
			'std'              => 'default',
			'value'            => array(
				'Disabled'    => 'disabled',
				'Default'     => 'default',
				'Mono color' => 'solid_rollover_bg',
				'Gradient'    => 'gradient_rollover_bg',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'     => __( 'Background color', 'dt-the7-core' ),
			'param_name'  => 'custom_rollover_bg_color',
			'type'        => 'colorpicker',
			'value'       => 'rgba(0,0,0,0.5)',
			'dependency'  => array(
				'element' => 'image_hover_bg_color',
				'value'   =>  'solid_rollover_bg',
			),
		),
		array(
			'heading'    => __( 'Gradient', 'dt-the7-core' ),
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
		//Icons

		array(
			'group'      => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'    => __( 'Show icon on image hover', 'dt-the7-core' ),
			'param_name' => 'show_zoom',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'    => __( 'Choose image zoom icon', 'dt-the7-core' ),
			'param_name' => 'gallery_image_zoom_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icomoon-the7-font-the7-zoom-06',
			'dependency' => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Icon Size & Background', 'dt-the7-core' ),
			'param_name'       => 'dt_project_icon_title',
			'type'             => 'dt_title',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Icon size', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Icon color', 'dt-the7-core' ),
			'description'      => __( 'Live empty to use accent color.', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Background size', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Paint background', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Background color', 'dt-the7-core' ),
			'param_name'       => 'project_icon_bg_color',
			'type'             => 'colorpicker',
			'value'            => 'rgba(255,255,255,0.3)',
			'dependency'       => array(
				'element' => 'project_icon_bg',
				'value'   => 'y',
			),
			'description'      => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Border radius', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Border width', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Border color', 'dt-the7-core' ),
			'description'      => __( 'Live empty to use accent color.', 'dt-the7-core' ),
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
			'heading'    => __( 'Pagination', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Pagination mode', 'dt-the7-core' ),
			'param_name'       => 'loading_mode',
			'type'             => 'dropdown',
			'std'              => 'disabled',
			'value'            => array(
				'Disabled'           => 'disabled',
				'Standard' => 'standard',
				'JavaScript pages'   => 'js_pagination',
				'"Load more" button' => 'js_more',
				'Infinite scroll'    => 'js_lazy_loading',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Pagination', 'dt-the7-core' ),
		),
		// -- Disabled.
		array(
			'heading' => __('Total number of images', 'dt-the7-core'),
			'param_name' => 'dis_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'disabled',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		// -- Standard.
		array(
			'heading' => __('Number of posts to display on one page', 'dt-the7-core'),
			'param_name' => 'st_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use number from wp settings.', 'dt-the7-core'),
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show all pages in paginator', 'dt-the7-core'),
			'param_name' => 'st_show_all_pages',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Gap before pagination', 'dt-the7-core'),
			'param_name' => 'st_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use default gap', 'dt-the7-core'),
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		// -- JavaScript pages.
		array(
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'jsp_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Number of images to display on one page', 'dt-the7-core' ),
			'param_name'       => 'jsp_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'dt-the7-core' ),
			'group'            => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Show all pages in paginator', 'dt-the7-core' ),
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
			'group'      => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Gap before pagination', 'dt-the7-core' ),
			'param_name'  => 'jsp_gap_before_pagination',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'dependency'  => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'description' => __( 'Leave empty to use default gap', 'dt-the7-core' ),
			'group'       => __( 'Pagination', 'dt-the7-core' ),
		),
		// -- js Load more.
		array(
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'jsm_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Number of images to display on one page', 'dt-the7-core' ),
			'param_name'       => 'jsm_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_more',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'dt-the7-core' ),
			'group'            => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Gap before pagination', 'dt-the7-core' ),
			'param_name'  => 'jsm_gap_before_pagination',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'dependency'  => array(
				'element' => 'loading_mode',
				'value'   => 'js_more',
			),
			'description' => __( 'Leave empty to use default gap', 'dt-the7-core' ),
			'group'       => __( 'Pagination', 'dt-the7-core' ),
		),
		// -- js Infinite scroll.
		array(
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'jsl_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Number of images to display on one page', 'dt-the7-core' ),
			'param_name'       => 'jsl_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_lazy_loading',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'dt-the7-core' ),
			'group'            => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Color Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'group'      => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Font color', 'dt-the7-core' ),
			'param_name'  => 'navigation_font_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( 'Leave empty to use headers color.', 'dt-the7-core' ),
			'group'       => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Accent color', 'dt-the7-core' ),
			'param_name'  => 'navigation_accent_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( 'Leave empty to use accent color.', 'dt-the7-core' ),
			'group'       => __( 'Pagination', 'dt-the7-core' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'CSS box', 'dt-the7-core' ),
			'param_name' => 'css_dt_gallery',
			'group'      => __( 'Design Options', 'dt-the7-core' ),
		),
	),
);
