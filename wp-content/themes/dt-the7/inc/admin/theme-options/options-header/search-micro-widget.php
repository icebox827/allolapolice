<?php
defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name'                => _x( 'Search', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-search-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-search' );

$options[] = array( 'name' => _x( 'Search style', 'theme-options', 'the7mk2' ), 'type' => 'title' );

$options['microwidgets-search_style'] = array(
	'name'      => _x( 'Style', 'theme-options', 'the7mk2' ),
	'id'        => 'microwidgets-search_style',
	'type'      => 'select',
	'class'     => 'middle',
	'std'       => 'popup',
	'options'   => array(
		'classic'       => _x( 'Input with fixed width', 'theme-options', 'the7mk2' ),
		'animate_width' => _x( 'Input with changing width', 'theme-options', 'the7mk2' ),
		'popup'         => _x( 'Popup', 'theme-options', 'the7mk2' ),
		'overlay'       => _x( 'Overlay', 'theme-options', 'the7mk2' ),
	),
	'show_hide' => array(
		'overlay' => 'overlay-bg-show',
	),
);

$options['header-elements-search-icon'] = array(
	'name'       => _x( 'Search icon', 'theme-options', 'the7mk2' ),
	'id'         => 'header-elements-search-icon',
	'type'       => 'select',
	'class'      => 'middle',
	'std'        => 'custom',
	'options'    => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'custom'   => _x( 'Custom', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		array(
			array(
				'field'    => 'microwidgets-search_style',
				'operator' => '==',
				'value'    => 'popup',
			),
		),
		array(
			array(
				'field'    => 'microwidgets-search_style',
				'operator' => '==',
				'value'    => 'overlay',
			),
		),
	),
);

