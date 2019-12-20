<?php
/**
 * The7 5.0.3 patch.
 *
 * @package the7
 * @since 5.0.3
 */

if ( ! class_exists( 'The7_DB_Patch_050003', false ) ) {

	class The7_DB_Patch_050003 extends The7_DB_Patch {

		protected function do_apply() {
			if ( $this->option_exists( 'sidebar-width' ) ) {
				$sidebar_width = $this->get_option( 'sidebar-width' );
				$sidebar_width = apply_filters( 'of_sanitize_css_width_as_percents_on_default', $sidebar_width );
				$this->set_option( 'sidebar-width', $sidebar_width );
			}
		}

	}

}
