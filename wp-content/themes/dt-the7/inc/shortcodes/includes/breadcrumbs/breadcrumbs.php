<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'DT_Shortcode_Breadcrumbs', false ) ) {

	/**
	 * Class DT_Shortcode_Breadcrumbs
	 */
	class DT_Shortcode_Breadcrumbs extends DT_Shortcode_With_Inline_Css {

		public function __construct() {
			$this->sc_name = 'dt_breadcrumbs';
			$this->unique_class_base = 'dt-breadcrumbs-id';
			$this->default_atts = array(
				'alignment' => 'center',
				'font_style' => '',
				'font_size' => '',
				'line_height' => '',
				'font_color' => '#a2a5a6',
				'paddings' => '2px 10px 2px 10px',
				'bg_color' => '',
				'border_color' => '',
				'border_width' => '0',
				'border_radius' => '0',
			);

			parent::__construct();
		}

		/**
		 * Main method. Return HTML.
		 *
		 * @param array $atts
		 * @param string $content
		 *
		 * @return string
		 */
		public function do_shortcode( $atts, $content = '' ) {
			$classes = array( 'dt-breadcrumbs-shortcode', $this->get_unique_class() );
			switch ( $this->get_att( 'alignment' ) ) {
				case 'center':
					$classes[] = 'align-centre';
					break;
				case 'left':
					$classes[] = 'align-left';
					break;
				case 'right':
					$classes[] = 'align-right';
					break;
			}

			echo '<div class="' . presscore_esc_implode( ' ', $classes ) . '">' . presscore_get_breadcrumbs() . '</div>';
		}

		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			// TODO: Implement setup_config() method.
		}

		/**
		 * Return array of prepared less vars to insert to less file.
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-breadcrumbs-class-name', $this->get_unique_class(), '~"%s"' );

			$less_vars->add_font_style( array(
					'breadcrumbs-font-style',
					'breadcrumbs-font-weight',
					'breadcrumbs-text-transform',
				),
				$this->get_att( 'font_style' )
			);

			$less_vars->add_pixel_number( 'breadcrumbs-font-size', $this->get_att( 'font_size' ) );
			$less_vars->add_pixel_number( 'breadcrumbs-line-height', $this->get_att( 'line_height' ) );
			$less_vars->add_keyword( 'breadcrumbs-color', $this->get_att( 'font_color', '~""' ) );
			$less_vars->add_paddings( array(
					'breadcrumbs-padding-top',
					'breadcrumbs-padding-right',
					'breadcrumbs-padding-bottom',
					'breadcrumbs-padding-left',
				),
				$this->get_att( 'paddings' )
			);
			$less_vars->add_keyword( 'breadcrumbs-bg', $this->get_att( 'bg_color', '~""' ) );
			$less_vars->add_keyword( 'breadcrumbs-border-color', $this->get_att( 'border_color', '~""' ) );
			$less_vars->add_pixel_number( 'breadcrumbs-border-width', $this->get_att( 'border_width' ) );
			$less_vars->add_pixel_number( 'breadcrumbs-border-radius', $this->get_att( 'border_radius' ) );

			return $less_vars->get_vars();
		}

		/**
		 * Return shortcode less file absolute path to output inline.
		 * @return string
		 */
		protected function get_less_file_name() {
			return get_template_directory() . '/css/dynamic-less/shortcodes/breadcrumbs.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return false;
		}
	}

	$breadcrumbs_shortcode = new DT_Shortcode_Breadcrumbs();
	$breadcrumbs_shortcode->add_shortcode();
}