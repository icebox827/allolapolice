<?php

class The7_Post_Meta_Preset {
	protected $id;
	protected $title = '';
	protected $meta = array();
	protected $data_provider;

	public function __construct( The7_Post_Meta_Data_Provider_Interface $data_provider, $id = null ) {
		$this->id = $id;
		$this->data_provider = $data_provider;

		if ( ! is_null( $this->id ) ) {
			$this->title = $this->data_provider->get_title( $this->id );
			$this->meta = $this->data_provider->get_meta( $this->id );
		}
	}

	public function set_id( $id ) {
		$this->id = $id;
	}

	public function set_title( $title ) {
		$this->title = $title;
	}

	public function set_meta( $meta ) {
		$this->meta = (array) $meta;
	}

	public function get_meta() {
		return $this->meta;
	}

	public function save() {
		$this->id = $this->data_provider->update_post_meta( $this->id, $this->title, $this->meta );
	}

	public function delete() {
		$this->data_provider->delete_post_meta( $this->id );
		$this->id = null;
	}

	public function apply_to_post( $post_id ) {
		foreach ( $this->meta as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}
	}
}