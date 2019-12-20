<?php

defined( 'ABSPATH' ) || exit;

return array(
	'base'			=> 'vc_pie',
	'name'			=> __( 'Pie Chart', 'the7mk2' ),
	'description'	=> __( 'Animated pie chart', 'the7mk2' ),
	'category'		=> __( 'Content', 'the7mk2' ),
	'icon'			=> 'icon-wpb-vc_pie',
	'params'		=> array(
		array(
			'heading'		=> __( 'Widget title', 'the7mk2' ),
			'description'	=> __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'the7mk2' ),
			'param_name'	=> 'title',
			'type'			=> 'textfield',
			'admin_label'	=> true,
		),
		array(
			'heading'		=> __( 'Pie value', 'the7mk2' ),
			'description'	=> __( 'Input graph value here. Choose range between 0 and 100.', 'the7mk2' ),
			'param_name'	=> 'value',
			'type'			=> 'textfield',
			'value'			=> '50',
			'admin_label'	=> true,
		),
		array(
			'heading'		=> __( 'Pie label value', 'the7mk2' ),
			'description'	=> __( 'Input integer value for label. If empty "Pie value" will be used.', 'the7mk2' ),
			'param_name'	=> 'label_value',
			'type'			=> 'textfield',
			'value'			=> '',
		),
		array(
			'heading'		=> __( 'Units', 'the7mk2' ),
			'description'	=> __( 'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', 'the7mk2' ),
			'param_name'	=> 'units',
			'type'			=> 'textfield',
		),
		array(
			"heading"		=> __( "Bar color", 'the7mk2' ),
			"description"	=> __( 'Select pie chart color.', 'the7mk2' ),
			"param_name"	=> "color_mode",
			"type"			=> "dropdown",
			"value"			=> array(
				"Title"					=> "title_like",
				"Light (50% content)"	=> "content_like",
				"Accent"				=> "accent",
				"Custom"				=> "custom"
			),
		),
		array(
			"heading"		=> __( "Custom bar color", 'the7mk2' ),
			"param_name"	=> "color",
			"type"			=> "colorpicker",
			"value"			=> '#f7f7f7',
			"dependency"	=> array(
				"element"		=> "color_mode",
				"value"			=> array( "custom" )
			)
		),
		array(
			'heading'		=> __( 'Extra class name', 'the7mk2' ),
			'description'	=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'the7mk2' ),
			'param_name'	=> 'el_class',
			'type'			=> 'textfield',
		),
		array(
			"heading"		=> __( "Appearance", 'the7mk2' ),
			"param_name"	=> "appearance",
			"type"			=> "dropdown",
			"value"			=> array(
				"Pie chart (default)"	=> "default",
				"Counter"				=> "counter"
			),
			"admin_label"	=> true,
		),
		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'the7mk2' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'the7mk2' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'the7mk2' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'the7mk2' )
		),
	)
);
