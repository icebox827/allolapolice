<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Top bar', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'topbar',
);


$options[] = array(
	'name' => _x( 'Layout', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['top-bar-height'] = array(
	'id'    => 'top-bar-height',
	'name'  => _x( 'Top bar height', 'theme-options', 'the7mk2' ),
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['top_bar-padding']         = array(
	'name'   => _x( 'Top bar paddings', 'theme-options', 'the7mk2' ),
	'id'     => 'top_bar-padding',
	'type'   => 'spacing',
	'std'    => '0px 50px 0px 50px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Top', 'theme-options', 'the7mk2' ),
		_x( 'Right', 'theme-options', 'the7mk2' ),
		_x( 'Bottom', 'theme-options', 'the7mk2' ),
		_x( 'Left', 'theme-options', 'the7mk2' ),
	),
);
$options['top_bar-switch_paddings'] = array(
	'name'  => _x( 'Mobile breakpoint', 'theme-options', 'the7mk2' ),
	'id'    => 'top_bar-switch_paddings',
	'type'  => 'number',
	'std'   => '600px',
	'units' => 'px',
);

$options['top_bar_mobile_paddings'] = array(
	'name'   => _x( 'Mobile paddings', 'theme-options', 'the7mk2' ),
	'id'     => 'top_bar_mobile_paddings',
	'type'   => 'spacing',
	'std'    => '0px 20px 0px 20px',
	'units'  => 'px|%',
	'fields' => array(
		_x( 'Top', 'theme-options', 'the7mk2' ),
		_x( 'Right', 'theme-options', 'the7mk2' ),
		_x( 'Bottom', 'theme-options', 'the7mk2' ),
		_x( 'Left', 'theme-options', 'the7mk2' ),
	),
);


$options[] = array(
	'name' => _x( 'Background', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['top_bar-bg-color'] = array(
	'id'   => 'top_bar-bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#ffffff',
);

$options['top_bar-bg-image'] = array(
	'id'   => 'top_bar-bg-image',
	'name' => _x( 'Add background image', 'theme-options', 'the7mk2' ),
	'type' => 'background_img',
	'std'  => array(
		'image'      => '',
		'repeat'     => 'repeat',
		'position_x' => 'center',
		'position_y' => 'center',
	),
);

$options['top_bar-bg-style'] = array(
	'id'      => 'top_bar-bg-style',
	'name'    => _x( 'Decoration', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'std'     => 'content_line',
	'options' => array(
		'disabled'       => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/topbar-bg-style-disabled.gif',
		),
		'content_line'   => array(
			'title' => _x( 'Content-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/topbar-bg-style-contentline.gif',
		),
		'fullwidth_line' => array(
			'title' => _x( 'Full-width line', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/topbar-bg-style-fullwidthline.gif',
		),
	),
	'class'   => 'small',
);

$options['top_bar-line-color'] = array(
	'id'         => 'top_bar-line-color',
	'name'       => _x( 'Line color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'std'        => '#ffffff',
	'dependency' => array(
		'field'    => 'top_bar-bg-style',
		'operator' => 'IN',
		'value'    => array( 'content_line', 'fullwidth_line' ),
	),
);

$options['top_bar-line_size'] = array(
	'id'         => 'top_bar-line_size',
	'name'       => _x( 'Line height', 'theme-options', 'the7mk2' ),
	'std'        => '1px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'top_bar-bg-style',
		'operator' => 'IN',
		'value'    => array( 'content_line', 'fullwidth_line' ),
	),
);

$options['top_bar-line_style'] = array(
	'name'       => _x( 'Line style', 'theme-options', 'the7mk2' ),
	'id'         => 'top_bar-line_style',
	'type'       => 'select',
	'class'      => 'middle',
	'std'        => 'solid',
	'options'    => array(
		'solid'  => _x( 'Solid', 'theme-options', 'the7mk2' ),
		'dotted' => _x( 'Dotted', 'theme-options', 'the7mk2' ),
		'dashed' => _x( 'Dashed', 'theme-options', 'the7mk2' ),
		'double' => _x( 'Double', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'top_bar-bg-style',
		'operator' => 'IN',
		'value'    => array( 'content_line', 'fullwidth_line' ),
	),
);

$options['top_bar-line-in-transparent-header'] = array(
	'id'         => 'top_bar-line-in-transparent-header',
	'name'       => _x( 'Show line in transparent headers ', 'theme-options', 'the7mk2' ),
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'top_bar-bg-style',
		'operator' => 'IN',
		'value'    => array( 'content_line', 'fullwidth_line' ),
	),
);
