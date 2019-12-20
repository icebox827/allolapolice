<?php
/**
 * Modules manager class.
 *
 * @since       1.0.0
 * @package     dt_the7_core
 */

class The7PT_Modules {

	/**
	 * Setup modules.
	 */
	public static function setup() {
		// Load modoules.
		add_action( 'after_setup_theme', array( __CLASS__, 'load' ) );

		// Filter located templates.
		add_filter( 'presscore_template_manager_located_template', array( __CLASS__, 'locate_templates' ), 10, 2 );

		// Flush rewrite rules after plugin activation.
		if ( get_option( 'the7pt_flush_rewrite_rules' ) ) {
			add_action( 'init', 'flush_rewrite_rules' );
			update_option( 'the7pt_flush_rewrite_rules', false );
		}
	}

	/**
	 * Load modules.
	 */
	public static function load() {
		$plugin_path = The7PT()->plugin_path();

		require_once  "{$plugin_path}mods/portfolio/public/shortcodes/portfolio-masonry/class-dt-portfolio-shortcode-html.php";

		$supported_modules = get_theme_support( 'presscore-modules' );
		if ( ! empty( $supported_modules[0] ) ) {
			foreach ( $supported_modules[0] as $module ) {
				$file_path = $plugin_path . "mods/{$module}/{$module}.php";
				if ( file_exists( $file_path ) ) {
					include $file_path;
				}
			}

			require_once "{$plugin_path}/includes/functions.php";
		}
	}

	/**
	 * Process modules templates.
	 *
	 * @param $located_template
	 * @param $template_names
	 *
	 * @return string
	 */
	public static function locate_templates( $located_template, $template_names ) {
		if ( ! $located_template && $template_names ) {
			foreach ( $template_names as $template_name ) {
				$template_path = The7PT()->plugin_path() . $template_name;
				if ( file_exists( $template_path ) ) {
					return $template_path;
				}
			}
		}

		return $located_template;
	}

}