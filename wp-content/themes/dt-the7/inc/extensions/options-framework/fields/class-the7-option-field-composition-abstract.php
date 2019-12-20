<?php

defined( 'ABSPATH' ) || exit;

abstract class The7_Option_Field_Composition_Abstract extends The7_Option_Field_Abstract implements The7_Option_Field_Composition_Interface {
	/**
	 * @var The7_Options_Interface
	 */
	protected $interface;

	public function with_interface( The7_Options_Interface $interface ) {
		$this->interface = $interface;
	}
}