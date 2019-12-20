<?php
/**
 * Portfolio helpers.
 *
 * @package the7\Portfolio\Helpers
 * @since 3.0.0
 */

if ( ! function_exists( 'presscore_display_related_projects' ) ) :

	/**
	 * Display related projects.
	 */
	function presscore_display_related_projects() {

		global $post;
		$html = '';

		$config = presscore_get_config();

		// if related projects turn on in theme options
		if ( $config->get( 'post.related_posts.enabled' ) ) {

			$terms = array();
			switch ( $config->get( 'post.related_posts.query.mode' ) ) {
				case 'custom': $terms = $config->get( 'post.related_posts.query.terms' ); break;
				default: $terms = wp_get_object_terms( $post->ID, 'dt_portfolio_category', array('fields' => 'ids') );
			}

			if ( $terms && !is_wp_error( $terms ) ) {

				$posts = presscore_query()->get_related_posts_by_terms( array(
					'post_type' => 'dt_portfolio',
					'taxonomy' => 'dt_portfolio_category',
					'posts_per_page' => intval( $config->get( 'post.related_posts.query.posts_per_page' ) ),
					'terms' => $terms
				) );

				$data_columns = array();
				$opt_columns = (array) of_get_option( 'portfolio-rel_projects_columns' );
				if ( $opt_columns ) {
					$option_to_data_map = array(
						'wide_desktop' => 'wide-col-num',
						'desktop'      => 'col-num',
						'laptop'       => 'laptop-col',
						'h_tablet'     => 'h-tablet-columns-num',
						'v_tablet'     => 'v-tablet-columns-num',
						'phone'        => 'phone-columns-num',
					);

					foreach ( $option_to_data_map as $opt => $dat ) {
						if ( array_key_exists( $opt, $opt_columns ) ) {
							$data_columns[ $dat ] = $opt_columns[ $opt ];
						}
					}
				}

				$portfolio_scroller = new Presscore_Portfolio_Posts_Scroller();
				$portfolio_scroller->setup( $posts, array(
					'class' => 'related-projects slider-wrapper owl-carousel dt-owl-carousel-init arrows-bg-on arrows-hover-bg-on',
					'columns' => $data_columns,
					'proportions' => of_get_option( 'portfolio-rel_projects_proportions' ),
					'show_title' => $config->get( 'post.related_posts.show.title' ),
					'show_excerpt' => $config->get( 'post.related_posts.show.description' ),
					'appearance' => 'under_image',
					'padding' => 50,
					'bg_under_projects' => 'disabled',
					'content_aligment' => 'center',
					'hover_animation' => 'fade',
					'hover_bg_color' => 'accent',
					'hover_content_visibility' => 'on_hoover',
					'show_link' => $config->get( 'post.related_posts.show.link' ),
					'show_details' => $config->get( 'post.related_posts.show.details_link' ),
					'show_zoom' => $config->get( 'post.related_posts.show.zoom' ),
					'show_date' => $config->get( 'post.related_posts.meta.fields.date' ),
					'show_categories' => $config->get( 'post.related_posts.meta.fields.categories' ),
					'show_comments' => $config->get( 'post.related_posts.meta.fields.comments' ),
					'show_author' => $config->get( 'post.related_posts.meta.fields.author' ),
					'arrows' => 'accent'
				) );

				$html .= $portfolio_scroller->get_html();

				if ( $html ) {
					// Title.
					$html = '<div class="single-related-posts"><h3>' . $config->get( 'post.related_posts.title' ) . '</h3>' . $html . '</div>';
				}

			}
		}

		echo (string) apply_filters('presscore_display_related_projects', $html);
	}

endif;

