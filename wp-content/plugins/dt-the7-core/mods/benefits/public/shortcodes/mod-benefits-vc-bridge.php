<?php
/**
 * Benefits shortcodes VC bridge
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ! Benefits
return array(
	"weight"   => - 1,
	"name"     => __( "Benefits", 'dt-the7-core' ),
	"base"     => "dt_benefits_vc",
	"icon"     => "dt_vc_ico_benefits",
	"class"    => "dt_vc_sc_benefits",
	"category" => __( 'by Dream-Theme', 'dt-the7-core' ),
	"params"   => array(

		array(
			"type"        => "dt_taxonomy",
			"taxonomy"    => "dt_benefits_category",
			"class"       => "",
			"admin_label" => true,
			"heading"     => __( "Categories", 'dt-the7-core' ),
			"param_name"  => "category",
			"description" => __( "Note: By default, all your benefits will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'dt-the7-core' ),
		),

		// Column min width
		array(
			"type"       => "textfield",
			"class"      => "",
			"heading"    => __( "Column minimum width (px)", 'dt-the7-core' ),
			"param_name" => "column_width",
			"value"      => "180",
		),

		// Column max width
		array(
			"type"       => "textfield",
			"class"      => "",
			"heading"    => __( "Desired columns number", 'dt-the7-core' ),
			"param_name" => "columns_number",
			"value"      => "3",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Benefits layout", 'dt-the7-core' ),
			"param_name"  => "style",
			"value"       => array(
				"Image, title & content centered" => "1",
				"Image & title inline"            => "2",
				"Image on the left"               => "3",
			),
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Icons backgrounds", 'dt-the7-core' ),
			"param_name"  => "image_background",
			"value"       => array(
				"Show" => "true",
				"Hide" => "false",
			),
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Border radius for image backgrounds", 'dt-the7-core' ),
			"param_name"  => "image_background_border",
			"value"       => array(
				"Default" => "",
				"Custom"  => "custom",
			),
			"description" => "",
		),

		array(
			"type"        => "textfield",
			"class"       => "",
			"heading"     => __( "Border radius (in px)", 'dt-the7-core' ),
			"param_name"  => "image_background_border_radius",
			"value"       => "",
			"description" => "",
			"dependency"  => array(
				"element" => "image_background_border",
				"value"   => array(
					"custom",
				),
			),
		),

		array(
			"type"        => "textfield",
			"class"       => "",
			"heading"     => __( "Background size (in px)", 'dt-the7-core' ),
			"param_name"  => "image_background_size",
			"value"       => "70",
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Backgrounds color", 'dt-the7-core' ),
			"param_name"  => "image_background_paint",
			"value"       => array(
				"Default"      => "light",
				"Accent"       => "accent",
				"Custom color" => "custom",
			),
			"description" => "",
		),

		array(
			"type"        => "colorpicker",
			"class"       => "",
			"heading"     => "",
			"param_name"  => "image_background_color",
			"value"       => "#222222",
			"description" => "",
			"dependency"  => array(
				"element" => "image_background_paint",
				"value"   => array(
					"custom",
				),
			),
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Backgrounds hover color", 'dt-the7-core' ),
			"param_name"  => "image_hover_background_paint",
			"value"       => array(
				"Default"      => "light",
				"Accent"       => "accent",
				"Custom color" => "custom",
			),
			"description" => "",
		),

		array(
			"type"        => "colorpicker",
			"class"       => "",
			"heading"     => "",
			"param_name"  => "image_hover_background_color",
			"value"       => "#444444",
			"description" => "",
			"dependency"  => array(
				"element" => "image_hover_background_paint",
				"value"   => array(
					"custom",
				),
			),
		),

		array(
			"type"        => "textfield",
			"class"       => "",
			"heading"     => __( "Icon size (in px)", 'dt-the7-core' ),
			"param_name"  => "icons_size",
			"value"       => "38",
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Icons color", 'dt-the7-core' ),
			"param_name"  => "icons_paint",
			"value"       => array(
				"Semitransparent" => "light",
				"Accent"          => "accent",
				"Custom color"    => "custom",
			),
			"description" => "",
		),

		array(
			"type"        => "colorpicker",
			"class"       => "",
			"heading"     => "",
			"param_name"  => "icons_color",
			"value"       => "#ffffff",
			"description" => "",
			"dependency"  => array(
				"element" => "icons_paint",
				"value"   => array(
					"custom",
				),
			),
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Icons hover color", 'dt-the7-core' ),
			"param_name"  => "icons_hover_paint",
			"value"       => array(
				"Semitransparent" => "light",
				"Accent"          => "accent",
				"Custom color"    => "custom",
			),
			"description" => "",
		),

		array(
			"type"        => "colorpicker",
			"class"       => "",
			"heading"     => "",
			"param_name"  => "icons_hover_color",
			"value"       => "#dddddd",
			"description" => "",
			"dependency"  => array(
				"element" => "icons_hover_paint",
				"value"   => array(
					"custom",
				),
			),
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Decorative lines", 'dt-the7-core' ),
			"param_name"  => "decorative_lines",
			"value"       => array(
				"Accent"          => "hover",
				"Semitransparent" => "static",
				"Disabled"        => "disabled",
			),
			'std'         => 'disabled',
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Title font size", 'dt-the7-core' ),
			"param_name"  => "header_size",
			"value"       => array(
				"H1" => "h1",
				"H2" => "h2",
				"H3" => "h3",
				"H4" => "h4",
				"H5" => "h5",
				"H6" => "h6",
			),
			'std'         => 'h5',
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Content font size", 'dt-the7-core' ),
			"param_name"  => "content_size",
			"value"       => array(
				"Large"  => "big",
				"Medium" => "normal",
				"Small"  => "small",
			),
			"description" => "",
		),

		array(
			"type"        => "textfield",
			"class"       => "",
			"heading"     => __( "Number of benefits to show", 'dt-the7-core' ),
			"param_name"  => "number",
			"value"       => "8",
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Open link in", 'dt-the7-core' ),
			"param_name"  => "target_blank",
			"value"       => array(
				"Same window" => "false",
				"New window"  => "true",
			),
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Order by", 'dt-the7-core' ),
			"param_name"  => "orderby",
			"value"       => array(
				"Date"          => "date",
				"Author"        => "author",
				"Title"         => "title",
				"Slug"          => "name",
				"Date modified" => "modified",
				"ID"            => "id",
				"Random"        => "rand",
			),
			"description" => __( "Select how to sort retrieved posts.", 'dt-the7-core' ),
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Order way", 'dt-the7-core' ),
			"param_name"  => "order",
			"value"       => array(
				"Descending" => "desc",
				"Ascending"  => "asc",
			),
			"description" => __( "Designates the ascending or descending order.", 'dt-the7-core' ),
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Animation", 'dt-the7-core' ),
			"admin_label" => true,
			"param_name"  => "animation",
			"value"       => presscore_get_vc_animation_options(),
			"description" => "",
		),

		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => __( "Animate", 'dt-the7-core' ),
			"param_name"  => "animate",
			"value"       => array(
				"One-by-one"       => 'one_by_one',
				"At the same time" => 'at_the_same_time',
			),
			"description" => "",
		),
	),
);
