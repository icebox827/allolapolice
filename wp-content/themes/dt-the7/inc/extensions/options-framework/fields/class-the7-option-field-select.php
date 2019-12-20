<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Select extends The7_Option_Field_Abstract {

	public function html() {
		$show_hide = empty( $this->option['show_hide'] ) ? array() : (array) $this->option['show_hide'];

		$class = 'of-input';
		if ( $show_hide ) {
			$class .= ' of-js-hider';
		}
		$output = '';
		$output .= '<select class="' . $class . '" name="' . esc_attr( $this->option_name ) . '" id="' . esc_attr( $this->option['id'] ) . '">';

		foreach ( $this->option['options'] as $option_value => $option_name ) {
			$option_class = '';
			$attr         = '';
			if ( ! empty( $show_hide[ $option_value ] ) ) {
				$option_class .= ' js-hider-show';

				if ( true !== $show_hide[ $option_value ] ) {

					if ( is_array( $show_hide[ $option_value ] ) ) {
						$data_js_target = implode( ', .', $show_hide[ $option_value ] );
					} else {
						$data_js_target = $show_hide[ $option_value ];
					}

					$attr = ' data-js-target="' . $data_js_target . '"';
				}
			}

			$selected = '';
			if ( (string) $this->val === (string) $option_value ) {
				$selected = ' selected="selected"';
			}

			$output .= '<option class="' . $option_class . '" value="' . esc_attr( $option_value ) . '"' . $selected . $attr . '>' . esc_html( $option_name ) . '</option>';
		}
		$output .= '</select>';

		return $output;
	}
}