<?php
/**
 * Toolbar API: The7_Options_Visual_Admin_Bar class
 *
 * @since   5.7.0
 * @package The7\Options
 */

defined( 'ABSPATH' ) || exit;

/**
 * Core class used to implement the Toolbar API.
 *
 * @since 5.7.0
 */
class The7_Options_Visual_Admin_Bar extends WP_Admin_Bar {

	/**
	 * @var array
	 */
	protected $white_list = array();

	/**
	 */
	public function render() {
		$root = $this->_bind();
		$root = $this->filter_root( $root );

		if ( $root ) {
			$this->_render( $root );
		}
	}

	/**
	 * @param array $white_list
	 */
	public function set_white_list( $white_list ) {
		$this->white_list = (array) $white_list;
	}

	/**
	 * @param object $root
	 *
	 * @return object
	 */
	protected function filter_root( $root ) {
		if ( ! $root ) {
			return $root;
		}

		foreach ( $root->children as $root_key => &$root_children ) {
			$white_list = array();
			if ( array_key_exists( $root_key, $this->white_list ) ) {
				$white_list = $this->white_list[ $root_key ];
			}

			foreach ( $root_children->children as $key => $child ) {
				if ( ! in_array( $child->id, $white_list ) ) {
					unset( $root_children->children[ $key ] );
				}
			}
		}

		return $root;
	}
}
