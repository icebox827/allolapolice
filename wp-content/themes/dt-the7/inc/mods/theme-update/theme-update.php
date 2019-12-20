<?php
/**
 * Theme update functions.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Presscore_Modules_ThemeUpdateModule', false ) ) :

	class Presscore_Modules_ThemeUpdateModule {

		const PAGE_ID = 'the7-dashboard';

		public static function execute() {
			if ( ! ( defined( 'THE7_PREVENT_THEME_UPDATE' ) && THE7_PREVENT_THEME_UPDATE ) ) {
				add_filter( 'pre_set_site_transient_update_themes', array(
					__CLASS__,
					'pre_set_site_transient_update_themes'
				) );
			}

			// Backup lang files.
			add_filter( 'upgrader_pre_install', array( __CLASS__, 'backup_lang_files' ), 10, 2 );
			add_filter( 'upgrader_post_install', array( __CLASS__, 'restore_lang_files' ), 10, 3 );

			add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
			add_action( 'admin_notices', array( __CLASS__, 'registration_admin_notice' ), 1 );
			add_filter( 'pre_update_site_option_the7_purchase_code', array( __CLASS__, 'check_for_empty_code' ), 10, 2 );

			if ( ! class_exists( 'The7_Install', false ) ) {
				include dirname( __FILE__ ) . '/class-the7-install.php';
			}

			The7_Install::init();

			if ( ! class_exists( 'The7_Registration_Warning', false ) ) {
				include dirname( __FILE__ ) . '/class-the7-registration-warning.php';
			}

			add_action( 'admin_notices', array( 'The7_Registration_Warning', 'add_admin_notices' ) );
			add_action( 'the7_after_theme_deactivation', array( 'The7_Registration_Warning', 'dismiss_admin_notices' ) );
			add_action( 'the7_after_theme_registration', array( 'The7_Registration_Warning', 'setup_registration_warning' ) );
		}

		/**
		 * Setup page hooks.
		 */
		public static function setup_hooks( $page ) {
			add_action( 'load-' . $page, array( __CLASS__, 'update_settings' ) );
		}

		public static function register_settings() {
			register_setting( 'the7_theme_registration', 'the7_purchase_code', array( __CLASS__, 'theme_activation_action' ) );
		}

		/**
		 * Theme registration action.
		 *
		 * @param $code
		 *
		 * @return string
		 */
		public static function theme_activation_action( $code ) {
			$code = trim( $code );

			if ( isset( $_POST['register_theme'] ) ) {
				$code = self::register_action( $code );
			} else if ( $_POST['deregister_theme'] ) {
				$code = self::de_register_action();
			}
			do_action( 'the7_theme_activation_action' );
			return $code;
		}

		public static function check_for_empty_code( $val = false, $old_val = false ) {
			if ( ! $val && $val === $old_val ) {
				add_settings_error( 'the7_theme_registration', 'update_errors', __( 'Purchase code is not valid.', 'the7mk2' ) , 'error inline the7-dashboard-notice' );
			}

			return $val;
		}

		protected static function register_action( $code ) {
			if ( ! $code ) {
				presscore_deactivate_theme();
				self::check_for_empty_code();
				return '';
			}

			$the7_remote_api = new The7_Remote_API( $code );

			$the7_remote_api_response = $the7_remote_api->register_purchase_code();
			if ( is_wp_error( $the7_remote_api_response ) ) {
				add_settings_error( 'the7_theme_registration', 'update_errors', $the7_remote_api_response->get_error_message() , 'error inline the7-dashboard-notice' );
				return '';
			}

			presscore_activate_theme();

			// Refresh transients.
			delete_site_transient( 'update_themes' );
			do_action( 'wp_update_themes' );

			if ( class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
				Presscore_Modules_TGMPAModule::delete_plugins_list_cache();
			}

			do_action( 'the7_after_theme_registration', $the7_remote_api_response );

			return $code;
		}

		protected static function de_register_action() {
			$code = presscore_get_purchase_code();

			$the7_remote_api = new The7_Remote_API( $code );

			$the7_remote_api_response = $the7_remote_api->de_register_purchase_code();
			if ( is_wp_error( $the7_remote_api_response ) ) {
				add_settings_error( 'the7_theme_registration', 'update_errors', $the7_remote_api_response->get_error_message() , 'error inline the7-dashboard-notice' );
				return $code;
			}

			presscore_deactivate_theme();
			add_settings_error( 'the7_theme_registration', 'update_success', __( 'Purchase code successfully de-registered.', 'the7mk2' ) , 'updated inline the7-dashboard-notice' );

			if ( class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
				Presscore_Modules_TGMPAModule::delete_plugins_list_cache();
			}

			return '';
		}

		public static function update_settings() {
			if ( ! isset( $_POST['option_page'] ) || 'the7_theme_registration' !== $_POST['option_page'] ) {
				return;
			}

			if ( ! isset( $_POST['action'] ) || 'update' !== $_POST['action'] ) {
				return;
			}

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			check_admin_referer( 'the7_theme_registration-options' );

			global $new_whitelist_options;
			$options = $new_whitelist_options['the7_theme_registration'];

			foreach ( $options as $option ) {
				$option = trim( $option );
				$value = null;
				if ( isset( $_POST[ $option ] ) ) {
					$value = $_POST[ $option ];
					if ( ! is_array( $value ) ) {
						$value = trim( $value );
					}
					$value = wp_unslash( $value );
				}

				update_site_option( $option, $value );
			}

			/**
			 * Handle settings errors.
			 */
			set_transient('settings_errors', get_settings_errors(), 30);

			$goback = add_query_arg( 'settings-updated', 'true', wp_get_referer() );
			wp_redirect( $goback );
			exit;
		}

		/**
		 * Adjust update_themes site transient to honor theme update from Envato server.
		 *
		 * @param $transient
		 *
		 * @return mixed
		 */
		public static function pre_set_site_transient_update_themes( $transient ) {
			if ( ! presscore_theme_is_activated() )  {
				return $transient;
			}

			$code = presscore_get_purchase_code();
			$the7_remote_api = new The7_Remote_API( $code );

			// Check The7 version.
			$response = $the7_remote_api->check_theme_update();
			if ( is_wp_error( $response ) || ! isset( $response['version'] ) ) {
				return $transient;
			}

			$new_version = $response['version'];

			// Save update info if there are newer version.
			$theme_template = get_template();
			if ( version_compare( wp_get_theme( $theme_template )->get( 'Version' ), $new_version, '<' ) ) {
				$transient->response[ $theme_template ] = array(
					'theme' => $theme_template,
					'new_version' => $new_version,
					'url' => presscore_theme_update_get_changelog_url(),
					'package' => $the7_remote_api->get_theme_download_url( $new_version ),
				);
			}

			return $transient;
		}

		/**
		 * Backup files from language dir to temporary folder in uploads.
		 */
		public static function backup_lang_files( $res = true, $hook_extra = array() ) {
			if ( is_wp_error( $res ) || ! isset( $hook_extra['theme'] ) || 'dt-the7' !== $hook_extra['theme'] ) {
				return $res;
			}

			$upload_dir = wp_get_upload_dir();
			$from = get_template_directory() . '/languages';
			$to = $upload_dir['basedir'] . '/the7-language-tmp';

			if ( wp_mkdir_p( $to ) ) {
				copy_dir( $from, $to, array( 'the7mk2.pot', 'the7mk2.mo' ) );
			}

			return $res;
		}

		/**
		 * Restore stored language files.
		 */
		public static function restore_lang_files( $res = true, $hook_extra = array(), $result = array() ) {
			/**
			 * @var $wp_filesystem WP_Filesystem_Base
			 */
			global $wp_filesystem;

			if ( is_wp_error( $res ) || ! isset( $hook_extra['theme'] ) || 'dt-the7' !== $hook_extra['theme'] ) {
				return $res;
			}

			$upload_dir = wp_get_upload_dir();
			$from = $upload_dir['basedir'] . '/the7-language-tmp';
			$to = get_template_directory() . '/languages';

			// Proceed only if both copy and destination folders exists.
			if ( $wp_filesystem->exists( $from ) && $wp_filesystem->exists( $to ) ) {
				$copy_result = copy_dir( $from, $to );

				// Remove backup.
				if ( ! is_wp_error( $copy_result ) ) {
					$wp_filesystem->delete( $from, true );
				}
			}

			return $res;
		}

		public static function registration_admin_notice() {
			if ( presscore_theme_is_activated() ) {
				return;
			}

			include( dirname( __FILE__ ) . '/views/html-notice-registration.php' );
		}
	}

	Presscore_Modules_ThemeUpdateModule::execute();

endif;

if ( ! function_exists( 'presscore_theme_update_get_changelog_url' ) ) :

	function presscore_theme_update_get_changelog_url() {
		return 'http://the7.io/changelog/';
	}

endif;
