<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor\Pro;

use ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager;
use ElementorPro\Modules\ThemeBuilder\Module;
use The7\Adapters\Elementor\Pro;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Theme_Builder_Adapter {

	public function bootstrap() {
		// Locations registration fire on priority 99, so we need to override them later.
		add_action( 'init', [ $this, 'on_elementor_init' ], 1 );

		add_action( 'elementor/theme/register_locations', [
			$this,
			'allow_indepndent_header_and_footer_override',
		], 999 );
		add_filter( 'theme_mod_custom_logo', [ $this, 'replace_site_logo_with_the_main_logo_from_theme_options' ] );
	}

	public function on_elementor_init() {
		require_once __DIR__ . '/modules/theme-support/the7-theme-support.php';
		new ThemeSupport\The7_Theme_Support();

		require_once __DIR__ . '/modules/dynamic-tags/the7/module.php';
		new DynamicTags\The7\Module();
	}

	/**
	 * @param Locations_Manager $location_manager
	 */
	public function allow_indepndent_header_and_footer_override( $location_manager ) {
		$core_locations = $location_manager->get_core_locations();
		$overwrite_header_location = false;
		$overwrite_footer_location = false;

		foreach ( $core_locations as $location => $settings ) {
			if ( $location_manager->get_location( $location ) ) {
				if ( 'header' === $location ) {
					$overwrite_header_location = true;
				} elseif ( 'footer' === $location ) {
					$overwrite_footer_location = true;
				}
			}
		}

		if ( $overwrite_header_location || $overwrite_footer_location ) {
			/** @var Module $theme_builder_module */
			$theme_builder_module = Module::instance();

			$conditions_manager = $theme_builder_module->get_conditions_manager();
			$theme_support = $theme_builder_module->get_component( 'theme_support' );

			if ( empty( $conditions_manager->get_documents_for_location( 'header' ) ) ) {
				remove_action( 'get_header', [ $theme_support, 'get_header' ] );
			}

			if ( empty( $conditions_manager->get_documents_for_location( 'footer' ) ) ) {
				remove_action( 'get_footer', [ $theme_support, 'get_footer' ] );
			}
		}
	}


	/**
	 * @param bool|int $logo_id
	 *
	 * @return bool|int
	 */
	public function replace_site_logo_with_the_main_logo_from_theme_options( $logo_id ) {
		$logo = (array) of_get_option( 'header-logo_regular', array( '', 0 ) );
		if ( ! empty( $logo[1] ) ) {
			return $logo[1];
		}

		$logo = (array) of_get_option( 'header-logo_hd', array( '', 0 ) );
		if ( ! empty( $logo[1] ) ) {
			return $logo[1];
		}

		return $logo_id;
	}

}