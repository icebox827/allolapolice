<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Social_Icon extends The7_Option_Field_Abstract {

	public function html() {
		$output = '';
		if ( isset( $this->option['options']['fields'] ) && is_array( $this->option['options']['fields'] ) ) {
			$w        = empty( $this->option['options']['ico_width'] ) ? 20 : (int) $this->option['options']['ico_width'];
			$h        = empty( $this->option['options']['ico_height'] ) ? 20 : (int) $this->option['options']['ico_height'];
			$ico_size = sprintf( 'width: %dpx;height: %dpx;', $w, $h );
			foreach ( $this->option['options']['fields'] as $field => $ico ) {
				$ico       = wp_parse_args( (array) $ico, array( 'img' => '', 'desc' => '' ) );
				$name      = sprintf( '%s[%s]', $this->option_name, $field );
				$soc_link  = isset( $this->val[ $field ]['link'] ) ? $this->val[ $field ]['link'] : '';
				$maxlength = isset( $this->option['maxlength'] ) ? ' maxlength="' . (int) $this->option['maxlength'] . '"' : '';

				$output .= '<input class="of-input" name="' . esc_attr( $name . '[link]' ) . '" type="text" value="' . esc_attr( $soc_link ) . '"' . $maxlength . ' style="display: inline-block; width: 300px; vertical-align: middle;" />';

				$output .= '<div class="of-soc-image" style="background: url( ' . esc_attr( $ico['img'] ) . ' ) no-repeat 0 0; vertical-align: middle; margin-right: 5px; display: inline-block;' . $ico_size . '"></div>';

			}
		}

		return $output;
	}
}