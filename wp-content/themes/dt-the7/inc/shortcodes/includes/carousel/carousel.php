<?php
/**
 * Carousel shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Carousel', false ) ) {

	class DT_Shortcode_Carousel extends DT_Shortcode_With_Inline_Css {
		public static $instance = null;

		/**
		 * @return DT_Shortcode_Carousel
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			$this->sc_name = 'dt_carousel';
			$this->unique_class_base = 'carousel-shortcode-id';

			$this->default_atts = array(
				'slide_to_scroll' => 'single',
				'slides_on_wide_desk' => '4',
				'slides_on_desk' => '3',
				'slides_on_lapt' => '3',
				'slides_on_h_tabs' => '3',
				'slides_on_v_tabs' => '2',
				'slides_on_mob' => '1',
				'adaptive_height' => 'y',
				'item_space' => '30',
				'stage_padding' => '0',
				'speed' => '600',
				'autoplay' => 'n',
				'autoplay_speed' => "6000",
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
				'css_dt_carousel'         => '',
				'el_class' => '',
			);

			parent::__construct();
		}
		

		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			echo '<div ' . $this->get_container_html_class( array( 'owl-carousel carousel-shortcode dt-owl-carousel-call' ) ) . ' ' . $this->get_container_data_atts() . '>';
				echo do_shortcode($content);
			echo '</div>';
		}
		
		protected function get_container_html_class( $class = array() ) {
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

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
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_carousel'], ' ' );
			};
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
				'auto-height' => ($this->atts['adaptive_height'] === 'y') ? 'true' : 'false',
				'col-gap' => $this->atts['item_space'],
				'stage-padding' => $this->atts['stage_padding'],
				'speed' => $this->atts['speed'],
				'autoplay' => ($this->atts['autoplay'] === 'y') ? 'true' : 'false',
				'autoplay_speed' => $this->atts['autoplay_speed'],
				'arrows' => ($this->atts['arrows'] === 'y') ? 'true' : 'false',
				'bullet' => ($this->atts['show_bullets'] === 'y') ? 'true' : 'false',
				'next-icon'=> $this->atts['next_icon'],
				'prev-icon'=> $this->atts['prev_icon']
			);

			return presscore_get_inlide_data_attr( $data_atts );
		}
		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();
		}
		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'carousel-shortcode.' . $this->get_unique_class(), '~"%s"' );

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
			// @TODO: Remove in production.
			$less_file_name = 'dt-carousel';

			$less_file_path = trailingslashit( get_template_directory() ) . "css/dynamic-less/shortcodes/{$less_file_name}.less";

			return $less_file_path;
		}
		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html($content = '') {
			// return $this->vc_inline_dummy( array(
			// 	'class'  => 'dt_carousel',
			// 	'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_carousel_editor_ico.gif', 131, 104 ),
			// 	'title'  => _x( 'Carousel', 'vc inline dummy', 'the7mk2' ),
			// 	'style' => array( 'height' => 'auto' )
			// ) );
			return $content;
		}

	}
	
	// create shortcode
	DT_Shortcode_Carousel::get_instance()->add_shortcode();	
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_dt_carousel extends WPBakeryShortCodesContainer {
		}
	}


}
