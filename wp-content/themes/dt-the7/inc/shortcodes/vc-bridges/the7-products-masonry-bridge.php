<?php

defined( 'ABSPATH' ) || exit;

return array(
	'weight' => -1,
	'name' => __( 'Products Masonry and Grid', 'the7mk2' ),
	'base' => 'dt_products_masonry',
	'class' => 'dt_vc_sc_products_masonry',
	'icon' => 'dt_vc_ico_products',
	'category' => __( 'by Dream-Theme', 'the7mk2' ),
	'params' => array(
		// General group.
		array(
			'heading' => __('Show:', 'the7mk2'),
			'param_name' => 'show_products',
			'type' => 'dropdown',
			'std' => 'all_products',
			'value' => array(
				'All products' => 'all_products',
				'Sale products' => 'sale_products',
				'Featured products' => 'featured_products',
				'Top rated products' => 'top_products',
				'Best selling products' => 'best_selling_products',
				'Products from categories' => 'categories_products',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose product categories', 'the7mk2' ),
			'param_name' => 'category_ids',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
				// In UI show results except selected. NB! You should manually check values in backend
			),
			'save_always' => true,
			'description' => __( 'Leave empty to show products from all categories. Input product category name to see suggestions.', 'the7mk2' ),
			"dependency" => Array("element" => "show_products", "value" => array("categories_products"))
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose products', 'the7mk2' ),
			'param_name' => 'ids',
			'settings' => array(
				'multiple' => true,
				'unique_values' => true,
				'min_length' => 0,
				// In UI show results except selected. NB! You should manually check values in backend
			),
			'save_always' => true,
			'description' => __( 'Leave empty to show all products. Input product ID or product SKU or product title to see suggestions.', 'the7mk2' ),
			"dependency" => Array("element" => "show_products", "value" => array("all_products"))
		),
		array(
			'heading' => __('Order', 'the7mk2'),
			'param_name' => 'order',
			'type' => 'dropdown',
			'value' => array(
				'Descending' => 'desc',
				'Ascending' => 'asc',
			),
			'edit_field_class' => 'vc_col-xs-6 vc_column',
		),
		array(
			'heading' => __('Order by', 'the7mk2'),
			'param_name' => 'orderby',
			'type' => 'dropdown',
			'value' => array(
				'Date' => 'date',
				'ID' => 'id',
				'Author'=> 'author',
				'Menu Order'=> 'menu_order',
				'Title' => 'title',
			),
			'edit_field_class' => 'vc_col-xs-6 vc_column',
		),
		// - Layout Settings.
		array(
			'heading' => __( 'Layout Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Mode', 'the7mk2'),
			'param_name' => 'mode',
			'type' => 'dropdown',
			'value' => array(
				'Masonry' => 'masonry',
				'Grid' => 'grid',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Text & button position:', 'the7mk2'),
			'param_name' => 'layout',
			'type' => 'dropdown',
			'value' => array(
				'Text & button below image' => 'content_below_img',
				'Text below image, button on image' => 'btn_on_img',
				'Text below image, button on image hover' => 'btn_on_img_hover',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// - Columns & Responsiveness.
		array(
			'heading' => __( 'Columns & Responsiveness', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Responsiveness mode', 'the7mk2'),
			'param_name' => 'responsiveness',
			'type' => 'dropdown',
			'value' => array(
				'Browser width based' => 'browser_width_based',
				'Post width based' => 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Browser width based.
		array(
			'heading' => __('Number of columns', 'the7mk2'),
			'param_name' => 'bwb_columns',
			'type' => 'dt_responsive_columns',
			'value' => 'desktop:4|h_tablet:3|v_tablet:2|phone:1',
			'dependency'	=> array(
				'element'	=> 'responsiveness',
				'value'		=> 'browser_width_based',
			),
		),
		// -- Post width based.
		array(
			'heading' => __('Column minimum width', 'the7mk2'),
			'param_name' => 'pwb_column_min_width',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'responsiveness',
				'value'		=> 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(

			'heading' => __('Desired columns number', 'the7mk2'),
			'param_name' => 'pwb_columns',
			'type' => 'dt_number',
			'value' => '',
			'units' => '',
			'max' => 12,
			'description' => __('Affects only masonry layout', 'the7mk2'),
			"dependency" => array("element" => "responsiveness", "value" => 'post_width_based'),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Gap between columns', 'the7mk2'),
			'param_name' => 'gap_between_posts',
			'type' => 'dt_number',
			'value' => '15px',
			'units' => 'px',
			'description' => __('Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)', 'the7mk2'),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// - Pagination.
		array(
			'heading' => __( 'Pagination', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Pagination mode', 'the7mk2'),
			'param_name' => 'loading_mode',
			'type' => 'dropdown',
			'std' => 'disabled',
			'value' => array(
				'Disabled' => 'disabled',
				'Standard' => 'standard',
				'JavaScript pages' => 'js_pagination',
				'"Load more" button' => 'js_more',
				'Infinite scroll' => 'js_lazy_loading',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Disabled.
		array(
			'heading' => __('Total number of products ', 'the7mk2'),
			'param_name' => 'dis_posts_total',
			'type' => 'dt_number',
			'value' => '12',
			'save_always' => true, // Allow to use different defaults in interface and shortcode.
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'disabled',
			),
		),
		// -- Standard.
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'st_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __('Show all pages in paginator', 'the7mk2'),
			'param_name' => 'st_show_all_pages',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'st_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
		),
		// -- JavaScript pages.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsp_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsp_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __('Show all pages in paginator', 'the7mk2'),
			'param_name' => 'jsp_show_all_pages',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'jsp_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
		),
		// -- js Load more.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsm_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsm_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'jsm_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
		),
		// -- js Infinite scroll.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsl_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsl_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to use number from wp settings.', 'the7mk2'),
		),
		array(
			'heading' => __( 'Categorization', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Show categories filter', 'the7mk2'),
			'param_name' => 'show_categories_filter',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'description' => __( 'You can set up categorization colors, font & style in Theme Options >> Post Types >> General.', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Gap below categorization', 'the7mk2' ),
			'param_name' => 'gap_below_category_filter',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'description' => __('Leave empty to use default gap', 'the7mk2'),
		),
		array(
			'heading' => __( 'Categorization & pagination colors', 'the7mk2' ),
			'param_name' => 'dt_title_pagination_colors',
			'type' => 'dt_title',
		),
		array(
			'heading' => __('Font color', 'the7mk2'),
			'param_name' => 'navigation_font_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use headings color.', 'the7mk2' ),
		),
		array(
			'heading' => __('Accent color', 'the7mk2'),
			'param_name' => 'navigation_accent_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use accent color.', 'the7mk2' ),
		),
		// PRODUCT group.
		// - Post Title.
		array(
			'heading' => __( 'Text Colors', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Product', 'the7mk2' ),
		),
		array(
			'heading'		=> __('Product titles & price', 'the7mk2'),
			'param_name'	=> 'custom_title_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use headings color.', 'the7mk2' ),
			'group' => __( 'Product', 'the7mk2' ),
		),
		// - Text.
		array(
			'heading'		=> __('Old price for sale products', 'the7mk2'),
			'param_name'	=> 'custom_price_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use secondary text color.', 'the7mk2' ),
			'group' => __( 'Product', 'the7mk2' ),
		),
		array(
			'heading' => __('Product rating', 'the7mk2'),
			'param_name' => 'product_rating',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Product', 'the7mk2' ),
		),
		array(
			'heading' => __('Product short description', 'the7mk2'),
			'param_name' => 'product_descr',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Product', 'the7mk2' ),
		),
		array(
			'heading'		=> __('Product description', 'the7mk2'),
			'param_name'	=> 'custom_content_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use primary text color.', 'the7mk2' ),
			'group' => __( 'Product', 'the7mk2' ),
			'dependency'	=> array(
				'element'	=> 'product_descr',
				'value'		=> 'y',
			),
		),
	),
);
