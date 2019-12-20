<?php

/**
 * Assets class.
 * @since       1.0.0
 * @package     dt_the7_core
 */
class The7PT_Assets {

	/**
	 * Setup assets.
	 */
	public static function setup() {
		if ( ! defined( 'PRESSCORE_STYLESHEETS_VERSION' ) || version_compare( PRESSCORE_STYLESHEETS_VERSION, '3.7.0' ) < 0 ) {
			return;
		}

		// Enqueue plugin styles and scripts.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ), 17 );

		// Register dynamic stylesheets.
		add_filter( 'presscore_get_dynamic_stylesheets_list', array( __CLASS__, 'register_dynamic_stylesheet' ) );
	}

	/**
	 * Enqueue scripts.
	 */
	public static function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$template_uri = The7PT()->plugin_url() . 'assets';

		$register_styles = array(
			'the7pt-static' => array(
				'src' => "{$template_uri}/css/post-type{$suffix}.css",
			),
			'the7pt-photo-scroller'    => array(
				'src'     => "{$template_uri}/css/photo-scroller{$suffix}.css",
			),
		);

		foreach ( $register_styles as $name => $props ) {
			$deps = isset( $props['deps'] ) ? $props['deps'] : array();
			wp_register_style( $name, $props['src'], $deps, THE7_VERSION, 'all' );
		}

		$register_scripts = array(
			'the7pt-photo-scroller'    => array(
				'src'     => "{$template_uri}/js/photo-scroller{$suffix}.js",
				'deps'      => array( 'jquery' ),
				'in_footer' => true,
			),
		);

		if (
			! class_exists( 'The7_Admin_Dashboard_Settings' )
			|| The7_Admin_Dashboard_Settings::get( 'portfolio' )
			|| The7_Admin_Dashboard_Settings::get( 'albums' )
		) {
			$register_scripts['the7pt'] = array(
				'src'       => "{$template_uri}/js/post-type{$suffix}.js",
				'deps'      => array( 'jquery' ),
				'in_footer' => true,
			);
		}

		foreach ( $register_scripts as $name => $props ) {
			wp_register_script( $name, $props['src'], $props['deps'], THE7_VERSION, $props['in_footer'] );
		}

		wp_enqueue_script( 'the7pt' );
		wp_enqueue_style( 'the7pt-static' );
	}

	/**
	 * Register dynamic stylesheets.
	 *
	 * @param array $dynamic_stylesheets
	 *
	 * @return array
	 */
	public static function register_dynamic_stylesheet( $dynamic_stylesheets ) {
		$dynamic_stylesheets['the7-elements'] = array(
			'path' => The7pt()->plugin_path() . 'assets/css/dynamic/post-type-dynamic.less',
			'src' => 'post-type-dynamic.less',
		);

		return $dynamic_stylesheets;
	}
}