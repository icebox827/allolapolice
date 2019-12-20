<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Gradient_Color_Stop
 */
class The7_Less_Gradient_Color_Stop implements The7_Less_Gradient_Color_Stop_Interface {

	/**
	 * @var Color
	 */
	protected $color;

	/**
	 * @var int
	 */
	protected $position;

	/**
	 * The7_Less_Gradient_Color_Stop constructor.
	 *
	 * @param string $color_stop
	 */
	public function __construct( $color_stop ) {
		if ( ! $color_stop ) {
			return;
		}

		$color_stop     = str_replace( ', ', ',', $color_stop );
		$stop_parts     = explode( ' ', $color_stop );
		$this->color    = $this->create_color( $stop_parts[0] );
		$this->position = (int) $stop_parts[1];
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->get_string();
	}

	/**
	 * Return string representation of color stop.
	 *
	 * @return string
	 */
	public function get_string() {
		$color = $this->get_color_str();
		if ( ! $color ) {
			return $color;
		}

		return "{$color} {$this->position}%";
	}

	/**
	 * Set color opacity.
	 *
	 * @param mixed $val
	 *
	 * @return The7_Less_Gradient_Color_Stop $this
	 */
	public function with_opacity( $val ) {
		if ( in_array( $val, array( null, false, '' ), true )  ) {
			return $this;
		}

		$clone = clone $this;
		$clone->color = $this->create_color( $this->get_color_str( $val ) );

		return $clone;
	}

	/**
	 * Return color string.
	 *
	 * @return string
	 */
	public function get_color() {
		return $this->get_color_str();
	}

	/**
	 * Return color string. Opacity can be set.
	 *
	 * @param int|null $opacity
	 *
	 * @return string
	 */
	protected function get_color_str( $opacity = null ) {
		if ( $this->color === null ) {
			return '';
		}

		if ( $opacity === null ) {
			$opacity = $this->color->getOpacity();
		}

		$opacity = (int) $opacity;

		if ( $opacity === 100 ) {
			$color = '#' . $this->color->getHex();
		} else {
			$color = 'rgba(' . implode( ',', $this->color->getRgb() ) . ',' . ( $opacity * 0.01 ) . ')';
		}

		return $color;
	}

	/**
	 * Return new Color instance.
	 *
	 * @param string $str
	 *
	 * @return Color
	 */
	protected function create_color( $str ) {
		return new Color( $str );
	}

}