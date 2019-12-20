<?php
/**
 * Fancy image shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_FancyImage', false ) ) {
	class DT_Shortcode_FancyImage extends DT_Shortcode_With_Inline_Css {

		static protected $instance;

		protected $content = null;

		public static function get_instance() {
			if ( !self::$instance ) {
				self::$instance = new DT_Shortcode_FancyImage();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name           = 'dt_fancy_image';
			$this->unique_class_base = 'shortcode-single-image';
			$this->default_atts      = array(
				'type'                        => 'uploaded_image',
				'image_id'                    => '',
				'image'                       => '',
				'image_alt'                   => '',
				'image_link'                  => '',
				'image_dimensions'            => '',
				'media'                       => '',
				'onclick'                     => 'none',
				'custom_link_target'          => '_self',
				'align'                       => 'center',
				'animation'                   => 'none',
				'width'                       => '500',
				'height'                      => '',
				'border_radius'               => '',
				'image_decoration'            => 'none',
				'shadow_h_length'             => '5px',
				'shadow_v_length'             => '5px',
				'shadow_blur_radius'          => '5px',
				'shadow_spread'               => '5px',
				'shadow_color'                => 'rgba(0,0,0,.6)',
				'show_zoom'					  => 'n',
				'dt_icon'                     => 'Defaults-heart',
				'rollover_icon_size'		  => '32px',
				'rollover_icon_color'		  => 'rgba(255,255,255,1)',
				'rollover_icon_bg_size'		  => '44px',
				'rollover_icon_bg'			  => 'n',
				'rollover_icon_bg_color'	  => 'rgba(255,255,255,0.3)',
				'rollover_icon_border_radius' => '100px',
				'rollover_icon_border_width'  => '0px',
				'rollover_icon_border_color'  => '',
				'image_hover_bg_color'        => 'default',
				'image_scale_animation_on_hover' => 'disabled',
				'custom_rollover_bg_color'    => 'rgba(0,0,0,0.5)',
				'custom_rollover_bg_gradient' => '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
				'extra_class'                 => '',
				'css'                         => '',
				'nofollow'                    => '',
				'caption'                     => 'description',

				// Deprecated atts.
				'margin_top'                  => '0',
				'margin_bottom'               => '0',
				'margin_right'                => '0',
				'margin_left'                 => '0',
				'lightbox'                    => '',
			);
		}

		public function do_shortcode( $atts, $content = null ) {
			// Temporary fix.
			$this->get_unique_class();

			$this->atts = $this->sanitize_attributes( $this->atts );
			// For custom caption.
			if ( $this->atts['caption'] !== 'off' ) {
				$this->content = $this->sanitize_content( $content );
			}

			// override shortcode atts for uploaded image
			if ( $this->is_uploaded_image() ) {

				$image_id = $this->atts['image_id'];
				$image_src = wp_get_attachment_image_src( $image_id, 'full' );

				if ( ! $image_src ) {
					return '';
				}

				if ( get_post_meta( $image_id, 'dt-img-hide-title', true ) ) {
					$this->atts['image_title'] = '';
				} else {
					$this->atts['image_title'] = get_the_title( $image_id );
				}

				$this->atts['image'] = $image_src[0];
				$this->atts['_image_width'] = $image_src[1];
				$this->atts['_image_height'] = $image_src[2];
				$this->atts['image_alt'] = esc_attr( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) );
				$this->atts['media'] = esc_url( get_post_meta( $image_id, 'dt-video-url', true ) );

				// Caption logic.
				if ( $this->atts['caption'] === 'on' ) {
					$this->content = $this->sanitize_content( get_post_field( 'post_excerpt', $image_id ) );
				} elseif ( $this->atts['caption'] === 'description' ) {
					$this->content = $this->sanitize_content( get_post_field( 'post_content', $image_id ) );
				}
			} else {

				// Do not use height attribute for images from url.
				$this->atts['height'] = 0;
			}

			$output = '';

			$output .= '<div ' . $this->get_container_html_class( 'shortcode-single-image-wrap' ) . $this->get_container_inline_style()  . presscore_get_share_buttons_for_prettyphoto( 'photo' ) .  '>';
				$output .= $this->get_media();
				$output .= $this->get_caption();
			$output .= '</div>';

			echo $output;
		}

		protected function get_container_html_class( $custom_class = '' ) {
			$class = array();

			if ( $custom_class ) {
				$class[] = $custom_class;
			}

			$class[] = $this->get_unique_class();

			switch ( $this->atts['align'] ) {
				case 'left': $class[] = 'alignleft'; break;
				case 'right': $class[] = 'alignright'; break;
				case 'centre':
				case 'center': $class[] = 'alignnone'; break;
			}

			if ( presscore_shortcode_animation_on( $this->atts['animation'] ) ) {
				$class[] = presscore_get_shortcode_animation_html_class( $this->atts['animation'] );
			}

			if ( $this->content ) {
				$class[] = 'caption-on';
			}

			$image_src = $this->atts['image'];
			$video_url = $this->atts['media'];
			$lightbox = ( 'lightbox' === $this->atts['onclick'] );

			if ( ( $image_src && $video_url && ! $lightbox ) || ( ! $image_src && $video_url ) ) {
				$class[] = 'shortcode-single-video';
			}

			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css'], ' ' );
			}
			if ( 'disabled' !=  $this->atts[ 'image_hover_bg_color' ] ) {
				$class[] = 'enable-bg-rollover';
			}else {
				$class[] = 'disable-bg-rollover';
			}
			if ( $this->get_flag( 'rollover_icon_bg' ) ) {
				$class[] = 'dt-icon-bg-on';
			} else {
				$class[] = 'dt-icon-bg-off';
			}
			if ( $this->atts['image_scale_animation_on_hover']  === 'quick_scale' ) {
				$class[] = 'quick-scale-img';
			}else if($this->atts['image_scale_animation_on_hover']  === 'slow_scale') {
				$class[] = 'scale-img';
			}

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		}

		protected function get_container_inline_style() {
			$style = array();

			if ( $this->is_compatibility_mode() ) {
				$style['margin-top'] = $this->atts['margin_top'] . 'px';
				$style['margin-bottom'] = $this->atts['margin_bottom'] . 'px';
				$style['margin-left'] = $this->atts['margin_left'] . 'px';
				$style['margin-right'] = $this->atts['margin_right'] . 'px';

				if ( $this->atts['width'] ) {
					$style['width'] = $this->atts['width'] . 'px';
				}
			}

			/**
			 * @see html-helpers.php
			 */
			return ' ' . presscore_get_inline_style_attr( $style );
		}

		protected function render_video_in_lightbox( $args = array() ) {
			$output = '';
			$class = '';

			if ( $this->lazy_loading_on() ) {
				$class .= 'layzr-bg ';
			}
			$dt_icon_attr = esc_attr( $this->atts['dt_icon'] );
			$dt_icon = str_replace( 'dt-icon-', '', $dt_icon_attr );
			static $social_icons = null;

			if ( !$social_icons ) {
				$social_icons = presscore_get_social_icons_data();
			}
			if ( array_key_exists( $dt_icon, $social_icons ) ) {
				$title = $title ? $title : $social_icons[ $dt_icon ];
				$icon_class = "soc-font-icon {$dt_icon_attr}";
			} else {
				$icon_class = $dt_icon_attr;
			}

			if ( $args['rollover'] ) {
				$output .= '<div class="' . $class . 'rollover-video" style="' . $this->image_inline_style() . '">';
					$output .= $args['image_html'];
					$output .= '<a class="video-icon dt-pswp-item pswp-video" href="' . $args['href'] . '" title="' . $args['title'] . '" data-dt-img-description="' . $args['description'] . '">';
						if ( $this->get_att( 'show_zoom' ) === 'y' ) {
							$output .= '<span class=" '. esc_attr( 'rollover-icon ' . $icon_class ).'"></span>';
						};
					$output .= '</a>';
				$output .= '</div>';
			} else {
				$output .= '<a class="' . $class . 'dt-pswp-item pswp-video" href="' . $args['href'] . '" title="' . $args['title'] . '" data-dt-img-description="' . $args['description'] . '">';
					$output .= $args['image_html'];
				$output .= '</a>';
			}

			return $output;
		}

		protected function render_video( $video_url, $width = null, $height = null ) {
			return dt_get_embed( $video_url, $width, $height );
		}

		protected function extract_dimensions( $dimensions ) {
			$dimensions = str_replace( ' ', '', $dimensions );
			$matches = null;

			if ( preg_match( '/(\d+)x(\d+)/', $dimensions, $matches ) ) {
				return array(
					$matches[1],
					$matches[2],
				);
			}

			return false;
		}

		protected function lazy_loading_on() {
			return function_exists( 'presscore_lazy_loading_enabled' ) && presscore_lazy_loading_enabled();
		}

		protected function image_inline_style() {
			$style = array();

			if ( 'shadow' === $this->atts['image_decoration'] ) {
				$shadow_style = join( ' ', array(
					$this->atts['shadow_h_length'],
					$this->atts['shadow_v_length'],
					$this->atts['shadow_blur_radius'],
					$this->atts['shadow_spread'],
					$this->atts['shadow_color'],
				) );

				$style['-webkit-box-shadow'] = $style['box-shadow'] = $shadow_style;
			}

			if ( $this->atts['border_radius'] ) {
				$style['border-radius'] = $this->atts['border_radius'] . 'px';
			}

			return esc_attr( implode( ' ', presscore_convert_indexed2numeric_array( ':', $style, '', '%s;' ) ) );
		}

		protected function render_resized_image( $args = array() ) {
			$thumb_args = array(
				'wrap' => '<img %IMG_CLASS% %SRC% %SIZE% %CUSTOM% %ALT% />',
				'img_meta' => array( $args['src'], $args['width'], $args['height'] ),
				'alt' => $args['alt'],
				'echo' => false,
				'options' => ( isset( $args['resize_to'] ) ? $args['resize_to'] : array() ),
				'custom' => sprintf( 'data-dt-location="%s"', esc_attr( $args['permalink'] ) ),
			);

			if ( ! $this->is_hover_enabled() ) {
				$thumb_args['custom'] .= sprintf( ' style="%s"', $this->image_inline_style() );
			}

			return dt_get_thumb_img( $thumb_args );
		}

		protected function render_image( $args = array() ) {
			$hwstring = ( $args['width'] && $args['height'] ? image_hwstring( $args['width'], $args['height'] ) : '' );
			$style = '';
			if ( ! $this->is_hover_enabled() ) {
				$style = $this->image_inline_style();
			}

			if ( $this->lazy_loading_on() ) {
				return presscore_get_lazy_image( array( array( $args['src'], $args['width'], $args['height'] ) ), $args['width'], $args['height'], array( 'alt' => $args['alt'], 'style' => $style, 'dt-data-location' => $args['permalink'] ) );
			} else {
				return '<img style="' . $style . '" src="' . $args['src'] . '" srcset="' . $args['src'] . ' ' . $args['width'] . 'w" alt="' . $args['alt'] . '" ' . $hwstring . ' data-dt-location="' . esc_attr( $args['permalink'] ) . '"/>';
			}
		}

		protected function render_image_in_lightbox( $args = array() ) {
			$output = '';

			$dt_icon_attr = esc_attr( $this->atts['dt_icon'] );
			$dt_icon = str_replace( 'dt-icon-', '', $dt_icon_attr );
			static $social_icons = null;

			if ( !$social_icons ) {
				$social_icons = presscore_get_social_icons_data();
			}
			if ( array_key_exists( $dt_icon, $social_icons ) ) {
				$title = $title ? $title : $social_icons[ $dt_icon ];
				$icon_class = "soc-font-icon {$dt_icon_attr}";
			} else {
				$icon_class = $dt_icon_attr;
			}

			$style = '';
			if ( $args['rollover'] ) {
				$style = $this->image_inline_style();
			}
			 $image_id = $this->atts['image_id'];
			// 	$image_src = wp_get_attachment_image_src( $image_id, 'full' );

			$output .= '<a class="' . ( $this->lazy_loading_on() ? 'layzr-bg ' : '' ) . ( $args['rollover'] ? 'rollover rollover-zoom ' : '' ) . 'dt-pswp-item pswp-image" href="' . $args['href'] . '" title="' . $args['title'] . '" data-dt-img-description="' . $args['description'] . '" data-large_image_width="' . $args['image_width'] . '" data-large_image_height = "' . $args['image_height']. '"  style="' . $style . '">';
				$output .= $args['image_html'];
				if ( $this->get_att( 'show_zoom' ) === 'y' ) {
					$output .= '<span class=" '. esc_attr( 'rollover-icon ' . $icon_class ).'"></span>';
				}
			$output .= '</a>';

			return $output;
		}

		protected function wrap_media( $media, $wrap_class = '' ) {
			$output = '';

			if ( $media ) {

				$class = '';
				if ( $this->atts['extra_class'] ) {
					$class .= ' ' . esc_attr( $this->atts['extra_class'] );
				}
				

				$style = '';
				if ( $this->atts['border_radius'] ) {
					$style .= 'border-radius:' . $this->atts['border_radius'] . 'px;';
				}

				$output .= '<div class="shortcode-single-image' . $class . '">';
					$output .= '<div class="fancy-media-wrap' . ( $wrap_class ? ' ' . esc_attr( $wrap_class ) : '' ) . '" style="' . esc_attr( $style ) . '">';
						$output .= $media;
					$output .= '</div>';
				$output .= '</div>';
			}

			return $output;
		}

		protected function get_caption() {
			$caption = '';
			if ( $this->content ) {
				$caption = '<div class="shortcode-single-caption">' . $this->content . '</div>';
			}
			return $caption;
		}

		protected function sanitize_attributes( $clear_atts ) {
			$clear_atts['type'] = sanitize_key( $clear_atts['type'] );
			$clear_atts['align'] = sanitize_key( $clear_atts['align'] );

			// artificial shortcode attr
			$clear_atts['image_alt'] = $clear_atts['image_title'] = esc_attr( $clear_atts['image_alt'] );

			$clear_atts['image'] = esc_url( $clear_atts['image'] );
			$clear_atts['media'] = esc_url( $clear_atts['media'] );
			$clear_atts['image_link'] = esc_url( $clear_atts['image_link'] );

			// Back compatibility.
			if ( apply_filters( 'dt_sanitize_flag', $clear_atts['lightbox'] ) ) {
				$clear_atts['onclick'] = 'lightbox';
			}

			$clear_atts['width'] = absint( $clear_atts['width'] );
			$clear_atts['height'] = absint( $clear_atts['height'] );
			$clear_atts['border_radius'] = absint( $clear_atts['border_radius'] );
			$clear_atts['image_id'] = absint( $clear_atts['image_id'] );
			$clear_atts['margin_top'] = intval( $clear_atts['margin_top'] );
			$clear_atts['margin_bottom'] = intval( $clear_atts['margin_bottom'] );
			$clear_atts['margin_right'] = intval( $clear_atts['margin_right'] );
			$clear_atts['margin_left'] = intval( $clear_atts['margin_left'] );

			$image_dimensions = $this->extract_dimensions( $clear_atts['image_dimensions'] );
			if ( ! $image_dimensions ) {
				$image_dimensions = array( 0, 0 );
			}

			$clear_atts['_image_width'] = ( $image_dimensions[0] ? $image_dimensions[0] : $clear_atts['width'] );
			$clear_atts['_image_height'] = $image_dimensions[1];

			return $clear_atts;
		}

		protected function sanitize_content( $content ) {
			return strip_shortcodes( $content );
		}

		protected function is_uploaded_image() {
			return ( 'uploaded_image' == $this->atts['type'] );
		}

		protected function is_image_with_link() {
			return ( 'custom_link' === $this->atts['onclick'] );
		}

		protected function is_hover_enabled() {
			return $this->atts['onclick'] !== 'none';
		}

		protected function is_compatibility_mode() {
			return ( ! $this->atts['css'] );
		}

		protected function get_media() {
			$output = '';
			$wrap_class = '';
			$video_url = $this->atts['media'];
			$image_src = $this->atts['image'];
			$dt_icon_attr = esc_attr( $this->atts['dt_icon'] );
			$dt_icon = str_replace( 'dt-icon-', '', $dt_icon_attr );
			static $social_icons = null;

			if ( !$social_icons ) {
				$social_icons = presscore_get_social_icons_data();
			}
			if ( array_key_exists( $dt_icon, $social_icons ) ) {
				$title = $title ? $title : $social_icons[ $dt_icon ];
				$icon_class = "soc-font-icon {$dt_icon_attr}";
			} else {
				$icon_class = $dt_icon_attr;
			}

			if ( $this->is_uploaded_image() ) {
				$image_html = $this->render_resized_image( array(
					'src' => $image_src,
					'alt' => $this->atts['image_alt'],
					'width' => $this->atts['_image_width'],
					'height' => $this->atts['_image_height'],
					'resize_to' => array( 'w' => $this->atts['width'], 'h' => $this->atts['height'] ),
					'permalink' => get_permalink( $this->atts['image_id'] ),
				) );

			} else {
				$image_html = $this->render_image( array(
					'src' => $image_src,
					'alt' => $this->atts['image_alt'],
					'width' => $this->atts['_image_width'],
					'height' => $this->atts['_image_height'],
					'permalink' => $image_src,
				) );
			}

			if ( $video_url && $image_src ) {

				if ( 'lightbox' === $this->atts['onclick'] ) {

					$output = $this->render_video_in_lightbox( array(
						'image_html' => $image_html,
						'href' => $video_url,
						'title' => $this->atts['image_title'],
						'description' => $this->content,
						'rollover' => $this->is_hover_enabled()
					) );

				} else {

					$output = $this->render_video( $video_url, $this->atts['width'], $this->atts['height'] );

				}

			} else if ( $image_src ) {
				$output = $image_html;

				if ( 'lightbox' === $this->atts['onclick'] ) {

					$output = $this->render_image_in_lightbox( array(
						'image_html' => $image_html,
						'image_width' => $this->atts['_image_width'],
                        'image_height' => $this->atts['_image_height'],
						'href' => $image_src,
						'title' => $this->atts['image_title'],
						'description' => $this->content,
						'rollover' => $this->is_hover_enabled()
					) );

				} elseif ( $this->is_image_with_link() ) {
					$target = ( '_blank' === $this->atts['custom_link_target'] ? ' target="_blank"' : '' );
					$rel = '';
					if ( $target ) {
						$rel = ' rel="noopener"';
					} elseif ( $this->atts['nofollow'] ) {
						$rel = ' rel="nofollow"';
					}
					$class = '';
					if ( $this->lazy_loading_on() ) {
						$class .= ' layzr-bg';
					}
					$style = '';
					if ( $this->is_hover_enabled() ) {
						$class .= ' rollover';
						$style = $this->image_inline_style();
					}
					$output = '<a href="' . esc_url( $this->atts['image_link'] ) . '" class="' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '"' . $target . $rel . ' aria-label="' . esc_attr( 'Image', 'the7mk2' ) . '">' .  $image_html ;
					if ( $this->get_att( 'show_zoom' ) === 'y' ) {
						$output .= '<span class="'. esc_attr( 'rollover-icon ' . $icon_class ).'"></span>';
					}
					$output .= '</a>';
				} elseif( $this->lazy_loading_on() ) {
					$wrap_class = ' layzr-bg';
				}

			} else if ( $video_url ) {

				$output = $this->render_video( $video_url, $this->atts['width'], $this->atts['height'] );

			}

			return $this->wrap_media( $output, $wrap_class );
		}

		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'shortcode-single-image-wrap.' . $this->get_unique_class(), '~"%s"' );

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
			$less_vars->add_pixel_number( 'rollover-icon-size', $this->get_att( 'rollover_icon_size' ) );
			$less_vars->add_keyword( 'rollover-icon-color', $this->get_att( 'rollover_icon_color', '~""' ) );

			$less_vars->add_pixel_number( 'rollover-icon-bg-size', $this->get_att( 'rollover_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'rollover-icon-border-width', $this->get_att( 'rollover_icon_border_width' ) );
			$less_vars->add_pixel_number( 'rollover-icon-border-radius', $this->get_att( 'rollover_icon_border_radius' ) );
			$less_vars->add_keyword( 'rollover-icon-border-color', $this->get_att( 'rollover_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'rollover-icon-bg-color', $this->get_att( 'rollover_icon_bg_color', '~""' ) );

			return $less_vars->get_vars();
		}

		/**
		 * Return shortcode less file absolute path to output inline.
		 *
		 * @return string
		 */
		protected function get_less_file_name() {
			return PRESSCORE_THEME_DIR . '/css/dynamic-less/shortcodes/fancy-image.less';
		}
	}

	DT_Shortcode_FancyImage::get_instance()->add_shortcode();

}
