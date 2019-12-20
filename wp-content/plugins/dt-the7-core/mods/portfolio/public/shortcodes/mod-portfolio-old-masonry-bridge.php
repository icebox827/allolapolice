<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Portfolio.
 */

include dirname( __FILE__ ) . '/mod-portfolio-bridge-common-parts.php';

return array(
	"weight"	=> -1,
	"base"		=> "dt_portfolio",
	"name"		=> __( "Portfolio Masonry and Grid (old)", 'dt-the7-core' ),
	"category"  => __('The7 Old', 'dt-the7-core'),
	"icon"		=> "dt_vc_ico_portfolio",
	"class"		=> "dt_vc_sc_portfolio",
	"params"	=> array(
		// General group.
		$category,
		$number_order_title,
		$number,
		$posts_per_page,
		$orderby,
		$order,
		$filter_title,
		$show_filter,
		$show_orderby,
		$show_order,
		// Appearance group.
		array(
			"group"         => __( "Appearance", 'dt-the7-core' ),
			"heading"		=> __( "Appearance", 'dt-the7-core' ),
			"param_name"	=> "type",
			"type"			=> "dropdown",
			"value"			=> array(
				"Masonry"		=> "masonry",
				"Grid"			=> "grid",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		$loading_effect,
		array(
			"group" => __( "Appearance", 'dt-the7-core' ),
			"heading"		=> __( "Projects width", 'dt-the7-core' ),
			"param_name"	=> "same_width",
			"type"			=> "dropdown",
			"value"			=> array(
				"Preserve original width"	=> "false",
				"Make projects same width"	=> "true",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array_merge( $padding, array(
			"description"	=> __( "Image paddings (e.g. 5 pixel padding will give you 10 pixel gaps between images)", 'dt-the7-core' ),
		) ),
		$proportion,
		$design_title,
		$descriptions,
		array_merge( $bg_under_projects, array(
			"dependency"	=> array(
				"element"	=> "descriptions",
				"value"		=> array( 'under_image' ),
			),
		) ),
		array_merge( $hover_animation, array(
			"dependency"	=> array(
				"element"		=> "descriptions",
				"value"			=> array( 'on_hover_centered' ),
			),
		) ),
		array_merge( $hover_bg_color, array(
			"dependency"	=> array(
				"element"		=> "descriptions",
				"value"			=> array(
					'on_hover_centered',
					'under_image',
					'bg_with_lines',
				),
			),
		) ),
		array_merge( $bgwl_animation_effect, array(
			"dependency"	=> array(
				"element"		=> "descriptions",
				"value"			=> array( 'bg_with_lines' ),
			),
		) ),
		array_merge( $hover_content_visibility, array(
			"dependency"	=> array(
				"element"		=> "descriptions",
				"value"			=> array(
					'on_dark_gradient',
					'bg_with_lines',
				),
			),
		) ),
		array_merge( $colored_bg_content_aligment, array(
			"dependency"	=> array(
				"element"		=> "descriptions",
				"value"			=> array( 'on_hover_centered' ),
			),
		) ),
		array_merge( $content_aligment, array(
			"dependency"	=> array(
				"element"		=> "descriptions",
				"value"			=> array(
					'under_image',
					'on_dark_gradient',
					'from_bottom',
				),
			),
		) ),
		$elements_title,
		$show_title,
		$show_link,
		$show_excerpt,
		$show_zoom,
		$show_details,
		// Project Meta group.
		$show_categories,
		$show_date,
		$show_author,
		$show_comments,
		// Responsiveness group.
		array(
			"heading" => __("Responsiveness", 'dt-the7-core'),
			"param_name" => "responsiveness",
			"type" => "dropdown",
			"value" => array(
				"Post width based" => "post_width_based",
				"Browser width based" => "browser_width_based",
			),
			"group" => __( "Responsiveness", 'dt-the7-core' ),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"heading"		=> __( "Column minimum width (px)", 'dt-the7-core' ),
			"param_name"	=> "column_width",
			"type"			=> "textfield",
			"value"			=> "370",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"post_width_based",
				),
			),
			"group" => __( "Responsiveness", 'dt-the7-core' ),
		),
		array(
			"heading"		=> __( "Desired columns number", 'dt-the7-core' ),
			"param_name"	=> "columns",
			"type"			=> "textfield",
			"value"			=> "2",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"dependency" => array(
				"element" => "responsiveness",
				"value" => array(
					"post_width_based",
				),
			),
			"group" => __( "Responsiveness", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Columns on Desktop", 'dt-the7-core'),
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
			"group" => __( "Responsiveness", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Columns on Horizontal Tablet", 'dt-the7-core'),
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
			"group" => __( "Responsiveness", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Columns on Vertical Tablet", 'dt-the7-core'),
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
			"group" => __( "Responsiveness", 'dt-the7-core' ),
		),
		array(
			"heading" => __("Columns on Mobile Phone", 'dt-the7-core'),
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
			"group" => __( "Responsiveness", 'dt-the7-core' ),
		),
	)
);
