<?php
/**
 * The7 admin dashboard class.
 *
 * @package The7\Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Admin_Dashboard
 */
class The7_Admin_Dashboard {

	const UPDATE_DASHBOARD_SETTINGS_NONCE_ACTION = 'the7-update-dashboard_settings';

	/**
	 * @var array
	 */
	protected $pages = array();

	/**
	 * Setup base dashboard menu items data.
	 *
	 * @since 7.4.0
	 */
	public function setup_pages() {
		$this->pages = array(
			'the7-dashboard'    => array(
				'title'      => __( 'My The7', 'the7mk2' ),
				'capability' => 'edit_theme_options',
			),
			'the7-demo-content' => array(
				'title'      => __( 'Pre-made Websites', 'the7mk2' ),
				'capability' => 'edit_theme_options',
			),
			'the7-plugins'      => array(
				'title'      => __( 'Plugins', 'the7mk2' ),
				'capability' => 'install_plugins',
			),
			'the7-status'       => array(
				'title'      => __( 'Service Information', 'the7mk2' ),
				'capability' => 'switch_themes',
			),
		);
	}

	/**
	 * Init admin dashboard. Add hooks and all the needed to dashboard works.
	 */
	public function init() {
		add_action( 'after_setup_theme', array( $this, 'setup_pages' ), 9999 );
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		add_action( 'after_switch_theme', array( $this, 'redirect_to_dashboard' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
	}

	public function register_scripts() {
		the7_register_style( 'the7-dashboard', PRESSCORE_ADMIN_URI . '/assets/css/the7-dashboard' );
		the7_register_style( 'the7-dashboard-icons', PRESSCORE_ADMIN_URI . '/assets/fonts/the7-dashboard-icons/the7-dashboard-icons' );

		the7_register_script( 'the7-dashboard', PRESSCORE_ADMIN_URI . '/assets/js/the7-dashboard', array(), false, true );
		the7_register_script( 'the7-status', PRESSCORE_ADMIN_URI . '/assets/js/the7-status', array(), false, true );
	}

	/**
	 * Add admin pages.
	 */
	public function add_menu_page() {
		$dashboard_slug = $this->get_main_page_slug();
		$dashboard      = $this->get_main_page();

		$the7_page = add_menu_page( $dashboard['title'], __( 'The7', 'the7mk2' ), $dashboard['capability'], $dashboard_slug, array(
				$this,
				'menu_page_screen',
			), '', 3 );

		add_action( 'admin_print_styles-' . $the7_page, array( $this, 'enqueue_dashboard_styles' ) );
		add_action( 'admin_print_styles-' . $the7_page, array( $this, 'enqueue_styles' ) );
		add_action( 'admin_print_scripts-' . $the7_page, array( $this, 'enqueue_scripts' ) );
		add_action( 'load-' . $the7_page, array( $this, 'update_dashboard_settings_by_url' ) );

		$sub_page_hook_suffix = array();
		$sub_pages            = $this->get_sub_pages();

		foreach ( $sub_pages as $sub_page_slug => $sub_page ) {
			$page['dashboard_slug'] = $dashboard_slug;
			$page['slug']           = $sub_page_slug;
			$page['title']          = $sub_page['title'];
			$page['capability']     = $sub_page['capability'];

			$page                                  = apply_filters( 'the7_subpages_filter', $page );
			$hook_suffix                           = add_submenu_page( $page['dashboard_slug'], $page['title'], $page['title'], $page['capability'], $page['slug'], array(
					$this,
					'menu_page_screen',
				) );
			$sub_page_hook_suffix[ $page['slug'] ] = $hook_suffix;

			// Adds actions to hook in the required css and javascript
			add_action( 'admin_print_styles-' . $hook_suffix, array( $this, 'enqueue_styles' ) );
			add_action( 'admin_print_scripts-' . $hook_suffix, array( $this, 'enqueue_scripts' ) );
		}

		// Additional actions:

		// Demo content.
		add_action( 'load-' . $sub_page_hook_suffix['the7-demo-content'], array(
			the7_demo_content()->remote,
			'update_check',
		) );
		add_action( 'admin_print_styles-' . $sub_page_hook_suffix['the7-demo-content'], array(
			the7_demo_content()->admin,
			'enqueue_styles',
		) );
		add_action( 'admin_print_scripts-' . $sub_page_hook_suffix['the7-demo-content'], array(
			the7_demo_content()->admin,
			'enqueue_scripts',
		) );

		// Plugins.
		Presscore_Modules_TGMPAModule::setup_hooks( $sub_page_hook_suffix['the7-plugins'] );

		// Theme registration.
		Presscore_Modules_ThemeUpdateModule::setup_hooks( $the7_page );

		// Status page.
		add_action( 'admin_print_scripts-' . $sub_page_hook_suffix['the7-status'], array(
			$this,
			'enqueue_status_scripts',
		) );

		global $submenu;
		if ( isset( $submenu[ $dashboard_slug ] ) ) {
			$submenu[ $dashboard_slug ][0][0] = $dashboard['title'];
		}
	}

	/**
	 * This method choose which screen to show.
	 */
	public function menu_page_screen() {
		global $plugin_page;

		$view_file = PRESSCORE_ADMIN_DIR . '/screens/' . basename( $plugin_page ) . '.php';
		if ( is_readable( $view_file ) ) {
			include $view_file;
		}
	}

	/**
	 * Enqueue common styles.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'the7-dashboard' );
	}

	/**
	 * Enqueue common scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'the7-dashboard' );
	}

	/**
	 * Enqueue styles for dashboard page.
	 */
	public function enqueue_dashboard_styles() {
		wp_enqueue_style( 'the7-dashboard-icons' );
	}

	/**
	 * Enqueue scripts on status page.
	 */
	public function enqueue_status_scripts() {
		wp_enqueue_script( 'the7-status' );
	}

	/**
	 * Redirect to theme dashboard.
	 */
	public function redirect_to_dashboard() {
		$main_page_slug = $this->get_main_page_slug();
		wp_safe_redirect( admin_url( "admin.php?page=$main_page_slug" ) );
	}

	/**
	 * Update dashboard settings by url.
	 */
	public function update_dashboard_settings_by_url() {
		$settings_id = 'the7_dashboard_settings';

		if ( ! array_key_exists( $settings_id, $_GET ) || ! is_array( $_GET[ $settings_id ] ) ) {
			return;
		}

		if ( ! isset( $_GET[ '_wpnonce' ] ) || ! wp_verify_nonce( $_GET[ '_wpnonce' ], self::UPDATE_DASHBOARD_SETTINGS_NONCE_ACTION ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		$new_settings = wp_unslash( $_GET[ $settings_id ] );
		$settings_definition = The7_Admin_Dashboard_Settings::get_settings_definition();

		foreach ( $new_settings as $id => $value ) {
			if ( ! array_key_exists( $id, $settings_definition ) ) {
				continue;
			}

			$type = $settings_definition[ $id ]['type'];
			The7_Admin_Dashboard_Settings::set( $id, The7_Admin_Dashboard_Settings::sanitize_setting( $value, $type ) );
		}

		$this->redirect_to_dashboard();
		exit;
	}

	/**
	 * Return dashboard main page slug.
	 *
	 * @return string
	 */
	protected function get_main_page_slug() {
		reset( $this->pages );

		return key( $this->pages );
	}

	/**
	 * Return dashboard main page title.
	 *
	 * @return string
	 */
	protected function get_main_page() {
		reset( $this->pages );

		return current( $this->pages );
	}

	/**
	 * Return dashboard sub pages as array( 'slug' => 'title' ).
	 *
	 * @return array
	 */
	protected function get_sub_pages() {
		$pages = $this->pages;
		array_shift( $pages );

		return $pages;
	}
}