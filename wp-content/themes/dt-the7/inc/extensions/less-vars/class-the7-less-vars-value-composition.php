<?php
/**
 * The7 less vars value composition.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Vars_Value_Composition
 */
class The7_Less_Vars_Value_Composition {
	protected $parts = array();

	public function __construct( $parts = null ) {
		if ( null === $parts ) {
			return;
		}
		if ( is_array( $parts ) ) {
			foreach ( $parts as $part ) {
				$this->add( $part );
			}
		} else {
			$this->add( $parts );
		}
	}

	public function add( $part ) {
		$this->parts[] = $part;
	}

	public function __call( $method, $args ) {
		$is_getter = 'get' === substr( $method, 0, 3 );
		$res = array();
		foreach ( $this->parts as $part ) {
			if ( ! is_object( $part ) ) {
				$res[] = $part;
			} else if ( is_callable( array( $part, $method ) ) ) {
				$res[] = call_user_func_array( array( $part, $method ), $args );
			}
		}

		if ( $is_getter ) {
			return $res;
		}
		return $this;
	}
}
