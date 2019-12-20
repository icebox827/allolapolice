<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Editor extends The7_Option_Field_Abstract {

	public function html() {
		ob_start();

		if ( isset( $this->option['desc'] ) ) {
			echo '<div class="explain">' . esc_html( $this->option['desc'] ) . '</div>' . "\n";
		}
		$textarea_name           = esc_attr( $this->option_name );
		$default_editor_settings = array(
			'textarea_name' => $textarea_name,
			'media_buttons' => false,
			'tinymce'       => array( 'plugins' => 'wordpress' ),
		);
		$editor_settings         = array();
		if ( isset( $this->option['settings'] ) ) {
			$editor_settings = $this->option['settings'];
		}
		$editor_settings = array_merge( $editor_settings, $default_editor_settings );
		wp_editor( $this->val, $this->option['id'], $editor_settings );

		return ob_get_clean();
	}
}