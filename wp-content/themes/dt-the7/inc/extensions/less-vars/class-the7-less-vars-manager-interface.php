<?php
/**
 * The7 less vars manager interface.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Interface The7_Less_Vars_Manager_Interface
 */
interface The7_Less_Vars_Manager_Interface {

	/**
	 * @param array $items
	 */
	public function import( $items );

	/**
	 * @param string $var
	 *
	 * @return mixed
	 */
	public function get_var( $var );

	/**
	 * @return array
	 */
	public function get_vars();

	/**
	 * @param array     $var
	 * @param array     $value
	 * @param string|null $wrap
	 */
	public function add_image( $var, $value, $wrap = null );

	/**
	 * @param string|array     $var
	 * @param string|array     $value
	 * @param string|null $wrap
	 */
	public function add_hex_color( $var, $value, $wrap = null );

	/**
	 * @param string|array     $var
	 * @param string     $value
	 * @param string|null $wrap
	 */
	public function add_rgb_color( $var, $value, $wrap = null );

	/**
	 * @param string|array     $var
	 * @param string|array     $value
	 * @param int|null $opacity
	 * @param string|null $wrap
	 */
	public function add_rgba_color( $var, $value, $opacity = null, $wrap = null );

	/**
	 * @param      $var
	 * @param      $value
	 * @param null $wrap
	 */
	public function add_pixel_number( $var, $value, $wrap = null );

	/**
	 * @param      $var
	 * @param      $value
	 * @param null $wrap
	 */
	public function add_percent_number( $var, $value, $wrap = null );

	/**
	 * @param      $var
	 * @param      $value
	 * @param null $wrap
	 */
	public function add_number( $var, $value, $wrap = null );

	/**
	 * @param      $var
	 * @param      $value
	 * @param null $wrap
	 */
	public function add_font( $var, $value, $wrap = null );

	/**
	 * @param      $var
	 * @param      $value
	 * @param null $wrap
	 */
	public function add_keyword( $var, $value, $wrap = null );

	/**
	 * Register less vars for paddings.
	 *
	 * @param array       $vars
	 * @param string      $value
	 * @param string|null $wrap
	 * @param string      $units
	 */
	public function add_paddings( $vars, $value, $units = 'px', $wrap = null );

	/**
	 * Register less var in pixels or percents.
	 *
	 * @param string      $var
	 * @param string      $value
	 * @param string|null $wrap
	 */
	public function add_pixel_or_percent_number( $var, $value, $wrap = null );
}