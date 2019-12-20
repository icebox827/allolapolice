<?php
/**
 * Admin notices hooks.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add admin notices.
 *
 * @return void
 */
function the7_add_admin_notices() {
	global $current_screen;

	if ( optionsframework_get_options_files( $current_screen->parent_base ) && ! apply_filters( 'presscore_less_cache_writable', true ) ) {
		the7_admin_notices()->add( 'unable-to-write-css', 'the7_cannot_write_css_notice', 'updated' );
	}

	if ( ! The7_Admin_Dashboard_Settings::get( 'silence-purchase-notification' ) ) {
		the7_admin_notices()->add(
			'silence-purchase-notification',
			'the7_silence_purchase_notification',
			'the7-dashboard-notice updated is-dismissible'
		);
	}

	if ( ! The7_Admin_Dashboard_Settings::get( 'critical-alerts' ) ) {
		the7_admin_notices()->add(
			'turn-on-critical-alerts',
			'the7_suggest_to_turn_on_critical_alerts_notice',
			'the7-dashboard-notice notice-warning is-dismissible'
		);
	}
}

add_action( 'admin_notices', 'the7_add_admin_notices' );

/**
 * Print admin notice that suggests to turn off plugins registration notifications.
 *
 * @return void
 */
function the7_silence_purchase_notification() {
	echo '<p>';
	/* translators: %s: admin page url */
	$msg = _x(
		'Hey, we\'ve noticed that you do not have "silence bundled plugins purchase notifications" options enabled. 
            If they are bothering you, <a href="%s">click here to enable it</a>.
            You can always change this setting under The7 > My The7, in the "Bundled Plugins" box.',
		'admin',
		'the7mk2'
	);
	$url = wp_nonce_url(
		admin_url( 'admin.php?page=the7-dashboard&the7_dashboard_settings[silence-purchase-notification]=true' ),
		The7_Admin_Dashboard::UPDATE_DASHBOARD_SETTINGS_NONCE_ACTION
	);
	echo wp_kses_post( sprintf( $msg, $url ) );
	echo '</p>';
}

/**
 * Print admin notice about not writable uploads folder.
 *
 * @return void
 */
function the7_cannot_write_css_notice() {
	echo '<p>';
	echo esc_html_x( 'Failed to create customization .CSS file. To improve your site performance, please check whether ".../wp-content/uploads/" folder is created, and its CHMOD is set to 755.', 'admin', 'the7mk2' );
	echo '</p>';
}

/**
 * Print admin that suggest to turn on critical alerts.
 *
 * @return void
 */
function the7_suggest_to_turn_on_critical_alerts_notice() {
	echo '<p>';
	/* translators: %s: admin page url */
	$msg = _x(
		'Hey, we\'ve noticed that you have "allow to send critical alerts by email" options disabled.<br>
		It is strongly recommended to keep this option enabled (in case of a critical bug, security issue, etc.). <a href="%s">Click here to enable it.</a><br>
		Note that we do not collect your email or other personal data and never spam.<br>
		You can always change this setting under The7 > My The7, in the "Settings" box.',
		'admin',
		'the7mk2'
	);
	$url = wp_nonce_url(
		admin_url( 'admin.php?page=the7-dashboard&the7_dashboard_settings[critical-alerts]=true' ),
		The7_Admin_Dashboard::UPDATE_DASHBOARD_SETTINGS_NONCE_ACTION
	);
	echo wp_kses_post( sprintf( $msg, $url ) );
	echo '</p>';
}

/**
 * Return object that handle admin notices.
 *
 * @return The7_Admin_Notices
 */
function the7_admin_notices() {
	static $admin_notices = null;

	if ( is_null( $admin_notices ) ) {
		$admin_notices = new The7_Admin_Notices();
	}

	return $admin_notices;
}

/**
 * Enqueue admin notices scripts.
 */
function the7_admin_notices_scripts() {
	the7_register_script( 'the7-admin-notices', PRESSCORE_ADMIN_URI . '/assets/js/admin-notices', array( 'jquery' ), false, true );

	wp_enqueue_script( 'the7-admin-notices' );
	wp_localize_script( 'the7-admin-notices', 'the7Notices', array( '_ajax_nonce' => the7_admin_notices()->get_nonce() ) );
}

/**
 * Main function to handle custom admin notices. Adds action handlers.
 */
function the7_admin_notices_bootstrap() {
	$notices = the7_admin_notices();

	add_action( 'admin_enqueue_scripts', 'the7_admin_notices_scripts', 9999 );
	add_action( 'wp_ajax_the7-dismiss-admin-notice', array( $notices, 'dismiss_notices' ) );
	add_action( 'admin_notices', array( $notices, 'print_admin_notices' ), 40 );
}
add_action( 'admin_init', 'the7_admin_notices_bootstrap' );
