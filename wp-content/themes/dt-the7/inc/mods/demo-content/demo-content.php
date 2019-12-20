<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://dream-theme.com
 * @since             1.0.1
 * @package           DT_Dummy
 *
 * @wordpress-plugin
 * Plugin Name:       The7 Demo Content
 * Description:       Demo content for the The7 theme.
 * Version:           2.0.0.b0501171010
 * Author:            Dream-Theme
 * Author URI:        http://dream-theme.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dt-dummy
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Helpers.
 */
require_once dirname( __FILE__ ) . '/includes/helpers-api.php';

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once dirname( __FILE__ ) . '/includes/class-the7-demo-content.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function the7_demo_content() {
	static $instance = null;
	if ( null === $instance ) {
		$instance = new The7_Demo_Content();
	}

	return $instance;
}

the7_demo_content()->run();
