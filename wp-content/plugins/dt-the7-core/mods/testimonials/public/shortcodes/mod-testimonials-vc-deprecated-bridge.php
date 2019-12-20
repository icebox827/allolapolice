<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"weight" => -1,
	"name" => __("Testimonials (old)", 'dt-the7-core'),
	"base" => 'dt_testimonials',
	"icon" => "dt_vc_ico_testimonials",
	"class" => "dt_vc_sc_testimonials",
	"category" => __('The7 Old', 'dt-the7-core'),
	"params" => array(

		// Terms
		array(
			"type" => "dt_taxonomy",
			"taxonomy" => "dt_testimonials_category",
			"class" => "",
			"heading" => __("Categories", 'dt-the7-core'),
			"param_name" => "category",
			"admin_label" => true,
			"description" => __("Note: By default, all your testimonials will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'dt-the7-core')
		),

		// Appearance
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Appearance", 'dt-the7-core'),
			"admin_label" => true,
			"param_name" => "type",
			"value" => array(
				"Masonry" => "masonry",
				"Slider" => "slider"
			),
			"description" => ""
		),

		// Gap
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Gap between testimonials (px)", 'dt-the7-core'),
			"description" => __("Testimonial paddings (e.g. 5 pixel padding will give you 10 pixel gaps between testimonials)", 'dt-the7-core'),
			"param_name" => "padding",
			"value" => "20",
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"masonry"
				)
			)
		),

		// Column width
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Column minimum width (px)", 'dt-the7-core'),
			"param_name" => "column_width",
			"value" => "370",
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"masonry"
				)
			)
		),

		// Desired columns number
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Desired columns number", 'dt-the7-core'),
			"param_name" => "columns",
			"value" => "2",
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"masonry"
				)
			)
		),

		// Loading effect
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Loading effect", 'dt-the7-core'),
			"param_name" => "loading_effect",
			"value" => array(
				'None' => 'none',
				'Fade in' => 'fade_in',
				'Move up' => 'move_up',
				'Scale up' => 'scale_up',
				'Fall perspective' => 'fall_perspective',
				'Fly' => 'fly',
				'Flip' => 'flip',
				'Helix' => 'helix',
				'Scale' => 'scale'
			),
			"description" => "",
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"masonry"
				)
			)
		),

		// Autoslide
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Autoslide", 'dt-the7-core'),
			"param_name" => "autoslide",
			"value" => "",
			"description" => __('In milliseconds (e.g. 3 seconds = 3000 miliseconds). Leave this field empty to disable autoslide. This field works only when "Appearance: Slider" selected.', 'dt-the7-core'),
			"dependency" => array(
				"element" => "type",
				"value" => array(
					"slider"
				)
			)
		),

		// Number of posts
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number of testimonials to show", 'dt-the7-core'),
			"param_name" => "number",
			"value" => "12",
			"description" => ""
		),

		// Order by
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by", 'dt-the7-core'),
			"param_name" => "orderby",
			"value" => array(
				"Date" => "date",
				"Author" => "author",
				"Title" => "title",
				"Slug" => "name",
				"Date modified" => "modified",
				"ID" => "id",
				"Random" => "rand"
			),
			"description" => __("Select how to sort retrieved posts.", 'dt-the7-core')
		),

		// Order
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order way", 'dt-the7-core'),
			"param_name" => "order",
			"value" => array(
				"Descending" => "desc",
				"Ascending" => "asc"
			),
			"description" => __("Designates the ascending or descending order.", 'dt-the7-core')
		)
	)
);

