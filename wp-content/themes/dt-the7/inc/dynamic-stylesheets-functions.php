<?php
/**
 * Dynamic stylesheets functions.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'presscore_get_dynamic_stylesheets_list' ) ) :

	/**
	 * Return list of dynamic stylesheets.
	 *
	 * @return array
	 */
	function presscore_get_dynamic_stylesheets_list() {
		static $dynamic_stylesheets = null;

		if ( null === $dynamic_stylesheets ) {
			$dynamic_stylesheets = array();

			$dynamic_import_top    = array(
				'dynamic-less/plugins/gutenberg.less',
			);
			$dynamic_import_bottom = array();

			if ( The7_Admin_Dashboard_Settings::get( 'overlapping-headers' ) ) {
				$dynamic_import_bottom[] = 'legacy/overlap-header.less';
			}

			switch ( of_get_option( 'header-layout' ) ) {
				case 'classic':
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_horizontal-headers.less';
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_classic-header.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_horizontal-headers.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_classic-header.less';
					break;
				case 'inline':
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_horizontal-headers.less';
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_inline-header.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_horizontal-headers.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_inline-header.less';
					break;
				case 'split':
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_horizontal-headers.less';
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_split-header.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_horizontal-headers.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_split-header.less';
					break;
				case 'side':
					$dynamic_import_top[]    = 'dynamic-less/plugins/jquery.mCustomScrollbar.less';
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_vertical-headers.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_vertical-headers.less';
					break;
				case 'top_line':
				case 'side_line':
				case 'menu_icon':
					$dynamic_import_top[]    = 'dynamic-less/plugins/jquery.mCustomScrollbar.less';
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_mixed-headers.less';
					$dynamic_import_top[]    = 'dynamic-less/header/header-layouts/static/_vertical-headers.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_mixed-headers.less';
					$dynamic_import_bottom[] = 'dynamic-less/header/header-layouts/_vertical-headers.less';
					break;
			}

			$dynamic_stylesheets['dt-custom'] = array(
				'src'     => 'custom.less',
				'imports' => compact( 'dynamic_import_top', 'dynamic_import_bottom' ),
			);

			if ( dt_is_woocommerce_enabled() ) {
				$dynamic_stylesheets['wc-dt-custom'] = array(
					'src' => 'compatibility/wc-dt-custom.less',
				);
			}

			if ( presscore_responsive() ) {
				$dynamic_stylesheets['dt-media'] = array(
					'src' => 'media.less',
				);
			}

			if ( The7_Admin_Dashboard_Settings::get( 'mega-menu' ) ) {
				$dynamic_stylesheets['the7-mega-menu'] = array(
					'src' => 'mega-menu.less',
				);
			}

			if ( The7_Admin_Dashboard_Settings::get( 'rows' ) ) {
				$dynamic_stylesheets['the7-stripes'] = array(
					'src'          => 'legacy/stripes.less',
					'auto_enqueue' => false,
				);
			}
		}

		$dynamic_stylesheets = apply_filters( 'presscore_get_dynamic_stylesheets_list', $dynamic_stylesheets );

		// Backward compatibility.
		foreach ( $dynamic_stylesheets as &$stylesheet ) {
			$stylesheet['src'] = str_replace( PRESSCORE_THEME_URI . '/css/', '', $stylesheet['src'] );
		}

		return $dynamic_stylesheets;
	}

endif;

if ( ! function_exists( 'presscore_get_admin_dynamic_stylesheets_list' ) ) {

	/**
	 * Return array of admin dynamic css.
	 *
	 * @since 7.2.0
	 *
	 * @return array
	 */
	function presscore_get_admin_dynamic_stylesheets_list() {
		return array(
			'the7-admin-custom' => array(
				'src' => 'admin-custom.less',
			),
		);
	}
}

if ( ! function_exists( 'presscore_enqueue_dynamic_stylesheets' ) ) :

	/**
	 * Enqueue *.less files
	 */
	function presscore_enqueue_dynamic_stylesheets() {
		$dynamic_stylesheets = presscore_get_dynamic_stylesheets_list();
		$css_cache           = presscore_get_dynamic_css_cache();
		$css_version         = presscore_get_dynamic_css_version();

		foreach ( $dynamic_stylesheets as $handle => $stylesheet ) {
			$stylesheet_obj = new The7_Dynamic_Stylesheet( $handle, $stylesheet['src'] );
			$stylesheet_obj->setup_with_array( $stylesheet );
			$stylesheet_obj->set_version( $css_version );

			if ( is_array( $css_cache ) && array_key_exists( $handle, $css_cache ) ) {
				$stylesheet_obj->set_css_body( $css_cache[ $handle ] );
			}

			$stylesheet_obj->register();

			if ( ! isset( $stylesheet['auto_enqueue'] ) || $stylesheet['auto_enqueue'] === true ) {
				$stylesheet_obj->enqueue();
			}
		}

		do_action( 'presscore_enqueue_dynamic_stylesheets' );
	}

