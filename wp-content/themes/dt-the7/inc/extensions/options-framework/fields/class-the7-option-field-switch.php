<?php
defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Option_Field_Switch
 */
class The7_Option_Field_Switch extends The7_Option_Field_Abstract {

	static protected $default_config = array(
		'value_input_class' => '',
		'default'           => '0',
		'options'           => array(
			'1' => 'On',
			'0' => 'Off',
		),
	);

	public function html() {
		$field_config = array();
		if ( isset( $this->option['options'] ) ) {
			$field_config['options'] = $this->option['options'];
		}

		return  The7_Option_Field_Switch::static_html( $this->option_name, $this->option['id'], $this->val, $field_config );
	}

	/**
	 * Return switch HTML.
	 *
	 * @param string $name   Input name.
	 * @param string $id     Field id.
	 * @param string $value  Value string.
	 * @param array  $config Config.
	 *
	 * @return string
	 */
	public static function static_html( $name, $id, $value, $config = array() ) {
		$config = wp_parse_args( $config, self::$default_config );

		$value = self::sanitize( $value, array_keys( $config['options'] ), $config['default'] );

		list( $on, $off ) = array_keys( $config['options'] );
		list( $on_title, $off_title ) = array_values( $config['options'] );

		$values_attr = json_encode( array( $on, $off ) );

		$output = '';
		$output .= '<div class="the7-option-switch">';
		$output .= '<input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" data-values="' . esc_attr( $values_attr ) . '" value="' . esc_attr( $value ) . '" class="the7-option-switch-checkbox ' . esc_attr( $config['value_input_class'] ) . '" ' . checked( $value, $on, false ) . '>';
		$output .= '<label class="the7-option-switch-label" for="' . esc_attr( $id ) . '">';
		$output .= '<div class="the7-option-switch-inner">';
		$output .= '<div class="the7-option-switch-active">';
		$output .= '<div class="the7-option-switch-title">' . esc_html( $on_title ) . '</div>';
		$output .= '</div>';
		$output .= '<div class="the7-option-switch-inactive">';
		$output .= '<div class="the7-option-switch-title">' . esc_html( $off_title ) . '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</label>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * Sanitize value.
	 *
	 * @param mixed       $value   Value to sanitize.
	 * @param null|array  $values  Array of allowed values.
	 * @param null|string $default Return this in case value is not allowed.
	 *
	 * @return string
	 */
	public static function sanitize( $value, $values = null, $default = null ) {
		if ( $values === null ) {
			$values = array_keys( self::$default_config['options'] );
		}

		if ( $default === null ) {
			$default = self::$default_config['default'];
		}

		if ( ! in_array( $value, (array) $values ) ) {
			$value = $default;
		}

		return $value;
	}
}
