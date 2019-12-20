<?php
/**
 * Bundled plugin content
 * @package the7
 * @since   5.1.5
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/includes/main-module.class.php';

function bundled_content() {
	static $instance = null;
	if ( null === $instance ) {
		$instance = new BundledContentMainModule();
	}

	return $instance;
}

$bundledContent = bundled_content();
$bundledContent->execute();

