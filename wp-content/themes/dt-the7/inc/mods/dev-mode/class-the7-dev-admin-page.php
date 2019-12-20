<?php

/**
 * Class The7_Dev_Admin_Page
 */
class The7_Dev_Admin_Page {

	/**
	 * Bootstrap page.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu_page' ) );
	}

	/**
	 * Add admin menu.
	 */
	public static function add_menu_page() {
		global $menu;

		$page_slug = add_menu_page(
			__( 'The7 Dev', 'the7mk2' ),
			__( 'The7 Dev', 'the7mk2' ),
			'switch_themes',
			'the7-dev',
			array( __CLASS__, 'display_page' )
		);

		add_action( "admin_print_styles-{$page_slug}", array( __CLASS__, 'enqueue_styles' ) );

		// Hide page in admin menu.
		foreach ( $menu as $num => $menu_item ) {
			if ( isset( $menu_item[5] ) && $menu_item[5] == $page_slug ) {
				unset( $menu[ $num ] );
				break;
			}
		}
	}

	/**
	 * Display admin page.
	 */
	public static function display_page() {
		include dirname( __FILE__ ) . '/views/the7-dev-page.php';
	}

	/**
	 * Enqueue page assets.
	 */
	public static function enqueue_styles() {
		wp_enqueue_style( 'the7-dashboard' );
	}
}