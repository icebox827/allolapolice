<?php
/**
 * The7 8.1.0 patch.
 *
 * @since   8.1.0
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

class The7_DB_Patch_080100 extends The7_DB_Patch {

	/**
	 * @return array
	 */
	public function typography_options_ids() {
		return array(
			'header-classic-elements-near_menu-typography',
			'header-classic-elements-near_logo-typography',
			'header-inline-elements-near_menu-typography',
			'header-split-elements-near_menu-typography',
			'header-side-elements-near_menu-typography',
			'header-top_line-elements-in_top_line-typography',
			'header-top_line-elements-near_menu-typography',
			'header-side_line-elements-near_menu-typography',
			'header-menu_icon-elements-near_menu-typography',
			'top_bar-typography',
			'header-mobile-microwidgets-typography',
			'menu-mobile-microwidgets-typography',
			'microwidgets-search-typography',
			'header-elements-button-1-typography',
			'header-elements-button-2-typography',
			'header-menu-typography',
			'header-menu-subtitle-typography',
			'header-menu-submenu-typography',
			'header-menu-submenu-subtitle-typography',
			'header-mega-menu-title-typography',
			'header-mega-menu-desc-typography',
			'header-mobile-menu-typography',
			'header-mobile-submenu-typography',
			'filter-typography',
			'general-page-title-typography',
			'breadcrumbs-typography',
			'fonts-h1-typography',
			'fonts-h2-typography',
			'fonts-h3-typography',
			'fonts-h4-typography',
			'fonts-h5-typography',
			'fonts-h6-typography',
			'buttons-s-typography',
			'buttons-m-typography',
			'buttons-l-typography',
		);
	}

	/**
	 * @return array
	 */
	public function web_fonts_options_ids() {
		return array(
			'fonts-font_family',
		);
	}

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$this->migrate_web_fonts();
		$this->migrate_typography();
		$this->migrate_paddings();
		$this->remove_deprecated_options();
	}

	/**
	 * Migrate typography.
	 */
	protected function migrate_typography() {
		$typography_options = $this->typography_options_ids();
		foreach ( $typography_options as $option_id ) {
			if ( ! $this->option_exists( $option_id ) ) {
				continue;
			}

			$typography = $this->get_option( $option_id );
			if ( isset( $typography['font_family'] ) ) {
				$font = new The7_Web_Font( $typography['font_family'] );
				$font->set_subset( '' );
				$typography['font_family'] = (string) $font;
				$this->set_option( $option_id, $typography );
			}
		}
	}

	/**
	 * Migrate web fonts.
	 */
	protected function migrate_web_fonts() {
		$web_fonts_options = $this->web_fonts_options_ids();
		foreach ( $web_fonts_options as $option_id ) {
			if ( ! $this->option_exists( $option_id ) ) {
				continue;
			}

			$font = new The7_Web_Font( $this->get_option( $option_id ) );
			$font->set_subset( '' );
			$this->set_option( $option_id, (string) $font );
		}
	}

	protected function migrate_paddings() {
		if ( $this->option_exists( 'general-mobile_side_content_paddings' ) ) {
			$mobile_side_padding = $this->get_option( 'general-mobile_side_content_paddings' );
			$new_paddings = $this->replace_side_paddings( 'general-page_content_margin', $mobile_side_padding );
			if ( $new_paddings ) {
				$this->set_option( 'general-page_content_mobile_margin', $new_paddings );
			}
			$new_footer_paddings = $this->replace_side_paddings( 'footer-padding', $mobile_side_padding );
			if ( $new_footer_paddings ) {
				$this->set_option( 'footer-mobile_padding', $new_footer_paddings );
			}
		} else {
			$this->copy_option_value( 'general-page_content_mobile_margin', 'general-page_content_margin' );
			$this->copy_option_value( 'footer-mobile_padding', 'footer-padding' );
		}

		if ( $this->option_exists( 'general-side_content_paddings' ) ) {
			$side_padding = $this->get_option( 'general-side_content_paddings' );
			$new_paddings = $this->replace_side_paddings( 'general-page_content_margin', $side_padding );
			if ( $new_paddings ) {
				$this->set_option( 'general-page_content_margin', $new_paddings );
			}
			$new_footer_paddings = $this->replace_side_paddings( 'footer-padding', $side_padding );
			if ( $new_footer_paddings ) {
				$this->set_option( 'footer-padding', $new_footer_paddings );
			}
		}

		if ( $this->option_exists( 'header-layout' ) && $this->option_exists( 'general-side_content_paddings' ) ) {
			$side_padding = $this->get_option( 'general-side_content_paddings' );
			$header_layout = $this->get_option( 'header-layout' );
			if ( in_array( $header_layout, [ 'classic', 'inline', 'split', 'top_line' ] ) ) {
				if ( $header_layout === 'top_line' ) {
					$fullwidth_option_name = "layout-{$header_layout}-is_fullwidth";
				} else {
					$fullwidth_option_name = "header-{$header_layout}-is_fullwidth";
				}

				if ( (string) $this->get_option( $fullwidth_option_name ) !== '1' ) {
					$this->set_option( "header-{$header_layout}-side-padding", "$side_padding $side_padding" );
				}
			}
		}
	}

	protected function remove_deprecated_options() {
		$options_to_delete = array(
			'general-side_content_paddings',
			'general-mobile_side_content_paddings',
		);

		foreach ( $options_to_delete as $option ) {
			$this->remove_option( $option );
		}
	}

	/**
	 * @param string $option_name
	 * @param string $side_padding
	 *
	 * @return string
	 */
	protected function replace_side_paddings( $option_name, $side_padding ) {
		$page_margin  = explode( ' ', (string) $this->get_option( $option_name ) );
		if ( count( $page_margin ) === 4 ) {
			list( $margin_top, $margin_right, $margin_bottom, $margin_left ) = $page_margin;

			return "$margin_top $side_padding $margin_bottom $side_padding";
		}

		return '';
	}
}
