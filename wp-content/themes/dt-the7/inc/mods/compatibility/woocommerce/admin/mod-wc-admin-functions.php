<?php
/**
 * Admint functions for WC module.
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'dt_woocommerce_add_theme_options_page' ) ) :

	/**
	 * Add WooCommerce theme options page.
	 * 
	 * @param  array  $menu_items
	 * @return array
	 */
	function dt_woocommerce_add_theme_options_page( $menu_items = array() ) {
		$menu_slug = 'of-woocommerce-menu';
		if ( ! array_key_exists( $menu_slug, $menu_items ) ) {
			$menu_items[ $menu_slug ] = array(
				'menu_title'       => _x( 'WooCommerce', 'backend', 'the7mk2' ),
			);
		}
		return $menu_items;
	}

	add_filter( 'presscore_options_menu_config', 'dt_woocommerce_add_theme_options_page', 20 );

endif;

if ( ! function_exists( 'dt_woocommerce_add_theme_options' ) ) {

	function dt_woocommerce_add_theme_options( $files_list ) {
		$menu_slug = 'of-woocommerce-menu';
		if ( ! array_key_exists( $menu_slug, $files_list ) ) {
			$files_list[ $menu_slug ] = plugin_dir_path( __FILE__ ) . 'mod-wc-options.php';
		}
		return $files_list;
	}
	add_filter( 'presscore_options_files_list', 'dt_woocommerce_add_theme_options' );

}

if ( ! function_exists( 'dt_woocommerce_inject_theme_options' ) ) :

	function dt_woocommerce_inject_theme_options( $options ) {
		if ( array_key_exists( 'of-header-menu', $options ) ) {
			$options['of-woocommerce-mod-injected-header-options'] = plugin_dir_path( __FILE__ ) . 'wc-cart-micro-widget-options.php';
		}
		if ( array_key_exists( 'of-likebuttons-menu', $options ) ) {
			$options[] = plugin_dir_path( __FILE__ ) . 'wc-share-buttons-options.php';
		}
		return $options;
	}
	add_filter( 'presscore_options_files_to_load', 'dt_woocommerce_inject_theme_options' );

endif;

if ( ! function_exists( 'dt_woocommerce_setup_less_vars' ) ) :

	/**
	 * @param The7_Less_Vars_Manager_Interface $less_vars
	 */
	function dt_woocommerce_setup_less_vars( The7_Less_Vars_Manager_Interface $less_vars ) {
		$less_vars->add_hex_color(
			'product-counter-color',
			of_get_option( 'header-elements-woocommerce_cart-counter-color' )
		);

		$counter_color_vars = array( 'product-counter-bg', 'product-counter-bg-2' );
		switch ( of_get_option( 'header-elements-woocommerce_cart-counter-bg' ) ) {
			case 'color':
				$less_vars->add_rgba_color( $counter_color_vars, array( of_get_option( 'header-elements-woocommerce_cart-counter-bg-color' ), null ) );
				break;
			case 'gradient':
				$gradient_obj = the7_less_create_gradient_obj( of_get_option( 'header-elements-woocommerce_cart-counter-bg-gradient' ) );
				$less_vars->add_rgba_color( $counter_color_vars[0], $gradient_obj->get_color_stop( 1 )->get_color() );
				$less_vars->add_keyword( $counter_color_vars[1], $gradient_obj->with_angle( 'left' )->get_string() );
				break;
			case 'accent':
			default:
				list( $first_color, $gradient ) = the7_less_get_accent_colors( $less_vars );
				$less_vars->add_rgba_color( $counter_color_vars[0], $first_color );
				$less_vars->add_keyword( $counter_color_vars[1], $gradient->with_angle( 'left' )->get_string() );
		}
		unset( $gradient_obj, $first_color, $gradient, $counter_color_vars );

		$less_vars->add_hex_color(
			'sub-cart-color',
			of_get_option( 'header-elements-woocommerce_cart-sub_cart-font-color' )
		);

 		$less_vars->add_pixel_number(
     		'sub-cart-width',
     		of_get_option( 'header-elements-woocommerce_cart-sub_cart-bg-width' )
     	);
		$less_vars->add_rgba_color(
			'sub-cart-bg',
			of_get_option( 'header-elements-woocommerce_cart-sub_cart-bg-color' )
		);

		$less_vars->add_number(
			'product-img-width',
			of_get_option( 'woocommerce_product_img_width' )
 		);
 		$less_vars->add_pixel_number(
     		'switch-product-to-mobile',
     		of_get_option( 'woocommerce_product_switch' )
     	);
		$less_vars->add_number(
			'cart-total-width',
			of_get_option( 'woocommerce_cart_total_width' )
 		);
 		$less_vars->add_pixel_number(
     		'switch-cart-list-to-mobile',
     		of_get_option( 'woocommerce_cart_switch' )
     	);
		$less_vars->add_rgba_color(
			'wc-steps-bg',
			of_get_option( 'woocommerce_steps_bg_color' ),
			of_get_option( 'woocommerce_steps-bg_opacity' )
		);
		$less_vars->add_hex_color(
			'wc-steps-color',
			of_get_option( 'woocommerce_steps_color', '#000000' )
		);
		$less_vars->add_paddings( array(
			'wc-step-padding-top',
			'wc-step-padding-bottom',
		), of_get_option( 'woocommerce_cart_padding' ) );
     	$less_vars->add_number(
			'wc-list-img-width',
			of_get_option( 'woocommerce_shop_template_img_width' )
 		);
     	$less_vars->add_pixel_number(
			'wc-list-switch-to-mobile',
			of_get_option( 'woocommerce_list_switch' )
 		);

	}
	add_action( 'presscore_setup_less_vars', 'dt_woocommerce_setup_less_vars', 20 );

endif;

if ( ! function_exists( 'dt_woocommerce_add_product_metaboxes' ) ) :

	/**
	 * Add common meta boxes to product post type.
	 */
	function dt_woocommerce_add_product_metaboxes( $pages ) {
		$pages[] = 'product';
		return $pages;
	}

	add_filter( 'presscore_pages_with_basic_meta_boxes', 'dt_woocommerce_add_product_metaboxes' );

endif;

if ( ! function_exists( 'dt_woocommerce_add_cart_micro_widget_filter' ) ) {

	/**
	 * This filter add cart micro widget to header options.
	 *
	 * @since 5.5.0
	 *
	 * @param array $elements
	 *
	 * @return array
	 */
	function dt_woocommerce_add_cart_micro_widget_filter( $elements = array() ) {
		$elements['cart'] = array( 'title' => _x( 'Cart', 'theme-options', 'the7mk2' ), 'class' => '' );

		return $elements;
	}

	add_filter( 'header_layout_elements', 'dt_woocommerce_add_cart_micro_widget_filter' );
}

/**
 * Add sidebar columns to products on manage_edit page.
 */
add_filter( 'manage_edit-product_columns', 'presscore_admin_add_sidebars_columns' );

/**
 * Add shortcodes.
 */
add_action( 'init', array( 'DT_WC_Shortcodes', 'init' ) );