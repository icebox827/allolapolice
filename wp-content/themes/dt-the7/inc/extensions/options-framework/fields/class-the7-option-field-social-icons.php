<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Social_Icons extends The7_Option_Field_Abstract {

	public function html() {
		$output = '';
		if ( isset( $this->option['options'] ) && is_array( $this->option['options'] ) ) {
			foreach ( $this->option['options'] as $class => $desc ) {
				$name = sprintf( '%s[%s]', $this->option_name, $class );
				$link = isset( $this->val[ $class ] ) ? $this->val[ $class ] : '';

				$maxlength = isset( $this->option['maxlength'] ) ? ' maxlength="' . $this->option['maxlength'] . '"' : '';
				$output    .= '<label>' . esc_html( $desc ) . '<input class="of-input" name="' . esc_attr( $name ) . '" type="text" value="' . esc_url( $link ) . '"' . $maxlength . '/></label>';
			}
		}

		return $output;
	}
}