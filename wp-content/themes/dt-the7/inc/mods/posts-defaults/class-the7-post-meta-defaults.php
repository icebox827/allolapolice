<?php

class The7_Post_Meta_Defaults {

	protected $meta_key;

	public function __construct( $post_type ) {
		$this->meta_key = "the7_{$post_type}_defaults";
	}

	public function set( $meta ) {
		update_option( $this->meta_key, $meta );
	}

	public function get() {
		return get_option( $this->meta_key, array() );
	}
}
