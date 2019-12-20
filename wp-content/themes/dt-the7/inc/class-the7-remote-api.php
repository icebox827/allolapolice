<?php
/**
 * The7 remote api.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Remote_API
 */
class The7_Remote_API {

	const THEMEFOREST_THEME_ID = '5556590';

	const THEME_PURCHASE_URL = 'https://themeforest.net/item/the7-responsive-multipurpose-wordpress-theme/5556590?ref=Dream-Theme&license=regular&open_purchase_for_item_id=5556590';

	const THEME_THEMEFOREST_PAGE_URL = 'https://themeforest.net/item/the7-responsive-multipurpose-wordpress-theme/5556590';

	const LICENSE_URL = 'https://themeforest.net/licenses/standard';

	const PURCHASE_CODES_MANAGE_URL = 'https://repo.the7.io/manage/';

	/**
	 * @var string
	 */
	protected $api_register_url = 'https://repo.the7.io/register.php';

	/**
	 * @var string
	 */
	protected $api_de_register_url = 'https://repo.the7.io/de_register.php';

	/**
	 * @var string
	 */
	protected $api_theme_info_url = 'https://repo.the7.io/theme/info.json';

	/**
	 * @var string
	 */
	protected $api_download_theme_url = 'https://repo.the7.io/theme/download.php';

	/**
	 * @var string
	 */
	protected $api_plugins_list_url = 'https://repo.the7.io/plugins/list.json';

	/**
	 * @var string
	 */
	protected $api_download_plugin_url = 'https://repo.the7.io/plugins/download.php';

	/**
	 * @var string
	 */
	protected $api_verify_purchase_code = 'https://repo.the7.io/verify-code.php';

	/**
	 * @var string
	 */
	protected $api_critical_alert = 'https://repo.the7.io/get-alert/';

	/**
	 * @var array
	 */
	protected $strings = array();

	/**
	 * @var string
	 */
	protected $code = '';

	/**
	 * The7_Remote_API constructor.
	 *
	 * @param $code
	 */
	public function __construct( $code ) {
		if ( defined( 'DT_REMOTE_API_REGISTER_URL' ) && DT_REMOTE_API_REGISTER_URL ) {
			$this->api_register_url = DT_REMOTE_API_REGISTER_URL;
		}

		if ( defined( 'DT_REMOTE_API_DE_REGISTER_URL' ) && DT_REMOTE_API_DE_REGISTER_URL ) {
			$this->api_de_register_url = DT_REMOTE_API_DE_REGISTER_URL;
		}

		if ( defined( 'DT_REMOTE_API_THEME_INFO_URL' ) && DT_REMOTE_API_THEME_INFO_URL ) {
			$this->api_theme_info_url = DT_REMOTE_API_THEME_INFO_URL;
		}

		if ( defined( 'DT_REMOTE_API_DOWNLOAD_THEME_URL' ) && DT_REMOTE_API_DOWNLOAD_THEME_URL ) {
			$this->api_download_theme_url = DT_REMOTE_API_DOWNLOAD_THEME_URL;
		}

		if ( defined( 'DT_REMOTE_API_PLUGINS_LIST_URL' ) && DT_REMOTE_API_PLUGINS_LIST_URL ) {
			$this->api_plugins_list_url = DT_REMOTE_API_PLUGINS_LIST_URL;
		}

		if ( defined( 'DT_REMOTE_API_DOWNLOAD_PLUGIN_URL' ) && DT_REMOTE_API_DOWNLOAD_PLUGIN_URL ) {
			$this->api_download_plugin_url = DT_REMOTE_API_DOWNLOAD_PLUGIN_URL;
		}

		if ( defined( 'DT_REMOTE_API_VERIFY_PURCHASE_CODE' ) && DT_REMOTE_API_VERIFY_PURCHASE_CODE ) {
			$this->api_verify_purchase_code = DT_REMOTE_API_VERIFY_PURCHASE_CODE;
		}

		if ( defined( 'DT_REMOTE_API_CRITICAL_ALERT' ) && DT_REMOTE_API_CRITICAL_ALERT ) {
			$this->api_critical_alert = DT_REMOTE_API_CRITICAL_ALERT;
		}

		$this->code = $code;

		$this->strings['fs_unavailable'] = __( 'Could not access filesystem.', 'the7mk2' );
		$this->strings['fs_error']       = __( 'Filesystem error.', 'the7mk2' );
		/* translators: %s: directory name */
		$this->strings['fs_no_folder']         = __( 'Unable to locate needed folder (%s).', 'the7mk2' );
		$this->strings['download_failed']      = __( 'Download failed.', 'the7mk2' );
		$this->strings['incompatible_archive'] = __( 'The package could not be installed.', 'the7mk2' );
		$this->strings['bad_request']          = __( 'Bad request.', 'the7mk2' );
		$this->strings['invalid_response']     = __( 'Invalid response.', 'the7mk2' );
	}

