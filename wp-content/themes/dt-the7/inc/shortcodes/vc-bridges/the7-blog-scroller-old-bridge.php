<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Blog Scroller (old)", 'the7mk2'),
	"base" => "dt_blog_scroller",
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
			"description" => __("Note: By default, all your posts will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'the7mk2'),
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
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
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
				"Random" => "rand"
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
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.", 'the7mk2'),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		// Appearance group.
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Gap between images (px)", 'the7mk2'),
			"param_name" => "padding",
			"type" => "textfield",
			"value" => "20",
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Thumbnails width", 'the7mk2'),
			"param_name" => "width",
			"type" => "textfield",
			"value" => "",
			"description" => __("In pixels. Leave this field empty if you want to preserve original thumbnails proportions.", 'the7mk2'),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Thumbnails height", 'the7mk2'),
			"param_name" => "height",
			"type" => "textfield",
			"value" => "210",
			"description" => __("In pixels.", 'the7mk2'),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Thumbnails max width", 'the7mk2'),
			"param_name" => "max_width",
			"type" => "textfield",
			"value" => "",
			"description" => __("In percents.", 'the7mk2'),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __( "Post Design & Elements", 'the7mk2' ),
			"param_name" => "dt_title",
			"type" => "dt_title",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Content alignment", 'the7mk2'),
			"param_name" => "content_aligment",
			"type" => "dropdown",
			"value" => array(
				'Left' => 'left',
				'Centre' => 'center'
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Image hover background color", 'the7mk2'),
			"param_name" => "hover_bg_color",
			"type" => "dropdown",
			"value" => array(
				'Color (from Theme Options)' => 'accent',
				'Dark' => 'dark'
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Background under projects", 'the7mk2'),
			"type" => "dropdown",
			"param_name" => "bg_under_posts",
			"value" => array(
				'Enabled (image with paddings)' => 'with_paddings',
				'Enabled (image without paddings)' => 'fullwidth',
				'Disabled' => 'disabled'
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"type" => "checkbox",
			"param_name" => "show_excerpt",
			"value" => array(
				"Show excerpt" => "true",
			),
		),
		// Elements group.
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_categories",
			"type" => "checkbox",
			"value" => array(
				"Show post categories" => "true",
			),
		),
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_date",
			"type" => "checkbox",
			"value" => array(
				"Show post date" => "true",
			),
		),
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_author",
			"type" => "checkbox",
			"value" => array(
				"Show post author" => "true",
			),
		),
		array(
			"group" => __("Post Meta", 'the7mk2'),
			"param_name" => "show_comments",
			"type" => "checkbox",
			"value" => array(
				"Show post comments" => "true",
			),
		),
	    // Slideshow group.
		array(
			"group" => __("Slideshow", 'the7mk2'),
			"heading" => __("Arrows", 'the7mk2'),
			"param_name" => "arrows",
			"type" => "dropdown",
			"value" => array(
				'light' => 'light',
				'dark' => 'dark',
				'rectangular accent' => 'rectangular_accent',
				'disabled' => 'disabled'
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Slideshow", 'the7mk2'),
			"heading" => __("Show arrows on mobile device", 'the7mk2'),
			"param_name" => "arrows_on_mobile",
			"type" => "dropdown",
			"value" => array(
				"Yes" => "on",
				"No" => "off",
			),
			"dependency" => array(
				"element" => "arrows",
				"value" => array(
					'light',
					'dark',
					'rectangular_accent',
				),
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Slideshow", 'the7mk2'),
			"heading" => __("Autoslide interval (in milliseconds)", 'the7mk2'),
			"param_name" => "autoslide",
			"type" => "textfield",
			"value" => "",
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"group" => __("Slideshow", 'the7mk2'),
			"heading" => '&nbsp;',
			"param_name" => "loop",
			"type" => "checkbox",
			"value" => array(
				"Loop" => "true",
			),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
	)
);

