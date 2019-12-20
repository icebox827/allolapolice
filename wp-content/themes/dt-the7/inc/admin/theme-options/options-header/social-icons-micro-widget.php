<?php
defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name'                => _x( 'Social icons', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-social_icons-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-soc_icons' );

$options['header-elements-soc_icons-bg-size'] = array(
	'name'  => _x( 'Icons background size', 'theme-options', 'the7mk2' ),
	'id'    => 'header-elements-soc_icons-bg-size',
	'std'   => '26px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-elements-soc_icons-size'] = array(
	'name'  => _x( 'Icons size', 'theme-options', 'the7mk2' ),
	'id'    => 'header-elements-soc_icons-size',
	'std'   => '16px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-elements-soc_icons_border_width'] = array(
	'name'  => _x( 'Icons border width', 'theme-options', 'the7mk2' ),
	'id'    => 'header-elements-soc_icons_border_width',
	'std'   => '1px',
	'type'  => 'number',
	'units' => 'px',
);

$options['header-elements-soc_icons_border_radius'] = array(
	'name'  => _x( 'Icons border radius', 'theme-options', 'the7mk2' ),
	'id'    => 'header-elements-soc_icons_border_radius',
	'std'   => '100px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array(
	'name' => _x( 'Icons margins', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['header-elements-soc_icons_gap'] = array(
	'id'       => 'header-elements-soc_icons_gap',
	'name'     => _x( 'Gap between icons', 'theme-options', 'the7mk2' ),
	'std'      => '4px',
	'type'     => 'text',
	'sanitize' => 'dimensions',
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Normal', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['header-elements-soc_icons-color'] = array(
	'id'       => 'header-elements-soc_icons-color',
	'name'     => _x( 'Icons color', 'theme-options', 'the7mk2' ),
	'type'     => 'color',
	'std'      => '#fff',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color', 'theme-options', 'the7mk2' ),
);

$options['header-elements-soc_icons-bg'] = array(
	'id'      => 'header-elements-soc_icons-bg',
	'name'    => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-soc_icons-bg-color'] = array(
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'id'         => 'header-elements-soc_icons-bg-color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-elements-soc_icons-bg',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-elements-soc_icons-bg-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-elements-soc_icons-bg-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-elements-soc_icons-bg',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-elements-soc_icons-border'] = array(
	'id'      => 'header-elements-soc_icons-border',
	'name'    => _x( 'Border color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-soc_icons-border-color'] = array(
	'id'         => 'header-elements-soc_icons-border-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-elements-soc_icons-border',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array( 'name' => _x( 'Hover', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['header-elements-soc_icons-hover-color'] = array(
	'id'       => 'header-elements-soc_icons-hover-color',
	'name'     => _x( 'Icons hover', 'theme-options', 'the7mk2' ),
	'std'      => '#fff',
	'type'     => 'color',
	'sanitize' => 'empty_color',
	'desc'     => _x( 'Leave empty to use accent color', 'theme-options', 'the7mk2' ),
);

$options['header-elements-soc_icons-hover-bg'] = array(
	'id'      => 'header-elements-soc_icons-hover-bg',
	'name'    => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'accent',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-soc_icons-hover-bg-color'] = array(
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'id'         => 'header-elements-soc_icons-hover-bg-color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-elements-soc_icons-hover-bg',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['header-elements-soc_icons-hover-bg-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'header-elements-soc_icons-hover-bg-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'header-elements-soc_icons-hover-bg',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options['header-elements-soc_icons-hover-border'] = array(
	'id'      => 'header-elements-soc_icons-hover-border',
	'name'    => _x( 'Border color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'disabled',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
		'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-soc_icons-hover-border-color'] = array(
	'id'         => 'header-elements-soc_icons-hover-border-color',
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'header-elements-soc_icons-hover-border',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options[] = array( 'type' => 'divider' );

$options['header-elements-soc_icons'] = array(
	'id'      => 'header-elements-soc_icons',
	'type'    => 'fields_generator',
	'std'     => array(
		array( 'icon' => '', 'url' => '' ),
	),
	'options' => array(
		'fields' => array(
			'icon' => array(
				'type'        => 'select',
				'class'       => 'of_fields_gen_title',
				'description' => _x( 'Icon', 'theme-options', 'the7mk2' ),
				'wrap'        => '<label>%2$s%1$s</label>',
				'desc_wrap'   => '%2$s',
				'options'     => presscore_get_social_icons_data(),
			),
			'url'  => array(
				'type'        => 'text',
				'description' => _x( 'Url', 'theme-options', 'the7mk2' ),
				'wrap'        => '<label>%2$s%1$s</label>',
				'desc_wrap'   => '%2$s',
			),
		),
	),
);
