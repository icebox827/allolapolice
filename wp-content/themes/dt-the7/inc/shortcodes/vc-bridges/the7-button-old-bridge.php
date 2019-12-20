<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Button (old)", 'the7mk2'),
	"base" => "dt_button",
	"icon" => "dt_vc_ico_button",
	"class" => "dt_vc_sc_button",
	"category" => __('The7 Old', 'the7mk2'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", 'the7mk2'),
			"param_name" => "el_class",
			"value" => "",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'the7mk2')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Caption", 'the7mk2'),
			"admin_label" => true,
			"param_name" => "content",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link URL", 'the7mk2'),
			"param_name" => "link",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Open link in", 'the7mk2'),
			"param_name" => "target_blank",
			"value" => array(
				"Same window" => "false",
				"New window" => "true"
			)
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Smooth scroll?', 'the7mk2' ),
			'param_name' => 'smooth_scroll',
			'description' => __( 'for #anchor navigation', 'the7mk2' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button alignment", 'the7mk2'),
			"param_name" => "button_alignment",
			"value" => array(
				"Default" => "default",
				"Centre" => "center",
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Animation", 'the7mk2'),
			"param_name" => "animation",
			"value" => presscore_get_vc_animation_options()
		),
		array(
			"group" => __("Style", 'the7mk2'),
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Size", 'the7mk2'),
			"param_name" => "size",
			"value" => array(
				"Small" => "small",
				"Medium" => "medium",
				"Large" => "big"
			),
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __("Style", 'the7mk2'),
			"param_name"	=> "style",
			"value"			=> array(
				"Default (from Theme Options / Buttons)"	=> "default",
				"Link"										=> "link",
				"Light"										=> "light",
				"Light with background on hover"			=> "light_with_bg",
				"Outline"									=> "outline",
				"Outline with background on hover"			=> "outline_with_bg",
			)
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __("Background (border) color", 'the7mk2'),
			"param_name"	=> "bg_color_style",
			"value"			=> array(
				"Default (from Theme Options / Buttons)"	=> "default",
				"Accent"									=> "accent",
				"Custom"									=> "custom"
			),
			"dependency"	=> array(
				"element"	=> "style",
				"value"		=> array(
					'default',
					'outline',
					'outline_with_bg'
				)
			),
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "colorpicker",
			"class"			=> "",
			"heading"		=> __("Custom background color", 'the7mk2'),
			"param_name"	=> "bg_color",
			"value"			=> '#888888',
			"dependency"	=> array(
				"element"	=> "bg_color_style",
				"value"		=> array( "custom" )
			),
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __("Background (border) hover color", 'the7mk2'),
			"param_name"	=> "bg_hover_color_style",
			"value"			=> array(
				"Default (from Theme Options / Buttons)"	=> "default",
				"Accent"									=> "accent",
				"Custom"									=> "custom"
			),
			"dependency"	=> array(
				"element"	=> "style",
				"value"		=> array(
					'default',
					'light_with_bg',
					'outline',
					'outline_with_bg'
				)
			),
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "colorpicker",
			"class"			=> "",
			"heading"		=> __("Custom background hover color", 'the7mk2'),
			"param_name"	=> "bg_hover_color",
			"value"			=> '#888888',
			"dependency"	=> array(
				"element"	=> "bg_hover_color_style",
				"value"		=> array( "custom" )
			),
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __("Text color", 'the7mk2'),
			"param_name"	=> "text_color_style",
			"value"			=> array(
				"Default (from Theme Options / Buttons)"	=> "default",
				"Title"										=> "context",
				"Accent"									=> "accent",
				"Custom"									=> "custom"
			)
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "colorpicker",
			"class"			=> "",
			"heading"		=> __("Custom text color", 'the7mk2'),
			"param_name"	=> "text_color",
			"value"			=> '#888888',
			"dependency"	=> array(
				"element"	=> "text_color_style",
				"value"		=> array( "custom" )
			),
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __("Text hover color", 'the7mk2'),
			"param_name"	=> "text_hover_color_style",
			"value"			=> array(
				"Default (from Theme Options / Buttons)"	=> "default",
				"Title"										=> "context",
				"Accent"									=> "accent",
				"Custom"									=> "custom"
			)
		),
		array(
			"group"			=> __("Style", 'the7mk2'),
			"type"			=> "colorpicker",
			"class"			=> "",
			"heading"		=> __("Custom text hover color", 'the7mk2'),
			"param_name"	=> "text_hover_color",
			"value"			=> '#888888',
			"dependency"	=> array(
				"element"	=> "text_hover_color_style",
				"value"		=> array( "custom" )
			),
		),
		array(
			"group" => __("Icon", 'the7mk2'),
			"type" => "textarea_raw_html",
			"class" => "",
			"heading" => __("Icon", 'the7mk2'),
			"param_name" => "icon",
			"value" => '',
			"description" => __('f.e. <code>&lt;i class="fa fa-coffee"&gt;&lt;/i&gt;</code>', 'the7mk2'),
		),
		array(
			"group"			=> __("Icon", 'the7mk2'),
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon alignment", 'the7mk2'),
			"param_name" => "icon_align",
			"value" => array(
				"Left" => "left",
				"Right" => "right"
			)
		),
	)
);

