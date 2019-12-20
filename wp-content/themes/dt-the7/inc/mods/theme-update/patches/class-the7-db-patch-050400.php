<?php
/**
 * The7 5.4.0 patch.
 *
 * @package the7
 * @since 5.4.0
 */

if ( ! class_exists( 'The7_DB_Patch_050400', false ) ) {

	class The7_DB_Patch_050400 extends The7_DB_Patch {

		protected function do_apply() {
			// Icons micro widget.
			if ( 'outline' === $this->get_option( 'header-elements-soc_icons-bg' ) ) {
				$this->set_option( 'header-elements-soc_icons-bg', 'disabled' );
				$this->set_option( 'header-elements-soc_icons-border', 'color' );
				$this->set_option( 'header-elements-soc_icons-border-color', $this->get_option( 'header-elements-soc_icons-bg-color' ) );
				$this->set_option( 'header-elements-soc_icons-border-opacity',  '100'  );
			} elseif ( ! $this->option_exists( 'header-elements-soc_icons-border' ) ) {
				$this->set_option( 'header-elements-soc_icons-border', 'disabled' );
			}

			if ( 'outline' === $this->get_option( 'header-elements-soc_icons-hover-bg' ) ) {
				$this->set_option( 'header-elements-soc_icons-hover-bg', 'disabled' );
				$this->set_option( 'header-elements-soc_icons-hover-border', 'color' );
				$this->set_option( 'header-elements-soc_icons-hover-border-color', $this->get_option( 'header-elements-soc_icons-hover-bg-color' ) );
				$this->set_option( 'header-elements-soc_icons-hover-border-color-opacity',  '100');
			} elseif ( ! $this->option_exists( 'header-elements-soc_icons-hover-border' ) ) {
				$this->set_option( 'header-elements-soc_icons-hover-border', 'disabled' );
			}
		}
	}

}
