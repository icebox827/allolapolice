<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Print "Add to wishlist" button if plugins is activated.
 */
function the7_ti_wishlist_button() {
	if ( ! defined( 'TINVWL_FVERSION' ) ) {
		return;
	}

	echo do_shortcode( '[ti_wishlists_addtowishlist loop=yes]' );
}
