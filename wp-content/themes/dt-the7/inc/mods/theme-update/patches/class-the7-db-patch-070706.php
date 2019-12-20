<?php
/**
 * The7 7.7.6 patch.
 *
 * @since   7.7.6
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_DB_Patch_070706
 */
class The7_DB_Patch_070706 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		if ( ! $this->option_exists( 'header-elements-soc_icons' ) ) {
			return;
		}

		$icons     = (array) $this->get_option( 'header-elements-soc_icons' );
		$new_icons = array();
		foreach ( $icons as $icon ) {
			if ( $icon['icon'] === 'google' ) {
				continue;
			}
			$new_icons[] = $icon;
		}
		$this->set_option( 'header-elements-soc_icons', $new_icons );
	}
}
