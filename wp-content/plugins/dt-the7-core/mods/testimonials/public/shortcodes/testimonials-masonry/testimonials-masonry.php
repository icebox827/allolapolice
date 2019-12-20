<?php
/**
 * Testimonials Masonry shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Testimonials_Masonry', false ) ) :

	class DT_Shortcode_Testimonials_Masonry extends The7pt_Shortcode_With_Inline_CSS {
		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Testimonials_Shortcode_Masonry
		 */
		public static $instance = null;

		/**
		 * @return DT_Testimonials_Shortcode_Masonry
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name = 'dt_testimonials_masonry';
			$this->unique_class_base = 'testimonials-masonry-shortcode-id';
			$this->taxonomy = 'dt_testimonials_category';
			$this->post_type = 'dt_testimonials';
			$this->default_atts = array(
				'post_type' => 'category',
				'posts' => '',
				'category' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'type' => 'grid',
				'loading_effect' => 'none',
				'content_layout' => 'layout_4',
				'img_border_radius' => '0px',
				'content_bg' => 'y',
				'custom_content_bg_color' => '',
				'post_content_paddings' => '30px 30px 20px 30px',
				'show_avatar' => 'y',
				'image_sizing' => 'resize',
				'resized_image_dimensions' => '1x1',
				'img_max_width' => '80px',
				'image_paddings' => '0px 20px 20px 0px',
				'image_scale_animation_on_hover' => 'y',
				'image_hover_bg_color' => 'y',
				'gap_between_posts'              => '15px',
				'responsiveness'                 => 'browser_width_based',
				'bwb_columns'                    => 'desktop:3|h_tablet:3|v_tablet:2|phone:1',
				'pwb_column_min_width'           => '',
				'pwb_columns'                    => '',
				'content_alignment' => 'left',
				'testimonial_name' => 'y',
				'post_title_font_style' => ':bold:',
				'post_title_font_size' => '',
				'post_title_font_size_tablet' => '',
				'post_title_font_size_phone' => '',
				'post_title_line_height' => '',
				'post_title_line_height_tablet' => '',
				'post_title_line_height_phone' => '',
				'custom_title_color' => '',
				'post_title_bottom_margin' => '0',
				'testimonial_position' => 'y',
				'testimonial_position_font_style' => 'normal:bold:none',
				'testimonial_position_font_size' => '',
				'testimonial_position_font_size_tablet' => '',
				'testimonial_position_font_size_phone' => '',
				'testimonial_position_line_height' => '',
				'testimonial_position_line_height_tablet' => '',
				'testimonial_position_line_height_phone' => '',
				'testimonial_position_color' => '',
				'testimonial_position_bottom_margin' => '20px',
				'post_content' => 'show_excerpt',
				'excerpt_words_limit' => '',
				'content_font_style' => '',
				'content_font_size' => '',
				'content_font_size_tablet' => '',
				'content_font_size_phone' => '',
				'content_line_height' => '',
				'content_line_height_tablet' => '',
				'content_line_height_phone' => '',
				'custom_content_color' => '',
				'content_bottom_margin' => '0',
				'css_dt_testimonials_masonry' => '',
				'el_class' => '',
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
				'navigation_font_color'          => '',
				'navigation_accent_color'        => '',
				'show_categories_filter'         => 'n',
			);
			parent::__construct();
		}

		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			// Loop query.
			$post_type = $this->get_att( 'post_type' );
			$config = presscore_config();
			if ( 'posts' === $post_type ) {
				$query = $this->get_posts_by_post_type( 'dt_testimonials', $this->get_att( 'posts' ) );
			}else {
				$category_terms = presscore_sanitize_explode_string( $this->get_att( 'category' ) );
				$category_field = ( is_numeric( $category_terms[0] ) ? 'term_id' : 'slug' );

				$query = $this->get_posts_by_taxonomy( 'dt_testimonials', 'dt_testimonials_category', $category_terms, $category_field );
			}

			$query_new = apply_filters( 'the7_shortcode_query', null, $this->sc_name, $this->atts );
			if ( is_a( $query_new, 'WP_Query' ) ) {
				$query = $query_new;
			}

			do_action( 'presscore_before_shortcode_loop', $this->sc_name, $this->atts );

			// Remove default masonry posts wrap.
			presscore_remove_posts_masonry_wrap();

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

			$data_atts = array(
				'data-post-limit="' . intval( $data_post_limit ) . '"',
				'data-pagination-mode="' . esc_attr( $data_pagination_mode ) . '"',
			);
			$data_atts = $this->add_responsiveness_data_atts( $data_atts );

				echo '<div ' . $this->get_container_html_class( 'dt-testimonials-masonry-shortcode dt-testimonials-shortcode' ) .  presscore_masonry_container_data_atts( $data_atts ) .  '>';

			// Posts filter.
			$filter_class = array( 'iso-filter' );
			if ( 'standard' === $loading_mode ) {
				$filter_class[] = 'without-isotope';
			}

			$filter_class[] = 'extras-off';

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

			DT_Portfolio_Shortcode_HTML::display_posts_filter( $terms, $filter_class );

					echo '<div ' . $this->iso_container_class() . '>';

					if ( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
					do_action('presscore_before_post');

						// Post visibility on the first page.
						$visibility = 'visible';
						if ( $data_post_limit >= 0 && $query->current_post >= $data_post_limit ) {
							$visibility = 'hidden';
						}
						echo '<div ' . presscore_tpl_masonry_item_wrap_class( $visibility ) . presscore_tpl_masonry_item_wrap_data_attr() . '>';

						$post_id = get_the_ID();

						echo '<div class="testimonial-item post visible">';
						if ( $this->get_att( 'content_layout' ) == 'layout_3' || $this->get_att( 'content_layout' ) == 'layout_4' ) {
							echo '<div class="testimonial-author">';
						}

							if( $this->get_att( 'show_avatar' ) == 'y') {
								$proportion = 0;
								$value = explode( ' ', $this->get_att( 'image_paddings' ) );
								$padding_right = isset($value[1]) ? $value[1] : 0;
								$padding_left = isset($value[3]) ? $value[3] : 0;
								if ( 'resize' === $this->get_att( 'image_sizing' ) ) {
									$proportion = $this->get_proportion( $this->get_att( 'resized_image_dimensions' ) );
								}
								echo '<div class="testimonial-avatar">';

								$img_width = absint( $this->get_att( 'img_max_width', '' ) );

								if ( has_post_thumbnail( $post_id ) ) {
									$thumb_id = get_post_thumbnail_id( $post_id );
									$avatar_args = array(
										'img_meta'      => wp_get_attachment_image_src( $thumb_id, 'full' ),
										'prop'          => $proportion,
										'echo'			=> false,
										'wrap'			=> '<img %IMG_CLASS% %SRC% %SIZE% %IMG_TITLE% %ALT% />',
									);
									if ( $img_width ) {
										$avatar_args['options'] = array( 'w' => $img_width, 'z' => 0 );
									}

									$avatar_wrap_class = 'testimonial-thumb';
									if ( presscore_lazy_loading_enabled() ) {
										$avatar_wrap_class .= ' layzr-bg';
									}

									$avatar = '<span class="' . $avatar_wrap_class . '">' . dt_get_thumb_img( $avatar_args ) . '</span>';
								} else {
									$no_avatar_width = $no_avatar_height = $img_width ? $img_width : 60;

									if ( 'resize' === $this->get_att( 'image_sizing' ) ) {
										$no_avatar_height = round( $no_avatar_width / $proportion, 2 );
									}

									$avatar = the7_core_testimonials_get_no_avatar( $no_avatar_width, $no_avatar_height );
									$avatar = '<span class="testim-no-avatar">' . $avatar . '</span>';
								}

								echo $avatar;
								echo '</div>';
							}

							if ( $this->get_att( 'content_layout' ) == 'layout_1' || $this->get_att( 'content_layout' ) == 'layout_5' || $this->get_att( 'content_layout' ) == 'layout_6' ) {
								echo '<div class="content-wrap">';
							}

							echo '<div class="testimonial-vcard">';
								if($this->get_att( 'testimonial_name' ) == 'y'){

									echo '<div class="testimonial-name">';
										// get link

										// TODO: Remove links in future. To enable just uncomment.
										$link = false;
										if ( $link ) {
											$link = esc_url( $link );
										} else {
											$link = '';
										}

										// get title
										$title = get_the_title();
										if ( $title ) {

											if ( $link ) {
												$title = '<a href="' . $link . '" class="text-primary" target="_blank"><span>' . $title . '</span></a>';
											} else {
												$title = '<span class="text-primary">' . $title . '</span>';
											}

											$title .= '<br />';
										} else {
											$title = '';
										}
										echo $title;
									echo '</div>';
								}

								echo '<div class="testimonial-position">';
									// Output author name
									// get position
									$position = get_post_meta( $post_id, '_dt_testimonial_options_position', true );
									if ( $position ) {
										$position = '<span class="text-secondary color-secondary">' . $position . '</span>';
									} else {
										$position = '';
									}

									echo $position;
								echo '</div>';

							echo '</div>';
						if ( $this->get_att( 'content_layout' ) == 'layout_3' || $this->get_att( 'content_layout' ) == 'layout_4' ) {
							echo '</div>';
						}

						// Output description
						echo '<div class="testimonial-content">' . $this->get_post_excerpt() . '</div>';

						if ( $this->get_att( 'content_layout' ) == 'layout_1' || $this->get_att( 'content_layout' ) == 'layout_5' || $this->get_att( 'content_layout' ) == 'layout_6' ) {
							echo '</div>';
						}

					echo '</div>';

					echo '</div>';

					do_action('presscore_after_post');

					endwhile; endif;

				echo '</div><!-- iso-container|iso-grid -->';


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

			do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
		}

		protected function get_container_html_class( $class = array() ) {
			if ( ! is_array( $class ) ) {
				$class = explode( ' ', $class );
			}
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();
			$class[] = presscore_tpl_get_load_effect_class($this->get_att( 'loading_effect' ));

			if ( 'left' === $this->get_att( 'content_alignment' ) ) {
				$class[] = 'content-align-left';
			}else{
				$class[] = 'content-align-center';
			};

			$mode_classes = array(
				'masonry' => 'mode-masonry',
				'grid'    => 'mode-grid',
			);

			$mode = $this->get_att( 'type' );
			if ( array_key_exists( $mode, $mode_classes ) ) {
				$class[] = $mode_classes[ $mode ];
			}

			if ( $this->get_flag( 'content_bg' ) ) {
				$class[] = 'content-bg-on';
			}else{
				$class[] = 'content-bg-off';
			}
			$layout_classes = array(
				'layout_1' => 'layout-1',
				'layout_2' => 'layout-2',
				'layout_3' => 'layout-3',
				'layout_4' => 'layout-4',
				'layout_5' => 'layout-5',
				'layout_6' => 'layout-6',
			);
			

			$layout = $this->get_att( 'content_layout' );
			if ( array_key_exists( $layout, $layout_classes ) ) {
				$class[] = $layout_classes[ $layout ];
			}
			if( $this->get_att( 'show_avatar' ) == 'n') {
				$class[] = 'hide-testimonial-avatar';
			}
			if($this->atts['testimonial_position'] === 'n'){
				$class[] = 'hide-testimonial-position';
			}

			if ( $this->get_flag( 'image_scale_animation_on_hover' ) ) {
				$class[] = 'scale-img';
			}
			if ( !$this->get_flag( 'image_hover_bg_color' ) ) {
				$class[] = 'disable-bg-rollover';
			}
			if ( 'grid' === $this->get_att( 'type' ) ) {
				$class[] = 'dt-css-grid-wrap';
			}
			$loading_mode = $this->get_att( 'loading_mode' );
			if ( 'standard' !== $loading_mode ) {
				$class[] = 'jquery-filter';
			}
			if ( 'grid' === $this->get_att( 'type' ) ) {
				$class[] = 'dt-css-grid-wrap';
			}

			if ( 'js_lazy_loading' === $loading_mode ) {
				$class[] = 'lazy-loading-mode';
			}

			if ( $this->get_flag( 'jsp_show_all_pages' ) ) {
				$class[] = 'show-all-pages';
			}

			$class = $this->add_responsiveness_class( $class );

			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_testimonials_masonry'], ' ' );
			}

			$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		}
		/**
		 * Iso container class.
		 *
		 * @param array $class
		 *
		 * @return string
		 */
		protected function iso_container_class( $class = array() ) {
			if ( 'grid' === $this->get_att( 'type' ) ) {
				$class[] = 'dt-css-grid';
			} else {
				$class[] = 'iso-container';
			}

			return 'class="' . esc_attr( join( ' ', $class ) ) . '" ';
		}
		/**
		 * Browser responsiveness classes.
		 *
		 * @param array $class
		 *
		 * @return array
		 */
		protected function add_responsiveness_class( $class = array() ) {
			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$class[] = 'resize-by-browser-width';
			}

			return $class;
		}
		/**
		 * Browser responsiveness data attributes.
		 *
		 * @param array $data_atts
		 *
		 * @return array
		 */
		protected function add_responsiveness_data_atts( $data_atts = array() ) {
			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$bwb_columns = DT_VCResponsiveColumnsParam::decode_columns( $this->get_att( 'bwb_columns' ) );
				$columns = array(
					'desktop'  => 'desktop',
					'v_tablet' => 'v-tablet',
					'h_tablet' => 'h-tablet',
					'phone'    => 'phone',
				);

				foreach ( $columns as $column => $data_att ) {
					$val = ( isset( $bwb_columns[ $column ] ) ? absint( $bwb_columns[ $column ] ) : '' );
					$data_atts[] = 'data-' . $data_att . '-columns-num="' . esc_attr( $val ) . '"';
				}
			}

			return $data_atts;
		}
			/**
		 * Return post excerpt with $length words.
		 *
		 * @return mixed
		 */
		 protected function get_post_excerpt() {
		 	$read_more_html = ' ' . presscore_post_details_link( null, array( 'more-link' ), __( 'read more', 'dt-the7-core' ) );
			$show_read_more = get_post_meta( get_the_ID(), '_dt_testimonial_options_go_to_single', true );

			if ( 'show_content' === $this->atts['post_content'] ) {
				$content = get_the_content();

				if ( $show_read_more  ) {
					$content .= $read_more_html ;
				}

				$excerpt = apply_filters( 'the_content', $content );
			} else {
				$length = absint( $this->atts['excerpt_words_limit'] );
				$excerpt = apply_filters( 'the7_shortcodeaware_excerpt', get_the_excerpt() );

				if ( $length ) {
					$trimmed_excerpt = wp_trim_words( $excerpt, $length );
					if ( $trimmed_excerpt != $excerpt ) {
						$show_read_more = true;
					}

					$excerpt = $trimmed_excerpt;
				}

				if ( $show_read_more ) {
					$excerpt .= $read_more_html ;
				}

				$excerpt = apply_filters( 'the_excerpt', $excerpt );
			}


			return $excerpt;
		 }
		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();

			$config->set( 'load_style', 'default' );
			$config->set( 'template', 'testimonials' );
			$config->set( 'layout', $this->get_att( 'type' ) );
			$config->set( 'post.preview.load.effect', $this->get_att( 'loading_effect' ), 'none' );
			$show_post_content = true;
			$config->set( 'show_excerpts', $show_post_content );
			$config->set( 'post.preview.content.visible', $show_post_content );
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
			$config->set( 'post.preview.description.style', 'under_image' );
			if ( 'standard' === $this->get_att( 'loading_mode' ) ) {
				$config->set( 'show_all_pages', $this->get_flag( 'st_show_all_pages' ) );
			} else {
				$config->set( 'show_all_pages', $this->get_flag( 'jsp_show_all_pages' ) );
				$config->set( 'request_display', false );
			}
			$config->set( 'order', $this->get_att( 'order' ) );
			$config->set( 'orderby', $this->get_att( 'orderby' ) );
			$config->set( 'item_padding', $this->get_att( 'gap_between_posts' ) );
			$config->set( 'post.preview.width.min', $this->get_att( 'pwb_column_min_width' ) );
			$config->set( 'template.columns.number', $this->get_att( 'pwb_columns' ) );
			$config->set( 'post.preview.background.enabled', $this->get_att( 'members_bg') );
			$config->set( 'template.posts_filter.terms.enabled', $this->get_flag( 'show_categories_filter' ) );
		}
		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'dt-testimonials-shortcode.' . $this->get_unique_class(), '~"%s"' );


			$less_vars->add_pixel_or_percent_number( 'post-content-width', $this->get_att( 'bo_content_width' ) );
			$less_vars->add_pixel_number( 'post-content-top-overlap', $this->get_att( 'bo_content_overlap' ) );
			$less_vars->add_pixel_or_percent_number( 'post-content-overlap', $this->get_att( 'grovly_content_overlap' ) );

			$less_vars->add_keyword( 'post-content-bg', $this->get_att( 'custom_content_bg_color', '~""' ) );
			$less_vars->add_pixel_number( 'testimonial-img-max-width', $this->get_att( 'img_max_width', '' ) );

			$less_vars->add_paddings( array(
				'post-content-padding-top',
				'post-content-padding-right',
				'post-content-padding-bottom',
				'post-content-padding-left',
			), $this->get_att( 'post_content_paddings' ) );


			$less_vars->add_paddings( array(
				'post-thumb-padding-top',
				'post-thumb-padding-right',
				'post-thumb-padding-bottom',
				'post-thumb-padding-left',
			), $this->get_att( 'image_paddings' ), '%|px' );
			$less_vars->add_pixel_number( 'img-border-radius', $this->get_att( 'img_border_radius' ) );
			
			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$bwb_columns = DT_VCResponsiveColumnsParam::decode_columns( $this->get_att( 'bwb_columns' ) );
				$columns = array(
					'desktop'  => 'desktop',
					'v_tablet' => 'v-tablet',
					'h_tablet' => 'h-tablet',
					'phone'    => 'phone',
				);

				foreach ( $columns as $column => $data_att ) {
					$val = ( isset( $bwb_columns[ $column ] ) ? absint( $bwb_columns[ $column ] ) : '' );
					$data_atts[] = 'data-' . $data_att . '-columns-num="' . esc_attr( $val ) . '"';
					
					$less_vars->add_keyword( $data_att. '-columns-num', esc_attr( $val ) );
			
				}
			};
			$less_vars->add_pixel_number( 'grid-posts-gap', $this->get_att( 'gap_between_posts' ) );
			$less_vars->add_pixel_number( 'grid-post-min-width', $this->get_att( 'pwb_column_min_width' ));
			$less_vars->add_pixel_number( 'grid-desire-col-num', $this->get_att( 'pwb_columns' ) );
			//Post tab
			$less_vars->add_font_style( array(
				'post-title-font-style',
				'post-title-font-weight',
				'post-title-text-transform',
			), $this->get_att( 'post_title_font_style' ) );
			$less_vars->add_pixel_number( 'post-title-font-size', $this->get_att( 'post_title_font_size' ) );
			$less_vars->add_pixel_number( 'post-title-font-size-tablet', $this->get_att( 'post_title_font_size_tablet' ) );
			$less_vars->add_pixel_number( 'post-title-font-size-phone', $this->get_att( 'post_title_font_size_phone' ) );
			$less_vars->add_pixel_number( 'post-title-line-height', $this->get_att( 'post_title_line_height' ) );
			$less_vars->add_pixel_number( 'post-title-line-height-tablet', $this->get_att( 'post_title_line_height_tablet' ) );
			$less_vars->add_pixel_number( 'post-title-line-height-phone', $this->get_att( 'post_title_line_height_phone' ) );
			$less_vars->add_pixel_number( 'testimonial-position-font-size', $this->get_att( 'testimonial_position_font_size' ) );
			$less_vars->add_pixel_number( 'testimonial-position-font-size-tablet', $this->get_att( 'testimonial_position_font_size_tablet' ) );
			$less_vars->add_pixel_number( 'testimonial-position-font-size-phone', $this->get_att( 'testimonial_position_font_size_phone' ) );
			$less_vars->add_pixel_number( 'testimonial-position-line-height', $this->get_att( 'testimonial_position_line_height' ) );
			$less_vars->add_pixel_number( 'testimonial-position-line-height-tablet', $this->get_att( 'testimonial_position_line_height_tablet' ) );
			$less_vars->add_pixel_number( 'testimonial-position-line-height-phone', $this->get_att( 'testimonial_position_line_height_phone' ) );

			$less_vars->add_keyword( 'post-title-color', $this->get_att( 'custom_title_color', '~""' ) );
			$less_vars->add_keyword( 'testimonial-position-color', $this->get_att( 'testimonial_position_color', '~""' ) );
			$less_vars->add_keyword( 'post-content-color', $this->get_att( 'custom_content_color', '~""' ) );

			$less_vars->add_pixel_number( 'post-excerpt-font-size', $this->get_att( 'content_font_size' ) );
			$less_vars->add_pixel_number( 'post-excerpt-font-size-tablet', $this->get_att( 'content_font_size_tablet' ) );
			$less_vars->add_pixel_number( 'post-excerpt-font-size-phone', $this->get_att( 'content_font_size_phone' ) );
			$less_vars->add_pixel_number( 'post-excerpt-line-height', $this->get_att( 'content_line_height' ) );
			$less_vars->add_pixel_number( 'post-excerpt-line-height-tablet', $this->get_att( 'content_line_height_tablet' ) );
			$less_vars->add_pixel_number( 'post-excerpt-line-height-phone', $this->get_att( 'content_line_height_phone' ) );
			$less_vars->add_pixel_number( 'testimonial-position-margin-bottom', $this->get_att( 'testimonial_position_bottom_margin', '0' ) );
			$less_vars->add_pixel_number( 'post-title-margin-bottom', $this->get_att( 'post_title_bottom_margin', '0' ) );
			$less_vars->add_pixel_number( 'post-excerpt-margin-bottom', $this->get_att( 'content_bottom_margin', '0' ) );

			$less_vars->add_font_style( array(
				'testimonial-position-font-style',
				'testimonial-position-font-weight',
				'testimonial-position-text-transform',
			), $this->get_att( 'testimonial_position_font_style' ) );
			$less_vars->add_font_style( array(
				'post-content-font-style',
				'post-content-font-weight',
				'post-content-text-transform',
			), $this->get_att( 'content_font_style' ) );

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
			$less_vars->add_keyword( 'shortcode-filter-color', $this->get_att( 'navigation_font_color', '~""' ) );
			$less_vars->add_keyword( 'shortcode-filter-accent', $this->get_att( 'navigation_accent_color', '~""' ) );

			return $less_vars->get_vars();
		}

		protected function get_less_file_name() {
			if ( the7pt_is_theme_version_smaller_or_equal_to( '6.7.0' ) ) {
				return get_template_directory() . '/css/dynamic-less/shortcodes/dt-testimonials-masonry.less';
			}

			return The7PT()->plugin_path() . 'assets/css/shortcodes/dt-testimonials-masonry.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return $this->vc_inline_dummy( array(
				'class'  => 'dt_testimonials_masonry',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_testim_masonry_editor_ico.gif', 98, 104 ),
				'title'  => _x( 'Testimonials Masonry & Grid', 'vc inline dummy', 'dt-the7-core' ),

				'style' => array( 'height' => 'auto' )
			) );
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
					'paged'            => dt_get_paged_var(),
					'suppress_filters' => false,
					'post__in'         => $post_ids,
				);

				$request = $config->get( 'request_display' );
				if ( ! empty( $request['terms_ids'] ) ) {
					$query_args['tax_query'] = array(
						array(
							'taxonomy' => 'dt_testimonials_category',
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
						'taxonomy' => 'dt_testimonials_category',
						'field'    => 'term_id',
						'terms'    => $request['terms_ids'],
					);
					$tax_query['relation'] = 'AND';
				}

				$query_args['orderby'] = $config->get( 'orderby' );
				$query_args['order'] = $config->get( 'order' );
				$query_args['paged'] = dt_get_paged_var();
			} else {
				// JS pagination.
				$query_args['orderby'] = $this->get_att( 'orderby' );
				$query_args['order'] = $this->get_att( 'order' );
				$query_args['paged'] = 1;
			}

			if ( $tax_query ) {
				$query_args['tax_query'] = $tax_query;
			}

			add_action( 'pre_get_posts', array( $this, 'sticky_posts_fix' ) );

			return new WP_Query( $query_args );
		}

		protected function get_posts_per_page( $pagination_mode ) {
			$posts_per_page = - 1;
			switch ( $pagination_mode ) {
				case 'disabled':
					$posts_per_page = $this->get_att( 'dis_posts_total' );
					break;
				case 'standard':
					$posts_per_page = $this->get_att( 'st_posts_per_page' );
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
			}

			return $posts_per_page;
		}

		/**
		 * pre_get_posts filter that add sticky posts to taxonomy
		 *
		 * @param $q
		 */
		public function sticky_posts_fix( $q ) {
			remove_action( 'pre_get_posts', array( $this, 'sticky_posts_fix' ) );

			// Set is_home to true.
			$q->is_home = true;

			if ( ! $q->get( 'tax_query' ) ) {
				return;
			}

			// Get all stickies
			$stickies = get_option( 'sticky_posts' );
			// Make sure we have stickies, if not, bail.
			if ( !$stickies ) {
				return;
			}

			// Query the stickies according to category.
			$args = array(
				'post__in'            => $stickies,
				'posts_per_page'      => -1,
				'ignore_sticky_posts' => 1,
				'tax_query'           => $q->get( 'tax_query' ),
				'orderby'             => 'post__in',
				'order'               => 'ASC',
				'fields'              => 'ids',
			);
			$valid_sticky_query = new WP_Query( $args );
			$valid_sticky_ids = $valid_sticky_query->posts;

			// Make sure we have valid ids.
			if ( !$valid_sticky_ids ) {
				$q->set( 'post__not_in', $stickies );
				return;
			}

			// Remove these ids from the sticky posts array.
			$invalid_ids = array_diff( $stickies, $valid_sticky_ids );

			// Check if we still have ids left in $invalid_ids.
			if ( !$invalid_ids ) {
				return;
			}

			// Lets remove these invalid ids from our query.
			$q->set( 'post__not_in', $invalid_ids );
		}

		protected function get_posts_filter_terms( $query ) {
			$post_type = $this->get_att( 'post_type' );
			$data = $this->get_att( $post_type );

			// If empty - return all categories.
			if ( empty( $data ) ) {
				return get_terms( array(
					'taxonomy'   => 'dt_testimonials_category',
					'hide_empty' => true,
				) );
			}

			// If posts selected - return corresponded categories.
			if ( 'posts' === $post_type ) {
				$post_ids = presscore_sanitize_explode_string( $data );

				return wp_get_object_terms( $post_ids, 'dt_testimonials_category', array( 'fields' => 'all_with_object_id' ) );
			}

			// If categories selected.
			if ( 'category' === $post_type ) {
				$get_terms_args = array(
					'taxonomy'   => 'dt_testimonials_category',
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
		}

		/**
		 * Return proportion out of string like '1x2'
		 *
		 * @param string $prop
		 *
		 * @return float|int
		 */
		protected function get_proportion( $prop ) {
			$img_dim = array_slice( array_map( 'absint', explode( 'x', strtolower( $prop ) ) ), 0, 2 );

			// Make sure that all values is set.
			for ( $i = 0; $i < 2; $i++ ) {
				if ( empty( $img_dim[ $i ] ) ) {
					return 0;
				}
			}

			return $img_dim[0] / $img_dim[1];
		}
	}

	// create shortcode
	DT_Shortcode_Testimonials_Masonry::get_instance()->add_shortcode();
endif;
