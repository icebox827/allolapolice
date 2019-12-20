<?php
/**
 * The7 7.0.0 patch.
 *
 * @package the7
 * @since   7.0.0
 */

class The7_DB_Patch_070000 extends The7_DB_Patch {

	protected function do_apply() {
		switch( $this->get_option( 'header-elements-search-icon' ) ) {
			case '1':
				$this->set_option( 'header-elements-search-icon', 'default' );
				break;
			case '0':
				$this->set_option( 'header-elements-search-icon', 'disabled' );
				break;
		}
	}
}
