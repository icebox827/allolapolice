<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Assets.
 */
add_action( 'wp_enqueue_scripts', 'dt_woocommerce_enqueue_scripts', 9 );

/**
 * Main content.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action( 'woocommerce_before_main_content', 'dt_woocommerce_before_main_content', 10 );
add_action( 'woocommerce_after_main_content', 'dt_woocommerce_after_main_content', 10 );
add_action( 'presscore_before_main_container', 'dt_woocommerce_cart_progress', 17 );

add_filter( 'body_class', 'dt_woocommerce_body_class' );
add_filter( 'presscore_hide_share_buttons', 'dt_woocommerce_hide_share_on_plugin_pages' );
add_filter( 'presscore_before_post_masonry-filter_taxonomy', 'dt_woocommerce_proper_taxonomy_for_masonry_wrap_classes', 10, 2 );

/**
 * Loop.
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_shop_loop_item_title', 'dt_woocommerce_template_loop_product_title', 10 );
add_action('woocommerce_shop_loop_item_desc','dt_woocommerce_template_loop_product_short_desc', 15);

add_action( 'dt_wc_loop_start', 'dt_woocommerce_add_masonry_container_filters' );
add_action( 'dt_wc_loop_start', 'presscore_wc_add_masonry_lazy_load_attrs' );
add_action( 'dt_wc_loop_start', 'dt_woocommerce_product_info_controller', 20 );
add_action( 'dt_wc_loop_start', 'dt_woocommerce_set_product_cart_button_position', 40 );

add_action( 'dt_wc_loop_end', 'dt_woocommerce_remove_masonry_container_filters' );
add_action( 'dt_wc_loop_end', 'presscore_wc_remove_masonry_lazy_load_attrs' );

// change products add to cart text
add_filter( 'woocommerce_product_add_to_cart_text', 'dt_woocommerce_filter_product_add_to_cart_text', 10, 2 );
add_filter( 'woocommerce_get_script_data', 'dt_woocommerce_filter_frontend_scripts_data', 10, 2 );

/**
 * Related products.
 */
add_filter( 'woocommerce_output_related_products_args', 'dt_woocommerce_related_products_args' );

/**
 * Subcategory shortcode.
 */
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
add_action( 'woocommerce_shop_loop_subcategory_title', 'dt_woocommerce_template_loop_category_title', 10 );

/**
 * Archives.
 */
add_action( 'woocommerce_archive_description', 'dt_woocommerce_add_shortcodes_inline_css_fix', 5 );

/**
 * Search.
 */
add_action( 'pre_get_posts', 'dt_woocommerce_exclude_out_of_stock_products_from_search' );

/**
 * Single product.
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

add_action( 'woocommerce_before_single_product_summary', 'dt_woocommerce_hide_related_products' );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'dt_woocommerce_share_buttons_action', 60 );

add_filter( 'woocommerce_upsell_display_args', 'dt_wc_upsell_display_args_filter' );

/**
 * Search.
 */
add_action( 'presscore_archive_post_content-product', 'dt_woocommerce_add_product_template_to_search', 10 );
add_filter( 'presscore_masonry_container_class', 'dt_woocommerce_add_classes_to_the_search_page_wrapper' );

/**
 * Change paypal icon.
 */
add_filter( 'woocommerce_paypal_icon', 'dt_woocommerce_change_paypal_icon' );

/**
 * Cart.
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart_form', 'woocommerce_cross_sell_display', 1 );
add_filter( 'woocommerce_cross_sells_columns', 'the7_woocommerce_cross_sells_columns' );
add_filter( 'woocommerce_cross_sells_total', 'the7_woocommerce_cross_sells_total' );

/**
 * Notices.
 */
if ( function_exists( 'wc_print_notices' ) && ! is_admin() ) {
	add_action( 'presscore_before_loop', 'wc_print_notices', 10 );
}
