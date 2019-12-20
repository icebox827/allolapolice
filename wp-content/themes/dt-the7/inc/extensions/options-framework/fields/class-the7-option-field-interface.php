<?php

defined( 'ABSPATH' ) || exit;

interface The7_Option_Field_Interface {

	public function html();

	public function setup( $option_name, $option, $val );

	public function need_wrap();

	public function get_value();

	public function get_option();
}