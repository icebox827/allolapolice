<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

include dirname( __FILE__ ) . '/mod-albums-bridge-common-parts.php';

return array(
	"weight" => -1,
	"base" => 'dt_albums_scroller',
	"name" => __( "Albums Scroller (old)", 'dt-the7-core' ),
	"category" => __( 'The7 Old', 'dt-the7-core' ),
	"icon" => "dt_vc_ico_albums",
	"class" => "dt_vc_sc_albums",
	"params" => array_merge(
		// General group.
		$category,
		$album_number_order_title,
		$scroller_albums_to_show,
		$ordering,

		// Appearance group.
		$scroller_padding,
		$thumbnails_width,
		$thumbnails_height,
		$thumbnails_max_width,
		$album_design_title,
		$descriptions_masonry,
		$album_elements_title,
		$show_albums_content,
		$show_miniatures,

		// Elements group.
		$show_meta,
		$show_media_count,

		// Slideshow group.
		$scroller_arrows,
		$scroller_slidehow_controls
	)
);

