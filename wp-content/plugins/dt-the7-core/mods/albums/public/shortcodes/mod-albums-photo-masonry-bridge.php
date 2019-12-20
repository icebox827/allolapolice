<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

include dirname( __FILE__ ) . '/mod-albums-bridge-common-parts.php';

return array(
	'weight'      => -1,
	'base'        => 'dt_photos_masonry',
	'name'        => __( 'Photos Masonry and Grid (old)', 'dt-the7-core' ),
	'description' => __( 'Images from Photo Albums post type', 'dt-the7-core' ),
	'category'    => __( 'The7 Old', 'dt-the7-core' ),
	'icon'        => 'dt_vc_ico_photos',
	'class'       => 'dt_vc_sc_photos',
	'params'      => array_merge(
		$category,
		$photo_number_order_title,
		$photos_to_show,
		$ordering,
		$appearance,
		$loading_effect,
		$padding_masonry,
		$proportion,
		$show_photos_content,
		$responsiveness
	)
);

