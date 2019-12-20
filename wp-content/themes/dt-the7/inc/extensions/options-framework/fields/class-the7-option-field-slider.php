<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Slider extends The7_Option_Field_Abstract {

	public function html() {
		$classes = array( 'of-slider' );

		if ( ! empty( $this->option['options']['java_hide_if_not_max'] ) ) {
			$classes[] = 'of-js-hider';
			$classes[] = 'js-hide-if-not-max';
		} else if ( ! empty( $this->option['options']['java_hide_global_not_max'] ) ) {
			$classes[] = 'of-js-hider-global';
			$classes[] = 'js-hide-if-not-max';
		}
		$classes = implode( ' ', $classes );

		$output = '<div class="' . $classes . '"></div>';

		$slider_opts = array(
			'max'   => isset( $this->option['options']['max'] ) ? (int) $this->option['options']['max'] : 100,
			'min'   => isset( $this->option['options']['min'] ) ? (int) $this->option['options']['min'] : 0,
			'step'  => isset( $this->option['options']['step'] ) ? (int) $this->option['options']['step'] : 1,
			'value' => isset( $this->val ) ? (int) $this->val : 100,
		);
		$str         = '';
		foreach ( $slider_opts as $name => $opt_val ) {
			$str .= ' data-' . $name . '="' . esc_attr( $opt_val ) . '"';
		}

		$output .= '<input type="text" class="of-slider-value"' . $str . ' name="' . esc_attr( $this->option_name ) . '" value="' . $slider_opts['value'] . '"/>';

		return $output;
	}
}