<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Make sure "text" field is loaded
require_once THE7_RWMB_FIELDS_DIR . 'text.php';

if ( ! class_exists( 'THE7_RWMB_Password_Field' ) )
{
	class THE7_RWMB_Password_Field extends THE7_RWMB_Text_Field
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
			return sprintf(
				'<input type="password" class="the7-mb-password" name="%s" id="%s" value="%s" size="%s" />',
				$field['field_name'],
				$field['id'],
				$meta,
				$field['size']
			);
		}
	}
}