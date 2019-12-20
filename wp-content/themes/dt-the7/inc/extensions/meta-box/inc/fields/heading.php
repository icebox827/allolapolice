<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'THE7_RWMB_Heading_Field' ) )
{
	class THE7_RWMB_Heading_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'the7-mb-heading', THE7_RWMB_CSS_URL . 'heading.css', array(), THE7_RWMB_VER );
		}

		/**
		 * Show begin HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function begin_html( $html, $meta, $field )
		{
			return sprintf(
				'<h4>%s</h4>',
				$field['name']
			);
		}

		/**
		 * Show end HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function end_html( $html, $meta, $field )
		{
			return '';
		}

		/**
		 * Define this field as decorative.
		 *
		 * @return bool
		 */
		static function is_decorative() {
			return true;
		}
	}
}
