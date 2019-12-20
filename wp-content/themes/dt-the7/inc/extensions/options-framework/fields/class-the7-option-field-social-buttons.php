<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Social_Buttons extends The7_Option_Field_Abstract {

	public function html() {
		$social_buttons = (array) apply_filters( 'optionsframework_interface-social_buttons', array() );

		if ( empty( $social_buttons ) ) {
			return '<p>Use "optionsframework_interface-social_buttons" filter to add some buttons.</p>';
		}

		$output        = '';
		$saved_buttons = isset( $this->val ) ? (array) $this->val : array();

		$output .= '<ul class="connectedSortable content-holder">';
		$output .= '<li class="ui-dt-sb-hidden"><input type="hidden" name="' . esc_attr( $this->option_name . '[]' ) . '" value="" /></li>';
		$saved_buttons = array_intersect( $saved_buttons, array_keys( $social_buttons ) );
		foreach ( $saved_buttons as $field ) {
			$output .= '<li class="ui-state-default"><input type="hidden" name="' . esc_attr( $this->option_name . '[]' ) . '" value="' . esc_attr( $field ) . '" data-name="' . esc_attr( $this->option_name . '[]' ) . '"/>' . $social_buttons[ $field ] . '</li>';
		}

		$output .= '</ul>';

		$output .= '<ul class="connectedSortable tools-palette">';

		foreach ( $social_buttons as $v => $desc ) {

			if ( in_array( $v, $saved_buttons ) ) {
				continue;
			}

			$output .= '<li class="ui-state-default"><input type="hidden" value="' . esc_attr( $v ) . '" data-name="' . esc_attr( $this->option_name . '[]' ) . '"/>' . $desc . '</li>';
		}

		$output .= '</ul>';

		return $output;
	}
}