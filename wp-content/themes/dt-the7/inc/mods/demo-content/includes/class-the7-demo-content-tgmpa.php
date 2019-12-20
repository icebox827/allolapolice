<?php
/**
 * TGMPA facade.
 *
 * @since   2.0.0
 * @package dt-dummy
 */

class The7_Demo_Content_TGMPA implements The7_Demo_Content_Plugins_Checker_Interface {

	/**
	 * array( 'slug' => 'name' )
	 * 
	 * @var array
	 */
	protected $inactive_plugins = array();

	/**
	 * @var array
	 */
	protected $plugins_to_install = array();

	/**
	 * Returns false if any of $plugins is not active, in other cases returns true.
	 * 
	 * @param  array   $plugins
	 * @return boolean
	 */
	public function is_plugins_active( $plugins = array() ) {
		global $the7_tgmpa;

		if ( ! $the7_tgmpa && class_exists( 'Presscore_Modules_TGMPAModule' ) ) {
			Presscore_Modules_TGMPAModule::init_the7_tgmpa();
			Presscore_Modules_TGMPAModule::register_plugins_action();
		}

		$this->inactive_plugins = $this->plugins_to_install = array();

		if ( $plugins ) {
			foreach ( $plugins as $plugin_slug ) {
				if ( ! $the7_tgmpa->is_plugin_installed( $plugin_slug ) ) {
					$this->plugins_to_install[ $plugin_slug ] = $this->get_plugin_name( $plugin_slug );
					continue;
				}

				if ( ! $the7_tgmpa->is_plugin_active( $plugin_slug ) ) {
					$this->inactive_plugins[ $plugin_slug ] = $this->get_plugin_name( $plugin_slug );
				}
			}

			if ( $this->inactive_plugins || $this->plugins_to_install ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Returns array of inactive plugins.
	 *
	 * @return array
	 */
	public function get_inactive_plugins() {
		return $this->inactive_plugins;
	}

	public function get_plugins_to_install() {
		return $this->plugins_to_install;
	}

	/**
	 * If all plugins installed and active - returns empty string. In other cases returns url to tgmpa plugins page.
	 * 
	 * @return string
	 */
	public function get_install_plugins_page_link() {
		global $the7_tgmpa;

		if ( $the7_tgmpa->is_tgmpa_complete() ) {
			return '';
		}

		return $the7_tgmpa->get_bulk_action_link();
	}

	/**
	 * Returns $slug plugin name if it is registered, in other cases returns $slug.
	 * 
	 * @param  string $slug
	 * @return string
	 */
	public function get_plugin_name( $slug ) {
		global $the7_tgmpa;

		if ( isset( $the7_tgmpa->plugins[ $slug ] ) ) {
			return $the7_tgmpa->plugins[ $slug ]['name'];
		}

		return $slug;
	}

	/**
	 * Checks if $the7_tgmpa global is not empty.
	 * 
	 * @return boolean
	 */
	public static function is_tgmpa_active() {
		return ( ! empty( $GLOBALS['the7_tgmpa'] ) && is_a( $GLOBALS['the7_tgmpa'], 'The7_TGMPA' ) );
	}
}