if ( ! function_exists( 'presscore_get_project_media_slider' ) ) :

	/**
	 * Portfolio media slider.
	 *
	 * Based on royal slider. Properly works only in the loop.
	 *
	 * @param array $class
	 * @return string
	 */
	function presscore_get_project_media_slider( $class = array() ) {
		global $post;

		// slideshow dimensions
		$slider_proportions = get_post_meta( $post->ID, '_dt_project_options_slider_proportions',  true );
		$slider_proportions = wp_parse_args( $slider_proportions, array( 'width' => '', 'height' => '' ) );

		$width = $slider_proportions['width'];
		$height = $slider_proportions['height'];

		// get slideshow
		$media_items = get_post_meta( $post->ID, '_dt_project_media_items', true );
		$slideshow = '';

		if ( !$media_items ) $media_items = array();

		// if we have post thumbnail and it's not hidden
		if ( has_post_thumbnail() ) {
			if ( is_single() ) {
				if ( !get_post_meta( $post->ID, '_dt_project_options_hide_thumbnail', true ) ) {
					array_unshift( $media_items, get_post_thumbnail_id() );
				}
			} else {
				array_unshift( $media_items, get_post_thumbnail_id() );
			}
		}

		$attachments_data = presscore_get_attachment_post_data( $media_items );

		// TODO: make it clean and simple
		if ( count( $attachments_data ) > 1 ) {

			$slideshow = presscore_get_photo_slider( $attachments_data, array(
				'width'		=> $width,
				'height'	=> $height,
				'class' 	=> $class,
				'style'		=> ' style="width: 100%"',
			) );
		} elseif ( !empty($attachments_data) ) {

			$image = current($attachments_data);

			$thumb_id = $image['ID'];
			$thumb_meta = array( $image['full'], $image['width'], $image['height'] );
			$video_url = esc_url( get_post_meta( $thumb_id, 'dt-video-url', true ) );

			$thumb_args = array(
				'img_meta'  => $thumb_meta,
				'img_id'    => $thumb_id,
				'img_class' => 'preload-me',
				'class'     => 'alignnone rollover',
				'href'      => get_permalink( $post->ID ),
				'custom'    => ' aria-label="' . esc_attr__( 'Post image', 'dt-the7-core' ) . '"',
				'wrap'      => '<a %CLASS% %HREF% %TITLE% %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /></a>',
				'echo'      => false,
			);

			if ( $video_url ) {
				$thumb_args['class'] = 'alignnone rollover-video';
			}

			$thumb_args = apply_filters( 'dt_portfolio_thumbnail_args', $thumb_args );

			$slideshow = dt_get_thumb_img( $thumb_args );
		}

		return $slideshow;
	}

endif;

if ( ! function_exists( 'presscore_get_project_rollover_link_icon' ) ) :

	/**
	 * @return string
	 */
	function presscore_get_project_rollover_link_icon() {
		$config = presscore_get_config();
		$rollover_icon = '';

		if ( $config->get( 'show_links' ) ) {

			$project_link = presscore_get_project_link( 'project-link' );
			if ( $project_link ) {
				$rollover_icon = $project_link;
			}

		}

		return $rollover_icon;
	}

endif;

if ( ! function_exists( 'presscore_get_project_rollover_details_icon' ) ) :

	/**
	 * @return string
	 */
	function presscore_get_project_rollover_details_icon() {
		$config = presscore_get_config();
		$rollover_icon = '';

		if ( $config->get( 'show_details' ) ) {
			$rollover_icon = '<a href="' . get_permalink() . '" class="project-details">' . __( 'Details', 'dt-the7-core' ) . '</a>';
		}

		return $rollover_icon;
	}

endif;

if ( ! function_exists( 'presscore_get_project_rollover_zoom_icon' ) ) :

	/**
	 * @param  array  $args
	 * @return string
	 */
	function presscore_get_project_rollover_zoom_icon( $args = array() ) {
		$default_args = array(
			// can be 'single', 'gallery' or 'first'
			'popup'         => 'single',
			'class'         => '',
			'text'          => false,
			'attachment_id' => 0,
		);
		$args = wp_parse_args( $args, $default_args );

		$config = presscore_get_config();
		$rollover_icon = '';

		if ( $config->get( 'show_zoom' ) && $args['attachment_id'] ) {

			$attachment_id = absint( $args['attachment_id'] );

			if ( !presscore_imagee_title_is_hidden( $attachment_id ) ) {
				$attachment_title = get_post_field( 'post_title', $attachment_id );

			} else {
				$attachment_title = '';

			}

			$link_class = array( 'project-zoom', 'dt-pswp-item' );

			if ( $args['class'] ) {
				$link_class[] = $args['class'];
			}

			switch( $args['popup'] ) {
				case 'single':
					$link_class[] = 'dt-single-pswp-popup';
					break;

				case 'gallery':
					$link_class[] = 'dt-gallery-pswp-popup';
					break;

				case 'first':
					$link_class[] = 'dt-first-pswp-popup';
					break;
			}

			$attachment_description = get_post_field( 'post_content', $attachment_id );
			$data_attr = sprintf( 'data-dt-img-description="%s"', esc_attr( $attachment_description ) );
			$attachment_video_src = get_post_meta( $attachment_id, 'dt-video-url', true );
			if ( $attachment_video_src ) {
				$link_class[] = 'pswp-video';
				$link_src = $attachment_video_src;
			} else {
				$attachment_src = wp_get_attachment_image_src( $attachment_id, 'full' );
				$link_src = $attachment_src[0];
				$data_attr .= sprintf( ' data-large_image_width="%s" data-large_image_height="%s"', intval( $attachment_src[1] ), intval( $attachment_src[2] ) );
			}

			$data_attr .= ' aria-label="' . esc_attr__( 'Portfolio zoom icon', 'dt-the7-core' ) . '"';
			$text = $args['text'] === false ? esc_html( __( 'Zoom', 'dt-the7-core' ) ) : $args['text'];
			$rollover_icon = sprintf(
				'<a href="%s" class="%s" title="%s" %s>%s</a>',
				esc_url( $link_src ),
				esc_attr( implode( ' ', $link_class ) ),
				esc_attr( $attachment_title ),
				$data_attr,
				$text
			);

		}

		return $rollover_icon;
	}

