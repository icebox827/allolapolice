<?php
/**
 * The7 less vars manager.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Vars_Manager
 */
class The7_Less_Vars_Manager implements The7_Less_Vars_Manager_Interface {

	protected $storage;
	protected $factory;

	public function __construct( Presscore_Lib_SimpleBag $storage, The7_Less_Vars_Factory_Interface $factory ) {
		$this->storage = $storage;
		$this->factory = $factory;
	}

	public function import( $items ) {
		$this->storage->map( $items );
	}

	public function get_var( $var ) {
		return $this->storage->get( $var );
	}

	public function copy_var( $src_var, $dest_var ) {
		$value = $this->storage->get( $src_var );
		$this->storage->set( $dest_var, $value );

		return $value;
	}

	public function get_vars() {
		return $this->storage->get_all();
	}

	public function add_image( $var, $value, $wrap = null ) {
		$this->storage->set( $var, $this->factory->image( $value )->wrap( $wrap )->get() );
	}

	public function add_hex_color( $var, $value, $wrap = null ) {
		$color_obj = $this->populate_color( $value );
		$this->storage->set( $var, $color_obj->wrap( $wrap )->get_hex() );
	}

	public function add_rgb_color( $var, $value, $wrap = null ) {
		$color_obj = $this->populate_color( $value );
		$this->storage->set( $var, $color_obj->wrap( $wrap )->get_rgb() );
	}

	public function add_rgba_color( $var, $value, $opacity = null, $wrap = null ) {
		$color_obj = $this->populate_color( $value );
		if ( ! is_null( $opacity ) ) {
			$color_obj->opacity( $opacity );
		}
		$this->storage->set( $var, $color_obj->wrap( $wrap )->get_rgba() );
	}

	public function add_pixel_number( $var, $value, $wrap = null ) {
		$this->storage->set( $var, $this->factory->number( $value )->wrap( $wrap )->get_pixels() );
	}

	public function add_percent_number( $var, $value, $wrap = null ) {
		$this->storage->set( $var, $this->factory->number( $value )->wrap( $wrap )->get_percents() );
	}

	public function add_number( $var, $value, $wrap = null ) {
		$this->storage->set( $var, $this->factory->number( $value )->wrap( $wrap )->get() );
	}

	/**
	 * Register less var in pixels or percents.
	 *
	 * @param string      $var
	 * @param string      $value
	 * @param string|null $wrap
	 */
	public function add_pixel_or_percent_number( $var, $value, $wrap = null ) {
		$number_obj = $this->factory->number( $value )->wrap( $wrap );
		if ( preg_match( '/(%|px)/', $number_obj->get_units() ) ) {
			$number = $number_obj->get();
		} else {
			$number = $number_obj->get_pixels();
		}

		$this->storage->set( $var, $number );
	}

	public function add_font( $var, $value, $wrap = null ) {
		$this->storage->set( $var, $this->factory->font( $value )->wrap( $wrap )->get() );
	}

	public function add_keyword( $var, $value, $wrap = null ) {
		$_value = (string) $value;
		if ( $wrap ) {
			$_value = sprintf( (string) $wrap, $_value );
		}
		$this->storage->set( $var, $_value ? $_value : '~""' );
	}

	/**
	 * Register less vars for paddings.
	 *
	 * @param array       $vars
	 * @param string      $value
	 * @param string|null $wrap
	 * @param string      $units
	 */
	public function add_paddings( $vars, $value, $units = 'px', $wrap = null ) {
		if ( ! is_array( $value ) ) {
			$value = explode( ' ', $value );
		}

		for ( $i = 0; $i < 4; $i ++ ) {
			$value[ $i ] = ( isset( $value[ $i ] ) ? $value[ $i ] : '0' );
		}

		$value = array_slice( $value, 0, 4 );

		foreach ( $vars as $i => $var ) {
			if ( ! isset( $value[ $i ] ) ) {
				$this->add_keyword( $var, '~""', $wrap );
			}

			switch ( $units ) {
				case '%|px':
				case 'px|%':
					$this->add_pixel_or_percent_number( $var, $value[ $i ], $wrap );
					break;
				case '%':
					$this->add_percent_number( $var, $value[ $i ], $wrap );
					break;
				case 'px':
				default:
					$this->add_pixel_number( $var, $value[ $i ], $wrap );
			}
		}
	}

	protected function populate_color( $value ) {
		if ( $value && is_array( $value ) ) {
			$color_obj = $this->factory->composition();
			foreach ( $value as $color ) {
				$color_obj->add( $this->factory->color( $color ) );
			}
		} else {
			$color_obj = $this->factory->color( $value );
		}

		return $color_obj;
	}
}
