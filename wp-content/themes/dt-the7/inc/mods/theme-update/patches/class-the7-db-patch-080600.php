<?php
/**
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

class The7_DB_Patch_080600 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$this->migrate_menu_hamburger_padding();
		$this->migrate_menu_hemburger_colors();
		$this->migrate_menu_dividers_color();
		$this->migrate_open_and_close_menu_button_dimensions();
		$this->migrate_open_menu_colors();
		$this->migrate_close_menu_colors();

		$this->copy_option_value( 'header-menu_close_icon-bg-border-radius', 'header-menu_icon-bg-border-radius' );
		$this->copy_option_value( 'header-mobile-menu_icon-bg-hover', 'header-mobile-menu_icon-bg-enable' );
	}

	protected function migrate_menu_hamburger_padding() {
		if ( ! $this->option_exists( 'header-mobile-menu_icon-bg-size' ) ) {
			return;
		}

		if ( $this->option_exists( 'header-mobile-menu_icon-caption-padding' ) ) {
			return;
		}

		$icon_size = $this->get_option( 'header-mobile-menu_icon-size' );

		if ( ! in_array( $icon_size, array( 'small', 'medium' ) ) ) {
			return;
		}

		$delta        = $icon_size === 'small' ? 22 : 24;
		$icon_bg_size = (int) $this->get_option( 'header-mobile-menu_icon-bg-size' );
		$p            = ceil( ( $icon_bg_size - $delta ) / 2 );
		$unip         = $p . 'px';
		$vertp        = ( $p + 3 ) . 'px';

		$this->add_option( 'header-mobile-menu_icon-caption-padding', "$vertp $unip $vertp $unip" );
		$this->remove_option( 'header-mobile-menu_icon-bg-size' );
	}

	protected function migrate_menu_hemburger_colors() {
		if ( $this->option_exists( 'header-mobile-menu_icon-color' ) ) {
			$icon_color = $this->get_option( 'header-mobile-menu_icon-color' );

			$this->add_option( 'header-mobile-menu_icon-color-hover', $icon_color );
			$this->add_option( 'header-mobile-menu_icon-caption_color', $icon_color );
			$this->add_option( 'header-mobile-menu_icon-caption_color-hover', $icon_color );
		}

		$this->copy_option_value( 'header-mobile-menu_icon-bg-color-hover', 'header-mobile-menu_icon-bg-color' );
	}

	protected function migrate_menu_dividers_color() {
		if ( ! $this->option_exists( 'header-mobile-menu-font-color' ) ) {
			return;
		}

		$color_obj = new The7_Less_Vars_Value_Color( $this->get_option( 'header-mobile-menu-font-color' ) );
		$color_obj->set_default( '' );
		$color_obj->opacity( 12 );
		$rgba_color = $color_obj->get_rgba();
		if ( $rgba_color ) {
			$this->add_option( 'header-mobile-menu-dividers-color', $rgba_color );
		}
	}

	protected function migrate_open_and_close_menu_button_dimensions() {
		$icon_size = $this->get_option( 'header-menu_icon-size' );

		$padding_deltas = array(
			'small'  => 22,
			'medium' => 24,
			'large'  => 30,
		);

		if ( array_key_exists( $icon_size, $padding_deltas ) && $this->option_exists( 'header-menu_icon-bg-size' ) ) {
			$delta        = $padding_deltas[ $icon_size ];
			$icon_bg_size = (int) $this->get_option( 'header-menu_icon-bg-size' );
			$p            = ceil( ( $icon_bg_size - $delta ) / 2 );
			$unip         = $p . 'px';
			$vertp        = ( $p + 3 ) . 'px';

			$this->add_option( 'header-menu_icon-caption-padding', "$vertp $unip $vertp $unip" );
			$this->add_option( 'header-menu_close_icon-padding', "$unip $unip $unip $unip" );
			$this->remove_option( 'header-menu_icon-bg-size' );
		}

		$icon_sizes = array(
			'small'  => 'fade_small',
			'medium' => 'fade_medium',
			'large'  => 'rotate_medium',
		);

		if ( array_key_exists( $icon_size, $icon_sizes ) ) {
			$this->add_option( 'header-menu-close_icon-size', $icon_sizes[ $icon_size ] );
		}
	}

	protected function migrate_open_menu_colors() {
		if ( $this->option_exists( 'header-menu_icon-color' ) ) {
			$icon_color = $this->get_option( 'header-menu_icon-color' );

			$this->add_option( 'header-menu_icon-color-hover', $icon_color );
			$this->add_option( 'header-menu_icon-caption_color', $icon_color );
			$this->add_option( 'header-menu_icon-caption_color-hover', $icon_color );
		}

		$this->copy_option_value( 'header-menu_icon-bg-color-hover', 'header-menu_icon-bg-color' );
	}

	protected function migrate_close_menu_colors() {
		if ( $this->option_exists( 'header-menu_icon-hover-color' ) ) {
			$icon_color = $this->get_option( 'header-menu_icon-hover-color' );

			$this->add_option( 'header-menu_close_icon-caption_color', $icon_color );
			$this->add_option( 'header-menu_close_icon-caption_color-hover', $icon_color );
			$this->add_option( 'header-menu_close_icon-hover-color', $icon_color );

			$this->rename_option( 'header-menu_icon-hover-color', 'header-menu_close_icon-color' );
		}

		$this->copy_option_value( 'header-menu_close_icon-bg-color', 'header-menu_icon-hover-bg-color' );
	}
}
