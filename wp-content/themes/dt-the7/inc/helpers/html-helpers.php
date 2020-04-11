<?php
/**
 * HTML helpers.
 *
 * @since 1.0.0
 * @package vogue
 */

if ( ! function_exists( 'presscore_convert_indexed2numeric_array' ) ) :

	function presscore_convert_indexed2numeric_array( $glue, $array, $prefix = '', $value_wrap = '%s' ) {
		$result = array();

		if ( is_array( $array ) && count( $array ) ) {
			foreach( $array as $key => $value ) {
				$result[] = $prefix . $key . $glue . sprintf( $value_wrap, $value );
			}
		}

		return $result;
	}

endif;

if ( ! function_exists( 'presscore_get_inline_style_attr' ) ) :

	function presscore_get_inline_style_attr( $css_style ) {
		if ( $css_style ) {
			return 'style="' . esc_attr( implode( ' ', presscore_convert_indexed2numeric_array( ':', $css_style, '', '%s;' ) ) ) . '"';
		}

		return '';
	}

endif;

if ( ! function_exists( 'presscore_get_inlide_data_attr' ) ) :

	function presscore_get_inlide_data_attr( $data_atts ) {
		if ( $data_atts ) {
			return implode( ' ', presscore_convert_indexed2numeric_array( '=', $data_atts, 'data-', '"%s"' ) );
		}

		return '';
	}

endif;

if ( ! function_exists( 'presscore_get_font_size_class' ) ) :

	/**
	 * Return proper class accordingly to $font_size.
	 *
	 * @param string $font_size Font size f.e. small
	 *
	 * @return string Proper font size class
	 */
	function presscore_get_font_size_class( $font_size = '' ) {
		switch ( $font_size ) {
			case 'h1': $class = 'h1-size'; break;
			case 'h2': $class = 'h2-size'; break;
			case 'h3': $class = 'h3-size'; break;
			case 'h4': $class = 'h4-size'; break;
			case 'h5': $class = 'h5-size'; break;
			case 'h6': $class = 'h6-size'; break;

			case 'normal': $class = 'text-normal'; break;
			case 'big': $class = 'text-big'; break;
			case 'small':
			default: $class = 'text-small';
		}

		return $class;
	}

endif;


if ( ! function_exists( 'presscore_get_menu_bg_mode_class' ) ) :

	/**
	 * Return proper class accordingly to $menu_bg_mode.
	 *
	 * @param string $menu_bg_mode Bg mode f.e. solid
	 *
	 * @return string Class
	 */
	function presscore_get_menu_bg_mode_class( $menu_bg_mode = '' ) {
		switch( $menu_bg_mode ) {
			case 'fullwidth_line': $class = 'full-width-line'; break;
			case 'solid': $class = 'solid-bg'; break;
			case 'content_line': $class = 'line-content'; break;
			default:
				$class = '';
		}

		return $class;
	}

endif;


if ( ! function_exists( 'presscore_is_gradient_color_mode' ) ) :

	/**
	 * Check whether the current colour mode is gradient
	 *
	 * @param string $color_mode Color mode f.e. color
	 * @return bool
	 */
	function presscore_is_gradient_color_mode( $color_mode = '' ) {
		if ( ('gradient' == $color_mode) || ('accent' == $color_mode && 'gradient' == presscore_config()->get( 'template.accent.color.mode' ) ) ) {
			return true;
		}
		return false;
	}

endif;


if ( ! function_exists( 'presscore_get_color_mode_class' ) ) :

	/**
	 * Return proper class accordingly to $color_mode.
	 * 
	 * @deprecated 3.0.0
	 * 
	 * @param string $color_mode Color mode f.e. color
	 * @return string Class
	 */
	function presscore_get_color_mode_class( $color_mode = '' ) {
		$class = '';

		if ( presscore_is_gradient_color_mode( $color_mode ) ) {
			$class = 'gradient-hover';
		}

		return $class;
	}

endif;

