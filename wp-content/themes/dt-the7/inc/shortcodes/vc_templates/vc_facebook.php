<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $type
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Facebook $this
 */

// The7: Old attributes initialisation left for back compatibility reasons.
extract( shortcode_atts( array(
	'type' => 'standard',
	'el_id' => '',
	'url'  => '',
	'like' => 'post',
	'css' => '',
	'el_class' => '',
	'css_animation' => '',
), $atts, 'vc_facebook' ) );

// The7: Custom permalink logic.
if ( empty( $url ) ) {
	$page_to_like = 0;
	if ( isset( $like ) && 'page' === $like && function_exists( 'presscore_config' ) && presscore_config()->get( 'page_id' ) ) {
		$page_to_like = presscore_config()->get( 'page_id' );
	}
	$url = get_permalink( $page_to_like );
}

$el_class = isset( $el_class ) ? $el_class : '';

$class_to_filter = 'fb_like wpb_content_element fb_type_' . $type;
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$output = '<div class="' . esc_attr( $css_class ) . '" ' . implode( ' ', $wrapper_attributes ) . '><iframe src="https://www.facebook.com/plugins/like.php?href='
	. esc_url( $url ) . '&amp;layout='
	. esc_attr( $type ) . '&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>';

if ( version_compare( WPB_VC_VERSION, '6.0.3', '<' ) ) {
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	return $output;
}
