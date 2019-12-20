<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class The7_Archive_Shortcodes_Handler
 */
class The7_Archive_Shortcodes_Handler extends The7_Orphaned_Shortcodes_Handler {

	/**
	 * @var string
	 */
	protected $cache_option_id = 'the7_archive_inline_css';

	public function get_unique_class( DT_Shortcode_With_Inline_Css $shortcode_obj ) {
		return 'archive-' . the7_get_shortcode_uid( $shortcode_obj->get_tag(), $shortcode_obj->get_atts() );
	}

	public function use_global_wp_query( $_ ) {
		global $wp_query;

		// Ensure that replacement appear only once.
		remove_filter( 'the7_shortcode_query', array( $this, 'use_global_wp_query' ) );

		return $wp_query;
	}

	public function adjust_template_shortcode_atts( $out, $pairs, $atts, $shortcode ) {
		$out['loading_mode']           = 'standard';
		$out['show_categories_filter'] = 'n';
		$out['show_orderby_filter']    = 'n';
		$out['show_order_filter']      = 'n';
		$out['show_filter']            = '';
		$out['show_orderby']           = '';
		$out['show_order']             = '';
		$out['posts_per_page']         = '-1';

		// Ensure that replacement appear only once.
		remove_filter( 'shortcode_atts_' . $shortcode, array( $this, 'adjust_template_shortcode_atts' ), 10 );

		return $out;
	}

	public function add_hooks( DT_Shortcode_With_Inline_Css $shortcode_obj = null ) {
		parent::add_hooks();

		add_filter( 'the7_shortcode_query', array( $this, 'use_global_wp_query' ) );
		if ( $shortcode_obj ) {
			add_filter( 'shortcode_atts_' . $shortcode_obj->get_tag(), array(
				$this,
				'adjust_template_shortcode_atts',
			), 10, 4 );
		}
	}

	public function remove_hooks( DT_Shortcode_With_Inline_Css $shortcode_obj = null ) {
		parent::remove_hooks();

		remove_filter( 'the7_shortcode_query', array( $this, 'use_global_wp_query' ) );
		if ( $shortcode_obj ) {
			remove_filter( 'shortcode_atts_' . $shortcode_obj->get_tag(), array(
				$this,
				'adjust_template_shortcode_atts',
			), 10 );
		}
	}

	public function add_cache_invalidation_hooks() {
		add_action( 'optionsframework_after_validate', array( $this, 'clear_cache' ) );
		add_action( 'optionsframework_after_options_reset', array( $this, 'clear_cache' ) );
	}
}