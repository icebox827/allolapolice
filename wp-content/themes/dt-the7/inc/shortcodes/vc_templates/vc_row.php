<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

global $vc_manager;

$use_the7_rows          = ( ! $vc_manager || ! isset( $atts['type'] ) || $atts['type'] !== 'vc_default' );
$echo_shortcode_content = version_compare( WPB_VC_VERSION, '6.0.3', '<' );

if ( The7_Admin_Dashboard_Settings::get( 'rows' ) && $use_the7_rows ) {
	if ( $echo_shortcode_content ) {
		echo include dirname( __FILE__ ) . '/dt_vc_row.php'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return include dirname( __FILE__ ) . '/dt_vc_row.php';
	}
} else {
	if ( $echo_shortcode_content ) {
		include trailingslashit( $vc_manager->getDefaultShortcodesTemplatesDir() ) . 'vc_row.php';
	} else {
		return include trailingslashit( $vc_manager->getDefaultShortcodesTemplatesDir() ) . 'vc_row.php';
	}
}