endif;

if ( ! function_exists( 'presscore_project_preview_buttons_count' ) ) :

	/**
	 * @return int
	 */
	function presscore_project_preview_buttons_count() {

		$buttons_count = 0;

		if ( !post_password_required() ) {
			$config = presscore_get_config();

			// details button
			if ( $config->get( 'show_details' ) ) {
				$buttons_count++;
			}

			// zoom button
			if ( $config->get( 'show_zoom' ) ) {
				$buttons_count++;
			}

			// link button
			if ( $config->get( 'show_links' ) && $config->get( 'post.buttons.link.enabled' ) && in_the_loop() ) {
				$buttons_count++;
			}
		}

		return $buttons_count;
	}

endif;

if ( ! function_exists( 'presscore_project_get_preview_buttons' ) ) :

	/**
	 * Return project preview icons (such as link, zoom, details) html.
	 * 
	 * @param  int		$thumb_id Attachment id for zoom icon.
	 * @return string
	 */
	function presscore_project_get_preview_buttons( $thumb_id ) {
		$rollover_icons = '';
		$rollover_icons .= presscore_get_project_rollover_link_icon();
		$rollover_icons .= presscore_get_project_rollover_zoom_icon( array( 'popup' => 'single', 'class' => '', 'attachment_id' => $thumb_id ) );
		$rollover_icons .= presscore_get_project_rollover_details_icon();

		if ( $rollover_icons ) {
			$rollover_icons = '<div class="links-container">' . $rollover_icons . '</div>';
		}

		return $rollover_icons;
	}

endif;

if ( ! function_exists( 'presscore_project_get_thumbnail_img' ) ) :

	/**
	 * @param  int		$thumb_id
	 * @param  string	$class
	 * @return string
	 */
	function presscore_project_get_thumbnail_img( $thumb_id, $class = '' ) {
		$thumb_args = array(
			'echo'      => false,
			'img_meta'  => wp_get_attachment_image_src( $thumb_id, 'full' ),
			'img_id'    => $thumb_id,
			'img_class' => 'preload-me',
			'class'     => $class,
			'href'      => get_permalink(),
			'options'   => presscore_set_image_dimesions(),
			'custom'    => ' aria-label="' . esc_attr__( 'Post image', 'dt-the7-core' ) . '"',
			'wrap'      => '<a %HREF% %CLASS% %TITLE% %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /></a>',
		);

		$thumb_args = apply_filters( 'dt_portfolio_thumbnail_args', $thumb_args );

		return dt_get_thumb_img( $thumb_args );
	}

endif;

if ( ! function_exists( 'presscore_project_get_preview_content' ) ) :

	/**
	 * @return string
	 */
	function presscore_project_get_preview_content() {
		$config = presscore_config();
		$html = '';

		// title
		if ( $config->get( 'show_titles' ) && $title = get_the_title() ) {
			$html .= sprintf( '<h3 class="entry-title"><a href="%s" title="%s" rel="bookmark">%s</a></h3>', get_permalink(), the_title_attribute( 'echo=0' ), $title );
		}

		// post meta
		$html .= presscore_get_posted_on();

		// description
		if ( $config->get( 'show_excerpts' ) ) {
			$html .= apply_filters( 'the_excerpt', get_the_excerpt() );
		}

		// details button
		if ( $config->get( 'post.preview.buttons.details.enabled' ) ) {
			$html .= '<p>' . presscore_post_details_link() . '</p>';
		}

		// edit link
		if ( $html ) {
			$html .= presscore_post_edit_link();
		}

		return $html;
	}

endif;

/**
 * Return portfolio rollover class.
 *
 * @since
 *
 * @uses presscore_project_preview_buttons_count
 *
 * @return string
 */
function the7pt_get_portfolio_rollover_class() {
	$rollover_class        = '';
	$preview_buttons_count = presscore_project_preview_buttons_count();
	if ( $preview_buttons_count === 0 ) {
		$rollover_class = 'forward-post';
	} elseif ( $preview_buttons_count === 1 ) {
		$rollover_class = 'rollover-active';
	}

	return $rollover_class;
}
