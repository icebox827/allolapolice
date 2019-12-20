<?php
/**
 * In case of old theme.
 */

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		$posts_with_inline_css = $wpdb->get_results( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'the7_shortcodes_inline_css' AND post_id NOT IN ($exclude_posts_str)" );

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

/**
 * Update posts back buttons urls stored in $meta_key.
 *
 * @since 1.18.0
 *
 * @param string $meta_key
 */
function the7pt_update_posts_back_button_urls_in_meta_key( $meta_key ) {
	global $wpdb;

	$posts_with_back_buttons = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = %s AND concat('',meta_value * 1) = meta_value", $meta_key ) );
	foreach ( $posts_with_back_buttons as $post ) {
		if ( $post->meta_value === '' ) {
			continue;
		}

		$new_value = '';
		if ( (int) $post->meta_value ) {
			$new_value = wp_make_link_relative( get_permalink( (int) $post->meta_value ) );
		}

		update_post_meta( $post->post_id, $meta_key, $new_value );
	}
}

/**
 * Apply $migration to theme options.
 *
 * @since 1.18.0
 */
function the7pt_migrate_theme_options( The7_DB_Patch_Interface $migration ) {
	$options = optionsframework_get_options();
	if ( ! $options ) {
		return;
	}

	$options = $migration->apply( $options );

	update_option( optionsframework_get_options_id(), $options );
}