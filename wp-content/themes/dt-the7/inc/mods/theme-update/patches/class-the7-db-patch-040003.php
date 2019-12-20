<?php
/**
 * The7 4.0.3 patch.
 *
 * @package the7
 * @since 4.0.3
 */

if ( ! class_exists( 'The7_DB_Patch_040003', false ) ) {

	class The7_DB_Patch_040003 extends The7_DB_Patch {

		protected function do_apply() {
			if ( $this->option_exists( 'general-page_content_vertical_margins' ) ) {
				$vertical_margins = $this->get_option( 'general-page_content_vertical_margins' );
				$this->set_option( 'general-page_content_top_margin', $vertical_margins );
				$this->set_option( 'general-page_content_bottom_margin', $vertical_margins );
				$this->remove_option( 'general-page_content_vertical_margins' );
			}
		}

	}

}
