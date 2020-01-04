<?php
/**
 * The7 page settings.
 *
 * @package The7
 */

namespace The7\Adapters\Elementor;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use \Color;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Page_Settings {

	/**
	 * Custom Elementor controls.
	 *
	 * @var array $controls Controls array.
	 */
	protected $controls = [];

	/**
	 * Custom Elementor sections.
	 *
	 * @var array $sections Sections array.
	 */
	protected $sections = [];

	/**
	 * Bootstrap calss.
	 */
	public function bootstrap() {
		$this->sections = $this->get_sections();
		$controls = [ [] ];
		foreach ( $this->sections as $section ) {
			if ( ! empty( $section['controls'] ) ) {
				$controls[] = $section['controls'];
			}
		}
		$this->controls = array_merge( ...$controls );

		add_action( 'elementor/documents/register_controls', [ $this, 'add_controls' ] );
		add_filter( 'elementor/editor/localize_settings', [ $this, 'localize_settings' ], 10, 2 );
		add_action( 'elementor/document/after_save', [ $this, 'update_post_meta' ], 10, 2 );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueu_editor_preview_scripts' ] );
	}

	/**
	 * Add Elementor controls for sidebar, footer and header.
	 *
	 * @param Elementor\Core\Base\Document $document Elementor document class.
	 */
	public function add_controls( $document ) {
		foreach ( $this->sections as $section_id => $section ) {
			$document->start_controls_section( $section_id, $section['args'] );

			if ( ! empty( $section['controls'] ) ) {
				foreach ( $section['controls'] as $control_id => $control ) {
					if ( isset( $control['args']['options'] ) && is_callable( $control['args']['options'] ) ) {
						$control['args']['options'] = call_user_func( $control['args']['options'] );
					}
					$document->add_control( $control_id, $control['args'] );
				}
			}

			$document->end_controls_section();
		}
	}

	/**
	 * Localize settings values to js front.
	 *
	 * @param array $settings Array of settings.
	 * @param int   $post_id Post ID.
	 *
	 * @return array
	 */
	public function localize_settings( $settings, $post_id ) {
		$page_settings = [];
		foreach ( $this->controls as $control_id => $control ) {
			if ( isset( $control['on_read'] ) && is_callable( $control['on_read'] ) ) {
				$page_settings[ $control_id ] = call_user_func( $control['on_read'], $post_id, $control );
				continue;
			}

			if ( isset( $control['meta'] ) && is_string( $control['meta'] ) ) {
				$page_settings[ $control_id ] = get_post_meta( $post_id, $control['meta'], true );
			}
		}

		$settings['settings'] = [
			'page' => [
				'settings' => $page_settings,
			],
		];

		return $settings;
	}

	/**
	 * Update post meta.
	 *
	 * @param Elementor\Core\Base\Document $document Elementor document class.
	 * @param array                        $data Updated settings values.
	 */
	public function update_post_meta( $document, $data ) {
		if ( ! isset( $data['settings'] ) ) {
			return;
		}

		$post_id = $document->get_post()->ID;
		foreach ( $this->controls as $control_id => $control ) {
			$val = $control['args']['default'];
			if ( isset( $data['settings'][ $control_id ] ) ) {
				$val = $data['settings'][ $control_id ];
			}

			if ( isset( $control['on_save'] ) && is_callable( $control['on_save'] ) ) {
				call_user_func( $control['on_save'], $post_id, $val, $control );
				continue;
			}

			if ( isset( $control['meta'] ) && is_string( $control['meta'] ) ) {
				update_post_meta( $post_id, $control['meta'], $val );
			}
		}
	}

	/**
	 * Update post meta color with opacity.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $val     Color value.
	 * @param array  $control Elementor controls array.
	 */
	public function update_alpha_color_post_meta( $post_id, $val, $control ) {
		if ( ! isset( $control['meta']['color'], $control['meta']['opacity'] ) ) {
			return;
		}

		try {
			$color = new Color( $val );
			update_post_meta( $post_id, $control['meta']['color'], '#' . $color->getHex() );
			update_post_meta( $post_id, $control['meta']['opacity'], $color->getOpacity() );
		} catch ( Exception $e ) {
			// Do nothing.
		}
	}

