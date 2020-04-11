<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return current year.
 *
 * @return false|string
 */
function the7_year_shortcode() {
	return date( 'Y' );
}

add_shortcode( 'dt_year', 'the7_year_shortcode' );
