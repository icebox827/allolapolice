<?php
/**
 * Typography option field.
 *
 * @package The7/Options
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class The7_Option_Field_Typography extends The7_Option_Field_Composition_Abstract {

	/**
	 * Do this field need a wrap.
	 *
	 * @var bool
	 */
	protected $need_wrap = false;

	/**
	 * Return field html.
	 *
	 * @return string
	 */
	public function html() {
		$typography_defaults = self::get_typography_fields();
		$typography_stored   = array_intersect_key(
			wp_parse_args( $this->option['options'], $typography_defaults ),
			$this->option['std']
		);

		$id          = $this->option['id'];
		$output      = '<div id="section-' . esc_attr( $id ) . '" class="section section-typography">';
		$field_value = self::sanitize( $this->val );
		foreach ( $typography_defaults as $field => $default_declaration ) {
			if ( empty( $typography_stored[ $field ] ) ) {
				continue;
			}

			$field_declaration       = wp_parse_args( $typography_stored[ $field ], $default_declaration );
			$field_declaration['id'] = $field;
			$field_object            = $this->interface->get_field_object(
				$this->option_name . '[' . $field . ']',
				$field_declaration,
				$field_value
			);
			// Fix id's.
			$output .= str_replace(
				array(
					"section-$field",
					"id=\"$field\"",
				),
				array(
					"section-$id-$field",
					"id=\"$id-$field\"",
				),
				$this->interface->wrap_option( $field_object )
			);
		}
		$output .= '</div>';

		return $output;
	}

	/**
	 * Return typography fields fields definition.
	 *
	 * @return array
	 */
	protected static function get_typography_fields() {
		return array(
			'font_family'    => array(
				'name'  => _x( 'Font family', 'theme-options', 'the7mk2' ),
				'type'  => 'web_fonts',
				'std'   => 'Open Sans',
				'fonts' => 'all',
				'class' => 'font-family',
			),
			'font_size'      => array(
				'name'     => _x( 'Font size', 'theme-options', 'the7mk2' ),
				'std'      => 20,
				'type'     => 'slider',
				'options'  => array(
					'min' => 1,
					'max' => 120,
				),
				'sanitize' => 'font_size',
				'class'    => 'font-size',
			),
			'line_height'    => array(
				'name'     => _x( 'Line height', 'theme-options', 'the7mk2' ),
				'std'      => 30,
				'type'     => 'slider',
				'options'  => array(
					'min' => 1,
					'max' => 120,
				),
				'sanitize' => 'font_size',
				'class'    => 'line-height',
			),
			'text_transform' => array(
				'name'    => _x( 'Text transformation', 'theme-options', 'the7mk2' ),
				'type'    => 'select',
				'std'     => 'none',
				'options' => array(
					'none'       => 'None',
					'uppercase'  => 'Uppercase',
					'lowercase'  => 'Lowercase',
					'capitalize' => 'Capitalize',
				),
				'class'   => 'mini text-transform',
			),
		);
	}

	/**
	 * Sanitize typography value.
	 *
	 * @param array $typography Typography value.
	 *
	 * @return array
	 */
	public static function sanitize( $typography ) {
		return wp_parse_args( (array) $typography, wp_list_pluck( self::get_typography_fields(), 'std' ) );
	}

	/**
	 * Normalize field definition.
	 *
	 * @param array $option Field definition array.
	 *
	 * @return array
	 */
	protected function normalize_option( $option ) {
		$option = wp_parse_args(
			$option,
			array(
				'std'     => array(),
				'options' => array(),
			)
		);

		$option['std']     = (array) $option['std'];
		$option['options'] = (array) $option['options'];

		return $option;
	}
}