endif;

if ( ! function_exists( 'presscore_regenerate_dynamic_css' ) ) :

	/**
	 * Generate css from dynamic stylesheets list.
	 *
	 * @param array $dynamic_css Dynamic stylesheets list.
	 */
	function presscore_regenerate_dynamic_css( $dynamic_css ) {
		include_once PRESSCORE_DIR . '/less-vars.php';

		$wp_upload = wp_get_upload_dir();
		$less_vars = presscore_compile_less_vars();
		$lessc     = new The7_Less_Compiler( $less_vars );

		// Compile beautiful loading css.
		$beautiful_loading_css = $lessc->compile_file( The7_Dynamic_Stylesheet::get_theme_css_dir() . '/beautiful-loading.less' );
		presscore_cache_loader_inline_css( $beautiful_loading_css );
		unset( $beautiful_loading_css );

		if ( $lessc->is_writable( $wp_upload['basedir'] ) ) {
			update_option( 'presscore_less_css_is_writable', 1 );
			presscore_set_dynamic_css_cache( array() );

			// Save version.
			$stylesheet_version = substr( md5( PRESSCORE_STYLESHEETS_VERSION . '-' . time() ), 20 );
			presscore_set_dynamic_css_version( $stylesheet_version );

			// Compile less.
			foreach ( $dynamic_css as $handle => $stylesheet ) {
				$stylesheet_obj = new The7_Dynamic_Stylesheet( $handle, $stylesheet['src'] );

				if ( ! empty( $stylesheet['path'] ) ) {
					$stylesheet_obj->set_less_file( $stylesheet['path'] );
				}

				$imports = empty( $stylesheet['imports'] ) ? array() : $stylesheet['imports'];
				$lessc->compile_to_file(
					$stylesheet_obj->get_less_file(),
					$stylesheet_obj->get_css_file(),
					$imports
				);
			}
		} else {
			update_option( 'presscore_less_css_is_writable', 0 );

			// Save css body in db.
			$dynamic_css_cache = array();
			foreach ( $dynamic_css as $handle => $stylesheet ) {
				$stylesheet_obj = new The7_Dynamic_Stylesheet( $handle, $stylesheet['src'] );

				if ( ! empty( $stylesheet['path'] ) ) {
					$stylesheet_obj->set_less_file( $stylesheet['path'] );
				}

				$dynamic_css_cache[ $handle ] = $lessc->compile_file( $stylesheet_obj->get_less_file() );
			}
			presscore_set_dynamic_css_cache( $dynamic_css_cache );
		}
	}

endif;

function the7_generate_dynamic_css_as_text( $dynamic_css ) {
	include_once PRESSCORE_DIR . '/less-vars.php';

	$less_vars = presscore_compile_less_vars();
	$lessc     = new The7_Less_Compiler( $less_vars );

	$dynamic_css_cache = array();
	foreach ( $dynamic_css as $handle => $stylesheet ) {
		$stylesheet_obj = new The7_Dynamic_Stylesheet( $handle, $stylesheet['src'] );

		if ( ! empty( $stylesheet['path'] ) ) {
			$stylesheet_obj->set_less_file( $stylesheet['path'] );
		}

		$imports = empty( $stylesheet['imports'] ) ? array() : $stylesheet['imports'];
		$dynamic_css_cache[ $handle ] = $lessc->compile_file( $stylesheet_obj->get_less_file(), $imports );
	}

	return $dynamic_css_cache;
}

/**
 * Store CSS code of each stylesheet to be enqueued inline.
 *
 * @param array $dynamic_css Array of compiled dynamic stylesheets.
 */
function presscore_set_dynamic_css_cache( $dynamic_css ) {
	update_option( 'the7_dynamic_css_cache', $dynamic_css );
}

/**
 * Return an array of compiled CSS code of each dynamic stylesheet.
 *
 * @return array
 */
function presscore_get_dynamic_css_cache() {
	return (array) get_option( 'the7_dynamic_css_cache', array() );
}

