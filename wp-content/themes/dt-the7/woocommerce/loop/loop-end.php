<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.0
 */

defined( 'ABSPATH' ) || exit;

// Masonry container close.
echo '</div>';

if ( 'grid' === presscore_config()->get( 'layout' ) ) {
	echo '</div>';
}

// Fullwidth wrap close.
if ( presscore_config()->get( 'full_width' ) ) {
	echo '</div>';
}

do_action( 'presscore_after_loop' );
do_action( 'dt_wc_loop_end' );
