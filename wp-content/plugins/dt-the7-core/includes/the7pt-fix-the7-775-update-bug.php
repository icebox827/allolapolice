<?php

defined( 'ABSPATH' ) || exit;

if ( version_compare( wp_get_theme( get_template() )->get( 'Version' ), '7.7.5', '!=' ) ) {
	return;
}

if ( ! defined( 'THE7_PREVENT_THEME_UPDATE' ) ) {
	define( 'THE7_PREVENT_THEME_UPDATE', true );
}

add_filter( 'pre_set_site_transient_update_themes', 'the7pt_pre_set_site_transient_update_themes' );

/**
 * Adjust update_themes site transient to honor theme update from Envato server.
 *
 * @param $transient
 *
 * @return mixed
 */
function the7pt_pre_set_site_transient_update_themes( $transient ) {
	if ( ! function_exists( 'presscore_theme_is_activated' ) || ! presscore_theme_is_activated() )  {
		return $transient;
	}

	$code = presscore_get_purchase_code();
	$the7_remote_api = new The7_Remote_API( $code );

	// Check The7 version.
	$response = $the7_remote_api->check_theme_update();
	if ( is_wp_error( $response ) || ! isset( $response['version'] ) ) {
		return $transient;
	}

	$new_version = $response['version'];

	// Save update info if there are newer version.
	$theme_template = get_template();
	if ( version_compare( wp_get_theme( $theme_template )->get( 'Version' ), $new_version, '<' ) ) {
		$transient->response[ $theme_template ] = array(
			'theme' => $theme_template,
			'new_version' => $new_version,
			'url' => presscore_theme_update_get_changelog_url(),
			'package' => $the7_remote_api->get_theme_download_url( $new_version ),
		);
	}

	return $transient;
}