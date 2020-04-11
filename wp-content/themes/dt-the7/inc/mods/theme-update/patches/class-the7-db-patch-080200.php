<?php
/**
 * The7 8.2.0 patch.
 *
 * @since   8.2.0
 * @package The7\Migrations
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_DB_Patch_080200
 */
class The7_DB_Patch_080200 extends The7_DB_Patch {

	/**
	 * Main method. Apply all migrations.
	 */
	protected function do_apply() {
		$this->migrate_footer_collapse_columns_after();
		$this->migrate_top_bar_paddings_switch();
		$this->migrate_top_bar_paddings();
	}

	protected function migrate_footer_collapse_columns_after() {
		$this->copy_option_value( 'footer-collapse_columns_after', 'footer-collapse_after' );
	}

	protected function migrate_top_bar_paddings() {
		$top_bar_padding = (string) $this->get_option( 'top_bar-padding' );

		if ( ! $top_bar_padding ) {
			return;
		}

		$top_bar_padding_parts = explode( ' ', $top_bar_padding );

		if ( count( $top_bar_padding_parts ) !== 4 ) {
			return;
		}

		list( $top_bar_padding_top, $top_bar_padding_right, $top_bar_padding_bottom, $top_bar_padding_left ) = $top_bar_padding_parts;

		$header_mobile_side_paddings = explode(
			' ',
			(string) $this->get_option( 'header-mobile-second_switch-side-padding' )
		);

		if ( count( $header_mobile_side_paddings ) === 2 && ! $this->option_exists( 'top_bar_mobile_paddings' ) ) {
			list( $header_mobile_padding_left, $header_mobile_padding_right ) = $header_mobile_side_paddings;

			$this->add_option(
				'top_bar_mobile_paddings',
				"$top_bar_padding_top $header_mobile_padding_right $top_bar_padding_bottom $header_mobile_padding_left"
			);
		}

		if ( $this->option_exists( 'header-layout' ) ) {
			$header_layout        = $this->get_option( 'header-layout' );
			$header_side_paddings = $this->get_option( "header-{$header_layout}-side-padding" );
			if ( in_array( $header_layout, [ 'classic', 'inline', 'split', 'top_line' ] ) && $header_side_paddings ) {
				list( $header_left_padding, $header_right_padding ) = explode( ' ', $header_side_paddings );

				$new_top_bar_padding_right = $this->sum_paddings( $top_bar_padding_right, $header_right_padding );
				$new_top_bar_padding_left  = $this->sum_paddings( $top_bar_padding_left, $header_left_padding );

				$this->set_option(
					'top_bar-padding',
					"$top_bar_padding_top $new_top_bar_padding_right $top_bar_padding_bottom $new_top_bar_padding_left"
				);
			}
		}
	}

	protected function migrate_top_bar_paddings_switch() {
		$this->copy_option_value( 'top_bar-switch_paddings', 'header-mobile-second_switch-after' );
	}

	/**
	 * Sum paddings.
	 *
	 * @param string $a
	 * @param string $b
	 *
	 * @return string
	 */
	protected function sum_paddings( $a, $b ) {
		$a_parts = The7_Option_Field_Number::decode( $a );
		$b_parts = The7_Option_Field_Number::decode( $b );

		if ( $b_parts['units'] && $a_parts['units'] !== $b_parts['units'] ) {
			return $a;
		}

		$sum = (int) $a_parts['val'] + (int) $b_parts['val'];

		return $sum . $a_parts['units'];
	}

}
