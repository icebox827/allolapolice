<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    DT_Dummy
 * @subpackage DT_Dummy/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    DT_Dummy
 * @subpackage DT_Dummy/admin
 * @author     Dream-Theme
 */
class The7_Demo_Content_Admin {

	/**
	 * Array of plugin pages ids.
	 *
	 * @var array
	 */
	private $plugin_page = array();

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * @var object
	 */
	private $plugins_checker = null;

	/**
	 * @var array
	 */
	private $dummies_list = array();

	/**
	 * DT_Dummy_Admin constructor.
	 *
	 * @since 1.0.0
	 * @param $plugin_name
	 * @param $version
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register scripts.
	 *
	 * @since 7.0.0
	 */
	public function register_scripts() {
		the7_register_style( 'the7-import-on-edit-screen', PRESSCORE_ADMIN_URI . '/assets/css/import-on-edit-screen' );
		the7_register_style( 'the7-demo-content', PRESSCORE_ADMIN_URI . '/assets/css/demo-content', array( 'the7-import-on-edit-screen' ) );

		the7_register_script( 'the7-demo-content', PRESSCORE_ADMIN_URI . '/assets/js/demo-content', array( 'jquery', 'jquery-ui-progressbar' ), false, true );
	}

	/**
	 * Enqueue styles for edit screen.
	 *
	 * @since 7.0.0
	 */
	public function enqueue_edit_screen_scripts() {
		if ( ! current_user_can( 'switch_themes' ) ) {
			return;
		}

		wp_enqueue_style( 'the7-import-on-edit-screen' );
		$this->enqueue_scripts();
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'the7-demo-content' );
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $the7_tgmpa, $typenow;

		wp_enqueue_script( 'the7-demo-content' );

		$plugins = array();
		$plugins_page_url = '';
		if ( class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
			$plugins = Presscore_Modules_TGMPAModule::get_plugins_list_cache();
			$plugins = wp_list_pluck( $plugins, 'name', 'slug' );

			if ( ! $the7_tgmpa->is_tgmpa_complete() ) {
				$plugins_page_url = $the7_tgmpa->get_bulk_action_link();
			}
		}

		$post_type_object = get_post_type_object( $typenow ? $typenow : 'post' );

