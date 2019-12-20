<?php
/**
 * The7 ReCaptcha class.
 *
 * @since 7.8.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_ReCaptcha
 */
class The7_ReCaptcha {

	/**
	 * The site key.
	 *
	 * @var string
	 */
	protected $site_key;

	/**
	 * The secret key.
	 *
	 * @var string
	 */
	protected $secret_key;

	/**
	 * The7_ReCaptcha constructor.
	 */
	public function __construct() {
		$this->site_key   = (string) of_get_option( 'contact_form_recaptcha_site_key' );
		$this->secret_key = (string) of_get_option( 'contact_form_recaptcha_secret_key' );
	}

	/**
	 * Return captcha secret key.
	 *
	 * @return string
	 */
	public function get_secret_key() {
		return $this->secret_key;
	}

	/**
	 * Return captcha site key.
	 *
	 * @return string
	 */
	public function get_site_key() {
		return $this->site_key;
	}

	/**
	 * Return true if both secret and site keys are set.
	 *
	 * @return bool
	 */
	public function is_active() {
		return $this->secret_key && $this->site_key;
	}

	/**
	 * Return true if provided token is valid and false otherwise.
	 *
	 * @param string $token      Google captcha token.
	 *
	 * @return bool
	 */
	public function validate_token( $token ) {
		$recaptcha_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
		$url                  = add_query_arg(
			array(
				'secret'   => $this->get_secret_key(),
				'response' => rawurlencode( $token ),
			),
			$recaptcha_verify_url
		);
		$response             = wp_remote_post( esc_url_raw( $url ) );
		if ( is_wp_error( $response ) ) {
			return false;
		}
		if ( wp_remote_retrieve_response_code( $response ) !== 200 ) {
			return false;
		}
		$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! isset( $response_body['success'] ) ) {
			return false;
		}

		return (bool) $response_body['success'];
	}

	/**
	 * Enqueue google ReCaptcha api js if not enqueued already.
	 */
	public function enqueue_scripts() {
		if ( ! wp_script_is( 'google-recaptcha', 'enqueued' ) ) {
			$url = add_query_arg( array( 'render' => 'explicit' ), 'https://www.google.com/recaptcha/api.js' );
			wp_enqueue_script( 'google-recaptcha', esc_url_raw( $url ), null, '2.0', true );
		}
	}
}
