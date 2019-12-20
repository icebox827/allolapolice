<?php
/**
 * Custom pagination function.
 *
 * @package presscore
 * @since presscore 0.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( !function_exists( 'dt_paginator' ) ) {

	function dt_paginator( $query = null, $opts = array() ) {
		global $wp_query, $paged, $wp_rewrite;

		$defaults = array(
			'wrap'                => '<div class="%CLASS%" role="navigation">%PREV%%LIST%%NEXT%</div>',
			'item_wrap'           => '<a href="%HREF%" class="page-numbers %ACT_CLASS%" data-page-num="%PAGE_NUM%">%TEXT%</a>',
			'first_wrap'          => '<a href="%HREF%" class="page-numbers %ACT_CLASS%" data-page-num="%PAGE_NUM%">%FIRST_PAGE%</a>',
			'last_wrap'           => '<a href="%HREF%" class="page-numbers %ACT_CLASS%" data-page-num="%PAGE_NUM%">%LAST_PAGE%</a>',
			'pages_wrap'          => '',
			'next_page_wrap'      => '%LINK%',
			'prev_page_wrap'      => '%LINK%',
			'ajaxing'             => false,
			'class'               => 'paginator',
			'item_class'          => '',
			'act_class'           => 'act',
			'pages_prev_class'    => 'nav-prev',
			'pages_next_class'    => 'nav-next',
			'always_show'         => 0,
			'dotleft_wrap'        => '<a href="javascript:void(0);" class="dots">%TEXT%</a>',
			'dotright_wrap'       => '<a href="javascript:void(0);" class="dots">%TEXT%</a>',
			'pages_text'          => _x( 'Page %CURRENT_PAGE% of %TOTAL_PAGES%', 'pagination defaults', 'the7mk2' ),
			'current_text'        => '%PAGE_NUMBER%',
			'page_text'           => '%PAGE_NUMBER%',
			'first_text'          => _x( 'First', 'pagination defaults', 'the7mk2' ),
			'last_text'           => _x( 'Last', 'pagination defaults', 'the7mk2' ),
			'prev_text'           => '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
			'next_text'           => '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
			'no_next'             => '<span class="nav-next disabled"><i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i></span>',
			'no_prev'             => '<span class="nav-prev disabled"><i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i></span>',
			'dotright_text'       => '&#8230;',
			'dotleft_text'        => '&#8230;',
			'num_pages'           => 5,
			'total_pages'         => true,
			'first_is_first_mode' => true,
			'query'               => is_object( $query ) ? $query : $wp_query,
			'max_num_pages'       => 0,
			'found_posts'         => 0,
			'posts_per_page'      => 0,
			'paged'               => 0,
			'format'              => '',
			'base'                => '',
			'return'              => false,
		);
		$opts     = wp_parse_args( $opts, $defaults );
		$opts     = apply_filters( 'dt_paginator_args', $opts );

		// setup query
		$query = $opts['query'];
		if ( ! is_object( $query ) ) {
			$query = $wp_query;
		}

		$paged = $opts['paged'];
		if ( ! $paged && ! $paged = (int) get_query_var( 'page' ) ) {
			$paged = (int) get_query_var( 'paged' );
		}

		$max_page = $opts['max_num_pages'] ? $opts['max_num_pages'] : $query->max_num_pages;

		if ( empty( $paged ) || $paged == 0 ) {
			$paged = 1;
		}

		if ( $opts['num_pages'] <= 0 ) {
			$opts['num_pages'] = 1;
		}

		$pages_to_show         = absint( $opts['num_pages'] );
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start       = floor( $pages_to_show_minus_1 / 2 );
		$half_page_end         = ceil( $pages_to_show_minus_1 / 2 );
		$start_page            = $paged - $half_page_start;

		if ( $start_page <= 0 ) {
			$start_page = 1;
		}

		$end_page = $paged + $half_page_end;

		if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 ) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}

		if ( $end_page > $max_page ) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page   = $max_page;
		}

		$end_page = absint( $end_page );

		if ( $start_page <= 0 ) {
			$start_page = 1;
		}

		$output     = '';
		$pages_list = '';

		$opts['item_wrap'] = str_replace( '%ITEM_CLASS%', $opts['item_class'], $opts['item_wrap'] );

		if ( $opts['ajaxing'] ) {
			add_filter( 'get_pagenum_link', 'dt_ajax_paginator_filter', 10, 1 );
		}
		// Setting up default values based on the current URL.
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		remove_filter( 'get_pagenum_link', 'dt_ajax_paginator_filter', 10 );
		$url_parts = explode( '?', $pagenum_link );

		// Append the format placeholder to the base URL.
		$base = $opts['base'];
		if ( ! $base ) {
			$base = $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
		}

		$format = $opts['format'];
		if ( ! $format ) {
			// URL base depends on permalink settings.
			$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
			$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
		}

		$add_args = array();

		// Merge additional query vars found in the original URL into 'add_args' array.
		if ( isset( $url_parts[1] ) ) {
			// Find the format argument.
			$format_parts = explode( '?', str_replace( '%_%', $format, $base ) );
			$format_query = isset( $format_parts[1] ) ? $format_parts[1] : '';
			wp_parse_str( $format_query, $format_args );

			// Find the query args of the requested URL.
			wp_parse_str( $url_parts[1], $url_query_args );

			// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
			foreach ( $format_args as $format_arg => $format_arg_value ) {
				unset( $url_query_args[ $format_arg ] );
			}

			$add_args = urlencode_deep( $url_query_args );
		}

		if ( $max_page > 1 || (int) $opts['always_show'] === 1 ) {
			add_filter( 'dt_next_posts_link_attributes', 'dt_paginator_add_posts_link_attr', 10, 2 );
			add_filter( 'dt_previous_posts_link_attributes', 'dt_paginator_add_posts_link_attr', 10, 2 );

			$link       = str_replace( '%_%', $format, $base );
			$pages_next = dt_get_next_posts_link( $opts['next_text'], $max_page, 'class="page-numbers ' . esc_attr( $opts['pages_next_class'] ) . '"', $link, $paged, $add_args );

			$link       = str_replace( '%_%', $paged === 2 ? '' : $format, $base );
			$pages_prev = dt_get_previous_posts_link( $opts['prev_text'], 'class="page-numbers ' . esc_attr( $opts['pages_prev_class'] ) . '"', $link, $paged, $add_args );


			remove_filter( 'dt_next_posts_link_attributes', 'dt_paginator_add_posts_link_attr', 10 );
			remove_filter( 'dt_previous_posts_link_attributes', 'dt_paginator_add_posts_link_attr', 10 );

			if ( ! $pages_next ) {
				$pages_next = $opts['no_next'];
			} else {
				$pages_next = str_replace( '%LINK%', $pages_next, $opts['next_page_wrap'] );
			}

			if ( ! $pages_prev ) {
				$pages_prev = $opts['no_prev'];
			} else {
				$pages_prev = str_replace( '%LINK%', $pages_prev, $opts['prev_page_wrap'] );
			}

			$loop_start       = $start_page;
			$loop_end         = $end_page;
			$dots_left_point  = 1;
			$dots_right_point = $max_page;

			if ( $opts['first_is_first_mode'] ) {
				if ( 1 == $start_page ) {
					$loop_start++;
				}

				if ( $max_page == $end_page ) {
					$loop_end--;
				}

				$dots_left_point++;
				$dots_right_point--;

			}

			if ( $paged > 1 || $opts['first_is_first_mode'] ) {

				$act_class = $class_act = '';
				if ( 1 === $paged ) {
					$act_class = $opts['act_class'];
					$class_act = 'class="' . $opts['act_class'] . '"';
				}

				$link = str_replace( '%_%', '', $base );
				$link = str_replace( '%#%', 1, $link );
				if ( $add_args ) {
					$link = add_query_arg( $add_args, $link );
				}

				$pages_list .= str_replace( array(
					'%HREF%',
					'%TEXT%',
					'%FIRST_PAGE%',
					'%ACT_CLASS%',
					'%CLASS_ACT%',
					'%PAGE_NUM%',
				), array(
						esc_url( $link ),
						$opts['first_text'],
						1,
						$act_class,
						$class_act,
						1,
					), $opts['first_wrap'] );
			}

			if ( $start_page > $dots_left_point && $pages_to_show < $max_page ) {
				if ( ! empty( $opts['dotleft_text'] ) ) {

					if ( $opts['first_is_first_mode'] ) {
						$class_act  = $curr_class = '';
						$pages_list .= '<div style="display: none;">';
						for ( $i = 2; $i < $loop_start; $i++ ) {
							$link = str_replace( '%_%', $format, $base );
							$link = str_replace( '%#%', $i, $link );
							if ( $add_args ) {
								$link = add_query_arg( $add_args, $link );
							}
							$page_text  = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $opts['page_text'] );
							$pages_list .= str_replace( array(
								'%ITEM_CLASS%',
								'%HREF%',
								'%TEXT%',
								'%ACT_CLASS%',
								'%CLASS_ACT%',
								'%PAGE_NUM%',
							), array(
									$opts['item_class'],
									esc_url( $link ),
									$page_text,
									$curr_class,
									$class_act,
									$i,
								), $opts['item_wrap'] );
						}
						$pages_list .= '</div>';
					}

					$pages_list .= str_replace( '%TEXT%', $opts['dotleft_text'], $opts['dotleft_wrap'] );
				}
			}

			for ( $i = $loop_start; $i <= $loop_end; $i++ ) {
				if ( $i == $paged ) {
					$page_text  = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $opts['current_text'] );
					$curr_class = $opts['act_class'];
					$class_act  = 'class="' . $opts['act_class'] . '"';
				} else {
					$page_text  = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $opts['page_text'] );
					$curr_class = $class_act = '';
				}

				$link = str_replace( '%_%', 1 === $i ? '' : $format, $base );
				$link = str_replace( '%#%', $i, $link );
				if ( $add_args ) {
					$link = add_query_arg( $add_args, $link );
				}

				$pages_list .= str_replace( array(
					'%ITEM_CLASS%',
					'%HREF%',
					'%TEXT%',
					'%ACT_CLASS%',
					'%CLASS_ACT%',
					'%PAGE_NUM%',
				), array(
						$opts['item_class'],
						esc_url( $link ),
						$page_text,
						$curr_class,
						$class_act,
						$i,
					), $opts['item_wrap'] );
			}

			if ( $end_page < $dots_right_point ) {
				if ( ! empty( $opts['dotright_text'] ) ) {
					$pages_list .= str_replace( '%TEXT%', $opts['dotright_text'], $opts['dotright_wrap'] );

					if ( $opts['first_is_first_mode'] ) {
						$class_act  = $curr_class = '';
						$pages_list .= '<div style="display: none;">';
						for ( $i = $loop_end + 1; $i <= $dots_right_point; $i++ ) {
							$link = str_replace( '%_%', $format, $base );
							$link = str_replace( '%#%', $i, $link );
							if ( $add_args ) {
								$link = add_query_arg( $add_args, $link );
							}
							$page_text  = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $opts['page_text'] );
							$pages_list .= str_replace( array(
								'%ITEM_CLASS%',
								'%HREF%',
								'%TEXT%',
								'%ACT_CLASS%',
								'%CLASS_ACT%',
								'%PAGE_NUM%',
							), array(
									$opts['item_class'],
									esc_url( $link ),
									$page_text,
									$curr_class,
									$class_act,
									$i,
								), $opts['item_wrap'] );
						}
						$pages_list .= '</div>';
					}
				}
			}

			if ( $paged < $max_page || $opts['first_is_first_mode'] ) {

				$act_class = $class_act = '';
				if ( $max_page == $paged ) {
					$act_class = $opts['act_class'];
					$class_act = 'class="' . $opts['act_class'] . '"';
				}

				$link = str_replace( '%_%', $format, $base );
				$link = str_replace( '%#%', $max_page, $link );
				if ( $add_args ) {
					$link = add_query_arg( $add_args, $link );
				}

				$pages_list .= str_replace( array(
					'%HREF%',
					'%TEXT%',
					'%LAST_PAGE%',
					'%ACT_CLASS%',
					'%CLASS_ACT%',
					'%PAGE_NUM%',
				), array(
						esc_url( $link ),
						$opts['last_text'],
						$max_page,
						$act_class,
						$class_act,
						$i,
					), $opts['last_wrap'] );
			}

			$pages_text = str_replace( array( '%CURRENT_PAGE%', '%TOTAL_PAGES%' ), array(
					number_format_i18n( $paged ),
					number_format_i18n( $max_page ),
				), $opts['pages_text'] );

			$output = str_replace( array(
				'%CLASS%',
				'%LIST%',
				'%TOTAL_PAGES_TEXT%',
				'%PREV%',
				'%NEXT%',
			), array(
					$opts['class'],
					$pages_list,
					$pages_text,
					$pages_prev,
					$pages_next,
				), $opts['wrap'] . ( isset( $opts['pages_wrap'] ) ? $opts['pages_wrap'] : '' ) );

			if ( $opts['return'] ) {
				return $output;
			}

			echo $output;
		}
	}

} // !function_exists

function dt_ajax_paginator_filter( $result ) {
	global $wp_rewrite;

	$page_permalink = get_permalink();
	$admin_url = admin_url( 'admin-ajax.php' );

	$search = array(
		'&paged=',
		'?paged=',
		'/page/'
	);

	$pagenum = 1;

	foreach( $search as $exp ) {
		$str = explode( $exp, $result );

		if ( isset($str[1]) ) {
			$pagenum = $str[1];
			break;
		}
	}

	$pagenum = (int) $pagenum;

	$request = remove_query_arg( 'paged' );

	$home_root = parse_url(home_url());
	$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
	$home_root = preg_quote( $home_root, '|' );

	$request = preg_replace('|^'. $home_root . '|i', '', $request);
	$request = preg_replace('|^/+|', '', $request);

	if ( !$wp_rewrite->using_permalinks() ) {
		$base = home_url( '/' );

		if ( $pagenum > 1 ) {
			$result = add_query_arg( 'paged', $pagenum, $base . $request );
		} else {
			$result = $base . $request;
		}
	} else {
		$qs_regex = '|\?.*?$|';
		preg_match( $qs_regex, $request, $qs_match );

		if ( !empty( $qs_match[0] ) ) {
			$query_string = $qs_match[0];
			$request = preg_replace( $qs_regex, '', $request );
		} else {
			$query_string = '';
		}

		$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request );
		$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request );
		$request = ltrim( $request, '/' );

		$base = home_url( '/' );

		if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) ) {
			$base .= $wp_rewrite->index . '/';
		}

		if ( $pagenum > 1 ) {
			$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
		}

		$result = $base . $request . $query_string;
	}

	$result = str_replace( array( trailingslashit($admin_url), $admin_url ), $page_permalink, $result );

	return esc_url( $result );
}

/**
 * Description here.
 *
 */
