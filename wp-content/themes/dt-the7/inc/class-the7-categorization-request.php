<?php
/**
 * Class that handles categorization request.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Categorization_Request {

	const ORDERBY_PARAM = 'orderby';

	const ORDER_PARAM = 'order';

	const TERMS_PARAM = 'term';

	public $orderby = '';

	public $order = '';

	public $terms = array();

	public function __construct() {
		if ( isset( $_GET[ self::ORDER_PARAM ] ) ) {
			$this->order = sanitize_key( $_GET[ self::ORDER_PARAM ] );
		}

		if ( isset( $_GET[ self::ORDERBY_PARAM ] ) ) {
			$this->orderby = sanitize_key( $_GET[ self::ORDERBY_PARAM ] );
		}

		if ( isset( $_GET[ self::TERMS_PARAM ] ) ) {
			$this->terms = array_filter( array_map( 'sanitize_key', (array) $_GET[ self::TERMS_PARAM ] ) );
		}
	}

	public function not_empty() {
		return $this->order || $this->orderby || $this->terms;
	}

	public function get_first_term() {
		return isset( $this->terms[0] ) ? $this->terms[0] : null;
	}
}