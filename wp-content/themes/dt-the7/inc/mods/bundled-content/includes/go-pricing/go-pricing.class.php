<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class The7GoPricing extends BundledContent {


	public function activatePlugin() {
	}

	public function deactivatePlugin() {
	}

	public function isActivatedPlugin() {
	}

	protected function getBundledPluginCode() {

	}

	public function isActivatedByTheme() {
		$themeCode = get_site_option( 'the7_purchase_code', '' );
		$retval = false;
		if ( ! empty( $themeCode ) ) {
			$retval = $themeCode;
		}

		return $retval;
	}
}