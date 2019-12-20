<?php
/**
 * The7 image width calculator config.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Image_Width_Calculator_Config
 */
class The7_Image_Width_Calculator_Config {

	protected $columns = 0;
	protected $columns_gaps = 0;
	protected $content_width = 0;
	protected $side_padding = 0;
	protected $mobile_side_padding = 0;
	protected $side_padding_switch = 0;
	protected $sidebar_width = 0;
	protected $sidebar_gap = 0;
	protected $sidebar_switch = 0;
	protected $image_is_wide = '';
	protected $sidebar_enabled = true;
	protected $sidebar_on_mobile = true;

	public function __construct( $config = array() ) {
		foreach ( $config as $prop => $val ) {
			if ( method_exists( $this, "set_{$prop}" ) ) {
				call_user_func( array( $this, "set_{$prop}" ), $val );
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function get_columns() {
		return $this->columns;
	}

	/**
	 * @return mixed
	 */
	public function get_columns_gaps() {
		return $this->columns_gaps;
	}

	/**
	 * @return mixed
	 */
	public function get_content_width() {
		return $this->content_width;
	}

	/**
	 * @return mixed
	 */
	public function get_side_padding() {
		return $this->side_padding;
	}

	/**
	 * @return mixed
	 */
	public function get_mobile_side_padding() {
		return $this->mobile_side_padding;
	}

	/**
	 * @return mixed
	 */
	public function get_side_padding_switch() {
		return $this->side_padding_switch;
	}

	/**
	 * @return mixed
	 */
	public function get_sidebar_width() {
		return $this->sidebar_width;
	}

	/**
	 * @return mixed
	 */
	public function get_sidebar_gap() {
		return $this->sidebar_gap;
	}

	/**
	 * @return mixed
	 */
	public function get_sidebar_switch() {
		return $this->sidebar_switch;
	}

	/**
	 * @return mixed
	 */
	public function image_is_wide() {
		return $this->image_is_wide;
	}

	/**
	 * @param int $columns
	 */
	public function set_columns( $columns ) {
		$this->columns = (array) $columns;
	}

	/**
	 * @param int $columns_gaps
	 */
	public function set_columns_gaps( $columns_gaps ) {
		$this->columns_gaps = absint( $columns_gaps );
	}

	/**
	 * @param int $content_width
	 */
	public function set_content_width( $content_width ) {
		$this->content_width = $content_width;
	}

	/**
	 * @param int $side_padding
	 */
	public function set_side_padding( $side_padding ) {
		$this->side_padding = absint( $side_padding );
	}

	/**
	 * @param int $mobile_side_padding
	 */
	public function set_mobile_side_padding( $mobile_side_padding ) {
		$this->mobile_side_padding = absint( $mobile_side_padding );
	}

	/**
	 * @param int $side_padding_switch
	 */
	public function set_side_padding_switch( $side_padding_switch ) {
		$this->side_padding_switch = absint( $side_padding_switch );
	}

	/**
	 * @param int $sidebar_width
	 */
	public function set_sidebar_width( $sidebar_width ) {
		$this->sidebar_width = $sidebar_width;
	}

	/**
	 * @param int $sidebar_gap
	 */
	public function set_sidebar_gap( $sidebar_gap ) {
		$this->sidebar_gap = absint( $sidebar_gap );
	}

	/**
	 * @param int $sidebar_switch
	 */
	public function set_sidebar_switch( $sidebar_switch ) {
		$this->sidebar_switch = absint( $sidebar_switch );
	}

	/**
	 * @param string $image_is_wide
	 */
	public function set_image_is_wide( $image_is_wide ) {
		$this->image_is_wide = (bool) $image_is_wide;
	}

	/**
	 * @return bool
	 */
	public function is_sidebar_enabled() {
		return $this->sidebar_enabled;
	}

	/**
	 * @param bool $sidebar_enabled
	 */
	public function set_sidebar_enabled( $sidebar_enabled ) {
		$this->sidebar_enabled = $sidebar_enabled;
	}

	/**
	 * @return bool
	 */
	public function is_sidebar_on_mobile() {
		return $this->sidebar_on_mobile;
	}

	/**
	 * @param bool $sidebar_on_mobile
	 */
	public function set_sidebar_on_mobile( $sidebar_on_mobile ) {
		$this->sidebar_on_mobile = $sidebar_on_mobile;
	}
}