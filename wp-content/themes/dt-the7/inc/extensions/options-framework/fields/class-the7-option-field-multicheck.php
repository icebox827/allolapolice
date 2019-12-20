<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Multicheck extends The7_Option_Field_Abstract {

	public function html() {
		$output = '';
		foreach ( $this->option['options'] as $key => $label ) {
			$checked    = '';
			$option_key = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $key ) );

			$id   = str_replace( array( '[', ']' ), '-', $this->option_name ) . $option_key;
			$name = $this->option_name . '[' . $option_key . ']';

			if ( isset( $this->val[ $option_key ] ) ) {
				$checked = checked( $this->val[ $option_key ], 1, false );
			}

			$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
		}

		return $output;
	}
}