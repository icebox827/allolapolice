<?php

class The7_Post_Meta_WP_Provider implements The7_Post_Meta_Data_Provider_Interface {

	/**
	 * @var string
	 */
	protected $presets_option_id;

	/**
	 * @var string
	 */
	protected $presets_names_option_id;

	public function __construct( $meta_field, $titles_field ) {
		$this->presets_option_id = $meta_field;
		$this->presets_names_option_id = $titles_field;
	}

	public function get_title( $id ) {
		if ( is_null( $id ) ) {
			return '';
		}

		$presets_names = get_option( $this->presets_names_option_id, array() );
		if ( ! array_key_exists( $id, $presets_names ) ) {
			return '';
		}

		return $presets_names[ $id ];
	}

	public function get_meta( $id ) {
		if ( is_null( $id ) ) {
			return array();
		}

		$preset_data = get_option( $this->presets_option_id, array() );
		if ( ! array_key_exists( $id, $preset_data ) ) {
			return array();
		}

		return $preset_data[ $id ];
	}

	public function update_post_meta( $id, $title, $meta ) {
		// Save preset meta.
		$presets_data = get_option( $this->presets_option_id, array() );
		if ( is_null( $id ) ) {
			// New entry.
			array_push( $presets_data, $meta );
			reset( $presets_data );
			end( $presets_data );
			// Update id with the new value.
			$id = key( $presets_data );
		} else {
			$presets_data[ $id ] = $meta;
		}
		update_option( $this->presets_option_id, $presets_data );

		// Save preset name.
		$presets_names = get_option( $this->presets_names_option_id, array() );
		$presets_names[ $id ] = $title;
		update_option( $this->presets_names_option_id, $presets_names );

		return $id;
	}

	public function delete_post_meta( $id ) {
		if ( is_null( $id ) ) {
			return;
		}

		$presets_data = get_option( $this->presets_option_id, array() );
		unset( $presets_data[ $id ] );
		update_option( $this->presets_option_id, $presets_data );

		$presets_names = get_option( $this->presets_names_option_id, array() );
		unset( $presets_names[ $id ] );
		update_option( $this->presets_names_option_id, $presets_names );
	}

	public function get_presets_names() {
		return get_option( $this->presets_names_option_id, array() );
	}
}