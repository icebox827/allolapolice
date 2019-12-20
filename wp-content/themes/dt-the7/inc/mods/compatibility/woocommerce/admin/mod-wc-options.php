<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options[] = array(
	'page_title' => _x( 'WooCommerce', 'theme-options', 'the7mk2' ),
	'menu_title' => _x( 'WooCommerce', 'theme-options', 'the7mk2' ),
	'menu_slug'  => 'of-woocommerce-menu',
	'type'       => 'page',
);

$options[] = array(
	'name' => _x( 'Product list', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'product-list',
);

$options[] = array( 'name' => _x( 'Layout', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['wc_view_mode'] = array(
	'name'      => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'id'        => 'wc_view_mode',
	'std'       => 'masonry_grid',
	'type'      => 'radio',
	'show_hide' => array(
		'masonry_grid' => array( 'isotope-block-settings', 'masonry_show_desc' ),
		'list'         => array( 'list-block-settings', 'list_show_desc' ),
		'view_mode'    => array(
			'isotope-block-settings',
			'list-block-settings',
			'default-block-settings',
			'masonry_show_desc',
			'list_show_desc',
		),
	),
	'options'   => array(
		'masonry_grid' => _x( 'Masonry/Grid', 'theme-options', 'the7mk2' ),
		'list'         => _x( 'List', 'theme-options', 'the7mk2' ),
		'view_mode'    => _x( 'Layout switcher', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'wc_view_mode default-block-settings' );

$options[] = array( 'type' => 'divider' );

$options['woocommerce_shop_template_layout_default'] = array(
	'name'    => _x( 'Default layout', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_shop_template_layout_default',
	'std'     => 'masonry_grid_default',
	'type'    => 'radio',
	'options' => array(
		'masonry_grid_default' => _x( 'Masonry/Grid', 'theme-options', 'the7mk2' ),
		'list_default'         => _x( 'List', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'js_hide_end' );

/**
 * Masonry & Grid.
 */
$options[] = array(
	'name'  => _x( 'Masonry & Grid', 'theme-options', 'the7mk2' ),
	'class' => 'wc_view_mode isotope-block-settings',
	'type'  => 'block',
);

$options['woocommerce_shop_template_isotope'] = array(
	'name'    => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_shop_template_isotope',
	'std'     => 'masonry',
	'type'    => 'radio',
	'options' => array(
		'masonry' => _x( 'Masonry', 'theme-options', 'the7mk2' ),
		'grid'    => _x( 'Grid', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_display_product_info'] = array(
	'name'    => _x( 'Text & button position', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_display_product_info',
	'std'     => 'wc_btn_on_hoover',
	'type'    => 'images',
	'options' => array(
		'under_image'      => array(
			'title' => _x( 'Text & button below image', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/woo-grid-01.gif',
		),
		'wc_btn_on_img'    => array(
			'title' => _x( 'Text below image, button on image', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/icon-image-always.gif',
		),
		'wc_btn_on_hoover' => array(
			'title' => _x( 'Text below image, button on image hover', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/icon-image-hover.gif',
		),
	),
);

$options['woocommerce_add_to_cart_icon'] = array(
	'name'       => _x( 'Add to cart icon', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_add_to_cart_icon',
	'default_icons' => array(
		'icomoon-the7-font-the7-cart-00',
		'icomoon-the7-font-the7-cart-001',
		'icomoon-the7-font-the7-cart-01',
		'icomoon-the7-font-the7-cart-002',
		'icomoon-the7-font-the7-cart-02',
		'icomoon-the7-font-the7-cart-021',
		'icomoon-the7-font-icon-cart-detailed',
		'icomoon-the7-font-the7-cart-04',
		'icomoon-the7-font-the7-cart-05',
		'icomoon-the7-font-the7-cart-051',
		'icomoon-the7-font-the7-cart-06',
		'icomoon-the7-font-the7-cart-07',
		'icomoon-the7-font-the7-cart-10',
		'icomoon-the7-font-the7-cart-11',
		'icomoon-the7-font-the7-cart-12',
		'icomoon-the7-font-the7-cart-13',
		'icomoon-the7-font-the7-cart-14',
		'icomoon-the7-font-the7-cart-15',
		
	),
	'std'        => 'icomoon-the7-font-the7-cart-04',
	'type'       => 'icons_picker',
	'dependency' => array(
		'field'    => 'woocommerce_display_product_info',
		'operator' => 'IN',
		'value'    => array( 'wc_btn_on_img', 'wc_btn_on_hoover' ),
	),
);

$options['woocommerce_details_icon'] = array(
	'name'       => _x( 'Details icon', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_details_icon',
	'default_icons' => array(
		'icomoon-the7-font-the7-more-00',
		'icomoon-the7-font-the7-more-01',
		'dt-icon-the7-menu-012',
		'dt-icon-the7-misc-006-2',
		'dt-icon-the7-menu-010',
		'dt-icon-the7-menu-004',
		'dt-icon-the7-menu-007',
	),
	'std'        => 'dt-icon-the7-menu-012',
	'type'       => 'icons_picker',
	'dependency' => array(
		'field'    => 'woocommerce_display_product_info',
		'operator' => 'IN',
		'value'    => array( 'wc_btn_on_img', 'wc_btn_on_hoover' ),
	),
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_shop_template_responsiveness'] = array(
	'name'    => _x( 'Responsiveness mode', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_shop_template_responsiveness',
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'post_width_based',
	'options' => array(
		'browser_width_based' => _x( 'Browser width based', 'theme-options', 'the7mk2' ),
		'post_width_based'    => _x( 'Post width based', 'theme-options', 'the7mk2' ),
	),
);

$options['woocommerce_shop_template_bwb_columns'] = array(
	'name'       => _x( 'Number of columns', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_shop_template_bwb_columns',
	'type'       => 'responsive_columns',
	'columns'    => array(
		'desktop'  => _x( 'Desktop', 'theme-options', 'the7mk2' ),
		'h_tablet' => _x( 'Horizontal Tablet', 'theme-options', 'the7mk2' ),
		'v_tablet' => _x( 'Vertical Tablet', 'theme-options', 'the7mk2' ),
		'phone'    => _x( 'Mobile Phone', 'theme-options', 'the7mk2' ),
	),
	'std'        => array(
		'desktop'  => 4,
		'h_tablet' => 3,
		'v_tablet' => 2,
		'phone'    => 1,
	),
	'dependency' => array(
		array(
			array(
				'field'    => 'woocommerce_shop_template_responsiveness',
				'operator' => '==',
				'value'    => 'browser_width_based',
			),
		),
	),
);

$options['woocommerce_shop_template_column_min_width'] = array(
	'name'       => _x( 'Column minimum width', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_shop_template_column_min_width',
	'std'        => '220px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		array(
			array(
				'field'    => 'woocommerce_shop_template_responsiveness',
				'operator' => '==',
				'value'    => 'post_width_based',
			),
		),
	),
);

$options['woocommerce_shop_template_columns'] = array(
	'name'       => _x( 'Desired columns number', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_shop_template_columns',
	'class'      => 'mini',
	'std'        => '5',
	'type'       => 'text',
	'sanitize'   => 'dimensions',
	'dependency' => array(
		array(
			array(
				'field'    => 'woocommerce_shop_template_responsiveness',
				'operator' => '==',
				'value'    => 'post_width_based',
			),
			array(
				'field'    => 'woocommerce_shop_template_isotope',
				'operator' => '==',
				'value'    => 'masonry',
			),
		),
	),
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_shop_template_gap'] = array(
	'name'  => _x( 'Gap between columns', 'theme-options', 'the7mk2' ),
	'desc'  => _x( 'For example: a value 10px will give you 20px gaps between posts', 'theme-options', 'the7mk2' ),
	'id'    => 'woocommerce_shop_template_gap',
	'std'   => '22px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_shop_template_loading_effect'] = array(
	'name'    => _x( 'Loading effect', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_shop_template_loading_effect',
	'std'     => 'none',
	'type'    => 'radio',
	'options' => array(
		'none'             => _x( 'None', 'backend metabox', 'the7mk2' ),
		'fade_in'          => _x( 'Fade in', 'backend metabox', 'the7mk2' ),
		'move_up'          => _x( 'Move up', 'backend metabox', 'the7mk2' ),
		'scale_up'         => _x( 'Scale up', 'backend metabox', 'the7mk2' ),
		'fall_perspective' => _x( 'Fall perspective', 'backend metabox', 'the7mk2' ),
		'fly'              => _x( 'Fly', 'backend metabox', 'the7mk2' ),
		'flip'             => _x( 'Flip', 'backend metabox', 'the7mk2' ),
		'helix'            => _x( 'Helix', 'backend metabox', 'the7mk2' ),
		'scale'            => _x( 'Scale', 'backend metabox', 'the7mk2' ),
	),
);

$options[] = array(
	'name'  => _x( 'List', 'theme-options', 'the7mk2' ),
	'class' => 'wc_view_mode list-block-settings',
	'type'  => 'block',
);

$options['woocommerce_shop_template_img_width'] = array(
	'name'  => _x( 'Image width', 'theme-options', 'the7mk2' ),
	'id'    => 'woocommerce_shop_template_img_width',
	'std'   => '30%',
	'type'  => 'number',
	'units' => 'px|%',
);

$options['woocommerce_list_switch'] = array(
	'name'  => _x( 'Switch to mobile layout after', 'theme-options', 'the7mk2' ),
	'id'    => 'woocommerce_list_switch',
	'std'   => '500px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'name' => _x( 'Appearance', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['woocommerce_hover_image'] = array(
	'name'    => _x( 'Change image on hover', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_hover_image',
	'std'     => 1,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_show_product_titles'] = array(
	'name'    => _x( 'Product titles', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_show_product_titles',
	'std'     => 1,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_show_product_price'] = array(
	'name'    => _x( 'Product price', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_show_product_price',
	'std'     => 1,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_show_product_rating'] = array(
	'name'    => _x( 'Product rating', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_show_product_rating',
	'std'     => 1,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_show_cart_icon'] = array(
	'name'    => _x( "'Add to cart' button", 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_show_cart_icon',
	'std'     => 1,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'wc_view_mode masonry_show_desc' );

$options[] = array( 'type' => 'divider' );

$options['woocommerce_show_masonry_desc'] = array(
	'name'    => _x( 'Product short description in masonry/grid layout', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_show_masonry_desc',
	'std'     => 1,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'wc_view_mode list_show_desc' );

$options[] = array( 'type' => 'divider' );

$options['woocommerce_show_list_desc'] = array(
	'name'    => _x( 'Product short description in list layout', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_show_list_desc',
	'std'     => 1,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options[] = array( 'type' => 'js_hide_end' );

$options[] = array(
	'name' => _x( 'Product page', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'product-page',
);

$options[] = array( 'name' => _x( 'Product settings', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['woocommerce_rel_products_max'] = array(
	'name'     => _x( 'Maximum number of related products', 'theme-options', 'the7mk2' ),
	'id'       => 'woocommerce_rel_products_max',
	'std'      => '3',
	'type'     => 'text',
	'class'    => 'mini',
	'sanitize' => 'slider',
);

$options['woocommerce-related_btn'] = array(
	'id'      => 'woocommerce-related_btn',
	'name'    => _x( "'Add to cart' button in related products", 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => '1',
	'options' => array(
		'1' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
		'0' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
	),
);

$options['woocommerce_product_img_width'] = array(
	'name'  => _x( 'Product image width', 'theme-options', 'the7mk2' ),
	'id'    => 'woocommerce_product_img_width',
	'std'   => '30%',
	'type'  => 'number',
	'units' => 'px|%',
);

$options['woocommerce_product_switch'] = array(
	'name'  => _x( 'Switch to one column layout after', 'theme-options', 'the7mk2' ),
	'id'    => 'woocommerce_product_switch',
	'std'   => '768px',
	'type'  => 'number',
	'units' => 'px',
);

$options['woocommerce-product_zoom'] = array(
	'id'      => 'woocommerce-product_zoom',
	'name'    => _x( 'Image zoom on hover', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => '1',
	'options' => array(
		'1' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
		'0' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
	),
);

$options[] = array(
	'name' => _x( 'Cart & Checkout', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'cart-and-checkout',
);

$options[] = array(
	'name' => _x( 'Cart settings', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['woocommerce_cart_total_width'] = array(
	'name'  => _x( 'Side column width', 'theme-options', 'the7mk2' ),
	'desc'  => _x( 'Use 100% to place side column below checkout content', 'theme-options', 'the7mk2' ),
	'id'    => 'woocommerce_cart_total_width',
	'std'   => '30%',
	'type'  => 'number',
	'units' => 'px|%',
);

$options['woocommerce_cart_switch'] = array(
	'name'  => _x( 'Switch to one column layout after', 'theme-options', 'the7mk2' ),
	'id'    => 'woocommerce_cart_switch',
	'std'   => '700px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'type' => 'divider' );

$options['woocommerce_show_steps'] = array(
	'name'    => _x( 'Checkout steps', 'theme-options', 'the7mk2' ),
	'id'      => 'woocommerce_show_steps',
	'std'     => 0,
	'type'    => 'radio',
	'options' => $en_dis_options,
);

$options['woocommerce_steps_bg_color'] = array(
	'name'       => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_steps_bg_color',
	'std'        => '#f8f8f9',
	'type'       => 'color',
	'dependency' => array(
		array(
			array(
				'field'    => 'woocommerce_show_steps',
				'operator' => '==',
				'value'    => '1',
			),
		),
	),
);

$options['woocommerce_steps-bg_opacity'] = array(
	'name'       => _x( 'Background opacity', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_steps-bg_opacity',
	'std'        => 100,
	'type'       => 'slider',
	'dependency' => array(
		array(
			array(
				'field'    => 'woocommerce_show_steps',
				'operator' => '==',
				'value'    => '1',
			),
		),
	),
);

$options['woocommerce_steps_color'] = array(
	'name'       => _x( 'Font color', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_steps_color',
	'std'        => '#3b3f4a',
	'type'       => 'color',
	'dependency' => array(
		array(
			array(
				'field'    => 'woocommerce_show_steps',
				'operator' => '==',
				'value'    => '1',
			),
		),
	),
);

$options['woocommerce_cart_padding'] = array(
	'name'       => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'id'         => 'woocommerce_cart_padding',
	'type'       => 'spacing',
	'std'        => '30px 30px',
	'units'      => 'px',
	'fields'     => array(
		_x( 'Top', 'theme-options', 'the7mk2' ),
		_x( 'Bottom', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		array(
			array(
				'field'    => 'woocommerce_show_steps',
				'operator' => '==',
				'value'    => '1',
			),
		),
	),
);
