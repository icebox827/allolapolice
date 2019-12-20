<?php
class The7_Demo_Content_Remote_Content {

	/**
	 * The7rem_Dummies constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'add_hooks' ) );
	}

	public function add_hooks() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		add_filter( 'the7_demo_content_list', array( $this, 'filter_dummies_list' ) );
	}

	/**
	 * Update dummies list from remote server.
	 *
	 */
	public function update_check() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		$last_update_time = get_site_option( 'the7_demo_content_last_update' );
		$cur_time = time();

		if ( ( $cur_time - $last_update_time ) <= MINUTE_IN_SECONDS ) {
			return;
		}

		$the7_remote_api = new The7_demo_Content_Remote_Server_API();

		$new_list = $the7_remote_api->get_items_list();
		if ( is_wp_error( $new_list ) || ! $new_list ) {
			return;
		}

		update_site_option( 'the7_demo_content_items_list', $new_list );
		update_site_option( 'the7_demo_content_last_update', $cur_time );
	}

	/**
	 * Populate dummies list with new data.
	 *
	 * @param array $dummies
	 *
	 * @return array
	 */
	public function filter_dummies_list( $dummies ) {
		$remote_dummies = get_site_option( 'the7_demo_content_items_list', array() );
		if ( $remote_dummies && is_array( $remote_dummies ) ) {
			$dummies = array_merge( $dummies, $remote_dummies );
		}
		return $dummies;
	}
}