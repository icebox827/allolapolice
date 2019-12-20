<?php
/**
 * The7 6.6.1 patch.
 *
 * @package the7
 * @since   6.6.1
 */

class The7_DB_Patch_060601 extends The7_DB_Patch {

	protected function do_apply() {
		$gradient_map = array(
			'header-elements-woocommerce_cart-counter-bg-gradient' => array(
				'angle' => '90deg',
			),
		);

		foreach ( $gradient_map as $option_name => $mutator ) {
			$gradient = $this->get_option( $option_name );
			if ( ! is_array( $gradient ) ) {
				continue;
			}

			$opacity = 100;
			if ( isset( $mutator['opacity'] ) && $this->option_exists( $mutator['opacity'] ) ) {
				$opacity = (int) $this->get_option( $mutator['opacity'] );
			}

			$angle = '135deg';
			if ( isset( $mutator['angle'] ) ) {
				$angle = $mutator['angle'];
			}

			$gradient = $this->convert_gradient_array_to_string( $gradient, $angle, $opacity );
			$this->set_option( $option_name, $gradient );
		}
	}

	/**
	 * Convert gradient value.
	 *
	 * @param string|array $gradient
	 * @param string       $angle
	 * @param int          $opacity
	 *
	 * @return string
	 */
	private function convert_gradient_array_to_string( $gradient, $angle = '135deg', $opacity = 100 ) {
		if ( ! is_array( $gradient ) || ! isset( $gradient[0], $gradient[1] ) ) {
			return (string) $gradient;
		}

		foreach ( $gradient as $i => $color ) {
			$color_obj      = new The7_Less_Vars_Value_Color( $color );
			$gradient[ $i ] = $opacity === 100 ? $color_obj->get_hex() : $color_obj->opacity( $opacity )->get_rgba();
		}

		return "{$angle}|{$gradient[0]} 30%|{$gradient[1]} 100%";
	}

}
