<?php
/**
 * The7 options preview class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Options_Preview
 */
class The7_Options_Preview {

	const OPTIONS_PREVIEW_KEY       = 'the7_options_preview';
	const CSS_KEY                   = 'the7_options_preview_css';
	const SAVE_OPTIONS_NONCE_ACTION = 'the7_save_options_preview';
	const SHOW_PREVIEW_NONCE_KEY    = 'the7_show_preview';
	const PREVIEW_SITE_MODE         = 'site';
	const PREVIEW_OPTIONS_MODE      = 'options';

	/**
	 * Bootstrap options preview.
	 */
	public function bootstrap() {
		if ( is_admin() ) {
			add_action( 'wp_ajax_the7_options_make_preview', array( $this, 'make_preview' ) );

			return;
		}

		add_action( 'init', array( $this, 'preview_in_front' ), 30 );
	}

	/**
	 * Ajax callback. Store options and generate css, "return" preview page url.
	 */
	public function make_preview() {
		check_ajax_referer( self::SAVE_OPTIONS_NONCE_ACTION );

		if ( ! isset( $_POST['options'] ) || ! current_user_can( 'edit_theme_options' ) ) {
			die();
		}

		$data = array();
		parse_str( wp_unslash( $_POST['options'] ), $data );
		$options_id = optionsframework_get_options_id();

		if ( empty( $data[ $options_id ] ) ) {
			die();
		}

		$origin_options       = array_merge( optionsframework_get_options(), $data[ $options_id ] );
		$the7_preview_options = optionsframework_sanitize_options_values(
			optionsframework_get_page_options( false ),
			$origin_options,
			optionsframework_presets_data( $origin_options['preset'] )
		);

		$this->save_options_for_preview( $the7_preview_options );
		$this->save_css();

		die( esc_url( self::get_preview_url( self::PREVIEW_OPTIONS_MODE ) ) );
	}

	/**
	 * Make various actions to support previewing in the front-end.
	 */
	public function preview_in_front() {
		$preview_mode = $this->get_preview_mode();
		if ( ! $preview_mode || ! isset( $_GET['_wpnonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), self::SHOW_PREVIEW_NONCE_KEY ) ) {
			return;
		}

		show_admin_bar( false );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if ( $preview_mode === self::PREVIEW_OPTIONS_MODE ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'override_stylesheets' ), 9999 );
			add_filter( 'dt_of_get_option', array( $this, 'override_theme_options' ) );
		}
	}

	/**
	 * Enqueue preview scripts.
	 */
	public function enqueue_scripts() {
		$preview_mode = $this->get_preview_mode();
		if ( ! $preview_mode ) {
			return;
		}

		the7_register_script( 'the7-options-preview', PRESSCORE_ADMIN_URI . '/assets/js/options-front-end-mode' );
		wp_enqueue_script( 'the7-options-preview' );
		wp_localize_script(
			'the7-options-preview',
			'the7OptionsPreview',
			array(
				'urlQueryArgs' => self::get_preview_url_query_args( $preview_mode ),
			)
		);
	}

	/**
	 * Override theme style with inline css.
	 */
	public function override_stylesheets() {
		$dynamic_stylesheets = array_keys( presscore_get_dynamic_stylesheets_list() );
		foreach ( $dynamic_stylesheets as $stylesheet_handler ) {
			wp_dequeue_style( $stylesheet_handler );
		}
		wp_add_inline_style( 'style', $this->get_css() );
	}

	/**
	 * Override theme options.
	 *
	 * @param array $options Theme options.
	 *
	 * @return array
	 */
	public function override_theme_options( $options ) {
		$preview_options = $this->get_options_for_preview();

		return $preview_options;
	}

	/**
	 * Save theme options for preview.
	 *
	 * @param array $options Theme options.
	 *
	 * @return bool
	 */
	public function save_options_for_preview( $options ) {
		return set_transient( self::OPTIONS_PREVIEW_KEY, $options, 5 * MINUTE_IN_SECONDS );
	}

	/**
	 * Return theme options for preview.
	 *
	 * @return array
	 */
	public function get_options_for_preview() {
		return get_transient( self::OPTIONS_PREVIEW_KEY );
	}

	/**
	 * Return preview mode. Can be 'site' or 'options'.
	 *
	 * @return bool|string
	 */
	public function get_preview_mode() {
		if ( ! isset( $_GET['the7_preview'] ) ) {
			return false;
		}

		$preview_mode = $_GET['the7_preview'];
		if ( ! in_array( $preview_mode, array( self::PREVIEW_SITE_MODE, self::PREVIEW_OPTIONS_MODE ), true ) ) {
			return false;
		}

		return $preview_mode;
	}

	/**
	 * Generate and save css for preview.
	 */
	protected function save_css() {
		add_filter( 'dt_of_get_option', array( $this, 'override_theme_options' ) );
		$dynamic_stylesheets = presscore_get_dynamic_stylesheets_list();
		$inline_css          = the7_generate_dynamic_css_as_text( $dynamic_stylesheets );
		remove_filter( 'dt_of_get_option', array( $this, 'override_theme_options' ) );

		set_transient( self::CSS_KEY, implode( "\n/***/\n", $inline_css ), 5 * MINUTE_IN_SECONDS );
	}

	/**
	 * Return css for preview.
	 *
	 * @return string
	 */
	protected function get_css() {
		return get_transient( self::CSS_KEY );
	}

	/**
	 * Return preview url based on $base_url.
	 *
	 * @param string      $mode Preview mode.
	 * @param null|string $base_url Base url. home_url() is used if empty.
	 *
	 * @return string
	 */
	public static function get_preview_url( $mode, $base_url = null ) {
		if ( ! $base_url ) {
			$base_url = home_url();
		}

		return add_query_arg(
			self::get_preview_url_query_args( $mode ),
			$base_url
		);
	}

	/**
	 * Return preview url query args.
	 *
	 * @param string $mode Preview mode.
	 *
	 * @return array
	 */
	public static function get_preview_url_query_args( $mode ) {
		return array(
			'the7_preview' => rawurlencode( $mode ),
			'_wpnonce'     => wp_create_nonce( self::SHOW_PREVIEW_NONCE_KEY ),
		);
	}
}
