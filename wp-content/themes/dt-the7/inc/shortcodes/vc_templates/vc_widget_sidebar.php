<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $el_class
 * @var $el_id
 * @var $show_bg
 * @var $sidebar_id
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Widget_sidebar $this
 */
$title = $el_class = $el_id = $sidebar_id = $show_bg = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( '' === $sidebar_id ) {
	return null;
}

$el_class = $this->getExtraClass( $el_class );

// The7: Custom background setting.
if ( 'true' === $show_bg ) {
	$el_class .= ' solid-bg';
}

switch ( presscore_config()->get( 'sidebar.style.background.decoration' ) ) {
	case 'shadow':
		$el_class .= ' sidebar-shadow-decoration';
		break;
	case 'outline':
		$el_class .= ' sidebar-outline-decoration';
		break;
}

ob_start();
dynamic_sidebar( $sidebar_id );
$sidebar_value = ob_get_contents();
ob_end_clean();

$sidebar_value = trim( $sidebar_value );
$sidebar_value = ( '<li' === substr( $sidebar_value, 0, 3 ) ) ? '<ul>' . $sidebar_value . '</ul>' : $sidebar_value;

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_widgetised_column wpb_content_element sidebar-content' . $el_class, $this->settings['base'], $atts );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$output = '<div ' . implode( ' ', $wrapper_attributes ) . ' class="' . esc_attr( $css_class ) . '">
		<div class="wpb_wrapper">
			' . wpb_widget_title( array(
	'title' => $title,
	'extraclass' => 'wpb_widgetised_column_heading',
) ) . '
			' . $sidebar_value . '
		</div>
	</div>
';

if ( version_compare( WPB_VC_VERSION, '6.0.3', '<' ) ) {
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	return $output;
}