		wp_localize_script( 'the7-demo-content', 'dtDummy', array(
			'import_nonce' => wp_create_nonce( $this->plugin_name . '_import' ),
			'status_nonce' => wp_create_nonce( $this->plugin_name . '_php_ini_status' ),
			'import_msg' => array(
				'btn_import'                         => __( 'Importing...', 'the7mk2' ),
				'msg_import_success'                 => __( 'Demo content successfully imported.', 'the7mk2' ),
				'msg_import_fail'                    => __( 'Import Fail!', 'the7mk2' ),
				'download_package'                   => __( 'Downloading package.', 'the7mk2' ),
				'import_post_types'                  => __( 'Importing content.', 'the7mk2' ),
				'import_attachments'                 => __( 'Importing attachments.', 'the7mk2' ),
				'import_theme_options'               => __( 'Importing theme options.', 'the7mk2' ),
				'import_rev_sliders'                 => __( 'Importing slider(s).', 'the7mk2' ),
				'cleanup'                            => __( 'Final cleanup.', 'the7mk2' ),
				'installing_plugin'                  => __( 'Installing', 'the7mk2' ),
				'activating_plugin'                  => __( 'Activating plugin(s)', 'the7mk2' ),
				'plugins_activated'                  => __( 'Plugin(s) activated successfully.', 'the7mk2' ),
				'plugins_installation_error'         => __( 'Server error.', 'the7mk2' ),
				'rid_of_redirects'                   => __( 'Cleanup after plugins installation.', 'the7mk2' ),
				'get_posts'                          => __( 'Parsing content.', 'the7mk2' ),
				'one_post_importing_msg'             => __( 'Importing', 'the7mk2' ),
				'one_post_importing_choose_posttype' => __( 'Choose post type', 'the7mk2' ),
				'one_post_importing_choose_post'     => __( 'Choose post', 'the7mk2' ),
				'one_post_importing_import'          => __( 'Import post', 'the7mk2' ),
				'one_post_importing_url_msg'         => __( 'example', 'the7mk2' ),
				'one_post_importing_success'         => __( 'Demo page successfully imported.', 'the7mk2' ),
				'cannot_found_page_by_url_error'     => esc_html( sprintf( __( '%%url%% is not a %s or does not exist.', 'the7mk2' ), strtolower( $post_type_object->labels->singular_name ) ) ),
				'cannot_get_posts_list_error'        => esc_html( __( 'Cannot get posts lists from package.', 'the7mk2' ) ),
				'invalid_url_error'                  => wp_kses( sprintf( __( 'Provided URL (link) is not valid. Please copy a valid URL (link) from one of %s.', 'the7mk2' ), '<a href="https://the7.io/#!/demos" target="_blank">The7 pre-made websites</a>' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
				'action_error'                       => esc_html( __( 'Error. Cannot complete following action', 'the7mk2' ) ),
			),
			'plugins' => $plugins,
			'plugins_page_url' => $plugins_page_url,
			'demo_urls' => $this->get_demo_urls(),
		) );
	}

	/**
	 * Add action link to plugin admin page.
	 *
	 * @since 1.2.0
	 * @param array $links
	 *
	 * @return array
	 */
	public function add_plugin_action_links( $links ) {
		$links['import-content'] = '<a href="' . esc_url( 'tools.php?page=dt-dummy-import' ) . '">' . __( 'Import content', 'the7mk2' ) . '</a>';
		return $links;
	}

	/**
	 * Add admin notice about successful demo installation.
	 *
	 * @since 6.0.1
	 * @param string $demo
	 */
	public function add_successful_demo_installation_admin_notice( $demo ) {
		set_transient( 'the7_demo_installed', $demo, 20 );
	}

	/**
	 * Display admin notice about successful demo installation.
	 *
	 * @since 6.0.1
	 */
	public function display_successful_demo_installation_admin_notice() {
		global $current_screen;

		if ( $current_screen->base !== 'the7_page_the7-demo-content' ) {
			return;
		}

		if ( ! get_transient( 'the7_demo_installed' ) ) {
			return;
		}

		the7_admin_notices()->add( 'the7_demo_content_installed', array(
			$this,
			'successful_demo_installation_notice'
		), 'updated the7-dashboard-notice' );
	}

	/**
	 * Print admin notice about successful demo installation.
	 *
	 * @since 6.0.1
	 */
	public function successful_demo_installation_notice() {
		$demo = get_transient( 'the7_demo_installed' );
		echo "<p>{$demo} has been successfully imported.</p>";
		delete_transient( 'the7_demo_installed' );
	}

	/**
	 * Import dummy content. Ajax response.
	 *
	 * @since 1.0.0
	 */
	public function import_dummy_content() {
		if ( ! check_ajax_referer( $this->plugin_name . '_import', false, false ) || ! current_user_can( 'edit_theme_options' ) ) {
			$error = ( the7_is_debug_on() ? '<p>' . __( 'Insufficient user rights.', 'the7mk2' ) . '</p>' : '' );
			wp_send_json_error( array( 'error_msg' => $error ) );
		}

		if ( empty( $_POST['dummy'] ) ) {
			$error = ( the7_is_debug_on() ? '<p>' . __( 'Unable to find dummy content.', 'the7mk2' ) . '</p>' : '' );
			wp_send_json_error( array( 'error_msg' => $error ) );
		}

		wp_raise_memory_limit( 'admin' );
		$execution_time = (int) ini_get( 'max_execution_time' );
		if ( $execution_time < 300 ) {
			the7_set_time_limit( 300 );
		}

		$dummy_slug = ( isset( $_POST['content_part_id'] ) ? sanitize_key( $_POST['content_part_id'] ) : '' );
		$wp_uploads = wp_get_upload_dir();
		$import_content_dir = trailingslashit( $wp_uploads['basedir'] ) . "the7-demo-content-tmp/{$dummy_slug}";
		$dummy_list = $this->get_dummy_list();

		$import_manager = new The7_Demo_Content_Import_Manager( $import_content_dir, $dummy_list[ $dummy_slug ] );

		do_action( 'the7_demo_content_before_content_import', $import_manager );

		$retval = null;

		switch ( $this->get_action() ) {
			case 'download_package':
				$source = isset( $_POST['demo_page_url'] ) ? $_POST['demo_page_url'] : '';
				$import_manager->download_dummy( $source );
				break;
			case 'import_post_types':
				$import_manager->import_post_types();
				$import_manager->import_wp_settings();
				$import_manager->import_vc_settings();
				break;
			case 'import_attachments':
				$include_attachments = ( isset( $dummy_list[ $dummy_slug ]['include_attachments'] ) ? (bool) $dummy_list[ $dummy_slug ]['include_attachments'] : false );
				$import_manager->import_attachments( $include_attachments );
				break;
			case 'import_theme_options':
				$import_manager->import_theme_option();
				$import_manager->import_ultimate_addons_settings();
				$import_manager->import_ultimate_addons_icon_fonts();
				$import_manager->import_the7_fontawesome();
				break;
			case 'import_rev_sliders':
				$import_manager->import_rev_sliders();
				break;
			case 'cleanup':
				$this->add_successful_demo_installation_admin_notice( $dummy_list[ $dummy_slug ]['title'] );
				$import_manager->cleanup_temp_dir();
				break;
			case 'get_posts':
				$retval = $import_manager->getPostsList( array(
					'page',
					'post',
					'product',
					'dt_portfolio',
					'dt_testimonials',
					'dt_gallery',
					'dt_team',
					'dt_slideshow',
				) );
				if ( is_array( $retval ) && ! $this->plugins_checker()->is_plugins_active( $this->get_demo_required_plugins( $dummy_slug ) ) ) {
					$retval['plugins_to_install'] = array_keys( $this->plugins_checker()->get_plugins_to_install() );
					$retval['plugins_to_activate'] = array_keys( $this->plugins_checker()->get_inactive_plugins() );
				}
				break;
			case 'import_one_post':
				$post_id = $import_manager->import_one_post();
				$retval  = array(
					'postPermalink' => get_permalink( $post_id ),
					'postEditLink' => get_edit_post_link( $post_id, 'return' ),
					'postImportActions' => $this->determine_post_import_actions( $post_id ),
				);
				break;
		}

		do_action( 'the7_demo_content_after_content_import', $import_manager );

		if ( $import_manager->has_errors() ) {
			wp_send_json_error( array( 'error_msg' => $import_manager->get_errors_string() ) );
		}

		wp_send_json_success($retval);
	}

	protected function get_action() {
		return $_POST['dummy'];
	}

	/**
	 * Check if php.ini have proper params values. Ajax response.
	 */
	public function get_php_ini_status() {
		if ( ! check_ajax_referer( $this->plugin_name . '_php_ini_status', false, false ) || ! current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error();
		}

		ob_start();
		include dirname( __FILE__ ) . '/partials/notices/status.php';
		$status = ob_get_clean();

		wp_send_json_success( $status );
	}

	/**
	 * Register plugin admin page.
	 *
	 * @since 1.0.0
	 * @use add_management_page
	 */
	public function add_plugin_page() {
		$this->plugin_page['import_dummy'] = '';
	}

	/**
	 * Render plugin admin page.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_page() {
		include 'partials/demos.php';
	}

	/**
	 * Return dummies list.
	 *
	 * @since 1.2.0
	 * @return array
	 */
	private function get_dummy_list() {
		return apply_filters( 'the7_demo_content_list', $this->dummies_list );
	}

	/**
	 * Return array of demo urls.
	 *
	 * Each item in list looks like [
	 *  'url' => string
	 *  'id' => string
	 * ]
	 *
	 * @since 7.0.0
	 *
	 * @return array
	 */
	private function get_demo_urls() {
		$demos = $this->get_dummy_list();
		$demo_urls = array();
		foreach( $demos as $demo ) {
			$demo_urls[] = array(
				'url' => $demo['link'],
				'id' => $demo['id'],
			);
		}

		return $demo_urls;
	}

	private function get_demo_required_plugins( $demo_slug ) {
		$demos = $this->get_dummy_list();
		if ( isset( $demos[ $demo_slug ]['required_plugins'] ) ) {
			return $demos[ $demo_slug ]['required_plugins'];
		}

		return null;
	}

	/**
	 * Factory method. Populates $plugins_checker property.
	 *
	 * @since 1.3.0
	 * @return The7_Demo_Content_TGMPA
	 */
	private function plugins_checker() {
		if ( null === $this->plugins_checker ) {
			$this->plugins_checker = new The7_Demo_Content_TGMPA();
		}

		return $this->plugins_checker;
	}

	/**
	 * Determine post-import actions based on provided post id.
	 *
	 * @since 7.0.0
	 *
	 * @param $post_id
	 *
	 * @return array
	 */
	private function determine_post_import_actions( $post_id ) {
		$actions = array();
		$post = get_post( $post_id );

		if ( ! $post ) {
			return array( 'cleanup' );
		}

		// import rev sliders?
		// search for shortcodes
		if ( preg_match( '/' . get_shortcode_regex( array( 'rev_slider_vc', 'rev_slider' ) ) . '/', $post->post_content ) ) {
			$actions[] = 'import_rev_sliders';
		}

		// check meta fields
		if (
			get_post_meta( $post_id, '_dt_header_title', true ) === 'slideshow'
			&& get_post_meta( $post_id, '_dt_slideshow_mode', true ) === 'revolution'
		) {
			$slider_in_use = get_post_meta( $post_id, '_dt_slideshow_revolution_slider', true );
			$actions[] = 'import_rev_sliders';
		}

		$actions[] = 'cleanup';

		return array_unique( $actions );
	}

	/**
	 * Add import by url admin pages.
	 *
	 * @since 7.0.0
	 */
	public function add_import_by_url_admin_menu() {
		$menu_items = array(
			array(
				'edit.php',
				_x( 'Import Post', 'admin', 'the7mk2' ),
				_x( 'Import', 'admin', 'the7mk2' ),
				'the7-import-post-by-url',
				'post-new.php',
			),
			array(
				'edit.php?post_type=page',
				_x( 'Import Page', 'admin', 'the7mk2' ),
				_x( 'Import', 'admin', 'the7mk2' ),
				'the7-import-page-by-url',
				'post-new.php?post_type=page',
			),
		);

		$menu_items = apply_filters( 'the7_import_by_url_menu_items', $menu_items );

		foreach ( $menu_items as $i => $menu_item ) {
			list( $parent_slug, $page_title, $menu_title, $menu_slug, $insert_after ) = $menu_item;
			$function = array( $this, 'display_import_by_url_admin_page' );
			$capability = 'switch_themes';
			$hook = the7_add_submenu_page_after( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function, $insert_after );
			add_action( "admin_print_scripts-{$hook}", array( $this, 'enqueue_edit_screen_scripts' ) );
		}
	}

	/**
	 * Import by url page callback.
	 *
	 * @since 7.0.0
	 */
	public function display_import_by_url_admin_page() {
		if ( ! current_user_can( 'switch_themes' ) ) {
			wp_die( _x( 'You have not sufficient capabilities to see this page.', 'admin', 'the7mk2' ) );
		}

		include dirname( __FILE__ ) . '/partials/demos/import-by-url.php';
	}
}
