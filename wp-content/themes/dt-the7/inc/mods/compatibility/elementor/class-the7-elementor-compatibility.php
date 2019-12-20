<?php
/**
 * The7 Elementor plugin compatibility class.
 *
 * @since 7.7.0
 *
 * @package The7
 */

use The7\Adapters\Elementor\The7_Elementor_Page_Settings;
use The7\Adapters\Elementor\The7_Elementor_Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Elementor_Compatibility
 */
class The7_Elementor_Compatibility {

	/**
	 * Bootstrap module.
	 */
	public function bootstrap() {
		require_once __DIR__ . '/elementor-functions.php';
		require_once __DIR__ . '/class-the7-elementor-widgets.php';
		require_once __DIR__ . '/class-the7-elementor-page-settings.php';
		require_once __DIR__ . '/class-the7-elementor-icons-extension.php';

		$page_settings = new The7_Elementor_Page_Settings();
		$page_settings->bootstrap();

		$icons_extension = new The7_Elementor_Icons_Extension();
		$icons_extension->bootstrap();

		$widgets = new The7_Elementor_Widgets();
		$widgets->bootstrap();
	}
}
