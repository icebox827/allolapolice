<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

abstract class BundledContent {

	protected static $wpdb;
	protected static $filedir;

	public function __construct() {
		global $wpdb;
		self::$wpdb = $wpdb;
		self::$filedir = trailingslashit( dirname( __FILE__ ) );
	}

	abstract protected function activatePlugin();

	abstract protected function deactivatePlugin();

	abstract protected function isActivatedPlugin();

	abstract protected function getBundledPluginCode();

	public function isActivatedByTheme() {
		$bundledPluginCode = $this->getBundledPluginCode();
		if ( empty( $bundledPluginCode ) ) {
			return false;
		}
		$themeCode = get_site_option( 'the7_purchase_code', '' );
		if ( empty( $themeCode ) ) {
			return true;
		}
		$val = ( $themeCode === $bundledPluginCode );

		return $val;
	}
}