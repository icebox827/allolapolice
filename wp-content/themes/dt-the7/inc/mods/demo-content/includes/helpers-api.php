<?php
/**
 * Helpers API.
 */

/**
 * @param string $path
 *
 * @return string
 */
function the7_demo_content_dir_path( $path = '' ) {
	return PRESSCORE_MODS_DIR . "/demo-content/$path";
}

/**
 * @param string $path
 *
 * @return string
 */
function the7_demo_content_dir_url( $path = '' ) {
	return PRESSCORE_MODS_URI . "/demo-content/$path";
}

/**
 * Determine is Woocommerce plugin is active.
 *
 * @return boolean
 */
function the7_demo_content_wc_is_active() {
	return class_exists( 'Woocommerce', false );
}

if ( ! function_exists( 'the7_is_debug_on' ) ) {

	/**
	 * @return bool
	 */
	function the7_is_debug_on() {
		return ( defined( 'THE7_DEBUG' ) && THE7_DEBUG );
	}

}