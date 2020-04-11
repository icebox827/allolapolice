<?php
/**
 * Theme hooks.
 *
 * @since 1.0.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

add_action( 'get_header', 'presscore_template_config_init', 9 );
add_action( 'wp_head', 'presscore_tracking_code_in_header_action', 9999 );
add_filter( 'presscore_get_attachment_post_data-attachment_data', 'presscore_filter_attachment_data', 15 );
add_filter( 'dt_get_thumb_img-args', 'presscore_add_default_meta_to_images', 15 );
add_filter( 'presscore_post_edit_link', 'presscore_wrap_edit_link_in_p', 15 );
add_filter( 'presscore_get_category_list-args', 'presscore_filter_categorizer_hash_arg', 15 );
add_action( 'parse_query', 'presscore_parse_query_for_front_page_categorizer' );
add_action( 'init', 'presscore_react_on_categorizer', 15 );
add_filter( 'the_excerpt', 'presscore_add_password_form_to_excerpts', 99 );
add_filter( 'excerpt_more', 'presscore_excerpt_more_filter' );
add_filter( 'teammate_thumbnail_args', 'presscore_set_image_width_based_on_column_width', 15 );
add_filter( 'dt_get_thumb_img-args', 'presscore_add_preload_me_class_to_images', 15 );
add_action( 'presscore_before_loop', 'presscore_page_masonry_controller', 25 );
add_action( 'presscore_before_shortcode_loop', 'presscore_page_masonry_controller', 25 );
add_action( 'presscore_after_loop', 'presscore_remove_posts_masonry_wrap', 15 );
add_action( 'presscore_after_shortcode_loop', 'presscore_remove_posts_masonry_wrap', 15 );
add_action( 'presscore_after_main_container', 'presscore_add_footer_widgetarea', 15 );
add_action( 'presscore_after_content', 'presscore_add_sidebar_widgetarea', 15 );

add_action( 'presscore_before_main_container', 'the7_print_post_inlne_css', 10 );
add_action( 'presscore_before_main_container', 'presscore_fancy_header_controller', 15 );
add_action( 'presscore_before_main_container', 'presscore_slideshow_controller', 15 );
add_action( 'presscore_before_main_container', 'presscore_page_title_controller', 16 );

add_filter( 'post_class', 'presscore_post_class_filter' );
add_filter( 'presscore_get_category_list', 'presscore_add_wrap_for_catgorizer', 16, 2 );
add_filter( 'dt_portfolio_thumbnail_args', 'presscore_setup_image_proportions', 15 );
add_filter( 'dt_post_thumbnail_args', 'presscore_setup_image_proportions', 15 );
add_filter( 'dt_album_title_image_args', 'presscore_setup_image_proportions', 15 );
add_filter( 'dt_media_image_args', 'presscore_setup_image_proportions', 15 );
add_filter( 'presscore_get_images_gallery_hoovered-title_img_args', 'presscore_setup_image_proportions', 15 );
add_action( 'presscore_body_top', 'presscore_render_fullscreen_overlay' );
add_action( 'wp_head', 'the7_site_icon', 98 );
add_action( 'presscore_get_filtered_posts', 'presscore_update_post_thumbnail_cache' );
add_filter( 'presscore_get_header_elements_list-near_logo_left', 'presscore_empty_classic_header_microwidgets_exception_filter' );
add_filter( 'presscore_get_header_elements_list-near_logo_right', 'presscore_empty_classic_header_microwidgets_exception_filter' );
add_filter( 'presscore_get_header_elements_list-side_top_line', 'presscore_empty_top_line_microwidgets_exception_filter' );
add_action( 'presscore_before_loop', 'presscore_add_masonry_lazy_load_attrs' );
add_action( 'presscore_before_shortcode_loop', 'presscore_add_masonry_lazy_load_attrs' );
add_action( 'presscore_after_loop', 'presscore_remove_masonry_lazy_load_attrs' );
add_action( 'presscore_after_shortcode_loop', 'presscore_remove_masonry_lazy_load_attrs' );
add_action( 'wp_head', 'presscore_pingback_header' );
add_action( 'presscore_body_top', 'the7_version_comment', 0 );
add_filter( 'dt_get_resized_img-options', 'the7_setup_speed_img_resize' );
add_action( 'wp_head', 'presscore_opengraph_tags' );

if ( ! function_exists( 'presscore_template_config_init' ) ) :

	function presscore_template_config_init() {
		presscore_config_base_init();
	}

endif;

if ( ! function_exists( 'presscore_tracking_code_in_header_action' ) ) :

	/**
	 * Output trcking code in header.
	 *
	 * @since 3.0.0
	 */
	function presscore_tracking_code_in_header_action() {
		if ( ! is_preview() ) {
			echo of_get_option( 'general-tracking_code' );
		}
	}

