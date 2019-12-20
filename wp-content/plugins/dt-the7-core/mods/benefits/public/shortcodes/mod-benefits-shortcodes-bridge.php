<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

vc_lean_map( 'dt_benefits_vc', null, dirname( __FILE__ ) . '/mod-benefits-vc-bridge.php' );
