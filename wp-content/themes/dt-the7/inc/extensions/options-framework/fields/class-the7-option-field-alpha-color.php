<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Alpha_Color extends The7_Option_Field_Abstract {

	public function html() {
		$default_color = '';
		if ( isset( $this->option['std'] ) ) {
			$default_color = ' data-default-color="' . $this->option['std'] . '" ';
		}

		$field_classes = array( 'of-color', 'of-rgba-color' );

		return sprintf( '<input name="%s" id="%s" class="%s" type="text" value="%s" %s />', esc_attr( $this->option_name ), esc_attr( $this->option['id'] ), implode( ' ', $field_classes ), esc_attr( $this->val ), $default_color );
	}
}