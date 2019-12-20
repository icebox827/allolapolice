<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class The7RevolutionSlider extends BundledContent {

	public function activatePlugin() {
		if ( ! defined( 'REVSLIDER_THE7' ) ) {
			$this->deactivatePlugin();

			return;
		}
		$revslider_code = get_option( 'revslider-code', '' );
		if ( ! empty( $revslider_code ) ) {
			return;
		}
		add_filter( 'revslider_dashboard_elements', array( &$this, 'the7_revslider_dashboard_elements' ), 30, 2 );
		if ( $this->isActivatedPlugin() ) {
			return;
		}
		update_option( 'revslider-valid', 'true' );
		update_option( 'revslider-valid-notice', 'false' );
		update_option( 'the7-revslider-code', presscore_get_purchase_code() );
	}

	public function deactivatePlugin() {
		if ( ! $this->isActivatedPlugin() ) {
			return;
		}
		if ( ! $this->isActivatedByTheme() ) {
			return;
		}
		update_option( 'revslider-valid', 'false' );
		update_option( 'the7-revslider-code', '' );
	}

	public function isActivatedPlugin() {
		$result = ( get_option( 'revslider-valid', 'false' ) === 'true' ) ? true : false;

		return $result;
	}

	public function getBundledPluginCode() {
		return get_option( 'the7-revslider-code', '' );
	}

	public static function the7_revslider_dashboard_elements( $dashboard_array, $dbvariables ) {
		$excludeFromDashboard = array( 'rs-support', 'rs-validation', 'rs-newsletter', 'rs-templates');
		foreach ( $excludeFromDashboard as $dashboard_element ) {
			if ( isset( $dashboard_array[ $dashboard_element ] ) ) {
				unset( $dashboard_array[ $dashboard_element ] );
			}
		}
		if ( isset( $dashboard_array['rs-requirements'] ) ) {
			$dashboard_array['rs-requirements'] = str_replace( 'ThemePunch', __( 'The7', 'the7mk2' ), $dashboard_array['rs-requirements'] );
		}

		return $dashboard_array;
	}
}