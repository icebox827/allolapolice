<?php
/**
 * Page title helpers
 *
 * @since 1.0.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'presscore_get_page_title' ) ) :

	/**
	 * Function return current page title.
	 *
	 * @return string
	 */
	function presscore_get_page_title() {
		$default_page_title_strings = array(
			'search'   => __( 'Search Results for: %s', 'the7mk2' ),
			'category' => __( 'Category Archives: %s', 'the7mk2' ),
			'tag'      => __( 'Tag Archives: %s', 'the7mk2' ),
			'author'   => __( 'Author Archives: %s', 'the7mk2' ),
			'day'      => __( 'Daily Archives: %s', 'the7mk2' ),
			'month'    => __( 'Monthly Archives: %s', 'the7mk2' ),
			'year'     => __( 'Yearly Archives: %s', 'the7mk2' ),
			'archives' => __( 'Archives: %s', 'the7mk2' ),
			'page_404' => __( 'Page not found', 'the7mk2' ),
			'blog'     => __( 'Blog', 'the7mk2' ),
		);

		/**
		 * Filter all default titles at once.
		 *
		 * @since 4.2.1
		 */
		$page_title_strings = apply_filters( 'presscore_page_title_strings', $default_page_title_strings );
		$page_title_strings = wp_parse_args( $page_title_strings, $default_page_title_strings );

		if ( ! of_get_option( 'show_static_part_of_archive_title' ) ) {
			$page_title_strings['category'] = '%s';
			$page_title_strings['tag']      = '%s';
			$page_title_strings['author']   = '%s';
			$page_title_strings['day']      = '%s';
			$page_title_strings['month']    = '%s';
			$page_title_strings['year']     = '%s';
			$page_title_strings['archives'] = '%s';
		}

		$title = '';

		if ( is_home() && ! is_front_page() ) {
			$title = single_post_title( '', false );

		} elseif ( is_page() || is_single() ) {
			$title = get_the_title();

		} elseif ( is_search() ) {
			$title = sprintf( $page_title_strings['search'], '<span>' . get_search_query() . '</span>' );

		} elseif ( is_archive() ) {

			if ( is_category() ) {
				$title = sprintf(
					$page_title_strings['category'],
					'<span>' . single_cat_title( '', false ) . '</span>'
				);

			} elseif ( is_tag() ) {
				$title = sprintf( $page_title_strings['tag'], '<span>' . single_tag_title( '', false ) . '</span>' );

			} elseif ( is_author() ) {
				the_post();
				$title = sprintf(
					$page_title_strings['author'],
					'<span class="vcard"><a class="url fn n" href="' . esc_url(
						get_author_posts_url( get_the_author_meta( 'ID' ) )
					) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>'
				);
				rewind_posts();

			} elseif ( is_day() ) {
				$title = sprintf( $page_title_strings['day'], '<span>' . get_the_date() . '</span>' );

			} elseif ( is_month() ) {
				$title = sprintf( $page_title_strings['month'], '<span>' . get_the_date( 'F Y' ) . '</span>' );

			} elseif ( is_year() ) {
				$title = sprintf( $page_title_strings['year'], '<span>' . get_the_date( 'Y' ) . '</span>' );

			} elseif ( is_tax() ) {
				$title = sprintf( $page_title_strings['archives'], '<span>' . single_term_title( '', false ) . '</span>' );

			} else {
				$title = sprintf( $page_title_strings['archives'], '<span>' . post_type_archive_title( '', false ) . '</span>' );

			}
		} elseif ( is_404() ) {
			$title = $page_title_strings['page_404'];

		} else {
			$title = $page_title_strings['blog'];

		}

		return apply_filters( 'presscore_get_page_title', $title );
	}

endif;

