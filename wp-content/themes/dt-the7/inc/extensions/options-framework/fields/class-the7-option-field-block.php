<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Block extends The7_Option_Field_Abstract implements The7_Option_Field_Container_Interface {

	protected $need_wrap = false;

	public function html() {
		$output = '';
		$class  = 'section';
		$id     = '';
		if ( isset( $this->option['type'] ) ) {
			$class .= ' section-' . $this->option['type'];
		}
		if ( isset( $this->option['class'] ) ) {
			$class .= ' ' . $this->option['class'];
		}
		if ( isset( $this->option['id'] ) ) {
			$id .= ' id="' . esc_attr( $this->option['id'] ) . '"';
		}
		$output .= '<div' . $id . ' class="postbox ' . esc_attr( $class ) . '">' . "\n";
		if ( isset( $this->option['name'] ) && ! empty( $this->option['name'] ) ) {
			$output .= '<h3>' . esc_html( $this->option['name'] ) . '</h3>' . "\n";
		}

		return $output;
	}

	public function closing_tag() {
		return '</div><!-- block -->';
	}
}
