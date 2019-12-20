<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 *
 * This template is highly customized. See the7-vc-pie-bridge.php.
 *
 * @var $atts
 * @var $appearance
 * @var $title
 * @var $el_class
 * @var $el_id
 * @var $value
 * @var $units
 * @var $color_mode
 * @var $color
 * @var $label_value
 * @var $css
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Pie $this
 */
$title = $el_class = $el_id = $value = $units = $color = $custom_color = $label_value = $css = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'vc_dt_pie' );

// The7: Custom appearance param.
$appearance_class = '';
if ( 'counter' === $appearance ) {
	$appearance_class = ' transparent-pie';
}

// The7: Custom color mode param.
switch ( $color_mode ) {
	case 'title_like':
		$color = 'dt-title';
		break;
	case 'content_like':
		$color = 'dt-content';
		break;
	case 'accent':
		$color = 'dt-accent';
		break;
	case 'custom':
	default:
		$colors_arr = array(
			'wpb_button',
			'btn-primary',
			'btn-info',
			'btn-success',
			'btn-warning',
			'btn-danger',
			'btn-inverse',
		);

		if ( ! in_array( $color, $colors_arr, true ) ) {
			$color = ( false !== strpos( $color, 'rgba' ) ? $color : dt_stylesheet_color_hex2rgba( $color, 100 ) );
		}

		if ( ! $color ) {
			$color = 'wpb_button';
		}
}

$class_to_filter  = 'vc_pie_chart wpb_content_element';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $appearance_class;
$css_class        = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$output  = '<div ' . implode( ' ', $wrapper_attributes ) . ' class= "' . esc_attr( $css_class ) . '" data-pie-value="' . esc_attr( $value ) . '" data-pie-label-value="' . esc_attr( $label_value ) . '" data-pie-units="' . esc_attr( $units ) . '" data-pie-color="' . esc_attr( $color ) . '">';
$output .= '<div class="wpb_wrapper">';
$output .= '<div class="vc_pie_wrapper">';
$output .= '<span class="vc_pie_chart_back"></span>';
$output .= '<span class="vc_pie_chart_value"></span>';
$output .= '<canvas width="101" height="101"></canvas>';
$output .= '</div>';

if ( '' !== $title ) {
	$output .= '<h4 class="wpb_heading wpb_pie_chart_heading">' . $title . '</h4>';
}

$output .= '</div>';
$output .= '</div>';

if ( version_compare( WPB_VC_VERSION, '6.0.3', '<' ) ) {
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	return $output;
}
