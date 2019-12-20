<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Js_Hide_Begin extends The7_Option_Field_Abstract {

	/**
	 * @var bool
	 */
	protected $need_wrap = false;

	public function html() {
		$class = 'of-js-hide';
		if ( ! isset( $this->option['hidden_by_default'] ) || $this->option['hidden_by_default'] ) {
			$class .= ' hide-if-js';
		}
		if ( ! empty( $this->option['class'] ) ) {
			$class .= ' ' . $this->option['class'];
		}

		return '<div class="' . esc_attr( $class ) . '">';
	}
}