<?php
/**
 * The7 WPML options definition.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'WPML Flags', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'wpml',
);

$options[] = array(
	'name' => _x( 'WPML Flags', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['wpml_dt-custom_style'] = array(
	'name' => _x( 'Use The7 skin for the language switcher', 'theme-options', 'the7mk2' ),
	'id'   => 'wpml_dt-custom_style',
	'type' => 'checkbox',
	'std'  => '1',
);

/* translators: %s - link to wpml admin page */
$wpml_info_desc      = _x( 'Click "Save" and configure language switcher appearance %s', 'theme-options', 'the7mk2' );
$wpml_info_admin_url = admin_url( 'admin.php?page=sitepress-multilingual-cms%2Fmenu%2Flanguages.php#wpml-language-switcher-shortcode-action' );
$options[]           = array(
	'desc' => sprintf( $wpml_info_desc, '<a href="' . $wpml_info_admin_url . '">' . _x( 'here', 'theme-options', 'the7mk2' ) . '</a>' ),
	'type' => 'info',
);
