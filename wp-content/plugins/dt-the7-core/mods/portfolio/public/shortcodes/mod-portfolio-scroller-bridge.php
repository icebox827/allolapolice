<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Portfolio Scroller.
 */

include dirname( __FILE__ ) . '/mod-portfolio-bridge-common-parts.php';

return array(
	"weight"	=> -1,
	"base"		=> "dt_portfolio_slider",
	"name"		=> __("Portfolio Scroller (old)", 'dt-the7-core'),
	"category" => __('The7 Old', 'dt-the7-core'),
	"icon"		=> "dt_vc_ico_portfolio_slider",
	"class"		=> "dt_vc_sc_portfolio_slider",
	"params"	=> array(
		// General group.
		$category,
		$number_order_title,
		array_merge( $number, array( "edit_field_class" => "vc_col-xs-12 vc_column dt_row-6", ) ),
		$orderby,
		$order,
		// Appearance group.
		array_merge( $padding, array( "edit_field_class" => "vc_col-xs-12 vc_column dt_row-6", ) ),
		array(
			"group" => __( "Appearance", 'dt-the7-core' ),
			"heading"		=> __("Thumbnails width", 'dt-the7-core'),
			"param_name"	=> "width",
			"type"			=> "textfield",
			"value"			=> "",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description"	=> __("In pixels. Leave this field empty if you want to preserve original thumbnails proportions.", 'dt-the7-core'),
		),
		array(
			"group" => __( "Appearance", 'dt-the7-core' ),
			"heading"		=> __("Thumbnails height", 'dt-the7-core'),
			"param_name"	=> "height",
			"type"			=> "textfield",
			"value"			=> "210",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description"	=> __("In pixels.", 'dt-the7-core'),
		),
		array(
			"group" => __( "Appearance", 'dt-the7-core' ),
			"heading"		=> __("Thumbnails max width", 'dt-the7-core'),
			"param_name"	=> "max_width",
			"type"			=> "textfield",
			"value"			=> "",
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"description"	=> __("In percents.", 'dt-the7-core'),
		),
		$design_title,
		array_merge( $descriptions, array( "param_name" => "appearance" ) ),
		array_merge( $bg_under_projects, array(
			"dependency"	=> array(
				"element"	=> "appearance",
				"value"		=> array( 'under_image' ),
			),
		) ),
		array_merge( $hover_animation, array(
			"dependency"	=> array(
				"element"		=> "appearance",
				"value"			=> array( 'on_hover_centered' ),
			),
		) ),
		array_merge( $hover_bg_color, array(
			"dependency"	=> array(
				"element"		=> "appearance",
				"value"			=> array(
					'on_hover_centered',
					'under_image',
					'bg_with_lines',
				),
			),
		) ),
		array_merge( $bgwl_animation_effect, array(
			"dependency"	=> array(
				"element"		=> "appearance",
				"value"			=> array( 'bg_with_lines' ),
			),
		) ),
		array_merge( $hover_content_visibility, array(
			"dependency"	=> array(
				"element"		=> "appearance",
				"value"			=> array(
					'on_dark_gradient',
					'bg_with_lines',
				),
			),
		) ),
		array_merge( $colored_bg_content_aligment, array(
			"dependency"	=> array(
				"element"		=> "appearance",
				"value"			=> array( 'on_hover_centered' ),
			),
		) ),
		array_merge( $content_aligment, array(
			"dependency"	=> array(
				"element"		=> "appearance",
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
		// Slideshow group.
		array(
			"group" => __( "Slideshow", 'dt-the7-core' ),
			"heading"		=> __("Arrows", 'dt-the7-core'),
			"param_name"	=> "arrows",
			"type"			=> "dropdown",
			"value"			=> array(
				'light'					=> 'light',
				'dark'					=> 'dark',
				'rectangular accent'	=> 'rectangular_accent',
				'disabled'				=> 'disabled',
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			"group" => __("Slideshow", 'dt-the7-core'),
			"heading" => __("Show arrows on mobile device", 'dt-the7-core'),
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
			"group" => __( "Slideshow", 'dt-the7-core' ),
			"heading"		=> __("Autoslide interval (in milliseconds)", 'dt-the7-core'),
			"param_name"	=> "autoslide",
			"type"			=> "textfield",
			"value"			=> "",
			"edit_field_class" => "vc_col-xs-6 vc_column",
		),
		array(
			"group" => __( "Slideshow", 'dt-the7-core' ),
			"heading" => '&nbsp;',
			"param_name"	=> "loop",
			"type"			=> "checkbox",
			"value"			=> array( "Loop" => "true" ),
			"edit_field_class" => "vc_col-xs-6 vc_column",
		),
	)
);
