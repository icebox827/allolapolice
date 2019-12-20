<?php
/**
 * The7 less vars builder abstract.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Vars_Builder
 */
abstract class The7_Less_Vars_Builder {
	private $wrap = '%s';

	public function wrap( $wrap ) {
		if ( $wrap ) {
			$this->wrap = strval( $wrap );
		}
		return $this;
	}

	protected function get_wrapped( $val ) {
		return sprintf( $this->wrap, $val );
	}
}
