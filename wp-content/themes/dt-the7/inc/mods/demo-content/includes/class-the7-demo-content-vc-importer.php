<?php

/**
 * Class The7_Demo_Content_VC_Importer
 */
class The7_Demo_Content_VC_Importer {

	/**
	 * Tries to get Vc_Settings object. Returns object on success or null on error.
	 *
	 * @return null|Vc_Settings
	 */
	public function vc_settings() {
		if ( ! function_exists( 'vc_settings' ) ) {
			return null;
		}

		$vc_settings = vc_settings();

		if ( ! is_object( $vc_settings ) || ! method_exists( $vc_settings, 'set' ) || ! method_exists( $vc_settings, 'getFieldPrefix' ) ) {
			return null;
		}

		return $vc_settings;
	}

	/**
	 * Import VC settings.
	 *
	 * @param array $settings
	 *
	 * @return bool
	 */
	public function import_settings( $settings ) {
		$vc_settings = $this->vc_settings();

		if ( is_null( $vc_settings ) ) {
			return false;
		}

		// Setup settings.
		foreach ( $settings as $key => $value ) {
			$vc_settings->set( $key, $value );
		}

		return true;
	}

	/**
	 * Remove 'less_version' option so vc will show notice that user need to save settings.
	 *
	 * @return bool
	 */
	public function show_notification() {
		$vc_settings = $this->vc_settings();

		if ( is_null( $vc_settings ) ) {
			return false;
		}

		/**
		 * Display notice about saving VC settings.
		 * @see vc_check_for_custom_css_build()
		 */
		delete_option( $vc_settings->getFieldPrefix() . 'less_version' );

		return true;
	}
}