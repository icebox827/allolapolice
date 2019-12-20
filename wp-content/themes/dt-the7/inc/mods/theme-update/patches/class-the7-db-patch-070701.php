<?php
/**
 * The7 7.8.0 patch.
 *
 * @since   7.8.0
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

class The7_DB_Patch_070701 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		if ( $this->option_exists( 'input_border_width' ) ) {
			$width     = (string) $this->get_option( 'input_border_width' );
			$width_arr = explode( ' ', $width );
			$w         = $width_arr[0];
			if ( "$w 0px 0px 0px" === $width || count( $width_arr ) === 1 ) {
				$this->set_option( 'input_border_width', "$w $w $w $w" );
			}
		}
	}
}
