<?php
/**
 * Testimonials shortcodes VC bridge
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

vc_lean_map( 'dt_testimonials', null, dirname( __FILE__ ) . '/mod-testimonials-vc-deprecated-bridge.php' );
vc_lean_map( 'dt_testimonials_carousel', null, dirname( __FILE__ ) . '/mod-testimonials-carousel-bridge.php' );
vc_lean_map( 'dt_testimonials_masonry', null, dirname( __FILE__ ) . '/mod-testimonials-masonry-bridge.php' );
