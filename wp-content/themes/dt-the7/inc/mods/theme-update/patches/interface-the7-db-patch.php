<?php
/**
 * The7 db patch base class.
 *
 * @package the7
 * @since 3.5.0
 */

interface The7_DB_Patch_Interface {

	public function apply( $options );

}

abstract class The7_DB_Patch implements The7_DB_Patch_Interface {

	protected $options = array();

	public function apply( $options ) {
		$this->options = $options;
		$this->do_apply();
		return $this->options;
	}

	abstract protected function do_apply();

	protected function rename_option( $old_key, $new_key ) {
		if ( array_key_exists( $old_key, $this->options ) && ! array_key_exists( $new_key, $this->options ) ) {
			$this->options[ $new_key ] = $this->options[ $old_key ];
			unset( $this->options[ $old_key ] );
		}
	}

	/**
	 * Copy option value to another option, if value option exists.
	 *
	 * @since 7.4.0
	 *
	 * @param string $target_key
	 * @param string $value_key
	 */
	protected function copy_option_value( $target_key, $value_key ) {
		if ( array_key_exists( $value_key, $this->options ) && ! array_key_exists( $target_key, $this->options ) ) {
			$this->options[ $target_key ] = $this->options[ $value_key ];
		}
	}

	protected function remove_option( $key ) {
		unset( $this->options[ $key ] );
	}

	protected function set_option( $key, $val ) {
		$this->options[ $key ] = $val;
	}

	protected function add_option( $key, $val ) {
		if ( ! array_key_exists( $key, $this->options ) ) {
			$this->options[ $key ] = $val;
		}
	}

	protected function get_option( $key ) {
		if ( array_key_exists( $key, $this->options ) ) {
			return $this->options[ $key ];
		}

		return null;
	}

	protected function option_exists( $key ) {
		return array_key_exists( $key, $this->options );
	}
}
