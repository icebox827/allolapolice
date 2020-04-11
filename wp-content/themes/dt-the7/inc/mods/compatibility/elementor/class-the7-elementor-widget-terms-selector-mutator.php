<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Widget_Terms_Selector_Mutator {

	public function bootstrap() {
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		add_action( 'wp_ajax_the7_elements_get_widget_taxonomies', [ $this, 'ajax_return_taxonomies' ] );
	}

	public function enqueue_editor_scripts() {
		wp_enqueue_script(
			'the7-elements-widget-settings',
			PRESSCORE_ADMIN_URI . '/assets/js/elementor/elements-widget-settings.js',
			array(),
			THE7_VERSION
		);
		wp_localize_script(
			'the7-elements-widget-settings',
			'the7ElementsWidget',
			[
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'_wpnonce' => wp_create_nonce( 'the7-elements-ajax' ),
			]
		);
	}

	public function ajax_return_taxonomies() {
		check_admin_referer( 'the7-elements-ajax' );

		$post_types = array_keys( the7_elementor_elements_widget_post_types() );
		$taxonomies = [];
		$terms = [];
		foreach ( $post_types as $post_type ) {
			$tax_objects = get_object_taxonomies( $post_type, 'objects' );
			$taxonomies[ $post_type ] = [];
			foreach ( $tax_objects as $tax ) {
				if ( $tax->name === 'post_format' ) {
					continue;
				}

				$taxonomies[ $post_type ][] = [
					'value' => $tax->name,
					'label' => $tax->label,
				];

				$terms_objects = get_terms(
					[
						'taxonomy'   => $tax->name,
						'hide_empty' => false,
					]
				);
				$terms[ $tax->name ] = [];
				foreach ( $terms_objects as $term ) {
					$terms[ $tax->name ][] = [
						'value' => (string) $term->term_id,
						'label' => $term->name,
					];
				}
			}
		}

		wp_send_json( compact( 'taxonomies', 'terms' ) );
	}

}
