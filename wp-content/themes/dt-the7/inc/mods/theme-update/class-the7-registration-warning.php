<?php
/**
 * @package The7
 */

/**
 * Class The7_Registration_Warning
 */
class The7_Registration_Warning {

    const OPTION_WARNING = 'the7_registered_domains_count';

	public static function add_admin_notices() {
		$domains_count = self::get_domains_count();

		if ( $domains_count > 2 ) {
			the7_admin_notices()->add( 'the7_registration_soft_warning', array( __CLASS__, 'registration_soft_warning' ), 'the7-dashboard-notice notice-warning is-dismissible' );
		}
	}

	public static function registration_soft_warning() {
		$domains_count = self::get_domains_count();

	    include dirname( __FILE__ ) . '/views/html-notice-soft-warning.php';
	}

	public static function dismiss_admin_notices() {
		delete_site_option( self::OPTION_WARNING );
		the7_admin_notices()->reset( 'the7_registration_soft_warning' );
	}

	public static function get_domains_count() {
		return (int) get_site_option( self::OPTION_WARNING );
	}

	public static function setup_registration_warning( $response ) {
		$data = isset( $response['data'] ) ? $response['data'] : array();
		if ( isset( $data['domains_count'] ) ) {
			update_site_option( self::OPTION_WARNING, (int) $data['domains_count'] );
		} else {
		    self::dismiss_admin_notices();
		}
	}
}