endif;

if ( ! function_exists( 'presscore_show_navigation_next_prev_posts_titles' ) ) :

	/**
	 * For blog posts only show next/prev posts titles.
	 */
	function presscore_show_navigation_next_prev_posts_titles( $args = array() ) {
		$args['next_post_text'] = '%title';
		$args['prev_post_text'] = '%title';
		return $args;
	}

endif;

if ( ! function_exists( 'presscore_filter_attachment_data' ) ) :

	/**
	 * Filter attachment data.
	 *
	 * @since 3.1
	 */
	function presscore_filter_attachment_data( $attachment_data = array() ) {

		// hide title
		if ( ! empty( $attachment_data['ID'] ) ) {
			$hide_title = presscore_imagee_title_is_hidden( $attachment_data['ID'] );

			if ( $hide_title ) {
				$attachment_data['title'] = false;
			}
		}

		$defaults = array(
			'alt'         => '',
			'caption'     => '',
			'description' => '',
			'title'       => '',
			'permalink'   => '',
			'video_url'   => '',
			'ID'          => '',
		);

		$image_attachment_data = array_intersect_key( $attachment_data, $defaults );
		$image_attachment_data = wp_parse_args( $image_attachment_data, $defaults );

		$attachment_data['image_attachment_data'] = $image_attachment_data;

		return $attachment_data;
	}

endif;

