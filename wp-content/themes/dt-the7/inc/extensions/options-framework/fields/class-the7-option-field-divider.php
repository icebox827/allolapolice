<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Divider extends The7_Option_Field_Abstract {

	protected $need_wrap = false;

	public function html() {
		return '<div class="divider"></div>';
	}
}