$options['header-elements-search_custom-icon'] = array(
	'name'          => 'Select icon',
	'id'            => 'header-elements-search_custom-icon',
	'type'          => 'icons_picker',
	'default_icons' => array(
		'icomoon-the7-font-the7-zoom-02',
		'icomoon-the7-font-the7-zoom-044',
		'icomoon-the7-font-icon-gallery-011-2',
		'icomoon-the7-font-the7-zoom-08',
	),
	'std'           => 'the7-mw-icon-search',
	'dependency'    => array(
		array(
			array(
				'field'    => 'microwidgets-search_style',
				'operator' => '==',
				'value'    => 'popup',
			),
			array(
				'field'    => 'header-elements-search-icon',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		array(
			array(
				'field'    => 'microwidgets-search_style',
				'operator' => '==',
				'value'    => 'overlay',
			),
			array(
				'field'    => 'header-elements-search-icon',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	),
);


$options['header-elements-search-caption'] = array(
	'id'         => 'header-elements-search-caption',
	'name'       => _x( 'Search caption', 'theme-options', 'the7mk2' ),
	'type'       => 'text',
	'std'        => _x( 'Search', 'theme-options', 'the7mk2' ),
	'desc'       => _x( 'Leave empty to remove caption.', 'theme-options', 'the7mk2' ),
	'dependency' => array(
		array(

			array(
				'field'    => 'microwidgets-search_style',
				'operator' => '==',
				'value'    => 'popup',
			),
		),
		array(
			array(
				'field'    => 'microwidgets-search_style',
				'operator' => '==',
				'value'    => 'overlay',
			),
		),
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Input font & icon settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['microwidgets-search-typography'] = array(
	'id'   => 'microwidgets-search-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family' => 'Roboto',
		'font_size'   => 14,
	),
);

$options['microwidgets-search_icon'] = array(
	'name'    => _x( 'Icon', 'theme-options', 'the7mk2' ),
	'id'      => 'microwidgets-search_icon',
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'custom',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'custom'   => _x( 'Custom', 'theme-options', 'the7mk2' ),
	),
);

$options['microwidgets-search_custom-icon'] = array(
	'name'          => 'Select icon',
	'id'            => 'microwidgets-search_custom-icon',
	'type'          => 'icons_picker',
	'default_icons'  => array(
		'icomoon-the7-font-the7-zoom-02',
		'icomoon-the7-font-the7-zoom-044',
		'icomoon-the7-font-icon-gallery-011-2',
		'icomoon-the7-font-the7-zoom-08',
	),
	'std'           => 'the7-mw-icon-search',
	'dependency'    => array(
		'field'    => 'microwidgets-search_icon',
		'operator' => '==',
		'value'    => 'custom',
	),
);

$options['microwidgets-search_font-color'] = array(
	'id'   => 'microwidgets-search_font-color',
	'name' => _x( 'Font & icon color', 'theme-options', 'the7mk2' ),
	'type' => 'color',
	'std'  => '#aaaaaa',
);

$options['microwidgets-search_icon-size'] = array(
	'id'         => 'microwidgets-search_icon-size',
	'name'       => _x( 'Icon size', 'theme-options', 'the7mk2' ),
	'type'       => 'slider',
	'std'        => 16,
	'options'    => array( 'min' => 9, 'max' => 120 ),
	'dependency' => array(
		'field'    => 'microwidgets-search_icon',
		'operator' => '!=',
		'value'    => 'disabled',
	),
);

$options['header-elements-search-input-caption'] = array(
	'id'   => 'header-elements-search-input-caption',
	'name' => _x( 'Input caption', 'theme-options', 'the7mk2' ),
	'type' => 'text',
	'std'  => _x( 'Type and hit enter &hellip;', 'theme-options', 'the7mk2' ),
	'desc' => _x( 'Leave empty to remove caption.', 'theme-options', 'the7mk2' ),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'Input background settings', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['microwidgets-search-height'] = array(
	'id'    => 'microwidgets-search-height',
	'name'  => _x( 'Background height', 'theme-options', 'the7mk2' ),
	'std'   => '34px',
	'type'  => 'number',
	'units' => 'px',
);

$options['microwidgets-search-width'] = array(
	'id'    => 'microwidgets-search-width',
	'name'  => _x( 'Background width', 'theme-options', 'the7mk2' ),
	'std'   => '200px',
	'type'  => 'number',
	'units' => 'px',
);

$options['microwidgets-search-active-width'] = array(
	'id'         => 'microwidgets-search-active-width',
	'name'       => _x( 'Background width on click', 'theme-options', 'the7mk2' ),
	'std'        => '200px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'microwidgets-search_style',
		'operator' => '==',
		'value'    => 'animate_width',
	),
);

$options['microwidgets-search_bg-color'] = array(
	'id'   => 'microwidgets-search_bg-color',
	'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#f4f4f4',
);

$options['microwidgets-search_bg_border_radius'] = array(
	'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'id'    => 'microwidgets-search_bg_border_radius',
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['microwidgets-search_bg_border_width'] = array(
	'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
	'id'    => 'microwidgets-search_bg_border_width',
	'std'   => '0px',
	'type'  => 'number',
	'units' => 'px',
);

$options['microwidgets-search_input-padding'] = array(
	'id'     => 'microwidgets-search_input-padding',
	'name'   => _x( 'Paddings', 'theme-options', 'the7mk2' ),
	'type'   => 'spacing',
	'std'    => '12px 12px',
	'fields' => array(
		_x( 'Right', 'theme-options', 'the7mk2' ),
		_x( 'Left', 'theme-options', 'the7mk2' ),
	),
);

$options['microwidgets-search_bg-border-color'] = array(
	'id'   => 'microwidgets-search_bg-border-color',
	'name' => _x( 'Border color', 'theme-options', 'the7mk2' ),
	'type' => 'alpha_color',
	'std'  => '#e2e2e2',
);

$options[] = array( 'type' => 'js_hide_begin', 'class' => 'microwidgets-search_style overlay-bg-show' );

$options[] = array( 'type' => 'divider', );

$options[] = array( 'name' => _x( 'Overlay color', 'theme-options', 'the7mk2' ), 'type' => 'title', );

$options['microwidgets-search_overlay-bg'] = array(
	'id'      => 'microwidgets-search_overlay-bg',
	'name'    => _x( 'Background color', 'theme-options', 'the7mk2' ),
	'type'    => 'radio',
	'class'   => 'small',
	'std'     => 'color',
	'options' => array(
		'color'    => _x( 'Mono color', 'theme-options', 'the7mk2' ),
		'gradient' => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	),
);

$options['microwidgets-search_overlay-bg-color'] = array(
	'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
	'type'       => 'alpha_color',
	'id'         => 'microwidgets-search_overlay-bg-color',
	'std'        => 'rgba(0, 0, 0, 0.9)',
	'dependency' => array(
		'field'    => 'microwidgets-search_overlay-bg',
		'operator' => '==',
		'value'    => 'color',
	),
);

$options['microwidgets-search_overlay-bg-gradient'] = array(
	'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
	'type'       => 'gradient_picker',
	'id'         => 'microwidgets-search_overlay-bg-gradient',
	'std'        => '135deg|#ffffff 30%|#000000 100%',
	'dependency' => array(
		'field'    => 'microwidgets-search_overlay-bg',
		'operator' => '==',
		'value'    => 'gradient',
	),
);

$options[] = array( 'type' => 'js_hide_end' );

$options['header-elements-search-by'] = array(
	'name'    => _x( 'Search by', 'theme-options', 'the7mk2' ),
	'id'      => 'header-elements-search-by',
	'type'    => 'radio',
	'std'     => 'general',
	'options' => array(
		'general'  => _x( 'All searchable post types', 'theme-options', 'the7mk2' ),
		'products' => _x( 'WooCommerce products', 'theme-options', 'the7mk2' ),
	),
	'divider' => 'top',
);