<?php
/**
 * The7 Less functions.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Functions
 */
class The7_Less_Functions {

	/**
	 * Escape function.
	 *
	 * @param array $arg
	 *
	 * @return array
	 */
	public static function escape( $arg ) {
		$v = &$arg[2][1][1];
		$v = rawurlencode( $v );

		return $arg;
	}

	/**
	 * Min function.
	 *
	 * @param array $arg
	 *
	 * @return array
	 */
	public static function min( $arg ) {
		list( $type, $sp, $values ) = $arg;

		$unit = '';
		$_values = array();
		foreach ( $values as $value ) {
			$unit = $value[2];
			$_values[] = intval( $value[1] );
		}

		$min = call_user_func_array( 'min', $_values );
		return array( 'number', $min, $unit );
	}

	/**
	 * Register the7_lessc functions.
	 *
	 * @param the7_lessc|null $less
	 */
	public static function register_functions( the7_lessc $less = null ) {
		if ( $less === null ) {
			return;
		}

		$less->registerFunction( 'escape', array( __CLASS__, 'escape' ) );
		$less->registerFunction( 'min', array( __CLASS__, 'min' ) );
	}
}
