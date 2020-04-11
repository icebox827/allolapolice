<?php
/**
 * Helpers.
 *
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

//////////////////////////
// include helpers libs //
//////////////////////////

require_once PRESSCORE_HELPERS_DIR . '/query.php';
require_once PRESSCORE_HELPERS_DIR . '/archive-functions.php';
require_once PRESSCORE_HELPERS_DIR . '/html-helpers.php';
require_once PRESSCORE_HELPERS_DIR . '/blog-helpers.php';
require_once PRESSCORE_HELPERS_DIR . '/widget-areas.php';
require_once PRESSCORE_HELPERS_DIR . '/masonry-template.php';
require_once PRESSCORE_HELPERS_DIR . '/microsite-template.php';
require_once PRESSCORE_HELPERS_DIR . '/list-template.php';
require_once PRESSCORE_HELPERS_DIR . '/post-navigation.php';
require_once PRESSCORE_HELPERS_DIR . '/page-title.php';
require_once PRESSCORE_HELPERS_DIR . '/comments-helpers.php';
require_once PRESSCORE_HELPERS_DIR . '/header-helpers.php';
require_once PRESSCORE_HELPERS_DIR . '/sanitize-functions.php';
require_once PRESSCORE_HELPERS_DIR . '/template-config.php';
require_once PRESSCORE_HELPERS_DIR . '/options.php';
require_once PRESSCORE_HELPERS_DIR . '/menu.php';
require_once PRESSCORE_HELPERS_DIR . '/logo.php';
require_once PRESSCORE_HELPERS_DIR . '/image-functions.php';

if ( ! function_exists( 'presscore_get_post_fancy_date' ) ) :

	/**
	 * Return fancy date html
	 *
	 * @since 1.0.0
	 * 
	 * @param  string $new_class Additional class
	 * @return string            Fancy date html
	 */
	function presscore_get_post_fancy_date( $new_class = '' ) {

		if ( !in_the_loop() ) {
			return '';
		}

		$class = 'fancy-date' . ( $new_class ? ' ' . trim($new_class) : '' );
		$href = 'javascript:void(0);';

		if ( 'post' == get_post_type() ) {

			// remove link if in date archive
			if ( !(is_day() && is_month() && is_year()) ) {

				$href = presscore_get_post_day_link();
			}
		}

		return sprintf(
			'<div class="%s"><a title="%s" href="%s" rel="nofollow"><span class="entry-month">%s</span><span class="entry-date updated">%s</span><span class="entry-year">%s</span></a></div>',
				esc_attr( $class ), // class
				esc_attr( get_the_time() ),	// title
				$href,	// href
				esc_attr( get_the_date( 'M' ) ),	// month
				esc_html( get_the_date( 'j' ) ),	// date
				esc_html( get_the_date( 'Y' ) )	// year
		);

	}

endif;

if ( ! function_exists( 'presscore_is_post_navigation_enabled' ) ) :

	/**
	 * Check if post navigation enabled.
	 *
	 * @return bool
	 */
	function presscore_is_post_navigation_enabled() {
		return presscore_get_config()->get( 'post.navigation.arrows.enabled' );
	}

endif;

if ( ! function_exists( 'presscore_is_post_title_enabled' ) ) :

	/**
	 * Check if post title enabled.
	 * 
	 * @return bool
	 */
	function presscore_is_post_title_enabled() {
		return in_array( presscore_get_config()->get( 'header_title' ), array( 'enabled', '' ) );
	}

endif;

if ( ! function_exists( 'presscore_get_current_template_type' ) ) :

	/**
	 * Get layout type based on current layout in theme config
	 *
	 * @since 1.0.0
	 * @return string Layout type (masonry, list) or empty string on failure
	 */
	function presscore_get_current_layout_type() {
		$config = presscore_get_config();

		$layout_type = $config->get( 'template.layout.type' );
		if ( $layout_type ) {
			return $layout_type;
		}

		$current_layout = $config->get( 'layout' );
		if ( in_array( $current_layout, array( 'masonry', 'grid' ) ) ) {
			$layout_type = 'masonry';

		} else if ( in_array( $current_layout, array( 'list', 'right_list', 'checkerboard' ) ) ) {
			$layout_type = 'list';

		} else {
			$layout_type = '';

		}

		return $layout_type;
	}

endif;

