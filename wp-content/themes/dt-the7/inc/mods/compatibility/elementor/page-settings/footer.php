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

return [
	'args'     => [
		'label'     => __( 'Footer settings', 'the7mk2' ),
		'tab'       => Controls_Manager::TAB_SETTINGS,
		'condition' => [
			$template_option_name . '!' => [ PageTemplatesModule::TEMPLATE_CANVAS ],
		],
	],
	'controls' => [
		'the7_document_show_footer_wa' => [
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
		'the7_document_footer_wa_id'   => [
			'meta' => '_dt_footer_widgetarea_id',
			'args' => [
				'label'     => __( 'Footer widget area', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'sidebar_2',
				'options'   => 'presscore_get_widgetareas_options',
				'separator' => 'none',
				'condition' => [
					'the7_document_show_footer_wa' => '1',
				],
			],
		],
	],
];
