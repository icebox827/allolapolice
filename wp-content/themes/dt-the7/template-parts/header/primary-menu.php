<?php
/**
 * Primary menu.
 *
 * @since   3.0.0
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'presscore_before_primary_menu' );

$menu_location = ( isset( $menu_location ) ? $menu_location : 'primary' );

echo '<ul id="' . esc_attr( "{$menu_location}-menu" ) . '" class="' . implode( ' ', presscore_get_primary_menu_class( 'main-nav' ) ) . '" role="navigation">';

presscore_primary_nav_menu( $menu_location );

echo '</ul>';

do_action( 'presscore_after_primary_menu' );