if ( ! function_exists( 'presscore_get_categorizer_sorting_fields' ) ) :

	/**
	 * Get Categorizer sorting fields.
	 *
	 * @since 1.0.0
	 */
	function presscore_get_categorizer_sorting_fields( $select, $term_id, $order, $orderby, $show_order, $show_orderby ) {
		$term = '';

		if ( 'except' == $select && 0 === $term_id ) {
			$term = 'none';

		} else if ( 'only' == $select ) {
			$term = absint( $term_id );

		}

		$paged = the7_get_paged_var();

		if ( $paged > 1 ) {
			$link = get_pagenum_link($paged, false);
		} else {
			$link = get_permalink();
		}

		//////////////
		// output //
		//////////////

		if ( $term ) {
			$link = add_query_arg( 'term', $term, $link );
		}

		$act = ' act';
		$display_none = ' style="display: none;"';

		$html =	'<div class="filter-extras">'
			.'<div class="filter-by"' . ( $show_orderby ? '' : $display_none ) . '>'
				. '<a href="' . esc_url( add_query_arg( array( 'orderby' => 'date', 'order' => $order ), $link ) ) . '" class="sort-by-date' . ('date' == $orderby ? $act : '') . '" data-by="date"><i class="dt-icon-the7-sort-02"></i><span class="filter-popup">' . __( 'Sort by date', 'the7mk2' ) . '</span></a>'
				. '<span class="filter-switch"></span>'
				. '<a href="' . esc_url( add_query_arg( array( 'orderby' => 'name', 'order' => $order ), $link ) ) . '" class="sort-by-name' . ('name' == $orderby ? $act : '') . '" data-by="name"><i class="dt-icon-the7-sort-03" aria-hidden="true"></i><span class="filter-popup">' . __( 'Sort by name', 'the7mk2' ) . '</span></a>'
			. '</div>'

			. '<div class="filter-sorting"' . ( $show_order ? '' : $display_none ) . '>'
				. '<a href="' . esc_url( add_query_arg( array( 'orderby' => $orderby, 'order' => 'DESC' ), $link ) ) . '" class="sort-by-desc' . ('desc' == $order ? $act : '') . '" data-sort="desc"><i class="dt-icon-the7-sort-00" aria-hidden="true"></i><span class="filter-popup">' . __( 'Descending', 'the7mk2' ) . '</span></a>'
				. '<span class="filter-switch"></span>'
				. '<a href="' . esc_url( add_query_arg( array( 'orderby' => $orderby, 'order' => 'ASC' ), $link ) ) . '" class="sort-by-asc' . ('asc' == $order ? $act : '') . '" data-sort="asc"><i class="dt-icon-the7-sort-01" aria-hidden="true"></i><span class="filter-popup">' . __( 'Ascending', 'the7mk2' ) . '</span></a>'
			. '</div>'
		. '</div>';

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_get_category_list' ) ) :

	// TODO: refactor this!
	/**
	 * Categorizer.
	 */
	function presscore_get_category_list( $args = array() ) {
		global $post;

		$defaults = array(
			'item_wrap'         => '<a href="%HREF%" %CLASS% data-filter="%CATEGORY_ID%">%TERM_NICENAME%</a>',
			'hash'              => '#!term=%TERM_ID%&amp;page=%PAGE%&amp;orderby=date&amp;order=DESC',
			'item_class'        => '',
			'all_class'        	=> 'show-all',
			'other_class'		=> '',
			'class'             => 'filter',
			'current'           => 'all',
			'page'              => '1',
			'ajax'              => false,
			'all_btn'           => true,
			'other_btn'         => true,
			'echo'				=> true,
			'data'				=> array(),
			'before'			=> '<div class="filter-categories">',
			'after'				=> '</div>',
			'act_class'			=> 'act',
		);
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'presscore_get_category_list-args', $args );

		$data = $args['data'];

		$args['hash'] = str_replace( array( '%PAGE%' ), array( $args['page'] ), $args['hash'] );
		$output = $all = '';

		if ( isset($data['terms']) &&
		     ! is_wp_error( $data['terms'] ) &&
			( ( count( $data['terms'] ) == 1 && !empty( $data['other_count'] ) ) ||
			count( $data['terms'] ) > 1 )
		) {

			$replace_list = array( '%HREF%', '%CLASS%', '%TERM_DESC%', '%TERM_NICENAME%', '%TERM_SLUG%', '%TERM_ID%', '%COUNT%', '%CATEGORY_ID%' );

			$terms_done = array();
			foreach( $data['terms'] as $term ) {

				// Prevent duplication.
				if ( in_array( $term->term_id, $terms_done ) ) {
					continue;
				}
				$terms_done[] = $term->term_id;

				$item_class = array();

				if ( !empty( $args['item_class'] ) ) {
					$item_class[] = $args['item_class'];
				}

				if ( in_array( (string) $args['current'], array( (string) $term->term_id, (string) $term->slug ), true ) ) {
					$item_class[] = $args['act_class'];
				}

				$item_class[] = (string) $term->slug;

				if ( $item_class ) {
					$item_class = sprintf( 'class="%s"', esc_attr( implode( ' ', $item_class ) ) );
				} else {
					$item_class = '';
				}

				$output .= str_replace(
					$replace_list,
					array(
						esc_url( str_replace( array( '%TERM_ID%' ), array( $term->term_id ), $args['hash'] ) ),
						$item_class,
						$term->description,
						$term->name,
						$term->slug,
						$term->term_id,
						$term->count,
						".category-{$term->term_id}"
					), $args['item_wrap']
				);
			}

			// all button
			if ( $args['all_btn'] ) {
				$all_class = array();

				if ( !empty( $args['all_class'] ) ) {
					$all_class[] = $args['all_class'];
				}

				if ( 'all' == $args['current'] ) {
					$all_class[] = $args['act_class'];
				}

				if ( $all_class ) {
					$all_class = sprintf( 'class="%s"', esc_attr( implode( ' ', $all_class ) ) );
				} else {
					$all_class = '';
				}

				$all = str_replace(
					$replace_list,
					array(
						esc_url( str_replace( array( '%TERM_ID%' ), array( '' ), $args['hash'] ) ),
						$all_class,
						__( 'All posts', 'the7mk2' ),
						__( 'View all', 'the7mk2' ),
						'',
						'',
						$data['all_count'],
						'*',
					), $args['item_wrap']
				);
			}

			// other button
			if( $data['other_count'] && $args['other_btn'] ) {
				$other_class = array();
				
				if ( !empty( $args['other_class'] ) ) {
					$other_class[] = $args['other_class'];
				}

				if ( 'none' == $args['current'] ) {
					$other_class[] = $args['act_class'];
				}

				if ( $other_class ) {
					$other_class = sprintf( 'class="%s"', esc_attr( implode( ' ', $other_class ) ) );
				} else {
					$other_class = '';
				}

				$output .= str_replace(
					$replace_list,
					array(
						esc_url( str_replace( array( '%TERM_ID%' ), array( 'none' ), $args['hash'] ) ),
						$other_class,
						__( 'Other posts', 'the7mk2' ),
						__( 'Other', 'the7mk2' ),
						'',
						0,
						$data['other_count'],
						esc_attr('.category-0'),
					), $args['item_wrap']
				); 
			}

			$config = presscore_config();

			$output = '<div class="filter-categories" data-default-order="' . esc_attr( strtolower( $config->get( 'order' ) ) ) . '" data-default-orderby="' . esc_attr( strtolower( $config->get( 'orderby' ) ) ) . '">' . $all . $output . '</div>';
			$output = str_replace( array( '%CLASS%' ), array( $args['class'] ), $output );
		}

		if ( empty( $args['sorting'] ) ) {
			$config         = presscore_config();
			$filter_request = $config->get( 'request_display' );
			if ( $filter_request === null ) {
				$filter_request           = (array) $config->get( 'display' );
				$filter_request['select'] = 'all';
			}

			$args['sorting'] = array(
				'order'        => strtolower( $config->get( 'order' ) ),
				'orderby'      => strtolower( $config->get( 'orderby' ) ),
				'show_order'   => $config->get( 'template.posts_filter.order.enabled' ),
				'show_orderby' => $config->get( 'template.posts_filter.orderby.enabled' ),
				'select'       => isset( $filter_request['select'] ) ? $filter_request['select'] : 'all',
				'term_id'      => isset( $filter_request['terms_ids'] ) ? current( (array) $filter_request['terms_ids'] ) : array(),
			);
		}
		$sorting_args = $args['sorting'];

		if ( $sorting_args['show_order'] || $sorting_args['show_orderby'] ) {
			$output .= presscore_get_categorizer_sorting_fields(
				$sorting_args['select'],
				$sorting_args['term_id'],
				$sorting_args['order'],
				$sorting_args['orderby'],
				$sorting_args['show_order'],
				$sorting_args['show_orderby']
			);
		}

		$output = apply_filters( 'presscore_get_category_list', $output, $args );

		if ( $args['echo'] ) {
			echo $output;
		} else {
			return $output;
		}
		return false;
	}

