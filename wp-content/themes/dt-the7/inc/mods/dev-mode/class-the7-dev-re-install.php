<?php

/**
 * Class The7_Dev_Re_Install
 */
class The7_Dev_Re_Install {

	/**
	 * Bootstrap.
	 */
	public static function init() {
		add_filter( 'site_transient_update_themes', array( __CLASS__, 'fix_update_themes_transient' ) );
	}

	/**
	 * Fix update_theme transient so theme could be re installed.
	 *
	 * @param $transient
	 *
	 * @return mixed
	 */
	public static function fix_update_themes_transient( $transient ) {
		if ( ! isset( $_GET['the7-force-update'] ) || ! presscore_theme_is_activated() )  {
			return $transient;
		}

		$code = presscore_get_purchase_code();
		$the7_remote_api = new The7_Remote_API( $code );
		$theme_template = get_template();
		$transient->response[ $theme_template ] = array(
			'theme' => $theme_template,
			'new_version' => THE7_VERSION,
			'url' => presscore_theme_update_get_changelog_url(),
			'package' => $the7_remote_api->get_theme_download_url( THE7_VERSION ),
		);

		return $transient;
	}

}