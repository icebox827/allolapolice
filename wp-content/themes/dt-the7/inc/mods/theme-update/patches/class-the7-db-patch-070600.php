<?php
/**
 * The7 7.6.0 patch.
 *
 * @since   7.6.0
 * @package The7/Updater/Migrations
 */

defined( 'ABSPATH' ) || exit;

class The7_DB_Patch_070600 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$typography_fields = array(
			'font_family',
			'font_size',
			'line_height',
			'text_transform',
		);
		for ( $i = 1; $i <= 6; $i ++ ) {
			if ( ! $this->option_exists( "fonts-h{$i}-typography" ) ) {
				$new_typography_value = array();
				foreach ( $typography_fields as $typography_field ) {
					$new_typography_value[ $typography_field ] = $this->get_option( "fonts-h{$i}_{$typography_field}" );
					$this->remove_option( "fonts-h{$i}_{$typography_field}" );
				}
				$new_typography_value = array_filter( $new_typography_value );
				if ( $new_typography_value ) {
					$this->set_option( "fonts-h{$i}-typography", $new_typography_value );
				}
			}
		}

		$fonts_migration_data = array(
			'general-page-title-typography'                => array(
				'font_family'    => 'general-font_family',
				'font_size'      => 'general-title_size',
				'line_height'    => 'general-title_line_height',
				'text_transform' => 'general-title_text_transform',
			),
			'filter-typography'                            => array(
				'font_family'    => 'general-filter-font-family',
				'font_size'      => 'general-filter-font-size',
				'text_transform' => 'general-filter_text_transform',
			),
			'breadcrumbs-typography'                       => array(
				'font_family'    => 'general-breadcrumbs_font_family',
				'font_size'      => 'general-breadcrumbs_font_size',
				'line_height'    => 'general-breadcrumbs_line_height',
				'text_transform' => 'general-breadcrumbs_text_transform',
			),
			'top_bar-typography'                           => array(
				'font_family'    => 'top_bar-font-family',
				'font_size'      => 'top_bar-font-size',
				'text_transform' => 'top_bar-font-text_transform',
			),
			'header-mobile-microwidgets-typography'        => array(
				'font_family' => 'header-mobile-microwidgets-font-family',
				'font_size'   => 'header-mobile-microwidgets-font-size',
			),
			'menu-mobile-microwidgets-typography'          => array(
				'font_family' => 'menu-mobile-microwidgets-font-family',
				'font_size'   => 'menu-mobile-microwidgets-font-size',
			),
			'header-menu-typography'                       => array(
				'font_family'    => 'header-menu-font-family',
				'font_size'      => 'header-menu-font-size',
				'text_transform' => 'header-menu-font-text_transform',
			),
			'header-menu-subtitle-typography'              => array(
				'font_family' => 'header-menu-subtitle-font-family',
				'font_size'   => 'header-menu-subtitle-font-size',
			),
			'header-menu-submenu-typography'               => array(
				'font_family'    => 'header-menu-submenu-font-family',
				'font_size'      => 'header-menu-submenu-font-size',
				'text_transform' => 'header-menu-submenu-font-text_transform',
			),
			'header-menu-submenu-subtitle-typography'      => array(
				'font_family' => 'header-menu-submenu-subtitle-font-family',
				'font_size'   => 'header-menu-submenu-subtitle-font-size',
			),
			'header-mobile-menu-typography'                => array(
				'font_family'    => 'header-mobile-menu-font-family',
				'font_size'      => 'header-mobile-menu-font-size',
				'text_transform' => 'header-mobile-menu-font-text_transform',
			),
			'header-mobile-submenu-typography'             => array(
				'font_family'    => 'header-mobile-submenu-font-family',
				'font_size'      => 'header-mobile-submenu-font-size',
				'text_transform' => 'header-mobile-submenu-font-text_transform',
			),
			'header-classic-elements-near_menu-typography' => array(
				'font_family' => 'header-classic-elements-near_menu-font_family',
				'font_size'   => 'header-classic-elements-near_menu-font_size',
			),
			'header-classic-elements-near_logo-typography' => array(
				'font_family' => 'header-classic-elements-near_logo-font_family',
				'font_size'   => 'header-classic-elements-near_logo-font_size',
			),
			'header-inline-elements-near_menu-typography'  => array(
				'font_family' => 'header-inline-elements-near_menu-font_family',
				'font_size'   => 'header-inline-elements-near_menu-font_size',
			),
			'header-split-elements-near_menu-typography'   => array(
				'font_family' => 'header-split-elements-near_menu-font_family',
				'font_size'   => 'header-split-elements-near_menu-font_size',
			),
			'header-side-elements-near_menu-typography'    => array(
				'font_family' => 'header-side-elements-near_menu-font_family',
				'font_size'   => 'header-side-elements-near_menu-font_size',
			),
			'header-top_line-elements-near_menu-typography' => array(
				'font_family' => 'header-top_line-elements-near_menu-font_family',
				'font_size'   => 'header-top_line-elements-near_menu-font_size',
			),
			'header-classic-elements-in_top_line-typography' => array(
				'font_family' => 'header-classic-elements-in_top_line-font_family',
				'font_size'   => 'header-classic-elements-in_top_line-font_size',
			),
			'header-side_line-elements-near_menu-typography' => array(
				'font_family' => 'header-side_line-elements-near_menu-font_family',
				'font_size'   => 'header-side_line-elements-near_menu-font_size',
			),
			'header-menu_icon-elements-near_menu-typography' => array(
				'font_family' => 'header-menu_icon-elements-near_menu-font_family',
				'font_size'   => 'header-menu_icon-elements-near_menu-font_size',
			),
			'buttons-s-typography'                         => array(
				'font_family'    => 'buttons-s_font_family',
				'font_size'      => 'buttons-s_font_size',
				'text_transform' => 'buttons-s_text_transform',
			),
			'buttons-m-typography'                         => array(
				'font_family'    => 'buttons-m_font_family',
				'font_size'      => 'buttons-m_font_size',
				'text_transform' => 'buttons-m_text_transform',
			),
			'buttons-l-typography'                         => array(
				'font_family'    => 'buttons-l_font_family',
				'font_size'      => 'buttons-l_font_size',
				'text_transform' => 'buttons-l_text_transform',
			),
			'microwidgets-search-typography'               => array(
				'font_family' => 'microwidgets-search_font-family',
				'font_size'   => 'microwidgets-search_font-size',
			),
			'header-elements-button-1-typography'          => array(
				'font_family' => 'header-elements-button-1-font-family',
				'font_size'   => 'header-elements-button-1-font-size',
			),
			'header-elements-button-2-typography'          => array(
				'font_family' => 'header-elements-button-2-font-family',
				'font_size'   => 'header-elements-button-2-font-size',
			),
		);
		foreach ( $fonts_migration_data as $new_typography_option => $value_map ) {
			if ( ! $this->option_exists( $new_typography_option ) ) {
				$new_typography_value = array();
				foreach ( $value_map as $value_key => $old_option ) {
					$new_typography_value[ $value_key ] = $this->get_option( $old_option );
					$this->remove_option( $old_option );
				}
				$new_typography_value = array_filter( $new_typography_value );
				if ( $new_typography_value ) {
					$this->set_option( $new_typography_option, $new_typography_value );
				}
			}
		}

		$this->migrate_submenu_settings();
	}

	/**
	 * Migrate cart submenu settings.
	 */
	protected function migrate_submenu_settings() {
		$this->copy_option_value( 'header-elements-woocommerce_cart-sub_cart-bg-width', 'header-menu-submenu-bg-width' );
		$this->copy_option_value( 'header-elements-edd_cart-sub_cart-bg-width', 'header-menu-submenu-bg-width' );
		$this->copy_option_value( 'header-elements-woocommerce_cart-sub_cart-bg-color', 'header-menu-submenu-bg-color' );
		$this->copy_option_value( 'header-elements-edd_cart-sub_cart-bg-color', 'header-menu-submenu-bg-color' );
		$this->copy_option_value( 'header-elements-woocommerce_cart-sub_cart-font-color', 'header-menu-submenu-font-color' );
		$this->copy_option_value( 'header-elements-edd_cart-sub_cart-font-color', 'header-menu-submenu-font-color' );
		$this->copy_option_value( 'header-mega-menu-title-font-color', 'header-menu-submenu-font-color' );
		$this->copy_option_value( 'header-mega-menu-desc-font-color', 'header-menu-submenu-font-color' );
		$this->copy_option_value( 'header-mega-menu-widget-font-color', 'header-menu-submenu-font-color' );
		$this->copy_option_value( 'header-mega-menu-widget-title-color', 'header-menu-submenu-font-color' );

		// Migrate active and hover colors if title font is set.
		if ( $this->option_exists( 'header-mega-menu-title-font-color' ) ) {
			$this->add_option( 'header-mega-menu-title-active_item-font-color-style', 'accent' );
			$this->add_option( 'header-mega-menu-title-hover-font-color-style', 'accent' );
			$this->add_option( 'header-mega-menu-widget-accent-color', '' );
		}

		if ( $this->option_exists( 'fonts-h5-typography' ) ) {
			$h5_typography = $this->get_option( 'fonts-h5-typography' );
			if ( isset( $h5_typography['font_size'] ) ) {
				$this->add_option( 'header-mega-menu-title-icon-size', $h5_typography['font_size'] );
			}
			$mm_title_typography                   = $h5_typography;
			$mm_title_typography['text_transform'] = 'none';
			unset( $mm_title_typography['line_height'] );
			$this->add_option( 'header-mega-menu-title-typography', $mm_title_typography );
		}

		if ( $this->option_exists( 'fonts-font_family' ) && $this->option_exists( 'fonts-small_size' ) ) {
			$this->add_option(
				'header-mega-menu-desc-typography',
				array(
					'font_family' => $this->get_option( 'fonts-font_family' ),
					'font_size'   => $this->get_option( 'fonts-small_size' ),
				)
			);
		}
	}
}
