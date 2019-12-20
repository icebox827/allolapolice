<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Info extends The7_Option_Field_Abstract {

	/**
	 * @var bool
	 */
	protected $need_wrap = false;

	public function html() {
		$output = '';
		$id     = '';
		$class  = 'section';
		if ( isset( $this->option['id'] ) ) {
			$id = 'id="' . esc_attr( $this->option['id'] ) . '" ';
		}
		if ( isset( $this->option['type'] ) ) {
			$class .= ' section-' . $this->option['type'];
		}
		if ( isset( $this->option['class'] ) ) {
			$class .= ' ' . $this->option['class'];
		}

		$output .= '<div ' . $id . 'class="' . esc_attr( $class ) . '"><div class="info-block">';

		if ( isset( $this->option['name'] ) ) {
			$output .= '<h4 class="heading">' . esc_html( $this->option['name'] ) . '</h4>';
		}

		if ( $this->option['desc'] ) {
			$output .= '<div class="info-description">' . apply_filters( 'of_sanitize_info', $this->option['desc'] ) . '</div>';
		}

		if ( ! empty( $this->option['image'] ) ) {
			$output .= '<div class="info-image-holder"><img src="' . esc_url( $this->option['image'] ) . '" /></div>';
		}

		$output .= '</div></div>';

		return $output;
	}
}