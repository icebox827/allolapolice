<?php
/**
 * Admint functions for WPML module.
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'dt_wpml_add_theme_options_page' ) ) :

	/**
	 * Add WPML theme options page.
	 * 
	 * @param  array  $menu_items
	 * @return array
	 */
	function dt_wpml_add_theme_options_page( $menu_items = array() ) {
		$menu_slug = 'of-wpml-menu';
		if ( ! array_key_exists( $menu_slug, $menu_items ) ) {
			$menu_items[ $menu_slug ] = array(
				'menu_title'       => _x( 'WPML', 'backend', 'the7mk2' ),
			);
		}
		return $menu_items;
	}

	add_filter( 'presscore_options_menu_config', 'dt_wpml_add_theme_options_page', 21 );

endif;

if ( ! function_exists( 'dt_wpml_add_theme_options' ) ) {

	function dt_wpml_add_theme_options( $files_list ) {
		$menu_slug = 'of-wpml-menu';
		
		if ( ! array_key_exists( $menu_slug, $files_list ) ) {
			$files_list[ $menu_slug ] = dirname( __FILE__ ) . '/mod-wpml-options.php';
		}
		return $files_list;
	}
	add_filter( 'presscore_options_files_list', 'dt_wpml_add_theme_options' );

}

