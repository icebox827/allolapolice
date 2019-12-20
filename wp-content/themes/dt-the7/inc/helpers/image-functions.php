<?php

defined( 'ABSPATH' ) || exit;

/**
 * Return image proportion.
 *
 * @since 6.7.0
 *
 * @param string|int $width
 * @param string|int $height
 *
 * @return float|int
 */
function the7_get_image_proportion( $width, $height ) {
	$width  = max( (int) $width, 1 );
	$height = max( (int) $height, 1 );

	return $width / $height;
}
