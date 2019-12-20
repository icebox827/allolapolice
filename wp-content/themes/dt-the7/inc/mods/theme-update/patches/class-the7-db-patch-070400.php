<?php
/**
 * The7 7.4.0 patch.
 *
 * @package the7
 * @since   7.4.0
 */

class The7_DB_Patch_070400 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$this->migrate_micro_widgets_in_mobile_menu_options();

		if ( ! $this->option_exists( 'bottom_bar-menu-collapse_after' ) ) {
			$this->copy_option_value( 'bottom_bar-menu-collapse_after', 'bottom_bar-collapse_after' );
		}

		$uppercase_options = array(
			'fonts-h1_uppercase'                        => 'fonts-h1_text_transform',
			'fonts-h2_uppercase'                        => 'fonts-h2_text_transform',
			'fonts-h3_uppercase'                        => 'fonts-h3_text_transform',
			'fonts-h4_uppercase'                        => 'fonts-h4_text_transform',
			'fonts-h5_uppercase'                        => 'fonts-h5_text_transform',
			'fonts-h6_uppercase'                        => 'fonts-h6_text_transform',
			'general-title_uppercase'                   => 'general-title_text_transform',
			'general-breadcrumbs_uppercase'             => 'general-breadcrumbs_text_transform',
			'general-filter_ucase'                      => 'general-filter_text_transform',
			'buttons-s_uppercase'                       => 'buttons-s_text_transform',
			'buttons-m_uppercase'                       => 'buttons-m_text_transform',
			'buttons-l_uppercase'                       => 'buttons-l_text_transform',
			'top_bar-font-is_capitalized'               => 'top_bar-font-text_transform',
			'header-menu-font-is_capitalized'           => 'header-menu-font-text_transform',
			'header-menu-submenu-font-is_uppercase'     => 'header-menu-submenu-font-text_transform',
			'header-mobile-menu-font-is_capitalized'    => 'header-mobile-menu-font-text_transform',
			'header-mobile-submenu-font-is_capitalized' => 'header-mobile-submenu-font-text_transform',
		);

		foreach ( $uppercase_options as $old_option => $new_option ) {
			// Prevent multiple apply.
			if ( ! $this->option_exists( $new_option ) ) {
				$old_value = $this->get_option( $old_option );
				$new_value = (int) $old_value ? 'uppercase' : 'none';
				$this->rename_option( $old_option, $new_option );
				$this->set_option( $new_option, $new_value );
			}
		}
	}

	/**
	 * Migrate micro-widgets in mobile menu options.
	 */
	protected function migrate_micro_widgets_in_mobile_menu_options() {
		$options_to_copy = array(
			'header-mobile-submenu-font-family' => 'menu-mobile-microwidgets-font-family',
			'header-mobile-submenu-font-size'   => 'menu-mobile-microwidgets-font-size',
			'header-mobile-menu-font-color'     => 'menu-mobile-microwidgets-font-color',
		);
		foreach ( $options_to_copy as $origin_option => $copy_to_option ) {
			if ( ! $this->option_exists( $copy_to_option ) ) {
				$this->copy_option_value( $copy_to_option, $origin_option );
			}
		}
	}
}
