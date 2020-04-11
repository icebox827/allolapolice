<?php
/**
 * The7 page settings.
 * @package The7
 */

namespace The7\Adapters\Elementor;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use ElementorPro\Modules\ThemeBuilder\Documents\Theme_Page_Document;
use The7_Elementor_Compatibility;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Page_Settings {

	/**
	 * Custom Elementor controls.
	 * @var array $controls Controls array.
	 */
	protected $controls = [];
	protected $template_option_name;

	/**
	 * Bootstrap calss.
	 */
	public function bootstrap() {
		add_action( 'elementor/documents/register_controls', [ $this, 'add_controls' ], 99 );
		add_filter( 'elementor/editor/localize_settings', [ $this, 'localize_settings' ], 10 );
		add_action( 'elementor/document/after_save', [ $this, 'update_post_meta' ], 10, 2 );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		add_action( 'elementor/preview/init', [ $this, 'on_elementor_preview_init' ] );
	}

	public function on_elementor_preview_init() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueue_editor_preview_scripts' ] );

		$this->maybe_override_post_meta( The7_Elementor_Compatibility::get_frontend_document() );
		$this->maybe_override_post_meta( The7_Elementor_Compatibility::get_document_applied_for_location( 'footer' ) );
	}

	/**
	 * Add 'get_post_metadata' filter that override preview metadata with one from the latest post revision.
	 * While editing, Elementor creates post reviews and sotre modified data there, but preview post with original
	 * metadata. This little trick allows us to see metadata changes in the preview.
	 */
	public function maybe_override_post_meta( $document ) {
		if ( ! $document ) {
			return;
		}

		$document_post_id = $document->get_id();
		$main_post_id = $document->get_main_id();

		if ( ! $document_post_id || ! $main_post_id ) {
			return;
		}

		if ( $document_post_id === $main_post_id ) {
			return;
		}

		$this->replace_theme_post_meta( $document_post_id, $main_post_id );
	}

	/**
	 * Add Elementor controls for sidebar, footer and header.
	 *
	 * @param Elementor\Core\Base\Document $document Elementor document class.
	 */
	public function add_controls( $document ) {
		$sections = $this->get_sections( $document );

		$this->controls = $this->get_sections_controls( $sections );

		foreach ( $sections as $section_id => $section ) {
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
		$this->inject_template_notices_in_document( $document );
	}

	/**
	 * Localize settings values to js front.
	 *
	 * @param array $settings Array of settings.
	 *
	 * @return array
	 */
	public function localize_settings( $settings ) {
		$document = Plugin::$instance->documents->get_doc_or_auto_save( Plugin::$instance->editor->get_post_id() );

		if ( $document && isset( $settings['initial_document']['settings']['settings'] ) ) {
			$post_id = $document->get_post()->ID;
			$page_settings = $settings['initial_document']['settings']['settings'];

			foreach ( $this->controls as $control_id => $control ) {
				if ( isset( $control['on_read'] ) && is_callable( $control['on_read'] ) ) {
					$page_settings[ $control_id ] = call_user_func( $control['on_read'], $control, $document );
					continue;
				}

				if ( isset( $control['meta'] ) && $this->metadata_exists( $post_id, $control['meta'] ) ) {
					$page_settings[ $control_id ] = $document->get_meta( $control['meta'], true );
				}
			}

			$settings['initial_document']['settings']['settings'] = $page_settings;
		}

		return $settings;
	}

	/**
	 * Update post meta.
	 *
	 * @param Elementor\Core\Base\Document $document Elementor document class.
	 * @param array                        $data     Updated settings values.
	 */
	public function update_post_meta( $document, $data ) {
		if ( ! isset( $data['settings'] ) ) {
			return;
		}

		$controls = $this->get_sections_controls( $this->get_sections( $document ) );

		foreach ( $controls as $control_id => $control ) {
			$val = isset( $control['args']['default'] ) ? $control['args']['default'] : '';
			if ( isset( $data['settings'][ $control_id ] ) ) {
				$val = $data['settings'][ $control_id ];
			}

			if ( isset( $control['args']['type'] ) && $control['args']['type'] === Controls_Manager::SWITCHER && $val === '' ) {
				$val = isset( $control['args']['empty_value'] ) ? $control['args']['empty_value'] : $val;
			}

			if ( isset( $control['on_save'] ) && is_callable( $control['on_save'] ) ) {
				call_user_func( $control['on_save'], $val, $control, $document );
				continue;
			}

			if ( isset( $control['meta'] ) && is_string( $control['meta'] ) ) {
				$document->update_meta( $control['meta'], $val );
			}
		}

		$post = $document->get_post();
		$post_id = $post->ID;

		// Fill revision meta fields from the main post.
		if ( $post->post_type === 'revision' ) {
			$this->copy_theme_post_meta( $document->get_main_id(), $post_id );
		}

		the7_update_post_css( $post_id );
	}

	/**
	 * Add scripts to auto save and reload preview.
	 */
	public function enqueue_editor_scripts() {
		the7_register_style( 'the7-elementor-editor', PRESSCORE_ADMIN_URI . '/assets/css/elementor-editor' );
		wp_enqueue_style( 'the7-elementor-editor' );

		wp_enqueue_script( 'the7-elementor-page-settings', PRESSCORE_ADMIN_URI . '/assets/js/elementor/page-settings.js', [], THE7_VERSION, true );

		$controls_ids = [];
		$sections = $this->get_sections( null );
		$controls = $this->get_sections_controls( $sections );

		foreach ( $controls as $id => $control ) {
			if ( isset( $control['on_change'] ) && $control['on_change'] === 'do_not_reload_page' ) {
				continue;
			}

			$controls_ids[] = $id;
		}

		wp_localize_script( 'the7-elementor-page-settings', 'the7Elementor', [
			'controlsIds' => $controls_ids,
		] );
	}

	/**
	 * Register frontend resources.
	 */
	public function enqueue_editor_preview_scripts() {
		the7_register_style( 'the7-elementor-editor-preview', PRESSCORE_ADMIN_URI . '/assets/css/elementor-editor-preview' );
		wp_enqueue_style( 'the7-elementor-editor-preview' );
	}


	/**
	 * Return page settings definition.
	 *
	 * @param      $document
	 * @param bool $get_all_sections
	 *
	 * @return array
	 */
	protected function get_sections( $document ) {
		$sections_definition = [
			'the7_document_title_section' => [
				'exclude_documents' => [ 'footer', 'header', 'section' ],
				'file'              => 'page-title.php',
			],
			'the7_document_sidebar'       => [
				'exclude_documents' => [ 'footer', 'header', 'section' ],
				'file'              => 'sidebar.php',
			],
			'the7_document_footer'        => [
				'exclude_documents' => [ 'footer', 'header', 'section' ],
				'file'              => 'footer.php',
			],
			'the7_document_paddings'      => [
				'exclude_documents' => [ 'footer', 'header', 'section' ],
				'file'              => 'paddings.php',
			],
		];
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$sections_definition['the7_document_footer']['file'] = 'footer-pro.php';
		}

		$sections = [];

		$document_name = '';
		if ( $document ) {
			$document_name = $document->get_name();
			$this->template_option_name = 'template';
			if ( defined( 'ELEMENTOR_PRO_VERSION' ) && $document instanceof Theme_Page_Document ) {
				$this->template_option_name = 'page_template';
			} else if ( empty( $document->get_controls( 'template' ) ) ) {
				$this->template_option_name = 'post_status'; //workaround if there no template and  page_template on the page
			}
		}

		foreach ( $sections_definition as $section_id => $section ) {
			if ( $document_name ) {
				if ( ! empty ( $section['only_documents'] ) && ! in_array( $document_name, $section['only_documents'], true ) ) {
					continue;
				}

				if ( ! empty ( $section['exclude_documents'] ) && in_array( $document_name, $section['exclude_documents'], true ) ) {
					continue;
				}
			}

			$sections[ $section_id ] = include __DIR__ . "/page-settings/{$section['file']}";
		}

		return $sections;
	}

	/**
	 * @param array $sections
	 *
	 * @return array
	 */
	protected function get_sections_controls( $sections ) {
		$controls = [ [] ];
		foreach ( $sections as $section ) {
			if ( isset( $section['controls'] ) && is_array( $section['controls'] ) ) {
				$controls[] = $section['controls'];
			}
		}

		return array_merge( ...$controls );
	}

	/**
	 * @param $post_id
	 * @param $meta_key
	 *
	 * @return bool
	 */
	protected function metadata_exists( $post_id, $meta_key ) {
		return $post_id && is_string( $meta_key ) && metadata_exists( 'post', $post_id, $meta_key );
	}

	/**
	 * @param $from_post
	 * @param $to_post
	 */
	protected function copy_theme_post_meta( $from_post, $to_post ) {
		$post_meta_cache = update_meta_cache( 'post', [ $to_post ] );
		$post_meta_cache = $post_meta_cache[ $to_post ];

		$main_meta_cache = wp_cache_get( $from_post, 'post_meta' );
		if ( ! empty( $main_meta_cache ) ) {
			foreach ( $main_meta_cache as $meta_key => $meta_value ) {
				if ( strpos( $meta_key, '_dt_' ) !== 0 ) {
					continue;
				}

				if ( ! array_key_exists( $meta_key, $post_meta_cache ) ) {
					$post_meta_cache[ $meta_key ] = $meta_value;
				}
			}
		}

		wp_cache_replace( $to_post, $post_meta_cache, 'post_meta' );
	}

	/**
	 * @param $from_post
	 * @param $to_post
	 */
	protected function replace_theme_post_meta( $from_post, $to_post ) {
		$post_meta_cache = update_meta_cache( 'post', [ $to_post ] );
		$post_meta_cache = $post_meta_cache[ $to_post ];

		$main_meta_cache = wp_cache_get( $from_post, 'post_meta' );
		foreach ( $main_meta_cache as $meta_key => $meta_value ) {
			if ( $meta_key !== 'the7_fancy_title_css' && strpos( $meta_key, '_dt_' ) !== 0 ) {
				continue;
			}

			$post_meta_cache[ $meta_key ] = $meta_value;
		}

		wp_cache_replace( $to_post, $post_meta_cache, 'post_meta' );
	}

	protected function inject_template_notices_in_document( $document ) {
		$not_allowed_documents = [ 'footer', 'header', 'section', 'archive'];
		if ( !$document || in_array( $document->get_name(), $not_allowed_documents, true ) ) {
			return;
		}

		$applied_archive_template_id = '';
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			//check if archive applied
			$template_id = The7_Elementor_Compatibility::get_applied_archive_page_id( $applied_archive_template_id );
			$document_front = The7_Elementor_Compatibility::get_frontend_document();
			if ( $document_front ) {
				$curr_document_id = $document_front->get_id();
				if ( $curr_document_id !== $template_id ) {
					$applied_archive_template_id = $template_id;
				}
			}
		}
		$document->start_injection( [
			'of'       => 'post_status',
			'fallback' => [
				'of' => 'post_title',
			],
		] );
		if ( ! empty( $applied_archive_template_id ) ) {
			$document->add_control( 'the7_document_page_template_applied_message', [
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf( __( 'A <a href="%s" target="_blank">page template</a> is being applied to this page. To edit individual page settings, please exclude this page from template display conditions, or choose the Page Layout other than "Default".', 'the7mk2' ), Plugin::$instance->documents->get( $template_id )->get_edit_url() ),
				'separator'       => 'none',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'conditions'      => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => $this->template_option_name,
							'operator' => '==',
							'value'    => 'default',
						],
						[
							'name'     => 'the7_template_applied',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			] );
			$document->add_control( 'the7_document_page_template_applied_no_effect_message', [
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf( __( 'A <a href="%s" target="_blank">page template</a> is being applied to this page. However, it will not take effect unless you change the Page Layout to "Default".', 'the7mk2' ), Plugin::$instance->documents->get( $template_id )->get_edit_url() ),
				'separator'       => 'none',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'conditions'      => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => $this->template_option_name,
							'operator' => '!=',
							'value'    => 'default',
						],
						[
							'name'     => 'the7_template_applied',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			] );
		}
		$document->add_control( 'the7_template_applied', [
			'type'        => Controls_Manager::HIDDEN,
			'default'     => $applied_archive_template_id,
			'render_type' => 'none',
		] );
		$document->end_injection();


	}
}
