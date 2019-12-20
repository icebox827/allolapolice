<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Icons_Extension {

	public function bootstrap() {
		add_filter(
			'elementor/icons_manager/additional_tabs',
			function( $tabs ) {
				$tabs['the7-icons'] = [
					'name'          => 'the7-icons',
					'label'         => __( 'The7 Icons', 'the7mk2' ),
					'url'           => PRESSCORE_THEME_URI . '/fonts/icomoon-the7-font/icomoon-the7-font.min.css',
					'enqueue'       => [],
					'prefix'        => '',
					'displayPrefix' => '',
					'labelIcon'     => 'fab fa-font-awesome-alt',
					'ver'           => THE7_VERSION,
					'fetchJson'     => PRESSCORE_THEME_URI . '/fonts/icomoon-the7-font/icomoon-the7-font.js',
					'native'        => false,
				];

				return $tabs;
			},
			PHP_INT_MAX
		);
	}
}
