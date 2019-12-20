<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

include dirname( __FILE__ ) . '/mod-albums-bridge-common-parts.php';

return array(
	"weight" => -1,
	"base" => 'dt_albums',
	"name" => __( "Albums Masonry and Grid (old)", 'dt-the7-core' ),
	"category" => __( 'The7 Old', 'dt-the7-core' ),
	"icon" => "dt_vc_ico_albums",
	"class" => "dt_vc_sc_albums",
	"params" => array_merge(
		$category,
		$album_number_order_title,
		$albums_per_page,
		$albums_to_show,
		$ordering,
		$album_filter_title,
		$show_filter,
		$show_filter_ordering,

		$appearance,
		$loading_effect,
		array(
			array(
				"heading" => __( "Albums width", 'dt-the7-core' ),
				"param_name" => "same_width",
				"type" => "dropdown",
				"value" => array(
					"Preserve original width" => "false",
					"Make albums same width" => "true",
				),
				"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
				"group" => __( "Appearance", 'dt-the7-core' ),
			)
		),
		$padding_masonry,
		$proportion,
		$album_design_title,
		$descriptions_masonry,
		$album_elements_title,
		$show_albums_content,
		$show_miniatures,

		$show_meta,
		$show_media_count,

		$responsiveness
	)
);
