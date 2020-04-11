<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor\Page_Settings;

use Elementor\Controls_Manager;
use Elementor\Modules\PageTemplates\Module as PageTemplatesModule;
use The7_Elementor_Compatibility;

defined( 'ABSPATH' ) || exit;

$template_option_name = The7_Elementor_Compatibility::instance()->page_settings->template_option_name;
$template_condition = [ PageTemplatesModule::TEMPLATE_CANVAS];

return [
	'args'     => [
		'label'     => __( 'Footer settings', 'the7mk2' ),
		'tab'       => Controls_Manager::TAB_SETTINGS,
		'conditions' => [
			'relation' => 'or',
			'terms'    => [
				[
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'the7_template_applied',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => $template_option_name,
							'operator' => '!in',
							'value'    => array_merge(['default'], $template_condition),
						],
					],
				],
				[
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => $template_option_name,
							'operator' => '!in',
							'value'    => $template_condition,
						],
						[
							'name'     => 'the7_template_applied',
							'operator' => '==',
							'value'    => '',
						],
					],
				],
			],
		],
	],
	'controls' => [
		'the7_document_show_footer_wa'   => [
			'meta' => '_dt_footer_show',
			'args' => [
				'label'        => __( 'Footer', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'prefix_class' => 'elementor-',
				'label_on'     => __( 'Show', 'the7mk2' ),
				'label_off'    => __( 'Hide', 'the7mk2' ),
				'return_value' => '1',
				'empty_value'  => '0',
				'separator'    => 'none',
			],
		],
		'the7_document_footer_source_wa' => [
			'meta' => '_dt_footer_elementor_source',
			'args' => [
				'label'        => __( 'Footer source', 'the7mk2' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'elementor',
				'prefix_class' => 'elementor-',
				'options'      => [
					'elementor' => __( 'Elementor', 'the7mk2' ),
					'the7'      => __( 'The7', 'the7mk2' ),
				],
				'condition'    => [
					'the7_document_show_footer_wa' => '1',
				],
				'separator'    => 'none',
			],
		],
		'the7_document_footer_wa_id'     => [
			'meta' => '_dt_footer_widgetarea_id',
			'args' => [
				'label'     => __( 'Footer widget area', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'sidebar_2',
				'options'   => 'presscore_get_widgetareas_options',
				'separator' => 'none',
				'condition' => [
					'the7_document_show_footer_wa'   => '1',
					'the7_document_footer_source_wa' => 'the7',
				],
			],
		],
	],
];
