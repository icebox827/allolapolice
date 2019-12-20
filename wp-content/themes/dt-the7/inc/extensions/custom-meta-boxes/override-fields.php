<?php
/**
 * Override for some meta-box fields.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**************************************************************************************/
// Radio field
/**************************************************************************************/

if ( ! class_exists( 'THE7_RWMB_Radio_Field' ) ) {
	class THE7_RWMB_Radio_Field {
		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field ) {
			$html = '';
			$tpl = '<label %s>%s<input type="radio" class="the7-mb-radio" name="%s" value="%s" %s /> %s</label>';

			if ( empty( $field['images_base_dir'] ) ) {
				$theme_uri = get_template_directory_uri();
				$admin_images_uri = $theme_uri . '/inc/admin/assets/images/';

			} else {
				$admin_images_uri = $field['images_base_dir'];

			}

			$hide_fields = !empty($field['hide_fields']) ? (array) $field['hide_fields'] : array();

			if ( ! array_key_exists( $meta, $field['options'] ) ) {
				$meta = ( array_key_exists( 'std', $field ) ? $field['std'] : key( $field['options'] ) );
			}

			foreach ( $field['options'] as $value => $label ) {
				$class = '';
				$image = '';
				$checked = checked( $value, $meta, false );
				
				if ( $checked ) {
					$class = 'class="act"';
				}

				if ( !empty($hide_fields[ $value ]) ) {
					$checked .= ' data-hide-fields="' . implode( ',', (array) $hide_fields[ $value ] ) . '"';
				}

				// radio image
				if ( is_array($label) ) {

					if( !empty($label[1]) && is_array($label[1]) ) {
						$image_meta = $label[1];

						$image = sprintf(
							'<img src="%s" class="the7-mb-thumb hide-if-no-js"  style="%s" width="%d" height="%d" /><br />',
							esc_url($admin_images_uri . 'blank.gif'),
							esc_attr( "background-image:url('" . esc_url($admin_images_uri . $image_meta[0]) . "'); height: {$image_meta[2]}px;" ),
							absint($image_meta[1]),
							absint($image_meta[2])
						);
					}

					$label = current($label);
				}

				$html .= sprintf(
					$tpl,
					$class,
					$image,
					$field['field_name'],
					$value,
					$checked,
					$label
				);
			}

			return $html;
		}

		/**
		 * Filter before html.
		 */
		static function dt_filter_begin_html( $begin, $field, $meta ) {

			if ( !empty($field['hide_fields']) ) {
				$begin = str_replace('class="the7-mb-input', 'class="the7-mb-input the7-mb-radio-hide-fields', $begin);
			}

			return $begin;
		}
	}
	add_filter('the7_mb_radio_begin_html', array('THE7_RWMB_Radio_Field', 'dt_filter_begin_html'), 10, 3);
}

/**************************************************************************************/
// Checkbox field
/**************************************************************************************/

if ( ! class_exists( 'THE7_RWMB_Checkbox_Field' ) ) {
	class THE7_RWMB_Checkbox_Field {
		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field ) {
			
			$checked = checked( !empty( $meta ), 1, false );
			$hide_fields = !empty($field['hide_fields']) ? (array) $field['hide_fields'] : array();
			$hide_index = '' . absint($meta);
			if ( !empty($hide_fields) ) {
				$checked .= ' data-hide-fields="' . implode( ',', $hide_fields ) . '"';
			}

			return sprintf(
				'<input type="checkbox" class="the7-mb-checkbox" name="%s" id="%s" value="1" %s />',
				$field['field_name'],
				$field['id'],
				$checked
			);
		}

		/**
		 * Set the value of checkbox to 1 or 0 instead of 'checked' and empty string
		 * This prevents using default value once the checkbox has been unchecked
		 *
		 * @link https://github.com/rilwis/meta-box/issues/6
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return int
		 */
		static function value( $new, $old, $post_id, $field ) {
			return empty( $new ) ? 0 : 1;
		}

		/**
		 * Filter before html.
		 */
		static function dt_filter_begin_html( $begin, $field, $meta ) {

			if ( !empty($field['hide_fields']) ) {
				$begin = str_replace('class="the7-mb-input', 'class="the7-mb-input the7-mb-checkbox-hide-fields', $begin);
			}

			return $begin;
		}
	}
	add_filter('the7_mb_checkbox_begin_html', array('THE7_RWMB_Checkbox_Field', 'dt_filter_begin_html'), 10, 3);
}

/**************************************************************************************/
// Select field
/**************************************************************************************/

if ( !class_exists( 'THE7_RWMB_Select_Field' ) ) {
	class THE7_RWMB_Select_Field {
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts() {
			wp_enqueue_style( 'the7-mb-select', THE7_RWMB_CSS_URL . 'select.css', array(), THE7_RWMB_VER );
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
		static function html( $html, $meta, $field ) {
			$html = sprintf(
				'<select class="the7-mb-select" name="%s" id="%s" size="%s"%s>',
				$field['field_name'],
				$field['id'],
				$field['size'],
				$field['multiple'] ? ' multiple="multiple"' : ''
			);

			$html .= self::options_html( $field, $meta );

			$html .= '</select>';

			return $html;
		}

		/**
		 * Get meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * @see "save" method for better understanding
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $meta
		 * @param $post_id
		 * @param $saved
		 * @param $field
		 *
		 * @return array
		 */
		static function meta( $meta, $post_id, $saved, $field ) {
			$single = $field['clone'] || !$field['multiple'];
			$meta = get_post_meta( $post_id, $field['id'], $single );
			$meta = ( !$saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

			$meta = array_map( 'esc_attr', (array) $meta );

			return $meta;
		}

		/**
		 * Save meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $new
		 * @param $old
		 * @param $post_id
		 * @param $field
		 */
		static function save( $new, $old, $post_id, $field ) {
			if ( !$field['clone'] )
			{
				The7_RW_Meta_Box::save( $new, $old, $post_id, $field );
				return;
			}

			if ( empty( $new ) )
				delete_post_meta( $post_id, $field['id'] );
			else
				update_post_meta( $post_id, $field['id'], $new );
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'desc'=> '',
				'name' => $field['id'],
				'size' => $field['multiple'] ? 5 : 0,
				'placeholder' => '',
				'field_type' => 'select'
			) );
			if ( !$field['clone'] && $field['multiple'] )
				$field['field_name'] .= '[]';
			return $field;
		}
		
		/**
		 * Creates html for options
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function options_html( $field, $meta ) {
			$html = '';

			// std
			if ( empty($meta) ) {
				$meta = $field['std'];
			}

			if ( $field['placeholder'] )
				$html = 'select' == $field['field_type'] ? "<option value=''>{$field['placeholder']}</option>" : '<option></option>';

			$option = '<option value="%s" %s>%s</option>';
			
			foreach ( $field['options'] as $value => $label )
			{
				$html .= sprintf(
					$option,
					$value,
					selected( in_array( $value, (array)$meta ), true, false ),
					$label
				);
			}
			
			return $html;
		}
	}
}