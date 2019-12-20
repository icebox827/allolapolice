<?php
/**
 * The7 7.7.2 patch.
 *
 * @since   7.7.2
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_DB_Patch_070702
 */
class The7_DB_Patch_070702 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		if ( ! $this->get_option( 'contact_form_security_token' ) ) {
			$this->set_option( 'contact_form_security_token', of_sanitize_random_double_nonce( '' ) );
		}
	}
}
