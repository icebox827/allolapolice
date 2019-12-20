<?php
/**
 * Slideshow shortcodes VC bridge
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Royal Slider.
 */
vc_map( array(
	"weight"   => -1,
	"base"     => "dt_slideshow",
	"name"     => __( "Slideshow", 'dt-the7-core' ),
	"category" => __( 'by Dream-Theme', 'dt-the7-core' ),
	"icon"     => "dt_vc_ico_slideshow",
	"class"    => "dt_vc_sc_slideshow",
	"params"   => array(
		array(
			"heading"     => __( "Display slideshow(s)", 'dt-the7-core' ),
			"description" => __( "Attention: Do not ignore this setting! Otherwise only one (newest) slideshow will be displayed.", 'dt-the7-core' ),
			"param_name"  => "posts",
			"type"        => "dt_posttype",
			"posttype"    => "dt_slideshow",
			"admin_label" => true,
		),
		array(
			"heading"    => __( "Proportions: width", 'dt-the7-core' ),
			"param_name" => "width",
			"type"       => "textfield",
			"value"      => "800",
		),
		array(
			"heading"    => __( "Proportions: height", 'dt-the7-core' ),
			"param_name" => "height",
			"type"       => "textfield",
			"value"      => "450",
		),
		array(
			"heading"    => __( "Image Scale Mode", 'dt-the7-core' ),
			"param_name" => "scale_mode",
			"type"       => "dropdown",
			"value"      => array(
				'Fill' => 'fill',
				'Fit'  => 'fit',
			),
		),
		array(
			"heading"    => __( "On page load slideshow is", 'dt-the7-core' ),
			"param_name" => "autoplay",
			"type"       => "dropdown",
			"value"      => array(
				'Paused'  => 'false',
				'Playing' => 'true',
			),
		),
		array(
			"heading"    => __( "Autoslide interval (in milliseconds)", 'dt-the7-core' ),
			"param_name" => "interval",
			"type"       => "textfield",
			"value"      => "5000",
		),
	)
) );
