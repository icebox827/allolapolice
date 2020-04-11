<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class THE7_RWMB_Dimension_Field extends THE7_RWMB_Text_Field {

	/**
	 * Normalize parameters for field
	 *
	 * @param array $field
	 *
	 * @return array
	 */
	static function normalize_field( $field ) {
		$field = wp_parse_args(
			$field,
			array(
				'size'     => 30,
				'datalist' => false,
				'class'    => '',
				'units'    => array( 'px' ),
			)
		);

		return $field;
	}

	/**
	 * @param mixed $new
	 * @param mixed $old
	 * @param int   $post_id
	 * @param array $field
	 *
	 * @return void
	 */
	static function save( $new, $old, $post_id, $field ) {
		preg_match( '/([-0-9]*)(.*)/', $new, $matches );

		$cur_units = '';
		$cur_val   = '';
		if ( $matches[1] !== '' ) {
			$cur_val   = (int) $matches[1];
			$cur_units = current( $field['units'] );
			if ( in_array( $matches[2], $field['units'] ) ) {
				$cur_units = $matches[2];
			}
		}

		update_post_meta( $post_id, $field['id'], $cur_val . $cur_units );
	}

}
