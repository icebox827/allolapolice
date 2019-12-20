<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Code_Editor extends The7_Option_Field_Abstract {

	public function html() {
		$rows = '8';

		if ( isset( $this->option['settings']['rows'] ) ) {
			$custom_rows = $this->option['settings']['rows'];
			if ( is_numeric( $custom_rows ) ) {
				$rows = $custom_rows;
			}
		}

		$code_style = isset( $this->option['settings']['code_style'] ) ? $this->option['settings']['code_style'] : 'text/html';
		$field_id   = esc_attr( $this->option['id'] );

		return '<textarea id="' . $field_id . '" class="of-input code-editor" name="' . esc_attr( $this->option_name ) . '" rows="' . $rows . '" data-code-style="' . esc_attr( $code_style ) . '">' . esc_textarea( $this->val ) . '</textarea>';
	}
}