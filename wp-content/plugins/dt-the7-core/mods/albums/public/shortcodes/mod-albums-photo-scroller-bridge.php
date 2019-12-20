<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

include dirname( __FILE__ ) . '/mod-albums-bridge-common-parts.php';

return array(
	'weight'      => -1,
	'base'        => 'dt_small_photos',
	'name'        => __( 'Photos Scroller (old)', 'dt-the7-core' ),
	'description' => __( 'Images from Photo Albums post type', 'dt-the7-core' ),
	'category'    => __( 'The7 Old', 'dt-the7-core' ),
	'icon'        => 'dt_vc_ico_photos',
	'class'       => 'dt_vc_sc_photos',
	'params'      => array_merge(
		// General group.
		$category,
		$photo_number_order_title,
		$photos_to_show,
		array(
			array(
				'heading' => __( 'Show', 'dt-the7-core' ),
				'param_name' => 'orderby',
				'type' => 'dropdown',
				'value' => array(
					'Recent photos' => 'recent',
					'Random photos' => 'random',
				),
				'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			),
		),

		// Appearance group.
		$scroller_padding,
		$thumbnails_width,
		$thumbnails_height,
		$thumbnails_max_width,
		$album_elements_title,
		$show_photos_content,

		// Slideshow group.
		$scroller_arrows,
		$scroller_slidehow_controls
	)
);
