<?php
/**
 * Blog helpers
 *
 * @since 1.0.0
 * @package vogue
 */

if ( ! function_exists( 'presscore_display_related_posts' ) ) :

	/**
	 * Display related posts.
	 *
	 */
	function presscore_display_related_posts() {
		if ( !of_get_option( 'general-show_rel_posts', false ) ) {
			return '';
		}

		global $post;

		$html = '';
		$terms = array();

		switch ( get_post_meta( $post->ID, '_dt_post_options_related_mode', true ) ) {
			case 'custom': $terms = get_post_meta( $post->ID, '_dt_post_options_related_categories', true ); break;
			default: $terms = wp_get_object_terms( $post->ID, 'category', array('fields' => 'ids') );
		}

		if ( $terms && !is_wp_error($terms) ) {

			$attachments_data = presscore_get_related_posts( array(
				'cats'		=> $terms,
				'post_type' => 'post',
				'taxonomy'	=> 'category',
				'args'		=> array( 'posts_per_page' => intval(of_get_option('general-rel_posts_max', 12)) )
			) );

			$posts_list = presscore_get_posts_small_list( $attachments_data, array( 'image_dimensions' => array( 'w' => 110, 'h' => 80 ) ) );
			if ( $posts_list ) {
				$column_class = 'related-item';

				foreach ( $posts_list as $p ) {
					$html .= sprintf( '<div class=" %s">%s</div>', $column_class, $p );
				}

				$html = '<section class="items-grid">' . $html . '</section>';

				$head_title = esc_html( of_get_option( 'general-rel_posts_head_title', 'Related posts' ) );
				// add title
				if ( $head_title ) {
					$html = '<h3>' . $head_title . '</h3>' . $html;
				}

				$html = '<div class="single-related-posts">' . $html . '</div>';
			}
		}

		echo (string) apply_filters( 'presscore_display_related_posts', $html );
	}

endif;

if ( ! function_exists( 'presscore_get_blog_post_fancy_date' ) ) :

	/**
	 * Returns fancy date for posts
	 *
	 * @return string Fancy date html
	 */
	function presscore_get_blog_post_fancy_date() {
		$config = presscore_config();

		if ( ! $config->get( 'post.fancy_date.enabled' ) ) {
			return '';
		}

		$additional_classes = '';
		if ( 'right_list' == $config->get( 'layout' ) ) {
			$additional_classes .= 'right-aligned';
		}

		return presscore_get_post_fancy_date( $additional_classes );
	}

endif;

