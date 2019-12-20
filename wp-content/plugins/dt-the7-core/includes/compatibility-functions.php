<?php
/**
 * Functions meant to provide backward compatibility with The7.
 *
 * @since   2.0.5
 *
 * @package The7pt
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'the7_get_new_shortcode_less_vars_manager' ) ) {

	/**
	 * Factory function for shortcode less manager.
	 * Provide backward compatibility with The7 7.7.0.
	 *
	 * @return DT_Blog_LessVars_Manager
	 */
	function the7_get_new_shortcode_less_vars_manager() {
		return new DT_Blog_LessVars_Manager( new Presscore_Lib_SimpleBag(), new Presscore_Lib_LessVars_Factory() );
	}

}