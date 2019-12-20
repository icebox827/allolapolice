<?php
/**
 * Team shortcodes VC bridge
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

vc_lean_map( 'dt_team', null, dirname( __FILE__ ) . '/mod-team-vc-bridge.php' );
vc_lean_map( 'dt_team_carousel', null, dirname( __FILE__ ) . '/mod-team-carousel-bridge.php' );
vc_lean_map( 'dt_team_masonry', null, dirname( __FILE__ ) . '/mod-team-masonry-bridge.php' );
