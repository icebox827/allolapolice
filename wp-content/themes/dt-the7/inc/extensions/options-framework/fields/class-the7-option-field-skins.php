<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Skins extends The7_Option_Field_Abstract {

	public function html() {
		$images = new The7_Option_Field_Images();
		$images->setup( $this->option_name, $this->option, $this->val );

		return '<input type="hidden" name="optionsframework_apply_preset" value="true">' . $images->html();
	}
}