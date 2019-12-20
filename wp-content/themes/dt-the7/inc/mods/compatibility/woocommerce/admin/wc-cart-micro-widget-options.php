<?php
/**
 * Options to inject in header.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$new_options = array();

$new_options[] = array(
	'name'  => _x( 'WooCommerce shopping cart', 'theme-options', 'the7mk2' ),
	'id'    => 'microwidgets-cart-block',
	'class' => 'block-disabled',
	'type'  => 'block',
);

presscore_options_apply_template( $new_options, 'header-element-mobile-layout', 'header-elements-woocommerce_cart' );

$new_options['header-elements-woocommerce_cart-caption'] = array(
	'name'     => _x( 'Caption', 'theme-options', 'the7mk2' ),
	'id'       => 'header-elements-woocommerce_cart-caption',
	'type'     => 'text',
	'std'      => '',
	'sanitize' => 'textarea',
);

$new_options['header-elements-woocommerce_cart-icon'] = array(
	'name'    => _x( 'Graphic icon', 'theme-options', 'the7mk2' ),
	'id'      => 'header-elements-woocommerce_cart-icon',
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'custom',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'custom'   => _x( 'Enabled', 'theme-options', 'the7mk2' ),
	),
);

$new_options['header-elements-woocommerce_cart-custom-icon'] = array(
	'name'          => _x( 'Select icon', 'theme-options', 'the7mk2' ),
	'id'            => 'header-elements-woocommerce_cart-custom-icon',
	'type'          => 'icons_picker',
	'std'           => 'icomoon-the7-font-the7-cart-04',
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
	'dependency'    => array(
		'field'    => 'header-elements-woocommerce_cart-icon',
		'operator' => '==',
		'value'    => 'custom',
	),
);

$new_options[] = array( 'type' => 'divider' );

$new_options['header-elements-woocommerce_cart-show_sub_cart'] = array(
	'id'   => 'header-elements-woocommerce_cart-show_sub_cart',
	'name' => _x( 'Show drop down cart', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => '1',
);
$new_options['header-elements-woocommerce_cart-sub_cart-bg-width'] = array(
	'id'       => 'header-elements-woocommerce_cart-sub_cart-bg-width',
	'name'     => _x( 'Background width', 'theme-options', 'the7mk2' ),
	'type'     => 'text',
	'std'      => '240',
	'class'    => 'mini',
	'sanitize' => 'dimensions',
	'dependency' => array(
		'field'    => 'header-elements-woocommerce_cart-show_sub_cart',
		'operator' => '==',
		'value'    => '1',
	),
);
$new_options['header-elements-woocommerce_cart-sub_cart-bg-color'] = array(
	'id'   => 'header-elements-woocommerce_cart-sub_cart-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(255,255,255,0.3)',
	'dependency' => array(
		'field'    => 'header-elements-woocommerce_cart-show_sub_cart',
		'operator' => '==',
		'value'    => '1',
	),
);
$new_options['header-elements-woocommerce_cart-sub_cart-font-color'] = array(
	'id'   => 'header-elements-woocommerce_cart-sub_cart-font-color',
	'name' => _x( 'Text color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#000',
	'dependency' => array(
		'field'    => 'header-elements-woocommerce_cart-show_sub_cart',
		'operator' => '==',
		'value'    => '1',
	),
);


$new_options[] = array( 'type' => 'divider' );

$new_options['header-elements-woocommerce_cart-show_subtotal'] = array(
	'id'   => 'header-elements-woocommerce_cart-show_subtotal',
	'name' => _x( 'Show cart subtotal', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => '0',
);

$new_options[] = array( 'type' => 'divider' );

$new_options['header-elements-woocommerce_cart-show_counter'] = array(
	'id'        => 'header-elements-woocommerce_cart-show_counter',
	'name'      => _x( 'Show products counter', 'theme-options', 'the7mk2' ),
	'type'      => 'radio',
	'std'       => 'allways',
	'show_hide' => array( 'if_not_empty' => true, 'allways' => true ),
	'options'   => array(
		'never'        => _x( 'Never', 'theme-options', 'the7mk2' ),
		'if_not_empty' => _x( 'If not empty', 'theme-options', 'the7mk2' ),
		'allways'      => _x( 'Allways', 'theme-options', 'the7mk2' ),
	),
);

$new_options[] = array( 'type' => 'js_hide_begin' );

$new_options['header-elements-woocommerce_cart-counter-style'] = array(
	'id'      => 'header-elements-woocommerce_cart-counter-style',
	'name'    => _x( 'Products counter style', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'round',
	'options' => array(
		'round'       => _x( 'Round', 'theme-options', 'the7mk2' ),
		'rectangular' => _x( 'Rectangular', 'theme-options', 'the7mk2' ),
	),
);

$new_options['header-elements-woocommerce_cart-counter-color'] = array(
	'id'   => 'header-elements-woocommerce_cart-counter-color',
	'name' => _x( 'Products counter font color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#ffffff',
);

$new_options['header-elements-woocommerce_cart-counter-bg'] = array(
	'id'      => 'header-elements-woocommerce_cart-counter-bg',
	'name'    => _x( 'Products counter background', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$new_options['header-elements-woocommerce_cart-counter-bg-color'] = array(
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'id'         => 'header-elements-woocommerce_cart-counter-bg-color',
	'std'        => '#000000',
	'dependency' => array(
		'field'    => 'header-elements-woocommerce_cart-counter-bg',
		'operator' => '==',
		'value'    => 'color',
	),
);

$new_options['header-elements-woocommerce_cart-counter-bg-gradient'] = array(
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'id'          => 'header-elements-woocommerce_cart-counter-bg-gradient',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg', // to right
	'dependency'  => array(
		'field'    => 'header-elements-woocommerce_cart-counter-bg',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$new_options[] = array( 'type' => 'js_hide_end' );

// add new options
if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'header-before-elements-placeholder' );
}

// cleanup
unset( $new_options );
