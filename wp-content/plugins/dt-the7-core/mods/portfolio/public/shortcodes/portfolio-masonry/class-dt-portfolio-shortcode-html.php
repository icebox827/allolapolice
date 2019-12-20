<?php
// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class DT_Blog_Shortcode_HTML
 */
class DT_Portfolio_Shortcode_HTML {

	public static function get_details_btn( $btn_style = 'default', $target = '', $btn_text = '', $btn_link = '', $class = array() ) {
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
		$return_class = implode( ' ', $class );

		return '<a class=" '. $return_class .' " href=" '.$btn_link.' " target="'.$target.'">' . $btn_text . '</a>';
		//presscore_post_details_link( null, $class, $btn_text );
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