<?php
/**
 * The7 theme.
 *
 * @since   1.0.0
 *
 * @package The7
 */


defined( 'ABSPATH' ) || exit;

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 *
 * @since 1.0.0
 */
require trailingslashit( get_template_directory() ) . 'inc/init.php';
