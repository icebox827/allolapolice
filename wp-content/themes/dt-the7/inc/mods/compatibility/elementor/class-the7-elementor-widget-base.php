<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor;

use Elementor\Widget_Base;
use The7\Adapters\Elementor\The7_Elementor_Less_Vars_Decorator;
use \The7_Less_Compiler;

defined( 'ABSPATH' ) || exit;

abstract class The7_Elementor_Widget_Base extends Widget_Base {

	const WIDGET_CSS_CACHE_ID = '_the7_elementor_widgets_css';

	/**
	 * Return unique shortcode class like {$unique_class_base}-{$sc_id}.
	 *
	 * @return string
	 */
	public function get_unique_class() {
		return $this->get_name() . '-' . $this->get_id();
	}

	protected function print_inline_css() {
		echo '<style type="text/css">';
		if ( wp_doing_ajax() ) {
			add_filter( 'dt_of_get_option-general-images_lazy_loading', '__return_false' );
			echo $this->generate_inline_css();
		} else {
			echo $this->get_css();
		}
		echo '</style>';
	}

	protected function generate_inline_css() {
		$less_file = $this->get_less_file_name();

		if ( ! $less_file ) {
			return '';
		}

		$lessc = new The7_Less_Compiler( (array) $this->get_less_vars(), (array) $this->get_less_import_dir() );

		return $lessc->compile_file( $less_file, $this->get_less_imports() );
	}

	public function save_css( $post_id = null ) {
		global $post;

		$post_id = $post_id ? $post_id : $post->ID;
		if ( ! $this->get_css( $post_id ) ) {
			$widgets_css                    = (array) get_post_meta( $post_id, self::WIDGET_CSS_CACHE_ID, true );
			$widgets_css[ $this->get_id() ] = $this->generate_inline_css();
			$widgets_css                    = array_filter( $widgets_css );
			update_post_meta( $post_id, self::WIDGET_CSS_CACHE_ID, $widgets_css );
		}

		return true;
	}

	public function get_css( $post_id = null ) {
		global $post;

		$post_id     = $post_id ? $post_id : $post->ID;
		$uid         = $this->get_id();
		$widgets_css = (array) get_post_meta( $post_id, self::WIDGET_CSS_CACHE_ID, true );
		if ( ! array_key_exists( $uid, $widgets_css ) ) {
			return '';
		}

		return $widgets_css[ $uid ];
	}

	public static function delete_widgets_css_cache( $post_id ) {
		delete_post_meta( $post_id, self::WIDGET_CSS_CACHE_ID );
	}

	/**
	 * Return less import dir.
	 *
	 * @return array
	 */
	protected function get_less_import_dir() {
		return [ PRESSCORE_THEME_DIR . '/css/dynamic-less/elementor' ];
	}

	protected function get_less_vars() {
		$less_vars = new The7_Elementor_Less_Vars_Decorator( the7_get_new_shortcode_less_vars_manager() );

		$this->less_vars( $less_vars );

		return $less_vars->get_vars();
	}

	protected function less_vars( The7_Elementor_Less_Vars_Decorator_Interface $less_vars ) {
		// Do nothing.
	}

	protected function get_less_imports() {
		return [];
	}

	protected function get_less_file_name() {
		return false;
	}

	protected function combine_dimensions( $dim ) {
		$units = $dim['unit'];

		return "{$dim['top']}{$units} {$dim['right']}{$units} {$dim['bottom']}{$units} {$dim['left']}{$units}";
	}

	protected function combine_slider_value( $val, $default = 0 ) {
		if ( empty( $val['size'] ) || ! isset( $val['unit'] ) ) {
			return $default;
		}

		return $val['size'] . $val['unit'];
	}
}
