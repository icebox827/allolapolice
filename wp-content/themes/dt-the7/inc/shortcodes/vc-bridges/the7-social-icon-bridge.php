<?php

defined( 'ABSPATH' ) || exit;

return array(
	"name"                    => __( "Social Icon Item" ),
	"base"                    => "dt_single_soc_icon",
	"class"                   => "dt_vc_single_soc_icon",
	"icon"                    => "dt_vc_soc_icon",
	"category"                => __( 'by Dream-Theme', 'the7mk2' ),
	"description"             => __( "Add a set of multiple icons and give some custom style.", "the7mk2" ),
	"as_child"                => array( 'only' => 'dt_soc_icons' ),
	"show_settings_on_create" => true,
	"is_container"            => false,
	"params"                  => array(
		array(
			"type"       => "vc_link",
			"class"      => "",
			"heading"    => __( "Icon link", 'the7mk2' ),
			"param_name" => "link",
			"value"      => "",
		),
		array(
			"heading"    => __( "Social Icon", 'the7mk2' ),
			"param_name" => "dt_title",
			"type"       => "dt_title",
		),
		array(
			"heading"          => __( "Choose icon", "the7mk2" ),
			"param_name"       => "dt_soc_icon",
			"type"             => "dt_soc_icon_manager",
			"value"            => "icon-ar-017-r",
			"edit_field_class" => "dt-shortcode-soc-icons",
		),
		array(
			"heading"    => __( "Icon size", 'the7mk2' ),
			"param_name" => "soc_icon_size",
			"type"       => "dt_number",
			"value"      => "16px",
			"units"      => "px",
		),
		array(
			"heading"    => __( "Icon Background", 'the7mk2' ),
			"param_name" => "dt_title",
			"type"       => "dt_title",
		),
		array(
			"heading"    => __( "Background size", 'the7mk2' ),
			"param_name" => "soc_icon_bg_size",
			"type"       => "dt_number",
			"value"      => "26px",
			"units"      => "px",
		),
		array(
			"heading"    => __( "Border width", 'the7mk2' ),
			"param_name" => "soc_icon_border_width",
			"type"       => "dt_number",
			"value"      => "0",
			"units"      => "px",
		),
		array(
			"heading"    => __( "Border radius", 'the7mk2' ),
			"param_name" => "soc_icon_border_radius",
			"type"       => "dt_number",
			"value"      => "100px",
			"units"      => "px",
		),
		array(
			"heading"    => __( "Normal", 'the7mk2' ),
			"param_name" => "dt_title",
			"type"       => "dt_title",
		),
		array(
			'heading'     => __( 'Icon color', 'the7mk2' ),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name'  => 'soc_icon_color',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,1)',
		),
		array(
			'heading'    => __( 'Show icon border color', 'the7mk2' ),
			'param_name' => 'soc_icon_border',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'     => __( 'Icon border color  ', 'the7mk2' ),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name'  => 'soc_icon_border_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_border',
				'value'   => 'y',
			),
		),
		array(
			'heading'    => __( 'Show icon background', 'the7mk2' ),
			'param_name' => 'soc_icon_bg',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'     => __( 'Icon background color', 'the7mk2' ),
			'param_name'  => 'soc_icon_bg_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_bg',
				'value'   => 'y',
			),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
		),
		array(
			"heading"    => __( "Hover", 'the7mk2' ),
			"param_name" => "dt_title",
			"type"       => "dt_title",
		),
		array(
			'heading'     => __( 'Icon color', 'the7mk2' ),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name'  => 'soc_icon_color_hover',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,0.75)',
		),
		array(
			'heading'    => __( 'Show icon border color', 'the7mk2' ),
			'param_name' => 'soc_icon_border_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'     => __( 'Icon border color  ', 'the7mk2' ),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name'  => 'soc_icon_border_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_border_hover',
				'value'   => 'y',
			),
		),

		array(
			'heading'    => __( 'Show icon background', 'the7mk2' ),
			'param_name' => 'soc_icon_bg_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'     => __( 'Icon background color', 'the7mk2' ),
			'param_name'  => 'soc_icon_bg_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_bg_hover',
				'value'   => 'y',
			),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
		),
		array(
			'type'             => 'css_editor',
			'heading'          => __( 'CSS box', 'the7mk2' ),
			'param_name'       => 'css',
			'group'            => __( 'Design ', 'the7mk2' ),
			'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border',
		),
	),
);

