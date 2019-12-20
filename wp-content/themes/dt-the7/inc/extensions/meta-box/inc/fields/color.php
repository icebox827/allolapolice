<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'THE7_RWMB_Color_Field' ) )
{
	class THE7_RWMB_Color_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'the7-mb-color', THE7_RWMB_CSS_URL . 'color.css', array( 'farbtastic',  'wp-color-picker' ), THE7_RWMB_VER );
			wp_enqueue_script( 'the7-mb-color', THE7_RWMB_JS_URL . 'color.js', array( 'farbtastic',  'wp-color-picker' ), THE7_RWMB_VER, true );
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
			return sprintf(
				'<input class="the7-mb-color" type="text" name="%s" id="%s" value="%s" size="%s" />
				<div class="the7-mb-color-picker"></div>',
				$field['field_name'],
				empty( $field['clone'] ) ? $field['id'] : '',
				$meta,
				$field['size']
			);
		}

		/**
		 * Don't save '#' when no color is chosen
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return int
		 */
		static function value( $new, $old, $post_id, $field )
		{
			return '#' === $new ? '' : $new;
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
				'size' => 7,
			) );

			return $field;
		}
	}
}