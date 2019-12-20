<?php
/**
 * MEC Compatibility class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_MEC_Compatibility
 */
class The7_MEC_Compatibility {

	/**
	 * Main function.
	 */
	public function bootstrap() {
		add_action( 'mec_save_options', array( $this, 'regenerate_css_on_mec_settings_save' ) );
		add_filter( 'presscore_get_dynamic_stylesheets_list', array( $this, 'customize_custom_less' ) );
		add_action( 'presscore_setup_less_vars', array( $this, 'add_less_vars' ) );
	}

	/**
	 * Force regenerate theme stylesheets after plugin settings save.
	 */
	public function regenerate_css_on_mec_settings_save() {
		presscore_set_force_regenerate_css( true );
	}

	/**
	 * Import dedicated mec less file in the bottom of custom.less.
	 *
	 * @param array $stylesheets Dynamic stylesheets list.
	 *
	 * @return array
	 */
	public function customize_custom_less( $stylesheets ) {
		if ( isset( $stylesheets['dt-custom']['imports']['dynamic_import_bottom'] ) ) {
			$stylesheets['dt-custom']['imports']['dynamic_import_bottom'][] = 'dynamic-less/event-calendar.less';
		}

		return $stylesheets;
	}

	/**
	 * Add less vars.
	 *
	 * @param The7_Less_Vars_Manager_Interface $less_vars Theme less vars manager.
	 */
	public function add_less_vars( The7_Less_Vars_Manager_Interface $less_vars ) {
		$mec_options = get_option( 'mec_options' );
		if ( is_array( $mec_options ) ) {
			if ( isset( $mec_options['styling']['mec_colorskin'] ) ) {
				$less_vars->add_hex_color( 'mec-colorskin', $mec_options['styling']['mec_colorskin'] );
			}
			if ( isset( $mec_options['styling']['color'] ) ) {
				$less_vars->add_hex_color( 'mec-color', $mec_options['styling']['color'] );
			}
		}
	}
}
