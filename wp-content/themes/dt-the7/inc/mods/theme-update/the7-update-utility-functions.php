<?php

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'the7_get_posts_with_shortcodes' ) ) {

	/**
	 * Return content of posts with shortcodes.
	 *
	 * @param array $exclude_posts
	 *
	 * @return array
	 */
	function the7_get_posts_with_shortcodes( $exclude_posts = array() ) {
		global $wpdb;

		$exclude_posts_str     = implode( ',', $exclude_posts );
		$posts_with_inline_css = $wpdb->get_results( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'the7_shortcodes_dynamic_css' AND post_id NOT IN ($exclude_posts_str)" );

		if ( ! $posts_with_inline_css ) {
			return array();
		}

		$post_ids      = array_unique( wp_list_pluck( $posts_with_inline_css, 'post_id' ) );
		$post_ids_str  = implode( ',', $post_ids );
		$posts_content = $wpdb->get_results( "SELECT ID, post_content FROM $wpdb->posts WHERE post_type != 'revision' AND ID IN ({$post_ids_str})" );

		return wp_list_pluck( $posts_content, 'post_content', 'ID' );
	}
}

if ( ! function_exists( 'the7_migrate_shortcodes' ) ) {

	/**
	 * Apply $callback to shortcodes attributes that can be found in $content. Search for $tags in content.
	 *
	 * @param callable $callback
	 * @param string   $content
	 * @param array    $tags
	 *
	 * @return string
	 */
	function the7_migrate_shortcodes( $callback, $content, $tags ) {
		if ( ! is_callable( $callback ) ) {
			return $content;
		}

		preg_match_all( '/' . get_shortcode_regex( $tags ) . '/', $content, $shortcodes );
		foreach ( $shortcodes[2] as $index => $tag ) {
			$atts = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );

			if ( ! is_array( $atts ) ) {
				continue;
			}

			$new_atts = call_user_func( $callback, $atts, $tag );
			if ( $new_atts === $atts ) {
				continue;
			}

			$new_atts_str = '';
			foreach ( $new_atts as $att => $val ) {
				$new_atts_str .= " $att=\"$val\"";
			}

			$replace    = '[' . $tag . $shortcodes[3][ $index ];
			$replace_to = "[{$tag}{$new_atts_str}";
			$content    = str_replace( $replace, $replace_to, $content );
		}

		return $content;
	}
}

if ( ! function_exists( 'the7_migrate_shortcodes_in_all_posts' ) ) {

	/**
	 * Migrate shortcodes $tags in all posts.
	 *
	 * Apply $callback for each shortcode atts. Save processed posts ids in option with $cache_key name.
	 *
	 * @param callable $callback
	 * @param array    $tags
	 * @param string   $cache_key
	 *
	 * @return bool
	 */
	function the7_migrate_shortcodes_in_all_posts( $callback, $tags, $cache_key ) {
		$processed_posts = get_option( $cache_key );
		if ( ! $processed_posts || ! is_array( $processed_posts ) ) {
			$processed_posts = array( '0' );
		}

		$posts_content_array = the7_get_posts_with_shortcodes( $processed_posts );
		if ( ! $posts_content_array ) {
			delete_option( $cache_key );

			return false;
		}

		foreach ( $posts_content_array as $post_id => $content ) {
			if ( empty( $content ) ) {
				continue;
			}

			$new_content = the7_migrate_shortcodes( $callback, $content, $tags );
			if ( $content !== $new_content ) {
				wp_update_post( array(
					'ID'           => $post_id,
					'post_content' => $new_content,
				) );
			}

			$processed_posts[] = $post_id;
			update_option( $cache_key, $processed_posts, false );
		}

		delete_option( $cache_key );

		return true;
	}
}

