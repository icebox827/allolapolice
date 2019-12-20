<?php
/**
 * Testimonials Carousel shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Testimonials_Carousel', false ) ) :

	class DT_Shortcode_Testimonials_Carousel extends The7pt_Shortcode_With_Inline_CSS {
		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Testimonials_Shortcode_Carousel
		 */
		public static $instance = null;

		/**
		 * @return DT_Testimonials_Shortcode_Carousel
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			$this->sc_name = 'dt_testimonials_carousel';
			$this->unique_class_base = 'testimonials-carousel-shortcode-id';
			$this->taxonomy = 'dt_testimonials_category';
			$this->post_type = 'dt_testimonials';

			$this->default_atts = array(
				'post_type' => 'category',
				'posts' => '',
				'category' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'dis_posts_total' => '6',
				'content_layout' => 'layout_4',
				'img_border_radius' => '500px',
				'content_bg' => 'y',
				'custom_content_bg_color' => '',
				'post_content_paddings' => '30px 30px 20px 30px',
				'show_avatar' => 'y',
				'image_sizing' => 'resize',
				'resized_image_dimensions' => '1x1',
				'img_max_width' => '80px',
				'image_paddings' => '0px 20px 20px 0px',

				'slide_to_scroll' => 'single',
				'slides_on_wide_desk' => '4',
				'slides_on_desk' => '3',
				'slides_on_lapt' => '3',
				'slides_on_h_tabs' => '2',
				'slides_on_v_tabs' => '1',
				'slides_on_mob' => '1',
				'adaptive_height' => 'n',
				'item_space' => '30',
				'stage_padding' => '0',
				'speed' => '600',
				'autoplay' => 'n',
				'autoplay_speed' => "6000",

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

				'arrows' => 'y',
				'arrow_icon_size' => '18px',
				'r_arrow_icon_paddings' => '0 0 0 0',
				'l_arrow_icon_paddings' => '0 0 0 0',
				'arrow_bg_width' => "36px",
				'arrow_bg_height' => "36px",
				'arrow_border_radius' => '500px',
				'arrow_border_width' => '0',
				'arrow_icon_color' => '#ffffff',
				'arrow_icon_border' => 'y',
				'arrow_border_color' => '',
				'arrows_bg_show' => 'y',
				'arrow_bg_color' => '',
				'arrow_icon_color_hover' => 'rgba(255,255,255,0.75)',
				'arrow_icon_border_hover' => 'y',
				'arrow_border_color_hover' => '',
				'arrows_bg_hover_show' => 'y',
				'arrow_bg_color_hover' => '',
				'r_arrow_v_position' => 'center',
				'r_arrow_h_position' => 'right',
				'r_arrow_v_offset' => '0',
				'r_arrow_h_offset' => '-43px',
				'l_arrow_v_position' => 'center',
				'l_arrow_h_position' => 'left',
				'l_arrow_v_offset' => '0',
				'l_arrow_h_offset' => '-43px',
				'arrow_responsiveness' => 'reposition-arrows',
				'hide_arrows_mobile_switch_width' => '778px',
				'reposition_arrows_mobile_switch_width' => '778px',
				'l_arrows_mobile_h_position' => '-18px',
				'r_arrows_mobile_h_position' => '-18px',

				'show_bullets' => 'n',
				'bullets_style' => 'small-dot-stroke',
				'bullet_size' => '10px',
				'bullet_color' => '',
				'bullet_color_hover' => '',
				'bullet_gap' => "16px",
				'bullets_v_position' => 'bottom',
				'bullets_h_position' => 'center',
				'bullets_v_offset' => '20px',
				'bullets_h_offset' => '0',
				'next_icon' => 'icon-ar-017-r',
				'prev_icon' => 'icon-ar-017-l',
				'css_dt_testimonials_carousel' => '',
				'el_class' => '',
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

			do_action( 'presscore_before_shortcode_loop', $this->sc_name, $this->atts );

			presscore_remove_posts_masonry_wrap();

			echo '<div ' . $this->get_container_html_class( array( 'owl-carousel testimonials-carousel-shortcode dt-testimonials-shortcode dt-owl-carousel-call' ) ) . ' ' . $this->get_container_data_atts() . '>';
				$lazy_loading_enabled = presscore_lazy_loading_enabled();
				if ( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
					do_action('presscore_before_post');
					$post_id = get_the_ID();

					echo '<div class="testimonial-item">';
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
										'img_meta' => wp_get_attachment_image_src( $thumb_id, 'full' ),
										'prop'     => $proportion,
										'echo'     => false,
										'lazy_loading'  => $lazy_loading_enabled,
										'lazy_class'    => 'owl-lazy-load',
										'lazy_bg_class' => 'layzr-bg',
										'wrap'     => '<img %IMG_CLASS% %SRC% %SIZE% %IMG_TITLE% %ALT% />',
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

					
					do_action('presscore_after_post');

					endwhile; endif;
				echo '</div>';
				presscore_add_lazy_load_attrs();
				do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
		}
		
		protected function get_container_html_class( $class = array() ) {
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

			if ( 'left' === $this->get_att( 'content_alignment' ) ) {
				$class[] = 'content-align-left';
			}else{
				$class[] = 'content-align-center';
			};

			$layout_classes = array(
				'layout_1'           => 'layout-1',
				'layout_2'    => 'layout-2',
				'layout_3'  => 'layout-3',
				'layout_4'  => 'layout-4',
				'layout_5' => 'layout-5',
				'layout_6' => 'layout-6',
			);

			$layout = $this->get_att( 'content_layout' );
			if ( array_key_exists( $layout, $layout_classes ) ) {
				$class[] = $layout_classes[ $layout ];
			}


			if ( $this->get_flag( 'content_bg' ) ) {
				$class[] = 'content-bg-on';
			}else{
				$class[] = 'content-bg-off';
			}

			if($this->atts['testimonial_position'] === 'n'){
				$class[] = 'hide-testimonial-position';
			}

			if( $this->get_att( 'show_avatar' ) == 'n') {
				$class[] = 'hide-testimonial-avatar';
			}

			switch ( $this->atts['bullets_style'] ) {
				case 'scale-up':
					$class[] = 'bullets-scale-up';
					break;
				case 'stroke':
					$class[] = 'bullets-stroke';
					break;
				case 'fill-in':
					$class[] = 'bullets-fill-in';
					break;
				case 'small-dot-stroke':
					$class[] = 'bullets-small-dot-stroke';
					break;
				case 'ubax':
					$class[] = 'bullets-ubax';
					break;
				case 'etefu':
					$class[] = 'bullets-etefu';
					break;
			};
			switch ( $this->atts['arrow_responsiveness'] ) {
				case 'hide-arrows':
					$class[] = 'hide-arrows';
					break;
				case 'reposition-arrows':
					$class[] = 'reposition-arrows';
					break;
			};
			if($this->atts['arrows_bg_show'] === 'y'){
				$class[] = 'arrows-bg-on';
			}else{
				$class[] = 'arrows-bg-off';
			};
			if($this->atts['arrow_icon_border'] === 'y'){
				$class[] = 'dt-arrow-border-on';
			}
			if($this->atts['arrow_icon_border_hover'] === 'y'){
				$class[] = 'dt-arrow-hover-border-on';
			}
			
			if ( $this->get_att( 'arrow_bg_color' ) === $this->get_att( 'arrow_bg_color_hover' ) ) {
				$class[] = 'disable-arrows-hover-bg';
			};

			if($this->atts['arrows_bg_hover_show'] === 'y'){
				$class[] = 'arrows-hover-bg-on';
			}else{
				$class[] = 'arrows-hover-bg-off';
			};
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_testimonials_carousel'], ' ' );
			};
			$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
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

			return 'class="' . join( ' ', get_post_class( $class, null ) ) . '"';
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

		protected function get_container_data_atts() {
			$data_atts = array(
				'scroll-mode' => ($this->atts['slide_to_scroll'] == "all") ? 'page' : '1',
				'col-num' => $this->atts['slides_on_desk'],
				'wide-col-num' => $this->atts['slides_on_wide_desk'],
				'laptop-col' => $this->atts['slides_on_lapt'],
				'h-tablet-columns-num' => $this->atts['slides_on_h_tabs'],
				'v-tablet-columns-num' => $this->atts['slides_on_v_tabs'],
				'phone-columns-num' => $this->atts['slides_on_mob'],
				'auto-height' => ($this->atts['adaptive_height'] === 'y') ? 'true' : 'false',
				'col-gap' => $this->atts['item_space'],
				'stage-padding' => $this->atts['stage_padding'],
				'speed' => $this->atts['speed'],
				'autoplay' => ($this->atts['autoplay'] === 'y') ? 'true' : 'false',
				'autoplay_speed' => $this->atts['autoplay_speed'],
				'arrows' => ($this->atts['arrows'] === 'y') ? 'true' : 'false',
				'bullet' => ($this->atts['show_bullets'] === 'y') ? 'true' : 'false',
				'next-icon'=> $this->atts['next_icon'],
				'prev-icon'=> $this->atts['prev_icon'],
			);

			return presscore_get_inlide_data_attr( $data_atts );
		}
		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = Presscore_Config::get_instance();

			$config->set( 'template', 'testimonials' );

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
			
			$config->set( 'post.preview.background.enabled', false );
			$config->set( 'post.preview.background.style',  '' );
		}
		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'testimonials-carousel-shortcode.' . $this->get_unique_class(), '~"%s"' );


			$less_vars->add_pixel_or_percent_number( 'post-content-width', $this->get_att( 'bo_content_width' ) );
			$less_vars->add_pixel_number( 'post-content-top-overlap', $this->get_att( 'bo_content_overlap' ) );
			$less_vars->add_pixel_or_percent_number( 'post-content-overlap', $this->get_att( 'grovly_content_overlap' ) );

			$less_vars->add_keyword( 'post-content-bg', $this->get_att( 'custom_content_bg_color', '~""' ) );
			$less_vars->add_pixel_number( 'testimonial-img-max-width', $this->get_att( 'img_max_width', '' ) );

            $proportion = 0;
			if ( 'resize' === $this->get_att( 'image_sizing' ) ) {
			    $proportion = $this->get_proportion( $this->get_att( 'resized_image_dimensions' ) );
			}
			$less_vars->add_pixel_number( 'testimonial-img-proportion', $proportion );

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

			$less_vars->add_pixel_number( 'icon-size', $this->get_att( 'arrow_icon_size' ) );
			$less_vars->add_paddings( array(
				'l-icon-padding-top',
				'l-icon-padding-right',
				'l-icon-padding-bottom',
				'l-icon-padding-left',
			), $this->get_att( 'l_arrow_icon_paddings' ) );
			$less_vars->add_paddings( array(
				'r-icon-padding-top',
				'r-icon-padding-right',
				'r-icon-padding-bottom',
				'r-icon-padding-left',
			), $this->get_att( 'r_arrow_icon_paddings' ) );
			$less_vars->add_pixel_number( 'arrow-width', $this->get_att( 'arrow_bg_width' ) );
			$less_vars->add_pixel_number( 'arrow-height', $this->get_att( 'arrow_bg_height' ) );
			$less_vars->add_pixel_number( 'arrow-border-radius', $this->get_att( 'arrow_border_radius' ) );
			$less_vars->add_pixel_number( 'arrow-border-width', $this->get_att( 'arrow_border_width' ) );

			$less_vars->add_keyword( 'icon-color', $this->get_att( 'arrow_icon_color', '~""' ) );
			$less_vars->add_keyword( 'arrow-border-color', $this->get_att( 'arrow_border_color', '~""' ) );
			$less_vars->add_keyword( 'arrow-bg', $this->get_att( 'arrow_bg_color', '~""' ) );
			$less_vars->add_keyword( 'icon-color-hover', $this->get_att( 'arrow_icon_color_hover', '~""' ) );
			$less_vars->add_keyword( 'arrow-border-color-hover', $this->get_att( 'arrow_border_color_hover', '~""' ) );
			$less_vars->add_keyword( 'arrow-bg-hover', $this->get_att( 'arrow_bg_color_hover', '~""' ) );
			
			$less_vars->add_keyword( 'arrow-right-v-position', $this->get_att( 'r_arrow_v_position' ) );
			$less_vars->add_keyword( 'arrow-right-h-position', $this->get_att( 'r_arrow_h_position' ) );
			$less_vars->add_pixel_number( 'r-arrow-v-position', $this->get_att( 'r_arrow_v_offset' ) );
			$less_vars->add_pixel_number( 'r-arrow-h-position', $this->get_att( 'r_arrow_h_offset' ) );

			$less_vars->add_keyword( 'arrow-left-v-position', $this->get_att( 'l_arrow_v_position' ) );
			$less_vars->add_keyword( 'arrow-left-h-position', $this->get_att( 'l_arrow_h_position' ) );
			$less_vars->add_pixel_number( 'l-arrow-v-position', $this->get_att( 'l_arrow_v_offset' ) );
			$less_vars->add_pixel_number( 'l-arrow-h-position', $this->get_att( 'l_arrow_h_offset' ) );
			$less_vars->add_pixel_number( 'hide-arrows-switch', $this->get_att( 'hide_arrows_mobile_switch_width' ) );
			$less_vars->add_pixel_number( 'reposition-arrows-switch', $this->get_att( 'reposition_arrows_mobile_switch_width' ) );
			$less_vars->add_pixel_number( 'arrow-left-h-position-mobile', $this->get_att( 'l_arrows_mobile_h_position' ) );
			$less_vars->add_pixel_number( 'arrow-right-h-position-mobile', $this->get_att( 'r_arrows_mobile_h_position' ) );

			$less_vars->add_pixel_number( 'bullet-size', $this->get_att( 'bullet_size' ) );
			$less_vars->add_keyword( 'bullet-color', $this->get_att( 'bullet_color', '~""' ) );
			$less_vars->add_keyword( 'bullet-color-hover', $this->get_att( 'bullet_color_hover', '~""' ) );
			$less_vars->add_pixel_number( 'bullet-gap', $this->get_att( 'bullet_gap' ) );
			$less_vars->add_keyword( 'bullets-v-position', $this->get_att( 'bullets_v_position' ) );
			$less_vars->add_keyword( 'bullets-h-position', $this->get_att( 'bullets_h_position' ) );
			$less_vars->add_pixel_number( 'bullet-v-position', $this->get_att( 'bullets_v_offset' ) );
			$less_vars->add_pixel_number( 'bullet-h-position', $this->get_att( 'bullets_h_offset' ) );
			

			return $less_vars->get_vars();
		}

		protected function get_less_file_name() {
			if ( the7pt_is_theme_version_smaller_or_equal_to( '6.7.0' ) ) {
				return get_template_directory() . '/css/dynamic-less/shortcodes/dt-testimonials-carousel.less';
			}

			return The7PT()->plugin_path() . 'assets/css/shortcodes/dt-testimonials-carousel.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return $this->vc_inline_dummy( array(
				'class'  => 'dt_testimonials_carousel',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_testim_carousel_editor_ico.gif', 133, 104 ),
				'title'  => _x( 'Testimonials Carousel', 'vc inline dummy', 'dt-the7-core' ),
				'style' => array( 'height' => 'auto' )
			) );
		}

		protected function get_posts_by_post_type( $post_type, $post_ids = array() ) {
			$posts_per_page = $this->get_att( 'dis_posts_total', '-1' );

			if ( is_string( $post_ids ) ) {
				$post_ids = presscore_sanitize_explode_string( $post_ids );
			}
			$post_ids = array_filter( $post_ids );
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

			return new WP_Query( $query_args );
		}

		protected function get_posts_by_taxonomy( $post_type, $taxonomy, $taxonomy_terms = array(), $taxonomy_field = 'term_id' ) {
			$posts_per_page = $this->get_att( 'dis_posts_total', '-1' );

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

			// JS pagination.
			$query_args['orderby'] = $this->get_att( 'orderby' );
			$query_args['order'] = $this->get_att( 'order' );
			$query_args['paged'] = 1;

			if ( $tax_query ) {
				$query_args['tax_query'] = $tax_query;
			}

			add_action( 'pre_get_posts', array( $this, 'sticky_posts_fix' ) );

			return new WP_Query( $query_args );
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
	DT_Shortcode_Testimonials_Carousel::get_instance()->add_shortcode();
endif;