endif;

if ( ! function_exists( 'presscore_get_posts_small_list' ) ) :

	/**
	 * Description here.
	 *
	 * Some sort of images list with some description and post title and date ... eah
	 *
	 * @return array Array of items or empty array.
	 */
	function presscore_get_posts_small_list( $attachments_data, $options = array() ) {
		if ( empty( $attachments_data ) ) {
			return array();
		}

		global $post;
		$default_options = array(
			'links_rel' => '',
			'show_images' => true,
			'show_excerpts' => false,
			'image_dimensions' => array( 'w' => 60, 'h' => 60 )
		);
		$options = wp_parse_args( $options, $default_options );

		$image_args = array(
			'img_class' => '',
			'class'		=> 'alignleft post-rollover',
			'custom'	=> $options['links_rel'],
			'options'	=> array( 'w' => $options['image_dimensions']['w'], 'h' => $options['image_dimensions']['h'], 'z' => true ),
			'echo'		=> false,
		);

		$articles = array();
		$class = '';
		$post_was_changed = false;
		$post_backup = $post;

		presscore_remove_masonry_lazy_load_attrs();

		foreach ( $attachments_data as $data ) {

			$new_post = null;

			if ( isset( $data['parent_id'] ) ) {

				$post_was_changed = true;
				$new_post = get_post( $data['parent_id'] );

				if ( $new_post ) {
					$post = $new_post;
					setup_postdata( $post );
				}
			}

			$permalink = esc_url($data['permalink']);

			$attachment_args = array(
				'href'		=> $permalink,
				'img_meta' 	=> array( $data['full'], $data['width'], $data['height'] ),
				'img_id'	=> empty($data['ID']) ? 0 : $data['ID'],
				'echo'		=> false,
				'custom'    => 'aria-label="' . esc_attr__( 'Post image', 'the7mk2' ) . '"',
				'wrap'		=> '<a %CLASS% %HREF% %CUSTOM%><img %IMG_CLASS% %SRC% %SIZE% %ALT% /></a>',
			);

			// show something if there is no title
			if ( empty($data['title']) ) {
				$data['title'] = __( 'No title', 'the7mk2');
			}

			if ( !empty( $data['parent_id'] ) ) {
				$class = 'post-format-standard';

				if ( empty($data['ID']) ) {
					$attachment_args['wrap'] = '<a class="' . esc_attr( $image_args['class'] . ' no-avatar' ) . '" %HREF% %TITLE% style="width:' . $options['image_dimensions']['w'] . 'px; height: ' . $options['image_dimensions']['h'] . 'px;" %CUSTOM%></a>';
					$attachment_args['img_meta'] = array('', 0, 0);
					$attachment_args['options'] = false;
				}
			}

			$article = '';
			$article .= '<article class="' . esc_attr( $class ) . '">';
			
				$image = '';
				if ( $options['show_images']  ) {
				$image = sprintf( '<div class="mini-post-img">%s</div>', dt_get_thumb_img( array_merge( $image_args, $attachment_args ) ) );
				}

				$article .= $image;

				$article .= '<div class="post-content">';
					$article .= '<a href="' . $permalink . '">' . apply_filters( 'post_title', $data['title'] ) . '</a>';

					if ( $options['show_excerpts'] ) {
						$article .= '<p class="text-small">' . esc_html( $data['description'] ) . '</p>';
					} else {
						$article .= '<br />';
					}

					$article .= '<time class="text-secondary" datetime="' . get_the_date('c') . '">' . get_the_date(get_option('date_format')) . '</time>';
				$article .= '</div>';
			$article .= '</article>';

			$articles[] = $article;
		}

		presscore_add_masonry_lazy_load_attrs();

		if ( $post_was_changed ) {
			$post = $post_backup;
			setup_postdata( $post );
		}

		return $articles;
	}

