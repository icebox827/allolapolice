<?php
/**
 * The7 config of image width calculator for list layout.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Image_List_Width_Calculator_Config
 */
class The7_Image_List_Width_Calculator_Config {

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
	protected $image_width = 0;
	protected $mobile_switch = 0;
	protected $left_padding = '0';
	protected $right_padding = '0';

	public function __construct( $config = array() ) {
		foreach ( $config as $prop => $val ) {
			if ( method_exists( $this, "set_{$prop}" ) ) {
				call_user_func( array( $this, "set_{$prop}" ), $val );
			}
		}
	}

	/**
	 * @return int
	 */
	public function get_content_width() {
		return $this->content_width;
	}

	/**
	 * @param int $content_width
	 */
	public function set_content_width( $content_width ) {
		$this->content_width = $content_width;
	}

	/**
	 * @return int
	 */
	public function get_side_padding() {
		return $this->side_padding;
	}

	/**
	 * @param int $side_padding
	 */
	public function set_side_padding( $side_padding ) {
		$this->side_padding = absint( $side_padding );
	}

	/**
	 * @return int
	 */
	public function get_mobile_side_padding() {
		return $this->mobile_side_padding;
	}

	/**
	 * @param int $mobile_side_padding
	 */
	public function set_mobile_side_padding( $mobile_side_padding ) {
		$this->mobile_side_padding = absint( $mobile_side_padding );
	}

	/**
	 * @return int
	 */
	public function get_side_padding_switch() {
		return $this->side_padding_switch;
	}

	/**
	 * @param int $side_padding_switch
	 */
	public function set_side_padding_switch( $side_padding_switch ) {
		$this->side_padding_switch = absint( $side_padding_switch );
	}

	/**
	 * @return int
	 */
	public function get_sidebar_width() {
		return $this->sidebar_width;
	}

	/**
	 * @param int $sidebar_width
	 */
	public function set_sidebar_width( $sidebar_width ) {
		$this->sidebar_width = $sidebar_width;
	}

	/**
	 * @return int
	 */
	public function get_sidebar_gap() {
		return $this->sidebar_gap;
	}

	/**
	 * @param int $sidebar_gap
	 */
	public function set_sidebar_gap( $sidebar_gap ) {
		$this->sidebar_gap = absint( $sidebar_gap );
	}

	/**
	 * @return int
	 */
	public function get_sidebar_switch() {
		return $this->sidebar_switch;
	}

	/**
	 * @param int $sidebar_switch
	 */
	public function set_sidebar_switch( $sidebar_switch ) {
		$this->sidebar_switch = absint( $sidebar_switch );
	}

	/**
	 * @return string
	 */
	public function get_image_is_wide() {
		return $this->image_is_wide;
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

	/**
	 * @return int
	 */
	public function get_image_width() {
		return $this->image_width;
	}

	/**
	 * @param int $image_width
	 */
	public function set_image_width( $image_width ) {
		$this->image_width = $image_width;
	}

	/**
	 * @return int
	 */
	public function get_mobile_switch() {
		return $this->mobile_switch;
	}

	/**
	 * @param int $mobile_switch
	 */
	public function set_mobile_switch( $mobile_switch ) {
		$this->mobile_switch = absint( $mobile_switch );
	}

	/**
	 * @return string
	 */
	public function get_left_padding() {
		return $this->left_padding;
	}

	/**
	 * @param string $left_padding
	 */
	public function set_left_padding( $left_padding ) {
		$this->left_padding = $left_padding;
	}

	/**
	 * @return string
	 */
	public function get_right_padding() {
		return $this->right_padding;
	}

	/**
	 * @param string $right_padding
	 */
	public function set_right_padding( $right_padding ) {
		$this->right_padding = $right_padding;
	}
}