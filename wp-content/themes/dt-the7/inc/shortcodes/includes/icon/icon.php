<?php
/**
 * Icon.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once trailingslashit( PRESSCORE_SHORTCODES_INCLUDES_DIR ) . 'abstract-dt-shortcode-with-inline-css.php';

if ( ! class_exists( 'DT_Shortcode_Icon', false ) ) {

	class DT_Shortcode_Icon extends DT_Shortcode_With_Inline_Css {
		public static $instance;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name = 'dt_icon';
			$this->unique_class_base = 'icon';
			$this->default_atts = array(
				'link'                  => '',
				'smooth_scroll' => 'n',
				'icon_alignment'		=> 'left',
				'dt_icon_size'			=> '32px',
				'dt_icon'				=> 'Defaults-heart',
				'dt_icon_bg_size'		=> '64px',
				'dt_icon_border_width'	=> '0',
				'icon_border_style'		=> 'solid',
				'icon_border_gap'		=> '0',
				'dt_icon_border_radius'	=> '100px',
				'dt_icon_color'			=> 'rgba(255,255,255,1)',
				'dt_icon_border'		=> 'y',
				'dt_icon_border_color'	=> '',
				'dt_icon_bg'			=> 'y',
				'dt_icon_bg_color'		=> '',
				'dt_icon_hover'			=> 'y',
				'dt_icon_color_hover'	=> 'rgba(255,255,255,0.75)',
				'dt_icon_border_hover'	=> 'y',
				'dt_icon_border_color_hover'	=> '',
				'dt_icon_bg_hover'		=> 'y',
				'dt_icon_bg_color_hover'=> '',
				'el_class'               => '',
				'icon_animation'		 => 'none',
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

			$dt_icon_attr = esc_attr( $this->atts['dt_icon'] );

			static $social_icons = null;

			if ( !$social_icons ) {
				$social_icons = presscore_get_social_icons_data();
			}

			$dt_icon = str_replace( 'dt-icon-', '', $dt_icon_attr );

			if ( empty($dt_icon) ) {
				return;
			}
			$icon_alignment_class = '';

			switch ( $this->atts['icon_alignment']) {
				case 'icon_center':
					$icon_alignment_class = 'dt-icon-center';
					break;
				case 'icon_right':
					$icon_alignment_class = 'dt-icon-right';
					break;
			};
			if ( $this->atts['smooth_scroll'] ) {
				$anchorclass = 'anchor-link';
			}

			if ( array_key_exists( $dt_icon, $social_icons ) ) {
				$title = $title ? $title : $social_icons[ $dt_icon ];
				$icon_class = "soc-font-icon {$dt_icon_attr}";
			} else {
				$icon_class = $dt_icon_attr;
			}
			echo '<div class="dt-shortcode-icon-wrap '.$icon_alignment_class.' ">';
			if(empty($this->atts['link'])){
				echo '<span  ' . $this->get_html_class( array(  $anchorclass, $dt_icon ) ) .' ><span class="icon-inner"><i class="dt-regular-icon '. esc_attr( 'soc-icon ' . $icon_class ).'"></i><i class="dt-hover-icon '. esc_attr( 'soc-icon ' . $icon_class ).'"></i><span class="screen-reader-text">'.esc_attr( $title ).'</span></span></span>';
			}else{
				echo '<a title="'. esc_attr( $title ) .'" href="'. esc_attr( $url ) .'" '. $target . $rel . $this->get_html_class( array(  $anchorclass, $dt_icon ) ) .' ><span class="icon-inner"><i class="dt-regular-icon '. esc_attr( 'soc-icon ' . $icon_class ).'"></i><i class="dt-hover-icon '. esc_attr( 'soc-icon ' . $icon_class ).'"></i><span class="screen-reader-text">'.esc_attr( $title ).'</span></span></a>';
			}
			echo '</div>';
		}

		protected function get_html_class($class = array()) {
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

			$class[] = 'dt-shortcode-icon';

			if($this->atts['dt_icon_bg'] === 'y'){
				$class[] = 'dt-icon-bg-on';
			}else{
				$class[] = 'dt-icon-bg-off';
			}
			if($this->atts['dt_icon_border'] === 'y'){
				$class[] = 'dt-icon-border-on';
			}
			if($this->atts['dt_icon_border_hover'] === 'y'){
				$class[] = 'dt-icon-hover-border-on';
			}
			if($this->atts['dt_icon_hover'] === 'y'){
				$class[] = 'dt-icon-hover-on';
			}else{
				$class[] = 'dt-icon-hover-off';
			}
			if($this->atts['dt_icon_bg_hover'] === 'y'){
				$class[] = 'dt-icon-hover-bg-on';
			}else{
				$class[] = 'dt-icon-hover-bg-off';
			}
			switch ( $this->atts['icon_border_style']) {
				case 'dotted':
					$class[] = 'dt-icon-border-dotted';
					break;
				case 'dashed':
					$class[] = 'dt-icon-border-dashed';
					break;
				case 'double':
					$class[] = 'dt-icon-border-double';
					break;
			};
			switch ( $this->atts['icon_animation']) {
				case 'slide_up':
					$class[] = 'dt-icon-animate-slide-up';
					break;
				case 'slide_right':
					$class[] = 'dt-icon-animate-slide-right';
					break;
				case 'shadow':
					$class[] = 'dt-icon-animate-shadow';
					break;
				case 'spin_around':
					$class[] = 'dt-icon-animate-spin-around';
					break;
				case 'shadow':
					$class[] = 'dt-icon-animate-shadow';
					break;
				case 'scale':
					$class[] = 'dt-icon-animate-scale';
					break;
				case 'scale_down':
					$class[] = 'dt-icon-animate-scale-down';
					break;
			};
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

			$less_vars->add_pixel_number( 'dt-icon-size', $this->get_att( 'dt_icon_size' ) );
			$less_vars->add_pixel_number( 'dt-icon-bg-size', $this->get_att( 'dt_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'dt-icon-border-width', $this->get_att( 'dt_icon_border_width' ) );
			$less_vars->add_pixel_number( 'icon-border-gap', $this->get_att( 'icon_border_gap' ) );
			$less_vars->add_pixel_number( 'dt-icon-border-radius', $this->get_att( 'dt_icon_border_radius' ) );

			$less_vars->add_keyword( 'dt-icon-color', $this->get_att( 'dt_icon_color', '~""') );
			$less_vars->add_keyword( 'dt-icon-color-hover', $this->get_att( 'dt_icon_color_hover', '~""' ) );

			$less_vars->add_keyword( 'dt-icon-border-color', $this->get_att( 'dt_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'dt-icon-border-color-hover', $this->get_att( 'dt_icon_border_color_hover', '~""' ) );
			$less_vars->add_keyword( 'dt-icon-bg-color', $this->get_att( 'dt_icon_bg_color', '~""' ) );
			$less_vars->add_keyword( 'dt-icon-bg-color-hover', $this->get_att( 'dt_icon_bg_color_hover', '~""' ) );

			return $less_vars->get_vars();
		}
		protected function get_less_file_name() {
			// @TODO: Remove in production.
			$less_file_name = 'dt-icon';

			$less_file_path = trailingslashit( get_template_directory() ) . "css/dynamic-less/shortcodes/{$less_file_name}.less";

			return $less_file_path;
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
	DT_Shortcode_Icon::get_instance()->add_shortcode();

}
