<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Js_Hide_End extends The7_Option_Field_Abstract {

	/**
	 * @var bool
	 */
	protected $need_wrap = false;

	public function html() {
		return '</div>';
	}
}