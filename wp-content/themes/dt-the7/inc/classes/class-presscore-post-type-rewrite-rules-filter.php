<?php
/**
 * Class register actions for custom post type rewrite rules.
 */

abstract class Presscore_Post_Type_Rewrite_Rules_Option_Adapter {

	protected $id;

	public function __construct( $id ) {
		$this->id = $id;
	}

	public function get_id() {
		return $this->id;
	}

	abstract public function get_val();
}

class Presscore_Post_Type_Rewrite_Rules_Option_Optionsframework extends Presscore_Post_Type_Rewrite_Rules_Option_Adapter {

	public function get_val() {
		return of_get_option( $this->id, false );
	}

}

class Presscore_Post_Type_Rewrite_Rules_Option_DashboardSettings extends Presscore_Post_Type_Rewrite_Rules_Option_Adapter {

	public function get_val() {
		return The7_Admin_Dashboard_Settings::get( $this->id );
	}
}

class Presscore_Post_Type_Rewrite_Rules_Filter {
	private $data_provider;

	public function __construct( $data_provider ) {
		if ( ! is_object( $data_provider ) ) {
			$data_provider = new Presscore_Post_Type_Rewrite_Rules_Option_Optionsframework( $data_provider );
		}

		$this->data_provider = $data_provider;

		add_action( 'presscore_post_type_rewrite_rules_filter_one_time', array( $this, 'flush_rewrite_rules' ) );
	}

	public function filter_post_type_rewrite( $args ) {
		if ( isset( $args['rewrite']['slug'] ) ) {
			$new_slug = $this->data_provider->get_val();
			if ( $new_slug && is_string( $new_slug ) ) {
				$args['rewrite']['slug'] = trim( strtolower( $new_slug ) );
			}
		}
		return $args;
	}

	public function flush_rules_after_slug_change( $options = array() ) {
		$option_key = $this->data_provider->get_id();

		if ( array_key_exists( $option_key, $options ) ) {
			$old_slug = $this->data_provider->get_val();
			$new_slug = $options[ $option_key ];

			// check if new slug is really new
			if ( $old_slug !== $new_slug && ! wp_next_scheduled( 'presscore_post_type_rewrite_rules_filter_one_time' ) ) {
				wp_schedule_single_event( time(), 'presscore_post_type_rewrite_rules_filter_one_time' );
			}
		}
	}

	public function flush_rewrite_rules() {
		flush_rewrite_rules();
	}
}
