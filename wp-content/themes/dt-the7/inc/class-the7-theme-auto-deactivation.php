<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Theme_Auto_Deactivation
 */
class The7_Theme_Auto_Deactivation {

	/**
	 * Display auto deactivation notice.
	 */
	public static function deactivation_notice() {
		echo '<p>';
		echo wp_kses_post(
			sprintf(
				_x(
					/* translators: 1: manage tool url, 2: themeforest the7 page url */
					'<strong>Theme was remotely de-registered because current purchase code is registered for another domain.</strong><br>Confused with numerous licenses and websites? Manage them <a href="%1$s" target="_blank">here</a>.<br>You can buy another theme copy <a href="%2$s" target="_blank">here</a>.',
					'admin',
					'the7mk2'
				),
				The7_Remote_API::PURCHASE_CODES_MANAGE_URL,
				The7_Remote_API::THEME_PURCHASE_URL
			)
		);
		echo '</p>';
	}

	/**
	 * Add hooks.
	 */
	public static function add_hooks() {
		add_action( 'admin_notices', array( __CLASS__, 'add_admin_notice' ) );
		add_action( 'the7_after_theme_activation', array( __CLASS__, 'dismiss_admin_notice_on_theme_activation' ) );
		add_action( 'the7_demo_content_before_content_import', array( __CLASS__, 'add_auto_deactivation_check' ) );
		add_filter( 'upgrader_pre_download', array( __CLASS__, 'add_auto_deactivation_check' ), 10, 3 );
	}

	/**
	 * Add admin notice.
	 */
	public static function add_admin_notice() {
		if ( the7_admin_notices()->notice_is_dismissed( 'the7_auto_deactivation' ) ) {
			delete_site_option( 'the7_auto_deactivated' );
		}

		if ( get_site_option( 'the7_auto_deactivated' ) ) {
			the7_admin_notices()->add( 'the7_auto_deactivation', array(
				__CLASS__,
				'deactivation_notice',
			), 'the7-dashboard-notice updated is-dismissible' );
		}
	}

	/**
	 * Dismiss admin notice on theme activation.
	 */
	public static function dismiss_admin_notice_on_theme_activation() {
		the7_admin_notices()->dismiss_notice( 'the7_auto_deactivation' );
	}

	/**
	 * Add auto deactivation check to 'http_response' filter. Used with 'upgrader_pre_download' filter.
	 *
	 * @param bool $r
	 *
	 * @return bool
	 */
	public static function add_auto_deactivation_check( $r = false ) {
		if ( ! has_filter( 'http_response', array( __CLASS__, 'http_response_filter' ) ) ) {
			add_filter( 'http_response', array( __CLASS__, 'http_response_filter' ) );
		}

		return $r;
	}

	/**
	 * Verify purchase code on 403 response header.
	 *
	 * @param $response
	 *
	 * @return array|WP_Error Array containing 'headers', 'body', 'response', 'cookies', 'filename'.
	 *                        A WP_Error instance upon error.
	 */
	public static function http_response_filter( $response ) {
		static $verifying_code = null;

		if ( ! $verifying_code && $response['response']['code'] === 403 && presscore_theme_is_activated() ) {
			$the7_remote_api = new The7_Remote_API( presscore_get_purchase_code() );
			$response_url = $response['http_response']->get_response_object()->url;

			// Prevent recursion.
			$verifying_code = true;
			if ( $the7_remote_api->is_api_url( $response_url ) && ! $the7_remote_api->verify_code() ) {
				the7_admin_notices()->reset( 'the7_auto_deactivation' );
				add_site_option( 'the7_auto_deactivated', true );
				presscore_deactivate_theme();
				presscore_delete_purchase_code();

				return new WP_Error( 'the7_auto_deactivated', __( 'Access denied. Theme was remotely de-registered.', 'the7mk2' ) );
			}
			$verifying_code = null;
		}

		return $response;
	}
}
