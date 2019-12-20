<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Square_Size extends The7_Option_Field_Abstract {

	public function html() {
		$id = esc_attr( $this->option['id'] );

		return '
			<label for="' . $id . '-width">' . _x( 'Width', 'theme-options', 'the7mk2' ) . '</label>
			<input type="text" id="' . $id . '-width" class="of-input dt-square-size" name="' . esc_attr( $this->option_name . '[width]' ) . '" value="' . absint( $this->val['width'] ) . '" />
			<span>&times;</span>
			<label for="' . $id . '-height">' . _x( 'Height', 'theme-options', 'the7mk2' ) . '</label>
			<input type="text" id="' . $id . '-height" class="of-input dt-square-size" name="' . esc_attr( $this->option_name . '[height]' ) . '" value="' . absint( $this->val['height'] ) . '" />
			';
	}
}