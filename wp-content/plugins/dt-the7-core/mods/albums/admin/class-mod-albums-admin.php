<?php
/**
 * Albums admin part.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Presscore_Mod_Albums_Admin {

	public function register_post_types() {
		$post_type = 'dt_gallery';
		$args = array(
			'labels'                => array(
				'name'                  => _x('Photo Albums',             'backend albums', 'dt-the7-core'),
				'singular_name'         => _x('Photo Album',              'backend albums', 'dt-the7-core'),
				'add_new'               => _x('Add New Album',            'backend albums', 'dt-the7-core'),
				'add_new_item'          => _x('Add New Album',            'backend albums', 'dt-the7-core'),
				'edit_item'             => _x('Edit Album',               'backend albums', 'dt-the7-core'),
				'new_item'              => _x('New Album',                'backend albums', 'dt-the7-core'),
				'view_item'             => _x('View Album',               'backend albums', 'dt-the7-core'),
				'search_items'          => _x('Search for Albums',        'backend albums', 'dt-the7-core'),
				'not_found'             => _x('No Albums Found',          'backend albums', 'dt-the7-core'),
				'not_found_in_trash'    => _x('No Albums Found in Trash', 'backend albums', 'dt-the7-core'),
				'parent_item_colon'     => '',
				'menu_name'             => _x('Photo Albums',             'backend albums', 'dt-the7-core')
			),
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => true, 
			'query_var'             => true,
			'rewrite'               => array( 'slug' => $post_type ),
			'capability_type'       => 'post',
			'has_archive'           => true, 
			'hierarchical'          => false,
			'menu_position'         => 40,
			'supports'              => array( 'author', 'title', 'thumbnail', 'excerpt', 'editor', 'comments', 'revisions' ),
			'show_in_rest'          => true,
		);

		$args = apply_filters( "presscore_post_type_{$post_type}_args", $args );

		register_post_type( $post_type, $args );
	}

	public function register_taxonomies() {
		$post_type = 'dt_gallery';
		$taxonomy = 'dt_gallery_category';
		$args = array(
			'labels'                => array(
				'name'              => _x( 'Album Categories',                  'backend albums', 'dt-the7-core' ),
				'singular_name'     => _x( 'Album Category',                    'backend albums', 'dt-the7-core' ),
				'search_items'      => _x( 'Search in Category',                'backend albums', 'dt-the7-core' ),
				'all_items'         => _x( 'Photo Album Categories',            'backend albums', 'dt-the7-core' ),
				'parent_item'       => _x( 'Parent Category',                   'backend albums', 'dt-the7-core' ),
				'parent_item_colon' => _x( 'Parent Category:',                  'backend albums', 'dt-the7-core' ),
				'edit_item'         => _x( 'Edit Category',                     'backend albums', 'dt-the7-core' ),
				'update_item'       => _x( 'Update Category',                   'backend albums', 'dt-the7-core' ),
				'add_new_item'      => _x( 'Add New Album Category',            'backend albums', 'dt-the7-core' ),
				'new_item_name'     => _x( 'New Album Category Name',           'backend albums', 'dt-the7-core' ),
				'menu_name'         => _x( 'Album Categories',                  'backend albums', 'dt-the7-core' )
			),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'rewrite'               => true,
			'show_admin_column'     => true,
			'show_in_rest'          => true,
		);

		$args = apply_filters( "presscore_taxonomy_{$taxonomy}_args", $args );

		register_taxonomy( $taxonomy, array( $post_type ), $args );
	}

	public function add_meta_boxes( $metaboxes ) {
		$metaboxes[] = plugin_dir_path( __FILE__ ) . 'metaboxes/metaboxes-albums.php';
		return $metaboxes;
	}

	public function add_basic_meta_boxes_support( $pages ) {
		$pages[] = 'dt_gallery';
		return $pages;
	}

	public function add_options( $options ) {
		if ( array_key_exists( 'of-blog-and-portfolio-menu', $options ) ) {
			$options['of-albums-mod-injected-options'] = plugin_dir_path( __FILE__ ) . 'options/options-albums.php';
			$options['of-albums-mod-injected-slug-options'] = plugin_dir_path( __FILE__ ) . 'options/options-slug-albums.php';
		}
		if ( function_exists( 'presscore_module_archive_get_menu_slug' ) && array_key_exists( presscore_module_archive_get_menu_slug(), $options ) ) {
			$options['of-albums-mod-injected-archive-options'] = plugin_dir_path( __FILE__ ) . 'options/options-archive-albums.php';
		}
		return $options;
	}

	public function js_composer_default_editor_post_types_filter( $post_types ) {
		$post_types[] = 'dt_gallery';
		return $post_types;
	}

	public function filter_admin_post_thumbnail( $thumbnail, $post_type, $post_id ) {
		if ( ! $thumbnail && 'dt_gallery' === $post_type ) {
			$media_gallery = get_post_meta( $post_id, '_dt_album_media_items', true );
			if ( $media_gallery && is_array( $media_gallery ) ) {
				$thumbnail = wp_get_attachment_image_src( current( $media_gallery ), 'thumbnail' );
			}
		}
		return $thumbnail;
	}
}
