<?php

if ( ! class_exists( 'The7_VC_Taxonomy_Autocomplete' ) ) {

	/**
	 * Class The7_VC_Taxonomy_Autocomplete
	 */
	class The7_VC_Taxonomy_Autocomplete {

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var string
		 */
		protected $label_tpl;

		/**
		 * The7_VC_Taxonomy_Autocomplete constructor.
		 *
		 * @param string $taxonomy
		 * @param string $label_tpl
		 */
		public function __construct( $taxonomy, $label_tpl = '%1$s' ) {
			$this->taxonomy = $taxonomy;
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
				$cat_id = absint( $query );
				$cat_id = ( $cat_id > 0 ? $cat_id : -1 );
				$db_query = $wpdb->prepare(
					"SELECT a.term_id AS id, b.name AS name, b.slug AS slug FROM {$wpdb->term_taxonomy} AS a INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id WHERE a.taxonomy = '{$this->taxonomy}' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' ) LIMIT 20",
					$cat_id,
					$query,
					$query
				);
			} else {
				$db_query = "SELECT a.term_id AS id, b.name AS name, b.slug AS slug FROM {$wpdb->term_taxonomy} AS a INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id WHERE a.taxonomy = '{$this->taxonomy}' LIMIT 20";
			}

			$terms = $wpdb->get_results( $db_query, ARRAY_A );

			if ( empty( $terms ) || ! is_array( $terms ) ) {
				return array();
			}

			$result = array();

			foreach ( $terms as $value ) {
				$result[] = array(
					'value' => $value['id'],
					'label' => sprintf( $this->label_tpl, $value['id'], $value['name'], $value['slug'] ),
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
			$value = $entry['value'];
			$field = 'id';

			// Query by slug for compatibility.
			if ( ! is_numeric( $value ) ) {
				$field = 'slug';
			}

			$term = get_term_by( $field, $value, $this->taxonomy, OBJECT );

			if ( ! $term ) {
				return false;
			}

			return array(
				'label' => sprintf( $this->label_tpl, $term->term_id, $term->name, $term->slug ),
				'value' => $term->term_id,
			);
		}
	}

}