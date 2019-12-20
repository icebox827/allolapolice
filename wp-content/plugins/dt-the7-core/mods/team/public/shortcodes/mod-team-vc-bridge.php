<?php
// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"weight" => -1,
	"name" => __("Team (old)", 'dt-the7-core'),
	"base" => 'dt_team',
	"icon" => "dt_vc_ico_team",
	"class" => "dt_vc_sc_team",
	"category" => __('The7 Old', 'dt-the7-core'),
	"params" => array(
		// General group.
		array(
			"heading" => __("Categories", 'dt-the7-core'),
			"param_name" => "category",
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_team_category",
			"admin_label" => true,
			"description" => __("Note: By default, all your team will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'dt-the7-core')
		),
		array(
			"heading" => __( "Photos Number & Order", 'dt-the7-core' ),
			"param_name" => "dt_title",
			"type" => "dt_title",
		),
		array(
			"heading" => __("Number of team members to show", 'dt-the7-core'),
			"param_name" => "number",
			"type" => "textfield",
			"value" => "12",
			"description" => __("(Integer)", 'dt-the7-core'),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading'          => __( 'Order by', 'dt-the7-core' ),
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
			'description'      => __( 'Select how to sort retrieved posts.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			"heading" => __("Order way", 'dt-the7-core'),
			"param_name" => "order",
			"type" => "dropdown",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.", 'dt-the7-core'),
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
		// Appearance group.
		array(
			"heading" => __("Appearance", 'dt-the7-core'),
			"param_name" => "type",
			"type" => "dropdown",
			"value" => array(
				"Masonry" => "masonry",
				"Grid" => "grid"
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Gap between team members (px)", 'dt-the7-core'),
			"param_name" => "padding",
			"type" => "textfield",
			"value" => "20",
			"description" => __("Team member paddings (e.g. 5 pixel padding will give you 10 pixel gaps between team members)", 'dt-the7-core'),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		array(
			"heading" => __( "Team Mender Design", 'dt-the7-core' ),
			"param_name" => "dt_title",
			"type" => "dt_title",
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Background under team members", 'dt-the7-core'),
			"param_name" => "members_bg",
			"type" => "dropdown",
			"value" => array(
				"Enabled" => "true",
				"disabled" => "false",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Images sizing", 'dt-the7-core'),
			"param_name" => "images_sizing",
			"type" => "dropdown",
			"value" => array(
				"preserve images proportions" => "original",
				"resize images" => "resize",
			),
			"group" => __( "Appearance", 'dt-the7-core' ),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"heading" => __("Images proportions", 'dt-the7-core'),
			"param_name" => "proportion",
			"type" => "textfield",
			"value" => "",
			"dependency" => array(
				"element" => "images_sizing",
				"value" => array( 'resize' ),
			),
			"description" => __("Width:height (e.g. 16:9). Leave this field empty to preserve original image proportions.", 'dt-the7-core'),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Enable rounded corners", 'dt-the7-core'),
			"param_name" => "round_images",
			"type" => "dt_switch",
			"value" => "n",
			"options" => array(
				"Yes" => "y",
				"No" => "n",
			),
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Show excerpts", 'dt-the7-core'),
			"param_name" => "show_excerpts",
			"type" => "dt_switch",
			"value" => "n",
			"options" => array(
				"Yes" => "y",
				"No" => "n",
			),
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		// Responsiveness group.
		array(
			"heading" => __("Responsiveness", 'dt-the7-core'),
			"param_name" => "responsiveness",
			"type" => "dropdown",
			"value" => array(
				"Post width based" => "post_width_based",
				"Browser width based" => "browser_width_based",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"group" => __("Responsiveness", 'dt-the7-core'),
		),
		array(
			"heading" => __("Column target width (px)", 'dt-the7-core'),
			"param_name" => "column_width",
			"type" => "textfield",
			"value" => "370",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"post_width_based",
				),
			),
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"group" => __("Responsiveness", 'dt-the7-core'),
		),
		array(
			"heading" => __("Desired columns number", 'dt-the7-core'),
			"param_name" => "columns",
			"type" => "textfield",
			"value" => "2",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"post_width_based",
				),
			),
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"group" => __("Responsiveness", 'dt-the7-core'),
		),
		array(
			"heading" => __("Columns on Desktop", 'dt-the7-core'),
			"param_name" => "columns_on_desk",
			"type" => "textfield",
			"value" => "3",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"group" => __("Responsiveness", 'dt-the7-core'),
		),
		array(
			"heading" => __("Columns on Horizontal Tablet", 'dt-the7-core'),
			"param_name" => "columns_on_htabs",
			"type" => "textfield",
			"value" => "3",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"group" => __("Responsiveness", 'dt-the7-core'),
		),
		array(
			"heading" => __("Columns on Vertical Tablet", 'dt-the7-core'),
			"param_name" => "columns_on_vtabs",
			"type" => "textfield",
			"value" => "3",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"group" => __("Responsiveness", 'dt-the7-core'),
		),
		array(
			"heading" => __("Columns on Mobile Phone", 'dt-the7-core'),
			"param_name" => "columns_on_mobile",
			"type" => "textfield",
			"value" => "3",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"browser_width_based",
				),
			),
			"edit_field_class" => "vc_col-sm-3 vc_column",
			"group" => __("Responsiveness", 'dt-the7-core'),
		),
	)
);

