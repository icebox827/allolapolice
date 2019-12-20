<?php

class The7_Demo_Content_Import extends WP_Import {

	const THE7_PROCESSED_DATA_KEY = 'the7_demo_content_processed_data';

	/**
	 * Performs post-import cleanup of files and the cache
	 */
	function import_end() {
		wp_import_cleanup( $this->id );

		wp_cache_flush();
		foreach ( get_taxonomies() as $tax ) {
			delete_option( "{$tax}_children" );
			_get_term_hierarchy( $tax );
		}

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );

		do_action( 'import_end' );
	}

	/**
	 * Method override.
	 *
	 * Add custom meta to menu items.
	 *
	 * @param array $item
	 */
	function process_menu_item( $item ) {

		// skip draft, orphaned menu items
		if ( 'draft' == $item['status'] ) {
			return;
		}

		$menu_slug = false;
		if ( isset( $item['terms'] ) ) {
			// loop through terms, assume first nav_menu term is correct menu
			foreach ( $item['terms'] as $term ) {
				if ( 'nav_menu' == $term['domain'] ) {
					$menu_slug = $term['slug'];
					break;
				}
			}
		}

		// no nav_menu term associated with this menu item
		if ( ! $menu_slug ) {
			_e( 'Menu item skipped due to missing menu slug', 'wordpress-importer' );
			echo '<br />';

			return;
		}

		$menu_id = term_exists( $menu_slug, 'nav_menu' );
		if ( ! $menu_id ) {
			printf( __( 'Menu item skipped due to invalid menu slug: %s', 'wordpress-importer' ), esc_html( $menu_slug ) );
			echo '<br />';

			return;
		} else {
			$menu_id = is_array( $menu_id ) ? $menu_id['term_id'] : $menu_id;
		}

		foreach ( $item['postmeta'] as $meta ) {
			${$meta['key']} = $meta['value'];
		}

		if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[ intval( $_menu_item_object_id ) ] ) ) {
			$_menu_item_object_id = $this->processed_terms[ intval( $_menu_item_object_id ) ];
		} else if ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[ intval( $_menu_item_object_id ) ] ) ) {
			$_menu_item_object_id = $this->processed_posts[ intval( $_menu_item_object_id ) ];
		} else if ( 'custom' != $_menu_item_type ) {
			// associated object is missing or not imported yet, we'll retry later
			$this->missing_menu_items[] = $item;

			return;
		}

		if ( isset( $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ] ) ) {
			$_menu_item_menu_item_parent = $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ];
		} else if ( $_menu_item_menu_item_parent ) {
			$this->menu_item_orphans[ intval( $item['post_id'] ) ] = (int) $_menu_item_menu_item_parent;
			$_menu_item_menu_item_parent                           = 0;
		}

		// wp_update_nav_menu_item expects CSS classes as a space separated string
		$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
		if ( is_array( $_menu_item_classes ) ) {
			$_menu_item_classes = implode( ' ', $_menu_item_classes );
		}

		$args = array(
			'menu-item-object-id'   => $_menu_item_object_id,
			'menu-item-object'      => $_menu_item_object,
			'menu-item-parent-id'   => $_menu_item_menu_item_parent,
			'menu-item-position'    => intval( $item['menu_order'] ),
			'menu-item-type'        => $_menu_item_type,
			'menu-item-title'       => $item['post_title'],
			'menu-item-url'         => $_menu_item_url,
			'menu-item-description' => $item['post_content'],
			'menu-item-attr-title'  => $item['post_excerpt'],
			'menu-item-target'      => $_menu_item_target,
			'menu-item-classes'     => $_menu_item_classes,
			'menu-item-xfn'         => $_menu_item_xfn,
			'menu-item-status'      => $item['status'],
		);

		/**
		 * Filter menu item args.
		 *
		 * @since 7.4.1
		 */
		$args = apply_filters( 'wxr_menu_item_args', $args, $menu_id );

		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( $id && ! is_wp_error( $id ) ) {
			$this->processed_menu_items[ intval( $item['post_id'] ) ] = (int) $id;

			// Add custom meta.
			$meta_to_exclude   = array_keys( $args );
			$meta_to_exclude[] = 'menu-item-menu-item-parent';
			foreach ( $item['postmeta'] as $meta ) {
				$key = str_replace( '_', '-', ltrim( $meta['key'], '_' ) );
				if ( ! empty( $meta['value'] ) && ! in_array( $key, $meta_to_exclude, true ) ) {
					update_post_meta( $id, $meta['key'], maybe_unserialize( $meta['value'] ) );
				}
			}
		}
	}

	/**
	 * Cache processed data to be used in future imports.
	 */
	public function cache_processed_data() {
		$data = array(
			'processed_authors'    => $this->processed_authors,
			'processed_terms'      => $this->processed_terms,
			'processed_posts'      => $this->processed_posts,
			'featured_images'      => $this->featured_images,
		);
		set_transient( self::THE7_PROCESSED_DATA_KEY, $data, 1200 );
	}

	/**
	 * Read populate internal variables with processed data from cache.
	 */
	public function read_processed_data_from_cache() {
		$processed_data = get_transient( self::THE7_PROCESSED_DATA_KEY );
		if ( ! is_array( $processed_data ) || empty( $processed_data ) ) {
			return;
		}

		foreach ( $processed_data as $group => $data ) {
			if ( property_exists( $this, $group ) && $data ) {
				$this->$group = $data;
			}
		}
	}

	/**
	 * Decide whether or not the importer is allowed to create users.
	 * Default is false (we don't want to scare users), can be filtered via import_allow_create_users.
	 *
	 * @return bool True if creating users is allowed
	 */
	public function allow_create_users() {
		return apply_filters( 'import_allow_create_users', false );
	}
}
