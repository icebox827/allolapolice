<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => "Fancy Separators",
	"base" => "dt_fancy_separator",
	"icon" => "dt_vc_ico_separators",
	"class" => "dt_vc_sc_separators",
	"category" => __('by Dream-Theme', 'the7mk2'),
	"description" => '',
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => "Separator style",
			"param_name" => "separator_style",
			"value" => array(
				"solid line" => "line",
				"dashed" => "dashed",
				"dotted" => "dotted",
				"double" => "double",
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => "Separator color",
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
		array(
			"type" => "dropdown",
			"heading" => "Alignment",
			"param_name" => "alignment",
			"value" => array(
				'center' => 'center',
				'left' => 'left',
				'right' => 'right',
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => "Thickness (in px)",
			"param_name" => "line_thickness",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => "Element width (in % or px)",
			"param_name" => "el_width",
			"value" => "100%",
			"description" => ""
		),
	)
);

