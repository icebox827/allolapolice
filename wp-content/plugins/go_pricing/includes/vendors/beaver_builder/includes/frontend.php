<?php
/**
 * Go Pricing Module for Beaver Builder
 * Frontend Output HTML
 */
$setting = isset( $settings->{'go_pricing--id'} ) ? $settings->{'go_pricing--id'} : '';
$setting_values = explode(
	'--',
	$setting,
	2
);

echo do_shortcode(
	sprintf(
		'[go_pricing id="%s"]',
		isset( $setting_values[1] ) ? $setting_values[1] : ''
	)
);