<?php
/**
 * Logos public part.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Presscore_Mod_Logos_Public {

	public function register_shortcodes() {
		foreach ( array( 'logos' ) as $shortcode_name ) {
			include_once plugin_dir_path( __FILE__ ) . "shortcodes/{$shortcode_name}/{$shortcode_name}.php";
		}
	}

	public function load_shortcodes_vc_bridge() {
		include_once plugin_dir_path( __FILE__ ) . "shortcodes/mod-logos-shortcodes-bridge.php";
	}

	public function init_widgets() {
		register_widget( 'Presscore_Inc_Widgets_Logos' );
	}

	/**
	 * Register dynamic stylesheets.
	 *
	 * @param array $dynamic_stylesheets
	 *
	 * @return array
	 */
	public function register_dynamic_stylesheet( $dynamic_stylesheets ) {
		$dynamic_stylesheets['the7-elements-benefits-logo'] = array(
			'path'         => The7pt()->plugin_path() . 'assets/css/legacy/benefits.less',
			'src'          => 'the7-elements-benefits-logo.less',
			'auto_enqueue' => false,
		);

		return $dynamic_stylesheets;
	}
}
