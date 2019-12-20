<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Password extends The7_Option_Field_Abstract {

	public function html() {
		$disabled = ( empty( $this->option['disabled'] ) ? '' : ' disabled' );

		return '<input autocomplete="new-password" id="' . esc_attr( $this->option['id'] ) . '" class="of-input" name="' . esc_attr( $this->option_name ) . '" type="password" value="' . esc_attr( $this->val ) . '"' . $disabled . '/>';
	}
}