<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Option_Field_Number
 */
class The7_Option_Field_Number extends The7_Option_Field_Abstract {

	/**
	 * Return field HTML.
	 *
	 * @return string
	 */
	public function html() {
		$units = 'px';
		if ( isset( $this->option['units'] ) ) {
			$units = $this->option['units'];
		}
		$min = isset( $this->option['min'] ) ? (int) $this->option['min'] : null;
		$max = isset( $this->option['max'] ) ? (int) $this->option['max'] : null;

		return self::static_html( $this->option_name, $this->val, $units, $min, $max );
	}

	/**
	 * Return number field HTML.
	 *
	 * @param string       $name
	 * @param string       $value
	 * @param string|array $units
	 * @param null|int     $min
	 * @param null|int     $max
	 *
	 * @return string
	 */
	public static function static_html( $name, $value, $units = 'px', $min = null, $max = null ) {
		$units     = self::decode_units( $units );
		$number    = self::sanitize( $value, $units, $min, $max );
		$cur_units = $number['units'];
		$val       = $number['val'];

		// Units HTML.
		$units_html       = '';
		$units_wrap_class = 'dt_spacing-units-wrap';
		$units_name       = $name ? "{$name}[units]" : '';
		if ( count( $units ) > 1 ) {
			$units_wrap_class .= ' select';
			foreach ( $units as $u ) {
				$units_html .= '<option value="' . esc_attr( $u ) . '" ' . selected(
						$u,
						$cur_units,
						false
					) . '>' . esc_html( $u ) . '</option>';
			}
			$units_html = '<select class="dt_spacing-units" name="' . $units_name . '" data-units="' . esc_attr(
					$cur_units
				) . '">' . $units_html . '</select>';
		} else {
			$units_html = '<span class="dt_spacing-units" data-units="' . esc_attr(
					$cur_units
				) . '"><input type="hidden" name="' . $units_name . '" value="' . esc_attr(
							  $cur_units
						  ) . '"/>' . esc_html( $cur_units ) . '</span>';
		}

		$units_html = '<div class="' . $units_wrap_class . '">' . $units_html . '</div>';

		$atts = array(
			'type'  => 'number',
			'value' => esc_attr( $val ),
		);

		if ( $name ) {
			$atts['name'] = "{$name}[val]";
		}

		if ( $min !== null ) {
			$atts['min'] = (int) $min;
		}

		if ( $max !== null ) {
			$atts['max'] = (int) $max;
		}

		$input_atts = '';
		foreach ( $atts as $att => $val ) {
			if ( is_bool( $val ) ) {
				$input_atts .= $att ? $att : '';
			} else {
				$input_atts .= " {$att}=\"{$val}\"";
			}
		}

		return '<input ' . $input_atts . '>' . $units_html;
	}

	/**
	 * Sanitize number string. Returns array of sanitized values in format array( 'val' => '', 'units' => '' ).
	 *
	 * @param string       $number Number string with units.
	 * @param array|string $units  Supported units.
	 * @param null|int     $min    Minimal value.
	 * @param null|int     $max    Maximal value.
	 *
	 * @return array
	 */
	public static function sanitize( $number, $units, $min = null, $max = null ) {
		$decoded_number = self::decode( $number );
		$units          = self::decode_units( $units );
		$cur_units      = current( $units );
		if ( in_array( $decoded_number['units'], $units, true ) ) {
			$cur_units = $decoded_number['units'];
		}
		$cur_val = (int) $decoded_number['val'];
		if ( $min !== null ) {
			$cur_val = max( $cur_val, $min );
		}
		if ( $max !== null ) {
			$cur_val = min( $cur_val, $max );
		}

		return array(
			'val'   => $cur_val,
			'units' => $cur_units,
		);
	}

	/**
	 * Encode decoded number array.
	 *
	 * @param array $number
	 *
	 * @return string
	 */
	public static function encode( $number ) {
		return $number['val'] . $number['units'];
	}

	/**
	 * Split number string to array( 'val' => '', 'units' => '' ).
	 *
	 * @param string $value
	 *
	 * @return array
	 */
	public static function decode( $value ) {
		preg_match( '/([-0-9]*)(.*)/', $value, $matches );
		$cur_val = 0;
		if ( ! empty( $matches[1] ) ) {
			$cur_val = $matches[1];
		}
		$cur_units = '';
		if ( ! empty( $matches[2] ) ) {
			$cur_units = $matches[2];
		}

		return array(
			'val'   => $cur_val,
			'units' => $cur_units,
		);
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
