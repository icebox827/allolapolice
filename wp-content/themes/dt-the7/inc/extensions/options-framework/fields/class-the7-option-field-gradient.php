<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Gradient extends The7_Option_Field_Abstract {

	public function html() {
		$default_color_1 = '';
		$default_color_2 = '';
		$val             = wp_parse_args( (array) $this->val, array( '', '' ) );

		if ( isset( $this->option['std'][0] ) && $val[0] !== $this->option['std'][0] ) {
			$default_color_1 = ' data-default-color="' . $this->option['std'][0] . '" ';
		}

		if ( isset( $this->option['std'][1] ) && $val[1] !== $this->option['std'][1] ) {
			$default_color_2 = ' data-default-color="' . $this->option['std'][1] . '" ';
		}

		$output = '';
		$output .= '<input name="' . esc_attr( $this->option_name . '[0]' ) . '" id="' . esc_attr( $this->option['id'] ) . '-0" class="of-color of-hex-color"  type="text" value="' . esc_attr( $val[0] ) . '"' . $default_color_1 . ' />';

		$output .= '&nbsp;';

		$output .= '<input name="' . esc_attr( $this->option_name . '[1]' ) . '" id="' . esc_attr( $this->option['id'] ) . '-1" class="of-color of-hex-color"  type="text" value="' . esc_attr( $val[1] ) . '"' . $default_color_2 . ' />';

		return $output;
	}
}