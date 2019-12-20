<?php

if ( ! class_exists( 'The7_VC_Posts_Autocomplete' ) ) {

	/**
	 * Class The7_VC_Posts_Autocomplete
	 */
	class The7_VC_Posts_Autocomplete {

		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $label_tpl;

		/**
		 * The7_VC_Posts_Autocomplete constructor.
		 *
		 * @param string $post_type
		 * @param string $label_tpl
		 */
		public function __construct( $post_type, $label_tpl = '%1$s' ) {
			$this->post_type = $post_type;
			$this->label_tpl = $label_tpl;
		}

		/**
		 * @param string $query
		 *
		 * @return array
		 */
		public function suggester( $query ) {
			global $wpdb;

			$query = stripslashes( trim( $query ) );

			if ( $query ) {
				$post_id = absint( $query );
				$post_id = ( $post_id > 0 ? $post_id : -1 );
				$db_query = $wpdb->prepare(
					"SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = '{$this->post_type}' AND post_status = 'publish' AND (ID = '%d' OR post_title LIKE '%%%s%%' OR post_name LIKE '%%%s%%') LIMIT 20",
					$post_id,
					$query,
					strtolower( $query )
				);
			} else {
				$db_query = "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = '{$this->post_type}' AND post_status = 'publish' LIMIT 20";
			}

			$posts = $wpdb->get_results( $db_query, ARRAY_A );

			if ( empty( $posts ) || ! is_array( $posts ) ) {
				return array();
			}

			$result = array();

			foreach ( $posts as $post ) {
				$result[] = array(
					'value' => $post['ID'],
					'label' => sprintf( $this->label_tpl, $post['ID'], $post['post_title'] ),
				);
			}

			return $result;
		}

		/**
		 * @param array $entry
		 *
		 * @return array|bool
		 */
		public function renderer( $entry ) {
			$post_id = $entry['value'];
			$post = get_post( $post_id, OBJECT );

			if ( ! $post ) {
				return false;
			}

			return array(
				'label' => sprintf( $this->label_tpl, $post->ID, $post->post_title ),
				'value' => $post->ID,
			);
		}
	}

}