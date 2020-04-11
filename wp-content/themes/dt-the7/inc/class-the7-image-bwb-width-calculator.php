<?php
/**
 * Image browser width based calculator.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Image_BWB_Width_Calculator
 */
class The7_Image_BWB_Width_Calculator {

	/**
	 * @var The7_Image_Width_Calculator_Config
	 */
	protected $config;

	/**
	 * The7_Image_BWB_Width_Calculator constructor.
	 *
	 * @param The7_Image_Width_Calculator_Config $config
	 */
	public function __construct( The7_Image_Width_Calculator_Config $config ) {
		$this->config = $config;
	}

	/**
	 * @return array
	 */
	public function calculate_options() {
		$responsive_width = $this->get_points_of_responsiveness();
		$image_w = array();
		foreach ( $responsive_width as $device => $content_width ) {
			$masonry_content_width = $content_width;
			$masonry_content_width_without_padding = $masonry_content_width;
			$masonry_content_width -= $this->get_sidebar_width( $content_width );
			$columns_gaps = $this->config->get_columns_gaps();
			$col = $this->get_columns( $device );
			if ( $col >= 2 && $this->config->image_is_wide() ) {
				$gaps = ($col - 2) * 2 * $columns_gaps;
				$masonry_content_width -= $gaps;
				$image_width = round( $masonry_content_width / $col );
				$image_width *= 2;
			} else {
				$gaps = ($col - 1) * 2 * $columns_gaps;
				$masonry_content_width -= $gaps;
				$image_width = round( $masonry_content_width / $col );
			}

			$image_w[] = min( $image_width, $masonry_content_width_without_padding );
		}

		$image_width = max( $image_w );

		return array( 'w' => $image_width, 'z' => 0, 'hd_ratio' => 1.5 );
	}

	/**
	 * @param int $content_width
	 *
	 * @return int
	 */
	protected function get_sidebar_width( $content_width ) {
		if ( ! $this->config->is_sidebar_enabled() ) {
			return 0;
		}

		$hide_sidebar_after = $this->config->get_sidebar_switch();

		if ( $content_width <= $hide_sidebar_after ) {
			// Do not count sidebar if it's displayed after content.
			return 0;
		}

		$sidebar_width = $this->config->get_sidebar_width();
		$sidebar_in_percents = ( false !== strpos( $sidebar_width, '%' ) );

		if ( $sidebar_in_percents ) {
			$sidebar_width = $content_width * absint( $sidebar_width ) * 0.01;
		} else {
			$sidebar_width = absint( $sidebar_width );
		}

		$sidebar_gap = $this->config->get_sidebar_gap();

		return ($sidebar_gap  + $sidebar_width - 25);
	}

	/**
	 * @param string $device
	 *
	 * @return int
	 */
	protected function get_columns( $device ) {
		$cols = $this->config->get_columns();
		if ( array_key_exists( $device, $cols ) ) {
			return max( absint( $cols[ $device ] ), 1 );
		}

		return 1;
	}

	/**
	 * @return array
	 */
	protected function get_points_of_responsiveness() {
		$desktop_width = $this->config->get_content_width();
		if ( false !== strpos( $desktop_width, '%' ) ) {
			$desktop_width = round(  (int) $desktop_width * 19.20 );
		}

		$desktop_width = absint( $desktop_width );

		$responsive_points = array(
			'wide_desktop' => 1450,
			'desktop'      => $desktop_width,
			'laptop'       => 1280,
			'h_tablet'     => 1200,
			'v_tablet'     => 990,
			'phone'        => 768,
		);

		$columns = $this->config->get_columns();

		return array_intersect_key( $responsive_points, $columns );
	}

}