<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Option_Field_Spacing
 */
class The7_Option_Field_Spacing extends The7_Option_Field_Abstract {

	public function html() {
		$field_id = $this->option['id'];
		$units = 'px';
		if ( isset( $this->option['units'] ) ) {
			$units = $this->option['units'];
		}
		if ( isset( $this->option['fields'] ) ) {
			$fields = $this->option['fields'];
		} else {
			// Default fields.
			$fields = array(
				_x( 'Top', 'theme-options', 'the7mk2' ),
				_x( 'Right', 'theme-options', 'the7mk2' ),
				_x( 'Bottom', 'theme-options', 'the7mk2' ),
				_x( 'Left', 'theme-options', 'the7mk2' ),
			);
		}

		return self::static_html( $this->option_name, $field_id, $this->val, $fields, $units );
	}

	/**
	 * Return spacing field HTML.
	 *
	 * @param string $name
	 * @param string $id
	 * @param string $value
	 * @param array $fields
	 * @param array  $units
	 *
	 * @return string
	 */
	public static function static_html( $name, $id, $value, $fields = array(), $units = array( 'px' ) ) {
		if ( empty( $fields ) || ! is_array( $fields ) ) {
			$fields = array( 'Top', 'Right', 'Bottom', 'Left' );
		}

		$html = '';
		$units = self::decode_units( $units );
		$spacing = self::sanitize( $value, $units, count( $fields ) );
		foreach ( $fields as $i=>$desc ) {
			$cur_units = $spacing[ $i ]['units'];
			$val = $spacing[ $i ]['val'];

			// Units HTML.
			$units_html = '';
			$units_wrap_class = 'dt_spacing-units-wrap';
			if ( count( $units ) > 1 ) {
				$units_wrap_class .= ' select';
				foreach ( $units as $u ) {
					$units_html .= '<option value="' . esc_attr( $u ) . '" ' . selected( $u, $cur_units, false ) . '>' . esc_html( $u ) . '</option>';
				}
				$units_html = '<select class="dt_spacing-units" data-units="' . esc_attr( $cur_units ) . '">' . $units_html . '</select>';
			} else {
				$units_html = '<span class="dt_spacing-units" data-units="' . esc_attr( $cur_units ) . '">' . esc_html( $cur_units ) . '</span>';
			}

			$units_html = '<div class="' . $units_wrap_class . '">' . $units_html . '</div>';

			// Space HTML.
			$html .= '<div class="dt_spacing-space"><input type="number" class="dt_spacing-value" value="' . esc_attr( $val ) . '">' . $units_html . '<div class="explain">' . esc_html( $desc ) . '</div></div>';
		}

		// Param value.
		$encoded_spacing = self::encode( $spacing );
		$html .= '<input type="hidden" id="' . esc_attr( $id ) . '" class="the7-option-field-value" name="' . esc_attr( $name ) . '" value="' . esc_attr( $encoded_spacing ) . '">';

		return $html;
	}

	/**
	 * Sanitize spacing string. Returns array of sanitized values in format array( 'val' => '', 'units' => '' ).
	 *
	 * @param string $spacing
	 * @param array|string $units
	 * @param int $fields_num
	 *
	 * @return array
	 */
	public static function sanitize( $spacing, $units, $fields_num = 4 ) {
		$spacing = self::decode( $spacing );
		$units = self::decode_units( $units );
		$max_val = 999;
		$sanitized_spacing = array();
		for ( $i = 0; $i < $fields_num;  $i++ ) {
			if ( ! isset( $spacing[ $i ] ) ) {
				$spacing[ $i ] = array(
					'val'   => 0,
					'units' => '',
				);
			}

			$cur_units = current( $units );
			if ( in_array( $spacing[ $i ]['units'], $units ) ) {
				$cur_units = $spacing[ $i ]['units'];
			}
			$cur_val = min( intval( $spacing[ $i ]['val'] ), $max_val );

			$sanitized_spacing[] = array(
				'val'   => $cur_val,
				'units' => $cur_units,
			);
		}

		return $sanitized_spacing;
	}

	/**
	 * Encode decoded spacing array.
	 *
	 * @param array $spacing
	 *
	 * @return string
	 */
	public static function encode( $spacing ) {
		$flat_spacing = array();
		foreach ( $spacing as $_spacing) {
			$flat_spacing[] = $_spacing['val'] . $_spacing['units'];
		}

		return join( ' ', $flat_spacing );
	}

	/**
	 * Split spacing string to array( 'val' => '', 'units' => '' ).
	 *
	 * @param string|array $value
	 *
	 * @return array
	 */
	public static function decode( $value ) {
		if ( ! is_array( $value ) ) {
			$value = explode( ' ', $value );
		}

		$decoded_val = array();
		foreach ( $value as $_value ) {
			preg_match( '/([-0-9]*)(.*)/', $_value, $matches );
			$cur_val = 0;
			if ( ! empty( $matches[1] ) ) {
				$cur_val = $matches[1];
			}
			$cur_units = '';
			if ( ! empty( $matches[2] ) ) {
				$cur_units = $matches[2];
			}
			$decoded_val[] = array(
				'val' => $cur_val,
				'units' => $cur_units,
			);
		}

		return $decoded_val;
	}

	/**
	 * Splits $units string to array.
	 *
	 * @param array|string $units
	 *
	 * @return array
	 */
	public static function decode_units( $units ) {
		if ( ! is_array( $units ) ) {
			$units = array_map( 'trim', explode( '|', $units ) );
		}

		return $units;
	}
}
