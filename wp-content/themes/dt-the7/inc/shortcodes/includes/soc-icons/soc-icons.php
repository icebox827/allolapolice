<?php
/**
 * Default button shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Social_Icons', false ) ) {

	class DT_Shortcode_Social_Icons extends DT_Shortcode_With_Inline_Css {
		protected $content = '';

		protected $shortcode_id = 0;

		protected $button_id = '';

		public static $instance = null;
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name = 'dt_soc_icons';
			$this->unique_class_base = 'soc-icons';
			$this->default_atts = array(
				'icon_align'             => 'center',
				'soc_icon_gap_between' => '4px',
				'el_class'               => '',
				'css'         			 => '',
			);
			parent::__construct();
		}

		protected function do_shortcode( $atts, $content = '' ) {
			echo '<div ' . $this->get_container_html_class( array( 'dt-shortcode-soc-icons' ) ) . ' >';
				echo do_shortcode($content);
			echo '</div>';
		}

		protected function get_container_html_class($class = array() ) {
			$class[] = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

			switch ( $this->atts['icon_align'] ) {
				case 'center':
					$class[] = 'soc-icons-center';
					break;
				case 'left':
					$class[] = 'soc-icons-left';
					break;
				case 'right':
					$class[] = 'soc-icons-right';
					break;
			}
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css'], ' ' );
			}
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
			$less_vars->add_pixel_number( 'soc-icon-gap-between', $this->get_att( 'soc_icon_gap_between' ) );

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
			return false;
		}
	}
	DT_Shortcode_Social_Icons::get_instance()->add_shortcode();

	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_dt_soc_icons extends WPBakeryShortCodesContainer {
		}
	}
}
