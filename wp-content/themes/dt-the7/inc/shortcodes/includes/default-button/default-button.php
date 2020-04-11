<?php
/**
 * Default button shortcode.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'DT_Shortcode_Default_Button', false ) ) {

	class DT_Shortcode_Default_Button extends DT_Shortcode_With_Inline_Css {

		public static $instance;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name           = 'dt_default_button';
			$this->unique_class_base = 'default-btn';
			$this->default_atts      = array(
				'size'                           => 'small',
				'font_size'                      => '14px',
				'button_padding'                 => '12px 18px 12px 18px',
				'border_radius'                  => '1px',
				'border_width'                   => '0px',
				'link'                           => '',
				'text_color'                     => '',
				'default_btn_bg'                 => 'y',
				'default_btn_bg_color'           => '',
				'default_btn_border'             => 'y',
				'default_btn_border_color'       => '',
				'default_btn_hover'              => 'y',
				'text_hover_color'               => '',
				'default_btn_bg_hover'           => 'y',
				'bg_hover_color'                 => '',
				'default_btn_border_hover'       => 'y',
				'default_btn_border_hover_color' => '',
				'btn_decoration'                 => 'none',
				'animation'                      => 'none',
				'icon_type'                      => 'html',
				'icon'                           => '',
				'icon_picker'                    => '',
				'icon_size'                      => '12px',
				'icon_gap'						 => '8px',
				'icon_align'                     => 'left',
				'button_alignment'               => 'btn_inline_left',
				'smooth_scroll'                  => 'n',
				'btn_width'                      => 'btn_auto_width',
				'custom_btn_width'               => '200px',
				'link_font_size'				 => '14px',
				'link_font_style' 				 => ':bold:',
				'link_icon_size'				 => '11px',
				'link_padding'					 => '4px 0px 4px 0px',
				'link_text_color'				 => '',
				'link_hover'					 => 'n',
				'link_decoration'				 => 'upwards',
				'link_border_width'				 => '2px',
				'link_border_color'				 => '',
				'link_border_hover_color'		 => '',
				'link_text_hover_color'			 => '',
				'el_class'                       => '',
				'css'                            => '',
			);
			parent::__construct();
		}

		protected function do_shortcode( $atts, $content = '' ) {
			$content = trim( preg_replace( '/<\/?p\>/', '', $content ) );

			$icon_html = '';
			$icon_type = $this->atts['icon_type'];
			if ( $icon_type !== 'none' ) {
				if ( 'html' === $icon_type ) {
					if ( preg_match( '/^fa[a-z]*\s/', $this->atts['icon'] ) ) {
						$icon_html = '<i class="' . esc_attr( $this->atts['icon'] ) . '"></i>';
					} else {
						$icon_html = wp_kses( rawurldecode( base64_decode( $this->atts['icon'] ) ), array( 'i' => array( 'class' => array() ) ) );
					}
				} elseif ( ! empty( $this->atts[ "icon_{$icon_type}" ] ) ) {
					$icon_html = '<i class="' . esc_attr( $this->atts[ "icon_{$icon_type}" ] ) . '"></i>';
				}
			}

			$after_title  = '';
			$before_title = '';
			if ( 'right' === $this->atts['icon_align'] ) {
				$after_title = $icon_html;
			} else {
				$before_title = $icon_html;
			}

			$btn_width = '';
			if ( 'btn_fixed_width' === $this->atts['btn_width'] ) {
				$btn_width .= ' style="width:' . absint( $this->atts['custom_btn_width'] ) . 'px;"';
			}

			$url        = $this->atts['link'] ? $this->atts['link'] : '#';
			$link_title = '';
			$target     = '';
			$rel        = '';
			if ( function_exists( 'vc_build_link' ) ) {
				$link = vc_build_link( $this->atts['link'] );
				if ( ! empty( $link['url'] ) ) {
					$url        = $link['url'];
					$target     = ( empty( $link['target'] ) ? '' : sprintf( ' target="%s"', trim( $link['target'] ) ) );
					$link_title = ( empty( $link['title'] ) ? '' : sprintf( ' title="%s"', $link['title'] ) );
					$rel        = ( empty( $link['rel'] ) ? '' : sprintf( ' rel="%s"', $link['rel'] ) );
				}
			}
			if ( $this->atts['size'] === 'link' ) {
				$content = '<span>' . $content . '</span>';
			}

			$button_html = presscore_get_button_html(
				array(
					'before_title' => $before_title,
					'after_title'  => $after_title,
					'href'         => esc_attr( $url ),
					'title'        => $content,
					'target'       => $target,
					'class'        => $this->get_html_class(),
					'atts'         => ' id="' . $this->get_unique_class() . '"' . $btn_width . $link_title . $rel,
				)
			);

			switch ( $this->atts['button_alignment'] ) {
				case 'btn_left':
					$button_html = '<div class="btn-align-left">' . $button_html . '</div>';
					break;
				case 'btn_center':
					$button_html = '<div class="btn-align-center">' . $button_html . '</div>';
					break;
				case 'btn_right':
					$button_html = '<div class="btn-align-right">' . $button_html . '</div>';
					break;
			}


			echo $button_html;
		}

		protected function get_html_class() {
			if ( $this->get_att( 'size' ) === 'link' ) {
				$classes = array( 'default-btn-shortcode dt-btn-link' );
			}else{
				$classes = array( 'default-btn-shortcode dt-btn' );
			}
			switch ( $this->atts['size'] ) {
				case 'small':
					$classes[] = 'dt-btn-s';
					break;
				case 'medium':
					$classes[] = 'dt-btn-m';
					break;
				case 'big':
					$classes[] = 'dt-btn-l';
					break;
			};
			if ( presscore_shortcode_animation_on( $this->atts['animation'] ) ) {
				$classes[] = presscore_get_shortcode_animation_html_class( $this->atts['animation'] );
				$classes[] = 'animation-builder';
			}

			$icon_type = $this->atts['icon_type'];
			if ( 'html' === $icon_type ) {
				$there_is_an_icon = ! empty( $this->atts['icon'] );
			} else {
				$there_is_an_icon = ! empty( $this->atts[ "icon_{$icon_type}" ] );
			}

			if ( ! $this->get_flag( 'default_btn_hover' ) ) {
				$classes[] = 'btn-hover-off';
			}
			if ( ! $this->get_flag( 'link_hover' ) ) {
				$classes[] = 'link-hover-off';
			}

			if ( $there_is_an_icon && 'right' === $this->atts['icon_align'] ) {
				$classes[] = 'ico-right-side';
			}

			if ( $this->get_flag( 'smooth_scroll' ) ) {
				$classes[] = 'anchor-link';
			}

			if ( $this->atts['el_class'] ) {
				$classes[] = $this->atts['el_class'];
			}

			if ( 'btn_full_width' === $this->atts['btn_width'] ) {
				$classes[] = 'full-width-btn';
			}

			switch ( $this->atts['button_alignment'] ) {
				case 'btn_inline_left':
					$classes[] = 'btn-inline-left';
					break;
				case 'btn_inline_right':
					$classes[] = 'btn-inline-right';
					break;
			}
			if ( 'custom' === $this->atts['size'] ) {
				switch ( $this->atts['btn_decoration'] ) {
					case 'none':
						$classes[] = 'btn-flat';
						break;
					case 'btn_3d':
						$classes[] = 'btn-3d';
						break;
					case 'btn_shadow':
						$classes[] = 'btn-shadow';
						break;
				}
			}
			if ( $this->get_att( 'link_decoration' ) != 'none' && 'link' === $this->atts['size']  ) {
				switch ( $this->atts['link_decoration'] ) {
					case 'left_to_right':
						$classes[] = 'left-to-right-line';
						break;
					case 'from_center':
						$classes[] = 'from-center-line';
						break;
					case 'upwards':
						$classes[] = 'upwards-line';
						break;
					case 'downwards':
						$classes[] = 'downwards-line';
						break;
				}
			}

			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$classes[] = vc_shortcode_custom_css_class( $this->atts['css'], ' ' );
			}

			return esc_attr( implode( ' ', $classes ) );
		}

		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
		}

		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', $this->get_unique_class(), '~"%s"' );
			
			$less_vars->add_pixel_number( 'btn-icon-gap', $this->get_att( 'icon_gap' ) );

			/**
			 * Custom settings.
			 */
			if ( $this->get_att( 'size' ) === 'custom' ) {
				$btn_padding       = array(
					'btn-padding-top',
					'btn-padding-right',
					'btn-padding-bottom',
					'btn-padding-left',
				);
				$btn_hover_padding = array(
					'btn-padding-top-hover',
					'btn-padding-right-hover',
					'btn-padding-bottom-hover',
					'btn-padding-left-hover',
				);
				$less_vars->add_paddings( $btn_padding, $this->get_att( 'button_padding' ) );
				$less_vars->add_paddings( $btn_hover_padding, $this->get_att( 'button_padding' ) );

				$less_vars->add_pixel_number( 'btn-icon-size', $this->get_att( 'icon_size' ) );
				$less_vars->add_pixel_number( 'btn-font-size', $this->get_att( 'font_size' ) );
				$less_vars->add_pixel_number( 'btn-border-radius', $this->get_att( 'border_radius' ) );

				$less_vars->add_keyword( 'btn-color', $this->get_att( 'text_color' ) );
				$less_vars->add_keyword( 'btn-bg-color', 'none' );
				if ( $this->get_flag( 'default_btn_bg' ) ) {
					$less_vars->add_keyword( 'btn-bg-color', $this->get_att( 'default_btn_bg_color' ) );
				}
				$less_vars->add_keyword( 'btn-border-color', $this->get_att( 'default_btn_border_color' ) );

				$border_width = $this->get_att( 'border_width' );

				// Take care of border width.
				$less_vars->add_pixel_number( 'btn-border-width', $border_width );
				if ( ! $this->get_flag( 'default_btn_border' ) ) {
					$less_vars->add_pixel_number( 'btn-border-width', 0 );
					$less_vars->add_pixel_number( 'btn-pi', $border_width );
				}

				if ( $this->get_flag( 'default_btn_hover' ) ) {
					$less_vars->add_keyword( 'btn-color-hover', $this->get_att( 'text_hover_color' ) );
					$less_vars->add_keyword( 'btn-bg-color-hover', 'none' );
					if ( $this->get_flag( 'default_btn_bg_hover' ) ) {
						$less_vars->add_keyword( 'btn-bg-color-hover', $this->get_att( 'bg_hover_color' ) );
					}
					$less_vars->add_keyword( 'btn-border-color-hover', $this->get_att( 'default_btn_border_hover_color' ) );

					// Take care of border width on hover.
					$less_vars->add_pixel_number( 'btn-border-width-hover', $border_width );
					if ( ! $this->get_flag( 'default_btn_border_hover' ) ) {
						$less_vars->add_pixel_number( 'btn-border-width-hover', 0 );
						$less_vars->add_pixel_number( 'btn-pi-h', $border_width );
					}
				} else {
					// Fill hover vars with regular values.
					$less_vars->add_keyword( 'btn-color-hover', $less_vars->get_var( 'btn-color' ) );
					$less_vars->add_keyword( 'btn-bg-color-hover', $less_vars->get_var( 'btn-bg-color' ) );
					$less_vars->add_keyword( 'btn-border-color-hover', $less_vars->get_var( 'btn-border-color' ) );
					$less_vars->add_pixel_number( 'btn-border-width-hover', $less_vars->get_var( 'btn-border-width' ) );
					if ( $less_vars->get_var( 'btn-pi' ) ) {
						$less_vars->add_pixel_number( 'btn-pi-h', $less_vars->get_var( 'btn-pi' ) );
					}
				}
			}

			if ( $this->get_att( 'size' ) === 'link' ) {
				$btn_padding       = array(
					'link-padding-top',
					'link-padding-right',
					'link-padding-bottom',
					'link-padding-left',
				);
				$less_vars->add_paddings( $btn_padding, $this->get_att( 'link_padding' ) );

				$less_vars->add_pixel_number( 'link-icon-size', $this->get_att( 'link_icon_size' ) );
				$less_vars->add_pixel_number( 'link-font-size', $this->get_att( 'link_font_size' ) );
				$less_vars->add_font_style( array(
					'link-font-style',
					'link-font-weight',
					'link-text-transform',
				), $this->get_att( 'link_font_style' ) );

				$less_vars->add_keyword( 'link-color', $this->get_att( 'link_text_color' ) );
				$less_vars->add_keyword( 'btn-border-color', $this->get_att( 'default_btn_border_color' ) );

				$border_width = $this->get_att( 'link_border_width' );

				// Take care of border width.
				$less_vars->add_pixel_number( 'link-border-width', $border_width );
				if ( $this->get_att( 'link_decoration' ) == 'none' ) {
					$less_vars->add_pixel_number( 'link-border-width', 0 );
					$less_vars->add_pixel_number( 'link-pi', $border_width );
				}

				$less_vars->add_keyword( 'link-border-color-hover', $this->get_att( 'link_border_color' ) );

				if ( $this->get_flag( 'link_hover' ) ) {
					$less_vars->add_keyword( 'link-color-hover', $this->get_att( 'link_text_hover_color' ) );
					
					// Take care of border width on hover.
					$less_vars->add_pixel_number( 'btn-border-width-hover', $border_width );
					if ( ! $this->get_flag( 'default_btn_border_hover' ) ) {
						$less_vars->add_pixel_number( 'btn-border-width-hover', 0 );
						$less_vars->add_pixel_number( 'btn-pi-h', $border_width );
					}
				} else {
					// Fill hover vars with regular values.
					$less_vars->add_keyword( 'btn-color-hover', $less_vars->get_var( 'btn-color' ) );
					$less_vars->add_keyword( 'btn-bg-color-hover', $less_vars->get_var( 'btn-bg-color' ) );
					$less_vars->add_keyword( 'btn-border-color-hover', $less_vars->get_var( 'btn-border-color' ) );
					$less_vars->add_pixel_number( 'btn-border-width-hover', $less_vars->get_var( 'btn-border-width' ) );
					if ( $less_vars->get_var( 'btn-pi' ) ) {
						$less_vars->add_pixel_number( 'btn-pi-h', $less_vars->get_var( 'btn-pi' ) );
					}
				}
			}


			return $less_vars->get_vars();
		}

		protected function get_less_file_name() {
			return trailingslashit( get_template_directory() ) . 'css/dynamic-less/shortcodes/default-buttons.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return false;
		}
	}
	DT_Shortcode_Default_Button::get_instance()->add_shortcode();
}
