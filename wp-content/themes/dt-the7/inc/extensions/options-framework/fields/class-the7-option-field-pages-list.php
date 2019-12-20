<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Pages_List extends The7_Option_Field_Abstract {

	public function html() {
		return self::static_html( $this->option_name, $this->option['id'], $this->val );
	}

	/**
	 * Return field HTML.
	 *
	 * @param string     $name
	 * @param string     $id
	 * @param string|int $value
	 * @param array      $config
	 *
	 * @return string
	 */
	public static function static_html( $name, $id, $value, $config = array() ) {
		$config = wp_parse_args( $config, array(
			'class' => 'of-input',
		) );

		$html = wp_dropdown_pages( array(
			'name'              => $name,
			'id'                => $id,
			'echo'              => 0,
			'show_option_none'  => _x( '&mdash; Select &mdash;', 'back-end', 'the7mk2' ),
			'option_none_value' => '0',
			'selected'          => $value,
			'post_status'       => 'publish,private,draft',
			'class'             => $config['class'],
		) );

		return $html;
	}
}
