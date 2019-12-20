<?php
/**
 * Shortcode with inline css for The7 Elements.
 *
 * @since 3.0.0
 *
 * @package The7pt
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7pt_Shortcode_With_Inline_CSS
 */
class The7pt_Shortcode_With_Inline_CSS extends DT_Shortcode_With_Inline_Css {

	/**
	 * Output shortcode HTML.
	 *
	 * @param array  $atts
	 * @param string $content
	 */
	protected function do_shortcode( $atts, $content = '' ) {
	}

	/**
	 * Setup theme config for shortcode.
	 */
	protected function setup_config() {
	}

	/**
	 * Return array of prepared less vars to insert to less file.
	 *
	 * @return array
	 */
	protected function get_less_vars() {
		return array();
	}

	/**
	 * Return shortcode less file absolute path to output inline.
	 *
	 * @return string
	 */
	protected function get_less_file_name() {
		return '';
	}

	/**
	 * Return dummy html for VC inline editor.
	 *
	 * @return string
	 */
	protected function get_vc_inline_html() {
		return '';
	}

	/**
	 * Return less import dir.
	 *
	 * @return array
	 */
	protected function get_less_import_dir() {
		return array( The7PT()->plugin_path() . 'assets/css/shortcodes' );
	}
}