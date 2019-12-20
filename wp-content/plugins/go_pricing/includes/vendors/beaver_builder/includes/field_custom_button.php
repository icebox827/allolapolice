<?php
/**
 * Go Pricing Module for Beaver Builder
 * Print Custom Field HTML
 */

$url_base = add_query_arg(
	array( 'page' => 'go-pricing', 'action' => 'edit', 'id' => '' ),
	admin_url( 'admin.php' )
);
$btn_text = esc_html__( 'Edit Pricing Table', 'go_pricing_textdomain' );

printf(
	'<a data-url-base="%1$s" href="#" title="%2$s" target="_blank" class="go-pricing_btn-edit-table">%3$s</a>',
	$url_base,
	esc_attr( $btn_text ),
	$btn_text
);