if ( ! function_exists( 'presscore_blog_fancy_date_class' ) ) :

	/**
	 * This function return fancy date class.
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function presscore_blog_fancy_date_class( $style = '' ) {
		if ( ! $style ) {
			$style = of_get_option( 'blog-fancy_date-style' );
		}

		$class = 'circle-fancy-style';
		switch ( $style ) {
			case 'vertical':
				$class = 'vertical-fancy-style';
				break;
			case 'horizontal':
				$class = 'horizontal-fancy-style';
				break;
		}

		return $class;
	}

endif;

if ( ! function_exists( 'presscore_get_post_fancy_category' ) ):

	/**
	 * Return fancy category HTML.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	function presscore_get_post_fancy_category( $args = array() ) {
		$default = array(
			'custom_text_color' => true,
			'custom_bg_color' => true,
		);
		$args = wp_parse_args( $args, $default );

		$post_type = get_post_type();

		if ( 'post' === $post_type ) {
			$taxonomy = 'category';
		} else {
			$taxonomy = "{$post_type}_category";
		}

		$terms = get_the_terms( get_the_ID(), $taxonomy );

		if ( is_wp_error( $terms ) ) {
			return '';
		}

		if ( empty( $terms ) ) {
			return '';
		}

		$links = array();

		foreach ( $terms as $term ) {
			$link = get_term_link( $term, $taxonomy );
			if ( is_wp_error( $link ) ) {
				return '';
			}

			$style = '';
			if ( $args['custom_bg_color'] ) {
				$bg_color = get_term_meta( $term->term_id, 'the7_fancy_bg_color', true );
				if ( $bg_color ) {
					$style .= 'background-color:' . $bg_color . ';';
				}
			}

			if ( $args['custom_text_color'] ) {
				$text_color = get_term_meta( $term->term_id, 'the7_fancy_text_color', true );
				if ( $text_color ) {
					$style .= 'color:' . $text_color . ';';
				}
			}

			if ( $style ) {
				$style = ' style="' . esc_attr( $style ) . '"';
			}

			$links[] = '<a href="' . esc_url( $link ) . '" rel="category tag"' . $style . '>' . $term->name . '</a>';
		}

		$term_links = apply_filters( "term_links-{$taxonomy}", $links );

		$sep = '';

		return '<span class="fancy-categories">' . join( $sep, $term_links ) . '</span>';
	}

endif;

if ( ! function_exists( 'presscore_get_blog_list_content_width' ) ) :

	function presscore_get_blog_list_content_width( $content_type = 'content' ) {
		static $static_content_width = null;

		if ( null == $static_content_width ) {

			$max_content_width = 100;
			$min_content_width = 0;
			$config = Presscore_Config::get_instance();
			$media_content_width = absint( $config->get( 'post.preview.media.width' ) );

			if ( $media_content_width > $max_content_width ) {
				$media_content_width = $max_content_width;

			} else if ( $media_content_width < $min_content_width ) {
				$media_content_width = $min_content_width;

			}

			$static_content_width = array();

			$static_content_width['media'] = $media_content_width;

			$static_content_width['content'] = $max_content_width - $media_content_width;
			if ( $static_content_width['content'] <= 0 ) {
				$static_content_width['content'] = 100;
			}

		}

		return array_key_exists($content_type, $static_content_width) ? $static_content_width[ $content_type ] : $static_content_width['content'];
	}

endif;

if ( ! function_exists( 'presscore_get_post_content_style_for_blog_list' ) ) :

	/**
	 * Get style attribute for content parts for blog posts
	 * 
	 * @param  string $content_type Content type: 'content' or 'media'
	 * @return string               Empty string for wide preview or if post type do not support media content, width style attribute in other case
	 */
	function presscore_get_post_content_style_for_blog_list( $content_type = 'content' ) {
		$config = Presscore_Config::get_instance();

		if ( 'wide' === $config->get( 'post.preview.width' ) ) {
			return '';
		}

		return sprintf( 'style="width: %s%%;"', presscore_get_blog_list_content_width( $content_type ) );
	}

endif;

if ( ! function_exists( 'presscore_blog_ajax_loading_responce' ) ) :

	function presscore_blog_ajax_loading_responce( $ajax_data = array() ) {
		global $post, $wp_query, $paged, $page;

		extract( $ajax_data );

		if ( !$nonce || !$post_id || !$post_paged || !$target_page || !wp_verify_nonce( $nonce, 'presscore-posts-ajax' ) ) {
			$responce = array( 'success' => false, 'reason' => 'corrupted data' );

		} else {

			require_once PRESSCORE_DIR . '/template-hooks.php';
			require_once PRESSCORE_EXTENSIONS_DIR . '/dt-pagination.php';

			$post_status = array(
				'publish',
			);

			if ( current_user_can( 'read_private_pages' ) ) {
				$post_status[] = 'private';
			}

			// get page
			query_posts( array(
				'post_type' => 'page',
				'page_id' => $post_id,
				'post_status' => $post_status,
				'page' => $target_page
			) );

			$html = '';
			if ( have_posts() && !post_password_required() ) : while ( have_posts() ) : the_post(); // main loop

				$config = Presscore_Config::get_instance();

				$config->set( 'template', 'blog' );
				$config->set( 'layout', empty( $page_data['layout'] ) ? 'masonry' : $page_data['layout'] );

				presscore_config_base_init();
				presscore_react_on_categorizer();

				do_action( 'presscore_before_loop' );

				ob_start();

				$query = presscore_get_blog_query();

				if ( $query->have_posts() ) {

					$page_layout = presscore_get_current_layout_type();
					$current_post = $posts_count;

					while( $query->have_posts() ) { $query->the_post();
/*
						// check if current post already loaded
						$key_in_loaded = array_search( $post->ID, $loaded_items );
						if ( false !== $key_in_loaded ) {
							unset( $loaded_items[ $key_in_loaded ] );
							continue;
						}
*/
						presscore_populate_post_config();

						switch ( $page_layout ) {
							case 'masonry':
								presscore_get_template_part( 'theme', 'blog/masonry/blog-masonry-post' );
								break;
							case 'list':
								// global posts counter
								$config->set( 'post.query.var.current_post', ++$current_post );

								presscore_get_template_part( 'theme', 'blog/list/blog-list-post' );
								break;
						}
					}

					wp_reset_postdata();

				}

				$html .= ob_get_clean();

			endwhile;

			$responce = array( 'success' => true );

			///////////////////
			// pagination //
			///////////////////

			$next_page_link = dt_get_next_posts_url( $query->max_num_pages );

			if ( $next_page_link ) {
				$responce['nextPage'] = the7_get_paged_var() + 1;

			} else {
				$responce['nextPage'] = 0;

			}

			$load_style = $config->get( 'load_style' );

			// pagination style
			if ( presscore_is_load_more_pagination() ) {
				$pagination = dt_get_next_page_button( $query->max_num_pages, 'paginator paginator-more-button with-ajax' );

				if ( $pagination ) {
					$responce['currentPage'] = the7_get_paged_var();
					$responce['paginationHtml'] = $pagination;
				} else {
					$responce['currentPage'] = $post_paged;
				}

				$responce['paginationType'] = 'more';

			} else if ( 'ajax_pagination' == $load_style ) {

				ob_start();
				dt_paginator( $query, array('class' => 'paginator with-ajax', 'ajaxing' => true ) );
				$pagination = ob_get_clean();

				if ( $pagination ) {
					$responce['paginationHtml'] = $pagination;
				}

				$responce['paginationType'] = 'paginator';

			}

			/////////////////
			// response //
			/////////////////

			$responce['itemsToDelete'] = array_values( $loaded_items );
			// $responce['query'] = $page_query->query;
			$responce['order'] = strtolower( $query->query['order'] );
			$responce['orderby'] = $query->query['orderby'];

			endif; // main loop

			$responce['html'] = $html;

		}

		return $responce;
	}

