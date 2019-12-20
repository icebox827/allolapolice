<?php
/**
 * Photos Carousel shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Photos_Carousel', false ) ) :

	class DT_Shortcode_Photos_Carousel extends The7pt_Shortcode_With_Inline_CSS {
		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Photos_Shortcode_Carousel
		 */
		public static $instance = null;

		/**
		 * @return DT_Photos_Shortcode_Carousel
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			$this->sc_name = 'dt_photos_carousel';
			$this->unique_class_base = 'photos-carousel-shortcode-id';
			$this->taxonomy = 'dt_gallery_category';
			$this->post_type = 'dt_gallery';

			$this->default_atts = array(
				'post_type' => 'category',
				'category' => '',
				'posts' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'dis_posts_total' => '6',
				'hover_animation' => 'fade',
				'image_sizing' => 'resize',
				'resized_image_dimensions' => '1x1',
				'image_scale_animation_on_hover' => 'quick_scale',
				'image_hover_bg_color' => 'y',
				'image_border_radius'         	 => '0px',
				'image_decoration'   			 => 'none',
				'shadow_h_length'    			 => '0px',
				'shadow_v_length'    			 => '4px',
				'shadow_blur_radius' 			 => '12px',
				'shadow_spread'      			 => '3px',
				'shadow_color'       			 => 'rgba(0,0,0,.25)',
				'image_hover_bg_color' => 'default',
				'custom_rollover_bg_color'       => 'rgba(0,0,0,0.5)',
				'custom_rollover_bg_gradient'    => '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
				'slide_to_scroll' 					=> 'single',
				'slides_on_wide_desk' 				=> '6',
				'slides_on_desk' 					=> '6',
				'slides_on_lapt' 					=> '5',
				'slides_on_h_tabs' 					=> '4',
				'slides_on_v_tabs' 					=> '3',
				'slides_on_mob' 					=> '1',
				'item_space' 						=> '10',
				'stage_padding' 					=> '0',
				'speed' => '600',
				'autoplay' => 'n',
				'autoplay_speed' => "6000",
				'show_zoom'                      => 'y',
				'gallery_image_zoom_icon'        => 'icomoon-the7-font-the7-zoom-06',
				'project_icon_size'              => '32px',
				'dt_project_icon'                => '',
				'project_icon_bg_size'           => '44px',
				'project_icon_border_width'      => '0',
				'project_icon_border_radius'     => '100px',
				'project_icon_color'             => 'rgba(255,255,255,1)',
				'project_icon_border_color'      => '',
				'project_icon_bg'                => 'n',
				'project_icon_bg_color'          => 'rgba(255,255,255,0.3)',
				
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
				'css_dt_gallery_carousel'         => '',
				'el_class' => '',
			);
			parent::__construct();
		}
		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			$post_type = $this->get_att( 'post_type' );
			$media_items = array(0);

			//Hover icon
			$show_icon_zoom = '';
			if ( $this->get_att( 'show_zoom' ) === 'y' ) {
				$show_icon_zoom = '<span class="gallery-zoom-ico ' . esc_attr( $this->get_att( 'gallery_image_zoom_icon' ) ) . '"><span></span></span>';
			}
			

			echo '<div ' . $this->get_container_html_class( array( 'owl-carousel gallery-carousel-shortcode gallery-shortcode dt-gallery-container album-gallery-shortcode dt-owl-carousel-call' ) ) . ' ' . $this->get_container_data_atts() . '>';

				presscore_populate_album_post_config();

				$dt_query = $this->get_albums_attachments( array(
					'orderby' => $this->atts['orderby'],
					'order' => $this->atts['order'],
					'number' => $this->atts['dis_posts_total'],
					'category' => $this->atts['category']
				) );
				$post_class_array = array(
					'post',
					'visible',
				);
				$lazy_loading_enabled = presscore_lazy_loading_enabled();
				while( $dt_query->have_posts() ) { 
					$dt_query->the_post();
					$img_id = get_the_ID();
					
					echo '<article ' . $this->post_class( $post_class_array ) . '>';

						$content = presscore_mod_albums_get_photo_description();
						$img_class = 'alignnone rollover';
						if ( presscore_get_image_video_url( $img_id ) ) {
							$img_class .= ' rollover-video';
						} else if ( presscore_get_image_link( $img_id ) ) {
							// Do nothing.
						} else {
							$img_class .= ' rollover-zoom';
						}

						$thumb_meta = wp_get_attachment_image_src( $img_id, 'full' );
						$thumb_title = presscore_image_title_enabled( $img_id ) ? get_the_title() : false;

						$thumb_args = array(
							'lazy_loading'  => $lazy_loading_enabled,
							'lazy_class'    => 'owl-lazy-load',
							'lazy_bg_class' => 'layzr-bg',
							'echo'				=> false,
							'img_meta' 			=> $thumb_meta,
							'img_id'			=> $img_id,
							'img_class' 		=> 'preload-me',
							'class'				=> ' rollover-click-target rollover',
							'img_description'	=> get_the_content(),
							'title'				=> $thumb_title,
							'options'			=> presscore_set_image_dimesions(),
							'wrap'				=> '<a %HREF% %CLASS% %TITLE% data-dt-img-description="%RAW_IMG_DESCRIPTION%"  data-large_image_width="' . $thumb_meta[1] . '" data-large_image_height = "' . $thumb_meta[2]. '" %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /><span class="gallery-rollover">' . $show_icon_zoom . '</span></a>'
						);

						$video_url = presscore_get_image_video_url( $img_id );
						$image_link = presscore_get_image_link( $img_id );

						if ( $video_url ) {
							$thumb_args['class'] .= ' dt-pswp-item pswp-video';
							$thumb_args['href'] = $video_url;
						} else if ( $image_link ) {
							$thumb_args['href'] = $image_link;
							$thumb_args['custom'] = ' target="_blank"';
						} else {
							$thumb_args['class'] .= ' dt-pswp-item';
						}

						// set proportion
						$thumb_args = presscore_add_thumbnail_class_for_masonry( $thumb_args );

						if ( of_get_option( 'social_buttons-photo' ) ) {
							$thumb_args = presscore_mod_albums_share_buttons_link( $thumb_args );
						}

						$image =  dt_get_thumb_img( $thumb_args );
					
						$template_args = array(
							'image'				=> $image,
							'content'			=> $content,
							'figure_class'		=> 'links-hovers-disabled',
						);
						echo $image;
						

					echo '</article>';
				}
			echo '</div>';
			presscore_add_lazy_load_attrs();
			do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
		}
		
		protected function get_container_html_class( $class = array() ) {
			$el_class = $this->atts['el_class'];
			$config = presscore_config();
			// Unique class.
			$class[] = $this->get_unique_class();
			

			if ( $this->atts['image_scale_animation_on_hover']  === 'quick_scale' ) {
				$class[] = 'quick-scale-img';
			}else if($this->atts['image_scale_animation_on_hover']  === 'slow_scale') {
				$class[] = 'scale-img';
			}
			if ( 'disabled' != $this->get_att( 'image_hover_bg_color' ) ) {
				$class[] = 'enable-bg-rollover';
			}
			if ( ! ( $this->get_flag( 'post_date' ) || $this->get_flag( 'post_category' ) || $this->get_flag( 'post_comments' ) || $this->get_flag( 'post_author' ) ) ) {
				$class[] = 'meta-info-off';
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
			if ( $this->get_flag( 'project_icon_bg' ) ) {
				$class[] = 'dt-icon-bg-on';
			} else {
				$class[] = 'dt-icon-bg-off';
			}
			
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
			if ( 'shadow' === $this->atts['image_decoration'] ) {
				$class[] = 'enable-img-shadow';
			}
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_gallery_carousel'], ' ' );
			};
			$class[] = presscore_tpl_get_hover_anim_class( $config->get( 'post.preview.hover.animation' ) );
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
		protected function get_albums_attachments( $args = array() ) {
			$post_type = $this->get_att( 'post_type' );
			$defaults = array(
				'orderby' => 'date',
				'order' => 'DESC',
				'number' => false,
				'category' => array(),
				//'select' => 'all'
			);

			$args = wp_parse_args( $args, $defaults );

			if ( 'posts' === $post_type ) {
				$page_query = $this->get_posts_by_post_type( 'dt_gallery', $this->get_att( 'posts' ) );
				
			} else {
				$category_terms = presscore_sanitize_explode_string( $this->get_att( 'category' ) );
				$category_field = ( is_numeric( $category_terms[0] ) ? 'term_id' : 'slug' );

				$page_query = $this->get_posts_by_taxonomy( 'dt_gallery', 'dt_gallery_category', $category_terms, $category_field );
			}
			//$page_query = $this->get_posts_by_terms( $args );

			$media_items = array(0);
			if ( $page_query->have_posts() ) {
				$media_items = array();
				foreach ( $page_query->posts as $gallery ) {
					$gallery_media = get_post_meta( $gallery->ID, '_dt_album_media_items', true );
					if ( is_array( $gallery_media ) ) {
						$media_items = array_merge( $media_items, $gallery_media );
					}
				}
			}

			$media_items = array_unique( $media_items );

			$media_args = array(
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'post_status' => 'inherit',
				'post__in' => $media_items,
				'orderby' => 'post__in',
				'suppress_filters'  => false,
				'posts_per_page' => '-1',
			);
			$pagination_mode = $this->get_att( 'loading_mode' );
			$posts_per_page = $this->atts['dis_posts_total'];

			if ( $args['number'] ) {
				$media_args['posts_per_page'] = intval( $args['number'] );
			}

			return new WP_Query( $media_args );
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
				'col-gap' => $this->atts['item_space'],
				'stage-padding' => $this->atts['stage_padding'],
				'speed' => $this->atts['speed'],
				'autoplay' => ($this->atts['autoplay'] === 'y') ? 'true' : 'false',
				'autoplay_speed' => $this->atts['autoplay_speed'],
				'arrows' => ($this->atts['arrows'] === 'y') ? 'true' : 'false',
				'bullet' => ($this->atts['show_bullets'] === 'y') ? 'true' : 'false',
				'next-icon'=> $this->atts['next_icon'],
				'prev-icon'=> $this->atts['prev_icon'],
				'img-shadow-size'=> $this->atts['shadow_blur_radius'],
				'img-shadow-spread'=> $this->atts['shadow_spread']
			);

			return presscore_get_inlide_data_attr( $data_atts );
		}
		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();
			
			$config->set( 'post.preview.hover.animation', $this->get_att( 'hover_animation' ) );
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

			// Get terms ids.
			$terms = get_terms( array(
				'taxonomy' => 'dt_gallery_category',
				'slug'     => presscore_sanitize_explode_string( $this->get_att( 'category' ) ),
				'fields'   => 'ids',
			) );

			$config->set( 'display', array(
				'type'      => 'dt_gallery_category',
				'terms_ids' => $terms,
				'select'    => ( $terms ? 'only' : 'all' ),
			) );
		}
		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', '' . $this->get_unique_class(), '~"%s"' );


			$less_vars->add_pixel_number( 'media-image-border-radius', $this->get_att( 'image_border_radius' ) );

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

			$less_vars->add_pixel_number( 'item-gap',$this->get_att('item_space' ));

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

			$shadow_style = '';
			if ( 'shadow' === $this->atts['image_decoration'] ) {
				$shadow_style = join( ' ', array(
						$this->atts['shadow_h_length'],
						$this->atts['shadow_v_length'],
						$this->atts['shadow_blur_radius'],
						$this->atts['shadow_spread'],
						$this->atts['shadow_color'],
					) );
			}
			$less_vars->add_keyword( 'portfolio-img-shadow', $shadow_style );
			$less_vars->add_pixel_number( 'shadow-v-length',abs($this->get_att('shadow_v_length' )));

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

			return The7PT()->plugin_path() . 'assets/css/shortcodes/gallery-carousel.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {

			return $this->vc_inline_dummy( array(
				'class'  => 'dt_vc-photos_carousel',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_photo_carousel_editor_ico.gif', 131, 104 ),
				'title'  => _x( 'Photos Carousel', 'vc inline dummy', 'dt-the7-core' ),
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
	}

	// create shortcode
	DT_Shortcode_Photos_Carousel::get_instance()->add_shortcode();
endif;
