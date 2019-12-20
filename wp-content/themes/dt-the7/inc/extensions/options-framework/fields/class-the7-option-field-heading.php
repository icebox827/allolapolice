<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Heading extends The7_Option_Field_Abstract implements The7_Option_Field_Container_Interface {

	/**
	 * @var bool
	 */
	protected $need_wrap = false;

	public function html() {
		$output = '';
		$class  = ! empty( $this->option['id'] ) ? $this->option['id'] : $this->option['name'];
		$class  = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $class ) );
		$output .= '<div id="' . $class . '-group" class="group ' . $class . '">';

		return $output;
	}

	public function closing_tag() {
		return '</div><!-- heading -->';
	}
}
