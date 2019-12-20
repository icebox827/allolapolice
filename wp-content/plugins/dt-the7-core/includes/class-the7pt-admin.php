<?php

/**
 * Plugin admin class.
 */
class The7PT_Admin {

	/**
	 * Setup plugin admin part.
	 */
	public static function setup() {
		// Rename theme options.
		add_filter( 'presscore_options_menu_config', array( __CLASS__, 'rename_blog_options_menu_entry' ), 20 );

		// Add modules options.
		add_filter( 'presscore_options_files_to_load', array( __CLASS__, 'add_module_options' ) );

		// Flush rewrite rules after options save.
		add_action( 'admin_init', array( __CLASS__, 'flush_rewrite_rules_on_modules_switch' ), 20 );

		// Add plugin action links only for the7 theme.
		$plugin_basename = The7PT()->plugin_basename();
		add_action( "plugin_action_links_{$plugin_basename}", array( __CLASS__, 'add_plugin_action_links' ) );

		add_filter( 'pre_set_site_transient_update_plugins', array( __CLASS__, 'pre_set_site_transient_update_plugins' ) );
		add_filter( 'plugins_api', array( __CLASS__, 'plugin_update_info', ), 10, 3 );

        add_action( 'admin_notices', array( __CLASS__, 'display_outdated_theme_notice' ) );

        // Add site health tests.
        include_once dirname( __FILE__ ) . '/the7pt-site-health-tests.php';
	}

	/**
	 * Rename Blog theme options menu entry.
	 *
	 * @param array $menu_items
	 *
	 * @return array
	 */
	public static function rename_blog_options_menu_entry( $menu_items = array() ) {
		$menu_slug = 'of-blog-and-portfolio-menu';
		if ( array_key_exists( $menu_slug, $menu_items ) ) {
			$menu_items[ $menu_slug ] = array(
				'menu_title' => _x( 'Post Types', 'backend', 'dt-the7-core' ),
			);
		}

		return $menu_items;
	}

	/**
	 * Add plugin specific theme options.
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public static function add_module_options( $options = array() ) {
		if ( array_key_exists( 'of-blog-and-portfolio-menu', $options ) ) {
			$options['dt-the7-core-inject-modules-options'] = The7PT()->plugin_path() . 'includes/theme-options/modules.php';
		}

		return $options;
	}

	/**
	 * Flush rewrite rules after modules switch.
	 */
	public static function flush_rewrite_rules_on_modules_switch() {
		$set = get_settings_errors( 'options-framework' );
		if ( $set && isset( $_GET['page'] ) && 'of-modules-menu' === $_GET['page'] ) {
			flush_rewrite_rules();
		}
	}

	/**
	 * Add plugin action links.
	 *
	 * @param array $links
	 *
	 * @return array
	 */
	public static function add_plugin_action_links( $links = array() ) {
		if ( defined( 'PRESSCORE_THEME_NAME' ) && current_user_can( 'edit_theme_options' ) ) {
			$links['the7pt_modules'] = '<a href="' . esc_url( 'admin.php?page=of-blog-and-portfolio-menu#admin-options-group-5' ) . '">' . __( 'Settings', 'dt-the7-core' ) . '</a>';
		}

		return $links;
	}

	/**
	 * Auto update plugin.
	 *
	 * @param $transient
	 *
	 * @return mixed
	 */
	public static function pre_set_site_transient_update_plugins( $transient ) {
		$disable_plugins_update = defined( 'THE7_PREVENT_PLUGINS_UPDATE' ) && THE7_PREVENT_PLUGINS_UPDATE;
		$new_plugin_info = self::get_plugin_info();
		if ( $new_plugin_info && ! $disable_plugins_update && presscore_theme_is_activated() ) {
			$plugin_basename = The7PT()->plugin_basename();
			$plugin_slug = dirname( $plugin_basename );

			// Save update info if there are newer version.
			if ( version_compare( The7PT()->version(), $new_plugin_info['version'], '<' ) ) {
				$plugin = new stdClass();
				$plugin->plugin = $plugin_basename;
				$plugin->slug = $plugin_slug;
				$plugin->new_version = $new_plugin_info['version'];
				$plugin->url = '';
				$plugin->package = $new_plugin_info['source'];
				$plugin->tested = ( isset( $new_plugin_info['tested'] ) ? $new_plugin_info['tested'] : '' );

				$transient->response[ $plugin_basename ] = $plugin;
			}
		}

		return $transient;
	}

	/**
	 * Plugin update info.
	 *
	 * @param $false
	 * @param $action
	 * @param $arg
	 *
	 * @return stdClass
	 */
	public static function plugin_update_info( $false, $action, $arg ) {
		$plugin_basename = The7PT()->plugin_basename();
		$plugin_slug = dirname( $plugin_basename );
		if ( isset( $arg->slug ) && $plugin_slug === $arg->slug ) {
			$plugin_info = self::get_plugin_info();
			if ( ! $plugin_info ) {
				return $false;
			}

			$info = new stdClass();
			$info->name = $plugin_info['name'];
			$info->version = $plugin_info['version'];
			$info->slug = $plugin_slug;
			$info->download_link = $plugin_info['source'];
			$info->author = '<a href="http://dream-theme.com/">Dream-Theme</a>';
			$info->sections = array(
				'description' => 'This plugin contains The7 custom post types and corresponding Visual Composer elements.',
			);

			return $info;
		}

		return $false;
	}

	/**
	 * Determine is theme compatible with current plugin version.
	 *
	 * @return bool
	 */
	public static function theme_is_compatible() {
		return defined( 'PRESSCORE_STYLESHEETS_VERSION' ) && version_compare( PRESSCORE_STYLESHEETS_VERSION, The7PT_Core::THE7_COMPATIBLE_VERSION, '>=' );
	}

	/**
	 * Display notice about outdated dt-the7 theme.
	 */
	public static function display_outdated_theme_notice() {
	    if ( ! defined( 'PRESSCORE_STYLESHEETS_VERSION' ) ) {
	        return;
        }

	    if ( ! current_user_can( 'update_themes' ) || self::theme_is_compatible() ) {
	        return;
        }
		?>
		<div class="the7-dashboard-notice the7-notice notice notice-error">
			<p>
				<?php echo wp_kses_post( sprintf( __( '<strong>Important notice</strong>: You have an outdated version of <strong>The7</strong> theme. For better compatibility with <strong>The7 Elements</strong> plugin it is required to <a href="%s">update the theme</a>.', 'dt-the7-core' ), admin_url( 'themes.php' ) ) ) ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Return plugin info from cache.
	 *
	 * @return array
	 */
	protected static function get_plugin_info() {
		if ( class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
			$plugin_slug = dirname( The7PT()->plugin_basename() );
			$plugins_list = Presscore_Modules_TGMPAModule::get_plugins_list_cache();
			foreach ( $plugins_list as $entry ) {
				if ( isset( $entry['slug'] ) && $plugin_slug === $entry['slug'] ) {
					return $entry;
				}
			}
		}

		return array();
	}
}