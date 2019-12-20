<?php

interface The7_Post_Meta_Data_Provider_Interface {
	public function get_title( $id );
	public function get_meta( $id );
	public function update_post_meta( $id, $title, $meta );
	public function delete_post_meta( $id );
	public function get_presets_names();
}
