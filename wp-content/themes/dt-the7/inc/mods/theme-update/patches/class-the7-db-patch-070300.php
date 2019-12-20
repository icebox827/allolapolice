<?php
/**
 * The7 7.3.0 patch.
 *
 * @package the7
 * @since   7.3.0
 */

class The7_DB_Patch_070300 extends The7_DB_Patch {

	/**
	 * @var array
	 */
	private static $widgets_base_settings_name = array(
		'header-elements-login',
		'header-elements-contact-phone',
		'header-elements-contact-address',
		'header-elements-contact-skype',
		'header-elements-contact-email',
		'header-elements-contact-clock',
		'header-elements-woocommerce_cart',
		'header-elements-edd_cart',
	);

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		// Order of invocation is crucial.
		$this->migrate_micro_widgets_icons_visibility();
		$this->migrate_search_micro_widget_icons();
		$this->migrate_micro_widgets_icons();
		$this->delete_redundant_options();
	}

	/**
	 * Migrate contacts, cart and login micro-widgets icons visibility options.
	 */
	private function migrate_micro_widgets_icons_visibility() {
		foreach ( self::$widgets_base_settings_name as $widget_base_settings_name ) {
			$val = $this->get_option( $widget_base_settings_name . '-icon' );
			// Prevent cascade changes when applied multiple times.
			if ( $val === null || in_array( $val, array( 'custom', 'disabled' ) ) ) {
				continue;
			}
			$this->set_option( $widget_base_settings_name . '-icon', $val === '1' ? 'custom' : 'disabled' );
		}
	}

	/**
	 * Migrate search micro-widget icons options.
	 */
	private function migrate_search_micro_widget_icons() {
		$layout              = $this->get_option( 'header-layout' );
		$widgets_icons_style = $this->get_option( "header-{$layout}-icons_style" );

		// Prevent cascade changes when applied multiple times.
		if ( $widgets_icons_style === null ) {
			return;
		}

		$search_icons_visibility_settings_names = array(
			'header-elements-search-icon' => 'header-elements-search_custom-icon',
			'microwidgets-search_icon'    => 'microwidgets-search_custom-icon',
		);
		foreach ( $search_icons_visibility_settings_names as $icons_visibility_setting_name => $custom_icon_setting_name ) {
			$icon_visibility = $this->get_option( $icons_visibility_setting_name );
			if ( $icon_visibility === null || $icon_visibility === 'default' ) {
				$custom_icon = 'the7-mw-icon-search';
				if ( $widgets_icons_style === 'bold' ) {
					$custom_icon .= '-bold';
				}
				$this->set_option( $custom_icon_setting_name, $custom_icon );
				$this->set_option( $icons_visibility_setting_name, 'custom' );
			}
		}
	}

	/**
	 * Migrate contacts, cart and login micro-widgets custom icons options.
	 */
	private function migrate_micro_widgets_icons() {
		$layout              = $this->get_option( 'header-layout' );
		$widgets_icons_style = $this->get_option( "header-{$layout}-icons_style" );

		// Prevent cascade changes when applied multiple times.
		if ( $widgets_icons_style === null ) {
			return;
		}

		$widgets_custom_icons = array(
			'header-elements-login'            => 'the7-mw-icon-login',
			'header-elements-contact-phone'    => 'the7-mw-icon-phone',
			'header-elements-contact-address'  => 'the7-mw-icon-address',
			'header-elements-contact-skype'    => 'the7-mw-icon-skype',
			'header-elements-contact-email'    => 'the7-mw-icon-mail',
			'header-elements-contact-clock'    => 'the7-mw-icon-clock',
			'header-elements-woocommerce_cart' => 'the7-mw-icon-cart',
			'header-elements-edd_cart'         => 'the7-mw-icon-cart',
		);

		foreach ( self::$widgets_base_settings_name as $widget_base_settings_name ) {
			$val = $this->get_option( $widget_base_settings_name . '-icon' );
			if ( $val === null || $val === 'disabled' ) {
				continue;
			}

			$custom_icon = $widgets_custom_icons[ $widget_base_settings_name ];
			if ( $widgets_icons_style === 'bold' ) {
				$custom_icon .= '-bold';
			}

			$this->set_option( $widget_base_settings_name . '-custom-icon', $custom_icon );
		}
	}

	/**
	 * Delete redundant options.
	 */
	protected function delete_redundant_options() {
		$layouts = array(
			'classic',
			'inline',
			'split',
			'side',
			'top_line',
			'side_line',
			'menu_icon',
		);
		foreach ( $layouts as $layout ) {
			$this->remove_option( "header-{$layout}-icons_style" );
		}
	}
}
