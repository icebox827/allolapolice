<?php

defined( 'ABSPATH' ) || exit;

return array(
	"name"                    => __( "Icon" ),
	"base"                    => "dt_icon",
	"class"                   => "dt_vc_icon",
	"icon"                    => "dt_vc_icon",
	"category"                => __( 'by Dream-Theme', 'the7mk2'),
	"params"                  => array(
		array(
			"type"       => "vc_link",
			"class"      => "",
			"heading"    => __( "Icon link", 'the7mk2' ),
			"param_name" => "link",
			"value"      => "",
		),
		array(
			'heading'     => __( 'Enable smooth scroll for anchor navigation', 'the7mk2' ),
			'param_name'  => 'smooth_scroll',
			'type'        => 'dt_switch',
			'value'       => 'n',
			'options'     => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'description' => __( 'for #anchor navigation', 'the7mk2' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon alignment", 'the7mk2'),
			"param_name" => "icon_alignment",
			"value" => array(
				"Left" => "icon_left",
				"Center" => "icon_center",
				"Right" => "icon_right"
			),

			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"heading"    => __( "Icon", 'the7mk2' ),
			"param_name" => "dt_title",
			"type"       => "dt_title",
		),
		array(
			"heading"    => __( "Choose icon", "the7mk2" ),
			"param_name" => "dt_icon",
			"type"       => "dt_soc_icon_manager",
			"value"      => "Defaults-heart",
		),
		array(
			"heading"    => __( "Icon size", 'the7mk2' ),
			"param_name" => "dt_icon_size",
			"type"       => "dt_number",
			"value"      => "32px",
			"units"      => "px",
		),
		array(
			"heading"    => __( "Icon Background", 'the7mk2' ),
			"param_name" => "dt_title",
			"type"       => "dt_title",
		),
		array(
			"heading"    => __( "Background size", 'the7mk2' ),
			"param_name" => "dt_icon_bg_size",
			"type"       => "dt_number",
			"value"      => "64px",
			"units"      => "px",
		),
		array(
			"heading"    => __( "Border width", 'the7mk2' ),
			"param_name" => "dt_icon_border_width",
			"type"       => "dt_number",
			"value"      => "0",
			"units"      => "px",
		),
		array(
			'heading' => __('Border style', 'the7mk2'),
			'param_name' => 'icon_border_style',
			'type' => 'dropdown',
			'std' => 'solid',
			'value' => array(
				'Solid' => 'solid',
				'Dotted' => 'dotted',
				'Dashed' => 'dashed',
				'Double' => 'double'
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"heading"    => __( "Gap between border & background", 'the7mk2' ),
			"param_name" => "icon_border_gap",
			"type"       => "dt_number",
			"value"      => "0",
			"units"      => "px",
		),
		array(
			"heading"    => __( "Border radius", 'the7mk2' ),
			"param_name" => "dt_icon_border_radius",
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
			'param_name'  => 'dt_icon_color',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,1)',
		),
		array(
			'heading'    => __( 'Show icon border color', 'the7mk2' ),
			'param_name' => 'dt_icon_border',
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
			'param_name'  => 'dt_icon_border_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'dt_icon_border',
				'value'   => 'y',
			),
		),
		array(
			'heading'    => __( 'Show icon background', 'the7mk2' ),
			'param_name' => 'dt_icon_bg',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'     => __( 'Icon background color', 'the7mk2' ),
			'param_name'  => 'dt_icon_bg_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'dt_icon_bg',
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
			'heading'    => __( 'Enable hover', 'the7mk2' ),
			'param_name' => 'dt_icon_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'     => __( 'Icon color', 'the7mk2' ),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name'  => 'dt_icon_color_hover',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,0.75)',
			'dependency'  => array(
				'element' => 'dt_icon_hover',
				'value'   => 'y',
			),
		),
		array(
			'heading'    => __( 'Show icon border color', 'the7mk2' ),
			'param_name' => 'dt_icon_border_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency'  => array(
				'element' => 'dt_icon_hover',
				'value'   => 'y',
			),
		),
		array(
			'heading'     => __( 'Icon border color  ', 'the7mk2' ),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name'  => 'dt_icon_border_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'dt_icon_border_hover',
				'value'   => 'y',
			),
		),

		array(
			'heading'    => __( 'Show icon background', 'the7mk2' ),
			'param_name' => 'dt_icon_bg_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency'  => array(
				'element' => 'dt_icon_hover',
				'value'   => 'y',
			),
		),
		array(
			'heading'     => __( 'Icon background color', 'the7mk2' ),
			'param_name'  => 'dt_icon_bg_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'dt_icon_bg_hover',
				'value'   => 'y',
			),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
		),
		array(
			'heading' => __('Animation', 'the7mk2'),
			'param_name' => 'icon_animation',
			'type' => 'dropdown',
			'std' => 'none',
			'value' => array(
				'None' => 'none',
				'Slide up' => 'slide_up',
				'Slide right' => 'slide_right',
				'Spin around' => 'spin_around',
				'Shadow' => 'shadow',
				'Scale up' => 'scale',
				'Scale down' => 'scale_down'
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'  => array(
				'element' => 'dt_icon_hover',
				'value'   => 'y',
			),
		),
		array(
			'heading'		=> __( 'Extra class name', 'the7mk2' ),
			'description'	=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'the7mk2' ),
			'param_name'	=> 'el_class',
			'type'			=> 'textfield',
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