	/**
	 * @return array|WP_Error
	 */
	public function register_purchase_code() {
		$args     = array(
			'timeout'    => 30,
			'body'       => array(
				'code' => urlencode( $this->code ),
			),
		);
		$response = wp_remote_post( $this->api_register_url, $args );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( '200' != $response_code ) {
			$error_msg = $response_code . ': ' . $this->strings['bad_request'];

			if ( the7_is_debug_on() ) {
				$error_msg .= '<br>Response dump:';
				ob_start();
				var_dump( $response );
				$error_msg .= ob_get_clean();
			}

			return new WP_Error( 'bad_request', $error_msg );
		}

		$code_check = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( isset( $code_check['errors'] ) ) {
			return new WP_Error( 'remote_api_error', $code_check['errors'] );
		}

		if ( empty( $code_check['success'] ) ) {
			$error_msg = $this->strings['invalid_response'];

			if ( the7_is_debug_on() ) {
				$error_msg .= '<br>Response dump:';
				ob_start();
				var_dump( $response );
				$error_msg .= ob_get_clean();
			}

			return new WP_Error( 'invalid_response', $error_msg );
		}

		return $code_check;
	}

	/**
	 * @return array|bool|WP_Error
	 */
	public function de_register_purchase_code() {
		$args     = array(
			'timeout'    => 30,
			'body'       => array(
				'code' => urlencode( $this->code ),
			),
		);
		$response = wp_remote_post( $this->api_de_register_url, $args );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( '200' != wp_remote_retrieve_response_code( $response ) ) {
			return new WP_Error( 'bad_request', $this->strings['bad_request'] );
		}

		$code_check = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( isset( $code_check['errors'] ) ) {
			return new WP_Error( 'remote_api_error', $code_check['errors'] );
		}

		if ( empty( $code_check['success'] ) ) {
			return new WP_Error( 'invalid_response', $this->strings['invalid_response'] );
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function verify_code() {
		$url      = add_query_arg( 'code', $this->code, $this->api_verify_purchase_code );
		$response = $this->remote_get_json( $url );
		if ( ! is_wp_error( $response ) && array_key_exists(
				'code',
				$response
			) && $response['code'] === 'deregistered' ) {
			return false;
		}

		return true;
	}

	public function is_api_url( $url ) {
		$host = @parse_url( $url, PHP_URL_HOST );

		return strpos( $this->api_download_plugin_url, $host ) !== false;
	}

	/**
	 * Check theme update info.
	 *
	 * @return array|WP_Error
	 */
	public function check_theme_update() {
		return $this->remote_get_json( $this->api_theme_info_url );
	}

	/**
	 * Return theme download url.
	 *
	 * @param string $version Required theme version.
	 *
	 * @return string
	 */
	public function get_theme_download_url( $version = '' ) {
		$query_args = array(
			'code' => $this->code,
		);

		if ( $version ) {
			$query_args['version'] = $version;
		}

		return add_query_arg( $query_args, $this->api_download_theme_url );
	}

	/**
	 * Get plugins list.
	 *
	 * @return array|WP_Error
	 */
	public function check_plugins_list() {
		return $this->remote_get_json( $this->api_plugins_list_url );
	}

	/**
	 * @param string $slug
	 *
	 * @return string
	 */
	public function get_plugin_download_url( $slug ) {
		return add_query_arg( array( 'code' => $this->code, 'item' => $slug ), $this->api_download_plugin_url );
	}

	/**
	 * Return critical alert body as array or WP_Error on error.
	 *
	 * @return array|WP_Error
	 */
	public function get_critical_alert() {
		return $this->remote_get_json( add_query_arg( array( 'code' => $this->code ), $this->api_critical_alert ) );
	}

	/**
	 * @param string $url
	 *
	 * @return array|WP_Error
	 */
	protected function remote_get_json( $url ) {
		$response = wp_remote_get( $url, array( 'timeout' => 30 ) );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( '200' != wp_remote_retrieve_response_code( $response ) ) {
			return new WP_Error( 'bad_request', $this->strings['bad_request'] );
		}

		$json = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $json ) || ! is_array( $json ) ) {
			return new WP_Error( 'invalid_response', $this->strings['invalid_response'] );
		}

		return $json;
	}
}
