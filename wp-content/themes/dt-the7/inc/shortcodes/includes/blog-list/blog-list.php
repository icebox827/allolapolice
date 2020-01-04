<?php
/**
 * Blog list shortcode.
 */

defined( 'ABSPATH' ) || exit;

require_once trailingslashit( PRESSCORE_SHORTCODES_INCLUDES_DIR ) . 'class-dt-blog-shortcode-html.php';

if ( ! class_exists( 'DT_Shortcode_BlogList', false ) ):

	class DT_Shortcode_BlogList extends DT_Shortcode_With_Inline_Css {

		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Shortcode_BlogList|null
		 */
		public static $instance = null;

		/**
		 * @return DT_Shortcode_BlogList
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * DT_Shortcode_BlogList constructor.
		 */
		public function __construct() {
			$this->sc_name = 'dt_blog_list';
			$this->unique_class_base = 'blog-list-shortcode-id';
			$this->taxonomy = 'category';
			$this->post_type = 'post';
			$this->default_atts = array(
				'post_type'                      => 'category',
				'category'                       => '',
				'tags'                           => '',
				'posts'                          => '',
				'posts_offset'                   => 0,
				'layout'                         => 'classic',
				'cl_image_width'                 => '50%',
				'cl_dividers'                    => 'n',
				'cl_dividers_color'              => '',
				'ce_content_width'               => '75%',
				'ce_dividers'                    => 'n',
				'ce_dividers_color'              => '',
				'bo_content_width'               => '75%',
				'bo_content_top_overlap'         => '100px',
				'si_content_align'               => 'checkerboard',
				'si_content_side_overlap'        => '150px',
				'si_content_top_margin'          => '50px',
				'si_image_width'                 => '75%',
				'mobile_switch_width'            => '768px',
				'custom_title_color'             => '',
				'custom_content_color'           => '',
				'custom_meta_color'              => '',
				'content_bg'                     => 'y',
				'custom_content_bg_color'        => '',
				'image_sizing'                   => 'resize',
				'resized_image_dimensions'       => '3x2',
				'image_paddings'                 => '0px 0px 0px 0px',
				'image_scale_animation_on_hover' => 'slow_scale',
				'image_hover_bg_color'           => 'disabled',
				'custom_rollover_bg_color'       => 'rgba(0,0,0,0.5)',
				'custom_rollover_bg_gradient'    => '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
				'show_zoom'                      => 'n',
				'gallery_image_zoom_icon'        => 'icon-im-hover-001',
				'project_icon_size'              => '32px',
				'dt_project_icon'                => '',
				'project_icon_bg_size'           => '44px',
				'project_icon_border_width'      => '0',
				'project_icon_border_radius'     => '100px',
				'project_icon_color'             => 'rgba(255,255,255,1)',
				'project_icon_border_color'      => '',
				'project_icon_bg'                => 'n',
				'project_icon_bg_color'          => 'rgba(255,255,255,0.3)',
				'loading_mode'                   => 'disabled',
				'dis_posts_total'                => '-1',
				'st_posts_per_page'              => '',
				'st_show_all_pages'              => 'n',
				'st_gap_before_pagination'       => '',
				'jsp_posts_total'                => '-1',
				'jsp_posts_per_page'             => '',
				'jsp_show_all_pages'             => 'n',
				'jsp_gap_before_pagination'      => '',
				'jsm_posts_total'                => '-1',
				'jsm_posts_per_page'             => '',
				'jsm_gap_before_pagination'      => '',
				'jsl_posts_total'                => '-1',
				'jsl_posts_per_page'             => '',
				'fancy_date'                     => 'n',
				'fancy_date_font_color'          => '#2d2d2d',
				'fancy_date_bg_color'            => '#ffffff',
				'fancy_date_line_color'          => '',
				'fancy_categories'               => 'n',
				'fancy_categories_font_color'    => '',
				'fancy_categories_bg_color'      => '',
				'post_content_paddings'          => '25px 30px 30px 30px',
				'post_title_font_style'          => ':bold:',
				'post_title_font_size'           => '',
				'post_title_line_height'         => '',
				'post_title_bottom_margin'       => '5px',
				'post_date'                      => 'y',
				'post_category'                  => 'y',
				'post_author'                    => 'y',
				'post_comments'                  => 'y',
				'meta_info_font_style'           => '',
				'meta_info_font_size'            => '',
				'meta_info_line_height'          => '',
				'meta_info_bottom_margin'        => '15px',
				'post_content'                   => 'show_excerpt',
				'excerpt_words_limit'            => '',
				'content_font_style'             => '',
				'content_font_size'              => '',
				'content_line_height'            => '',
				'content_bottom_margin'          => '5px',
				'read_more_button'               => 'default_link',
				'read_more_button_text'          => '',
				'show_categories_filter'         => 'n',
				'show_orderby_filter'            => 'n',
				'show_order_filter'              => 'n',
				'gap_between_posts'              => '50px',
				'order'                          => 'desc',
				'orderby'                        => 'date',
				'filter_position'				 => 'center',
				'gap_below_category_filter'      => '',
				'navigation_font_color'          => '',
				'navigation_accent_color'        => '',
			);

			parent::__construct();
		}

		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			$query = $this->get_loop_query();

			$loading_mode = $this->get_att( 'loading_mode' );

			$data_post_limit = '-1';
			switch ( $loading_mode ) {
				case 'js_pagination':
					$data_post_limit = $this->get_att( 'jsp_posts_per_page', get_option( 'posts_per_page' ) );
					break;
				case 'js_more':
					$data_post_limit = $this->get_att( 'jsm_posts_per_page', get_option( 'posts_per_page' ) );
					break;
				case 'js_lazy_loading':
					$data_post_limit = $this->get_att( 'jsl_posts_per_page', get_option( 'posts_per_page' ) );
					break;
			}

			if ( 'disabled' == $loading_mode ) {
				$data_pagination_mode = 'none';
			} else if ( in_array( $loading_mode, array( 'js_more', 'js_lazy_loading' ) ) ) {
				$data_pagination_mode = 'load-more';
			} else {
				$data_pagination_mode = 'pages';
			}
			$show_icon_zoom = '';
			if ( $this->get_att( 'show_zoom' ) === 'y' ) {
				$show_icon_zoom = '<span class="gallery-zoom-ico ' . esc_attr( $this->get_att( 'gallery_image_zoom_icon' ) ) . '"><span></span></span>';
			}

			$data_atts = array(
				'data-post-limit="' . intval( $data_post_limit ) . '"',
				'data-pagination-mode="' . esc_attr( $data_pagination_mode ) . '"',
			);
			echo '<div ' . $this->container_class( 'articles-list blog-shortcode mode-list' ) . presscore_list_container_data_atts( $data_atts ) . '>';

			// Posts filter.
			$filter_class = array();
			if ( 'standard' == $loading_mode ) {
				$filter_class[] = 'without-isotope';
			}

			if ( ! $this->get_flag( 'show_orderby_filter' ) && ! $this->get_flag( 'show_order_filter' ) ) {
				$filter_class[] = 'extras-off';
			}

			$config = presscore_config();

			switch ( $config->get( 'template.posts_filter.style' ) ) {
				case 'minimal':
					$filter_class[] = 'filter-bg-decoration';
					break;
				case 'material':
					$filter_class[] = 'filter-underline-decoration';
					break;
			}

			$terms = array();
			if ( $this->get_flag( 'show_categories_filter' ) ) {
				$terms = $this->get_posts_filter_terms( $query );
			}

			DT_Blog_Shortcode_HTML::display_posts_filter( $terms, $filter_class );

			/**
			 * Blog posts have a custom lazy loading classes.
			 */
			presscore_remove_lazy_load_attrs();

			presscore_remove_posts_masonry_wrap();

			// Start loop.
			if ( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();

				do_action('presscore_before_post');

				remove_filter( 'presscore_post_details_link', 'presscore_return_empty_string', 15 );

				// Article layout (odd, even).
				$article_layout = presscore_get_template_image_layout( $config->get( 'layout' ), ( $query->current_post + 1 ) );

				// Post visibility on the first page.
				$visibility = 'visible';
				if ( $data_post_limit >= 0 && $query->current_post >= $data_post_limit ) {
					$visibility = 'hidden';
				}

				$post_class_array = array(
					'post',
					"project-{$article_layout}",
					$visibility
				);

				if ( ! has_post_thumbnail() ) {
					$post_class_array[] = 'no-img';
				}

				echo '<article ' . $this->post_class( $post_class_array ) . ' data-name="' . esc_attr( get_the_title() ) . '" data-date="' . esc_attr( get_the_date( 'c' ) ) . '">';

				// Print custom css for VC scripts.
				if ( 'show_content' === $this->get_att( 'post_content' ) && function_exists( 'visual_composer' ) ) {
					visual_composer()->addShortcodesCustomCss();
				}

				// populate config with current post settings
				presscore_populate_post_config();

				$post_media = '';
				if ( has_post_thumbnail() ) {
					$layout_image_width_map = array(
						'classic' => $this->get_att( 'cl_image_width' ),
						'centered' => '100%',
						'bottom_overlap' => '100%',
						'side_overlap' => $this->get_att( 'si_image_width' ),
					);
					$layout = $this->get_att( 'layout' );
					$image_width = ( array_key_exists( $layout, $layout_image_width_map ) ? $layout_image_width_map[ $layout ] : '100%' );
					$image_paddings = $this->sanitize_paddings( $this->get_att( 'image_paddings' ) );
					$image_is_wide = ( 'wide' === $config->get( 'post.preview.width' ) && ! $config->get( 'all_the_same_width' ) );

					$resize_options = the7_calculate_image_resize_options_for_list_layout(
						$image_width,
						$this->get_att( 'mobile_switch_width' ),
						$image_paddings[1],
						$image_paddings[3],
						$image_is_wide
					);

					// Post media.
					$thumb_args = apply_filters( 'dt_post_thumbnail_args', array(
						'img_id' => get_post_thumbnail_id(),
						'class'  => 'post-thumbnail-rollover',
						'href'   => get_permalink(),
						'wrap'   => '<a %HREF% %CLASS% %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %IMG_TITLE% %SIZE% />' . $show_icon_zoom . '</a>',
						'options' => $resize_options,
						'echo'   => false,
					) );

					// Custom lazy loading classes.
					if ( presscore_lazy_loading_enabled() ) {
						$thumb_args['lazy_loading'] = true;
						$thumb_args['img_class'] = ( 'standard' === $loading_mode ? 'lazy-load' : 'blog-thumb-lazy-load' );
						$thumb_args['class'] .= ' layzr-bg';
					}

					$post_media = dt_get_thumb_img( $thumb_args );
				}

				$details_btn_style = $this->get_att( 'read_more_button' );
				$details_btn_text = $this->get_att( 'read_more_button_text', esc_html_x( 'Read more', 'the7 shortcode', 'the7mk2' ) );
				$details_btn_class = ('default_button' === $details_btn_style ? array( 'dt-btn-s', 'dt-btn' ) : array());

				presscore_get_template_part( 'shortcodes', 'blog-list/tpl-layout', $this->get_att( 'layout' ), array(
					'post_media' => $post_media,
					'details_btn' => DT_Blog_Shortcode_HTML::get_details_btn( $details_btn_style, $details_btn_text, $details_btn_class ),
					'post_excerpt' => $this->get_post_excerpt(),
					'fancy_category_args' => array(
						'custom_text_color' => ( ! $this->get_att( 'fancy_categories_font_color' ) ),
						'custom_bg_color' => ( ! $this->get_att( 'fancy_categories_bg_color' ) ),
					),
				) );

				echo '</article>';

				do_action('presscore_after_post');

			endwhile; endif;

			presscore_add_lazy_load_attrs();

			if ( 'disabled' == $loading_mode ) {
				// Do not output pagination.
			} else if ( in_array( $loading_mode, array( 'js_more', 'js_lazy_loading' ) ) ) {
				// JS load more.
				echo dt_get_next_page_button( 2, 'paginator paginator-more-button' );
			} else if ( 'js_pagination' == $loading_mode ) {
				// JS pagination.
				echo '<div class="paginator" role="navigation"></div>';
			} else {
				// Pagination.
				dt_paginator( $query, array( 'class' => 'paginator' ) );
			}

			echo '</div>';
		}

		/**
		 * Return post excerpt with $length words.
		 *
		 * @return mixed
		 */
		protected function get_post_excerpt() {
			global $post;

			if ( 'off' === $this->atts['post_content'] ) {
				return '';
			}

			$post_back = $post;

			if ( 'show_content' === $this->atts['post_content'] ) {
				$excerpt = apply_filters( 'the_content', get_the_content( '' ) );
			} else {
				$length = absint( $this->atts['excerpt_words_limit'] );
				$excerpt = apply_filters( 'the7_shortcodeaware_excerpt', get_the_excerpt() );

				if ( $length ) {
					$excerpt = wp_trim_words( $excerpt, $length );
				}

				$excerpt = apply_filters( 'the_excerpt', $excerpt );
			}

			// Restore original post in case some shortcode in the content will change it globally.
			$post = $post_back;

			return $excerpt;
		}

		/**
		 * Return container class attribute.
		 *
		 * @param array $class
		 *
		 * @return string
		 */
		protected function container_class( $class = array() ) {
			if ( ! is_array( $class ) ) {
				$class = explode( ' ', $class );
			}

			// Unique class.
			$class[] = $this->get_unique_class();

			$layout_classes = array(
				'classic' => 'classic-layout-list',
				'centered' => 'centered-layout-list',
				'bottom_overlap' => 'bottom-overlap-layout-list',
				'side_overlap' => 'side-overlap-layout-list',
			);

			$layout = $this->get_att( 'layout' );
			if ( array_key_exists( $layout, $layout_classes ) ) {
				$class[] = $layout_classes[ $layout ];
			}

			if ( 'classic' === $this->get_att( 'layout' ) && $this->get_flag( 'cl_dividers' ) ) {
				$class[] = 'dividers-on';
			}

			if ( 'centered' === $this->get_att( 'layout' ) && $this->get_flag( 'ce_dividers' ) ) {
				$class[] = 'dividers-on';
			}

			if ( $this->get_flag( 'content_bg' ) ) {
				$class[] = 'content-bg-on';
			}
			if ( 'disabled' != $this->get_att( 'image_hover_bg_color' ) ) {
				$class[] = 'enable-bg-rollover';
			}

			$loading_mode = $this->get_att( 'loading_mode' );
			if ( 'standard' !== $loading_mode ) {
				$class[] = 'jquery-filter';
			}

			if ( 'js_lazy_loading' === $loading_mode ) {
				$class[] = 'lazy-loading-mode';
			}
			switch ( $this->get_att('filter_position') ) {
				case 'left':
					$class[] = 'filter-align-left';
					break;
				case 'right':
					$class[] = 'filter-align-right';
					break;
			}

			if ( $this->get_flag( 'jsp_show_all_pages' ) ) {
				$class[] = 'show-all-pages';
			}

			if ( $this->atts['image_scale_animation_on_hover']  === 'quick_scale' ) {
				$class[] = 'quick-scale-img';
			}else if($this->atts['image_scale_animation_on_hover']  === 'slow_scale') {
				$class[] = 'scale-img';
			}
			if ( $this->get_flag( 'project_icon_bg' ) ) {
				$class[] = 'dt-icon-bg-on';
			} else {
				$class[] = 'dt-icon-bg-off';
			}

			if ( $this->get_flag( 'fancy_date' ) ) {
				$class[] = presscore_blog_fancy_date_class();
			}

			return presscore_list_container_html_class( $class );
		}

		/**
		 * Return post classes.
		 *
		 * @param string|array $class
		 *
		 * @return string
		 */
		protected function post_class( $class = array() ) {
			if ( ! is_array( $class ) ) {
				$class = explode( ' ', $class );
			}

			if ( 'classic' === $this->atts['layout'] && strpos( $this->atts['cl_image_width'], '%' ) !== false && absint( $this->atts['cl_image_width'] ) >= 100 ) {
                $class[] = ' full-width-img';
            }
			return 'class="' . join( ' ', get_post_class( $class, null ) ) . '"';
		}

		/**
		 * Return shortcode less file absolute path to output inline.
		 *
		 * @return string
		 */
		protected function get_less_file_name() {
			return PRESSCORE_THEME_DIR . '/css/dynamic-less/shortcodes/blog.less';
		}

		protected function get_less_imports() {
			$dynamic_import_top = array();

			switch ( $this->atts['layout'] ) {
				case 'centered':
					$dynamic_import_top[] = 'blog/centered-layout-blog.less';
					break;
				case 'bottom_overlap':
					$dynamic_import_top[] = 'blog/bottom-overlap-layout-blog.less';
					break;
				case 'side_overlap':
					$dynamic_import_top[] = 'blog/side-overlap-layout-blog.less';
					break;
				case 'classic':
				default:
					$dynamic_import_top[] = 'blog/classic-layout-blog.less';
			}

			return compact( 'dynamic_import_top' );
		}

		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();

			$config->set( 'load_style', 'default' );
			$config->set( 'template', 'blog' );

			$layout = 'list';
			if ( 'side_overlap' === $this->get_att( 'layout' ) ) {
				$layout = $this->get_att( 'si_content_align' );
			}
			$config->set( 'layout', $layout );
			$config->set( 'all_the_same_width', true );

			$config->set( 'show_excerpts', ( 'off' !== $this->get_att( 'post_content' ) ) );
			$config->set( 'show_details', ( 'off' !== $this->get_att( 'read_more_button' ) ) );

			$config->set( 'image_layout', ( 'resize' === $this->get_att( 'image_sizing' ) ? $this->get_att( 'image_sizing' ) : 'original' ) );

			if ( 'resize' == $this->get_att( 'image_sizing' ) && $this->get_att( 'resized_image_dimensions' ) ) {
				// Sanitize.
				$img_dim = array_slice( array_map( 'absint', explode( 'x', strtolower( $this->get_att( 'resized_image_dimensions' ) ) ) ), 0, 2 );
				// Make sure that all values is set.
				for ( $i = 0; $i < 2; $i++ ) {
					if ( empty( $img_dim[ $i ] ) ) {
						$img_dim[ $i ] = '';
					}
				}
				$config->set( 'thumb_proportions', array( 'width' => $img_dim[0], 'height' => $img_dim[1] ) );
			} else {
				$config->set( 'thumb_proportions', '' );
			}

			$config->set( 'post.meta.fields.date', apply_filters( 'dt_sanitize_flag', $this->get_att( 'post_date' ) ) );
			$config->set( 'post.meta.fields.categories', apply_filters( 'dt_sanitize_flag', $this->get_att( 'post_category' ) ) );
			$config->set( 'post.meta.fields.comments', apply_filters( 'dt_sanitize_flag', $this->get_att( 'post_comments' ) ) );
			$config->set( 'post.meta.fields.author', apply_filters( 'dt_sanitize_flag', $this->get_att( 'post_author' ) ) );

			$config->set( 'post.fancy_date.enabled', apply_filters( 'dt_sanitize_flag', $this->get_att( 'fancy_date' ) ) );
			$config->set( 'post.fancy_category.enabled', apply_filters( 'dt_sanitize_flag', $this->get_att( 'fancy_categories' ) ) );
			$config->set( 'post.preview.background.enabled', false );
			$config->set( 'post.preview.background.style',  '' );
			$config->set( 'post.preview.media.width', 30 );
			$config->set( 'post.preview.load.effect', 'fade_in' );

			$config->set( 'template.posts_filter.terms.enabled', apply_filters( 'dt_sanitize_flag', $this->get_att( 'show_categories_filter' ) ) );
			$config->set( 'template.posts_filter.orderby.enabled', apply_filters( 'dt_sanitize_flag', $this->get_att( 'show_orderby_filter' ) ) );
			$config->set( 'template.posts_filter.order.enabled', apply_filters( 'dt_sanitize_flag',  $this->get_att( 'show_order_filter' ) ) );

			if ( 'standard' === $this->get_att( 'loading_mode' ) ) {
				$config->set( 'show_all_pages', $this->get_flag( 'st_show_all_pages' ) );

				// Allow sorting from request.
				if ( ! $config->get('order') ) {
					$config->set( 'order', $this->get_att( 'order' ) );
				}

				if ( ! $config->get('orderby') ) {
					$config->set( 'orderby', $this->get_att( 'orderby' ) );
				}
			} else {
				$config->set( 'show_all_pages', $this->get_flag( 'jsp_show_all_pages' ) );

				$config->set( 'request_display', false );
				$config->set( 'order', $this->get_att( 'order' ) );
				$config->set( 'orderby', $this->get_att( 'orderby' ) );
			}

			// Get terms ids.
			$terms = get_terms( array(
				'taxonomy' => 'category',
				'slug' => presscore_sanitize_explode_string( $this->get_att( 'category' ) ),
			    'fields' => 'ids',
			) );

			$config->set( 'display', array(
				'type' => 'category',
				'terms_ids' => $terms,
				'select' => ( $terms ? 'only' : 'all' ),
			) );
		}

		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'blog-shortcode.' . $this->get_unique_class(), '~"%s"' );

			switch ( $this->get_att( 'layout' ) ) {
				case 'classic':
					$less_vars->add_keyword( 'post-divider-color', $this->get_att( 'cl_dividers_color', '~""' ) );
					$less_vars->add_pixel_or_percent_number( 'post-thumbnail-width', $this->get_att( 'cl_image_width' ) );
					break;
				case 'centered':
					$less_vars->add_keyword( 'post-divider-color', $this->get_att( 'cl_dividers_color', '~""' ) );
					$less_vars->add_pixel_or_percent_number( 'post-content-width', $this->get_att( 'ce_content_width' ) );
					break;
				case 'bottom_overlap':
					$less_vars->add_pixel_or_percent_number( 'post-content-width', $this->get_att( 'bo_content_width' ) );
					$less_vars->add_pixel_number( 'post-content-top-overlap', $this->get_att( 'bo_content_top_overlap' ) );
					break;
				case 'side_overlap':
					$less_vars->add_pixel_or_percent_number( 'post-thumbnail-width', $this->get_att( 'si_image_width' ) );
					$less_vars->add_pixel_number( 'post-content-side-overlap', $this->get_att( 'si_content_side_overlap' ) );
					$less_vars->add_pixel_number( 'post-content-top-overlap', $this->get_att( 'si_content_top_margin' ) );
			}

			$less_vars->add_pixel_number( 'switch-blog-list-to-mobile', $this->get_att( 'mobile_switch_width' ) );
			$less_vars->add_keyword( 'post-title-color', $this->get_att( 'custom_title_color', '~""' ) );
			$less_vars->add_keyword( 'post-meta-color', $this->get_att( 'custom_meta_color', '~""' ) );
			$less_vars->add_keyword( 'post-content-color', $this->get_att( 'custom_content_color', '~""' ) );
			$less_vars->add_keyword( 'post-content-bg', $this->get_att( 'custom_content_bg_color', '~""' ) );

			$less_vars->add_paddings( array(
				'post-thumb-padding-top',
				'post-thumb-padding-right',
				'post-thumb-padding-bottom',
				'post-thumb-padding-left',
			), $this->get_att( 'image_paddings' ), '%|px' );

			$less_vars->add_keyword( 'fancy-data-color', $this->get_att( 'fancy_date_font_color' ) );
			$less_vars->add_keyword( 'fancy-data-bg', $this->get_att( 'fancy_date_bg_color' ) );
			$less_vars->add_keyword( 'fancy-data-line-color', $this->get_att( 'fancy_date_line_color', '~""' ) );
			$less_vars->add_keyword( 'fancy-category-color', $this->get_att( 'fancy_categories_font_color', '~""' ) );
			$less_vars->add_keyword( 'fancy-category-bg', $this->get_att( 'fancy_categories_bg_color', '~""' ) );

			switch ( $this->get_att( 'image_hover_bg_color' ) ) {
				case 'gradient_rollover_bg':
					$first_color = 'rgba(0,0,0,0.6)';
					$gradient    = '';
					if ( function_exists( 'the7_less_prepare_gradient_var' ) ) {
						list( $first_color, $gradient ) = the7_less_prepare_gradient_var( $this->get_att( 'custom_rollover_bg_gradient' ) );
					}
					$less_vars->add_rgba_color( 'portfolio-rollover-bg', $first_color );
					$less_vars->add_keyword( 'portfolio-rollover-bg-gradient', $gradient );
					break;
				case 'solid_rollover_bg':
					$less_vars->add_keyword( 'portfolio-rollover-bg', $this->get_att( 'custom_rollover_bg_color', '~""' ) );
					break;
			}

			$less_vars->add_paddings( array(
				'post-content-padding-top',
				'post-content-padding-right',
				'post-content-padding-bottom',
				'post-content-padding-left',
			), $this->get_att( 'post_content_paddings' ) );

			$less_vars->add_pixel_number( 'post-title-font-size', $this->get_att( 'post_title_font_size' ) );
			$less_vars->add_pixel_number( 'post-title-line-height', $this->get_att( 'post_title_line_height' ) );
			$less_vars->add_pixel_number( 'post-meta-font-size', $this->get_att( 'meta_info_font_size' ) );
			$less_vars->add_pixel_number( 'post-meta-line-height', $this->get_att( 'meta_info_line_height' ) );

			$less_vars->add_pixel_number( 'post-excerpt-font-size', $this->get_att( 'content_font_size' ) );
			$less_vars->add_pixel_number( 'post-excerpt-line-height', $this->get_att( 'content_line_height' ) );
			$less_vars->add_pixel_number( 'post-meta-margin-bottom', $this->get_att( 'meta_info_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-title-margin-bottom', $this->get_att( 'post_title_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-excerpt-margin-bottom', $this->get_att( 'content_bottom_margin' ) );
			$less_vars->add_pixel_number( 'gap-between-posts', $this->get_att( 'gap_between_posts' ) );
			$less_vars->add_font_style( array(
				'post-title-font-style',
				'post-title-font-weight',
				'post-title-text-transform',
			), $this->get_att( 'post_title_font_style' ) );
			$less_vars->add_font_style( array(
				'post-meta-font-style',
				'post-meta-font-weight',
				'post-meta-text-transform',
			), $this->get_att( 'meta_info_font_style' ) );
			$less_vars->add_font_style( array(
				'post-content-font-style',
				'post-content-font-weight',
				'post-content-text-transform',
			), $this->get_att( 'content_font_style' ) );

			$less_vars->add_pixel_number( 'project-icon-size', $this->get_att( 'project_icon_size' ) );
			$less_vars->add_pixel_number( 'project-icon-bg-size', $this->get_att( 'project_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'project-icon-border-width', $this->get_att( 'project_icon_border_width' ) );
			$less_vars->add_pixel_number( 'project-icon-border-radius', $this->get_att( 'project_icon_border_radius' ) );
			$less_vars->add_keyword( 'project-icon-color', $this->get_att( 'project_icon_color', '~""' ) );
			$less_vars->add_keyword( 'project-icon-border-color', $this->get_att( 'project_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'project-icon-bg-color', $this->get_att( 'project_icon_bg_color', '~""' ) );

			$less_vars->add_pixel_number( 'shortcode-filter-gap', $this->get_att( 'gap_below_category_filter', '' ) );
			$less_vars->add_keyword( 'shortcode-filter-color', $this->get_att( 'navigation_font_color', '~""' ) );
			$less_vars->add_keyword( 'shortcode-filter-accent', $this->get_att( 'navigation_accent_color', '~""' ) );

			$gap_before_pagination = '';
			switch ( $this->get_att( 'loading_mode' ) ) {
				case 'standard':
					$gap_before_pagination = $this->get_att( 'st_gap_before_pagination', '' );
					break;
				case 'js_pagination':
					$gap_before_pagination = $this->get_att( 'jsp_gap_before_pagination', '' );
					break;
				case 'js_more':
					$gap_before_pagination = $this->get_att( 'jsm_gap_before_pagination', '' );
					break;
			}
			$less_vars->add_pixel_number( 'shortcode-pagination-gap', $gap_before_pagination );

			return $less_vars->get_vars();
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return false;
		}

		protected function get_posts_filter_terms( $query ) {
			$post_type = $this->get_att( 'post_type' );
			$data = $this->get_att( $post_type );

			// If empty - return all categories.
			if ( empty( $data ) ) {
				return get_terms( array(
					'taxonomy'   => 'category',
					'hide_empty' => true,
				) );
			}

			// If posts selected - return corresponded categories.
			if ( 'posts' === $post_type ) {
				$post_ids = presscore_sanitize_explode_string( $data );

				return wp_get_object_terms( $post_ids, 'category', array( 'fields' => 'all_with_object_id' ) );
			}

			// If categories selected.
			if ( 'category' === $post_type ) {
				$get_terms_args = array(
					'taxonomy'   => 'category',
					'hide_empty' => true,
				);

				$categories = presscore_sanitize_explode_string( $data );
				if ( ! is_numeric( $categories[0] ) ) {
					$get_terms_args['slug'] = $categories;
				} else {
					$get_terms_args['include'] = $categories;
				}

				return get_terms( $get_terms_args );
			}

			// If tags selected.
			if ( 'tags' === $post_type ) {
				$post_tags = get_terms( array(
					'taxonomy'   => 'post_tag',
					'hide_empty' => true,
					'include'    => presscore_sanitize_explode_string( $data ),
					'fields'     => 'ids',
				) );

				$posts_query = new WP_Query( array(
					'post_type'        => 'post',
					'post_status'      => 'publish',
					'fields'           => 'ids',
					'nopaging'         => true,
					'suppress_filters' => false,
					'tax_query'        => array(
						array(
							'taxonomy' => 'post_tag',
							'field'    => 'id',
							'terms'    => $post_tags,
						),
					),
				) );

				return wp_get_object_terms( $posts_query->posts, 'category', array( 'fields' => 'all_with_object_id' ) );
			}
		}

		/**
		 * @return array|WP_Query
		 */
		protected function get_loop_query() {
			$query = apply_filters( 'the7_shortcode_query', null, $this->sc_name, $this->atts );
			if ( is_a( $query, 'WP_Query' ) ) {
				return $query;
			}

			add_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
			add_filter( 'found_posts', array( $this, 'fix_pagination' ), 1, 2 );

			$post_type = $this->get_att( 'post_type' );
			if ( 'posts' === $post_type ) {
				$query = $this->get_posts_by_post_type( 'post', $this->get_att( 'posts' ) );
			} elseif ( 'tags' === $post_type ) {
				$query = $this->get_posts_by_taxonomy( 'post', 'post_tag', $this->get_att( 'tags' ) );
			} else {
				$category_terms = presscore_sanitize_explode_string( $this->get_att( 'category' ) );
				$category_field = ( is_numeric( $category_terms[0] ) ? 'term_id' : 'slug' );

				$query = $this->get_posts_by_taxonomy( 'post', 'category', $category_terms, $category_field );
			}

			remove_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
			remove_filter( 'found_posts', array( $this, 'fix_pagination' ), 1 );

			return $query;
		}

		/**
		 * Add offset to the posts query.
		 *
		 * @since 7.1.0
		 *
		 * @param WP_Query $query
		 */
		public function add_offset( &$query ) {
			$offset  = (int) $this->get_att( 'posts_offset' );
			$ppp     = (int) $query->query_vars['posts_per_page'];
			$current = (int) $query->query_vars['paged'];

			if ( $query->is_paged ) {
				$page_offset = $offset + ( $ppp * ( $current - 1 ) );
				$query->set( 'offset', $page_offset );
			} else {
				$query->set( 'offset', $offset );
			}
		}

		/**
		 * Fix pagination accordingly with posts offset.
		 *
		 * @since 7.1.0
		 *
		 * @param int $found_posts
		 *
		 * @return int
		 */
		public function fix_pagination( $found_posts ) {
			return $found_posts - (int) $this->get_att( 'posts_offset' );
		}

		protected function get_posts_by_post_type( $post_type, $post_ids = array() ) {
			$pagination_mode = $this->get_att( 'loading_mode' );
			$posts_per_page = $this->get_posts_per_page( $pagination_mode );

			if ( is_string( $post_ids ) ) {
				$post_ids = presscore_sanitize_explode_string( $post_ids );
			}
			$post_ids = array_filter( $post_ids );

			if ( 'standard' === $pagination_mode ) {
				$config = presscore_config();
				$query_args = array(
					'orderby'          => $config->get( 'orderby' ),
					'order'            => $config->get( 'order' ),
					'posts_per_page'   => $posts_per_page,
					'post_type'        => $post_type,
					'post_status'      => 'publish',
					'paged'            => the7_get_paged_var(),
					'suppress_filters' => false,
					'post__in'         => $post_ids,
				);

				$request = $config->get( 'request_display' );
				if ( ! empty( $request['terms_ids'] ) ) {
					$query_args['tax_query'] = array(
						array(
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => $request['terms_ids'],
						),
					);
				}
			} else {
				$query_args = array(
					'orderby'          => $this->get_att( 'orderby' ),
					'order'            => $this->get_att( 'order' ),
					'posts_per_page'   => $posts_per_page,
					'post_type'        => $post_type,
					'post_status'      => 'publish',
					'paged'            => 1,
					'suppress_filters' => false,
					'post__in'         => $post_ids,
				);
			}

			return new WP_Query( $query_args );
		}

		protected function get_posts_per_page( $pagination_mode ) {
			$max_posts_per_page = 99999;
			switch ( $pagination_mode ) {
				case 'disabled':
					$posts_per_page = $this->get_att( 'dis_posts_total' );
					break;
				case 'standard':
					$posts_per_page = $this->get_att( 'st_posts_per_page' );
					$posts_per_page = $posts_per_page ? $posts_per_page : get_option( 'posts_per_page' );
					break;
				case 'js_pagination':
					$posts_per_page = $this->get_att( 'jsp_posts_total' );
					break;
				case 'js_more':
					$posts_per_page = $this->get_att( 'jsm_posts_total' );
					break;
				case 'js_lazy_loading':
					$posts_per_page = $this->get_att( 'jsl_posts_total' );
					break;
				default:
					return $max_posts_per_page;
			}

			$posts_per_page = (int) $posts_per_page;
			if ( $posts_per_page === -1 ) {
				return $max_posts_per_page;
			}

			return $posts_per_page;
		}

		protected function get_posts_by_taxonomy( $post_type, $taxonomy, $taxonomy_terms = array(), $taxonomy_field = 'term_id' ) {
			$pagination_mode = $this->get_att( 'loading_mode' );
			$posts_per_page = $this->get_posts_per_page( $pagination_mode );

			if ( is_string( $taxonomy_terms ) ) {
				$taxonomy_terms = presscore_sanitize_explode_string( $taxonomy_terms );
			}
			$taxonomy_terms = array_filter( $taxonomy_terms );

			$query_args = array(
				'posts_per_page'   => $posts_per_page,
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'suppress_filters' => false,
			);

			$tax_query = array();
			if ( $taxonomy_terms ) {
				$tax_query = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => $taxonomy_field,
						'terms'    => $taxonomy_terms,
					),
				);
			}

			if ( 'standard' === $pagination_mode ) {
				$config = presscore_config();
				$request = $config->get( 'request_display' );
				if ( ! empty( $request['terms_ids'] ) ) {
					$tax_query[] = array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $request['terms_ids'],
					);
					$tax_query['relation'] = 'AND';
				}

				$query_args['orderby'] = $config->get( 'orderby' );
				$query_args['order'] = $config->get( 'order' );
				$query_args['paged'] = the7_get_paged_var();
			} else {
				// JS pagination.
				$query_args['orderby'] = $this->get_att( 'orderby' );
				$query_args['order'] = $this->get_att( 'order' );
				$query_args['paged'] = 1;
			}

			if ( $tax_query ) {
				$query_args['tax_query'] = $tax_query;
			}

			return new WP_Query( $query_args );
		}

		protected function sanitize_paddings( $padding ) {
			if ( ! is_array( $padding ) ) {
				$padding = explode( ' ', $padding );
			}

			for ( $i = 0; $i < 4;  $i++ ) {
				$padding[ $i ] = ( isset( $padding[ $i ] ) ? $padding[ $i ] : '0' );
			}

			return array_slice( $padding, 0, 4 );
		}
	}

	DT_Shortcode_BlogList::get_instance()->add_shortcode();

endif;