if ( ! function_exists( 'presscore_add_default_meta_to_images' ) ) :

	/**
	 * Add description to images.
	 *
	 * TODO: use proper image attributes i.e. img_title and alt. Change all images wraps.
	 */
	function presscore_add_default_meta_to_images( $args = array() ) {
		$id = absint( $args['img_id'] );
		if ( $id ) {
			$attachment = get_post( $id );

			if ( $attachment ) {

				if ( '' === $args['title'] ) {
					$args['title'] = esc_attr( $attachment->post_title );
				}

				if ( empty( $args['img_description'] ) ) {
					$args['img_description'] = $attachment->post_content;
				}
			}

			$hide_title = presscore_imagee_title_is_hidden( $id );

			if ( $hide_title ) {
				$args['img_title'] = false;
			}
		}

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_wrap_edit_link_in_p' ) ) :

	/**
	 * Wrap edit link in p tag.
	 */
	function presscore_wrap_edit_link_in_p( $link = '' ) {
		if ( $link ) {
			$link = '<p>' . $link . '</p>';
		}
		return $link;
	}

endif;

if ( ! function_exists( 'presscore_filter_categorizer_hash_arg' ) ) :

	/**
	 * Categorizer hash filter.
	 */
	function presscore_filter_categorizer_hash_arg( $args ) {
		$config = Presscore_Config::get_instance();

		$order   = $config->get( 'order' );
		$orderby = $config->get( 'orderby' );

		$hash = add_query_arg(
			array(
				'term'    => '%TERM_ID%',
				'orderby' => $orderby,
				'order'   => $order,
			),
			get_permalink()
		);

		$args['hash'] = $hash;

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_parse_query_for_front_page_categorizer' ) ) :

	/**
	 * Add exceptions for front page templates with category filter.
	 */
	function presscore_parse_query_for_front_page_categorizer( $query ) {

		if ( $query->is_main_query() && $query->is_home && 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) {

			$_query = wp_parse_args( $query->query );

			if ( empty( $_query ) || ! array_diff( array_keys( $_query ), array( 'term', 'order', 'orderby', 'page', 'paged', 'preview', 'cpage', 'lang' ) ) ) {
				$query->is_page     = true;
				$query->is_home     = false;
				$query->is_singular = true;

				$query->query_vars['page_id'] = get_option( 'page_on_front' );
				// Correct <!--nextpage--> for page_on_front.
				if ( ! empty( $query->query_vars['paged'] ) ) {
					$query->query_vars['page'] = $query->query_vars['paged'];
				}
			}
		}

	}

endif;

if ( ! function_exists( 'presscore_filter_categorizer_current_arg' ) ) :

	/**
	 * Categorizer current filter.
	 */
	function presscore_filter_categorizer_current_arg( $args ) {
		$config = presscore_config();

		$display = $config->get( 'request_display' );

		if ( ! $display ) {
			return $args;
		}

		if ( 'only' === $display['select'] && ! empty( $display['terms_ids'] ) ) {
			$args['current'] = current( $display['terms_ids'] );
		} elseif ( 'except' === $display['select'] && 0 === (int) current( $display['terms_ids'] ) ) {
			$args['current'] = 'none';
		}
		return $args;
	}

endif;

if ( ! function_exists( 'presscore_react_on_categorizer' ) ) :

	/**
	 * Change config, categorizer.
	 */
	function presscore_react_on_categorizer() {
		if ( ! isset( $_REQUEST['term'] ) ) {
			return;
		}

		$config = presscore_config();

		if ( '' === $_REQUEST['term'] ) {
			$display = array();
		} elseif ( 'none' === $_REQUEST['term'] ) {
			$display = array(
				'terms_ids' => array( 0 ),
				'select'    => 'except',
			);
		} else {
			$display = array(
				'terms_ids' => array( absint( $_REQUEST['term'] ) ),
				'select'    => 'only',
			);
		}
		$config->set( 'request_display', $display );

		if ( isset( $_REQUEST['order'] ) ) {
			$order = strtolower( $_REQUEST['order'] );
			if ( in_array( $order, array( 'asc', 'desc' ) ) ) {
				$config->set( 'order', $order );
			}
		}

		if ( isset( $_REQUEST['orderby'] ) ) {
			$orderby = strtolower( $_REQUEST['orderby'] );
			if ( in_array( $orderby, array( 'name', 'date' ) ) ) {
				$config->set( 'orderby', $orderby );
			}
		}

		add_filter( 'presscore_get_category_list-args', 'presscore_filter_categorizer_current_arg', 15 );
	}

endif;

if ( ! function_exists( 'presscore_post_navigation_controller' ) ) :

	/**
	 * Post pagination controller.
	 */
	function presscore_post_navigation_controller() {
		if ( ! in_the_loop() ) {
			return;
		}

		$show_navigation = presscore_is_post_navigation_enabled();

		if ( $show_navigation ) {
			presscore_post_navigation();
		}
	}

endif;

if ( ! function_exists( 'presscore_add_password_form_to_excerpts' ) ) :

	/**
	 * Add post password form to excerpts.
	 *
	 * @return string
	 */
	function presscore_add_password_form_to_excerpts( $content ) {
		if ( post_password_required() ) {
			$content = get_the_password_form();
		}

		return $content;
	}

endif;

if ( ! function_exists( 'presscore_excerpt_more_filter' ) ) :

	/**
	 * Replace default excerpt more to &hellip;
	 *
	 * @return string
	 */
	function presscore_excerpt_more_filter( $more ) {
		return '&hellip;';
	}

endif;

if ( ! function_exists( 'presscore_add_more_anchor' ) ) :

	/**
	 * Add anchor #more-{$post->ID} to href.
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	function presscore_add_more_anchor( $content = '' ) {
		global $post;

		if ( $post ) {
			$content = preg_replace( '/href=[\'"]?([^\'" >]+)/', ( 'href="$1#more-' . $post->ID ), $content );
		}

		// Added in helpers.php:3120+.
		remove_filter( 'presscore_post_details_link', 'presscore_add_more_anchor', 15 );

		return $content;
	}

endif;

if ( ! function_exists( 'presscore_return_empty_string' ) ) :

	/**
	 * Return empty string.
	 *
	 * @return string
	 */
	function presscore_return_empty_string() {
		return '';
	}

endif;

if ( ! function_exists( 'presscore_gallery_post_exclude_featured_image_from_gallery' ) ) :

	/**
	 * Attempt to exclude featured image from hovered gallery in albums.
	 * Works only in the loop.
	 */
	function presscore_gallery_post_exclude_featured_image_from_gallery( $args = array(), $default_args = array(), $options = array() ) {
		global $post;

		return $args;

		if ( in_the_loop() && get_post_meta( $post->ID, '_dt_album_options_exclude_featured_image', true ) ) {
			$args['custom'] = isset( $args['custom'] ) ? $args['custom'] : trim( str_replace( $options['links_rel'], '', $default_args['custom'] ) );
			$args['class']  = $default_args['class'] . ' ignore-feaured-image';
		}

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_set_image_width_based_on_column_width' ) ) :

	/**
	 * Set image width for testimonials template and shortcode.
	 */
	function presscore_set_image_width_based_on_column_width( $args = array() ) {
		$config       = Presscore_Config::get_instance();
		$target_width = $config->get( 'target_width' );

		if ( $target_width ) {
			$args['options'] = array(
				'w' => round( $target_width * 1.5 ),
				'z' => 0,
			);
		}

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_add_preload_me_class_to_images' ) ) :

	/**
	 * Add preload-me to every image that created with dt_get_thumb_img().
	 */
	function presscore_add_preload_me_class_to_images( $args = array() ) {
		$img_class = $args['img_class'];

		$img_class = str_replace( 'preload-me', '', $img_class );

		$img_class        .= ' preload-me';
		$args['img_class'] = trim( $img_class );

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_before_post_masonry' ) ) :

	/**
	 * Add post open div for masonry layout.
	 */
	function presscore_before_post_masonry() {
		echo '<div ' . presscore_tpl_masonry_item_wrap_class() . presscore_tpl_masonry_item_wrap_data_attr() . '>';
	}

endif;

if ( ! function_exists( 'presscore_after_post_masonry' ) ) :

	/**
	 * Add post close div for masonry layout.
	 */
	function presscore_after_post_masonry() {
		echo '</div>';
	}

endif;

if ( ! function_exists( 'presscore_page_masonry_controller' ) ) :

	/**
	 * Page masonry controller.
	 *
	 * Filter classes used in post masonry wrap.
	 */
	function presscore_page_masonry_controller() {
		$config = presscore_config();

		if ( in_array( $config->get( 'layout' ), array( 'masonry', 'grid' ), true ) ) {
			add_action( 'presscore_before_post', 'presscore_before_post_masonry', 15 );
			add_action( 'presscore_after_post', 'presscore_after_post_masonry', 15 );
		}
	}

endif;

if ( ! function_exists( 'presscore_remove_posts_masonry_wrap' ) ) :

	/**
	 * Removes posts masonry wrap
	 *
	 * @since 5.0.0
	 */
	function presscore_remove_posts_masonry_wrap() {
		remove_action( 'presscore_before_post', 'presscore_before_post_masonry', 15 );
		remove_action( 'presscore_after_post', 'presscore_after_post_masonry', 15 );
	}

endif;

if ( ! function_exists( 'presscore_add_footer_widgetarea' ) ) :

	/**
	 * Add footer widgetarea.
	 */
	function presscore_add_footer_widgetarea() {
		do_action( 'the7_before_footer_widgets_output' );
		get_sidebar( 'footer' );
		do_action( 'the7_after_footer_widgets_output' );
	}

endif;

if ( ! function_exists( 'presscore_add_sidebar_widgetarea' ) ) :

	/**
	 * Add sidebar widgetarea.
	 */
	function presscore_add_sidebar_widgetarea() {
		do_action( 'the7_before_sidebar_widgets_output' );
		get_sidebar();
		do_action( 'the7_after_sidebar_widgets_output' );
	}

endif;

if ( ! function_exists( 'presscore_get_page_content_before' ) ) :

	/**
	 * Display page content before.
	 * Used in presscore_page_content_controller
	 */
	function presscore_get_page_content_before() {
		static $doing_action = false;

		// Prevent loops.
		if ( $doing_action ) {
			return;
		}

		$doing_action = true;
		if ( get_the_content() && ! post_password_required() ) {
			echo '<div class="page-info">';
			the_content();
			echo '</div>';
		}
		$doing_action = false;
	}

endif;

if ( ! function_exists( 'presscore_get_page_content_after' ) ) :

	/**
	 * Display page content after.
	 * Used in presscore_page_content_controller
	 */
	function presscore_get_page_content_after() {
		static $doing_action = false;

		// Prevent loops.
		if ( $doing_action ) {
			return;
		}

		$doing_action = true;
		if ( get_the_content() ) {
			echo '<div>';
			the_content();
			echo '</div>';
		}
		$doing_action = false;
	}

endif;

if ( ! function_exists( 'presscore_page_content_controller' ) ) :

	/**
	 * Show content for blog'like page templates.
	 *
	 * Uses template settings.
	 */
	function presscore_page_content_controller() {
		global $post;

		// If is not page - return.
		if ( ! is_page() ) {
			return;
		}

		$display_content = get_post_meta( $post->ID, '_dt_content_display', true );

		// If content hidden - return.
		if ( ! $display_content || 'no' === $display_content ) {
			return;
		}

		// Only for first page.
		if ( 'on_first_page' === $display_content && the7_get_paged_var() > 1 ) {
			return;
		}

		$content_position = get_post_meta( $post->ID, '_dt_content_position', true );

		if ( 'before_items' === $content_position ) {
			add_action( 'presscore_before_loop', 'presscore_get_page_content_before', 20 );
		} else {
			add_action( 'presscore_after_loop', 'presscore_get_page_content_after', 20 );
		}
	}

endif;

if ( ! function_exists( 'presscore_fancy_header_controller' ) ) :

	/**
	 * Fancy header controller.
	 */
	function presscore_fancy_header_controller() {
		if ( 'fancy' !== presscore_config()->get( 'header_title' ) ) {
			return;
		}

		presscore_get_template_part( 'theme', 'page-title/fancy-title' );
	}

endif;

if ( ! function_exists( 'presscore_page_title_controller' ) ) :

	/**
	 * This function display page title.
	 *
	 * @uses presscore_config()
	 * @uses presscore_is_post_title_enabled()
	 * @uses presscore_is_content_visible()
	 * @uses presscore_get_page_title_wrap_html_class()
	 * @uses presscore_get_page_title_html_class()
	 * @uses presscore_get_page_title()
	 * @uses presscore_get_page_title_breadcrumbs()
	 */
	function presscore_page_title_controller() {
		$config = presscore_config();

		if ( ! ( $config->get( 'page_title.enabled' ) || $config->get( 'page_title.breadcrumbs.enabled' ) ) ) {
			return;
		}

		$show_page_title = ( presscore_is_post_title_enabled() && presscore_is_content_visible() );
		if ( ! $show_page_title ) {
			return;
		}

		$page_title_wrap_attrs = '';
		$parallax_speed        = $config->get( 'page_title.background.parallax_speed' );
		if ( $parallax_speed ) {
			$page_title_wrap_attrs .= ' data-prlx-speed="' . $parallax_speed . '"';
		}
		?>
		<div <?php echo presscore_get_page_title_wrap_html_class( 'page-title' ), $page_title_wrap_attrs; ?>>
			<div class="wf-wrap">

				<?php
				if ( $config->get( 'page_title.enabled' ) ) {
					$page_title = '<div class="page-title-head hgroup"><h1 ' . presscore_get_page_title_html_class() . '>' . presscore_get_page_title() . '</h1></div>';
				} else {
					$page_title = '';
				}
				$page_title = apply_filters( 'presscore_page_title', $page_title );

				if ( $config->get( 'page_title.breadcrumbs.enabled' ) ) {
					$breadcrumbs = presscore_get_page_title_breadcrumbs();
				} else {
					$breadcrumbs = '';
				}

				if ( 'right' === $config->get( 'page_title.align' ) ) {
					echo $breadcrumbs, $page_title;
				} else {
					echo $page_title, $breadcrumbs;
				}
				?>
			</div>
		</div>

		<?php
	}

endif;

if ( ! function_exists( 'presscore_post_class_filter' ) ) :

	/**
	 * Add post format classes to post.
	 */
	function presscore_post_class_filter( $classes = array() ) {
		global $post;

		// All public taxonomies for posts filter.
		$taxonomy = 'category';
		if ( $post->post_type !== 'post' ) {
			$taxonomy = $post->post_type . '_category';
		}
		if ( is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {
			foreach ( (array) get_the_terms( $post->ID, $taxonomy ) as $term ) {
				if ( empty( $term->slug ) ) {
					continue;
				}

				$classes[] = sanitize_html_class( $taxonomy . '-' . $term->term_id );
			}
		}

		$config = Presscore_Config::get_instance();

		$is_archive = is_search() || is_archive();

		if ( ! $is_archive && 'wide' === $config->get( 'post.preview.width' ) ) {
			$classes[] = 'media-wide';
		}

		if ( $config->get( 'post.preview.background.enabled' ) ) {
			$classes[] = 'bg-on';
		}

		$current_layout_type = presscore_get_current_layout_type();

		if ( 'masonry' === $current_layout_type ) {
			if ( $config->get( 'post.preview.background.enabled' ) && 'fullwidth' === $config->get( 'post.preview.background.style' ) ) {
				$classes[] = 'fullwidth-img';
			}

			if ( ! $config->get( 'post.media.library' ) && ! has_post_thumbnail() ) {
				$classes[] = 'no-img';
			}

			if ( 'center' === $config->get( 'post.preview.description.alignment' ) ) {
				$classes[] = 'text-centered';
			}
		}

		if ( ! $config->get( 'post.preview.content.visible' ) ) {
			$classes[] = 'description-off';
		}

		if ( is_single() ) {
			$hentry_key = array_search( 'hentry', $classes, true );
			if ( $hentry_key !== false ) {
				unset( $classes[ $hentry_key ] );
			}
		}

		return $classes;
	}

endif;

if ( ! function_exists( 'presscore_add_wrap_for_catgorizer' ) ) :

	/**
	 * Categorizer wrap.
	 */
	function presscore_add_wrap_for_catgorizer( $html, $args ) {
		if ( $html ) {
			$class = empty( $args['class'] ) ? 'filter' : $args['class'];

			$html = '<div class="' . esc_attr( $class ) . '">' . $html . '</div>';
		}

		return $html;
	}

endif;

if ( ! function_exists( 'presscore_add_thumbnail_class_for_masonry' ) ) :

	/**
	 * @deprecated
	 * @param array $args
	 *
	 * @return array
	 */
	function presscore_add_thumbnail_class_for_masonry( $args = array() ) {
		$args = presscore_setup_image_proportions( $args );

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_setup_image_proportions' ) ) :

	/**
	 * Add proportions to images.
	 *
	 * @param array $args
	 *
	 * @return array.
	 */
	function presscore_setup_image_proportions( $args = array() ) {
		$config            = presscore_config();
		$thumb_proportions = $config->get( 'thumb_proportions' );

		if ( ! $thumb_proportions || 'resize' !== $config->get( 'image_layout' ) ) {
			return $args;
		}

		if ( is_array( $thumb_proportions ) ) {
			$thumb_proportions = wp_parse_args(
				$thumb_proportions,
				array(
					'width'  => 1,
					'height' => 1,
				)
			);
			$args['prop']      = the7_get_image_proportion( $thumb_proportions['width'], $thumb_proportions['height'] );
		} else {
			$args['prop'] = presscore_meta_boxes_get_images_proportions( $thumb_proportions );
		}

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_render_fullscreen_overlay' ) ) :

	/**
	 * Renders fullscreen overlay.
	 */
	function presscore_render_fullscreen_overlay() {
		if ( presscore_config()->get_bool( 'template.beautiful_loading.enabled' ) ) {
			$tpl_args = array();
			switch ( presscore_config()->get( 'template.beautiful_loading.loadr.style' ) ) {
				case 'square_jelly_box':
					$tpl_args['load_class'] = 'ring-loader';
					break;
				case 'ball_elastic_dots':
					$tpl_args['load_class'] = 'hourglass-loader';
					break;
				case 'custom':
					$tpl_args['loader_code'] = presscore_config()->get( 'template.beautiful_loading.loadr.custom_code' );
					break;
				default:
					$tpl_args['load_class'] = 'spinner-loader';
			}

			presscore_get_template_part( 'theme', 'loader', null, $tpl_args );
		}
	}

endif;

if ( ! function_exists( 'presscore_slideshow_controller' ) ) :

	/**
	 * Slideshow controller.
	 */
	function presscore_slideshow_controller() {
		$config = presscore_config();

		if ( 'slideshow' !== $config->get( 'header_title' ) ) {
			return;
		}

		remove_action( 'presscore_before_main_container', 'presscore_page_title_controller', 16 );

		if ( the7_get_paged_var() > 1 ) {
			return;
		}

		switch ( $config->get( 'slideshow_mode' ) ) {
			case 'revolution':
				$rev_slider = $config->get( 'slideshow_revolution_slider' );

				if ( $rev_slider && function_exists( 'putRevSlider' ) ) {

					echo '<div id="main-slideshow">';
					putRevSlider( $rev_slider );
					echo '</div>';
				}
				break;
			case 'layer':
				$layer_slider          = $config->get( 'slideshow_layer_slider' );
				$layer_bg_and_paddings = $config->get( 'slideshow_layer_bg_and_paddings' );

				if ( $layer_slider && function_exists( 'layerslider' ) ) {

					echo '<div id="main-slideshow"' . ( $layer_bg_and_paddings ? ' class="layer-fixed"' : '' ) . '>';
					layerslider( $layer_slider );
					echo '</div>';
				}
		}

		do_action( 'presscore_do_header_slideshow', $config->get( 'slideshow_mode' ) );
	}

endif;


if ( ! function_exists( 'the7_site_icon' ) ) :

	/**
	 * Display site icon.
	 *
	 * @since 6.5.0
	 */
	function the7_site_icon() {
		if ( is_customize_preview() ) {
			return;
		}

		$icons = presscore_get_device_icons();
		if ( ! $icons ) {
			return;
		}

		echo $icons;

		if ( is_admin() ) {
			remove_action( 'admin_head', 'wp_site_icon' );
		} else {
			remove_action( 'wp_head', 'wp_site_icon', 99 );
		}
	}

endif;

if ( ! function_exists( 'presscore_update_post_thumbnail_cache' ) ) :

	/**
	 * Update post thumbnail cache for $query.
	 *
	 * @param  WP_Query $query
	 */
	function presscore_update_post_thumbnail_cache( $query ) {
		if ( $query->have_posts() ) {
			update_post_thumbnail_cache( $query );
		}
	}

endif;

if ( ! function_exists( 'presscore_empty_classic_header_microwidgets_exception_filter' ) ) :

	/**
	 * Render empty microwidgets wrap if there is no elements near logo for classic layout.
	 *
	 * @since 3.0.0
	 *
	 * @param  array $elements
	 * @return array
	 */
	function presscore_empty_classic_header_microwidgets_exception_filter( $elements ) {
		if ( ! $elements && 'classic' === presscore_config()->get( 'header.layout' ) ) {
			$elements = array( 'dummy_element' );
		}
		return $elements;
	}

endif;

if ( ! function_exists( 'presscore_empty_top_line_microwidgets_exception_filter' ) ) :

	/**
	 * Render empty microwidgets wrap if there is no elements in top bar for "on click" haders.
	 *
	 * @since 3.0.0
	 *
	 * @param  array $elements
	 * @return array
	 */
	function presscore_empty_top_line_microwidgets_exception_filter( $elements ) {
		if ( ! $elements && presscore_mixed_header_with_top_line() ) {
			$elements = array( 'dummy_element' );
		}
		return $elements;
	}

endif;

if ( ! function_exists( 'presscore_add_images_lazy_loading' ) ) :

	/**
	 * Add lazy loading capabilities to images.
	 *
	 * @param  array $args
	 * @return array
	 */
	function presscore_add_images_lazy_loading( $args = array() ) {
		if ( presscore_lazy_loading_enabled() ) {
			$args['lazy_loading'] = true;
		}

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_add_lazy_load_attrs' ) ) :

	function presscore_add_lazy_load_attrs() {
		if ( ! has_filter( 'dt_get_thumb_img-args', 'presscore_add_images_lazy_loading' ) ) {
			add_filter( 'dt_get_thumb_img-args', 'presscore_add_images_lazy_loading' );
		}
	}

	presscore_add_lazy_load_attrs();

endif;

if ( ! function_exists( 'presscore_remove_lazy_load_attrs' ) ) :

	function presscore_remove_lazy_load_attrs() {
		remove_filter( 'dt_get_thumb_img-args', 'presscore_add_images_lazy_loading' );
	}

endif;

if ( ! function_exists( 'presscore_add_masonry_lazy_load_attrs' ) ) :

	/**
	 * Add lazy loading images attributes.
	 */
	function presscore_add_masonry_lazy_load_attrs() {
		if ( ! has_filter( 'dt_get_thumb_img-output', 'presscore_masonry_lazy_loading' ) ) {
			add_filter( 'dt_get_thumb_img-output', 'presscore_masonry_lazy_loading', 10, 2 );
		}
	}

endif;

if ( ! function_exists( 'presscore_remove_masonry_lazy_load_attrs' ) ) :

	/**
	 * Remove lazy loading images attributes.
	 */
	function presscore_remove_masonry_lazy_load_attrs() {
		remove_filter( 'dt_get_thumb_img-output', 'presscore_masonry_lazy_loading', 10 );
	}

endif;

if ( ! function_exists( 'presscore_masonry_lazy_loading' ) ) :

	/**
	 * Custom layzr attribute for masonry layout.
	 *
	 * @since 3.3.0
	 *
	 * @param  string $output
	 * @param  array  $args
	 * @return string
	 */
	function presscore_masonry_lazy_loading( $output = '', $args = array() ) {
		$config = presscore_config();
		if ( ! empty( $args['lazy_loading'] ) && ! $config->get( 'is_scroller' ) ) {
			if ( $config->get( 'justified_grid' ) ) {
				$output = str_replace( 'lazy-load', 'jgrid-lazy-load', $output );
			} elseif ( in_array( $config->get( 'layout' ), array( 'masonry', 'grid' ), true ) ) {
				$output = str_replace( 'lazy-load', 'iso-lazy-load', $output );
			}
		}
		return $output;
	}

endif;


if ( ! function_exists( 'presscore_pingback_header' ) ) :
	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 */
	function presscore_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
		}
	}
endif;

if ( ! function_exists( 'presscore_opengraph_tags' ) ) :

	/**
	 * Output OpenGraph tags if seo plugins is not active.
	 *
	 * @since   3.7.2
	 */
	function presscore_opengraph_tags() {
		global $post;

		if ( ! of_get_option( 'the7_opengraph_tags' ) ) {
			return;
		}

		if ( defined( 'WPSEO_VERSION' ) || ! $post || is_home() || is_archive() || is_search() ) {
			return;
		}

		// Fix warnings in php 7.2.x.
		setup_postdata( $post );

		$the7_og = new The7_OpenGraph();
		echo $the7_og->site_name();
		echo $the7_og->title();
		echo $the7_og->description();
		echo $the7_og->image();
		echo $the7_og->url();
		echo $the7_og->type();
	}

endif;

if ( ! function_exists( 'the7_version_comment' ) ) :

	/**
	 * This function print comment with theme version after body tag.
	 * Used to ease life support.
	 *
	 * @since 5.3.0
	 */
	function the7_version_comment() {
		echo '<!-- The7 ' . THE7_VERSION . " -->\n";
	}

endif;

if ( ! function_exists( 'the7_setup_speed_img_resize' ) ) {

	/**
	 * Filter that force aq_resizer do not call getimagesize twice for every image...
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	function the7_setup_speed_img_resize( $args = array() ) {
		if ( of_get_option( 'advanced-speed_img_resize', false ) ) {
			$args['speed_resize'] = true;
		}

		return $args;
	}
}

/**
 * Print post inline css
 *
 * Include fancy header and post content padding override.
 *
 * @since 8.3.0
 */
function the7_print_post_inlne_css() {
	$config = presscore_config();

	$post_inline_css = The7_Post_CSS_Generator::get_css_for_post( $config->get( 'post_id' ) );
	if ( $post_inline_css ) {
		echo '<style id="the7-page-content-style">', "\n", $post_inline_css, "\n", '</style>';
	}
}
