<?php
/**
 * The7 less vars manager modification for shortcode.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Vars_Shortcode_Manager
 */
class The7_Less_Vars_Shortcode_Manager extends The7_Less_Vars_Manager {

	/**
	 * Register font style less vars.
	 *
	 * @param array       $vars
	 * @param string      $value
	 * @param string|null $wrap
	 */
	public function add_font_style( $vars, $value, $wrap = null ) {
		$value = array_map( 'trim', explode( ':', $value ) );
		$defaults = array( '~""', '~""', '~""' );
		foreach ( $defaults as $i => $default ) {
			if ( empty( $value[ $i ] ) ) {
				$value[ $i ] = $default;
			}
		}

		foreach ( $vars as $i => $var ) {
			$_value = '~""';
			if ( isset( $value[ $i ] ) && ! in_array( $value[ $i ], array( 'normal', 'none' ) ) ) {
				$_value = $value[ $i ];
			}

			$this->add_keyword( $var, $_value, $wrap );
		}
	}

	/**
	 * Register less var in pixels.
	 *
	 * @param string      $var
	 * @param string      $value
	 * @param string|null $wrap
	 */
	public function add_pixel_number( $var, $value, $wrap = null ) {
		if ( '' === $value ) {
			$this->add_keyword( $var, '~""' );
		} else {
			parent::add_pixel_number( $var, $value, $wrap );
		}
	}
}