endif;

if ( ! function_exists( 'presscore_is_content_visible' ) ) :

	/**
	 * Flag to check is content visible.
	 *
	 * @return boolean Returns true or false.
	 */
	function presscore_is_content_visible() {
		if ( post_password_required() ) {
			return true;
		}

		$config = presscore_get_config();

		$hide_content_for_photo_scroller_in_album_post = 'photo_scroller' == $config->get( 'post.media.type' ) 
			&& 'fullscreen' == $config->get( 'post.media.photo_scroller.layout' );

		$hide_content_for_photo_scroller_slideshow = 'slideshow' == $config->get('header_title') 
			&& 'photo_scroller' == $config->get('slideshow_mode') 
			&& 'fullscreen' == $config->get( 'slideshow.photo_scroller.layout' );

		$content_is_visible = !( $hide_content_for_photo_scroller_in_album_post || $hide_content_for_photo_scroller_slideshow );

		return apply_filters( 'presscore_is_content_visible', $content_is_visible );
	}

endif; // presscore_is_content_visible

if ( ! function_exists( 'presscore_get_attachments_data_count' ) ) :

	/**
	 * Counts attachments data images and videos.
	 *
	 * @return array
	 */
	function presscore_get_attachments_data_count( $attachments_ids = array() ) {
		$images_count = 0;
		$videos_count = 0;

		if ( !empty( $attachments_ids ) ) {

			foreach ( $attachments_ids as $id ) {

				if ( false != get_post_meta( $id, 'dt-video-url', true ) ) {
					$videos_count++;

				} else {
					$images_count++;

				}

			}

		}

		return array( $images_count, $videos_count );
	}

