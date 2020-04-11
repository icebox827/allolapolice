<?php

namespace The7\Adapters\Elementor\Pro\DynamicTags\The7\Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use The7\Adapters\Elementor\Pro\DynamicTags\The7\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class The7_Color extends Tag {

	public function get_categories() {
		return [ Module::COLOR_CATEGORY ];
	}

	public function get_group() {
		return Module::THE7_GROUP;
	}

	public function get_title() {
		return __( 'The7 color', 'the7mk2' );
	}

	public function get_name() {
		return 'the7-color';
	}

	protected function _register_controls() {
		$this->add_control( 'color-type', [
			'label'  => __( 'Color', 'the7mk2' ),
			'type'   => Controls_Manager::SELECT,
			'groups' => $this->get_custom_keys_array(),
		] );
	}

	public function render() {
		$color_type = $this->get_settings( 'color-type' );
		if ( ! empty( $color_type ) ) {
			$value =  $this->get_color( $color_type );
		}

		if ( empty( $value ) && $this->get_settings( 'fallback' ) ) {
			$value = $this->get_settings( 'fallback' );
		}
		if ( empty( $value ) ) {
			return;
		}
		echo wp_kses_post( $value );
	}

	private function get_custom_keys_array() {
		$options = [
			''                             => __( 'Select...', 'the7mk2' ),
			'content-headers_color'        => __( 'Headings', 'the7mk2' ),
			'content-primary_text_color'   => __( 'Primary text', 'the7mk2' ),
			'content-secondary_text_color' => __( 'Secondary text', 'the7mk2' ),
			'accent'                       => __( 'Accent', 'the7mk2' ),
		];

		return $options;
	}

	public function get_color( $color_type ) {
		switch ( $color_type ) {
			case 'accent':
				$color_val = the7_theme_accent_color();
				break;
			default:
				$color_val = of_get_option( $color_type, '#000000' );
				break;
		}

		return $color_val;
	}

}