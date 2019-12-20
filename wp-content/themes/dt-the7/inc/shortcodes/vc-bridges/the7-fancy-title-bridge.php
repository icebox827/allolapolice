<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => "Fancy Titles",
	"base" => "dt_fancy_title",
	"icon" => "dt_vc_ico_fancy_titles",
	"class" => "dt_vc_sc_fancy_titles",
	"category" => __('by Dream-Theme', 'the7mk2'),
	"description" => '',
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => "Title",
			"param_name" => "title",
			"holder" => "div",
			"value" => "Title",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => "Title position",
			"param_name" => "title_align",
			"value" => array(
				'centre' => "center",
				'left' => "left",
				'right' => "right"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => "Title size",
			"param_name" => "title_size",
			"value" => array(
				'small' => "small",
				'medium' => "normal",
				'large' => "big",
				'h1' => "h1",
				'h2' => "h2",
				'h3' => "h3",
				'h4' => "h4",
				'h5' => "h5",
				'h6' => "h6",
			),
			"std" => "normal",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => "Title color",
			"param_name" => "title_color",
			"value" => array(
				"semitransparent" => "default",
				"accent" => "accent",
				"title" => "title",
				"custom" => "custom"
			),
			"std" => "default",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"heading" => "Custom title color",
			"param_name" => "custom_title_color",
			"dependency" => array(
				"element" => "title_color",
				"value" => array( "custom" )
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => "Separator style",
			"param_name" => "separator_style",
			"value" => array(
				"line" => "",
				"dashed" => "dashed",
				"dotted" => "dotted",
				"double" => "double",
				"thick" => "thick",
				"disabled" => "disabled"
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => "Element width (in %)",
			"param_name" => "el_width",
			"value" => "100",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => "Background under title",
			"param_name" => "title_bg",
			"value" => array(
				"enabled" => "enabled",
				"disabled" => "disabled"
			),
			"std" => "disabled",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => "Separator & background color",
			"param_name" => "separator_color",
			"value" => array(
				"default" => "default",
				"accent" => "accent",
				"custom" => "custom"
			),
			"std" => "default",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"heading" => "Custom separator color",
			"param_name" => "custom_separator_color",
			"dependency" => array(
				"element" => "separator_color",
				"value" => array( "custom" )
			),
			"description" => ""
		),
	)
);

