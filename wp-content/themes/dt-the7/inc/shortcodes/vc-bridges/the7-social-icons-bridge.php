<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Social Icons", 'the7mk2'),
	"base" => "dt_soc_icons",
	"icon" => "dt_vc_soc_icons",
	"class" => "dt_vc_soc_icons",
	"category" => __('by Dream-Theme', 'the7mk2'),
	"as_parent" => array('only' => 'dt_single_soc_icon'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
	"content_element" => true,
	"show_settings_on_create" => true,
	"js_view" => 'VcColumnView',
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Alignment","the7mk2"),
			"param_name" => "icon_align",
			"value" => array(
				"Center" => "center",
				"Left" => "left",
				"Right" => "right"
			),
		),
		array(
			"heading" => __("Gap between icons", 'the7mk2'),
			"param_name" => "soc_icon_gap_between",
			"type" => "dt_number",
			"value" => "4",
			"units" => "px",
		),
		array(
			'heading'		=> __( 'Extra class name', 'the7mk2' ),
			'description'	=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'the7mk2' ),
			'param_name'	=> 'el_class',
			'type'			=> 'textfield',
		),
		array(
			'type' => 'css_editor',
            'heading' => __( 'CSS box', 'the7mk2' ),
            'param_name' => 'css',
            'group' => __( 'Design ', 'the7mk2' ),
            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border',
		),
	)
);