endif; // presscore_get_attachments_data_count

if ( ! function_exists( 'presscore_vc_is_inline' ) ) :

	function presscore_vc_is_inline() {
		return function_exists( 'vc_is_inline' ) && vc_is_inline();
	}

endif;

if ( ! function_exists( 'presscore_image_title_enabled' ) ) :

	function presscore_image_title_enabled( $image_id ) {
		return ! get_post_meta( $image_id, 'dt-img-hide-title', true );
	}

endif;

if ( ! function_exists( 'presscore_get_attachment_post_data' ) ) :

	/**
	 * Get attachments post data.
	 *
	 * @param array $media_items Attachments id's array.
	 * @return array Attachments data.
	 */
	function presscore_get_attachment_post_data( $media_items, $orderby = 'post__in', $order = 'DESC', $posts_per_page = -1 ) {
		if ( empty( $media_items ) ) {
			return array();
		}

		global $post;

		// sanitize $media_items
		$media_items = array_diff( array_unique( array_map( "absint", $media_items ) ), array(0) );

		if ( empty( $media_items ) ) {
			return array();
		}

		$attachments_data = array();

		foreach ( $media_items as $post_id ) {
			$post_id = apply_filters( 'wpml_object_id', $post_id, 'attachment', true );
			$data = array();

			// attachment meta
			$data['full'] = $data['width'] = $data['height'] = '';
			$meta = wp_get_attachment_image_src( $post_id, 'full' );
			if ( !empty($meta) ) {
				$data['full'] = esc_url($meta[0]);
				$data['width'] = absint($meta[1]);
				$data['height'] = absint($meta[2]);
			}

			$data['thumbnail'] = wp_get_attachment_image_src( $post_id, 'thumbnail' );
			$data['alt'] = esc_attr( get_post_meta( $post_id, '_wp_attachment_image_alt', true ) );

			$data['caption'] = '';
			$data['description'] = '';
			$_post = get_post( $post_id );
			if ( $_post ) {
				$data['caption'] = $_post->post_excerpt;
				$data['description'] = $_post->post_content;
			}

			$data['title'] = get_the_title( $post_id );
			$data['permalink'] = get_permalink( $post_id );
			$data['video_url'] = esc_url( get_post_meta( $post_id, 'dt-video-url', true ) );
			$data['link'] = presscore_get_image_link( $post_id );
			$data['mime_type_full'] = get_post_mime_type( $post_id );
			$data['mime_type'] = dt_get_short_post_myme_type( $post_id );
			$data['ID'] = $post_id;

			// attachment meta
			$data['meta'] = presscore_get_posted_on();

			$attachments_data[] = apply_filters( 'presscore_get_attachment_post_data-attachment_data', $data, $media_items );
		}

		return $attachments_data;
	}

endif;

if ( ! function_exists( 'presscore_get_posts_in_categories' ) ) :

	/**
	 * Get posts by categories.
	 *
	 * @return object WP_Query Object. 
	 */
	function presscore_get_posts_in_categories( $options = array() ) {

		$default_options = array(
			'post_type'	=> 'post',
			'taxonomy'	=> 'category',
			'field'		=> 'term_id',
			'cats'		=> array( 0 ),
			'select'	=> 'all',
			'args'		=> array(),
		);

		$options = wp_parse_args( $options, $default_options );

		$args = array(
			'posts_per_page'	=> -1,
			'post_type'			=> $options['post_type'],
			'no_found_rows'     => 1,
			'post_status'       => 'publish',
			'suppress_filters'  => false,
			'tax_query'         => array( array(
				'taxonomy'      => $options['taxonomy'],
				'field'         => $options['field'],
				'terms'         => $options['cats'],
			) ),
		);

		$args = array_merge( $args, $options['args'] );

		switch( $options['select'] ) {
			case 'only': $args['tax_query'][0]['operator'] = 'IN'; break;
			case 'except': $args['tax_query'][0]['operator'] = 'NOT IN'; break;
			default: unset( $args['tax_query'] );
		}

		return new WP_Query( apply_filters( 'the7_related_posts_query_args', $args ) );
	}

