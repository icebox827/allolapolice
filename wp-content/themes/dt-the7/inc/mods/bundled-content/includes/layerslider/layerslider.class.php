<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class The7Layerslider extends BundledContent {

	public function activatePlugin() {
		if ( ! defined( 'LAYERSLIDER_THE7' ) ) {
			$this->deactivatePlugin();

			return;
		}
		$plugin_code = $this->getBundledPluginCode();
		if ( ! empty($plugin_code) ) {
			return;
		}
		if ( $this->isActivatedPlugin() ) {
			return;
		}
		update_option( 'layerslider-authorized-site', true );
		update_option( 'layerslider-purchase-code', presscore_get_purchase_code() );
		update_option( 'layerslider-activated_by_the7', true );

		return;
	}

	public function deactivatePlugin() {
		if ( !$this->isActivatedPlugin() ) {
			return;
		}
		if ( !$this->isActivatedByTheme() ) {
			return;
		}
		update_option( 'layerslider-authorized-site', false );
		update_option( 'layerslider-purchase-code', '' );
		update_option( 'layerslider-activated_by_the7', false );
	}

	public function isActivatedPlugin() {
		return ( get_option('layerslider-authorized-site', false));
	}

	protected function getBundledPluginCode() {
		return get_option( 'layerslider-purchase-code', '' );
	}

	public function isActivatedByTheme() {
		return  ( get_option('layerslider-activated_by_the7', false));
	}
}