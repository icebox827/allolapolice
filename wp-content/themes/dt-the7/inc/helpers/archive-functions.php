<?php
/**
 * Archive helpers.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'presscore_archive_post_content' ) ) {

	/**
	 * @deprecated
	 */
	function presscore_archive_post_content() {
		$post_type = get_post_type();
		$html = apply_filters( "presscore_archive_post_content-{$post_type}", '' );
		if ( $html ) {

			echo $html;

		} else if ( 'post' == $post_type ) {

			presscore_config()->set( 'show_details', false );
			presscore_populate_post_config();
			presscore_get_template_part( 'theme', 'blog/masonry/blog-masonry-post' );

		} else {

			presscore_get_template_part( 'theme', 'content-archive' );

		}
	}
}

if ( ! function_exists( 'the7_archive_loop' ) ) {

	/**
	 * Archive loop handler.
	 */
	function the7_archive_loop() {
		$post_type = get_post_type();
		$custom_loop = apply_filters( "the7_{$post_type}_archive_loop", false );
		if ( ! $custom_loop ) {
			the7_generic_archive_loop();
		}
	}
}

if ( ! function_exists( 'the7_search_loop' ) ) {

	/**
	 * Search loop handler.
	 */
	function the7_search_loop() {
		$custom_loop = apply_filters( 'the7_search_loop', false );
		if ( ! $custom_loop ) {
			the7_generic_archive_loop();
		}
	}
}

if ( ! function_exists( 'the7_generic_archive_loop' ) ) {

	/**
	 * Generic archive loop. Output posts in masonry layout.
	 */
	function the7_generic_archive_loop() {
		do_action( 'presscore_before_loop' );

		$config = presscore_config();

		// backup config
		$config_backup = $config->get();

		// masonry container open
		echo '<div ' . presscore_masonry_container_class( array( 'wf-container' ) ) . presscore_masonry_container_data_atts() . '>';
		while ( have_posts() ) {
			the_post();
			presscore_archive_post_content();
			$config->reset( $config_backup );
		}
		// masonry container close
		echo '</div>';

		dt_paginator();

		do_action( 'presscore_after_loop' );
	}
}
