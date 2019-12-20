<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Blog Masonry and Grid (old)", 'the7mk2'),
	"base" => "dt_blog_posts",
	"icon" => "dt_vc_ico_blog_posts",
	"class" => "dt_vc_sc_blog_posts",
	"category" => __('The7 Old', 'the7mk2'),
	"params" => array(
		// General group.
		array(
			"heading" => __("Categories", 'the7mk2'),
			"param_name" => "category",
			"type" => "dt_taxonomy",
			"taxonomy" => "category",
			"admin_label" => true,
			"description" => __("Note: By default, all your posts will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'the7mk2')
		),
		array(
			"heading" => __( "Posts Number & Order", 'the7mk2' ),
			"param_name" => "dt_title",
			"type" => "dt_title",
		),
		array(
			"heading" => __("Number of posts to show", 'the7mk2'),
			"param_name" => "number",
			"type" => "textfield",
			"value" => "12",
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"heading" => __("Posts per page", 'the7mk2'),
			"param_name" => "posts_per_page",
			"type" => "textfield",
			"value" => "-1",
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"heading" => __("Order by", 'the7mk2'),
			"param_name" => "orderby",
			"type" => "dropdown",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id",
				"Random" => "rand",
			),
			"description" => __("Select how to sort retrieved posts.", 'the7mk2'),
		    "edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"heading" => __("Order way", 'the7mk2'),
			"param_name" => "order",
			"type" => "dropdown",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc",
			),
			"description" => __("Designates the ascending or descending order.", 'the7mk2'),
		    "edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"heading" => __( "Posts Filter", 'the7mk2' ),
			"param_name" => "dt_title",
			"type" => "dt_title",
		),
		array(
			"param_name" => "show_filter",
			"type" => "checkbox",
			"value" => array(
				"Show categories filter" => "true",
			),
		),
		array(
			"param_name" => "show_orderby",
			"type" => "checkbox",
			"value" => array(
				"Show name / date ordering" => "true",
			),
		),
		array(
			"param_name" => "show_order",
			"type" => "checkbox",
			"value" => array(
				"Show asc. / desc. ordering" => "true",
			),
		),
		// Appearance group.
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Appearance", 'the7mk2'),
			"param_name" => "type",
			"type" => "dropdown",
			"value" => array(
				"Masonry" => "masonry",
				"Grid" => "grid",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Loading effect", 'the7mk2'),
			"param_name" => "loading_effect",
			"type" => "dropdown",
			"value" => array(
				'None' => 'none',
				'Fade in' => 'fade_in',
				'Move up' => 'move_up',
				'Scale up' => 'scale_up',
				'Fall perspective' => 'fall_perspective',
				'Fly' => 'fly',
				'Flip' => 'flip',
				'Helix' => 'helix',
				'Scale' => 'scale'
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Posts width", 'the7mk2'),
			"param_name" => "same_width",
			"type" => "dropdown",
			"value" => array(
				"Preserve original width" => "false",
				"Make posts same width" => "true",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Gap between posts (px)", 'the7mk2'),
			"param_name" => "padding",
			"type" => "textfield",
			"value" => "20",
			"description" => __("Post paddings (e.g. 5 pixel padding will give you 10 pixel gaps between posts)", 'the7mk2'),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Image proportions", 'the7mk2'),
			"param_name" => "proportion",
			"type" => "textfield",
			"value" => "",
			"description" => __("Width:height (e.g. 16:9). Leave this field empty to preserve original image proportions.", 'the7mk2'),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __( "Post Design & Elements", 'the7mk2' ),
			"param_name" => "dt_title",
			"type" => "dt_title",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Image & background style", 'the7mk2'),
			"param_name" => "background",
			"type" => "dropdown",
			"value" => array(
				"No background" => "disabled",
				"Fullwidth image" => "fullwidth",
				"Image with paddings" => "with_paddings"
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"param_name" => "show_excerpts",
			"type" => "checkbox",
			"value" => array(
				"Show excerpts" => "true",
			),
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"param_name" => "show_read_more_button",
			"type" => "checkbox",
			"value" => array(
				'Show "Read more" buttons' => "true",
			),
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"param_name" => "fancy_date",
			"type" => "checkbox",
			"value" => array(
				"Fancy date" => "true",
			),
		),
		// Elements group.
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_post_categories",
			"type" => "checkbox",
			"value" => array(
				"Show post categories" => "true",
			),
		),
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_post_date",
			"type" => "checkbox",
			"value" => array(
				"Show post date" => "true",
			),
		),
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_post_author",
			"type" => "checkbox",
			"value" => array(
				"Show post author" => "true",
			),
		),
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_post_comments",
			"type" => "checkbox",
			"value" => array(
				"Show post comments" => "true",
			),
		),
		// Responsiveness group.
		array(
			"group" => __("Responsiveness", 'the7mk2'),
			"heading" => __("Responsiveness", 'the7mk2'),
			"param_name" => "responsiveness",
			"type" => "dropdown",
			"value" => array(
				"Post width based" => "post_width_based",
				"Browser width based" => "browser_width_based",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Responsiveness", 'the7mk2'),
			"heading" => __("Column minimum width (px)", 'the7mk2'),
			"param_name" => "column_width",
			"type" => "textfield",
			"value" => "370",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"post_width_based",
				),
			),
		),
		array(
			"group" => __("Responsiveness", 'the7mk2'),
			"heading" => __("Desired columns number", 'the7mk2'),
			"param_name" => "columns_number",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"post_width_based",
				),
			),
		),
		array(
			"group" => __("Responsiveness", 'the7mk2'),
			"heading" => __("Columns on Desktop", 'the7mk2'),
			"param_name" => "columns_on_desk",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
		),
		array(
			"group" => __("Responsiveness", 'the7mk2'),
			"heading" => __("Columns on Horizontal Tablet", 'the7mk2'),
			"param_name" => "columns_on_htabs",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
		),
		array(
			"group" => __("Responsiveness", 'the7mk2'),
			"heading" => __("Columns on Vertical Tablet", 'the7mk2'),
			"param_name" => "columns_on_vtabs",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
		),
		array(
			"group" => __("Responsiveness", 'the7mk2'),
			"heading" => __("Columns on Mobile Phone", 'the7mk2'),
			"param_name" => "columns_on_mobile",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
		),
	)
);

