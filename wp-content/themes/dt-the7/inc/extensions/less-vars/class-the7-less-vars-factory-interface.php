<?php
/**
 * The7 less vars factory interface.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Interface The7_Less_Vars_Factory_Interface
 */
interface The7_Less_Vars_Factory_Interface {
	public function __call( $name, $args );
}
