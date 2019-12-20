<?php
/**
 * Albums archive options.
 *
 * @package the7
 * @since   3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$new_options[] = array( 'name' => _x( 'Albums archives', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$new_options['template_page_id_gallery_category'] = array(
	'id'   => 'template_page_id_gallery_category',
	'name' => _x( 'Choose a page to take settings from', 'theme-options', 'dt-the7-core' ),
	'desc' => _x( 'This template will be applied to taxonomy and post type archive pages.', 'theme-options', 'dt-the7-core' ),
	'type' => 'pages_list',
	'std'  => '0',
);

$new_options['template_page_id_gallery_category_full_content'] = array(
	'id'         => 'template_page_id_gallery_category_full_content',
	'name'       => _x( 'Show full content of albums archive template', 'theme-options', 'dt-the7-core' ),
	'type'       => 'radio',
	'std'        => '0',
	'options'    => array(
		'1' => _x( 'Yes', 'theme-options', 'dt-the7-core' ),
		'0' => _x( 'No', 'theme-options', 'dt-the7-core' ),
	),
	'dependency' => array(
		'field'    => 'template_page_id_gallery_category',
		'operator' => '!=',
		'value'    => '0',
	),
);

// add new options
if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'archive_placeholder' );
}

// cleanup
unset( $new_options );