<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'The7_DevToolMainModule', false ) ) :

	class The7_DevToolMainModule {

		protected $plugin_name;

		protected $version;

		protected $plugin_dir;

		const DEV_TOOL_OPTION = 'the7_dev_tool_option';

		private $options = array();

		private $_message = "";

		public function __construct() {
			$this->plugin_name = 'the7-dev-tools';
			$this->version = '1.0.0';
			$this->plugin_dir = trailingslashit( dirname( __FILE__ ) );
			$this->options = get_option( self::DEV_TOOL_OPTION, array() );
		}

		public function execute() {
			if ( ! is_admin() ) {
				return;
			}
			if ( empty( $this->options ) ) {
				$this->resetTheme();
			}
			register_setting( self::DEV_TOOL_OPTION, self::DEV_TOOL_OPTION, array( $this, 'validate_options' ) );
		}

		public static function init() {
			add_action( 'admin_notices', array( __CLASS__, 'add_admin_notice' ), 1 );
			add_action( 'admin_notices', array( __CLASS__, 'remove_plugin_notices' ), 9999 );
			add_action( 'vc_settings_tabs', array( __CLASS__, 'remove_vc_tabs'), 10, 1);

			add_filter('upgrader_pre_download', array(__CLASS__, 'pre_download_filter' ), 1, 4);

			$is_replace = The7_DevToolMainModule::getToolOption( 'replace_theme_branding' );
			if ($is_replace) {
				add_action( 'admin_notices', array( __CLASS__, 'white_label_admin_notice_enable' ), 1 );
				add_action( 'admin_notices', array( __CLASS__, 'white_label_admin_notice_disable' ), 9999 );
			}
			add_action( 'after_setup_theme', array( __CLASS__, 'dev_tools_after_setup_theme' ), 9999 );
			add_action( 'admin_menu', array( __CLASS__, 'dev_tools_menu_filter' ), 9999 );
			add_action( 'admin_bar_menu', array( __CLASS__, 'dev_tools_admin_bar_filter' ), 1 );
			add_filter( 'upgrader_post_install', array( __CLASS__, 'restore_dev_tool_files' ), 11, 3 );
			add_action( 'optionsframework_get_options_id', array(
				__CLASS__,
				'dev_tools_optionsframework_get_options_id',
			) );
			add_action( 'the7_subpages_filter', array( __CLASS__, 'dev_tools_the7_subpages_filter' ) );
		}


		public static function pre_download_filter($reply, $package, $updater) {
			global $the7_tgmpa;
			if (!presscore_theme_is_activated()) return $reply;

			if ( ! $the7_tgmpa ) {
				if (class_exists( 'Presscore_Modules_TGMPAModule' )){
					Presscore_Modules_TGMPAModule::init_the7_tgmpa();
					Presscore_Modules_TGMPAModule::register_plugins_action();
				}
				else return $reply;
			}
			$skin = $updater->skin;

			$slug_found = "";
			if ( false === $updater->bulk && isset( $skin->options['extra']['slug'] ) ) {
				$slug_found = $skin->options['extra']['slug'];
			} else {
				// Bulk installer contains less info, so fall back on the info registered in tgma
				foreach ( $the7_tgmpa->plugins as $slug => $plugin ) {
					if (!$the7_tgmpa->is_the7_plugin($slug)) continue;
					if ( isset( $skin->plugin_info['Name'] ) && $plugin['name'] === $skin->plugin_info['Name'] ) {
						$slug_found = $slug;
						break;
					}
				}
				unset( $slug, $plugin );
			}

			if(!empty($slug_found)) {
				$skin->plugin = "ignore";
				if (isset($skin->plugin_info['Name']))
					$skin->plugin_info['Name'] = $skin->plugin;
			}
			return $reply;
		}

		public static function add_admin_notice() {
			if ( get_transient( 'the7_dev_tool_error' ) ) {
				the7_admin_notices()->add( 'the7_dev_tool_error', array( __CLASS__, 'render_error_notice' ), 'error the7-dashboard-notice' );
			}

			if (presscore_is_silence_enabled())
			{
				global $the7_tgmpa;
				if ( ! $the7_tgmpa && class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
					Presscore_Modules_TGMPAModule::init_the7_tgmpa();
					Presscore_Modules_TGMPAModule::register_plugins_action();
				}

				if ($the7_tgmpa->is_the7_plugin( "LayerSlider" )){
					if (defined('LS_PLUGIN_BASE')) {
						remove_action( 'after_plugin_row_' . LS_PLUGIN_BASE, 'layerslider_plugins_purchase_notice', 10 );
					}
				}

				if ($the7_tgmpa->is_the7_plugin("go_pricing")) {
					if ( method_exists( 'GW_GoPricing_AdminNotices', 'instance' ) ) {
						remove_action( 'admin_notices', array( GW_GoPricing_AdminNotices::instance(), 'print_remote_admin_notices' ) );
					}
				}

				if ( $the7_tgmpa->is_the7_plugin( "js_composer" ) )				{
					if( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_license' ) ) //wpbakery
						remove_action( 'admin_notices', array( vc_license(), 'adminNoticeLicenseActivation' ), 10 );
				}

				if ($the7_tgmpa->is_the7_plugin("Ultimate_VC_Addons") || $the7_tgmpa->is_the7_plugin("convertplug"))
				{
					if (defined("ULTIMATE_VERSION")) { //ult addon
						if ( ! defined( 'BSF_PRODUCTS_NOTICES' ) )
						{
							define( 'BSF_PRODUCTS_NOTICES', false );
						}
					}
				}
			}
		}

		public static function white_label_admin_notice_enable() {
			add_filter( 'gettext', array( __CLASS__, 'replace_theme_name' ), 1, 3 );
		}
		public static function white_label_admin_notice_disable() {
			remove_filter( 'gettext',  array( __CLASS__, 'replace_theme_name' ), 1);
		}

		public static function replace_theme_name( $translation, $text, $domain ) {
			return str_replace( 'The7',   'theme' , $translation );
		}

		static function remove_plugin_notices(){
			global $the7_tgmpa;
			if ( ! $the7_tgmpa && class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
				Presscore_Modules_TGMPAModule::init_the7_tgmpa();
				Presscore_Modules_TGMPAModule::register_plugins_action();
			}

			if ( $the7_tgmpa->is_the7_plugin( "revslider" ) ) {
				remove_action( 'after_plugin_row_revslider/revslider.php', array(
					'RevSliderAdmin',
					'add_notice_wrap_pre'
				), 10 );
				remove_action( 'after_plugin_row_revslider/revslider.php', array(
					'RevSliderAdmin',
					'show_purchase_notice'
				), 10 );
				remove_action( 'after_plugin_row_revslider/revslider.php', array(
					'RevSliderAdmin',
					'add_notice_wrap_post'
				), 10 );
			}
			if ( $the7_tgmpa->is_the7_plugin( "js_composer" ) )				{
				if( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_updater' )  && function_exists( 'vc_plugin_name' )) { //wpbakery
					remove_action( 'in_plugin_update_message-' . vc_plugin_name(), array(
						vc_updater()->updateManager(),
						'addUpgradeMessageLink'
					), 10 );
				}
			}
			if ( $the7_tgmpa->is_the7_plugin("Ultimate_VC_Addons")) {
				if ( method_exists( 'BSF_Update_Manager', 'getInstance' ) ) {
					remove_action( 'in_plugin_update_message-Ultimate_VC_Addons/Ultimate_VC_Addons.php', array(
						BSF_Update_Manager::getInstance(),
						'bsf_add_registration_message'
					), 9 );
				}
			}
			if ( $the7_tgmpa->is_the7_plugin("convertplug")) {
				if ( method_exists( 'BSF_Update_Manager', 'getInstance' ) ) {
					remove_action( 'in_plugin_update_message-convertplug/convertplug.php', array(
						BSF_Update_Manager::getInstance(),
						'bsf_add_registration_message'
					), 9 );
				}
			}
		}

		static function  remove_vc_tabs($tabs) {
			if (presscore_is_silence_enabled()) {
				global $the7_tgmpa;
				if ( ! $the7_tgmpa && class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
					Presscore_Modules_TGMPAModule::init_the7_tgmpa();
					Presscore_Modules_TGMPAModule::register_plugins_action();
				}
				if ( $the7_tgmpa->is_the7_plugin( "js_composer" ) ) {
					unset( $tabs["vc-updater"] );
				}
			}
			return $tabs;
		}

		static function dev_tools_after_setup_theme() {
			$theme_version = wp_get_theme( get_template())->Version;
			if ( $theme_version === "6.0.0" ) {
				$devTools = new The7_DevToolMainModule();
				$devTools->updateThemeFiles( PRESSCORE_STYLESHEETS_VERSION );
			}
		}

		static function dev_tools_optionsframework_get_options_id( $name ) {
			if ( self::getToolOption( 'use_the7_options' ) ) {
				return "the7";
			}

			return $name;
		}

		static function dev_tools_the7_subpages_filter( $page ) {
			if ( self::getToolOption( 'hide_the7_menu' ) && ( $page['dashboard_slug'] === 'the7-dashboard' ) && ( $page['slug'] === 'the7-plugins' ) ) {
				$page['dashboard_slug'] = 'plugins.php';
				$theme_name = self::getToolOption( 'theme_name' );
				$page['title'] = $theme_name . ' ' . $page['title'];
			}

			return $page;
		}

		public static function dev_tools_admin_bar_filter() {
			if ( self::getToolOption( 'hide_theme_options' ) ) {
				remove_action( 'admin_bar_menu', 'optionsframework_admin_bar_theme_options', 40 );
			}
		}

		public static function dev_tools_menu_filter() {
			global $menu, $submenu;
			global $the7_tgmpa;

			if ( self::getToolOption( 'hide_the7_menu' ) ) {
				remove_menu_page( 'the7-dashboard' );
			}
			if ( self::getToolOption( 'hide_theme_options' ) ) {
				remove_menu_page( 'of-options-wizard' );
			}

			$is_replace = The7_DevToolMainModule::getToolOption( 'replace_theme_branding' );
			if ( $is_replace ) {
				$replace_text = "";
				foreach ( $menu AS $k => &$v ) {
					$result = array_search( 'the7-dashboard', $v );
					if ( ! $result ) {
						$v[0] = str_replace( "The7", $replace_text, $v[0] );
					}
				}
			}
			if (presscore_is_silence_enabled()) {
				if ( ! $the7_tgmpa && class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
					Presscore_Modules_TGMPAModule::init_the7_tgmpa();
					Presscore_Modules_TGMPAModule::register_plugins_action();
				}
				if ( $the7_tgmpa->is_the7_plugin( "Ultimate_VC_Addons" ) ) {
					remove_submenu_page( "about-ultimate", "ultimate-product-license" );
				}
			}
		}

		public function initDefaultThemeStyle() {
			$default = include $this->plugin_dir . "templates/style-default.css.php";
			$this->options = array_merge( $this->options, $default );
		}

		public function validate_options( $input ) {
			$validateCheckboxed = array(
				"replace_theme_descr",
				"hide_the7_menu",
				"hide_theme_options",
				"replace_theme_branding",
				"use_the7_options"
			);

			$this->options = array_merge( $this->options, $input );
			foreach ( $this->options as $field => $value ) {
				switch ( $field ) {
					case 'theme_name':
						$this->options[ $field ] = sanitize_text_field( $value );
						//$this->options[ $field ] = preg_replace( '/\s+/', '', $this->options[ $field ] );
						break;
					case 'theme_url':
						$this->options[ $field ] = esc_url( $value );
						break;
					case 'theme_author_uri':
						$this->options[ $field ] = esc_url( $value );
						break;
					default:
						$this->options[ $field ] = sanitize_text_field( $value );
				}
			}
			foreach ( $validateCheckboxed as $value ) {
				$this->options[ $value ] = self::arr_get( $input, $value, false );
				$this->options[ $value ] = $this->sanitize_checkbox( $this->options[ $value ] );
			}

			$this->updateThemeFiles();

			if ( is_multisite() ) {
				update_site_option( self::DEV_TOOL_OPTION . '-network', $this->options );
			}

			return $this->options;
		}

		private function sanitize_checkbox( $input ) {
			if ( $input ) {
				$output = '1';
			} else {
				$output = false;
			}

			return $output;
		}

		public function setDevToolsOptions() {
			return update_option( self::DEV_TOOL_OPTION, $this->options );
		}

		public function isReplaceThemeDescription() {
			return self::arr_get( $this->options, 'replace_theme_descr', false );
		}

		public function resetTheme() {
			$this->initDefaultThemeStyle();
			$this->options['theme_name'] = $this->options['theme_title'];
			$this->options['screenshot'] = '';
			$this->setDevToolsOptions();
		}

		private function get_optionsframework_theme_name( $name ) {
			return preg_replace( "/\W/", "", strtolower( $name ) );
		}

		private function updateThemeFilesErrorHandling( $theme_version = '' ) {
			global $wp_filesystem;

			if ( empty( $this->options ) ) {
				return;
			}

			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			if ( ! $wp_filesystem && ! WP_Filesystem( false, PRESSCORE_THEME_DIR ) ) {
				$this->_message = __( 'Cannot access file system.', 'the7mk2' );
				return;
			}

			$current_theme = wp_get_theme();

			$this->options['modified_folder_name'] = $current_theme->Template;
			//fill variables
			$theme_title = self::arr_get( $this->options, 'theme_name', '' );
			$theme_uri = self::arr_get( $this->options, 'theme_url', '' );
			$theme_author = self::arr_get( $this->options, 'theme_author', '' );
			$theme_author_uri = self::arr_get( $this->options, 'theme_author_uri', '' );
			$theme_description = self::arr_get( $this->options, 'theme_description', '' );
			$theme_tags = self::arr_get( $this->options, 'theme_tags', '' );
			if ( empty( $theme_version ) ) {
				$theme_version = wp_get_theme( $current_theme->Template )->Version;
			}

			//write style css
			ob_start();
			$styleTemplateFile = $this->plugin_dir . 'templates/style-css.php';
			$ret = $wp_filesystem->exists( $styleTemplateFile );
			if ( !$ret  ) {
				return;
			}
			require $this->plugin_dir . 'templates/style-css.php';
			$css = ob_get_clean();
			$wp_filesystem->put_contents( PRESSCORE_THEME_DIR . '/style.css', $css );

			if ( $screenshot_local_filename = $this->searchScreenshot( PRESSCORE_THEME_DIR ) ) {
				$screenshot_local_path = PRESSCORE_THEME_DIR . '/' . $screenshot_local_filename;
				$ret = $wp_filesystem->delete($screenshot_local_path);
				if ( !$ret ) {
					$this->_message = __( 'Cannot delete screenshot file', 'the7mk2' );
					return;
				}
			}
			//copy screenshot image
			$screenshot = self::arr_get( $this->options, 'screenshot', '' );
			if ( empty( $screenshot ) ) {
				$screenshot_path = $this->plugin_dir . "templates/screenshot.jpg";
				$screenshot_file =  PRESSCORE_THEME_DIR . "/screenshot." . pathinfo( $screenshot_path, PATHINFO_EXTENSION );
				$ret = $wp_filesystem->copy( $screenshot_path, $screenshot_file );
				if ( !$ret ) {
					$this->_message = __( 'Cannot write write file ', 'the7mk2' ) . $screenshot_file;
				}
			} else {
				$screenshot_path = $this->options['screenshot'];
				$screenshot_file =  PRESSCORE_THEME_DIR . "/screenshot." . pathinfo( $screenshot_path, PATHINFO_EXTENSION );
				$get = wp_remote_get($screenshot_path,  array( 'timeout' => 200 ));
				if ( ! $get || is_wp_error($get) || $get["response"]["code"] != "200" ) {
					$this->_message = __( 'Cannot download file from url ', 'the7mk2' );
					if (is_wp_error($get))
						$this->_message = $this->_message . $get->get_error_message();
				} else {
					$ret = $wp_filesystem->put_contents( $screenshot_file, $get['body']);
					if ( !$ret ) {
						$this->_message = __( 'Cannot write write file ', 'the7mk2' ) . $screenshot_file;
					}
				}
			}
		}

		public function updateThemeFiles( $theme_version = '' ) {
			$this->_message = "";
			$this->updateThemeFilesErrorHandling($theme_version);
			if (!empty($this->_message))
			{
				set_transient( 'the7_dev_tool_error', $this->_message, 60 );
				return;
			}
		}

		public static function render_error_notice()  {
			$error_notice = get_transient( 'the7_dev_tool_error');
			delete_transient( 'the7_dev_tool_error' );
			echo '<p><strong>' . $error_notice . '</strong></p>';
		}

		/**
		 * Searches directory for a theme screenshot
		 *
		 * @param  string $directory directory to search (a theme directory)
		 *
		 * @return string|false 'screenshot.png' (or whatever) or false if there is no screenshot
		 */
		private function searchScreenshot( $directory ) {
			$screenshots = glob( $directory . '/screenshot.{png,jpg,jpeg,gif}', GLOB_BRACE );

			return ( empty( $screenshots ) ) ? false : basename( $screenshots[0] );
		}

		public static function restore_dev_tool_files( $res = true, $hook_extra = array(), $result = array() ) {
			if ( is_wp_error( $res ) || ! isset( $hook_extra['theme'] ) || 'dt-the7' !== $hook_extra['theme'] ) {
				return $res;
			}
			$devTools = new The7_DevToolMainModule();
			$theme_name = self::arr_get( $devTools->options, 'theme_name', '' );
			$screenshot = self::arr_get( $devTools->options, 'screenshot', '' );
			if ( ! $devTools->isReplaceThemeDescription() && ( empty( $theme_name ) || $theme_name === "The7" ) && empty( $screenshot ) ) {
				return $res;
			}
			wp_clean_themes_cache( true );
			$devTools->updateThemeFiles();

			return $res;
		}

		public static function get_setting_name( $name ) {
			return self::DEV_TOOL_OPTION . "[$name]";
		}

		public static function getDevToolsOptions() {
			return self::get_option( self::DEV_TOOL_OPTION, array() );
		}

		public static function getOptionName() {
			return self::DEV_TOOL_OPTION;
		}

		public static function getToolOption( $name ) {
			if ( is_multisite() ) {
				$options = get_site_option( self::DEV_TOOL_OPTION . '-network' );
			} else {
				$options = get_option( self::DEV_TOOL_OPTION );
			}

			if ( isset( $options[ $name ] ) ) {
				return $options[ $name ];
			}

			return null;
		}

		public static function getToolOptionDefault( $name, $defaultVal ) {
			$result = getToolOption($name);
			if ($result === NULL){
				return $defaultVal;
			}
			return $result;
		}


		private static function arr_get( $array, $key, $default = null ) {
			return isset( $array[ $key ] ) ? $array[ $key ] : $default;
		}
	}
endif;

