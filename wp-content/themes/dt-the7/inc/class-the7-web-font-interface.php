<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

interface The7_Web_Font_Interface {

	/**
	 * @return string
	 */
	public function get_family();

	/**
	 * @return string
	 */
	public function get_subset();

	/**
	 * @return array
	 */
	public function get_weight();

	/**
	 * @param string $subset
	 *
	 * @return void
	 */
	public function set_subset( $subset );

	/**
	 * @param array $weight
	 *
	 * @return void
	 */
	public function set_weight( $weight );

	/**
	 * @param string $weight
	 *
	 * @return void
	 */
	public function add_weight( $weight );
}