if ( ! function_exists( 'presscore_fancy_separator' ) ) :

	function presscore_fancy_separator( $args = array() ) {

		$default_args = array(
			'class' => '',
			'title_align' => 'left',
			'title' => ''
		);

		$args = wp_parse_args( $args, $default_args );

		$main_class = array( 'dt-fancy-separator' );
		$separator_class = array( 'separator-holder' );
		$title_template = '<div class="dt-fancy-title">%s</div>';
		$separator_template = '<span class="%s"></span>';
		$title = '';

		switch ( $args['title_align'] ) {

			case 'center':
				$separator_base_class = implode( ' ', $separator_class );

				$separator_left = sprintf( $separator_template, esc_attr( $separator_base_class . ' separator-left' ) );
				$separator_right = sprintf( $separator_template, esc_attr( $separator_base_class . ' separator-right' ) );

				$title = sprintf( $title_template, $separator_left . esc_html( $args['title'] ) . $separator_right );

				break;

			case 'right':
				$main_class[] = 'title-right';
				$separator_class[] = 'separator-left';

				$separator = sprintf( $separator_template, esc_attr( implode( ' ', $separator_class ) ) );

				$title = sprintf( $title_template, $separator . esc_html( $args['title'] ) );
				break;

			// left
			default:
				$main_class[] = 'title-left';
				$separator_class[] = 'separator-right';

				$separator = sprintf( $separator_template, esc_attr( implode( ' ', $separator_class ) ) );

				$title = sprintf( $title_template, esc_html( $args['title'] )  . $separator  );
		}

		if ( $args['class'] && is_string( $args['class'] ) ) {
			$main_class[] = $args['class'];
		}

		$html = '<div class="' . esc_attr( implode( ' ', $main_class ) ) . '">' . $title . '</div>';

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_get_template_image_layout' ) ) :

	/**
	 * Returns image layout
	 *
	 * @since  1.0.0
	 * 
	 * @param  string  $lyout    Template layout
	 * @param  integer $post_num Post number
	 * @return string            Returns 'odd' (default) or 'even'
	 */
	function presscore_get_template_image_layout( $lyout = 'left', $post_num = 1 ) {

		switch ( $lyout ) {

			case 'right_list':
				$image_layout = 'even';
				break;

			case 'checkerboard':
				$image_layout = ( $post_num % 2 ) ? 'odd' : 'even';
				break;

			// list ?
			default:
				$image_layout = 'odd';
		}

		return $image_layout;
	}

endif;

if ( ! function_exists( 'presscore_main_container_classes' ) ) :

	/**
	 * Main container classes.
	 */
	function presscore_main_container_classes( $custom_class = array() ) {

		$classes = $custom_class;
		$config = presscore_config();

		switch( $config->get( 'sidebar_position' ) ) {
			case 'left':
				$classes[] = 'sidebar-left';
				break;
			case 'disabled':
				$classes[] = 'sidebar-none';
				break;
			default :
				$classes[] = 'sidebar-right';
		}

		if ( ! $config->get( 'sidebar.style.dividers.vertical' ) ) {
			$classes[] = 'sidebar-divider-off';
		}elseif($config->get( 'sidebar.style.dividers.vertical' )){
			$classes[] = 'sidebar-divider-vertical';
		}

		$classes = apply_filters( 'presscore_main_container_classes', $classes );
		if ( ! empty( $classes ) ) {
			printf( 'class="%s"', esc_attr( implode( ' ', (array)$classes ) ) );
		}
	}

endif;

if ( ! function_exists( 'presscore_get_post_tags_html' ) ) :

	function presscore_get_post_tags_html() {
		$html = '';
		if ( in_the_loop() ) {
			$tags_list = get_the_tag_list('', '');
			if ( $tags_list && ! is_wp_error( $tags_list ) ) {
				$html = '<div class="entry-tags">' . __( 'Tags:', 'the7mk2' ) . '&nbsp;' . $tags_list . '</div>';
			}
		}

		return apply_filters( 'presscore_get_post_tags', $html );
	}

endif;


if ( ! function_exists( 'presscore_get_post_day_link' ) ) :

	function presscore_get_post_day_link() {

		$archive_year = get_the_time('Y');
		$archive_month = get_the_time('m');
		$archive_day = get_the_time('d');

		return get_day_link( $archive_year, $archive_month, $archive_day );
	}

endif;


if ( ! function_exists( 'presscore_get_post_data' ) ) :

	/**
	 * Get post date.
	 */
	function presscore_get_post_data( $html = '' ) {

		$href = 'javascript:void(0);';

		if ( 'post' == get_post_type() ) {

			// remove link if in date archive
			if ( !(is_day() && is_month() && is_year()) ) {

				$href = presscore_get_post_day_link();
			}
		}

		$html .= sprintf(
			'<a href="%s" title="%s" class="data-link" rel="bookmark"><time class="entry-date updated" datetime="%s">%s</time></a>',
				$href,	// href
				esc_attr( get_the_time() ),	// title
				esc_attr( get_the_date( 'c' ) ),	// datetime
				esc_html( get_the_date() )	// date
		);

		return $html;
	}

endif;


if ( ! function_exists( 'presscore_get_post_comments' ) ) :

	/**
	 * Get post comments.
	 */
	function presscore_get_post_comments( $html = '' ) {
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
			ob_start();
			comments_popup_link( __( 'Leave a comment', 'the7mk2' ), __( '1 Comment', 'the7mk2' ), __( '% Comments', 'the7mk2' ), 'comment-link' );
			$html .= ob_get_clean();
		endif;

		return $html;
	}

endif;


if ( ! function_exists( 'presscore_get_post_categories' ) ) :

	/**
	 * Get post categories.
	 */
	function presscore_get_post_categories() {
		$post_type = get_post_type();
		$divider = ', ';

		if ( 'post' === $post_type ) {
			$categories_list = get_the_category_list( $divider );
		} else {
			$categories_list = get_the_term_list( get_the_ID(), "{$post_type}_category", '', $divider );
		}

		if ( ! $categories_list || is_wp_error($categories_list) ) {
			return '';
		}

		return str_replace( array( 'rel="tag"', 'rel="category tag"' ), '', $categories_list );
	}

endif;

if ( !function_exists( 'presscore_get_single_posted_on' ) ) :

	/**
	 * Return post meta for single post page.
	 *
	 * @param array $class
	 *
	 * @return string
	 */
	function presscore_get_single_posted_on( $class = array() ) {
		$post_meta_fields = presscore_get_posted_on_parts();

		if ( ! empty( $post_meta_fields['categories'] ) ) {
			$post_meta_fields['categories'] = '<span class="category-link">' . _n( 'Category:', 'Categories:', substr_count( $post_meta_fields['categories'], ',' ) + 1, 'the7mk2' ) . '&nbsp;' . $post_meta_fields['categories'] . '</span>';
		}

		$html = implode( '', $post_meta_fields );
		if ( $html ) {
			$class[] = 'entry-meta';
			$class = apply_filters( 'presscore_posted_on_wrap_class', $class );
			$html = '<div class="' . presscore_esc_implode( ' ', $class ) . '">' . $html .'</div>';
		}

		return apply_filters( 'presscore_posted_on_html', $html, $class );
	}

endif;

if ( !function_exists( 'presscore_get_posted_on' ) ) :

	/**
	 * This function returns post meta information.
	 *
	 * @uses 'presscore_get_posted_on_parts' - function.
	 * @uses 'presscore_posted_on_wrap_class' - filter.
	 * @uses 'presscore_posted_on_html' - filter.
	 * 
	 * @param array $class Array of wrap classes, by default contain 'enrty-meta'.
	 * 
	 * @return string Post meta information html.
	 *
	 * @since 3.0.0
	 */
	function presscore_get_posted_on( $class = array() ) {
		$post_meta_fields = presscore_get_posted_on_parts();

		if ( ! empty( $post_meta_fields['categories'] ) ) {
			$post_meta_fields['categories'] = '<span class="category-link">' . $post_meta_fields['categories'] . '</span>';
		}

		$html = implode( '', $post_meta_fields );
		if ( $html ) {
			$class[] = 'entry-meta';
			$class = apply_filters( 'presscore_posted_on_wrap_class', $class );
			$html = '<div class="' . presscore_esc_implode( ' ', $class ) . '">' . $html .'</div>';
		}

		return apply_filters( 'presscore_posted_on_html', $html, $class );
	}

endif;

if ( ! function_exists( 'presscore_get_posted_on_parts' ) ) :

	/**
	 * This function returns array of posted on html parts.
	 *
	 * @return array Array of post meta html parts.
	 */
	function presscore_get_posted_on_parts() {
		$config = presscore_config();
		$parts = array();

		if ( $config->get( 'post.meta.fields.categories' ) ) {
			$parts['categories'] = presscore_get_post_categories();
		}

		if ( $config->get( 'post.meta.fields.author' ) ) {
			$parts['author'] = presscore_get_post_author();
		}

		if ( $config->get( 'post.meta.fields.date' ) ) {
			$parts['date'] = presscore_get_post_data();
		}

		if ( $config->get( 'post.meta.fields.comments' ) ) {
			$parts['comments'] = presscore_get_post_comments();
		}

		if ( $config->get( 'post.meta.fields.media_number' ) && 'albums' == $config->get( 'template' ) ) {
			$parts['media_count'] = presscore_get_post_media_count();
		}

		return apply_filters( 'presscore_posted_on_parts', $parts );
	}

endif;

if ( ! function_exists( 'presscore_post_details_link' ) ) :

	/**
	 * Return details link HTML.
	 *
     * @global $post
     *
	 * @param int|null          $post_id   Post ID. Default is null.
	 * @param array|string|null $class     Custom classes. May be array or string with classes separated by ' '.
	 * @param string|null       $link_text Link text.
	 *
	 * @return string
	 */
	function presscore_post_details_link( $post_id = null, $class = null, $link_text = null ) {
		global $post;

		if ( ! $post_id && ! $post ) {
			return '';
		}

		if ( ! $post_id ) {
			$post_id = $post->ID;
		}

		if ( post_password_required( $post_id ) ) {
			return '';
		}

		if ( $class === null ) {
			$class = array(
				'details',
				'more-link',
			);
		} elseif ( ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		$output = '';
		$url    = get_permalink( $post_id );

		if ( $url ) {
			$output = sprintf( '<a href="%1$s" class="%2$s" rel="nofollow">%3$s</a>', esc_url( $url ), esc_attr( implode( ' ', $class ) ), is_string( $link_text ) ? $link_text : esc_html__( 'Details', 'the7mk2' ) );
		}

		return apply_filters( 'presscore_post_details_link', $output, $post_id, $class );
	}

endif;

if ( ! function_exists( 'presscore_post_edit_link' ) ) :

	/**
	 * Return post edit button HTML.
     *
     * @TODO: maybe remove it.
	 *
	 * @param null  $post_id
	 * @param array $class
	 *
	 * @return string
	 */
	function presscore_post_edit_link( $post_id = null, $class = array() ) {
	    return '';

		$output = '';
		if ( current_user_can( 'edit_posts' ) ) {
			global $post;

			if ( !$post_id && !$post ) {
				return '';
			}

			if ( !$post_id ) {
				$post_id = $post->ID;
			}

			if ( !is_array( $class ) ) {
				$class = explode( ' ', $class );
			}

			$url = get_edit_post_link( $post_id );
			$final_classes = $class;
			$final_classes[] = 'edit-link';

			if ( $url ) {
				$output = sprintf(
					'<a href="%1$s" class="%2$s" target="_blank">%3$s</a>',
					$url,
					esc_attr( implode( ' ', $final_classes ) ),
					__( 'Edit', 'the7mk2' )
				);
			}
		}
		return apply_filters( 'presscore_post_edit_link', $output, $post_id, $class );
	}

endif; // presscore_post_edit_link

if ( ! function_exists( 'presscore_get_avatar' ) ) :

	/**
	 * get_avatar() wrapper with some filters.
	 *
	 * @since 5.4.1.1
	 *
	 * @param mixed      $id_or_email
	 * @param int        $size
	 * @param string     $default
	 * @param string     $alt
	 * @param null|array $args
	 *
	 * @return false|string
	 */
	function presscore_get_avatar( $id_or_email, $size = 96, $default = '', $alt = '', $args = null ) {
		return The7_Avatar::get_avatar( $id_or_email, $size, $default, $alt, $args );
	}

endif;

if ( ! function_exists( 'presscore_display_post_author' ) ) :

	/**
	 * Post author snippet.
	 *
	 * Use only in the loop.
	 *
	 * @since 1.0.0
	 */
	function presscore_display_post_author() {
		?>
		<div class="author-info entry-author">
			<?php
			$avatar = presscore_get_avatar( get_the_author_meta( 'ID' ), 80 );

			if ( $avatar ) {
				echo '<div class="author-avatar round-images">' . $avatar . '</div>';
			} else {
				echo '<span class="author-avatar no-avatar"></span>';
			}
            ?>
			<div class="author-description">
				<h4><span class="author-heading"><?php _e( 'Author:', 'the7mk2' ); ?></span>&nbsp;<?php the_author_meta( 'display_name' ); ?></h4>
				<?php
				$user_url = get_the_author_meta('user_url');
				if ( $user_url ) {
					echo '<a class="author-link" href="' . esc_url( $user_url ) . '" rel="author">' . esc_html( $user_url ) . '</a>';
				}
				?>
				<p class="author-bio"><?php the_author_meta( 'description' ); ?></p>
			</div>
		</div>
	<?php
	}

endif; // presscore_display_post_author

if ( ! function_exists( 'presscore_set_image_dimesions' ) ) :

	/**
     * Returns array with resize configuration for dt_get_thumb_img().
     *
     * @uses presscore_config() to retrieve the external state.
     *
	 * @return array
	 */
	function presscore_set_image_dimesions() {
		$config = presscore_config();

		if ( $config->get( 'justified_grid' ) ) {
			$target_image_height = absint( $config->get( 'target_height' ) );
			$target_image_height *= 1.3;

			return array( 'h' => round( $target_image_height ), 'z' => 0 );
		} elseif ( $config->get( 'post.preview.width.min' ) ) {
			$content_width = $config->get( 'template.content.width' );
			if ( false !== strpos( $content_width, '%' ) ) {
				$content_width = round( (int) $content_width * 19.20 );
			}
			$content_width = (int) $content_width;

			$computed_width = absint( $config->get( 'post.preview.width.min' ) );
			$columns = absint( $config->get( 'template.columns.number' ) );
			if ( $columns ) {
				$computed_width = max( array( $content_width / $columns, $computed_width ) );
			}

			if ( 'wide' == $config->get( 'post.preview.width' ) && ! $config->get( 'all_the_same_width' ) ) {
				$computed_width *= 3;

				return array( 'w' => round( $computed_width ), 'z' => 0, 'hd_convert' => false );
			} else {
				$computed_width *= 1.5;

				return array( 'w' => round( $computed_width ), 'z' => 0 );
			}
		}

		return array();
	}

endif;

if ( function_exists( 'presscore_set_browser_width_based_image_dimesions' ) ) :

    function presscore_set_browser_width_based_image_dimesions( $columns ) {
	    $config = presscore_config();
	    if ( $config->get( 'justified_grid' ) ) {
		    return array();
	    }

	    $content_width = absint( $config->get( 'template.content.width' ) );
	    if ( false !== strpos( $content_width, '%' ) ) {
		    $content_width = round( $content_width * 19.20 );
	    }

	    $responsive_width = array(
		    'desktop' => $content_width,
		    'h_tablet' => 1200,
		    'w_tablet' => 990,
		    'mobile' => 768,
	    );


    }

endif;

if ( ! function_exists( 'presscore_get_post_media_count' ) ) :

	function presscore_get_post_media_count( $html = '' ) {
		$config = Presscore_Config::get_instance();

		$media_items = $config->get( 'post.media.library' );

		if ( !$media_items ) {
			$media_items = array();
		}

		// add thumbnail to attachments list
		if ( has_post_thumbnail() && $config->get( 'post.media.featured_image.enabled' ) ) {
			array_unshift( $media_items, get_post_thumbnail_id() );
		}

		// if pass protected - show only cover image
		if ( $media_items && post_password_required() ) {
			$media_items = array( $media_items[0] );
		}

		list( $images_count, $videos_count ) = presscore_get_attachments_data_count( $media_items );

		$output = '';

		if ( $images_count || $videos_count ) {

			$output .= '<span class="num-of-images">';

			$counters = array();

			if ( $images_count ) {
				$counters[] = sprintf( _n( '1 image', '%s images', $images_count, 'the7mk2' ), $images_count );
			}

			if ( $videos_count ) {
				$counters[] = sprintf( _n( '1 video', '%s video', $videos_count, 'the7mk2' ), $videos_count );
			}

			$output .= implode( ' &amp; ', $counters );

			$output .= '</span>';
		}

		return $html . $output;
	}

endif;

if ( ! function_exists( 'presscore_get_media_content' ) ) :

	/**
	 * Get video embed.
	 *
	 */
	function presscore_get_media_content( $media_url, $id = '' ) {
		if ( !$media_url ) {
			return '';
		}

		if ( $id ) {
			$id = ' id="' . esc_attr( sanitize_html_class( $id ) ) . '"';
		}

		$html = '<div' . $id . ' class="pp-media-content" style="display: none;">' . dt_get_embed( $media_url ) . '</div>';

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_get_post_attachment_html' ) ) :

	/**
	 * Get post attachment html.
	 *
	 * Check if there is video_url and react respectively.
	 *
	 * @param array $attachment_data
	 * @param array $options
	 *
	 * @return string
	 */
	function presscore_get_post_attachment_html( $attachment_data, $options = array() ) {
		if ( empty( $attachment_data['ID'] ) ) {
			return '';
		}

		$default_options = array(
			'link_rel'	=> '',
			'class'		=> array(),
			'wrap'		=> '',
		);
		$options = wp_parse_args( $options, $default_options );

		$class = $options['class'];
		$image_media_content = '';

		if ( !$options['wrap'] ) {
			$options['wrap'] = '<a %HREF% %CLASS% %CUSTOM%><img %SRC% %IMG_CLASS% %ALT% %IMG_TITLE% %SIZE% /></a>';
		}

		$image_args = array(
			'img_meta' 	=> array( $attachment_data['full'], $attachment_data['width'], $attachment_data['height'] ),
			'img_id'	=> empty( $attachment_data['ID'] ) ? $attachment_data['ID'] : 0,
			'alt'		=> $attachment_data['alt'],
			'title'		=> $attachment_data['title'],
			'img_class' => 'preload-me',
			'custom'	=> $options['link_rel'] . ' data-dt-img-description="' . esc_attr($attachment_data['description']) . '"',
			'echo'		=> false,
			'wrap'		=> $options['wrap']
		);

		$class[] = 'dt-pswp-item';

		// check if image has video
		if ( empty($attachment_data['video_url']) ) {
			$class[] = 'rollover';
			$class[] = 'rollover-zoom';

		} else {
			$class[] = 'video-icon';

			$image_args['href'] = $attachment_data['video_url'];
			$class[] = 'pswp-video';

			$image_args['wrap'] = '<div class="rollover-video"><img %SRC% %IMG_CLASS% %ALT% %IMG_TITLE% %SIZE% /><a %HREF% %TITLE% %CLASS% %CUSTOM%></a></div>';
		}

		$image_args['class'] = implode( ' ', $class );

		$image = dt_get_thumb_img( $image_args );

		return $image;
	}

endif;

if ( ! function_exists( 'presscore_get_button_html' ) ) :

	/**
	 * Button helper.
	 * Look for filters in template-hooks.php
	 *
	 * @return string HTML.
	 */
	function presscore_get_button_html( $options = array() ) {
		$default_options = array(
			'before_title'	=> '',
			'after_title'	=> '',
			'title'			=> '',
			'target'		=> '',
			'href'			=> '',
			'class'			=> 'dt-btn',
			'atts'			=> ''
		);

		$options = wp_parse_args( $options, $default_options );

		$title = $options['title'];
		$class_parts = explode( ' ', $options['class'] );
		if ( in_array( 'dt-btn', $class_parts ) || in_array( 'btn-link', $class_parts ) ) {
			$title = '<span>' . $title . '</span>';
		}
		unset( $class_parts );

		if ( $options['target'] && strpos( $options['atts'], 'rel="' ) === false ) {
			$options['atts'] .= ' rel="noopener"';
		}

		$html = sprintf(
			'<a href="%1$s" class="%2$s"%3$s>%4$s</a>',
			$options['href'],
			esc_attr( $options['class'] ),
			( $options['target'] ? ' target="_blank"' : '' ) . $options['atts'],
			$options['before_title'] . $title . $options['after_title']
		);

		return apply_filters( 'presscore_get_button_html', $html, $options );
	}

endif;

if ( ! function_exists( 'presscore_get_post_author' ) ) :

	/**
	 * Get post author.
	 */
	function presscore_get_post_author( $html = '' ) {
		$html .= sprintf(
			'<a class="author vcard" href="%s" title="%s" rel="author">%s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'the7mk2' ), get_the_author() ) ),
				sprintf( __( 'By %s', 'the7mk2' ), '<span class="fn">' . get_the_author() . '</span>' )
		);

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_get_post_tags' ) ) :

	/**
	 * Get post tags.
	 *
	 * TODO: Remove this.
	 */
	function presscore_get_post_tags( $html = '' ) {
		$tags_list = get_the_tag_list('', '');
		if ( $tags_list ) {
			$html .= sprintf(
				'<div class="entry-tags">%s</div>',
					$tags_list
			);
		}

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_get_share_buttons_for_prettyphoto' ) ) :

	/**
	 * Share buttons lite.
	 *
	 */
	function presscore_get_share_buttons_for_prettyphoto( $place = '', $options = array() ) {
		global $post;
		$buttons = of_get_option('social_buttons-' . $place, array());

		if ( empty($buttons) ) return '';

		$default_options = array(
			'id'	=> null,
		);
		$options = wp_parse_args($options, $default_options);

		$options['id'] = $options['id'] ? absint($options['id']) : $post->ID;

		$html = '';

		$html .= sprintf(
			' data-pretty-share="%s"',
			esc_attr( str_replace( '+', '', implode( ',', $buttons ) ) )
		);

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_the_title_trim' ) ) :

	/**
	 * Replace protected and private title part.
	 *
	 * From http://wordpress.org/support/topic/how-to-remove-private-from-private-pages
	 *
	 * @return string Clear title.
	 */
	function presscore_the_title_trim( $title ) {
		$pattern[0] = '/Protected:/';
		$pattern[1] = '/Private:/';
		$replacement[0] = ''; // Enter some text to put in place of Protected:
		$replacement[1] = ''; // Enter some text to put in place of Private	
		return preg_replace($pattern, $replacement, $title);
	}

endif;

if ( ! function_exists( 'presscore_get_image_with_srcset' ) ) :

	function presscore_get_image_with_srcset( $regular, $retina, $default, $custom = '', $class = '' ) {
		$srcset = array();

		$file_extension = pathinfo( $default[0], PATHINFO_EXTENSION );
		if ( $file_extension === 'svg' ) {
			return '<img class="' . esc_attr( $class ) . '" src="' . esc_attr( $default[0] ) . '" ' . $custom . ' />';
		}

		foreach ( array( $regular, $retina ) as $img ) {
			if ( $img ) {
				$srcset[] = "{$img[0]} {$img[1]}w";
			}
		}

		$output = '<img class="' . esc_attr( $class . ' preload-me' ) . '" src="' . esc_attr( $default[0] ) . '" srcset="' . esc_attr( implode( ', ', $srcset ) ) . '" ' . image_hwstring( $default[1], $default[2] ) . ' ' . $custom . ' />';

		return $output;
	}

endif;

if ( ! function_exists( 'presscore_get_lazy_image' ) ) :

	/**
	 * Generate img html with lazy loading.
     *
     * @param array $img_src
     * @param int $width
     * @param int $height
     * @param array $atts
     *
     * @return string
	 */
	function presscore_get_lazy_image( $img_src, $width, $height, $atts = array() ) {
		if ( ! is_array( $img_src ) ) {
			return '';
		}

		$width = (int) $width;
		$height = (int) $height;
		$src_placeholder = "data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg' viewBox%3D'0 0 {$width} {$height}'%2F%3E";

		$atts = wp_parse_args( $atts, array(
			'class'  => '',
			'src'    => $src_placeholder,
			'width'  => $width,
			'height' => $height,
		) );

		$atts['data-srcset'] = array();
		$srcset_type = ( isset( $atts['_srcset_type'] ) && $atts['_srcset_type'] === 'x' ) ? 'x' : 'w';
		unset( $atts['_srcset_type'] );
		$i = 1;
		foreach ( $img_src as $_img_src ) {
			if ( empty( $_img_src[0] ) ) {
				continue;
			}

			$file_extension = pathinfo( $_img_src[0], PATHINFO_EXTENSION );
			if ( $file_extension === 'svg' ) {
				$atts['src'] = $_img_src[0];
				$atts = array_filter( $atts );
				$atts = array_map( 'trim', $atts );
				$atts = array_map( 'esc_attr', $atts );
				return '<img ' . implode( ' ', presscore_convert_indexed2numeric_array( '=', $atts, '', '"%s"') ) . ' />';
			}

			if ( ! isset( $atts['data-src'] ) ) {
				$atts['data-src'] = $_img_src[0];
            }

			$atts['data-srcset'][] = $_img_src[0] . ( $srcset_type === 'x' ? " {$i}x" : " {$_img_src[1]}w" );
			$i ++;
		}
		$atts['class'] .= ' lazy-load';
		$atts['data-srcset'] = implode( ', ', $atts['data-srcset'] );

		$atts = array_filter( $atts );

		$html = '<img ';
		foreach ( $atts as $attr => $val ) {
			$html .= $attr . '="' . esc_attr( trim( $val ) ) . '" ';
		}
		$html .= '/>';

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_substring' ) ) :

	/**
	 * Return substring $max_chars length with &hellip; at the end.
	 *
	 * @param string $str
	 * @param int $max_chars
	 *
	 * @return string
	 */

	function presscore_substring( $str, $max_chars = 30 ) {

		if ( function_exists('mb_strlen') && function_exists('mb_substr') ) {

			if ( mb_strlen( $str ) > $max_chars ) {

				$str = mb_substr( $str, 0, $max_chars );
				$str .= '&hellip;';
			}

		}
		return $str;
	}

endif;

if ( ! function_exists( 'presscore_get_social_icons' ) ) :

	/**
	 * Generate social icons links list.
	 * $icons = array( array( 'icon_class', 'title', 'link' ) )
	 *
	 * @param $icons array
	 *
	 * @return string
	 */
	function presscore_get_social_icons( $icons = array(), $common_classes = array() ) {
		if ( empty($icons) || !is_array($icons) ) {
			return '';
		}

		$classes = $common_classes;
		if ( !is_array($classes) ) {
			$classes = explode( ' ', trim($classes) );
		}

		$output = array();
		foreach ( $icons as $icon ) {

			if ( !isset($icon['icon'], $icon['link'], $icon['title']) ) {
				continue;
			}

			$output[] = presscore_get_social_icon( $icon['icon'], $icon['link'], $icon['title'], $classes );
		}

		return apply_filters( 'presscore_get_social_icons', implode( '', $output ), $output, $icons, $common_classes );
	}

endif;

if ( ! function_exists( 'presscore_get_social_icon' ) ) :

	/**
	 * Get social icon.
	 *
	 * @return string
	 */
	function presscore_get_social_icon( $icon = '', $url = '#', $title = '', $classes = array(), $target = '_blank' ) {
		$title = esc_attr( $title );

		$icon_attributes = array(
			'title="' . $title . '"',
		);

		if ( 'mail' === $icon && is_email( $url ) ) {
			$url = 'mailto:' . esc_attr( $url );
			$target = '_top';
		} else {
			$url = esc_attr( $url );
		}

		$icon_attributes[] = 'href="' . $url . '"';
		$icon_attributes[] = 'target="' . esc_attr( $target ) . '"';

		$icon_classes = is_array( $classes ) ? $classes : array();
		$icon_classes[] = $icon;

		$icon_attributes[] = 'class="' . esc_attr( implode( ' ',  $icon_classes ) ) . '"';

		$output = '<a ' . implode( ' ', $icon_attributes ) . '><span class="soc-font-icon"></span><span class="screen-reader-text">' . $title . '</span></a>';

		return $output;
	}

endif;

if ( ! function_exists( 'presscore_get_device_icons' ) ) :

	/**
	 * Returns device icons meta tags array.
	 *
	 * @since 2.2.1
	 * 
	 * @return string
	 */
	function presscore_get_device_icons() {
        $output = '';

		$icons = array(
			'general-favicon'    => '16x16',
			'general-favicon_hd' => '32x32',
		);
		foreach ( $icons as $opt => $sizes ) {
			$icon = dt_get_of_uploaded_image( of_get_option( $opt ) );
			if ( ! $icon ) {
			    continue;
            }

			$mime = the7_get_image_mime( $icon );
			$output .= sprintf( '<link rel="icon" href="%s" type="%s" sizes="%s"/>', $icon, $mime, $sizes );
		}

		$device_icons = array(
			array(
				'option_id' => 'general-handheld_icon-old_iphone',
			),
			array(
				'option_id' => 'general-handheld_icon-old_ipad',
				'sizes' => '76x76',
			),
			array(
				'option_id' => 'general-handheld_icon-retina_iphone',
				'sizes' => '120x120',
			),
			array(
				'option_id' => 'general-handheld_icon-retina_ipad',
				'sizes' => '152x152',
			),
		);

		foreach ( $device_icons as $icon ) {
			$src = dt_get_of_uploaded_image( of_get_option( $icon['option_id'] ) );
			if ( $src ) {
				$output .= '<link rel="apple-touch-icon"' . ( empty( $icon['sizes'] ) ? '' : ' sizes="' . esc_attr( $icon['sizes'] ) . '"' ) . ' href="' . esc_url( $src ) . '">';
			}
		}

		return $output;
	}

endif;

if ( ! function_exists( 'presscore_get_terms_list_by_slug' ) ) :

	/**
	 * Returns terms names list separated by separator based on terms slugs
	 *
	 * @since 4.1.5
	 * @param  array  $args Default arguments: array( 'slugs' => array(), 'taxonomy' => 'category', 'separator' => ', ', 'titles' => array() ).
	 * Default titles: array( 'empty_slugs' => __( 'All', 'the7mk2' ), 'no_result' => __('There is no categories', 'the7mk2') )
	 * @return string       Terms names list or title
	 */
	function presscore_get_terms_list_by_slug( $args = array() ) {

		$default_args = array(
			'slugs' => array(),
			'taxonomy' => 'category',
			'separator' => ', ',
			'titles' => array()
		);

		$default_titles = array(
			'empty_slugs' => __( 'All', 'the7mk2' ),
			'no_result' => __('There is no categories', 'the7mk2')
		);

		$args = wp_parse_args( $args, $default_args );
		$args['titles'] = wp_parse_args( $args['titles'], $default_titles );

		if ( ! is_array( $args['slugs'] ) ) {
			$args['slugs'] = presscore_sanitize_explode_string( $args['slugs'] );
		}

		// get categories names list or show all
		if ( empty( $args['slugs'] ) ) {
			$output = $args['titles']['empty_slugs'];

		} else {

			$terms_names = array();
			foreach ( $args['slugs'] as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, $args['taxonomy'] );

				if ( $term ) {
					$terms_names[] = $term->name;
				}

			}

			if ( $terms_names ) {
				asort( $terms_names );
				$output = join( $args['separator'], $terms_names );

			} else {
				$output = $args['titles']['no_result'];

			}

		}

		return $output;
	}

endif;

if ( ! function_exists( 'presscore_bottom_bar_class' ) ) :

	/**
	 * Bottom bar html class
	 * 
	 * @param  array  $class Custom html class
	 * @return string        Html class attribute
	 */
	function presscore_bottom_bar_class( $class = array() ) {
		if ( $class ) {
			$output = is_array( $class ) ? $class : explode( ' ', $class );
		} else {
			$output = array();
		}

		switch( presscore_config()->get( 'template.bottom_bar.style' ) ) {
			case 'full_width_line' :
				$output[] = 'full-width-line';
				break;
			case 'solid_background' :
				$output[] = 'solid-bg';
				break;
			// default - content_width_line
		}
		switch( presscore_config()->get( 'template.bottom_bar.layout' ) ) {
			case 'logo_left' :
				$output[] = 'logo-left';
				break;
			case 'logo_center' :
				$output[] = 'logo-center';
				break;
			case 'split' :
				$output[] = 'logo-split';
				break;
		}

		$output = apply_filters( 'presscore_bottom_bar_class', $output );

		return $output ? sprintf( 'class="%s"', presscore_esc_implode( ' ', array_unique( $output ) ) ) : '';
	}

endif;

if ( ! function_exists( 'presscore_get_photo_slider' ) ) :

	/**
	 * Photo slider helper.
	 *
	 * @param array $attachments_data
	 * @param array $options
	 *
	 * @return string
	 */
	function presscore_get_photo_slider( $attachments_data, $options = array() ) {
		if ( empty( $attachments_data ) ) {
			return '';
		}

		presscore_remove_lazy_load_attrs();

		$default_options = array(
			'echo'      => false,
			'width'     => null,
			'height'    => null,
			'class'     => array(),
			'style'     => '',
			'show_info' => array( 'title', 'link', 'description' ),
		);
		$options = wp_parse_args( $options, $default_options );

		if ( ! is_array( $options['class'] ) ) {
			$options['class'] = explode( ' ', $options['class'] );
		}

		// common classes
		$options['class'][] = 'photoSlider';

		$container_class = implode(' ', $options['class']);

		$data_attributes = '';
		if ( !empty($options['width']) ) {
			$data_attributes .= ' data-width="' . absint($options['width']) . '"';
		}

		if ( !empty($options['height']) ) {
			$data_attributes .= ' data-height="' . absint($options['height']) . '"';
		}

		if ( isset( $options['autoplay'] ) ) {
			$data_attributes .= ' data-autoslide="' . ( isset( $options['interval'] ) ? $options['interval'] : '' ) . '"';
		}

		if ( isset( $options['interval'] ) ) {
			$options['interval'] = absint( $options['interval'] );
			$data_attributes .= ' data-paused="' . ( $options['autoplay'] ? 'false' : 'true' ) . '"';
		}

		$html = "\n" . '<div class="' . esc_attr($container_class) . '"' . $data_attributes . $options['style'] . '>';

		foreach ( $attachments_data as $data ) {

			if ( empty($data['full']) ) continue;

			$html .= "\n\t" . '<div class="slide-item">';

			$image_args = array(
				'img_meta' 	=> array( $data['full'], $data['width'], $data['height'] ),
				'img_id'	=> $data['ID'],
				'alt'		=> $data['alt'],
				'title'		=> $data['title'],
				'caption'	=> $data['caption'],
				'img_class' => '',
				'custom'	=> '',
				'class'		=> '',
				'echo'		=> false,
				'wrap'		=> '<img %IMG_CLASS% %SRC% %SIZE% %ALT% %CUSTOM% />',
			);

			$image = dt_get_thumb_img( $image_args );

			$html .= "\n\t\t" . $image;

			// Video & link here.
			$links_html = '';
			$have_link = !empty($data['link']) && in_array('link', $options['show_info']);
			if ( $have_link ) {
				$links_html .= "\n\t\t" . '<a href="' . $data['link'] . '" class="ps-link" target="_blank"></a>';
			}

			$is_video = !empty( $data['video_url'] );
			if ( $is_video ) {
				$video_url = remove_query_arg( array('iframe', 'width', 'height'), $data['video_url'] );
				$links_html .= '<a href="' . esc_url($video_url) . '" class="video-icon dt-pswp-item pswp-video"></a>';
			}

			if ( $links_html ) {
				$links_class = 'ps-center-btn';
				if ( $have_link && $is_video ) {
					$links_class .= ' BtnCenterer';
				}

				$html .= '<div class="' . $links_class . '">' . $links_html . '</div>';
			}

			// Caption.
			$caption_html = '';

			if ( in_array('share_buttons', $options['show_info']) ) {
				ob_start();
				the7_display_popup_share_buttons( $data['ID'] );
				$caption_html .= '<div class="album-content-btn">' . "\n\t\t\t\t" . ob_get_clean() . '</div>';
			}

			if ( !empty($data['title']) && in_array('title', $options['show_info']) ) {
				$caption_html .= "\n\t\t\t\t" . '<h4>' . esc_html($data['title']) . '</h4>';
			}

			if ( !empty($data['description']) && in_array('description', $options['show_info']) ) {
				$caption_html .= "\n\t\t\t\t" . wpautop($data['description']);
			}

			if ( $caption_html ) {
				$html .= "\n\t\t" . '<div class="slider-post-caption">' . "\n\t\t\t" . '<div class="slider-post-inner">' . $caption_html . "\n\t\t\t" . '</div>' . "\n\t\t" . '</div>';
			}

			$html .= '</div>';

		}

		$html .= '</div>';

		if ( $options['echo'] ) {
			echo $html;
		}

		presscore_add_lazy_load_attrs();

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_get_images_list' ) ) :

	/**
	 * Images list.
	 *
	 * Description here.
	 *
	 * @return string HTML.
	 */
	function presscore_get_images_list( $attachments_data, $args = array() ) {
		if ( empty( $attachments_data ) ) {
			return '';
		}

		$default_args = array(
			'open_in_lightbox' => false,
			'show_share_buttons' => false
		);
		$args = wp_parse_args( $args, $default_args );

		static $gallery_counter = 0;
		$gallery_counter++;

		$html = '';

		$base_img_args = array(
			'custom' => '',
			'class' => '',
			'img_class' => 'images-list',
			'echo' => false,
			'wrap' => '<img %SRC% %IMG_CLASS% %ALT% style="width: 100%;" />',
		);

		$video_classes = 'video-icon dt-pswp-item pswp-video';

		if ( $args['open_in_lightbox'] ) {

			$base_img_args = array(
				'class' => 'dt-pswp-item rollover rollover-zoom',
				'img_class' => 'images-list',
				'echo' => false,
				'wrap' => '<a %HREF% %TITLE% %CLASS% %CUSTOM%><img %SRC% %IMG_CLASS% %ALT% style="width: 100%;" /></a>'
			);

		} else {
			$video_classes .= ' dt-single-pswp';
		}

		foreach ( $attachments_data as $data ) {

			if ( empty($data['full']) ) {
				continue;
			}

			$is_video = !empty( $data['video_url'] );

			$html .= "\n\t" . '<div class="images-list">';

			$image_args = array(
				'img_meta' 	=> array( $data['full'], $data['width'], $data['height'] ),
				'img_id'	=> empty($data['ID']) ? 0 : $data['ID'],
				'title'		=> $data['title'],
				'alt'		=> $data['alt'],
				'custom'	=> ' data-dt-img-description="' . esc_attr( $data['description'] ) . '" data-large_image_width="' . $data['width'] . '" data-large_image_height = "' . $data['height']. '"',
			);

			$image_args = array_merge( $base_img_args, $image_args );

			// $media_content = '';
			if ( $is_video ) {

				$image_args['href'] = $data['video_url'];
				// $image_args['custom'] = 'data-dt-img-description="' . esc_attr($data['description']) . '"';
				$image_args['title'] = $data['title'];
				$image_args['class'] = $video_classes;
				$image_args['wrap'] = '<div class="rollover-video"><img %SRC% %IMG_CLASS% %ALT% style="width: 100%;" /><a %HREF% %TITLE% %CLASS% %CUSTOM%></a></div>';
			}

			$image = dt_get_thumb_img( $image_args );

			$html .= "\n\t\t" . $image;// . $media_content;

			if ( $args['show_share_buttons'] || !empty( $data['description'] ) || !empty($data['title']) || !empty($data['link']) ) {
				$html .= "\n\t\t" . '<div class="images-list-caption">' . "\n\t\t\t" . '<div class="images-list-inner">';

				$links = '';
				if ( !empty($data['link']) ) {
					$links .= '<a href="' . $data['link'] . '" class="slider-link" target="_blank"></a>';
				}

				if ( $args['show_share_buttons'] ) {
					ob_start();
					the7_display_popup_share_buttons( $data['ID'] );
					$links .= "\n\t\t\t\t" . ob_get_clean();
				}

				if ( $links ) {
					$html .= '<div class="album-content-btn">' . $links . '</div>';
				}

				if ( !empty($data['title']) ) {
					$html .= "\n\t\t\t" . '<h4>' . $data['title'] . '</h4>';
				}

				$html .= "\n\t\t\t\t" . wpautop($data['description']);

				$html .= "\n\t\t\t" . '</div>' . "\n\t\t" . '</div>';
			}

			$html .= '</div>';

		}

		if ( $args['open_in_lightbox'] ) {

			$container_atts = '';
			if ( $args['show_share_buttons'] ) {
				$container_atts .= presscore_get_share_buttons_for_prettyphoto( 'photo' );
			}

			$html = '<div class="dt-gallery-container"' . $container_atts . '>' . $html . '</div>';
		}

		return $html;
	}

endif; // presscore_get_images_list

if ( ! function_exists( 'presscore_get_images_gallery_1' ) ) :

	/**
	 * Gallery helper.
	 *
	 * @param array $attachments_data Attachments data array.
	 * @return string HTML.
	 */
	function presscore_get_images_gallery_1( $attachments_data, $options = array() ) {
		if ( empty( $attachments_data ) ) {
			return '';
		}

		static $gallery_counter = 0;
		$gallery_counter++;

		$default_options = array(
			'echo'			=> false,
			'class'			=> array(),
			'links_rel'		=> '',
			'style'			=> '',
			'columns'		=> 4,
			'first_big'		=> true,
			'show_only'		=> count( $attachments_data ),
		);
		$options = wp_parse_args( $options, $default_options );

		$gallery_cols = absint($options['columns']);
		if ( !$gallery_cols ) {
			$gallery_cols = $default_options['columns'];
		} else if ( $gallery_cols > 6 ) {
			$gallery_cols = 6;
		}

		$options['class'] = (array) $options['class']; 
		$options['class'][] = 'dt-format-gallery';
		$options['class'][] = 'gallery-col-' . $gallery_cols;
		$options['class'][] = 'dt-gallery-container';

		$container_class = implode( ' ', $options['class'] );

		$html = '<div class="' . esc_attr( $container_class ) . '"' . $options['style'] . '>';

		// clear attachments_data
		foreach ( $attachments_data as $index=>$data ) {
			if ( empty($data['full']) ) unset($attachments_data[ $index ]);
		}
		unset($data);

		if ( empty($attachments_data) ) {
			return '';
		}

		$show_only = absint( $options['show_only'] );

		if ( $options['first_big'] ) {

			$show_only--;
			$big_image = current( array_slice($attachments_data, 0, 1) );
			$gallery_images = array_slice($attachments_data, 1);
		} else {

			$gallery_images = $attachments_data;
		}

		$image_custom = $options['links_rel'];
		$media_container_class = 'rollover-video';

		$image_args = array(
			'img_class' => '',
			'class'		=> 'rollover rollover-zoom dt-pswp-item',
			'echo'		=> false,
		);

		$media_args = array_merge( $image_args, array(
			'class'		=> 'dt-pswp-item pswp-video rollover rollover-video',
		) );

		if ( isset($big_image) ) {

			// big image
			$big_image_args = array(
				'img_meta' 	=> array( $big_image['full'], $big_image['width'], $big_image['height'] ),
				'img_id'	=> empty( $big_image['ID'] ) ? 0 : $big_image['ID'], 
				'options'	=> array( 'w' => 600, 'h' => 600, 'z' => true ),
				'alt'		=> $big_image['alt'],
				'title'		=> $big_image['title'],
				'echo'		=> false,
				'custom'	=> $image_custom . ' data-dt-img-description="' . esc_attr($big_image['description']) . '" data-large_image_width="' . $big_image['width'] . '" data-large_image_height = "' . $big_image['height']. '"'
			);

			if ( empty($big_image['video_url']) ) {
				$big_image_args['class'] = $image_args['class'] . ' big-img';

				$image = dt_get_thumb_img( array_merge( $image_args, $big_image_args ) );
			} else {
				$big_image_args['href'] = $big_image['video_url'];
				$big_image_args['class'] = $media_args['class'] . ' big-img';

				$image = dt_get_thumb_img( array_merge( $media_args, $big_image_args ) );
			}

			$html .= "\n\t\t" . $image;
		}

		// medium images
		if ( !empty($gallery_images) ) {

			foreach ( $gallery_images as $data ) {

				// hide images
				if ( 0 >= $show_only-- ) {
					$image_custom .= ' style="display: none;"';
				}

				$medium_image_args = array(
					'img_meta' 	=> array( $data['full'], $data['width'], $data['height'] ),
					'img_id'	=> empty( $data['ID'] ) ? 0 : $data['ID'], 
					'options'	=> array( 'w' => 300, 'h' => 300, 'z' => true ),
					'alt'		=> $data['alt'],
					'title'		=> $data['title'],
					'echo'		=> false,
					'custom'	=> $image_custom . ' data-dt-img-description="' . esc_attr($data['description']) . '" data-large_image_width="' . $data['width'] . '" data-large_image_height = "' . $data['height']. '"'
				);

				if ( empty($data['video_url']) ) {
					$image = dt_get_thumb_img( array_merge( $image_args, $medium_image_args ) );
				} else {
					$medium_image_args['href'] = $data['video_url'];

					$image = dt_get_thumb_img( array_merge( $media_args, $medium_image_args ) );
				}

				$html .= $image;
			}
		}

		$html .= '</div>';

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_get_images_gallery_hoovered' ) ) :

	/**
	 * Hoovered gallery.
	 *
	 * @param array $attachments_data Attachments data array.
	 * @param array $options Gallery options.
	 *
	 * @return string HTML.
	 */
	function presscore_get_images_gallery_hoovered( $cover, $attachments_data = array(), $options = array() ) {
		// clear attachments_data
		foreach ( $attachments_data as $index=>$data ) {
			if ( empty( $data['full'] ) ) {
				unset( $attachments_data[ $index ] );
			}
		}
		unset( $data );

		if ( empty( $cover ) ) {
			return '';
		}

		static $gallery_counter = 0;
		$gallery_counter++;

		$id_mark_prefix = 'pp-gallery-hoovered-media-content-' . $gallery_counter . '-';

		$default_options = array(
			'echo'			=> false,
			'class'			=> array(),
			'links_rel'		=> '',
			'style'			=> '',
			'share_buttons'	=> false,
			'exclude_cover'	=> false,
			'title_img_options' => array(),
			'title_image_args' => array(),
			'attachments_count' => null,
			'show_preview_on_hover' => true,
			'video_icon' => true
		);
		$options = wp_parse_args( $options, $default_options );

		$class = implode( ' ', (array) $options['class'] );

		$small_images = $attachments_data;
		$big_image = $cover;

		if ( ! is_array($options['attachments_count']) || count($options['attachments_count']) < 2 ) {

			$attachments_count = presscore_get_attachments_data_count( $options['exclude_cover'] ? $small_images : $attachments_data );

		} else {

			$attachments_count = $options['attachments_count'];
		}

		list( $images_count, $videos_count ) = $attachments_count;

		$count_text = array();

		if ( $images_count ) {
			$count_text[] = sprintf( _n( '1 image', '%s images', $images_count, 'the7mk2' ), $images_count );
		}

		if ( $videos_count ) {
			$count_text[] = sprintf( __( '%s video', 'the7mk2' ), $videos_count );
		}

		$count_text = implode( ',&nbsp;', $count_text );

		$image_args = array(
			'img_class' => 'preload-me',
			'class'		=> $class,
			'custom'	=> implode( ' ', array( $options['links_rel'], $options['style'] ) ),
			'echo'		=> false,
		);

		$image_hover = '';
		$mini_count = 3;
		$html = '';
		$share_buttons = '';

		if ( $options['share_buttons'] ) {
			$share_buttons = presscore_get_share_buttons_for_prettyphoto( 'photo' );
		}

		// medium images
		if ( !empty( $small_images ) ) {
			presscore_remove_lazy_load_attrs();

			$html .= '<div class="dt-gallery-container dt-album"' . $share_buttons . '>';
			foreach ( $attachments_data as $key=>$data ) {
				$thumb_meta = wp_get_attachment_image_src( $attachments_data, 'full' );
				$small_image_args = array(
					'img_meta' 	=> $data['thumbnail'],
					'img_id'	=> empty( $data['ID'] ) ? 0 : $data['ID'],
					'alt'		=> $data['title'],
					'title'		=> $data['description'],
					'href'		=> esc_url( $data['full'] ),
					'custom'	=> '',
					'class'		=> 'dt-pswp-item',
				);

				if ( $options['share_buttons'] ) {
					$small_image_args['custom'] = 'data-dt-location="' . esc_attr($data['permalink']) . '" ';
				}

				$mini_image_args = array(
					'img_meta' 	=> $data['thumbnail'],
					'img_id'	=> empty( $data['ID'] ) ? 0 : $data['ID'],
					'alt'		=> $data['title'],
					'title'		=> $data['description'],
					'wrap'		=> '<img %IMG_CLASS% %SRC% %ALT% %IMG_TITLE% width="90" />',
				);

				if ( $mini_count && !( !$options['exclude_cover'] && 0 == $key ) && $options['show_preview_on_hover'] ) {
					$image_hover = '<span class="r-thumbn-' . $mini_count . '">' . dt_get_thumb_img( array_merge( $image_args, $mini_image_args ) ) . '<i>' . $count_text . '</i></span>' . $image_hover;
					$mini_count--;
				}

				if ( !empty($data['video_url']) ) {
					$small_image_args['href'] = $data['video_url'];
					$small_image_args['class'] = 'pswp-video dt-pswp-item';
				}

				$small_image_args['custom'] .= ' aria-label="' . esc_attr__( 'Gallery image', 'dt-the7-core' ) . '"';

				$html .= sprintf( '<a href="%s" title="%s" class="%s" data-large_image_width="' . $data['width'] . '" data-large_image_height = "' . $data['height']. '" data-dt-img-description="%s" %s></a>',
					esc_url($small_image_args['href']),
					esc_attr($small_image_args['alt']),
					esc_attr($small_image_args['class'] ),
					esc_attr($small_image_args['title']),
					$small_image_args['custom']
				);


			}
			$html .= '</div>';

			presscore_add_lazy_load_attrs();
		}
		unset( $image );

		if ( $image_hover && $options['show_preview_on_hover'] ) {
			$image_hover = '<span class="rollover-thumbnails">' . $image_hover . '</span>';
		}

		// big image
		$big_image_args = array(
			'img_meta' 	=> array( $big_image['full'], $big_image['width'], $big_image['height'] ),
			'img_id'	=> empty( $big_image['ID'] ) ? 0 : $big_image['ID'],
			'wrap'		=> '<a %HREF% %CLASS% %CUSTOM% %TITLE%><img %SRC% %IMG_CLASS% %ALT% %IMG_TITLE% %SIZE% />%_MINI_IMG_%</a>',
			'alt'		=> $big_image['alt'],
			'title'		=> $big_image['title'],
			'class'		=> $class,
			'options'	=> $options['title_img_options']
		);


		if ( empty( $small_images ) ) {

			$big_image_args['custom'] = ' data-dt-img-description="' . esc_attr($big_image['description']) . '" data-large_image_width="' . $big_image['width'] . '" data-large_image_height = "' . $big_image['height']. '" '. $share_buttons;

			if ( $options['share_buttons'] ) {
				$big_image_args['custom'] = ' data-dt-location="' . esc_attr($big_image['permalink']) . '"' . $big_image_args['custom'];
			}

			$big_image_args['class'] .= ' dt-pswp-item';
		} else {

			$big_image_args['custom'] = $image_args['custom'];
			$big_image_args['class'] .= ' dt-gallery-pswp';
		}

		$big_image_args['custom'] .= ' aria-label="' . esc_attr__( 'Gallery image', 'dt-the7-core' ) . '"';

		$big_image_args = apply_filters('presscore_get_images_gallery_hoovered-title_img_args', $big_image_args, $image_args, $options, $big_image);

		if ( !empty( $big_image['video_url'] ) && !$options['exclude_cover'] ) {
			$big_image_args['href'] = $big_image['video_url'];

			if ( $options['video_icon'] ) {
				$video_link_classes = 'video-icon';
				if ( empty( $small_images ) ) {
					$video_link_classes .= ' pswp-video dt-single-pswp dt-pswp-item';
				} else {
					$video_link_classes .= ' dt-gallery-pswp';
				}

				$video_link_custom = $big_image_args['custom'];

				$big_image_args['class'] = str_replace( array('rollover'), array('rollover-video', ''), $class);
				$big_image_args['custom'] = $options['style'];

				$big_image_args['wrap'] = '<div %CLASS% %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %IMG_TITLE% %SIZE% /><a %HREF% %TITLE% class="' . $video_link_classes . '"' . $video_link_custom . '></a></div>';
			} else {
				$big_image_args['class'] = str_replace( 'dt-pswp-item', 'dt-pswp-item pswp-video', $big_image_args['class'] );
			}
		}
		$image = dt_get_thumb_img( array_merge( $image_args, $big_image_args, $options['title_image_args'] ) );

		$image = str_replace( '%_MINI_IMG_%', $image_hover, $image );

		$html = $image . $html;

		return apply_filters( 'presscore_get_images_gallery_hoovered-html', $html );
	}

endif;

/**
 * Return share buttons header.
 *
 * @param string $place Share buttons context.
 *
 * @return string
 */
function the7_get_share_buttons_header( $place ) {
	$header = of_get_option( "social_buttons-{$place}-button_title" );
	if ( ! $header ) {
		$header = __( 'Share this', 'the7mk2' );
	}

	return (string) $header;
}

/**
 * Display popup share buttons. Used in sliders.
 *
 * @since 7.8.0
 *
 * @param null   $image_id   ID of the image to share. If null, then current post will be used instead.
 * @param string $wrap_class Buttons wrap class.
 */
function the7_display_popup_share_buttons( $image_id = null, $wrap_class = 'album-share-overlay' ) {
	$place         = 'photo';
	$share_buttons = the7_get_share_buttons_list( $place, $image_id );
	if ( apply_filters( 'presscore_hide_share_buttons', empty( $share_buttons ) ) ) {
		return;
	}

	presscore_get_template_part(
		'theme',
		'share-buttons/popup-share-buttons',
		null,
		array(
			'wrap_class'           => $wrap_class,
			'share_buttons_header' => the7_get_share_buttons_header( $place ),
			'share_buttons'        => $share_buttons,
		)
	);
}

/**
 * Display post share buttons.
 *
 * @since 7.8.0
 *
 * @param string $place      Share buttons context.
 * @param null   $post_id    ID of the post to share. If null, then current post will be shared.
 * @param string $wrap_class Buttons wrap class.
 */
function the7_display_post_share_buttons( $place, $post_id = null, $wrap_class = 'single-share-box' ) {
	$share_buttons = the7_get_share_buttons_list( $place, $post_id );
	if ( apply_filters( 'presscore_hide_share_buttons', empty( $share_buttons ) ) ) {
		return;
	}

	if ( 'on_hover' === of_get_option( 'social_buttons-visibility' ) ) {
		$wrap_class .= ' show-on-hover';
	}

	presscore_get_template_part(
		'theme',
		'share-buttons/post-share-buttons',
		null,
		array(
			'wrap_class'           => $wrap_class,
			'share_buttons_header' => the7_get_share_buttons_header( $place ),
			'share_buttons'        => $share_buttons,
		)
	);
}

/**
 * Return share buttons list attached to $place and post with $post_id.
 *
 * @since 7.8.0
 *
 * @param string $place   Share buttons context.
 * @param null   $post_id ID of the post to share. If null, then current post will be shared.
 *
 * @return array
 */
function the7_get_share_buttons_list( $place, $post_id = null ) {
	global $post;

	$buttons = of_get_option( 'social_buttons-' . $place, array() );

	if ( empty( $buttons ) ) {
		return array();
	}

	// get title
	if ( ! $post_id ) {
		$_post   = $post;
		$post_id = $_post->ID;
	} else {
		$_post = get_post( $post_id );
	}

	$t = isset( $_post->post_title ) ? $_post->post_title : '';

	// get permalink
	$u = get_permalink( $post_id );

	$buttons_list  = presscore_themeoptions_get_social_buttons_list();
	$protocol      = is_ssl() ? "https" : "http";
	$share_buttons = array();
	$title_tpl     = __( 'Share on %s', 'the7mk2' );
	$buttons       = array_intersect( $buttons, array_keys( $buttons_list ) );
	foreach ( $buttons as $button ) {
		$esc_url   = true;
		$url       = $custom = $icon_class = '';
		$desc      = $buttons_list[ $button ];
		$title     = sprintf( $title_tpl, $desc );
		$alt_title = $title;

		switch ( $button ) {
			case 'twitter':
				$icon_class = 'twitter';
				$url        = add_query_arg(
					array( 'url' => rawurlencode( $u ), 'text' => urlencode( $t ) ),
					'https://twitter.com/share'
				);
				$alt_title  = __( 'Tweet', 'the7mk2' );
				break;
			case 'facebook':
				$icon_class = 'facebook';
				$url        = add_query_arg(
					array( 'u' => rawurlencode( $u ), 't' => urlencode( $t ) ),
					'http://www.facebook.com/sharer.php'
				);
				break;
			case 'pinterest':
				$icon_class = 'pinterest pinit-marklet';
				$url        = '//pinterest.com/pin/create/button/';
				$custom     = ' data-pin-config="above" data-pin-do="buttonBookmark"';
				// if image
				if ( wp_attachment_is_image( $post_id ) ) {
					$image = wp_get_attachment_image_src( $post_id, 'full' );
					if ( ! empty( $image ) ) {
						$url        = add_query_arg(
							array(
								'url'         => rawurlencode( $u ),
								'media'       => rawurlencode( $image[0] ),
								'description' => rawurlencode(
									apply_filters( 'get_the_excerpt', $_post->post_content )
								),
							),
							$url
						);
						$custom     = ' data-pin-config="above" data-pin-do="buttonPin"';
						$icon_class = 'pinterest';
					}
				}
				$alt_title = __( 'Pin it', 'the7mk2' );
				break;
			case 'linkedin':
				$bt         = get_bloginfo( 'name' );
				$url        = $protocol . '://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode(
						$u
					) . '&title=' . rawurlencode( $t ) . '&summary=&source=' . rawurlencode( $bt );
				$icon_class = 'linkedin';
				break;
			case 'whatsapp':
				$esc_url    = false;
				$url        = 'https://api.whatsapp.com/send?text=' . rawurlencode( "{$t} - {$u}" );
				$custom     = ' data-action="share/whatsapp/share"';
				$icon_class = 'whatsapp';
				break;
		}

		if ( $esc_url ) {
			$url = esc_url( $url );
		}

		$share_buttons[] = array(
			'id'          => $button,
			'url'         => $url,
			'name'        => $desc,
			'title'       => $title,
			'alt_title'   => $alt_title,
			'icon_class'  => $icon_class,
			'custom_atts' => $custom,
		);
	}

	return (array) apply_filters( 'the7_get_share_buttons_list', $share_buttons, $place, $post_id, $buttons );
}

/**
 * @since 8.3.0
 *
 * @param int $post_id
 *
 * @return string
 * @throws Exception
 */
function the7_generate_post_css( $post_id ) {
	return The7_Post_CSS_Generator::generate_css_for_post(
		$post_id,
		the7_get_new_shortcode_less_vars_manager(),
		new The7_Less_Compiler()
	);
}