if ( ! function_exists( 'presscore_get_page_title_html_class' ) ) :

	/**
	 * Return page title class html attr.
	 *
	 * @param array $class
	 *
	 * @return string
	 */
	function presscore_get_page_title_html_class( $class = array() ) {
		if ( ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		if ( is_single() ) {
			$class[] = 'entry-title';
		}

		$class = apply_filters( 'presscore_get_page_title_html_class', $class );

		$class_str = '';
		if ( $class ) {
			$class_str = sprintf( 'class="%s"', presscore_esc_implode( ' ', array_unique( $class ) ) );
		}

		return $class_str;
	}

endif;

if ( ! function_exists( 'presscore_get_page_title_wrap_html_class' ) ) :

	function presscore_get_page_title_wrap_html_class( $class = array() ) {
		$config = presscore_config();
		$output = array();

		switch ( $config->get( 'page_title.align' ) ) {
			case 'right':
				$output[] = 'title-right';
				break;
			case 'left':
				$output[] = 'title-left';
				break;
			case 'all_right':
				$output[] = 'content-right';
				break;
			case 'all_left':
				$output[] = 'content-left';
				break;
			default:
				$output[] = 'title-center';
		}

		$title_bg_mode_class = presscore_get_page_title_bg_mode_html_class();
		if ( $title_bg_mode_class ) {
			$output[] = $title_bg_mode_class;
		}

		if ( ! $config->get( 'page_title.breadcrumbs.enabled' ) ) {
			$output[] = 'breadcrumbs-off';
		}
		if ( $config->get( 'page_title.breadcrumbs.mobile.enabled' ) ) {
			$output[] = 'breadcrumbs-mobile-off';
		}
		if ( $config->get( 'page_title.breadcrumbs.background.mode' ) == 'enabled' ) {
			$output[] = 'breadcrumbs-bg';
		}
		if ( $config->get( 'page_title.background.responsiveness' ) ) {
			$output[] = 'page-title-responsive-enabled';
		}

		if (
			'parallax' === $config->get( 'page_title.background.parallax' )
			&& 'background' === $config->get( 'page_title.background.mode' )
			&& 'enabled' === $config->get( 'page_title.background.img' )
		) {
			$output[] = 'page-title-parallax-bg';
		}

		if (
			'background' === $config->get( 'page_title.background.mode' )
			&& 'enabled' === $config->get( 'page_title.background.img' )
		) {
			$output[] = 'bg-img-enabled';
		}

		if ( $config->get( 'page_title.background.overlay' ) && 'background' === $config->get( 'page_title.background.mode' ) ) {
			$output[] = 'overlay-bg';
		}

		if ( 'background' === $config->get( 'page_title.background.mode' ) && 'outline' === $config->get( 'page_title.decoration' ) ) {
			$output[] = 'title-outline-decoration';
		}

		if ( $class && ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		$output = apply_filters( 'presscore_get_page_title_wrap_html_class', array_merge( $class, $output ) );

		return $output ? sprintf( 'class="%s"', presscore_esc_implode( ' ', array_unique( $output ) ) ) : '';
	}

endif;

if ( ! function_exists( 'presscore_get_page_title_breadcrumbs' ) ) :

	function presscore_get_page_title_breadcrumbs( $args = array() ) {
		$config            = Presscore_Config::get_instance();
		$breadcrumbs_class = 'breadcrumbs text-small';

		switch ( $config->get( 'page_title.breadcrumbs.background.mode' ) ) {
			case 'black':
				$breadcrumbs_class .= ' bg-dark breadcrumbs-bg';
				break;
			case 'white':
				$breadcrumbs_class .= ' bg-light breadcrumbs-bg';
				break;
		}

		$default_args = array(
			'beforeBreadcrumbs' => '<div class="page-title-breadcrumbs">',
			'afterBreadcrumbs'  => '</div>',
			'listAttr'          => ' class="' . $breadcrumbs_class . '"',
		);

		$args = wp_parse_args( $args, $default_args );

		return presscore_get_breadcrumbs( $args );
	}

endif;

if ( ! function_exists( 'presscore_get_page_title_bg_mode_html_class' ) ) :

	/**
	 * Returns class based on title_bg_mode value
	 *
	 * @since 1.0.0
	 * @return string class
	 */
	function presscore_get_page_title_bg_mode_html_class() {
		switch ( presscore_config()->get( 'page_title.background.mode' ) ) {
			case 'background':
				$class = 'solid-bg';
				break;
			case 'gradient':
				$class = 'gradient-bg';
				break;
			case 'disabled':
				$class = 'disabled-bg';
				break;
			default:
				$class = '';
		}
		return $class;
	}


endif;
