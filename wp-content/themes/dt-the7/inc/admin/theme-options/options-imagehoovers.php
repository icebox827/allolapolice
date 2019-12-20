<?php
/**
 * Image Hovers.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Heading definition.
 */
$options[] = array(
	'name' => _x( 'Images Styling &amp; Hovers', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'images-styling-hovers',
);

/**
 * Styling.
 */
$options[] = array( 'name' => _x( 'Styling', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['image_hover-style'] = array(
	'name'    => _x( 'Image &amp; hover effects', 'theme-options', 'the7mk2' ),
	'desc'    => _x( 'May not have effect on some portfolio, photo albums and shortcodes image hovers.', 'theme-options', 'the7mk2' ),
	'id'      => 'image_hover-style',
	'std'     => 'none',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'none'       => array(
			'title' => _x( 'None', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/image_hover-style-none.gif',
		),
		'grayscale'  => array(
			'title' => _x( 'Grayscale', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/image_hover-style-grayscale.gif',
		),
		'gray_color' => array(
			'title' => _x( 'Grayscale with color hovers', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/image_hover-style-grayscale-with-color-hover.gif',
		),
	),
);

/**
 * Hover color.
 */
$options[] = array( 'name' => _x( 'Default image hovers', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['image_hover-color_mode'] = array(
	'name'    => _x( 'Hovers background color', 'theme-options', 'the7mk2' ),
	'id'      => 'image_hover-color_mode',
	'std'     => 'accent',
	'type'    => 'radio',
	'class'   => 'small',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['image_hover-color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'image_hover-color',
	'std'        => '#ffffff',
	'type'       => 'alpha_color',
	'dependency' => array(
		'field'    => 'image_hover-color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['image_hover-color_gradient'] = array(
	'name'       => '&nbsp;',
	'type'       => 'gradient_picker',
	'id'         => 'image_hover-color_gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'image_hover-color_mode',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['image_hover-opacity'] = array(
	'name'       => _x( 'Hovers background opacity', 'theme-options', 'the7mk2' ),
	'id'         => 'image_hover-opacity',
	'std'        => 30,
	'type'       => 'slider',
	'dependency' => array(
		'field'    => 'image_hover-color_mode',
		'operator' => '==',
		'value'    => 'accent',
	),
);

/**
 * Hover opacity.
 */
$options[] = array(
	'name' => _x( 'Default portfolio &amp; photo albums hovers', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);


$options['image_hover-project_rollover_color_mode'] = array(
	'name'    => _x( 'Hovers background color', 'theme-options', 'the7mk2' ),
	'id'      => 'image_hover-project_rollover_color_mode',
	'std'     => 'accent',
	'type'    => 'radio',
	'class'   => 'small',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['image_hover-project_rollover_color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'image_hover-project_rollover_color',
	'std'        => '#ffffff',
	'type'       => 'alpha_color',
	'dependency' => array(
		'field'    => 'image_hover-project_rollover_color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['image_hover-project_rollover_color_gradient'] = array(
	'name'       => '&nbsp;',
	'type'       => 'gradient_picker',
	'id'         => 'image_hover-project_rollover_color_gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'image_hover-project_rollover_color_mode',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['image_hover-project_rollover_opacity'] = array(
	'name'       => _x( 'Hovers background opacity', 'theme-options', 'the7mk2' ),
	'id'         => 'image_hover-project_rollover_opacity',
	'std'        => 70,
	'type'       => 'slider',
	'dependency' => array(
		'field'    => 'image_hover-project_rollover_color_mode',
		'operator' => '==',
		'value'    => 'accent',
	),
);
