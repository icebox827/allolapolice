<?php

defined( 'ABSPATH' ) || exit;

// Animation
vc_add_param( "vc_row", array(
	"heading" => __( "Animation", 'the7mk2' ),
	"param_name" => "animation",
	"type" => "dropdown",
	"value" => presscore_get_vc_animation_options(),
	"admin_label" => true,
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Anchor
vc_add_param( "vc_row", array(
	"heading" => __( "Anchor", 'the7mk2' ),
	"description" => __( "If anchor is &quot;contact&quot;, use &quot;#!/contact&quot; as its smooth scroll link.", 'the7mk2' ),
	"param_name" => "anchor",
	"type" => "textfield",
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Minimum height
vc_add_param( "vc_row", array(
	"heading" => __( "Row minimum height", 'the7mk2' ),
	"description" => __( "You can use pixels (px) or percents (%).", 'the7mk2' ),
	"param_name" => "min_height",
	"type" => "textfield",
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

$row_margin_support_link = 'http://support.dream-theme.com/knowledgebase/remove-gap-above-and-below-content-area/';

// Top margin
vc_add_param( "vc_row", array(
	"heading" => __( "Top margin", 'the7mk2' ),
	"description" => sprintf( __( 'In pixels; negative values are allowed. if this is <a href="%s" target="_blank">the first stripe</a>, set -50px.', 'the7mk2' ), $row_margin_support_link ),
	"param_name" => "margin_top",
	"type" => "textfield",
	"value" => "",
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Bottom margin
vc_add_param( "vc_row", array(
	"heading" => __( "Bottom margin", 'the7mk2' ),
	"description" => sprintf( __( 'In pixels; negative values are allowed. if this is <a href="%s" target="_blank">the last stripe</a>, set -50px.', 'the7mk2' ), $row_margin_support_link ),
	"param_name" => "margin_bottom",
	"type" => "textfield",
	"value" => "",
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Full-width content
vc_add_param( "vc_row", array(
	"heading" => __( "Full-width content", 'the7mk2' ),
	"param_name" => "full_width_row",
	"type" => "checkbox",
	"value" => array( "" => "true" ),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Left padding
vc_add_param( "vc_row", array(
	"heading" => __( "Left padding", 'the7mk2' ),
	"description" => __( "In pixels. This setting works only for inner row (a row inside a row).", 'the7mk2' ),
	"param_name" => "padding_left",
	"type" => "textfield",
	"value" => "",
	"dependency" => array(
		"element" => "full_width_row",
		"not_empty" => true,
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Right padding
vc_add_param( "vc_row", array(
	"heading" => __( "Right padding", 'the7mk2' ),
	"description" => __( "In pixels. This setting works only for inner row (a row inside a row).", 'the7mk2' ),
	"param_name" => "padding_right",
	"type" => "textfield",
	"value" => "",
	"dependency" => array(
		"element" => "full_width_row",
		"not_empty" => true,
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Top padding
vc_add_param( "vc_row", array(
	"heading" => __( "Top padding", 'the7mk2' ),
	"description" => __( "In pixels.", 'the7mk2' ),
	"param_name" => "padding_top",
	"type" => "textfield",
	"value" => "",
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Bottom padding
vc_add_param( "vc_row", array(
	"heading" => __( "Bottom padding", 'the7mk2' ),
	"description" => __( "In pixels.", 'the7mk2' ),
	"param_name" => "padding_bottom",
	"type" => "textfield",
	"value" => "",
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Background color
vc_add_param( "vc_row", array(
	"heading" => __( "Background color", 'the7mk2' ),
	"param_name" => "bg_color",
	"type" => "colorpicker",
	"value" => "",
	"dependency" => array(
		"element" => "type",
		"not_empty" => true,
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Background image
vc_add_param( "vc_row", array(
	"heading" => __( "Background image", 'the7mk2' ),
	"description" => __( "Image URL.", 'the7mk2' ),
	"param_name" => "bg_image",
	"type" => "textfield",
	"class" => "dt_image",
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Background position
vc_add_param( "vc_row", array(
	"heading" => __( "Background position", 'the7mk2' ),
	"param_name" => "bg_position",
	"type" => "dropdown",
	"value" => array(
		"Top" => "top",
		"Middle" => "center",
		"Bottom" => "bottom",
	),
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Background repeat
vc_add_param( "vc_row", array(
	"heading" => __( "Background repeat", 'the7mk2' ),
	"param_name" => "bg_repeat",
	"type" => "dropdown",
	"value" => array(
		"No repeat" => "no-repeat",
		"Repeat (horizontally & vertically)" => "repeat",
		"Repeat horizontally" => "repeat-x",
		"Repeat vertically" => "repeat-y",
	),
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Full-width background
vc_add_param( "vc_row", array(
	"heading" => __( "Full-width background", 'the7mk2' ),
	"param_name" => "bg_cover",
	"type" => "dropdown",
	"value" => array(
		"Disabled" => "false",
		"Enabled" => "true"
	),
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Fixed background
vc_add_param( "vc_row", array(
	"heading" => __( "Fixed background", 'the7mk2' ),
	"param_name" => "bg_attachment",
	"type" => "dropdown",
	"value" => array(
		"Disabled" => "false",
		"Enabled" => "true"
	),
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Enable parallax
vc_add_param( "vc_row", array(
	"heading" => __( "Enable parallax", 'the7mk2' ),
	"param_name" => "enable_parallax",
	"type" => "checkbox",
	"value" => array( "" => "false" ),
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Parallax speed
vc_add_param( "vc_row", array(
	"heading" => __( "Parallax speed", 'the7mk2' ),
	"description" => __( "Slower then content scrolling: 0.1 - 1. Faster then content scrolling: 1 and above. Reverse direction: - 0.1 and below.", 'the7mk2' ),
	"param_name" => "parallax_speed",
	"type" => "textfield",
	"value" => "0.1",
	"dependency" => array(
		"element" => "enable_parallax",
		"not_empty" => true,
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column",
));

// Video background (mp4)
vc_add_param( "vc_row", array(
	"heading" => __( "Video background (mp4)", 'the7mk2' ),
	"param_name" => "bg_video_src_mp4",
	"type" => "textfield",
	"value" => "",
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column dt-force-hidden",
));

// Video background (ogv)
vc_add_param( "vc_row", array(
	"heading" => __( "Video background (ogv)", 'the7mk2' ),
	"param_name" => "bg_video_src_ogv",
	"type" => "textfield",
	"value" => "",
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column dt-force-hidden",
));

// Video background (webm)
vc_add_param( "vc_row", array(
	"heading" => __( "Video background (webm)", 'the7mk2' ),
	"param_name" => "bg_video_src_webm",
	"type" => "textfield",
	"value" => "",
	"dependency" => array(
		"element" => "type",
		"value" => array( '1', '2', '3', '4', '5' ),
	),
	"edit_field_class" => "dt_vc_row-param vc_col-xs-12 vc_column dt-force-hidden",
));

$vc_row_shortcode = WPBMap::getShortCode( 'vc_row' );
if ( isset( $vc_row_shortcode['params'] ) && is_array( $vc_row_shortcode['params'] ) ) {
	$params = $vc_row_shortcode['params'];

	$row_value = array(
		'Default The7'                               => '',
		'Default VC'                                 => 'vc_default',
		'Stripe 1 (from Theme Options > Stripes)'    => '1',
		'Stripe 2 (from Theme Options > Stripes)'    => '2',
		'Stripe 3 (from Theme Options > Stripes)'    => '3',
		'Stripe 4 (dark background & light content)' => '4',
		'Stripe 5 (light background & dark content)' => '5',
	);

	// Output 'type' param first.
	array_unshift( $params, array(
		'heading'          => __( 'Row style', 'the7mk2' ),
		'param_name'       => 'type',
		'type'             => 'dropdown',
		'edit_field_class' => 'dt_vc_row-params_switch vc_col-xs-12 vc_column',
		'admin_label'      => true,
		'value'            => $row_value,
	) );

	$el_class_key = false;
	foreach ( $params as $p_key=>$p_data ) {
		if ( isset( $p_data['param_name'] ) && 'el_class' === $p_data['param_name'] ) {
			$el_class_key = $p_key;
			break;
		}
	}

	// Output 'el_class' param last.
	if ( false !== $el_class_key ) {
		$el_class = $params[ $el_class_key ];
		unset( $params[ $el_class_key ] );
		$params[] = $el_class;
	}

	WPBMap::modify( 'vc_row', 'params', $params );
}