/**
 * Set dynamic css version.
 *
 * @param string $version Dynamic css version.
 */
function presscore_set_dynamic_css_version( $version ) {
	update_option( 'the7_dynamic_css_version', $version );
}

/**
 * Return dynamic css version.
 *
 * @return string|bool
 */
function presscore_get_dynamic_css_version() {
	return get_option( 'the7_dynamic_css_version' );
}

if ( ! function_exists( 'the7_maybe_regenerate_dynamic_css' ) ) :

	/**
	 * Regenerate dynamic css by force if needed.
	 *
	 * This function used mostly for after theme update stylesheets refresh.
	 *
	 * @since 5.5.0
	 */
	function the7_maybe_regenerate_dynamic_css() {
		$force_regenerate = presscore_force_regenerate_css();

		// Regenerate dynamic stylesheets if their definitions are changed.
		$dynamic_stylesheets      = presscore_get_dynamic_stylesheets_list();
		$dynamic_stylesheets_hash = md5( wp_json_encode( $dynamic_stylesheets ) );
		if ( $dynamic_stylesheets_hash !== get_option( 'the7_last_dynamic_stylesheets_hash' ) ) {
			$force_regenerate = true;
			update_option( 'the7_last_dynamic_stylesheets_hash', $dynamic_stylesheets_hash );
		}

		if ( ! $force_regenerate ) {
			return;
		}

		presscore_set_force_regenerate_css( false );
		$admin_dynamic_css = presscore_get_admin_dynamic_stylesheets_list();

		try {
			presscore_regenerate_dynamic_css( array_merge( $dynamic_stylesheets, $admin_dynamic_css ) );
		} catch ( Exception $e ) {
			// Do nothing.
		}
	}

endif;

if ( ! function_exists( 'presscore_compile_loader_css' ) ) :

	/**
	 * Compile inline loader css from .less files.
	 *
	 * Compiled css will be cached in db. Lunches after theme options save.
	 *
	 * @since  3.3.2
	 * @return string
	 */
	function presscore_compile_loader_css() {
		include_once PRESSCORE_DIR . '/less-vars.php';

		try {
			$less_vars = presscore_compile_less_vars();
			$lessc     = new The7_Less_Compiler( $less_vars );
			$css       = $lessc->compile_file( The7_Dynamic_Stylesheet::get_theme_css_dir() . '/beautiful-loading.less' );
		} catch ( Exception $e ) {
			return '';
		}

		return $css;
	}

endif;

if ( ! function_exists( 'presscore_cache_loader_inline_css' ) ) :

	/**
	 * Store beautiful loader css.
	 *
	 * @since 3.3.2
	 *
	 * @param  string $css CSS code.
	 *
	 * @return string
	 */
	function presscore_cache_loader_inline_css( $css ) {
		update_option( 'the7_beautiful_loader_inline_css', $css );

		return $css;
	}

endif;

if ( ! function_exists( 'presscore_get_loader_inline_css' ) ) :

	/**
	 * This function returns compiled loader css.
	 *
	 * First of all function attempts to read css from cache, if false then regenerate it manually.
	 *
	 * @since 3.3.2
	 *
	 * @return string
	 */
	function presscore_get_loader_inline_css() {
		$css = apply_filters( 'presscore_pre_get_loader_inline_css', '' );
		if ( $css ) {
			return $css;
		}

		$css = get_option( 'the7_beautiful_loader_inline_css' );

		return apply_filters( 'presscore_get_loader_inline_css', $css );
	}

endif;

if ( ! function_exists( 'presscore_force_regenerate_css' ) ) :

	/**
	 * Get regenerate css from less flag.
	 *
	 * @return boolean
	 */
	function presscore_force_regenerate_css() {
		return get_option( 'the7_force_regen_css' );
	}

endif;

if ( ! function_exists( 'presscore_set_force_regenerate_css' ) ) :

	/**
	 * Set force regenerate css from less flag.
	 *
	 * @param  boolean $force Force regenerate dunamic css.
	 *
	 * @return boolean
	 */
	function presscore_set_force_regenerate_css( $force = false ) {
		return update_option( 'the7_force_regen_css', $force );
	}

endif;

if ( ! function_exists( 'presscore_refresh_dynamic_css' ) ) :

	/**
	 * Setup theme to regen dynamic stylesheets on next page load.
	 *
	 * @since 3.7.0
	 */
	function presscore_refresh_dynamic_css() {
		presscore_set_force_regenerate_css( true );
		presscore_cache_loader_inline_css( '' );
	}

endif;
