<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Blog Mini", 'the7mk2'),
	"base" => "dt_blog_posts_small",
	"icon" => "dt_vc_ico_blog_posts_small",
	"class" => "dt_vc_sc_blog_posts_small",
	"category" => __('by Dream-Theme', 'the7mk2'),
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
			"value" => "6",
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading'          => __( 'Order by', 'the7mk2' ),
			'param_name'       => 'orderby',
			'type'             => 'dropdown',
			'std'              => 'date',
			'value'            => array(
				'Author'        => 'author',
				'Slug'          => 'name',
				'Date'          => 'date',
				'Name'          => 'title',
				'ID'            => 'ID',
				'Modified'      => 'modified',
				'Comment count' => 'comment_count',
				'Menu order'    => 'menu_order',
				'Rand'          => 'rand',
			),
			'description'      => __( 'Select how to sort retrieved posts.', 'the7mk2' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
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
			"heading" => __("Layout", 'the7mk2'),
			"param_name" => "columns",
			"type" => "dropdown",
			"value" => array(
				"List" => "1",
				"2 columns" => "2",
				"3 columns" => "3"
			),
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
			"heading" => __("Featured images", 'the7mk2'),
			"param_name" => "featured_images",
			"type" => "dropdown",
			"value" => array(
				"Show" => "true",
				"Hide" => "false"
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Images width", 'the7mk2'),
			"param_name" => "images_width",
			"type" => "textfield",
			"value" => "60",
			"description" => 'in px',
			"dependency" => array(
				"element" => "featured_images",
				"value" => array( "true" )
			),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"heading" => __("Images height", 'the7mk2'),
			"param_name" => "images_height",
			"type" => "textfield",
			"value" => "60",
			"description" => 'in px',
			"dependency" => array(
				"element" => "featured_images",
				"value" => array( "true" )
			),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"param_name" => "round_images",
			"type" => "checkbox",
			"value" => array(
				"Enable rounded corners" => "true",
			),
			"dependency" => array(
				"element" => "featured_images",
				"value" => array( "true" )
			),
		),
		array(
			"group" => __("Appearance", 'the7mk2'),
			"param_name" => "show_excerpts",
			"type" => "checkbox",
			"value" => array(
				"Show excerpts" => "true",
			),
		),
	)
);

