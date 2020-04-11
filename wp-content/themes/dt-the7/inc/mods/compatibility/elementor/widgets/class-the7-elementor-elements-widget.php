<?php
/**
 * The7 elements widget for Elementor.
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
use The7_Categorization_Request;
use The7\Adapters\Elementor\The7_Elementor_Widget_Base;
use The7\Adapters\Elementor\With_Pagination;
use The7\Adapters\Elementor\The7_Elementor_Less_Vars_Decorator_Interface;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Elements_Widget extends The7_Elementor_Widget_Base {

	use With_Pagination;

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 */
	public function get_name() {
		return 'the7_elements';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'The7 Masonry & Grid', 'the7mk2' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
				'the7-elements-widget-preview',
				PRESSCORE_ADMIN_URI . '/assets/js/elementor/elements-widget-preview.js',
				[],
				THE7_VERSION,
				true
			);

			return [ 'the7-elements-widget-preview' ];
		}

		return [];
	}

	public function get_style_depends() {
		the7_register_style(
			'the7-elements-widget',
			PRESSCORE_THEME_URI . '/css/compatibility/elementor/the7-elements-widget'
		);

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
				'label'   => __( 'Source', 'the7mk2' ),
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
					'post_type!' => [ '', 'current_query' ],
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
					'taxonomy!'  => '',
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'ordering_heading',
			[
				'label'     => __( 'Ordering', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'post_type!' => 'current_query',
				],
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
				'condition' => [
					'post_type!' => 'current_query',
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
				'condition' => [
					'post_type!' => 'current_query',
				],
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
			'layout',
			[
				'label'   => __( 'Mode', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'masonry',
				'options' => [
					'masonry' => 'Masonry',
					'grid'    => 'Grid',
				],
			]
		);

		$this->add_control(
			'loading_effect',
			[
				'label'   => __( 'Loading effect', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'             => 'None',
					'fade_in'          => 'Fade in',
					'move_up'          => 'Move up',
					'scale_up'         => 'Scale up',
					'fall_perspective' => 'Fall perspective',
					'fly'              => 'Fly',
					'flip'             => 'Flip',
					'helix'            => 'Helix',
					'scale'            => 'Scale',
				],
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
				'selectors'  => [// '{{WRAPPER}} .post-entry-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'responsiveness',
			[
				'label'   => __( 'Responsiveness mode', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'browser_width_based',
				'options' => [
					'browser_width_based' => 'Browser width based',
					'post_width_based'    => 'Post width based',
				],
			]
		);

		$this->add_control(
			'desktop_columns',
			[
				'label'     => __( 'Columns on a desktop', 'the7mk2' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'condition' => [
					'responsiveness' => 'browser_width_based',
				],
			]
		);

		$this->add_control(
			'tablet_h_columns',
			[
				'label'     => __( 'Columns on a horizontal tablet', 'the7mk2' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2,
				'condition' => [
					'responsiveness' => 'browser_width_based',
				],
			]
		);

		$this->add_control(
			'tablet_v_columns',
			[
				'label'     => __( 'Columns on a vertical tablet', 'the7mk2' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'condition' => [
					'responsiveness' => 'browser_width_based',
				],
			]
		);

		$this->add_control(
			'phone_columns',
			[
				'label'     => __( 'Columns on a phone', 'the7mk2' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'condition' => [
					'responsiveness' => 'browser_width_based',
				],
			]
		);

		$this->add_control(
			'pwb_column_min_width',
			[
				'label'      => __( 'Column minimum width', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 300,
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
					'responsiveness' => 'post_width_based',
				],
			]
		);

		$this->add_control(
			'pwb_columns',
			[
				'label'     => __( 'Desired columns number', 'the7mk2' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => 12,
				'condition' => [
					'responsiveness' => 'post_width_based',
				],
			]
		);

		$this->add_control(
			'gap_between_posts',
			[
				'label'       => __( 'Gap between columns', 'the7mk2' ),
				'description' => __(
					'Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)',
					'the7mk2'
				),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => 15,
				],
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'all_posts_the_same_width',
			[
				'label'        => __( 'Make all posts the same width', 'the7mk2' ),
				'description'  => __( 'Post wide/normal width can be chosen in single post options.', 'the7mk2' ),
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
					'{{WRAPPER}} .entry-meta > a, {{WRAPPER}} .entry-meta > span'             => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .project-links-container a'               => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .project-links-container a.icon-with-border:before'         => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .project-links-container a.icon-with-hover-border:after'    => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .project-links-container a.icon-without-border:before'      => 'border-width: 0; padding: {{SIZE}}{{UNIT}};',
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
				'label'        => __( 'Show icon border', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',
				'condition'    => [
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
					'{{WRAPPER}} .dt-icon-bg-on .project-links-container a:before' => 'background: {{VALUE}}; box-shadow: none;',
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
				'condition'    => [
					'show_details' => 'y',
				],
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
					'show_details'            => 'y',
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
					'show_details'            => 'y',
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
					'enable_project_icon_hover'        => 'y',
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
					'show_details'            => 'y',
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
					'{{WRAPPER}} .dt-icon-hover-bg-on .project-links-container a:after' => 'background: {{VALUE}}; box-shadow: none;',
				],
				'condition' => [
					'enable_project_icon_hover' => 'y',
					'project_icon_bg_hover'   => 'y',
					'show_details'            => 'y',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Pagination.
		 */
		$this->start_controls_section(
			'pagination',
			[
				'label' => __( 'Pagination', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'loading_mode',
			[
				'label'   => __( 'Pagination mode', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'disabled',
				'options' => [
					'disabled'        => 'Disabled',
					'standard'        => 'Standard',
					'js_pagination'   => 'JavaScript pages',
					'js_more'         => '"Load more" button',
					'js_lazy_loading' => 'Infinite scroll',
				],
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		// Disabled pagination.
		$this->add_control(
			'dis_posts_total',
			[
				'label'       => __( 'Total number of posts', 'the7mk2' ),
				'description' => __( 'Leave empty to display all posts.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'loading_mode' => 'disabled',
					'post_type!' => 'current_query',
				],
			]
		);

		// Standard pagination.
		$this->add_control(
			'st_posts_per_page',
			[
				'label' => __( 'Number of posts to display on one page', 'the7mk2' ),
				'description' => __(
					'Leave empty to use value from the WP Reading settings. Set "-1" to show all posts.',
					'the7mk2'
				),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'condition' => [
					'loading_mode' => 'standard',
					'post_type!' => 'current_query',
				],
			]
		);

		// JS pagination.
		$this->add_control(
			'jsp_posts_total',
			[
				'label'       => __( 'Total number of posts', 'the7mk2' ),
				'description' => __( 'Leave empty to display all posts.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'loading_mode' => 'js_pagination',
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'jsp_posts_per_page',
			[
				'label'       => __( 'Number of posts to display on one page', 'the7mk2' ),
				'description' => __( 'Leave empty to use value from the WP Reading settings.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'loading_mode' => 'js_pagination',
					'post_type!' => 'current_query',
				],
			]
		);

		// JS load more.
		$this->add_control(
			'jsm_posts_total',
			[
				'label'       => __( 'Total number of posts', 'the7mk2' ),
				'description' => __( 'Leave empty to display all posts.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'loading_mode' => 'js_more',
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'jsm_posts_per_page',
			[
				'label'       => __( 'Number of posts to display on one page', 'the7mk2' ),
				'description' => __( 'Leave empty to use value from the WP Reading settings.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'loading_mode' => 'js_more',
					'post_type!' => 'current_query',
				],
			]
		);

		// JS infinite scroll.
		$this->add_control(
			'jsl_posts_total',
			[
				'label'       => __( 'Total number of posts', 'the7mk2' ),
				'description' => __( 'Leave empty to display all posts.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'loading_mode' => 'js_lazy_loading',
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'jsl_posts_per_page',
			[
				'label'       => __( 'Number of posts to display on one page', 'the7mk2' ),
				'description' => __( 'Leave empty to use value from the WP Reading settings.', 'the7mk2' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'condition'   => [
					'loading_mode' => 'js_lazy_loading',
					'post_type!' => 'current_query',
				],
			]
		);

		// Posts offset.
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
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'show_all_pages',
			[
				'label'        => __( 'Show all pages in paginator', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => '',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'loading_mode',
							'operator' => 'in',
							'value' => [ 'standard', 'js_pagination' ],
						],
						[
							'name' => 'post_type',
							'operator' => '==',
							'value' => 'current_query',
						],
					],
				],
			]
		);

		$this->add_control(
			'gap_before_pagination',
			[
				'label'       => __( 'Gap before pagination', 'the7mk2' ),
				'description' => __( 'Leave empty to use default gap', 'the7mk2' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .paginator' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'loading_mode',
							'operator' => 'in',
							'value' => [ 'standard', 'js_pagination', 'js_more' ],
						],
						[
							'name' => 'post_type',
							'operator' => '==',
							'value' => 'current_query',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'categorization_section',
			[
				'label' => __( 'Categorization', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'show_categories_filter',
			[
				'label'        => __( 'Show categories filter', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => '',
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'show_orderby_filter',
			[
				'label'        => __( 'Show name / date ordering', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => '',
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'show_order_filter',
			[
				'label'        => __( 'Show asc. / desc. ordering', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => '',
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'filter_position',
			[
				'label'   => __( 'Categorization position', 'the7mk2' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center' => 'Center',
					'left'   => 'Left',
					'right'  => 'Right',
				],
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'gap_below_category_filter',
			[
				'label'       => __( 'Gap below categorization & ordering', 'the7mk2' ),
				'description' => __( 'Leave empty to use default gap', 'the7mk2' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .filter' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'filter_color',
			[
				'label'     => __( 'Color Settings', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'navigation_font_color',
			[
				'label'       => __( 'Font color', 'the7mk2' ),
				'description' => __( 'Leave empty to use headers color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition' => [
					'post_type!' => 'current_query',
				],
			]
		);

		$this->add_control(
			'navigation_accent_color',
			[
				'label'       => __( 'Accent color', 'the7mk2' ),
				'description' => __( 'Leave empty to use accent color.', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',
				'condition' => [
					'post_type!' => 'current_query',
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

		$loading_mode = $settings['loading_mode'];

		// Only standard pagination for current query.
		if ( $settings['post_type'] === 'current_query' ) {
			$loading_mode = 'standard';
		}

		$request = null;
		if ( $settings['post_type'] !== 'current_query' && $loading_mode === 'standard' ) {
			$request = new The7_Categorization_Request();
		}

		$query = $this->get_query( $request );

		echo '<div ' . $this->container_class() . $this->get_container_data_atts() . '>';

		// Posts filter.
		$filter_class = array( 'iso-filter' );
		if ( $loading_mode === 'standard' ) {
			$filter_class[] = 'without-isotope';
		}

		if ( $settings['layout'] === 'grid' ) {
			$filter_class[] = 'css-grid-filter';
		}

		if ( ! $settings['show_orderby_filter'] && ! $settings['show_order_filter'] ) {
			$filter_class[] = 'extras-off';
		}

		switch ( of_get_option( 'general-filter_style' ) ) {
			case 'minimal':
				$filter_class[] = 'filter-bg-decoration';
				break;
			case 'material':
				$filter_class[] = 'filter-underline-decoration';
				break;
		}

		$terms = [];
		if ( $settings['show_categories_filter'] ) {
			$terms = $this->get_posts_filter_terms( $settings['taxonomy'], $settings['terms'] );
		}

		$filter_class[] = 'filter';

		$sorting_args = [
			'show_order'   => $settings['show_order_filter'],
			'show_orderby' => $settings['show_orderby_filter'],
			'order'        => $settings['order'],
			'orderby'      => $settings['orderby'],
			'select'       => 'all',
			'term_id'      => 'none',
		];

		if ( $loading_mode === 'standard' && is_object( $request ) && $request->not_empty() ) {
			$sorting_args['select']  = 'only';
			$sorting_args['order']   = $request->order;
			$sorting_args['orderby'] = $request->orderby;
			$sorting_args['term_id'] = $request->get_first_term();
		}

		presscore_get_category_list(
			[
				'data'    => [
					'terms'       => $terms,
					'all_count'   => false,
					'other_count' => false,
				],
				'class'   => implode( ' ', $filter_class ),
				'sorting' => $sorting_args,
			]
		);

		$iso_container_class = 'iso-container dt-isotope';
		if ( 'grid' === $settings['layout'] ) {
			$iso_container_class = 'dt-css-grid';
		}

		echo '<div class="' . esc_attr( $iso_container_class ) . '">';

		$data_post_limit        = $this->get_pagination_posts_limit();
		$is_overlay_post_layout = in_array(
			$settings['post_layout'],
			[ 'gradient_rollover', 'gradient_overlay' ],
			true
		);

		$icons_html_tpl = '';
		if ( $settings['show_details'] ) {
			ob_start();
			Icons_Manager::render_icon( $settings['project_link_icon'], [ 'aria-hidden' => 'true' ], 'span' );
			$details_icon         = ob_get_clean();
			$details_icon_class   = [ 'project-details' ];
			$details_icon_class[] = $settings['show_project_icon_border'] ? 'icon-with-border' : 'icon-without-border';
			$details_icon_class[] = $settings['show_project_icon_hover_border'] ? 'icon-with-hover-border' : 'icon-without-hover-border';

			$icons_html_tpl       = sprintf(
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

				// Post is visible on the first page.
				$visibility = 'visible';
				if ( $data_post_limit >= 0 && $query->current_post >= $data_post_limit ) {
					$visibility = 'hidden';
				}

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

				echo '<div ' . $this->masonry_item_wrap_class( $visibility ) . presscore_tpl_masonry_item_wrap_data_attr() . '>';
				echo '<article class="' . esc_attr( implode( ' ', get_post_class( $post_class_array ) ) ) . '" data-name="' . esc_attr( get_the_title() ) . '" data-date="' . esc_attr( get_the_date( 'c' ) ) . '">';

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

					if ( 'browser_width_based' === $settings['responsiveness'] ) {
						$thumb_args['options'] = the7_calculate_bwb_image_resize_options(
							[
								'desktop'  => $settings['desktop_columns'],
								'v_tablet' => $settings['tablet_v_columns'],
								'h_tablet' => $settings['tablet_h_columns'],
								'phone'    => $settings['phone_columns'],
							],
							$settings['gap_between_posts'],
							$this->current_post_is_wide()
						);
					} else {
						$thumb_args['options'] = the7_calculate_columns_based_image_resize_options(
							$settings['pwb_column_min_width']['size'],
							of_get_option( 'general-content_width' ),
							$settings['pwb_columns'],
							$this->current_post_is_wide()
						);
					}

					if ( presscore_lazy_loading_enabled() ) {
						$thumb_args['lazy_loading'] = true;
						if ( 'masonry' === $settings['layout'] ) {
							$thumb_args['lazy_class'] = 'iso-lazy-load';
						}
					}

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
				echo '</div>';
			}
		}

		wp_reset_postdata();

		echo '</div><!-- iso-container|iso-grid -->';

		if ( 'standard' === $loading_mode ) {
			$this->display_pagination( $query->max_num_pages );
		} elseif ( in_array( $loading_mode, [ 'js_more', 'js_lazy_loading' ], true ) ) {
			echo dt_get_next_page_button( 2, 'paginator paginator-more-button' );
		} elseif ( 'js_pagination' === $loading_mode ) {
			echo '<div class="paginator" role="navigation"></div>';
		}

		echo '</div>';

		$has_img_preload_me_filter && add_filter(
			'dt_get_thumb_img-args',
			'presscore_add_preload_me_class_to_images',
			15
		);
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

		$btn_text     .= '<i class="dt-icon-the7-arrow-03" aria-hidden="true"></i>';
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

	protected function display_pagination( $max_num_pages ) {
		$add_pagination_filter = has_filter( 'dt_paginator_args', 'presscore_paginator_show_all_pages_filter' );
		remove_filter( 'dt_paginator_args', 'presscore_paginator_show_all_pages_filter' );

		$settings  = $this->get_settings_for_display();
		$class     = 'paginator';
		$num_pages = 5;
		if ( $settings['show_all_pages'] ) {
			$num_pages = 9999;
		}

		dt_paginator( null, compact( 'class', 'max_num_pages', 'num_pages' ) );

		$add_pagination_filter && add_filter( 'dt_paginator_args', 'presscore_paginator_show_all_pages_filter' );
	}

	protected function current_post_is_wide() {
		global $post;

		if ( $this->get_settings_for_display( 'all_posts_the_same_width' ) ) {
			return false;
		}

		switch ( get_post_type( $post ) ) {
			case 'post':
				return get_post_meta( $post->ID, '_dt_post_options_preview', true ) === 'wide';
			case 'dt_gallery':
				return get_post_meta( $post->ID, '_dt_album_options_preview', true ) === 'wide';
			case 'dt_portfolio':
				return get_post_meta( $post->ID, '_dt_project_options_preview', true ) === 'wide';
		}

		return false;
	}

	protected function masonry_item_wrap_class( $class = array() ) {
		global $post;

		if ( ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		$settings = $this->get_settings_for_display();

		$class[] = 'wf-cell';

		if ( $this->current_post_is_wide() ) {
			$class[] = 'double-width';
		}

		if ( 'masonry' === $settings['layout'] ) {
			$class[] = 'iso-item';
		}

		if ( $settings['show_categories_filter'] ) {
			$terms = (array) get_the_terms( $post->ID, $settings['taxonomy'] );
			if ( $terms ) {
				foreach ( $terms as $term ) {
					$class[] = sanitize_html_class( 'category-' . $term->term_id );
				}
			} else {
				$class[] = 'category-0';
			}
		}

		return 'class="' . esc_attr( implode( ' ', $class ) ) . '" ';
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

		$mode_classes = array(
			'masonry' => 'mode-masonry',
			'grid'    => 'mode-grid dt-css-grid-wrap',
		);

		$mode = $settings['layout'];
		if ( array_key_exists( $mode, $mode_classes ) ) {
			$class[] = $mode_classes[ $mode ];
		}

		$layout_classes = array(
			'classic'           => 'classic-layout-list',
			'bottom_overlap'    => 'bottom-overlap-layout-list',
			'gradient_overlap'  => 'gradient-overlap-layout-list',
			'gradient_overlay'  => 'gradient-overlay-layout-list',
			'gradient_rollover' => 'content-rollover-layout-list',
		);

		$layout = $settings['post_layout'];
		if ( array_key_exists( $layout, $layout_classes ) ) {
			$class[] = $layout_classes[ $layout ];
		}

		if ( in_array( $settings['post_layout'], [ 'gradient_overlay', 'gradient_rollover' ], true ) ) {
			$class[] = 'description-on-hover';
		} else {
			$class[] = 'description-under-image';
		}

		if ( $settings['content_bg'] ) {
			$class[] = 'content-bg-on';
		}

		$loading_mode = $settings['loading_mode'];
		if ( 'standard' !== $loading_mode ) {
			$class[] = 'jquery-filter';
		}

		if ( 'js_lazy_loading' === $loading_mode ) {
			$class[] = 'lazy-loading-mode';
		}

		if ( $loading_mode === 'js_pagination' && $settings['show_all_pages'] ) {
			$class[] = 'show-all-pages';
		}

		if ( 'center' === $settings['post_content_alignment'] ) {
			$class[] = 'content-align-center';
		}

		if ( ! $settings['enable_project_icon_hover'] ) {
			$class[] = 'dt-icon-hover-off';
		}

		if ( $settings['project_icon_bg'] ) {
			$class[] = 'dt-icon-bg-on';
		} else {
			$class[] = 'dt-icon-bg-off';
		};

		if ( $settings['project_icon_bg_hover'] ) {
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

		if ( in_array(
				 $layout,
				 [ 'gradient_overlay', 'gradient_rollover' ]
			 ) && 'off' === $settings['post_content'] && 'off' === $settings['read_more_button'] ) {
			$class[] = 'disable-layout-hover';
		}

		if ( 'disabled' !== $settings['image_hover_bg_color'] ) {
			$class[] = 'enable-bg-rollover';
		}

		if ( 'shadow' === $settings['image_decoration'] ) {
			$class[] = 'enable-img-shadow';
		}

		switch ( $settings['filter_position'] ) {
			case 'left':
				$class[] = 'filter-align-left';
				break;
			case 'right':
				$class[] = 'filter-align-right';
				break;
		}

		if ( 'browser_width_based' === $settings['responsiveness'] ) {
			$class[] = 'resize-by-browser-width';
		}

		$class[] = presscore_tpl_get_load_effect_class( $settings['loading_effect'] );

		if ( 'gradient_overlay' === $settings['post_layout'] ) {
			$class[] = presscore_tpl_get_hover_anim_class( $settings['go_animation'] );
		}

		return sprintf( ' class="%s" ', esc_attr( implode( ' ', $class ) ) );
	}

	protected function get_container_data_atts() {
		$settings = $this->get_settings_for_display();

		$data_pagination_mode = 'none';
		if ( in_array( $settings['loading_mode'], [ 'js_more', 'js_lazy_loading' ] ) ) {
			$data_pagination_mode = 'load-more';
		} elseif ( $settings['loading_mode'] === 'js_pagination' ) {
			$data_pagination_mode = 'pages';
		} elseif ( $settings['loading_mode'] === 'standard' ) {
			$data_pagination_mode = 'standard';
		}

		$data_atts = array(
			'data-padding="' . esc_attr( $this->combine_slider_value( $settings['gap_between_posts'] ) ) . '"',
			'data-cur-page="' . esc_attr( the7_get_paged_var() ) . '"',
			'data-post-limit="' . (int) $this->get_pagination_posts_limit() . '"',
			'data-pagination-mode="' . esc_attr( $data_pagination_mode ) . '"',
		);

		$target_width = $settings['pwb_column_min_width'];
		if ( $target_width['size'] ) {
			$data_atts[] = 'data-width="' . absint( $target_width['size'] ) . '"';
		}

		if ( ! empty( $settings['pwb_columns'] ) ) {
			$data_atts[] = 'data-columns="' . absint( $settings['pwb_columns'] ) . '"';
		}

		if ( 'browser_width_based' === $settings['responsiveness'] ) {
			$columns = array(
				'desktop'  => $settings['desktop_columns'],
				'v-tablet' => $settings['tablet_v_columns'],
				'h-tablet' => $settings['tablet_h_columns'],
				'phone'    => $settings['phone_columns'],
			);

			foreach ( $columns as $column => $val ) {
				$data_atts[] = 'data-' . $column . '-columns-num="' . esc_attr( $val ) . '"';
			}
		}

		return ' ' . implode( ' ', $data_atts );
	}

	/**
	 * Return shortcode less file absolute path to output inline.
	 *
	 * @return string
	 */
	protected function get_less_file_name() {
		return PRESSCORE_THEME_DIR . '/css/dynamic-less/elementor/the7-elements-widget.less';
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
		if ( $settings['layout'] === 'grid' ) {
			$dynamic_import_bottom[] = 'grid.less';
		}

		return compact( 'dynamic_import_top', 'dynamic_import_bottom' );
	}

	/**
	 * Return array of prepared less vars to insert to less file.
	 *
	 * @return array
	 */
	protected function less_vars( The7_Elementor_Less_Vars_Decorator_Interface $less_vars ) {
		$settings = $this->get_settings_for_display();

		$less_vars->add_keyword(
			'unique-shortcode-class-name',
			$this->get_unique_class() . '.portfolio-shortcode',
			'~"%s"'
		);

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

		if ( 'browser_width_based' === $settings['responsiveness'] ) {
			$columns = array(
				'desktop'  => $settings['desktop_columns'],
				'v-tablet' => $settings['tablet_v_columns'],
				'h-tablet' => $settings['tablet_h_columns'],
				'phone'    => $settings['phone_columns'],
			);

			foreach ( $columns as $column => $val ) {
				$less_vars->add_keyword( $column . '-columns-num', $val );
			}
		};

		$less_vars->add_pixel_number( 'grid-posts-gap', $settings['gap_between_posts'] );
		$less_vars->add_pixel_number( 'grid-post-min-width', $settings['pwb_column_min_width'] );

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
		$less_vars->add_set_of_responsive_keywords(
			'post-title-letter-spacing',
			[
				$settings['post_title_letter_spacing'],
				$settings['post_title_letter_spacing_tablet'],
				$settings['post_title_letter_spacing_mobile'],
			]
		);

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
			[ '', '', '26px' ]
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

		// Filter.
		$less_vars->add_pixel_number( 'shortcode-filter-gap', $settings['gap_below_category_filter'] );
		$less_vars->add_keyword( 'shortcode-filter-color', $settings['navigation_font_color'] );
		$less_vars->add_keyword( 'shortcode-filter-accent', $settings['navigation_accent_color'] );

		$less_vars->add_pixel_number( 'shortcode-pagination-gap', $settings['gap_before_pagination'] );

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

	protected function get_pagination_posts_limit() {
		$settings = $this->get_settings_for_display();

		$posts_limit = '-1';
		switch ( $settings['loading_mode'] ) {
			case 'js_pagination':
				$posts_limit = $settings['jsp_posts_per_page'];
				break;
			case 'js_more':
				$posts_limit = $settings['jsm_posts_per_page'];
				break;
			case 'js_lazy_loading':
				$posts_limit = $settings['jsl_posts_per_page'];
				break;
		}

		if ( ! $posts_limit ) {
			$posts_limit = get_option( 'posts_per_page' );
		}

		return $posts_limit;
	}

	protected function get_query( $request ) {
		$settings = $this->get_settings_for_display();

		if ( $settings['post_type'] === 'current_query' ) {
			return $GLOBALS['wp_query'];
		}

		$loading_mode = $settings['loading_mode'];

		// Loop query.
		$query_args = [
			'posts_offset'   => $settings['posts_offset'],
			'post_type'      => $settings['post_type'],
			'order'          => $settings['order'],
			'orderby'        => $settings['orderby'],
			'posts_per_page' => $this->get_posts_per_page( $loading_mode, $settings ),
		];

		$query_builder = ( new The7_Query_Builder( $query_args ) )->from_terms(
			$settings['taxonomy'],
			$settings['terms']
		);

		if ( $loading_mode === 'standard' ) {
			$query_builder->with_categorizaition( $request );
			$query_builder->set_page( the7_get_paged_var() );
		}

		return $query_builder->query();
	}

	protected function get_posts_filter_terms( $taxonomy, $terms = [] ) {
		$get_terms_args = [
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
		];

		if ( $terms ) {
			$get_terms_args['include'] = $terms;
		}

		return get_terms( $get_terms_args );
	}
}
