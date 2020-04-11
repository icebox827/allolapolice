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
$template_condition   = [ PageTemplatesModule::TEMPLATE_CANVAS ];

return [
	'args'     => [
		'label'      => __( 'Page header settings', 'the7mk2' ),
		'tab'        => Controls_Manager::TAB_SETTINGS,
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
							'value'    => array_merge( [ 'default' ], $template_condition ),
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
		'the7_document_title'                            => [
			'meta' => '_dt_header_title',
			'args' => [
				'label'     => __( 'Page title', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'enabled',
				'options'   => [
					'enabled'   => __( 'Show page title', 'the7mk2' ),
					'disabled'  => __( 'Hide page title', 'the7mk2' ),
					'fancy'     => __( 'Fancy title', 'the7mk2' ),
					'slideshow' => __( 'Slideshow', 'the7mk2' ),
				],
				'separator' => 'none',
			],
		],

		// Disabled page title.
		'the7_document_disabled_header_style'            => [
			'meta' => '_dt_header_disabled_background',
			'args' => [
				'label'     => __( 'Header style', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'normal',
				'options'   => [
					'normal'      => __( 'Normal', 'the7mk2' ),
					'transparent' => __( 'Transparent', 'the7mk2' ),
				],
				'separator' => 'none',
				'condition' => [
					'the7_document_title' => 'disabled',
				],
			],
		],
		'the7_document_disabled_header_color_scheme'     => [
			'meta' => '_dt_header_disabled_transparent_bg_color_scheme',
			'args' => [
				'label'     => __( 'Color scheme', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'from_options',
				'options'   => [
					'from_options' => __( 'From options', 'the7mk2' ),
					'light'        => __( 'Light', 'the7mk2' ),
				],
				'separator' => 'none',
				'condition' => [
					'the7_document_title'                 => 'disabled',
					'the7_document_disabled_header_style' => 'transparent',
				],
			],
		],
		'the7_document_disabled_header_top_bar_color'    => [
			'meta'      => [
				'color'   => '_dt_header_disabled_transparent_top_bar_bg_color',
				'opacity' => '_dt_header_disabled_transparent_top_bar_bg_opacity',
			],
			'on_save'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'update_alpha_color',
			],
			'on_read'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'get_alpha_color',
			],
			'on_change' => 'do_not_reload_page',
			'args'      => [
				'label'     => __( 'Top bar color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.25)',
				'separator' => 'none',
				'condition' => [
					'the7_document_title'                 => 'disabled',
					'the7_document_disabled_header_style' => 'transparent',
				],
			],
		],
		'the7_document_disabled_header_backgraund_color' => [
			'meta'      => [
				'color'   => '_dt_header_disabled_transparent_bg_color',
				'opacity' => '_dt_header_disabled_transparent_bg_opacity',
			],
			'on_save'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'update_alpha_color',
			],
			'on_read'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'get_alpha_color',
			],
			'on_change' => 'do_not_reload_page',
			'args'      => [
				'label'     => __( 'Transparent background color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.5)',
				'separator' => 'none',
				'condition' => [
					'the7_document_title'                 => 'disabled',
					'the7_document_disabled_header_style' => 'transparent',
				],
			],
		],

		// Fancy titles and slideshow.
		'the7_document_fancy_header_style'               => [
			'meta' => '_dt_header_background',
			'args' => [
				'label'     => __( 'Header style', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'normal',
				'options'   => [
					'normal'      => __( 'Normal', 'the7mk2' ),
					'transparent' => __( 'Transparent', 'the7mk2' ),
				],
				'separator' => 'none',
				'condition' => [
					'the7_document_title' => [ 'fancy', 'slideshow' ],
				],
			],
		],
		'the7_document__background_below_slideshow'      => [
			'meta' => '_dt_header_background_below_slideshow',
			'args' => [
				'label'        => __( 'Show header below slideshow', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'enabled',
				'default'      => '',
				'condition'    => [
					'the7_document_title' => 'slideshow',
				],
			],
		],
		'the7_document_fancy_header_color_scheme'        => [
			'meta' => '_dt_header_transparent_bg_color_scheme',
			'args' => [
				'label'     => __( 'Color scheme', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'from_options',
				'options'   => [
					'from_options' => __( 'From options', 'the7mk2' ),
					'light'        => __( 'Light', 'the7mk2' ),
				],
				'separator' => 'none',
				'condition' => [
					'the7_document_title'              => [ 'fancy', 'slideshow' ],
					'the7_document_fancy_header_style' => 'transparent',
				],
			],
		],
		'the7_document_fancy_header_top_bar_color'       => [
			'meta'      => [
				'color'   => '_dt_header_transparent_top_bar_bg_color',
				'opacity' => '_dt_header_transparent_top_bar_bg_opacity',
			],
			'on_save'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'update_alpha_color',
			],
			'on_read'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'get_alpha_color',
			],
			'on_change' => 'do_not_reload_page',
			'args'      => [
				'label'     => __( 'Top bar color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.25)',
				'separator' => 'none',
				'condition' => [
					'the7_document_title'              => [ 'fancy', 'slideshow' ],
					'the7_document_fancy_header_style' => 'transparent',
				],
			],
		],
		'the7_document_fancy_header_backgraund_color'    => [
			'meta'      => [
				'color'   => '_dt_header_transparent_bg_color',
				'opacity' => '_dt_header_transparent_bg_opacity',
			],
			'on_save'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'update_alpha_color',
			],
			'on_read'   => [
				\The7\Adapters\Elementor\Meta_Adapters\The7_Elementor_Color_Meta_Adapter::class,
				'get_alpha_color',
			],
			'on_change' => 'do_not_reload_page',
			'args'      => [
				'label'     => __( 'Transparent background color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.5)',
				'separator' => 'none',
				'condition' => [
					'the7_document_title'              => [ 'fancy', 'slideshow' ],
					'the7_document_fancy_header_style' => 'transparent',
				],
			],
		],
	],
];
