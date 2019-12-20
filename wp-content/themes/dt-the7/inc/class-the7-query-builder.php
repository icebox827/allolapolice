<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Query_Builder {

	/**
	 * @var array
	 */
	protected $query_args = array();

	/**
	 * @var array
	 */
	protected $tax_query = array();

	/**
	 * @var string
	 */
	protected $requested_taxonomy = '';

	/**
	 * The7_Query_Builder constructor.
	 *
	 * @param array $query_args
	 */
	public function __construct( $query_args ) {
		$this->query_args = wp_parse_args(
			$query_args,
			array(
				'posts_offset'     => 0,
				'post_type'        => 'post',
				'order'            => 'desc',
				'orderby'          => 'date',
				'post_status'      => 'publish',
				'paged'            => 1,
				'posts_per_page'   => 10,
				'suppress_filters' => false,
				'tax_query'        => array(),
			)
		);
	}

	public function from_terms( $taxonomy, $terms = array(), $field = 'term_id' ) {
		$this->requested_taxonomy = $taxonomy;

		if ( $terms && $taxonomy ) {
			$this->tax_query = compact( 'taxonomy', 'terms', 'field' );
		}

		return $this;
	}

	public function with_categorizaition( The7_Categorization_Request $request ) {
		if ( $request->not_empty() ) {
			$this->query_args['order']   = $request->order;
			$this->query_args['orderby'] = $request->orderby;

			$request_term = $request->get_first_term();
			if ( $request_term && $this->requested_taxonomy ) {
				$tax_query = wp_parse_args(
					$this->tax_query,
					array(
						'taxonomy' => $this->requested_taxonomy,
						'field'    => 'term_id',
					)
				);
				$tax_query['terms'] = array( $request_term );
				$this->tax_query = $tax_query;
			}
		}

		return $this;
	}

	public function set_page( $page ) {
		$this->query_args['paged'] = $page;

		return $this;
	}

	public function get_query_args() {
		$query_args = $this->query_args;

		if ( ! empty( $this->tax_query ) ) {
			if ( ! empty( $query_args['tax_query'] ) ) {
				$query_args['tax_query']['relation'] = 'AND';
			}

			$query_args['tax_query'][] = $this->tax_query;
		}

		return $query_args;
	}

	/**
	 * @return WP_Query
	 */
	public function query() {
		add_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
		add_filter( 'found_posts', array( $this, 'fix_pagination' ), 1, 2 );

		$query = new WP_Query( $this->get_query_args() );

		remove_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
		remove_filter( 'found_posts', array( $this, 'fix_pagination' ), 1 );

		return $query;
	}

	/**
	 * Add offset to the posts query.
	 *
	 * @param WP_Query $query
	 *
	 * @since 1.15.0
	 */
	public function add_offset( &$query ) {
		$offset  = (int) $this->query_args['posts_offset'];
		$ppp     = (int) $query->query_vars['posts_per_page'];
		$current = (int) $query->query_vars['paged'];

		if ( $query->is_paged ) {
			$page_offset = $offset + ( $ppp * ( $current - 1 ) );
			$query->set( 'offset', $page_offset );
		} else {
			$query->set( 'offset', $offset );
		}
	}

	/**
	 * Fix pagination accordingly with posts offset.
	 *
	 * @param int $found_posts
	 *
	 * @return int
	 */
	public function fix_pagination( $found_posts ) {
		return $found_posts - (int) $this->query_args['posts_offset'];
	}
}