endif;

if ( ! function_exists( 'presscore_get_post_media_slider' ) ) :

	/**
	 * Post media slider.
	 *
	 * Based on royal slider. Properly works only in the loop.
	 *
	 * @since 1.0.0
	 * 
	 * @return string HTML.
	 */
	function presscore_get_post_media_slider( $attachments_data, $options = array() ) {
		if ( ! $attachments_data ) {
			return '';
		}

		$default_options = array(
			'class'	=> array(),
			'style'	=> ' style="width: 100%"',
			'proportions' => array( 'width' => '', 'height' => '' )
		);
		$options = wp_parse_args( $options, $default_options );

		$width = $options['proportions']['width'];
		$height = $options['proportions']['height'];

		$slideshow = presscore_get_photo_slider( $attachments_data, array(
			'width'		=> $width,
			'height'	=> $height,
			'class' 	=> $options['class'],
			'style'		=> $options['style'],
			'show_info'	=> array()
		) );

		return $slideshow;
	}

endif;

if ( ! function_exists( 'presscore_search_post_galleries' ) ) :

	/**
	 * Recursively search for gallery shortcodes in given content.
	 *
	 * @since 1.0.0
	 *
	 * @param  string  $content   Target content
	 * @param  boolean $html      If true - return array of galleries html
	 * @param  integer $num       Number of galleries to search
	 * @param  array   $galleries Base galleries array
	 * @return array              Found galleries array
	 */
	function presscore_search_post_galleries( $content = '', $html = true, $num = 0, $galleries = array() ) {
		if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $shortcode ) {
				if ( 'gallery' === $shortcode[2] ) {
					$srcs = array();

					$gallery = do_shortcode_tag( $shortcode );
					if ( $html ) {
						$galleries[] = $gallery;
					} else {
						preg_match_all( '#src=([\'"])(.+?)\1#is', $gallery, $src, PREG_SET_ORDER );
						if ( ! empty( $src ) ) {
							foreach ( $src as $s )
								$srcs[] = $s[2];
						}

						$data = shortcode_parse_atts( $shortcode[3] );
						$data['src'] = array_values( array_unique( $srcs ) );
						$galleries[] = $data;
					}
				}

				if ( $num && count( $galleries ) >= $num ) {
					break;
				}

				if ( ! empty( $shortcode[5] ) ) {
					$galleries = presscore_search_post_galleries( $shortcode[5], $html, $num, $galleries );
				}
			}
		}

		return $galleries;
	}