function dt_paginator_add_posts_link_attr( $attr, $nextpage = 0 ) {
	if ( $nextpage ) {
		$attr .= ' data-page-num="' . absint($nextpage) . '"';
	}
	return $attr;
}

/**
 * Description here.
 *
 * @see get_next_posts_link
 */
function dt_get_next_posts_link( $label = null, $max_page = 0, $attr = '', $base = '', $current = null, $add_args = array() ) {
	global $paged, $wp_query;

	if ( is_single() ) {
		return '';
	}

	$paged_origin = $paged;
	$paged = $paged ? $paged : 1;
	$current = $current !== null ? $current : $paged;
	$nextpage = $current + 1;
	$max_page = $max_page ? $max_page : $wp_query->max_num_pages;

	if ( $nextpage > $max_page ) {
		return '';
	}

	if ( $base ) {
		$link = str_replace( '%#%', $nextpage, $base );
	} else {
		$paged = $current;
		$link = next_posts( $max_page, false );
		$paged = $paged_origin;
	}

	if ( $add_args ) {
		$link = add_query_arg( $add_args, $link );
	}

	$label = $label ? $label : '';
	$attr = apply_filters( 'dt_next_posts_link_attributes', $attr, $nextpage, $max_page );

	return '<a href="' . esc_url( $link ) . '" ' . $attr . ' >' . preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label ) . '</a>';
}