	/**
	 * Return rgba color combined from post meta.
	 *
	 * @param int   $post_id Post ID.
	 * @param array $control Elementor controls array.
	 *
	 * @return string|null
	 */
	public function get_alpha_color_post_meta( $post_id, $control ) {
		if ( ! isset( $control['meta']['color'], $control['meta']['opacity'] ) ) {
			return null;
		}

		$color   = get_post_meta( $post_id, $control['meta']['color'], true );
		$opacity = get_post_meta( $post_id, $control['meta']['opacity'], true );

		return dt_stylesheet_color_hex2rgba( $color, $opacity );
	}

	public function get_page_margin_post_meta( $post_id, $control ) {
		$margin = get_post_meta( $post_id, $control['meta'], true );
		preg_match( '/([-0-9]*)(.*)/', $margin, $matches );
		list( $_, $size, $unit ) = $matches;
		$unit = $unit ?: 'px';

		return compact( 'size', 'unit' );
	}

	public function update_page_margin_post_meta( $post_id, $val, $control ) {
		$margin = '';
		if ( $val['size'] !== '' ) {
			$margin = $val['size'] . $val['unit'];
		}

		update_post_meta( $post_id, $control['meta'], $margin );
	}

	/**
	 * Add scripts to auto save and reload preview.
	 */
	public function enqueue_editor_scripts() {
		the7_register_style( 'the7-elementor-editor', PRESSCORE_ADMIN_URI . '/assets/css/elementor-editor' );
		wp_enqueue_style( 'the7-elementor-editor' );

		wp_enqueue_script( 'the7-elementor-page-settings', PRESSCORE_ADMIN_URI . '/assets/js/elementor/page-settings.js', [], THE7_VERSION, true );

		$controls_ids = [];
		foreach ( $this->controls as $id => $control ) {
			if ( isset( $control['on_change'] ) && $control['on_change'] === 'do_not_reload_page' ) {
				continue;
			}

			$controls_ids[] = $id;
		}

		wp_localize_script(
			'the7-elementor-page-settings',
			'the7Elementor',
			[
				'controlsIds' => $controls_ids,
			]
		);
	}

	/**
	 * Register frontend resources.
	 */
	public function enqueu_editor_preview_scripts() {
		if ( Plugin::$instance->preview->is_preview_mode() ) {
			the7_register_style( 'the7-elementor-editor-preview', PRESSCORE_ADMIN_URI . '/assets/css/elementor-editor-preview' );
			wp_enqueue_style( 'the7-elementor-editor-preview' );
		}
	}

