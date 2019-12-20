<?php
/**
 * The7 options text field class.
 *
 * @package The7\Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Option_Field_Text
 */
class The7_Option_Field_Text extends The7_Option_Field_Abstract {

	/**
	 * Return field HTML.
	 *
	 * @return string
	 */
	public function html() {
		$disabled    = empty( $this->option['disabled'] ) ? '' : ' disabled';
		$placeholder = empty( $this->option['placeholder'] ) ? '' : sprintf( ' placeholder="%s"', esc_attr( $this->option['placeholder'] ) );

		return '<input id="' . esc_attr( $this->option['id'] ) . '" class="of-input" name="' . esc_attr( $this->option_name ) . '" type="text" value="' . esc_attr( $this->val ) . '"' . $disabled . $placeholder . '/>';
	}
}