if ( ! function_exists( 'the7_mass_regenerate_short_codes_inline_css' ) ) {

	/**
	 * Regenerate short codes inline css for all posts.
	 *
	 * @return bool
	 */
	function the7_mass_regenerate_short_codes_inline_css() {
		global $wpdb;

		$processed_posts = get_option( 'the7_update_short_codes_inline_css_processed_posts' );
		if ( ! $processed_posts || ! is_array( $processed_posts ) ) {
			$processed_posts = array( '0' );
		}
		$processed_posts_str   = implode( ',', $processed_posts );
		$posts_with_inline_css = $wpdb->get_results( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'the7_shortcodes_dynamic_css' AND post_id NOT IN ($processed_posts_str)" );

		if ( ! $posts_with_inline_css ) {
			delete_option( 'the7_update_short_codes_inline_css_processed_posts' );

			return false;
		}

		$post_ids            = wp_list_pluck( $posts_with_inline_css, 'post_id' );
		$post_ids_str        = join( ',', $post_ids );
		$posts_content       = $wpdb->get_results( "SELECT ID, post_content FROM $wpdb->posts WHERE ID IN ({$post_ids_str})" );
		$posts_content_array = wp_list_pluck( $posts_content, 'post_content', 'ID' );

		if ( ! class_exists( 'The7_Shortcode_Id_Crutch', false ) ) {
			include( PRESSCORE_SHORTCODES_INCLUDES_DIR . '/class-the7-shortcode-id-crutch.php' );
		}

		if ( ! class_exists( 'the7_lessc', false ) ) {
			include( PRESSCORE_DIR . '/vendor/lessphp/the7_lessc.inc.php' );
		}

		/**
		 * Little crutch to overcome short codes inner id issue.
		 *
		 * On each output short code increments inner id, which lead to fatal issues when trying to process many posts at once.
		 * First post processed normally but short codes id's in the next one will start not from 1, and inline css wil be generated with invalid selectors.
		 * This class can fix the issue. It can reset short code inner id on each iteration which emulates normal post save process.
		 */
		$id_crutch_obj = new The7_Shortcode_Id_Crutch();

		/**
		 * Hook to reset short code inner id.
		 */
		add_action( 'the7_after_shortcode_init', array( $id_crutch_obj, 'reset_id' ) );

		foreach ( $post_ids as $post_id ) {
			if ( empty( $posts_content_array[ $post_id ] ) || wp_is_post_revision( $post_id ) ) {
				continue;
			}

			/**
			 * Reset processed tags on each iteration.
			 */
			$id_crutch_obj->reset_processed_tags();
			$css = the7_generate_shortcode_css( $posts_content_array[ $post_id ] );
			if ( $css ) {
				update_post_meta( $post_id, 'the7_shortcodes_dynamic_css', $css );
			}

			$processed_posts[] = $post_id;
			update_option( 'the7_update_short_codes_inline_css_processed_posts', $processed_posts, false );
		}

		delete_option( 'the7_update_short_codes_inline_css_processed_posts' );
	}
}

/**
 * Regenerate css for each post.
 *
 * @since 7.9.1
 */
function the7_regenerate_post_css() {
	global $wpdb;

	$processed_posts = (array) get_transient( 'the7_updater_posts_with_regenerated_css' );
	$processed_posts = array_map( 'intval', $processed_posts );
	$supported_post_types = presscore_get_pages_with_basic_meta_boxes();

	$post_type_paceholder = implode( ',', array_fill( 0, count( $supported_post_types ), '%s' ) );
	$post_id_placeholder = implode( ',', array_fill( 0, count( $processed_posts ), '%d' ) );

	$query = $wpdb->prepare(
		"SELECT ID, post_type from $wpdb->posts where post_type in ($post_type_paceholder) and post_status = 'publish' and ID not in ($post_id_placeholder) order by ID asc limit 10",
		array_merge( $supported_post_types, $processed_posts )
	);

	$posts = $wpdb->get_results( $query );

	if ( ! $posts ) {
		delete_transient( 'the7_updater_posts_with_regenerated_css' );

		return false;
	}

	foreach ( $posts as $post ) {
		the7_update_post_css_on_save( $post->ID );
		$processed_posts[] = (int) $post->ID;
	}

	$processed_posts = array_filter( $processed_posts );

	set_transient( 'the7_updater_posts_with_regenerated_css', $processed_posts, 30 * MINUTE_IN_SECONDS );

	return __FUNCTION__;
}
