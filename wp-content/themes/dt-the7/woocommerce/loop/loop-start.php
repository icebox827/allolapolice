<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'dt_wc_loop_start' );
do_action( 'presscore_before_loop' );

// Responsiveness mode: Browser width based data atts.
$data_atts             = array();
$wp_col_responsiveness = of_get_option( 'woocommerce_shop_template_bwb_columns' );
if ( $wp_col_responsiveness ) {
	$columns = array(
		'desktop'  => 'desktop',
		'v_tablet' => 'v-tablet',
		'h_tablet' => 'h-tablet',
		'phone'    => 'phone',
	);
	foreach ( $columns as $column => $data_att ) {
		$val         = ( isset( $wp_col_responsiveness[ $column ] ) ? absint( $wp_col_responsiveness[ $column ] ) : '' );
		$data_atts[] = 'data-' . $data_att . '-columns-num="' . esc_attr( $val ) . '"';
	}
}

// Fullwidth wrap open.
if ( presscore_config()->get( 'full_width' ) ) {
	echo '<div class="full-width-wrap">';
}

$loop_layout = presscore_config()->get( 'layout' );
if ( 'list' === $loop_layout ) {
	$classes = array(
		'wc-layout-list',
		'dt-products',
		'products',
	);

	if ( of_get_option( 'woocommerce_hover_image' ) ) {
		$classes[] = 'wc-img-hover';
	}

	if ( ! of_get_option( 'woocommerce_show_list_desc' ) ) {
		$classes[] = 'hide-description';
	}

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	printf( '<div class="%s">', implode( ' ', $classes ) );
} elseif ( 'grid' === $loop_layout ) {
	$classes   = array_diff( presscore_masonry_container_classes_array(), array( 'iso-grid' ) );
	$classes[] = 'dt-css-grid-wrap';
	$classes[] = 'woo-hover';
	$classes[] = 'wc-grid';
	$classes[] = 'dt-products';
	$classes[] = 'products';

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	printf( '<div class="%s" %s><div class="dt-css-grid">', esc_attr( implode( ' ', $classes ) ), presscore_masonry_container_data_atts( $data_atts ) );
} else {
	$classes = array( 'wf-container', 'dt-products ', 'woo-hover', 'products' );
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<div ' . presscore_masonry_container_class( $classes ) . presscore_masonry_container_data_atts( $data_atts ) . '>';
}
