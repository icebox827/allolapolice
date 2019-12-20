<?php
/**
 * The7 7.6.2 patch.
 *
 * @since   7.6.2
 * @package The7/Updater/Migrations
 */

defined( 'ABSPATH' ) || exit;

class The7_DB_Patch_070602 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$this->copy_option_value( 'header-style-mixed-top_line-floating-logo-padding', 'header-style-mixed-logo-padding' );
	}
}
