<?php

defined( 'ABSPATH' ) || exit;

interface The7_Option_Field_Exporter_Interface {

	/**
	 * Setup settings to export.
	 *
	 * @param array $settings Current theme settings.
	 * @param array $options_definitions Theme options definitions.
	 *
	 * @return void
	 */
	public function with_settings( $settings, $options_definitions );
}
