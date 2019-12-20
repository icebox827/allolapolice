<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Shortcode_Id_Crutch
 */
class The7_Shortcode_Id_Crutch {

	/**
	 * @var array
	 */
	protected $processed_tags = array();

	/**
	 * Reset processed tags.
	 */
	public function reset_processed_tags() {
		$this->processed_tags = array();
	}

	/**
	 * Reset inner short code id once per tag. Store processed tags.
	 *
	 * @param DT_Shortcode_With_Inline_Css $short_code_obj
	 */
	public function reset_id( DT_Shortcode_With_Inline_Css $short_code_obj ) {
		$tag = $short_code_obj->get_tag();
		if ( ! in_array( $tag, $this->processed_tags ) ) {
			$short_code_obj->reset_id();
			$this->processed_tags[] = $tag;
		}
	}
}