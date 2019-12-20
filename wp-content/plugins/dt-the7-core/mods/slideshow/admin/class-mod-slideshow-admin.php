<?php
/**
 * Slideshow admin part.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Presscore_Mod_Slideshow_Admin {

	public function register_post_types() {
		$post_type = 'dt_slideshow';
		$args = array(
			'labels'                => array(
				'name'                  => _x('Slideshows',						'backend albums', 'dt-the7-core'),
				'singular_name'         => _x('Slider',							'backend albums', 'dt-the7-core'),
				'add_new'               => _x('Add New',						'backend albums', 'dt-the7-core'),
				'add_new_item'          => _x('Add New Slider',					'backend albums', 'dt-the7-core'),
				'edit_item'             => _x('Edit Slider',					'backend albums', 'dt-the7-core'),
				'new_item'              => _x('New Slider',						'backend albums', 'dt-the7-core'),
				'view_item'             => _x('View Slider',					'backend albums', 'dt-the7-core'),
				'search_items'          => _x('Search for Slideshow',			'backend albums', 'dt-the7-core'),
				'not_found'             => _x('No Slideshow Found',				'backend albums', 'dt-the7-core'),
				'not_found_in_trash'    => _x('No Slideshow Found in Trash',	'backend albums', 'dt-the7-core'),
				'parent_item_colon'     => '',
				'menu_name'             => _x('Slideshows',						'backend albums', 'dt-the7-core')
			),
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => true, 
			'query_var'             => true,
			'rewrite'               => true,
			'capability_type'       => 'post',
			'has_archive'           => true, 
			'hierarchical'          => false,
			'menu_position'         => 41,
			'supports'              => array( 'title', 'thumbnail' )
		);

		$args = apply_filters( "presscore_post_type_{$post_type}_args", $args );

		register_post_type( $post_type, $args );
	}

	public function add_meta_boxes( $metaboxes ) {
		$metaboxes[] = plugin_dir_path( __FILE__ ) . 'metaboxes/metaboxes-slideshow.php';
		return $metaboxes;
	}

	public function filter_admin_post_thumbnail( $thumbnail, $post_type, $post_id ) {
		if ( ! $thumbnail && 'dt_slideshow' === $post_type ) {
			$media_gallery = get_post_meta( $post_id, '_dt_slider_media_items', true );
			if ( $media_gallery && is_array( $media_gallery ) ) {
				$thumbnail = wp_get_attachment_image_src( current( $media_gallery ), 'thumbnail' );
			}
		}
		return $thumbnail;
	}
}
