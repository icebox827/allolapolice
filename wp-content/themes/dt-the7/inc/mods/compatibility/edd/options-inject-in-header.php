<?php
/**
 * Options to inject in header.
 *
 * @since 6.6.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$new_options = array();

$new_options[] = array(
	'name'  => _x( 'EDD shopping cart', 'theme-options', 'the7mk2' ),
	'id'    => 'microwidgets-edd_cart-block',
	'class' => 'block-disabled',
	'type'  => 'block',
);

presscore_options_apply_template( $new_options, 'basic-header-element', 'header-elements-edd_cart', array(
	'caption' => array(
		'divider' => false,
	),
	'custom-icon' => array(
		'std' => 'the7-mw-icon-cart',
	),
) );

$new_options[] = array( 'type' => 'divider' );

$new_options['header-elements-edd_cart-show_sub_cart'] = array(
	'id'   => 'header-elements-edd_cart-show_sub_cart',
	'name' => _x( 'Show drop down cart', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => '1',
);
$new_options['header-elements-edd_cart-sub_cart-bg-width'] = array(
	'id'       => 'header-elements-edd_cart-sub_cart-bg-width',
	'name'     => _x( 'Background width', 'theme-options', 'the7mk2' ),
	'type'     => 'text',
	'std'      => '240',
	'class'    => 'mini',
	'sanitize' => 'dimensions',
	'dependency' => array(
		'field'    => 'header-elements-edd_cart-show_sub_cart',
		'operator' => '==',
		'value'    => '1',
	),
);
$new_options['header-elements-edd_cart-sub_cart-bg-color'] = array(
	'id'   => 'header-elements-edd_cart-sub_cart-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => 'rgba(255,255,255,0.3)',
	'dependency' => array(
		'field'    => 'header-elements-edd_cart-show_sub_cart',
		'operator' => '==',
		'value'    => '1',
	),
);
$new_options['header-elements-edd_cart-sub_cart-font-color'] = array(
	'id'   => 'header-elements-edd_cart-sub_cart-font-color',
	'name' => _x( 'Text color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#000',
);


$new_options[] = array( 'type' => 'divider' );

$new_options['header-elements-edd_cart-show_subtotal'] = array(
	'id'   => 'header-elements-edd_cart-show_subtotal',
	'name' => _x( 'Show cart subtotal', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => '0',
);

$new_options[] = array( 'type' => 'divider' );

$new_options['header-elements-edd_cart-show_counter'] = array(
	'id'      => 'header-elements-edd_cart-show_counter',
	'name'    => _x( 'Show products counter', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'std'     => 'allways',
	'options' => array(
		'never'        => _x( 'Never', 'theme-options', 'the7mk2' ),
		'if_not_empty' => _x( 'If not empty', 'theme-options', 'the7mk2' ),
		'allways'      => _x( 'Allways', 'theme-options', 'the7mk2' ),
	),
);

$new_options['header-elements-edd_cart-counter-style'] = array(
	'id'         => 'header-elements-edd_cart-counter-style',
	'name'       => _x( 'Products counter style', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'std'        => 'round',
	'options'    => array(
		'round'       => _x( 'Round', 'theme-options', 'the7mk2' ),
		'rectangular' => _x( 'Rectangular', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'header-elements-edd_cart-show_counter',
		'operator' => 'IN',
		'value'    => array( 'if_not_empty', 'allways' ),
	),
);

$new_options['header-elements-edd_cart-counter-color'] = array(
	'id'         => 'header-elements-edd_cart-counter-color',
	'name'       => _x( 'Products counter font color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-elements-edd_cart-show_counter',
		'operator' => 'IN',
		'value'    => array( 'if_not_empty', 'allways' ),
	),
);

$new_options['header-elements-edd_cart-counter-bg'] = array(
	'id'         => 'header-elements-edd_cart-counter-bg',
	'name'       => _x( 'Products counter background', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'class'      => 'small',
	'std'        => 'accent',
	'options'    => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'header-elements-edd_cart-show_counter',
		'operator' => 'IN',
		'value'    => array( 'if_not_empty', 'allways' ),
	),
);

$new_options['header-elements-edd_cart-counter-bg-color'] = array(
	'id'         => 'header-elements-edd_cart-counter-bg-color',
	'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
	'type'       => 'color',
	'std'        => '#000000',
	'dependency' => array(
		array(
			'field'    => 'header-elements-edd_cart-show_counter',
			'operator' => 'IN',
			'value'    => array( 'if_not_empty', 'allways' ),
		),
		array(
			'field'    => 'header-elements-edd_cart-counter-bg',
			'operator' => '==',
			'value'    => 'color',
		),
	),
);

$new_options['header-elements-edd_cart-counter-bg-gradient'] = array(
	'id'          => 'header-elements-edd_cart-counter-bg-gradient',
	'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'        => 'gradient_picker',
	'std'         => '90deg|#ffffff 30%|#000000 100%',
	'fixed_angle' => '90deg', // to right
	'dependency'  => array(
		array(
			'field'    => 'header-elements-edd_cart-show_counter',
			'operator' => 'IN',
			'value'    => array( 'if_not_empty', 'allways' ),
		),
		array(
			'field'    => 'header-elements-edd_cart-counter-bg',
			'operator' => '==',
			'value'    => 'gradient',
		),
	),
);
$new_options['header-elements-woocommerce_edd_cart-counter-size'] = array(
	'name'        => _x( 'Products counter size', 'theme-options', 'the7mk2' ),
	'id'   => 'header-elements-woocommerce_edd_cart-counter-size',
	'type' => 'slider',
	'std'  => 9,
	'options' => array( 'min' => 9, 'max' => 120 ),
);

if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'header-before-elements-placeholder' );
}

unset( $new_options );
