<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'THE7_RWMB_Map_Field' ) )
{
	class THE7_RWMB_Map_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_script( 'googlemap', 'https://maps.google.com/maps/api/js?sensor=false', array(), '', true );
			wp_enqueue_script( 'the7-mb-map', THE7_RWMB_JS_URL . 'map.js', array( 'jquery', 'jquery-ui-autocomplete', 'googlemap' ), THE7_RWMB_VER, true );
		}

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
			$address = isset( $field['address_field'] ) ? $field['address_field'] : false;

			$html = '<div class="the7-mb-map-field">';

			$html .= sprintf(
				'<div class="the7-mb-map-canvas" style="%s"></div>
				<input type="hidden" name="%s" class="the7-mb-map-coordinate" value="%s">',
				isset( $field['style'] ) ? $field['style'] : '',
				$field['field_name'],
				$meta
			);

			if ( $address )
			{
				$html .= sprintf(
					'<button class="button the7-mb-map-goto-address-button" value="%s">%s</button>',
					is_array( $address ) ? implode( ',', $address ) : $address,
					__( 'Find Address', 'the7mk2' )
				);
			}

			$html .= '</div>';

			return $html;
		}
	}
}
