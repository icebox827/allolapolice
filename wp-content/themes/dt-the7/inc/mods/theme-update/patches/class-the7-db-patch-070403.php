<?php
/**
 * The7 7.4.3 patch.
 *
 * @since   7.4.3
 * @package the7
 */

class The7_DB_Patch_070403 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		if ( ! $this->option_exists( 'general-post_back_button_url' ) ) {
			$back_page_id  = (int) $this->get_option( 'general-post_back_button_target_page_id' );
			$back_page_url = '';
			if ( $back_page_id ) {
				$back_page_url = wp_make_link_relative( get_permalink( $back_page_id ) );
			}
			$this->set_option( 'general-post_back_button_url', $back_page_url );
			$this->remove_option( 'general-post_back_button_target_page_id' );
		}
	}
}
