<?php
/*
Plugin Name: Meta Box
Plugin URI: http://www.deluxeblogtips.com/meta-box
Description: Create meta box for editing pages in WordPress. Compatible with custom post types since WP 3.0
Version: 4.3.3
Author: Rilwis
Author URI: http://www.deluxeblogtips.com
License: GPL2+
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Script version, used to add version for scripts and styles
define( 'THE7_RWMB_VER', '4.3.3.1' );

// Define plugin URLs, for fast enqueuing scripts and styles
if ( ! defined( 'THE7_RWMB_URL' ) )
	define( 'THE7_RWMB_URL', plugin_dir_url( __FILE__ ) );
define( 'THE7_RWMB_JS_URL', trailingslashit( THE7_RWMB_URL . 'js' ) );
define( 'THE7_RWMB_CSS_URL', trailingslashit( THE7_RWMB_URL . 'css' ) );

// Plugin paths, for including files
if ( ! defined( 'THE7_RWMB_DIR' ) )
	define( 'THE7_RWMB_DIR', plugin_dir_path( __FILE__ ) );
define( 'THE7_RWMB_INC_DIR', trailingslashit( THE7_RWMB_DIR . 'inc' ) );
define( 'THE7_RWMB_FIELDS_DIR', trailingslashit( THE7_RWMB_INC_DIR . 'fields' ) );
define( 'THE7_RWMB_CLASSES_DIR', trailingslashit( THE7_RWMB_INC_DIR . 'classes' ) );

// Optimize code for loading plugin files ONLY on admin side
// @see http://www.deluxeblogtips.com/?p=345

// Helper function to retrieve meta value
require_once THE7_RWMB_INC_DIR . 'helpers.php';

if ( is_admin() )
{
	// require_once THE7_RWMB_INC_DIR . 'common.php';

	// Field classes
	foreach ( glob( THE7_RWMB_FIELDS_DIR . '*.php' ) as $file )
	{
		require_once $file;
	}

	// Main file
	require_once THE7_RWMB_CLASSES_DIR . 'meta-box.php';
}
