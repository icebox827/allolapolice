<?php
/**
 * Portfolio shortcodes VC bridge.
 *
 * @package the7\Portfolio\Shortcodes
 * @since 3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

vc_lean_map( 'dt_portfolio_slider', null, dirname( __FILE__ ) . '/mod-portfolio-scroller-bridge.php' );
vc_lean_map( 'dt_portfolio', null, dirname( __FILE__ ) . '/mod-portfolio-old-masonry-bridge.php' );
vc_lean_map( 'dt_portfolio_jgrid', null, dirname( __FILE__ ) . '/mod-portfolio-justified-grid-bridge.php' );
vc_lean_map( 'dt_portfolio_masonry', null, dirname( __FILE__ ) . '/mod-portfolio-masonry-bridge.php' );
vc_lean_map( 'dt_portfolio_carousel', null, dirname( __FILE__ ) . '/mod-portfolio-carousel-bridge.php' );