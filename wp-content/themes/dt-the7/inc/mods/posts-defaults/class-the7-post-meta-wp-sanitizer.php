<?php

class The7_Post_Meta_WP_Sanitizer {

	public static function sanitize_meta( $meta, $post_id ) {
		$post_type = get_post_type( $post_id );
		$meta_fields = self::get_meta_fields_by_post_type( $post_type );

		$sanitized_meta = array();
		foreach ( $meta_fields as $meta_field ) {
			// Exclude from preset.
			if ( ! empty( $meta_field['exclude_from_presets'] ) ) {
				continue;
			}

			$field_id = $meta_field['id'];

			if ( array_key_exists( $field_id, $meta ) ) {
				$sanitized_meta[ $field_id ] = $meta[ $field_id ];
				continue;
			}

			if ( 'checkbox' === $meta_field['type'] ) {
				$sanitized_meta[ $field_id ] = '0';
			} elseif ( 'image_advanced_mk2' === $meta_field['type'] ) {
				$images = get_post_meta( $post_id, $field_id, true );
				$sanitized_meta[ $field_id ] = ( $images ? $images : array() );
			}
		}

		return $sanitized_meta;
	}

	public static function sanitize_title( $title ) {
		return $title;
	}

	public static function get_meta_fields_by_post_type( $post_type ) {
		global $DT_META_BOXES;

		$fields = array();
		foreach ( $DT_META_BOXES as $box ) {
			if ( ! isset( $box['pages'], $box['fields'] ) || ! in_array( $post_type, $box['pages'] ) ) {
				continue;
			}

			$fields = array_merge( $fields, $box['fields'] );
		}

		return $fields;
	}
}