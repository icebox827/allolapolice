<?php
/**
 * The7 critical alerts class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Critical_Alerts
 */
class The7_Critical_Alerts {

	const PROCESSED_ALERTS_DB_KEY = 'the7_processed_critical_alerts';

	const SPAWN_ALERT_CRON_EVENT = 'the7_spawn_critical_alter';

	const CHECK_FOR_CRITICAL_ALERTS_EVENT = 'the7_check_for_critical_alerts';

	/**
	 * The7 remote API object.
	 *
	 * @var The7_Remote_API
	 */
	protected $the7_remote_api;

	/**
	 * Email address to send alert to.
	 *
	 * @var string
	 */
	protected $email;

	/**
	 * The7_Critical_Alerts constructor.
	 *
	 * @param string          $email           Email address to send alert to.
	 * @param The7_Remote_API $the7_remote_api The7 remote API object.
	 */
	public function __construct( $email, The7_Remote_API $the7_remote_api ) {
		$this->email           = sanitize_email( $email );
		$this->the7_remote_api = $the7_remote_api;
	}

	/**
	 * Check if alert is already sent.
	 *
	 * @param The7_Critical_Alert $critical_alert Alert object.
	 *
	 * @return bool
	 */
	public static function is_alert_already_sent( The7_Critical_Alert $critical_alert ) {
		$processed_alerts = (array) get_option( self::PROCESSED_ALERTS_DB_KEY, array() );

		return in_array( $critical_alert->get_time(), $processed_alerts, true );
	}

	/**
	 * Mark alert as sent, preventing multiple spawn of the same alert.
	 *
	 * @param The7_Critical_Alert $critical_alert Alert object.
	 */
	public static function alert_was_sent( The7_Critical_Alert $critical_alert ) {
		$processed_alerts   = (array) get_option( self::PROCESSED_ALERTS_DB_KEY, array() );
		$processed_alerts[] = $critical_alert->get_time();
		update_option( self::PROCESSED_ALERTS_DB_KEY, array_unique( $processed_alerts ) );
	}

	/**
	 * Clear alerts list that was already sent, remove from schedule future alerts.
	 */
	public static function drop_alerts() {
		delete_option( self::PROCESSED_ALERTS_DB_KEY );
		wp_unschedule_hook( self::SPAWN_ALERT_CRON_EVENT );
	}

	/**
	 * Action. Remove scheduled actions, cleanup db. Triggered on `the7_dashboard_before_settings_save`.
	 *
	 * @param array $new_settings New the7 dashboard settings.
	 * @param array $old_settings Old the7 dashboard settings.
	 */
	public function maybe_erase_presence( $new_settings, $old_settings ) {
		if ( ! isset( $new_settings['critical-alerts'], $old_settings['critical-alerts'] ) ) {
			return;
		}

		if ( $new_settings['critical-alerts'] !== $old_settings['critical-alerts'] && wp_next_scheduled( self::CHECK_FOR_CRITICAL_ALERTS_EVENT ) ) {
			wp_unschedule_hook( self::CHECK_FOR_CRITICAL_ALERTS_EVENT );
			self::drop_alerts();
		}
	}

	/**
	 * Add all necessary hooks and schedule critical alert check twice a day.
	 */
	public function bootstrap() {
		add_action( self::SPAWN_ALERT_CRON_EVENT, array( $this, 'spawn_critical_alert' ) );
		add_action( self::CHECK_FOR_CRITICAL_ALERTS_EVENT, array( $this, 'check_for_critical_alerts' ) );
		add_action( 'the7_dashboard_before_settings_save', array( $this, 'maybe_erase_presence' ), 10, 2 );

		if ( ! wp_next_scheduled( self::CHECK_FOR_CRITICAL_ALERTS_EVENT ) ) {
			wp_schedule_event( time(), 'twicedaily', self::CHECK_FOR_CRITICAL_ALERTS_EVENT );
		}
	}

	/**
	 * Cron action to check for next critical alert and schedule one if it's haven't been already sent.
	 *
	 * @return bool
	 */
	public function check_for_critical_alerts() {
		$critical_alert = $this->remote_get_critical_alert();
		if ( ! $critical_alert ) {
			return false;
		}

		return ! self::is_alert_already_sent( $critical_alert ) && $this->schedule_critical_alert( $critical_alert );
	}

	/**
	 * Schedule next critical alert.
	 *
	 * @param The7_Critical_Alert $critical_alert Alert object.
	 *
	 * @return bool
	 */
	public function schedule_critical_alert( The7_Critical_Alert $critical_alert ) {
		$alert_args = array( $critical_alert );

		if ( ! wp_next_scheduled( self::SPAWN_ALERT_CRON_EVENT, $alert_args ) ) {
			return wp_schedule_single_event( $critical_alert->get_time(), self::SPAWN_ALERT_CRON_EVENT, $alert_args );
		}

		return false;
	}

	/**
	 * Get critical alert data from remote server and return The7_Critical_Alert object on success or false on failure.
	 *
	 * @return bool|The7_Critical_Alert
	 */
	public function remote_get_critical_alert() {
		$alert = $this->the7_remote_api->get_critical_alert();

		if ( is_wp_error( $alert ) ) {
			return false;
		}

		if ( ! isset( $alert['time'], $alert['subject'], $alert['body'] ) ) {
			return false;
		}

		return new The7_Critical_Alert( $alert['time'], $alert['subject'], $alert['body'] );
	}

	/**
	 * Cron action to send an email.
	 *
	 * @param The7_Critical_Alert $alert Alert object.
	 */
	public function spawn_critical_alert( The7_Critical_Alert $alert ) {
		if ( $this->mail( $this->email, $alert->get_subject(), $alert->get_message() ) ) {
			self::alert_was_sent( $alert );
		}
	}

	/**
	 * Send an email.
	 *
	 * @param string $email   Email address to send alert to.
	 * @param string $subject Email subject.
	 * @param string $message Email message.
	 *
	 * @return bool
	 */
	public function mail( $email, $subject, $message ) {
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$subject  = sprintf( '[%s] %s', $blogname, $subject );
		$message  = str_replace( array( '###SITEURL###' ), array( home_url( '/' ) ), $message );

		return wp_mail( $email, $subject, $message );
	}
}
