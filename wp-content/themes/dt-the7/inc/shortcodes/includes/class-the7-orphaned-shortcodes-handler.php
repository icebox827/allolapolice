<?php

class The7_Orphaned_Shortcodes_Handler {

	/**
	 * @var string
	 */
	protected $cache_option_id = 'the7_orphaned_shortcodes_inline_css';

	/**
	 * @param DT_Shortcode_With_Inline_Css $shortcode_obj
	 */
	public function set_unique_shortcode_id( DT_Shortcode_With_Inline_Css $shortcode_obj ) {
		$shortcode_obj->set_unique_class( $this->get_unique_class( $shortcode_obj ) );
	}

	/**
	 * @param DT_Shortcode_With_Inline_Css $shortcode_obj
	 *
	 * @return string
	 */
	protected function get_unique_class( DT_Shortcode_With_Inline_Css $shortcode_obj ) {
		return 'orphaned-shortcode-' . the7_get_shortcode_uid( $shortcode_obj->get_tag(), $shortcode_obj->get_atts() );
	}

	/**
	 * @param string                            $_
	 * @param DT_Shortcode_With_Inline_Css|null $shortcode_obj
	 *
	 * @return string
	 */
	public function get_inline_css( $_, $shortcode_obj = null ) {
		if ( ! is_a( $shortcode_obj, 'DT_Shortcode_With_Inline_Css' ) ) {
			return '';
		}

		$atts = $shortcode_obj->get_atts();
		$tag = $shortcode_obj->get_tag();
		$css_list = (array) get_option( $this->cache_option_id, array() );
		$uid      = the7_get_shortcode_uid( $tag, $atts );

		if ( array_key_exists( $uid, $css_list ) ) {
			return $css_list[ $uid ];
		}

		$inline_css    = '';
		$generated_css = (array) $shortcode_obj->generate_inline_css( '', $atts );
		if ( array_key_exists( $uid, $generated_css ) ) {
			$inline_css = $css_list[ $uid ] = $generated_css[ $uid ];
			update_option( $this->cache_option_id, $css_list );
		}

		return $inline_css;
	}

	public function clear_cache() {
		delete_option( $this->cache_option_id );
	}

	public function add_cache_invalidation_hooks() {
		add_action( 'optionsframework_after_validate', array( $this, 'clear_cache' ) );
		add_action( 'optionsframework_after_options_reset', array( $this, 'clear_cache' ) );
	}

	public function add_hooks() {
		add_action( 'the7_after_shortcode_init', array( $this, 'set_unique_shortcode_id' ) );
		add_filter( 'the7_shortcodes_get_custom_inline_css', array( $this, 'get_inline_css' ), 10, 2 );
	}

	public function remove_hooks() {
		remove_action( 'the7_after_shortcode_init', array( $this, 'set_unique_shortcode_id' ) );
		remove_filter( 'the7_shortcodes_get_custom_inline_css', array( $this, 'get_inline_css' ) );
	}
}
