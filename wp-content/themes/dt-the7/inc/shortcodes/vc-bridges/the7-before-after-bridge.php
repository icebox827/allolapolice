<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight"      => - 1,
	'name'        => __( 'Before / After', 'the7mk2' ),
	'base'        => 'dt_before_after',
	'class'       => 'dt_vc_sc_before_after',
	'icon'        => 'dt_vc_ico_before_after',
	'category'    => __( 'by Dream-Theme', 'the7mk2' ),
	'description' => "",
	'params'      => array(
		array(
			"type"       => "attach_image",
			"holder"     => "img",
			"class"      => "dt_image",
			"heading"    => __( "Choose first image", 'the7mk2' ),
			"param_name" => "image_1",
			"value"      => "",
		),
		array(
			"type"       => "attach_image",
			"holder"     => "img",
			"class"      => "dt_image",
			"heading"    => __( "Choose second image", 'the7mk2' ),
			"param_name" => "image_2",
			"value"      => "",
		),
		array(
			"type"       => "dropdown",
			"heading"    => __( "Orientation", 'the7mk2' ),
			"param_name" => "orientation",
			"value"      => array(
				"Vertical"   => "horizontal",
				"Horizontal" => "vertical",
			),
		),
		array(
			"type"       => "dropdown",
			"heading"    => __( "Navigation", 'the7mk2' ),
			"param_name" => "navigation",
			"value"      => array(
				"Click and drag" => "drag",
				"Follow"         => "move",
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => __( 'Visible part of the "Before" image (in %)', 'the7mk2' ),
			'param_name' => 'offset',
			'std'        => '50',
		),
	),
);

