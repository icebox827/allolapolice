<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Web_Font implements The7_Web_Font_Interface {

	/**
	 * @var string
	 */
	protected $family = '';

	/**
	 * @var string
	 */
	protected $subset = '';

	/**
	 * @var array
	 */
	protected $weight = array();

	/**
	 * @param string $font
	 */
	public function __construct( $font = '' ) {
		// Replace &amp; coz db value is sanitized with esc_attr().
		$font = str_replace( '&amp;', '&', $font );

		$font_parts = explode( '&', $font );
		if ( ! empty( $font_parts[1] ) ) {
			$this->subset = str_replace( 'subset=', '', $font_parts[1] );
		}

		$font_parts = explode( ':', $font_parts[0] );
		if ( isset( $font_parts[1] ) ) {
			$this->weight = explode( ',', $font_parts[1] );
			$this->weight = array_map( 'trim', $this->weight );
			sort( $this->weight );
		}

		if ( '' !== $font_parts[0] ) {
			$this->family = $font_parts[0];
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$variations = join( ',', $this->get_weight() );
		$subset = $this->get_subset();
		$variations .= ( $subset ? "&subset={$subset}" : '' );
		$web_font = $this->get_family();
		if ( $variations ) {
			$web_font .= ':' . $variations;
		}

		return $web_font;
	}

	/**
	 * @return string
	 */
	public function get_family() {
		return $this->family;
	}

	/**
	 * @return string
	 */
	public function get_subset() {
		return $this->subset;
	}

	/**
	 * @param string $subset
	 */
	public function set_subset( $subset ) {
		$this->subset = $subset;
	}

	/**
	 * @return array
	 */
	public function get_weight() {
		return $this->weight;
	}

	/**
	 * @param array $weight
	 */
	public function set_weight( $weight ) {
		$this->weight = (array) $weight;
		sort( $this->weight );
	}

	/**
	 * @param string $weight
	 */
	public function add_weight( $weight ) {
		if ( ! in_array( $weight, $this->weight ) ) {
			$this->weight[] = $weight;
			sort( $this->weight );
		}
	}
}