/**
 * Description here.
 *
 * @see get_previous_posts_link
 */
function dt_get_previous_posts_link( $label = null, $attr = '', $base = '', $current = null, $add_args = array() ) {
	global $paged;

	if ( is_single() ) {
		return '';
	}

	$paged_origin = $paged;
	$paged = $paged ? $paged : 1;
	$current = $current !== null ? (int) $current : $paged;

	if ( $current < 2 ) {
		return '';
	}

	$prev_page = $current - 1;
	if ( $base ) {
		$link = str_replace( '%#%', $prev_page, $base );
	} else {
		$paged = $current;
		$link = get_previous_posts_page_link();
		$paged = $paged_origin;
	}

	if ( $add_args ) {
		$link = add_query_arg( $add_args, $link );
	}

	$label = $label ? $label : '';
	$attr = apply_filters( 'dt_previous_posts_link_attributes', $attr, $prev_page );

	return '<a href="' . esc_url( $link ) . '" ' . $attr . ' >'. preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label ) .'</a>';
}

if ( ! function_exists( 'presscore_paginator_show_all_pages_filter' ) ) :

	/**
	 * Implements show all pages behaviour.
	 *
	 * @since 5.0.0
	 *
	 * @param array $args
	 * @return array
	 */
	function presscore_paginator_show_all_pages_filter( $args ) {
		if ( is_page() && presscore_config()->get_bool( 'show_all_pages' ) ) {
			$args['num_pages'] = 9999;
		}

		return $args;
	}

	add_filter( 'dt_paginator_args', 'presscore_paginator_show_all_pages_filter' );

