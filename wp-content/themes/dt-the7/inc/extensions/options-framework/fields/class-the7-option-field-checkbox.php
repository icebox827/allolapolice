<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Checkbox extends The7_Option_Field_Abstract {

	public function html() {
		$classes   = array();
		$classes[] = 'checkbox';
		$classes[] = 'of-input';
		if ( isset( $this->option['options']['java_hide'] ) && $this->option['options']['java_hide'] ) {
			$classes[] = 'of-js-hider';
		} else if ( isset( $this->option['options']['java_hide_global'] ) && $this->option['options']['java_hide_global'] ) {
			$classes[] = 'of-js-hider-global';
		}
		$classes = implode( ' ', $classes );

		return '<input id="' . esc_attr( $this->option['id'] ) . '" class="' . $classes . '" type="checkbox" name="' . esc_attr( $this->option_name ) . '" ' . checked( $this->val, 1, false ) . ' />';
	}
}