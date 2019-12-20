<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    DT_Dummy
 * @subpackage DT_Dummy/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    DT_Dummy
 * @subpackage DT_Dummy/includes
 * @author     Dream-Theme
 */
class The7_Demo_Content {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.

	 * @since    1.0.0
	 * @access   protected
	 * @var      The7_Demo_Content_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Plugin dir.
	 */
	protected $plugin_dir;

	/**
	 * @var The7_Demo_Content_Admin
	 */
	public $admin;

	/**
	 * @var The7_Demo_Content_Remote_Content
	 */
	public $remote;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'dt-dummy';
		$this->version = '2.0.0.b0401171332';
		$this->plugin_dir = trailingslashit( plugin_dir_path( dirname( __FILE__ ) ) );

		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - DT_Dummy_Loader. Orchestrates the hooks of the plugin.
	 * - DT_Dummy_i18n. Defines internationalization functionality.
	 * - DT_Dummy_Admin. Defines all hooks for the dashboard.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once 'class-the7-demo-content-loader.php';

		/**
		 * Load admin utility classes.
		 */
		require_once 'interface-the7-demo-content-plugins-checker.php';
		require_once 'class-the7-demo-content-tgmpa.php';
		require_once 'class-the7-demo-content-import-manager.php';
		require_once 'class-the7-demo-content-remote-server-api.php';
		require_once 'class-the7-demo-content-phpstatus.php';
		require_once 'class-the7-demo-content-remote-content.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once $this->get_plugin_dir() . 'admin/class-the7-demo-content-admin.php';

		$this->loader = new The7_Demo_Content_Loader();
	}

	/**
	 * Retrieve plugin dir.
	 *
	 * @param string $path
	 *
	 * @since 1.2.0
	 * @return string
	 */
	public function get_plugin_dir( $path = '' ) {
		return $this->plugin_dir . $path;
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$this->admin = new The7_Demo_Content_Admin( $this->plugin_name, $this->version );
		$this->remote = new The7_Demo_Content_Remote_Content();

		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'register_scripts' );

		// Notices.
		$this->loader->add_action( 'admin_notices', $this->admin, 'display_successful_demo_installation_admin_notice' );

		// Ajax handler.
		$this->loader->add_action( 'wp_ajax_the7_import_demo_content', $this->admin, 'import_dummy_content' );
		$this->loader->add_action( 'wp_ajax_the7_demo_content_php_status', $this->admin, 'get_php_ini_status' );

		// Admin menu.
		$this->loader->add_action( 'admin_menu', $this->admin, 'add_import_by_url_admin_menu' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.

	 * @since     1.0.0
	 * @return    The7_Demo_Content_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
