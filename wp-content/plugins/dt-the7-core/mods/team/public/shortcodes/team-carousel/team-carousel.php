<?php
/**
 * Team Carousel shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Team_Carousel', false ) ) :

	class DT_Shortcode_Team_Carousel extends The7pt_Shortcode_With_Inline_CSS {
		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Team_Shortcode_Carousel
		 */
		public static $instance = null;

		/**
		 * @return DT_Team_Shortcode_Carousel
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			$this->sc_name = 'dt_team_carousel';
			$this->unique_class_base = 'team-carousel-shortcode-id';
			$this->taxonomy = 'dt_team_category';
			$this->post_type = 'dt_team';

			$this->default_atts = array(
				'post_type' => 'category',
				'posts' => '',
				'posts_offset' => 0,
				'category' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'dis_posts_total' => '6',
				'img_border_radius' => '0px',
				'content_bg' => 'y',
				'custom_content_bg_color' => '',
				'post_content_paddings' => '20px 20px 20px 20px',
				'image_sizing' => 'resize',
				'resized_image_dimensions' => '1x1',
				'img_max_width' => '',
				'image_paddings' => '0px 0px 0px 0px',
				'image_scale_animation_on_hover' => 'y',
				'image_hover_bg_color' => 'y',
				'slide_to_scroll' => 'single',
				'slides_on_wide_desk' => '4',
				'slides_on_desk' => '4',
				'slides_on_lapt' => '4',
				'slides_on_h_tabs' => '3',
				'slides_on_v_tabs' => '2',
				'slides_on_mob' => '1',
				'adaptive_height' => 'n',
				'item_space' => '30',
				'stage_padding' => '0',
				'speed' => '600',
				'autoplay' => 'n',
				'autoplay_speed' => "6000",
				'content_alignment' => 'center',
				'post_title_font_style' => ':bold:',
				'post_title_font_size' => '',
				'post_title_line_height' => '',
				'custom_title_color' => '',
				'post_title_bottom_margin' => '0',
				'post_date' => 'y',
				'post_category' => 'y',
				'post_author' => 'y',
				'post_comments' => 'y',
				'team_position' => 'y',
				'team_position_font_style' => 'normal:bold:none',
				'team_position_font_size' => '',
				'team_position_line_height' => '',
				'team_position_color' => '',
				'team_position_bottom_margin' => '10px',
				'show_team_desc' => 'y',
				'post_content' => 'show_excerpt',
				'excerpt_words_limit' => '',
				'content_font_style' => '',
				'content_font_size' => '',
				'content_line_height' => '',
				'custom_content_color' => '',
				'content_bottom_margin' => '5px',
				'read_more_button' => 'default_link',
				'read_more_button_text' => 'View details',
				'show_soc_icon'	=> 'y',
				'show_icons_under' => 'under_position',
				'soc_icon_size'	=> '16px',
				'dt_soc_icon' => '',
				'soc_icon_bg_size' => '26px',
				'soc_icon_border_width'	=> '0',
				'soc_icon_border_radius'=> '100px',
				'soc_icon_color' => 'rgba(255,255,255,1)',
				'soc_icon_border_color'	=> '',
				'soc_icon_bg' => 'y',
				'soc_icon_bg_color'	=> '',
				'soc_icon_color_hover' => 'rgba(255,255,255,0.75)',
				'soc_icon_border_color_hover' => '',
				'soc_icon_bg_hover' => 'y',
				'soc_icon_bg_color_hover' => '',
				'soc_icon_gap' => '4px',
				'soc_icon_below_gap' => '15px',
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
				'l_arrows_mobile_h_position' => '10px',
				'r_arrows_mobile_h_position' => '10px',
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
				'css_dt_team_carousel' => '',
				'el_class' => '',
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

			echo '<div ' . $this->get_container_html_class( array( 'owl-carousel team-carousel-shortcode dt-team-shortcode dt-owl-carousel-call' ) ) . ' ' . $this->get_container_data_atts() . '>';
				$lazy_loading_enabled = presscore_lazy_loading_enabled();
				if ( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
					do_action('presscore_before_post');

					presscore_populate_team_config();

					echo '<div class="team-container">';

						if ( has_post_thumbnail() ) {

							$thumb_id = get_post_thumbnail_id();

							$teammate_thumb_args = array(
								'lazy_loading'  => $lazy_loading_enabled,
								'lazy_class'    => 'owl-lazy-load',
								'lazy_bg_class' => 'layzr-bg',
								'img_meta'		=> wp_get_attachment_image_src( $thumb_id, 'full' ),
								'img_id'		=> $thumb_id,
								'options'		=> presscore_set_image_dimesions(),
								'echo'			=> true,
								'wrap'			=> '<img %IMG_CLASS% %SRC% %SIZE% %IMG_TITLE% %ALT% />',
							);

							$config = Presscore_Config::get_instance();

							if ( 'post' == $config->get( 'post.open_as' ) ) {
								$teammate_thumb_args['wrap'] = '<a %HREF% %CLASS%>' . $teammate_thumb_args['wrap'] . '</a>';
								$teammate_thumb_args['class'] = 'rollover';
								$teammate_thumb_args['href'] = get_permalink();

							} else {
								$teammate_thumb_args['wrap'] = '<span>' . $teammate_thumb_args['wrap'] . '</span>';

							}

							$teammate_thumb_args = presscore_add_thumbnail_class_for_masonry( $teammate_thumb_args );

							echo '<div class="team-media">';

								dt_get_thumb_img( $teammate_thumb_args );

							echo '</div>';

						}

						echo '<div class="team-desc">';
							echo '<div class="team-author">';

								$config = presscore_config();

								// Output author name
								$title = get_the_title();
								if ( $title ) {
									if('post' == $config->get( 'post.open_as' )  ){
										$title = '<div class="team-author-name"><a href=" '.get_permalink().' ">' . $title . '</a></div>';
									}else{
										$title = '<div class="team-author-name">' . $title . '</div>';
									}

								} else {
									$title = '';

								}
								echo $title;

								// Output author position
								$position = $config->get( 'post.member.position' );
								if ( $position ) {
									$position = '<p>' . $position . '</p>';

								} else {
									$position = '';

								}
								echo $position;
							echo '</div>';

							// Output description 
							echo '<div class="team-content">' . $this->get_post_excerpt() . '</div>';

							$clear_links = array();
							$links = $config->get( 'post.preview.links' );
							if ( function_exists('presscore_get_team_links_array') ) {

								foreach ( presscore_get_team_links_array() as $id=>$data ) {

									if ( array_key_exists( $id , $links ) ) {
										$clear_links[] = presscore_get_social_icon( $id, $links[ $id ], $data['desc'] );
									}
								}

							}

							// Output soc links

							if ( !empty( $clear_links ) && $this->get_att( 'show_soc_icon' ) == 'y' ) {
								echo '<div class="soc-ico">' . implode( '', $clear_links ) . '</div>';
							}

							// Output view btn
							if($this->atts['read_more_button'] != 'off' && 'post' == $config->get( 'post.open_as' )  ){
								$details_btn_style = $this->get_att( 'read_more_button' );
								$details_btn_text = $this->get_att( 'read_more_button_text' );
								$details_btn_class = ('default_button' === $details_btn_style ? array( 'dt-btn-s', 'dt-btn' ) : array());
								echo DT_Blog_Shortcode_HTML::get_details_btn( $details_btn_style, $details_btn_text, $details_btn_class );
							}

						echo '</div>';
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


			if ( $this->get_flag( 'content_bg' ) ) {
				$class[] = 'content-bg-on';
			}

			if($this->atts['team_position'] === 'n'){
				$class[] = 'hide-team-position';
			}

			if ( $this->get_flag( 'image_scale_animation_on_hover' ) ) {
				$class[] = 'scale-img';
			}
			if ( !$this->get_flag( 'image_hover_bg_color' ) ) {
				$class[] = 'disable-bg-rollover';
			}

			if($this->atts['soc_icon_bg'] === 'y'){
				$class[] = 'dt-icon-bg-on';
			}else{
				$class[] = 'dt-icon-bg-off';
			};
			if($this->atts['arrow_icon_border'] === 'y'){
				$class[] = 'dt-arrow-border-on';
			}
			if($this->atts['arrow_icon_border_hover'] === 'y'){
				$class[] = 'dt-arrow-hover-border-on';
			}

			if($this->atts['soc_icon_bg_hover'] === 'y'){
				$class[] = 'dt-icon-hover-bg-on';
			}else{
				$class[] = 'dt-icon-hover-bg-off';
			};
			if($this->atts['show_icons_under'] === 'under_position'){
				$class[] = 'move-icons-under-position';
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
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_team_carousel'], ' ' );
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

			if ( 'n' === $this->atts['show_team_desc'] ) {
				return '';
			}

			//$post_back = $post;

			if ( 'show_content' === $this->atts['post_content'] ) {
				$excerpt = apply_filters( 'the_content', get_the_content() );
			} else {
				$length = absint( $this->atts['excerpt_words_limit'] );
				$excerpt = apply_filters( 'the7_shortcodeaware_excerpt', get_the_excerpt() );

				if ( $length ) {
					$excerpt = wp_trim_words( $excerpt, $length );
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

			$config->set( 'template', 'team' );

			$show_post_content = ( 'n' !== $this->get_att( 'show_team_desc' ) );
			$config->set( 'show_excerpts', $show_post_content );
			$config->set( 'post.preview.content.visible', $show_post_content );

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

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'team-carousel-shortcode.' . $this->get_unique_class(), '~"%s"' );


			$less_vars->add_pixel_or_percent_number( 'post-content-width', $this->get_att( 'bo_content_width' ) );
			$less_vars->add_pixel_number( 'post-content-top-overlap', $this->get_att( 'bo_content_overlap' ) );
			$less_vars->add_pixel_or_percent_number( 'post-content-overlap', $this->get_att( 'grovly_content_overlap' ) );

			$less_vars->add_keyword( 'post-content-bg', $this->get_att( 'custom_content_bg_color', '~""' ) );
			$less_vars->add_pixel_number( 'team-img-max-width', $this->get_att( 'img_max_width' ) );

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
			$less_vars->add_pixel_number( 'post-title-line-height', $this->get_att( 'post_title_line_height' ) );
			$less_vars->add_pixel_number( 'team-position-font-size', $this->get_att( 'team_position_font_size' ) );
			$less_vars->add_pixel_number( 'team-position-line-height', $this->get_att( 'team_position_line_height' ) );

			$less_vars->add_keyword( 'post-title-color', $this->get_att( 'custom_title_color', '~""' ) );
			$less_vars->add_keyword( 'team-position-color', $this->get_att( 'team_position_color', '~""' ) );
			$less_vars->add_keyword( 'post-content-color', $this->get_att( 'custom_content_color', '~""' ) );

			$less_vars->add_pixel_number( 'post-excerpt-font-size', $this->get_att( 'content_font_size' ) );
			$less_vars->add_pixel_number( 'post-excerpt-line-height', $this->get_att( 'content_line_height' ) );
			$less_vars->add_pixel_number( 'team-position-margin-bottom', $this->get_att( 'team_position_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-title-margin-bottom', $this->get_att( 'post_title_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-excerpt-margin-bottom', $this->get_att( 'content_bottom_margin' ) );
			
			$less_vars->add_font_style( array(
				'team-position-font-style',
				'team-position-font-weight',
				'team-position-text-transform',
			), $this->get_att( 'team_position_font_style' ) );
			$less_vars->add_font_style( array(
				'post-content-font-style',
				'post-content-font-weight',
				'post-content-text-transform',
			), $this->get_att( 'content_font_style' ) );

			$less_vars->add_pixel_number( 'soc-icon-size', $this->get_att( 'soc_icon_size' ) );
			$less_vars->add_pixel_number( 'soc-icon-bg-size', $this->get_att( 'soc_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'soc-icon-border-width', $this->get_att( 'soc_icon_border_width' ) );
			$less_vars->add_pixel_number( 'soc-icon-border-radius', $this->get_att( 'soc_icon_border_radius' ) );

			$less_vars->add_keyword( 'soc-icon-color', $this->get_att( 'soc_icon_color', '~""') );
			$less_vars->add_keyword( 'soc-icon-color-hover', $this->get_att( 'soc_icon_color_hover', '~""' ) );

			$less_vars->add_keyword( 'soc-icon-border-color', $this->get_att( 'soc_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'soc-icon-border-color-hover', $this->get_att( 'soc_icon_border_color_hover', '~""' ) );
			$less_vars->add_keyword( 'soc-icon-bg-color', $this->get_att( 'soc_icon_bg_color', '~""' ) );
			$less_vars->add_keyword( 'soc-icon-bg-color-hover', $this->get_att( 'soc_icon_bg_color_hover', '~""' ) );
			$less_vars->add_pixel_number( 'team-icon-gap', $this->get_att( 'soc_icon_gap' ) );
			$less_vars->add_pixel_number( 'team-icon-gap-below', $this->get_att( 'soc_icon_below_gap' ) );

			

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
				return get_template_directory() . '/css/dynamic-less/shortcodes/dt-team-carousel.less';
			}

			return The7PT()->plugin_path() . 'assets/css/shortcodes/dt-team-carousel.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return $this->vc_inline_dummy( array(
				'class'  => 'dt_team_carousel',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_team_carousel_editor_ico.gif', 133, 104 ),
				'title'  => _x( 'Team Carousel', 'vc inline dummy', 'dt-the7-core' ),
				'style' => array( 'height' => 'auto' )
			) );
		}

		/**
		 * Return posts query.
		 *
		 * @since 1.16.0
		 *
		 * @return WP_Query
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
				$query = $this->get_posts_by_post_type( 'dt_team', $this->get_att( 'posts' ) );
			} else {
				$category_terms = presscore_sanitize_explode_string( $this->get_att( 'category' ) );
				$category_field = ( is_numeric( $category_terms[0] ) ? 'term_id' : 'slug' );

				$query = $this->get_posts_by_taxonomy( 'dt_team', 'dt_team_category', $category_terms, $category_field );
			}

			remove_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
			remove_filter( 'found_posts', array( $this, 'fix_pagination' ), 1 );

			return $query;
		}

		/**
		 * Add offset to the posts query.
		 *
		 * @since 1.16.0
		 *
		 * @param WP_Query $query
		 */
		public function add_offset( &$query ) {
			// Apply offset only to the7 main query.
			if ( empty( $query->query['is_the7_main_query'] ) ) {
				return;
			}

			$offset  = (int) $this->atts['posts_offset'];
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
		 * @since 1.16.0
		 *
		 * @param int $found_posts
		 * @param WP_Query $query
		 *
		 * @return int
		 */
		public function fix_pagination( $found_posts, $query ) {
			// Apply offset only to the7 main query.
			if ( empty( $query->query['is_the7_main_query'] ) ) {
				return $found_posts;
			}

			return $found_posts - (int) $this->atts['posts_offset'];
		}

		/**
		 * Return posts per page.
		 *
		 * @since 1.16.0
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
	DT_Shortcode_Team_Carousel::get_instance()->add_shortcode();
endif;
