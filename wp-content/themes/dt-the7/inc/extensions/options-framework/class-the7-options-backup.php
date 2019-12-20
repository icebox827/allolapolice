<?php
/**
 * Class that handles theme options backup routine.
 *
 * @since 7.6.0
 *
 * @package The7\Options
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Options_Backup
 */
class The7_Options_Backup {

	const RECORD_NAME_BASE = 'the7-theme-options-backup';

	/**
	 * Store current theme options in database.
	 */
	public static function store_options() {
		$date           = date( 'Y-m-d-H:i:s' );
		$cur_db_version = get_option( 'the7_db_version', 'latest' );
		set_transient( self::RECORD_NAME_BASE . "-{$cur_db_version}-{$date}", optionsframework_get_options(), 7 * DAY_IN_SECONDS );
	}

	/**
	 * Restore theme options from the record.
	 *
	 * @param string $record_name Record name.
	 *
	 * @return bool Return true on success, false otherwise.
	 */
	public static function restore( $record_name ) {
		$options_backup = get_transient( $record_name );
		if ( is_array( $options_backup ) ) {
			update_option( optionsframework_get_options_id(), $options_backup );
			_optionsframework_delete_defaults_cache();
			presscore_refresh_dynamic_css();

			return true;
		}

		return false;
	}

	/**
	 * Delete all records.
	 *
	 * @return int Return number of deleted records.
	 */
	public static function delete_all_records() {
		$records_deleted = 0;
		foreach ( self::get_records() as $record_name ) {
			if ( delete_transient( $record_name ) ) {
				$records_deleted++;
			}
		}

		return $records_deleted;
	}

	/**
	 * Return all stored records of them options.
	 *
	 * @return array Array of record names.
	 */
	public static function get_records() {
		global $wpdb;

		$record_name_like = '_transient_' . self::RECORD_NAME_BASE . '%';
		$transients       = $wpdb->get_results( $wpdb->prepare( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s", $record_name_like ), ARRAY_A );

		$records = array();
		foreach ( $transients as $transient ) {
			$records[] = str_replace( '_transient_', '', $transient['option_name'] );
		}

		return $records;
	}
}
