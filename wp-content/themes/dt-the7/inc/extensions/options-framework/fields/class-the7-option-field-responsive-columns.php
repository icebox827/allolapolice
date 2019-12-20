<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Responsive_Columns extends The7_Option_Field_Abstract {

	public function html() {
		if ( isset( $this->option['columns'] ) ) {
			$responsiveness = $this->option['columns'];
		} else {
			$responsiveness = array(
				'desktop'  => _x( 'Desktop', 'theme-options', 'the7mk2' ),
				'h_tablet' => _x( 'Horizontal Tablet', 'theme-options', 'the7mk2' ),
				'v_tablet' => _x( 'Vertical Tablet', 'theme-options', 'the7mk2' ),
				'phone'    => _x( 'Mobile Phone', 'theme-options', 'the7mk2' ),
			);
		}

		$columns = $this->val;
		$html    = '';
		foreach ( $responsiveness as $device => $desc ) {
			$columns_on_device = '';
			if ( ! empty( $columns[ $device ] ) ) {
				$columns_on_device = $columns[ $device ];
			}
			$html       .= '<div class="responsive_columns-column"><input type="number" max="12" min="1" class="responsive_columns-value" data-device="' . esc_attr( $device ) . '" name="' . esc_attr( $this->option_name . '[' . $device . ']' ) . '" value="' . esc_attr( $columns_on_device ) . '"><div class="explain">' . esc_html( $desc ) . '</div></div>';
		}

		return $html;
	}
}