<?php
/**
 * The7 6.1.1 patch.
 * @package the7
 * @since   6.1.1
 */

if ( ! class_exists( 'The7_DB_Patch_060101', false ) ) {

	class The7_DB_Patch_060101 extends The7_DB_Patch {

		protected function do_apply() {
			$this->migrate_top_bar_line_in_transparent_header();
			$this->migrate_transparent_header_top_bar_color();
		}

		private function migrate_top_bar_line_in_transparent_header() {
			if ( $this->option_exists( 'top_bar-line-in-transparent-header' ) ) {
				return;
			}
			if ( ! in_array( $this->get_option( 'top_bar-bg-style' ), array(
				'fullwidth_line',
				'content_line',
			), true ) ) {
				return;
			}
			$this->set_option( 'top_bar-line-in-transparent-header', '1' );
		}

		private function migrate_transparent_header_top_bar_color() {
			if ( $this->option_exists( 'top-bar-transparent_bg_color' ) ) {
				return;
			}

			if ( 'transparent' !== $this->get_option( 'header-background' ) ) {
				return;
			}

			$color_obj = new The7_Less_Vars_Value_Color( $this->get_option( 'top_bar-bg-color' ) );
			$top_bar_with_bg = $color_obj->get_opacity() > 0;
			$top_bar_with_decoration = in_array( $this->get_option( 'top_bar-bg-style' ), array(
				'fullwidth_line',
				'content_line',
			), true );

			$opacity = '0';
			if ( $top_bar_with_bg && ! $top_bar_with_decoration ) {
				$opacity = '0.25';
			}

			$this->set_option( 'top-bar-transparent_bg_color', "rgba(255,255,255,{$opacity})" );
		}
	}

}
