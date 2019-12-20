<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * @deprecated
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $el_id
 * @var $content - shortcode content
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Accordion_tab $this
 */
$title = $el_id = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings['base'], $atts );

// The7: Span added in h3 title.
$output = '
	<div ' . ( isset( $el_id ) && ! empty( $el_id ) ? "id='" . esc_attr( $el_id ) . "'" : '' ) . 'class="' . esc_attr( $css_class ) . '">
		<h3 class="wpb_accordion_header ui-accordion-header"><a href="#' . sanitize_title( $title ) . '"><span>' . $title . '</span></a></h3>
		<div class="wpb_accordion_content ui-accordion-content vc_clearfix">
			' . ( ( '' === trim( $content ) ) ? esc_html__( 'Empty section. Edit page to add content here.', 'the7mk2' ) : wpb_js_remove_wpautop( $content ) ) . '
		</div>
	</div>
';

if ( version_compare( WPB_VC_VERSION, '6.0.3', '<' ) ) {
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	return $output;
}

