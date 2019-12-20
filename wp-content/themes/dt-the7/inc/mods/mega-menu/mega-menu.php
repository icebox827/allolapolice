<?php
/**
 * Mega menu bootstrap.
 *
 * @since   3.0.0
 *
 * @package The7\Modules
 */

defined( 'ABSPATH' ) || exit;

// Admin hooks.
$mega_menu_admin = new The7_Admin_Mega_Menu();
add_filter( 'wp_setup_nav_menu_item', array( $mega_menu_admin, 'wp_setup_nav_menu_item' ) );
add_action( 'wp_update_nav_menu_item', array( $mega_menu_admin, 'wp_update_nav_menu_item' ), 10, 2 );
add_action( 'admin_print_styles-nav-menus.php', array( $mega_menu_admin, 'admin_enqueue_scripts' ) );
add_action( 'admin_print_footer_scripts-nav-menus.php', array( $mega_menu_admin, 'output_popup_template' ) );
add_action( 'wp_ajax_the7_render_mega_menu_settings', array( $mega_menu_admin, 'ajax_render_mega_menu_settings' ) );

// Front hooks.
$mega_menu_front = new The7_Mega_Menu();
add_action( 'presscore_primary_nav_menu_before', array( $mega_menu_front, 'add_hooks' ) );
add_action( 'presscore_primary_nav_menu_after', array( $mega_menu_front, 'remove_hooks' ) );
