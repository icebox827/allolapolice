<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor;

defined( 'ABSPATH' ) || exit;

trait With_Pagination {

	public function get_posts_per_page( $pagination_mode, $settings ) {
		$settings = wp_parse_args(
			$settings,
			[
				'dis_posts_total'   => -1,
				'st_posts_per_page' => -1,
				'jsp_posts_total'   => -1,
				'jsm_posts_total'   => -1,
				'jsl_posts_total'   => -1,
			]
		);

		$max_posts_per_page = 99999;
		switch ( $pagination_mode ) {
			case 'disabled':
				$posts_per_page = $settings['dis_posts_total'];
				break;
			case 'standard':
				$posts_per_page = $settings['st_posts_per_page'] ?: get_option( 'posts_per_page' );
				break;
			case 'js_pagination':
				$posts_per_page = $settings['jsp_posts_total'];
				break;
			case 'js_more':
				$posts_per_page = $settings['jsm_posts_total'];
				break;
			case 'js_lazy_loading':
				$posts_per_page = $settings['jsl_posts_total'];
				break;
			default:
				return $max_posts_per_page;
		}

		$posts_per_page = (int) $posts_per_page;
		if ( $posts_per_page === -1 || ! $posts_per_page ) {
			return $max_posts_per_page;
		}

		return $posts_per_page;
	}

}
