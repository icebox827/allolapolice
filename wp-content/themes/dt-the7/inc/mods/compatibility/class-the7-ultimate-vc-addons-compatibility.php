<?php
/**
 * Ultimate VC Addons adapter.
 * 
 * @package The7
 * @since 7.8.2
 */

defined( 'ABSPATH' ) || exit;

class The7_Ultimate_VC_Addons_Compatibility {

	/**
	 * Bootstrap adapter.
	 */
	public function bootstrap() {
		add_filter( 'shortcode_atts_ultimate_heading', array( $this, 'ajust_ultimate_heading_shortcode' ) );
	}

	/**
	 * Adjust ultimate heading shortcode attributes.
	 *
	 * @param array $out Shortcode attributes.
	 *
	 * @return array
	 */
	public function ajust_ultimate_heading_shortcode( $out ) {
		if ( empty( $out['main_heading_line_height'] ) && empty( $out['main_heading_font_size'] ) ) {
			$out['el_class'] .= ' uvc-heading-default-font-sizes';
		}

		if ( isset( $out['main_heading_style'] ) && strpos( $out['main_heading_style'], 'font-weight' ) === false ) {
			// It seems more gentle to use custom CSS property rather then invalid value.
			$out['main_heading_style'] .= ',--font-weight:theme;';
		}

		return $out;
	}

}