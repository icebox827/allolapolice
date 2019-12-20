<?php
/**
 * The7 7.1.0 patch.
 *
 * @package the7
 * @since   7.1.0
 */

class The7_DB_Patch_070100 extends The7_DB_Patch {

	protected function do_apply() {
		$this->rename_option( 'header-elements-button-first-header-switch', 'header-elements-button-1-first-header-switch' );
		$this->rename_option( 'header-elements-button-on-desktops', 'header-elements-button-1-on-desktops' );
		$this->rename_option( 'header-elements-button-second-header-switch', 'header-elements-button-1-second-header-switch' );
	}
}