endif;

if ( ! function_exists( 'presscore_get_post_galleries_recursive' ) ) :

	/**
	 * Recursively search for gallery shortcodes in given post.
	 *
	 * @since 1.0.0
	 * 
	 * @param  integer $post Post ID
	 * @param  boolean $html If true - return array of galleries html
	 * @param  integer $num  Number of galleries to search
	 * @return array         Found galleries array
	 */
	function presscore_get_post_galleries_recursive( $post, $html = true, $num = 0 ) {
		if ( ! $post = get_post( $post ) )
			return array();

		if ( ! has_shortcode( $post->post_content, 'gallery' ) )
			return array();

		$galleries = presscore_search_post_galleries( $post->post_content, $html, $num );

		return apply_filters( 'presscore_get_post_galleries_recursive', $galleries, $post );
	}

endif;

if ( ! function_exists( 'presscore_get_post_gallery_recursive' ) ) :

	/**
	 * Return first gallery shortcode info in post.
	 *
	 * @since 1.0.0
	 * 
	 * @param  integer $post Post ID
	 * @param  boolean $html If true - return array of galleries html
	 * @return array         Found shotcode info
	 */
	function presscore_get_post_gallery_recursive( $post = 0, $html = true ) {
		$galleries = presscore_get_post_galleries_recursive( $post, $html, 2 );
		$gallery = reset( $galleries );

		return apply_filters( 'presscore_get_post_gallery_recursive', $gallery, $post, $galleries );
	}

endif;

if ( ! function_exists( 'presscore_post_buttons' ) ) :

	/**
	 * PressCore post Details and Edit buttons in <p> tag.
	 */
	function presscore_post_buttons() {
		echo presscore_post_details_link() . presscore_post_edit_link();
	}

endif;

if ( ! function_exists( 'presscore_get_blog_post_date' ) ) :

	/**
	 * Return post date only for blog. Reacts on themeoptions settings.
	 *
	 * @return string
	 */
	function presscore_get_blog_post_date() {
		$post_meta = of_get_option( 'general-blog_meta_on', 1 );
		$post_date = of_get_option( 'general-blog_meta_date', 1 );

		if ( !$post_meta ) {
			return '';
		}

		if ( !$post_date ) {
			return '&nbsp;';
		}

		return presscore_get_post_data();
	}

endif;

if ( ! function_exists( 'presscore_get_blog_query' ) ) :

	function presscore_get_blog_query() {
		$config = presscore_get_config();
		$orderby = $config->get( 'orderby' );

		$query_args = array(
			'post_type'		    => 'post',
			'post_status'	    => 'publish',
			'paged'			    => the7_get_paged_var(),
			'order'			    => $config->get( 'order' ),
			'orderby'		    => 'name' == $orderby ? 'title' : $orderby,
			'suppress_filters'  => false,
		);

		$ppp = $config->get( 'posts_per_page' );
		if ( $ppp ) {
			$query_args['posts_per_page'] = intval( $ppp );
		}

		$display = $config->get( 'display' );
		if ( ! empty( $display['terms_ids'] ) ) {
			$terms_ids = array_values($display['terms_ids']);

			switch( $display['select'] ) {
				case 'only':
					$query_args['category__in'] = $terms_ids;
					break;

				case 'except':
					$query_args['category__not_in'] = $terms_ids;
			}

		}

		// get filter request
		$request_display = $config->get('request_display');
		if ( $request_display ) {

			// get all category terms
			$all_terms = get_categories( array(
				'type'          => 'post',
				'hide_empty'    => 1,
				'hierarchical'  => 0,
				'taxonomy'      => 'category',
				'pad_counts'    => false
			) );

			// populate $all_terms_array with terms names
			$all_terms_array = array();
			foreach ( $all_terms as $term ) {
				$all_terms_array[] = $term->term_id;
			}

			// except for empty term that appers when all filter category selcted, see it's url
			if ( 0 == current($request_display['terms_ids']) ) {
				$request_display['terms_ids'] = $all_terms_array;
			}

			// override base tax_query
			$query_args['tax_query'] = array( array(
				'taxonomy'	=> 'category',
				'field'		=> 'id',
				'terms'		=> array_values($request_display['terms_ids']),
				'operator'	=> 'IN',
			) );

			if ( 'except' == $request_display['select'] ) {
				$query_args['tax_query'][0]['operator'] = 'NOT IN';
			}
		}

		$query = new WP_Query( $query_args );

		return $query;
	}

