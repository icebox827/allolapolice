<?php
/**
 * Photos Carousel shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Media_Gallery_Carousel', false ) ) :

	class DT_Shortcode_Media_Gallery_Carousel extends DT_Shortcode_With_Inline_Css {
		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Media_Gallery_Shortcode_Carousel
		 */
		public static $instance = null;

		/**
		 * @return DT_Media_Gallery_Shortcode_Carousel
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			$this->sc_name = 'dt_media_gallery_carousel';
			$this->unique_class_base = 'gallery-carousel-shortcode-id';

			$this->default_atts = array(
				'include'            => 'include',
				'hover_animation' => 'fade',
				'image_sizing' => 'resize',
				'resized_image_dimensions' => '1x1',
				'image_scale_animation_on_hover' => 'quick_scale',
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
				'slide_to_scroll' => 'single',
				'slides_on_wide_desk' => '6',
				'slides_on_desk' => '6',
				'slides_on_lapt' => '5',
				'slides_on_h_tabs' => '4',
				'slides_on_v_tabs' => '3',
				'slides_on_mob' => '1',
				'item_space' => '10',
				'stage_padding' => '0',
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
			
			//Hover icon
			$show_icon_zoom = '';
			if ( $this->get_att( 'show_zoom' ) === 'y' ) {
				$show_icon_zoom = '<span class="gallery-zoom-ico ' . esc_attr( $this->get_att( 'gallery_image_zoom_icon' ) ) . '"><span></span></span>';
			}
			$data_atts_array = array(
				//'post-limit'      => (int) $data_post_limit,
				//'pagination-mode' => esc_attr( $data_pagination_mode ),
			);

			$config = presscore_config();
			$image_is_wide = ( 'wide' === $config->get( 'post.preview.width' ) && ! $config->get( 'all_the_same_width' ) );

			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$data_atts_array          = the7_shortcode_add_responsive_columns_data_attributes(
					$data_atts_array,
					$this->get_att( 'bwb_columns' )
				);
				$thumb_img_resize_options = the7_calculate_bwb_image_resize_options(
					DT_VCResponsiveColumnsParam::decode_columns( $this->get_att( 'bwb_columns' ) ),
					$this->get_att( 'gap_between_posts' ),
					$image_is_wide
				);
			} else {
				$thumb_img_resize_options = the7_calculate_columns_based_image_resize_options(
					$this->get_att( 'pwb_column_min_width' ),
					$config->get( 'template.content.width' ),
					$this->get_att( 'pwb_columns' ),
					$image_is_wide
				);
			}

			$data_atts_str = presscore_get_inlide_data_attr( $data_atts_array );
			

			echo '<div ' . $this->get_container_html_class( array( 'owl-carousel gallery-carousel-shortcode gallery-shortcode  dt-gallery-container dt-owl-carousel-call' ) ) . ' ' . $this->get_container_data_atts() . '>';

			$image_ids = explode( ',', $this->get_att( 'include' ) );
			$query     = new WP_Query( array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post__in'       => $image_ids,
				'posts_per_page' => '-1',
				'orderby'        => 'post__in',
			) );

			global $post;

			$lazy_loading_enabled = presscore_lazy_loading_enabled();
			while ( $query->have_posts() ) {
				$query->the_post();


				$image_data_array = wp_get_attachment_image_src( $post->ID, 'full' );
				if ( ! $image_data_array ) {
					continue;
				}

				$img_title = '';
				$video_url = esc_url( get_post_meta( $post->ID, 'dt-video-url', true ) );
				if ( presscore_image_title_enabled( $post->ID ) ) {
					$img_title = get_the_title();
				}

				echo '<div ' . presscore_tpl_masonry_item_wrap_data_attr() . '>';

				$anchor_data_atts = presscore_get_inlide_data_attr( array(
					'large_image_width'  => esc_attr( $image_data_array[1] ),
					'large_image_height' => esc_attr( $image_data_array[2] ),
					'dt-img-description' => esc_attr( get_the_content() ),
				) );
				if ( $video_url ) {
					$thumb_args = array(
						'lazy_loading'  => $lazy_loading_enabled,
						'lazy_class'    => 'owl-lazy-load',
						'lazy_bg_class' => 'layzr-bg',
						'wrap'     => '<figure class="post"><a %HREF% %CLASS% %CUSTOM% %TITLE%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /><span class="gallery-rollover">' . $show_icon_zoom . '</span></a></figure>',
						'href'     => $video_url,
						'img_meta' => $image_data_array,
						'class'    => 'rollover dt-pswp-item pswp-video',
						'title'    => $img_title,
						'alt'      => get_post_meta( $post->ID, '_wp_attachment_image_alt', true ),
						'echo'     => true,
						'options'  => $thumb_img_resize_options,
						'custom'   => $anchor_data_atts,
					);
				} else {

					$thumb_args = array(
						'lazy_loading'  => $lazy_loading_enabled,
						'lazy_class'    => 'owl-lazy-load',
						'lazy_bg_class' => 'layzr-bg',
						'wrap'     => '<figure class="post"><a %HREF% %CLASS% %CUSTOM% %TITLE%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /><span class="gallery-rollover">' . $show_icon_zoom . '</span></a></figure>',
						'img_meta' => $image_data_array,
						'class'    => 'rollover dt-pswp-item',
						'title'    => $img_title,
						'alt'      => get_post_meta( $post->ID, '_wp_attachment_image_alt', true ),
						'echo'     => true,
						'options'  => $thumb_img_resize_options,
						'custom'   => $anchor_data_atts,
					);
				}
				if ( $this->get_att( 'image_sizing' ) === 'resize' ) {
					list( $thumb_width, $thumb_height ) = the7_shortcode_decode_image_dimension( $this->get_att( 'resized_image_dimensions' ) );
					$thumb_args['prop'] = the7_get_image_proportion( $thumb_width, $thumb_height );
				}

				dt_get_thumb_img( $thumb_args );

				echo '</div>';
			}
			presscore_add_lazy_load_attrs();
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
			if($this->atts['arrow_icon_border'] === 'y'){
				$class[] = 'dt-arrow-border-on';
			}
			if($this->atts['arrow_icon_border_hover'] === 'y'){
				$class[] = 'dt-arrow-hover-border-on';
			}
			
			if ( 'shadow' === $this->atts['image_decoration'] ) {
				$class[] = 'enable-img-shadow';
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
			if ( $this->get_att( 'arrow_bg_color' ) === $this->get_att( 'arrow_bg_color_hover' ) ) {
				$class[] = 'disable-arrows-hover-bg';
			};

			if($this->atts['arrows_bg_hover_show'] === 'y'){
				$class[] = 'arrows-hover-bg-on';
			}else{
				$class[] = 'arrows-hover-bg-off';
			};
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_gallery_carousel'], ' ' );
			};
			$class[] = presscore_tpl_get_hover_anim_class( $config->get( 'post.preview.hover.animation' ) );
			$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
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

			$config->set( 'load_style', 'default' );

			
			$config->set( 'post.preview.hover.animation', $this->get_att( 'hover_animation' ) );
			$config->set( 'image_layout', ( 'resize' === $this->get_att( 'image_sizing' ) ? $this->get_att( 'image_sizing' ) : 'original' ) );
		

		}
		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'gallery-carousel-shortcode.' . $this->get_unique_class(), '~"%s"' );
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
			return get_template_directory(). '/css/dynamic-less/shortcodes/gallery-carousel.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {

			return $this->vc_inline_dummy( array(
				'class'  => 'dt_vc_sc_media_gallery_carousel',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_photo_carousel_editor_ico.gif', 131, 104 ),
				'title'  => _x( 'Media Gallery Carousel', 'vc inline dummy', 'the7mk2' ),
				'style' => array( 'height' => 'auto' )
			) );
		}
	}

	// create shortcode
	DT_Shortcode_Media_Gallery_Carousel::get_instance()->add_shortcode();
endif;
