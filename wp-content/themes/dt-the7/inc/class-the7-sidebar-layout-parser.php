<?php
/**
 * Sidebar columns layout parser.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Sidebar_Layout_Parser
 */
class The7_Sidebar_Layout_Parser {

	protected $widgets_count = 0;
	protected $columns = array();
	protected $columns_count = 0;

	public function __construct( $columns_layout = '' ) {
		$this->columns = $this->parse_columns( $columns_layout );
		$this->columns_count = count( $this->columns );
	}

	public function get_columns() {
		return $this->columns;
	}

	public function get_columns_count() {
		return $this->columns_count;
	}

	protected function parse_columns( $columns_layout = '' ) {

		if ( ! $columns_layout ) {
			return array();
		}

		return array_map( array( $this, 'get_column_class' ), explode( '+', $columns_layout ) );
	}

	protected function get_column_class( $string = '' ) {
		$clear_string = trim( $string );
		$clear_string = str_replace( '/', '-', $clear_string );
		return 'wf-' . $clear_string;
	}

	public function filter_dynamic_sidebar_params( $params = array() ) {

		if ( isset( $this->columns[ $this->widgets_count ] ) ) {
			$this->flush_default_widgets_cache();

			$column = $this->columns[ $this->widgets_count ];

			$params[0]['before_widget'] = preg_replace('/(class=[\'"])(.*?)([\'"])/', '$1$2 wf-cell ' . $column . '$3', $params[0]['before_widget']);

			if ( $this->widgets_count >= ( $this->columns_count - 1 ) ) {
				$this->widgets_count = 0;
			} else {
				$this->widgets_count++;
			}
		}

		return $params;
	}

	public function add_sidebar_columns() {
		add_filter( 'dynamic_sidebar_params', array( $this, 'filter_dynamic_sidebar_params' ) );
	}

	public function remove_sidebar_columns() {
		remove_filter( 'dynamic_sidebar_params', array( $this, 'filter_dynamic_sidebar_params' ) );
	}

	private function flush_default_widgets_cache() {
		wp_cache_delete('widget_recent_comments', 'widget');
		wp_cache_delete('widget_recent_posts', 'widget');
	}

}
