<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

include dirname( __FILE__ ) . '/mod-albums-bridge-common-parts.php';

return array(
	'weight'      => -1,
	'base'        => 'dt_photos_jgrid',
	'name'        => __( 'Photos Justified Grid', 'dt-the7-core' ),
	'description' => __( 'Images from Photo Albums post type', 'dt-the7-core' ),
	'category'    => __( 'by Dream-Theme', 'dt-the7-core' ),
	'icon'        => 'dt_vc_ico_photos',
	'class'       => 'dt_vc_sc_photos',
	'params'      => array_merge(
		$category,
		$photo_number_order_title,
		$photos_to_show,
		$ordering,
		$loading_effect,
		$target_height,
		$hide_last_row,
		$padding,
		$proportion,
		$photo_elements_title,
		$show_photos_content
	)
);

