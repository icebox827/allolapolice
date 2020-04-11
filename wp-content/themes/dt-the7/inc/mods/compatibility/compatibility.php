<?php
/**
 * Compatibility module.
 *
 * @since 3.0.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$path = dirname( __FILE__ );

include $path . '/class-compatibility-vc.php';
include $path . '/class-compatibility-ubermenu.php';
include $path . '/class-compatibility-tec.php';
include $path . '/class-compatibility-layerslider.php';
include $path . '/class-compatibility-jetpack.php';
include $path . '/class-compatibility-bbpress.php';
include $path . '/class-compatibility-ldlms.php';
include $path . '/class-compatibility-gopricing.php';
include $path . '/wpml/class-compatibility-wpml.php';
include $path . '/backward-compat/mod-the7-compatibility.php';
include $path . '/edd/class-compatibility-edd.php';
include $path . '/class-the7-sensei-compatibility.php';
include $path . '/the7-ti-wishlist-compatibility.php';

The7_Sensei_Compatibility::bootstrap();

if ( class_exists( 'Woocommerce', false ) ) {
	require_once $path . '/woocommerce/class-the7-woocommerce-compatibility.php';
	$woocommerce_adapter = new The7_Woocommerce_Compatibility();
	$woocommerce_adapter->bootstrap();
}

if ( defined( 'MECEXEC' ) ) {
	require_once $path . '/class-the7-mec-compatibility.php';
	$mec_compat = new The7_MEC_Compatibility();
	$mec_compat->bootstrap();
}

if ( defined( 'MPHB_PLUGIN_FILE' ) ) {
	require_once $path . '/class-the7-mphb-compatibility.php';
	$mphb_compat = new The7_MPHB_Compatibility();
	$mphb_compat->bootstrap();
}

if ( defined( 'ULTIMATE_VERSION' ) ) {
	require_once $path . '/class-the7-ultimate-vc-addons-compatibility.php';
	$ua_adapter = new The7_Ultimate_VC_Addons_Compatibility();
	$ua_adapter->bootstrap();
}

if ( class_exists( 'Elementor\Plugin' ) ) {
	require_once $path . '/elementor/class-the7-elementor-compatibility.php';
	The7_Elementor_Compatibility::instance();
}
