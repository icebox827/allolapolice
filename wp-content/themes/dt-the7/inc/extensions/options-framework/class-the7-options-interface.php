<?php

defined( 'ABSPATH' ) || exit;

interface The7_Options_Interface {

	/**
	 * @param string $option_name
	 * @param array  $option
	 * @param array  $settings
	 *
	 * @return mixed
	 */
	public function get_field_object( $option_name, $option, $settings );

	/**
	 * @param The7_Option_Field_Interface $option_obj
	 *
	 * @return string
	 */
	public function wrap_option( The7_Option_Field_Interface $option_obj );
}