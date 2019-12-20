<?php
/**
 * The7 dev tools class.
 *
 * @package The7/Dev
 */

defined( 'ABSPATH' ) || exit;

class The7_Dev_Tools {

	/**
	 * Form post action handler.
	 */
	public static function use_tool() {
		if ( ! check_ajax_referer( 'the7-dev-tools', false, false ) ) {
			return;
		}

		if ( ! current_user_can( 'switch_themes' ) ) {
			return;
		}

		if ( empty( $_POST['tool'] ) ) {
			return;
		}

		$tool = $_POST['tool'];
		if ( is_callable( __CLASS__ . "::tool_$tool" ) ) {
			call_user_func( __CLASS__ . "::tool_$tool" );
		}

		wp_safe_redirect( admin_url( 'admin.php?page=the7-dev' ) );
		exit();
	}

	/**
	 * Regenerate shortcodes css.
	 */
	public static function tool_regenerate_shortcodes_css() {
		include_once PRESSCORE_MODS_DIR . '/theme-update/the7-update-utility-functions.php';
		the7_mass_regenerate_short_codes_inline_css();
		self::set_message( '<p>Shortcodes css was regenerated.</p>' );
	}

	/**
	 * Test download speed from repo.the7.io.
	 */
	public static function tool_download_speed_test() {
		$start         = time();
		$response      = wp_safe_remote_get(
			'https://repo.the7.io/download-test/10MB.zip',
			array(
				'timeout'    => 300,
				'decompress' => false,
			)
		);
		$download_time = time() - $start;
		if ( is_wp_error( $response ) ) {
			$message  = '<p>There was an error while downloading:</p>';
			$message .= '<pre>';
			ob_start();
			var_dump( $response );
			$message .= ob_get_clean() . '</pre>';
		} else {
			$message = '<p>10MB of test data was downloaded for ' . $download_time . ' seconds.</p>';
		}
		self::set_message( $message );
	}

	/**
	 * Restore theme options from a backup.
	 */
	public static function tool_restore_theme_options_from_backup() {
		if ( ! isset( $_POST['theme_options_backup'] ) ) {
			self::set_message( '<p>There is no backup selected.</p>' );
			return;
		}

		$record_name = $_POST['theme_options_backup'];

		unset( $_POST['_wp_http_referer'] );
		if ( The7_Options_Backup::restore( $record_name ) ) {
			$message = '<p>Theme options successfully restored from backup <code>' . esc_html( $record_name ) . '</code>.</p>';
		} else {
			$message = '<p>Selected backup is not valid, please search for <code>%' . esc_html( $record_name ) . '%</code> option in DB.</p>';
		}

		self::set_message( $message );
	}

	/**
	 * Delete all theme options backups.
	 */
	public static function tool_delete_all_theme_options_backups() {
		$count = The7_Options_Backup::delete_all_records();
		self::set_message( "<p>Successfully deleted $count backups.</p>" );
	}

	/**
	 * Store message to be published on the7 tools admin page.
	 *
	 * @param string $message Message text.
	 */
	protected static function set_message( $message ) {
		set_transient( 'the7-dev-tools-message', $message, 60 );
	}
}
