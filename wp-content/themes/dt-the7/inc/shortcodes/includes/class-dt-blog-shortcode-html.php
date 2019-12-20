<?php
defined( 'ABSPATH' ) || exit;

/**
 * Class DT_Blog_Shortcode_HTML
 */
class DT_Blog_Shortcode_HTML {

	/**
	 * Return "Details" button HTML.
	 *
	 * @param string       $btn_style
	 * @param string|null  $btn_text
	 * @param array|string $class
	 *
	 * @return string
	 */
	public static function get_details_btn( $btn_style = 'default', $btn_text = '', $class = array() ) {
		if ( ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		$class[] = 'post-details';

		$btn_classes = array(
			'default_link' => 'details-type-link',
			'default_button' => 'details-type-btn',
		);

		if ( isset( $btn_classes[ $btn_style ] ) ) {
			$class[] = $btn_classes[ $btn_style ];
		}

		$btn_text .= '<i class="dt-icon-the7-arrow-03" aria-hidden="true"></i>';

		return presscore_post_details_link( null, $class, $btn_text );
	}

	/**
	 * Output posts filter.
	 *
	 * @param array $terms
	 * @param array $class
	 */
	public static function display_posts_filter( $terms, $class = array() ) {
		if ( ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		$class[] = 'filter';

		presscore_get_category_list( array(
			'data'  => array(
				'terms'       => $terms,
				'all_count'   => false,
				'other_count' => false,
			),
			'class' => implode( ' ', $class ),
		) );
	}
}