<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Portfolio justified grid.
 */

include dirname( __FILE__ ) . '/mod-portfolio-bridge-common-parts.php';

return array(
	"weight"	=> -1,
	"base"		=> 'dt_portfolio_jgrid',
	"name"		=> __( "Portfolio Justified Grid", 'dt-the7-core' ),
	"category"	=> __( 'by Dream-Theme', 'dt-the7-core' ),
	"icon"		=> "dt_vc_ico_portfolio",
	"class"		=> "dt_vc_sc_portfolio",
	"params"	=> array(
		// General group.
		$category,
		$number_order_title,
		$number,
		$posts_per_page,
		array(
			'heading'          => __( 'Projects offset', 'dt-the7-core' ),
			'param_name'       => 'posts_offset',
			'type'             => 'dt_number',
			'value'            => 0,
			'min'              => 0,
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description'      => __( 'Offset for projects  query (i.e. 2 means, projects will be displayed starting from the third project).', 'dt-the7-core' ),
		),
		$orderby,
		$order,
		$filter_title,
		$show_filter,
		// Apppearace group.
		$loading_effect,
		array(
			"group" => __( "Appearance", 'dt-the7-core' ),
			"heading"		=> __( "Row target height (px)", 'dt-the7-core' ),
			"param_name"	=> "target_height",
			"type"			=> "textfield",
			"value"			=> "240",
			"edit_field_class" => "vc_col-xs-6 vc_column",
		),
		array(
			"group" => __( "Appearance", 'dt-the7-core' ),
			"heading"		=> '&nbsp;',
			"param_name" => "hide_last_row",
			"type" => "checkbox",
			"value" => array( "Hide last row if there's not enough images to fill it" => "true" ),
			"edit_field_class" => "vc_col-xs-6 vc_column",
		),
		$padding,
		$proportion,
		$design_title,
		array_merge( $descriptions, array( 'value' => array_diff( $descriptions['value'], array( 'under_image' ) ) ) ),
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
		// Project meta group.
		$show_categories,
		$show_date,
		$show_author,
		$show_comments,
	)
);
