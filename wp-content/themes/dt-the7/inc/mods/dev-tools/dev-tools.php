<?php
/**
 *
 * @package the7
 * @since   5.5.5
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/main-module.class.php';

function The7_DevTools() {
	static $instance = null;
	if ( null === $instance ) {
		$instance = new The7_DevToolMainModule();
	}
	return $instance;
}

$devToolModule = The7_DevTools();
$devToolModule->execute();
