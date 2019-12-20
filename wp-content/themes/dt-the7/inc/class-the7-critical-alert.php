<?php
/**
 * The7 critical alert class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Critical_Alert
 */
class The7_Critical_Alert {

	/**
	 * Alert spawn time as a timestamp.
	 *
	 * @var string
	 */
	protected $time;

	/**
	 * Alert subject.
	 *
	 * @var string
	 */
	protected $subject;

	/**
	 * Alert message.
	 *
	 * @var string
	 */
	protected $message;

	/**
	 * The7_Critical_Alert constructor.
	 *
	 * @param string $time    Alert spawn time as a timestamp.
	 * @param string $subject Alert subject.
	 * @param string $message Alert message.
	 */
	public function __construct( $time, $subject, $message ) {
		$this->time    = $time;
		$this->subject = $subject;
		$this->message = $message;
	}

	/**
	 * Return alert time.
	 *
	 * @return string
	 */
	public function get_time() {
		return $this->time;
	}

	/**
	 * Return alert message.
	 *
	 * @return string
	 */
	public function get_message() {
		return $this->message;
	}

	/**
	 * Return alert subject.
	 *
	 * @return string
	 */
	public function get_subject() {
		return $this->subject;
	}
}
