<?php
/**
 * Buttons options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Heading definition.
 */
$options[] = array( 'name' => _x( 'Buttons', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'buttons' );

/**
 * Buttons style.
 */
$options[] = array( 'name' => _x( 'Buttons decoration', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['buttons-style'] = array(
	'name'    => _x( 'Choose decoration', 'theme-options', 'the7mk2' ),
	'id'      => 'buttons-style',
	'std'     => 'flat',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'flat'   => array(
			'title' => _x( 'None', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/buttons-style-flat.gif',
		),
		'3d'     => array(
			'title' => _x( '3D', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/buttons-style-3d.gif',
		),
		'shadow' => array(
			'title' => _x( 'Shadow', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/buttons-style-shadow.gif',
		),
	),
);

/**
 * Buttons color.
 */
$options[] = array( 'name' => _x( 'Buttons color', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['buttons-color_mode'] = array(
	'name'    => _x( 'Buttons color', 'theme-options', 'the7mk2' ),
	'id'      => 'buttons-color_mode',
	'std'     => 'accent',
	'type'    => 'radio',
	'class'   => 'small',
	'options' => array(
		'disabled'   => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    =>_x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['buttons-color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-color',
	'std'        => '#ffffff',
	'type'       => 'color',
	'dependency' => array(
		'field'    => 'buttons-color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['buttons-color_gradient'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-color_gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'type'       => 'gradient_picker',
	'dependency' => array(
		'field'    => 'buttons-color_mode',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['buttons-hover_color_mode'] = array(
	'name'    => _x( 'Buttons hover color', 'theme-options', 'the7mk2' ),
	'id'      => 'buttons-hover_color_mode',
	'std'     => 'accent',
	'type'    => 'radio',
	'class'   => 'small',
	'divider' => 'top',
	'options' => array(
		'disabled'   => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'accent'   =>  _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'   => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['buttons-hover_color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-hover_color',
	'std'        => '#ffffff',
	'type'       => 'color',
	'dependency' => array(
		'field'    => 'buttons-hover_color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['buttons-hover_color_gradient'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-hover_color_gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'type'       => 'gradient_picker',
	'dependency' => array(
		'field'    => 'buttons-hover_color_mode',
		'operator' => '==',
		'value'    => 'gradient',
	),
);
$options['buttons-border-color_mode'] = array(
	'name'    => _x( 'Border color', 'theme-options', 'the7mk2' ),
	'id'      => 'buttons-border-color_mode',
	'std'     => 'accent',
	'type'    => 'radio',
	'class'   => 'small',
	'divider' => 'top',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    =>_x( 'Custom color', 'theme-options', 'the7mk2' ),
	),
);
$options['buttons-border-color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-border-color',
	'std'        => '#ffffff',
	'type'       => 'color',
	'dependency' => array(
		'field'    => 'buttons-border-color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);
$options['buttons-hover-border-color_mode'] = array(
	'name'    => _x( 'Border hover color', 'theme-options', 'the7mk2' ),
	'id'      => 'buttons-hover-border-color_mode',
	'std'     => 'accent',
	'type'    => 'radio',
	'class'   => 'small',
	'divider' => 'top',
	'options' => array(
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    =>_x( 'Custom color', 'theme-options', 'the7mk2' ),
	),
);
$options['buttons-hover-border-color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-hover-border-color',
	'std'        => '#ffffff',
	'type'       => 'color',
	'dependency' => array(
		'field'    => 'buttons-hover-border-color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);
$options['buttons-text_color_mode'] = array(
	'name'    => _x( 'Text color', 'theme-options', 'the7mk2' ),
	'id'      => 'buttons-text_color_mode',
	'std'     => 'color',
	'type'    => 'radio',
	'class'   => 'small',
	'divider' => 'top',
	'options' => array(
		'accent' => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'  => _x( 'Custom color', 'theme-options', 'the7mk2' ),
	),
);

$options['buttons-text_color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-text_color',
	'std'        => '#ffffff',
	'type'       => 'color',
	'dependency' => array(
		'field'    => 'buttons-text_color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['buttons-text_hover_color_mode'] = array(
	'name'    => _x( 'Text hover color', 'theme-options', 'the7mk2' ),
	'id'      => 'buttons-text_hover_color_mode',
	'std'     => 'color',
	'type'    => 'radio',
	'class'   => 'small',
	'divider' => 'top',
	'options' => array(
		'accent' => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'  => _x( 'Custom color', 'theme-options', 'the7mk2' ),
	),
);

$options['buttons-text_hover_color'] = array(
	'name'       => '&nbsp;',
	'id'         => 'buttons-text_hover_color',
	'std'        => '#ffffff',
	'type'       => 'color',
	'dependency' => array(
		'field'    => 'buttons-text_hover_color_mode',
		'operator' => '==',
		'value'    => 'color',
	),
);

/**
 * Small buttons.
 */

$options[] = array( 'name' => _x( 'Small buttons', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options["buttons-s-typography"] = array(
	'id'   => "buttons-s-typography",
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 12,
		'text_transform' => 'none',
	),
);

$options['buttons-s-icon-size'] = array(
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'id'      => 'buttons-s-icon-size',
	'std'     => 12,
	'options' => array( 'min' => 9, 'max' => 120 ),
);

$options["buttons-s_padding"] = array(
	'id'   => "buttons-s_padding",
	'name' => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '8px 14px 7px 14px',
);

$options["buttons-s_border_radius"] = array(
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'id'    => "buttons-s_border_radius",
	'std'   => '4px',
	'type'  => 'number',
	'units' => 'px',
);

$options["buttons-s_border_width"] = array(
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'id'    => "buttons-s_border_width",
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

/**
 * Medium buttons.
 */

$options[] = array( 'name' => _x( 'Medium buttons', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options["buttons-m-typography"] = array(
	'id'   => "buttons-m-typography",
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 12,
		'text_transform' => 'none',
	),
);

$options['buttons-m-icon-size'] = array(
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'id'      => 'buttons-m-icon-size',
	'std'     => 12,
	'options' => array( 'min' => 9, 'max' => 120 ),
);

$options["buttons-m_padding"] = array(
	'id'   => "buttons-m_padding",
	'name' => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '12px 18px 11px 18px',
);

$options["buttons-m_border_radius"] = array(
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'id'    => "buttons-m_border_radius",
	'std'   => '4px',
	'type'  => 'number',
	'units' => 'px',
);

$options["buttons-m_border_width"] = array(
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'id'    => "buttons-m_border_width",
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

/**
 * Big buttons.
 */

$options[] = array( 'name' => _x( 'Big buttons', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options["buttons-l-typography"] = array(
	'id'   => "buttons-l-typography",
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 12,
		'text_transform' => 'none',
	),
);

$options['buttons-l-icon-size'] = array(
	'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'    => 'slider',
	'id'      => 'buttons-l-icon-size',
	'std'     => 12,
	'options' => array( 'min' => 9, 'max' => 120 ),
);

$options["buttons-l_padding"] = array(
	'id'   => "buttons-l_padding",
	'name' => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '17px 24px 16px 24px',
);

$options["buttons-l_border_radius"] = array(
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'id'    => "buttons-l_border_radius",
	'std'   => '4px',
	'type'  => 'number',
	'units' => 'px',
);

$options["buttons-l_border_width"] = array(
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'id'    => "buttons-l_border_width",
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);
