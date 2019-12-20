<?php

defined( 'ABSPATH' ) || exit;

/**
 * Convert dimensions string like '1x1' to array [1, 1].
 * Return [1, 1] if $dimension_string is invalid.
 *
 * @since 6.7.0
 *
 * @param string $dimension_string
 *
 * @return array
 */
function the7_shortcode_decode_image_dimension( $dimension_string ) {
	$dimension_string = strtolower( $dimension_string );
	if ( strpos( $dimension_string, 'x' ) === false ) {
		return array( 1, 1 );
	}

	$dimension_array = array();
	foreach ( array_slice( explode( 'x', $dimension_string ), 0, 2 ) as $dimension ) {
		$dimension_array[] = max( (int) $dimension, 1 );
	}

	return $dimension_array;
}

/**
 * Decode typical shortcode responsive columns attribute and add it to $data_atts_array.
 * By default attribute value is empty string.
 * Added attributes:
 * [
 *  'desktop-columns-num' => '',
 *  'v-tablet-columns-num'' => '',
 *  'h-tablet-columns-num'' => '',
 *  'phone-columns-num'' => '',
 * ]
 *
 * @since 6.7.0
 * @uses  DT_VCResponsiveColumnsParam::decode_columns()
 * @uses  absint()
 *
 * @param array  $data_atts_array
 * @param string $encoded_columns
 *
 * @return array
 */
function the7_shortcode_add_responsive_columns_data_attributes( $data_atts_array, $encoded_columns ) {
	$columns     = DT_VCResponsiveColumnsParam::decode_columns( $encoded_columns );
	$columns_map = array(
		'desktop'  => 'desktop',
		'v_tablet' => 'v-tablet',
		'h_tablet' => 'h-tablet',
		'phone'    => 'phone',
	);

	foreach ( $columns_map as $column_name => $data_att_name ) {
		$data_atts_array["{$data_att_name}-columns-num"] = isset( $columns[ $column_name ] ) ? absint( $columns[ $column_name ] ) : '';
	}

	return $data_atts_array;
}

/**
 * Return array of custom icons stylesheets.
 *
 * @since 7.0.0
 *
 * @param array $icons_stylesheets
 *
 * @return array
 */
function the7_get_custom_icons_stylesheets( $icons_stylesheets = array() ) {
	$custom_icons = (array) get_option( 'smile_fonts', array() );
	$upload_dir   = wp_get_upload_dir();

	foreach ( $custom_icons as $icon ) {
		if ( isset( $icon['style'] ) ) {
			$icons_stylesheets[] = $upload_dir['baseurl'] . '/smile_fonts/' . $icon['style'];
		}
	}

	return $icons_stylesheets;
}

/**
 * Return shortcode uid based on $tag and $atts.
 *
 * @since 7.1.3
 *
 * @param string $tag  Shortcode tag.
 * @param array  $atts Shortcode atts array.
 *
 * @return string Shortcode UID.
 */
function the7_get_shortcode_uid( $tag, $atts = array() ) {
	return md5( $tag . json_encode( $atts ) );
}