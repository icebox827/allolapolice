<?php
/**
 * Plugins list.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
	array(
		'name' => 'WooCommerce',
		'slug' => 'woocommerce',
		'required' => false
	),
	array(
		'name' => 'Contact Form 7',
		'slug' => 'contact-form-7',
		'required' => false
	),
	array(
		'name' => 'Recent Tweets Widget',
		'slug' => 'recent-tweets-widget',
		'required' => false
	),
);
