<?php
/**
 * Setup Elementor widgets.
 *
 * @package The7
 */

namespace The7\Adapters\Elementor;

use Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Elementor_Widgets
 */
class The7_Elementor_Widgets {

	protected $widgets_collection = [];

	/**
	 * Bootstrap widgets.
	 */
	public function bootstrap() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_action( 'elementor/editor/after_save', [ $this, 'on_after_widget_save' ], 10, 2 );
		add_action( 'elementor/init', [ $this, 'elementor_add_custom_category' ] );
		add_action( 'elementor/init', [ $this, 'load_dependencies' ] );
		add_action( 'elementor/preview/init', [ $this, 'turn_off_lazy_loading' ] );
		add_action( 'elementor/editor/init', [ $this, 'turn_off_lazy_loading' ] );

		presscore_template_manager()->add_path( 'elementor', array( 'template-parts/elementor' ) );
	}

	/**
	 * Disable lazy loading with filter.
	 */
	public function turn_off_lazy_loading() {
		add_filter( 'dt_of_get_option-general-images_lazy_loading', '__return_false' );
	}

	/**
	 * Load dependencies and populate widgets collection.
	 *
	 * @throws Exception
	 */
	public function load_dependencies() {
		require_once __DIR__ . '/class-the7-elementor-widget-terms-selector-mutator.php';
		require_once __DIR__ . '/trait-with-pagination.php';
		require_once __DIR__ . '/class-the7-elementor-widget-base.php';
		require_once __DIR__ . '/the7-elementor-less-vars-decorator-interface.php';
		require_once __DIR__ . '/class-the7-elementor-less-vars-decorator.php';
		require_once __DIR__ . '/widgets/class-the7-elementor-elements-widget.php';
		require_once __DIR__ . '/widgets/class-the7-elementor-elements-carousel-widget.php';

		$terms_selector_mutator = new The7_Elementor_Widget_Terms_Selector_Mutator();
		$terms_selector_mutator->bootstrap();

		$this->collection_add_widget( new \The7\Adapters\Elementor\Widgets\The7_Elementor_Elements_Widget() );
		$this->collection_add_widget( new \The7\Adapters\Elementor\Widgets\The7_Elementor_Elements_Carousel_Widget() );
	}

	/**
	 * Register widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		foreach ( $this->widgets_collection as $widget ) {
			$widgets_manager->register_widget_type( $widget );
		}
	}

	/**
	 * Add 'The7 elements' category.
	 */
	public function elementor_add_custom_category() {
		Plugin::$instance->elements_manager->add_category(
			'the7-elements',
			[
				'title' => esc_html__( 'The7 elements', 'the7mk2' ),
				'icon'  => 'fa fa-header',
			]
		);
	}

	public function on_after_widget_save( $post_id, $editor_data ) {
		The7_Elementor_Widget_Base::delete_widgets_css_cache( $post_id );
		$this->generate_and_save_widget_css( $post_id, $editor_data );
	}

	public function generate_and_save_widget_css( $post_id, $editor_data ) {
		foreach ( $editor_data as $element ) {
			$widget_type = isset( $element['widgetType'] ) ? $element['widgetType'] : null;
			if ( array_key_exists( $widget_type, $this->widgets_collection ) ) {
				$widget_class = get_class( $this->widgets_collection[ $widget_type ] );
				if ( $widget_class ) {
					$widget = new $widget_class( $element, [] );
					$widget->save_css( $post_id );
				}
			}

			if ( ! empty( $element['elements'] ) ) {
				$this->generate_and_save_widget_css( $post_id, $element['elements'] );
			}
		}
	}

	protected function collection_add_widget( $widget ) {
		$this->widgets_collection[ $widget->get_name() ] = $widget;
	}
}
