<?php
/**
 * Albums shortcodes VC bridge
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

vc_lean_map( 'dt_albums_masonry', null, dirname( __FILE__ ) . '/mod-albums-masonry-bridge-new.php' );
vc_lean_map( 'dt_albums_jgrid', null, dirname( __FILE__ ) . '/mod-albums-justified-grid-bridge.php' );
vc_lean_map( 'dt_albums_carousel', null, dirname( __FILE__ ) . '/mod-albums-carousel-bridge.php' );
vc_lean_map( 'dt_gallery_photos_masonry', null, dirname( __FILE__ ) . '/mod-gallery-masonry-bridge.php' );
vc_lean_map( 'dt_photos_jgrid', null, dirname( __FILE__ ) . '/mod-albums-photo-justified-grid-bridge.php' );
vc_lean_map( 'dt_photos_carousel', null, dirname( __FILE__ ) . '/mod-photos-carousel-bridge.php' );


// Old shortcodes.
vc_lean_map( 'dt_albums', null, dirname( __FILE__ ) . '/mod-albums-masonry-bridge.php' );
vc_lean_map( 'dt_albums_scroller', null, dirname( __FILE__ ) . '/mod-albums-scroller-bridge.php' );
vc_lean_map( 'dt_photos_masonry', null, dirname( __FILE__ ) . '/mod-albums-photo-masonry-bridge.php' );
vc_lean_map( 'dt_small_photos', null, dirname( __FILE__ ) . '/mod-albums-photo-scroller-bridge.php' );

