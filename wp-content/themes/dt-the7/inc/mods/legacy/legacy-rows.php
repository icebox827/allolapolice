<?php

class Presscore_Modules_Legacy_Rows {

	public static function launch() {
		add_filter( 'presscore_options_menu_config', array( __CLASS__, 'remove_stripe_theme_options' ), 99 );
	}

	public static function remove_stripe_theme_options( $menu_items ) {
		unset( $menu_items['of-stripes-menu'] );

		return $menu_items;
	}
}