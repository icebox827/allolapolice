<?php
/**
 * Plugin activator.
 *
 * @since       1.0.0
 * @package     dt_the7_core
 */

/**
 * Activator class.
 */
class The7PT_Activator {

	public static function activate() {
		// Regenerate theme stylesheets.
		if ( function_exists( 'presscore_refresh_dynamic_css' ) ) {
			presscore_refresh_dynamic_css();
		}

		update_option( 'the7pt_flush_rewrite_rules', true );
	}

}