endif;

if ( ! function_exists( 'presscore_get_related_posts' ) ) :

	/**
	 * Get related posts attachments data slightly modified.
	 *
	 * @return array Attachments data.
	 */
	function presscore_get_related_posts( $options = array() ) {
		$default_options = array(
			'select'			=> 'only',
			'exclude_current'	=> true,
			'args'				=> array(),
		);

		$options = wp_parse_args( $options, $default_options );

		// exclude current post if in the loop
		if ( in_the_loop() && $options['exclude_current'] ) {
			$options['args'] = array_merge( $options['args'], array( 'post__not_in' => array( get_the_ID() ) ) );
		}

		$posts = presscore_get_posts_in_categories( $options );

		$attachments_ids = array();
		$attachments_data_override = array();
		$posts_data = array();

		// get posts attachments id
		if ( $posts->have_posts() ) {

			global $post;
			$post_back = $post;

			while ( $posts->have_posts() ) { $posts->the_post();

				// thumbnail or first attachment id
				if ( has_post_thumbnail() ) {
					$attachment_id = get_post_thumbnail_id();

				} else if ( $attachment = presscore_get_first_image() ) {
					$attachment_id = $attachment->ID;

				} else {
					$attachment_id = 0;

				}

				$post_data = array();

				/////////////////////////
				// attachment data //
				/////////////////////////

				$post_data['full'] = $post_data['width'] = $post_data['height'] = '';
				$meta = wp_get_attachment_image_src( $attachment_id, 'full' );
				if ( !empty($meta) ) {
					$post_data['full'] = esc_url($meta[0]);
					$post_data['width'] = absint($meta[1]);
					$post_data['height'] = absint($meta[2]);
				}

				$post_data['thumbnail'] = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );

				$post_data['caption'] = '';
				$post_data['video_url'] = esc_url( get_post_meta( $attachment_id, 'dt-video-url', true ) );
				$post_data['mime_type_full'] = get_post_mime_type( $attachment_id );
				$post_data['mime_type'] = dt_get_short_post_myme_type( $attachment_id );
				$post_data['ID'] = $attachment_id;

				$post_data['image_attachment_data'] = array(
					'caption' => $post_data['caption'],
					'description' => wp_kses_post( get_post_field( 'post_content', $attachment_id ) ),
					'title' => presscore_imagee_title_is_hidden( $attachment_id ) ? '' : get_the_title( $attachment_id ),
					'permalink' => get_permalink( $attachment_id ),
					'video_url' => $post_data['video_url'],
					'ID' => $attachment_id
				);

				///////////////////
				// post data //
				///////////////////

				$post_data['title'] = get_the_title();
				$post_data['permalink'] = get_permalink();
				$post_data['link'] = presscore_get_project_link('project-link');
				$post_data['description'] = get_the_excerpt();
				$post_data['alt'] = get_the_title();
				$post_data['parent_id'] = get_the_ID();
				$post_data['meta'] = presscore_get_posted_on();

				// save data
				$posts_data[] = $post_data;
			}

			$post = $post_back;
			setup_postdata( $post );
		}

		return $posts_data;
	}

endif;

if ( ! function_exists( 'presscore_get_project_link' ) ) :

	/**
	 * Get project link.
	 *
	 * @param string $class
	 * @param string $before_title
	 * @param string $after_title
	 * @return string
	 */
	function presscore_get_project_link( $class = 'link dt-btn', $before_title = '', $after_title = '' ) {
		if ( post_password_required() || !in_the_loop() ) {
			return '';
		}

		$config = presscore_get_config();

		// project link html
		$project_link = '';
		if ( $config->get( 'post.buttons.link.enabled' ) ) {

			$title = $config->get( 'post.buttons.link.title' );
			if ( ! $title ) {
				$class .= ' no-text';
			}

			$project_link = presscore_get_button_html( array(
				'title'		=> $before_title . ( $title ? $title : __( 'Link', 'the7mk2' ) ) . $after_title,
				'href'		=> $config->get( 'post.buttons.link.url' ),
				'target'	=> $config->get( 'post.buttons.link.target_blank' ),
				'class'		=> $class,
			) );
		}

		return $project_link;
	}

