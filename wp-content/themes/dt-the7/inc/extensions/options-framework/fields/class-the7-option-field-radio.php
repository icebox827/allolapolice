<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Radio extends The7_Option_Field_Abstract {

	public function html() {
		$output = '';

		$wrap_class = 'controls-input-wrap';
		if ( empty( $this->option['style'] ) || 'horizontal' === $this->option['style'] ) {
			$wrap_class .= ' inline-input-wrap';
		} else if ( 'vertical' === $this->option['style'] ) {
			$wrap_class .= ' block-input-wrap';
		}

		$show_hide = empty( $this->option['show_hide'] ) ? array() : (array) $this->option['show_hide'];
		$classes   = array( 'of-input', 'of-radio' );

		if ( ! empty( $show_hide ) ) {
			$classes[] = 'of-js-hider';
		}

		foreach ( $this->option['options'] as $key => $caption ) {
			$id            = str_replace( array( '[', ']' ), '-', $this->option_name ) . $key;
			$input_classes = $classes;
			$attr          = '';

			if ( ! empty( $show_hide[ $key ] ) ) {
				$input_classes[] = 'js-hider-show';

				if ( true !== $show_hide[ $key ] ) {

					if ( is_array( $show_hide[ $key ] ) ) {
						$data_js_target = implode( ', .', $show_hide[ $key ] );
					} else {
						$data_js_target = $show_hide[ $key ];
					}

					$attr = ' data-js-target="' . $data_js_target . '"';
				}
			}

			$output .= '<div class="' . $wrap_class . '">' . '<input class="' . esc_attr( implode( ' ', $input_classes ) ) . '"' . $attr . ' type="radio" name="' . esc_attr( $this->option_name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $key ) . '" ' . checked( $this->val, $key, false ) . ' />' . '<label for="' . esc_attr( $id ) . '">' . esc_html( $caption ) . '</label>' . '</div>';
		}

		return $output;
	}
}