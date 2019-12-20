<?php

class Presscore_Modules_Legacy_Overlapping_Headers {

	public static function launch() {
		add_filter( 'presscore_loaded_options', array( __CLASS__, 'alter_theme_options' ) );
		add_action( 'admin_init', array( __CLASS__, 'alter_meta_boxes' ), 25 );
		add_action( 'presscore_config_base_init', array( __CLASS__, 'alter_theme_config' ), 99 );
	}

	public static function alter_theme_options( $_options ) {
		if ( array_key_exists( 'header-background', $_options ) ) {
			unset( $_options['header-background']['options']['overlap'] );
		}

		return $_options;
	}

	public static function alter_meta_boxes() {
		global $DT_META_BOXES;

		if ( ! $DT_META_BOXES ) {
			return;
		}

		foreach ( $DT_META_BOXES as $box_key => $meta_box ) {
			if ( ! isset( $meta_box['id'] ) ) {
				continue;
			}

			$meta_box_id = $meta_box['id'];

			if ( 'dt_page_box-header_options' !== $meta_box_id ) {
				continue;
			}

			foreach ( $meta_box['fields'] as $field_key => $field ) {
				if ( '_dt_header_background' === $field['id'] ) {
					unset( $DT_META_BOXES[ $box_key ]['fields'][ $field_key ]['options']['overlap'] );
					break;
				}
			}

			break;
		}
	}

	public static function alter_theme_config() {
		$config = presscore_config();

		if ( 'overlap' === $config->get( 'header_background' ) ) {
			$config->set( 'header_background', 'normal' );
		}
	}
}