endif;

if ( ! function_exists( 'presscore_get_first_image' ) ) :

	/**
	 * Get first image associated with the post.
	 *
	 * @param integer $post_id Post ID.
	 * @return mixed Return (object) attachment on success ar false on failure.
	 */
	function presscore_get_first_image( $post_id = null ) {
		if ( in_the_loop() && !$post_id ) {
			$post_id = get_the_ID();
		}

		if ( !$post_id ) {
			return false;
		}

		$args = array(
			'posts_per_page' 	=> 1,
			'order'				=> 'ASC',
			'post_mime_type' 	=> 'image',
			'post_parent' 		=> $post_id,
			'post_status'		=> 'inherit',
			'post_type'			=> 'attachment',
		);

		$attachments = get_children( $args );

		if ( $attachments ) {
			return current($attachments);
		}

		return false;
	}

endif;

if ( ! function_exists( 'presscore_responsive' ) ) :

	/**
	 * Set some responsivness flag.
	 */
	function presscore_responsive() {
		return absint( of_get_option( 'general-responsive', 1 ) );
	}

endif;

if ( ! function_exists( 'presscore_the_excerpt' ) ) :

	/**
	 * Echo custom content.
	 *
	 */
	function presscore_the_excerpt() {
		echo presscore_get_the_excerpt();
	}

endif;

if ( ! function_exists( 'presscore_get_the_excerpt' ) ) :

	/**
	 * Show content with funny details button.
	 *
     * @return string
	 */
	function presscore_get_the_excerpt() {
		global $post;

		add_filter( 'wp_trim_words', 'the7_hide_details_link_for_small_auto_excerpt', 10, 4 );
		$excerpt = apply_filters( 'the_excerpt', get_the_excerpt( $post ) );
		remove_filter( 'wp_trim_words', 'the7_hide_details_link_for_small_auto_excerpt' );

		return $excerpt;
	}

endif;

if ( ! function_exists( 'the7_hide_details_link_for_small_auto_excerpt' ) ) {

	/**
     * This filter hide details button on blog template if original text is smaller or equal than trim words limit.
     *
	 * @param string $text          The trimmed text.
	 * @param int    $num_words     The number of words to trim the text to. Default 55.
	 * @param string $more          An optional string to append to the end of the trimmed text, e.g. &hellip;.
	 * @param string $original_text The text before it was trimmed.
	 *
	 * @return string
	 */
	function the7_hide_details_link_for_small_auto_excerpt( $text, $num_words, $more, $original_text ) {
		if ( $text && $text === wp_strip_all_tags( $original_text ) ) {
			// Hide details button.
			add_filter( 'presscore_post_details_link', 'presscore_return_empty_string', 15 );
		}

		return $text;
	}
}

if ( ! function_exists( 'presscore_imagee_title_is_hidden' ) ) :

	/**
	 * Check image title status.
	 *
	 */
	function presscore_imagee_title_is_hidden( $img_id ) {
		return get_post_meta( $img_id, 'dt-img-hide-title', true );
	}

endif;

if ( ! function_exists( 'presscore_get_image_video_url' ) ) :

	/**
	 * @param  int $img_id
	 * @return string
	 */
	function presscore_get_image_video_url( $img_id ) {
		return esc_url( get_post_meta( $img_id, 'dt-video-url', true ) );
	}

endif;

if ( ! function_exists( 'presscore_get_image_link' ) ) :

	/**
	 * Return escaped image link.
	 *
	 * @since 4.2.1
	 *
	 * @param  int $img_id
	 *
	 * @return string
	 */
	function presscore_get_image_link( $img_id ) {
		return esc_url( get_post_meta( $img_id, 'dt-img-link', true ) );
	}

endif;

if ( ! function_exists( 'presscore_lazy_loading_enabled' ) ) :

	/**
	 * Return true if lazy loading enabled.
	 *
	 * @since  3.3.0
	 *
	 * @return boolean
	 */
	function presscore_lazy_loading_enabled() {
		return of_get_option( 'general-images_lazy_loading' ) === '1';
	}

endif;

