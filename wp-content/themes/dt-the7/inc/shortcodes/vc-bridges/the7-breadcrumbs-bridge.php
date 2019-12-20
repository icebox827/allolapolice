<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	'name' => __( 'Breadcrumbs', 'the7mk2' ),
	'base' => 'dt_breadcrumbs',
	'class' => 'dt_vc_sc_breadcrumbs',
	'icon' => 'dt_vc_ico_breadcrumbs',
	'category' => __( 'by Dream-Theme', 'the7mk2' ),
	'description' => "",
	'params' => array(
		array(
			'heading' => __( 'Font', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __( 'Font style', 'the7mk2' ),
			'param_name' => 'font_style',
			'type' => 'dt_font_style',
			'value' => '',
		),
		array(
			'heading' => __('Font size', 'the7mk2'),
			'param_name' => 'font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H3 font size.', 'the7mk2' ),
		),
		array(
			'heading' => __('Line height', 'the7mk2'),
			'param_name' => 'line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H3 line height.', 'the7mk2' ),
		),
		array(
			'heading'		=> __('Font color', 'the7mk2'),
			'param_name'	=> 'font_color',
			'type'			=> 'colorpicker',
			'value'			=> '#a2a5a6',
			'description' => __( 'Leave empty to use headings color.', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Background', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Paddings', 'the7mk2'),
			'param_name' => 'paddings',
			'type' => 'dt_spacing',
			'value' => '2px 10px 2px 10px',
			'units' => 'px',
		),
		array(
			'heading'		=> __('Background color', 'the7mk2'),
			'param_name'	=> 'bg_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
		),
		array(
			'heading' => __( 'Border', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading'		=> __('Border color', 'the7mk2'),
			'param_name'	=> 'border_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
		),
		array(
			'heading' => __('Border width', 'the7mk2'),
			'param_name' => 'border_width',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Border radius', 'the7mk2'),
			'param_name' => 'border_radius',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __( 'Position', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Alignment', 'the7mk2'),
			'type' => 'dropdown',
			'holder' => 'div',
			'param_name' => 'alignment',
			'value' => array(
				'Center' => 'center',
				'Left' => 'left',
				'Right' => 'right',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
	)
);