	/**
	 * Return page settings definition.
	 *
	 * @return array
	 */
	protected function get_sections() {
		return [
			'the7_document_title_section' => [
				'args'     => [
					'label' => __( 'Page header settings', 'the7mk2' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				],
				'controls' => [
					'the7_document_title' => [
						'meta' => '_dt_header_title',
						'args' => [
							'label'     => __( 'Page title', 'the7mk2' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'enabled',
							'options'   => [
								'enabled'   => 'Show page title',
								'disabled'  => 'Hide page title',
								'fancy'     => 'Fancy title',
								'slideshow' => 'Slideshow',
							],
							'separator' => 'none',
						],
					],
					'the7_document_disabled_header_style' => [
						'meta' => '_dt_header_disabled_background',
						'args' => [
							'label'     => __( 'Header style', 'the7mk2' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'normal',
							'options'   => [
								'normal'      => 'Normal',
								'transparent' => 'Transparent',
							],
							'separator' => 'none',
							'condition' => [
								'the7_document_title' => 'disabled',
							],
						],
					],
					'the7_document_disabled_header_color_scheme' => [
						'meta' => '_dt_header_disabled_transparent_bg_color_scheme',
						'args' => [
							'label'     => __( 'Color scheme', 'the7mk2' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'from_options',
							'options'   => [
								'from_options' => 'From options',
								'light'        => 'Light',
							],
							'separator' => 'none',
							'condition' => [
								'the7_document_title' => 'disabled',
								'the7_document_disabled_header_style' => 'transparent',
							],
						],
					],
					'the7_document_disabled_header_top_bar_color' => [
						'meta'    => [
							'color'   => '_dt_header_disabled_transparent_top_bar_bg_color',
							'opacity' => '_dt_header_disabled_transparent_top_bar_bg_opacity',
						],
						'on_save' => [ $this, 'update_alpha_color_post_meta' ],
						'on_read' => [ $this, 'get_alpha_color_post_meta' ],
						'args'    => [
							'label'     => __( 'Top bar color', 'the7mk2' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#ffffff',
							'separator' => 'none',
							'condition' => [
								'the7_document_title' => 'disabled',
								'the7_document_disabled_header_style' => 'transparent',
							],
						],
					],
					'the7_document_disabled_header_backgraund_color' => [
						'meta'    => [
							'color'   => '_dt_header_disabled_transparent_bg_color',
							'opacity' => '_dt_header_disabled_transparent_bg_opacity',
						],
						'on_save' => [ $this, 'update_alpha_color_post_meta' ],
						'on_read' => [ $this, 'get_alpha_color_post_meta' ],
						'args'    => [
							'label'     => __( 'Transparent background color', 'the7mk2' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#000000',
							'separator' => 'none',
							'condition' => [
								'the7_document_title' => 'disabled',
								'the7_document_disabled_header_style' => 'transparent',
							],
						],
					],
				],
			],
			'the7_document_sidebar'       => [
				'args'     => [
					'label' => __( 'Sidebar settings', 'the7mk2' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				],
				'controls' => [
					'the7_document_sidebar_position' => [
						'meta' => '_dt_sidebar_position',
						'args' => [
							'label'     => __( 'Sidebar position', 'the7mk2' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'right',
							'options'   => [
								'left'     => 'Left',
								'right'    => 'Right',
								'disabled' => 'Disabled',
							],
							'separator' => 'none',
						],
					],
					'the7_document_sidebar_id'       => [
						'meta' => '_dt_sidebar_widgetarea_id',
						'args' => [
							'label'     => __( 'Sidebar', 'the7mk2' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'sidebar_1',
							'options'   => 'presscore_get_widgetareas_options',
							'separator' => 'none',
							'condition' => [
								'the7_document_sidebar_position' => [ 'left', 'right' ],
							],
						],
					],
				],
			],
			'the7_document_footer'        => [
				'args'     => [
					'label' => __( 'Footer settings', 'the7mk2' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				],
				'controls' => [
					'the7_document_show_footer_wa' => [
						'meta' => '_dt_footer_show',
						'args' => [
							'label'        => __( 'Hide Widgetized footer', 'the7mk2' ),
							'type'         => Controls_Manager::SWITCHER,
							'default'      => '1',
							'prefix_class' => 'elementor-',
							'label_on'     => 'Yes',
							'label_off'    => 'No',
							'return_value' => '0',
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
								'the7_document_show_footer_wa' => [ '1', '' ],
							],
						],
					],
				],
			],
			'the7_document_margins' => [
				'args'     => [
					'label' => __( 'Page Margins', 'the7mk2' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				],
				'controls' => [
					'the7_document_margin_top' => [
						'meta'    => '_dt_page_overrides_top_margin',
						'on_save' => [ $this, 'update_page_margin_post_meta' ],
						'on_read' => [ $this, 'get_page_margin_post_meta' ],
						'args'    => [
							'label'      => __( 'Top margin', 'the7mk2' ),
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
								'%' => [
									'min'  => 0,
									'max'  => 100,
									'step' => 1,
								],
							],
						],
					],
					'the7_document_margin_right' => [
						'meta'    => '_dt_page_overrides_right_margin',
						'on_save' => [ $this, 'update_page_margin_post_meta' ],
						'on_read' => [ $this, 'get_page_margin_post_meta' ],
						'args'    => [
							'label'      => __( 'Right margin', 'the7mk2' ),
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
								'%' => [
									'min'  => 0,
									'max'  => 100,
									'step' => 1,
								],
							],
						],
					],
					'the7_document_margin_bottom' => [
						'meta'    => '_dt_page_overrides_bottom_margin',
						'on_save' => [ $this, 'update_page_margin_post_meta' ],
						'on_read' => [ $this, 'get_page_margin_post_meta' ],
						'args'    => [
							'label'      => __( 'Bottom margin', 'the7mk2' ),
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
								'%' => [
									'min'  => 0,
									'max'  => 100,
									'step' => 1,
								],
							],
						],
					],
					'the7_document_margin_left' => [
						'meta'    => '_dt_page_overrides_left_margin',
						'on_save' => [ $this, 'update_page_margin_post_meta' ],
						'on_read' => [ $this, 'get_page_margin_post_meta' ],
						'args'    => [
							'label'      => __( 'Left margin', 'the7mk2' ),
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
								'%' => [
									'min'  => 0,
									'max'  => 100,
									'step' => 1,
								],
							],
						],
					],
				],
			],
		];
	}

}