endif;

if ( ! function_exists( 'the7_calculate_bwb_image_resize_options' ) ) {

	/**
	 * Return image resize options based on various parameters.
	 *
	 * @param array $columns
	 * @param int   $columns_gap
	 * @param bool  $image_is_wide
	 *
	 * @return array
	 * @since 6.3.2
	 */
	function the7_calculate_bwb_image_resize_options( $columns, $columns_gap, $image_is_wide = false ) {
		$config = presscore_config();

		$img_width_calculator_config = new The7_Image_Width_Calculator_Config(
			array(
				'columns'             => $columns,
				'columns_gaps'        => $columns_gap,
				'content_width'       => of_get_option( 'general-content_width' ),
				'sidebar_enabled'     => ( 'disabled' !== $config->get( 'sidebar_position' ) ),
				'sidebar_on_mobile'   => ( ! $config->get( 'sidebar_hide_on_mobile' ) ),
				'sidebar_width'       => of_get_option( 'sidebar-width' ),
				'sidebar_gap'         => of_get_option( 'sidebar-distance_to_content' ),
				'sidebar_switch'      => of_get_option( 'sidebar-responsiveness' ),
				'image_is_wide'       => $image_is_wide,
			)
		);
		$img_width_calculator        = new The7_Image_BWB_Width_Calculator( $img_width_calculator_config );

		return $img_width_calculator->calculate_options();
	}
}

if ( ! function_exists( 'the7_calculate_image_resize_options_for_list_layout' ) ) {

	/**
	 * Return image resize options for list layout.
	 *
	 * @param string $image_width
	 * @param string $mobile_switch
	 * @param int    $right_padding
	 * @param int    $left_padding
	 * @param bool   $image_is_wide
	 *
	 * @return array
	 *
	 * @since 8.0.0
	 */
	function the7_calculate_image_resize_options_for_list_layout( $image_width, $mobile_switch, $right_padding, $left_padding, $image_is_wide = false ) {
		$config = presscore_config();

		$image_width_config = new The7_Image_List_Width_Calculator_Config(
			array(
				'content_width'     => of_get_option( 'general-content_width' ),
				'sidebar_enabled'   => ( 'disabled' !== $config->get( 'sidebar_position' ) ),
				'sidebar_on_mobile' => ( ! $config->get( 'sidebar_hide_on_mobile' ) ),
				'sidebar_width'     => of_get_option( 'sidebar-width' ),
				'sidebar_gap'       => of_get_option( 'sidebar-distance_to_content' ),
				'sidebar_switch'    => of_get_option( 'sidebar-responsiveness' ),
				'image_is_wide'     => $image_is_wide,
				'image_width'       => $image_width,
				'mobile_switch'     => $mobile_switch,
				'right_padding'     => $right_padding,
				'left_padding'      => $left_padding,
			)
		);
		$image_width_calc   = new The7_Image_List_Width_Calculator( $image_width_config );

		return $image_width_calc->calculate_options();
	}

}

if ( ! function_exists( 'the7_calculate_columns_based_image_resize_options' ) ) {

	/**
	 * Calculate image resize options based on columns and minimum image width.
	 *
	 * @since 6.7.0
	 *
	 * @param string|int $width
	 * @param string|int $content_width
	 * @param string|int $columns
	 * @param bool $is_wide
	 *
	 * @return array
	 */
	function the7_calculate_columns_based_image_resize_options( $width, $content_width, $columns, $is_wide = false ) {
		$width = absint( $width );
		if ( ! $width ) {
			return array();
		}

		if ( false !== strpos( $content_width, '%' ) ) {
			$content_width = round( (int) $content_width * 19.20 );
		}
		$content_width = (int) $content_width;

		$columns = absint( $columns );
		if ( $columns ) {
			$width = max( array( $content_width / $columns, $width ) );
		}

		if ( $is_wide ) {
			$width *= 3;
		} else {
			$width *= 1.5;
		}

		return array(
			'w'          => round( $width ),
			'z'          => 0,
			'hd_convert' => ! $is_wide,
		);
	}
}