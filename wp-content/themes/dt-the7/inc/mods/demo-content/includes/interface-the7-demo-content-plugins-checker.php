<?php
/**
 * Plugins checher interface.
 *
 * @since 2.0.0
 * @package dt-dummy
 */

interface The7_Demo_Content_Plugins_Checker_Interface {

	public function is_plugins_active( $plugins = array() );

	public function get_inactive_plugins();

	public function get_plugins_to_install();

	public function get_install_plugins_page_link();

	public function get_plugin_name( $slug );
}
