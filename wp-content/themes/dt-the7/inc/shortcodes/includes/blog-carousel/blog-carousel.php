<?php
/**
 * Blog Carousel shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Blog_Carousel', false ) ) :

	class DT_Shortcode_Blog_Carousel extends DT_Shortcode_With_Inline_Css {
		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Blog_Shortcode_Carousel
		 */
		public static $instance = null;

		/**
		 * @return DT_Blog_Shortcode_Carousel
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name           = 'dt_blog_carousel';
			$this->unique_class_base = 'blog-carousel-shortcode-id';
			$this->taxonomy          = 'category';
			$this->post_type         = 'post';
			$this->default_atts      = array(
				'post_type'                             => 'category',
				'category'                              => '',
				'tags'                                  => '',
				'posts'                                 => '',
				'posts_offset'                          => 0,
				'order'                                 => 'desc',
				'orderby'                               => 'date',
				'dis_posts_total'                       => '6',
				'layout'                                => 'classic',
				'bo_content_width'                      => '75%',
				'bo_content_top_overlap'                => '100px',
				'grovly_content_overlap'                => '0px',
				'content_bg'                            => 'y',
				'custom_content_bg_color'               => '',
				'post_content_paddings'                 => '15px 20px 20px 20px',
				'image_sizing'                          => 'resize',
				'resized_image_dimensions'              => '3x2',
				'image_paddings'                        => '0px 0px 0px 0px',
				'image_scale_animation_on_hover' 		=> 'slow_scale',
				'image_hover_bg_color'           		=> 'disabled',
				'custom_rollover_bg_color'       		=> 'rgba(0,0,0,0.5)',
				'custom_rollover_bg_gradient'    		=> '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
				'slide_to_scroll'                       => 'single',
				'slides_on_wide_desk'                   => '4',
				'slides_on_desk'                        => '3',
				'slides_on_lapt'                        => '3',
				'slides_on_h_tabs'                      => '3',
				'slides_on_v_tabs'                      => '2',
				'slides_on_mob'                         => '1',
				'adaptive_height'                       => 'y',
				'item_space'                            => '30',
				'stage_padding' 						=> '0',
				'speed'                                 => '600',
				'autoplay'                              => 'n',
				'autoplay_speed'                        => "6000",
				'content_alignment'                     => 'left',
				'post_title_font_style'                 => ':bold:',
				'post_title_font_size'                  => '',
				'post_title_line_height'                => '',
				'custom_title_color'                    => '',
				'post_title_bottom_margin'              => '5px',
				'post_date'                             => 'y',
				'post_category'                         => 'y',
				'post_author'                           => 'y',
				'post_comments'                         => 'y',
				'meta_info_font_style'                  => '',
				'meta_info_font_size'                   => '',
				'meta_info_line_height'                 => '',
				'custom_meta_color'                     => '',
				'meta_info_bottom_margin'               => '15px',
				'post_content'                          => 'show_excerpt',
				'excerpt_words_limit'                   => '',
				'content_font_style'                    => '',
				'content_font_size'                     => '',
				'content_line_height'                   => '',
				'custom_content_color'                  => '',
				'content_bottom_margin'                 => '5px',
				'read_more_button'                      => 'default_link',
				'read_more_button_text'                 => '',
				'fancy_date'                            => 'n',
				'fancy_date_font_color'                 => '',
				'fancy_date_bg_color'                   => '',
				'fancy_date_line_color'                 => '',
				'fancy_categories'                      => 'n',
				'fancy_categories_font_color'           => '',
				'fancy_categories_bg_color'             => '',
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
				'arrows'                                => 'y',
				'arrow_icon_size'                       => '18px',
				'r_arrow_icon_paddings'                 => '0 0 0 0',
				'l_arrow_icon_paddings'                 => '0 0 0 0',
				'arrow_bg_width'                        => "36px",
				'arrow_bg_height'                       => "36px",
				'arrow_border_radius'                   => '500px',
				'arrow_border_width'                    => '0',
				'arrow_icon_color'                      => '#ffffff',
				'arrow_icon_border'                     => 'y',
				'arrow_border_color'                    => '',
				'arrows_bg_show'                        => 'y',
				'arrow_bg_color'                        => '',
				'arrow_icon_color_hover'                => 'rgba(255,255,255,0.75)',
				'arrow_icon_border_hover'               => 'y',
				'arrow_border_color_hover'              => '',
				'arrows_bg_hover_show'                  => 'y',
				'arrow_bg_color_hover'                  => '',
				'r_arrow_v_position'                    => 'center',
				'r_arrow_h_position'                    => 'right',
				'r_arrow_v_offset'                      => '0',
				'r_arrow_h_offset'                      => '-43px',
				'l_arrow_v_position'                    => 'center',
				'l_arrow_h_position'                    => 'left',
				'l_arrow_v_offset'                      => '0',
				'l_arrow_h_offset'                      => '-43px',
				'arrow_responsiveness'                  => 'reposition-arrows',
				'hide_arrows_mobile_switch_width'       => '778px',
				'reposition_arrows_mobile_switch_width' => '778px',
				'l_arrows_mobile_h_position'            => '10px',
				'r_arrows_mobile_h_position'            => '10px',
				'show_bullets'                          => 'n',
				'bullets_style'                         => 'small-dot-stroke',
				'bullet_size'                           => '10px',
				'bullet_color'                          => '',
				'bullet_color_hover'                    => '',
				'bullet_gap'                            => "16px",
				'bullets_v_position'                    => 'bottom',
				'bullets_h_position'                    => 'center',
				'bullets_v_offset'                      => '20px',
				'bullets_h_offset'                      => '0',
				'next_icon'                             => 'icon-ar-017-r',
				'prev_icon'                             => 'icon-ar-017-l',
				'css_dt_blog_carousel'                  => '',
				'el_class'                              => '',
			);
			parent::__construct();
		}
		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			$query = $this->get_loop_query();

			do_action( 'presscore_before_shortcode_loop', $this->sc_name, $this->atts );

			presscore_remove_posts_masonry_wrap();
			presscore_remove_lazy_load_attrs();
			$show_icon_zoom = '';
			if ( $this->get_att( 'show_zoom' ) === 'y' ) {
				$show_icon_zoom = '<span class="gallery-zoom-ico ' . esc_attr( $this->get_att( 'gallery_image_zoom_icon' ) ) . '"><span></span></span>';
			}

			echo '<div ' . $this->get_container_html_class( array( 'owl-carousel blog-carousel-shortcode dt-owl-carousel-call' ) ) . ' ' . $this->get_container_data_atts() . '>';
			$lazy_loading_enabled = presscore_lazy_loading_enabled();
			if ( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();

					do_action('presscore_before_post');

					$post_class_array = array(
						'post',
					);

					if ( ! has_post_thumbnail() ) {
						$post_class_array[] = 'no-img';
					}

					echo '<article ' . $this->post_class( $post_class_array ) . ' data-name="' . esc_attr( get_the_title() ) . '" data-date="' . esc_attr( get_the_date( 'c' ) ) . '">';

						// Print custom css for VC scripts.
						if ( 'show_content' === $this->get_att( 'post_content' ) && function_exists( 'visual_composer' ) ) {
							visual_composer()->addShortcodesCustomCss();
						}

						$post_media = '';
						if ( has_post_thumbnail() ) {
							$columns = array(
								'wide_desktop'  => $this->get_att( 'slides_on_wide_desk' ),
								'desktop'  => $this->get_att( 'slides_on_desk' ),
								'h_tablet' => $this->get_att( 'slides_on_h_tabs' ),
								'v_tablet' => $this->get_att( 'slides_on_v_tabs' ),
								'phone'    => $this->get_att( 'slides_on_mob' ),
							);

							$config = presscore_config();
							$image_is_wide = ( 'wide' === $config->get( 'post.preview.width' ) && ! $config->get( 'all_the_same_width' ) );
							$thumb_args = array(
								'lazy_loading'  => $lazy_loading_enabled,
								'lazy_class'    => 'owl-lazy-load',
								'lazy_bg_class' => 'layzr-bg',
								'img_id'        => get_post_thumbnail_id(),
								'class'         => 'post-thumbnail-rollover',
								'options'       => the7_calculate_bwb_image_resize_options( $columns, $this->get_att( 'item_space' ), $image_is_wide ),
								'href'          => get_permalink(),
								'wrap'          => '<a %HREF% %CLASS% %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %IMG_TITLE% %SIZE% />' . $show_icon_zoom . '</a>',
								'echo'          => false,
							);

							$post_media = dt_get_thumb_img( apply_filters( 'dt_post_thumbnail_args', $thumb_args ) );
						}

						$details_btn_style = $this->get_att( 'read_more_button' );
						$details_btn_text = $this->get_att( 'read_more_button_text', esc_html_x( 'Read more', 'the7 shortcode', 'the7mk2' ) );
						$details_btn_class = ('default_button' === $details_btn_style ? array( 'dt-btn-s', 'dt-btn' ) : array());

						presscore_get_template_part( 'shortcodes', 'blog-carousel/tpl-layout', $this->get_att( 'layout' ), array(
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
				echo '</div>';

				presscore_add_lazy_load_attrs();

				do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
		}
		
		protected function get_container_html_class( $class = array() ) {
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

			if ( 'center' === $this->get_att( 'content_alignment' ) ) {
				$class[] = 'content-align-center';
			};

			$layout_classes = array(
				'classic' => 'classic-layout-list',
				'bottom_overlap' => 'bottom-overlap-layout-list',
				'gradient_overlap' => 'gradient-overlap-layout-list',
				'gradient_overlay' => 'gradient-overlay-layout-list',
				'gradient_rollover' => 'content-rollover-layout-list',
			);
			$layout = $this->get_att( 'layout' );
			if ( array_key_exists( $layout, $layout_classes ) ) {
				$class[] = $layout_classes[ $layout ];
			};

			if ( $this->get_flag( 'content_bg' ) ) {
				$class[] = 'content-bg-on';
			}

			if ( $this->atts['image_scale_animation_on_hover']  === 'quick_scale' ) {
				$class[] = 'quick-scale-img';
			}else if($this->atts['image_scale_animation_on_hover']  === 'slow_scale') {
				$class[] = 'scale-img';
			}
			if ( 'disabled' != $this->get_att( 'image_hover_bg_color' ) ) {
				$class[] = 'enable-bg-rollover';
			}
			if ( $this->get_flag( 'project_icon_bg' ) ) {
				$class[] = 'dt-icon-bg-on';
			} else {
				$class[] = 'dt-icon-bg-off';
			}
			if($this->atts['arrow_icon_border'] === 'y'){
				$class[] = 'dt-arrow-border-on';
			}
			if($this->atts['arrow_icon_border_hover'] === 'y'){
				$class[] = 'dt-arrow-hover-border-on';
			}
			if ( ! ( $this->get_flag( 'post_date' ) || $this->get_flag( 'post_category' ) || $this->get_flag( 'post_comments' ) || $this->get_flag( 'post_author' ) ) ) {
				$class[] = 'meta-info-off';
			}

			if ( in_array( $layout, array( 'gradient_overlay', 'gradient_rollover' ) ) && 'off' === $this->get_att( 'post_content' ) && 'off' === $this->get_att( 'read_more_button' ) ) {
				$class[] = 'disable-layout-hover';
			}
			if ( $this->get_flag( 'fancy_date' ) ) {
				$class[] = presscore_blog_fancy_date_class();
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
			
			if ( $this->get_att( 'arrow_bg_color' ) === $this->get_att( 'arrow_bg_color_hover' ) ) {
				$class[] = 'disable-arrows-hover-bg';
			};

			if($this->atts['arrows_bg_hover_show'] === 'y'){
				$class[] = 'arrows-hover-bg-on';
			}else{
				$class[] = 'arrows-hover-bg-off';
			};
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_blog_carousel'], ' ' );
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
			$config = presscore_config();
			$show_post_content = ( 'off' !== $this->get_att( 'post_content' ) );
			$config->set( 'show_excerpts', $show_post_content );
			$config->set( 'post.preview.content.visible', $show_post_content );

			$config->set( 'show_details', ( 'off' !== $this->get_att( 'read_more_button' ) ) );
			$config->set( 'blog.show_icon', ('n' !==$this->get_att( 'show_zoom' )));
			$config->set( 'blog.show_icon.html',($this->get_att( 'gallery_image_zoom_icon')));

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

			$config->set( 'post.meta.fields.date', $this->get_flag( 'post_date' ) );
			$config->set( 'post.meta.fields.categories', $this->get_flag( 'post_category' ) );
			$config->set( 'post.meta.fields.comments', $this->get_flag( 'post_comments' ) );
			$config->set( 'post.meta.fields.author', $this->get_flag( 'post_author' ) );

			$config->set( 'post.fancy_date.enabled', $this->get_flag( 'fancy_date' ) );
			$config->set( 'post.fancy_category.enabled', $this->get_flag( 'fancy_categories' ) );
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
			$less_vars->add_keyword( 'unique-shortcode-class-name', 'blog-carousel-shortcode.' . $this->get_unique_class(), '~"%s"' );


			$less_vars->add_pixel_or_percent_number( 'post-content-width', $this->get_att( 'bo_content_width' ) );
			$less_vars->add_pixel_number( 'post-content-top-overlap', $this->get_att( 'bo_content_top_overlap' ) );
			$less_vars->add_pixel_or_percent_number( 'post-content-overlap', $this->get_att( 'grovly_content_overlap' ) );

			$less_vars->add_keyword( 'post-content-bg', $this->get_att( 'custom_content_bg_color', '~""' ) );

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

			//Post tab
			$less_vars->add_font_style( array(
				'post-title-font-style',
				'post-title-font-weight',
				'post-title-text-transform',
			), $this->get_att( 'post_title_font_style' ) );
			$less_vars->add_pixel_number( 'post-title-font-size', $this->get_att( 'post_title_font_size' ) );
			$less_vars->add_pixel_number( 'post-title-line-height', $this->get_att( 'post_title_line_height' ) );
			$less_vars->add_pixel_number( 'post-meta-font-size', $this->get_att( 'meta_info_font_size' ) );
			$less_vars->add_pixel_number( 'post-meta-line-height', $this->get_att( 'meta_info_line_height' ) );

			$less_vars->add_keyword( 'post-title-color', $this->get_att( 'custom_title_color', '~""' ) );
			$less_vars->add_keyword( 'post-meta-color', $this->get_att( 'custom_meta_color', '~""' ) );
			$less_vars->add_keyword( 'post-content-color', $this->get_att( 'custom_content_color', '~""' ) );

			$less_vars->add_pixel_number( 'post-excerpt-font-size', $this->get_att( 'content_font_size' ) );
			$less_vars->add_pixel_number( 'post-excerpt-line-height', $this->get_att( 'content_line_height' ) );
			$less_vars->add_pixel_number( 'post-meta-margin-bottom', $this->get_att( 'meta_info_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-title-margin-bottom', $this->get_att( 'post_title_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-excerpt-margin-bottom', $this->get_att( 'content_bottom_margin' ) );
			
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

			$less_vars->add_keyword( 'fancy-data-color', $this->get_att( 'fancy_date_font_color', '~""' ) );
			$less_vars->add_keyword( 'fancy-data-bg', $this->get_att( 'fancy_date_bg_color', '~""' ) );
			$less_vars->add_keyword( 'fancy-data-line-color', $this->get_att( 'fancy_date_line_color', '~""' ) );
			$less_vars->add_keyword( 'fancy-category-color', $this->get_att( 'fancy_categories_font_color', '~""' ) );
			$less_vars->add_keyword( 'fancy-category-bg', $this->get_att( 'fancy_categories_bg_color', '~""' ) );

			$less_vars->add_pixel_number( 'project-icon-size', $this->get_att( 'project_icon_size' ) );
			$less_vars->add_pixel_number( 'project-icon-bg-size', $this->get_att( 'project_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'project-icon-border-width', $this->get_att( 'project_icon_border_width' ) );
			$less_vars->add_pixel_number( 'project-icon-border-radius', $this->get_att( 'project_icon_border_radius' ) );
			$less_vars->add_keyword( 'project-icon-color', $this->get_att( 'project_icon_color', '~""' ) );
			$less_vars->add_keyword( 'project-icon-border-color', $this->get_att( 'project_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'project-icon-bg-color', $this->get_att( 'project_icon_bg_color', '~""' ) );

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
			return PRESSCORE_THEME_DIR . '/css/dynamic-less/shortcodes/dt-blog-carousel.less';
		}

		/**
		 * Return less imports.
		 *
		 * @return array
		 */
		protected function get_less_imports() {
			$dynamic_import_bottom = array();
			$dynamic_import_top = array();

			switch ( $this->atts['layout'] ) {
				case 'bottom_overlap':
					$dynamic_import_top[] = 'blog/bottom-overlap-layout-blog.less';
					break;
				case 'gradient_overlap':
					$dynamic_import_top[] = 'blog/gradient-overlap-layout-blog.less';
					break;
				case 'gradient_overlay':
					$dynamic_import_top[] = 'blog/gradient-overlay-layout-blog.less';
					break;
				case 'gradient_rollover':
					$dynamic_import_top[] = 'blog/content-rollover-layout-blog.less';
					break;
				case 'classic':
				default:
					$dynamic_import_top[] = 'blog/classic-layout-blog.less';
			}

			return compact( 'dynamic_import_top', 'dynamic_import_bottom' );
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {

			return $this->vc_inline_dummy( array(
				'class'  => 'dt_vc-blog_carousel',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_blog_carousel_editor_ico.gif', 131, 104 ),
				'title'  => _x( 'Blog Carousel', 'vc inline dummy', 'the7mk2' ),
				'style' => array( 'height' => 'auto' )
			) );
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
			// Apply offset only to the7 main query.
			if ( empty( $query->query['is_the7_main_query'] ) ) {
				return;
			}

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
		 * @param int      $found_posts
		 * @param WP_Query $query
		 *
		 * @return int
		 */
		public function fix_pagination( $found_posts, $query ) {
			// Apply offset only to the7 main query.
			if ( empty( $query->query['is_the7_main_query'] ) ) {
				return $found_posts;
			}

			return $found_posts - (int) $this->get_att( 'posts_offset' );
		}

		protected function get_posts_by_post_type( $post_type, $post_ids = array() ) {
			$posts_per_page = $this->get_posts_per_page();

			if ( is_string( $post_ids ) ) {
				$post_ids = presscore_sanitize_explode_string( $post_ids );
			}
			$post_ids = array_filter( $post_ids );
			$query_args = array(
				'orderby'            => $this->get_att( 'orderby' ),
				'order'              => $this->get_att( 'order' ),
				'posts_per_page'     => $posts_per_page,
				'post_type'          => $post_type,
				'post_status'        => 'publish',
				'paged'              => 1,
				'suppress_filters'   => false,
				'post__in'           => $post_ids,
				'is_the7_main_query' => true,
			);

			return new WP_Query( $query_args );
		}

		protected function get_posts_by_taxonomy( $post_type, $taxonomy, $taxonomy_terms = array(), $taxonomy_field = 'term_id' ) {
			$posts_per_page = $this->get_posts_per_page();

			if ( is_string( $taxonomy_terms ) ) {
				$taxonomy_terms = presscore_sanitize_explode_string( $taxonomy_terms );
			}
			$taxonomy_terms = array_filter( $taxonomy_terms );

			$query_args = array(
				'posts_per_page'     => $posts_per_page,
				'post_type'          => $post_type,
				'post_status'        => 'publish',
				'suppress_filters'   => false,
				'is_the7_main_query' => true,
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
		 * Return posts per page query var.
		 *
		 * @since 7.1.0
		 *
		 * @return int
		 */
		protected function get_posts_per_page() {
			$posts_per_page = (int) $this->get_att( 'dis_posts_total', '-1' );
			if ( $posts_per_page === -1 ) {
				return 99999;
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
	}

	// create shortcode
	DT_Shortcode_Blog_Carousel::get_instance()->add_shortcode();
endif;
