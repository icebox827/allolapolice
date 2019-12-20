<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Web_Fonts extends The7_Option_Field_Abstract {

	public function html() {
		// Replace &amp; coz in db value sanitized with esc_attr().
		$this->val       = str_replace( '&amp;', '&', $this->val );
		$id        = esc_attr( $this->option['id'] );
		$data_attr = '';

		if ( isset( $this->option['fonts'] ) ) {
			$this->option['fonts'] = in_array( $this->option['fonts'], array( 'safe', 'web', 'all' ) ) ? $this->option['fonts'] : 'all';
			$data_attr       .= ' data-fonts-group="' . esc_attr( $this->option['fonts'] ) . '"';

			$fonts = optionsframework_get_fonts_options( $this->option['fonts'] );

			if ( $this->val && isset( $fonts[ $this->val ] ) ) {
				$this->option['options'] = array( $this->val => $fonts[ $this->val ] );
			} else {
				reset( $fonts );
				$this->option['options'] = array( key( $fonts ) => current( $fonts ) );
			}
			unset( $fonts );
		}

		$output = '<div class="dt-web-fonts-preview"><span>Don\'t stop until you’re proud!</span></div>';

		$output .= '<select class="of-input dt-web-fonts" name="' . esc_attr( $this->option_name ) . '" id="' . $id . '"' . $data_attr . ' style="width: 100%;">';

		foreach ( $this->option['options'] as $key => $font ) {
			$selected = '';
			if ( $this->val !== '' && $this->val === $key ) {
				$selected = ' selected="selected"';
			}
			$output .= '<option' . $selected . ' value="' . esc_attr( $key ) . '">' . esc_html( $font ) . '</option>';
		}

		$output .= '</select>';

		return $output;
	}
}
