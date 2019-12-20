<?php
/**
 * The7 less gradient class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Gradient
 */
class The7_Less_Gradient {

	/**
	 * @var array
	 */
	protected $color_stops = array();

	/**
	 * @var string
	 */
	protected $angle = '';

	/**
	 * The7_Less_Gradient constructor.
	 *
	 * @param string $gradient
	 */
	public function __construct( $gradient ) {
		if ( ! $gradient ) {
			return;
		}

		$grad_parts  = explode( '|', $gradient );
		$this->angle = array_shift( $grad_parts );

		foreach ( $grad_parts as $color_stop ) {
			$this->color_stops[] = $this->new_color_stop( $color_stop );
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->get_string();
	}

	/**
	 * Return string representation of gradient.
	 *
	 * @return string
	 */
	public function get_string() {
		if ( empty( $this->color_stops ) ) {
			return '';
		}

		return $this->angle . ', ' . implode( ', ', $this->color_stops );
	}

	/**
	 * Return $pos color stop.
	 *
	 * @param int $pos
	 *
	 * @return The7_Less_Gradient_Color_Stop_Interface
	 */
	public function get_color_stop( $pos ) {
		-- $pos;

		return array_key_exists( $pos, $this->color_stops ) ? $this->color_stops[ $pos ] : $this->new_color_stop( '' );
	}

	/**
	 * Return the last color stop.
	 *
	 * @return The7_Less_Gradient_Color_Stop
	 */
	public function get_last_color_stop() {
		reset( $this->color_stops );
		$last_color_stop = end( $this->color_stops );

		return $last_color_stop ? $last_color_stop : $this->new_color_stop( '' );
	}

	/**
	 * Set gradient opacity.
	 *
	 * @param mixed $val
	 *
	 * @return The7_Less_Gradient $this
	 */
	public function with_opacity( $val ) {
		if ( in_array( $val, array( null, false, '' ), true )  ) {
			return $this;
		}

		$clone = clone $this;
		$clone->color_stops = array();

		foreach ( $this->color_stops as $color_stop ) {
			$clone->color_stops[] = $color_stop->with_opacity( $val );
		}

		return $clone;
	}

	/**
	 * Set gradient angle.
	 *
	 * @param string $angle
	 *
	 * @return The7_Less_Gradient $this
	 */
	public function with_angle( $angle ) {
		if ( in_array( $angle, array( null, false, '' ), true )  ) {
			return $this;
		}

		$clone = clone $this;
		$clone->angle = $angle;

		return $clone;
	}

	/**
	 * Create new color stop object.
	 *
	 * @param string $str
	 *
	 * @return The7_Less_Gradient_Color_Stop
	 */
	protected function new_color_stop( $str ) {
		return new The7_Less_Gradient_Color_Stop( $str );
	}

}