<?php

defined( 'ABSPATH' ) || exit;

abstract class The7_Option_Field_Abstract implements The7_Option_Field_Interface {

	/**
	 * @var string
	 */
	protected $option_name = '';

	/**
	 * @var array
	 */
	protected $option = array();

	/**
	 * @var string|array
	 */
	protected $val;

	/**
	 * @var bool
	 */
	protected $need_wrap = true;

	abstract public function html();

	public function setup( $option_name, $option, $val ) {
		if ( empty( $option['input_name'] ) ) {
			$this->option_name = $option_name;
		} else {
			$this->option_name = $option['input_name'];
		}

		$this->option = $this->normalize_option( $option );
		$this->val    = $this->sanitize_value( $val );
	}

	public function need_wrap() {
		return $this->need_wrap;
	}

	public function get_value() {
		return $this->val;
	}

	public function get_option() {
		return $this->option;
	}

	protected function sanitize_value( $val ) {
		// Set default value to $val.
		if ( $val === null && isset( $this->option['std'] ) ) {
			$val = $this->option['std'];
		}

		// If the option is already saved, override $val.
		if ( ! in_array( $this->option['type'], array( 'page', 'info', 'heading' ) ) ) {
			// Striping slashes of non-array options.
			if ( ! is_array( $val ) && ! in_array( $this->option['type'], array( 'textarea', 'code_editor' ) ) ) {
				$val = stripslashes( $val );
			}
		}

		return $val;
	}

	protected function normalize_option( $option ) {
		if ( isset( $option['id'] ) ) {
			$option = wp_parse_args(
				$option,
				array(
					'std' => '',
				)
			);
		}

		return $option;
	}
}
