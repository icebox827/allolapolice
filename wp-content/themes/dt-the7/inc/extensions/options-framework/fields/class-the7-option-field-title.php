<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Title extends The7_Option_Field_Abstract {

	/**
	 * @var bool
	 */
	protected $need_wrap = false;

	public function html() {
		return '<div class="of-title"><h4>' . esc_html( $this->option['name'] ) . '</h4></div>';
	}
}