<?php
/**
 * The7 8.0.0 patch.
 *
 * @since   8.0.0
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_DB_Patch_080000
 */
class The7_DB_Patch_080000 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		if ( $this->option_exists( 'general-mobile_side_content_paddings' ) ) {
			$side_padding = $this->get_option( 'general-mobile_side_content_paddings' );

			$this->migrate_page_margins( $side_padding );
			$this->migrate_header_margin( $side_padding );
			$this->migrate_footer_padding( $side_padding );
			$this->migrate_mobile_header_padding( $side_padding );
		}

		if ( $this->option_exists( 'top_bar-padding' ) ) {
			$this->migrate_top_bar_padding();
		}
	}

	protected function migrate_page_margins( $side_padding ) {
		if ( ! $this->option_exists( 'general-page_content_margin' ) ) {
			return;
		}

		$page_margin = explode( ' ', (string) $this->get_option( 'general-page_content_margin' ) );
		if ( count( $page_margin ) === 2 ) {
			list( $margin_top, $margin_bottom ) = $page_margin;
			$new_page_margin = "$margin_top $side_padding $margin_bottom $side_padding";
			$this->set_option( 'general-page_content_margin', $new_page_margin );
		}
	}

	protected function migrate_header_margin( $side_padding ) {
		if ( ! $this->option_exists( 'header-layout' ) ) {
			return;
		}

		$header_layout = $this->get_option( 'header-layout' );
		if ( in_array( $header_layout, [ 'classic', 'inline', 'split', 'top_line' ] ) ) {
			if ( $header_layout === 'top_line' ) {
				$fullwidth_option_name = "layout-{$header_layout}-is_fullwidth";
			} else {
				$fullwidth_option_name = "header-{$header_layout}-is_fullwidth";
			}

			if ( (string) $this->get_option( $fullwidth_option_name ) === '1' ) {
				$menu_margin = '0px 0px';
			} else {
				$menu_margin = "$side_padding $side_padding";
			}
			$this->add_option( "header-{$header_layout}-side-padding", $menu_margin );
		}
	}

	protected function migrate_footer_padding( $side_padding ) {
		if ( ! $this->option_exists( 'footer-padding' ) ) {
			return;
		}

		$footer_padding = explode( ' ', (string) $this->get_option( 'footer-padding' ) );
		if ( count( $footer_padding ) === 2 ) {
			list( $padding_top, $padding_bottom ) = $footer_padding;
			$this->set_option( 'footer-padding', "$padding_top $side_padding $padding_bottom $side_padding" );
		}
	}

	protected function migrate_mobile_header_padding( $side_padding ) {
		if ( $this->option_exists( 'header-mobile-first_switch-after' ) ) {
			$this->add_option( 'header-mobile-first_switch-side-padding', "$side_padding $side_padding" );
		}

		if ( $this->option_exists( 'header-mobile-second_switch-after' ) ) {
			$this->add_option( 'header-mobile-second_switch-side-padding', "$side_padding $side_padding" );
		}
	}

	protected function migrate_top_bar_padding() {
		$padding = explode( ' ', (string) $this->get_option( 'top_bar-padding' ) );
		if ( count( $padding ) === 3 ) {
			list( $top, $bottom, $side ) = $padding;
			$this->set_option( 'top_bar-padding', "$top $side $bottom $side" );
		}
	}
}
