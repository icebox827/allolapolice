<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor\Page_Settings;
use Elementor\Modules\PageTemplates\Module as PageTemplatesModule;

use Elementor\Controls_Manager;
use The7_Elementor_Compatibility;

defined( 'ABSPATH' ) || exit;

$template_option_name = The7_Elementor_Compatibility::instance()->page_settings->template_option_name;
$template_condition = [ PageTemplatesModule::TEMPLATE_CANVAS, PageTemplatesModule::TEMPLATE_HEADER_FOOTER ];

return [
	'args'     => [
		'label' => __( 'Page Paddings', 'the7mk2' ),
		'tab'   => Controls_Manager::TAB_SETTINGS,
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
		'desktop_heading'                     => [
			'args' => [
				'label'     => __( 'Desktop', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			],
		],
		'the7_document_padding_top'           => [
			'meta'    => '_dt_page_overrides_top_margin',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Top padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
		'the7_document_padding_right'         => [
			'meta'    => '_dt_page_overrides_right_margin',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Right padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
		'the7_document_padding_bottom'        => [
			'meta'    => '_dt_page_overrides_bottom_margin',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Bottom padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
		'the7_document_padding_left'          => [
			'meta'    => '_dt_page_overrides_left_margin',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Left padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
		'mobile_heading'                      => [
			'args' => [
				'label'     => __( 'Mobile', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			],
		],
		'the7_document_mobile_padding_top'    => [
			'meta'    => '_dt_mobile_page_padding_top',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Top padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
		'the7_document_mobile_padding_right'  => [
			'meta'    => '_dt_mobile_page_padding_right',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Right padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
		'the7_document_mobile_padding_bottom' => [
			'meta'    => '_dt_mobile_page_padding_bottom',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Bottom padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
		'the7_document_mobile_padding_left'   => [
			'meta'    => '_dt_mobile_page_padding_left',
			'on_save' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'update_padding',
			],
			'on_read' => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Padding_Meta_Adapter::class,
				'get_padding',
			],
			'args'    => [
				'label'      => __( 'Left padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			],
		],
	],
];
