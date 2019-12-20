<?php
/**
 * DT Dummy remote API. Used to communicate with DT dummy server.
 *
 * @since 2.0.0
 * @package dt-dummy/includes
 */

class The7_demo_Content_Remote_Server_API {

	/**
	 * @var string
	 */
	private $api_remote_info_url = 'https://repo.the7.io/demo-content/list.json';

	/**
	 * @var string
	 */
	private $api_remote_download_url = 'https://repo.the7.io/demo-content/download.php';

	/**
	 * @var array
	 */
	private $strings = array();

	/**
	 * DT_Dummy_Remote_Server_API constructor.
	 */
	public function __construct() {
		if ( defined( 'DT_REMOTE_API_DEMO_CONTENT_LIST_URL' ) && DT_REMOTE_API_DEMO_CONTENT_LIST_URL ) {
			$this->api_remote_info_url = DT_REMOTE_API_DEMO_CONTENT_LIST_URL;
		}

		if ( defined( 'DT_REMOTE_API_DEMO_CONTENT_DOWNLOAD_URL' ) && DT_REMOTE_API_DEMO_CONTENT_DOWNLOAD_URL ) {
			$this->api_remote_download_url = DT_REMOTE_API_DEMO_CONTENT_DOWNLOAD_URL;
		}

		$this->strings['fs_unavailable'] = __('Could not access filesystem.', 'the7mk2');
		$this->strings['fs_error'] = __('Filesystem error.', 'the7mk2');
		/* translators: %s: directory name */
		$this->strings['fs_no_folder'] = __('Unable to locate needed folder (%s).', 'the7mk2');

		$this->strings['download_failed'] = __('Download failed.', 'the7mk2');
		$this->strings['incompatible_archive'] = __('The package could not be installed.', 'the7mk2');
	}

	/**
	 * This method get dummy items list from the DT remote server.
	 *
	 * Return array on wp_remote_get success or false otherwise. May return empty array if received data is not valid json.
	 *
	 * @return array|bool
	 */
	public function get_items_list() {
		$response = wp_remote_get( $this->api_remote_info_url, array(
			'timeout' => 30,
			'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . network_site_url(),
		) );

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( is_wp_error( $response ) || 200 != $response_code ) {
			return false;
		}

		$response_body = wp_remote_retrieve_body( $response );

		return json_decode( $response_body, true );
	}

	/**
	 * This method try to download dummy content with $id and put it to $target_path.
	 * Creates $target_path dir if it is not exists. Dummy content zip archive will be unzipped.
	 *
	 * @param string $id
	 * @param string $code
	 * @param string $target_dir
	 * @param string $req_url
	 *
	 * @return string|WP_Error Path where dummy content files is located on success or WP_Error on failure.
	 */
	public function download_dummy( $id, $code, $target_dir, $req_url = '' ) {
		/**
		 * @var $wp_filesystem WP_Filesystem_Base
		 */
		global $wp_filesystem;

		if ( ! $wp_filesystem && ! WP_Filesystem() ) {
			return new WP_Error( 'fs_unavailable', $this->strings['fs_unavailable'] );
		}

		if ( is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
			return new WP_Error( 'fs_error', $this->strings['fs_error'], $wp_filesystem->errors );
		}

		$request_url_args = array(
			'item'    => $id,
			'code'    => $code,
			'req_url' => rawurlencode( $req_url ),
		);
		$request_url      = add_query_arg( $request_url_args, $this->api_remote_download_url );
		$remote_response  = wp_safe_remote_get( $request_url, array(
			'timeout'    => 300,
			'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . network_site_url(),
		) );

		if ( is_wp_error( $remote_response ) ) {
			return $remote_response;
		}

		$response_code = (int) wp_remote_retrieve_response_code( $remote_response );

		if ( ! is_array( $remote_response ) || 200 !== $response_code ) {
			return new WP_Error( 'download_failed', $this->strings['download_failed'] );
		}

		wp_mkdir_p( $target_dir );

		$file_content  = wp_remote_retrieve_body( $remote_response );
		$zip_file_name = trailingslashit( $target_dir ) . "{$id}.zip";
		$wp_filesystem->put_contents( $zip_file_name, $file_content );

		$unzip_result = unzip_file( $zip_file_name, $target_dir );
		if ( is_wp_error( $unzip_result ) ) {
			return new WP_Error( 'incompatible_archive', $this->strings['incompatible_archive'], $unzip_result );
		}

		$dummy_dir = trailingslashit( $target_dir ) . $id;

		if ( ! is_dir( $dummy_dir ) ) {
			return new WP_Error( 'fs_no_folder', sprintf( $this->strings['fs_no_folder'], $dummy_dir ) );
		}

		return $dummy_dir;
	}
}