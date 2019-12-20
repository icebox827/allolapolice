<?php
/**
 * Plugin deactivator.
 *
 * @since       1.0.0
 * @package     dt_the7_core
 */

/**
 * Deactivator class.
 */
class The7PT_Deactivator {

	public static function deactivate() {
		// Regenerate theme stylesheets.
		if ( function_exists( 'presscore_refresh_dynamic_css' ) ) {
			presscore_refresh_dynamic_css();
		}

		flush_rewrite_rules();
	}

}