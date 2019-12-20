<?php
/**
 * Single Social Icon.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Single_Social_Icon', false ) ) {

	class DT_Shortcode_Single_Social_Icon extends DT_Shortcode_With_Inline_Css {
		protected $content = '';

		protected $shortcode_id = 0;


		public static $instance = null;
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name = 'dt_single_soc_icon';
			$this->unique_class_base = 'single-soc-icon';
			$this->default_atts = array(
				'link'                  => '',
				'soc_icon_size'			=> '16px',
				'dt_soc_icon'			=> '',
				'soc_icon_bg_size'		=> '26px',
				'soc_icon_border_width'	=> '0',
				'soc_icon_border_radius'=> '100px',
				'soc_icon_color'		=> 'rgba(255,255,255,1)',
				'soc_icon_border'		=> 'y',
				'soc_icon_border_color'	=> '',
				'soc_icon_bg'		=> 'y',
				'soc_icon_bg_color'		=> '',
				'soc_icon_color_hover'		=> 'rgba(255,255,255,0.75)',
				'soc_icon_border_hover'		=> 'y',
				'soc_icon_border_color_hover'	=> '',
				'soc_icon_bg_hover'		=> 'y',
				'soc_icon_bg_color_hover'		=> '',
				'el_class'               => '',
				'css'         			 => '',
			);
			parent::__construct();
		}

		protected function do_shortcode( $atts, $content = '' ) {
			$this->get_unique_class();

			$url = '#';
			$target = $rel = $title = '';
			if ( $this->atts['link'] ) {
				if ( function_exists( 'vc_build_link' ) ) {
					$href = vc_build_link( $this->atts['link'] );
					if ( ! empty( $href['url'] ) ) {
						$url = $href['url'];
						$target = ( empty( $href['target'] ) ? '' : sprintf( ' target="%s"', trim( $href['target'] ) ) );
						$rel = ( empty( $href['rel'] ) ? '' : sprintf( ' rel="%s"', $href['rel'] ) );
						$title = ( empty( $href['title'] ) ? '' : $href['title'] );
					}
				} else {
					$url = $this->atts['link'];

				}
			}

			$dt_soc_icon_attr = esc_attr( $this->atts['dt_soc_icon'] );

			static $social_icons = null;

			if ( !$social_icons ) {
				$social_icons = presscore_get_social_icons_data();
			}

			$dt_soc_icon = str_replace( 'dt-icon-', '', $dt_soc_icon_attr );
			if ( 'deviant' === $dt_soc_icon ) {
				$dt_soc_icon = 'devian';
			} elseif ( 'tumblr' === $dt_soc_icon ) {
				$dt_soc_icon = 'tumbler';
			} elseif ( '500px' === $dt_soc_icon ) {
				$dt_soc_icon = 'px-500';
			} elseif ( in_array( $dt_soc_icon, array( 'youtube', 'YouTube' ) ) ) {
				$dt_soc_icon = 'you-tube';
			} elseif ( in_array( $dt_soc_icon, array( 'tripedvisor', 'tripadvisor' ) ) ) {
				$dt_soc_icon = 'tripedvisor';
			} elseif ( $dt_soc_icon === 'google' ) {
				$dt_soc_icon = '';
			}

			if ( empty($dt_soc_icon) ) {
				return;
			}

			if ( array_key_exists( $dt_soc_icon, $social_icons ) ) {
				$title = $title ? $title : $social_icons[ $dt_soc_icon ];
				$icon_class = "soc-font-icon {$dt_soc_icon_attr}";
			} else {
				$icon_class = $dt_soc_icon_attr;
			}

			printf(
				'<a title="%1$s" href="%2$s" %3$s ><i class="%4$s"></i><span class="screen-reader-text">%1$s</span></a>',
				esc_attr( $title ),
				esc_attr( $url ),
				$target . $rel . $this->get_html_class( array( $dt_soc_icon ) ),
				esc_attr( 'soc-icon ' . $icon_class )
			);
		}

		protected function get_html_class($class = array()) {
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

			if($this->atts['soc_icon_bg'] === 'y'){
				$class[] = 'dt-icon-bg-on';
			}else{
				$class[] = 'dt-icon-bg-off';
			}
			if($this->atts['soc_icon_border'] === 'y'){
				$class[] = 'dt-icon-border-on';
			}
			if($this->atts['soc_icon_border_hover'] === 'y'){
				$class[] = 'dt-icon-hover-border-on';
			}

			if($this->atts['soc_icon_bg_hover'] === 'y'){
				$class[] = 'dt-icon-hover-bg-on';
			}else{
				$class[] = 'dt-icon-hover-bg-off';
			}
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css'], ' ' );
			}
			$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
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

			$less_vars->add_keyword( 'unique-shortcode-class-name',  $this->get_unique_class(), '~"%s"' );

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

			return $less_vars->get_vars();
		}
		protected function get_less_file_name() {
			// @TODO: Remove in production.
			$less_file_name = 'social-icons-inline';

			$less_file_path = trailingslashit( get_template_directory() ) . "css/dynamic-less/shortcodes/{$less_file_name}.less";

			return $less_file_path;
		}
		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			$dt_soc_icon_attr = esc_attr( $this->atts['dt_soc_icon'] );
			$dt_soc_icon_attr = (string) $dt_soc_icon_attr;

			static $social_icons = null;

			if ( !$social_icons ) {
				$social_icons = presscore_get_social_icons_data();
			}

			$dt_soc_icon = str_replace( 'dt-icon-', '', $dt_soc_icon_attr );
			if ( 'deviant' == $dt_soc_icon ) {
				$dt_soc_icon = 'devian';
			} elseif ( 'tumblr' == $dt_soc_icon ) {
				$dt_soc_icon = 'tumbler';
			} elseif ( '500px' == $dt_soc_icon ) {
				$dt_soc_icon = 'px-500';
			} elseif ( in_array( $dt_soc_icon, array( 'youtube', 'YouTube' ) ) ) {
				$dt_soc_icon = 'you-tube';
			} elseif ( in_array( $dt_soc_icon, array( 'tripedvisor', 'tripadvisor' ) ) ) {
				$dt_soc_icon = 'tripedvisor';
			}
			
			$dt_soc_icon = array_key_exists( $dt_soc_icon, $social_icons ) ? $dt_soc_icon : '';

			if ( empty($dt_soc_icon) ) {
				return;
			}

			$title = esc_attr( $social_icons[ $dt_soc_icon ] );
			return $this->vc_inline_dummy( array(
				'class'  => 'dt_single_soc_icon',
				
				'title'  => _x( '' . $title . ' ', 'vc inline dummy', 'the7mk2' ),
				'style' => array( 'height' => 'auto' )
				
			) );
		}
	}
	DT_Shortcode_Single_Social_Icon::get_instance()->add_shortcode();

}