if ( ! function_exists( 'the7_theme_accent_color' ) ) :

	/**
	 * Return simplified accent color.
	 */
	function the7_theme_accent_color() {
		if ( 'gradient' === of_get_option( 'general-accent_color_mode' ) ) {
			$color = of_get_option( 'general-accent_bg_color_gradient' );
			$color = isset( $color[0] ) ? $color[0] : '#ffffff';
		} else {
			$color = of_get_option( 'general-accent_bg_color' );
		}
        return $color;
	}

endif;

if ( ! function_exists( 'presscore_theme_color_meta' ) ) :

	/**
	 * Display "theme-color" meta. Uses accent color.
	 */
	function presscore_theme_color_meta() {
		printf( '<meta name="theme-color" content="%s"/>', the7_theme_accent_color() );
	}

endif;

if ( ! function_exists( 'presscore_js_resize_event_hack' ) ):

	/**
	 * Output js resize event hack that improves performance on mobile.
     *
	 * @since 6.2.1
	 * @uses  of_get_option
	 */
	function presscore_js_resize_event_hack() {
		if ( ! of_get_option( 'advanced-normalize_resize_on_mobile' ) ) {
			return;
		}
		?>
        <script type="text/javascript">
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                var originalAddEventListener = EventTarget.prototype.addEventListener,
                    oldWidth = window.innerWidth;

                EventTarget.prototype.addEventListener = function (eventName, eventHandler, useCapture) {
                    if (eventName === "resize") {
                        originalAddEventListener.call(this, eventName, function (event) {
                            if (oldWidth === window.innerWidth) {
                                return;
                            }
                            else if (oldWidth !== window.innerWidth) {
                                oldWidth = window.innerWidth;
                            }
                            if (eventHandler.handleEvent) {
                                eventHandler.handleEvent.call(this, event);
                            }
                            else {
                                eventHandler.call(this, event);
                            };
                        }, useCapture);
                    }
                    else {
                        originalAddEventListener.call(this, eventName, eventHandler, useCapture);
                    };
                };
            };
        </script>
		<?php
	}

endif;

if ( ! function_exists( 'the7_register_style' ) ) {

	/**
	 * Simple wrap for wp_register_style.
	 *
	 * @since 7.0.0
	 *
	 * @param string      $handle
	 * @param string      $src
	 * @param array       $deps
	 * @param bool|string $ver
	 * @param string      $media
	 */
	function the7_register_style( $handle, $src, $deps = array(), $ver = false, $media = 'all' ) {
		$src = the7_add_asset_suffix( $src, '.css' );

		wp_register_style( $handle, $src, $deps, $ver ? $ver : THE7_VERSION, $media );
	}

}

if ( ! function_exists( 'the7_register_script' ) ) {

	/**
	 * Simple wrap for wp_register_script.
	 *
	 * @since 7.0.0
	 *
	 * @param string      $handle
	 * @param string      $src
	 * @param array       $deps
	 * @param bool|string $ver
	 * @param bool        $in_footer
	 */
	function the7_register_script( $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
		$src = the7_add_asset_suffix( $src, '.js' );

		wp_register_script( $handle, $src, $deps, $ver ? $ver : THE7_VERSION, $in_footer );
	}

}

if ( ! function_exists( 'the7_add_asset_suffix' ) ) {

	/**
     * Add '.min' suffix to provided $src.
     *
     * @since 7.1.0
     *
	 * @param string $src Asset uri without extension.
	 * @param string $ext Asset extension.
	 *
	 * @return string
	 */
	function the7_add_asset_suffix( $src, $ext ) {
		$suffix = '.min';

		if ( defined( 'THE7_DEV_ENV' ) && THE7_DEV_ENV && file_exists( str_replace( PRESSCORE_THEME_URI, PRESSCORE_THEME_DIR, "{$src}{$ext}" ) ) ) {
			$suffix = '';
		}

		return "{$src}{$suffix}{$ext}";
	}
}

if ( ! function_exists( 'the7_register_fontawesome_style' ) ) {

	/**
	 * Register FontAwesome style with dedicated handler and dependencies.
	 *
	 * @since 7.0.0
	 *
	 * @param string $handle
	 * @param array  $deps
	 */
    function the7_register_fontawesome_style( $handle, $deps = array() ) {
	    wp_register_style( $handle, get_template_directory_uri() . '/fonts/FontAwesome/css/all.min.css', $deps, THE7_VERSION, 'all' );
    }

}

/**
 * Return `enable`.
 *
 * @since 7.5.0
 * @return string
 */
function the7__return_enable() {
    return 'enable';
}
