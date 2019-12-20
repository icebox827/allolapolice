<?php
/**
 * The7 less vars number class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Vars_Value_Number
 */
class The7_Less_Vars_Value_Number extends The7_Less_Vars_Builder {
	protected $val;
	protected $suffix;

	public function __construct( $val = 0 ) {
		$this->val = 0;
		$this->suffix = '';

		preg_match( '/([-0-9]*)(.*)/', $val, $matches );
		if ( ! empty( $matches[1] ) ) {
			$this->val = intval( $matches[1] );
		}

		if ( ! empty( $matches[2] ) ) {
			$this->suffix = $matches[2];
		}
	}

	public function get() {
		return $this->get_wrapped( $this->val . $this->suffix );
	}

	public function get_units() {
		return $this->suffix;
	}

	public function get_val() {
		return $this->val;
	}

	public function get_percents() {
		return $this->get_wrapped( $this->val . '%' );
	}

	public function get_pixels() {
		return $this->get_wrapped( $this->val . 'px' );
	}
}
