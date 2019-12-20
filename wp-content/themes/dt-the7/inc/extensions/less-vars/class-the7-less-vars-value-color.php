<?php
/**
 * The7 less vars value color.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Vars_Value_Color
 */
class The7_Less_Vars_Value_Color extends The7_Less_Vars_Builder {
	protected $default = '~""';
	protected $color;
	protected $opacity;

	public function __construct( $color = null ) {
		$this->color = null;
		$this->opacity = 1;

		if ( $color ) {
			$this->color = $this->create_color( (string) $color );
		}

		if ( is_object( $this->color ) ) {
			$this->opacity( $this->color->getOpacity() );
		}
	}

	public function opacity( $value ) {
		$this->opacity = $this->sanitize_opacity( $value );
		return $this;
	}

	public function get_opacity() {
		return $this->opacity;
	}

	public function set_default( $value ) {
		$this->default = $value;
	}

	public function get_hex() {
		if ( empty( $this->color ) ) {
			return $this->default;
		}
		return $this->get_wrapped( '#' . $this->color->getHex() );
	}

	public function get_rgb() {
		if ( empty( $this->color ) ) {
			return $this->default;
		}
		return $this->get_wrapped( 'rgb(' . implode( ',', $this->color->getRGB() ) . ')' );
	}

	public function get_rgba() {
		if ( empty( $this->color ) ) {
			return $this->default;
		}
		return $this->get_wrapped( 'rgba(' . implode( ',', $this->color->getRGB() ) . ',' . $this->opacity . ')' );
	}

	protected function sanitize_opacity( $value ) {
		$value = absint( $value );
		if ( $value > 100 ) {
			$value = 100;
		}
		return $value > 0 ? $value/100 : 0;
	}

	protected function create_color( $color ) {
		try {
			return new Color( $color );
		} catch ( Exception $e ) {
			return null;
		}
	}
}
