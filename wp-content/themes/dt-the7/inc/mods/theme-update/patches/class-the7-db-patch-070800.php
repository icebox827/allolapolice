<?php
/**
 * The7 7.8.0 patch.
 *
 * @since   7.8.0
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_DB_Patch_070800
 */
class The7_DB_Patch_070800 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$typography_to_icon_size = array(
			'buttons-s-typography' => 'buttons-s-icon-size',
			'buttons-m-typography' => 'buttons-m-icon-size',
			'buttons-l-typography' => 'buttons-l-icon-size',
		);

		foreach ( $typography_to_icon_size as $typography_id => $icon_size ) {
			if ( $this->option_exists( $icon_size ) || ! $this->option_exists( $typography_id ) ) {
				continue;
			}

			$typography = $this->get_option( $typography_id );
			if ( isset( $typography['font_size'] ) ) {
				$this->set_option( $icon_size, $typography['font_size'] );
			}
		}
	}
}
