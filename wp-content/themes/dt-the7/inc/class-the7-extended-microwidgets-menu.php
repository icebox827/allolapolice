<?php
/**
 * Extended microwidgets menu.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Extended_Microwidgets_Menu
 */
class The7_Extended_Microwidgets_Menu extends The7_Mega_Menu {

	/**
	 * Add mega menu hooks.
	 */
	public function add_hooks() {
		add_filter( 'presscore_nav_menu_item', array( $this, 'menu_item' ), 10, 5 );
	}

	/**
	 * Remove mega menu hooks.
	 */
	public function remove_hooks() {
		remove_filter( 'presscore_nav_menu_item', array( $this, 'menu_item' ) );
	}

	/**
	 * Filter menu item. Add icon/image.
	 *
	 * @param string  $menu_item   Menu item code.
	 * @param string  $title       Menu item title.
	 * @param string  $description Menu item description.
	 * @param WP_Post $item        Menu item data object.
	 * @param int     $depth       Menu item depth.
	 *
	 * @return string
	 */
	public function menu_item( $menu_item, $title, $description, $item, $depth ) {
		if ( $menu_item ) {
			return $menu_item;
		}

		if ( $depth !== 0 ) {
			return '';
		}

		return parent::menu_item( $menu_item, $title, $description, $item, $depth );
	}
}
