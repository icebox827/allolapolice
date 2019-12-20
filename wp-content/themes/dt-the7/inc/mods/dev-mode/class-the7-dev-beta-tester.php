<?php

/**
 * Class The7_Dev_Beta_Tester
 */
class The7_Dev_Beta_Tester {

	/**
	 * Bootstrap.
	 */
	public static function init() {
		add_action( 'load-toplevel_page_the7-dev', array( __CLASS__, 'save_mode' ) );
		add_action( 'init', array( __CLASS__, 'switch_to_beta_server' ) );
	}

	/**
	 * Save beta tester mode.
	 */
	public static function save_mode() {
		if ( ! check_ajax_referer( 'the7-dev-beta-tester', false, false ) || ! current_user_can( 'switch_themes' )  ) {
			return;
		}

		if ( ! isset( $_POST['save'] ) ) {
			return;
		}

		self::set_status(  (int) isset( $_POST['beta-tester'] ) );

		// Force update plugins list on next page load.
		delete_site_option( 'the7_plugins_last_check' );
	}

	/**
	 * Get beta tester status.
	 *
	 * @return mixed
	 */
	public static function get_status() {
		return get_site_option( 'the7-beta-tester', 0 );
	}

	/**
	 * Set beta tester status.
	 *
	 * @param mixed $val
	 */
	public static function set_status( $val ) {
		update_site_option( 'the7-beta-tester', $val );
	}

	/**
	 * Load theme and plugins from beta server.
	 */
	public static function switch_to_beta_server() {
		if ( ! self::get_status() ) {
			return;
		}

		$beta_domain = 'https://repo.the7.io/beta';
		$constants = array(
			'DT_REMOTE_API_THEME_INFO_URL' => "{$beta_domain}/theme/info.php",
			'DT_REMOTE_API_DOWNLOAD_THEME_URL' => "{$beta_domain}/theme/download.php",
			'DT_REMOTE_API_PLUGINS_LIST_URL' => "{$beta_domain}/plugins/list.php",
			'DT_REMOTE_API_DOWNLOAD_PLUGIN_URL' => "{$beta_domain}/plugins/download.php",
		);

		foreach ( $constants as $constant => $value ) {
			if ( ! defined( $constant ) ) {
				define( $constant, $value );
			}
		}
	}
}
