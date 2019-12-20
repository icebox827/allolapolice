<?php

/**
 * Class DT_Dummy_Admin_PHPStatus
 */
class The7_Demo_Content_PHPStatus {

	/**
	 * @var array
	 */
	protected $requirements = array();

	/**
	 * @var bool
	 */
	protected $check_passed = true;

	/**
	 * @var array
	 */
	protected $ini_entries = array();

	/**
	 * DT_Dummy_Admin_Status constructor.
	 *
	 * @param array $requirements
	 */
	public function __construct( $requirements ) {
		$this->requirements = $requirements;
	}

	/**
	 * Check php.ini entries against requirements.
	 *
	 * @return bool
	 */
	public function check_requirements() {
		foreach ( $this->requirements as $entry_name => $entry ) {
			$value                            = ini_get( $entry_name );
			$this->ini_entries[ $entry_name ] = array(
				'value'          => $value,
				'required_value' => $entry['value'],
				'good'           => true,
			);

			if ( $this->raw_value( $value, $entry['type'] ) < $this->raw_value( $entry['value'], $entry['type'] ) ) {
				$this->ini_entries[ $entry_name ]['good'] = false;
				$this->check_passed                       = false;
			}
		}

		return $this->check_passed;
	}

	/**
	 * Return checked php.ini entries.
	 *
	 * @return array
	 */
	public function get_ini_entries() {
		return $this->ini_entries;
	}

	/**
	 * let_to_num function.
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 *
	 * @param $size
	 *
	 * @return int
	 */
	public function let_to_num( $size ) {
		$l   = substr( $size, - 1 );
		$ret = substr( $size, 0, - 1 );
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}

		return $ret;
	}

	/**
	 * Return raw value based on $type
	 *
	 * @param string $value
	 * @param string $type
	 *
	 * @return mixed
	 */
	protected function raw_value( $value, $type ) {
		if ( 'bytes' == $type ) {
			$value = $this->let_to_num( $value );
		}

		return $value;
	}
}