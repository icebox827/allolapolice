<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Import_Export_Options extends The7_Option_Field_Abstract implements The7_Option_Field_Exporter_Interface {

	/**
	 * @var array
	 */
	protected $settings;

	public function html() {
		$rows = '8';

		if ( isset( $option['settings']['rows'] ) ) {
			$custom_rows = $this->option['settings']['rows'];
			if ( is_numeric( $custom_rows ) ) {
				$rows = $custom_rows;
			}
		}

		$val = base64_encode( serialize( $this->settings ) );

		return '<textarea id="' . esc_attr( $this->option['id'] ) . '" class="of-input of-import-export" name="' . esc_attr( $this->option_name ) . '" rows="' . $rows . '" onclick="this.focus();this.select()">' . esc_textarea( $val ) . '</textarea>';
	}

	/**
	 * Setup settings to export.
	 *
	 * @param array $settings            Current theme settings.
	 * @param array $options_definitions Theme options definitions.
	 *
	 * @return void
	 */
	public function with_settings( $settings, $options_definitions ) {
		foreach ( $options_definitions as $option_definition ) {
			if ( isset( $option_definition['id'], $option_definition['exportable'] ) && $option_definition['exportable'] === false ) {
				unset( $settings[ $option_definition['id'] ] );
			}
		}
		$this->settings = $settings;
	}
}
