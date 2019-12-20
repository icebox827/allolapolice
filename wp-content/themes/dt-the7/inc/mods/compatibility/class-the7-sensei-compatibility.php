<?php
/**
 * Sensei compatibility code.
 *
 * @package The7/Compatibility
 */

defined( 'ABSPATH' ) || exit;

class The7_Sensei_Compatibility {

	/**
	 * Bootstrap sensei compatibility code.
	 */
	public static function bootstrap() {
		if ( ! class_exists( 'Sensei_Bootstrap' ) ) {
			return;
		}

		add_filter( 'presscore_pages_with_basic_meta_boxes', array(
			__CLASS__,
			'enable_basic_meta_boxes_for_sensei_post_types',
		) );
	}

	/**
	 * Add `course` and `lesson` to the list of post types with basic meta boxes.
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	public static function enable_basic_meta_boxes_for_sensei_post_types( $post_types ) {
		$post_types[] = 'course';
		$post_types[] = 'lesson';

		return $post_types;
	}

}
