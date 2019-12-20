<?php
/**
 * 1.18.0 theme options migration.
 *
 * @since   1.18.0
 * @package The7pt/Migrations
 */

class The7pt_Options_Migration_1_18_0 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$back_buttons_to_migrate = array(
			'general-project_back_button_target_page_id' => 'general-project_back_button_url',
			'general-album_back_button_target_page_id'   => 'general-album_back_button_url',
		);
		foreach ( $back_buttons_to_migrate as $old_option => $new_option ) {
			if ( ! $this->option_exists( $new_option ) ) {
				$back_page_id  = (int) $this->get_option( $old_option );
				$back_page_url = '';
				if ( $back_page_id ) {
					$back_page_url = wp_make_link_relative( get_permalink( $back_page_id ) );
				}
				$this->set_option( $new_option, $back_page_url );
				$this->remove_option( $old_option );
			}
		}
	}

}