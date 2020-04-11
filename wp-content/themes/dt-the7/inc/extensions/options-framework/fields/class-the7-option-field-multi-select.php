<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Multi_Select extends The7_Option_Field_Abstract {

	public function html() {
		$data_atts = array();
		if ( isset( $this->option['config'] ) ) {
			$data_atts = (array) $this->option['config'];
		}

		$output  = '';
		$output .= '<select class="of-input of-select2" name="' . esc_attr( "{$this->option_name}[]" ) . '" id="' . esc_attr( $this->option['id'] ) . '" multiple ' . presscore_get_inlide_data_attr( $data_atts ) . ' style="width: 100%">';

		foreach ( $this->option['options'] as $value => $title ) {
			$selected = selected( in_array( $value, $this->val, true ), true, false );
			$output  .= '<option value="' . esc_attr( $value ) . '" ' . $selected . ' >' . esc_html( $title ) . '</option>';
		}
		$output .= '</select>';

		return $output;
	}
}
