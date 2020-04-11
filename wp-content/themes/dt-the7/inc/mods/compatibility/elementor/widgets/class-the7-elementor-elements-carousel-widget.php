<?php
/**
 * The7 elements scroller widget for Elementor.
 *
 * @package The7
 */

namespace The7\Adapters\Elementor\Widgets;

use Elementor\Plugin;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use The7_Query_Builder;
use The7\Adapters\Elementor\The7_Elementor_Widget_Base;
use The7\Adapters\Elementor\The7_Elementor_Less_Vars_Decorator_Interface;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Elements_Carousel_Widget extends The7_Elementor_Widget_Base {

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 */
	public function get_name() {
		return 'the7_elements_carousel';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'The7 Carousel', 'the7mk2' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	/**
	 * Get widget category.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'the7-elements' ];
	}

	public function get_script_depends() {
		if ( Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script(
				'the7-elements-carousel-widget-preview',
				PRESSCORE_ADMIN_URI . '/assets/js/elementor/elements-carousel-widget-preview.js',
				[],
				THE7_VERSION,
				true
			);

			return [ 'the7-elements-carousel-widget-preview' ];
		}

		return [];
	}

	public function get_style_depends() {
		the7_register_style( 'the7-elements-widget', PRESSCORE_THEME_URI . '/css/compatibility/elementor/the7-elements-widget' );

		return [ 'the7-elements-widget' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'   => __( 'Post type', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => 'post',
				'options' => the7_elementor_elements_widget_post_types(),
				'classes' => 'select2-medium-width',
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label'     => __( 'Select Taxonomy', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'category',
				'options'   => [],
				'classes'   => 'select2-medium-width',
				'condition' => [
					'post_type!' => '',
				],
			]
		);

		$this->add_control(
			'terms',
			[
				'label'     => __( 'Select Terms', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT2,
				'default'   => '',
				'multiple'  => true,
				'options'   => [],
				'classes'   => 'select2-medium-width',
				'condition' => [
					'taxonomy!' => '',
				],
			]
		);

		$this->add_control(
			'ordering_heading',
			[
				'label'     => __( 'Ordering', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => 'Ascending',
					'desc' => 'Descending',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order by', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => 'Date',
					'title'         => 'Name',
					'ID'            => 'ID',
					'modified'      => 'Modified',
					'comment_count' => 'Comment count',
					'menu_order'    => 'Menu order',
					'rand'          => 'Rand',
				],
			]
		);

		$this->add_control(
			'dis_posts_total',
			[
				'label' => __( 'Total number of posts', 'the7mk2' ),
				'description' => __(
					'Leave empty to use value from the WP Reading settings. Set "-1" to show all posts.',
					'the7mk2'
				),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'posts_offset',
			[
				'label'       => __( 'Posts offset', 'the7mk2' ),
				'description' => __(
					'Offset for posts query (i.e. 2 means, posts will be displayed starting from the third post).',
					'the7mk2'
				),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'min'         => 0,
			]
		);

		$this->add_control(
			'layout_settings',
			[
				'label'     => __( 'Layout Settings', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_layout',
			[
				'label'   => __( 'Layout', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => [
					'classic'           => 'Classic',
					'bottom_overlap'    => 'Bottom overlap (background)',
					'gradient_rollover' => 'Overlay (gradient)',
					'gradient_overlay'  => 'Overlay (background)',
					'gradient_overlap'  => 'Bottom overlap (gradient)',
				],
			]
		);

		$this->add_control(
			'bo_content_width',
			[
				'label'      => __( 'Content area width', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => '%',
					'size' => 75,
				],
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition'  => [
					'post_layout' => 'bottom_overlap',
				],
			]
		);

		$this->add_control(
			'bo_content_overlap',
			[
				'label'      => __( 'Content area overlap', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 100,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'condition'  => [
					'post_layout' => 'bottom_overlap',
				],
			]
		);

		$this->add_control(
			'go_animation',
			[
				'label'     => __( 'Animation', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'              => 'Fade',
					'direction_aware'   => 'Direction aware',
					'redirection_aware' => 'Reverse direction aware',
					'scale_in'          => 'Scale in',
				],
				'condition' => [
					'post_layout' => 'gradient_overlay',
				],
			]
		);

		$this->add_control(
			'post_content_alignment',
			[
				'label'   => __( 'Content alignment', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'   => 'Left',
					'center' => 'Center',
				],
			]
		);

		$this->add_control(
			'content_area',
			[
				'label'     => __( 'Content Area', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_bg',
			[
				'label'        => __( 'Show background', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_control(
			'custom_content_bg_color',
			[
				'label'     => __( 'Background color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'alpha'     => true,
				'condition' => [
					'content_bg' => 'y',
				],
			]
		);

		$this->add_control(
			'post_content_padding',
			[
				'label'      => __( 'Content area padding', 'the7mk2' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '25',
					'right'    => '30',
					'bottom'   => '30',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
			]
		);

		/**
		 * Images.
		 */
		$this->add_control(
			'image_settings',
			[
				'label'     => __( 'Image Settings', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_sizing',
			[
				'label'   => __( 'Image sizing', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'resize',
				'options' => [
					'proportional' => 'Preserve images proportions',
					'resize'       => 'Resize images',
				],
			]
		);

		$this->add_control(
			'resize_image_to_width',
			[
				'label'     => __( 'Width', 'the7mk2' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'condition' => [
					'image_sizing' => 'resize',
				],
			]
		);

		$this->add_control(
			'resize_image_to_height',
			[
				'label'     => __( 'Height', 'the7mk2' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'condition' => [
					'image_sizing' => 'resize',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Image border radius', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'image_decoration',
			[
				'label'   => __( 'Image decoration', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => 'None',
					'shadow' => 'Shadow',
				],
			]
		);

		$this->add_control(
			'shadow_h_length',
			[
				'label'      => __( 'Horizontal length', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					],
				],
				'condition'  => [
					'image_decoration' => 'shadow',
				],
			]
		);

		$this->add_control(
			'shadow_v_length',
			[
				'label'      => __( 'Vertical length', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 4,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					],
				],
				'condition'  => [
					'image_decoration' => 'shadow',
				],
			]
		);

		$this->add_control(
			'shadow_blur_radius',
			[
				'label'      => __( 'Blur radius', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 12,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					],
				],
				'condition'  => [
					'image_decoration' => 'shadow',
				],
			]
		);

		$this->add_control(
			'shadow_spread',
			[
				'label'      => __( 'Spread', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 3,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					],
				],
				'condition'  => [
					'image_decoration' => 'shadow',
				],
			]
		);

		$this->add_control(
			'shadow_color',
			[
				'label'     => __( 'Shadow color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => 'rgba(0,0,0,.25)',
				'condition' => [
					'image_decoration' => 'shadow',
				],
			]
		);

		$this->add_control(
			'image_padding',
			[
				'label'      => __( 'Image padding', 'the7mk2' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_control(
			'image_scale_animation_on_hover',
			[
				'label'   => __( 'Scale animation on hover', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'quick_scale',
				'options' => [
					'disabled'    => 'Disabled',
					'quick_scale' => 'Quick scale',
					'slow_scale'  => 'Slow scale',
				],
			]
		);

		$this->add_control(
			'image_hover_bg_color',
			[
				'label'   => __( 'Hover background color', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'disabled'          => 'Disabled',
					'default'           => 'Default',
					'solid_rollover_bg' => 'Mono color',
				],
			]
		);

		$this->add_control(
			'custom_rollover_bg_color',
			[
				'label'     => __( 'Background color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => 'rgba(0,0,0,0.5)',
				'condition' => [
					'image_hover_bg_color' => 'solid_rollover_bg',
				],
			]
		);

		/**
		 * Responsiveness.
		 */
		$this->add_control(
			'responsiveness_settings',
			[
				'label'     => __( 'Columns & Responsiveness', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wide_desk_columns',
			[
				'label'   => __( 'Columns on a wide desktop', 'the7mk2' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);

		$this->add_control(
			'desktop_columns',
			[
				'label'   => __( 'Columns on a desktop', 'the7mk2' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'laptop_columns',
			[
				'label'   => __( 'Columns on a laptop', 'the7mk2' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'tablet_h_columns',
			[
				'label'   => __( 'Columns on a horizontal tablet', 'the7mk2' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'tablet_v_columns',
			[
				'label'   => __( 'Columns on a vertical tablet', 'the7mk2' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
			]
		);

		$this->add_control(
			'phone_columns',
			[
				'label'   => __( 'Columns on a phone', 'the7mk2' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
			]
		);

		$this->add_control(
			'gap_between_posts',
			[
				'label'      => __( 'Gap between columns', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'stage_padding',
			[
				'label'      => __( 'Stage padding', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'adaptive_height',
			[
				'label'        => __( 'Adaptive height', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => '',
			]
		);

		$this->end_controls_section();

		/**
		 * Post section.
		 */
		$this->start_controls_section(
			'post_content_section',
			[
				'label' => __( 'Post', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_title_heading',
			[
				'label'     => __( 'Post title', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'post_title',
				'label'          => __( 'Typography', 'the7mk2' ),
				'selector'       => '{{WRAPPER}} .entry-title a',
				'fields_options' => [
					'font_family' => [
						'default' => '',
					],
					'font_size'   => [
						'default' => [
							'unit' => 'px',
							'size' => '',
						],
					],
					'font_weight' => [
						'default' => '',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'custom_title_color',
			[
				'label'     => __( 'Font color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .entry-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'post_title_bottom_margin',
			[
				'label'      => __( 'Gap below title', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 5,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'post_meta_heading',
			[
				'label'     => __( 'Meta Information', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_date',
			[
				'label'        => __( 'Show post date', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_control(
			'post_category',
			[
				'label'        => __( 'Show post category', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_control(
			'post_author',
			[
				'label'        => __( 'Show post author', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_control(
			'post_comments',
			[
				'label'        => __( 'Show post comments count', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'post_meta',
				'label'          => __( 'Typography', 'the7mk2' ),
				'fields_options' => [
					'font_family' => [
						'default' => '',
					],
					'font_size'   => [
						'default' => [
							'unit' => 'px',
							'size' => '',
						],
					],
					'font_weight' => [
						'default' => '',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '',
						],
					],
				],
				'selector'       => '{{WRAPPER}} .entry-meta > a, {{WRAPPER}} .entry-meta > span, {{WRAPPER}} .entry-meta span a',
			]
		);

		$this->add_control(
			'post_meta_font_color',
			[
				'label'     => __( 'Font color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .entry-meta > a, {{WRAPPER}} .entry-meta > span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .entry-meta > a:after, {{WRAPPER}} .entry-meta > span:after' => 'background: {{VALUE}}; -webkit-box-shadow: none; box-shadow: none;',
				],
			]
		);

		$this->add_control(
			'post_meta_bottom_margin',
			[
				'label'      => __( 'Gap below meta info', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .entry-meta' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_text_heading',
			[
				'label'     => __( 'Text', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_content',
			[
				'label'   => __( 'Excerpt', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'show_excerpt',
				'options' => [
					'off'          => 'Hide',
					'show_excerpt' => 'Show',
				],
			]
		);

		$this->add_control(
			'excerpt_words_limit',
			[
				'label'       => __( 'Maximum number of words', 'the7mk2' ),
				'description' => __( 'Leave empty to show full text.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'post_content' => 'show_excerpt',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'post_content',
				'label'          => __( 'Typography', 'the7mk2' ),
				'fields_options' => [
					'font_family' => [
						'default' => '',
					],
					'font_size'   => [
						'default' => [
							'unit' => 'px',
							'size' => '',
						],
					],
					'font_weight' => [
						'default' => '',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '',
						],
					],
				],
				'selector'       => '{{WRAPPER}} .entry-excerpt *',
				'condition'      => [
					'post_content!' => 'off',
				],
			]
		);

		$this->add_control(
			'post_content_color',
			[
				'label'     => __( 'Font color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .entry-excerpt' => 'color: {{VALUE}}',
				],
				'condition' => [
					'post_content!' => 'off',
				],
			]
		);

		$this->add_control(
			'post_content_bottom_margin',
			[
				'label'      => __( 'Gap below text', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 5,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .entry-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'post_content!' => 'off',
				],
			]
		);

		$this->add_control(
			'read_more_button_heading',
			[
				'label'     => __( 'Button', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'read_more_button',
			[
				'label'   => __( 'Button style', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default_button',
				'options' => [
					'off'            => 'Off',
					'default_link'   => 'Default link',
					'default_button' => 'Default button',
				],
			]
		);

		$this->add_control(
			'read_more_button_text',
			[
				'label'     => __( 'Button text', 'the7mk2' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Read more', 'the7mk2' ),
				'condition' => [
					'read_more_button' => [ 'default_link', 'default_button' ],
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Icon section.
		 */
		$this->start_controls_section(
			'icon_section',
			[
				'label' => __( 'Icon', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_details',
			[
				'label'        => __( 'Show icon', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_control(
			'project_link_icon',
			[
				'label'     => __( 'Choose project page link icon', 'the7mk2' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
				],
				'condition' => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'icon_settings',
			[
				'label'     => __( 'Icon Size & Background', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_size',
			[
				'label'      => __( 'Icon size', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .project-links-container a > span:before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_bg_size',
			[
				'label'      => __( 'Background size', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 44,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .project-links-container a > span:before' => 'line-height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .project-links-container a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_border_width',
			[
				'label'      => __( 'Border width', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 25,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .project-links-container a.icon-with-border:before' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .project-links-container a.icon-with-hover-border:after' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .project-links-container a.icon-without-border:before' => 'border-width: 0; padding: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .project-links-container a.icon-without-hover-border:after' => 'border-width: 0; padding: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_border_radius',
			[
				'label'      => __( 'Border radius', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 100,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .project-links-container a' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_below_gap',
			[
				'label'      => __( 'Gap below icons', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .project-links-container a' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_above_gap',
			[
				'label'      => __( 'Gap above icons', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .project-links-container a' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'icons_colors',
			[
				'label'     => __( 'Normal', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_color',
			[
				'label'       => __( 'Icon color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .project-links-container a > span' => 'color: {{VALUE}}',
				],
				'condition'   => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
		    'show_project_icon_border',
		    [
		        'label' => __( 'Show icon border', 'the7mk2' ),
		        'type' => Controls_Manager::SWITCHER,
		        'return_value' => 'y',
		        'default' => 'y',
				'condition'   => [
					'show_details' => 'y',
				],
		    ]
		);

		$this->add_control(
			'project_icon_border_color',
			[
				'label'       => __( 'Icon border color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .project-links-container a:before' => 'border-color: {{VALUE}}',
				],
				'condition'   => [
					'show_project_icon_border' => 'y',
					'show_details'             => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_bg',
			[
				'label'        => __( 'Show icon background', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_bg_color',
			[
				'label'     => __( 'Icon background color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => 'rgba(255,255,255,0.3)',
				'selectors' => [
					'{{WRAPPER}} .dt-icon-bg-on .project-links-container a:before' => 'background: {{VALUE}}; -webkit-box-shadow: none; box-shadow: none;',
				],
				'condition' => [
					'project_icon_bg' => 'y',
					'show_details'    => 'y',
				],
			]
		);

		$this->add_control(
			'icons_hover_colors',
			[
				'label'     => __( 'Hover', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_details' => 'y',
				],
			]
		);

		$this->add_control(
			'enable_project_icon_hover',
			[
				'label'        => __( 'Enable icon hover', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_control(
			'project_icon_color_hover',
			[
				'label'       => __( 'Icon color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .project-links-container a:hover > span' => 'color: {{VALUE}}',
				],
				'condition'   => [
					'enable_project_icon_hover' => 'y',
					'show_details'              => 'y',
				],
			]
		);

		$this->add_control(
			'show_project_icon_hover_border',
			[
				'label'        => __( 'Show icon border', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
					'enable_project_icon_hover' => 'y',
					'show_details'              => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_border_color_hover',
			[
				'label'       => __( 'Icon border color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .project-links-container a:after' => 'border-color: {{VALUE}}',
				],
				'condition'   => [
					'enable_project_icon_hover'      => 'y',
					'show_project_icon_hover_border' => 'y',
					'show_details'                   => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_bg_hover',
			[
				'label'        => __( 'Show icon background', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
					'enable_project_icon_hover' => 'y',
					'show_details'              => 'y',
				],
			]
		);

		$this->add_control(
			'project_icon_bg_color_hover',
			[
				'label'     => __( 'Icon background color', 'the7mk2' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => 'rgba(255,255,255,0.3)',
				'selectors' => [
					'{{WRAPPER}} .dt-icon-hover-bg-on .project-links-container a:after' => 'background: {{VALUE}}; -webkit-box-shadow: none; box-shadow: none;',
				],
				'condition' => [
					'enable_project_icon_hover' => 'y',
					'project_icon_bg_hover'     => 'y',
					'show_details'              => 'y',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Arrows section.
		 */
		$this->start_controls_section(
			'arrows_section',
			[
				'label' => __( 'Arrows', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'arrows',
			[
				'label'        => __( 'Show arrows', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
			]
		);

		$this->add_control(
			'arrows_heading',
			[
				'label'     => __( 'Arrow Icon', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'next_icon',
			[
				'label'     => __( 'Choose next arrow icon', 'the7mk2' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'icomoon-the7-font-the7-arrow-09',
					'library' => 'the7-icons',
				],
				'classes'   => [ 'elementor-control-icons-svg-uploader-hidden' ],
				'condition' => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'prev_icon',
			[
				'label'     => __( 'Choose previous arrow icon', 'the7mk2' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'icomoon-the7-font-the7-arrow-08',
					'library' => 'the7-icons',
				],
				'classes'   => [ 'elementor-control-icons-svg-uploader-hidden' ],
				'condition' => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_icon_size',
			[
				'label'      => __( 'Arrow icon size', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition'  => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrows_background_heading',
			[
				'label'     => __( 'Arrow Background', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_bg_width',
			[
				'label'      => __( 'Width', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 36,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition'  => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_bg_height',
			[
				'label'      => __( 'Height', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 36,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition'  => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_border_radius',
			[
				'label'      => __( 'Arrow border radius', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 500,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'condition'  => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_border_width',
			[
				'label'      => __( 'Arrow border width', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 25,
						'step' => 1,
					],
				],
				'condition'  => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrows_color_heading',
			[
				'label'     => __( 'Color Setting', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_icon_color',
			[
				'label'       => __( 'Arrow icon color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '#ffffff',
				'condition'   => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_icon_border',
			[
				'label'        => __( 'Show arrow border color', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_border_color',
			[
				'label'       => __( 'Arrow border color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition'   => [
					'arrow_icon_border' => 'y',
					'arrows'            => 'y',
				],
			]
		);

		$this->add_control(
			'arrows_bg_show',
			[
				'label'        => __( 'Show arrow background', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_bg_color',
			[
				'label'       => __( 'Arrow background color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition'   => [
					'arrows_bg_show' => 'y',
					'arrows'         => 'y',
				],
			]
		);

		$this->add_control(
			'arrows_hover_color_heading',
			[
				'label'     => __( 'Hover Color Setting', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_icon_color_hover',
			[
				'label'       => __( 'Arrow icon color hover', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => 'rgba(255,255,255,0.75)',
				'condition'   => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_icon_border_hover',
			[
				'label'        => __( 'Show arrow border color hover', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_border_color_hover',
			[
				'label'       => __( 'Arrow border color hover', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition'   => [
					'arrow_icon_border_hover' => 'y',
					'arrows'                  => 'y',
				],
			]
		);

		$this->add_control(
			'arrows_bg_hover_show',
			[
				'label'        => __( 'Show arrow background hover', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
					'arrows' => 'y',
				],
			]
		);

		$this->add_control(
			'arrow_bg_color_hover',
			[
				'label'       => __( 'Arrow background hover color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition'   => [
					'arrows_bg_hover_show' => 'y',
					'arrows'               => 'y',
				],
			]
		);
		
		$this->add_control(
		    'right_arrow_position_heading',
		    [
		        'label' => __( 'Right Arrow Position', 'the7mk2' ),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'r_arrow_icon_paddings',
		    [
		        'label'      => __( 'Icon paddings', 'the7mk2' ),
		        'type'       => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px' ],
		        'default'    => [
		            'top'      => '0',
		            'right'    => '0',
		            'bottom'   => '0',
		            'left'     => '0',
		            'unit'     => 'px',
		            'isLinked' => true,
		        ],
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'r_arrow_v_position',
		    [
		        'label'   => __( 'Vertical position', 'the7mk2' ),
		        'type'    => Controls_Manager::SELECT,
		        'default' => 'center',
		        'options' => [
					'top' => 'Top',
					'center' => 'Center',
					 'bottom' => 'Bottom',
		        ],
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'r_arrow_h_position',
		    [
		        'label'   => __( 'Horizontal position', 'the7mk2' ),
		        'type'    => Controls_Manager::SELECT,
		        'default' => 'right',
		        'options' => [
					"left" => "Left",
					"center" => "Center",
					"right" => "Right",
		        ],
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'r_arrow_v_offset',
		    [
		        'label' => __( 'Vertical offset', 'the7mk2' ),
		        'type' => Controls_Manager::SLIDER,
		        'default'    => [
		            'unit' => 'px',
		            'size' => 0,
		        ],
		        'size_units' => [ 'px' ],
		        'range'      => [
		            'px' => [
		                'min'  => -10000,
		                'max'  => 10000,
		                'step' => 1,
		            ],
		        ],
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'r_arrow_h_offset',
		    [
		        'label' => __( 'Horizontal offset', 'the7mk2' ),
		        'type' => Controls_Manager::SLIDER,
		        'default'    => [
		            'unit' => 'px',
		            'size' => -43,
		        ],
		        'size_units' => [ 'px' ],
		        'range'      => [
		            'px' => [
		                'min'  => -10000,
		                'max'  => 10000,
		                'step' => 1,
		            ],
		        ],
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'left_arrow_position_heading',
		    [
		        'label' => __( 'Left Arrow Position', 'the7mk2' ),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'l_arrow_icon_paddings',
		    [
		        'label'      => __( 'Icon paddings', 'the7mk2' ),
		        'type'       => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px' ],
		        'default'    => [
		            'top'      => '0',
		            'right'    => '0',
		            'bottom'   => '0',
		            'left'     => '0',
		            'unit'     => 'px',
		            'isLinked' => true,
		        ],
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
			'l_arrow_v_position',
			[
				'label'   => __( 'Vertical position', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'top' => 'Top',
					'center' => 'Center',
					'bottom' => 'Bottom',
				],
				'condition'   => [
					'arrows'               => 'y',
				],
			]
		);

		$this->add_control(
			'l_arrow_h_position',
			[
				'label'   => __( 'Horizontal position', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					"left" => "Left",
					"center" => "Center",
					"right" => "Right",
				],
				'condition'   => [
					'arrows'               => 'y',
				],
			]
		);

		$this->add_control(
			'l_arrow_v_offset',
			[
				'label' => __( 'Vertical offset', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -10000,
						'max'  => 10000,
						'step' => 1,
					],
				],
				'condition'   => [
					'arrows'               => 'y',
				],
			]
		);

		$this->add_control(
			'l_arrow_h_offset',
			[
				'label' => __( 'Horizontal offset', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => -43,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -10000,
						'max'  => 10000,
						'step' => 1,
					],
				],
				'condition'   => [
					'arrows'               => 'y',
				],
			]
		);

		$this->add_control(
		    'arrows_responsiveness_heading',
		    [
		        'label' => __( 'Arrows responsiveness', 'the7mk2' ),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'arrow_responsiveness',
		    [
		        'label'   => __( 'Responsive behaviour', 'the7mk2' ),
		        'type'    => Controls_Manager::SELECT,
		        'default' => 'reposition-arrows',
		        'options' => [
					 'reposition-arrows' => 'Reposition arrows',
					 'no-changes' => 'Leave as is',
					 'hide-arrows' => 'Hide arrows',
		        ],
				'condition'   => [
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'hide_arrows_mobile_switch_width',
		    [
		        'label' => __( 'Hide arrows if browser width is less then', 'the7mk2' ),
		        'type' => Controls_Manager::NUMBER,
		        'default' => 778,
				'condition'   => [
					'arrow_responsiveness' => 'hide-arrows',
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'reposition_arrows_mobile_switch_width',
		    [
		        'label' => __( 'Reposition arrows if browser width is less then', 'the7mk2' ),
		        'type' => Controls_Manager::NUMBER,
		        'default' => 778,
				'condition'   => [
					'arrow_responsiveness' => 'reposition-arrows',
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'l_arrows_mobile_h_position',
		    [
		        'label' => __( 'Left arrow horizontal offset', 'the7mk2' ),
		        'type' => Controls_Manager::SLIDER,
		        'default'    => [
		            'unit' => 'px',
		            'size' => 10,
		        ],
		        'size_units' => [ 'px' ],
		        'range'      => [
		            'px' => [
		                'min'  => -10000,
		                'max'  => 10000,
		                'step' => 1,
		            ],
		        ],
				'condition'   => [
					'arrow_responsiveness' => 'reposition-arrows',
					'arrows'               => 'y',
				],
		    ]
		);

		$this->add_control(
		    'r_arrows_mobile_h_position',
		    [
		        'label' => __( 'Right arrow horizontal offset', 'the7mk2' ),
		        'type' => Controls_Manager::SLIDER,
		        'default'    => [
		            'unit' => 'px',
		            'size' => 10,
		        ],
		        'size_units' => [ 'px' ],
		        'range'      => [
		            'px' => [
		                'min'  => -10000,
		                'max'  => 10000,
		                'step' => 1,
		            ],
		        ],
				'condition'   => [
					'arrow_responsiveness' => 'reposition-arrows',
					'arrows'               => 'y',
				],
		    ]
		);




		$this->end_controls_section();

		// Scolling.

		$this->start_controls_section(
			'scrolling_section',
			[
				'label' => __( 'Scrolling', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slide_to_scroll',
			[
				'label'   => __( 'Scroll mode', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'single',
				'options' => [
					'single' => 'One slide at a time',
					'all'    => 'All slides',
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => __( 'Transition speed', 'the7mk2' ),
				'description' => __( '(milliseconds)', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '600',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => __( 'Autoplay slides', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => '',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'       => __( 'Autoplay speed', 'the7mk2' ),
				'description' => __( '(milliseconds)', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 6000,
				'min'         => 100,
				'max'         => 10000,
				'step'        => 10,
				'condition'   => [
					'autoplay' => 'y',
				],
			]
		);

		$this->end_controls_section();

		// Bullets.

		$this->start_controls_section(
			'bullets_section',
			[
				'label' => __( 'Bullets', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_bullets',
			[
				'label'        => __( 'Show bullets', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => '',
			]
		);

		$this->add_control(
			'bullets_Style_heading',
			[
				'label'     => __( 'Bullets Style, Size & Color', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullets_style',
			[
				'label'     => __( 'Choose bullets style', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'small-dot-stroke',
				'options'   => [
					'small-dot-stroke' => 'SMALL DOT STROKE',
					'scale-up'         => 'SCALE UP',
					'stroke'           => 'STROKE',
					'fill-in'          => 'FILL IN',
					'ubax'             => 'SQUARE',
					'etefu'            => 'RECTANGULAR',
				],
				'condition' => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullet_size',
			[
				'label'      => __( 'Bullets size', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition'  => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullet_gap',
			[
				'label'      => __( 'Gap between bullets', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'condition'  => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullet_color',
			[
				'label'       => __( 'Bullets color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition'   => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullet_color_hover',
			[
				'label'       => __( 'Bullets hover color', 'the7mk2' ),
				'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition'   => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullets_position_heading',
			[
				'label'     => __( 'Bullets Position', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullets_v_position',
			[
				'label'     => __( 'Vertical position', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom',
				'options'   => [
					'bottom' => 'Bottom',
					'top'    => 'Top',
					'center' => 'Center',
				],
				'condition' => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullets_h_position',
			[
				'label'     => __( 'Horizontal position', 'the7mk2' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => [
					'center' => 'Center',
					'right'  => 'Right',
					'left'   => 'Left',
				],
				'condition' => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullets_v_offset',
			[
				'label'      => __( 'Vertical offset', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 20,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -10000,
						'max'  => 10000,
						'step' => 1,
					],
				],
				'condition'  => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->add_control(
			'bullets_h_offset',
			[
				'label'      => __( 'Horizontal offset', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -10000,
						'max'  => 10000,
						'step' => 1,
					],
				],
				'condition'  => [
					'show_bullets' => 'y',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget.
	 */
	protected function render() {
		$has_img_preload_me_filter = has_filter( 'dt_get_thumb_img-args', 'presscore_add_preload_me_class_to_images' );
		remove_filter( 'dt_get_thumb_img-args', 'presscore_add_preload_me_class_to_images' );

		$settings = $this->get_settings_for_display();

		$this->print_inline_css();

		// Loop query.
		$query_args = [
			'posts_offset'   => $settings['posts_offset'],
			'post_type'      => $settings['post_type'],
			'order'          => $settings['order'],
			'orderby'        => $settings['orderby'],
			'posts_per_page' => $settings['dis_posts_total'],
		];

		$query_builder = ( new The7_Query_Builder( $query_args ) )->from_terms( $settings['taxonomy'], $settings['terms'] );
		$query = $query_builder->query();

		echo '<div ' . $this->container_class( [ 'owl-carousel', 'portfolio-carousel-shortcode', 'dt-owl-carousel-call' ] ) . $this->get_container_data_atts() . '>';

		$is_overlay_post_layout = in_array( $settings['post_layout'], [ 'gradient_rollover', 'gradient_overlay' ], true );

		$icons_html_tpl = '';
		if ( $settings['show_details'] ) {
			ob_start();
			Icons_Manager::render_icon( $settings['project_link_icon'], [ 'aria-hidden' => 'true' ], 'span' );
			$details_icon = ob_get_clean();
			$details_icon_class = [ 'project-details' ];
			$details_icon_class[] = $settings['show_project_icon_border'] ? 'icon-with-border' : 'icon-without-border';
			$details_icon_class[] = $settings['show_project_icon_hover_border'] ? 'icon-with-hover-border' : 'icon-without-hover-border';
			$icons_html_tpl = sprintf(
				'<a href="#FOLLOW_LINK#" class="%s" aria-label="%s">%s</a>',
				esc_attr( implode( ' ', $details_icon_class ) ),
				__( 'Details link', 'the7mk2' ),
				$details_icon
			);
		}

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$follow_link        = get_the_permalink();
				$has_post_thumbnail = has_post_thumbnail();

				$icons_html = str_replace( '#FOLLOW_LINK#', $follow_link, $icons_html_tpl );

				$post_class_array = array(
					'post',
					'visible',
				);

				if ( ! $has_post_thumbnail ) {
					$post_class_array[] = 'no-img';
				}

				if ( ! $icons_html && $is_overlay_post_layout ) {
					$post_class_array[] = 'forward-post';
				}

				echo '<article class="' . esc_attr( implode( ' ', get_post_class( $post_class_array ) ) ) . '">';

				$post_media = '';
				$target     = '';

				if ( $has_post_thumbnail ) {
					$thumb_args = [
						'img_id' => get_post_thumbnail_id(),
						'class'  => 'post-thumbnail-rollover',
						'href'   => $follow_link,
						'custom' => ' aria-label="' . esc_attr__( 'Post image', 'the7mk2' ) . '"',
						'wrap'   => '<a %HREF% %CLASS% target="' . $target . '" %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %IMG_TITLE% %SIZE% /></a>',
						'echo'   => false,
					];

					$thumb_args['img_class'] = 'preload-me';

					if ( $settings['image_sizing'] === 'resize' ) {
						$thumb_args['prop'] = the7_get_image_proportion(
							$settings['resize_image_to_width'],
							$settings['resize_image_to_height']
						);
					}

					$thumb_args['options'] = the7_calculate_bwb_image_resize_options(
						[
							'desktop'  => $settings['desktop_columns'],
							'v_tablet' => $settings['tablet_v_columns'],
							'h_tablet' => $settings['tablet_h_columns'],
							'phone'    => $settings['phone_columns'],
						],
						$settings['gap_between_posts']['size'],
						false
					);

					$thumb_args['lazy_loading'] = presscore_lazy_loading_enabled();

					$post_media = dt_get_thumb_img( $thumb_args );
				} elseif ( $is_overlay_post_layout ) {
					$image      = sprintf(
						'<img class="%s" src="%s" width="%s" height="%s">',
						'preload-me',
						get_template_directory_uri() . '/images/gray-square.svg',
						1500,
						1500
					);
					$post_media = sprintf(
						'<a class="%s" href="%s" aria-label="%s">%s</a>',
						'post-thumbnail-rollover',
						$follow_link,
						esc_attr__( 'Post image', 'the7mk2' ),
						$image
					);
				}

				$details_btn = '';
				if ( $settings['read_more_button'] !== 'off' ) {
					$details_btn_class = [];
					if ( 'default_button' === $settings['read_more_button'] ) {
						$details_btn_class = [ 'dt-btn-s', 'dt-btn' ];
					}

					$details_btn = $this->get_details_btn(
						$settings['read_more_button'],
						$target,
						$settings['read_more_button_text'],
						$follow_link,
						$details_btn_class
					);
				}

				$post_meta = [
					'terms'    => $settings['post_category'],
					'author'   => $settings['post_author'],
					'date'     => $settings['post_date'],
					'comments' => $settings['post_comments'],
				];

				presscore_get_template_part(
					'elementor',
					'the7-elements/tpl-layout',
					$settings['post_layout'],
					array(
						'post_media'   => $post_media,
						'post_meta'    => $this->get_post_meta( $post_meta ),
						'details_btn'  => $details_btn,
						'post_excerpt' => $this->get_post_excerpt(),
						'icons_html'   => $icons_html,
						'follow_link'  => $follow_link,
					)
				);

				echo '</article>';
			}
		}

		wp_reset_postdata();

		echo '</div>';

		$has_img_preload_me_filter && add_filter( 'dt_get_thumb_img-args', 'presscore_add_preload_me_class_to_images', 15 );
	}

	public function get_details_btn( $btn_style = 'default', $target = '', $btn_text = '', $btn_link = '', $class = array() ) {
		if ( ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		$class[] = 'post-details';

		$btn_classes = array(
			'default_link'   => 'details-type-link',
			'default_button' => 'details-type-btn',
		);

		if ( isset( $btn_classes[ $btn_style ] ) ) {
			$class[] = $btn_classes[ $btn_style ];
		}

		$btn_text    .= '<i class="dt-icon-the7-arrow-03" aria-hidden="true"></i>';
		$return_class = implode( ' ', $class );

		return '<a class=" ' . $return_class . ' " href=" ' . $btn_link . ' " target="' . $target . '">' . $btn_text . '</a>';
	}

	/**
	 * Return post excerpt with $length words.
	 *
	 * @return mixed
	 */
	protected function get_post_excerpt() {
		global $post;

		$settings = $this->get_settings_for_display();

		if ( 'off' === $settings['post_content'] ) {
			return '';
		}

		$post_back = $post;

		$excerpt = get_the_excerpt();

		if ( $settings['excerpt_words_limit'] ) {
			$excerpt = wp_trim_words( $excerpt, absint( $settings['excerpt_words_limit'] ) );
		}

		$excerpt = apply_filters( 'the_excerpt', $excerpt );

		// Restore original post in case some shortcode in the content will change it globally.
		$post = $post_back;

		return $excerpt;
	}

	protected function get_post_meta( $required_meta = [] ) {
		$defaults      = [
			'terms'    => false,
			'author'   => false,
			'date'     => false,
			'comments' => false,
		];
		$required_meta = wp_parse_args( $required_meta, $defaults );

		$parts = [];
		if ( $required_meta['terms'] ) {
			$parts['terms'] = presscore_get_post_categories();
			if ( $parts['terms'] ) {
				$parts['terms'] = '<span class="category-link">' . $parts['terms'] . '</span>';
			}
		}

		if ( $required_meta['author'] ) {
			$parts['author'] = presscore_get_post_author();
		}

		if ( $required_meta['date'] ) {
			$parts['date'] = presscore_get_post_data();
		}

		if ( $required_meta['comments'] ) {
			$parts['comments'] = presscore_get_post_comments();
		}

		// TODO: Why it even here?
		$class = apply_filters( 'presscore_posted_on_wrap_class', [ 'entry-meta' ] );

		$html = '';
		if ( $parts ) {
			$html = '<div class="' . presscore_esc_implode( ' ', $class ) . '">' . implode( '', $parts ) . '</div>';
		}

		return apply_filters( 'presscore_posted_on_html', $html, $class );
	}

	/**
	 * Return container class attribute.
	 *
	 * @param array $class
	 *
	 * @return string
	 */
	protected function container_class( $class = [] ) {
		$class[] = 'portfolio-shortcode';

		// Unique class.
		$class[] = $this->get_unique_class();

		$settings = $this->get_settings_for_display();

		if ( $settings['content_bg'] ) {
			$class[] = 'content-bg-on';
		}

		if ( 'center' === $settings['post_content_alignment'] ) {
			$class[] = 'content-align-center';
		}

		if ( ! $settings['enable_project_icon_hover'] ) {
			$class[] = 'dt-icon-hover-off';
		}

		if ( $settings['project_icon_bg'] === 'y' ) {
			$class[] = 'dt-icon-bg-on';
		} else {
			$class[] = 'dt-icon-bg-off';
		};

		if ( $settings['project_icon_bg_hover'] === 'y' ) {
			$class[] = 'dt-icon-hover-bg-on';
		} else {
			$class[] = 'dt-icon-hover-bg-off';
		}

		if ( $settings['project_icon_bg_color'] === $settings['project_icon_bg_color_hover'] ) {
			$class[] = 'disable-icon-hover-bg';
		}

		if ( $settings['image_scale_animation_on_hover'] === 'quick_scale' ) {
			$class[] = 'quick-scale-img';
		} elseif ( $settings['image_scale_animation_on_hover'] === 'slow_scale' ) {
			$class[] = 'scale-img';
		}

		if ( ! $settings['post_date'] && ! $settings['post_category'] && ! $settings['post_comments'] && ! $settings['post_author'] ) {
			$class[] = 'meta-info-off';
		}

		if ( 'disabled' !== $settings['image_hover_bg_color'] ) {
			$class[] = 'enable-bg-rollover';
		}

		if ( 'shadow' === $settings['image_decoration'] ) {
			$class[] = 'enable-img-shadow';
		}

		$layout = $settings['post_layout'];

		$class[] = presscore_array_value(
			$layout,
			[
				'classic'           => 'classic-layout-list',
				'bottom_overlap'    => 'bottom-overlap-layout-list',
				'gradient_overlap'  => 'gradient-overlap-layout-list',
				'gradient_overlay'  => 'gradient-overlay-layout-list',
				'gradient_rollover' => 'content-rollover-layout-list',
			]
		);

		if ( in_array( $layout, [ 'gradient_overlay', 'gradient_rollover' ], true ) ) {
			$class[] = 'description-on-hover';
		} else {
			$class[] = 'description-under-image';
		}

		if ( in_array( $layout, [ 'gradient_overlay', 'gradient_rollover' ] ) && 'off' === $settings['post_content'] && 'off' === $settings['read_more_button'] ) {
			$class[] = 'disable-layout-hover';
		}

		if ( 'gradient_overlay' === $layout ) {
			$class[] = presscore_tpl_get_hover_anim_class( $settings['go_animation'] );
		}

		$class[] = presscore_array_value(
			$settings['bullets_style'],
			[
				'scale-up'         => 'bullets-scale-up',
				'stroke'           => 'bullets-stroke',
				'fill-in'          => 'bullets-fill-in',
				'small-dot-stroke' => 'bullets-small-dot-stroke',
				'ubax'             => 'bullets-ubax',
				'etefu'            => 'bullets-etefu',
			]
		);
		$class[] = sanitize_key( $settings['arrow_responsiveness'] );

		$class[] = $settings['arrows_bg_show'] === 'y' ? 'arrows-bg-on' : 'arrows-bg-off';
		$class[] = $settings['arrows_bg_hover_show'] === 'y' ? 'arrows-hover-bg-on' : 'arrows-hover-bg-off';

		if ( $settings['arrow_bg_color'] === $settings['arrow_bg_color_hover'] ) {
			$class[] = 'disable-arrows-hover-bg';
		}

		if ( $settings['arrow_icon_border'] === 'y' ) {
			$class[] = 'dt-arrow-border-on';
		}

		if ( $settings['arrow_icon_border_hover'] === 'y' ) {
			$class[] = 'dt-arrow-hover-border-on';
		}

		return sprintf( ' class="%s" ', esc_attr( implode( ' ', $class ) ) );
	}

	protected function get_container_data_atts() {
		$settings = $this->get_settings_for_display();

		$data_atts = [
			'scroll-mode'          => $settings['slide_to_scroll'] === 'all' ? 'page' : '1',
			'col-num'              => $settings['desktop_columns'],
			'wide-col-num'         => $settings['wide_desk_columns'],
			'laptop-col'           => $settings['laptop_columns'],
			'h-tablet-columns-num' => $settings['tablet_h_columns'],
			'v-tablet-columns-num' => $settings['tablet_v_columns'],
			'phone-columns-num'    => $settings['phone_columns'],
			'auto-height'          => $settings['adaptive_height'] ? 'true' : 'false',
			'col-gap'              => $settings['gap_between_posts']['size'],
			'stage-padding'        => $settings['stage_padding']['size'],
			'speed'                => $settings['speed'],
			'autoplay'             => $settings['autoplay'] ? 'true' : 'false',
			'autoplay_speed'       => $settings['autoplay_speed'],
			'arrows'               => $settings['arrows'] ? 'true' : 'false',
			'bullet'               => $settings['show_bullets'] ? 'true' : 'false',
			'next-icon'            => $settings['next_icon']['value'],
			'prev-icon'            => $settings['prev_icon']['value'],
			'img-shadow-size'      => $settings['shadow_blur_radius'],
			'img-shadow-spread'    => $settings['shadow_spread'],
		];

		return ' ' . presscore_get_inlide_data_attr( $data_atts );
	}

	/**
	 * Return shortcode less file absolute path to output inline.
	 *
	 * @return string
	 */
	protected function get_less_file_name() {
		return PRESSCORE_THEME_DIR . '/css/dynamic-less/elementor/the7-elements-carousel-widget.less';
	}

	/**
	 * Return less imports.
	 *
	 * @return array
	 */
	protected function get_less_imports() {
		$settings           = $this->get_settings_for_display();
		$dynamic_import_top = array();

		switch ( $settings['post_layout'] ) {
			case 'bottom_overlap':
				$dynamic_import_top[] = 'post-layouts/bottom-overlap-layout.less';
				break;
			case 'gradient_overlap':
				$dynamic_import_top[] = 'post-layouts/gradient-overlap-layout.less';
				break;
			case 'gradient_overlay':
				$dynamic_import_top[] = 'post-layouts/gradient-overlay-layout.less';
				break;
			case 'gradient_rollover':
				$dynamic_import_top[] = 'post-layouts/content-rollover-layout.less';
				break;
			case 'classic':
			default:
				$dynamic_import_top[] = 'post-layouts/classic-layout.less';
		}

		$dynamic_import_bottom = array();

		return compact( 'dynamic_import_top', 'dynamic_import_bottom' );
	}

	/**
	 * Specify a vars to be inserted in to a less file.
	 */
	protected function less_vars( The7_Elementor_Less_Vars_Decorator_Interface $less_vars ) {
		// For project icon style, see `selectors` in settings declaration.

		$settings = $this->get_settings_for_display();

		$less_vars->add_keyword(
			'unique-shortcode-class-name',
			$this->get_unique_class() . '.portfolio-shortcode',
			'~"%s"'
		);

		$less_vars->add_keyword( 'post-layout', $settings['post_layout'] );

		// Carousel arrows.
		$less_vars->add_pixel_number( 'icon-size', $settings['arrow_icon_size'] );
		$less_vars->add_paddings(
			[
				'l-icon-padding-top',
				'l-icon-padding-right',
				'l-icon-padding-bottom',
				'l-icon-padding-left',
			],
			$settings['l_arrow_icon_paddings']
		);
		$less_vars->add_paddings(
			[
				'r-icon-padding-top',
				'r-icon-padding-right',
				'r-icon-padding-bottom',
				'r-icon-padding-left',
			],
			$settings['r_arrow_icon_paddings']
		);
		$less_vars->add_pixel_number( 'arrow-width', $settings['arrow_bg_width'] );
		$less_vars->add_pixel_number( 'arrow-height', $settings['arrow_bg_height'] );
		$less_vars->add_pixel_number( 'arrow-border-radius', $settings['arrow_border_radius'] );
		$less_vars->add_pixel_number( 'arrow-border-width', $settings['arrow_border_width'] );

		$less_vars->add_keyword( 'icon-color', $settings['arrow_icon_color'] );
		$less_vars->add_keyword( 'arrow-border-color', $settings['arrow_border_color'] );
		$less_vars->add_keyword( 'arrow-bg', $settings['arrow_bg_color'] );
		$less_vars->add_keyword( 'icon-color-hover', $settings['arrow_icon_color_hover'] );
		$less_vars->add_keyword( 'arrow-border-color-hover', $settings['arrow_border_color_hover'] );
		$less_vars->add_keyword( 'arrow-bg-hover', $settings['arrow_bg_color_hover'] );

		$less_vars->add_keyword( 'arrow-right-v-position', $settings['r_arrow_v_position'] );
		$less_vars->add_keyword( 'arrow-right-h-position', $settings['r_arrow_h_position'] );
		$less_vars->add_pixel_number( 'r-arrow-v-position', $settings['r_arrow_v_offset'] );
		$less_vars->add_pixel_number( 'r-arrow-h-position', $settings['r_arrow_h_offset'] );

		$less_vars->add_keyword( 'arrow-left-v-position', $settings['l_arrow_v_position'] );
		$less_vars->add_keyword( 'arrow-left-h-position', $settings['l_arrow_h_position'] );
		$less_vars->add_pixel_number( 'l-arrow-v-position', $settings['l_arrow_v_offset'] );
		$less_vars->add_pixel_number( 'l-arrow-h-position', $settings['l_arrow_h_offset'] );
		$less_vars->add_pixel_number( 'hide-arrows-switch', $settings['hide_arrows_mobile_switch_width'] );
		$less_vars->add_pixel_number( 'reposition-arrows-switch', $settings['reposition_arrows_mobile_switch_width'] );
		$less_vars->add_pixel_number( 'arrow-left-h-position-mobile', $settings['l_arrows_mobile_h_position'] );
		$less_vars->add_pixel_number( 'arrow-right-h-position-mobile', $settings['r_arrows_mobile_h_position'] );

		$less_vars->add_pixel_number( 'bullet-size', $settings['bullet_size'] );
		$less_vars->add_keyword( 'bullet-color', $settings['bullet_color'] );
		$less_vars->add_keyword( 'bullet-color-hover', $settings['bullet_color_hover'] );
		$less_vars->add_pixel_number( 'bullet-gap', $settings['bullet_gap'] );
		$less_vars->add_keyword( 'bullets-v-position', $settings['bullets_v_position'] );
		$less_vars->add_keyword( 'bullets-h-position', $settings['bullets_h_position'] );
		$less_vars->add_pixel_number( 'bullet-v-position', $settings['bullets_v_offset'] );
		$less_vars->add_pixel_number( 'bullet-h-position', $settings['bullets_h_offset'] );

		$less_vars->add_pixel_or_percent_number( 'post-content-width', $settings['bo_content_width'] );
		$less_vars->add_pixel_number( 'post-content-top-overlap', $settings['bo_content_overlap'] );
		$less_vars->add_keyword( 'post-title-color', $settings['custom_title_color'] );
		$less_vars->add_keyword( 'post-meta-color', $settings['post_meta_font_color'] );
		$less_vars->add_keyword( 'post-content-color', $settings['post_content_color'] );
		$less_vars->add_keyword( 'post-content-bg', $settings['custom_content_bg_color'] );

		$less_vars->add_paddings(
			array(
				'post-thumb-padding-top',
				'post-thumb-padding-right',
				'post-thumb-padding-bottom',
				'post-thumb-padding-left',
			),
			$settings['image_padding'],
			'%|px'
		);
		$less_vars->add_pixel_number( 'portfolio-image-border-radius', $settings['image_border_radius'] );

		if ( $settings['image_hover_bg_color'] === 'solid_rollover_bg' ) {
			$less_vars->add_keyword( 'portfolio-rollover-bg', $settings['custom_rollover_bg_color'] );
		}

		$columns = array(
			'desktop'  => $settings['desktop_columns'],
			'v-tablet' => $settings['tablet_v_columns'],
			'h-tablet' => $settings['tablet_h_columns'],
			'phone'    => $settings['phone_columns'],
		);

		foreach ( $columns as $column => $val ) {
			$less_vars->add_keyword( $column . '-columns-num', $val );
		}

		$less_vars->add_pixel_number( 'grid-posts-gap', $settings['gap_between_posts'] );

		$less_vars->add_paddings(
			array(
				'post-content-padding-top',
				'post-content-padding-right',
				'post-content-padding-bottom',
				'post-content-padding-left',
			),
			$settings['post_content_padding']
		);

		// Post title.
		$less_vars->add_keyword( 'post-title-font-family', $settings['post_title_font_family'] );
		$less_vars->add_keyword( 'post-title-text-decoration', $settings['post_title_text_decoration'] );
		$less_vars->add_keyword( 'post-title-font-style', $settings['post_title_font_style'] );
		$less_vars->add_keyword( 'post-title-font-weight', $settings['post_title_font_weight'] );
		$less_vars->add_keyword( 'post-title-text-transform', $settings['post_title_text_transform'] );
		$less_vars->add_pixel_number( 'post-title-margin-bottom', $settings['post_title_bottom_margin'] );

		// Post title responsive letter spacing.
		$less_vars->add_set_of_responsive_keywords( 'post-title-letter-spacing', [
			$settings['post_title_letter_spacing'],
			$settings['post_title_letter_spacing_tablet'],
			$settings['post_title_letter_spacing_mobile'],
		] );

		// Post title responsive font size.
		$less_vars->add_set_of_responsive_keywords(
			'post-title-font-size',
			[
				$settings['post_title_font_size'],
				$settings['post_title_font_size_tablet'],
				$settings['post_title_font_size_mobile'],
			],
			[ '', '', '20px' ]
		);

		// Post title responsive line height.
		$less_vars->add_set_of_responsive_keywords(
			'post-title-line-height',
			[
				$settings['post_title_line_height'],
				$settings['post_title_line_height_tablet'],
				$settings['post_title_line_height_mobile'],
			],
			['', '', '26px']
		);

		// Post meta.
		$less_vars->add_keyword( 'post-meta-font-family', $settings['post_meta_font_family'] );
		$less_vars->add_keyword( 'post-meta-text-decoration', $settings['post_meta_text_decoration'] );
		$less_vars->add_keyword( 'post-meta-font-style', $settings['post_meta_font_style'] );
		$less_vars->add_keyword( 'post-meta-font-weight', $settings['post_meta_font_weight'] );
		$less_vars->add_keyword( 'post-meta-text-transform', $settings['post_meta_text_transform'] );
		$less_vars->add_pixel_number( 'post-meta-margin-bottom', $settings['post_meta_bottom_margin'] );

		// Post meta responsive letter spacing.
		$less_vars->add_set_of_responsive_keywords(
			'post-meta-letter-spacing',
			[
				$settings['post_meta_letter_spacing'],
				$settings['post_meta_letter_spacing_tablet'],
				$settings['post_meta_letter_spacing_mobile'],
			]
		);

		// Post meta responsive font size.
		$less_vars->add_set_of_responsive_keywords(
			'post-meta-font-size',
			[
				$settings['post_meta_font_size'],
				$settings['post_meta_font_size_tablet'],
				$settings['post_meta_font_size_mobile'],
			]
		);

		// Post meta responsive line height.
		$less_vars->add_set_of_responsive_keywords(
			'post-meta-line-height',
			[
				$settings['post_meta_line_height'],
				$settings['post_meta_line_height_tablet'],
				$settings['post_meta_line_height_mobile'],
			]
		);

		// Post content.
		$less_vars->add_keyword( 'post-content-font-family', $settings['post_content_font_family'] );
		$less_vars->add_keyword( 'post-content-text-decoration', $settings['post_content_text_decoration'] );
		$less_vars->add_keyword( 'post-content-font-style', $settings['post_content_font_style'] );
		$less_vars->add_keyword( 'post-content-font-weight', $settings['post_content_font_weight'] );
		$less_vars->add_keyword( 'post-content-text-transform', $settings['post_content_text_transform'] );
		$less_vars->add_pixel_number( 'post-content-margin-bottom', $settings['post_content_bottom_margin'] );

		// Post content responsive letter spacing.
		$less_vars->add_set_of_responsive_keywords(
			'post-content-letter-spacing',
			[
				$settings['post_content_letter_spacing'],
				$settings['post_content_letter_spacing_tablet'],
				$settings['post_content_letter_spacing_mobile'],
			]
		);

		// Post content responsive font size.
		$less_vars->add_set_of_responsive_keywords(
			'post-content-font-size',
			[
				$settings['post_content_font_size'],
				$settings['post_content_font_size_tablet'],
				$settings['post_content_font_size_mobile'],
			]
		);

		// Post content responsive line height.
		$less_vars->add_set_of_responsive_keywords(
			'post-content-line-height',
			[
				$settings['post_content_line_height'],
				$settings['post_content_line_height_tablet'],
				$settings['post_content_line_height_mobile'],
			]
		);

		$shadow_style = 'none';
		if ( 'shadow' === $settings['image_decoration'] ) {
			$shadow_style = implode(
				' ',
				[
					$less_vars->maybe_transform_value( $settings['shadow_h_length'] ),
					$less_vars->maybe_transform_value( $settings['shadow_v_length'] ),
					$less_vars->maybe_transform_value( $settings['shadow_blur_radius'] ),
					$less_vars->maybe_transform_value( $settings['shadow_spread'] ),
					$settings['shadow_color'],
				]
			);
		}
		$less_vars->add_keyword( 'portfolio-img-shadow', $shadow_style );
	}
}
