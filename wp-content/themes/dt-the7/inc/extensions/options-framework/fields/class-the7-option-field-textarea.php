<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Textarea extends The7_Option_Field_Abstract {

	public function html() {
		$rows = '8';

		if ( isset( $this->option['settings']['rows'] ) ) {
			$custom_rows = $this->option['settings']['rows'];
			if ( is_numeric( $custom_rows ) ) {
				$rows = $custom_rows;
			}
		}

		$val = $this->val;
		if ( empty( $this->option['sanitize'] ) || 'without_sanitize' !== $this->option['sanitize'] ) {
			$val = stripslashes( $this->val );
		}

		return '<textarea id="' . esc_attr( $this->option['id'] ) . '" class="of-input" name="' . esc_attr( $this->option_name ) . '" rows="' . $rows . '">' . esc_textarea( $val ) . '</textarea>';
	}
}