endif;

if ( ! function_exists( 'presscore_ajax_pagination_controller' ) ) :

	/**
	 * Ajax pagination controller.
	 *
	 */
	function presscore_ajax_pagination_controller() {

		$ajax_data = array(
			'nonce'        => isset($_POST['nonce']) ? $_POST['nonce'] : false,
			'post_id'      => isset($_POST['postID']) ? absint($_POST['postID']) : false,
			'post_paged'   => isset($_POST['paged']) ? absint($_POST['paged']) : false,
			'target_page'  => isset($_POST['targetPage']) ? absint($_POST['targetPage']) : false,
			'page_data'    => isset($_POST['pageData']) ? $_POST['pageData'] : false,
			'term'         => isset($_POST['term']) ? $_POST['term'] : '',
			'orderby'      => isset($_POST['orderby']) ? $_POST['orderby'] : '',
			'order'        => isset($_POST['order']) ? $_POST['order'] : '',
			'loaded_items' => isset($_POST['visibleItems']) ? array_map('absint', $_POST['visibleItems']) : array(),
			'sender'       => isset($_POST['sender']) ? $_POST['sender'] : '',
			'posts_count'  => isset($_POST['postsCount']) ? $_POST['postsCount'] : 0,
		);

		if ( $ajax_data['post_id'] && 'page' == get_post_type($ajax_data['post_id']) ) {
			$template = dt_get_template_name( $ajax_data['post_id'], true );
		} else if ( is_array($ajax_data['page_data']) ) {

			switch ( $ajax_data['page_data'][0] ) {
				case 'archive' : $template = 'archive'; break;
				case 'search' : $template = 'search';
			}
		}

		do_action( 'presscore_before_ajax_response', $template );

		// Map all vc shortcodes if needed. Shortcodes must be mapped prior auto excerpt usage.
		if ( ! shortcode_exists( 'vc_row' ) && is_callable( array( 'WPBMap', 'addAllMappedShortcodes' ) ) ) {
			WPBMap::addAllMappedShortcodes();
		}

		$response = array( 'success' => false, 'reason' => 'undefined template' );
		if ( in_array( $template, array( 'template-blog-list.php', 'template-blog-masonry.php' ) ) ) {
			$response = presscore_blog_ajax_loading_responce( $ajax_data );
		}

		$response = apply_filters( 'presscore_ajax_pagination_response', $response, $ajax_data, $template );

		wp_send_json( $response );
	}
	add_action( 'wp_ajax_nopriv_presscore_template_ajax', 'presscore_ajax_pagination_controller' );
	add_action( 'wp_ajax_presscore_template_ajax', 'presscore_ajax_pagination_controller' );

endif;

if ( ! function_exists( 'presscore_complex_pagination' ) ) :

	function presscore_complex_pagination( &$query ) {
		if ( $query ) {

			if ( presscore_is_load_more_pagination() ) {

				// load more button
				echo dt_get_next_page_button( $query->max_num_pages, 'paginator paginator-more-button with-ajax' );

			} else {

				$ajax_class = 'default' != presscore_get_config()->get( 'load_style' ) ? ' with-ajax' : '';

				// paginator
				dt_paginator( $query, array( 'class' => 'paginator' . $ajax_class ) );

			}

		}
	}

endif;

if ( ! function_exists( 'presscore_is_load_more_pagination' ) ) :

	/**
	 * Description here
	 *
	 * @since 1.0.0
	 * @return boolean Is we use load more button in pagination
	 */
	function presscore_is_load_more_pagination() {
		return in_array( presscore_get_config()->get('load_style'), array( 'ajax_more', 'lazy_loading' ) );
	}

endif;

if ( ! function_exists( 'presscore_is_lazy_loading' ) ) :

	function presscore_is_lazy_loading() {
		return ( 'lazy_loading' == presscore_get_config()->get( 'load_style' ) );
	}

endif;
