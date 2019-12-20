<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'THE7_RWMB_Text_Field' ) )
{
	class THE7_RWMB_Text_Field
	{
		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$attributes = array();

			if ( $field['datalist'] ) {
				$attributes[] = "list='{$field['datalist']['id']}'";
			}

			if ( isset( $field['placeholder'] ) ) {
				$attributes[] = sprintf( 'placeholder="%s"', esc_attr( $field['placeholder'] ) );
			}

			return sprintf(
				'<input type="text" class="the7-mb-text %s" name="%s" id="%s" value="%s" size="%s" %s/>%s',
				$field['class'],
				$field['field_name'],
				$field['id'],
				$meta,
				$field['size'],
				implode( ' ', $attributes ),
				self::datalist_html($field)
			);
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field = wp_parse_args( $field, array(
				'size' => 30,
				'datalist' => false,
				'class' => '',
			) );
			return $field;
		}
		
		/**
		 * Create datalist, if any
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function datalist_html( $field )
		{
			if( !$field['datalist'] )
				return '';
			$datalist = $field['datalist'];
			$html = sprintf(
				'<datalist id="%s">',
				$datalist['id']
			);
			
			foreach( $datalist['options'] as $option ) {
				$html.= sprintf('<option value="%s"></option>', $option);	
			}
			
			$html .= '</datalist>';
			
			return $html;
		}
	}
}