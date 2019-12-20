<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Gradient_Picker extends The7_Option_Field_Abstract {

	public function html() {
		$field_id   = $this->option['id'];
		$val        = apply_filters( 'of_sanitize_gradient_picker', $this->val, $this->option );

		return self::static_html( $this->option_name, $field_id, $val, array(
			'hide_angle_controls' => isset( $this->option['fixed_angle'] ),
		) );
	}

	/**
	 * Return field HTML.
	 *
	 * @param string $name
	 * @param string $id
	 * @param string $value
	 * @param array  $config
	 *
	 * @return string
	 */
	public static function static_html( $name, $id, $value, $config = array() ) {
		$config          = wp_parse_args( $config, array(
			'hide_angle_controls' => false,
			'value_input_class'   => '',
		) );
		$sanitized_value = self::sanitize( $value );
		$encoded_value   = self::encode( $sanitized_value );
		$gradient_data   = array();

		$gradient_controls_html = '';
		$gradient_controls_html .= sprintf( '<div class="of-gradient_picker-preview-box" style="background-image: linear-gradient(%s);"></div>', str_replace( '|', ',', $encoded_value ) );
		$wrap_class             = array( 'grad_ex' );
		if ( $config['hide_angle_controls'] ) {
			$wrap_class[] = 'hide-angle';
		}
		$gradient_controls_html .= sprintf( '<div class="%s" id="%s" %s>', implode( ' ', $wrap_class ), $id, implode( ' ', $gradient_data ) );
		$gradient_controls_html .= sprintf( '<input type="hidden" class="of-gradient_picker-value %s" value="%s" name="%s">', esc_attr( $config['value_input_class'] ), $encoded_value, esc_attr( $name ) );
		$angle                  = absint( $sanitized_value['angle'] );
		$slider_data            = array(
			'data-max="360"',
			'data-min="0"',
			'data-step="1"',
			sprintf( 'data-value="%s"', $angle ),
		);
		$gradient_controls_html .= sprintf( '<div class="of-slider"></div><input type="text" class="of-slider-value of-gradient_picker-angle" value="%s" %s />', $angle, implode( ' ', $slider_data ) );
		$gradient_controls_html .= '</div>';

		return $gradient_controls_html;
	}

	/**
	 * Decode, than sanitize value.
	 *
	 * @param string $gradient
	 *
	 * @return array
	 */
	public static function sanitize( $gradient ) {
		$gradient = self::decode( $gradient );

		if ( ! preg_match( '/[0-9]*deg/i', $gradient['angle'] ) ) {
			$gradient['angle'] && array_unshift( $gradient['color_stops'], $gradient['angle'] );
			$gradient['angle'] = '90deg';
		}

		if ( count( $gradient['color_stops'] ) < 2 ) {
			$gradient['color_stops'] = array(
				'#000000 30%',
				'#000000 100%',
			);

			return $gradient;
		}

		foreach ( $gradient['color_stops'] as $i => $color_stop ) {
			$color_stop_parts = explode( ' ', trim( $color_stop ) );
			if ( count( $color_stop_parts ) < 2 || ( strpos( $color_stop, '#' ) !== 0 && strpos( $color_stop, 'rgb' ) !== 0 ) ) {
				$gradient['color_stops'][ $i ] = '#000000 ' . ( $i === 0 ? '30%' : '100%' );
			}
		}

		return $gradient;
	}

	/**
	 * Encode value.
	 *
	 * @param array $gradient
	 *
	 * @return string
	 */
	public static function encode( $gradient ) {
		$parts = $gradient['color_stops'];
		array_unshift( $parts, $gradient['angle'] );

		return implode( '|', $parts );
	}

	/**
	 * Decode value.
	 *
	 * @param string $gradient
	 *
	 * @return array
	 */
	public static function decode( $gradient ) {
		$color_stops = explode( '|', $gradient );
		$angle       = array_shift( $color_stops );

		return array(
			'angle'       => $angle,
			'color_stops' => $color_stops,
		);
	}
}
