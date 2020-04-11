<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Install
 */
class The7_Install {

	/**
	 * @var The7_Background_Updater
	 */
    private static $background_updater;

	/**
	 * @var array
	 */
	private static $update_callbacks = array(
		'5.5.0' => array(
			'the7_update_550_fancy_titles_parallax',
			'the7_update_550_fancy_titles_font_size',
			'the7_update_550_fancy_subtitles_font_size',
			'the7_update_550_db_version',
		),
		'6.0.0' => array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_600_db_version',
		),
		'6.1.0' => array(
			'the7_update_610_db_version',
		),
		'6.1.1' => array(
			'the7_update_611_page_transparent_top_bar_migration',
			'the7_update_611_db_version',
		),
		'6.2.0' => array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_620_db_version',
		),
		'6.3.0' => array(
			'the7_update_630_microsite_content_visibility_settings_migration',
			'the7_update_630_db_version',
		),
		'6.4.0' => array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_640_db_version',
		),
		'6.4.1' => array(
			'the7_update_641_carousel_backward_compatibility',
			'the7_update_641_db_version',
		),
		'6.4.3' => array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_643_db_version',
		),
		'6.5.0' => array(
			'the7_update_650_disable_options_autoload',
			'the7_update_650_db_version',
		),
		'6.6.0' => array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_660_db_version',
		),
		'6.6.1' =>array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_661_db_version',
		),
		'6.7.0' =>array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_670_db_version',
		),
		'6.8.0' =>array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_680_db_version',
		),
		'6.8.1' =>array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_681_db_version',
		),
		'6.9.3' => array(
			'the7_update_693_migrate_custom_menu_widgets',
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_693_db_version',
		),
		'7.0.0' => array(
			'the7_update_700_shortcodes_gradient_backward_compatibility',
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_700_db_version',
		),
		'7.1.0' => array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_710_db_version',
		),
		'7.3.0' => array(
			'the7_update_730_set_fancy_title_zero_top_padding',
			'the7_update_730_fancy_title_responsiveness_settings',
			'the7_update_730_db_version',
		),
		'7.4.0' => array(
			'the7_update_740_fancy_title_uppercase_migration',
			'the7_update_740_db_version',
		),
		'7.4.3' => array(
			'the7_update_743_back_button_migration',
			'the7_update_743_db_version',
		),
		'7.5.0' => array(
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_750_db_version',
		),
		'7.6.0' => array(
			'the7_update_760_mega_menu_migration',
			'the7_update_760_db_version',
		),
		'7.6.2' => array(
			'the7_update_762_db_version',
		),
		'7.7.0' => array(
			'the7_update_770_shortcodes_blog_backward_compatibility',
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_770_db_version',
		),
		'7.7.1' => array(
			'the7_update_771_shortcodes_blog_backward_compatibility',
			'the7_update_771_shortcodes_button_backward_compatibility',
			'the7_mass_regenerate_short_codes_inline_css',
			'the7_update_771_db_version',
		),
		'7.7.2' => array(
			'the7_update_772_db_version',
		),
		'7.7.5' => array(
			'the7_update_775_fontawesome_compatibility',
			'the7_update_775_db_version',
		),
		'7.7.6' => array(
			'the7_update_776_db_version',
		),
		'7.8.0' => array(
			'the7_update_780_shortcodes_backward_compatibility',
			'the7_update_780_db_version',
		),
		'7.9.0' => array(
			'the7_update_790_silence_plugins_purchase_notification',
			'the7_update_790_db_version',
		),
		'7.9.1' => array(
			'the7_regenerate_post_css',
			'the7_update_791_db_version',
		),
		'8.0.0' => array(
			'the7_update_800_db_version',
		),
		'8.1.0' => array(
			'the7_update_810_db_version',
		),
		'8.2.0' => array(
			'the7_update_820_db_version',
		),
		'8.3.0' => array(
			'the7_update_830_fix_post_padding_meta',
			'the7_update_830_migrate_post_mobile_padding',
			'the7_regenerate_post_css',
			'the7_update_830_db_version',
		),
		'8.4.0' => array(
			'the7_regenerate_post_css',
			'the7_update_840_db_version',
		),
		'8.5.0' => array(
			'the7_update_850_migrate_post_footer_visibility',
			'the7_update_850_db_version',
		),
		'8.5.0.2' => array(
			'the7_update_8502_migrate_post_footer_source_for_elementor',
			'the7_update_8502_db_version',
		),
		'8.6.0' => array(
			'the7_update_860_db_version',
		),
	);

    public static function init() {
	    add_action( 'init', array( __CLASS__, 'init_background_updater' ), 5 );
	    add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
	    add_action( 'init', array( __CLASS__, 'upgrade_stylesheets_action' ) );

	    if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) && ! wp_doing_ajax() && ! wp_doing_cron() ) {
		    add_action( 'init', array( __CLASS__, 'install_actions' ) );
		    add_action( 'init', array( __CLASS__, 'show_db_update_notices' ), 20 );
	    }
    }

    public static function check_version() {
	    $current_db_version = self::get_db_version();

	    // No db version? New install.
	    if ( is_null( $current_db_version ) ) {
		    self::update_db_version();

		    // Dismiss updated notice.
		    the7_admin_notices()->dismiss_notice( 'the7_updated' );
	    }
    }

	/**
	 * Init background updates
	 */
	public static function init_background_updater() {
		include_once( dirname( __FILE__ ) . '/class-the7-background-updater.php' );
		include_once( dirname( __FILE__ ) . '/the7-update-functions.php' );

		self::$background_updater = new The7_Background_Updater();
	}

	/**
	 * Install actions when a update button is clicked within the admin area.
	 *
	 * This function is hooked into admin_init to affect admin only.
	 */
	public static function install_actions() {
		if ( ! current_user_can( 'update_themes' ) ) {
			return;
		}

		if ( ! empty( $_GET['force_update_the7'] ) && is_admin() ) {
			do_action( 'wp_the7_updater_cron' );
			wp_safe_redirect( admin_url( 'admin.php?page=the7-dashboard' ) );
			exit;
		}

		if ( self::db_is_updating() ) {
			return;
		}

		if ( self::is_auto_update_db() ) {
			self::update();

			return;
		}

		if ( ! empty( $_GET['do_update_the7'] ) && is_admin() ) {
			self::update();
			wp_safe_redirect( add_query_arg( 'do_updating_the7', 'true', admin_url( 'admin.php?page=the7-dashboard' ) ) );
			exit;
		}
	}

	public static function update_notice() {
		include( dirname( __FILE__ ) . '/views/html-notice-update.php' );
	}

	public static function updating_notice() {
		include( dirname( __FILE__ ) . '/views/html-notice-updating.php' );
	}

	public static function updated_notice() {
		include( dirname( __FILE__ ) . '/views/html-notice-updated.php' );
	}

	private static function get_update_callbacks() {
		return self::$update_callbacks;
	}

	/**
	 * Push all needed DB updates to the queue for processing.
	 */
	public static function update() {
		$db_version = self::get_db_version();

		if ( version_compare( $db_version, PRESSCORE_DB_VERSION, '>=' ) ) {
			return;
		}

		$update_queued = false;

		// Update the7 options.
		self::$background_updater->push_to_queue( array( __CLASS__, 'update_theme_options' ) );

		$db_update_callbacks = self::get_update_callbacks();

		// Update db.
		foreach ( $db_update_callbacks as $version => $update_callbacks ) {
			if ( version_compare( $db_version, $version, '<' ) ) {
				foreach ( $update_callbacks as $update_callback ) {
					self::$background_updater->push_to_queue( $update_callback );
					$update_queued = true;
				}
			}
		}

		if ( $update_queued ) {
			self::$background_updater->save()->dispatch();
		}
	}

	public static function show_db_update_notices() {
		if ( ! current_user_can( 'update_themes' ) ) {
			return;
		}

		$db_version = self::get_db_version();

		if ( version_compare( $db_version, PRESSCORE_DB_VERSION, '<' ) ) {
			the7_admin_notices()->reset( 'the7_updated' );
			if ( self::db_is_updating() ) {
				the7_admin_notices()->add( 'the7_updating', array( __CLASS__, 'updating_notice' ), 'the7-dashboard-notice' );
			} elseif( ! self::is_auto_update_db() ) {
				the7_admin_notices()->add( 'the7_update', array( __CLASS__, 'update_notice' ), 'the7-dashboard-notice' );
			}
		} else {
			the7_admin_notices()->add( 'the7_updated', array( __CLASS__, 'updated_notice' ), 'the7-dashboard-notice updated is-dismissible' );
		}
	}

	public static function update_db_version( $version = null ) {
		delete_option( 'the7_db_version' );
		add_option( 'the7_db_version', is_null( $version ) ? PRESSCORE_DB_VERSION : $version );
	}

	public static function is_auto_update_db() {
		return The7_Admin_Dashboard_Settings::get( 'db-auto-update' );
	}

	public static function get_db_version() {
	    return get_option( 'the7_db_version', null );
    }

	public static function upgrade_stylesheets_action() {
		if ( version_compare( get_option( 'the7_style_version' ), PRESSCORE_STYLESHEETS_VERSION, '<' ) ) {
			_optionsframework_delete_defaults_cache();

			self::regenerate_stylesheets();

			update_option( 'the7_style_version', PRESSCORE_STYLESHEETS_VERSION );
		}
	}

	public static function regenerate_stylesheets() {
		presscore_refresh_dynamic_css();
	}

	public static function db_is_updating() {
		return self::$background_updater->is_updating();
	}

	public static function db_update_is_needed() {
		return version_compare( self::get_db_version(), PRESSCORE_DB_VERSION, '<' );
	}

	public static function update_theme_options() {
		$cur_db_version = self::get_db_version();
		$options = optionsframework_get_options();
		if ( ! $options ) {
			return;
		}

		$patches_dir = trailingslashit( trailingslashit( dirname( __FILE__ ) ) . 'patches' );
		require_once( $patches_dir . 'interface-the7-db-patch.php' );

		$patches = array(
			'3.5.0' => 'The7_DB_Patch_030500',
			'4.0.0' => 'The7_DB_Patch_040000',
			'4.0.3' => 'The7_DB_Patch_040003',
			'5.0.3' => 'The7_DB_Patch_050003',
			'5.1.6' => 'The7_DB_Patch_050106',
			'5.2.0' => 'The7_DB_Patch_050200',
			'5.3.0' => 'The7_DB_Patch_050300',
			'5.4.0' => 'The7_DB_Patch_050400',
			'6.0.0' => 'The7_DB_Patch_060000',
			'6.1.0' => 'The7_DB_Patch_060100',
			'6.1.1' => 'The7_DB_Patch_060101',
			'6.6.0' => 'The7_DB_Patch_060600',
			'6.6.1' => 'The7_DB_Patch_060601',
			'7.0.0' => 'The7_DB_Patch_070000',
			'7.1.0' => 'The7_DB_Patch_070100',
			'7.3.0' => 'The7_DB_Patch_070300',
			'7.4.0' => 'The7_DB_Patch_070400',
			'7.4.3' => 'The7_DB_Patch_070403',
			'7.6.0' => 'The7_DB_Patch_070600',
			'7.6.2' => 'The7_DB_Patch_070602',
			'7.7.1' => 'The7_DB_Patch_070701',
			'7.7.2' => 'The7_DB_Patch_070702',
			'7.7.6' => 'The7_DB_Patch_070706',
			'7.8.0' => 'The7_DB_Patch_070800',
			'8.0.0' => 'The7_DB_Patch_080000',
			'8.1.0' => 'The7_DB_Patch_080100',
			'8.2.0' => 'The7_DB_Patch_080200',
			'8.6.0' => 'The7_DB_Patch_080600',
		);

		$update_options = false;
		foreach ( $patches as $ver => $class_name ) {
			if ( version_compare( $ver, $cur_db_version ) <= 0 ) {
				continue;
			}

			if ( ! class_exists( $class_name ) ) {
				require_once $patches_dir . 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
			}

			$patch          = new $class_name();
			$options        = $patch->apply( $options );
			$update_options = true;
		}

		if ( $update_options ) {
			The7_Options_Backup::store_options();
			update_option( optionsframework_get_options_id(), $options );
			_optionsframework_delete_defaults_cache();
		}
	}
}