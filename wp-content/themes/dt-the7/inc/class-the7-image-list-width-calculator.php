<?php
/**
 * The7 image width calculator for list layout.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Image_List_Width_Calculator
 */
class The7_Image_List_Width_Calculator {

	protected $config;

	public function __construct( The7_Image_List_Width_Calculator_Config $config ) {
		$this->config = $config;
	}

	public function calculate_options() {
		$image_w = array();

		// Mobile view.
		$image_w[] = $this->get_content_width( $this->config->get_side_padding_switch() );
		$image_w[] = $this->get_content_width( $this->config->get_mobile_switch() );

		// Desktop view.
		$image_width = $this->sanitize_dimension( $this->config->get_image_width() );
		$left_padding = $this->sanitize_dimension( $this->config->get_left_padding() );
		$right_padding = $this->sanitize_dimension( $this->config->get_right_padding() );
		$side_padding = $right_padding + $left_padding;
		$image_w[] = ( $image_width - $side_padding );

		return array( 'w' => max( $image_w ), 'z' => 0, 'hd_ratio' => 1.7 );
	}

	protected function get_content_width( $base_width ) {
		$mobile_sidebar_width = $this->get_sidebar_width( $base_width );
		$mobile_side_padding = $this->get_content_padding( $base_width ) * 2;

		return ( $base_width - $mobile_sidebar_width - $mobile_side_padding );
	}

	protected function get_content_padding( $content_width ) {
		if ( $content_width <= $this->config->get_side_padding_switch() ) {
			return $this->config->get_mobile_side_padding();
		}

		return $this->config->get_side_padding();
	}

	protected function get_desktop_width() {
		$desktop_width = $this->config->get_content_width();
		if ( false !== strpos( $desktop_width, '%' ) ) {
			return round( (int) $desktop_width * 19.20 );
		}

		return absint( $desktop_width );
	}

	protected function get_sidebar_width( $content_width ) {
		if ( ! $this->config->is_sidebar_enabled() ) {
			return 0;
		}

		$hide_sidebar_after = $this->config->get_sidebar_switch();

		if ( $content_width <= $hide_sidebar_after ) {
			// Do not count sidebar if it's displayed after content.
			return 0;
		}

		$content_padding = $this->get_content_padding( $content_width );
		$sidebar_width = $this->sanitize_dimension( $this->config->get_sidebar_width(), ( $content_width - $content_padding ) );
		$sidebar_gap = $this->config->get_sidebar_gap();

		return ( $sidebar_gap + $sidebar_width - 25 );
	}

	protected function sanitize_dimension( $value, $content_width = null ) {
		if ( is_null( $content_width ) ) {
			$content_width = $this->get_content_width( $this->get_desktop_width() );
		}

		if ( false !== strpos( $value, '%' ) ) {
			$value = round( $content_width * absint( $value ) * 0.01 );
		} else {
			$value = absint( $value );
		}

		return $value;
	}
}