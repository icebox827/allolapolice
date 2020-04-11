<?php

/**
 * Redefines elementor templates.
 * @package The7
 */

namespace The7\Adapters\Elementor;

use Elementor\Modules\PageTemplates\Module as PageTemplatesModule;
use Elementor\Plugin;

use Elementor\Modules\Library\Documents\Section;
use ElementorPro\Modules\ThemeBuilder\Documents\Section as ProSection;
use ElementorPro\Modules\ThemeBuilder\Module;

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Elementor_Template_Manager
 */
class The7_Elementor_Template_Manager {

	public function bootstrap() {
		add_filter( 'template_include', [ $this, 'template_include' ], 20 );
		add_filter( 'elementor/theme/need_override_location', [ $this, 'theme_template_include' ], 20, 2 ); //use 20 priority to override woocommerce documents
	}

	/**
	 * Template include.
	 * Update the path for the Elementor Canvas  and header-footer template.
	 * Fired by `template_include` filter.
	 * @access public
	 *
	 * @param string $template The path of the template to include.
	 *
	 * @return string The path of the template to include.
	 */
	public function template_include( $template ) {
		if ( is_singular() ) {
			$document = Plugin::instance()->documents->get_doc_for_frontend( get_the_ID() );
			if ( $document && ( $document instanceof ProSection || $document instanceof Section ) ) {
				$page_templates_module = Plugin::$instance->modules_manager->get_modules( 'page-templates' );
				if ( $page_templates_module !== null ) {
					$template = $page_templates_module->get_template_path( PageTemplatesModule::TEMPLATE_CANVAS );
				}
			}
		}
		$need_override_location = false;
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$archives = Module::instance()->get_conditions_manager()->get_documents_for_location( 'archive' );
			if ( ! empty( $archives ) ) {
				$need_override_location = true;
			}
			$single = Module::instance()->get_conditions_manager()->get_documents_for_location( 'single' );
			if ( ! empty( $single ) ) {
				$need_override_location = true;
			}
		}
		$template = $this->get_template_path( $template, $need_override_location );

		return $template;
	}

	/**
	 * Get page template path.
	 * Retrieve the path for any given page template.
	 * @access public
	 *
	 * @param string $page_template The page template name.
	 *
	 * @return string Page template path.
	 */
	public function get_template_path( $template_path, $need_override_location ) {
		$replace_path = $need_override_location;
		$page_templates_module = Plugin::$instance->modules_manager->get_modules( 'page-templates' );
		if ( $page_templates_module === null ) {
			return $template_path;
		}
		switch ( $template_path ) {
			case $page_templates_module->get_template_path( PageTemplatesModule::TEMPLATE_CANVAS ):
				$replace_path = true;
				Plugin::$instance->frontend->add_body_class( 'elementor-template-canvas' );
				add_action( 'presscore_config_base_init', [ $this, 'canvas_template' ] );
				Plugin::$instance->frontend->add_body_class( 'elementor-clear-template' );
				break;
			case $page_templates_module->get_template_path( PageTemplatesModule::TEMPLATE_HEADER_FOOTER ):
				$replace_path = true;
				Plugin::$instance->frontend->add_body_class( 'elementor-template-full-width' );
				add_action( 'presscore_config_base_init', [ $this, 'full_width_template' ] );
				Plugin::$instance->frontend->add_body_class( 'elementor-clear-template' );
				break;
		}
		if ( $replace_path ) {
			$template_path = locate_template( 'inc/mods/compatibility/elementor/page-templates/elementor-page.php', false, false );
		}

		return $template_path;
	}

	/**
	 *  Will override default page template options.
	 *  Leave only page content
	 */
	public function canvas_template() {
		add_filter( 'presscore_replace_footer', '__return_false' );
		add_filter( 'presscore_show_header', '__return_false' );
		presscore_config()->set( 'template.bottom_bar.enabled', false );
		presscore_config()->set( 'footer_show', false );
		presscore_config()->set( 'sidebar_position', 'disabled' );
		presscore_config()->set( 'header_title', 'false' );
		presscore_config()->set( 'header.floating_navigation.enabled' , 'disabled' ) ;
	}

	/**
	 *  Will override default page template options.
	 *  Only disable sidebar
	 */
	public function full_width_template() {
		presscore_config()->set( 'sidebar_position', 'disabled' );
	}

	public function theme_template_include( $need_override_location, $location ) {
		if ( $need_override_location ) {
			$page_templates_module = Plugin::$instance->modules_manager->get_modules( 'page-templates' );
			$page_templates_module->set_print_callback( function () use ( $location ) {
				Module::instance()->get_locations_manager()->do_location( $location );
			} );
		}

		return false;
	}

}