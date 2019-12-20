<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

include dirname( __FILE__ ) . '/mod-albums-bridge-common-parts.php';

return array(
	"weight" => -1,
	"base" => "dt_albums_jgrid",
	"name" => __( "Albums Justified Grid", 'dt-the7-core' ),
	"category" => __( 'by Dream-Theme', 'dt-the7-core' ),
	"icon" => "dt_vc_ico_albums",
	"class" => "dt_vc_sc_albums",
	"params" => array_merge(
		$category,
		$album_number_order_title,
		$albums_to_show,
		$albums_per_page,
		array(
			array(
				'heading'          => __( 'Albums offset', 'dt-the7-core' ),
				'param_name'       => 'posts_offset',
				'type'             => 'dt_number',
				'value'            => 0,
				'min'              => 0,
				'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
				'description'      => __( 'Offset for albums query (i.e. 2 means, albums will be displayed starting from the third album).', 'dt-the7-core' ),
			),
		),
		$ordering,
		$album_filter_title,
		$show_filter,

		$loading_effect,
		$target_height,
		$hide_last_row,
		$padding,
		$proportion,
		$album_design_title,
		$descriptions_jgrid,
		$album_elements_title,
		$show_albums_content,
		$show_miniatures,

		$show_meta,
		$show_media_count
	)
);

