<?php
/**
 * The7 less vars factory.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Vars_Factory
 */
class The7_Less_Vars_Factory implements The7_Less_Vars_Factory_Interface {

	public function __call( $name, $args ) {
		$class_name = 'The7_Less_Vars_Value_';
		$class_name .= implode( '', array_map( 'ucfirst', explode( '_', strtolower( $name ) ) ) );

		return new $class_name( isset( $args[0] ) ? $args[0] : null );
	}
}